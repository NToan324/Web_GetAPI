<?php

class Comment
{
    private $conn;

    public function __construct()
    {
        require_once __DIR__ . '/../config/db.conn.php';
        $this->conn = $conn;
    }
    
    public function create($post_id, $user_id, $comment)
    {
        $stmt = $this->conn->prepare("INSERT INTO comments (post_id, user_id, comment) VALUES (?, ?, ?)");
        return $stmt->execute([$post_id, $user_id, $comment]);
    }

    public function delete($comment_id)
    {
        $stmt = $this->conn->prepare("DELETE FROM comments WHERE comment_id = ?");
        return $stmt->execute([$comment_id]);
    }
}
