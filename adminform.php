<?php
    session_start();
    $loggedIn = isset($_SESSION['username']) ? true : false;
$username = $loggedIn ? $_SESSION['username'] : '';
    include('smtp/PHPMailerAutoload.php');
    require_once "database.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
   

   $product_name = $_POST['product_name'];
   $product_amount = $_POST['product_amount'];
   $uploadedimage = $_FILES['uploadedimage']['name'];
   $uploadedimage_tmp_name =$_FILES['uploadedimage']['tmp_name'];
   $uploadedimage_folder = "icon/";
   $uploadedimage_path = "{$uploadedimage_folder}{$uploadedimage}";

   $insert_query=mysqli_query($conn,"insert into `products` (p_name,p_price,p_image) values ('$product_name','$product_amount','$uploadedimage_path')");

    if($insert_query){
        move_uploaded_file($uploadedimage_tmp_name, $uploadedimage_path);
        $display_message= "Product inserted Successfully";
    }else{
        $display_message= "There is some error inserting product";
    }

}
   
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var isLoggedIn = <?php echo json_encode($loggedIn); ?>;
            var username = <?php echo json_encode($username); ?>;
            
            if (isLoggedIn) {
                $('.login-status').html('<a class="buy" href="logout.php">Log Out  </a> <br>   <span class="username">Hii..' + username + '</span>');
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
<style>
.display_message {
    background-color: lightgreen;
    color: olive;
    padding: 15px;
    margin: 20px 0;
    border: 1px solid #f5c6cb;
    border-radius: 5px;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
    animation: fadeIn 0.5s ease-in-out;
}

.display_message span {
    font-size: 16px;
    font-weight: 500;
}

.display_message i {
    cursor: pointer;
    font-size: 20px;
    padding-left: 10px;
    transition: color 0.3s;
}

.display_message i:hover {
    color: #d9534f;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
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
               <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col logo_section mt-3">
                  <div class="full">
                     <div class="center-desk">
                        <div class="logo"> <a href="index.php">
      <img src="images/logo1.png" alt="AK Sports" style=" height: 90px; width: 90px; margin-top: 5%; "/>
   </a> </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 mt-3">
                  <div class="menu-area">
                     <div class="limit-box">
                        <nav class="main-menu">
                           <ul class="menu-area-main">
                              <li class="active" > <a href="adminform.php">Add Products</a> </li>
                              <li> <a href="admin.php">product</a> </li>              
                              <li > <a href="admindelete.php">Delete Products</a> </li>
                                <li> <a href="showintable.php">Users</a> </li>
                           </ul>
                        </nav>
                     </div>
                  </div>
               </div>
               <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 ">
               <li class="login-status">
                
               </li> <!-- Placeholder for login or user info -->   
                
               </div>
            </div>
         </div>
         <!-- end header inner --> 
      </header>
      <!-- end header -->
      <div class="brand_color mt-5">
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
    <?php
        if(isset($display_message)){
            echo "<div class ='display_message'>
            <span>$display_message</span>
            <i class='fas fa-times' onclick = 'this.parentElement.style.display=`none`';></i>
        </div>";
        }
        
    ?>
   
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

          <div class="form-group">
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