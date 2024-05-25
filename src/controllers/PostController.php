<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Services\PostService;
use App\Utils\HttpHelper;
use Exception;

class PostController
{
    public function showAll()
    {
        header('Content-type: application/json');

        try {
            $posts = Post::all();

            $user = User::getById($_SESSION['id']);

            if ($posts) {
                echo json_encode(array(
                    'success' => true,
                    'message' => 'Load all post successfully',
                    'data' => [
                        'posts' => $posts,
                        'user' => $user
                    ]
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

    public function createView()
    {
        require_once '/Web_RestAPI/src/views/Post/index.html';
    }

    public function create()
    {
        HttpHelper::requirePostMethod();

        try {
            $userId = $_SESSION['id']; 
            $content = $_POST['content'];
            $image = isset($_FILES['image']) ? $_FILES['image'] : null;


            $result = PostService::create($userId, $content, $image);

            echo json_encode(array(
                'success' => true,
                'message' => 'Post created successfully',
                'data' => $result
            ));
        } catch (Exception $e) {
            echo json_encode(array(
                'success' => false,
                'message' => $e->getMessage()
            ));
        }
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
