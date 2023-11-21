<?php
include('conn.php'); // Include your database connection

if (isset($_POST['id']) && isset($_POST['idp']) && isset($_POST['date']) && isset($_POST['time']) ) {
	$id = $_POST['id'];
    $idp = $_POST['idp'];
	$date = $_POST['date'];
	$time = $_POST['time'];

    // $id = 'kje@britam.com';
    // $idp = 'kaml@un.org';
    // $date = 'sfsdfsdffsd';
    // $time = 'sdfsdf';
    $appointment_date = $date.' '.$time;
    $sql = "UPDATE doctor_appointments SET appointment_time = '".$appointment_date."' WHERE doctor_email = '".$id."' AND patient_email = '".$idp."'";

    if ($conn->query($sql) === TRUE) {
        return "Appointment updated successfully";
         
    } else {
        return "Error: " . $sql . "<br>" . $conn->error;
    }

}

?>