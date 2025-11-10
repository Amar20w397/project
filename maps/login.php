<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = "SELECT user_id, username, password, role_id FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['role_id'] = $user['role_id'];
        $_SESSION['username'] = $user['username']; // Simpan username
        header("Location: map.php");
        exit;
    } else {
        $error = "Username atau password salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
}

.container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    width: 100%;
}

.login {
    color: #000;
    text-transform: uppercase;
    letter-spacing: 2px;
    display: block;
    font-weight: bold;
    font-size: x-large;
}

.card {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 400px; /* Diperbesar */
    width: 375px; /* Diperbesar */
    flex-direction: column;
    gap: 35px;
    background: #e3e3e3;
    box-shadow: 16px 16px 32px #c8c8c8, -16px -16px 32px #fefefe;
    border-radius: 8px;
}

.inputBox {
    position: relative;
    width: 280px; /* Diperbesar */
}

.inputBox input {
    width: 100%;
    padding: 10px;
    outline: none;
    border: none;
    color: #000;
    font-size: 1em;
    background: transparent;
    border-left: 2px solid #000;
    border-bottom: 2px solid #000;
    transition: 0.1s;
    border-bottom-left-radius: 8px;
}

.inputBox span {
    position: absolute;
    left: 0px;
    bottom: -45px;
    transform: translateY(-49px); /* Diubah 45px lebih tinggi dari sebelumnya */
    margin-left: 10px;
    padding: 10px;
    pointer-events: none;
    font-size: 12px;
    color: #000;
    text-transform: uppercase;
    transition: 0.5s;
    letter-spacing: 3px;
    border-radius: 8px;
}

.inputBox input:valid~span,
.inputBox input:focus~span {
    transform: translateX(157px) translateY(-72px); /* Posisi saat label berpindah */
    font-size: 0.8em;
    padding: 5px 10px;
    background: #000;
    letter-spacing: 0.2em;
    color: #fff;
    border: 2px;
}

.inputBox input:valid,
.inputBox input:focus {
    border: 2px solid #000;
    border-radius: 8px;
}

.enter {
    height: 45px;
    width: 100px;
    border-radius: 5px;
    border: 2px solid #000;
    cursor: pointer;
    background-color: transparent;
    transition: 0.5s;
    text-transform: uppercase;
    font-size: 10px;
    letter-spacing: 2px;
    margin-bottom: 1em;
}

.enter:hover {
    background-color: rgb(0, 0, 0);
    color: white;
}
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <br>
            <a class="login">Log in</a>

            <?php if (isset($error)): ?>
                <p style="color:red; margin:0;"><?php echo $error; ?></p>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="inputBox">
                    <input type="text" name="username" required="required">
                    <span class="user">Username</span>
                </div>
                <br>
                <div class="inputBox">
                    <input type="password" name="password" required="required">
                    <span>Password</span>
                </div>
                <br>
                <button type="submit" class="enter">Enter</button>
            </form>

            <p>Belum punya akun? <a href="registrasi.php">Daftar di sini</a></p>
        </div>
    </div>
</body>
</html>
