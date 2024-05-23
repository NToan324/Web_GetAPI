<?php

namespace App\Services;

require_once __DIR__ . '/../models/User.php';

use App\Models\User;
use Exception;
use InvalidArgumentException;

class UserService
{
    public static function authenticate($email, $password)
    {
        // Check if email is empty
        if (empty($email)) {
            throw new InvalidArgumentException("Username cannot be empty");
        }

        // Get user by email
        $user = User::findByEmail($email);

        // Check if user exists
        if (!$user) {
            throw new Exception("User not found");
        }

        // Verify password
        if (!($password === $user["password"])) {
            // if (!password_verify($password, $user["password"])) {
            throw new Exception("Incorrect password");
        }

        // Authentication successful, return user details
        return $user;
    }

    public static function signup($name, $email, $password)
    {
        if (empty($name) || empty($email) || empty($password)) {
            throw new Exception('All fields are required.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email format.');
        }

        if (User::findByEmail($email)) {
            throw new Exception('Email already exists.');
        }

        return User::create($name, $email, $password);
    }

    public static function updatePassword($userId, $newPassword)
    {
        if (strlen($newPassword) < 8) {
            throw new InvalidArgumentException("Password must be at least 8 characters long.");
        }

        $user = User::getById($userId);
        if (!$user) {
            throw new Exception("User not found.");
        }

        try {
            return User::updatePassword($userId, $newPassword);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
