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
        $stmt = self::$conn->prepare("DELETE FROM posts WHERE post_id = ?");
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

            // Delete the like record
            $query = "DELETE FROM likes WHERE post_id = ? AND user_id = ?";
            $stmt = self::$conn->prepare($query);
            $stmt->execute([$postId, $userId]);

            // Decrease post's total_likes
            $stmt = self::$conn->prepare("UPDATE posts SET total_likes = total_likes - 1 WHERE id = ?");
            $stmt->execute([$postId]);

            return true;
        } catch (Exception $e) {
            throw new Exception("Error while unliking post: " . $e->getMessage());
        }
    }

    public static function isPostLiked($userId, $postId)
    {
        try {
            $likedPosts = User::getLikedPost($userId);
            // die(var_dump($likedPosts));

            foreach ($likedPosts as $post) {
                if ($post['id'] == $postId) {
                    return true;
                }
            }

            return false;
        } catch (Exception $e) {
            throw new Exception("Error checking if post is liked: " . $e->getMessage());
        }
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

Post::isPostLiked(14, 33);