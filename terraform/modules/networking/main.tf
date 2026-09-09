# create custom vpc

resource "aws_vpc" "this" {
  cidr_block = var.cidr_block
  enable_dns_hostnames = true
  enable_dns_support = true

  tags = {
    Name = var.project_name
  }
}

# public subnet 

resource "aws_subnet" "public" {
  for_each = var.aws_public_subnet_cidrs_az

  vpc_id = aws_vpc.this.id
  cidr_block = each.value.cidr
  availability_zone = each.value.az
  map_public_ip_on_launch = true

  tags = {
    Name = "${var.project_name}-${each.key}-Subnet"
  }

}

# private subnets

resource "aws_subnet" "private" {
  for_each = var.aws_private_subnet_cidrs_az

  vpc_id = aws_vpc.this.id
  cidr_block = each.value.cidr
  availability_zone = each.value.az
 
  tags = {
    Name = "${var.project_name}-${each.key}-Subnet"
  }

}

# internet gateway

resource "aws_internet_gateway" "this" {
  vpc_id = aws_vpc.this.id

  tags = {
    Name = "${var.project_name}-igw"
  }
}

# elastic ip

resource "aws_eip" "this" {
  domain = "vpc"

  tags = {
    Name = "${var.project_name}-eip"
  }

}

# nat gateway

resource "aws_nat_gateway" "this" {
  allocation_id = aws_eip.this.id
  subnet_id = values(aws_subnet.public)[0].id

  tags = {
    Name = "${var.project_name}-nat"
  }

  depends_on = [ aws_internet_gateway.this ]
}

# route table for public

resource "aws_route_table" "public" {
  vpc_id = aws_vpc.this.id

  route {
    cidr_block = "0.0.0.0/0"
    gateway_id = aws_internet_gateway.this.id
  }

  tags = {
    Name = "${var.project_name}-public-rt"
  }
}

# route table private for natgateway

resource "aws_route_table" "private" {
  vpc_id = aws_vpc.this.id

  route {
    cidr_block = "0.0.0.0/0"
    gateway_id = aws_nat_gateway.this.id
  }

  tags = {
    Name = "${var.project_name}-private-rt"
  }
}

# route table association for public subnet 

resource "aws_route_table_association" "public" {
  for_each = aws_subnet.public

  route_table_id = aws_route_table.public.id
  subnet_id = each.value.id
}

# route table association for private subnet 

resource "aws_route_table_association" "private" {
  for_each = aws_subnet.private

  route_table_id = aws_route_table.private.id
  subnet_id = each.value.id
}
