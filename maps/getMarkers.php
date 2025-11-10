<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log function
function logError($message) {
    error_log(date('[Y-m-d H:i:s] ') . $message . PHP_EOL, 3, 'error.log');
}

// Fungsi untuk mengembalikan respons JSON
function sendJsonResponse($data, $statusCode = 200) {
    header('Content-Type: application/json');
    http_response_code($statusCode);
    echo json_encode($data);
    exit;
}

// Konfigurasi koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "maps";

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    logError("Database connection failed: " . $conn->connect_error);
    sendJsonResponse(['error' => "Koneksi gagal: " . $conn->connect_error], 500);
}

// Jika ada permintaan GET untuk mengambil marker
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $sql = "SELECT id, lat, lng, title, linkurl, tentang, alamat, user_id, linkgambar FROM koordinat";
    $result = $conn->query($sql);

    if ($result === false) {
        logError("SQL query failed: " . $conn->error);
        sendJsonResponse(['error' => 'Gagal mengambil data: ' . $conn->error], 500);
    }

    $markers = [];

    while($row = $result->fetch_assoc()) {
        $markers[] = $row;
    }

    sendJsonResponse($markers);
} else {
    logError("Invalid request method: " . $_SERVER['REQUEST_METHOD']);
    sendJsonResponse(['error' => 'Metode tidak diizinkan'], 405);
}

// Menutup koneksi
$conn->close();
?>