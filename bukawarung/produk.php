<?php 
	error_reporting(0);
	include 'db.php';
	$kontak = mysqli_query($conn, "SELECT admin_telp, admin_email, admin_address FROM tb_admin WHERE admin_id = 3");
	$a = mysqli_fetch_object($kontak);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Bukalaptop</title>
	<link rel="stylesheet" type="text/css" href="css/styl345.css">
	<link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
	<style>
.options-container {
    position: relative;
    top: 100%; 
    left: 15%; 
    width: 833px; 
    max-height: 200px; 
    overflow-y: auto; 
    background-color: #fff; 
    border: 2px solid rgba(0, 48, 73, 0.4); 
    border-radius: 12px; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
    z-index: 1000; 
    display: none; 
}
.option {
    padding: 3px 1rem; 
    cursor: pointer; 
    color: #0d0c22; 
    transition: background-color 0.3s ease; 
}

.option:hover {
    background-color: rgba(0, 48, 73, 0.1);
}
	</style>
</head>
<body>
	<!-- header -->
	<header>
		<div class="container">
			<h1><a href="index.php">Bukalaptop</a></h1>
			<ul>
				<li><a href="produk.php">Produk</a></li>
			</ul>
		</div>
	</header>

    <!-- search -->
    <div class="search">
        <div class="container">
            <form action="produk.php">
                <input type="text" name="search" placeholder="Cari Produk" value="<?php echo $_GET['search'] ?>">
                <input type="hidden" name="kat" value="<?php echo $_GET['kat'] ?>">
                <input type="submit" name="cari" value="Cari Produk">
            </form>
            <!-- Options container for filtered product names -->
            <div class="options-container"></div>
        </div>
    </div>

	<!-- new product -->
	<div class="section">
		<div class="container">
			<h3>Produk</h3>
			<div class="box">
				<?php 
                
					if($_GET['search'] != '' || $_GET['kat'] != ''){
						$where = "AND product_name LIKE '%".$_GET['search']."%' AND category_id LIKE '%".$_GET['kat']."%' ";
					}

					$produk = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_status = 1 $where ORDER BY product_id DESC");
					if(mysqli_num_rows($produk) > 0){
						while($p = mysqli_fetch_array($produk)){
				?>	
					<a href="detail-produk.php?id=<?php echo $p['product_id'] ?>">
						<div class="col-4">
							<img src="produk/<?php echo $p['product_image'] ?>"  style="width: 300px; height: 250px;">
							<p class="nama"><?php echo substr($p['product_name'], 0, 30) ?></p>
							<p class="harga">Rp. <?php echo number_format($p['product_price']) ?></p>
						</div>
					</a>
				<?php }}else{ ?>
					<p>Produk tidak ada</p>
				<?php } ?>
			</div>
		</div>
	</div>

	<!-- footer -->
	<div class="footer">
		<div class="container">
			<h4>Alamat</h4>
			<p><?php echo $a->admin_address ?></p>

			<h4>Email</h4>
			<p><?php echo $a->admin_email ?></p>

			<h4>No. Hp</h4>
			<p><?php echo $a->admin_telp ?></p>
			<small>Copyright &copy; 2025 - Bukalaptop.</small>
		</div>
	</div>
	<script>
const allProducts = <?php
    $produk = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_status = 1 ORDER BY product_id DESC");
    $products = [];
    while ($p = mysqli_fetch_assoc($produk)) {
        $products[] = [
            "title" => $p['product_name'],
            "lat" => $p['product_id'],
            "lng" => $p['product_image']
        ];
    }
    echo json_encode($products);
?>;

function filterProducts(searchTerm, optionsContainer) {
    optionsContainer.innerHTML = '';

    if (!searchTerm.trim()) {
        optionsContainer.style.display = 'none';
        return;
    }

    const filteredProducts = allProducts.filter(product =>
        product.title.toLowerCase().includes(searchTerm.toLowerCase()) 
    );

    if (filteredProducts.length === 0) {
        optionsContainer.style.display = 'none';
        return;
    }

    filteredProducts.forEach(product => {
        const option = document.createElement('div');
        option.classList.add('option');
        option.textContent = product.title;
        option.dataset.productId = product.lat;

        option.addEventListener('click', () => {
            window.location.href = `detail-produk.php?id=${product.lat}`;
        });

        optionsContainer.appendChild(option);
    });

    optionsContainer.style.display = 'block';
}

document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('input[name="search"]');
    const optionsContainer = document.querySelector('.options-container');

    searchInput.addEventListener('input', () => {
        filterProducts(searchInput.value, optionsContainer);
    });
});

</script>

</body>
</html>