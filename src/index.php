<?php
define('SESSION_EXPIRED_DAY', 60 * 60 * 24);

session_set_cookie_params(SESSION_EXPIRED_DAY);
session_start();

require_once __DIR__ . '/controllers/home.controller.php';
require_once __DIR__ . '/controllers/login.controller.php';
require_once __DIR__ . '/controllers/signup.controller.php';


$request = $_SERVER['REQUEST_URI'];
$split_request = explode("?", $request);
$request_parts = explode('/', $split_request[0]);

$homeController = new HomeController();
$loginController = new LoginController();

// routing
switch ($request_parts[1]) {
    case "": {
        $homeController->showHome();
        break;
    }

    case "login": {
            if (isset($_POST['submit'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];
                $loginController->login($email, $password);
            } else {
                $loginController->showLogin();
            }
            break;
        }

    case 'logout': {
        // if (isset($_POST['logout_btn'])) {
            $homeController->logout();
        // }
        break;
    }

    case "signUp": {
            $signUpController = new SignUpController();
            if (isset($_POST['submit'])) {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $signUpController->signUp($name, $email, $password);
            } else {
                // $signUpController->showSignUpPage();
            }
            break;
        }

    case 'test-db': {
            require_once './config/db.conn.php';
            break;
        }
        // default: require __DIR__ . '/views/404.php';
        
    default:
        header('Content-Type: application/json');
        $res = array(
            "success" => true,
            "data" => "hello world"
        );
        echo json_encode($res);
        break;
}



