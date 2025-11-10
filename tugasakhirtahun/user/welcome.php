
<?php  
session_start();
include "config.php";
if (isset($_SESSION['id'])&& isset($_SESSION['username'])){

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Hello <?php  echo $_SESSION['username'];?></h1>
    <a href="logout.php">Logout</a>
    <button a href="beranda.php"></button>

</body>
</html>
<?php  
}else{
    header ("Location:login_index.php");
    exit();
}
?>