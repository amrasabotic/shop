<?php
	require 'config.php';
  
  //check if session is created
  session_start();
  if(isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $accessL= $_SESSION['accessLevel']; 
  }else{
    header("Location: login.php");
  }

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
 
  //calculating total amount to pay
	$grand_total = 0;

  //creating arrays for products atributes
	$allItems = '';
  $allsize = '';
  $allcolor = '';
  $allsign = '';
  $alltel = '';

	$items = [];
  $sizes = [];
  $colors = [];
  $tels = [];


	$sql = "SELECT CONCAT(product_name, ' (',qty,') ' , ' <br> Size: ',size,' ' ,' Color: ' ,color, ' ' , 'Sign:  ' ,`sign`,' ' ,tel) AS ItemQty, total_price, size, color, `sign`, tel FROM cart";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->get_result();
	while ($row = $result->fetch_assoc()) {
	  $grand_total += $row['total_price'];
	  $items[] = $row['ItemQty'];
    $sizes[] =  $row['size'];
    $colors[] =  $row['color'];
    $signs[] =  $row['sign'];
    $tels[] =  $row['tel'];

	}
	$allItems = implode(', ', $items);
  $allsize = implode(', ', $sizes);
  $allcolor = implode(', ', $colors);
  $allsign = implode(', ', $signs);
  $alltel = implode(', ', $tels);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="js/bootstrap.min.js"></script>

  <script src="js/myjs.js"></script>
  <script src="js/bootstrap.js"></script>
  <title>Checkout</title>
</head>

<body>
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
  <div class="content">
    <div class="container">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6 px-4 pb-4" id="order">
            <h4 class="text-center text-info p-2">Complete your order!</h4>
            <div class="jumbotron p-3 mb-2 text-center">
              <h6 class="lead"><b>Products: </b><?= $allItems; ?></h6>
              <h6 class="lead"><b>Delivery Fee: </b>Free</h6>
              <h5><b>Total: </b><?= number_format($grand_total,2) ?>&euro;</h5>
            </div>
            <form action="" method="post" id="placeOrder">
              <input type="hidden" name="products" value="<?= $allItems; ?>"> 
              <input type="hidden" name="grand_total" value="<?= $grand_total; ?>">
              <input type="hidden" name="size" value="<?= $allsize; ?>">
              <input type="hidden" name="color" value="<?= $allcolor; ?>">
              <input type="hidden" name="sign" value="<?= $allsign; ?>">
              <input type="hidden" name="tel" value="<?= $alltel; ?>">
             <br>
              <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Enter Name and Surname" required>
              </div>
              <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Enter E-Mail" required>
              </div>
              <div class="form-group">
                <input type="tel" name="phone" class="form-control" placeholder="Enter Phone" required>
              </div>
              <div class="form-group">
                <textarea name="address" class="form-control" rows="3" cols="10"
                  placeholder="Enter Shipping Address Here..."></textarea>
              </div>
              <h6 class="text-center lead">Select Payment Mode</h6>
              <div class="form-group">
                <select name="pmode" class="form-control">
                  <option value="" selected disabled>-Select Payment Mode-</option>
                  <option value="Cash">Cash On Delivery</option>
                  <option value="Banking">eBanking</option>
                  <option value="Card">Debit/Credit Card</option>
                </select>
              </div>
              <div class="form-group">
                <input type="submit" name="submit" value="Place Order" class="btn btn-danger btn-block">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--- Footer --->
  <div class="my-5">
    <footer class="text-center text-lg-start" style="background-color: #333;   
    bottom: 0;
    right: 0; left:0">
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

<script type="text/javascript">
  $(document).ready(function () {

    // Sending Form data to the server
    $("#placeOrder").submit(function (e) {
      e.preventDefault();
      $.ajax({
        url: 'action.php',
        method: 'post',
        data: $('form').serialize() + "&action=order",
        success: function (response) {
          $("#order").html(response);
        }
      });
    });

    // Load total no.of items added in the cart and display in the navbar
    load_cart_item_number();

    function load_cart_item_number() {
      $.ajax({
        url: 'action.php',
        method: 'get',
        data: {
          cartItem: "cart_item"
        },
        success: function (response) {
          $("#cart-item").html(response);
        }
      });
    }
  });
</script>