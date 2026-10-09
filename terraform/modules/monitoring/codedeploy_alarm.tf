resource "aws_cloudwatch_metric_alarm" "codedeploy" {
  for_each = local.codedeploy_alarm_configs

  alarm_name = "${var.project_name}-codedeploy-${each.key}"

  alarm_description = each.value.description

  namespace   = each.value.namespace
  metric_name = each.value.metric_name

  statistic = each.value.statistic

  period              = each.value.period
  evaluation_periods  = each.value.evaluation_periods
  datapoints_to_alarm = each.value.datapoints_to_alarm

  threshold           = each.value.threshold
  comparison_operator = each.value.comparison_operator

  treat_missing_data = each.value.treat_missing_data

  actions_enabled = true

  alarm_actions = [
    aws_sns_topic.alerts.arn
  ]

  ok_actions = [
    aws_sns_topic.alerts.arn
  ]

  dimensions = each.key == "target_5xx" ? {
    LoadBalancer = var.alb_arn_suffix
  } : {}

  tags = {
    Name = "${var.project_name}-codedeploy-${each.key}"
  }
}