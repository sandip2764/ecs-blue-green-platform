resource "aws_db_subnet_group" "this_subnet_group" {
  subnet_ids = var.subnet_ids

}

resource "aws_db_instance" "this_db_instance" {
  identifier = var.identifier
  instance_class = var.instance_class

  allocated_storage = var.storage
  storage_type = var.storage_type
  vpc_security_group_ids = var.security_group

  engine = var.engine
  engine_version = var.engine_version

  username = var.username
  password = var.password

  db_subnet_group_name = aws_db_subnet_group.this_subnet_group.name

  publicly_accessible = var.publicly_accessible
  skip_final_snapshot = var.skip_final_snapshot

}

