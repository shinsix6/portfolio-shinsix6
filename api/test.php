<?php
error_reporting(E_ALL);
ini_set("display_errors", "1");

echo "<h2>1. Environment & Extension Check</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "PDO MySQL Installed: " .
    (extension_loaded("pdo_mysql") ? "YES" : "NO") .
    "<br><br>";

echo "<h2>2. Database Connection Test</h2>";
$host = getenv("DB_HOST");
$port = getenv("DB_PORT") ?: 4000;
$db = getenv("DB_DATABASE");
$user = getenv("DB_USERNAME");
$pass = getenv("DB_PASSWORD");

echo "Host: <code>$host:$port</code><br>";
echo "Database: <code>$db</code><br><br>";

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
    $sslCa = defined("Pdo\Mysql::ATTR_SSL_CA")
        ? \Pdo\Mysql::ATTR_SSL_CA
        : \PDO::MYSQL_ATTR_SSL_CA;

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        $sslCa => true,
    ];
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "<h3 style='color:green;'>Database Connection Successful!</h3>";
} catch (\Exception $e) {
    echo "<h3 style='color:red;'>Database Connection Failed:</h3>";
    echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
}
