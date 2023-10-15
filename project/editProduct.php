<?php
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
            <div class="col-12">
              <h3>Edit Product</h3>
              <?php
include "config.php";

$sql = "SELECT itemID, itemName, material, price, description, signName, image, quantity, category, product_code FROM item
INNER JOIN category ON item.categoryID = category.categoryID 
INNER JOIN `sign` ON item.signID = `sign`.signID";

$result = mysqli_query($conn, $sql);

echo "<table>
<tr>
<th>Name</th>
<th>Description</th>
<th>Image</th>
<th>Category</th>
<th>Material</th>
<th>Quantity</th>
<th>Price</th>
</tr>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['itemName'] . "</td>";
echo "<td>" . $row['description'] . "</td>";
?>
              <td><img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']); ?>"
                  class="img-fluid mb-2 img-thumbnail" style="height:100px; width:100px;" /> </td>
              <?php
//table with products
echo "<td>" . $row['category'] . "</td>";
echo "<td>" . $row['material'] . "</td>";
echo "<td>" . $row['quantity'] . "</td>";
echo "<td>" . $row['price'] . "</td>";
echo "<td>
<form action='' method='POST' style='all: initial;'>
<input type='hidden' name='productid' value='".$row['itemID']."'>
<input type='submit' name='edit' value='Edit' style='width:50px;'>
</form>
</td>";
echo "</tr>";
}
echo "</table>";

if(isset($_POST['edit'])){

$productid = $_POST['productid'];
$sql = "SELECT * FROM item WHERE itemID = '$productid'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$sql1 = "SELECT * FROM category";
$result1 = mysqli_query($conn, $sql1);

$sql2 = "SELECT * FROM `sign`";
$result2 = mysqli_query($conn, $sql2);

//populating a form with record's data
echo "<form action='' method='POST' enctype='multipart/form-data'>
<input type='hidden' name='productid' value='".$row['itemID']."'>
<label>Name: </label> <input type='text' name='itemName' value='".$row['itemName']."'><br>
<label>Description: </label> <input type='text' name='description' value='".$row['description']."'><br>

<label>Category: </label> 
<select name='catid'>";

while($row1 = mysqli_fetch_array($result1))
{
echo "<option value='".$row1['categoryID']."'>".$row1['category']."</option>";
}

echo "</select><br>
<label>Sign: </label>
<select name='signID'>";

while($row2 = mysqli_fetch_array($result2))
{
echo "<option value='".$row2['signID']."'>".$row2['signName']."</option>";
}

echo "</select><br>
<label>Quantity: </label> <input type='text' name='quantity' value='".$row['quantity']."'><br>
<label>Price: </label> <input type='text' name='price' value='".$row['price']."'><br>

<label>Image: </label> <input type='file' name='image'><br>"
?>
              <td><img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']); ?>"
                  class="img-fluid mb-2 img-thumbnail" style="height:100px; width:100px;" /> </td>

              <?php
echo "<br><br><input type='submit' name='update' value='Update' style='margin:initial;'>
</form>";
}

if(isset($_POST['update'])){

// Get data from form and update record
$productid = $_POST['productid'];
$name = $_POST['itemName'];
$desc = $_POST['description'];
$catid = $_POST['catid'];
$signid = $_POST['signID'];
$qty = $_POST['quantity'];
$price = $_POST['price'];

if(empty($_FILES['image']['tmp_name'])){
    $sql = "UPDATE item SET itemName='$name', description='$desc', categoryID='$catid', signID='$signid', quantity='$qty', price='$price' WHERE itemID='$productid'";
}
else{
    $image = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
    $sql = "UPDATE item SET itemName='$name', description='$desc', image='$image', categoryID='$catid', signID='$signid', quantity='$qty', price='$price' WHERE itemID='$productid'";
}


if (mysqli_query($conn, $sql)) {
    echo "Record updated successfully";
    echo "<script>window.location.href = 'editProduct.php';</script>"; //reload page
}

}

mysqli_close($conn);
?>

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