<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Services\UserService;
use App\Utils\HttpHelper;
use Exception;

class AccountController
{
    public function settingView()
    {
        require_once __DIR__ . '/../views/Setting/index.html';
    }

    public function profileView()
    {
        require_once __DIR__ . '/../views/Personal/index.html';
    }

    public function signUp($name, $email, $password)
    {
        HttpHelper::requirePostMethod();

        try {
            if (isset($_POST['email']) && isset($_POST['password'])) {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $password = $_POST['password'];

                $user = new User();
                $success = $user->create($name, $email, $password);

                if ($success) {
                    echo json_encode(array(
                        'success' => true,
                        'message' => 'Create new user successfully',
                        'data' => $success
                    ));
                    return;
                }
            } else {
                throw new Exception('All field has not been filled yet');
            }
        } catch (Exception $e) {
            $res = array(
                'success' => false,
                'message' => $e->getMessage()
            );
            echo json_encode($res);
        }
    }

    public function profile()
    {
        header('Content-type: application/json');

        // $userId = $_SESSION['id'];
        $userId = "2";

        try {
            $posts = Post::getAllPostOfUser($userId);

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
}
