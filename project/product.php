<?php

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
  <title>Home</title>
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
          <a href='logout.php'> <img src='images/user.png' alt='Login'><span>Login</span></a>";          }
        ?>
      </div>
    </div>
  </header>
  <div class="content">
    <div class="container">
      <div class="products">
        <br><br>
        <?php
$product_id = $_GET['id'];

include "config.php";


$result = $conn->query('SELECT itemID, itemName, material, price, description, image, signName, category, quantity, product_code FROM item 
JOIN `sign` ON item.signID = `sign`.signID
JOIN category ON item.categoryID = category.categoryID
WHERE itemID = ' . $product_id);

// Fetch the product data
$product = $result->fetch_assoc();


?>
        <div class="row">
          <div id="message"></div>

          <div class="col">
            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($product['image']); ?>"
              class="col img-fluid img-thumbnail img-responsive pimage" />
          </div>
          <?php

echo '<div class="col">';
echo "<h3><center>". $product['itemName']."</center></h3>";
echo '<p>' . $product['description'] . '</p>';
echo '<p>Material: <em>' . $product['material'] . '</em></p>';
echo '<p> Price: <b> &euro; ' . $product['price'] . '</b></p>';
?>
<!------------------------------------- Form to insert product in cart --------------------------------------------------->

          <form action="" class="form-submit">
            <?php

        // code for size dropdown lists
       echo '<div id="size">';      
        $sql = ('SELECT * FROM size');
        $result = mysqli_query($conn, $sql);
        echo '<lable>Size: </lable><br><select name="size" style="margin-bottom: 15px; width:185px;height:35px;border:1px solid black;"><option disabled selected>--Size--</option>';
        while($row = mysqli_fetch_assoc($result)) {
            echo '<option value="'.$row['size'].'">'.$row['size'].'</option>';
        }
        echo '</select></div>';
        
        //dropdown menu for color
        echo '<div id="color">';
        $sql = ('SELECT * FROM color');
        $result = mysqli_query($conn, $sql);
        echo '<label>Color: </label><br><select name="color" style="margin-bottom: 15px; width:185px;height:35px;border:1px solid black;"><option disabled selected>--Color--</option>';
        while($row = mysqli_fetch_assoc($result)) {
            echo '<option value="'.$row['color'].'">'.$row['color'].'</option>';
        }
        echo '</select></div>';

        //dropdown menu for phone type
        echo '<div id="phone">';
        $sql = ('SELECT * FROM telephonetype');
        $result = mysqli_query($conn, $sql);
        echo '<label>Phone: </label><br><select name="tel" style="margin-bottom: 15px; width:185px;height:35px;border:1px solid black;"><option disabled selected>--Phone--</option>';
        while($row = mysqli_fetch_assoc($result)) {
            echo '<option value="'.$row['typeName'].'">'.$row['typeName'].'</option>';
        }
        echo '</select></div>';
    
    // code for zodiac sign dropdown list
    $sql = ("SELECT * FROM `sign`");
    $result = mysqli_query($conn, $sql);
    echo '<label>Zodiac sign: </label><br><select name="sign" style="margin-bottom: 15px; width:185px;height:35px;border:1px solid black;"><option disabled selected>--Sign--</option>';
    while($row = mysqli_fetch_assoc($result)) {
        echo '<option value="'.$row['signName'].'">'.$row['signName'].'</option>';
    }
    echo '</select> <br><br>';


//Checking which dropdown menus to show on page, based on product category
$query = $conn->prepare( "SELECT categoryID FROM item WHERE itemID = '$product_id'");
$query -> execute();
$query->bind_result($categoryID);
while($query->fetch()){
  $id = $categoryID;
}
$query->close();

if($id == 1){
  echo '<script>document.getElementById("size").style.display = "block";</script>';
  echo '<script>document.getElementById("phone").style.display = "none";</script>';
}elseif($id == 2){
  echo '<script>document.getElementById("size").style.display = "none";</script>';
  echo '<script>document.getElementById("phone").style.display = "none";</script>';
}elseif($id == 3){
  echo '<script>document.getElementById("size").style.display = "none";</script>';
  echo '<script>document.getElementById("phone").style.display = "block";</script>';
}
elseif($id == 4){
  echo '<script>document.getElementById("size").style.display = "none";</script>';
  echo '<script>document.getElementById("phone").style.display = "none";</script>';
}
?>  
            <label>Quantity: </label>
            <input type="number" class="form-control pqty" min="1" max="<?= $product['quantity'] ?>" value="1" style="width:185px;">
            <input type="hidden" class="pid" value="<?= $product['itemID'] ?>">
            <input type="hidden" class="pname" value="<?= $product['itemName'] ?>">
            <input type="hidden" class="pprice" value="<?= $product['price'] ?>">
            <input type="hidden" class="pcode" value="<?= $product['product_code'] ?>">
            <?php
?>
           <br><br> <button class="btn btn-success addItemBtn" type="submit">
            <i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Add to cart</button>
          </form>
        </div>
      </div>
      <?php
?>

<!----- Details ---->

      <br><br>
      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home">Description</a></li>
        <li><a data-toggle="tab" href="#menu1">Material</a></li>
        <li><a data-toggle="tab" href="#menu2">Delivery</a></li>
        <li><a data-toggle="tab" href="#menu3">Return Policy</a></li>
      </ul>

      <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
          <br>
          <?php
      echo '<p>' . $product['description'] . '</p>';
      ?>
        </div>
        <div id="menu1" class="tab-pane fade">
          <br>
          <?php
    echo '<p> Material of the product is: ' . $product['material'] . '</p>';
    ?>
        </div>
        <div id="menu2" class="tab-pane fade">
          <br>
          <p>Please note the delivery estimate is greater than 3 business days.
            Seller ships within 1 day after receiving cleared payment.</p>
        </div>
        <div id="menu3" class="tab-pane fade">
          <br>
          <p>Offers a 15 to 30-day window in which customers can return a product and ask for a refund. Some businesses
            extend that period up to 90 days. Regardless of the time frame you choose, ensuring that you actually have a
            time frame is essential.</p>
        </div>
      </div>

    </div>
  </div>

  <!--- Footer --->
  <div class="my-5">
    <footer class="text-center text-lg-start" style="background-color: #333;">
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

  <!---- Function for sending data to server ---->
  <script type="text/javascript">
    $(document).ready(function () {
      $(".addItemBtn").click(function (e) {
        e.preventDefault();
        var $form = $(this).closest(".form-submit");
        var pid = $form.find(".pid").val();
        var pname = $form.find(".pname").val();
        var pprice = $form.find(".pprice").val();
        var pimage = $form.find(".pimage").val();
        var pcode = $form.find(".pcode").val();


        var pqty = $form.find(".pqty").val();
        var size = $form.find('[name="size"]').val();
        var tel = $form.find('[name="tel"]').val();
        var sign = $form.find('[name="sign"]').val();
        var color = $form.find('[name="color"]').val();

        $.ajax({
          url: 'action.php',
          method: 'post',
          data: {
            pid: pid,
            pname: pname,
            pprice: pprice,
            pqty: pqty,
            pimage: pimage,
            pcode: pcode,
            size: size,
            color: color,
            tel:tel,
            sign:sign
          },
          success: function (response) {
            $("#message").html(response);
            window.scrollTo(0, 0);
          }
        });
      });      
    });
  </script>
</body>

</html>