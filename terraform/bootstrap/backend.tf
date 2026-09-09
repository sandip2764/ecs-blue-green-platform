terraform {
  backend "s3" {
    bucket       = "cloud-projects-terraform-state-2026"
    key          = "ecs-blue-green-platform/bootstrap/terraform.tfstate"
    region       = "us-east-1"
    use_lockfile = true
  }
}