<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa; /* Light gray background */
        }

        form {
            width: 100%;
            max-width: 400px;
        }

        .error {
            margin-bottom: 15px;
        }

        .wave-group {
            position: relative;
            margin-bottom: 1.5rem; /* Add some space between form groups */
        }

        .wave-group .form-control {
            font-size: 16px;
            padding: 10px 10px 10px 5px;
            display: block;
            width: 100%;
            border: none;
            border-bottom: 1px solid #515151;
            background: transparent;
        }

        .wave-group .form-control:focus {
            outline: none;
        }

        .wave-group .label {
            color: #999;
            font-size: 18px;
            font-weight: normal;
            position: absolute;
            pointer-events: none;
            left: 5px;
            top: 10px;
            display: flex;
        }

        .wave-group .label-char {
            transition: 0.2s ease all;
            transition-delay: calc(var(--index) * .05s);
        }

        .wave-group .form-control:focus ~ .label .label-char,
        .wave-group .form-control:valid ~ .label .label-char {
            transform: translateY(-20px);
            font-size: 14px;
            color: #5264AE;
        }

        .wave-group .bar {
            position: relative;
            display: block;
            width: 100%;
        }

        .wave-group .bar:before, .wave-group .bar:after {
            content: '';
            height: 2px;
            width: 0;
            bottom: 1px;
            position: absolute;
            background: #5264AE;
            transition: 0.2s ease all;
            -moz-transition: 0.2s ease all;
            -webkit-transition: 0.2s ease all;
        }

        .wave-group .bar:before {
            left: 50%;
        }

        .wave-group .bar:after {
            right: 50%;
        }

        .wave-group .form-control:focus ~ .bar:before,
        .wave-group .form-control:focus ~ .bar:after {
            width: 50%;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <form action="login.php" method="post" class="p-5 bg-white rounded shadow">
        <h2 class="text-center mb-4">LOGIN</h2>
        <?php  
        if (isset($_GET['error'])) {
        ?>
        <p class="error text-danger">
        <?php  
        echo $_GET['error'];
        ?>
        </p>
        <?php  
        }
        ?>
        <div class="wave-group">
            <input type="text" name="username" id="username" class="form-control" required>
            <span class="bar"></span>
            <label class="label">
                <span class="label-char" style="--index: 0">U</span>
                <span class="label-char" style="--index: 1">s</span>
                <span class="label-char" style="--index: 2">e</span>
                <span class="label-char" style="--index: 3">r</span>
                <span class="label-char" style="--index: 4">n</span>
                <span class="label-char" style="--index: 5">a</span>
                <span class="label-char" style="--index: 6">m</span>
                <span class="label-char" style="--index: 7">e</span>
            </label>
        </div>
        <div class="wave-group">
            <input type="password" name="password" id="password" class="form-control" required>
            <span class="bar"></span>
            <label class="label">
                <span class="label-char" style="--index: 0">P</span>
                <span class="label-char" style="--index: 1">a</span>
                <span class="label-char" style="--index: 2">s</span>
                <span class="label-char" style="--index: 3">s</span>
                <span class="label-char" style="--index: 4">w</span>
                <span class="label-char" style="--index: 5">o</span>
                <span class="label-char" style="--index: 6">r</span>
                <span class="label-char" style="--index: 7">d</span>
            </label>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Login</button>
        <a href="buatakun.php" class="btn btn-link d-block text-center mt-3">Buat Akun</a>
    </form>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>