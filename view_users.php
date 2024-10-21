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

    // Delete user from database
    $delete_sql = "DELETE FROM pma__users WHERE id='$remove_id'";
    if(mysqli_query($link, $delete_sql)) {
        echo "<script>alert('User removed successfully');</script>";
    } else {
        echo "<script>alert('Error removing user');</script>";
    }
}

// Query to fetch all users from the pma__users table with utype 'user'
$sql = "SELECT id, firstname, lastname,housenumber, street, num, urstel, email, utype FROM pma__users WHERE utype='user'";
$result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
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

        .remove-btn {
            background-color: #e74c3c;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
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
    <h1>User Management</h1>
</header>
<nav>
    <a href="admin.php">Home</a>
    <a href="register_doctor.php">Register Doctor</a>
    <a href="view_users.php">View Users</a>
    <a href="view_doctors.php">View Doctors</a>
    <a href="logout.php">Logout</a>
</nav>
<div class="container">
    <h2>List of Users</h2>

    <!-- Table for displaying users -->
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>House Number</th>
                <th>Street</th>
                <th>Street Number</th>
                <th>Contact</th>
                <th>Email</th>
                <th>User Type</th>
                <th>Action</th> <!-- Add a column for the remove button -->
            </tr>
        </thead>
        <tbody>
        <?php
        // Loop through all the results and display each user
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['firstname'] . "</td>";
                echo "<td>" . $row['lastname'] . "</td>";
                echo "<td>" . $row['housenumber'] . "</td>";
                echo "<td>" . $row['street'] . "</td>";
                echo "<td>" . $row['num'] . "</td>";
                echo "<td>" . $row['urstel'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['utype'] . "</td>";
                echo "<td><a href='view_users.php?remove_id=" . $row['id'] . "' class='remove-btn' onclick='return confirm(\"Are you sure you want to remove this user?\");'>Remove</a></td>"; // Add remove button
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='11'>No users found</td></tr>";
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
