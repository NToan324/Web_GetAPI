<?php
// src/Utils/HttpHelper.php

namespace App\Utils;

class HttpHelper
{
    public static function requirePostMethod()
    {
        self::requireMethod('POST');
    }

    public static function requireDeleteMethod()
    {
        self::requireMethod('DELETE');
    }

    public static function requirePutMethod()
    {
        self::requireMethod('PUT');
    }

    public static function requirePatchMethod()
    {
        self::requireMethod('PATCH');
    }

    private static function requireMethod($method)
    {
        header('Content-type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== $method) {
            $res = array(
                'success' => false,
                'message' => "$method method is required. You're not using $method method"
            );
            echo json_encode($res);
            exit(); // Make sure to stop further execution
        }
    }
}
