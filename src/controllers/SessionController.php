<?php

namespace App\Controllers;

// require_once __DIR__ .'/../services/UserService.php';

// $userService = new UserService();
use App\Models\User;
use App\Services\UserService;
use Exception;


class SessionController
{
    public $userService;
    
    public function __construct()
    {
        $this->userService = new UserService();
    }
    
    public function showLogin()
    {
        require_once __DIR__ . '/../views/Login/index.html';
    }

    public function login($email, $password)
    {
        header('Content-type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $res = array(
                'success' => false,
                'message' => 'POST method is required for login. You\'re not using POST method'
            );
            echo (json_encode($res));
        }

        try {
            if (isset($_POST['email']) && isset($_POST['password'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];
                // echo json_encode([$email, $password, $_POST['rememberMe']]);

                $auth = $this->userService->authenticate($email, $password);

                if ($auth) {
                    // Create new session
                    session_regenerate_id();
                    $_SESSION['logged_in'] = TRUE;
                    $_SESSION['email'] = $auth['email'];
                    $_SESSION['id'] = $auth['user_id'];

                    if (isset($_POST['rememberMe'])) {
                        setcookie('email', $email, time() + SESSION_EXPIRED_DAY, '/');
                    }

                    echo (json_encode(array(
                        'success' => true,
                        'message' => 'Login successfully',
                        'data' => $auth
                    )));
                }
            } else {
                throw new Exception('Email and password are required.');
            }
        } catch (Exception $e) {
            $res = array(
                'success' => false,
                'message' => $e->getMessage()
            );
            echo (json_encode($res));
        }
    }

    public function signUp($name, $email, $password)
    {
        header('Content-type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $res = array(
                'success' => false,
                'message' => 'POST method is required for sign up. You\'re not using POST method'
            );
            echo (json_encode($res));
        }

        try {
            if (isset($_POST['email']) && isset($_POST['password'])) {
                require_once './src/models/User.php';
                require_once './src/config/db.conn.php';

                $name = $_POST['name'];
                $email = $_POST['email'];
                $password = $_POST['password'];

                $user = new User();
                $success = $user->create($name, $email, $password);

                if ($success) {
                    $res = array(
                        'success' => true,
                        'message' => 'Create new user successfully',
                        'data' => $success
                    );

                    echo json_encode($res);
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

    public function logout()
    {
        $_SESSION = array();
        session_destroy();

        if (isset($_COOKIE['email'])) {
            unset($_COOKIE['email']);
            setcookie('email', '', time() - 3600, '/');
        }

        header('Content-Type: application/json');
        echo json_encode(array(
            'success' => true,
            'message' => 'Logout successfully'
        ));
    }
}
