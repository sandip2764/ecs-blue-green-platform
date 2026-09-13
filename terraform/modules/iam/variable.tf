variable "project_name" {
  type = string
}

variable "github_repository" {
  type = string
}

variable "ecr_repository_arn" {
  type = string
}

variable "codedeploy_application_arn" {
  type = string
}

variable "codedeploy_deployment_group_arn" {
  type = string
}

variable "db_secret_arn" {
  type = string
}