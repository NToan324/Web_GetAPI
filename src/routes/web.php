<?php

use App\Controllers\HomeController;
use App\Controllers\SessionController;
use App\Controllers\PostController;
use App\Controllers\AccountController;
use App\Controllers\PasswordController;
use App\Controllers\SettingController;
use App\Controllers\SearchController;
use App\Utils\HttpHelper;

$request = $_SERVER['REQUEST_URI'];
$split_request = explode("?", $request);
$request_parts = explode('/', $split_request[0]);

$homeController = new HomeController();
$sessionController = new SessionController();
$postController = new PostController();
$accountController = new AccountController();
$passwordController = new PasswordController();
$settingController = new SettingController();
$searchController = new SearchController();


switch ($request_parts[2]) {
    case "": {
            if (!isset($_SESSION['id'])) {
                $sessionController->showLogin();
            }
            $homeController->showHome();
            break;
        }

    case 'check-health': {
            $res = array(
                'success' => true,
                'message' => 'Health is good'
            );

            header('Content-Type: application/json');
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

    case 'forgot-password': {
            if (HttpHelper::isPostRequest()) {
                $passwordController->forgot();
                break;
            } else {
                $passwordController->forgetView();
                break;
            }
        }

    case 'verify-token': {
            if (HttpHelper::isPostRequest()) {
                $passwordController->verifyToken();
                break;
            } else {
                $passwordController->confirmTokenView();
                break;
            }
        }
    case 'reset-password': {
            if (HttpHelper::isPostRequest()) {
                $passwordController->update();
                break;
            } else {
                $passwordController->resetView();
                break;
            }
        }

    case 'setting': {
            $settingController->settingView();
            break;
        }

    case 'getUser': {
            $settingController->getUserInfo();
            break;
        }

    case 'update-profile': {
            $settingController->updateProfile();
            break;
        }

    case 'change-password': {
            $settingController->changePassword();
            break;
        }

    case 'post':
        $isUpdate = isset($request_parts[3]) && $request_parts[3] === 'update';
        if (HttpHelper::isPostRequest() && $isUpdate) {
            $postController->update();
            break;
        } elseif (HttpHelper::isDeleteRequest()) {
            $postController->delete();
            break;
        } elseif (HttpHelper::isPostRequest()) {
            $postController->create();
            break;
        } else {
            $postController->createView();
            break;
        }

    case 'like': {
            if (HttpHelper::isPostRequest()) {
                $postController->like();
                break;
            } elseif (HttpHelper::isDeleteRequest()) {
                $postController->unlike();
                break;
            }
        }

    case 'comment': {
        if (HttpHelper::isPostRequest()) {
            $postController->comment();
            break;
        } elseif (HttpHelper::isDeleteRequest()) {
            $postController->deleteComment();
            break;
        }
    }

    case 'comments': {
        $postController->getAllComments();
        break;
    }

    case 'profile': {
            if (HttpHelper::isDeleteRequest()) {
                $accountController->delete();
                break;
            } else {
                $accountController->profileView();
                break;
            }
        }

    case 'load-profile': {
            $accountController->profile();
            break;
        }

    case 'search': {
            $searchController->searchUser();
            break;
        }

    case 'edit-post': {
            $postController->update();
            break;
        }


    default: {
            header('Content-type: application/json');
            echo json_encode([
                'success' => true,
                'code' => 404,
                'message' => 'Page not found'
            ]);
        }
}
