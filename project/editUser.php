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
    <title>Add User</title>
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
    input[type=submit]:hover{
        background-color: #333;
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
                    <div class="col-lg-12 col-md-9 col-sm-12">
<h3>Users</h3>
    <?php
include "config.php";

$sql = "SELECT * FROM user;";
$result = $conn->query($sql);

echo "<table>";
echo "<tr>";
echo "<th>Name</th>";
echo "<th>Surname</th>";
echo "<th>Level</th>";
echo "<th>Username</th>";
echo "<th>Password</th>";
echo "<th>Edit</th>";
echo "</tr>";

while($row = mysqli_fetch_array($result)) {

    $userID = $row['userID'];
    $name = $row['name'];
    $surname = $row['surname'];
    $username = $row['username'];
    $password = $row['password'];
    
    $sql2 = "SELECT DISTINCT levelName FROM accesslevel WHERE levelID = '".$row['accessLevel']."';";
    $result2 = $conn->query($sql2);
    $row2 = mysqli_fetch_array($result2);
    $levelName = $row2['levelName'];
    
    echo "<tr>";
    echo "<td>" . $name . "</td>";
    echo "<td>" . $surname . "</td>";
    echo "<td>" . $levelName . "</td>";
    echo "<td>" . $username . "</td>";
    echo "<td>" . $password . "</td>";
    echo "<td><form method='post' action='editUser.php' style='all:initial;'>";
    echo "<input type='hidden' name='userID' value='$userID'>";
    echo "<input type='submit' value='Edit'>";
    echo "</form></td>";
    echo "</tr>";
}
echo "</table>";
?>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        
<?php
if (isset($_POST['userID'])) {
    $userID = $_POST['userID'];
    
    $sql3 = "SELECT * FROM user WHERE userID = '$userID';";
    $result3 = $conn->query($sql3);
    $row3 = mysqli_fetch_array($result3);
    
    $name = $row3['name'];
    $levelID = $row3['accessLevel'];
    $surname = $row3['surname'];
    $username = $row3['username'];
    $password = $row3['password'];
    
    $sql4 = "SELECT DISTINCT levelName FROM accesslevel WHERE levelID = '$levelID';";
    $result4 = $conn->query($sql4);
    $row4 = mysqli_fetch_array($result4);
    $levelName = $row4['levelName'];
    
    echo "<form method='post' action='editUser.php'>";
    echo "<h3>Edit User</h3>";
    echo "<input type='hidden' name='userID' value='$userID'>" ;
    echo "<label>Name:</label><input type='text' name='name' value='$name'>";
    echo "<label>Surname:</label><input type='text' name='surname' value='$surname'>";
    echo "<label>Username:</label><input type='text' name='username' value='$username'>";
    echo "<label>Password:</label><input type='text' name='password' value='$password'>";
    echo "<label>User Level:</label><select name='levelName'>";
    echo "<option value='$levelName' selected>$levelName</option>";

    $sql5 = "SELECT DISTINCT levelName FROM accesslevel;";
    $result5 = $conn->query($sql5);
    
    while($row5 = mysqli_fetch_array($result5)) {
      if($row5['levelName']!=$levelName){
        echo "<option value='".$row5['levelName']."'>".$row5['levelName']."</option>";
    }}
    echo "</select><br><br>";
    echo "<input type='submit' value='Update'>";
    echo "</form>";
}

if (isset($_POST['name'])) {
    $userID = $_POST['userID'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $levelName = $_POST['levelName'];
    
    $sql6 = "SELECT DISTINCT levelID FROM accesslevel WHERE levelName = '$levelName';";
    $result6 = $conn->query($sql6);
    $row6 = mysqli_fetch_array($result6);
    $levelID = $row6['levelID'];
    

    $sql7 = "UPDATE user SET name = '$name', surname = '$surname',accessLevel = '$levelID', username = '$username', password = '$password' WHERE userID = '$userID';";
    $result7 = $conn->query($sql7);
    echo "<script>window.location.href = 'editUser.php';</script>";
}
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
                <button type="button" class="btn btn-primary btn-lg btn-floating mx-2"
                    style="background-color: #4A4A4A;">
                    <i class="fab fa-facebook-f"></i>
                </button>
                <button type="button" class="btn btn-primary btn-lg btn-floating mx-2"
                    style="background-color: #4A4A4A;">
                    <i class="fab fa-youtube"></i>
                </button>
                <button type="button" class="btn btn-primary btn-lg btn-floating mx-2"
                    style="background-color: #4A4A4A;">
                    <i class="fab fa-instagram"></i>
                </button>
                <button type="button" class="btn btn-primary btn-lg btn-floating mx-2"
                    style="background-color: #4A4A4A;">
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