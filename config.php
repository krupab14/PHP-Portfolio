<?php
/**
 * Environment Configuration
 * Handles different environments (development, production)
 */

// Determine environment
$environment = $_ENV['ENVIRONMENT'] ?? 'development';

// Database configuration for phpMyAdmin setup
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'cv_db');

// Development settings for local phpMyAdmin
define('DEBUG_MODE', true);
define('DISPLAY_ERRORS', true);

// Error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

// Common settings
define('SITE_URL', 'http://localhost');
define('UPLOAD_PATH', __DIR__ . '/uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_FILE_TYPES', ['image/jpeg', 'image/jpg', 'image/png', 'image/gif']);

// Session configuration
define('SESSION_LIFETIME', 86400); // 24 hours
define('CSRF_TOKEN_LIFETIME', 3600); // 1 hour

// Timezone
date_default_timezone_set('UTC');
?>