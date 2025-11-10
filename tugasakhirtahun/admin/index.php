<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aceh Arts Store Center</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Additional styles for customization */

        .container-custom {
            background-color: rgb(255, 0, 0);
            color: rgb(0, 0, 0);
            text-align: center;
        }

        header {
            background-color: #f4f4f4;
            padding: 10px;
            text-align: center;
            margin-top: 1px;
        }


        .nav-custom {
            justify-content: space-around;
            margin-top: 15px;
        }

        /* Confirmation box styles */



        .btn-danger {
    background-color: rgb(255, 0, 0);
    }

    button {
    position: relative;
    width: 214px;
    height: 40px;
    cursor: pointer;
    display: flex;
    align-items: center;
    background: red;
    border: none;
    border-radius: 5px;
    box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.15);
    overflow: hidden; /* Mengatur overflow agar animasi tetap dalam batas tombol */
}

button .text {
    flex-grow: 1;
    text-align: center;
    color: white;
    font-weight: bold;
    transition: opacity 0.3s ease; /* Animasi opasitas saat tombol dihover */
}

button .icon {
    position: absolute;
    left: 50%; /* Menempatkan ikon di tengah horizontal */
    top: 50%; /* Menempatkan ikon di tengah vertikal */
    transform: translate(-50%, -50%) scale(0); /* Menggeser ikon ke tengah dan mengatur skala menjadi 0 */
    transition: transform 0.3s ease; /* Animasi transform saat tombol dihover */
}

button svg {
    width: 15px;
    fill: #eee;
}

button:hover .text {
    opacity: 0; /* Mengubah opasitas teks menjadi 0 saat tombol dihover */
}

button:hover .icon {
    transform: translate(-50%, -50%) scale(1); /* Mengembalikan skala ikon menjadi 1 saat tombol dihover */
}

button:focus {
    outline: none;
}

button:active .icon svg {
    transform: scale(0.8);
}

    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <div class="container-custom py-2">
            <h4>We are open 24 hours, and free delivery throughout the city of Banda Aceh</h4>
        </div>
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#"><img src="media/fotoAceh.png" alt=""></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse nav-custom" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="logout.php" id="logout-btn" class="logout-btn">LOG OUT</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Content -->
    <div class="container mt-4">
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
                <div class="card h-100">
                    <img src="media/<?= $row['product_image'] ?>" class="card-img-top" height="250">
                    <div class="card-body">
                        <h5 class="card-title text-center text-info"><?= $row['product_name'] ?></h5>
                        <h5 class="card-text text-center text-danger"><i class="fas fa-rupee-sign"></i>&nbsp;&nbsp;<?= number_format($row['product_price'],2) ?>/-</h5>
                    </div>
                    <div class="card-footer">
                        <form action="" class="form-submit">
                            <div class="row p-2">
                                <div class="col-md-6 py-1">
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
                            <a href="update.php?id=<?= $row['id'] ?>" class="btn btn-success btn-block">Update Product</a>
                            <button class="noselect">
                            <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-block noselect" onclick="return confirm('Are you sure want to delete this product?');">
                                <span class="text">Delete</span>
                                <span class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <path d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z"></path>
                                    </svg>
                                </span>
                            </a>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
            <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-text text-center text-danger">Add New Product</h5>
                    </div>
                    <div class="card-footer">
                        <a href="add.php" class="btn btn-primary btn-block">Add</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
