<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "maps";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    header('Content-Type: application/json');
    echo json_encode(array('success' => false, 'message' => 'Koneksi gagal: ' . $conn->connect_error));
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 

    $sql = "SELECT * FROM koordinat WHERE id = $id";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $response = array(
                'success' => true,
                'school' => array(
                    'id' => $row['id'],
                    'nama_sekolah' => $row['title'],
                    'lat' => $row['lat'],
                    'lng' => $row['lng']
                )
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Sekolah tidak ditemukan'
            );
        }
    } else {
        $response = array(
            'success' => false,
            'message' => 'Error dalam query: ' . $conn->error
        );
    }
} else {
    $response = array(
        'success' => false,
        'message' => 'Parameter ID sekolah tidak diberikan'
    );
}

$conn->close();
header('Content-Type: application/json');
echo json_encode($response);
?>
