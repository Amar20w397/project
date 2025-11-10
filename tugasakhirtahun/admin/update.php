<?php
require "config.php";

// Ambil data dari URL
$id = $_GET["id"];

// Query data produk berdasarkan id
$product = query("SELECT * FROM product WHERE id = $id")[0];

// Ketika tombol submit dipencet
if (isset($_POST["submit"])) {
    // Cek jika data berhasil diubah atau tidak
    if (ubah($_POST) > 0) {
        echo "
        <script>
            alert('Data Berhasil Diubah!');
            document.location.href='index.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Data Gagal Diubah!');
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
    <title>Update Data Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <h1 class="text-center">Update Data Produk</h1>

    <form action="" method="post">
        <input type="hidden" name="id" value="<?= $product["id"]; ?>">
        <ul>
            <li>
                <label for="product_name" class="form-label">Nama Produk:</label>
                <input type="text" class="form-control" name="product_name" id="product_name" required value="<?= $product["product_name"]; ?>">
            </li>
            <li>
                <label for="product_price" class="form-label">Harga Produk:</label>
                <input type="text" class="form-control" name="product_price" id="product_price" required value="<?= $product["product_price"]; ?>">
            </li>
            <li>
                <label for="product_qty" class="form-label">Jumlah Produk:</label>
                <input type="number" class="form-control" name="product_qty" id="product_qty" required value="<?= $product["product_qty"]; ?>">
            </li>
            <li>
                <label for="product_image" class="form-label">Gambar Produk:</label>
                <input type="text" class="form-control" name="product_image" id="product_image" value="<?= $product["product_image"]; ?>">
            </li>
            <li>
                <label for="product_code" class="form-label">Kode Produk:</label>
                <input type="text" class="form-control" name="product_code" id="product_code" required value="<?= $product["product_code"]; ?>">
            </li>
            <button type="submit" class="btn btn-primary mt-3" name="submit">Update Data</button>
        </ul>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>