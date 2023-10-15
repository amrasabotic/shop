<?php
//check if session is created
session_start();
if(isset($_SESSION['username']) && !empty($_SESSION['username'])) {
	$username = $_SESSION['username'];
  $accessL= $_SESSION['accessLevel']; 
}else{
	header("Location: login.php");
}
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
  <title>Add Product</title>
</head>
<style>
  form {
    margin: 10px 0;
    border: 1px solid black;
    padding: 25px;
  }

  form label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
  }

  form input {
    width: 200px;
    padding: 3px;
    border: 1px solid #ccc;
    margin-bottom: 10px;
  }

  form select {
    width: 200px;
    padding: 3px;
    border: 1px solid #ccc;
    margin-bottom: 10px;
  }

  table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
  }

  td,
  th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
  }

  tr:nth-child(even) {
    background-color: #dddddd;
  }

  @media only screen and (max-width: 600px) {
    .responsive-table {
      width: 100%;
    }

    .responsive-table th {
      text-align: left;
      width: auto;
    }

    .responsive-table td {
      display: block;
      text-align: left;
      width: auto;
    }

  }

  @media only screen and (max-width:760px) {
    table th {
      border: none;
      clip: rect(0 0 0 0);
      height: 1px;
      margin: -1px;
      overflow: hidden;
      padding: 0;
      position: absolute;
      width: 1px;
    }

    table tr {
      border-bottom: 3px solid #ddd;
      display: block;
      margin-bottom: .625em;
    }

    table td {
      border-bottom: 1px solid #ddd;
      display: block;
      font-size: .8em;
      text-align: right;
    }

    table td::before {
      content: attr(data-label);
      float: left;
      font-weight: bold;
      text-transform: uppercase;
    }

    table td:last-child {
      border-bottom: 0;
    }
  }

  table {
    border: 1px solid #ccc;
    border-collapse: collapse;
    margin: 5% 0;
    padding: 0;
    width: 100%;
    table-layout: fixed;
  }

  table tr {
    background-color: #f8f8f8;
    border: 1px solid #ddd;
    padding: .35em;
  }

  table th,
  table td {
    padding: .625em;
    text-align: center;
  }

  table th {
    font-size: .85em;
    letter-spacing: .1em;
    text-transform: uppercase;
  }

  table tr:hover td {
    background-color: #e0e0d1;
    color: black;
  }
</style>

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
    <div class="row" style="position:relative;">
      <div class="container">
        <div class="products">
          <div class="row">
            <h3>Available Products</h3>


            <div class="col-12">
              <?php
    include "config.php";
$sql = "SELECT * FROM item";
$query = mysqli_query($conn, $sql);

echo "<table>";
echo "<tr>";
echo "<th>Name</th>";
echo "<th>Material</th>";
echo "<th>Price</th>";
echo "<th>Description</th>";
echo "<th>Image</th>";
echo "<th>Quantity</th>";

echo "</tr>";

while ($row = mysqli_fetch_array($query)) {
  echo "<tr>";
  echo "<td>" . $row['itemName'] . "</td>";
  echo "<td>" . $row['material'] . "</td>";
  echo "<td>" . $row['price'] . "</td>";
  echo "<td>" . $row['description'] . "</td>";
  //echo "<td>" . $row['image'] . "</td>";
  ?>
              <td><img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']); ?>"
                  class="img-fluid mb-2 img-thumbnail" style="height:100px; width:100px;" /> </td>
              <?php
  echo "<td>" . $row['quantity'] . "</td>";

  echo "</tr>";
}
echo "</table>";

mysqli_close($conn);
?>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12">

              <?php
include "config.php";

$stmt = $conn->prepare("INSERT INTO item (itemName, material, price, description, signID,image, quantity, categoryID, product_code ) VALUES (?,?,?,?,?,?,?,?,?)");


$stmt->bind_param("ssisisiis", $itemName, $material, $price, $description, $signID, $image, $quantity, $categoryID, $product_code);
if(isset($_POST['Submit'])){

$itemName = $_POST['name'];
$material = $_POST['material'];
$price = $_POST['price'];
$description = $_POST['description'];
$signID = $_POST['signID'];
$image = $_POST['image'];
$quantity = $_POST['quantity'];
$categoryID = $_POST['categoryID'];
$product_code = $_POST['code'];



$stmt->execute();
}
$sqlCat = "SELECT categoryID, category FROM `category`";
$sqlBrand = "SELECT signID, signName FROM `sign`";


$resultCat = mysqli_query($conn, $sqlCat);
$resultBrand = mysqli_query($conn, $sqlBrand);


$stmt->close();
$conn->close();

?>

              <form action="addProduct.php" method="post">
                <h3>Add product</h3>
                <label>Name: </label> <input type="text" name="name" style="margin-bottom: 15px;"><br>
                <label>Description: </label> <input type="text" name="description" style="margin-bottom: 15px ;"><br>
                <label>Material: </label> <input type="text" name="material" style="margin-bottom: 15px ;"><br>
                <label>Image: </label> <input type="file" name="image" style="margin-bottom: 15px ;"><br>
                <label>Quantity: </label> <input type="text" name="quantity" style="margin-bottom: 15px ;"><br>
                <label>Price: </label> <input type="text" name="price" style="margin-bottom: 15px ;"><br>
                <label>Code: </label><input type="text" name="code" style="margin-bottom: 15px ;"><br>
                <label>Category: </label> <select name="categoryID" style="margin-bottom: 15px; width:200px;height:35px">
                  <option disabled selected>--Category--</option>
                  <?php
while($rowCat = mysqli_fetch_array($resultCat)){
    echo "<option value='" . $rowCat['categoryID'] . "'>" . $rowCat['category'] . "</option>";
}
?>
                </select><br>
                <label>Sign: </label> <select name="signID" style="margin-bottom: 15px; width:200px; height:35px">
                  <option disabled selected>--Sign--</option>

                  <?php
while($rowBrand = mysqli_fetch_array($resultBrand)){
    echo "<option value='" . $rowBrand['signID'] . "'>" . $rowBrand['signName'] . "</option>";
}
?>
                </select><br><br>

                <input type="submit" value="Submit" name="Submit" style="margin:initial;">
              </form>
            </div>
          </div>
        </div>
      </div>
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