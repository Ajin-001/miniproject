<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['login_user'])) {
    header("location: login.php");
    exit;
}

// Database connection
$link = mysqli_connect("localhost", "root", "", "phpmyadmin");

// Check the connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Get the user id from the URL or session
if (isset($_GET['uid'])) {
    $uid = mysqli_real_escape_string($link, $_GET['uid']);
} else {
    // If uid is not passed in URL, fetch it from the session
    $login_session = $_SESSION['login_user'];
    $qry = "SELECT id FROM pma__users WHERE username='$login_session'";
    $res = mysqli_query($link, $qry);
    $row = mysqli_fetch_assoc($res);
    $uid = $row['id'];
}

// Query to fetch the username based on the user ID
$sql = "SELECT username FROM pma__users WHERE id='$uid'";
$result = mysqli_query($link, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $username = $user['username'];
} else {
    $username = "Unknown User";
}

// Query to fetch the pet info based on the username
$pet_sql = "SELECT * FROM pet_info WHERE username='$username'";
$pet_result = mysqli_query($link, $pet_sql);

// Close the connection
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User and Pet Details</title>
    <link rel="stylesheet" href="project.css">
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
            padding: 1em;
        }
        section {
            margin: 2em auto;
            width: 80%;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2, h3 {
            color: #4CAF50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #45a049;
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
        .btn-container {
            display: flex;
            justify-content: space-between;
            gap: 10px; /* Space between buttons */
        }
        /* Set specific width for the Action column */
        th:last-child, td:last-child {
            width: 150px; /* Adjust width as needed */
        }
    </style>
</head>
<body>
<header>
    <h1>Doctor Dashboard</h1>
</header>
<nav>
    <a href="doctor.php">Home</a>
    <a href="view_appointments.php">View Appointments</a>
    <a href="update_profile.php">Update Profile</a>
    <a href="logout.php">Logout</a>
</nav>

<section>
    <h3>Your Pet Information:</h3>
    <?php if ($pet_result && mysqli_num_rows($pet_result) > 0): ?>
        <table>
            <tr>
                <th>Pet ID</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Age</th>
                <th>Type</th>
                <th>Breed</th>
                <th>Action</th>
            </tr>
            <?php while ($pet = mysqli_fetch_assoc($pet_result)): ?>
            <tr>
                <td><?php echo $pet['id']; ?></td>
                <td><?php echo $pet['Name']; ?></td>
                <td><?php echo $pet['gender']; ?></td>
                <td><?php echo $pet['age']; ?></td>
                <td><?php echo $pet['type']; ?></td>
                <td><?php echo $pet['breed']; ?></td>
                <td>
                    <div class="btn-container">
                        <a href="add_prescription.php?uid=<?php echo $uid; ?>" class="btn">Add Prescription</a>
                        <a href="certificate.php?uid=<?php echo $uid; ?>&pet_id=<?php echo $pet['id']; ?>" class="btn">Certificate</a>
                    </div>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No pets found for this user.</p>
    <?php endif; ?>
</section>

</body>
</html>
