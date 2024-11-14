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
    $login = false;
    $err = false;
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $sql = "SELECT * FROM user_details WHERE `username` = '$username'";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        $con = true;
        if($num >= 1){
            while($row = mysqli_fetch_assoc($result)){
                if(password_verify($password, $row['password'])){
                    $login = true;
                    session_start(); 
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $password;
                    header('location: welcome.php');
                }else{
                    $err = true;
                }
            }
        }else{
            $err = true;
        }
    }
?>

<!DOCTYPE html>

<html lang = 'en'>

    <header>
        <title>Login page</title>
        <link rel = "stylesheet" href = "Partials/style.css">
        <link rel = "stylesheet" href = "login.css">
    </header>

    <body>
        <?php
        require('Partials/navbar.php');
        ?>
        
        <?php
        if($login == true){
            echo "<div class = 'alert_success' style = 'background-color: rgb(131, 199, 131);height : 30px; display : flex; 
            align-items : center; color : rgb(6, 67, 6);'>
                <b style = 'margin-right : 4px; background-color: rgb(131, 199, 131);'>Hooray!! </b> You are Logged in
                <div class = 'choice' style = 'margin-left : 1070px; background-color: rgb(131, 199, 131);'>x</div>
            </div>";
        }
        if($err == true){
            echo "<div class = 'alert_success' style = 'background-color: rgb(239, 79, 95);height : 30px; display : flex; 
            align-items : center; color : #f5e4d6;'>
                <b style = 'margin-right : 4px ;background-color: rgb(239, 79, 95); color : #f5e4d6;'>Error!! </b> Invalid Credentials
                <div class = 'choice' style = 'background-color: rgb(239, 79, 95); margin-left : 1080px; color : #f5e4d6;'>x</div>
        </div>";
        }
        ?>

        <div class="container">
            <h1 align = "center">Login</h1>
            <form action = "login.php" method = "POST">

                <label for = "username">Username</label>
                <input type = "text" name = "username" id = "username" maxlength="20">

                <label for = "password">Password</label>
                <input type = "password" name = "password" id = "password" maxlength="20">

                <button type = "submit">Login</button>

            </form>
        </div>

        <script src = "alert.js"></script>
    </body>

</html>