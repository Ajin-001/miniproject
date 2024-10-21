<?php
// Start session
session_start();

// Database connection
$link = mysqli_connect("localhost", "root", "", "phpmyadmin");

if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Check if user is logged in
if (!isset($_SESSION['login_user'])) {
    header("location: login.php");
    exit(); // Prevent further script execution
}

// Get the logged-in user's username (which is actually the email)
$login_user = $_SESSION['login_user'];

// Fetch appointments based on user type, and include owner and pet details
$appointments_sql = "
    SELECT pc.id, pc.Apptdate, pc.Time, pc.service, u.firstname, u.lastname, pc.uid
    FROM pet_clinic pc 
    JOIN pma__users u ON pc.uid = u.id
    WHERE pc.Doctor = '$login_user' AND pc.done = 0
";

// Execute the query
$appointments_result = mysqli_query($link, $appointments_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appointments</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/view_appointments.css"> <!-- Custom styling -->
    <style>
        body {
            font-family: 'Catamaran', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        header {
            background-color: #4CAF50;
            padding: 20px;
            text-align: center;
            color: white;
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

        h2 {
            text-align: center;
            font-size: 28px;
            color: #333;
            margin-top: 30px;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #ccc;
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

        tr:hover {
            background-color: #eaeaea;
        }

        p {
            text-align: center;
            font-size: 20px;
            color: #666;
            margin: 20px;
        }
        
        /* Style for buttons */
        .button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px; /* Consistent padding */
            margin-bottom: 10px; /* Space between buttons */
            cursor: pointer;
            text-align: center;
            width: 100%; /* Full width for buttons */
            border-radius: 4px; /* Rounded corners */
            transition: background-color 0.3s; /* Smooth hover effect */
            text-decoration: none; /* Remove underline */
            display: inline-block; /* Aligns link as a button */
            box-sizing: border-box; /* Ensures padding is included in width */
        }

        .button:hover {
            background-color: #45a049;
        }

        td {
            vertical-align: middle;
            text-align: center; /* Center align the content */
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
<h2>Your Appointments</h2>

<?php if (mysqli_num_rows($appointments_result) > 0): ?>
    <table>
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Owner</th>
            <th>Service</th>
            <th>Actions</th> <!-- Column for buttons -->
        </tr>
        <?php while ($row = mysqli_fetch_assoc($appointments_result)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['Apptdate']); ?></td>
                <td><?php echo htmlspecialchars($row['Time']); ?></td>
                <td><?php echo htmlspecialchars($row['firstname'] . ' ' . $row['lastname']); ?></td>
                <td><?php echo htmlspecialchars($row['service']); ?></td>
                <td>
                    <!-- Using anchor tag for completed action -->
                                   <form action="details.php" method="get" style="margin-top: 10px;">
                        <input type="hidden" name="uid" value="<?php echo htmlspecialchars($row['uid']); ?>">
                        <input type="hidden" name="appointment-id" value="<?php echo htmlspecialchars($row['id']); ?>">
                        <button type="submit" name="action" value="view" class="button">View Details</button>
                        <a href="completed.php?uid=<?php echo htmlspecialchars($row['uid']); ?>&appointment-id=<?php echo htmlspecialchars($row['id']); ?>" class="button">Completed</a>
     
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No appointments found.</p>
<?php endif; ?>

<?php
// Close connection
mysqli_close($link);
?>

</body>
</html>
