<?php
namespace App\Models;

use Exception;

class Token
{
    private static $conn;

    private static function init()
    {
        if (self::$conn === null) {
            require_once __DIR__ . '/../config/db.conn.php';
            self::$conn = $conn;
        }
    }

    public static function create($userId, $expiry = TOKEN_EXPIRED_TIME)
    {
        self::init();
        $token = rand(1000, 9999);
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
}
