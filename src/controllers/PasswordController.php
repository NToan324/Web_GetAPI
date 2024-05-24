<?php

namespace App\Controllers;

use App\Models\Token;
use App\Services\MailService;
use App\Utils\HttpHelper;
use App\Models\User;
use App\Services\UserService;
use Exception;


class PasswordController
{
    public function forgetView()
    {
        require_once __DIR__ . '/../views/ForgotPassword/index.html';
    }

    public function resetView()
    {
        require_once __DIR__ . '/../views/ForgotPassword/resetPassword.html';
    }

    public function confirmTokenView()
    {
        require_once __DIR__ . '/../views/ForgotPassword/verification.html';
    }

    public function forgot()
    {
        HttpHelper::requirePostMethod();

        $email = $_POST['email'] ?? '';

        if (!$email) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Please enter your email'
            ]);
            return;
        }

        $user = User::findByEmail($email);

        if (!$user) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'User with the provided email does not exist'
            ]);
            return;
        }

        MailService::sendResetPasswordEmail($user);

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'code' => 200,
            'message' => 'Reset password request has been fulfilled',
        ]);
        return;
    }

    public function verifyToken()
    {
        HttpHelper::requirePostMethod();

        $tokenValue = $_POST['token'] ?? '';

        if (empty($tokenValue)) {
            // If token is empty, return an error response
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Token is missing'
            ]);
            return;
        }

        try {
            if (Token::isExpired($tokenValue)) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Token is expired'
                ]);
                return;
            }

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Token is valid'
            ]);
        } catch (Exception $e) {
            // If an exception occurs (e.g., token not found), return an error response
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update()
    {
        HttpHelper::requirePostMethod();

        $password = $_POST['password'] ?? '';
        $passwordConfirmation = $_POST['password-confirmation'] ?? '';
        $tokenValue = $_POST['token'] ?? '';

        // Validate all fields
        if (empty($password) || empty($passwordConfirmation) || empty($tokenValue)) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'All fields are required',
                'data' => [
                    'password' => $password,
                    'password-confirmation' => $passwordConfirmation,
                    'password' => $password,
                ]
            ]);
            return;
        }

        // Check password confirmation
        if ($password !== $passwordConfirmation) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Passwords do not match',
                'data' => $_POST
            ]);
            return;
        }

        try {
            // Check token expired time
            if (Token::isExpired($tokenValue)) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Token is expired'
                ]);
                return;
            }

            // Update password
            $user = Token::findUserByToken($tokenValue);
            UserService::updatePassword($user['id'], $password);
            Token::destroy($tokenValue);

            // Return a success response
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Password updated successfully'
            ]);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
