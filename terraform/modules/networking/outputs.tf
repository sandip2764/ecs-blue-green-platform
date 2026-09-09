output "vpc_id" {
  value = aws_vpc.this.id
}

output "aws_public_subnet_ids" {
  value = {
    for name, subnet in aws_subnet.public :
    name => subnet.id
  }
}

output "aws_private_subnet_ids" {
  value = {
    for name, subnet in aws_subnet.private :
    name => subnet.id
  }
}

output "internet_gateway_id" {
  value = aws_internet_gateway.this.id
}

output "nat_gateway_id" {
  value = aws_nat_gateway.this.id
}