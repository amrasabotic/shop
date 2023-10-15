<?php

include "config.php";

//check for existing cookie
if(isset($_COOKIE['customerID'])){
  //get existing customer ID
  $customerID = $_COOKIE['customerID'];
}
else{
  //generate new customer ID
  $customerID = uniqid();

  //set cookie to expire in 30 days
  setcookie('customerID', $customerID, time() + (86400 * 30), "/");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/bootstrap.min.js"></script>

  <script src="js/myjs.js"></script>
  <script src="js/bootstrap.js"></script>
  <title>Home</title>
</head>

<body>
  <header>
    <div class="topnav" id="myTopnav">
      <li>
      <a href="index.php"><img src="images/logo1.png" alt="logo"></a>
      </li>
      <?php
session_start();

if(isset($_SESSION['username']) && !empty($_SESSION['username'])) {
	$username = $_SESSION['username'];
  echo "<a href=\"index.php\">Home</a> | <a href=\"admin.php\">Admin Panel</a> | <a href='#' name='content'>Contact</a> | <a href='#'>About</a> | <a href=\"logout.php\">Logout</a>";   
}else{
  echo "<a href='index.php'>Home</a> | <a href='#'> Admin Panel </a>| <a href='#'>Contact</a> | <a href='#'>About</a> |<a href='login.php'>Login</a> ";
}

include "config.php";
  ?>

      <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <i class="fa fa-bars"></i>
      </a>
      <div class="link">
        <hr>
        <?php
        if(isset($_SESSION['username']) && !empty($_SESSION['username'])) {
          $username = $_SESSION['username'];
          echo "        <a href='search.php'><img src='images/search.png' alt='Search'><span>Search</span></a>
          <a href='cart.php'><img src='images/shopping-cart.png' alt='Cart'><span>Shopping Cart</span></a>
          <a href='orders.php'><img src='images/orders.png' alt='Orders'><span>Orders</span></a>
          <a href='logout.php'> <img src='images/user.png' alt='Login'><span>Login</span></a>";   
        }else{
          echo "<a href='search.php'><img src='images/search.png' alt='Search'><span>Search</span></a>
          <a href=''><img src='images/shopping-cart.png' alt='Cart'><span>Shopping Cart</span></a>
          <a href=''><img src='images/orders.png' alt='Cart'><span>Orders</span></a>
          <a href='logout.php'> <img src='images/user.png' alt='Login'><span>Login</span></a>";          }
        ?>
      </div>
    </div>
  </header>
  <div class="content">
    <div class="row">
     
        <div class="slider">

          <div id="myCarousel" class="carousel slide img-responsive" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
              <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
              <li data-target="#myCarousel" data-slide-to="1"></li>
              <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">

              <div class="item active">
                <img src="images/slider1.jpg" alt="Home decoration" style="width:100%; height:420px;"
                  class="img-responsive">
                <div class="carousel-caption">
                  <h3>Home decoration</h3>
                  <p>Personalize you home decoration!</p>
                </div>
              </div>

              <div class="item">
                <img src="images/slider2.jpg" alt="Zodiac sign gifts" style="width:100%; height:420px"
                  class="img-responsive">
                <div class="carousel-caption">
                  <h3>Zodiac Sign Gifts</h3>
                  <p>Choose a personalized gift for you or your special person!</p>
                </div>
              </div>

              <div class="item">
                <img src="images/slider3.jpg" alt="New York" style="width:100%;height:420px" class="img-responsive">
                <div class="carousel-caption">
                  <h3>Football Fan</h3>
                  <p>Choose your favorite team and cheer like a pro!</p>
                </div>
              </div>

            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>

        </div>
     
    </div>
    <div class="products">
      <h3>All products</h3>

      <div class="row">
        <div class="container">

          <div class="col-lg-3 col-md-3 col-sm-12" style="margin-bottom: 50px ;">
            <h4>Search product</h4>
            <?php

echo '<form action="index.php" method="post">';
echo '<input type="text" name="search" placeholder="Search..." />';
echo '<input type="submit" value="Search" />';
echo '</form>';
echo '<script>document.getElementById("myDiv").style.display = "none";</script>';
?>
          </div>
          <?php
if(isset($_POST['search']) && !empty($_POST['search'])) {

$search_term = $_POST['search'];

$query ="SELECT itemID, itemName, material, price, description, image, 	signName FROM item 
JOIN `sign` ON item.signID = `sign`.signID
WHERE itemName LIKE '%$search_term%'";

$result = mysqli_query($conn, $query);

while($row = mysqli_fetch_assoc($result)) {   
?>
          <a href="product?id=<?=$row['itemID']?>" class="product">
          <div class="col-lg-3 col-md-3 col-sm-12">          
            <div class="card">
              <h6 class="card-title bg-dark text-white p-2 text-center">
                <?php echo $row['itemName'];  ?> </h6>
              <div class="card-body">
                <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']); ?>"
                  class="img-fluid mb-2 img-thumbnail" style="height:200px;" />

                <p>Material: <em><?php echo $row['material'];  ?></em></p>
                <h6> &euro; <?php echo $row['price'];  ?><span> </h6>

              </div>
              <div class="btn-group d-flex">
                    <a style="text-decoration: none; padding:10px; border:1px solid gray; background-color: #478729;color:white; border-radius:10px; margin: 15px;"
                      href="product.php?id=<?php echo $row['itemID']; ?>"> See More...</a> <a href="product.php?id=<?php echo $row['itemID']; ?>"
                      style="text-decoration: none; padding:10px; border:1px solid gray; background-color: #ffc107; color:white; border-radius:10px; margin: 15px;">Add
                      to Cart</a>
                  </div>
            </div>
          </div>
          </a>
          <?php
}
}else{

?>
          <?php
$con = mysqli_connect('localhost','root');
mysqli_select_db($con,'we_onlinedb');

$query ="SELECT itemID, itemName, material, price, description, image, 	signName FROM item 
JOIN `sign` ON item.signID = `sign`.signID";

$result = mysqli_query($con, $query);
//$product = mysqli_fetch_assoc($result);

while($product = mysqli_fetch_assoc($result)) {
  
    ?>
          <a href="product?id=<?=$product['itemID']?>" class="product">
            <div class="col-lg-3 col-md-3 col-sm-12" id="myDiv" style="margin-bottom: 50px ;">

              <form>
                <div class="card">
                  <h6 class="card-title bg-dark text-white p-2 text-center"> <?php echo
             $product['itemName'];  ?> </h6>

                  <div class="card-body">

                    <img src="data:images/jpg;charset=utf8;base64,<?php echo base64_encode($product['image']); ?>"
                      class="img-fluid mb-2 img-thumbnail" style="height:200px;" />
                    <p>Material: <em><?php echo $product['material'];  ?></em></p>
                    <h6> &euro; <?php echo $product['price'];  ?><span> </h6>


                  </div>
                  <div class="btn-group d-flex">
                    <a style="text-decoration: none; padding:10px; border:1px solid gray; background-color: #478729;color:white; border-radius:10px; margin: 15px;"
                      href="product.php?id=<?php echo $product['itemID']; ?>"> See More...</a> <a href="product.php?id=<?php echo $product['itemID']; ?>"
                      style="text-decoration: none; padding:10px; border:1px solid gray; background-color: #ffc107; color:white; border-radius:10px; margin: 15px;">Add
                      to Cart</a>
                  </div>
                </div>
              </form>
            </div>
          </a>
          <?php       
}
}
?>
        </div>
      </div>
    </div>
  </div>

  <!--- Footer --->
  <div class="my-5">
    <footer class="text-center text-lg-start"
      style="background-color: #333; position:relative; bottom:0px; left:0px; right:0px;">
      <div class="container d-flex justify-content-center py-5">
        <button type="button" class="btn btn-primary btn-lg btn-floating mx-2" style="background-color: #4A4A4A;">
          <i class="fab fa-facebook-f"></i>
        </button>
        <button type="button" class="btn btn-primary btn-lg btn-floating mx-2" style="background-color: #4A4A4A;">
          <i class="fab fa-youtube"></i>
        </button>
        <button type="button" class="btn btn-primary btn-lg btn-floating mx-2" style="background-color: #4A4A4A;">
          <i class="fab fa-instagram"></i>
        </button>
        <button type="button" class="btn btn-primary btn-lg btn-floating mx-2" style="background-color: #4A4A4A;">
          <i class="fab fa-twitter"></i>
        </button>
      </div>
      <div class="text-center text-white p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        © 2023 Copyright Amra Sabotic
      </div>
    </footer>
  </div>

</body>

</html>