<?php
if (isset($_POST['change'])) {
  $plateId = $_POST['plateId'];

  // Database connection
  $mysql = new mysqli('localhost', 'root', '', 'car_Rental_System');
  if ($mysql->connect_error) {
    die("Connection failed: " . $mysql->connect_error);
  }

  // Check if PlateID exists in the Car table
  $query = "SELECT * FROM Car WHERE PlateID = '$plateId'";
  $result = $mysql->query($query);

  if ($result && $result->num_rows > 0) {
    $car = $result->fetch_assoc();
    $currentStatus = $car['Status'];

    if ($currentStatus === 'Rented') {
       $message = "Cannot change the status of a rented car.";
    } else {
      $newStatus = ($currentStatus === 'Active') ? 'OutOfService' : 'Active';
      
      // Update the car status
      $updateQuery = "UPDATE Car SET Status = '$newStatus' WHERE PlateID = '$plateId'";
      $updateResult = $mysql->query($updateQuery);

      if ($updateResult) {
        $message = "Car status updated successfully. New status: $newStatus";
      } else {
        $message = "Failed to update car status: " . $mysql->error;
      }
    }
  } else {
    $message = "Incorrect PlateID. Car not found in the database.";
  }

  $mysql->close();
  
  echo $message;
}
?>