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

    public static function likePost($postId, $userId)
    {
        try {
            $isLiked = Post::isPostLiked($postId, $userId);
            if ($isLiked) {
                return false;
            }

            // Like the post
            $success = Post::like($postId, $userId);
            return $success;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function deletePost($postId)
    {
        try {
            $post = Post::findById($postId);

            if (!$post) {
                throw new Exception('Post not found');
            }

            $deleted = Post::delete($post['id']);

            if ($deleted) {
                return $deleted;
            } else {
                throw new Exception('Failed to delete post');
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function updatePostContent($postId, $content)
    {
        try {
            $post = Post::findById($postId);

            if (!$post) {
                throw new Exception('Post not found');
            }

            $updated = Post::updatePostContent($postId, $content);

            if ($updated) {
                return $post;
            } else {
                throw new Exception('Failed to update post');
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
}
