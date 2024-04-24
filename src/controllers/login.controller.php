<?php

class LoginController
{
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
            die(json_encode($res));
        }

        try {
            if (isset($_POST['email']) && isset($_POST['password'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];
                // echo json_encode([$email, $password]);

                $auth = $this->authenticate($email, $password);

                if ($auth) {
                    session_start();
                    // Create new session
                    session_regenerate_id();
                    $_SESSION['logged_in'] = TRUE;
                    $_SESSION['email'] = $auth->email;
                    $_SESSION['id'] = $auth->id;

                    $res = array(
                        'success' => true,
                        'message' => 'Login successfully',
                        'data' => $auth
                    );

                    die(json_encode($res));
                }
            } else {
                throw new Exception('Email and password are required.');
            }
        } catch (Exception $e) {
            $res = array(
                'success' => false,
                'message' => $e->getMessage()
            );
            die(json_encode($res));

        }
    }

    public function authenticate($email, $password)
    {
        require_once __DIR__ . '/../models/User.php';
        require_once './config/db.conn.php';

        // Check if email is empty
        if (empty($email)) {
            throw new InvalidArgumentException("Username cannot be empty");
        }

        // Get user by email
        $user = (new User($conn))->findByEmail($email);

        // Check if user exists
        if (!$user) {
            throw new Exception("User not found");
        }

        // Verify password
        // if (!password_verify($password, $user["password"])) {
        if (!($password === $user["password"])) {
            throw new Exception("Incorrect password");
        }

        // Authentication successful, return user details
        return $user;
    }
}
