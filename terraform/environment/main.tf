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

# iam role 

module "iam" {
  source = "../modules/iam/"

  project_name = var.project_name

  db_secret_arn = ""

  ecr_repository_arn = data.terraform_remote_state.bootstrap.outputs.aws_ecr_repository_url

  codedeploy_application_arn = ""

  codedeploy_deployment_group_arn = ""

  github_repository = ""

}

# rds 

module "rds" {
  source = "../modules/rds/"

  subnet_ids = values(module.networking.aws_private_subnet_ids)
  identifier = "${var.project_name}-db"

  security_group = [module.rds_security_group.aws_security_group_id]

  instance_class = var.instance_class

  username = var.username
  password = var.password

  storage      = var.storage
  storage_type = var.storage_type

  engine         = var.engine
  engine_version = var.engine_version

  publicly_accessible = var.public_access
  skip_final_snapshot = var.skip_final_snapshot
}

# create aws secret manager for db

resource "aws_secretsmanager_secret" "db" {
  name                    = "${var.project_name}-db-secret"
  recovery_window_in_days = 0
}

resource "aws_secretsmanager_secret_version" "db" {

  secret_id = aws_secretsmanager_secret.db.id

  secret_string = jsonencode({
    host     = module.rds.host
    username = module.rds.username
    password = module.rds.password
    database = var.database_name
    port     = module.rds.port
  })

}

# ecs 

module "ecs" {
  source = "../modules/ecs/"

  project_name = "${var.project_name}-ecs"
  private_subnet_ids = values(module.networking.aws_private_subnet_ids)
  log_group_name = ""
  execution_role_arn = module.iam.ecs_task_execution_role_arn
  aws_region = var.region

  container_name = "${var.project_name}-container"
  container_port = ""
  container_image = ""
  security_group_id = ""

  task_cpu = ""
  task_memory = ""
  task_role_arn = ""

  blue_target_group_arn = ""

}

# alb + listner + tg 

module "lb" {
  source = "../modules/alb/"

  project_name = var.project_name

  vpc_id = module.networking.vpc_id
  subnets = values(module.networking.aws_public_subnet_ids)
  security_group_ids = [module.alb_security_group.aws_security_group_id]

  load_balancer_type = "application"

  target_group_port = 80
  target_group_protocol = "HTTP"

  health_check_interval = 120
  health_check_path = "/"
  health_check_timeout = 30

  certificate_arn = ""
}
