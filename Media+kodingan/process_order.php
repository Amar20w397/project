<?php
session_start();

if(isset($_POST['add'])) {
    // Ambil data dari form
    $namaProduk = $_POST['hidden_name'];
    $hargaProduk = $_POST['hidden_price'];
    $quantity = $_POST['quantity'];

    // Simpan data ke dalam session
    $itemArray = array(
        $namaProduk => array(
            'harga' => $hargaProduk,
            'quantity' => $quantity
        )
    );

    // Jika sesi keranjang belum ada, buat sesi baru
    if(!isset($_SESSION['shopping_cart'])) {
        $_SESSION['shopping_cart'] = $itemArray;
        $response = array('message' => 'Barang berhasil ditambahkan ke keranjang');
    } else{
        // Jika sesi keranjang sudah ada, tambahkan barang baru atau update barang yang sudah ada
        $array_keys = array_keys($_SESSION['shopping_cart']);
        if(in_array($namaProduk, $array_keys)) {
            // Jika barang sudah ada di keranjang, update jumlahnya
            $_SESSION['shopping_cart'][$namaProduk]['quantity'] += $quantity;
            $response = array('message' => 'Jumlah barang di keranjang berhasil diperbarui');
        } else {
            // Jika barang belum ada di keranjang, tambahkan barang baru
            $_SESSION['shopping_cart'] = array_merge($_SESSION['shopping_cart'], $itemArray);
            $response = array('message' => 'Barang berhasil ditambahkan ke keranjang');  
            echo json_encode($response);
        }
    }
    // Kembalikan respon dalam format JSON
   
}
?>