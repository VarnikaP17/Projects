<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>ThreadList</title>
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
        $id = $_GET['catid'];
        $sql = "SELECT * FROM categories WHERE `category_id` = $id";
        $result = mysqli_query($conn, $sql);
            $showAlert = false;
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $th_title = $_POST['title'];
                $th_desc = $_POST['desc'];
                $user_id = $_POST["user_id"];
                $nsql = "INSERT INTO  threads(`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`) VALUES('$th_title', '$th_desc', '$id', '$user_id');";    
                $nresult = mysqli_query($conn, $nsql);
                $showAlert = true;
                if($showAlert){
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> Your thread Has been added, please wait for community to respond.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
                }
            }
        while($row = mysqli_fetch_assoc($result)){
    echo '<div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">Welcome To '.$row['category_name'].'!</h1>
            <p class="lead">'.$row['category_desc'].'</p>
            <hr class="my-4">
            <p>This forum is for sharing knowledge with each other.<br/>
            Be civil: Don\'t post anything that is offensive, abusive, or hate speech.<br/>
            Stay on topic: Keep your posts relevant to the thread.<br/>
            Be respectful: Don\'t harass, bully, or threaten other participants.<br/>
            Be clear: Use plain English and avoid acronyms or text talk.<br/>
            Be constructive: Provide information, opinions, or questions.<br/>
            </p>
            <p class="lead">
                <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
            </p>
        </div>
        </div>';
        }
    ?>

    <?php

    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
        echo '<div class="container">
                <h1 class="py-2">Start a Discussion</h1>
                <form action ='.$_SERVER['REQUEST_URI'].' method = "post">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Problem Title</label>
                        <input type="text" class="form-control" name = "title" id="exampleInputEmail1" aria-describedby="emailHelp"
                            placeholder="Enter Title">
                        <small id="emailHelp" class="form-text text-muted">Keep your title crisp.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Elaborate Your Concern</label>
                        <textarea class="form-control" id="desc" name = "desc" rows="3"></textarea>
                        <input type = "hidden" name = "user_id" value = "'.$_SESSION['user_id'].'">
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>';
    }else{
        echo '<div class = "container my-4">
        <h1 class="py-2">Start a Discussion</h1>
            <div class="jumbotron jumbotron-fluid m-2">
                <div class="container">
                    <h1 class="display-4 lead">Login to start a discussion.</h1>
                </div>
            </div>
            </div>';
    }

    ?>

    <div class="container" style="min-height : 300px;">
        <h1 class="py-2">Browse Questions</h1>
        <?php
        $id = $_GET['catid'];
        $sql = "SELECT * FROM threads WHERE `thread_cat_id` = $id";
        $result = mysqli_query($conn, $sql);
        $noresult = true;
        while($row = mysqli_fetch_assoc($result)){
            $noresult = false;
            $thread_user_id = $row['thread_user_id'];
            $sql2 = "SELECT username FROM users WHERE `user_id` = '$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            if($row2 == NULL){
                $name = "Anonymous User";
            }else{
                $name = $row2['username'];
            }
            echo '<div class="media my-4">
            <img height = 50px width = 50px class="mr-3" src="https://static.vecteezy.com/system/resources/thumbnails/005/129/844/small_2x/profile-user-icon-isolated-on-white-background-eps10-free-vector.jpg" alt="Generic placeholder image">
            <div class="media-body">
            <p class = "font-weight-bold my-0">'.$name.' at '.$row['timestamp'].'</p>
            <h5 class="mt-0"><a class = "text-dark" href = "thread.php?threadid='.$row['thread_id'].' ">'.$row['thread_title'].'</a></h5>'.
            $row['thread_desc'].'
            </div>
            </div>';
        } 
        if($noresult){
            echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h2 class="display-4">No Questions In This Category</h2>
                <p class="lead">Be the first person to ask a question.</p>
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



<!-- 


 -->