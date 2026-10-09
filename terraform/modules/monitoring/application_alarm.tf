# create metric filter to convert logs into understandble numeric for triggering alarm

resource "aws_cloudwatch_log_metric_filter" "application" {
  for_each = local.application_log_monitors

  name           = "${var.project_name}-${each.key}"
  log_group_name = aws_cloudwatch_log_group.ecs.name
  pattern        = each.value.pattern

  metric_transformation {
    name          = each.value.metric_name
    namespace     = "${var.project_name}/Application"
    value         = "1"
    default_value = 0
  }
}

# alarms

resource "aws_cloudwatch_metric_alarm" "application" {
  for_each = local.application_log_monitors

  alarm_name = "${var.project_name}-${each.key}"

  alarm_description = each.value.description

  namespace   = "${var.project_name}/Application"
  metric_name = each.value.metric_name

  statistic = "Sum"

  period              = each.value.period
  evaluation_periods  = each.value.evaluation_periods
  datapoints_to_alarm = each.value.datapoints_to_alarm

  threshold           = each.value.threshold
  comparison_operator = "GreaterThanOrEqualToThreshold"

  treat_missing_data = "notBreaching"

  actions_enabled = true

  alarm_actions = [
    aws_sns_topic.alerts.arn
  ]

  ok_actions = [
    aws_sns_topic.alerts.arn
  ]

  tags = {
    Name = "${var.project_name}-application-${each.key}"
  }
}