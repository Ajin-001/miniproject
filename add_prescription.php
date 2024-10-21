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

// Get the user ID from the URL
if (isset($_GET['uid'])) {
    $uid = mysqli_real_escape_string($link, $_GET['uid']);
} else {
    header("location: doctor.php");
    exit;
}

// Query to fetch pets for the logged-in user
$pet_sql = "SELECT * FROM pet_info WHERE username=(SELECT username FROM pma__users WHERE id='$uid')";
$pet_result = mysqli_query($link, $pet_sql);

// Check if pets exist for the user
if (!$pet_result || mysqli_num_rows($pet_result) == 0) {
    echo "<script>alert('No pets found for this user.'); window.location.href='doctor.php';</script>";
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pet_id = mysqli_real_escape_string($link, $_POST['pet_id']);
    $prescription_details = mysqli_real_escape_string($link, $_POST['prescription_details']);
    
    // Insert prescription into the database
    $sql = "INSERT INTO prescriptions (pet_id, doctor_id, prescription_details, created_at) 
            VALUES ('$pet_id', '$uid', '$prescription_details', NOW())";
    
    if (mysqli_query($link, $sql)) {
        echo "<script>alert('Prescription added successfully!'); window.location.href='view_appointments.php';</script>";
    } else {
        echo "ERROR: Could not execute $sql. " . mysqli_error($link);
    }
}

// Close the connection
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Prescription</title>
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
        h2 {
            color: #4CAF50;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<header>
    <h1>Add Prescription</h1>
</header>

<section>
    <h2>Select Pet and Add Prescription</h2>
    <form action="" method="POST">
        <div class="form-group">
            <label for="pet_id">Select Pet:</label>
            <select id="pet_id" name="pet_id" required>
                <?php while ($pet = mysqli_fetch_assoc($pet_result)): ?>
                    <option value="<?php echo $pet['id']; ?>"><?php echo $pet['Name']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="prescription_details">Prescription Details:</label>
            <textarea id="prescription_details" name="prescription_details" rows="5" required></textarea>
        </div>
        <button type="submit">Add Prescription</button>
    </form>
</section>

</body>
</html>
