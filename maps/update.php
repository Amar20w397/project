<?php
// Konfigurasi koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "maps";

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mendapatkan data dari request body
$data = json_decode(file_get_contents('php://input'), true);

// Memeriksa apakah semua data yang dibutuhkan tersedia
if (isset($data['id']) && isset($data['lat']) && isset($data['lng']) && isset($data['title']) && isset($data['linkurl']) && isset($data['tentang']) && isset($data['alamat']) && isset($data['linkgambar'])) {
    
    // Mengamankan input
    $id = $conn->real_escape_string($data['id']);
    $lat = $conn->real_escape_string($data['lat']);
    $lng = $conn->real_escape_string($data['lng']);
    $title = $conn->real_escape_string($data['title']);
    $linkurl = $conn->real_escape_string($data['linkurl']);
    $tentang = $conn->real_escape_string($data['tentang']);
    $alamat = $conn->real_escape_string($data['alamat']);
    $linkgambar = $conn->real_escape_string($data['linkgambar']);

    // Update query
    $sql = "UPDATE koordinat SET lat='$lat', lng='$lng', title='$title', linkurl='$linkurl', tentang='$tentang', alamat='$alamat', linkgambar='$linkgambar' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        $response = array("success" => true, "message" => "Marker berhasil diperbarui.");
    } else {
        $response = array("success" => false, "message" => "Gagal memperbarui marker: " . $conn->error);
    }
} else {
    $response = array("success" => false, "message" => "Data tidak lengkap.");
}

// Menutup koneksi
$conn->close();

// Mengembalikan respons dalam format JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
