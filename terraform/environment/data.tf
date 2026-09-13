data "terraform_remote_state" "bootstrap" {
  backend = "s3"

  config = {
    bucket = "cloud-projects-terraform-state-2026"
    key    = "ecs-blue-green-platform/bootstrap/terraform.tfstate"
    region = "us-east-1"
  }
}