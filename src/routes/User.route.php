<?php
require_once SERVER_PATH . '/controllers/User.controller.php';

$request = $_SERVER['REQUEST_URI'];
$split_request = explode("?", $request);
$request_parts = explode('/', $split_request[0]);

$userController = new UserController();

switch ($request_parts[2]) {
    case "login": {
            if (isset($_POST['submit'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];
                $userController->login($email, $password);
            } else {
                $userController->showLogin();
            }
            break;
        }

    case 'logout': {
            if (isset($_POST['logoutBtn'])) {
                $userController->logout();
            }
            break;
        }

    case "signUp": {
            if (isset($_POST['submit'])) {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $userController->signUp($name, $email, $password);
            } else {
                // $userController->showSignUpPage();
            }
            break;
        }
}
