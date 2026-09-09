# key pair
resource "aws_key_pair" "this_key_pair" {
  key_name   = "terra_key_ec2"
  public_key = file("terra_key_ec2.pub")
}

# networking
module "networking" {
  source = "../modules/networking/"

  project_name = var.project_name

  cidr_block = var.cidr_block

  aws_public_subnet_cidrs_az = var.aws_public_subnet_cidrs_az

  aws_private_subnet_cidrs_az = var.aws_private_subnet_cidrs_az
}

