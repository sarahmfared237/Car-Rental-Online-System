<html>
<head>
  <title>Reservaation</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');
  * {
      font-family: 'Poppins';
    }
	body {
      display: flex;
      justify-content: center;
      color: rgba(32, 208, 8, 0.953);
      font-size: 70px;
      display: flex;
      background: url('booking-suc.png') no-repeat;
      background-position: center;
    }
  </style>
  </head>

<body>
<?php
$mysql = new mysqli('localhost', 'root', '', 'car_rental_system');

if ($mysql->connect_errno) {
    echo "Failed to connect: " . $mysql->connect_error;
    exit();
}

$PlateID = $_GET['PlateID'];
$PricePerDay = $_GET['PricePerDay'];
$OfficeID = $_GET['OfficeID'];
$customerID = $_GET['customerID'];
$pickDate = $_GET['pickDate'];
$returnDate = $_GET['returnDate'];

$startDate = new DateTime($pickDate);
$endDate = new DateTime($returnDate);
$duration = $startDate->diff($endDate)->format("%a") + 1;

$payment = $PricePerDay * $duration;

$query = "INSERT INTO Reservation (CustomerID,PlateID, OfficeID,  PickupDate, ReturnDate, Payment) 
          VALUES ('$customerID','$PlateID', '$OfficeID', '$pickDate', '$returnDate', '$payment')";

$query1 = "UPDATE car
          SET Status = 'Rented'
          WHERE PlateID = '$PlateID' ";

if ($mysql->query($query) && $mysql->query($query1)) {
  echo "Successful Reservation";
  echo "<script>setTimeout(function(){ window.location.href = 'userOption.php'; }, 3000);</script>";
} else {
    echo "Error: " . $query . "<br>" . $mysql->error;
}
/*if ($mysql->query($query1)) {
  echo "Reservation successfully added!";
} else {
  echo "Error: " . $query1 . "<br>" . $mysql->error;
}*/

$mysql->close();
?>
</body>
</html>