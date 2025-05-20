<?php
session_start();
$loggedIn = isset($_SESSION['username']) ? true : false;
$username = $loggedIn ? $_SESSION['username'] : '';

// Database connection
require_once "database.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle cart item removal
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['remove_item'])) {
        $cart_id = $_POST['cart_id'];
        $sql = "DELETE FROM cart WHERE cart_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $cart_id);
        $stmt->execute();
        echo "<script>
          alert('Item removed');
          window.location.href = 'addtocart.php';
        </script>";
    }

    // Handle cart item quantity update
    if (isset($_POST['update_quantity'])) {
        $cart_id = $_POST['cart_id'];
        $quantity = $_POST['quantity'];
        $sql = "UPDATE cart SET quantity = ? WHERE cart_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $quantity, $cart_id);
        $stmt->execute();
        echo "<script>

          window.location.href = 'addtocart.php';
        </script>";
           // alert('Quantity updated');
    }

    
}



// Prepare the SQL query to join cart and products tables
$session_id = session_id();
$sql = "SELECT cart.cart_id, products.p_name, products.p_price, cart.quantity 
        FROM cart 
        JOIN products ON cart.product_id = products.p_id 
        WHERE cart.session_id = ? AND cart.username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $session_id, $username); // Bind both session_id and username
$stmt->execute();
$result = $stmt->get_result();


$sql = "SELECT SUM(quantity) AS total_quantity
        FROM cart
        WHERE username = ?";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("s", $username); // Bind username
    $stmt->execute();
    $stmt->bind_result($total_quantity); // Bind the result to a variable
    $stmt->fetch();



    $stmt->close();
} else {
    echo "Error preparing statement: " . $conn->error;
}




// Fetch user details based on username
$email = '';
$phone = '';

if ($loggedIn) {
    $sql = "SELECT email, phonenumber FROM signup WHERE username = ?"; // Adjust table and columns as needed
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $username); // Bind username
        $stmt->execute();
        $stmt->bind_result($email, $phone); // Bind results to variables
        $stmt->fetch();
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
        $(document).ready(function() {
            var isLoggedIn = <?php echo json_encode($loggedIn); ?>;
            var username = <?php echo json_encode($username); ?>;
            
            if (isLoggedIn) {
                $('.login-status').html('<a class="buy"  href="logout.php">Log Out </a><span class="username " style="margin-left:10px; font-size:15px;">WELCOME, ' + username + '</span>');
            } else {
                $('.login-status').html('<a class="buy"  href="loginPage.php">Login</a>');
            }
        });
    </script>
<style>
   .username {
      background: #ffc221;
      padding: 7px 41px !important;
      margin-top: 18px;
      border-radius: 5px;
      display: inline-block;
      padding: 7px 40px !important;
      color: black;

   }
</style> 


<!DOCTYPE html>
<html lang="en">

<head>
  <style>
    @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');

    body1 {
      display: grid;
      height: 100%;
      place-items: center;
      text-align: center;
    }

    .container1 {
      position: relative;
      width: 400px;
      background: #111;
      padding: 20px 30px;
      border: 1px solid #444;
      border-radius: 5px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
    }

    .container1 .post {
      display: none;
    }

    .container1 .text {
      font-size: 25px;
      color: #666;
      font-weight: 500;
    }

    .container1 .edit {
      position: absolute;
      right: 10px;
      top: 5px;
      font-size: 16px;
      color: #666;
      font-weight: 500;
      cursor: pointer;
    }

    .container1 .edit:hover {
      text-decoration: underline;
    }

    .container1 .star-widget input {
      display: none;
    }

    .star-widget label {
      font-size: 40px;
      color: #444;
      padding: 10px;
      float: right;
      transition: all 0.2s ease;
    }

    input:not(:checked)~label:hover,
    input:not(:checked)~label:hover~label {
      color: #fd4;
    }

    input:checked~label {
      color: #fd4;
    }

    input#rate-5:checked~label {
      color: #fe7;
      text-shadow: 0 0 20px #952;
    }

    #rate-1:checked~form header:before {
      content: "I just hate it ";
    }

    #rate-2:checked~form header:before {
      content: "I don't like it ";
    }

    #rate-3:checked~form header:before {
      content: "It is awesome ";
    }

    #rate-4:checked~form header:before {
      content: "I just like it ";
    }

    #rate-5:checked~form header:before {
      content: "I just love it ";
    }

    .container1 form {
      display: none;
    }

    input:checked~form {
      display: block;
    }

    form header {
      width: 100%;
      font-size: 25px;
      color: #fe7;
      font-weight: 500;
      margin: 5px 0 20px 0;
      text-align: center;
      transition: all 0.2s ease;
    }

    form .textarea {
      height: 100px;
      width: 100%;
      overflow: hidden;
    }

    form .textarea textarea {
      height: 100%;
      width: 100%;
      outline: none;
      color: #eee;
      border: 1px solid #333;
      background: #222;
      padding: 10px;
      font-size: 17px;
      resize: none;
    }

    .textarea textarea:focus {
      border-color: #444;
    }

    form .btn {
      height: 45px;
      width: 100%;
      margin: 15px 0;
    }

    form .btn button {
      height: 100%;
      width: 100%;
      border: 1px solid #444;
      outline: none;
      background: #222;
      color: #999;
      font-size: 17px;
      font-weight: 500;
      text-transform: uppercase;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    form .btn button:hover {
      background: #1b1b1b;
    }

    .xyz {
      position: relative;
    }

    .xyz img {
      position: absolute;
      top: 0;
      right: 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    table,
    th,
    td {
      border: 1px solid #ddd;
    }

    th,
    td {
      padding: 15px;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
    }

    .cart-actions {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .update-quantity,
    .remove-item {
      background-color: #f0c14b;
      border: 1px solid #a88734;
      border-radius: 3px;
      color: #111;
      cursor: pointer;
      padding: 5px 10px;
      font-size: 14px;
      text-transform: uppercase;
      transition: background-color 0.3s;
    }

    .update-quantity:hover,
    .remove-item:hover {
      background-color: #ddb347;
    }

    .cart-icon {
      position: relative;
      display: inline-block;
    }

    .quantity-badge {
      position: absolute;
      top: -5px;
      /* Adjust based on your needs */
      right: -5px;
      /* Adjust based on your needs */
      background-color: red;
      /* Badge color */
      color: white;
      /* Text color */
      border-radius: 50%;
      padding: 2px 5px;
      font-size: 12px;
      /* Adjust font size as needed */
      font-weight: bold;
      text-align: center;
      width: 20px;
      /* Adjust width as needed */
      height: 20px;
      /* Adjust height as needed */
      line-height: 20px;
      /* Center text vertically */
    }

    .menu-area-main li {
      transition: all 0.3s ease;
      /* Smooth transition for hover effect */
    }

    .menu-area-main li:hover {
      background-color: #ffc221;
      /* Highlight background */
      color: black;
      /* Change text color */
      border-radius: 10px;
      /* Rounded corners */
    }

    .menu-area-main li a {
      color: black;
      /* Inherit text color from the parent */
      text-decoration: none;
      /* Remove underline */
      display: block;
      /* Ensure hover applies to the entire area, including padding */
      padding: 10px 15px;
      /* Add padding for clickable area */

    }

    .menu-area-main li:hover a {
      color: black;
      /* Ensure text color remains black when hovered */
    }
  </style>
  <meta charset="utf-8">



  <!-- basic -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- mobile metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="initial-scale=1, maximum-scale=1">
  <!-- site metas -->
  <title>AK Sports</title>
  <meta name="keywords" content="">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- bootstrap css -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- style css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- Responsive-->
  <link rel="stylesheet" href="css/responsive.css">
  <!-- fevicon -->
  <link rel="icon" href="images/fevicon.png" type="image/gif" />
  <!-- Scrollbar Custom CSS -->
  <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
  <!-- Tweaks for older IEs-->
  <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css"
    media="screen">
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  <meta charset="utf-8">
  <title>Star Rating Form | CodingNepal</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />


</head>
<!-- body -->

<body class="main-layout">
  <!-- loader  -->

  <div class="loader_bg">
    <div class="loader"><img src="images/loading.gif" alt="#" /></div>
  </div>
  <!-- end loader -->
  <!-- header -->
  <header>
    <!-- header inner -->

    <div>
      <div class="row">
        <div style="margin-left:50px;"><a href="index.php">
      <img src="images/logo1.png" alt="AK Sports" style=" height: 90px; width: 90px; margin-top: 5%; "/>
   </a></div>
        <div class="col-md-7">
          <div class="menu-area">
            <div class="limit-box">
              <nav class="main-menu">
                <ul class="menu-area-main mt-3"
                  style="display: flex; gap: 20px; list-style: none; margin: 0; padding: 0; justify-content: center; font-size: 16px;">
                  <li><a href="index.php">Home</a></li>
                  <li><a href="about.php">About</a></li>
                  <li><a href="product1.php">Products</a></li>
                  <li><a href="contact.php">Contact</a></li>
                  <li class="active">
                    <a href="addToCart.php">
                      <div class="cart-icon">
                        <img src="icon/cart.png" height="30px" width="30px" alt="Cart">
                        <span class="quantity-badge">
                          <?php echo $total_quantity ? $total_quantity : 0; ?>
                        </span>
                      </div>
                    </a>
                  </li>
                </ul>
              </nav>

            </div>
          </div>
        </div>
        <div class="">
          <li class="login-status"></li> <!-- Placeholder for login or user info -->

        </div>
      </div>
    </div>
    <!-- end header inner -->
  </header>
  <!-- end header -->


  <div class="bg-dark text-white text-center p-3">
    <h1 class="text-white"> YOUR CART</h1>
  </div>


  <div class="col-md-12 row">
    <div class="col-md-8">
      <table>
        <tr>
          <th>Product Name</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Total</th>
          <th>Actions</th>
        </tr>
        <?php
            if ($result->num_rows > 0) {
                $total_amount = 0;
                while ($row = $result->fetch_assoc()) {
                    $total = $row['p_price'] * $row['quantity'];
                    $total_amount += $total;
                    echo "<tr>
                            <td>{$row['p_name']}</td>
                            <td>₹{$row['p_price']}</td>
                            <td>
                                <form method='POST' action=''>
                                    <input type='number' name='quantity' value='{$row['quantity']}' min='1' style='width: 50px;'>
                                    <input type='hidden' name='cart_id' value='{$row['cart_id']}'>
                                    <button type='submit' name='update_quantity' class='update-quantity'>Update</button>
                                </form>
                            </td>
                            <td>₹{$total}</td>
                            <td>
                                <form method='POST' action=''>
                                    <input type='hidden' name='cart_id' value='{$row['cart_id']}'>
                                    <button type='submit' name='remove_item' class='remove-item'>Remove</button>
                                </form>
                            </td>
                          </tr>";
                }
                echo "<tr>
                        <td colspan='3' style='text-align:right; font-weight:bold;'>Total Amount</td>
                        <td colspan='2'>₹{$total_amount}</td>
                      </tr>";
            } else {
                echo "<tr><td colspan='5' style='text-align:center;'>Your cart is empty</td></tr>";
            }
            ?>
      </table>
      <div class="cart-actions">
        <a href="product1.php" class="update-quantity">Continue Shopping</a>

      </div>
    </div>
    <?php
      $sr = 1;
      
      if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $value) {
          // Retrieve the quantity from the session if available
         
        

          echo "
          <tr>
            <td>$sr</td>
            <td>$value[item_name]</td>
            <td>$value[price]<input type='hidden' class='iprice' value='$value[price]'></td>
            <td>
              <input class='text-center iquantity' onchange='subtotal()' type='number' value='$value[Quantity]' min='1' max='10'>
            </td>
            <td class='itotal'></td>
            <td>
              <form action='manageCart.php' method='post'>
                <button name='remove_item' class='btn btn-sm btn-outline-danger'>REMOVE</button>
                <input type='hidden' name='item_name' value='$value[item_name]'>
              </form>
            </td>
          </tr>
          ";
          $sr++;
        }
      }
      ?>

    <div class="col-md-4">
      <div class="parent-container">
        <div>
          <div class="border bg-light rounded p-4">
            <h2 class="bg-dark text-white p-2">Total</h2>
            <div style=" display: flex;
            align-items: center;
            justify-content: center;">
              <br><br><br>
              <h1>₹
                <?php
          // Check if total_amount is defined, if not set it to 0
          if (!isset($total_amount)) {
              $total_amount = 0;
          }
          echo $total_amount;
          $_SESSION["gtotal"] = $total_amount;
          ?>
              </h1>
              <!-- <h1 class="text-center" id="gtotal"></h1> -->
            </div>

            <br>

            <!-- <form action="transaction_form.php" method="POST" onsubmit="return addTotalToForm()">
      <div class="form-group">
                <input type="text" placeholder="Enter user name:" name="username" class="form-control">
            </div>
            <div class="form-group">
                <input type="Email" placeholder="Enter Email:" name="Email" class="form-control">
            </div>
            <div class="form-group">
                <input type="Phone" placeholder="Enter phone Number:" name="phone" class="form-control">
            </div>
        <input type="hidden" name="gtotal" id="hiddenGtotal">
        <button class="btn btn-primary btn-block" type="submit">Purchase</button>
      </form> -->
            <form action="transaction_form.php" method="POST" onsubmit="return addTotalToForm()">
              <div class="form-group">
                <input type="text" placeholder="Enter user name:" name="username" class="form-control"
                  value="<?php echo htmlspecialchars($username); ?>" readonly>
              </div>
              <div class="form-group">
                <input type="email" placeholder="Enter Email:" name="Email" class="form-control"
                  value="<?php echo htmlspecialchars($email); ?>" readonly>
              </div>
              <div class="form-group">
                <input type="phone" placeholder="Enter phone Number:" name="phone" class="form-control"
                  value="<?php echo htmlspecialchars($phone); ?>" readonly>
              </div>
              <input type="hidden" name="gtotal" id="hiddenGtotal">
              <button class="btn btn-primary btn-block" type="submit">Purchase</button>
            </form>

            <script>
              function addTotalToForm() {
                // Example of setting a total quantity value; adjust logic as needed
                var totalQuantity = 10; // Replace with dynamic value as needed
                document.getElementById('hiddenGtotal').value = totalQuantity;
                return true; // Ensure the form submits
              }
            </script>


          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- <div class="col-lg-9">
  <table class="table">
    <thead class="text-center">
      <tr>
        <th scope="col">Serial No.</th>
        <th scope="col">Item Name</th>
        <th scope="col">Price</th>
        <th scope="col">Quantity</th>
        <th scope="col">Total</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody class="text-center">
      
    </tbody>
  </table>
</div>
<br>
 -->



  <!-- <div class="parent-container" style="display: flex;">
  <div class="col-lg-3" style="margin-left: auto;">
    <div class="border bg-light rounded p-4">
      <h2>Total</h2>
      <h1 class="text-center" id="gtotal"></h1>
      <br>
      
      <form action="transaction_form.php" method="POST" onsubmit="subtotal()">
        <button class="btn btn-primary btn-block" type="submit">Purchase</button>
      </form>
     
    </div>
  </div>
</div> -->






  <script>
    var gt = 0;
    var iprice = document.getElementsByClassName('iprice');
    var iquantity = document.getElementsByClassName('iquantity');
    var itotal = document.getElementsByClassName('itotal');
    var gtotal = document.getElementById('gtotal');
    var hiddenGtotal = document.getElementById('hiddenGtotal');

    function subtotal() {
      gt = 0;
      for (var i = 0; i < iprice.length; i++) {
        itotal[i].innerText = (iprice[i].value) * (iquantity[i].value);
        gt += (iprice[i].value) * (iquantity[i].value);
      }
      gtotal.innerText = gt;
    }

    function addTotalToForm() {
      subtotal();
      hiddenGtotal.value = gt;
      return true; // Ensures the form is submitted
    }

    // Call the subtotal function to display the initial totals when the page loads
    window.onload = subtotal;
  </script>






  <!-- end Lastestnews -->
  <!--  footer -->
  <footr>
    <div class="footer">
      <div class="container">

        <div class="row">
          <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
            <div class="contact">
            <h3>Contact us</h3>
                     <span>Email: aksports11703@gmail.com<br>
                           Mobile: +91 86521 43575<br>
                           Facebook: Our Facebook Page<br>
                           Address: Jogeshwari (E), Mumbai, India
                     </span>
            </div>
          </div>
          <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
            <div class="contact">
              <h3>ADDITIONAL LINKS</h3>
              <ul class="lik">
                <li> <a href="about.php">About us</a></li>
                <li> <a href="product1.php">Our Product</a></li>
                <li> <a href="contact.php">Contact us</a></li>
              </ul>
            </div>
          </div>
          <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
            <div class="contact">
              <h3>service</h3>
              <ul class="lik">
                <li> <a href="#"> </a></li>
                <li> <a href="#">Secure payments</a></li>
                <li> <a href="#">Expert team</a></li>
                <li> <a href="#">Affordable services</a></li>
            </div>
          </div>
        </div>
        <br><br><br>
      </div>
  </footr>
  <!-- end footer -->
  <!-- Javascript files-->
  <script src="js/jquery.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/jquery-3.0.0.min.js"></script>
  <script src="js/plugin.js"></script>
  <!-- sidebar -->
  <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="js/custom.js"></script>
  <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
  <script>
    $(document).ready(function () {
      $(".fancybox").fancybox({
        openEffect: "none",
        closeEffect: "none"
      });

      $(".zoom").hover(function () {

        $(this).addClass('transition');
      }, function () {

        $(this).removeClass('transition');
      });
    });

  </script>
</body>

</html>