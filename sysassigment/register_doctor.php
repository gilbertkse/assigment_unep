<?php
include('conn.php');

if ( isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password']; // You should hash this for security in a real application
    $specialization = $_POST['specialization'];
    $email = $_POST['email'];
    $av= 'available';

    $sql = "INSERT INTO doctors (doctor_name, specialization, email,availability) VALUES ('$username', '$specialization','$email',$av)";
    if ($conn->query($sql) === TRUE) {
    	$role = 'doctor';
        $sqlp = "INSERT INTO login (username,email, password,role) VALUES ('$username','$email', '$password','$role')";
    if ($conn->query($sqlp) === TRUE) {
        // Doctor registered successfully, redirect to login page or another appropriate action
         echo '<script>showUpdateNotification();</script>'; // Trigger notification on successful update
        header('Location: login.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Doctor Registration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Doctor Registration</h2>
        <form method="post" action="register_doctor.php">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="specialization">Specialization:</label>
                <input type="text" class="form-control" id="specialization" name="specialization" required>
            </div>
            <div class="form-group">
                <label for="specialization">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary" name="register">Register</button>
        </form>
    </div>
     <script>
        function showUpdateNotification() {
            // Implement JavaScript notification for successful update
            alert('Doctor Registered successfully!');
        }
    </script>
</body>
</html>
