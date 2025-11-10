<?php
session_start();
include 'db.php';
if ($_SESSION['status_login'] != true) {
    echo "<script>window.location='login.php'</script>";
}

$query = mysqli_query($conn, " SELECT * FROM tb_admin WHERE admin_id = '". $_SESSION['id']."' ");
$d = mysqli_fetch_object($query);
?>  

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bukalaptop</title>
    <link rel="stylesheet" href="css/styl345.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- header -->
    <header>
        <div class="container">
            <h1><a href="dashboard.php">Bukalaptop</a></h1>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="data-kategori.php">Data Kategori</a></li>
                <li><a href="data-produk.php">Data Produk</a></li>
                <li><a href="keluar.php">Keluar</a></li>
            </ul>
        </div>
    </header>

    <!-- content -->
<div class="section">
    <div class="container">
        <h3>Tambah Data Kategori</h3>
        <div class="box">
            <form action="" method="POST">
                <input type="text" name="nama" placeholder="Nama Kategori" class="input-control" required>
                <input type="submit" name="submit" value="Submit" class="btn">
            </form>
            <?php
            if (isset($_POST['submit'])) {
                $nama = ucwords($_POST['nama']);
                $insert = mysqli_query($conn, "INSERT INTO tb_category VALUES (null, '$nama')");
                if ($insert) {
                    echo '<script>alert("Tambah data berhasil")</script>';
                    echo '<script>window.location="data-kategori.php"</script>';
                } else {
                    echo 'Gagal. ' . mysqli_error($conn);
                }
            }
            ?>
        </div>
    </div>
</div>

      <!-- footer -->
      <footer>
        <div class="container">
            <smail>Copyright &copy; 2025 - Bukalaptop.</smail>
        </div>
    </footer>
</body>
</html>
