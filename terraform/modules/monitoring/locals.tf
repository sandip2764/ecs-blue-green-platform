locals {

  # ECS alarms

  ecs_alarms = {

    cpu_high = {
      namespace           = "AWS/ECS"
      metric_name         = "CPUUtilization"
      statistic           = "Average"
      threshold           = 80
      comparison_operator = "GreaterThanOrEqualToThreshold"

      evaluation_periods  = 5
      datapoints_to_alarm = 3
      period              = 60

      treat_missing_data = "notBreaching"
    }

    memory_high = {
      namespace           = "AWS/ECS"
      metric_name         = "MemoryUtilization"
      statistic           = "Average"
      threshold           = 80
      comparison_operator = "GreaterThanOrEqualToThreshold"

      evaluation_periods  = 5
      datapoints_to_alarm = 3
      period              = 60

      treat_missing_data = "notBreaching"
    }

    running_tasks_low = {
      namespace           = "ECS/ContainerInsights"
      metric_name         = "RunningTaskCount"
      statistic           = "Minimum"
      threshold           = 1
      comparison_operator = "LessThanThreshold"

      evaluation_periods  = 2
      datapoints_to_alarm = 2
      period              = 60

      treat_missing_data = "breaching"
    }

  }

  # alb_alarms

  alb_alarms = {

    elb_5xx = {
      metric_name         = "HTTPCode_ELB_5XX_Count"
      statistic           = "Sum"
      period              = 60
      evaluation_periods  = 5
      datapoints_to_alarm = 3

      comparison_operator = "GreaterThanOrEqualToThreshold"
      threshold           = 5

      treat_missing_data = "notBreaching"
      actions_enabled    = true

      description = "ALB is returning 5XX errors."
    }

    target_5xx = {
      metric_name         = "HTTPCode_Target_5XX_Count"
      statistic           = "Sum"
      period              = 60
      evaluation_periods  = 5
      datapoints_to_alarm = 3

      comparison_operator = "GreaterThanOrEqualToThreshold"
      threshold           = 5

      treat_missing_data = "notBreaching"
      actions_enabled    = true

      description = "ECS targets behind ALB are returning 5XX errors."
    }

    unhealthy_hosts = {
      metric_name         = "UnHealthyHostCount"
      statistic           = "Maximum"
      period              = 60
      evaluation_periods  = 2
      datapoints_to_alarm = 2

      comparison_operator = "GreaterThanOrEqualToThreshold"
      threshold           = 1

      treat_missing_data = "notBreaching"
      actions_enabled    = true

      description = "ALB has unhealthy targets."
    }

    target_response_time = {
      metric_name         = "TargetResponseTime"
      statistic           = "Average"
      period              = 60
      evaluation_periods  = 5
      datapoints_to_alarm = 3

      comparison_operator = "GreaterThanOrEqualToThreshold"
      threshold           = 2

      treat_missing_data = "notBreaching"
      actions_enabled    = true

      description = "ALB target response time is high."
    }
  }

  # rds alarms

  rds_alarms = {

    cpu_high = {

      metric_name         = "CPUUtilization"
      statistic           = "Average"
      period              = 60
      evaluation_periods  = 5
      datapoints_to_alarm = 3

      comparison_operator = "GreaterThanOrEqualToThreshold"
      threshold           = 80

      treat_missing_data = "notBreaching"
      actions_enabled    = true

      description = "RDS CPU utilization is consistently high."
    }

    memory_low = {

      metric_name         = "FreeableMemory"
      statistic           = "Average"
      period              = 60
      evaluation_periods  = 5
      datapoints_to_alarm = 3

      comparison_operator = "LessThanOrEqualToThreshold"

      # Example: 512 MiB
      threshold = 536870912

      treat_missing_data = "notBreaching"
      actions_enabled    = true

      description = "RDS freeable memory is critically low."
    }

    connections_high = {

      metric_name         = "DatabaseConnections"
      statistic           = "Average"
      period              = 60
      evaluation_periods  = 5
      datapoints_to_alarm = 3

      comparison_operator = "GreaterThanOrEqualToThreshold"

      # Tune this according to your DB instance
      threshold = 80

      treat_missing_data = "notBreaching"
      actions_enabled    = true

      description = "RDS database connections are consistently high."
    }

    storage_low = {

      metric_name         = "FreeStorageSpace"
      statistic           = "Minimum"
      period              = 60
      evaluation_periods  = 5
      datapoints_to_alarm = 3

      comparison_operator = "LessThanOrEqualToThreshold"

      # Example: 10 GiB
      threshold = 10737418240

      treat_missing_data = "notBreaching"
      actions_enabled    = true

      description = "RDS free storage space is critically low."
    }

    read_latency_high = {

      metric_name         = "ReadLatency"
      statistic           = "Average"
      period              = 60
      evaluation_periods  = 5
      datapoints_to_alarm = 3

      comparison_operator = "GreaterThanOrEqualToThreshold"

      # Seconds. Example: 100 ms
      threshold = 0.1

      treat_missing_data = "notBreaching"
      actions_enabled    = true

      description = "RDS read latency is consistently high."
    }

    write_latency_high = {

      metric_name         = "WriteLatency"
      statistic           = "Average"
      period              = 60
      evaluation_periods  = 5
      datapoints_to_alarm = 3

      comparison_operator = "GreaterThanOrEqualToThreshold"
      threshold           = 0.1

      treat_missing_data = "notBreaching"
      actions_enabled    = true

      description = "RDS write latency is consistently high."
    }
  }


  # application log monitor

  application_log_monitors = {
    php_errors = {
      pattern             = "?\"PHP Fatal error\" ?\"PHP Parse error\" ?\"Uncaught Error\" ?\"Uncaught Exception\""
      metric_name         = "PHPErrorCount"
      description         = "Counts PHP fatal errors, parse errors, and uncaught exceptions."
      threshold           = 1
      period              = 300
      evaluation_periods  = 1
      datapoints_to_alarm = 1
    }

    database_errors = {
      pattern             = "?\"mysqli_connect\" ?\"mysqli_sql_exception\" ?\"PDOException\" ?\"SQLSTATE\" ?\"Connection refused\" ?\"Connection timed out\""
      metric_name         = "DatabaseErrorCount"
      description         = "Counts application database connection and database-related errors."
      threshold           = 3
      period              = 300
      evaluation_periods  = 1
      datapoints_to_alarm = 1
    }

    application_errors = {
      pattern             = "\"ERROR\""
      metric_name         = "ApplicationErrorCount"
      description         = "Counts application-level ERROR messages."
      threshold           = 5
      period              = 300
      evaluation_periods  = 1
      datapoints_to_alarm = 1
    }
  }


  # target group alarm config 

  target_group_alarm_configs = {

    blue = {

      target_group_arn_suffix = var.tg_blue_arn_suffix

      alarms = {
        unhealthy_hosts = {

          metric_name         = "UnHealthyHostCount"
          statistic           = "Maximum"
          period              = 60
          evaluation_periods  = 2
          datapoints_to_alarm = 2
          threshold           = 1
          comparison_operator = "GreaterThanOrEqualToThreshold"
          treat_missing_data  = "notBreaching"

          description = "Triggers when one or more targets in the Blue target group remain unhealthy."
        }

        target_5xx = {

          metric_name         = "HTTPCode_Target_5XX_Count"
          statistic           = "Sum"
          period              = 60
          evaluation_periods  = 5
          datapoints_to_alarm = 3
          threshold           = 5
          comparison_operator = "GreaterThanOrEqualToThreshold"
          treat_missing_data  = "notBreaching"

          description = "Triggers when the Blue target group returns elevated HTTP 5XX errors."
        }
      }
    }

    green = {

      target_group_arn_suffix = var.tg_green_arn_suffix

      alarms = {
        unhealthy_hosts = {

          metric_name         = "UnHealthyHostCount"
          statistic           = "Maximum"
          period              = 60
          evaluation_periods  = 2
          datapoints_to_alarm = 2
          threshold           = 1
          comparison_operator = "GreaterThanOrEqualToThreshold"
          treat_missing_data  = "notBreaching"

          description = "Triggers when one or more targets in the Green target group remain unhealthy."
        }

        target_5xx = {

          metric_name         = "HTTPCode_Target_5XX_Count"
          statistic           = "Sum"
          period              = 60
          evaluation_periods  = 5
          datapoints_to_alarm = 3
          threshold           = 5
          comparison_operator = "GreaterThanOrEqualToThreshold"
          treat_missing_data  = "notBreaching"

          description = "Triggers when the Green target group returns elevated HTTP 5XX errors."
        }
      }
    }
  }


  # before use for_each should it be flatten

  target_group_alarms = merge(
    [
      for tg_name, tg_config in local.target_group_alarm_configs : {
        for alarm_name, alarm_config in tg_config.alarms :
        "${tg_name}-${alarm_name}" => merge(
          alarm_config,
          {
            target_group_name       = tg_name
            target_group_arn_suffix = tg_config.target_group_arn_suffix
          }
        )
      }
    ]...
  )

  # code deploy alarms


  codedeploy_alarm_configs = {
    target_5xx = {
      metric_name = "HTTPCode_Target_5XX_Count"
      namespace   = "AWS/ApplicationELB"
      statistic   = "Sum"

      period              = 60
      evaluation_periods  = 2
      datapoints_to_alarm = 2

      threshold           = 1
      comparison_operator = "GreaterThanOrEqualToThreshold"
      treat_missing_data  = "notBreaching"

      description = "Stops the deployment when the application starts returning target-side HTTP 5XX errors."
    }

    application_errors = {
      metric_name = "ApplicationErrorCount"
      namespace   = "${var.project_name}/Application"
      statistic   = "Sum"

      period              = 60
      evaluation_periods  = 2
      datapoints_to_alarm = 2

      threshold           = 1
      comparison_operator = "GreaterThanOrEqualToThreshold"
      treat_missing_data  = "notBreaching"

      description = "Stops the deployment when application-level errors are detected."
    }

    database_errors = {
      metric_name = "DatabaseErrorCount"
      namespace   = "${var.project_name}/Application"
      statistic   = "Sum"

      period              = 60
      evaluation_periods  = 2
      datapoints_to_alarm = 1

      threshold           = 1
      comparison_operator = "GreaterThanOrEqualToThreshold"
      treat_missing_data  = "notBreaching"

      description = "Stops the deployment when database errors are detected."
    }
  }



}