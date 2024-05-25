<?php

namespace App\Services;

use App\Models\Post;
use Exception;

class PostService
{
    public static function create($userId, $content, $image = null)
    {
        try {
            $imagePath = null;
            if ($image && $image['error'] === UPLOAD_ERR_OK) {
                $imagePath = $userId . '-' . uniqid() . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);
                $targetDir = __DIR__ . '/../../storage/posts/' . $imagePath;
                move_uploaded_file($image['tmp_name'], $targetDir);
            }

            // Create the post
            $post = Post::create($userId, $content, $imagePath);

            if ($post) {
                return $post;
            } else {
                throw new Exception('Failed to create post');
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
}
