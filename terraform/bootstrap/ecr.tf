resource "aws_ecr_repository" "app_repo" {
  name = "ecs-blue-green-platform"

  image_tag_mutability = "MUTABLE"
  image_scanning_configuration {
    scan_on_push = true
  }

  tags = {
    Name = "ecs-blue-green-platform"
  }
}