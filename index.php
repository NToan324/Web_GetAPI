<?php
define('SESSION_EXPIRED_DAY', 60 * 60 * 24);
define('SERVER_PATH', __DIR__ . '/src');
session_set_cookie_params(SESSION_EXPIRED_DAY);
session_start();

require_once SERVER_PATH . '/controllers/home.controller.php';
require_once SERVER_PATH . '/controllers/User.controller.php';



$request = $_SERVER['REQUEST_URI'];
$split_request = explode("?", $request);
$request_parts = explode('/', $split_request[0]);

$homeController = new HomeController();
$userController = new UserController();

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

    case 'checkhealth': {
            $res = array(
                'success' => true,
                'message' => 'Health is good'
            );

            header('Content-Type: applicatin/json');
            die(json_encode($res));
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



