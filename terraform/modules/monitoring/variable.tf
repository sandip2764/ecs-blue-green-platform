variable "project_name" {
  type = string
}

variable "endpoint" {
  default = "konjno29@gmail.com"
  type    = string
}

variable "aws_ecs_cluster_name" {
  type = string
}

variable "aws_ecs_service_name" {
  type = string
}

variable "alb_arn_suffix" {
  type = string
}

variable "tg_blue_arn_suffix" {
  type = string
}

variable "tg_green_arn_suffix" {
  type = string
}

variable "DBInstanceIdentifier" {
  type = string
}

variable "aws_region" {
  type = string
}