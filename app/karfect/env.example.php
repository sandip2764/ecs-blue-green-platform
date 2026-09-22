<?php
// Environment Configuration
// Change the domain here for future updates
define('DOMAIN', 'https://sandip.qd.je');

// Base path derived from DOMAIN, used throughout the site for assets, links, etc.
define('BASE_PATH', DOMAIN . '/');

// Database Configuration
// Set USE_AWS_SECRETS to true to fetch DB credentials dynamically from AWS Secrets Manager
define('USE_AWS_SECRETS', true);
define('AWS_REGION', 'us-east-1');
define('AWS_SECRET_NAME', 'ecs-blue-green-platform-db-secret');

// Optional AWS Credentials (leave empty if using IAM Roles on EC2/ECS/EKS/Lambda)
// define('AWS_ACCESS_KEY_ID', '');
// define('AWS_SECRET_ACCESS_KEY', '');

// Fallback / Local Database Credentials (used when USE_AWS_SECRETS is false or AWS fetch fails)
define('DB_HOST', 'localhoat');
define('DB_USER', '');
define('DB_PASS', '');
define('DB_NAME', 'karfect');

// Google Maps API Key
define('GOOGLE_MAPS_API_KEY', 'your_google_maps_api_key_here');

// Google OAuth Credentials
define('GOOGLE_CLIENT_ID', 'your_google_client_id_here');
define('GOOGLE_CLIENT_SECRET', 'your_google_client_secret_here');
?>
