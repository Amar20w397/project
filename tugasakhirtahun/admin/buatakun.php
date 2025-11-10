<?php
session_start();
include "config.php";

if (isset($_POST['username']) && isset($_POST['password'])) {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = validate($_POST['username']);
    $password = validate($_POST['password']);

    if (empty($username)) {
        header("Location: buatakun.php?error=Username is required");
        exit();
    } else if (empty($password)) {
        header("Location: buatakun.php?error=Password is required");
        exit();
    } else {
        // Check if the username is already taken
        $sql = "SELECT * FROM admin WHERE username='$username'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            header("Location: buatakun.php?error=Username is already taken");
            exit();
        } else {
            // Insert new user into the database
            $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                header("Location: login_index.php?success=Your account has been created successfully");
                exit();
            } else {
                header("Location: buatakun.php?error=Unknown error occurred");
                exit();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #272727;
            font-family: Arial, sans-serif;
        }

        .login-box {
            position: relative;
            width: 400px;
            padding: 40px;
            margin: 20px auto;
            background: rgba(0, 0, 0, .9);
            box-sizing: border-box;
            box-shadow: 0 15px 25px rgba(0, 0, 0, .6);
            border-radius: 10px;
        }

        .login-box p:first-child {
            margin: 0 0 30px;
            padding: 0;
            color: #fff;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .login-box .user-box {
            position: relative;
        }

        .login-box .user-box input {
            width: 100%;
            padding: 10px 0;
            font-size: 16px;
            color: #fff;
            margin-bottom: 30px;
            border: none;
            border-bottom: 1px solid #fff;
            outline: none;
            background: transparent;
        }

        .login-box .user-box label {
            position: absolute;
            top: 0;
            left: 0;
            padding: 10px 0;
            font-size: 16px;
            color: #fff;
            pointer-events: none;
            transition: .5s;
        }

        .login-box .user-box input:focus ~ label,
        .login-box .user-box input:valid ~ label {
            top: -20px;
            left: 0;
            color: #fff;
            font-size: 12px;
        }

        .login-box form a {
            position: relative;
            display: inline-block;
            padding: 10px 20px;
            font-weight: bold;
            color: #fff;
            font-size: 16px;
            text-decoration: none;
            text-transform: uppercase;
            overflow: hidden;
            transition: .5s;
            margin-top: 40px;
            letter-spacing: 3px;
            cursor: pointer;
            text-align: center;
        }

        .login-box a:hover {
            background: #fff;
            color: #272727;
            border-radius: 5px;
        }

        .login-box a span {
            position: absolute;
            display: block;
        }

        .login-box a span:nth-child(1) {
            top: 0;
            left: -100%;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #fff);
            animation: btn-anim1 1.5s linear infinite;
        }

        @keyframes btn-anim1 {
            0% { left: -100%; }
            50%, 100% { left: 100%; }
        }

        .login-box a span:nth-child(2) {
            top: -100%;
            right: 0;
            width: 2px;
            height: 100%;
            background: linear-gradient(180deg, transparent, #fff);
            animation: btn-anim2 1.5s linear infinite;
            animation-delay: .375s;
        }

        @keyframes btn-anim2 {
            0% { top: -100%; }
            50%, 100% { top: 100%; }
        }

        .login-box a span:nth-child(3) {
            bottom: 0;
            right: -100%;
            width: 100%;
            height: 2px;
            background: linear-gradient(270deg, transparent, #fff);
            animation: btn-anim3 1.5s linear infinite;
            animation-delay: .75s;
        }

        @keyframes btn-anim3 {
            0% { right: -100%; }
            50%, 100% { right: 100%; }
        }

        .login-box a span:nth-child(4) {
            bottom: -100%;
            left: 0;
            width: 2px;
            height: 100%;
            background: linear-gradient(360deg, transparent, #fff);
            animation: btn-anim4 1.5s linear infinite;
            animation-delay: 1.125s;
        }

        @keyframes btn-anim4 {
            0% { bottom: -100%; }
            50%, 100% { bottom: 100%; }
        }

        .login-box p:last-child {
            color: #aaa;
            font-size: 14px;
            text-align: center;
        }

        .login-box a.a2 {
            color: #fff;
            text-decoration: none;
        }

        .login-box a.a2:hover {
            background: transparent;
            color: #aaa;
            border-radius: 5px;
        }

        .error {
            color: red;
            text-align: center;
        }

        .password-container {
            position: relative;
        }

        .password-container input[type="password"], 
        .password-container input[type="text"] {
            width: calc(100% - 40px); /* Adjust width */
        }

        .password-container .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            background: none;
            border: none;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <p>Create Account</p>
        <form action="buatakun.php" method="post">
            <div class="user-box">
                <input type="text" name="username" id="username" placeholder="Username" required>
                <label for="username">Username</label>
            </div>
            <div class="user-box ">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>
            <?php if (isset($_GET['error'])): ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php endif; ?>
            <a href="#" onclick="this.closest('form').submit();return false;">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                Create
            </a>
        </form>
        <p>Already have an account? <a href="index.php" class="a2">Login</a></p>
    </div>
</body>
</html>