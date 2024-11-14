<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Forums</title>
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
    ?>

    <!-- slider starts here -->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100"
                    src="https://api.lilly021.com/wp-content/uploads/2022/10/professional-programmer-working-late-dark-office-scaled.jpg"
                    alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100"
                    src="https://user-images.githubusercontent.com/71090710/125194888-23718980-e24b-11eb-95ae-9b11396a888e.png"
                    alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100"
                    src="https://e0.pxfuel.com/wallpapers/461/943/desktop-wallpaper-coding-background-dark-coding.jpg"
                    alt="Third slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

<!-- Category container starts here -->
    <div class="container my-4" style = "min-height : 433px;">
        <h2 class="text-center my-4">Welcome to Forums</h2>
        <div class="row">

        <?php
        include("dbconnect.php");
        $sql = 'SELECT * FROM categories';
        $result = mysqli_query($conn, $sql);
        // Use for loop here
        while($row = mysqli_fetch_assoc($result)){
            echo '<div class="col-md-4 my-3">
                <div class="card" style="width: 18rem;">
                    <img height = "280px" width = "100px" class="card-img-top" src="'.$row['category_link'].'"
                        alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title"><a href = "thread_list.php?catid=' .$row['category_id']. '">'.$row['category_name'].'</a></h5>
                        <p class="card-text">'.substr($row['category_desc'], 0, 90).'....</p>
                        <a href="#" class="btn btn-primary">View Threads</a>
                    </div>
                </div>
            </div>';
        }
        ?> 
        </div>
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



