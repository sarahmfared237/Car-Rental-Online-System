<?php
$mysqli = new mysqli("localhost", "root", "", "car_rental_system");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the search parameters from the form
    $startPeriod = $_POST['startPeriod'];
    $endPeriod = $_POST['endPeriod'];
    $carId = $_POST['carId'];
    $customerSsn = $_POST['customerSsn'];

    // Check if the entered PlateID exists in the Car table
    $checkCarQuery = "SELECT * FROM Car WHERE PlateID = '$carId'";
    $checkCarResult = $mysqli->query($checkCarQuery);

    // Check if the entered CustomerID exists in the Customer table
    $checkCustomerQuery = "SELECT * FROM Customer WHERE CustomerID = '$customerSsn'";
    $checkCustomerResult = $mysqli->query($checkCustomerQuery);
    if (!empty($startPeriod) && !empty($endPeriod) && $endPeriod < $startPeriod) {
        echo "Invalid period. Please make sure the end date is not earlier than the start date.";}
    elseif (!empty($carId) && $checkCarResult->num_rows === 0) {
        echo "Incorrect Plate ID. Please enter a valid Plate ID.";
    } elseif (!empty($customerSsn) && $checkCustomerResult->num_rows === 0) {
        echo "Incorrect Customer SSN. Please enter a valid Customer SSN.";
    } else {
            // Construct the base SQL query
            $query = "SELECT * FROM Reservation WHERE 1 = 1";

            // Add conditions based on the selected fields
            if (!empty($startPeriod)) {
                $query .= " AND PickupDate >= '$startPeriod'";
            }
            if (!empty($endPeriod)) {
                $query .= " AND PickupDate <= '$endPeriod'";
            }
            if (!empty($carId)) {
                $query .= " AND PlateID = '$carId'";
            }
            if (!empty($customerSsn)) {
                $query .= " AND CustomerID = '$customerSsn'";
            }

            // Execute the SQL query
            $result = $mysqli->query($query);

            // Display the results
            if ($result) {
                ob_start();
                if ($result->num_rows > 0) {
                    echo "<table border='1'>";
                    echo "<tr><th>Reservation ID</th><th>Customer ID</th><th>Pickup Date</th><th>Return Date</th><th>Plate ID</th><th>Office ID</th><th>Payment</th></tr>";
                    while ($reservation = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $reservation['ReservationID'] . "</td>";
                        echo "<td>" . $reservation['CustomerID'] . "</td>";
                        echo "<td>" . $reservation['PickupDate'] . "</td>";
                        echo "<td>" . $reservation['ReturnDate'] . "</td>";
                        echo "<td>" . $reservation['PlateID'] . "</td>";
                        echo "<td>" . $reservation['OfficeID'] . "</td>";
                        echo "<td>" . $reservation['Payment'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No Reservation found.";
                    $htmlContent = ob_get_clean();
                    echo $htmlContent;
                }
            } else {
                echo "Error in query: " . $mysqli->error;
            }
        }
    }


$mysqli->close();
?>
