resource "aws_sns_topic" "alerts" {
  name = "${var.project_name}-alerts"

  tags = {
    Name = "${var.project_name}-alerts"
  }
}

resource "aws_sns_topic_subscription" "this" {

  topic_arn = aws_sns_topic.alerts.arn

  protocol = "email"

  endpoint = var.endpoint
}