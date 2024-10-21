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

// Get data from the form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = mysqli_real_escape_string($link, $_POST['uid']);
    $pet_id = mysqli_real_escape_string($link, $_POST['pet_id']);
    $vaccination_name = mysqli_real_escape_string($link, $_POST['vaccination_name']);
    $vaccination_date = date('Y-m-d'); // today's date
    $next_vaccination_date = date('Y-m-d', strtotime('+6 months')); // 6 months from today

    // Insert into vaccination_certificates table
    $insert_sql = "INSERT INTO vaccination_certificates (owner_id, pet_id, vaccination_name, vaccination_date, next_vaccination_date) 
                   VALUES ('$uid', '$pet_id', '$vaccination_name', '$vaccination_date', '$next_vaccination_date')";

    if (mysqli_query($link, $insert_sql)) {
        // Redirect back to details.php with success message
        header("location: details.php?uid=$uid&pet_id=$pet_id&success=1");
    } else {
        // Redirect back to details.php with error message
        header("location: details.php?uid=$uid&pet_id=$pet_id&error=1");
    }
}

// Close the database connection
mysqli_close($link);
?>
