# networking

module "networking" {
  source = "../modules/networking/"

  project_name = var.project_name

  cidr_block = var.cidr_block

  aws_public_subnet_cidrs_az = var.aws_public_subnet_cidrs_az

  aws_private_subnet_cidrs_az = var.aws_private_subnet_cidrs_az
}

# alb security-group 

module "alb_security_group" {
  source = "../modules/security-group/"

  name_prefix = "${var.project_name}-lb-sg-"

  description       = "for application load-balancer"
  vpc_id            = module.networking.vpc_id
  allowed_ports     = var.lb_allowed_ports
  ingress_source_ip = "0.0.0.0/0"
  tags = {
    Name = "${var.project_name}-lb-sg"
  }
}

# ecs farget security group

module "ecs_farget_security_group" {
  source = "../modules/security-group/"

  name_prefix = "${var.project_name}-farget-sg-"

  description                  = "for ecs-farget"
  vpc_id                       = module.networking.vpc_id
  allowed_ports                = var.ecs_farget_allowed_ports
  referenced_security_group_id = module.alb_security_group.aws_security_group_id
  tags = {
    Name = "${var.project_name}-farget-sg"
  }
}

# rds security group

module "rds_security_group" {
  source = "../modules/security-group/"

  name_prefix = "${var.project_name}-rds-sg-"

  description                  = "for rds sg"
  vpc_id                       = module.networking.vpc_id
  allowed_ports                = var.rds_allowed_ports
  referenced_security_group_id = module.ecs_farget_security_group.aws_security_group_id
  tags = {
    Name = "${var.project_name}-rds-sg"
  }
}

