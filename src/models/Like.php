<?php

namespace App\Models;

use PDO;
use Exception;
use PDOException;

class Like
{
    private static $conn;

    public static function init()
    {
        if (self::$conn === null) {
            require_once __DIR__ . '/../config/db.conn.php';
            self::$conn = $conn;
        }
    }
    
    public static function create($post_id, $user_id)
    {
        self::init();
        $stmt = self::$conn->prepare("INSERT INTO likes (post_id, user_id) VALUES (?, ?)");
        return $stmt->execute([$post_id, $user_id]);
    }

    public static function delete($like_id)
    {
        self::init();
        $stmt = self::$conn->prepare("DELETE FROM likes WHERE like_id = ?");
        return $stmt->execute([$like_id]);
    }
}
