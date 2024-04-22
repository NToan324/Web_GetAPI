<?php

class LoginController
{
    public function showLogin()
    {
        // TODO: render login page
    }

    public function login($email, $password)
    {
        header('Content-type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $res = array(
                'success' => false,
                'message' => 'POST method is required for login. You\'re not using POST method'
            );
            die(json_encode($res));
        }

        try {
            if (isset($_POST['email']) && isset($_POST['password'])) {
                require_once __DIR__ . '/../models/User.php';
                require_once './config/db.conn.php';

                $name = $_POST['name'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $avatar = $_POST['avatar']; // TODO: add default value 
                $birthday = $_POST['birthday'];
                // echo json_encode([$email, $password]);

                $user = new User($conn);
                $auth = $user->authenticate($email, $password);

                if ($auth) {
                    $res = array(
                        'success' => true,
                        'message' => 'Login successfully',
                        'data' => $auth
                    );

                    echo json_encode($res);
                    return;
                }
            } else {
                throw new Exception('Email and password are required.');
            }
        } catch (Exception $e) {
            $res = array(
                'success' => false,
                'message' => $e->getMessage()
            );
            echo json_encode($res);
        }
    }
}
