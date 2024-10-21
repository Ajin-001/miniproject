<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['login_user'])) {
    header("location: login.php"); // Redirect to login page if not logged in
    exit;
}

// Database connection
$link = mysqli_connect("localhost", "root", "", "phpmyadmin");

// Check the connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Get the username from the session
$login_session = $_SESSION['login_user'];

// Query to get the user ID based on the username
$qry = "SELECT id FROM pma__users WHERE username='$login_session'";
$res = mysqli_query($link, $qry);

// Check if the user exists
if ($res && mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_assoc($res);
    $user_id = $row['id']; // Get user ID
} else {
    echo "<script>alert('User not found!'); window.location.href='login.php';</script>";
    exit;
}

// Query to fetch the pet_id for the user based on username
$pet_sql = "SELECT id, Name FROM pet_info WHERE username='$login_session'";
$pet_result = mysqli_query($link, $pet_sql);

// Check if any pets are associated with the user
if (!$pet_result || mysqli_num_rows($pet_result) == 0) {
    echo "<p class='error'>No pets found for this user!</p>";
    exit;
}

// Fetch prescriptions for the user's pets
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 24px;
        }
        section {
            margin: 40px auto;
            width: 80%;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #4CAF50;
            margin-bottom: 20px;
        }
        .error {
            color: red;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

    <header>
        Prescription List
    </header>

<section>
    <?php
    while ($pet = mysqli_fetch_assoc($pet_result)) {
        $pet_id = $pet['id']; // Fetch pet_id for each pet
        $pet_name = $pet['Name']; // Fetch pet name

        // Query to get prescriptions based on pet_id
        $prescription_sql = "SELECT prescription_details, created_at FROM prescriptions WHERE pet_id='$pet_id'";
        $prescription_result = mysqli_query($link, $prescription_sql);

        // Check if any prescriptions exist for the pet
        if ($prescription_result && mysqli_num_rows($prescription_result) > 0) {
            echo "<h2>Prescriptions for Pet: " . $pet_name . "</h2>";
            echo "<table>
                    <tr>
                        <th>Prescription Details</th>
                        <th>Date</th>
                    </tr>";

            while ($prescription = mysqli_fetch_assoc($prescription_result)) {
                echo "<tr>
                        <td>" . $prescription['prescription_details'] . "</td>
                        <td>" . $prescription['created_at'] . "</td>
                      </tr>";
            }

            echo "</table>";
        } else {
            echo "<p class='error'>No prescriptions found for " . $pet_name . "</p>";
        }
    }

    // Close the database connection
    mysqli_close($link);
    ?>
</section>

</body>
</html>
