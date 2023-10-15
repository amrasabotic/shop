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
  <title>Search</title>
</head>
<style>
  #nav {
    float: left;
    padding: 0 10px;
    margin: 0 10px;
    background-color: #333;
    color: white;
    border: 1px solid #aaa;
    width: 150px;
    visibility: visible;
  }

  #nav ul,
  #nav li {
    margin-left: 15px;
    padding: 0px;
    color: white;
  }

  #nav h3 {
    padding: 5px;
  }

  #nav a {
    color: white;
  }

  h1 {
    margin: 20px 0px 0px 10px;
    padding: 0px 3px;
    font-size: 16px;
    background-color: transparent;
    color: white;
  }

  h2 {
    margin: 15px 0px 0px 10px;
    padding: 0px 3px;
    font-size: 15px;
    color: white;
  }

  h3 {
    margin: 20px 0px 0px 10px;
    padding: 0px 3px;
    font-size: 14px;
    color: white;
  }

  h4 {
    padding-left: 20px;
    padding-right: 20px;
  }

  button {
    visibility: hidden;
    display: none;
  }

  @media only screen and (max-width:760px) {

    #nav {
      visibility: hidden;
      float: left;
      margin-left: 0px;
      width: 150px;
      position: fixed;
      margin-left: -5%;
      z-index: 1;
    }

    .content {
      float: left;
      margin-left: 23%;
      width: 80%;
      z-index: 2;
    }

    #open {
      position: fixed;
      background: green;
      color: white;
      border: 1px solid #aaa;
      font-size: 15px;
      visibility: visible;
      display: block;
      transform: rotate(90deg);
      margin-top: 60px;
      margin-left: -17%;
      padding-bottom: 25px;

    }
  }
</style>

<body>
<?php
//check if session is created
session_start();
if(isset($_SESSION['username']) && !empty($_SESSION['username'])) {
	$username = $_SESSION['username'];
  $accessL= $_SESSION['accessLevel']; 
}else{
	header("Location: login.php");
}
?>
  <header>
    <div class="topnav" id="myTopnav">
      <a href="index.php"><img src="images/logo1.png" alt="logo"></a>
      <?php

if($accessL == 1){
  echo "<a href=\"index.php\">Home</a> | <a href=\"admin.php\">Admin Panel</a> | <a href=''>Contact</a> | <a href=''>About</a> | <a href=\"logout.php\">Logout</a>";   
}else if($accessL == 2){
  echo "<a href='index.php'>Home</a> | <a href='#'> Admin Panel </a>| <a href=''>Contact</a> | <a href=''>About</a> |<a href='login.php'>Logout</a> ";
}else{
  echo "<a href='index.php'>Home</a> | <a href='#'> Admin Panel </a>| <a href=''>Contact</a> | <a href=''>About</a> |<a href='login.php'>Login</a> ";
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
          <a href=''><img src='images/orders.png' alt='Orders'><span>Orders</span></a>
          <a href='logout.php'> <img src='images/user.png' alt='Login'><span>Login</span></a>";         
         }
        ?>
      </div>
    </div>
  </header>
  <div class="row" style="position:relative;">
    <div class="container">
      <div class="col-lg-3 col-md-3 col-sm-12" style="padding:20px ;">
        <button id="open" onmouseover="openNav()">
          <h4>Administrator Panel</h4>
        </button>

        <?php
      if($accessL == 1){
      echo   "
        <div id='nav' onmouseleave='closeNav()'>
          <h3>Products</h3>
           <ul>
            <li><a href='addProduct.php'>Add Product </a></li>
            <li><a href='editProduct.php'>Edit Product </a></li>
            <li><a href='deleteProduct.php'>Delete Product </a></li>
          </ul>

          <h3>Users</h3>
          <ul>
            <li><a href='addUser.php'>Add User </a></li>
            <li><a href='editUser.php'>Edit User </a></li>
            <li><a href='deleteUser.php'>Delete User </a></li>
          </ul>

          <h3>Color</h3>
          <ul>
            <li><a href='addColor.php'>Add Color </a></li>
            <li><a href='editColor.php'>Edit Color </a></li>
            <li><a href='deleteColor.php'>Delete Color </a></li>
          </ul>
          <h3>Orders</h3>
          <ul>
            <li><a href='editStatus.php'>Order Status</a></li>
          </ul>
        </div>
        ";}else{
          echo   "
          <div id='nav' onmouseleave='closeNav()'>
            <h3>Products</h3>
             <ul>
              <li><a href='addProduct.php'>Add Product </a></li>
              <li><a href=''>Edit Product </a></li>
              <li><a href=''>Delete Product </a></li>
            </ul>
  
            <h3>Users</h3>
            <ul>
              <li><a href=''>Add User </a></li>
              <li><a href=''>Edit User </a></li>
              <li><a href=''>Delete User </a></li>
            </ul>
  
            <h3>Color</h3>
            <ul>
              <li><a href=''>Add Color </a></li>
              <li><a href=''>Edit Color </a></li>
              <li><a href=''>Delete Color </a></li>
            </ul>
            <h3>Orders</h3>
            <ul>
              <li><a href=''>Order Status</a></li>
            </ul>
          </div>
          ";
        }
        ?>
      </div>

      <div class="content">
        <?php
$con = mysqli_connect('localhost','root');
mysqli_select_db($con,'we_onlinedb');

$query ="SELECT itemID, itemName, material, price, description, image, 	signName FROM item 
JOIN `sign` ON item.signID = `sign`.signID";

$result = mysqli_query($con, $query);
//$product = mysqli_fetch_assoc($result);

while($product = mysqli_fetch_assoc($result)) {
    ?>
        <div class="col-lg-3 col-md-3 col-sm-12" style="padding:20px ;">
          <a href="index.php?page=product&id=<?=$product['itemID']?>" class="product">


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
                  <a style="text-decoration: none; padding:10px; border:1px solid gray; background-color: #478729;color:white; border-radius:10px; margin-right: 10px;"
                    href="product.php?id=<?php echo $product['itemID']; ?>"> See More...</a> <a href=""
                    style="text-decoration: none; padding:10px; border:1px solid gray; background-color: #ffc107; color:white; border-radius:10px">Add
                    to Cart</a>
                </div>
              </div>
            </form>

          </a>
        </div>
        <?php       
}
?></div>
    </div>
  </div>
  <!--- Footer --->
  <div class="my-5">
    <footer class="text-center text-lg-start"
      style="background-color: #333; margin-top:30px;  bottom:0px; left:0px; right:0px;">
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

<script>
  var widths = [0, 760];

  function openNav() {
    if (window.innerWidth >= widths[0] && window.innerWidth < widths[1]) {
      document.getElementById("open").style.display = "none";
      document.getElementById("nav").style.visibility = "visible";
    }
  }
  openNav();


  function closeNav() {
    if (window.innerWidth >= widths[0] && window.innerWidth < widths[1]) {
      document.getElementById("nav").style.visibility = "hidden";
      document.getElementById("open").style.display = "block";
    }
    if (window.innerWidth > widths[1]) {
      document.getElementById("nav").style.visibility = "visible";
      document.getElementById("open").style.display = "none";
    }
  }
  window.onresize = closeNav;
  closeNav();
</script>