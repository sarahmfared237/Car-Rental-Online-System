<html>
<head>
  <title>Home Page</title>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Example</title>
    <link rel="stylesheet" type="text/css" href="try.css">
</head>
<body>
<?php
session_start();

$userId = $_GET['userId'];

$mysql = new mysqli('localhost', 'root', '', 'car_rental_system');

if ($mysql->connect_error) {
    die("Connection failed: " . $mysql->connect_error);
}

$query = "SELECT ReservationID,PlateID,OfficeID,PickupDate,ReturnDate,Payment FROM Reservation WHERE CustomerID = $userId";
$result = $mysql->query($query);

if ($result) {
        
    echo "<table>";
        echo "<tr><th>ReservationID</th><th>PlateID</th><th>OfficeID</th><th>PickupDate</th><th>ReturnDate</th><th>Payment</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>{$row['ReservationID']}</td><td>{$row['PlateID']}</td><td>{$row['OfficeID']}</td><td>{$row['PickupDate']}</td><td>{$row['ReturnDate']}</td><td>{$row['Payment']}</td></tr>";
            }

    echo "</table>";
}else{
        echo "Query error: " . $mysql->error;
     }

$mysql->close();
?>
