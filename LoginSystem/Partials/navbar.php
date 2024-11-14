<?php
session_start();
$loggedin = false;
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
    $loggedin = true;
}
echo '<!DOCTYPE html>

<html lang = "en">

    <header>
        <title>Nav-Bar</title>
        <link rel = "stylesheet" href = "style.css">
    </header>

    <body>
        <div class = "nav">
            <div class = "logo-img"></div>
            <div><a href = "/LoginSystem/welcome.php">Home</a></div>
            <div>Our Menu</div>';
            if($loggedin != true){
                echo '<div><a href = "/LoginSystem/login.php">Login</a></div>
                <div><a href = "/LoginSystem/signup.php">Sign Up</a></div>';
            };
            if($loggedin == true){
                echo '<div><a href = "/LoginSystem/logout.php">Log Out</a></div>';
            };
        echo '</div>
    </body>

</html>';
?>