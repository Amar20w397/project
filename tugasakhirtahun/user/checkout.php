<?php
	require 'config.php';

	$grand_total = 0;
	$allItems = '';
	$items = [];

	$sql = "SELECT CONCAT(product_name, '(',product_qty,')') AS ItemQty, total_price FROM cart";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->get_result();
	while ($row = $result->fetch_assoc()) {
	  $grand_total += $row['total_price'];
	  $items[] = $row['ItemQty'];
	}
	$allItems = implode(', ', $items);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="author" content="Sahil Kumar">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Shopping Cart System</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />
  <style>
body {
  font-family: Arial, sans-serif;
}

header {
  background-color: #f4f4f4;
  padding: 10px;
  text-align: center;
  margin-top: 1px;
}

header h4 {
  margin: 0;
  color: #333;
}

nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px;
}

nav img {
  margin-right: 20px;
}

nav ul {
  list-style-type: none;
  padding: 0;
  display: flex;
  align-items: center;
}

nav ul li {
  margin-left: 20px;
}

nav ul li a {
  color: #333;
  text-decoration: none;
}

nav ul li a:hover {
  color: #ff4d00;
}

.logout-btn {
  padding: 10px 20px;
  font-size: 16px;
  color: #000;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  margin-bottom: 20px;
}

.checkout-btn {
  background-color: rgb(255, 0, 0);
}

.confirmation-box {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.confirmation-content {
  background-color: #fff;
  padding: 20px;
  border-radius: 8px;
  display: flex;
  flex-direction: column;
  align-items: center;
  box-shadow: 0px 0px 15px 0px rgba(0, 0, 0, 0.75);
  max-width: 300px;
  width: 80%;
}

.confirmation-content p {
  margin-bottom: 20px;
}

.confirmation-content button {
  padding: 8px 16px;
  font-size: 14px;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  margin: 5px;
}

.confirm-yes {
  background-color: #666;
}

.confirm-no {
  background-color: #ff4d00;
}


  </style>
</head>

<body>
  <!-- Header start -->
  <header>
  <div class=".container-fluid" style="background-color: rgb(255, 0, 0); height: 3rem;">
      <h4>We are open 24 hours, and free delivery throughout the city of Banda Aceh</h4>
    </div>
    <nav>
      <img src="fotoAceh.png" alt="">
      <ul>
        <li><a href="index.php">HOME</a></li>
        <li><a href="index.php">SHOP</a></li>
        <li><a href="checkout.php">CHECKOUT</a></li>
        <li><a href="#" id="logout-btn" class="logout-btn">LOG OUT</a></li>
        <li>  <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i> <span id="cart-item" class="badge badge-danger"></span></a></li>
      </ul>
    </nav>
  </header>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6 px-4 pb-4" id="order">
        <h4 class="text-center text-info p-2">Complete your order!</h4>
        <div class="jumbotron p-3 mb-2 text-center">
          <h6 class="lead"><b>Product(s) : </b><?= $allItems; ?></h6>
          <h6 class="lead"><b>Delivery Charge : </b>Free</h6>
          <h5><b>Total Amount Payable : </b><?= number_format($grand_total,2) ?>/-</h5>
        </div>
        <form action="" method="post" id="placeOrder">
          <input type="hidden" name="products" value="<?= $allItems; ?>">
          <input type="hidden" name="grand_total" value="<?= $grand_total; ?>">
          <div class="form-group">
            <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
          </div>
          <div class="form-group">
            <input type="email" name="email" class="form-control" placeholder="Enter E-Mail" required>
          </div>
          <div class="form-group">
            <input type="tel" name="phone" class="form-control" placeholder="Enter Phone" required>
          </div>
          <div class="form-group">
            <textarea name="address" class="form-control" rows="3" cols="10" placeholder="Enter Delivery Address Here..."></textarea>
          </div>
          <h6 class="text-center lead">Select Payment Mode</h6>
          <div class="form-group">
            <select name="pmode" class="form-control">
              <option value="" selected disabled>-Select Payment Mode-</option>
              <option value="cod">Cash On Delivery</option>
              <option value="netbanking">Net Banking</option>
              <option value="cards">Debit/Credit Card</option>
            </select>
          </div>
          <div class="form-group">
            <input type="submit" name="submit" value="Place Order" class="btn btn-danger btn-block">
          </div>
        </form>
  
  </div>
</div>


      </div>
    </div>
  </div>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>
 <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
<script>
$(document).ready(function() {

// Sending Form data to the server
$("#placeOrder").submit(function(e) {
  e.preventDefault();

  // Show loader animation
  $(".loader").css("display", "block");

  // Simulate form submission delay (for demo purposes)
  setTimeout(() => {
    // You can replace this with your actual form submission logic
    $.ajax({
      url: 'action.php',
      method: 'post',
      data: $(this).serialize() + "&action=order",
      success: function(response) {
        $(".loader").css("display", "none"); // Hide loader after response received
        $("#order").html(response);
      }
    });
  }, 3000); // Adjust delay as needed
});

// Load total no.of items added in the cart and display in the navbar
load_cart_item_number();

function load_cart_item_number() {
  $.ajax({
    url: 'action.php',
    method: 'get',
    data: {
      cartItem: "cart_item"
    },
    success: function(response) {
      $("#cart-item").html(response);
    }
  });
}

$("#logout-btn").click(function(e) {
  e.preventDefault();
  $(".confirmation-box").fadeIn();
});

$(".confirm-yes").click(function(e) {
  e.preventDefault();
  window.location.href = "logout.php";
});

$(".confirm-no").click(function(e) {
  e.preventDefault();
  $(".confirmation-box").fadeOut();
});

});
</script>
  
<!-- Confirmation Box -->
<div class="confirmation-box" style="display: none;">
  <div class="confirmation-content">
    <p>Are you sure you want to log out?</p>
    <button class="confirm-yes">Yes</button>
    <button class="confirm-no">No</button>
  </div>
</div>
</body>

</html>