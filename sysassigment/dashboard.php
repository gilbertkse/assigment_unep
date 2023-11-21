<?php
include('conn.php');

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'receptionist') {
    header('Location: login.php');
    exit();
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
           <p>You have access to admin functionalities.</p>
        </div>
        
        <h2>Patient Visits</h2>
<div class="row">
    <div class="col-md-3">
        <input type="text" class="form-control" id="patientNameFilter" placeholder="Patient Name">
    </div>
    <div class="col-md-3">
        <input type="text" class="form-control" id="doctorNameFilter" placeholder="Doctor Name">
    </div>
    <div class="col-md-3">
        <input type="date" class="form-control" id="appointmentDateFilter" placeholder="Appointment Date">
    </div>
    <div class="col-md-3">
        <button class="btn btn-primary" onclick="applyFilters()">Apply Filters</button>
    </div>
</div>

<table class="table">
    <!-- table headers -->
    <tbody id="visitsTableBody">
        <!-- table body content will be updated dynamically -->
    </tbody>
</table>

        <table class="table">
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>Doctor Name</th>
                    <th>Speciliazation</th>
                    <th>Appointment Time</th>
                    <th>Illness</th>
                    <th>Dignosis</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch and display patient information from the database
                $sql = "SELECT * FROM doctor_appointments";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                          $sqld = "SELECT * FROM doctors where email = '".$row['doctor_email']."'";
                           $resultd = $conn->query($sqld);
                           $rowd = $resultd->fetch_assoc();
                            $sqlp = "SELECT * FROM patients where email = '".$row['patient_email']."'";
                           $resultp = $conn->query($sqlp);
                           $rowp = $resultp->fetch_assoc();
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
            </tbody>
        </table>
    </div>
</div>
<script>
    function applyFilters() {
        var patientName = document.getElementById('patientNameFilter').value;
        var doctorName = document.getElementById('doctorNameFilter').value;
        var appointmentDate = document.getElementById('appointmentDateFilter').value;

        // Fetch data using AJAX with filtered parameters
        $.ajax({
            type: 'POST',
            url: 'filter_visits.php', // Create a PHP file to handle filtering
            data: {
                patientName: patientName,
                doctorName: doctorName,
                appointmentDate: appointmentDate
            },
            success: function(response) {
                $('#visitsTableBody').html(response);
            },
            error: function() {
                alert('Error occurred while fetching filtered data');
            }
        });
    }
</script>
    </body>
</html>
