<?php

namespace App\Models;

use PDO;
use Exception;
use App\Models\User;

class Post
{
    private static $conn;

    private static function init()
    {
        if (self::$conn === null) {
            require __DIR__ . '/../config/db.conn.php';
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

    public static function getAllPostOfUser($userId)
    {
        self::init();
        $stmt = self::$conn->prepare("
            SELECT posts.*, users.name AS user_name, users.avatar AS avatar, TIMEDIFF(NOW(), posts.created_at) AS time_elapsed
            FROM posts
            JOIN users ON posts.user_id = users.id
            WHERE user_id = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function findById($post_id)
    {
        self::init();
        $stmt = self::$conn->prepare("SELECT * FROM posts WHERE id = ?");
        $stmt->execute([$post_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($user_id, $content, $image = null)
    {
        self::init();
        $stmt = self::$conn->prepare("INSERT INTO posts (user_id, content, image) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $content, $image]);
        $id = self::$conn->lastInsertId();
        return self::findById($id);
    }

    public static function delete($post_id)
    {
        self::init();
        $stmt = self::$conn->prepare("DELETE FROM posts WHERE id = ?");
        return $stmt->execute([$post_id]);
    }

    public static function like($postId, $userId)
    {
        try {
            self::init();

            $query = "INSERT INTO likes (post_id, user_id) VALUES (?, ?)";
            $stmt = self::$conn->prepare($query);
            $success = $stmt->execute([$postId, $userId]);

            if (!$success) {
                throw new Exception("Failed to like post");
            }

            // Increase post's total_likes
            $stmt = self::$conn->prepare("UPDATE posts SET total_likes = total_likes + 1 WHERE id = ?");
            $stmt->execute([$postId]);

            return true;
        } catch (Exception $e) {
            throw new Exception("Error while liking post: " . $e->getMessage());
        }
    }

    public static function unlike($postId, $userId)
    {
        try {
            self::init();

            $query = "DELETE FROM likes WHERE post_id = ? AND user_id = ?";
            $stmt = self::$conn->prepare($query);
            $success = $stmt->execute([$postId, $userId]);

            if (!$success) {
                throw new Exception("Failed to unlike post");
            }

            $stmt = self::$conn->prepare("UPDATE posts SET total_likes = total_likes - 1 WHERE id = ?");
            $stmt->execute([$postId]);

            return true;
        } catch (Exception $e) {
            throw new Exception("Error while unliking post: " . $e->getMessage());
        }
    }

    public static function isPostLiked($postId, $userId)
    {
        try {
            self::init();

            // Query the database to check if the user has already liked the post
            $stmt = self::$conn->prepare("SELECT COUNT(*) FROM likes WHERE post_id = ? AND user_id = ?");
            $stmt->execute([$postId, $userId]);
            $result = $stmt->fetchColumn();

            return $result > 0; // If there are rows returned, it means the user has already liked the post
        } catch (Exception $e) {
            throw new Exception("Error checking if post is liked: " . $e->getMessage());
        }
    }

    public static function updatePostContent($postId, $content)
    {
        self::init();
        $stmt = self::$conn->prepare("UPDATE posts SET content = ? WHERE id = ?");
        $stmt->execute([$content, $postId]);
        return self::findById($postId);
    }

    public static function getAllCommentsByPostId($postId)
    {
        self::init();
        $stmt = self::$conn->prepare("
            SELECT c.*, u.name, u.id FROM comments c
            INNER JOIN users u 
            ON c.user_id = u.id
            WHERE post_id = ?
        ");
        $stmt->execute([$postId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function comment($postId, $userId, $content)
    {
        try {
            self::init();

            $stmt = self::$conn->prepare("INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)");
            $success = $stmt->execute([$postId, $userId, $content]);

            return $success;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function deleteComment($commentId)
    {
        try {
            self::init();

            $stmt = self::$conn->prepare("DELETE FROM comments WHERE id = ?");
            $success = $stmt->execute([$commentId]);

            return $success;
        } catch (Exception $e) {
            throw $e;
        }
    }
}

// die(var_dump(Post::deleteComment(11)));
