<?php
session_start();

error_log(print_r($_SESSION, true)); // Menulis informasi sesi ke log untuk debugging

if (isset($_SESSION['username'])) {
    echo json_encode($_SESSION['username']);
} else {
    echo json_encode("User not logged in");
}
?>
