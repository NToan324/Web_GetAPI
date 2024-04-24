<?php

class HomeController
{
    public function showHome()
    {

        if (!isset($_SESSION['email']) && !$_SESSION['logged_in']) {
            header('Location: /login');
        }
        require_once __DIR__ . '/../views/Home/index.html';
        header('Location: /');
    }

    public function search($name)
    {
        // TODO: search by user name
    }

    public function logout()
    {
        session_start();
        $_SESSION = array();
        session_destroy();

        if (isset($_COOKIE['email'])) {
            unset($_COOKIE['email']);
            setcookie('email', '', time() - 3600, '/');
        }

        $res = array(
            'success' => true,
            'message' => 'Logout successfully'
        );

        header('Content-Type: application/json');
        die(json_encode($res));
    }
}
