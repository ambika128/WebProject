<!DOCTYPE html>
<html lang="en">
   <head>
<style>
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
            margin-top: 50px;
            color: #333333;
            font-size: 36px;
            text-shadow: 2px 2px 2px rgba(0, 0, 0, 0.3);
        }

        form {
            margin: auto;
            width: 50%;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0px 0px 10px 1px rgba(0,0,0,0.5);
            border-radius: 5px;
        }

        input[type="text"], input[type="password"] {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: none;
            border-radius: 3px;
            box-sizing: border-box;
            font-size: 16px;
            color: #333333;
            background-color: #f2f2f2;
            box-shadow: inset 1px 1px 3px rgba(0, 0, 0, 0.1);
        }

            input[type="text"]:focus, input[type="password"]:focus {
                outline: none;
                box-shadow: 0px 0px 3px 1px #ffc107;
            }

        input[type="submit"] {
            background-color: #46C646;
            color: #ffffff;
            border: none;
            border-radius: 3px;
            padding: 10px;
            cursor: pointer;
            font-size: 20px;
            margin-top: 20px;
            transition: background-color 0.2s ease;
        }

            input[type="submit"]:hover {
                background-color: #1E9E1E;
            }
.text-center{text-align: center}


 .a-divider.a-divider-break {
    text-align: center;
    position: relative;
    top: 2px;
    padding-top: 1px;
    margin-bottom: 14px;
    line-height: 0;
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
      <!-- <div class="loader_bg">
         <div class="loader"><img src="images/loading.gif" alt="#" /></div>
      </div> -->
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
  
      <div class="bg-dark text-white text-center p-3">
           <h1 class="text-white"> SIGN UP</h1>
      </div>

    <div class="container">
    <?php
include('smtp/PHPMailerAutoload.php');
if (isset($_POST["submit"])) {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $password1 = $_POST["password"];
    $passwordRepeat = $_POST["repeat_password"];
    $username1 = $_POST["username"];
    $phone = $_POST["phonenumber"];
    $address = $_POST["address"];

    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ecommerce";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM signup WHERE username = '$username1' OR email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        echo "<script>alert('Username or Email is already registered!');</script>";
    } else {
        
        $sql = "INSERT INTO signup VALUES ('$firstName', '$lastName', '$email', '$password1', '$username1', '$phone', '$address')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Record inserted successfully');
            window.location.href = 'loginPage.php';
            </script>";
       
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $subject = "Signup Successfully";
        $msg = "Your username is $username1 and password is $password1 <br>
        thanks for registration.
        ";
        $result1 = smtp_mailer($email, $subject, $msg);
    }
   

    $conn->close();
}
function smtp_mailer($to, $subject, $msg){
    $mail = new PHPMailer(); 
    $mail->IsSMTP(); 
    $mail->SMTPAuth = true; 
    $mail->SMTPSecure = 'tls'; 
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587; 
    $mail->IsHTML(true);
    $mail->CharSet = 'UTF-8';
    //$mail->SMTPDebug = 2; 
    $mail->Username = "";
    $mail->Password = "pwvi qfyu dsra ilgs";
    $mail->SetFrom("");
    $mail->Subject = $subject;
    $mail->Body = $msg;
    $mail->AddAddress($to);
    $mail->SMTPOptions = array('ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => false
    ));
    if(!$mail->Send()){
        return $mail->ErrorInfo;
    } else {
        return 'Sent';
    }
}
?>

<form action="signup.php" method="post">
    <div class="form-group">
        <input type="text" class="form-control" name="firstName" placeholder="First Name">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="lastName" placeholder="Last Name">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="email" placeholder="Email">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="username" placeholder="Username">
    </div>
    <div class="form-group">
        <input type="password" class="form-control" name="password" placeholder="Password">
    </div>
    <div class="form-group">
        <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="address" placeholder="Address">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="phonenumber" placeholder="Phone Number">
    </div>
    <div class="form-btn text-center">
        <input type="submit" class="btn btn-primary" value="Signup" name="submit">
    </div>
    <hr style="border-width: 1px; border-style: inset;"><br>
    <div class="text-center">
        <p>Already registered?</p>
        <a href="loginPage.php"><div class="a-divider a-divider-break"><h3 aria-level="5"><strong>Login Here?</strong></h3></div></a>
    </div>
</form>
<br><br><br>

    <!-- end contact -->

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