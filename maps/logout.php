<?php
session_start(); // Memulai sesi

// Menghapus semua variabel sesi
$_SESSION = [];

// Menghancurkan sesi
session_destroy();

// Mengembalikan respon sukses
http_response_code(200); // Status OK
?>
