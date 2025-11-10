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

    .addItemBtn {
      background-color: rgb(255, 0, 0);
      color: #fff;
      border: none;
    }

    .addItemBtn:hover {
      background-color: #ff4d00;
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
        <li><a href="beranda.php">HOME</a></li>
        <li><a href="index.php">SHOP</a></li>
        <li><a href="checkout.php">CHECKOUT</a></li>
        <li><a href="#" id="logout-btn" class="logout-btn">LOG OUT</a></li>
        <li>  <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i> <span id="cart-item" class="badge badge-danger"></span></a></li>
      </ul>
    </nav>
  </header>
  <!-- Header end -->


        

  <!-- Navbar end -->

  <!-- Displaying Products Start -->
  <div class="container">
    <div id="message"></div>
    <div class="row mt-2 pb-3">
      <?php
        include 'config.php';
        $stmt = $conn->prepare('SELECT * FROM product');
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()):
      ?>
      <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
        <div class="card-deck">
          <div class="card p-2 border-secondary mb-2">
            <img src="media/<?= $row['product_image'] ?>" class="card-img-top" height="250">
            <div class="card-body p-1">
              <h4 class="card-title text-center text-info"><?= $row['product_name'] ?></h4>
              <h5 class="card-text text-center text-danger"><i class="fas fa-rupiah-sign"></i>&nbsp;&nbsp;<?= number_format($row['product_price'],2) ?>/-</h5>
            </div>
            <div class="card-footer p-1">
              <form action="" class="form-submit">
                <div class="row p-2">
                  <div class="col-md-6 py-1 pl-4">
                    <b>Quantity : </b>
                  </div>
                  <div class="col-md-6">
                    <input type="number" class="form-control pqty" value="<?= $row['product_qty'] ?>">
                  </div>
                </div>
                <input type="hidden" class="pid" value="<?= $row['id'] ?>">
                <input type="hidden" class="pname" value="<?= $row['product_name'] ?>">
                <input type="hidden" class="pprice" value="<?= $row['product_price'] ?>">
                <input type="hidden" class="pimage" value="<?= $row['product_image'] ?>">
                <input type="hidden" class="pcode" value="<?= $row['product_code'] ?>">
                <button class="btn btn-info btn-block addItemBtn"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Add to cart</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
  </div>
  <!-- Displaying Products End -->

  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>

  <script type="text/javascript">
    $(document).ready(function() {

      $(".addItemBtn").click(function(e) {
        e.preventDefault();
        var $form = $(this).closest(".form-submit");
        var pid = $form.find(".pid").val();
        var pname = $form.find(".pname").val();
        var pprice = $form.find(".pprice").val();
        var pqty = $form.find(".pqty").val();
        var pimage = $form.find(".pimage").val();
        var pcode = $form.find(".pcode").val();

        $.ajax({
          url: 'action.php',
          method: 'post',
          data: {
            pid: pid,
            pname: pname,
            pprice: pprice,
            pqty: pqty,
            pimage: pimage,
            pcode: pcode
          },
          success: function(response) {
            $("#message").html(response);
            window.scrollTo(0, 0);
            load_cart_item_number();
          }
        });
      });

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
