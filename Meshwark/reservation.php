<html>
<head>
    <title>Reservations</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Example</title>
    <link rel="stylesheet" type="text/css" href="try.css">
</head>
<body>

<?php
$mysql = new mysqli('localhost', 'root', '', 'car_rental_system');
if ($mysql->connect_errno) {
    echo "Failed to connect" . $mysql->connect_error;
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $modelName = $_POST["modelName"];
    $Year = $_POST["year"];
    $passengerCount = $_POST["passengerCount"];
    $Officelocation = $_POST["officeLocation"];
    $pickDate = $_POST["pickDate"];
    $returnDate = $_POST["returnDate"];   
    $userId = $_POST["userId"];
    
    if (!empty($modelName) && !empty($Year) && !empty($passengerCount) && !empty($Officelocation)) {
        $query = "SELECT * FROM car c JOIN office o ON c.OfficeID = o.OfficeID
        WHERE c.Model = '$modelName' AND c.Year = $Year AND c.NoPassengers = $passengerCount AND o.Location = '$Officelocation' AND c.Status= 'Active'";  
    }
    else if (!empty($modelName) && !empty($Year) && !empty($passengerCount) && empty($Officelocation)) {
        $query = "SELECT * FROM car c
        WHERE c.Model = '$modelName' AND c.Year = $Year AND c.NoPassengers = $passengerCount AND c.Status= 'Active'";
    }
    else if (!empty($modelName) && !empty($Year) && empty($passengerCount) && !empty($Officelocation)) {
        $query = "SELECT * FROM car c JOIN office o ON c.OfficeID = o.OfficeID
        WHERE c.Model = '$modelName' AND c.Year = $Year AND o.Location = '$Officelocation' AND c.Status= 'Active'";
    }
    else if (!empty($modelName) && empty($Year) && !empty($passengerCount) && !empty($Officelocation)) {
        $query = "SELECT * FROM car c JOIN office o ON c.OfficeID = o.OfficeID
        WHERE c.Model = '$modelName' AND c.NoPassengers = $passengerCount AND o.Location = '$Officelocation' AND c.Status= 'Active'";
    }
    else if (empty($modelName) && !empty($Year) && !empty($passengerCount) && !empty($Officelocation)) {
        $query = "SELECT * FROM car c JOIN office o ON c.OfficeID = o.OfficeID
        WHERE c.Year = $Year AND c.NoPassengers = $passengerCount AND o.Location = '$Officelocation' AND c.Status= 'Active'";
    }
    // 2 empty
    else if (!empty($modelName) && !empty($Year) && empty($passengerCount) && empty($Officelocation)) {
        $query = "SELECT * FROM car c
        WHERE c.Model = '$modelName' AND c.Year = $Year AND c.Status= 'Active'";
    }
    else if (!empty($modelName) && empty($Year) && !empty($passengerCount) && empty($Officelocation)) {
        $query = "SELECT * FROM car c JOIN office o ON c.OfficeID = o.OfficeID
        WHERE c.Model = '$modelName' AND c.NoPassengers = $passengerCount AND c.Status= 'Active'";
    }
    else if (!empty($modelName) && empty($Year) && empty($passengerCount) && !empty($Officelocation)) {
        $query = "SELECT * FROM car c JOIN office o ON c.OfficeID = o.OfficeID
        WHERE c.Model = '$modelName' AND o.Location = '$Officelocation' AND c.Status= 'Active'";
    }
    else if (empty($modelName) && !empty($Year) && !empty($passengerCount) && empty($Officelocation)) {
        $query = "SELECT * FROM car c JOIN office o ON c.OfficeID = o.OfficeID
        WHERE c.Year = $Year AND c.NoPassengers = $passengerCount AND c.Status= 'Active'";
    }
    else if (empty($modelName) && !empty($Year) && empty($passengerCount) && !empty($Officelocation)) {
        $query = "SELECT * FROM car c JOIN office o ON c.OfficeID = o.OfficeID
        WHERE c.Year = $Year AND o.Location = '$Officelocation' AND c.Status= 'Active'";
    }
    else if (empty($modelName) && empty($Year) && !empty($passengerCount) && !empty($Officelocation)) {
        $query = "SELECT * FROM car c JOIN office o ON c.OfficeID = o.OfficeID
        WHERE c.NoPassengers = $passengerCount AND o.Location = '$Officelocation' AND c.Status= 'Active'";
    }

    // 3 empty
    else if (!empty($modelName) && empty($Year) && empty($passengerCount) && empty($Officelocation)) {
        $query = "SELECT * FROM car c JOIN office o ON c.OfficeID = o.OfficeID
        WHERE c.Model = '$modelName' AND c.Status= 'Active'";
    }
    else if (empty($modelName) && !empty($Year) && empty($passengerCount) && empty($Officelocation)) {
        $query = "SELECT * FROM car c JOIN office o ON c.OfficeID = o.OfficeID
        WHERE c.Year = $Year AND c.Status= 'Active'";
    }
    else if (empty($modelName) && empty($Year) && !empty($passengerCount) && empty($Officelocation)) {
        $query = "SELECT * FROM car c JOIN office o ON c.OfficeID = o.OfficeID
        WHERE c.NoPassengers = $passengerCount AND c.Status= 'Active'";
    }
    else if (empty($modelName) && empty($Year) && empty($passengerCount) && !empty($Officelocation)) {
        $query = "SELECT * FROM car c JOIN office o ON c.OfficeID = o.OfficeID
        WHERE o.Location = '$Officelocation' AND c.Status= 'Active'";
    }
    else {
        $query = "SELECT * FROM car c WHERE c.Status= 'Active'";
    }

        // Execute the SQL query
    $result = $mysql->query($query);
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>PlateID</th><th>Model</th><th>Year</th><th>NoPassengers</th><th>PricePerDay</th><th>OfficeID</th><th>Reservation</th></tr>";

        while($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['PlateID']}</td><td>{$row['Model']}</td><td>{$row['Year']}</td><td>{$row['NoPassengers']}</td><td>{$row['PricePerDay']}</td><td>{$row['OfficeID']}</td><td><button onclick=\"registrationcar(this,'{$row['PlateID']}','{$row['PricePerDay']}', '{$row['OfficeID']}')\">Reserve</button></td></tr>";
        }
        echo "</table>";
    
    } else {
        echo "No Available Active cars";
    }

}

$mysql->close();
?>

<script>
    function deleteRow(button) {
    var row = button.parentNode.parentNode;
    row.parentNode.removeChild(row);
  }
    
    function registrationcar(button, PlateID, PricePerDay, OfficeID) {
    window.location.href = "insert.php?PlateID=" + encodeURIComponent(PlateID)
        + "&PricePerDay=" + encodeURIComponent(PricePerDay)
        + "&OfficeID=" + encodeURIComponent(OfficeID)
        + "&customerID=" + encodeURIComponent(<?php echo $userId; ?>)
        + "&pickDate=" + encodeURIComponent('<?php echo $pickDate; ?>')
        + "&returnDate=" + encodeURIComponent('<?php echo $returnDate; ?>');
    
    deleteRow(button);
}

</script>
</body>
</html>
