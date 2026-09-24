variable "project_name" {
  type = string
}

variable "codedeploy_service_role_arn" {
  type = string
}

variable "ecs_cluster_name" {
  type = string
}

variable "ecs_service_name" {
  type = string
}

variable "https_listener_arn" {
  type = string
}

variable "blue_target_group_name" {
  type = string
}

variable "green_target_group_name" {
  type = string
}

variable "deployment_config_name" {
  type    = string
  default = "CodeDeployDefault.ECSAllAtOnce"
}