<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    /* Mengatur tata letak dan tampilan font dari seluruh halaman */
body {
    font-family: Arial, sans-serif; /* Menggunakan font Arial atau sans-serif jika tidak tersedia */
}

/* Gaya untuk bagian header */
header {
    background-color: #f4f4f4; /* Warna latar belakang header */
    padding: 10px; /* Padding untuk header */
    padding-right: 10px; /* Padding kanan untuk header */
    text-align: center; /* Posisi teks ke tengah */
    margin-top: 1px; /* Jarak atas dari elemen di atasnya */
    height: 100%; /* Tinggi header */
}

/* Gaya untuk kontainer */
.container {
    height: 3rem; /* Tinggi kontainer */
    width: 100%; /* Lebar kontainer */
    background-color: rgb(255, 0, 0); /* Warna latar belakang kontainer */
    color: rgb(0, 0, 0); /* Warna teks pada kontainer */
    text-align: center; /* Posisi teks ke tengah pada kontainer */
}

/* Gaya untuk judul h1 dalam header */
header h1 {
    color: #333; /* Warna teks judul h1 */
    margin-bottom: 10px; /* Jarak bawah dari judul h1 */
}

/* Gaya untuk paragraf dalam header */
header p {
    color: #777; /* Warna teks paragraf dalam header */
    margin-bottom: 20px; /* Jarak bawah dari paragraf dalam header */
}

/* Gaya untuk daftar navigasi */
nav ul {
    list-style-type: none; /* Menghilangkan tanda bullet pada daftar navigasi */
    padding: 10px; /* Padding untuk daftar navigasi */
    text-align: right; /* Posisi teks ke kanan */
}

/* Gaya untuk setiap item daftar navigasi */
nav ul li {
    display: inline; /* Menampilkan item daftar navigasi secara sejajar */
    margin-right: 20px; /* Jarak kanan antara setiap item */
}

/* Gaya untuk tautan di dalam daftar navigasi */
nav ul li a {
    color: #333; /* Warna teks tautan */
    text-decoration: none; /* Menghilangkan garis bawah pada tautan */
}

/* Gaya saat hover pada tautan di dalam daftar navigasi */
nav ul li a:hover {
    color: #ff4d00; /* Warna teks tautan saat hover */
}

/* Gaya untuk gambar di dalam kontainer */
.gambar-container img {
    align-items: center; /* Posisi item ke tengah secara vertikal */
    display: flex; /* Menjadikan tata letak gambar menjadi flexbox */
    margin: auto; /* Mengatur margin secara otomatis untuk pusat horisontal */
}
        
      /* Gaya untuk navigasi */
nav {
    display: flex; /* Menjadikan tata letak flexbox */
    justify-content: space-around; /* Menyebarkan elemen secara merata */
    margin-top: 15px; /* Jarak atas */
}

/* Gaya untuk elemen footer */
footer {
    position: relative; /* Posisi relatif footer */
    bottom: 0; /* Memposisikan footer di bagian bawah */
    height: 3rem; /* Tinggi footer */
    width: 100%; /* Lebar footer */
    background-color: rgb(255, 0, 0); /* Warna latar belakang footer */
    color: rgb(0, 0, 0); /* Warna teks pada footer */
    display: flex; /* Menjadikan tata letak footer menjadi flexbox */
    justify-content: space-between; /* Menyebarkan elemen pada footer secara merata */
}

/* Gaya saat hover pada tautan di dalam elemen footer */
footer a:hover {
    color: white; /* Warna teks saat tautan dihover pada footer */
}

/* Gaya untuk tautan di dalam elemen footer */
footer a {
    text-decoration: none; /* Menghilangkan garis bawah pada tautan footer */
    line-height: 50px; /* Jarak vertikal antara baris dalam tautan footer */
    color: #000; /* Warna teks pada tautan footer */
    padding-right: 25px; /* Padding kanan pada tautan footer */
}

/* Gaya untuk paragraf dalam elemen footer */
footer p1 {
    padding-left: 25px; /* Padding kiri pada paragraf dalam footer */
    line-height: 40px; /* Jarak vertikal antara baris dalam paragraf footer */
}

/* Gaya untuk menambahkan garis bawah */
.border {
    border-bottom: 3px solid black; /* Garis bawah dengan ketebalan 3px */
    margin-top: 20px; /* Jarak atas dari elemen di atasnya */
}

/* Gaya untuk paragraf */
p {
    width: 100%; /* Lebar maksimum paragraf */
    max-width: 500px; /* Lebar maksimum paragraf */
    text-align: center; /* Posisi teks ke tengah */
    margin: 0 auto; /* Pusatkan paragraf secara horizontal */
}

/* Gaya untuk elemen dengan kelas 'contaa' */
.contaa {
    height: 3rem; /* Tinggi elemen 'contaa' */
    width: 100%; /* Lebar elemen 'contaa' */
    background-color: rgb(255, 255, 255); /* Warna latar belakang elemen 'contaa' */
    color: rgb(0, 0, 0); /* Warna teks pada elemen 'contaa' */
    text-transform: capitalize; /* Mengubah teks menjadi huruf kapital pada awal kata */
}

/* Gaya untuk paragraf dalam elemen 'contaa' */
.contaa p {
    margin-left: 51px; /* Margin kiri pada paragraf dalam elemen 'contaa' */
}

/* Gaya untuk judul h2 dalam elemen 'contaa' */
.contaa h2 {
    margin-left: 270px; /* Margin kiri pada judul h2 dalam elemen 'contaa' */
}
        
    </style>
</head>
<body>
    <header>
        <div class="container"> <h4> <br>We are open 24 hours, and free delivery throughout the city of Banda Aceh</br> </h4></div>
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
    <br>

    <div class="border"></div>
    <h2 style="text-align: center;">Privacy Policies</h2>
    <div class="border"></div><br>
    <p> You may consult this list to find the Privacy Policy for each of the advertising partners of Aceh Arts Store Center.
        Third-party ad servers or ad networks uses technologies like cookies, JavaScript, or Web Beacons that are used in their respective advertisements and links 
        that appear on Aceh Arts Store Center, which are sent directly to users' browser. They 
        automatically receive your IP address when this occurs. These technologies are used to measure the effectiveness of their advertising campaigns and/or to 
        personalize the advertising content that you see on websites that you visit.
        Note that Aceh Arts Store Center has no access to or control over these cookies that are used by third-party advertisers.</p>
        <br>
    <div class="border"></div>
    <h2 style="text-align: center;">Third Party Privacy Policies</h2>
    <div class="border"></div><br>

    <p>Aceh Arts Store Center's Privacy Policy does not apply to other advertisers or websites. Thus, we are 
        advising you to consult the respective Privacy Policies of these third-party ad servers for more detailed 
        information. It may include their practices and instructions about how to opt-out of certain options. </p>

    <p>You can choose to disable cookies through your individual browser options. To know more detailed information 
        about cookie management with specific web browsers, it can be found at the browsers' respective websites. 
        What Are Cookies?</p><br>

        <div class="border"></div>
    <h2 style="text-align: center;">Children's Information</h2>
    <div class="border"></div><br>

    <p>Another part of our priority is adding protection for children while using the internet. We encourage parents 
        and guardians to observe, participate in, and/or monitor and guide their online activity.</p>

<p>Aceh Arts Store Center does not knowingly collect any Personal Identifiable Information from children under the age 
    of 13. If you think that your child provided this kind of information on our website, we strongly encourage you to 
    contact us immediately and we will do our best efforts to promptly remove such information from our records.</p><br>

    <div class="border"></div>
    <h2 style="text-align: center;">Online Privacy Policy Only</h2>
    <div class="border"></div><br>
    
    <p>This Privacy Policy applies only to our online activities and is valid for visitors to our website with 
        regards to the information that they shared and/or collect in Aceh Arts Store Center. This policy is not 
        applicable to any information collected offline or via channels other than this website.</p><br>

        <div class="border"></div>
        <br>
    <div class="border"></div><br><br>


    
    <footer>
        <P1> &copy;2023 by Aceh Art Store, </P1>
    

                
        <div class="link">
        <a href="https://www.tiktok.com/@vartune" target="_blank"> Tiktok </a>
        <a href="https://www.tiktok.com/@vartune" target="_blank"> Instagram </a>
        <a href="https://www.tiktok.com/@vartune" target="_blank"> Facebook </a>
        <a href="https://www.tiktok.com/@vartunen" target="_blank"> Twitter </a>
    </div>
    
        
        </footer>
</body>
</html>