<?php
require_once SERVER_PATH . '/controllers/home.controller.php';

$request = $_SERVER['REQUEST_URI'];
$split_request = explode("?", $request);
$request_parts = explode('/', $split_request[0]);

$homeController = new HomeController();
        
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
            echo(json_encode($res));
            break;
        }
}
