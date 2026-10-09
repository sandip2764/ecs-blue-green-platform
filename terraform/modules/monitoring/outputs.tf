output "ecs_log_group_name" {
  value = aws_cloudwatch_log_group.ecs.name
}

output "topic_arn" {
  value = aws_sns_topic.alerts.arn
}

output "codedeploy_alarm_names" {
  value = {
    for name, alarm in aws_cloudwatch_metric_alarm.codedeploy :
    name => alarm.alarm_name
  }
}