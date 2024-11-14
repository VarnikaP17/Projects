<?php
// session_start();
require('Partials/navbar.php');
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>

<html lang = 'en'>

    <header>
        <title>Welcome - <?php echo $_SESSION['username']?></title>
        <link rel = "stylesheet" href = "Partials/style.css">
        <link rel = "stylesheet" href = "welcome.css">
    </header>

    <body>

        <div class = 'msg'>
                <b>Welcome - <?php echo $_SESSION['username']?></b>
                <p>Click on this <a href = "logout.php">Link to Log out</a></p>
        </div>
    </body>

</html>