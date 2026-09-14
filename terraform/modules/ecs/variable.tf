variable "project_name" {
  description = "Project name used for ECS resources"
  type        = string
}

variable "aws_region" {
  description = "AWS region"
  type        = string
}

variable "container_name" {
  description = "Name of the application container"
  type        = string
}

variable "container_image" {
  description = "Docker image URI used by the ECS task"
  type        = string
}

variable "container_port" {
  description = "Application container port"
  type        = number
  default     = 80
}

variable "task_cpu" {
  description = "Fargate task CPU units"
  type        = number
  default     = 256
}

variable "task_memory" {
  description = "Fargate task memory in MiB"
  type        = number
  default     = 512
}

variable "desired_count" {
  description = "Number of ECS tasks"
  type        = number
  default     = 2
}

variable "execution_role_arn" {
  description = "ECS task execution role ARN"
  type        = string
}

variable "task_role_arn" {
  description = "ECS application task role ARN"
  type        = string
}

variable "private_subnet_ids" {
  description = "Private subnet IDs where ECS tasks run"
  type        = list(string)
}

variable "security_group_id" {
  description = "Security group attached to ECS tasks"
  type        = string
}

variable "blue_target_group_arn" {
  description = "Blue target group ARN used by the ECS service"
  type        = string
}

variable "log_group_name" {
  description = "CloudWatch log group name"
  type        = string
}