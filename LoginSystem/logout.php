<?php
session_start();

session_unset();
session_destroy();
header("location: login.php");
exit;

?>



<!DOCTYPE html>

<html lang = 'en'>

    <header>
        <title>Log out page</title>
        <link rel = "stylesheet" href = "Partials/style.css">
    </header>

    <body>
        <?php
        require('Partials/navbar.php');
        ?>
    </body>

</html>