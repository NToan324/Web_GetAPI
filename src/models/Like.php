<?php

namespace App\Models;

class Like
{
    private $conn;

    public function __construct()
    {
        require_once __DIR__ . '/../config/db.conn.php';
        $this->conn = $conn;
    }
    
    public function create($post_id, $user_id)
    {
        $stmt = $this->conn->prepare("INSERT INTO likes (post_id, user_id) VALUES (?, ?)");
        return $stmt->execute([$post_id, $user_id]);
    }

    public function delete($like_id)
    {
        $stmt = $this->conn->prepare("DELETE FROM likes WHERE like_id = ?");
        return $stmt->execute([$like_id]);
    }
}
