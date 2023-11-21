<?php
$servername = "localhost";
    $username = "root";
    $password = "britam321";
    $dbname = "doctor_appointment";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
