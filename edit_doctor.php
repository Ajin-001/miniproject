<?php
// Start the session
session_start();

// Check if the user is logged in
if(!isset($_SESSION['login_user'])){
    header("location: login.php");
    die();
}

// Database connection
$link = mysqli_connect("localhost", "root", "", "phpmyadmin");

// Check the connection
if($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Check if doctor_id is set in the URL
if(isset($_GET['doctor_id'])) {
    $doctor_id = $_GET['doctor_id'];

    // Fetch the doctor's current details
    $sql = "SELECT * FROM doctor WHERE doctor_id = '$doctor_id'";
    $result = mysqli_query($link, $sql);
    $doctor = mysqli_fetch_assoc($result);

    // Check if form is submitted to update the details
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $doctor_name = mysqli_real_escape_string($link, $_POST['doctor_name']);
        $specialization = mysqli_real_escape_string($link, $_POST['specialization']);
        $phone_number = mysqli_real_escape_string($link, $_POST['phone_number']);
        $email = mysqli_real_escape_string($link, $_POST['email']);
        $available_days = mysqli_real_escape_string($link, $_POST['available_days']);
        $available_time_from = mysqli_real_escape_string($link, $_POST['available_time_from']);
        $available_time_to = mysqli_real_escape_string($link, $_POST['available_time_to']);

        // Update query
        $update_sql = "UPDATE doctor SET doctor_name='$doctor_name', specialization='$specialization', phone_number='$phone_number', email='$email', available_days='$available_days', available_time_from='$available_time_from', available_time_to='$available_time_to' WHERE doctor_id='$doctor_id'";

        if(mysqli_query($link, $update_sql)) {
            echo "<script>alert('Doctor details updated successfully');</script>";
            header("Location: view_doctors.php");
            exit;
        } else {
            echo "<script>alert('Error updating doctor details');</script>";
        }
    }
} else {
    echo "<script>alert('No doctor selected');</script>";
    header("Location: view_doctors.php");
    exit;
}

// Close the database connection at the end
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Doctor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 20px;
        }

        .container {
            width: 60%;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
        }

        input, select {
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            border: none;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .back-btn {
            text-align: center;
            margin-top: 20px;
        }

        .back-btn a {
            text-decoration: none;
            color: #4CAF50;
        }
        nav {
            display: flex;
            justify-content: space-around;
            background-color: #333;
        }
        nav a {
            color: white;
            text-decoration: none;
            padding: 14px 20px;
            display: block;
        }
        nav a:hover {
            background-color: #ddd;
            color: black;
        }
    </style>
</head>
<body>

<header>
    <h1>Edit Doctor Details</h1>
</header>
<nav>
    <a href="admin.php">Home</a>
    <a href="register_doctor.php">Register Doctor</a>
    <a href="view_users.php">View Users</a>
    <a href="view_doctors.php">View Doctors</a>
    <a href="logout.php">Logout</a>
</nav>
<div class="container">
    <h2>Edit Details for Doctor: <?php echo $doctor['doctor_name']; ?></h2>

    <form action="edit_doctor.php?doctor_id=<?php echo $doctor['doctor_id']; ?>" method="POST">
        <label for="doctor_name">Doctor Name:</label>
        <input type="text" name="doctor_name" id="doctor_name" value="<?php echo $doctor['doctor_name']; ?>" required>

        <label for="specialization">Specialization:</label>
        <input type="text" name="specialization" id="specialization" value="<?php echo $doctor['specialization']; ?>" required>

        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" id="phone_number" value="<?php echo $doctor['phone_number']; ?>" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo $doctor['email']; ?>" required>

        <label for="available_days">Available Days:</label>
        <input type="text" name="available_days" id="available_days" value="<?php echo $doctor['available_days']; ?>" required>

        <label for="available_time_from">Available Time (From):</label>
        <input type="time" name="available_time_from" id="available_time_from" value="<?php echo $doctor['available_time_from']; ?>" required>

        <label for="available_time_to">Available Time (To):</label>
        <input type="time" name="available_time_to" id="available_time_to" value="<?php echo $doctor['available_time_to']; ?>" required>

        <input type="submit" value="Update Doctor Details">
    </form>

    <div class="back-btn">
        <a href="view_doctors.php">Back to Doctor List</a>
    </div>
</div>

</body>
</html>
