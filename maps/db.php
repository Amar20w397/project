<?php


// Konfigurasi database
$host = 'localhost'; // Ganti dengan host database Anda
$dbname = 'maps'; // Nama database Anda
$username = 'root'; // Username database Anda
$password = ''; // Password database Anda (kosongkan jika tidak ada)

try {
    // Membuat koneksi ke database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
}

// Fungsi untuk mendapatkan username berdasarkan user_id
function getUsername() {
    global $pdo;

    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        // Ambil username dari database
        $stmt = $pdo->prepare("SELECT username FROM users WHERE id = :id");
        $stmt->bindParam(':id', $userId);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user['username'];
        }
    }
    return null;
}

// Fungsi untuk mengecek apakah username sudah terdaftar
function isUsernameTaken($username) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    return $stmt->fetchColumn() > 0;
}

// Fungsi untuk mengambil informasi pengguna berdasarkan ID
function getUserById($userId) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $userId);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
