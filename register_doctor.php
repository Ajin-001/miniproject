<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Doctor</title>
    <style>
        body {
            font-family: 'Catamaran', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #4CAF50;
            padding: 20px;
            text-align: center;
            color: white;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #45a049;
        }
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            width: 100%;
            bottom: 0;
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
        }
    </style>
</head>
<body>

<header>
    <h1>Admin - Register Doctor</h1>
</header>
<nav>
    <a href="admin.php">Home</a>
    <a href="register_doctor.php">Register Doctor</a>
    <a href="view_users.php">View Users</a>
    <a href="view_doctors.php">View Doctors</a>
    <a href="logout.php">Logout</a>
</nav>
<div class="container">
    <h1>Register a New Doctor</h1>
    <form action="" method="POST">
        <label for="doctor_name">Doctor Name:</label>
        <input type="text" id="doctor_name" name="doctor_name" required>

        <label for="specialization">Specialization:</label>
        <input type="text" id="specialization" name="specialization" required>

        <label for="phone_number">Phone Number:</label>
        <input type="text" id="phone_number" name="phone_number" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="available_days">Available Days:</label>
        <input type="text" id="available_days" name="available_days" required>

        <label for="available_time_from">Available Time From:</label>
        <input type="time" id="available_time_from" name="available_time_from" required>

        <label for="available_time_to">Available Time To:</label>
        <input type="time" id="available_time_to" name="available_time_to" required>

        <hr>

        <h2>Doctor Login Credentials</h2>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" class="btn">Register Doctor</button>
    </form>
</div>
<br><br><br><br>
<footer>
    <p>Pet Care Management System &copy; 2024</p>
</footer>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $link = mysqli_connect("localhost", "root", "", "phpmyadmin");

    if ($link === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    // Collect data from the form
    $doctor_name = mysqli_real_escape_string($link, $_POST['doctor_name']);
    $specialization = mysqli_real_escape_string($link, $_POST['specialization']);
    $phone_number = mysqli_real_escape_string($link, $_POST['phone_number']);
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $available_days = mysqli_real_escape_string($link, $_POST['available_days']);
    $available_time_from = mysqli_real_escape_string($link, $_POST['available_time_from']);
    $available_time_to = mysqli_real_escape_string($link, $_POST['available_time_to']);
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $password = mysqli_real_escape_string($link, $_POST['password']); // In a real system, use password_hash() to hash the password
    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');

    // Insert into the doctor table
    $sql_doctor = "INSERT INTO doctor (doctor_name, specialization, phone_number, email, available_days, available_time_from, available_time_to, created_at, updated_at) 
                   VALUES ('$doctor_name', '$specialization', '$phone_number', '$email', '$available_days', '$available_time_from', '$available_time_to', '$created_at', '$updated_at')";

    if (mysqli_query($link, $sql_doctor)) {
        echo "<p>Doctor registered successfully!<br></p>";

        // Insert into the pma__users table with other fields as NULL
        $sql_user = "INSERT INTO pma__users (firstname, lastname, username, password, housenumber, street, num, urstel, email, utype) 
                     VALUES (NULL, NULL, '$username', '$password', NULL, NULL, NULL, NULL, '$email', 'doctor')";

        if (mysqli_query($link, $sql_user)) {
            echo "<p>Doctor user account created successfully!</p>";
        } else {
            echo "<p>ERROR: Could not create doctor user account. " . mysqli_error($link) . "</p>";
        }
    } else {
        echo "<p>ERROR: Could not register the doctor. " . mysqli_error($link) . "</p>";
    }

    mysqli_close($link);
}
?>

</body>
</html>
