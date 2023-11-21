<?php
include('conn.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['doctor_name'])) {
        $doctorName = $_GET['doctor_name'];
        $sql = "SELECT doctor_email, patient_email, appointment_time, appoint_id FROM doctor_appointments WHERE doctor_email = '$doctorName'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $bookings = array();
            while ($row = $result->fetch_assoc()) {
                $bookings[] = $row;
            }
            header('Content-Type: application/json');
            echo json_encode($bookings);
        } else {
            header('Content-Type: application/json');
            echo json_encode(array('message' => 'No bookings found for this doctor.'));
        }
    } else {
        header('Content-Type: application/json');
        echo json_encode(array('message' => 'Doctor name not provided.'));
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(array('message' => 'Invalid request method.'));
}

$conn->close();
?>
