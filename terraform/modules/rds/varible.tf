variable "subnet_ids" {
  type = list(string)
}

variable "identifier" {
  type = string
}

variable "security_group" {
  type = list(string)
}

variable "instance_class" {
  type = string
}

variable "storage" {
  type = number
}

variable "storage_type" {
  type = string
}

variable "engine" {
  type = string
}

variable "engine_version" {
  type = string
}

variable "username" {
  type = string
}

variable "password" {
  type = string
}

variable "publicly_accessible" {
  type = bool
}

variable "skip_final_snapshot" {
  type = bool
}

variable "prevent_destroy" {
  type = bool
  default = null
}