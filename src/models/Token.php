<?php

namespace App\Models;

use App\Utils\StringHelper;
use Exception;
use PDO;

class Token
{
    private static $conn;

    private static function init()
    {
        if (self::$conn === null) {
            require __DIR__ . '/../config/db.conn.php';
            self::$conn = $conn;
        }
    }
    public static function find($token)
    {
        self::init();

        $stmt = self::$conn->prepare("SELECT * FROM tokens WHERE token = ?");
        $stmt->execute([$token]);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);

        return $record;
    }


    public static function create($userId, $expiry = TOKEN_EXPIRED_TIME)
    {
        self::init();
        $token = StringHelper::randCode();
        $expiresAt = date('Y-m-d H:i:s', time() + $expiry);

        $stmt = self::$conn->prepare("
            INSERT INTO tokens (user_id, token, expires_at)
            VALUES (?, ?, ?)
        ");

        if (!$stmt->execute([$userId, $token, $expiresAt])) {
            throw new Exception("Failed to create token");
        }

        return $token;
    }

    public static function destroy($token)
    {
        self::init();
        $stmt = self::$conn->prepare("DELETE FROM tokens WHERE token = ?");
        return $stmt->execute([$token]);
    }

    public static function isExpired($token)
    {
        self::init();

        $stmt = self::$conn->prepare("SELECT expires_at FROM tokens WHERE token = ?");
        $stmt->execute([$token]);
        $expiresAt = $stmt->fetchColumn();

        if (!$expiresAt) {
            throw new Exception("Token not found");
        }

        return strtotime($expiresAt) < time();
    }

    public static function findUserByToken($token)
    {
        self::init();

        $stmt = self::$conn->prepare("
            SELECT u.*
            FROM users u
            JOIN tokens t ON u.id = t.user_id
            WHERE t.token = ?
        ");
        $stmt->execute([$token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            throw new Exception("User not found for the provided token");
        }

        return $user;
    }
}
