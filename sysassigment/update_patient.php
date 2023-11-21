<?php
include('conn.php');

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'receptionist') {
    header('Location: login.php');
    exit();
}

if (isset($_GET['email'])) {
    $id = $_GET['email'];
    // Retrieve patient data based on the ID for pre-filling the form for update
    $sql = "SELECT * FROM patients WHERE email='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

// Code to update patient details
if (isset($_POST['update_patient'])) {
    $id = $_POST['email'];
    $patient_name = $_POST['patient_name'];
    $dob = $_POST['dob'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];

    $sql = "UPDATE patients SET patient_name='$patient_name', dob='$dob', phone_number='$phone_number', email='$email' WHERE email='$id'";

    if ($conn->query($sql) === TRUE) {
        echo '<script>showUpdateNotification();</script>'; // Trigger notification on successful update
        header('Location: reception.php');
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Patient</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Update Patient</h2>
        <form method="post" action="update_patient.php">
            <input type="hidden" name="id" value='<?php echo $row['email']; ?>'>
            <div class="form-group">
                <label for="patient_name">Patient Name:</label>
                <input type="text" class="form-control" id="patient_name" name="patient_name" value="<?php echo $row['patient_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $row['dob']; ?>" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo $row['phone_number']; ?>">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>">
            </div>
            <button type="submit" class="btn btn-primary" name="update_patient" onclick="showUpdateNotification()">Update Patient</button>
        </form>
    </div>

    <script>
        function showUpdateNotification() {
            // Implement JavaScript notification for successful update
            alert('Patient information updated successfully!');
        }
    </script>
</body>
</html>
