# ========================================
# Route 53 Hosted Zone
# ========================================

data "aws_route53_zone" "main" {
  name         = "sandip.qd.je."
  private_zone = false
}


# ========================================
# ACM Certificate
# ========================================

resource "aws_acm_certificate" "app_cert" {

  domain_name = "sandip.qd.je"

  validation_method = "DNS"

  lifecycle {
    create_before_destroy = true
  }

  tags = {
    Name = "${var.project_name}-acm"
  }
}


# ========================================
# ACM DNS Validation Record
# ========================================

resource "aws_route53_record" "cert_validation" {

  for_each = {
    for dvo in aws_acm_certificate.app_cert.domain_validation_options :
    dvo.domain_name => {
      name   = dvo.resource_record_name
      record = dvo.resource_record_value
      type   = dvo.resource_record_type
    }
  }

  zone_id = data.aws_route53_zone.main.zone_id

  name = each.value.name
  type = each.value.type
  ttl  = 60

  records = [
    each.value.record
  ]
}


# ========================================
# ACM Certificate Validation
# ========================================

resource "aws_acm_certificate_validation" "app_cert" {

  certificate_arn = aws_acm_certificate.app_cert.arn

  validation_record_fqdns = [
    for record in aws_route53_record.cert_validation :
    record.fqdn
  ]
}


# ========================================
# Application DNS - IPv4
# ========================================

resource "aws_route53_record" "app_ipv4" {

  zone_id = data.aws_route53_zone.main.zone_id

  name = "sandip.qd.je"
  type = "A"

  alias {
    name                   = module.load-balancer.alb_dns_name
    zone_id                = module.load-balancer.alb_zone_id
    evaluate_target_health = true
  }
}