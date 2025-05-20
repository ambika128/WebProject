<?php
session_start();
$loggedIn = isset($_SESSION['username']) ? true : false;
$username = $loggedIn ? $_SESSION['username'] : '';
require_once "database.php";
if (!$conn) {
   die("Something went wrong;");
}


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

?>
<style>
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
</style>
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
   </a></div>
            <div class="col-md-7">
               <div class="menu-area">
                  <div class="limit-box">
                     <nav class="main-menu">
                        <ul class="menu-area-main mt-3"
                           style="display: flex; gap: 20px; list-style: none; margin: 0; padding: 0; justify-content: center; font-size: 16px;">
                           <li><a href="index.php">Home</a></li>
                           <li class="active"><a href="about.php">About</a></li>
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
   <div class="bg-dark text-white text-center p-3 mt-2">
      <h1 class="text-white"> ABOUT</h1>
   </div>


   <div class="about">
      <div class="container">
         <div class="row">
            <dir class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
               <div class="about_box">
                  <figure><img src="images\logo1.png" class="p-3 rounded" /></figure>
               </div>
            </dir>
            <dir class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-5">
               <div class="about_box">
                  <h3 class="mt-5">About AK Sports</h3>
                  <p style="font-family:verdana">Welcome to AK Sports, your ultimate destination for high-quality, stylish, and performance-driven sportswear and casual clothing. Established with a passion for fashion and fitness, AK Sports brings together the best of both worlds—trendy styles and top-notch comfort. </p>
            </dir>


            </br></br>
            <p style="font-family:verdana">About Us

            Welcome to AK Sports, your ultimate destination for high-quality, stylish, and performance-driven sportswear and casual clothing. Established with a passion for fashion and fitness, AK Sports brings together the best of both worlds—trendy styles and top-notch comfort. Whether you're an athlete, a fitness enthusiast, or someone who simply loves wearing sporty outfits, we have something special for you.

At AK Sports, we believe that the right clothing boosts confidence and performance. Our online store features a wide range of products including activewear, gym wear, running gear, casual t-shirts, joggers, track pants, hoodies, and more—all carefully curated to meet the needs of our diverse customers. We prioritize quality, using breathable fabrics, advanced stitching, and modern designs that not only look great but also last long.

We are more than just a clothing store—we are a lifestyle brand. Our mission is to inspire an active and fashionable life through our products. Every piece in our collection reflects the latest trends blended with comfort and utility. We constantly update our catalog to bring you the newest styles at affordable prices, ensuring that our customers always stay ahead in fashion and fitness.

Customer satisfaction is at the heart of everything we do. From easy browsing to secure checkout, fast delivery, and responsive customer support, we are committed to providing a seamless shopping experience. AK Sports also offers flexible return policies and multiple payment options to make your journey with us smooth and enjoyable.

We are proud to serve customers across India and aim to grow globally, promoting not just a brand, but a movement that celebrates energy, strength, and style. Join the AK Sports community and elevate your wardrobe with our exclusive range of clothing that fits your body and your goals.

Thank you for choosing AK Sports—where style meets performance.
         </div>

      </div>
   </div>
   </div>

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
<!-- Working process -->
<div class="p-5">
   <div class="container">
      <div class="white_bg">
         <div class="row">
         <div class="col-md-7 offset-md-3">
            <div class="title text-center p-5">
               <h2>Process <strong class="black">of Our Working</strong></h2>
            </div>
         </div>
         <img src="images/process.jpg" alt="Process of our working." />
         </div>
      </div>
   </div>
</div>
   <footer>
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
                        <li> <a href="product1.php">Our products</a></li>
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