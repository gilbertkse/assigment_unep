<?php
include('conn.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT doctor_email, patient_email, appointment_time, appoint_id FROM doctor_appointments";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $bookings = array();
        while ($row = $result->fetch_assoc()) {
            $bookings[] = $row;
        }
        echo json_encode($bookings);
    } else {
        echo json_encode(array('message' => 'No bookings found.'));
    }
} else {
    echo json_encode(array('message' => 'Invalid request method.'));
}
?>
