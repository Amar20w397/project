<?php
session_start();

function removeFromCart($productId)
{
  if (isset($_SESSION["shopping_cart"])) {
    foreach ($_SESSION["shopping_cart"] as $keys => $value) {
      if ($value["id"] == $productId) {
        unset($_SESSION["shopping_cart"][$keys]);
        echo '<script>window.location="Abelanja.php"</script>';
      }
    }
  }
}

if (isset($_GET['hapus'])) {
  $productId = $_GET['hapus'];
  removeFromCart($productId);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Keranjang Belanja - Toko Cat Online</title>
  <style>
    * {
      margin: 0;
      padding: 0;
    }

    /* Gaya font default untuk body */
    body {
      font-family: Arial, sans-serif;
      /* Menggunakan font Arial atau sans-serif jika tidak tersedia */
    }

    /* Gaya untuk bagian header */
    header {
      background-color: #f4f4f4;
      /* Warna latar belakang header */
      padding: 10px;
      /* Padding untuk header */
      padding-right: 10px;
      /* Padding kanan untuk header */
      text-align: center;
      /* Posisi teks ke tengah */
      margin-top: 1px;
      /* Jarak atas dari elemen di atasnya */
      height: 100%;
      /* Tinggi header */
    }

    /* Gaya untuk kontainer */
    .container {
      height: 3rem;
      /* Tinggi kontainer */
      width: 100%;
      /* Lebar kontainer */
      background-color: rgb(255, 0, 0);
      /* Warna latar belakang kontainer */
      color: rgb(0, 0, 0);
      /* Warna teks pada kontainer */
      text-align: center;
      /* Posisi teks ke tengah pada kontainer */
    }

    /* Gaya untuk judul h1 dalam header */
    header h1 {
      color: #333;
      /* Warna teks judul h1 */
      margin-bottom: 10px;
      /* Jarak bawah dari judul h1 */
    }

    /* Gaya untuk paragraf dalam header */
    header p {
      color: #777;
      /* Warna teks paragraf dalam header */
      margin-bottom: 20px;
      /* Jarak bawah dari paragraf dalam header */
    }

    /* Gaya untuk daftar navigasi */
    nav ul {
      list-style-type: none;
      /* Menghilangkan tanda bullet pada daftar navigasi */
      padding: 10px;
      /* Padding untuk daftar navigasi */
      text-align: right;
      /* Posisi teks ke kanan */
    }

    /* Gaya untuk setiap item daftar navigasi */
    nav ul li {
      display: inline;
      /* Menampilkan item daftar navigasi secara sejajar */
      margin-right: 20px;
      /* Jarak kanan antara setiap item */
    }

    /* Gaya untuk tautan di dalam daftar navigasi */
    nav ul li a {
      color: #333;
      /* Warna teks tautan */
      text-decoration: none;
      /* Menghilangkan garis bawah pada tautan */
    }

    /* Gaya saat hover pada tautan di dalam daftar navigasi */
    nav ul li a:hover {
      color: #ff4d00;
      /* Warna teks tautan saat hover */
    }

    /* Gaya untuk elemen footer */
    footer {
      position: relative;
      /* Posisi relatif footer */
      bottom: 0;
      /* Memposisikan footer di bagian bawah */
      height: 3rem;
      /* Tinggi footer */
      width: 100%;
      /* Lebar footer */
      background-color: rgb(255, 0, 0);
      /* Warna latar belakang footer */
      color: rgb(0, 0, 0);
      /* Warna teks pada footer */
      display: flex;
      /* Menjadikan tata letak footer menjadi flexbox */
      justify-content: space-between;
      /* Menyebarkan elemen pada footer secara merata */
    }

    /* Gaya saat hover pada tautan di dalam elemen footer */
    footer a:hover {
      color: white;
      /* Warna teks saat tautan dihover pada footer */
    }

    /* Gaya untuk tautan di dalam elemen footer */
    footer a {
      text-decoration: none;
      /* Menghilangkan garis bawah pada tautan footer */
      line-height: 50px;
      /* Jarak vertikal antara baris dalam tautan footer */
      color: #000;
      /* Warna teks pada tautan footer */
      padding-right: 25px;
      /* Padding kanan pada tautan footer */
    }

    /* Gaya untuk paragraf dalam elemen footer */
    footer p {
      padding-left: 25px;
      /* Padding kiri pada paragraf dalam footer */
      line-height: 40px;
      /* Jarak vertikal antara baris dalam paragraf footer */
    }

    /* Gaya untuk menambahkan garis bawah */
    .border {
      border-bottom: 3px solid black;
      /* Garis bawah dengan ketebalan 3px */
      margin-top: 20px;
      /* Jarak atas dari elemen di atasnya */
    }

    /* Gaya untuk tautan dalam elemen dengan kelas 'rumah' yang berada dalam elemen <a> dengan gambar */
    .rumah a img {
      margin-right: 16px;
      /* Jarak kanan dari gambar */
      display: flex;
      /* Menjadikan tata letak gambar menjadi flexbox */
    }

    /* Gaya untuk keranjang */
    .keranjang {
      border: 2px solid #ccc;
      /* Garis tepi dengan warna dan ketebalan tertentu */
      padding: 10px;
      /* Padding untuk konten dalam keranjang */
      width: 766px;
      /* Lebar keranjang */
      margin-bottom: 20px;
      /* Jarak bawah dari keranjang */
    }

    /* Gaya untuk setiap item dalam keranjang */
    .item-keranjang {
      margin-bottom: 5px;
      /* Jarak bawah antar item dalam keranjang */
    }

    /* Gaya untuk tombol-kurangi */
    .tombol-kurangi {
      cursor: pointer;
      /* Kursor menunjukkan tombol dapat diklik */
      padding: 3px 8px;
      /* Padding untuk tombol kurangi */
      background-color: #f44336;
      /* Warna latar belakang tombol kurangi */
      color: white;
      /* Warna teks tombol kurangi */
      border: none;
      /* Menghilangkan border tombol */
      border-radius: 3px;
      /* Sudut sudut tombol */
    }

    /* Gaya untuk tombol */
    .tombol {
      padding: 8px 16px;
      /* Padding untuk tombol */
      margin: 5px;
      /* Jarak antara tombol */
      background-color: #f44336;
      /* Warna latar belakang tombol */
      color: white;
      /* Warna teks tombol */
      border: none;
      /* Menghilangkan border tombol */
      border-radius: 4px;
      /* Sudut sudut tombol */
      cursor: pointer;
      /* Kursor menunjukkan tombol dapat diklik */
      text-decoration: none;
      /* Menghilangkan dekorasi teks pada tombol */
    }

    /* Gaya saat hover pada tombol */
    .tombol:hover {
      background-color: #bb372d;
      /* Warna latar belakang saat tombol dihover */
    }

    /* Gaya untuk menampilkan harga total */
    #hargaTotal {
      font-weight: bold;
      /* Ketebalan teks harga total */
      margin-top: 10px;
      /* Jarak atas dari elemen */
    }

    main {
      margin-left: 15px;
      /*untuk membuat jarak ke kiri*/
    }
  </style>
</head>

<body>
  <header>
    <div class="container">
      <h4> <br>We are open 24 hours, and free delivery throughout the city of Banda Aceh</br> </h4>
    </div>
    <nav>
      <div class="rumah">
        <a href=""><img src="fotoAceh.png" alt=""></a>
      </div>
      <ul>
        <li><a href="beranda.php" target="_self">HOME</a></li>
        <li><a href="belum_tentu.php" target="_self">SHOP</a></li>
        <li><a href="beranda.php#kontak" target="_self">CONTACT</a></li>
        <li><a href="More_privasi.php" target="_self">MORE</a></li>


      </ul>
    </nav>
  </header>
  <main>
    <?php

    // Periksa apakah sesi keranjang ada dan tidak kosong

    if (isset($_SESSION['shopping_cart']) && !empty($_SESSION['shopping_cart'])) {
      foreach ($_SESSION['shopping_cart'] as $item) {
        echo "<div class='keranjang'>";
        echo "Nama Produk: " . $item['name'] . "<br>";
        echo "Harga: Rp " . $item['price'] . "<br>";
        echo "Quantity: " . $item['quantity'] . "<br>";
        echo "<a href='?hapus=" . $item['id'] . "' class='tombol-kurangi'>Hapus</a>";
        echo "</div>";
      }
    } else {
      echo "Keranjang belanja kosong.";
    }
    ?>
  </main>
  <footer>
    <P> &copy;2023 by Aceh Art Store, </P>



    <div class="link">
      <a href="https://www.tiktok.com/@vartune" target="_blank"> Tiktok </a>
      <a href="https://www.instagram.com/acehartsstorecenter" target="_blank"> Instagram </a>
      <a href="https://www.facebook.com/profile.php?id=61554166425232" target="_blank"> Facebook </a>
      <a href="https://twitter.com/Mr_Aan14" target="_blank"> Twitter </a>
    </div>


  </footer>

  <script>

  </script>
</body>

</html>