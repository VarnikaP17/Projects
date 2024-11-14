<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Search Results</title>
</head>

<style>
    .container{
        min-height : 100vh;
    }
</style>

<body>
    <?php 
    include("header.php");
    include("dbconnect.php");
    ?>

    <!-- Search Results starts here -->
     <div class="container my-3">
        <h1 class = "py-2">Search results for <em>"<?php echo $_GET['search']?></em>"</h1>
        <?php
        $search = $_GET['search'];
        $sql = "SELECT * FROM threads WHERE MATCH(thread_title, thread_desc) AGAINST('$search');";
        $result = mysqli_query($conn, $sql);
        $res_show = false;
        while($row = mysqli_fetch_assoc($result)){
            $res_show = true;
            $thread_title = $row['thread_title'];
            $thread_desc = $row['thread_desc'];
            $thread_id = $row['thread_id'];
            $url = "thread.php?threadid=".$thread_id;
           
            echo '<div class="result">
                    <h3><a href="'.$url.'" class="text-dark">'.$thread_title.'</a></h3>
                    <p>'.$thread_desc.'</p>
                 </div>';
        }
        if($res_show == false){
            echo '<div class="container my-4">
                    <div class="jumbotron">
                        <h1 class="display-5">No Results Found</h1><br\>
                        <p class = "lead">Suggestions:
                                <ul class = "lead">
                                <li>Make sure that all words are spelled correctly.</li>
                                <li>Try different keywords.</li>
                                <li>Try more general keywords.</li>
                                <li>Try fewer keywords.</li>
                                </ul>
                        </p>
                    </div>
                </div>';
        }
        ?>
     </div>

    <?php include("footer.php");?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
</body>

</html>



