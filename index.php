<?php
session_start();
$loggedIn = isset($_SESSION['username']) ? true : false;
$username = $loggedIn ? $_SESSION['username'] : '';
require_once "database.php";
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
   <style>
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

      .pricebtn {
         margin-top: 20px;
         /* Push the button to the bottom */
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
         <div style="margin-left:50px;">
   <a href="index.php">
      <img src="images/logo1.png" alt="AK Sports" style=" height: 90px; width: 90px; margin-top: 5%; "/>
   </a>
</div>
            <div class="col-md-7">
               <div class="menu-area">
                  <div class="limit-box">
                     <nav class="main-menu">
                        <ul class="menu-area-main mt-3"
                           style="display: flex; gap: 20px; list-style: none; margin: 0; padding: 0; justify-content: center; font-size: 16px;">
                           <li class="active"><a href="index.php">Home</a></li>
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
   <section class="slider_section mt-2">
      <div id="main_slider" class="carousel slide banner-main" data-ride="carousel">

         <div class="carousel-inner">
            <div class="carousel-item active">
               <img class="first-slide" src="images/banner.jpg" alt="First slide" width="100%">

            </div>
         </div>
      </div>
   </section>

   <!-- CHOOSE  -->
   <div class="whyschose">
   <div class="container">
      <div class="row">
         <div class="col-md-7 offset-md-3">
            <div class="title text-center p-5">
               <h2>Why <strong class="black">Choose AK Sports</strong></h2>
               <span>Premium Quality Sportswear at the Best Prices!</span>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="p-5">
   <div class="container">
      <div class="white_bg">
         <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 p-5 border rounded">
               <div class="for_box">
                  <i><img src="images/quality-wear.jpg" class="rounded" width="250px" height="250px" /></i>
                  <h3 class="mt-4">High-Quality Sportswear</h3>
                  <p>At AK Sports, we offer premium, durable, and breathable activewear that keeps up with your performance on and off the field.</p>
               </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 p-5 border rounded">
               <div class="for_box">
                  <i><img src="images/affordable.jpg" class="rounded" width="250px" height="250px" /></i>
                  <h3 class="mt-4">Affordable & Stylish</h3>
                  <p>Enjoy the perfect blend of style and comfort at pocket-friendly prices. Look good, feel great, and stay on budget.</p>
               </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 p-5 border rounded">
               <div class="for_box">
                  <i><img src="images/mobile-friendly.jpg" class="rounded" width="250px" height="250px" /></i>
                  <h3 class="mt-4">Easy Online Shopping</h3>
                  <p>Our website is fully mobile-friendly, making it easy to browse, select, and order your favorite apparel on the go.</p>
               </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 p-5 border rounded">
               <div class="for_box">
                  <i><img src="images/support.jpg" class="rounded" width="250px" height="250px" /></i>
                  <h3 class="mt-4">Customer Support</h3>
                  <p>Need help with an order or product? Our friendly support team is always ready to assist you anytime.</p>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

   <!-- end CHOOSE -->

   <!-- service -->
   <div class="service mt-5">
   <div class="container">
      <div class="row">
         <div class="col-md-8 offset-md-2">
            <div class="title text-center">
               <h2>Our <strong class="black">Services</strong></h2>
               <h3>Seamless Shopping Experience from Start to Finish</h3>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
            <div class="service-box text-center p-3">
               <i><img src="images/fast-delivery.png" alt="Fast Delivery" /></i>
               <h3>Fast Delivery</h3>
               <p>Get your favorite sportswear delivered quickly and safely right to your doorstep across India.</p>
            </div>
         </div>
         <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
            <div class="service-box text-center p-3">
               <i><img src="images/secure-payment.png" alt="Secure Payments" /></i>
               <h3>Secure Payments</h3>
               <p>Shop with confidence using our trusted and encrypted online payment gateways.</p>
            </div>
         </div>
         <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
            <div class="service-box text-center p-3">
               <i><img src="images/quality-products.png" alt="Quality Products" /></i>
               <h3>Premium Quality</h3>
               <p>All our apparel is made from top-notch, breathable fabrics designed for performance and comfort.</p>
            </div>
         </div>
         <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
            <div class="service-box text-center p-3">
               <i><img src="images/return-policy.png" alt="Easy Returns" /></i>
               <h3>Easy Returns</h3>
               <p>Not happy with your order? Enjoy hassle-free returns and exchanges within 7 days of delivery.</p>
            </div>
         </div>
         <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
            <div class="service-box text-center p-3">
               <i><img src="images/customer-support.png" alt="Customer Support" /></i>
               <h3>24/7 Support</h3>
               <p>Our team is always available to assist you with queries, orders, or size guidance.</p>
            </div>
         </div>
         <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
            <div class="service-box text-center p-3">
               <i><img src="images/loyalty-rewards.png" alt="Loyalty Program" /></i>
               <h3>Loyalty Rewards</h3>
               <p>Earn points with every purchase and unlock exclusive discounts and early access to new arrivals.</p>
            </div>
         </div>
      </div>
   </div>
</div>

   <!-- end service -->

   <!-- our product -->
   <div class="product mt-5">
      <div class="container">
         <div class="row">

         </div>
      </div>
   </div>
   <div class=" p-5">
      <div class="col-md-12">
         <div class="title">
            <h2>our <strong class="black">Products</strong></h2>
         </div>
      </div>
      <div class="product-bg-white p-5">
   <div class="container">

      <h2 class="text-center mb-4 border border-1 border-dark bg-dark text-light p-2 rounded">Sports Outfit</h2>
      <div class="row justify-content-center">
         <!-- Product 1 -->
         <div class="col-md-3 col-sm-6 text-center border rounded m-2">
            <div class="product-box">
               <i><img src="images/img-1.jpg" class="img-fluid" /></i>
               <h5 class="border rounded p-2">Cricket Jerseys</h5>
               <a href="product1.php"><button class="btn btn-success pricebtn">₹200/-</button></a>
            </div>
         </div>
         <!-- Product 2 -->
         <div class="col-md-3 col-sm-6 text-center border rounded m-2">
            <div class="product-box">
               <i><img src="images/img-2.jpg" class="img-fluid" /></i>
               <h5 class="border rounded p-2">Football Jerseys</h5>
               <a href="product1.php"><button class="btn btn-success pricebtn">₹300/-</button></a>
            </div>
         </div>
         <!-- Product 3 -->
         <div class="col-md-3 col-sm-6 text-center border rounded m-2">
            <div class="product-box">
               <i><img src="images/img-3.jpg" class="img-fluid p-3" /></i>
               <h5 class="border rounded p-2">Kabaddi Jerseys</h5>
               <a href="product1.php"><button class="btn btn-success pricebtn">₹200/-</button></a>
            </div>
         </div>
         <!-- Product 4 -->
         <div class="col-md-3 col-sm-6 text-center border rounded m-2">
            <div class="product-box">
               <i><img src="images/img-4.jpg" class="img-fluid p-3" /></i>
               <h5 class="border rounded p-2">Premium Jerseys</h5>
               <a href="product1.php"><button class="btn btn-success pricebtn">₹200/-</button></a>
            </div>
         </div>
         <!-- Product 5 -->
         <div class="col-md-3 col-sm-6 text-center border rounded m-2">
            <div class="product-box">
               <i><img src="images/img-5.jpg" class="img-fluid p-3" /></i>
               <h5 class="border rounded p-2">Comfortable Jerseys</h5>
               <a href="product1.php"><button class="btn btn-success pricebtn">₹200/-</button></a>
            </div>
         </div>
      </div>

      <h2 class="text-center my-5 border border-1 border-dark bg-dark text-light p-2 rounded">Festival Outfit</h2>
      <div class="row justify-content-center">
         <!-- Product 6-10 -->
         <div class="col-md-3 col-sm-6 text-center border rounded m-2">
            <div class="product-box">
               <i><img src="images/img-6.jpg" class="img-fluid p-3" /></i>
               <h5 class="border rounded p-2">Ganpati Jerseys</h5>
               <a href="product1.php"><button class="btn btn-success pricebtn">₹500/-</button></a>
            </div>
         </div>
         <div class="col-md-3 col-sm-6 text-center border rounded m-2">
            <div class="product-box">
               <i><img src="images/img-7.jpg" class="img-fluid p-3" /></i>
               <h5 class="border rounded p-2">Navratri Jerseys</h5>
               <a href="product1.php"><button class="btn btn-success pricebtn">₹350/-</button></a>
            </div>
         </div>
         <div class="col-md-3 col-sm-6 text-center border rounded m-2">
            <div class="product-box">
               <i><img src="images/img-8.jpg" class="img-fluid p-3" /></i>
               <h5 class="border rounded p-2">Shimga Jerseys</h5>
               <a href="product1.php"><button class="btn btn-success pricebtn">₹400/-</button></a>
            </div>
         </div>
         <div class="col-md-3 col-sm-6 text-center border rounded m-2">
            <div class="product-box">
               <i><img src="images/img-9.jpg" class="img-fluid p-3" /></i>
               <h5 class="border rounded p-2">Shivjayanti Jerseys</h5>
               <a href="product1.php"><button class="btn btn-success pricebtn">₹300/-</button></a>
            </div>
         </div>
         <div class="col-md-3 col-sm-6 text-center border rounded m-2">
            <div class="product-box">
               <i><img src="images/img-10.jpg" class="img-fluid p-3" /></i>
               <h5 class="border rounded p-2">Dahi Handi Jerseys</h5>
               <a href="product1.php"><button class="btn btn-success pricebtn">₹250/-</button></a>
            </div>
         </div>
      </div>

      <h2 class="text-center my-5 border border-1 border-dark bg-dark text-light p-2 rounded">Other Ware</h2>
      <div class="row justify-content-center">
         <!-- Product 11-15 -->
         <div class="col-md-3 col-sm-6 text-center border rounded m-2">
            <div class="product-box">
               <i><img src="images/img-11.jpg" class="img-fluid p-3" /></i>
               <h5 class="border rounded p-2">Red Sando</h5>
               <a href="product1.php"><button class="btn btn-success pricebtn">₹250/-</button></a>
            </div>
         </div>
         <div class="col-md-3 col-sm-6 text-center border rounded m-2">
            <div class="product-box">
               <i><img src="images/img-12.jpg" class="img-fluid p-3" /></i>
               <h5 class="border rounded p-2">Sando</h5>
               <a href="product1.php"><button class="btn btn-success pricebtn">₹350/-</button></a>
            </div>
         </div>
         <div class="col-md-3 col-sm-6 text-center border rounded m-2">
            <div class="product-box">
               <i><img src="images/img-13.jpg" class="img-fluid p-3" /></i>
               <h5 class="border rounded p-2">Coloured Sando</h5>
               <a href="product1.php"><button class="btn btn-success pricebtn">₹300/-</button></a>
            </div>
         </div>
         <div class="col-md-3 col-sm-6 text-center border rounded m-2">
            <div class="product-box">
               <i><img src="images/img-14.jpg" class="img-fluid p-3" /></i>
               <h5 class="border rounded p-2">Music Design Jerseys</h5>
               <a href="product1.php"><button class="btn btn-success pricebtn">₹250/-</button></a>
            </div>
         </div>
         <div class="col-md-3 col-sm-6 text-center border rounded m-2">
            <div class="product-box">
               <i><img src="images/img-15.jpg" class="img-fluid p-3" /></i>
               <h5 class="border rounded p-2">Music Design Jerseys</h5>
               <a href="product1.php"><button class="btn btn-success pricebtn">₹350/-</button></a>
            </div>
         </div>
      </div>

      <div class="text-center mt-5">
         <a href="product1.php"><button class="btn btn-warning col-md-4">Go To Buy Products</button></a>
      </div>

   </div>
</div>
   </div>

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
                        <li> <a href="product1.php">Our Products</a></li>
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