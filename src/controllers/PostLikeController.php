<?php

namespace App\Controllers;

use App\Models\PostLike;
use App\Utils\HttpHelper;
use Exception;

class PostLikeController
{
    public function like()
    {
        HttpHelper::requirePostMethod();

        $userId = $_SESSION['id'];
        $postId = $_POST['post_id'] ?? '';

        
        try {
            PostLike::likePost($postId, $userId);
            echo json_encode(['success' => true, 'message' => 'Post liked successfully']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function unlike($postId, $userId)
    {
        HttpHelper::requirePostMethod();

        try {
            PostLike::unlikePost($postId, $userId);
            echo json_encode(['success' => true, 'message' => 'Post unliked successfully']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
