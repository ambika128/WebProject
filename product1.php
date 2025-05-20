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

// Handle Add to Cart
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['add_to_cart'])) {
        $product_id = $_POST['product_id'];
        $session_id = session_id();
        
        // Check if the product is already in the cart
        $sql = "SELECT quantity FROM cart WHERE session_id = ? AND product_id = ? AND username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sis", $session_id, $product_id, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Product is already in the cart, increase the quantity
            $sql = "UPDATE cart SET quantity = quantity + 1 WHERE session_id = ? AND product_id = ? AND username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sis", $session_id, $product_id, $username);
            $stmt->execute();
        } else {
            // Product is not in the cart, add a new entry
            $sql = "INSERT INTO cart (session_id, product_id, quantity, username) VALUES (?, ?, 1, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sis", $session_id, $product_id, $username);
            $stmt->execute();
        }

        echo "<script>
            alert('Item added to cart');
            window.location.href = 'product1.php';
        </script>";
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
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
        }

        .product-box {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 25px;
            width: 210px;
            height: 500px;
            /* Set a fixed height */
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            margin-top: 20px;
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
            margin-top: auto;
            /* Push the button to the bottom */
        }

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

            padding: 20px 0;
        }

        .product-bg-white {
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
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
        .cart-button{
            padding: 3px;
            
        }

        .cart-button:hover{
            background-color: black;
            color: white;
        }
    </style>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>AK Sports</title>
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
                                    <li class="active"><a href="product1.php">Products</a></li>
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





    <div class="bg-dark text-white text-center p-3">
        <h1 class="text-white">OUR PRODUCTS</h1>
    </div>

    <div class="product-bg">
        <div class="product-bg-white">
            <div class="container">
                <div class="products-container">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // echo "<div class='product-box'>";
                            // echo "<img src='images/" . $row["p_image"] . "' alt='" . $row["P_name"] . "'>";
                            // echo "<h3>" . $row["P_name"] . "</h3>";
                            // echo "<span class='price'>₹" . $row["p_price"] . "</span>";

                   
                                echo "<div class='product-box'>";
                                echo "<img src='" . $row["p_image"] . "' alt='" . $row["P_name"] . "'>";
                                echo "<h3>" . $row["P_name"] . "</h3>";
                                echo "<span class='price'>₹" . $row["p_price"] . "</span>";

                            echo '<div class="cart-button-container">';
                            echo '<form method="POST" action="">';
                            echo '<input type="hidden" name="product_id" value="' . $row["p_id"] . '">';
                            if ($loggedIn) {
                                echo '<button type="submit" name="add_to_cart" class="cart-button btn btn-success">Add to Cart</button>';
                            } else {
                                echo '<button type="button" class="cart-button" onclick="alert(\'You need to be logged in to add items to the cart\')">Add to Cart</button>';
                            }
                            echo '</form>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo "<p>No products found</p>";
                    }
                    $conn->close();
                    ?>
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

    <script>
        // Hide the loader once the page has fully loaded
        window.addEventListener('load', function () {
            document.querySelector('.loader_bg').style.display = 'none';
        });
    </script>
</body>

</html>