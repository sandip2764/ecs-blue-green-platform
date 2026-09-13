output "rds_endpoint" {
  value = aws_db_instance.this_db_instance.endpoint
}

output "host" {
  value = aws_db_instance.this_db_instance.address
}

output "database_name" {
  value = aws_db_instance.this_db_instance.db_name
}

output "db_instance_identifier" {
  value = aws_db_instance.this_db_instance.identifier
}

output "username" {
  value = aws_db_instance.this_db_instance.username
}

output "password" {
  value = aws_db_instance.this_db_instance.password
}

output "port" {
  value = aws_db_instance.this_db_instance.port
}