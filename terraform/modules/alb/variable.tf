variable "project_name" {
  type = string
}

variable "subnets" {
  type = list(string)
}

variable "security_group_ids" {
  type = list(string)
}

variable "internal" {
  type    = bool
  default = false
}

variable "load_balancer_type" {
  type    = string
#   default = "application"
}

variable "tags" {
  type    = map(string)
  default = {}
}

# https listner

variable "ssl_policy" {
  type = string
  default = "ELBSecurityPolicy-2016-08"
}

variable "certificate_arn" {
  type = string
}

# tg group 

variable "vpc_id" {
  type = string
}

variable "target_group_port" {
  type    = number
}

variable "target_group_protocol" {
  type    = string
}


variable "health_check_path" {
  type    = string
}

variable "health_check_timeout" {
  type    = number
}

variable "health_check_interval" {
  type    = number
}

variable "tags" {
  type    = map(string)
  default = {}
}