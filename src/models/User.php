<?php

namespace App\Models;

use PDO;
use Exception;
use PDOException;

class User
{
    private static $conn;

    private static function init()
    {
        if (self::$conn === null) {
            require __DIR__ . '/../config/db.conn.php';
            self::$conn = $conn;
        }
    }

    // Get user by ID
    public static function getById($id)
    {
        self::init();
        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = self::$conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get user by email
    public static function findByEmail($email)
    {
        self::init();
        try {
            $query = "SELECT * FROM users WHERE email = ?";
            $stmt = self::$conn->prepare($query);
            $stmt->execute([$email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die(json_encode(array(
                'success' => false,
                'message' => $e->getMessage()
            )));
        }
    }

    // Insert new user
    public static function create($name, $email, $password)
    {
        self::init();
        try {
            // Check if the user already exists
            if (self::isUserExist($email)) {
                throw new Exception('Email already taken. Please try again with another email');
            }

            $query = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
            $stmt = self::$conn->prepare($query);
            $success = $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);

            if (!$success) {
                throw new Exception("Failed to create user");
            }

            return array($name, $email, $password);
        } catch (PDOException $e) {
            throw $e;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function isUserExist($email)
    {
        self::init();
        $query = "SELECT COUNT(*) FROM users WHERE email = ?";
        $stmt = self::$conn->prepare($query);
        $stmt->execute([$email]);
        $count = $stmt->fetchColumn();

        return $count > 0;
    }

    public static function updatePassword($userId, $newPassword)
    {
        self::init();
        try {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $query = "UPDATE users SET password = ? WHERE id = ?";
            $stmt = self::$conn->prepare($query);

            $success = $stmt->execute([$hashedPassword, $userId]);

            if (!$success) {
                throw new Exception("Failed to update password");
            }

            return true;
        } catch (PDOException $e) {
            throw $e;
        } catch (Exception $e) {
            throw $e;
        }
    }


    // Delete user by ID
    public static function delete($id)
    {
        self::init();
        $query = "DELETE FROM users WHERE id = ?";
        $stmt = self::$conn->prepare($query);
        return $stmt->execute([$id]);
    }

    public static function updateProfile($userId, $name, $birthday, $bio)
    {
        self::init();

        try {
            $query = "UPDATE users SET name = ?, birthday = ?, bio = ? WHERE id = ?";
            $stmt = self::$conn->prepare($query);
            $stmt->execute([$name, $birthday, $bio, $userId]);
            return true; // Success
        } catch (Exception $e) {
            throw new Exception("Failed to update profile: " . $e->getMessage());
        }
    }
}
