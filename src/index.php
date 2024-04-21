<?php
session_start();
require_once './controllers/login.controller.php';
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\LoginController;

$request = $_SERVER['REQUEST_URI'];
$split_request = explode("?", $request);
$request_parts = explode('/', $split_request[0]);



switch ($request_parts[1]) {
    case "login": {
            $loginController = new LoginController();
            if (isset($_POST['submit'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];
                $loginController->login($email, $password);
            } else {
                $signInController->showSignInPage();
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



