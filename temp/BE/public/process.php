<?php
include '../config/database.php';
session_start();

$action = $_POST['action'];

switch ($action) {
    case 'register':
        $username = htmlspecialchars(strip_tags($_POST['username']));
        $email = htmlspecialchars(strip_tags($_POST['email']));
        $password = htmlspecialchars(strip_tags($_POST['password']));
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Kiểm tra email đã tồn tại chưa
        $checkQuery = "SELECT email FROM users WHERE email = ?";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->execute([$email]);

        if ($checkStmt->rowCount() > 0) {
            $_SESSION['message_register'] = "Email đã tồn tại. Vui lòng chọn email khác.";
            header("Location: index.php");
            exit;
        }

        // Thêm vào database
        $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);

        if ($stmt->execute([$username, $email, $hashed_password])) {
            $_SESSION['message_register'] = "Đăng ký thành công! Hãy đăng nhập.";
            header("Location: index.php");
            exit;
        } else {
            $_SESSION['message_register'] = "Đăng ký thất bại. Vui lòng thử lại.";
            header("Location: index.php");
        }
        break;

    case 'login':
        $email = htmlspecialchars(strip_tags($_POST['email']));
        $password = $_POST['password'];

        $query = "SELECT id, username, password FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: home.php");
            exit;
            // Xử lý sau khi đăng nhập thành công, ví dụ như thiết lập session
        } else {
            $_SESSION['message_login'] = "Email hoặc mật khẩu không đúng. Vui lòng thử lại.";
            header("Location: index.php");
        }
        break;
}
