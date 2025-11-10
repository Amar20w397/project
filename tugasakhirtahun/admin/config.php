<?php
$conn = new mysqli("localhost", "root", "", "shopping");

if ($conn->connect_error) {
    die("Connection Failed! " . $conn->connect_error);
}

function tambah($data) {
    global $conn;
    $product_name = htmlspecialchars($data["product_name"]);
    $product_price = htmlspecialchars($data["product_price"]);
    $product_qty = htmlspecialchars($data["product_qty"]);
    $product_image = htmlspecialchars($data["product_image"]);
    $product_code = htmlspecialchars($data["product_code"]);

    $stmt = $conn->prepare('INSERT INTO product (product_name, product_price, product_qty, product_image, product_code) VALUES (?, ?, ?, ?, ?)');
    $stmt->bind_param('sdiss', $product_name, $product_price, $product_qty, $product_image, $product_code);
    $stmt->execute();

    return $stmt->affected_rows;
}

function hapus($id) {
    global $conn;
    $stmt = $conn->prepare('DELETE FROM product WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();

    return $stmt->affected_rows;
}

function query($query) {
    global $conn;
    $result = $conn->query($query);
    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    return $rows;
}

function ubah($data) {
    global $conn;

    $id = $data["id"];
    $product_name = htmlspecialchars($data["product_name"]);
    $product_price = htmlspecialchars($data["product_price"]);
    $product_qty = htmlspecialchars($data["product_qty"]);
    $product_image = htmlspecialchars($data["product_image"]);
    $product_code = htmlspecialchars($data["product_code"]);

    $query = "UPDATE product SET
                product_name = '$product_name',
                product_price = '$product_price',
                product_qty = '$product_qty',
                product_image = '$product_image',
                product_code = '$product_code'
            WHERE id = $id";

    $conn->query($query);

    return $conn->affected_rows;
}

if (isset($_GET['product_price']) && $_GET['product_price'] == 'total_harga') {
    $stmt = $conn->prepare('SELECT SUM(product_price * product_qty) AS total_harga FROM product');
    $stmt->execute();
    $stmt->bind_result($product_price);
    $stmt->fetch();
    $stmt->close();

    echo "Total Harga Produk: " . $product_price;
}
?>