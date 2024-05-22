<?php

namespace App\Models;

require_once __DIR__ . '/../models/Like.php';

use PDO;
use PDOException;
use App\Models\Like;

class Post
{
    private $conn;

    public function __construct()
    {
        require_once __DIR__ . '/../config/db.conn.php';
        $this->conn = $conn;
    }

    public function findAll()
    {
        $stmt = $this->conn->query("
            SELECT posts.*, users.name AS user_name, users.avatar AS avatar
            FROM posts
            JOIN users ON posts.user_id = users.user_id
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function findById($post_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM posts WHERE post_id = ?");
        $stmt->execute([$post_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($user_id, $content, $image = null)
    {
        $stmt = $this->conn->prepare("INSERT INTO posts (user_id, content, image) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $content, $image]);
        return $this->conn->lastInsertId();
    }

    public function delete($post_id)
    {
        $stmt = $this->conn->prepare("DELETE FROM posts WHERE post_id = ?");
        return $stmt->execute([$post_id]);
    }

    public function like($post_id, $user_id)
    {
        // Increase total_likes column in the posts table
        $stmt = $this->conn->prepare("UPDATE posts SET total_likes = total_likes + 1 WHERE post_id = ?");
        $stmt->execute([$post_id]);

        // Add a like to the likes table
        $like = new Like();
        $like->create($post_id, $user_id);
    }

    public function unlike($post_id, $user_id)
    {
        $stmt = $this->conn->prepare("UPDATE posts SET total_likes = total_likes - 1 WHERE post_id = ?");
        return $stmt->execute([$post_id]);

        $like = new Like();
        $like->delete($post_id, $user_id);
    }

    public function comment($post_id, $user_id, $content)
    {
        $stmt = $this->conn->prepare("INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)");
        return $stmt->execute([$post_id, $user_id, $content]);
    }

    public function deleteComment($comment_id)
    {
        $stmt = $this->conn->prepare("DELETE FROM comments WHERE comment_id = ?");
        return $stmt->execute([$comment_id]);
    }
}
