<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'landing_page_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// Paystack Configuration
define('PAYSTACK_SECRET_KEY', 'YOUR_PAYSTACK_SECRET_KEY');

// Email Configuration (SMTP)
define('SMTP_HOST', 'smtp.example.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'your-email@example.com');
define('SMTP_PASS', 'your-email-password');
define('FROM_EMAIL', 'noreply@yourdomain.com');
define('FROM_NAME', 'Landing Page Generator');

// Base URL
define('BASE_URL', "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/");
?>
