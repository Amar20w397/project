<?php
  session_start();
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
      <div class="col-lg-10">
        <div style="display:<?php if (isset($_SESSION['showAlert'])) {
  echo $_SESSION['showAlert'];
} else {
  echo 'none';
} unset($_SESSION['showAlert']); ?>" class="alert alert-success alert-dismissible mt-3">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong><?php if (isset($_SESSION['message'])) {
  echo $_SESSION['message'];
} unset($_SESSION['showAlert']); ?></strong>
        </div>
        <div class="table-responsive mt-2">
          <table class="table table-bordered table-striped text-center">
            <thead>
              <tr>
                <td colspan="7">
                  <h4 class="text-center text-info m-0">Products in your cart!</h4>
                </td>
              </tr>
              <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>
                  <a href="action.php?clear=all" class="badge-danger badge p-1" onclick="return confirm('Are you sure want to clear your cart?');"><i class="fas fa-trash"></i>&nbsp;&nbsp;Clear Cart</a>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php
                require 'config.php';
                $stmt = $conn->prepare('SELECT * FROM cart');
                $stmt->execute();
                $result = $stmt->get_result();
                $grand_total = 0;
                while ($row = $result->fetch_assoc()):
                    // Tambahkan pemeriksaan untuk kunci 'total_price'
                  
              ?>
              
              <tr>
                <td><?= $row['id'] ?></td>
                <input type="hidden" class="pid" value="<?= $row['id'] ?>">
                <td><img src="<?= $row['product_image'] ?>" width="50"></td>
                <td><?= $row['product_name'] ?></td>
                <td>
                  <i class="fas fa-rupiah-sign"></i>&nbsp;&nbsp;<?= number_format($row['product_price'],2); ?>
                </td>
                <input type="hidden" class="pprice" value="<?= $row['product_price'] ?>">
                <td>
                  <input type="number" class="form-control itemQty" value="<?= $row['product_qty'] ?>" style="width:75px;">
                </td>
                <td><i class="fas fa-rupiah-sign"></i>&nbsp;&nbsp;<?= number_format($row['product_price'],2) ?></td>
                <td>
                  <a href="action.php?remove=<?= $row['id'] ?>" class="text-danger lead" onclick="return confirm('Are you sure want to remove this item?');"><i class="fas fa-trash-alt"></i></a>
                </td>
              </tr>
              <?php $grand_total += $row['total_price']; ?>
              <?php endwhile; ?>
              <tr>
                <td colspan="3">
                  <a href="index.php" class="btn btn-success"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Continue
                    Shopping</a>
                </td>
                <td colspan="2"><b>Grand Total</b></td>
                <td><b><i class="fas fa-rupiah-sign"></i>&nbsp;&nbsp;<?= number_format($grand_total,2); ?></b></td>
                <td>
                  <a href="checkout.php" class="btn btn-info <?= ($grand_total > 1) ? '' : 'readonly'; ?>"><i class="far fa-credit-card"></i>&nbsp;&nbsp;Checkout</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>

  <script type="text/javascript">
  $(document).ready(function() {

    // Change the item quantity
    $(".itemQty").on('change', function() {
      var $el = $(this).closest('tr');

      var pid = $el.find(".pid").val();
      var pprice = $el.find(".pprice").val();
      var qty = $el.find(".itemQty").val();
      location.reload(true);
      $.ajax({
        url: 'action.php',
        method: 'post',
        cache: false,
        data: {
          qty: qty,
          pid: pid,
          pprice: pprice
        },
        success: function(response) {
          console.log(response);
        }
      });
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