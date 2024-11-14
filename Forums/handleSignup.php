<?php

if($_SERVER['REQUEST_METHOD'] == "POST"){
    include('dbconnect.php');
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    $showAlert = false;
    $showError = "false";

    $existssql = "SELECT * FROM users WHERE `username` = '$username'";
    $existsresult = mysqli_query($conn, $existssql);
    $num = mysqli_num_rows($existsresult);

    if($num > 0){
        $showError = "Username already exists.";
    }else{
        if($password == $cpassword){
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users(`username`,`user_pass`) VALUES('$username', '$hash');";
            $result = mysqli_query($conn, $sql);
            if($result){
                $showAlert = true;
                header("location:index.php?signupsuccess=true");
                exit();
            }
        }else{
            $showError = "Password and confirm password do not match.";
        }
    }
    header("location:index.php?signupsuccess=false&showError=".urlencode($showError)."");
}

?>