<?php
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'users';
    $conn = mysqli_connect($hostname, $username, $password, $database);
    if(!$conn){
        die("Couldn't connect to the database". mysqli_connect_error());
    }else{
            // echo "Successfully connected";
    }
    $con = false;
    $exists = false;
    $err = false;
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        $exists = false;

        $sqlexists = "SELECT * FROM user_details WHERE username = '$username'";
        $num = mysqli_query($conn, $sqlexists);
        if(mysqli_num_rows($num) > 0){
            $exists = true;
        }

        if($password == $cpassword && $exists == false){
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO user_details(`username` , `password`) VALUES('$username', '$hash')";
            $insert = mysqli_query($conn, $sql);
            $con = true;
        }
        if($password != $cpassword){
            $err = true;
        }
    }
?>

<!DOCTYPE html>

<html lang = 'en'>

    <header>
        <title>Sign Up page</title>
        <link rel = "stylesheet" href = "Partials/style.css">
        <link rel = "stylesheet" href = "login.css">
    </header>

    <body>
        <?php
        require('Partials/navbar.php');
        ?>
        
        <?php
        if($con == true){
            echo "<div class = 'alert_success' style = 'background-color: rgb(131, 199, 131);height : 30px; display : flex; 
            align-items : center; color : rgb(6, 67, 6);'>
                <b style = 'background-color: rgb(131, 199, 131);'>Hooray!!</b> Your account has been created
                <div class = 'choice' style = 'margin-left : 990px; background-color: rgb(131, 199, 131);'>x</div>
            </div>";
        }
        if($exists == false){
            if($err == true){
                echo "<div class = 'alert_success' style = 'background-color: rgb(239, 79, 95);height : 30px; display : flex; 
                align-items : center; color : #f5e4d6;'>
                    <b style = 'margin-right : 4px ;background-color: rgb(239, 79, 95); color : #f5e4d6;'>Error!! </b> Password and Confirm Password don't match
                    <div class = 'choice' style = 'background-color: rgb(239, 79, 95); margin-left : 900px; color : #f5e4d6;'>x</div>
            </div>";
            }
        }
        if($exists == true){
            echo "<div class = 'alert_success' style = 'background-color: rgb(239, 79, 95);height : 30px; display : flex; 
            align-items : center; color : #f5e4d6;'>
                <b style = 'margin-right : 4px ;background-color: rgb(239, 79, 95); color : #f5e4d6;'>Error!! </b> Your Account already exists
                <div class = 'choice' style = 'background-color: rgb(239, 79, 95); margin-left : 1020px; color : #f5e4d6;'>x</div>
        </div>";
        }
        ?>

        <div class="container">
            <h1 align = "center">Sign Up</h1>
            <form action = "signup.php" method = "POST">

                <label for = "username">Username</label>
                <input type = "text" name = "username" id = "username" maxlength="20">

                <label for = "password">Password</label>
                <input type = "password" name = "password" id = "password" maxlength="20">

                <label for = "cpassword">Confirm Password</label>
                <input type = "password" name = "cpassword" id = "cpassword" maxlength="20">

                <button type = "submit">Sign Up</button>

            </form>
        </div>

        <script src = "alert.js"></script>
    </body>

</html>