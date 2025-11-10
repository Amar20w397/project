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

// Query untuk mengambil data sekolah dari tabel `koordinat`
$sql = "SELECT id, lat, lng, title, linkurl, tentang, alamat, linkgambar FROM koordinat";
$result = $conn->query($sql);

$schools = array();

// Memeriksa apakah ada hasil dari query
if ($result->num_rows > 0) {
    // Memasukkan data sekolah ke dalam array
    while($row = $result->fetch_assoc()) {
        $schools[] = array(
            "id" => $row["id"],
            "lat" => $row["lat"],
            "lng" => $row["lng"],
            "title" => $row["title"],
            "linkurl" => $row["linkurl"],
            "tentang" => $row["tentang"],
            "alamat" => $row["alamat"],
            "linkgambar" => $row["linkgambar"]
        );
    }
}

// Mengembalikan data sekolah dalam format JSON
header('Content-Type: application/json');
echo json_encode(array("schools" => $schools));

// Menutup koneksi
$conn->close();
?>
