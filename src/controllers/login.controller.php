<?php namespace App\Controller;

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\User;
use Exception;

class LoginController
{
    public function login($email, $password)
    {
        header('Content-type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $res = array(
                'success' => false,
                'message' => 'POST method is required. You\'re not using POST method'
            );
            die(json_encode($res));
        }

        try {
            if (isset($_POST['email']) && isset($_POST['password'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];
                echo json_encode([$email, $password]);
                require_once './config/db.conn.php';

                $user = new User($conn);
                $auth = $user->authenticate($email, $password);

                if ($auth) {
                    $res = array(
                        'success' => true,
                        'data' => $auth,
                        'message' => 'Login successfully'
                    );

                    echo json_encode($res);
                    return;
                }
            } else {
                throw new Exception('Email and password are required.');
            }
        } catch (Exception $e) {
            $res = array(
                'success' => false,
                'message' => $e->getMessage()
            );
            echo json_encode($res);
        }
    }
}
