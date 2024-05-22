<?php

use App\Controllers\HomeController;
use App\Controllers\SessionController;
use App\Controllers\PostController;
use App\Controllers\AccountController;


$request = $_SERVER['REQUEST_URI'];
$split_request = explode("?", $request);
$request_parts = explode('/', $split_request[0]);

$homeController = new HomeController();
$sessionController = new SessionController();
$postController = new PostController();
$accountController = new AccountController();

switch ($request_parts[2]) {
    case "": {
            $homeController->showHome();
            break;
        }

    case 'check-health': {
            $res = array(
                'success' => true,
                'message' => 'Health is good'
            );

            header('Content-Type: applicatin/json');
            echo (json_encode($res));
            break;
        }

    case 'loadAllPost': {
            $postController->showAll();
            break;
        }

    case "login": {
            if (isset($_POST['submit'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];
                $sessionController->login($email, $password);
            } else {
                $sessionController->showLogin();
            }
            break;
        }

    case 'logout': {
            if (isset($_POST['logoutBtn'])) {
                $sessionController->logout();
            }
            break;
        }

    case "signUp": {
            if (isset($_POST['submit'])) {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $accountController->signUp($name, $email, $password);
            } else {
                // $sessionController->showSignUpPage();
            }
            break;
        }
}
