<?php
include('conn.php'); // Include your database connection

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'doctor') {
    header('Location: login.php');
    exit();
}
if (isset($_GET['email']) && isset($_GET['patient'])) {
	$email = $_GET['email'];
	$patient_name = $_GET['patient'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctors List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
      <script>
        $(document).ready(function(){
               // On checked event listener
            $('.row').on('change', '.checkbox', function(){
                if($(this).is(':checked')){
                    var row = $(this).closest('.row'); 
                    var demail = row.find('.d_email').val();
                     var pemail = row.find('.p_email').val();
                      var pname = row.find('.p_name').val();
                    alert(demail);
                $.ajax({
                    type: 'POST',
                    url: 'book.php', 
                    data: { demail:demail,pemail:pemail,pname:pname},
                    success: function(response){
                        alert('Appointment saved successfully!');
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
           <p>You have access to doctor functionalities.</p>
        </div>
        <h2>History based on visits: <?php echo $patient_name; ?></h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Doctor Name</th>
                    <th>Specialization</th>
                     <th>Descriptive visits</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch and display patient information from the database
                $sql = "SELECT * FROM patients WHERE email = '".$email ."'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $row['patient_name']; ?></td>
                            <td><?php echo $row['dob']; ?></td>
                            
                            <td><?php echo "Patient descriptive visits";
                            ?>
    </form></td>
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
</body>
</html>

<?php } ?>

