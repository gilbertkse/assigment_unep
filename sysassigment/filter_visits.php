<?php
include('conn.php');

// Fetch filter values from POST
$patientName = $_POST['patientName'];
$doctorName = $_POST['doctorName'];
$appointmentDate = $_POST['appointmentDate'];

$sql = "SELECT * FROM doctor_appointments da
        INNER JOIN patients p ON da.patient_email = p.email
        INNER JOIN doctors d ON da.doctor_email = d.email
        WHERE 1";

if (!empty($patientName)) {
    $sql .= " AND p.patient_name LIKE '%$patientName%'";
}
if (!empty($doctorName)) {
    $sql .= " AND d.doctor_name LIKE '%$doctorName%'";
}
if (!empty($appointmentDate)) {
    $sql .= " AND DATE(da.appointment_time) = '$appointmentDate'";
}

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
       ?>
       <tr>
                            <td><?php echo $rowp['patient_name']; ?></td>
                            <td><?php echo $rowd['doctor_name']; ?></td>
                            <td><?php echo $rowd['specialization']; ?></td>
                            <td><?php echo $row['appointment_time']; ?></td>
                            
                        </tr>
       <?php
    }
} else {
    echo "0 results";
}
?>
