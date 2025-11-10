<?php  
session_start();
include "config.php";
if (isset ($_POST ['username'])&&isset ($_POST ['password']) ){
    function validate($data){
        $data=trim($data);
        $data =stripslashes($data);
        $data= htmlspecialchars($data);
        return $data;
    }
    $username= validate($_POST ['username']);
    $password= validate($_POST ['password']);
    if (empty($username)){
        header("Location:login_index.php?error=user name is required");
        exit();
    }
    else if(empty($password)){
        header("Location:login_index.php?error=password is required");
        exit();
    }else{
        $sql= "SELECT * FROM admin WHERE username='$username' AND password ='$password'";

        $result = mysqli_query($conn,$sql);

        if(mysqli_num_rows($result)===1){
            $row = mysqli_fetch_assoc($result);
            if($row ['username']=== $username && $row ['password'] === $password){
                $_SESSION['username']= $row ['username'];
                $_SESSION['id']= $row ['id'];
                header("Location:index.php");
                exit();
            }else {
                header("Location:login_index.php?error=Incorect username or password");
                exit();
            }
            
        }else{
            header("Location:login_index.php?error=Incorect username or password");
            exit();
        }

    }
    
} else {
    header("Location:index.php");
    exit();
}



?>