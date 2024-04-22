<?php
require_once __DIR__ . '/../models/User.php';
class SignUpController
{
    public function showSignUp() {
        // TODO: render sign up page
    }

    public function signUp($name, $email, $password)
    {
        header('Content-type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $res = array(
                'success' => false,
                'message' => 'POST method is required for sign up. You\'re not using POST method'
            );
            die(json_encode($res));
        }

        try {
            if (isset($_POST['email']) && isset($_POST['password'])) {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                require_once './config/db.conn.php';

                $user = new User($conn);
                $success = $user->create($name, $email, $password);

                if ($success) {
                    $res = array(
                        'success' => true,
                        'message' => 'Login successfully',
                        'data' => $success
                    );

                    echo json_encode($res);
                    return;
                }
            } else {
                throw new Exception('All field has not been filled yet');
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
