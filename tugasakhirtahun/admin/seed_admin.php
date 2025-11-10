<?php
require 'config.php';

// Menggunakan password hash untuk keamanan
$username = 'admin';
$password = password_hash('adminpassword', PASSWORD_DEFAULT);

$stmt = $conn->prepare('INSERT INTO admin (username, password) VALUES (?, ?)');
$stmt->bind_param('ss', $username, $password);

if ($stmt->execute()) {
    echo "Admin berhasil ditambahkan";
} else {
    echo "Gagal menambahkan admin: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>