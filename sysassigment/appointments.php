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
      <script>
        $(document).ready(function(){
               // On checked event listener
            $('.row').on('change', '.checkbox', function(){
                if($(this).is(':checked')){
                    var row = $(this).closest('.row'); 
                    var date = row.find('.date').val();
                     var time = row.find('.time').val();
                      var id = row.find('.apid').val();
                       var idp = row.find('.apidp').val();
                    //alert(date+time+id+idp);
                $.ajax({
                    type: 'POST',
                    url: 'update_appointment.php', 
                    data: { date:date,time:time,id:id,idp:idp},
                    success: function(response){
                        alert(response + 'Appointment updated successfully!');
                        location.reload(true);
                        // You can perform further actions here after data is saved
                    },
                    error: function(){
                        alert('Error occurred while saving data');
                    }
                });
                }
            });
        
        });
    </script>
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
           <p>You have access to receptionist functionalities.</p>
        </div>
        
        <h2>Appointments List</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>Doctor Name</th>
                    <th>Speciliazation</th>
                    <th>Appointment Time</th>
                    <th>Action</th>
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
                            <td>
                                <?php 
                            echo "<form class='row'>
                                <input type='date' class='date form-control' id='appoint_date' name='appoint_date' required>
                                <input type='hidden' value=" . $row['doctor_email']."  class='apid'>
                                <input type='hidden' value=" . $row['patient_email']."  class='apidp'>
                                <input type='time' class='time form-control' id='appoint_time' name='appoint_time' required>Update appointment time<input type='checkbox' class='checkbox' class='form-control'>";
                                ?>
                                
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
