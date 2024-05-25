<?php

namespace App\Controllers;

use Exception;
use App\Services\UserService;

class SearchController
{
    public function searchUser()
    {
        header('Content-type: application/json');

        try {
            $name = $_GET['name'] ?? '';

            if (empty($name)) {
                throw new Exception('Name is required');
            }

            $users = UserService::searchUsersByName($name);

            echo json_encode(array(
                'success' => true,
                'message' => 'Users retrieved successfully',
                'data' => $users
            ));
        } catch (Exception $e) {
            echo json_encode(array(
                'success' => false,
                'message' => $e->getMessage()
            ));
        }
    }
}
