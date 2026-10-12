# networking

output "vpc_id" {
  value = module.networking.vpc_id
}

output "public_subnet_ids" {
  value = module.networking.aws_public_subnet_ids
}

output "private_subnet_ids" {
  value = module.networking.aws_private_subnet_ids
}

output "internet_gateway_id" {
  value = module.networking.internet_gateway_id
}

output "nat_gateway_id" {
  value = module.networking.nat_gateway_id
}


output "ecs_cluster_name" {
  value = module.ecs.cluster_name
}

output "ecs_security_group_id" {
  value = module.ecs_farget_security_group.aws_security_group_id
}

output "ecr_repository_url" {
  value = data.terraform_remote_state.bootstrap.outputs.aws_ecr_repository_url
}