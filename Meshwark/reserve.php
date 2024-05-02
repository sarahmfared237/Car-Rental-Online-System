<?php
$mysqli = new mysqli("localhost", "root", "", "car_rental_system");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are provided
    if (empty($_POST['PlateID']) || empty($_POST['CustomerID']) || empty($_POST['datepicker1']) || empty($_POST['datepicker2'])) {
        $message = "All reservation fields are required.";
    } else {
        // Retrieve reservation parameters from the form
        $PlateID = $_POST['PlateID'];
        $CustomerID = $_POST['CustomerID'];
        $pickupDate = $_POST['datepicker1'];
        $returnDate = $_POST['datepicker2'];

        // Check if the car's plate ID exists in the Car table
        $checkCarExistenceQuery = "SELECT 1 FROM Car WHERE PlateID = '$PlateID'";
        $carExistenceResult = $mysqli->query($checkCarExistenceQuery);

        if ($carExistenceResult->num_rows == 1) {
            // Check if the customer ID exists in the Customer table
            $checkCustomerExistenceQuery = "SELECT 1 FROM Customer WHERE CustomerID = '$CustomerID'";
            $customerExistenceResult = $mysqli->query($checkCustomerExistenceQuery);

            if ($customerExistenceResult->num_rows == 1) {
                // Continue with the reservation
                // Validate date format and pickup date being before or equal to the return date
                if (strtotime($pickupDate) && strtotime($returnDate) && $pickupDate <= $returnDate) {
                    // Check if the car is out of service
                    $checkCarStatusQuery = "SELECT Status FROM Car WHERE PlateID = '$PlateID'";
                    $carStatusResult = $mysqli->query($checkCarStatusQuery);

                    if ($carStatusResult) {
                        $carStatus = $carStatusResult->fetch_assoc()['Status'];

                        if ($carStatus != 'OutOfService') {
                            // Check if the car is not already reserved for the specified period
                            $checkExistingReservationQuery = "SELECT *
                                FROM Reservation
                                WHERE PlateID = '$PlateID'
                                    AND (
                                        ('$pickupDate' BETWEEN PickupDate AND ReturnDate)
                                        OR ('$returnDate' BETWEEN PickupDate AND ReturnDate)
                                        OR (PickupDate BETWEEN '$pickupDate' AND '$returnDate')
                                        OR (ReturnDate BETWEEN '$pickupDate' AND '$returnDate')
                                    )";

                            $existingReservationResult = $mysqli->query($checkExistingReservationQuery);

                            if ($existingReservationResult->num_rows == 0) {
                                // Get OfficeID and PricePerDay from the Car table
                                $carInfoQuery = "SELECT OfficeID, PricePerDay FROM Car WHERE PlateID = '$PlateID'";
                                $carInfoResult = $mysqli->query($carInfoQuery);

                                if ($carInfoResult) {
                                    $carInfo = $carInfoResult->fetch_assoc();
                                    $officeID = $carInfo['OfficeID'];
                                    $pricePerDay = $carInfo['PricePerDay'];

                                    // Calculate payment
                                    $dateDiff = strtotime($returnDate) - strtotime($pickupDate);
                                    $days = floor($dateDiff / (60 * 60 * 24));
                                    $payment = $days * $pricePerDay;

                                    // Insert reservation into the database
                                    $insertReservationQuery = "INSERT INTO Reservation (CustomerID, PlateID, OfficeID, PickupDate, ReturnDate, Payment)
                                        VALUES ('$CustomerID', '$PlateID', '$officeID', '$pickupDate', '$returnDate', '$payment')";

                                    if ($mysqli->query($insertReservationQuery)) {
                                        $message = "Reservation successful!";
                                    } else {
                                        $message = "Error in reservation: " . $mysqli->error;
                                    }
                                } else {
                                    $message = "Error retrieving car information: " . $mysqli->error;
                                }
                            } else {
                                $message = "Car already reserved for the specified period.";
                            }
                        } else {
                            $message = "Car is currently out of service.";
                        }
                    } else {
                        $message = "Error checking car status: " . $mysqli->error;
                    }
                } else {
                    $message = "Invalid period. Return date must be later than or equal to the pickup date.";
                }
            } else {
                $message = "Incorrect Customer ID. The specified customer does not exist.";
            }
        } else {
            $message = "Incorrect Plate ID. The specified car does not exist.";
        }
    }
    
$mysqli->close();
echo $message ;

}

?>