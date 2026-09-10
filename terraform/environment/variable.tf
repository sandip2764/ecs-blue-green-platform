variable "region" {
  type    = string
  default = "us-east-1"
}

variable "project_name" {
  default = "ecs-blue-green-platform"
  type    = string
}

variable "cidr_block" {
  type    = string
  default = "10.0.0.0/16"
}

variable "aws_public_subnet_cidrs_az" {
  type = map(object({
    cidr = string
    az   = string
  }))

  default = {
    public-a = {
      cidr = "10.0.1.0/24"
      az   = "us-east-1a"
    }

    public-b = {
      cidr = "10.0.2.0/24"
      az   = "us-east-1b"
    }
  }
}

variable "aws_private_subnet_cidrs_az" {
  type = map(object({
    cidr = string
    az   = string
  }))

  default = {
    private-a = {
      cidr = "10.0.3.0/24"
      az   = "us-east-1a"
    }

    private-b = {
      cidr = "10.0.4.0/24"
      az   = "us-east-1b"
    }
  }
}

# sg

variable "lb_allowed_ports" {
  default = {
    http  = 80,
    https = 443
  }
}

variable "ecs_farget_allowed_ports" {
  default = {
    tcp = 80
  }
}

variable "rds_allowed_ports" {
  default = {
    mysql = 3306
  }
}