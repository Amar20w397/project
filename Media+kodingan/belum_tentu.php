<?php
session_start();
require 'conn.php';

$barang = query("SELECT * FROM barang");

// Fungsi untuk memeriksa dan memulai sesi jika belum dimulai
function checkAndStartSession() {
  if (session_status() == PHP_SESSION_NONE) {
      session_start();
  }
}

// Panggil fungsi untuk memeriksa dan memulai sesi
checkAndStartSession();
function addToCart($productId, $productName, $productPrice, $productQuantity) {
    if (!isset($_SESSION["shopping_cart"])) {
        $_SESSION["shopping_cart"] = [];
    }

    foreach ($_SESSION["shopping_cart"] as $item) {
        if ($item["id"] == $productId) {
            echo '<script>alert("Product is already in the cart")</script>';
            echo '<script>window.location="process_order.php"</script>';
            return;
        }
    }

    $_SESSION["shopping_cart"][] = [
        'id' => $productId,
        'name' => $productName,
        'price' => $productPrice,
        'quantity' => $productQuantity
    ];

    echo '<script>window.location="process_order.php"</script>';
}

if (isset($_POST['add'])) {
    $productId = $_POST['id'];
    $productName = $_POST['hidden_name'];
    $productPrice = $_POST['hidden_price'];
    $productQuantity = $_POST['quantity'];

    addToCart($productId, $productName, $productPrice, $productQuantity);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
    <style>
/* Mengatur nol margin dan padding untuk semua elemen */
* {
  margin: 0;
  padding: 0;
}

/* Gaya font default untuk body */
body {
  font-family: Arial, sans-serif;
}

/* Gaya untuk bagian header */
header {
  background-color: #f4f4f4;
  padding: 10px;
  padding-right: 10px;
  text-align: center;
  margin-top: 1px;
  height: 100%;
}

/* Gaya untuk container */
.custom-container {
  height: 5rem;
  width: 100%;
  background-color: rgb(255, 0, 0);
  color: rgb(0, 0, 0);
  text-align: center;
  margin: auto;
}

/* Gaya untuk judul h1 dalam header */
header h1 {
  color: #333;
  margin-bottom: 10px;
}

/* Gaya untuk paragraf dalam header */
header p {
  color: #777;
  margin-bottom: 20px;
}

/* Gaya untuk daftar navigasi */
nav ul {
  list-style-type: none;
  padding: 10px;
  text-align: right;
}

/* Gaya untuk setiap item daftar navigasi */
nav ul li {
  display: inline;
  margin-right: 20px;
}

/* Gaya untuk tautan di dalam daftar navigasi */
nav ul li a {
  color: #333;
  text-decoration: none;
}

/* Gaya saat hover pada tautan di dalam daftar navigasi */
nav ul li a:hover {
  color: #ff4d00;
}

/* Gaya untuk elemen footer */
footer {
  position: relative;
  bottom: 0;
  height: 3rem;
  width: 100%;
  background-color: rgb(255, 0, 0);
  color: rgb(0, 0, 0);
  display: flex;
  justify-content: space-between;
}

/* Gaya saat hover pada tautan di dalam elemen footer */
footer a:hover {
  color: white;
}

/* Gaya untuk tautan di dalam elemen footer */
footer a {
  text-decoration: none;
  line-height: 50px;
  color: #000;
  padding-right: 25px;
}

/* Gaya untuk paragraf dalam elemen footer */
footer p {
  padding-left: 25px;
  line-height: 40px;
}

/* Gaya untuk menambahkan garis bawah */
.border {
  border-bottom: 3px solid black;
  margin-top: 20px;
}

/* Gaya untuk tautan dalam elemen dengan kelas 'rumah' yang berada dalam elemen <a> dengan gambar */
.rumah a img {
  margin-right: 16px;
  display: flex;
  margin-top: 2rem;
}

/* Gaya untuk container45 */
.container45 {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 10px;
  justify-content: space-around;
  margin-left: 200px;
}

/* Gaya untuk item */
.item {
  text-align: center;
  width: 30%;
  margin-bottom: 20px;
  margin-left: 20px;
  margin-top: 20px;
}

/* Gaya untuk harga */
.harga {
  margin-top: 10px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

/* Gaya untuk jumlah */
.jumlah {
  display: flex;
  align-items: center;
  justify-content: center;
  margin-top: 5px;
}

/* Gaya untuk tombol */
.tombol {
  margin: 0 5px;
  padding: 5px 10px;
  cursor: pointer;
  background-color: #f0f0f0;
  border-radius: 5px;
}

/* Gaya saat hover pada tombol di dalam container45 */
.container45 button:hover {
  background-color: #000;
  transition: 0.5s;
}

/* Gaya untuk elemen dengan kelas 'side' */
.side {
  position: absolute;
  left: 50px;
}

/* Gaya untuk menambahkan garis bawah pada elemen */
.border34 {
  border-bottom: 1px solid black;
  margin-top: 10px;
  margin-bottom: 20px;
}

/* Gaya saat hover pada tautan dalam elemen dengan kelas 'side' */
.side a:hover {
  color: wheat;
}

/* Gaya untuk tautan dalam elemen dengan kelas 'side' */
.side a {
  color: #000;
  text-decoration: none;
}
    </style>
</head>
<body>

    <header>
        <div class="custom-container"> <h4> <br>We are open 24 hours, and free delivery throughout the city of Banda Aceh</br> </h4></div>
        <nav>
            <div class="rumah">
                <a href=""><img src="media/fotoAceh.png" alt=""></a>
              </div>
              <ul>
                  <li><a href="beranda.php" target="_self">HOME</a></li>
                  <li><a href="belum_tentu.php" target="_self">SHOP</a></li>
                  <li><a href="beranda.php#kontak" target="_self">CONTACT</a></li>
                  <li><a href="More_privasi.php" target="_self">MORE</a></li>
                  <li><a href="Abelanja.php">KERANJANG</a></li>
              </ul>
          </nav>
    </header>
    <div class="border"></div>
    <br>
        <h1 class="text-center">Professional Art</h1>
        
    <div class="border"></div><br>
    <div class="side">
    <h1>FILTER BY</h1>
    
    <div class="border34"></div>
    <h3>Category</h3><br>
    <a href="belum_tentu.html">Professional Art</a>
    
    <br>
    <a href="shopkid.html">Kids Art</a>
    <div class="border34"></div>
  </div>

    <div class="container45">
      <?php foreach ($barang as $item): ?>
        <div class="item" id="item1">
          <img src="media/<?= $item['gambar']?>" width="300">
          <div class="harga">
            <p id="namaProduk10"><?= $item['nama']; ?></p> <br>
            <p id="hargaProduk10">Harga: Rp <?= $item['harga']; ?></p>

            <form id="beliForm" method="post">
                <div class=" inpu input-group mb-3">
                    <button type="button" class="btn btn-outline-secondary btn-decrement btn-sm me-2">-</button>
                    <input type="text" name="quantity" class="form-control text-center" value="1" min="1">
                    <button type="button" class="btn btn-outline-secondary btn-increment btn-sm ms-2">+</button>
                </div>
                <input type="hidden" name="hidden_name" value="<?php echo $item["nama"]; ?>">
                <input type="hidden" name="hidden_price" value="<?php echo $item["harga"]; ?>">
                <button type="submit" onclick="beliBarang(<?php echo $item['id']; ?>)" class="btn btn-outline-secondary" name="add" ><a href="" class="text-decoration-none text-secondary">Beli</a></button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
    </div>



      </div>

    <br>
    <br>

    <footer>
      <P> &copy;2023 by Aceh Art Store, </P>
        

              
      <div class="link">
        <a href="https://www.tiktok.com/@vartune" target="_blank"> Tiktok </a>
        <a href="https://www.instagram.com/acehartsstorecenter" target="_blank"> Instagram </a>
        <a href="https://www.facebook.com/profile.php?id=61554166425232" target="_blank"> Facebook </a>
        <a href="https://twitter.com/Mr_Aan14" target="_blank"> Twitter </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<!-- Include Bootstrap JS and jQuery (optional) -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    
        
        </footer>
        <script>
       // Fungsi untuk menambah nilai elemen dengan ID tertentu

    document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-increment').forEach(button => {
        button.addEventListener('click', function () {
            let input = this.closest('.inpu').querySelector('input[name="quantity"]');
            input.value = parseInt(input.value) + 1;
        });
    });

    document.querySelectorAll('.btn-decrement').forEach(button => {
        button.addEventListener('click', function () {
            let input = this.closest('.inpu').querySelector('input[name="quantity"]');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        });
    });
});
        </script>

    
</body>
</html>