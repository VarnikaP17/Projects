<?php
session_start();
include("dbconnect.php");

echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="index.php">Forums</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about.php">About</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Categories
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">';

        $sql = "SELECT * FROM categories LIMIT 3";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
          echo '<a class="dropdown-item" href="thread_list.php?catid=' .$row['category_id'].'">'.$row['category_name'].'</a>';
        }

        echo '
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contact.php">Contact</a>
      </li>
    </ul>
    <div class = "row mx-2">';
    

    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
      echo '<form action = "search.php" method = "get" class="form-inline my-2 my-lg-0">
              <input class="form-control mr-sm-2 mx-2" name = "search" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-success my-2 my-sm-0 mx-2" type="submit">Search</button>
              <p class = "text-light my-0">Welcome '.$_SESSION['username'].'</p></form>
              <a href = "logout.php" class = "btn btn-outline-success mx-2">Log Out</a>
              </div>
              </div>
              </nav>';
    }else{
      echo '<form action = "search.php" method = "get" class="form-inline my-2 my-lg-0">
              <input name = "search" class="form-control mr-sm-2 mx-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
              </form>
              <button class = "btn btn-outline-success mx-2" data-toggle="modal" data-target="#loginModal">Login</button>
              <button class = "btn btn-outline-success" data-toggle="modal" data-target="#signupModal">Sign Up</button>
              </div>
              </div>
              </nav>';
    }
include("loginModal.php");
include("signupModal.php");
if(isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "true"){
  echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
          <strong>Success!</strong> You have been signed up.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
}


if(isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "false"){
  if(isset($_GET['showError'])){
    echo '<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
          <strong>Warning! </strong> '.$_GET['showError'].'
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
  }
}
?>