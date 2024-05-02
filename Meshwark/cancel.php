<?php
$mysqli = new mysqli("localhost", "root", "", "car_rental_system");

if ($mysqli->connect_errno) {
    $message = "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the Cancel button is pressed
    if (isset($_POST['ReservationID'])) {
        $reservationID = $_POST['ReservationID'];

        // Check if the Reservation ID field is empty
        if (empty($reservationID)) {
            $message = "Please enter the reservation ID you want to cancel.";
        } else {
            // Check if the reservation ID exists in the Reservation table
            $checkReservationQuery = "SELECT 1 FROM Reservation WHERE ReservationID = '$reservationID'";
            $reservationExistenceResult = $mysqli->query($checkReservationQuery);

            if ($reservationExistenceResult->num_rows === 1) {
                // Reservation ID exists, proceed with cancellation
                $cancelReservationQuery = "DELETE FROM Reservation WHERE ReservationID = '$reservationID'";
                if ($mysqli->query($cancelReservationQuery)) {
                    $message = "Reservation canceled!";
                } else {
                    $message = "Error canceling reservation: " . $mysqli->error;
                }
            } else {
                $message = "Please enter a correct reservation ID.";
            }
        }
    }
}
$mysqli->close();
echo $message;
?>
