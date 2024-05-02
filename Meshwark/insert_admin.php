<?php
$mysqli = new mysqli("localhost", "root", "", "car_rental_system");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are provided for car details
    if (empty($_POST['plate_id']) || empty($_POST['model']) || empty($_POST['year']) || empty($_POST['NoPassengers']) || empty($_POST['Status']) || empty($_POST['PricePerDay']) || empty($_POST['OfficeID'])) {
        $message = "All car details fields are required.";
    } else {
        // Retrieve car parameters from the form
        $plateID = $_POST['plate_id'];
        $model = $_POST['model'];
        $year = $_POST['year'];
        $noPassengers = $_POST['NoPassengers'];
        $status = $_POST['Status'];
        $pricePerDay = $_POST['PricePerDay'];
        $officeID = $_POST['OfficeID'];

        // Check if Plate ID already exists in the Car table
        $checkPlateIDQuery = "SELECT 1 FROM Car WHERE PlateID = '$plateID'";
        $plateIDResult = $mysqli->query($checkPlateIDQuery);

        if ($plateIDResult->num_rows > 0) {
            $message = "Plate ID already exists. Refusing insertion.";
        } else {
            // Check if Office ID exists in the Office table
            $checkOfficeIDQuery = "SELECT 1 FROM Office WHERE OfficeID = '$officeID'";
            $officeIDResult = $mysqli->query($checkOfficeIDQuery);

            if ($officeIDResult->num_rows > 0) {
                // Check if 'year' is an integer
                if (!is_numeric($year) || !is_int((int)$year)) {
                    $message = "Year must be an integer. Refusing insertion.";
                } else {
                    // Check if 'NoPassengers' is an integer
                    if (!is_numeric($noPassengers) || !is_int((int)$noPassengers)) {
                        $message = "Number of Passengers must be an integer. Refusing insertion.";
                    } else {
                        // Check if 'PricePerDay' is an integer
                        if (!is_numeric($pricePerDay) || !is_int((int)$pricePerDay)) {
                            $message = "Price per Day must be an integer. Refusing insertion.";
                        } else {
                            // Insert car details into the Car table
                            $insertCarQuery = "INSERT INTO Car (PlateID, Model, Year, NoPassengers, Status, PricePerDay, OfficeID)
                                VALUES ('$plateID', '$model', '$year', '$noPassengers', '$status', '$pricePerDay', '$officeID')";

                            if ($mysqli->query($insertCarQuery)) {
                                $message = "Car details inserted successfully!";
                            } else {
                                $message = "Error inserting car details: " . $mysqli->error;
                            }
                        }
                    }
                }
            } else {
                $message = "Office ID does not exist. Refusing insertion.";
            }
        }
    }

$mysqli->close();
echo $message ;
}

?>
