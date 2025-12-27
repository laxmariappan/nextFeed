<?php
echo "=== PHP Debug Info ===\n\n";

echo "PHP Version: " . phpversion() . "\n";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' . "\n";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown' . "\n";
echo "Script Filename: " . __FILE__ . "\n\n";

echo "=== Environment Variables ===\n";
echo "APP_ENV: " . getenv('APP_ENV') . "\n";
echo "APP_DEBUG: " . getenv('APP_DEBUG') . "\n";
echo "APP_KEY: " . (getenv('APP_KEY') ? 'Set (' . strlen(getenv('APP_KEY')) . ' chars)' : 'Not Set') . "\n";
echo "DB_HOST: " . getenv('DB_HOST') . "\n";
echo "DB_PORT: " . getenv('DB_PORT') . "\n";
echo "DB_DATABASE: " . getenv('DB_DATABASE') . "\n";
echo "DB_USERNAME: " . getenv('DB_USERNAME') . "\n\n";

echo "=== File System ===\n";
echo "Current directory: " . getcwd() . "\n";
echo "Index.php exists: " . (file_exists(__DIR__ . '/index.php') ? 'Yes' : 'No') . "\n";
echo "Bootstrap exists: " . (file_exists(__DIR__ . '/../bootstrap/app.php') ? 'Yes' : 'No') . "\n\n";

echo "=== Laravel Bootstrap Test ===\n";
try {
    require __DIR__ . '/../vendor/autoload.php';
    echo "Autoload: OK\n";

    $app = require_once __DIR__ . '/../bootstrap/app.php';
    echo "Bootstrap: OK\n";

    echo "App instance: " . get_class($app) . "\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n=== END DEBUG ===\n";
