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
      image     = "${aws_ecr_repository.app.repository_url}:db-import-latest"
      essential = true

      environment = [
        { name = "DB_PORT", value = "3306" }
      ]

      secrets = [
        { name = "DB_HOST",     valueFrom = "${aws_secretsmanager_secret.db.arn}:host::" },
        { name = "DB_NAME",     valueFrom = "${aws_secretsmanager_secret.db.arn}:db::" },
        { name = "DB_USERNAME", valueFrom = "${aws_secretsmanager_secret.db.arn}:username::" },
        { name = "DB_PASSWORD", valueFrom = "${aws_secretsmanager_secret.db.arn}:password::" }
      ]

      logConfiguration = {
        logDriver = "awslogs"
        options = {
          awslogs-group         = module.monitoring.aws_cloudwatch_log_group.ecs.name
          awslogs-region        = var.region
          awslogs-stream-prefix = "import"
        }
      }
    }
  ])
}