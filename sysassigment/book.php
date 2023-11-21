<?php
include('conn.php'); // Include your database connection

if (isset($_POST['demail']) && isset($_POST['pemail']) && isset($_POST['pname']) ) {
	$d_email = $_POST['demail'];
	$p_email = $_POST['pemail'];
	$p_name = $_POST['pname'];

    $appointment_date = date('Y-m-d H:i:s');

    $sql = "INSERT INTO doctor_appointments (doctor_email, patient_email, appointment_time) VALUES ('$d_email', '$p_email', '$appointment_date')";
    if ($conn->query($sql) === TRUE) {

 $sql2 = "UPDATE doctors set availability = 'Not Available' WHERE email = '$d_email'";

    if ($conn->query($sql2) === TRUE) {
        return "Appointment booked successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }

        
    } else {
        return "Error: " . $sql . "<br>" . $conn->error;
    }

}

?>