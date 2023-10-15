<?php
    session_start();
    require 'config.php';

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

    // Add products into the cart table
    if (isset($_POST['pid'])) {
      $pid = $_POST['pid'];
      $pname = $_POST['pname'];
      $pprice = $_POST['pprice'];
      $pcode = $_POST['pcode'];
      $pqty = $_POST['pqty'];
      $total_price = $pprice * $pqty;
      $size = $_POST['size'];
      $color = $_POST['color'];
      $tel = $_POST['tel'];
      $sign = $_POST['sign'];
      //var_dump($size);


      $select = $conn->prepare('SELECT * FROM cart WHERE id=?');
      $select->bind_param('s',$pid);
      $select->execute();
      $res = $select->get_result();
      $r = $res->fetch_assoc();
      $code = $r['id'] ?? '';
      //var_dump($code);

      if (!$code) {
        $query = $conn->prepare('INSERT INTO cart (product_name,product_price,qty,total_price,product_code,size,color,tel, `sign`) VALUES (?,?,?,?,?,?,?,?,?)');
        $query->bind_param('sssssssss',$pname,$pprice,$pqty,$total_price,$pcode,$size,$color,$tel,$sign);
        $query->execute();

        echo '<div class="alert alert-success alert-dismissible mt-2">
                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                          <strong>Item added to your cart!</strong>
                        </div>';
      } else {
        echo '<div class="alert alert-danger alert-dismissible mt-2">
                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                          <strong>Item already added to your cart!</strong>
                        </div>';
      }
    }
 
    // Get no.of items available in the cart table
    if (isset($_GET['cartItem']) && isset($_GET['cartItem']) == 'cart_item') {
      $stmt = $conn->prepare('SELECT * FROM cart');
      $stmt->execute();
      $stmt->store_result();
      $rows = $stmt->num_rows;

      echo $rows;
    }

    // Remove single items from cart
    if (isset($_GET['remove'])) {
      $id = $_GET['remove'];

      $stmt = $conn->prepare('DELETE FROM cart WHERE id=?');
      $stmt->bind_param('i',$id);
      $stmt->execute();

      $_SESSION['showAlert'] = 'block';
      $_SESSION['message'] = 'Item removed from the cart!';
      header('location:cart.php');
    }

    // Remove all items at once from cart
    if (isset($_GET['clear'])) {
      $stmt = $conn->prepare('DELETE FROM cart');
      $stmt->execute();
      $_SESSION['showAlert'] = 'block';
      $_SESSION['message'] = 'All Item removed from the cart!';
      header('location:cart.php');
    }

    // Set total price of the product in the cart table
    if (isset($_POST['qty'])) {
      $qty = $_POST['qty'];
      $pid = $_POST['pid'];
      $pprice = $_POST['pprice'];

      $tprice = $qty * $pprice;

      $stmt = $conn->prepare('UPDATE cart SET qty=?, total_price=? WHERE id=?');
      $stmt->bind_param('isi',$qty,$tprice,$pid);
      $stmt->execute();
    }

    // Checkout and save customer info in the orders table
    if (isset($_POST['action']) && isset($_POST['action']) == 'order') {
      $name = $_POST['name'];
      $email = $_POST['email'];
      $phone = $_POST['phone'];
      $products = $_POST['products'];
      $grand_total = $_POST['grand_total'];
      $address = $_POST['address'];
      $pmode = $_POST['pmode'];

      $size = $_POST['size'];
      $color = $_POST['color'];
      $tel = $_POST['tel'];
      $sign = $_POST['sign'];

      $data = '';

      $stmt = $conn->prepare('INSERT INTO orders (name,email,phone,address,pmode,products,amount_paid, size, color, telephonetype, `sign`)VALUES(?,?,?,?,?,?,?,?,?,?,?)');
      $stmt->bind_param('sssssssssss',$name,$email,$phone,$address,$pmode,$products,$grand_total, $size, $color,$tel,$sign);
      $stmt->execute();

   

      // empty the cart once the order is placed
      $stmt2 = $conn->prepare('DELETE FROM cart');
      $stmt2->execute();


  //    $stmt3 = $conn->prepare('SELECT * FROM customer WHERE email = ?');
  //    $stmt3->bind_param('s',$email);
 //     $stmt3->execute();
 //   $result = $stmt3->fetch();
 //     if(!$result){
        //email exists
        $stmt1 = $conn->prepare('INSERT INTO customer (customerName, email) VALUES (?,?)');
        $stmt1->bind_param('ss',$name,$email);
        $stmt1->execute();
        $stmt1->close();
   //   } 

   $stmt4 = $conn->prepare("SELECT customerID FROM customer WHERE email = '$email' ORDER BY customerID DESC LIMIT 1");
   $stmt4->execute();
   $stmt4->bind_result($customerID);
   while($stmt4->fetch()){
     $id = $customerID;
   }
   $stmt4->close();
 
      $stmt5 = $conn->prepare("UPDATE orders SET customerID = '$id' WHERE email = '$email'");
      $stmt5->execute();

      $data .= '<div class="text-center">
                                <h1 class="display-4 mt-2 text-danger">Thank You!</h1>
                                <h2 class="text-success">Your have ordered Successfully!</h2>
                                <h4 class="bg-danger text-light rounded p-2">Ordered Items : ' . $products . '</h4>
                                <h4>Your Name: ' . $name . '</h4>
                                <h4>Your E-mail: ' . $email . '</h4>
                                <h4>Your Phone: ' . $phone . '</h4>
                                <h4>Total: ' . number_format($grand_total,2) . '</h4>
                                <h4>Payment Mode: ' . $pmode . '</h4>

                          </div>';
      echo $data;
    }
?>