<?php

namespace App\Models;

use PDO;
use Exception;
use PDOException;

class PostLike
{
    private static $conn;

    private static function init()
    {
        if (self::$conn === null) {
            require __DIR__ . '/../config/db.conn.php';
            self::$conn = $conn;
        }
    }

    public static function likePost($postId, $userId)
    {
        self::init();
        try {
            $query = "INSERT INTO POSTS_LIKES (post_id, user_id) VALUES (?, ?)";
            $stmt = self::$conn->prepare($query);
            $stmt->execute([$postId, $userId]);
            die(var_dump('here'));

            // Update total likes count in the POSTS table
            self::updateTotalLikesCount($postId);

            return true;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public static function unlikePost($postId, $userId)
    {
        self::init();
        try {
            $query = "DELETE FROM POSTS_LIKES WHERE post_id = ? AND user_id = ?";
            $stmt = self::$conn->prepare($query);
            $stmt->execute([$postId, $userId]);

            // Update total likes count in the POSTS table
            self::updateTotalLikesCount($postId);

            return true;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    private static function updateTotalLikesCount($postId)
    {
        $query = "UPDATE POSTS SET total_likes = (SELECT COUNT(*) FROM POSTS_LIKES WHERE post_id = ?) WHERE id = ?";
        $stmt = self::$conn->prepare($query);
        $stmt->execute([$postId, $postId]);
    }
}
