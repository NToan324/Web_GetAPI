<?php

namespace App\Models;



class Comment
{
    private static $conn;

    public static function init()
    {
        if (self::$conn === null) {
            require_once __DIR__ . '/../config/db.conn.php';
            self::$conn = $conn;
        }
    }
    
    public static function create($post_id, $user_id, $comment)
    {
        self::init();
        $stmt = self::$conn->prepare("INSERT INTO comments (post_id, user_id, comment) VALUES (?, ?, ?)");
        return $stmt->execute([$post_id, $user_id, $comment]);
    }

    public static function delete($comment_id)
    {
        self::init();
        $stmt = self::$conn->prepare("DELETE FROM comments WHERE comment_id = ?");
        return $stmt->execute([$comment_id]);
    }
}
