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

// Get user ID and pet ID from the URL
if (isset($_GET['uid']) && isset($_GET['pet_id'])) {
    $uid = mysqli_real_escape_string($link, $_GET['uid']);
    $pet_id = mysqli_real_escape_string($link, $_GET['pet_id']);
} else {
    die("ERROR: Invalid parameters.");
}

// Query to fetch the owner's details
$owner_sql = "SELECT * FROM pma__users WHERE id='$uid'";
$owner_result = mysqli_query($link, $owner_sql);
$owner = mysqli_fetch_assoc($owner_result);

// Query to fetch the pet details
$pet_sql = "SELECT * FROM pet_info WHERE id='$pet_id'";
$pet_result = mysqli_query($link, $pet_sql);
$pet = mysqli_fetch_assoc($pet_result);

// Close the database connection
mysqli_close($link);

// Get today's date and calculate the next vaccination date (6 months from now)
$current_date = date('Y-m-d');
$next_vaccination_date = date('Y-m-d', strtotime('+6 months'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Vaccination Certificate</title>
    <link rel="stylesheet" href="project.css">
    <style>
        /* Add your CSS styles here */
        body {
            font-family: 'Arial', sans-serif;
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
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border: 2px solid #4CAF50;
        }
        h1, h2, h3 {
            color: #4CAF50;
        }
        h1 {
            font-size: 2.5em;
            margin-bottom: 0.5em;
        }
        h2 {
            font-size: 2em;
            margin-top: 0.5em;
            margin-bottom: 1em;
            text-align: center;
        }
        h3 {
            margin-top: 1.5em;
        }
        p {
            font-size: 1.2em;
            line-height: 1.5;
        }
        .certificate-info {
            display: flex; /* Use flexbox for layout */
            justify-content: space-between;
            margin-top: 20px;
            padding: 15px;
            border: 1px dashed #4CAF50; /* Border around the info */
            border-radius: 5px;
        }
        .owner-details, .pet-details {
            flex: 1; /* Allow each section to grow */
            padding: 10px; /* Add some padding */
        }
        .vaccination-form {
            margin-top: 20px;
            border: 1px solid #4CAF50; /* Border around vaccination form */
            padding: 15px;
            border-radius: 5px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"] {
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.2em;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<header>
    <h1>Vaccination Certificate</h1>
</header>
<section>
    <h2>Certificate of Vaccination</h2>
    <div class="certificate-info">
        <div class="owner-details">
            <h3>Owner Details:</h3>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($owner['firstname'] . ' ' . $owner['lastname']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($owner['email']); ?></p>
        </div>
        <div class="pet-details">
            <h3>Pet Details:</h3>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($pet['Name']); ?></p>
            <p><strong>Gender:</strong> <?php echo htmlspecialchars($pet['gender']); ?></p>
            <p><strong>Age:</strong> <?php echo htmlspecialchars($pet['age']); ?></p>
            <p><strong>Type:</strong> <?php echo htmlspecialchars($pet['type']); ?></p>
            <p><strong>Breed:</strong> <?php echo htmlspecialchars($pet['breed']); ?></p>
        </div>
    </div>

    <div class="vaccination-form">
        <h3>Vaccination Details:</h3>
        <p><strong>Vaccination Date:</strong> <?php echo htmlspecialchars($current_date); ?></p>
        <p><strong>Next Vaccination Date:</strong> <?php echo htmlspecialchars($next_vaccination_date); ?></p>

        <h3>Add Vaccination:</h3>
        <form action="add_vaccination.php" method="post">
            <label for="vaccination_name">Vaccination Name:</label>
            <input type="text" id="vaccination_name" name="vaccination_name" required>
            <input type="hidden" name="pet_id" value="<?php echo htmlspecialchars($pet['id']); ?>">
            <input type="hidden" name="uid" value="<?php echo htmlspecialchars($uid); ?>">
            <button type="submit">Add Vaccination</button>
        </form>
    </div>
</section>
</body>
</html>
