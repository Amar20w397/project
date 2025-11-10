<?php
require "config.php";


// Ketika tombol submit dipencet
if (isset($_POST["submit"])) {
    // Peringatan jika data berhasil ditambahkan atau tidak
    if (tambah($_POST) > 0) {
        echo "
        <script>
            alert('Data Berhasil Ditambahkan!');
            document.location.href='index.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Data Gagal Ditambahkan!');
            document.location.href='index.php';
        </script>
        ";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <h1 class="text-center">Tambah Data Produk</h1>

    <form action="" method="post">
        <ul>
            <li>
                <label for="product_name" class="form-label">Nama Produk:</label>
                <input type="text" class="form-control" name="product_name" id="product_name" required>
            </li>
            <li>
                <label for="product_price" class="form-label">Harga Produk:</label>
                <input type="text" class="form-control" name="product_price" id="product_price" required>
            </li>
            <li>
                <label for="product_qty" class="form-label">Jumlah Produk:</label>
                <input type="number" class="form-control" name="product_qty" id="product_qty" required>
            </li>
            <li>
                <label for="product_image" class="form-label">Gambar Produk:</label>
                <input type="text" class="form-control" name="product_image" id="product_image">
            </li>
            <li>
                <label for="product_code" class="form-label">Kode Produk:</label>
                <input type="text" class="form-control" name="product_code" id="product_code" required>
            </li>
            <button type="submit" class="btn btn-primary mt-3" name="submit">Tambah Data</button>
        </ul>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>