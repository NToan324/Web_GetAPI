<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$host = $_ENV['DB_HOST'];
$db_name = $_ENV['DB_DATABASE'];
$username = $_ENV['DB_USERNAME'];
$db_password = $_ENV['DB_PASSWORD'];

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo 'Database connected!';
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
