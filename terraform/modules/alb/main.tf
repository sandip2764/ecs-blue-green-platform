# ============================================================
# Application Load Balancer
# ============================================================

resource "aws_lb" "this" {
  name               = "${var.project_name}-lb"
  internal           = var.internal
  load_balancer_type = var.load_balancer_type

  security_groups = var.security_group_ids
  subnets         = var.subnets

  tags = {
    Name = "${var.project_name}-lb"
  }
}


# ============================================================
# Blue Target Group
# ============================================================

resource "aws_lb_target_group" "blue" {
  name     = "${var.project_name}-blue-tg"
  port     = var.target_group_port
  protocol = var.target_group_protocol
  vpc_id   = var.vpc_id
  target_type = "ip"

  health_check {
    path     = var.health_check_path
    timeout  = var.health_check_timeout
    interval = var.health_check_interval
  }

  tags = {
    Name = "${var.project_name}-blue-tg"
  }
}


# ============================================================
# Green Target Group
# ============================================================

resource "aws_lb_target_group" "green" {
  name     = "${var.project_name}-green-tg"
  port     = var.target_group_port
  protocol = var.target_group_protocol
  vpc_id   = var.vpc_id
  target_type = "ip"

  health_check {
    path     = var.health_check_path
    timeout  = var.health_check_timeout
    interval = var.health_check_interval
  }

  tags = {
    Name = "${var.project_name}-green-tg"
  }
}


# ============================================================
# HTTP Listener
# ============================================================

resource "aws_lb_listener" "http" {
  load_balancer_arn = aws_lb.this.arn

  port     = 80
  protocol = "HTTP"

  default_action {
    type = "redirect"

    redirect {
      port        = "443"
      protocol    = "HTTPS"
      status_code = "HTTP_301"
    }
  }
}


# ============================================================
# HTTPS Listener
# ============================================================

resource "aws_lb_listener" "https" {
  load_balancer_arn = aws_lb.this.arn

  port            = 443
  protocol        = "HTTPS"
  ssl_policy      = var.ssl_policy
  certificate_arn = var.certificate_arn

  default_action {
    type             = "forward"
    target_group_arn = aws_lb_target_group.blue.arn
  }
}