<?php
$mysqli = new mysqli("localhost", "root", "", "car_rental_system");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $checkQuery = "SELECT * FROM admin WHERE Email = '$email' AND Password = '$password'";
    $checkResult = $mysqli->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        $user = $checkResult->fetch_assoc();
        echo "Login successful"; // You can customize this message if needed
    } else {
        echo "Incorrect Email or Password";
    }
}

$mysqli->close();
?>
