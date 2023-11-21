<?php
include('conn.php');

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'receptionist') {
    header('Location: login.php');
    exit();
}

// Code to add a patient
if (isset($_POST['add_patient'])) {
    $patient_name = $_POST['patient_name'];
    $dob = $_POST['dob'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $sql = "INSERT INTO patients (patient_name, dob, phone_number, email) VALUES ('$patient_name', '$dob', '$phone_number', '$email')";
        if ($conn->query($sql) === TRUE) {
        echo "Patient added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM patients WHERE email='$delete_id'";
    if ($conn->query($sql) === TRUE) {
        echo '<script>showDeleteNotification();</script>'; // Trigger notification on successful deletion
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reception Interface</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
  <style>
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: black;
            display: block;
        }
        .sidebar a:hover {
            background-color: #e9ecef;
            color: black;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <!-- Bootstrap-styled sidebar navigation -->
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="reception.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="appointments.php">Appointments</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="reception.php">Patients</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="doctors.php">Doctors</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="dashboard.php">Dashboard</a>
            </li>
            <!-- Add more links if needed -->
        </ul>
    </div>
     <div class="content">
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <p>Welcome, <strong><?php echo $_SESSION['username']; ?></strong>!</p>
            </div>
            <div class="col-md-6 text-md-right">
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
        <div class="alert alert-success" role="alert">
           <p>You have access to receptionist functionalities.</p>
        </div>
        <h2>Add Patient</h2>
        <form method="post" action="reception.php">
            <div class="form-group">
                <label for="patient_name">Patient Name:</label>
                <input type="text" class="form-control" id="patient_name" name="patient_name" required>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" class="form-control" id="dob" name="dob" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <button type="submit" class="btn btn-primary" name="add_patient" onclick="showNotification()">Add Patient</button>
        
        </form>

        <h2>Patient List</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Date of Birth</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch and display patient information from the database
                $sql = "SELECT * FROM patients";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $row['patient_name']; ?></td>
                            <td><?php echo $row['dob']; ?></td>
                            <td><?php echo $row['phone_number']; ?></td>
                            <td><?php echo $row['email']; ?></td>

                            <td>
                                <a href="appointment_booking.php?email=<?php echo $row['email']; ?>&patient=<?php echo $row['patient_name']; ?>" class="btn btn-info btn-sm">Book Appointment</a>
                                <a href="update_patient.php?email=<?php echo $row['email']; ?>" class="btn btn-info btn-sm">Update</a>
                                <a href="reception.php?delete_id=<?php echo $row['email']; ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "0 results";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
    </body>
</html>
