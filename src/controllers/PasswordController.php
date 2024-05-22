<?php

namespace App\Controllers;

use App\Services\MailService;
use App\Utils\HttpHelper;
use App\Models\User;


class PasswordController
{
    public function forgetView()
    {
        require_once __DIR__ . '/../views/ForgotPassword/index.html';
    }

    public function resetView()
    {
        //
        require_once __DIR__ . '/../views/ForgotPassword/resetPassword.html';
    }

    public function forgot()
    {
        HttpHelper::requirePostMethod();

        $email = $_POST['email'] ?? '';

        if (!$email) {
            echo json_encode([
                'success' => false,
                'message' => 'User not found'
            ]);
        }

        $user = User::findByEmail($email);

        MailService::sendResetPasswordEmail($email, $user['id']);

        die(json_encode([
            'success' => true,
            'code' => 200,
            'message' => 'Reset password request has fulfilled',
        ]));
    }

    public function reset()
    {
        //
    }
}
