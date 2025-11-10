<?php
session_start();
include 'db.php';
if ($_SESSION['status_login'] != true) {
    echo "<script>window.location='login.php'</script>";
}


?>  

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bukalaptop</title>
    <link rel="stylesheet" type="text/css" href="css/styl345.css">
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

    <div class="section">
    <div class="container">
        <h3>Data Kategori</h3>
        <div class="box">
            <p><a href="tambah-kategori.php">Tambah Data</a></p>
            <table border="2" cellspacing="0" class="table">
                <thead>
                    <tr>
                        <td width="60px">No</td>
                        <td>Kategori</td>
                        <td width="150px">Aksi</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $kategori = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY category_id DESC");
                    if(mysqli_num_rows($kategori) > 0) {
                    while ($row = mysqli_fetch_array($kategori)) {
                    ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $row['category_name'] ?></td>
                            <td>
                                <a href="edit-kategori.php?id=<?php echo $row['category_id'] ?>">Edit</a> || 
                                <a href="proses-hapus.php?idk=<?php echo $row['category_id'] ?>"onclick="return confirm('yakin ingin di hapus ?')">Hapus</a>
                            </td>
                        </tr>
                    <?php }}else{ ?>
                        <tr>
                            <td colspan="3">tidak ada data</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
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
