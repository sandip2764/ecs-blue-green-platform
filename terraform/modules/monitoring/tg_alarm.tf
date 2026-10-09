resource "aws_cloudwatch_metric_alarm" "target_group" {
  for_each = local.target_group_alarms

  alarm_name = "${var.project_name}-${each.key}"

  alarm_description = each.value.description

  namespace   = "AWS/ApplicationELB"
  metric_name = each.value.metric_name

  dimensions = {
    LoadBalancer = var.alb_arn_suffix
    TargetGroup  = each.value.target_group_arn_suffix
  }

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

  tags = {
    Name = "${var.project_name}-TG-${each.key}"
  }
}