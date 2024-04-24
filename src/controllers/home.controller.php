<?php

class HomeController
{
    public function showHome()
    {

        if (!isset($_SESSION['email']) && !$_SESSION['logged_in']) {
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

        // Clear all session variables
        $_SESSION = array();

        // Destroy the session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Destroy the session
        session_destroy();

        // Unset any relevant cookies
        if (isset($_COOKIE['user_id'])) {
            unset($_COOKIE['user_id']);
            setcookie('user_id', '', time() - 3600, '/');
        }

        // Redirect to the login page or any other appropriate page
        header("Location: login.php");
    }
}
