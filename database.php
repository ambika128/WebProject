<?php
$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "ecommerce";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

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
    top: -5px; /* Adjust based on your needs */
    right: -5px; /* Adjust based on your needs */
    background-color: red; /* Badge color */
    color: white; /* Text color */
    border-radius: 50%;
    padding: 2px 5px;
    font-size: 12px; /* Adjust font size as needed */
    font-weight: bold;
    text-align: center;
    width: 20px; /* Adjust width as needed */
    height: 20px; /* Adjust height as needed */
    line-height: 20px; /* Center text vertically */
}

</style>