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
            // Like the post
            $success = PostService::likePost($postId, $userId);

            if ($success) {
                echo json_encode(array(
                    'success' => true,
                    'message' => 'Post liked successfully'
                ));
            } else {
                throw new Exception('Failed to like post');
            }
        } catch (Exception $e) {
            echo json_encode(array(
                'success' => false,
                'message' => $e->getMessage()
            ));
        }
    }

    public function unlike()
    {
        HttpHelper::requirePostMethod();

        $userId = $_SESSION['id'] ?? '';
        $postId = $_POST['post_id'];

        try {
            // Unlike the post
            $success = PostService::unlikePost($postId, $userId);

            if ($success) {
                echo json_encode(array(
                    'success' => true,
                    'message' => 'Post unliked successfully'
                ));
            } else {
                throw new Exception('Failed to unlike post');
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

    public function update()
    {
        HttpHelper::requirePostMethod();

        try {

            $postId = $_POST['id'];
            $userId = $_SESSION['id'];
            $content = $_POST['content'];


            if (!$postId) {
                throw new Exception('Post ID is required');
            }

            $result = PostService::updatePostContent($postId, $content);

            echo json_encode(array(
                'success' => true,
                'message' => 'Post updated successfully',
                'data' => $result
            ));
        } catch (Exception $e) {
            echo json_encode(array(
                'success' => false,
                'message' => $e->getMessage()
            ));
        }
    }

    public function checkLikeStatus()
    {
        header('Content-type: application/json');

        try {
            $postId = $_GET['id'] ?? null;
            $userId = $_SESSION['id'] ?? null;

            if (!$postId || !$userId) {
                throw new Exception("Post ID and user ID are required");
            }

            $liked = PostService::isPostLikedByUser($postId, $userId);

            echo json_encode(array(
                'success' => true,
                'liked' => $liked,
            ));
        } catch (Exception $e) {
            echo json_encode(array(
                'error' => $e->getMessage()
            ));
        }
    }


    public function getAllComments()
    {

        header('Content-type: application/json');
        try {
            $postId = $_GET['id'];

            $comments = PostService::getAllCommentsByPostId($postId);

            echo json_encode(array(
                'success' => true,
                'message' => 'Comments retrieved successfully',
                'data' => $comments
            ));
        } catch (Exception $e) {
            echo json_encode(array(
                'success' => false,
                'message' => $e->getMessage()
            ));
        }
    }

    public function comment()
    {
        HttpHelper::requirePostMethod();

        try {
            $postId = $_POST['post_id'] ?? '';
            $userId = $_SESSION['id'] ?? '';
            $content = $_POST['content'] ?? '';



            $success = PostService::comment($postId, $userId, $content);

            if ($success) {
                echo json_encode(array(
                    'success' => true,
                    'message' => 'Comment added successfully',
                    'data' => $success
                ));
            } else {
                throw new Exception('Failed to add comment');
            }
        } catch (Exception $e) {
            echo json_encode(array(
                'success' => false,
                'message' => $e->getMessage()
            ));
        }
    }

    public function deleteComment()
    {
        HttpHelper::requireDeleteMethod();

        try {
            $commentId = $_GET['id'];

            $success = PostService::deleteComment($commentId);

            if ($success) {
                echo json_encode(array(
                    'success' => true,
                    'message' => 'Comment deleted successfully'
                ));
            } else {
                throw new Exception('Failed to delete comment');
            }
        } catch (Exception $e) {
            echo json_encode(array(
                'success' => false,
                'message' => $e->getMessage()
            ));
        }
    }
}
