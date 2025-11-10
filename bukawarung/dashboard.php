<?php
session_start();
 if($_SESSION['status_login'] !=true){
     echo "<script>window.location='login.php'</script>";
 }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf_8">
    <meta name="viewpoint" content="width-device-width, initial-scale=1"">
    <title>Bukalaptop</title>
    <link rel="stylesheet" href="css/styl345.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">

</head>
<body >
<!-- header -->
    <header>
        <div class="container">
        <h1><a href="dashboard.php">Bukalaptop</a></h1>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="profil.php">Profil</a></li>
            <li><a href="data-kategori.php">Data Kategori</a></li>
            <li><a href="data-produk.php">Data Produk</a></li>
            <li><a href="keluar.php">keluar</a></li>
        </ul>
        </div>
    </header>

<!-- container -->
    <div class="section">
        <div class="container">
            <h2>Dashboard</h2>
            <div class="box">
                <h4>selamat datang <?php echo $_SESSION['a_global']->admin_name ?> ditoko online</h4>
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