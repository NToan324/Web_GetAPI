<?php

class HomeController {
    public function showHome() {

        if (!isset($_SESSION['email']) && !$_SESSION['logged_in']) {
            
        }
        require_once __DIR__ . '/../views/Home/index.html';
        header('Location: /');
    }

}