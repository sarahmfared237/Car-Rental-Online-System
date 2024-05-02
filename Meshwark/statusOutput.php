<?php
$mysqli = new mysqli("localhost", "root", "", "car_rental_system");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the search parameter from the form
    $period = $_POST['Period'];

    $query = "SELECT
    Car.PlateID,
    Car.Model,
    Car.Year,
    Car.NoPassengers,
    Car.PricePerDay,
    Car.OfficeID,
    CASE
        WHEN '$period' BETWEEN Reservation.PickupDate AND Reservation.ReturnDate THEN 'Rented'
        WHEN Car.Status = 'OutOfService' THEN 'Out of Service'
        ELSE 'Available'
    END AS UpdatedStatus
FROM
    Car
LEFT JOIN (
    SELECT
        PlateID,
        MAX(ReturnDate) AS MaxReturnDate
    FROM
        Reservation
    WHERE
        '$period' >= PickupDate
    GROUP BY
        PlateID
) AS MaxReservation ON Car.PlateID = MaxReservation.PlateID
LEFT JOIN Reservation ON Car.PlateID = Reservation.PlateID AND MaxReservation.MaxReturnDate = Reservation.ReturnDate";



    // Execute the SQL query
    $result = $mysqli->query($query);

    // Display the results in a table
    if ($result) {
        echo "<table border='1'>";
        echo "<tr><th>Plate ID</th><th>Model</th><th>Year</th><th>No. of Passengers</th><th>Price Per Day</th><th>Office ID</th><th>Status</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['PlateID'] . "</td>";
            echo "<td>" . $row['Model'] . "</td>";
            echo "<td>" . $row['Year'] . "</td>";
            echo "<td>" . $row['NoPassengers'] . "</td>";
            echo "<td>" . $row['PricePerDay'] . "</td>";
            echo "<td>" . $row['OfficeID'] . "</td>";
            echo "<td>" . $row['UpdatedStatus'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Error in query: " . $mysqli->error;
    }
}

$mysqli->close();
?>