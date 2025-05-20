<?php
 $servername = "localhost";
 $username = "root";
 $password = "";
 $dbname = "ecom";
 
 // Create connection
 $conn = new mysqli($servername, 
     $username, $password, $dbname);
 
 // Check connection
 if ($conn->connect_error) {
     die("Connection failed: " 
         . $conn->connect_error);
 }


$sql = "SELECT firstname, lastname, username, password, email, address FROM signup";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Data</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>User Data</h2>

<table>
    <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Username</th>
        <th>Password</th>
        <th>Email</th>
        <th>Address</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["firstname"]. "</td>
                    <td>" . $row["lastname"]. "</td>
                    <td>" . $row["username"]. "</td>
                    <td>" . $row["password"]. "</td>
                    <td>" . $row["email"]. "</td>
                    <td>" . $row["address"]. "</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No data found</td></tr>";
    }
    $conn->close();
    ?>
</table>

</body>
</html>


