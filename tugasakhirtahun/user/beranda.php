<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aceh Arts Store Center</title>
    <style>
    body {
    /* Menetapkan jenis font untuk teks */
    font-family: Arial, sans-serif;
    }
        /* Styles for the container */
        .container {
            /* Menetapkan tinggi kotak */
            height: 3rem;
            /* Menetapkan lebar kotak */
            width: 100%;
            /* Menetapkan warna latar belakang */
            background-color: rgb(255, 0, 0);
            /* Menetapkan warna teks */
            color: rgb(0, 0, 0);
            /* Menetapkan penataan teks ke tengah kotak */
            text-align: center;
        }

        /* Styles for the header */
        header {
            /* Menetapkan warna latar belakang */
            background-color: #f4f4f4;
            /* Menetapkan ruang kosong di dalam header */
            padding: 10px;
            /* Menetapkan ruang kosong di dalam header (bagian kanan) */
            padding-right: 10px;
            /* Menetapkan penataan teks ke tengah header */
            text-align: center;
            /* Menetapkan jarak dari atas ke header */
            margin-top: 1px;
        }

        /* Styles for the header's h1 element */
        header h1 {
            /* Menetapkan warna teks */
            color: #333;
            /* Menetapkan jarak antara elemen dengan elemen lain di bawahnya */
            margin-bottom: 10px;
        }

        /* Styles for the header's p element */
        header p {
            /* Menetapkan warna teks */
            color: #777;
            /* Menetapkan jarak antara elemen dengan elemen lain di bawahnya */
            margin-bottom: 20px;
        }

        /* Styles for the navigation ul */
        nav ul {
            /* Menetapkan jenis daftar menjadi tanpa bullet point */
            list-style-type: none;
            /* Menetapkan ruang kosong di dalam daftar */
            padding: 10px;
            /* Menetapkan penataan teks ke kanan */
            text-align: right; 
        }
        nav ul li {
            /* Menetapkan tampilan elemen menjadi sejajar */
            display: inline;
            /* Menetapkan jarak dari sisi kanan elemen */
            margin-right: 20px;
        }

        /* Styles for the navigation ul li a elements */
        nav ul li a {
            /* Menetapkan warna teks */
            color: #333;
            /* Menghapus dekorasi hyperlink */
            text-decoration: none;
        }

        /* Styles for the navigation ul li a elements when hovered */
        nav ul li a:hover {
            /* Menetapkan warna teks saat kursor diarahkan ke atas */
            color: #ff4d00;
        }

        /* Styles for the image container */
        .gambar-container img {
            /* Menetapkan penataan konten gambar ke tengah */
            align-items: center;
            /* Menetapkan tampilan konten sebagai flexbox */
            display: flex;
            /* Menetapkan jarak dari sisi kanan dan kiri secara otomatis */
            margin: auto;
        }

        /* Styles for the navigation */
        nav {
            /* Menetapkan tampilan konten sebagai flexbox */
            display: flex;
            /* Menetapkan penyebaran sekitar konten */
            justify-content: space-around;
            /* Menetapkan jarak dari atas ke navigasi */
            margin-top: 15px;
        }

        /* Styles for the buttons */
        .tombol {
            /* Menetapkan ukuran padding atas dan bawah serta kiri dan kanan */
            padding: 24px 60px;
            /* Menetapkan jarak dari sisi kanan elemen */
            margin-right: 230px;
            /* Menetapkan jarak dari sisi atas elemen */
            margin-top: 17px;
        }

        /* Styles for the buttons when hovered */
        .tombol:hover {
            /* Menetapkan warna latar belakang saat tombol dihover */
            background-color: #000;
            /* Menetapkan warna teks saat tombol dihover */
            color: white;
            /* Efek transisi ketika terjadi perubahan pada tombol */
            transition: 0.5s;
        }
        .kotakdlmgambar {
            /* Menetapkan posisi elemen secara absolut */
            position: absolute;
            /* Menetapkan jarak dari bagian atas elemen */
            top: 49%;
            /* Menetapkan jarak dari bagian kiri elemen */
            left: 19%;
            /* Menetapkan tinggi elemen */
            height: 240px;
            /* Menetapkan lebar elemen */
            width: 500px;
            /* Menetapkan warna latar belakang dengan transparansi */
            background-color: rgba(255, 255, 255, 0.8); 
            /* Menetapkan warna teks */
            color: #333;
            /* Menetapkan penataan teks ke tengah */
            text-align: center;
            /* Menetapkan padding pada elemen */
            padding: 10px;
            /* Menetapkan border untuk elemen */
            border: 2px solid #000;
            /* Menetapkan ketebalan font */
            font-weight: 100;

        }

        /* Styles for the bottom border */
        .border {
            /* Menetapkan border bawah */
            border-bottom: 3px solid black;
            /* Menetapkan jarak dari bagian atas elemen */
            margin-top: 20px;
        }

        /* Styles for the image in the 'rumah' class */
        .rumah a img {
            /* Menetapkan jarak dari sisi kanan elemen */
            margin-right: 165px;
        }

        /* Styles for the footer */
        footer {
            /* Menetapkan posisi relatif */
            position: relative;
            /* Menetapkan posisi bawah */
            bottom: 0;
            /* Menetapkan tinggi elemen */
            height: 3rem;
            /* Menetapkan lebar elemen */
            width: 100%;
            /* Menetapkan warna latar belakang */
            background-color: rgb(255, 0, 0);
            /* Menetapkan warna teks */
            color: rgb(0, 0, 0);
            /* Menetapkan tampilan konten sebagai flexbox dengan penyebaran sekitar */
            display: flex;
            justify-content: space-between;            
        }

        /* Styles for the links in the footer when hovered */
        footer a:hover {
            /* Menetapkan warna teks saat kursor diarahkan ke atas */
            color: white;
        }

        /* Styles for the links in the footer */
        footer a {
            /* Menghapus dekorasi hyperlink */
            text-decoration: none;
            /* Menetapkan tinggi baris */
            line-height: 50px;
            /* Menetapkan jarak dari sisi kanan elemen */
            padding-right: 25px;
            /*digunakan untuk mengubah warna*/
            color: #000;
        }

        /* Styles for the paragraph in the footer */
        footer p {
            /* Menetapkan jarak dari sisi kiri elemen */
            padding-left: 25px;
        }

        /* Styles for the 'contaa' class */
        .contaa {
            /* Menetapkan tinggi elemen */
            height: 3rem;
            /* Menetapkan lebar elemen */
            width: 100%;
            /* Menetapkan warna latar belakang */
            background-color: rgb(255, 255, 255);
            /* Menetapkan warna teks */
            color: rgb(0, 0, 0);
            /* Menetapkan teks menjadi huruf kapital */
            text-transform: capitalize;
            /* Menetapkan tampilan konten sebagai inline block */
            display: inline-block;
        }

        /* Styles for the links in the 'contaa' class */
        .contaa a {
            /* Menetapkan jarak dari sisi kiri elemen */
            margin-left: 250px;
            /* Menghapus dekorasi hyperlink */
            text-decoration: none;
            /* Menetapkan warna teks */
            color: #000;
        }

        /* Styles for the links in the 'contaa' class when hovered */
        .contaa a:hover {
            /* Menetapkan warna teks saat kursor diarahkan ke atas */
            color: #ff4d00;
        }

        /* Styles for the heading in the 'contaa' class */
        .contaa h2 {
            /* Menetapkan jarak dari sisi kiri elemen */
            margin-left: 250px;
        }

        /* Additional styles for the 'contaa' class */
        .contaa {
            /* Menetapkan tampilan konten sebagai flexbox dengan penyebaran sekitar */
            display: flex;
            justify-content: space-around;
            /* Menetapkan tinggi elemen */
            height: 400px;
        }

        /* Styles for links in 'contact' class when hovered */
        .contact a:hover {
            /* Menetapkan warna teks saat kursor diarahkan ke atas */
            color: #ff4d00;
        }

        /* Styles for the HTML element */
        html {
            /* Menetapkan perilaku scroll halus */
            scroll-behavior: smooth;
        }

       /* Gaya untuk kotak konfirmasi */
.confirmation-box {
  position: fixed; /* Menempatkan kotak konfirmasi secara tetap pada halaman */
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5); /* Warna latar belakang dengan transparansi */
  display: none; /* Kotak konfirmasi disembunyikan secara default */
  justify-content: center; /* Posisi konten secara horizontal di tengah kotak */
  align-items: center; /* Posisi konten secara vertikal di tengah kotak */
    
}

/* Gaya untuk konten dalam kotak konfirmasi */
.confirmation-content {
  background-color: #fff; /* Warna latar belakang konten */
  padding: 20px; /* Jarak antara konten dan batas konten */
  border-radius: 8px; /* Sudut sudut elemen */
  display: flex; /* Mengatur tata letak konten menjadi flexbox */
  flex-direction: column; /* Menata konten menjadi kolom */
  align-items: center; /* Posisi konten secara vertikal di tengah */
  box-shadow: 0px 0px 15px 0px rgba(0,0,0,0.75); /* Bayangan untuk efek visual */
  max-width: 300px; /* Lebar maksimum konten */
  width: 80%; /* Lebar konten */
}

/* Gaya untuk paragraf dalam kotak konfirmasi */
.confirmation-content p {
  margin-bottom: 20px; /* Jarak bawah antara paragraf */
}

/* Gaya untuk tombol dalam kotak konfirmasi */
.confirmation-content button {
  padding: 8px 16px; /* Ukuran padding tombol */
  font-size: 14px; /* Ukuran font tombol */
  color: #fff; /* Warna teks tombol */
  border: none; /* Tanpa garis batas */
  border-radius: 4px; /* Sudut sudut tombol */
  cursor: pointer; /* Menampilkan kursor tangan saat diarahkan ke tombol */
  transition: background-color 0.3s ease; /* Transisi perubahan warna latar belakang */
  margin: 5px; /* Jarak antara tombol */
}

/* Gaya untuk tombol 'Yes' dalam kotak konfirmasi */
.confirm-yes {
  background-color: #666; /* Warna latar belakang untuk tombol 'Yes' */
}

/* Gaya untuk tombol 'No' dalam kotak konfirmasi */
.confirm-no {
  background-color: #ff4d00; /* Warna latar belakang untuk tombol 'No' */
}

/* Gaya untuk tombol logout */
.logout-btn {
  padding: 10px 20px; /* Ukuran padding tombol logout */
  font-size: 16px; /* Ukuran font tombol logout */
  color: #000; /* Warna teks tombol logout */
  border: none; /* Tanpa garis batas */
  border-radius: 4px; /* Sudut sudut tombol logout */
  cursor: pointer; /* Menampilkan kursor tangan saat diarahkan ke tombol logout */
  transition: background-color 0.3s ease; /* Transisi perubahan warna latar belakang */
  margin-bottom: 20px; /* Jarak bawah antara tombol logout dan konten di atasnya */
}
</style>
</head>
<body>
    <!--ini adalah bagian header-->
    <header>
        <div class="container"> <h4> <br>We are open 24 hours, and free delivery throughout the city of Banda Aceh</br> </h4></div>
        <!--ini adalah bagian Navigasi-->
        <nav>
            <div class="rumah">
                <a href=""><img src="media/fotoAceh.png" alt=""></a>
        </div>
            <ul>
                <li><a href="" target="_self">HOME</a></li>
                <li><a href="index.php" target="_self">SHOP</a></li>
                <li><a href="checkout.php">CHECKOUT</a></li>
                <li><a href="#" id="logout-btn" class="logout-btn">LOG OUT</a></li>

            </ul>
        </nav>
        <!--ini adalah akhir dari bagian Navigasi-->
    </header>
    <!--ini adalah akhir dari bagian header-->
<!--ini adalah konten utama-->
<main>
    <div class="confirmation-box" id="confirmationBox">
        <div class="confirmation-content">
          <p>Apakah Anda yakin ingin logout?</p>
          <button id="yes-btn" class="confirm-yes">Iya</button>
          <button id="no-btn" class="confirm-no">Tidak</button>
        </div>
    </div>



    <div class="gambar-container">
            <img src="media/backkk.png" alt="" width="1200px">
    </div>
    <div class="kotakdlmgambar"> 
        <h1>ARTS & CRAFTS SUPPLIES</h1>
        <p>The Most Complete Art Materials & Equipment Shop in The City of Banda Aceh</p>
<a href="index.php"><button class="tombol" >Shop Now</button>
</a>    </div>
    <div class="border"></div>
    <br><br><br>
    <div class="contaa" id="kontak">
        <div>
            <h2><b>SHOP</b></h2><br>
            <a href="index.php" target="_self">Shop</a><br><br><br>
            <a href="More_privasi.html" target="_self">Store Policy</a><br><br>
        </div>
        <div>
            <h2><b>CONTACT</b></h2><br>
            <a href="" target="_blank">Jl. Stadion H Dirmuthala, No.5 Lampinueng. Kota Banda Aceh, Kode Pos: 23125</a><br><br><br>
            <a href="" target="_blank">@acehartsstorecenter</a><br><br><br>
            <a href="" target="_blank">0821-5753-8593</a><br><br>
        </div>
    </div>
</main>
<!--ini adalh akhir dari konten utama-->
    <!--ini adalah bagian footer-->
    <footer>
    <p>&copy;2023 by Aceh Art Store,  </p>
                <div class="link">
                    <a href="" target="_blank"> Tiktok </a>
                    <a href="" target="_blank"> Instagram </a>
                    <a href="" target="_blank"> Facebook </a>
                    <a href="" target="_blank"> Twitter </a>
                </div>
    </footer>
        <!--ini Adalah akhir bagian footer-->
        
        <script>
           // Mengambil elemen tombol logout dan kotak konfirmasi
const logoutBtn = document.getElementById('logout-btn');
const confirmationBox = document.getElementById('confirmationBox');
const yesBtn = document.getElementById('yes-btn');
const noBtn = document.getElementById('no-btn');
const kotakDlmGambar = document.querySelector('.kotakdlmgambar'); // Memilih elemen dengan kelas .kotakdlmgambar

// Saat tombol logout diklik, tampilkan kotak konfirmasi, nonaktifkan penggelapan halaman, dan sembunyikan elemen tertentu
logoutBtn.addEventListener('click', () => {
    confirmationBox.style.display = 'flex'; // Tampilkan kotak konfirmasi
    document.body.style.overflow = 'hidden'; // Nonaktifkan penggelapan halaman
    kotakDlmGambar.style.display = 'none'; // Sembunyikan .kotakdlmgambar saat logout diklik
});

// Jika tombol "Tidak" diklik di kotak konfirmasi, sembunyikan kotak tersebut, aktifkan penggelapan halaman,
noBtn.addEventListener('click', () => {
    confirmationBox.style.display = 'none'; // Sembunyikan kotak konfirmasi
    document.body.style.overflow = 'auto'; // Aktifkan penggelapan halaman
    kotakDlmGambar.style.display = 'block'; // Tampilkan .kotakdlmgambar saat logout dibatalkan
});

// Jika tombol "Ya" diklik di kotak konfirmasi (untuk logout), lakukan logika logout
yesBtn.addEventListener('click', () => {
    // Tambahkan logika logout di sini (contohnya: redirect ke halaman login atau hapus token autentikasi)
    alert('Anda telah logout.'); // Tampilkan pesan logout
    window.location.href = 'logout.php'; // Redirect ke halaman login yang sesuai
});

// Tambahkan event listener pada tombol "Tidak" untuk menyembunyikan kotak konfirmasi dan mengaktifkan penggelapan halaman
noBtn.addEventListener('click', () => {
    confirmationBox.style.display = 'none'; // Sembunyikan kotak konfirmasi
    document.body.style.overflow = 'auto'; // Aktifkan penggelapan halaman
    // window.location.href = 'beranda.html'; // Redirect ke halaman beranda yang sesuai
});
        </script>
</body>
</html>
