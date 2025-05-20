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
$sql = "SELECT firstname, lastname, email,password,username,phonenumber, address FROM signup";
$result = $conn->query($sql);




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
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                    <div class="full">
                        <div class="center-desk">
                            <div class="logo"> <a href="index.php">
      <img src="images/logo1.png" alt="AK Sports" style=" height: 90px; width: 90px; margin-top: 5%; "/>
   </a> </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-7 col-md-9 col-sm-9">
                    <div class="menu-area">
                        <div class="limit-box">
                            <nav class="main-menu">
                                <ul class="menu-area-main">
                                    <li> <a href="adminform.php">Add Products</a> </li>
                                    <li > <a href="admin.php">Product</a> </li>
                                    <li > <a href="admindelete.php">Delete Products</a> </li>
                                    <li class="active"> <a href="showintable.php">Users</a> </li>
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



    
    <div class="brand_color">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage">
                        <h2>Users Register Data</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!DOCTYPE html>
<html>
<head>
    <title>User Data</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
            text-transform: uppercase;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        td {
            border: 1px solid #ddd;
        }
        .no-data {
            text-align: center;
            font-weight: bold;
            color: #4CAF50;
        }
    </style>
</head>
<body>


    <table>
    <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Password</th>
        <th>Username</th>
        <th>Phone Number</th>
        <th>Address</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["firstname"]. "</td>
                    <td>" . $row["lastname"]. "</td>
                    <td>" . $row["email"]. "</td>
                    <td>" . $row["password"]. "</td>
                    <td>" . $row["username"]. "</td>
                    <td>" . $row["phonenumber"]. "</td>
                    <td>" . $row["address"]. "</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No data found</td></tr>";
    }
    $conn->close();
    ?>
</table>

    
    <script>
        // Hide the loader once the page has fully loaded
        window.addEventListener('load', function() {
            document.querySelector('.loader_bg').style.display = 'none';
        });
    </script>
</body>
</html>
