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


<?php
if (session_status() === PHP_SESSION_NONE) {
   session_start();
}

require_once "database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $name = trim($_POST['Name']);
    $email = trim($_POST['Email']);
    $mobile = trim($_POST['Mobile']);
    $message = trim($_POST['Message']);

    // Validate the data
    $errors = [];
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }
    if (empty($mobile) || !preg_match('/^[7-9]\d{9}$/', $mobile)) {
        $errors[] = "Valid mobile number is required.";
    }
    if (empty($message)) {
        $errors[] = "Message is required.";
    }

    // If no errors, insert into the database
    if (empty($errors)) {
        $sql = "INSERT INTO contact (name, email, mobile, message) VALUES (?, ?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssss", $name, $email, $mobile, $message);
            if ($stmt->execute()) {
                $success_message = "Thank you! Your message has been submitted.";
            } else {
                $errors[] = "Error submitting the form. Please try again.";
            }
            $stmt->close();
        } else {
            $errors[] = "Error preparing the statement: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <title>Contact Us</title>
</head>

<body>
   <?php if (!empty($errors)): ?>
   <div class="alert alert-danger">
      <?php foreach ($errors as $error): ?>
      <p>
         <?php echo htmlspecialchars($error); ?>
      </p>
      <?php endforeach; ?>
   </div>
   <?php endif; ?>
   <?php if (!empty($success_message)): ?>
   <div class="alert alert-success">
      <p>
         <?php echo htmlspecialchars($success_message); ?>
      </p>
   </div>
   <?php endif; ?>


</body>

</html>

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
                           <li class="active"><a href="contact.php">Contact</a></li>
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
      <h1 class="text-white"> CONTACT</h1>
   </div>

   <!-- contact -->
   <div class="contact">
      <div class="container">
         <div class="row">
            <div class="col-md-12">

               <form class="main_form" method="post" action="contact.php">
                  <div class="row">
                     <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                        <input class="form-control" id="name" placeholder="Your name" type="text" name="Name">
                     </div>
                     <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                        <input class="form-control" id="email" placeholder="Email" type="text" name="Email">
                     </div>
                     <div class=" col-md-12">
                        <input class="form-control" id="mobile" placeholder="Mobile Number" type="text" name="Mobile">
                     </div>
                     <div class="col-md-12">
                        <textarea class="textarea" name="Message" placeholder="Message"></textarea>
                     </div>
                     <div class=" col-md-12">
                        <button class="send" type="submit">Send</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
   <!-- end contact -->

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


      function val() {
         var mobile = document.getElementById("mobile").value
         var name = document.getElementById("name").value
         // var name = input.getAttribute("name");
         var email = document.getElementById("email").value
         var regx = /^[7-9]\d{9}$/
         var regex = /^([a-z A-Z 0-9 \._]+)@([a-z A-Z]+).([a-z A-Z]{2,6})$/


         if (name.trim() == "") {
            alert("Please Enter Youe name");
         }
         if (email.trim() == "") {
            alert("Please Enter Email Id");
         }
         else if ((!regex.test(email))) {
            alert("Elease Enter Valid Email Id");
         }

         if (mobile.trim() == "") {
            alert("Please Enter Mobilr Number");
         }
         else if ((!regx.test(mobile))) {
            alert("Please Enter Valid Mobile Number");
         }
         if (regex.test(email) && regx.test(mobile) && !(name.trim() == "")) {
            alert("Thank You !!!!")
         }
      }
   </script>
</body>

</html>