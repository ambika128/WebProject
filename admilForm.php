<?php
    session_start();
    $loggedIn = isset($_SESSION['username']) ? true : false;
$username = $loggedIn ? $_SESSION['username'] : '';
    include('smtp/PHPMailerAutoload.php');
    require_once "database.php";

// if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
//     $servername = "localhost";  // change this to your database server
//     $username = "root";         // change this to your database username
//     $password = "";             // change this to your database password
//     $dbname = "sighup_table";   // change this to your database name

//     // Create connection
//     $conn = new mysqli($servername, $username, $password, $dbname);

//     // Check connection
//     if ($conn->connect_error) {
//         die("Connection failed: " . $conn->connect_error);
//     }

//     $car_name = $_POST['product_name'];
//     $car_nameplate = $_POST['product_amount'];

//     if (isset($_FILES['uploadedimage']) && $_FILES['uploadedimage']['error'] == UPLOAD_ERR_OK) {
//         $uploadedimage = $_FILES['uploadedimage']['name'];

//         // Upload the image file to a directory on the server
//         $target_dir = "uploads/";
//         $target_file = $target_dir . basename($uploadedimage);
//         if (move_uploaded_file($_FILES['uploadedimage']['tmp_name'], $target_file)) {
//             // Prepare an insert statement
//             $sql = "INSERT INTO products(p_name, p_price, p_image) VALUES (?, ?, ?)";

//             if ($stmt = $conn->prepare($sql)) {
//                 $stmt->bind_param("sss", $car_name, $car_nameplate, $target_file);

//                 if ($stmt->execute()) {
//                     echo "Records inserted successfully.";
//                 } else {
//                     echo "Error: " . $stmt->error;
//                 }

//                 $stmt->close();
//             } else {
//                 echo "Error: " . $conn->error;
//             }
//         } else {
//             echo "Error uploading file.";
//         }
//     } else {
//         echo "No file uploaded or there was an upload error.";
//     }

//     $conn->close();
// }

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
   

   $product_name = $_POST['product_name'];
   $product_amount = $_POST['product_amount'];

   if (isset($_FILES['uploadedimage'])) {
       if ($_FILES['uploadedimage']['error'] == UPLOAD_ERR_OK) {
           $uploadedimage = $_FILES['uploadedimage']['name'];

           // Upload the image file to a directory on the server
           $target_dir = 'icon/';
           $target_file = $target_dir . basename($uploadedimage);
           if (move_uploaded_file($_FILES['uploadedimage']['tmp_name'], $target_file)) {
               // Prepare an insert statement
               $sql = "INSERT INTO products(p_name, p_price, p_image) VALUES (?, ?, ?)";

               if ($stmt = $conn->prepare($sql)) {
                   $stmt->bind_param("sss", $car_name, $car_nameplate, $target_file);

                   if ($stmt->execute()) {
                       echo "Records inserted successfully.";
                   } else {
                       echo "Error: " . $stmt->error;
                   }

                   $stmt->close();
               } else {
                   echo "Error: " . $conn->error;
               }
           } else {
               echo "Error uploading file.";
           }
       } else {
           echo "File upload error code: " . $_FILES['uploadedimage']['error'];
       }
   } else {
       echo "No file uploaded.";
   }

   $conn->close();
}

   
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var isLoggedIn = <?php echo json_encode($loggedIn); ?>;
            var username = <?php echo json_encode($username); ?>;
            
            if (isLoggedIn) {
                $('.login-status').html('<a class="buy" href="logout.php">Log Out  </a> <br>   <span class="username">Hi,' + username + '</span>');
            } else {
                $('.login-status').html('<a class="buy" href="loginPage.php">Login</a>');
            }
        });
    </script>
<style>
   .username {
      font-weight: bold;
    color: #ffc221;
    margin-left: 14px;
    font-style: oblique;
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
         
         <div class="container">
            <div class="row">
               <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                  <div class="full">
                     <div class="center-desk">
                        <div class="logo"><a href="index.php">
      <img src="images/logo1.png" alt="AK Sports" style=" height: 90px; width: 90px; margin-top: 5%; "/>
   </a></div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-7 col-lg-7 col-md-9 col-sm-9">
                  <div class="menu-area">
                     <div class="limit-box">
                        <nav class="main-menu">
                           <ul class="menu-area-main">
                              <li > <a href="index.php">Home</a> </li>
                              <li> <a href="about.php">About</a> </li>
                              <li> <a href="product1.php">product</a> </li>              
                              <li > <a href="contact.php">Contact</a> </li>
<li>
<a href="addToCart.php ">
<img src="icon/cart.png" height=30px width=30px>
</a>
</li>
                           </ul>
                        </nav>
                     </div>
                  </div>
               </div>
               <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 d-flex justify-content-center align-items-center">
               <li class="login-status"></li> <!-- Placeholder for login or user info -->   
                
               </div>
            </div>
         </div>
         <!-- end header inner --> 
      </header>
      <!-- end header -->
      <div class="brand_color">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage">
                        <h2>Add Products</h2>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="container">
   
<form action="adminform.php" method="post" enctype="multipart/form-data">
<div class="container" style="margin-top: 65px;" >
    <div class="col-md-7" style="float: none; margin: 0 auto;">
      <div class="form-area">
        <form role="form" action="entercar1.php?action=car" enctype="multipart/form-data" method="POST">
        <br style="clear: both">
          <h3 style="margin-bottom: 25px; text-align: center; font-size: 30px;"> Please Provide Your Product Details. </h3>

          <div class="form-group">
            <input type="text" class="form-control" id="car_name" name="product_name" placeholder="Enter product Name " required autofocus="">
          </div>

          <div class="form-group">
            <input type="number" class="form-control" id="car_nameplate" name="product_amount" placeholder="Enter a Amount of product" required>
          </div>     

          <div class="form-group">5
            <input name="uploadedimage" type="file" required accept="image/png, image/jpg, image/jpeg">
          </div>
           <button type="submit" id="submit" name="submit" class="btn btn-success pull-right">Submit for products</button>    
        </form>
      </div>
    </div>
            <div class="form-btn text-center">
                        <button id="rzp-button1" type="submit" class="btn btn-primary">Back to Homepage</button>
            </div>
      

 </form>
    </div>
    <!-- end contact -->
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