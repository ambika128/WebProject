<?php
session_start();
$loggedIn = isset($_SESSION['username']) ? true : false;
$username = $loggedIn ? $_SESSION['username'] : '';

// Database connection
require_once "database.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from products table
$sql = "SELECT p_id, P_name, p_price, p_image FROM products";
$result = $conn->query($sql);


if (isset($_POST['delete'])) {
    $product_name = $_POST['product_name'];
    
    // Begin transaction
    $conn->begin_transaction();

    try {
        // Get the product ID based on the product name
        $stmt = $conn->prepare("SELECT p_id FROM products WHERE p_name = ?");
        $stmt->bind_param("s", $product_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $product_id = $row['p_id'];
            
            // Delete from the cart table
            $stmt = $conn->prepare("DELETE FROM cart WHERE product_id = ?");
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $stmt->close();
            
            // Delete from the products table
            $stmt = $conn->prepare("DELETE FROM products WHERE p_name = ?");
            $stmt->bind_param("s", $product_name);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $display_message="Product and related records deleted successfully.";
            } else {
                $display_message="No product found with the given name.";
            }
        } else {
            $display_message="No product found with the given name.";
        }

        // Commit transaction
        $conn->commit();
    } catch (Exception $e) {
        // Rollback transaction if something goes wrong
        $conn->rollback();
        echo "Error deleting product: " . $e->getMessage();
    }

    // Close the statement and connection
    $stmt->close();
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

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .loader_bg {
            position: fixed;
            z-index: 999999;
            background: #fff;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            opacity: 0.8;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .loader {
            width: 100px;
            height: 100px;
        }
        .loader img {
            width: 100%;
        }
        .products-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-top: 20px;
        }
        .product-box {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            width: 200px;
            height: 350px; /* Set a fixed height */
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .product-box img {
            max-width: 100%;
            height: auto;
            margin-bottom: 15px;
        }
        .product-box h3 {
            font-size: 18px;
            margin: 0 0 10px 0;
        }
        .product-box .price {
            color: #b12704;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .product-box .cart-button-container {
            margin-top: auto; /* Push the button to the bottom */
        }
        .product-box .cart-button {
            background-color: #f0c14b;
            border: 1px solid #a88734;
            border-radius: 3px;
            color: #111;
            cursor: pointer;
            padding: 5px 10px; /* Smaller padding */
            font-size: 14px; /* Smaller font size */
            text-transform: uppercase;
            transition: background-color 0.3s;
        }
        .product-box .cart-button:hover {
            background-color: #ddb347;
        }
        /* header {
            background: #fff;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        } */
        /* .logo_section img {
            max-width: 100px;
        } */
        /* .menu-area {
            display: flex;
            align-items: center;
        } */
        /* .menu-area-main {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            gap: 20px;
        } */
        /* .menu-area-main li {
            display: inline;
        } */
        .menu-area-main a {
            text-decoration: none;
            color: #000;
            font-size: 16px;
            text-transform: uppercase;
            padding: 10px;
            transition: color 0.3s;
        }
        .menu-area-main a:hover {
            color: #f0c14b;
        }
        .menu-area-main .active a {
            color: #f0c14b;
        }
        .brand_color {
            background: #f0c14b;
            padding: 20px 0;
        }
        .brand_color h2 {
            color: #fff;
            text-align: center;
        }
        .title {
            text-align: center;
            margin-bottom: 20px;
        }
        .title span {
            font-size: 18px;
            color: #555;
        }
        .product-bg {
            background: #f9f9f9;
            padding: 20px 0;
        }
        .product-bg-white {
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
    </style>
    <style>
.display_message {
    background-color: mistyrose;
    color: red;
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

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Product List</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
</head>
<body class="main-layout product_page">
    <!-- loader  -->
    <div class="loader_bg">
        <div class="loader"><img src="images/loading.gif" alt="#" /></div>
    </div>
    <!-- end loader -->
    <header>
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section mt-3">
                    <div class="full">
                        <div class="center-desk">
                            <div class="logo"> <a href="index.php">
      <img src="images/logo1.png" alt="AK Sports" style=" height: 90px; width: 90px; margin-top: 5%; "/>
   </a> </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-7 col-md-9 col-sm-9 mt-3">
                    <div class="menu-area">
                        <div class="limit-box">
                            <nav class="main-menu">
                                <ul class="menu-area-main">
                                    <li> <a href="adminform.php">Add Products</a> </li>
                                    <li > <a href="admin.php">Product</a> </li>
                                    <li class="active"> <a href="admindelete.php">Delete Products</a> </li>
                                    <li> <a href="showintable.php">Users</a> </li>

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
    </header>



    
    <div class="brand_color mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage">
                        <h2>Delete Products</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <h1>Delete Product</h1>
    <form action="" method="post">
        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" required>
        <button type="submit" name="delete">Delete Product</button>
    </form> -->
    
    <!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product</title>
    <style>
        .container1 {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            background-color: #ff4b5c;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #ff1f3c;
        }
    </style>
</head>
<body>
    <center>
    <div class="container1">
        <h1>Delete Product</h1>
        <form action="" method="post">
            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name" required>
            <button type="submit" name="delete">Delete Product</button>
        </form>
    </div>
    </center>
</body>
</html> -->

<div class="container">

<?php
        if(isset($display_message)){
            echo "<div class ='display_message'>
            <span>$display_message</span>
            <i class='fas fa-times' onclick = 'this.parentElement.style.display=`none`';></i>
        </div>";
        }
        
    ?>
   
<form action="" method="post" enctype="multipart/form-data">

<div class="container" style="margin-top: 65px;" >
    <div class="col-md-7" style="float: none; margin: 0 auto;">
      <div class="form-area">
        <form role="form" action="entercar1.php?action=car" enctype="multipart/form-data" method="POST">
        <br style="clear: both">
          <h3 style="margin-bottom: 25px; text-align: center; font-size: 30px;"> Please Provide Delete Product Name. </h3>

          <div class="form-group">
            <input type="text" class="form-control" id="car_name" name="product_name" placeholder="Enter product Name " required autofocus="">
          </div> 

           <button type="submit" id="submit" name="delete" class="btn btn-success pull-right">Delete product</button>    
        </form>
      </div>
    </div>

 </form>
    </div>

    <script>
        // Hide the loader once the page has fully loaded
        window.addEventListener('load', function() {
            document.querySelector('.loader_bg').style.display = 'none';
        });
    </script>
</body>
</html>
