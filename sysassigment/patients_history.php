<?php
include('conn.php');

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'doctor') {
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
                <a class="nav-link" href="patients_history.php">Patients</a>
            </li>
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
                                <a href="checkhistory.php?email=<?php echo $row['email']; ?>&patient=<?php echo $row['patient_name']; ?>" class="btn btn-info btn-sm">Check History</a>
                                
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
