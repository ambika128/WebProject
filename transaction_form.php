<?php
    session_start();
  

    if(isset($_POST["submit"])){
        $username1 = $_POST["username"];
        $email = $_POST["email"];
        $phoneNumber = $_POST["phone"];

        echo $email;
        echo $phonenumber;

         echo $_POST['username'];
         echo $_POST['Email'];
         echo $_POST['phone'];

        
    }

    $_SESSION["username1"] = $_POST["username"];
    $_SESSION["email"] = $_POST["Email"];
    $_SESSION["phone"] = $_POST["phone"];
    
   
?>
<?php
$loggedIn = isset($_SESSION['username']) ? true : false;
$username = $loggedIn ? $_SESSION['username'] : '';

require_once "database.php";
?>
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

<!-- <!DOCTYPE html>
<html lang="en">
   <head>

   

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
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
       <style>
         .menu-area-main li {
   transition: all 0.3s ease; /* Smooth transition for hover effect */
}

.menu-area-main li:hover {
   background-color: #ffc221; /* Highlight background */
   color: black; /* Change text color */
   border-radius: 10px; /* Rounded corners */
}

.menu-area-main li a {
   color: black; /* Inherit text color from the parent */
   text-decoration: none; /* Remove underline */
   display: block; /* Ensure hover applies to the entire area, including padding */
   padding: 10px 15px; /* Add padding for clickable area */
   
}

.menu-area-main li:hover a {
   color: black; /* Ensure text color remains black when hovered */
}

      </style>

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
   <ul class="menu-area-main mt-3" style="display: flex; gap: 20px; list-style: none; margin: 0; padding: 0; justify-content: center; font-size: 16px;">
      <li><a href="index.php">Home</a></li>
      <li><a href="about.php">About</a></li>
      <li><a href="product1.php">Products</a></li>
      <li><a href="contact.php">Contact</a></li>
      <li>
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
           <h1 class="text-white"> PAYMENT</h1>
      </div>

    <div class="container border">
   <form id="payment-form" action="paysuccess.php" method="post">
    <center><img src="icon/transaction_img.gif" class="rounded" alt="img" height="50%" width="50%"/></center>
    <div class="mt-1" style="max-width: 600px; margin: -53px auto; padding: 25px; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.36); border-radius: 8px;">
        <h1 style="text-align: center; color: #333;">Payment Confirmation</h1>
        <div style="margin: 20px 0;">
            <p style="font-size: 18px; color: #555; margin: 10px 0;"><b>Username:</b> <?php echo htmlspecialchars($_POST['username']); ?></p>
            <p style="font-size: 18px; color: #555; margin: 10px 0;"><b>Email:</b> <?php echo htmlspecialchars($_POST['Email']); ?></p>
            <p style="font-size: 18px; color: #555; margin: 10px 0;"><b>Phone:</b> <?php echo htmlspecialchars($_POST['phone']); ?></p>
            <p style="font-size: 18px; color: #555; margin: 10px 0;"><b>Amount: </b> ₹<?php echo htmlspecialchars($_SESSION["gtotal"]); ?></p>
        </div>
    </div>
            <div class="form-btn text-center">
                        <button id="rzp-button1" type="submit" class="btn btn-primary">Pay</button>
            </div>
<br><br><br>
            <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
var options = {
    "key": "rzp_test_ox5TgzYsqHFvg", // Enter the Key ID generated from the Dashboard
    "amount": "<?php echo $_SESSION["gtotal"]*100;?>", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
    "currency": "INR",
    "name": "AK SPORTS", //your business name
    "description": "Test Transaction",
    "image": "https://example.com/your_logo",
    "id": "<?php echo $order_id; ?>", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
    "handler": function (response){
      document.getElementById('payment-form').submit();
    },
    "prefill": { //We recommend using the prefill parameter to auto-fill customer's contact information, especially their phone number
        "name": "<?php echo $_POST['username']?>", //your customer's name
        "email": "<?php echo $_POST['Email']?>", 
        "contact": "<?php echo $_POST['phone']?>"  //Provide the customer's phone number for better conversion rates 
    },
    "notes": {
        "address": "Razorpay Corporate Office"
    },
    "theme": {
        "color": "#3399cc"
    }
};

$orderData = [
    'receipt'         => 3456,
    'amount'          => $_SESSION["gtotal"] * 100, // in paise
    'currency'        => 'INR',
    'payment_capture' => 1 
];

$razorpayOrder = $api->order->create($orderData);
$order_id = $razorpayOrder['id'];

var rzp1 = new Razorpay(options);
rzp1.on('payment.failed', function (response){
        alert(response.error.code);
        alert(response.error.description);
        alert(response.error.source);
        alert(response.error.step);
        alert(response.error.reason);
        alert(response.error.metadata.order_id);
        alert(response.error.metadata.payment_id);
});
document.getElementById('rzp-button1').onclick = function(e){
    rzp1.open();
    e.preventDefault();
}
</script>

        
 </form>
    </div>
    <!-- end contact -->
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
         $(document).ready(function(){
         $(".fancybox").fancybox({
         openEffect: "none",
         closeEffect: "none"
         });
         
         $(".zoom").hover(function(){
         
         $(this).addClass('transition');
         }, function(){
         
         $(this).removeClass('transition');
         });
         });
         
      </script> 
   </body>
</html>