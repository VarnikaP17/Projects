<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Threads</title>
</head>
<style>
.carousel-item img {
    height: 300px;
    /* Set your desired height */
    object-fit: cover;
    /* Maintains aspect ratio */
}
</style>

<body>
    <?php 
    include("header.php");
    include("dbconnect.php");
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM threads WHERE `thread_id` = $id";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $thread_user_id = $row['thread_user_id'];
            // $comment_by = $row['comment_by'];
            $sql2 = "SELECT username FROM users WHERE `user_id` = '$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $posted_by = $row2['username'];
    echo '<div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">'.$row['thread_title'].'!</h1>
            <p class="lead">'.$row['thread_desc'].'</p>
            <hr class="my-4">
            <p class="lead">
                <p>Posted by- '.$posted_by.'</p>
            </p>
        </div>
        </div>';
        }
    ?>

    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
        echo '<div class="container">
        <h1 class="py-2">Post a Comment</h1>
        <form action = '.$_SERVER['REQUEST_URI'] .' method = "post">
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Type Your Comment</label>
                <textarea class="form-control" id="comment" name = "comment" rows="3"></textarea>
                <input type = "hidden" name = "user_id" value = "'.$_SESSION['user_id'].'">
            </div>
            <button type="submit" class="btn btn-success">Post Comment</button>
        </form>
    </div>';
    }else{
        echo '<div class = "container my-4">
        <h1 class="py-2">Post a Comment</h1>
            <div class="jumbotron jumbotron-fluid m-2">
                <div class="container">
                    <h1 class="display-4 lead">Login to post a comment.</h1>
                </div>
            </div>
            </div>';
    }
    ?>

    <?php
        $showAlert = false;
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $comment = $_POST['comment'];
                $comment = str_replace("<", "&lt;", $comment);
                $comment = str_replace(">", "&gt;", $comment);
                $user_id = $_POST["user_id"];
                $nsql = "INSERT INTO  comments(`comment_content`, `thread_id`, `comment_by`) VALUES('$comment', '$id', '$user_id');";    
                $nresult = mysqli_query($conn, $nsql);
                $showAlert = true;
                if($showAlert){
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> Your Comment has been added.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
                }
            }
        ?>

    <div class="container" style = "min-height : 300px;">
        <h1 class="py-2">Discussions</h1>
        <?php
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM comments WHERE `thread_id` = $id";
        $result = mysqli_query($conn, $sql);
        $noresult = true;
        while($row = mysqli_fetch_assoc($result)){
            $noresult = false;
            $comment_by = $row['comment_by'];
            $sql2 = "SELECT username FROM users WHERE `user_id` = '$comment_by'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            if($row2 == NULL){
                $name = "Anonymous User";
            }else{
                $name = $row2['username'];
            }
            echo '<div class="media my-4">
            <img height = 50px width = 50px class="mr-3" src="https://static.vecteezy.com/system/resources/thumbnails/005/129/844/small_2x/profile-user-icon-isolated-on-white-background-eps10-free-vector.jpg" alt="Generic placeholder image">
            
            <div class="media-body"><p class = "font-weight-bold my-0">'.$name.' at '.$row['comment_time'].'</p>'.$row['comment_content'].'</div>
            </div>';
        } 
        if($noresult){
            echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h2 class="display-4">No Commets In This Category</h2>
                <p class="lead">Be the first person to answer a question.</p>
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