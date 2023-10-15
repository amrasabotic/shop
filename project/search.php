<?php

include "config.php";

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

<body>
  <header>
    <div class="topnav" id="myTopnav">
      <a href="index.php"><img src="images/logo1.png" alt="logo"></a>
      <?php
session_start();

if(isset($_SESSION['username']) && !empty($_SESSION['username'])) {
	$username = $_SESSION['username'];
  echo "<a href=\"index.php\">Home</a> | <a href=\"admin.php\">Admin Panel</a> | <a href=''>Contact</a> | <a href=''>About</a> | <a href=\"logout.php\">Logout</a>";   
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
  <div class="content" style="position: relative;">
    <div class="row">
      <div class="container">
        <div class="products">
          <h3>Search products</h3>

          <div class="row">
            <div class="container">

              <div class="col-lg-3 col-md-3 col-sm-12 justify-content-center align-items-center">
                <h4>Search product</h4>
                <?php

echo '<form action="search.php" method="post">';
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
                    <button class="btn btn-success flex-fill"> <a href="product.php?id=<?php echo $row['itemID']; ?>">
                        See More...</a> </button> <button class="btn btn-warning flex-fill text-white"> Buy</button>
                  </div>
                </div>
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
    </div>


  <!--- Footer --->


  </div>
</body>
</html>