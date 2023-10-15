<?php    
    include_once("config.php");
   
    session_start(); //we start a session
    $count=null;
    if (isset($_POST['username']) and isset($_POST['password'])){

            $username = $_POST['username'];
            $password = $_POST['password'];
           
            $query = "SELECT * FROM user WHERE username='$username' and password='$password'";         
            $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
            $count = mysqli_num_rows($result);

            $conn->close();
        }
       
        if (isset($count)){
            if ($count == 1){           
                while($res = mysqli_fetch_array($result)) {        
                    $accessL= $res['accessLevel'];
                    $email = $res['mail'];
                }
                           
            $_SESSION['username'] = $username; //We create a session named "username"
            $_SESSION['accessLevel'] = $accessL; //We create a session named "accessLevel"
            $_SESSION['mail'] = $email;

            header("Location: index.php");
        }else{
            echo  "<p style='text-align: center;color:red;'>Invalid Username or Password.</p>";
        }
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
  <title>Login</title>
</head>

<body>
  <header>
    <div class="topnav" id="myTopnav">
      <a href="index.php"><img src="images/logo1.png" alt="logo"></a>
      <?php



  echo "<a href='index.php'>Home</a> | <a href='#'> Admin Panel </a>| <a href=''>Contact</a> | <a href=''>About</a> |<a href='login.php'>Login</a> ";


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
          <a href='orders.php'><img src='images/orders.png' alt='Orders'><span>Orders</span></a>
          <a href='logout.php'> <img src='images/user.png' alt='Login'><span>Login</span></a>";          }
        ?>
      </div>
    </div>
  </header>
  <div class="content">

    <section class="h-100 gradient-form" style="padding:30px; position:relative">
      <div class="container">
        <div class="row d-flex justify-content-center align-items-center">
          <div class="col-xl-10">
            <div class="card rounded-3 text-black">
              <div class="row g-0">
                <div class="col-xl-10" style="margin: 0 auto ;">
                  <div class="card-body">

                    <div class="text-center">
                      <img src="images/logo1.png" style="width: 185px;" alt="logo">
                      <h4 class="mt-1 mb-5 pb-1" style="color: #478729; font-family: Brush Script MT; font-size:40px;">
                        Welcome to Amra's Online Store</h4>
                      <p class="mt-1 mb-5 pb-1"><em>Please use correct data to login to your account</em></p>
                    </div>

                    <form action="login.php" method="post">

                      <div class="form-outline mb-4">
                        <input type="text" name="username" placeholder="Username" id="form2Example11"
                          class="form-control" />
                      </div>

                      <div class="form-outline mb-4">
                        <input type="password" name="password" placeholder="Password" id="form2Example22"
                          class="form-control" />
                      </div>

                      <div class="text-center pt-1 mb-5 pb-1">
                        <button class="btn btn-success flex-fill btn-block fa-lg gradient-custom-2 mb-3" type="submit"
                          name="submit" value="Login">Log
                          in</button> <br>
                        <a class="text-muted" href="#!">Forgot password?</a>
                      </div>

                      <div class="d-flex align-items-center justify-content-center pb-4">
                        <p class="mb-0 me-2">Don't have an account?</p>
                        <a href="#">Create New Account</a>
                      </div>

                    </form>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!--- Footer --->
  <div class="my-5">
    <footer class="text-center text-lg-start" style="background-color: #333; bottom:0px; left:0px; right:0px;">
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