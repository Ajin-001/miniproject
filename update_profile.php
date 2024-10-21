<?php
// Start the session
session_start();



// Database connection
$link = mysqli_connect("localhost", "root", "", "phpmyadmin");

// Check the connection
if($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Fetch the logged-in doctor's email or id from session
$doctor_email = $_SESSION['login_user'];

// Fetch the doctor's current details from the database
$sql = "SELECT * FROM doctor WHERE email = '$doctor_email'";
$result = mysqli_query($link, $sql);
$doctor = mysqli_fetch_assoc($result);

// Check if form is submitted to update the details
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctor_name = mysqli_real_escape_string($link, $_POST['doctor_name']);
    $specialization = mysqli_real_escape_string($link, $_POST['specialization']);
    $phone_number = mysqli_real_escape_string($link, $_POST['phone_number']);
    $available_days = mysqli_real_escape_string($link, $_POST['available_days']);
    $available_time_from = mysqli_real_escape_string($link, $_POST['available_time_from']);
    $available_time_to = mysqli_real_escape_string($link, $_POST['available_time_to']);
    
    // Update query
    $update_sql = "UPDATE doctor SET doctor_name='$doctor_name', specialization='$specialization', phone_number='$phone_number', available_days='$available_days', available_time_from='$available_time_from', available_time_to='$available_time_to' WHERE email='$doctor_email'";

    if(mysqli_query($link, $update_sql)) {
        echo "<script>alert('Profile updated successfully');</script>";
    } else {
        echo "<script>alert('Error updating profile');</script>";
    }
}

// Close the database connection
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
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

        input {
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
    <h1>Doctor Profile Update</h1>
</header>
<nav>
<a href="doctor.php">Home</a>
    <a href="view_appointments.php">View Appointments</a>
  
    <a href="update_profile.php">Update Profile</a>
    <a href="logout.php">Logout</a>
</nav>
<div class="container">
    <h2>Edit Your Profile</h2>

    <form action="update_profile.php" method="POST">
        <label for="doctor_name">Doctor Name:</label>
        <input type="text" name="doctor_name" id="doctor_name" value="<?php echo $doctor['doctor_name']; ?>" required>

        <label for="specialization">Specialization:</label>
        <input type="text" name="specialization" id="specialization" value="<?php echo $doctor['specialization']; ?>" required>

        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" id="phone_number" value="<?php echo $doctor['phone_number']; ?>" required>

        <label for="available_days">Available Days:</label>
        <input type="text" name="available_days" id="available_days" value="<?php echo $doctor['available_days']; ?>" required>

        <label for="available_time_from">Available Time (From):</label>
        <input type="time" name="available_time_from" id="available_time_from" value="<?php echo $doctor['available_time_from']; ?>" required>

        <label for="available_time_to">Available Time (To):</label>
        <input type="time" name="available_time_to" id="available_time_to" value="<?php echo $doctor['available_time_to']; ?>" required>

        <input type="submit" value="Update Profile">
    </form>

    <div class="back-btn">
        <a href="doctor_dashboard.php">Back to Dashboard</a>
    </div>
</div>

</body>
</html>
