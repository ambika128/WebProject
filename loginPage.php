<?php
    session_start();
$loggedIn = isset($_SESSION['username']) ? true : false;
$username = $loggedIn ? $_SESSION['username'] : '';

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    require_once "database.php";
    $sql = "SELECT * FROM signup WHERE username = '$username' && password ='$password'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0){
        $_SESSION['username'] = $username;

        echo "<script>alert('Login successful');
        window.location.href = 'index.php';
        </script>";

        }else{
            echo "<script>alert('Try Again');</script>";    }
    
    
}
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var isLoggedIn = <?php echo json_encode($loggedIn); ?>;
            var username = <?php echo json_encode($username); ?>;
            
            if (isLoggedIn) {
                $('.login-status').html('<a class="buy" style="margin-left:10px;" href="logout.php">Log Out </a><span class="username mx-3" style="margin-left:10px; font-size:15px;">WELCOME, ' + username + '</span>');
            } else {
                $('.login-status').html('<a class="buy" style="margin-left:100px;" href="loginPage.php">Login</a>');
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

      <div>
         <div class="row">
            <div style="margin-left:50px;"><a href="index.php">
      <img src="images/logo1.png" alt="AK Sports" style=" height: 90px; width: 90px; margin-top: 5%; "/>
   </a></div>
            <div class="col-md-8">
               <div class="menu-area">
                  <div class="limit-box">
                  <nav class="main-menu">
   
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
           <h1 class="text-white"> LOGIN</h1>
      </div>
   

    <div class="container col-md-6">
   
<form action="loginPage.php" method="post">
    <center><img src="icon/lg.png" alt="img" height="25%" width="25%"/></center>
            <div class="form-group">
                <input type="text" placeholder="Enter user name:" name="username" class="form-control">
            </div>
            <div class="form-group">
                <input type="password" placeholder="Enter Password:" name="password" class="form-control">
            </div>
            <div class="form-btn text-center" style="width: 100%;">
                <input type="submit" value="Login" name="login" class="btn btn-primary btn-block">
            </div>
        
        


       

<style>
.second_box { display: none; }
.field_error { color: red; }
</style>





<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function send_otp() {
    var email = jQuery('#email').val();
    jQuery.ajax({
        url: 'send_otp.php',
        type: 'post',
        data: 'email=' + email,
        success: function(response) {
            var result = JSON.parse(response);
            if (result.status == 'yes') {
                jQuery('.second_box').show();
                jQuery('.first_box').hide();
                start_timer(result.expiry_time);
            }
            if (result.status == 'not_exist') {
                jQuery('#email_error').html('Please enter a valid email');
            }
            if (result.status == 'email_not_found') {
                jQuery('#email_error').html('Signup first for login');
            }
        }
    });
}

function start_timer(duration) {
    var timer = duration, minutes, seconds;
    var interval = setInterval(function() {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        jQuery('#timer').text(minutes + ":" + seconds);

        if (--timer < 0) {
            clearInterval(interval);
            jQuery('#otp_error').html('OTP has expired. Please request a new OTP.');
        }
    }, 1000);
}


function submit_otp() {
    var otp = jQuery('#otp').val();
    var email = jQuery('#email').val();
    jQuery.ajax({
        url: 'check_otp.php',
        type: 'post',
        data: {
            otp: otp,
            email: email
        },
        success: function(response) {
            var result;
            try {
                result = JSON.parse(response);
            } catch (e) {
                result = { result: response };
            }
            if (result.result == 'yes') {
                // Successful OTP verification
                window.location.href = 'index.php';
            } else if (result.result == 'otp_expired') {
                jQuery('#otp_error').html('OTP has expired. Please request a new OTP.');
            } else if (result.result == 'not_exist') {
                jQuery('#otp_error').html('Please enter a valid OTP.');
            } else if (result.result == 'user_not_found') {
                jQuery('#otp_error').html('User not found. Please check your email.');
            }
        },
        error: function() {
            jQuery('#otp_error').html('An error occurred. Please try again.');
        }
    });
}


</script>



<hr style=" border-width: 50px border-style: inset; width: 100%;"><br>
<a href="signup.php">
         <div class="a-divider a-divider-break" style=" color: green;display: flex;justify-content: center;align-items: center;text-align: center;"><h3 aria-level="5" style="color:red"><strong>New to Shop?</strong></h3></div></a>
        
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