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

    // Check if the end date is less than the start date
    if (empty($startPeriod) || empty($endPeriod)) {
        echo "Please enter both dates";
    }
    else if ($endPeriod < $startPeriod) {
        echo "Invalid period. Please make sure the end date is not earlier than the start date.";
    } else {

        // Construct the base SQL query
        $query = "SELECT PickupDate, SUM(Payment) AS TotalPayment 
                  FROM Reservation 
                  WHERE PickupDate BETWEEN '$startPeriod' AND '$endPeriod' 
                  GROUP BY PickupDate";

        // Execute the SQL query
        $result = $mysqli->query($query);

        // Display the results in a table
        if ($result) {
            // Check if there are any results
            if ($result->num_rows > 0) {
                echo "<table border='1'>";
                echo "<tr><th>Pickup Date</th><th>Total Payment</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    // Display daily payment details
                    echo "<tr>";
                    echo "<td>" . $row['PickupDate'] . "</td>";
                    echo "<td>" . $row['TotalPayment'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No payments in the specified period.";
            }
        } else {
            echo "Error in query: " . $mysqli->error;
        }
    }
}

$mysqli->close();
?>