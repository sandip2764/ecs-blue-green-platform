resource "aws_cloudwatch_metric_alarm" "ecs" {

  for_each = local.ecs_alarms

  alarm_name = "${var.project_name}-ecs-${each.key}"

  alarm_description = (
    "ECS ${each.key} alarm for ${var.aws_ecs_service_name}"
  )

  namespace   = each.value.namespace
  metric_name = each.value.metric_name

  dimensions = {
    ClusterName = var.aws_ecs_cluster_name
    ServiceName = var.aws_ecs_service_name
  }

  statistic = each.value.statistic
  period    = each.value.period

  evaluation_periods  = each.value.evaluation_periods
  datapoints_to_alarm = each.value.datapoints_to_alarm

  comparison_operator = each.value.comparison_operator
  threshold           = each.value.threshold

  treat_missing_data = each.value.treat_missing_data

  alarm_actions = [
    aws_sns_topic.alerts.arn
  ]

  ok_actions = [
    aws_sns_topic.alerts.arn
  ]

  tags = {
    Name = "${var.project_name}-ecs-${each.key}"
  }
}