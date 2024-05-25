<?php

namespace App\Models;

use PDO;

class Post
{
    private static $conn;

    private static function init()
    {
        if (self::$conn === null) {
            require_once __DIR__ . '/../config/db.conn.php';
            self::$conn = $conn;
        }
    }

    public static function all()
    {
        self::init();
        $stmt = self::$conn->query("
            SELECT posts.*, users.name AS user_name, users.avatar AS avatar, TIMEDIFF(NOW(), posts.created_at) AS time_elapsed
            FROM posts
            JOIN users ON posts.user_id = users.id
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById($post_id)
    {
        self::init();
        $stmt = self::$conn->prepare("SELECT * FROM posts WHERE post_id = ?");
        $stmt->execute([$post_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($user_id, $content, $image = null)
    {
        self::init();
        $stmt = self::$conn->prepare("INSERT INTO posts (user_id, content, image) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $content, $image]);
        return self::$conn->lastInsertId();
    }

    public static function delete($post_id)
    {
        self::init();
        $stmt = self::$conn->prepare("DELETE FROM posts WHERE post_id = ?");
        return $stmt->execute([$post_id]);
    }

    public static function like($post_id, $user_id)
    {
        self::init();
        // Increase total_likes column in the posts table
        $stmt = self::$conn->prepare("UPDATE posts SET total_likes = total_likes + 1 WHERE post_id = ?");
        $stmt->execute([$post_id]);

        // Add a like to the likes table
        Like::create($post_id, $user_id);
    }

    public static function unlike($post_id, $user_id)
    {
        self::init();
        $stmt = self::$conn->prepare("UPDATE posts SET total_likes = total_likes - 1 WHERE post_id = ?");
        $stmt->execute([$post_id]);

        Like::delete($post_id, $user_id);
    }

    public static function comment($post_id, $user_id, $content)
    {
        self::init();
        $stmt = self::$conn->prepare("INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)");
        return $stmt->execute([$post_id, $user_id, $content]);
    }

    public static function deleteComment($comment_id)
    {
        self::init();
        $stmt = self::$conn->prepare("DELETE FROM comments WHERE comment_id = ?");
        return $stmt->execute([$comment_id]);
    }
}
