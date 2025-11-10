<?php
require_once 'db.php';
session_start();

try {
    // Konfigurasi koneksi database
    $pdo = new PDO("mysql:host=localhost;dbname=maps", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $role_id = $_POST['role_id']; // 2 untuk Admin, 3 untuk User
    $marker_id = $_POST['marker_id'];

    // Cek apakah marker sudah dimiliki oleh pengguna lain
    $sql = "SELECT user_id FROM koordinat WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$marker_id]);
    $marker = $stmt->fetch();

    if ($marker && $marker['user_id'] !== null) {
        // Marker sudah dimiliki, tampilkan pesan error
        echo "<script>alert('Marker sudah dimiliki oleh pengguna lain. Silakan pilih marker yang lain.'); window.location.href='register.php';</script>";
    } else {
        // Jika marker belum dimiliki, lanjutkan dengan registrasi
        $sql = "INSERT INTO users (username, password, email, role_id) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$username, $password, $email, $role_id])) {
            // Dapatkan user_id dari pengguna baru yang didaftarkan
            $user_id = $pdo->lastInsertId();

            // Update marker dengan user_id pengguna yang baru
            $sql = "UPDATE koordinat SET user_id = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$user_id, $marker_id]);

            echo "<script>alert('Registrasi berhasil!'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Registrasi gagal. Silakan coba lagi.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
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

.register {
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
    min-height: 500px; /* Diperbesar */
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

.inputBox input, .inputBox select {
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

.inputBox span, .inputBox label {
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
.inputBox input:focus~span,
.inputBox select:valid~label,
.inputBox select:focus~label {
    transform: translateX(157px) translateY(-72px); /* Posisi saat label berpindah */
    font-size: 0.8em;
    padding: 5px 10px;
    background: #000;
    letter-spacing: 0.2em;
    color: #fff;
    border: 2px;
}

.inputBox input:valid,
.inputBox input:focus,
.inputBox select:valid,
.inputBox select:focus {
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
            <a class="register">Registrasi</a>

            <form method="POST" action="">
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
                <div class="inputBox">
                    <input type="email" name="email" required="required">
                    <span>Email</span>
                </div>
                <br>
                <div class="inputBox">
                    <select name="role_id" id="roleSelect" required="required">
                        <option value="3">User (Hanya Melihat)</option>
                        <option value="2">Admin (Tambah/Hapus/Update)</option>
                    </select>
                    <label for="role_id">Hak Akses</label>
                </div>
                <br>
                <div class="inputBox" id="markerBox">
                    <select name="marker_id" id="markerSelect" required="required">
                        <option value=""></option>
                    </select>
                    <label for="markerSelect">Pilih Marker</label>
                </div>
                <br>
                <button type="submit" class="enter">Daftar</button>
            </form>

            <p>Sudah punya akun? <a href="login.php">Masuk di sini</a></p>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Fetch data marker dari getMarkers.php dan mengisi select
        fetch('getMarkers.php')
            .then(response => response.json())
            .then(data => {
                const markerSelect = document.getElementById('markerSelect');
                data.forEach(marker => {
                    const option = document.createElement('option');
                    option.value = marker.id;
                    option.text = marker.title;
                    markerSelect.appendChild(option);
                });
            }); // Menambahkan event listener untuk mengatur disable markerSelect
            
    const roleSelect = document.getElementById('roleSelect');
    const markerSelect = document.getElementById('markerSelect');
    const markerBox = document.getElementById('markerBox'); // Ambil elemen markerBox
    
    // Mengatur status default
    markerSelect.disabled = true; // Nonaktifkan markerSelect secara default
    
    // Menampilkan markerBox secara default
    markerBox.style.display = 'block'; // Menampilkan markerBox saat halaman pertama kali dibuka
    
    roleSelect.addEventListener('change', function() {
        if (this.value === '2') { // Jika "Admin" dipilih
            markerBox.style.display = 'none'; // Sembunyikan markerSelect
            markerSelect.disabled = true; // Nonaktifkan markerSelect
        } else { // Jika "User" dipilih
            markerBox.style.display = 'block'; // Tampilkan markerSelect
            markerSelect.disabled = false; // Aktifkan markerSelect
        }
    });
});

    </script>
</body>
</html>
