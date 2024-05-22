<?php
require_once SERVER_PATH . '/controllers/Post.controller.php';



$request = $_SERVER['REQUEST_URI'];
$split_request = explode("?", $request);
$request_parts = explode('/', $split_request[0]);

$postController = new PostController();


switch ($request_parts[2]) {
    case 'loadAllPost': {
            $postController->loadAllPost();
            break;
        }
}
