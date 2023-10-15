<?php
//check if session is created
session_start();
if(isset($_SESSION['username']) && !empty($_SESSION['username'])) {
	$username = $_SESSION['username'];
  $accessL= $_SESSION['accessLevel']; 
  //$customer_id = $_SESSION['customer_id'];
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
    <title>Order Status</title>
</head>
<style>
    form {
        margin: 10px 0;
        border: 1px solid lightgray;
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

    input[type=submit] {
        all: initial;
        background-color: #478729;
        border-radius: 5px;
        color: white;
        padding: 10px 20px;
        margin: 4px 2px;
        cursor: pointer;
    }

    input[type=submit]:hover {
        background-color: #333;
    }
</style>

<body >
    <header>

        <!--- Navigation menu at the top---->

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
    <div class="sadrzaj" style="position: relative;">
    <div class="content" >
        <div class="row" >
            <div class="container">
                <div class="products">
                    <div class="row">
                        <div class="col-12">
                        
                        <?php
// Start the session
$username = $_SESSION['username'];
$email = $_SESSION['mail'];

//getting customerID thorough the session
$stmt4 = $conn->prepare("SELECT customerID FROM customer WHERE email = '$email'");
$stmt4->execute();
$stmt4->bind_result($customerID);
while($stmt4->fetch()){
  $id = $customerID;
}
$stmt4->close();

// Table with the customer's orders
$query = $conn->prepare('SELECT id, name, email, phone, address, pmode, products, amount_paid, purchase_date, `status`
FROM orders
INNER JOIN `status` ON orders.statusID = `status`.statusID 
WHERE customerID=?');
$query->bind_param('i', $id);
$query->execute();
$result = $query->get_result();
echo '<h1 style="text-align: center;">My orders</h1>';
echo '<table>';
echo '<tr>';
echo '<th>ID: </th>';
echo '<th>Name: </th>';
echo '<th>Email: </th>';
echo '<th>Phone: </th>';
echo '<th>Address: </th>';
echo '<th>Payment Mode: </th>';
echo '<th>Products: </th>';
echo '<th>Amount: </th>';
echo '<th>Purchase Date: </th>';
echo '<th>Status: </th>';
echo '</tr>';

// populating table with data from order
while ($row = $result->fetch_assoc()) {
    
    echo '<tr><td>' . $row['id'] . '</td>';
    echo '<td>' . $row['name'] . '</td>';
    echo '<td>' . $row['email'] . '</td>';
    echo '<td>' . $row['phone'] . '</td>';
    echo '<td>' . $row['address'] . '</td>';
    echo '<td>' . $row['pmode'] . '</td>';
    echo '<td>' . $row['products'] . '</td>';
    echo '<td>' . $row['amount_paid'] . ' &euro; </td>';
    echo '<td>' . $row['purchase_date'] . '</td>';
    echo '<td>' . $row['status'] . '</td>';   
}
echo '</table>';

// Close connection
$conn->close();
?>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  </div>
</body>

</html>