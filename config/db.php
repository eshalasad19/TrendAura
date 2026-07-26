<?php
/**
 * Central DB connection (used by admin/*.php via '../config/db.php').
 * Credentials now come from environment variables (.env), not hardcoded values.
 */
require_once __DIR__ . '/env.php';
load_env(__DIR__ . '/../.env');

$host     = env('DB_HOST', 'localhost');
$name     = env('DB_USER', 'root');
$password = env('DB_PASS', '');
$dbname   = env('DB_NAME', 'ecommerce');
$port     = env('DB_PORT', '3306');

$conn = mysqli_connect($host, $name, $password, $dbname, $port);
if (!$conn) {
    // Don't leak connection details to the browser in production.
    error_log('Database connection failed: ' . mysqli_connect_error());
    if (env('APP_ENV', 'local') === 'local') {
        die('Database not connected: ' . mysqli_connect_error());
    }
    die('Service temporarily unavailable. Please try again later.');
}
?>
