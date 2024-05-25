<?php

namespace App\Controllers;

class HomeController
{
    public function showHome()
    {
        if (!isset($_SESSION['email']) && !$_SESSION['logged_in']) {
            header('Location:' . ROOT .'/login');
        }
        require_once __DIR__ . '/../views/Home/index.html';
        
    }

    public function search()
    {
        // TODO: search by user name
    }

    
}
