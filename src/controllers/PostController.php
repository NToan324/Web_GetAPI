<?php

namespace App\Controllers;

use App\Models\Post;
use App\Utils\HttpHelper;
use Exception;

class PostController
{
    public function showAll()
    {
        header('Content-type: application/json');

        try {
            $posts = Post::all();

            if ($posts) {
                echo json_encode(array(
                    'success' => true,
                    'message' => 'Load all post successfully',
                    'data' => $posts
                ));
            } else {
                throw new Exception('No post found');
            }
        } catch (Exception $e) {
            echo json_encode(array(
                'success' => false,
                'message' => $e->getMessage()
            ));
        }
    }

    public function create($userId)
    {
        // Thêm bài viết cho một user cụ thể
        // TODO: createPost (lam cai nay di)
    }

    public function modify()
    {
        // TODO: cai nay sai PUT de tao nghien cuu ai
    }

    public function delete()
    {
        // TODO: cai nay sai delete
    }

    public function like($postId, $userId)
    {
    }

    public function unlike()
    {
    }

    public function comment()
    {
    }

    public function deleteComment()
    {
    }
}
