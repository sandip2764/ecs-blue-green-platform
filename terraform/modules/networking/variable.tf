variable "cidr_block" {
  type = string
}

variable "project_name" {
  type = string
}

variable "aws_public_subnet_cidrs_az" {
  type = map(object({
    cidr = string
    az = string
  }))
}

variable "aws_private_subnet_cidrs_az" {
  type = map(object({
    cidr = string
    az = string
  }))
}

variable "common_tags" {
  type    = map(string)
  default = {}
}