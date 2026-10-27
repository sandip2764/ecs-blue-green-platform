resource "aws_ecs_task_definition" "db_import" {
  family                   = "karfect-db-import"
  requires_compatibilities = ["FARGATE"]
  network_mode             = "awsvpc"
  cpu                      = "256"
  memory                   = "512"
  execution_role_arn       = module.iam.ecs_task_execution_role_arn
  container_definitions = jsonencode([
    {
      name      = "db-import"
      image     = "${data.terraform_remote_state.bootstrap.outputs.aws_ecr_repository_url}:db-import-latest"
      essential = true

      secrets = [
        { name = "DB_HOST", valueFrom = "${aws_secretsmanager_secret.db.arn}:host::" },
        { name = "DB_PORT", valueFrom = "${aws_secretsmanager_secret.db.arn}:port::" },
        { name = "DB_NAME", valueFrom = "${aws_secretsmanager_secret.db.arn}:database::" },
        { name = "DB_USERNAME", valueFrom = "${aws_secretsmanager_secret.db.arn}:username::" },
        { name = "DB_PASSWORD", valueFrom = "${aws_secretsmanager_secret.db.arn}:password::" }
      ]

      logConfiguration = {
        logDriver = "awslogs"
        options = {
          awslogs-group         = module.monitoring.ecs_log_group_name
          awslogs-region        = var.region
          awslogs-stream-prefix = "import"
        }
      }
    }
  ])
}