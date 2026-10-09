resource "aws_cloudwatch_metric_alarm" "rds" {

  for_each = local.rds_alarms

  alarm_name = "${var.project_name}-rds-${each.key}"

  alarm_description = each.value.description

  namespace   = "AWS/RDS"
  metric_name = each.value.metric_name

  statistic           = each.value.statistic
  period              = each.value.period
  evaluation_periods  = each.value.evaluation_periods
  datapoints_to_alarm = each.value.datapoints_to_alarm

  comparison_operator = each.value.comparison_operator
  threshold           = each.value.threshold

  treat_missing_data = each.value.treat_missing_data
  actions_enabled    = each.value.actions_enabled

  dimensions = {
    DBInstanceIdentifier = var.DBInstanceIdentifier
  }

  alarm_actions = [
    aws_sns_topic.alerts.arn
  ]

  ok_actions = [
    aws_sns_topic.alerts.arn
  ]

  tags = {
    Name = "${var.project_name}-rds-${each.key}"
  }
}