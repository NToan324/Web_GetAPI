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
        require_once __DIR__ . '/../views/Post/index.html';
    }

    public function create()
    {
        HttpHelper::requirePostMethod();

        try {
            $userId = $_SESSION['id'];
            $content = $_POST['content'];
            $image = isset($_FILES['image']) ? $_FILES['image'] : null;

            if (!$image) {
                throw new Exception('Please choose an image.');
            }


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

    public function like()
    {
        HttpHelper::requirePostMethod();

        $userId = $_SESSION['id'] ?? '';
        $postId = $_POST['post_id'];

        try {
            $success = PostService::likePost($postId, $userId);

            if ($success) {
                echo json_encode(array(
                    'success' => true,
                    'message' => 'Post liked successfully'
                ));
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Failed to like post'
                ));
            }
        } catch (Exception $e) {
            echo json_encode(array(
                'success' => false,
                'message' => $e->getMessage()
            ));
        }
    }

    public function delete()
    {
        HttpHelper::requireDeleteMethod();

        try {
            $postId = $_GET['id'] ?? null;

            if (!$postId) {
                throw new Exception('Post ID is required');
            }

            $deleted = PostService::deletePost($postId);

            if ($deleted) {
                echo json_encode(array(
                    'success' => true,
                    'message' => 'Post deleted successfully'
                ));
            } else {
                throw new Exception('Failed to delete post');
            }
        } catch (Exception $e) {
            echo json_encode(array(
                'success' => false,
                'message' => $e->getMessage()
            ));
        }
    }
}
