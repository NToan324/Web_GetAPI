<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/style.css" />
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="./process.php" method="POST" class="action">
                <h1>Create Account</h1>
                <div class="social-icons">
                    <a href="#" class="icon"></a>
                </div>
                <span>Use your email for registeration</span>
                <input type="hidden" name="action" value="register" />
                <input type="text" name="username" placeholder="Name" required />
                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Password" required />

                <?php
                if (isset($_SESSION['message_register'])) {
                    echo "<p style='color:red'>" . $_SESSION['message_register'] . "</p>";
                    unset($_SESSION['message_register']); 
                }
                ?>

                <button type="submit">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form action="./process.php" method="POST" class="action">
                <h1>Login</h1>
                <div class="social-icons">
                    <a href="#" class="icon"></a>
                </div>
                <span>Use your email password</span>
                <input type="hidden" name="action" value="login" />
                <input type="email" name="email" placeholder="Email" />
                <input type="password" name="password" placeholder="Password" />
                <div class="remember-forget">
                    <div class="remember-me">
                        <input type="checkbox" />
                        <label for="remember-me">Remember me</label>
                    </div>
                    <a href="forgot.php"> Forgot Password</a>
                </div>

                <?php
                if (isset($_SESSION['message_login'])) {
                    echo "<p style='color:red'>" . $_SESSION['message_login'] . "</p>";
                    unset($_SESSION['message_login']); 
                }
                ?>

                <button type="submit">Login</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>
                        Enter your personal details to use all of site
                        feature
                    </p>
                    <button class="hidden" id="login">Login</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>
                        Register your personal details to use all of site
                        feature
                    </p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/script.js"></script>
</body>

</html>