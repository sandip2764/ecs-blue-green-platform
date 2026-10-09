resource "aws_cloudwatch_dashboard" "main" {
  dashboard_name = "${var.project_name}-dashboard"

  dashboard_body = jsonencode({
    widgets = [

      # ==========================================================
      # ECS
      # ==========================================================
      {
        type   = "metric"
        x      = 0
        y      = 0
        width  = 12
        height = 6

        properties = {
          title  = "ECS - CPU & Memory"
          region = var.aws_region

          view    = "timeSeries"
          stacked = false

          metrics = [
            [
              "AWS/ECS",
              "CPUUtilization",
              "ClusterName",
              var.aws_ecs_cluster_name,
              "ServiceName",
              var.aws_ecs_service_name
            ],
            [
              ".",
              "MemoryUtilization",
              ".",
              ".",
              ".",
              "."
            ]
          ]

          period = 300
          stat   = "Average"

          yAxis = {
            left = {
              min = 0
              max = 100
            }
          }
        }
      },

      {
        type   = "metric"
        x      = 12
        y      = 0
        width  = 12
        height = 6

        properties = {
          title  = "ECS - Running Tasks"
          region = var.aws_region

          view = "timeSeries"

          metrics = [
            [
              "ECS/ContainerInsights",
              "RunningTaskCount",
              "ClusterName",
              var.aws_ecs_cluster_name,
              "ServiceName",
              var.aws_ecs_service_name
            ]
          ]

          period = 60
          stat   = "Average"
        }
      },

      # ==========================================================
      # ALB
      # ==========================================================
      {
        type   = "metric"
        x      = 0
        y      = 6
        width  = 12
        height = 6

        properties = {
          title  = "ALB - Errors"
          region = var.aws_region

          view = "timeSeries"

          metrics = [
            [
              "AWS/ApplicationELB",
              "HTTPCode_ELB_5XX_Count",
              "LoadBalancer",
              var.alb_arn_suffix
            ],
            [
              ".",
              "HTTPCode_Target_5XX_Count",
              "LoadBalancer",
              var.alb_arn_suffix
            ]
          ]

          period = 60
          stat   = "Sum"
        }
      },

      {
        type   = "metric"
        x      = 12
        y      = 6
        width  = 12
        height = 6

        properties = {
          title  = "ALB - Response Time & Unhealthy Hosts"
          region = var.aws_region

          view = "timeSeries"

          metrics = [
            [
              "AWS/ApplicationELB",
              "TargetResponseTime",
              "LoadBalancer",
              var.alb_arn_suffix
            ],
            [
              ".",
              "UnHealthyHostCount",
              "LoadBalancer",
              var.alb_arn_suffix
            ]
          ]

          period = 60
          stat   = "Average"
        }
      },

      # ==========================================================
      # BLUE / GREEN
      # ==========================================================
      {
        type   = "metric"
        x      = 0
        y      = 12
        width  = 12
        height = 6

        properties = {
          title  = "Blue Target Group"
          region = var.aws_region

          view = "timeSeries"

          metrics = [
            [
              "AWS/ApplicationELB",
              "UnHealthyHostCount",
              "LoadBalancer",
              var.alb_arn_suffix,
              "TargetGroup",
              var.tg_blue_arn_suffix,

              {
                stat = "Maximum"
              }
            ],
            [
              ".",
              "HTTPCode_Target_5XX_Count",
              ".",
              ".",
              ".",
              ".",

              {
                stat = "Sum"
              }
            ]
          ]

          period = 60
        }
      },

      {
        type   = "metric"
        x      = 12
        y      = 12
        width  = 12
        height = 6

        properties = {
          title  = "Green Target Group"
          region = var.aws_region

          view = "timeSeries"

          metrics = [
            [
              "AWS/ApplicationELB",
              "UnHealthyHostCount",
              "LoadBalancer",
              var.alb_arn_suffix,
              "TargetGroup",
              var.tg_green_arn_suffix,

              {
                stat = "Maximum"
              }
            ],
            [
              ".",
              "HTTPCode_Target_5XX_Count",
              ".",
              ".",
              ".",
              ".",

              {
                stat = "Sum"
              }
            ]
          ]

          period = 60
        }
      },

      # ==========================================================
      # RDS
      # ==========================================================
      {
        type   = "metric"
        x      = 0
        y      = 18
        width  = 12
        height = 6

        properties = {
          title  = "RDS - CPU & Connections"
          region = var.aws_region

          view = "timeSeries"

          metrics = [
            [
              "AWS/RDS",
              "CPUUtilization",
              "DBInstanceIdentifier",
              var.DBInstanceIdentifier
            ],
            [
              ".",
              "DatabaseConnections",
              ".",
              "."
            ]
          ]

          period = 300
          stat   = "Average"
        }
      },

      {
        type   = "metric"
        x      = 12
        y      = 18
        width  = 12
        height = 6

        properties = {
          title  = "RDS - Storage & Latency"
          region = var.aws_region

          view = "timeSeries"

          metrics = [
            [
              "AWS/RDS",
              "FreeStorageSpace",
              "DBInstanceIdentifier",
              var.DBInstanceIdentifier
            ],
            [
              ".",
              "ReadLatency",
              ".",
              "."
            ],
            [
              ".",
              "WriteLatency",
              ".",
              "."
            ]
          ]

          period = 300
          stat   = "Average"
        }
      },

      # ==========================================================
      # APPLICATION
      # ==========================================================
      {
        type   = "metric"
        x      = 0
        y      = 24
        width  = 24
        height = 6

        properties = {
          title  = "Application Errors"
          region = var.aws_region

          view = "timeSeries"

          metrics = [
            [
              "${var.project_name}/Application",
              "PHPErrorCount"
            ],
            [
              ".",
              "DatabaseErrorCount"
            ],
            [
              ".",
              "ApplicationErrorCount"
            ]
          ]

          period = 300
          stat   = "Sum"
        }
      }
    ]
  })
}