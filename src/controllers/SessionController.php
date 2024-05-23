<?php

namespace App\Controllers;

use App\Services\UserService;
use App\Utils\HttpHelper;
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
        HttpHelper::requirePostMethod();

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
                    $_SESSION['id'] = $auth['id'];

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
