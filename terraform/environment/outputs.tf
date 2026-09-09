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