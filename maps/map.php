<?php
require_once 'db.php';

// Cek apakah sesi sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fungsi untuk mengecek izin berdasarkan role_id
function checkPermission($role_id, $requiredRole)
{
    return $role_id == $requiredRole;
}

// Tentukan status login
$isLoggedIn = isset($_SESSION['user_id']);

// Inisialisasi izin default
$canAddDeleteUpdate = false;
$canViewOnly = false;

// Periksa apakah pengguna sudah login dan tentukan izin
if ($isLoggedIn && isset($_SESSION['role_id'])) {
    $role_id = $_SESSION['role_id'];
    $canAddDeleteUpdate = checkPermission($role_id, 2); // Izin tambah/hapus/update
    $canViewOnly = checkPermission($role_id, 3); // Izin hanya melihat
}

// Ambil data marker dari database
$markers = array();
try {
    $sql = "SELECT id, lat, lng, title, linkurl, tentang, alamat, user_id FROM koordinat";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $markers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Jika terjadi error pada query, tampilkan pesan kesalahan
    die("Error: " . $e->getMessage());
}

// Mengirimkan data pengguna ke JavaScript
echo '<script>';
echo 'var isLoggedIn = ' . json_encode($isLoggedIn) . ';';
echo 'var canAddDeleteUpdate = ' . json_encode($canAddDeleteUpdate) . ';';
echo 'var canViewOnly = ' . json_encode($canViewOnly) . ';';
if ($isLoggedIn) {
    echo 'var loggedInUserId = ' . json_encode($_SESSION['user_id']) . ';';
} else {
    echo 'var loggedInUserId = null;';
}
echo '</script>';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maps Sekolah di Banda Aceh</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css" />

    <!-- Scripts -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <script src="https://unpkg.com/leaflet.heat/dist/leaflet-heat.js"></script>

    <script>
        // Pass PHP variables to JavaScript
        var isLoggedIn = <?php echo json_encode($isLoggedIn); ?>;
        var canAddDeleteUpdate = <?php echo json_encode($canAddDeleteUpdate); ?>;
        var canViewOnly = <?php echo json_encode($canViewOnly); ?>;

        console.log(isLoggedIn);
        console.log(canAddDeleteUpdate);
        console.log(canViewOnly);
    </script>
    <style>
        #map {
            height: 100vh;
            width: 100vw;
            position: absolute;
            top: 0;
            left: 0;
        }

        .sidebar {
            width: 500px;
            height: 100vh;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.5);
            position: fixed;
            top: 0;
            left: -500px;
            transition: left 0.3s ease;
            z-index: 10000;
            overflow-y: auto;

        }

        .sidebar.open {
            left: 0;
        }

        .carddd {
            position: absolute;
            top: 50px;
            right: 10px;
            width: 300px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            display: none;
        }

        .carddd span {
            line-height: 20px;
        }

        #selectContainer {
            margin: 20px;
        }

        #radiusContent,
        #markersContent {
            margin: 20px;
        }

        .card {
            position: relative;
            width: 300px;
            height: 200px;
            background-color: #f2f2f2;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            perspective: 1000px;
            box-shadow: 0 0 0 5px #ffffff80;
            transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            margin: 10px;
        }

        .card svg {
            width: 48px;
            fill: #333;
            transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(255, 255, 255, 0.2);
        }

        .card__content {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            padding: 20px;
            box-sizing: border-box;
            background-color: #f2f2f2;
            transform: rotateX(-90deg);
            transform-origin: bottom;
            transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .card:hover .card__content {
            transform: rotateX(0deg);
        }

        .card__title {
            margin: 0;
            font-size: 24px;
            color: #333;
            font-weight: 700;
        }

        .card:hover svg {
            scale: 0;
        }

        .card__description {
            margin: 10px 0 0;
            font-size: 14px;
            color: #777;
            line-height: 1.4;
        }

        .animated-button {
            position: relative;
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background: #ff4757;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            overflow: hidden;
            transition: background 0.3s ease;
        }

        .animated-button .text {
            position: relative;
            z-index: 2;
        }

        .animated-button .circle {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 300%;
            height: 300%;
            background: #ff6b81;
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(0);
            transition: transform 0.5s ease;
            z-index: 1;
        }

        .animated-button:hover .circle {
            transform: translate(-50%, -50%) scale(1);
        }

        .animated-button svg {
            position: absolute;
            width: 24px;
            height: 24px;
            fill: #fff;
            transition: transform 0.3s ease;
        }

        .animated-button .arr-1 {
            left: 10px;
        }

        .animated-button .arr-2 {
            right: 10px;
        }

        .animated-button:hover .arr-1 {
            transform: translateX(-5px);
        }

        .animated-button:hover .arr-2 {
            transform: translateX(5px);
        }

        .button99 {
            height: 35px;
            padding: 7px 18px;
            border: unset;
            border-radius: 15px;
            color: #212121;
            z-index: 1;
            background: #e8e8e8;
            position: relative;
            font-weight: 1000;
            font-size: 13px;
            -webkit-box-shadow: 4px 8px 19px -3px rgba(0, 0, 0, 0.27);
            box-shadow: 4px 8px 19px -3px rgba(0, 0, 0, 0.27);
            transition: all 250ms;
            overflow: hidden;
            text-align: center;
            line-height: 10px;
            margin: 1px;
            justify-content: center;
            align-items: center;
            top: 10px;
        }

        .button99::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 0;
            border-radius: 15px;
            background-color: #212121;
            z-index: -1;
            -webkit-box-shadow: 4px 8px 19px -3px rgba(0, 0, 0, 0.27);
            box-shadow: 4px 8px 19px -3px rgba(0, 0, 0, 0.27);
            transition: all 250ms;
        }

        .button99:hover {
            color: #e8e8e8;
        }

        .button99:hover::before {
            width: 100%;
        }

        .btn {
            width: 150px;
            height: 50px;
            border-radius: 5px;
            border: none;
            transition: all 0.5s ease-in-out;
            font-size: 20px;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-weight: 600;
            display: flex;
            align-items: center;
            background: #040f16;
            color: #f5f5f5;
            position: absolute;
            top: 20px;
            left: 55px;
            z-index: 10008;
        }

        .btn:hover {
            box-shadow: 0 0 20px 0px #2e2e2e3a;
        }

        .btn .icon {
            position: absolute;
            height: 40px;
            width: 70px;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: all 0.5s;
        }

        .btn .text {
            transform: translateX(55px);
        }

        .btn:hover .icon {
            width: 175px;
        }

        .btn:hover .text {
            transition: all 0.5s;
            opacity: 0;
        }

        .btn:focus {
            outline: none;
        }

        .btn:active .icon {
            transform: scale(0.85);
        }

        .group {
            display: flex;
            line-height: 28px;
            align-items: center;
            position: relative;
            max-width: 300px;
            z-index: 10000;
            margin-left: 35px;
            margin-top: 30px;
        }

        .input {
            width: 305px;
            height: 40px;
            line-height: 28px;
            padding: 0 1rem;
            padding-left: 2.5rem;
            border: 2px solid transparent;
            border-radius: 8px;
            outline: none;
            background-color: #f3f3f4;
            color: #0d0c22;
            transition: 0.3s ease;

        }

        .input::placeholder {
            color: #9e9ea7;
        }

        .input:focus,
        input:hover {
            outline: none;
            border-color: rgba(0, 48, 73, 0.4);
            background-color: #fff;
            box-shadow: 0 0 0 4px rgb(0 48 73 / 10%);
        }

        .icon {
            position: absolute;
            left: 13px;
            fill: #9e9ea7;
            width: 1rem;
            height: 1rem;

        }

        .icon67 {
            position: absolute;
            left: 13px;
            fill: #9e9ea7;
            width: 1rem;
            height: 1rem;

        }

        .options-container {
            position: absolute;
            left: 0;      
            top: 100%;
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
            background-color: #fff;
            border: 2px solid rgba(0, 48, 73, 0.4);
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            display: none;
        }

        .option {
            padding: 10px 1rem;
            cursor: pointer;
            color: #0d0c22;
            transition: background-color 0.3s ease;
        }

        .option:hover {
            background-color: rgba(0, 48, 73, 0.1);
        }

        .button2 {
            background-color: transparent;
            border: none;
            padding: 10px;
            cursor: pointer;
            display: inline-block;
            position: absolute;
            top: 10px;
            right: 18px;
            z-index: 1000;
        }

        .dots {
            display: grid;
            grid-template-columns: repeat(3, auto);
            gap: 2px;
            width: 16px;
            height: 16px;
        }

        .dot {
            width: 6px;
            height: 6px;
            background-color: black;
            border-radius: 50%;
        }
        .cardd {
            width: 280px;
            height: 280px;
            left: 1400px;
            top: 40px;
            background: white;
            border-radius: 32px;
            padding: 3px;
            position: relative;
            box-shadow: #604b4a30 0px 70px 30px -50px;
            transition: all 0.5s ease-in-out;
            z-index: 10000;
        }

        .cardd .mail {
            position: absolute;
            right: 2rem;
            top: 1.4rem;
            background: transparent;
            border: none;
        }

        .cardd .mail svg {
            stroke: #fbb9b6;
            stroke-width: 3px;
        }

        .cardd .mail svg:hover {
            stroke: #f55d56;
        }

        .cardd .profile-pic {
            position: absolute;
            width: calc(100% - 6px);
            height: calc(100% - 6px);
            top: 3px;
            left: 3px;
            border-radius: 29px;
            z-index: 1;
            border: 0px solid #fbb9b6;
            overflow: hidden;
            transition: all 0.5s ease-in-out 0.2s, z-index 0.5s ease-in-out 0.2s;
        }

        .cardd .profile-pic img {
            -o-object-fit: cover;
            object-fit: cover;
            width: 100%;
            height: 100%;
            -o-object-position: 0px 0px;
            object-position: 0px 0px;
            transition: all 0.5s ease-in-out 0s;
        }

        .cardd .profile-pic svg {
            width: 100%;
            height: 100%;
            -o-object-fit: cover;
            object-fit: cover;
            -o-object-position: 0px 0px;
            object-position: 0px 0px;
            transform-origin: 45% 20%;
            transition: all 0.5s ease-in-out 0s;
        }

        .cardd .bottom {
            position: absolute;
            bottom: 3px;
            left: 3px;
            right: 3px;
            background: #fbb9b6;
            top: 80%;
            border-radius: 29px;
            z-index: 2;
            box-shadow: rgba(96, 75, 74, 0.1882352941) 0px 5px 5px 0px inset;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.645, 0.045, 0.355, 1) 0s;
        }

        .cardd .bottom .content {
            position: absolute;
            bottom: 0;
            left: 1.5rem;
            right: 1.5rem;
            height: 160px;
        }

        .cardd .bottom .content .name {
            display: block;
            font-size: 1.2rem;
            color: white;
            font-weight: bold;
        }

        .cardd .bottom .content .about-me {
            display: block;
            font-size: 0.9rem;
            color: white;
            margin-top: 1rem;
        }

        .cardd .bottom .bottom-bottom {
            position: absolute;
            bottom: 1rem;
            left: 1.5rem;
            right: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .cardd .bottom .bottom-bottom .social-links-container {
            display: flex;
            gap: 1rem;
        }

        .cardd .bottom .bottom-bottom .social-links-container svg {
            height: 20px;
            fill: white;
            filter: drop-shadow(0 5px 5px rgba(165, 132, 130, 0.1333333333));
        }

        .cardd .bottom .bottom-bottom .social-links-container svg:hover {
            fill: #f55d56;
            transform: scale(1.2);
        }

        .cardd .bottom .bottom-bottom .button {
            background: white;
            color: #fbb9b6;
            border: none;
            border-radius: 20px;
            font-size: 0.6rem;
            padding: 0.4rem 0.6rem;
            box-shadow: rgba(165, 132, 130, 0.1333333333) 0px 5px 5px 0px;
        }

        .cardd .bottom .bottom-bottom .button:hover {
            background: #f55d56;
            color: white;
        }

        .cardd:hover {
            border-top-left-radius: 55px;
        }

        .cardd:hover .bottom {
            top: 20%;
            border-radius: 80px 29px 29px 29px;
            transition: all 0.5s cubic-bezier(0.645, 0.045, 0.355, 1) 0.2s;
        }

        .cardd:hover .profile-pic {
            width: 100px;
            height: 100px;
            aspect-ratio: 1;
            top: 10px;
            left: 10px;
            border-radius: 50%;
            z-index: 3;
            border: 7px solid #fbb9b6;
            box-shadow: rgba(96, 75, 74, 0.1882352941) 0px 5px 5px 0px;
            transition: all 0.5s ease-in-out, z-index 0.5s ease-in-out 0.1s;
        }

        .cardd:hover .profile-pic:hover {
            transform: scale(1.3);
            border-radius: 0px;
        }

        .cardd:hover .profile-pic img {
            transform: scale(2.5);
            -o-object-position: 0px 25px;
            object-position: 0px 25px;
            transition: all 0.5s ease-in-out 0.5s;
        }

        .cardd:hover .profile-pic svg {
            transform: scale(2.5);
            transition: all 0.5s ease-in-out 0.5s;
        }
    </style>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div id="sidebar-container">
        <div id="mySidebar" class="sidebar">
            <div class="group">
                <svg viewBox="0 0 24 24" aria-hidden="true" class="icon67">
                    <g>
                        <path
                            d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z">
                        </path>
                    </g>
                </svg>
                <input class="input" type="search" placeholder="Rute ke..." id="schoolFilterInput" autocomplete="off" />
                <div id="options" class="options-container" style="display: none;">
                    <!-- Opsi akan muncul di sini berdasarkan input -->
                </div>
            </div>


            <div id="radiusContent">
                <h2>Daftar tempat didalam radius</h2>
                <p id="noRadiusMessage">Tidak ada radius...</p>
            </div>
            <div id="markersContent">
                <h2>Daftar Tempat</h2>
            </div>
        </div>
    </div>
    <button id="toggleButton" class="openbtn btn" onclick="toggleSidebar()">
        <span class="icon">
            <svg viewBox="0 0 175 80" width="40" height="40">
                <rect width="80" height="15" fill="#f0f0f0" rx="10"></rect>
                <rect y="30" width="80" height="15" fill="#f0f0f0" rx="10"></rect>
                <rect y="60" width="80" height="15" fill="#f0f0f0" rx="10"></rect>
            </svg>
        </span>
        <span class="text">MENU</span>
    </button>

    <div id="map"></div>

    <button class="userbtn button2">
        <div class="dots">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </button>

    <div id="dynamicCard" class="cardd" style="display: none;">
        <button class="mail">
            <svg class="lucide lucide-mail" stroke-linejoin="round" stroke-linecap="round" stroke-width="2" stroke="currentColor" fill="none" viewBox="0 0 24 24" height="24" width="24" xmlns="http://www.w3.org/2000/svg">
                <rect rx="2" y="4" x="2" height="16" width="20"></rect>
                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
            </svg>
        </button>
        <img src="user2.png" alt="Profile Picture" class="profile-pic" />
        <div class="bottom">
            <div class="content">
                <span id="username" class="name">Loading</span>
                <span class="about-me"> saya adalah orang yang mengujungi web ini </span>
            </div>
            <div class="bottom-bottom">
                <div class="social-links-container">
                    <svg viewBox="0 0 16 15.999" height="15.999" width="16" xmlns="http://www.w3.org/2000/svg">
                        <path transform="translate(6 598)" d="M6-582H-2a4,4,0,0,1-4-4v-8a4,4,0,0,1,4-4H6a4,4,0,0,1,4,4v8A4,4,0,0,1,6-582ZM2-594a4,4,0,0,0-4,4,4,4,0,0,0,4,4,4,4,0,0,0,4-4A4.005,4.005,0,0,0,2-594Zm4.5-2a1,1,0,0,0-1,1,1,1,0,0,0,1,1,1,1,0,0,0,1-1A1,1,0,0,0,6.5-596ZM2-587.5A2.5,2.5,0,0,1-.5-590,2.5,2.5,0,0,1,2-592.5,2.5,2.5,0,0,1,4.5-590,2.5,2.5,0,0,1,2-587.5Z" data-name="Subtraction 4" id="Subtraction_4"></path>
                    </svg>
                    <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                        <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"></path>
                    </svg>
                    <svg width="24px" height="24px" viewBox="0 0 24 24" role="img" xmlns="http://www.w3.org/2000/svg">
                        <title>WhatsApp icon</title>
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                    </svg>
                </div>
                <button class="button">Logout</button>
            </div>
        </div>
    </div>

    <script>
        var map = L.map('map').setView([5.547303342864643, 95.32330618243087], 13);
        var currentRouteControl = null;
        var markerCircles = {};
        var schoolMarkers = [];
        var activeRouteControl = null;

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var satelliteLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; Satellite Layer'
        });

        var topoLayer = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenTopoMap contributors'
        });

        var baseMaps = {
            "Streets": streetLayer,
            "Satellite": satelliteLayer,
            "Topography": topoLayer,
        };

        // Menambahkan control layers di sudut kanan bawah
        L.control.layers(baseMaps, null, {
            position: 'bottomright'
        }).addTo(map);

        var trafficLayer = L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
            attribution: 'Traffic Data &copy; OpenStreetMap contributors'
        }).addTo(map);

        var markersCluster = L.markerClusterGroup();

        function toggleSidebar() {
            var sidebar = document.getElementById("sidebar");
            if (sidebar.style.width === "250px") {
                sidebar.style.width = "0";
            } else {
                sidebar.style.width = "250px";
            }
        }

        document.querySelector('.userbtn').addEventListener('click', function() {
            var existingCard = document.getElementById('dynamicCard');
            if (existingCard.style.display === 'block') {
                existingCard.style.display = 'none';
                return;
            }

            existingCard.style.display = 'block';

            fetch('getUsername.php')
                .then(response => response.json())
                .then(username => {
                    document.getElementById('username').textContent = username;
                })
                .catch(error => {
                    console.error('Error fetching username:', error);
                    document.getElementById('username').textContent = 'Error';
                });
        });


        document.querySelector('.button').addEventListener('click', function() {

            if (isLoggedIn) {

                Swal.fire({
                    title: 'Konfirmasi Logout',
                    text: 'Apakah Anda yakin ingin logout?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Logout',
                    cancelButtonText: 'Tidak, Kembali'
                }).then((result) => {
                    if (result.isConfirmed) {

                        fetch('logout.php')
                            .then(response => {
                                if (response.ok) {
                                    window.location.href = 'login.php'; // Alihkan ke halaman login setelah logout
                                } else {
                                    alert('Logout failed'); // Pesan jika logout gagal
                                }
                            })
                            .catch(error => {
                                console.error('Error during logout:', error); // Tampilkan error jika ada
                            });
                    }
                    // Jika pengguna memilih untuk tidak logout, tidak melakukan apa-apa
                });
            } else {
                // Tampilkan SweetAlert jika belum login
                Swal.fire({
                    icon: "warning",
                    title: "GAGAL",
                    text: "Anda belum login",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Login",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'login.php'; // Arahkan ke halaman login jika mengkonfirmasi
                    }
                });
            }
        });
        
        var sidebarOpen = false;

        function toggleSidebar() {
            var sidebar = document.getElementById("mySidebar");
            var button = document.getElementById("toggleButton");

            if (sidebarOpen) {
                sidebar.style.left = "-500px";
                button.classList.remove('opened');
                button.style.left = "55px"; // Posisi tombol saat sidebar tertutup
                sidebarOpen = false;
            } else {
                sidebar.style.left = "0";
                button.classList.add('opened');
                button.style.left = "520px"; // Posisi tombol saat sidebar terbuka
                sidebarOpen = true;
            }
        }

        var allMarkers = [];

        fetch('getMarkers.php')
            .then(response => response.json())
            .then(data => {
                allMarkers = data; // Simpan data markers ke variabel global
                data.forEach(marker => {
                    console.log(marker.linkgambar);
                    createMarker(marker.id, marker.lat, marker.lng, marker.title, marker.linkurl, marker.tentang, marker.alamat, marker.user_id, marker.linkgambar);
                });
            })
            .catch(error => console.error('Error:', error));

        var markersCluster = L.markerClusterGroup({
            iconCreateFunction: function(cluster) {
                var count = cluster.getChildCount();
                return L.divIcon({
                    html: `<div style="position: relative; display: inline-block;">
                     <span style="background-color: rgba(0, 0, 0, 0.6); color: white; padding: 5px 10px; border-radius: 50%;">${count}</span>
                     <img src="location.png" alt="marker" style="width: 25px; height: 41px; position: absolute; top: 0; right: -15px;">
                   </div>`,
                    className: 'custom-cluster-icon',
                    iconSize: [40, 40],
                });
            }
        });

        let userHasUpdatedMarker = false;
        // Pastikan loggedInUserId terdefinisi di awal

        // Fungsi untuk membuat marker
        function createMarker(id, lat, lng, title, linkurl, tentang, alamat, user_Id, linkgambar) {
            if (!linkgambar || linkgambar.trim() === '') {
                linkgambar = 'download.phg'; // Ganti dengan URL gambar default
            }

            var customIcon = L.divIcon({
                className: 'custom-icon',
                html: `<div>
                <img src="location.png" alt="${title}" style="width: 25px; height: 41px; border-radius: 10px;">
               </div>
               <div class="marker-title" style="max-width: 125px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: inline-block;">${title}</div>`,
                iconSize: [25, 66],
                iconAnchor: [12, 66]
            });

            // Membuat marker baru
            var marker = L.marker([lat, lng], {
                icon: customIcon,
                title: title,
                alamat: alamat,
                tentang: tentang,
                linkgambar: linkgambar
            });
            marker.id = id;
            marker.bindTooltip(title);

            var popupContent = `<div class="popup-content">
                            <img src="${linkgambar}" alt="${title}" style="width: 285px; height: 200px; border-radius: 10px;">
                            <br>
                            <b>${title}</b><br>
                            <p>${tentang}</p><br>
                            <p>${alamat}</p><br>
                            <a class="menu__link" href="${linkurl}" target="_blank">Lihat Lokasi</a><br>
                            <br>
                            <input class="input" type="number" id="radiusInput${lat}-${lng}" value="1000" placeholder="Masukkan radius (meter)"><br>
                            <button class="button99" onclick="toggleRadius(${lat}, ${lng})">Tampilkan Radius</button>
                            <button class="button99" onclick="removeRadius(${lat}, ${lng})">Hapus Radius</button>
                            <button class="button99" onclick="showClosestOrRouteToSchool(${lat}, ${lng})">Rute</button>
                            <button class="button99" onclick="manageRoute('remove')">Hapus Rute</button><br>
                            <br>
                        </div>`;

            if (isLoggedIn) {

                if (canAddDeleteUpdate) {
                    popupContent += `
            <button class="button99" onclick="deleteMarker(${lat}, ${lng})">Hapus Marker</button>
            <button class="button99" onclick="update(${id}, ${lat}, ${lng}, '${title.replace(/'/g, "\\'")}', '${linkurl}', '${tentang.replace(/'/g, "\\'")}', '${alamat.replace(/'/g, "\\'")}', '${linkgambar.replace(/'/g, "\\'")}')">Update data</button><br>`;
                } else if (canViewOnly) {

                    if (loggedInUserId && user_Id == loggedInUserId && !userHasUpdatedMarker) {

                        popupContent += `
        <button class="button99" onclick="noakses(${lat}, ${lng})">Hapus Marker</button>
        <button class="button99" onclick="update(${id}, ${lat}, ${lng}, '${title.replace(/'/g, "\\'")}', '${linkurl}', '${tentang.replace(/'/g, "\\'")}', '${alamat.replace(/'/g, "\\'")}', '${linkgambar.replace(/'/g, "\\'")}')">Update data</button><br>`;

                        userHasUpdatedMarker = true;
                    } else {
                        popupContent += `
        <button class="button99" readonly onclick="noakses(${lat}, ${lng})">Hapus Marker</button>
        <button class="button99" readonly onclick="noakses(${lat}, ${lng})">Update data</button><br>`;
                    }
                }
            } else {
                popupContent += `
        <button class="button99" onclick="noakses(${lat}, ${lng})">Hapus Marker</button>
        <button class="button99" onclick="noakses(${lat}, ${lng})">Update data</button><br>`;
            }
            // Simpan ID pada marker untuk referensi


            // Tambahkan konten popup
            popupContent += `</div>`;
            marker.bindPopup(popupContent);

            // Tambahkan marker ke cluster
            markersCluster.addLayer(marker);
            schoolMarkers.push({
                lat,
                lng,
                marker
            });
            return marker;
        }

        // Tambahkan marker cluster ke peta
        map.addLayer(markersCluster);

        function noakses(lat, lng) {
            Swal.fire({
                icon: "warning",
                title: "Oops...",
                text: "Anda tidak memiliki akses",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Login",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "login.php";
                }
            });
        }

        function update(id, lat, lng, title, linkurl, tentang, alamat, linkgambar) {
            Swal.fire({
                title: 'Update Marker',
                html: `
            <form id="markerForm">
                <input type="hidden" name="id" value="${id}">
                <input class="input" type="text" name="lat" value="${lat}" placeholder="Masukkan Latitude (contoh: 5.551388)" required><br>
                <input class="input" type="text" name="lng" value="${lng}" placeholder="Masukkan Longitude (contoh: 95.356225)" required><br>
                <input class="input" type="text" name="title" value="${title}" placeholder="Masukkan Title" required><br>
                <input class="input" type="text" name="linkurl" value="${linkurl}" placeholder="Masukkan Link URL" required><br>
                <input class="input" type="text" name="tentang" value="${tentang}" placeholder="Masukkan Data Tempat" required><br>
                <input class="input" type="text" name="alamat" value="${alamat}" placeholder="Masukkan Alamat" required><br>
                <input class="input" type="text" name="linkgambar" value="${linkgambar}" placeholder="Masukkan link Gambar" required><br>
                <button class="button99" type="submit">Submit</button>
            </form>
        `,
                showConfirmButton: false,
                didOpen: () => {
                    document.getElementById('markerForm').addEventListener('submit', function(e) {
                        e.preventDefault();
                        console.log(id, lat, lng, title, linkurl, tentang, alamat, linkgambar);
                        var formData = new FormData(this);
                        var id = formData.get('id');
                        var newLat = parseFloat(formData.get('lat').replace(',', '.'));
                        var newLng = parseFloat(formData.get('lng').replace(',', '.'));
                        var newTitle = formData.get('title');
                        var newLinkurl = formData.get('linkurl');
                        var newTentang = formData.get('tentang');
                        var newAlamat = formData.get('alamat');
                        var newLinkgambar = formData.get('linkgambar');

                        if (!id || isNaN(newLat) || isNaN(newLng) || !newTitle || !newLinkurl || !newTentang || !newAlamat || !newLinkgambar) {
                            Swal.fire('Gagal!', 'Semua bidang harus diisi dengan benar.', 'error');
                            return;
                        }

                        updateMarkerForm(id, newLat, newLng, newTitle, newLinkurl, newTentang, newAlamat, newLinkgambar);
                    });
                }
            });
        }

        function updateMarkerForm(id, newLat, newLng, newTitle, newLinkurl, newTentang, newAlamat, newLinkgambar) {
            const Data = {
                id: id,
                lat: newLat,
                lng: newLng,
                title: newTitle,
                linkurl: newLinkurl,
                tentang: newTentang,
                alamat: newAlamat,
                linkgambar: newLinkgambar
            };

            fetch('update.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(Data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Berhasil!', 'Marker berhasil diperbarui.', 'success').then(() => {
                            resetMap();
                        });
                    } else {
                        Swal.fire('Gagal!', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat menyimpan data.', 'error');
                });
        }

        function routeToMarker(lat, lng) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var userLat = position.coords.latitude;
                    var userLng = position.coords.longitude;

                    // Hapus rute yang aktif sebelumnya jika ada
                    clearActiveRoute();

                    // Buat kontrol rute baru
                    activeRouteControl = L.Routing.control({
                        waypoints: [
                            L.latLng(userLat, userLng),
                            L.latLng(lat, lng)
                        ],
                        routeWhileDragging: true
                    }).addTo(map);

                    var marker = schoolMarkers.find(marker => marker.lat === lat && marker.lng === lng);
                    if (marker) {
                        marker.marker.closePopup();
                    }
                });
            } else {
                alert("Geolocation tidak didukung oleh browser ini.");
            }
        }

        function deleteMarker(lat, lng) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('getMarkers.php', {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                lat,
                                lng
                            }),
                        })
                        .then(response => {
                            if (response.ok) {
                                return response.json();
                            } else {
                                throw new Error('Network response was not ok');
                            }
                        })
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Berhasil!', 'Marker berhasil dihapus.', 'success')
                                    .then(() => {
                                        resetMap();
                                    });
                            } else {
                                Swal.fire('Gagal!', data.message, 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus marker.', 'error');
                        });
                }
            });
        }

        L.Control.Locate = L.Control.extend({
            onAdd: function(map) {
                // Buat elemen tombol dengan class 'leaflet-control-locate' dan 'button99'
                var btn = L.DomUtil.create('button', 'leaflet-control-locate button99');
                btn.innerHTML = 'Lokasi Saya';
                btn.style.cursor = 'pointer';
                btn.style.position = 'relative'; // Pastikan posisi absolut
                btn.style.left = '5px'; // Jarak 5px dari kiri
                btn.style.bottom = '10px';
                btn.style.zIndex = '19999';

                // Variabel untuk menyimpan marker lokasi pengguna
                var userLocationMarker;

                L.DomEvent.on(btn, 'click', function() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                            var latitude = position.coords.latitude;
                            var longitude = position.coords.longitude;

                            // Hapus marker sebelumnya, jika ada
                            if (userLocationMarker) {
                                map.removeLayer(userLocationMarker);
                            }

                            // Menambahkan marker lokasi pengguna dengan ikon custom
                            var userIcon = L.icon({
                                iconUrl: 'position.png', // Ganti dengan path yang sesuai untuk ikon
                                iconSize: [51, 51],
                                iconAnchor: [24, 41],
                                popupAnchor: [1, -34],
                                shadowSize: [41, 41]
                            });

                            userLocationMarker = L.marker([latitude, longitude], {
                                icon: userIcon
                            }).addTo(map);
                            userLocationMarker.bindPopup(`
                        Anda berada di sini!<br>
                        <input class="input" type="number" id="radiusInput${latitude}-${longitude}" value="1000" placeholder="Masukkan radius (meter)"><br>
                        <button class="button99" onclick="toggleRadius(${latitude}, ${longitude})">Tampilkan Radius</button>
                        <button class="button99" onclick="removeRadius()">Hapus Radius</button>
                    `).openPopup();

                            // Atur tampilan peta ke lokasi pengguna
                            map.setView([latitude, longitude], 14);

                            // Setup listener untuk input radius
                            setupRadiusInputListener(latitude, longitude);
                        }, function(err) {
                            console.warn(`ERROR(${err.code}): ${err.message}`);
                        }, {
                            enableHighAccuracy: true,
                            maximumAge: 0
                        });
                    } else {
                        alert("Geolocation tidak didukung di browser ini.");
                    }
                });

                return btn;
            }
        });

        // Tambahkan kontrol lokasi ke peta di posisi kiri bawah
        L.control.locate = function(opts) {
            return new L.Control.Locate(opts);
        };

        L.control.locate({
            position: 'bottomleft'
        }).addTo(map);

        // Menggunakan id yang sama dengan yang ada di HTML
        var sidebar = document.getElementById('mySidebar');

        var radiusCircle = null;
        var titlesInRadius = [];
        var markersInRadius = []; // Array untuk menyimpan data marker dalam radius

        function toggleRadius(lat, lng) {
            var radiusInput = document.getElementById('radiusInput' + lat + '-' + lng);
            var radius = parseInt(radiusInput ? radiusInput.value : 500);

            if (isNaN(radius) || radius <= 0) {
                alert("Radius harus berupa angka positif.");
                return;
            }

            if (radiusCircle) {
                removeRadius();
                return;
            }

            markersInRadius = []; // Kosongkan array sebelum menambah data baru

            radiusCircle = L.circle([lat, lng], {
                radius: radius,
                color: 'blue',
                opacity: 0.5,
                fillOpacity: 0.2
            }).addTo(map);

            map.eachLayer(function(layer) {
                if (layer instanceof L.Marker) {
                    var markerLatLng = layer.getLatLng();
                    var distance = markerLatLng.distanceTo([lat, lng]);
                    var distanceToCenter = distance > 1000 ?
                        (distance / 1000).toFixed(2) + ' km' :
                        distance.toFixed(2) + ' meters';

                    if (distance <= radius) {
                        var title = layer.options.title || (layer.getTooltip && layer.getTooltip() ? layer.getTooltip().getContent() : '');
                        var tentang = layer.options.tentang;
                        var alamat = layer.options.alamat;
                        var markerId = layer.options.markerId;

                        if (title) {
                            markersInRadius.push({
                                Id: markerId,
                                title: title.trim(),
                                tentang: tentang,
                                alamat: alamat,
                                linkgambar: layer.options.linkgambar, // Pastikan linkgambar tersedia
                                lat: markerLatLng.lat,
                                lng: markerLatLng.lng,
                                distance: distanceToCenter
                            });
                        } else {
                            console.log('Marker title is missing for marker at', markerLatLng);
                        }
                    }
                }
            });

            // Tampilkan data di sidebar
            updateSidebarWithMarkers();
        }

        function updateSidebarWithMarkers() {
            var radiusContent = document.getElementById('radiusContent');

            // Pastikan elemen ada sebelum mengaksesnya
            if (!radiusContent) {
                console.error('Elemen dengan ID "radiusContent" tidak ditemukan.');
                return;
            }

            // Kosongkan konten radiusContent
            radiusContent.innerHTML = '<h2>Daftar tempat didalam radius</h2>';

            // Jika tidak ada marker dalam radius
            if (markersInRadius.length === 0) {
                var noRadiusMessage = document.createElement('p');
                noRadiusMessage.id = 'noRadiusMessage';
                noRadiusMessage.innerText = 'Tidak ada radius...';
                radiusContent.appendChild(noRadiusMessage);
            } else {
                markersInRadius.forEach(function(marker) {
                    var card = document.createElement('div');
                    card.className = 'card';

                    var cardContent = `
                <img src="${marker.linkgambar}" alt="${marker.title}" style="width: 100%; border-radius: 10px;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width: 100%; height: auto; border-radius: 10px;">
                <path d="M20 5H4V19L13.2923 9.70649C13.6828 9.31595 14.3159 9.31591 14.7065 9.70641L20 15.0104V5ZM2 3.9934C2 3.44476 2.45531 3 2.9918 3H21.0082C21.556 3 22 3.44495 22 3.9934V20.0066C22 20.5552 21.5447 21 21.0082 21H2.9918C2.44405 21 2 20.5551 2 20.0066V3.9934ZM8 11C6.89543 11 6 10.1046 6 9C6 7.89543 6.89543 7 8 7C9.10457 7 10 7.89543 10 9C10 10.1046 9.10457 11 8 11Z"></path>
            </svg>
            <div class="card__content">
                <p class="card__title">${marker.title}</p>
                <p class="card__description">${marker.tentang}</p>
                <p class="card__description">Alamat: ${marker.alamat}</p>
                <p class="card__description">Jarak: ${getDistance}</p>
            </div>
            `;

                    card.innerHTML = cardContent;
                    radiusContent.appendChild(card);

                    // Tambahkan event listener untuk klik
                    card.addEventListener('click', function() {
                        map.setView([marker.lat, marker.lng], 17); // Zoom ke lokasi marker
                    });
                });
            }
        }

        function removeRadius() {
            if (radiusCircle) {
                map.removeLayer(radiusCircle);
                radiusCircle = null;
            }

            var radiusContent = document.getElementById('radiusContent');
            if (radiusContent) {
                while (radiusContent.firstChild) {
                    radiusContent.removeChild(radiusContent.firstChild);
                }

                // Tampilkan kembali pesan "Tidak ada radius..."
                var noRadiusMessage = document.createElement('p');
                noRadiusMessage.id = 'noRadiusMessage';
                noRadiusMessage.innerText = 'Tidak ada radius...';
                radiusContent.appendChild(noRadiusMessage);
            }

            // Tampilkan kembali daftar sekolah saat radius dihapus
            var markersContent = document.getElementById('markersContent');
            if (markersContent) {
                markersContent.style.display = 'block';
            }
        }

        // Menambahkan event listener untuk menangani input radius
        function setupRadiusInputListener(lat, lng) {
            var radiusInput = document.getElementById('radiusInput' + lat + '-' + lng);
            if (radiusInput) {
                radiusInput.addEventListener('keypress', function(event) {
                    if (event.key === 'Enter') {
                        event.preventDefault(); // Menghindari aksi default Enter
                        toggleRadius(lat, lng);
                    }
                });
            }
        }

        function addEventListenersToSchools() {
            const schoolItems = document.querySelectorAll('#dataContainer li');

            schoolItems.forEach(item => {
                item.addEventListener('click', () => {
                    const lat = parseFloat(item.dataset.lat);
                    const lng = parseFloat(item.dataset.lng);
                    showClosestSchool(lat, lng);
                });
            });
        }

        let currentLocation = null;
        document.addEventListener('DOMContentLoaded', () => {
            // Dapatkan elemen optionsContainer di sini
            const optionsContainer = document.getElementById('options');

            // Dapatkan lokasi pengguna saat ini
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(position => {
                    currentLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                }, error => {
                    console.error('Error mendapatkan lokasi:', error);
                    Swal.fire({
                        title: 'Gagal mendapatkan lokasi',
                        icon: 'warning'
                    });
                });
            } else {
                console.error('Geolocation tidak didukung di browser ini.');
                Swal.fire({
                    title: 'Geolocation tidak didukung di browser anda',
                    icon: 'error'
                });
            }

            // Fetch data untuk sekolah
            fetchSchools().then(schools => {
                allMarkers = schools; 
            }).catch(error => {
                console.error('Error fetching schools:', error);
            });

            const schoolFilterInput = document.getElementById('schoolFilterInput');

            // Event listener untuk input pencarian
            schoolFilterInput.addEventListener('input', (e) => {
                filterSchools(e.target.value, optionsContainer);
            });

            // Event listener untuk tombol Enter pada input pencarian
            schoolFilterInput.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    const firstOption = optionsContainer.querySelector('.option');
                    if (firstOption) {
                        firstOption.click(); // Jalankan aksi seperti klik opsi pertama
                    }
                }
            });

            document.addEventListener('click', (event) => {
                // Jika klik terjadi di luar input atau optionsContainer
                if (!optionsContainer.contains(event.target) && event.target !== schoolFilterInput) {
                    optionsContainer.style.display = 'none'; // Sembunyikan opsi
                }
            });
        });

        function filterSchools(searchTerm, optionsContainer) {
            optionsContainer.innerHTML = ''; // Kosongkan opsi yang ada

            const filteredSchools = allMarkers.filter(school =>
                school.title.toLowerCase().startsWith(searchTerm.toLowerCase())
            );

            filteredSchools.forEach(school => {
                const option = document.createElement('div');
                option.classList.add('option');
                option.textContent = school.title;
                option.dataset.lat = school.lat;
                option.dataset.lng = school.lng;

                option.addEventListener('click', () => {
                    showClosestOrRouteToSchool(parseFloat(school.lat), parseFloat(school.lng));
                    optionsContainer.style.display = 'none'; // Sembunyikan opsi setelah dipilih
                });

                optionsContainer.appendChild(option);
            });

            // Tampilkan/hide container berdasarkan hasil pencarian
            optionsContainer.style.display = filteredSchools.length > 0 ? 'block' : 'none';
        }

        function fetchSchools() {
            return fetch('getData.php') 
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (!data.schools) {
                        throw new Error('Invalid response structure');
                    }
                    return data.schools;
                })
                .catch(error => {
                    console.error('Error fetching schools:', error);
                    return [];
                });
        }

        var currentRouteControl = null;

        function manageRoute(action, startLat, startLng, endLat, endLng) {
            if (action === 'clearCurrent' || action === 'remove') {
                console.log('Menghapus rute...'); // Tambahkan log untuk debugging
                if (currentRouteControl) {
                    map.removeControl(currentRouteControl);
                    currentRouteControl = null;
                    console.log('Rute dihapus'); // Log untuk memastikan rute dihapus
                } else {
                    console.log('Tidak ada rute yang bisa dihapus'); // Log jika tidak ada rute
                }
            }

            if (action === 'show' && startLat !== undefined && startLng !== undefined && endLat !== undefined && endLng !== undefined) {
                currentRouteControl = L.Routing.control({
                    waypoints: [
                        L.latLng(startLat, startLng),
                        L.latLng(endLat, endLng)
                    ],
                    routeWhileDragging: true
                }).addTo(map);
                console.log('Rute ditambahkan'); // Log untuk memastikan rute ditambahkan
            }
        }

        document.addEventListener('keydown', function(event) {
            // Mengecek apakah sidebar terbuka
            const sidebarOpen = document.querySelector('.sidebar').classList.contains('open');

            // Jika sidebar terbuka dan tombol Backspace ditekan
            if (sidebarOpen && event.key === 'Backspace') {
                manageRoute('clearCurrent'); // Panggil fungsi manageRoute dengan action 'clearCurrent'
            }
        });

        function showClosestOrRouteToSchool(lat, lng, isClosest = false) {
            let targetLat, targetLng;

            if (isClosest) {
                var closestSchool = findClosestSchool(lat, lng);
                if (!closestSchool) {
                    Swal.fire({
                        title: 'Tidak ada sekolah ditemukan',
                        icon: 'warning'
                    });
                    return;
                }
                targetLat = closestSchool.lat;
                targetLng = closestSchool.lng;
                closestSchool.marker.openPopup();
            } else {
                if (!currentLocation) {
                    Swal.fire({
                        title: 'Lokasi pengguna tidak tersedia',
                        icon: 'warning'
                    });
                    return;
                }
                targetLat = lat;
                targetLng = lng;
            }

            map.setView([targetLat, targetLng], isClosest ? 10 : 12);
            manageRoute('clearCurrent');
            manageRoute('show', isClosest ? lat : currentLocation.lat, isClosest ? lng : currentLocation.lng, targetLat, targetLng);
        }

        function findClosestSchool(lat, lng) {
            var closestSchool = null;
            var minDistance = Infinity;

            allSchools.forEach(school => {
                var distance = getDistance(lat, lng, school.lat, school.lng);
                if (distance < minDistance) {
                    minDistance = distance;
                    closestSchool = school;
                }
            });

            if (closestSchool) {
                if (!closestSchool.marker) {
                    closestSchool.marker = L.marker([closestSchool.lat, closestSchool.lng]).addTo(map).bindPopup(closestSchool.name);
                }
                return closestSchool;
            }
            return null;
        }

        function getDistance(lat1, lng1, lat2, lng2) {
            var R = 6371; // Radius bumi dalam kilometer
            var dLat = (lat2 - lat1) * Math.PI / 180;
            var dLng = (lng2 - lng1) * Math.PI / 180;
            var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLng / 2) * Math.sin(dLng / 2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            var distanceKm = R * c; // Jarak dalam kilometer

            return distanceKm >= 1 ? `${distanceKm.toFixed(2)} km` : `${(distanceKm * 1000).toFixed(0)} meters`;
        }

        var allSchools = [];

        document.addEventListener('DOMContentLoaded', () => {
            fetchSchools().then(schools => {
                allSchools = schools;
                displaySchoolsInSidebar(schools);
            });
        });

        let currentLat = null;
        let currentLng = null;

        navigator.geolocation.getCurrentPosition(function(position) {
            currentLat = position.coords.latitude;
            currentLng = position.coords.longitude;

            displaySchoolsInSidebar(allMarkers); // Ganti schools dengan allMarkers
        }, function(error) {
            console.error('Error mendapatkan lokasi:', error);
        });


        function displaySchoolsInSidebar(schools) {
            if (currentLat === null || currentLng === null) {
                console.error('Lokasi pengguna tidak tersedia.');
                return;
            }

            var markersContent = document.getElementById('markersContent');
            markersContent.innerHTML = '<h2>Daftar Tempat</h2>';

            if (schools.length === 0) {
                markersContent.innerHTML += '<p>Tidak ada sekolah ditemukan.</p>';
                return;
            }

            schools.forEach(school => {
                var schoolLat = school.lat;
                var schoolLng = school.lng;

                var distance = getDistance(currentLat, currentLng, schoolLat, schoolLng);

                var card = document.createElement('div');
                card.className = 'card';

                var cardContent = `
            <img src="${school.linkgambar}" alt="${school.title}" style="width: 100%; border-radius: 10px;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width: 100%; height: auto; border-radius: 10px;">
                <path d="M20 5H4V19L13.2923 9.70649C13.6828 9.31595 14.3159 9.31591 14.7065 9.70641L20 15.0104V5ZM2 3.9934C2 3.44476 2.45531 3 2.9918 3H21.0082C21.556 3 22 3.44495 22 3.9934V20.0066C22 20.5552 21.5447 21 21.0082 21H2.9918C2.44405 21 2 20.5551 2 20.0066V3.9934ZM8 11C6.89543 11 6 10.1046 6 9C6 7.89543 6.89543 7 8 7C9.10457 7 10 7.89543 10 9C10 10.1046 9.10457 11 8 11Z"></path>
            </svg>
            <div class="card__content">
                <p class="card__title">${school.title}</p>
                <p class="card__description">${school.tentang}</p>
                <p class="card__description">Alamat: ${school.alamat}</p>
                <p class="card__description">Jarak: ${distance}</p>
            </div>
        `;

                card.innerHTML = cardContent;
                markersContent.appendChild(card);
            });
        }

        map.on('click', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;
            if (sidebarOpen) {
                var sidebar = document.getElementById("mySidebar");
                var button = document.getElementById("toggleButton");
                sidebar.style.left = "-500px";
                button.classList.remove('opened');
                button.style.left = "55px";
                sidebarOpen = false;
            }

            var closestSchool = findClosestSchool(lat, lng);

            L.popup()
                .setLatLng(e.latlng)
                .setContent((function() {
                    var lat = e.latlng.lat.toFixed(6);
                    var lng = e.latlng.lng.toFixed(6);
                    var popupContent = `<div class="popup-content">
                                    Koordinat: ${lat}, ${lng}<br>
                                </div>
                                <button class="button99" onclick="showClosestOrRouteToSchool(${lat}, ${lng})">Cari Sekolah Terdekat</button>
                                <button class="button99" onclick="manageRoute('remove')">Hapus Rute</button>`;

                    if (canAddDeleteUpdate) {
                        popupContent += `<button class="button99" onclick="showForm(${lat}, ${lng})">Tandai</button>`;
                    } else {
                        popupContent += `<button class="button99" onclick="noakses(${lat}, ${lng})">Tandai</button>`;
                    }

                    return popupContent;
                })())
                .openOn(map);
        });

        function showForm(lat, lng) {
            Swal.fire({
                title: 'Tambahkan Marker Baru',
                html: `<form id="markerForm">
                <input type="number" name="id" placeholder="ID" required> <br>
                <input class="input" type="text" name="lat" value="${lat}" placeholder="Masukkan Latitude (contoh: 5.551388)" required><br>
                <input class="input" type="text" name="lng" value="${lng}" placeholder="Masukkan Longitude (contoh: 95.356225)" required><br>
                <input class="input" type="text" name="title" placeholder="Masukkan Title" required><br>
                <input class="input" type="text" name="linkurl" placeholder="Masukkan Link URL" required><br>
                <input class="input" type="text" name="tentang" placeholder="Masukkan Data Tempat" required><br>
                <input class="input" type="text" name="alamat" placeholder="Masukkan Alamat" required><br>
                <input class="input" type="text" name="linkgambar" placeholder="Masukkan Link Gambar" required><br>
                <button class="button99" type="submit">Submit</button>
            </form>`,
                showConfirmButton: false,
                didOpen: () => {
                    const form = document.getElementById('markerForm');
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();

                        const formData = new FormData(form);
                        const newLat = parseFloat(formData.get('lat').replace(',', '.'));
                        const newLng = parseFloat(formData.get('lng').replace(',', '.'));

                        if (isNaN(newLat) || isNaN(newLng) || !formData.get('id') || !formData.get('title') || !formData.get('linkurl') || !formData.get('tentang') || !formData.get('alamat') || !formData.get('linkgambar')) {
                            Swal.fire('Gagal!', 'Semua bidang harus diisi dengan benar.', 'error');
                            return;
                        }
                        console.log(newLat, newLng, formData);

                        fetch('getMarkers.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    createMarker(newLat, newLng, formData.get('id'), formData.get('title'), formData.get('linkurl'), formData.get('tentang'), formData.get('alamat'), formData.get('linkgambar'));
                                    Swal.fire('Berhasil!', 'Marker berhasil ditambahkan.', 'success')
                                        .then(() => {
                                            resetMap();
                                        });
                                } else {
                                    Swal.fire('Gagal!', data.message, 'error');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire('Gagal!', 'Terjadi kesalahan saat menyimpan data.', 'error');
                            });
                    });
                }
            });
        }

        function resetRadiusContent() {
            var radiusContent = document.getElementById('radiusContent');
            radiusContent.innerHTML = '<h2>Daftar tempat didalam radius</h2>';
            var noRadiusMessage = document.createElement('p');
            noRadiusMessage.id = 'noRadiusMessage';
            noRadiusMessage.textContent = 'Tidak ada radius...';
            radiusContent.appendChild(noRadiusMessage);
        }


        var sidebar = document.getElementById('mySidebar');
        // Variabel global
        let existingMarkerIds = [];

        // Tile layer
        const tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        });

        // Fungsi untuk mereset peta
        function resetMap() {
            console.log('Resetting map');

            // Pastikan map sudah diinisialisasi
            if (!map) {
                console.error('Map is not initialized');
                return;
            }

            // Hapus semua marker dari grup cluster
            if (markersCluster) {
                markersCluster.clearLayers();
            } else {
                markersCluster = L.markerClusterGroup();
            }

            // Hapus semua layer lain yang bukan tile layer dari peta
            map.eachLayer(function(layer) {
                if (layer !== tileLayer) {
                    map.removeLayer(layer);
                }
            });

            // Pastikan tile layer hanya ditambahkan sekali
            if (!map.hasLayer(tileLayer)) {
                tileLayer.addTo(map);
            }

            existingMarkerIds = [];

            map.addLayer(markersCluster);

            loadMarkers();
        }

        function loadMarkers() {
            console.log('loadMarkers called');

            fetch('getMarker.php')
                .then(response => {
                    console.log('Response status:', response.status);
                    console.log('Response headers:', response.headers);

                    if (!response.ok) {
                        return response.text().then(text => {
                            throw new Error(`HTTP status ${response.status}: ${text}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Loaded markers:', data);

                })
                .catch(error => {
                    console.error('Error fetching markers:', error);
                });
        }

        // Export fungsi-fungsi agar bisa diakses dari luar
        window.resetMap = resetMap;
        window.loadMarkers = loadMarkers;
    </script>

</body>

</html>