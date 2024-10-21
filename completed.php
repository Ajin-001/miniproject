<?php
// Start session
session_start();

// Database connection
$link = mysqli_connect("localhost", "root", "", "phpmyadmin");

if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Check if the uid and appointment-id are set in the GET request
if (isset($_GET['uid']) && isset($_GET['appointment-id'])) {
    // Retrieve and sanitize the values
    $uid = htmlspecialchars($_GET['uid']);
    $appointment_id = htmlspecialchars($_GET['appointment-id']);

    // Update the appointment status to done (1)
    $update_sql = "UPDATE pet_clinic SET done = 1 WHERE id = '$appointment_id'";

    if (mysqli_query($link, $update_sql)) {
        // Status updated successfully, redirect back to view appointments
        header("Location: view_appointments.php");
        exit();
    } else {
        // Handle error if the update fails
        echo "ERROR: Could not execute $update_sql. " . mysqli_error($link);
    }
} else {
    // Redirect back to appointments if not accessed properly
    header("Location: view_appointments.php");
    exit();
}

// Close connection
mysqli_close($link);
?>
