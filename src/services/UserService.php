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
        if (empty($email)) {
            throw new InvalidArgumentException("Username cannot be empty");
        }

        $user = User::findByEmail($email);

        if (!$user) {
            throw new Exception("User not found");
        }

        // if (!($password === $user["password"])) {
        if (!password_verify($password, $user["password"])) {
            throw new Exception("Incorrect password");
        }

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

    public static function updateProfile($userId, $name, $birthday, $bio)
    {

        try {
            User::updateProfile($userId, $name, $birthday, $bio);
        } catch (Exception $e) {
            throw new Exception('Failed to update profile: ' . $e->getMessage());
        }
    }

    public static function searchUsersByName($name)
    {
        try {
            $users = User::searchByName($name);

            if (!$users) {
                throw new Exception('No users found');
            }

            return $users;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function deleteUser($userId)
    {
        try {
            $user = User::getById($userId);
            if (!$user) {
                throw new Exception('User not found');
            }

            $deleted = User::delete($userId);

            return $deleted;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
