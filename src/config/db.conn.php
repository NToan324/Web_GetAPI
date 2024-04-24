<?php
$host = 'localhost';
$db_name = 'social_media';
$username = 'root';
$db_password = '12345';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $res = array(
        "succes" => false,
        "message" => $e->getMessage()
    );
    
    echo json_encode($res);
}
