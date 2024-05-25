<?php

namespace App\Controllers;

use App\Models\User;
use App\Services\UserService;
use Exception;

class SettingController
{
    public function settingView()
    {
        require_once __DIR__ . '/../views/Setting/index.html';
    }

    public function getUserInfo()
    {
        try {
            $userId = $_SESSION['id'];

            $user = User::getById($userId);

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'user' => $user
            ]);
        } catch (Exception $e) {
            // Return error response if an exception occurs
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function updateProfile()
    {
        try {
            $userId = $_SESSION['id'];

            $name = $_POST['name'] ?? '';
            $birthday = $_POST['birthday'] ?? '';
            $bio = $_POST['bio'] ?? '';
            $avatar = $_FILES['avatar'] ?? '';

            if (!empty($avatar)) {
                $this->updateAvatart($avatar);
            }

            if (empty($name) || empty($birthday)) {
                throw new Exception("Name and birthday are required");
            }

            $result = UserService::updateProfile($userId, $name, $birthday, $bio);

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Profile updated successfully'
            ]);
        } catch (Exception $e) {
            // Return error response
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function changePassword()
    {
        try {
            $userId = $_SESSION['id'];

            $oldPassword = $_POST['old-password'] ?? '';
            $newPassword = $_POST['password'] ?? '';
            $confirmPassword = $_POST['password-confirmation'] ?? '';


            if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
                throw new Exception("All fields are required.");
            }

            if ($newPassword !== $confirmPassword) {
                throw new Exception("New password and confirm password do not match.");
            }

            $user = User::getById($userId);

            if (!password_verify($oldPassword, $user['password'])) {
                throw new Exception("Incorrect old password.");
            }

            UserService::updatePassword($userId, $newPassword);

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Password updated successfully.'
            ]);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    private function updateAvatart($avatar)
    {
        if ($avatar['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Can not update avatar');
        }

        $userId = $_SESSION['id'];

        $fileExtension = pathinfo($avatar['name'], PATHINFO_EXTENSION);
        $fileName = $userId . '.' . $fileExtension;

        $uploadDir = __DIR__ . '/../../storage/users/';
        $uploadFilePath = $uploadDir . $fileName;

        if (move_uploaded_file($avatar['tmp_name'], $uploadFilePath)) {
            User::updateAvatarPath($userId, $fileName);
        }
    }
}
