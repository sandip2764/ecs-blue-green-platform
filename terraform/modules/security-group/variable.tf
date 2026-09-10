variable "name_prefix" {
  type = string
}

variable "vpc_id" {
  type = string
}

variable "description" {
  type = string
}

variable "allowed_ports" {
  type = map(number)
}

variable "ingress_source_ip" {
  type = string
  default = null
}

variable "referenced_security_group_id" {
  type = string
  default = null
}

variable "tags" {
  type    = map(string)
}
