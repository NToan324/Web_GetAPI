<?php
require_once __DIR__ . '/../models/Post.php';

class PostController
{
    public function loadAllPost()
    {
        header('Content-type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $res = array(
                'success' => false,
                'message' => 'POST method is required for login. You\'re not using POST method'
            );
            echo (json_encode($res));
        }

        try {
            require_once './src/config/db.conn.php';

            $post = new Post($conn);

            $posts = $post->findAll();

            if ($posts) {
                $res = array(
                    'success' => true,
                    'message' => 'Load all post successfully',
                    'data' => $posts
                );

                echo (json_encode($res));
            } else {
                $res = array(
                    'success' => false,
                    'message' => 'No post found'
                );
            }
        } catch (Exception $e) {
            $res = array(
                'success' => false,
                'message' => $e->getMessage()
            );

            echo (json_encode($res));
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
