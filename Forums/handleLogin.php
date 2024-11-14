<?php

if($_SERVER['REQUEST_METHOD'] == "POST"){
    include("dbconnect.php");
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE `username` = '$username'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);

    if($num == 1){
        $row = mysqli_fetch_assoc($result);
        // var_dump(password_verify($password, $row['user_pass']));
        if(password_verify($password, $row['user_pass'])){
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $username;
            echo 'login';
            header("location:index.php");
            exit();
        }else{
            header("location:index.php");
        }

    }else{
        header("location:index.php");
    }

}

?>