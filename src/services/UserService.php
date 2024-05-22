<?php

namespace App\Services;

require_once __DIR__ . '/../models/User.php';

use App\Models\User;
use Exception;
use InvalidArgumentException;

class UserService
{
    public function authenticate($email, $password)
    {
        require_once __DIR__ . '/../config/db.conn.php';

        // Check if email is empty
        if (empty($email)) {
            throw new InvalidArgumentException("Username cannot be empty");
        }

        // Get user by email
        $user = (new User($conn))->findByEmail($email);

        // Check if user exists
        if (!$user) {
            throw new Exception("User not found");
        }

        // Verify password
        if (!password_verify($password, $user["password"])) {
            throw new Exception("Incorrect password");
        }

        $conn = null;
        // Authentication successful, return user details
        return $user;
    }
}
