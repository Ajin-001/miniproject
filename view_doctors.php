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

// Check if the remove button was clicked and process the removal
if(isset($_GET['remove_id'])) {
    $remove_id = $_GET['remove_id'];

    // Delete doctor from database
    $delete_sql = "DELETE FROM doctor WHERE doctor_id='$remove_id'";
    if(mysqli_query($link, $delete_sql)) {
        echo "<script>alert('Doctor removed successfully');</script>";
    } else {
        echo "<script>alert('Error removing doctor');</script>";
    }
}

// Query to fetch all doctors from the doctor table
$sql = "SELECT doctor_id, doctor_name, specialization, phone_number, email, available_days, available_time_from, available_time_to FROM doctor";
$result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Doctors</title>
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
            width: 80%;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #4CAF50;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        h2 {
            text-align: center;
        }

        .action-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
        }

        .edit-btn {
            background-color: #3498db;
        }

        .edit-btn:hover {
            background-color: #2980b9;
        }

        .remove-btn {
            background-color: #e74c3c;
        }

        .remove-btn:hover {
            background-color: #c0392b;
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
    <h1>Doctor Management</h1>
</header>
<nav>
    <a href="admin.php">Home</a>
    <a href="register_doctor.php">Register Doctor</a>
    <a href="view_users.php">View Users</a>
    <a href="view_doctors.php">View Doctors</a>
    <a href="logout.php">Logout</a>
</nav>
<div class="container">
    <h2>List of Doctors</h2>

    <!-- Table for displaying doctors -->
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Specialization</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Available Days</th>
                <th>Available Time (From)</th>
                <th>Available Time (To)</th>
                <th>Action</th> <!-- Add a column for the edit and remove buttons -->
            </tr>
        </thead>
        <tbody>
        <?php
        // Loop through all the results and display each doctor
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['doctor_id'] . "</td>";
                echo "<td>" . $row['doctor_name'] . "</td>";
                echo "<td>" . $row['specialization'] . "</td>";
                echo "<td>" . $row['phone_number'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['available_days'] . "</td>";
                echo "<td>" . $row['available_time_from'] . "</td>";
                echo "<td>" . $row['available_time_to'] . "</td>";
                echo "<td>
                        <a href='edit_doctor.php?doctor_id=" . $row['doctor_id'] . "' class='action-btn edit-btn'>Edit</a>
                        <a href='view_doctors.php?remove_id=" . $row['doctor_id'] . "' class='action-btn remove-btn' onclick='return confirm(\"Are you sure you want to remove this doctor?\");'>Remove</a>
                      </td>"; // Add edit and remove buttons
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9'>No doctors found</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
// Close the database connection
mysqli_close($link);
?>
