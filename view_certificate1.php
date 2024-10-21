<?php
session_start();
$link = mysqli_connect("localhost", "root", "", "phpmyadmin");

if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$pet_id = mysqli_real_escape_string($link, $_GET['pet_id']);

// Fetch the certificate details along with pet and owner details
$sql = "SELECT vc.*, pi.Name AS pet_name, pi.gender AS pet_gender, pi.age AS pet_age, 
               pi.type AS pet_type, pi.breed AS pet_breed, 
               u.firstname AS owner_firstname, u.lastname AS owner_lastname 
        FROM vaccination_certificates vc 
        JOIN pet_info pi ON vc.pet_id = pi.id 
        JOIN pma__users u ON vc.owner_id = u.id 
        WHERE vc.pet_id='$pet_id'";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
    $certificate = mysqli_fetch_assoc($result);
} else {
    die("No certificate found for the selected pet.");
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Details</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Libre+Baskerville|Catamaran">
    <style>
        body {
            font-family: 'Libre Baskerville', serif; /* Changed to a formal font */
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .certificate {
            width: 80%;
            margin: 25px auto;
            padding: 30px;
            border: 5px solid #4CAF50;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            position: relative;
            line-height: 1.6;
        }
        header {
            text-align: center;
            padding: 10px 0;
        }
        h1 {
            margin: 0;
            color: #4CAF50;
            font-size: 36px; /* Increased size for the title */
        }
        h2 {
            margin: 20px 0;
            color: #333;
            font-size: 24px; /* Increased size for section headers */
        }
        .details-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .details {
            width: 30%; /* Adjusting width for left, middle, and right */
            padding: 10px;
            border-right: 1px solid #ddd;
        }
        .details:last-child {
            border-right: none;
        }
        .details p {
            margin: 8px 0;
            font-size: 18px; /* Increased size for detail text */
        }
        .button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            font-size: 16px;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #45a049;
        }
        .footer {
            position: absolute;
            bottom: 10px;
            right: 10px;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>
<div class="certificate">
    <header>
        <h1>Vaccination Certificate</h1>
    </header>

    <div class="details-container">
        <!-- Owner Details Column -->
        <div class="details">
            <h2>Owner Details</h2>
            <p><strong>Owner Name:</strong> <?php echo htmlspecialchars($certificate['owner_firstname'] . ' ' . $certificate['owner_lastname']); ?></p>
        </div>

        <!-- Pet Details Column -->
        <div class="details">
            <h2>Pet Details</h2>
            <p><strong>Pet Name:</strong> <?php echo htmlspecialchars($certificate['pet_name']); ?></p>
            <p><strong>Pet Gender:</strong> <?php echo htmlspecialchars($certificate['pet_gender']); ?></p>
            <p><strong>Pet Age:</strong> <?php echo htmlspecialchars($certificate['pet_age']); ?></p>
            <p><strong>Pet Type:</strong> <?php echo htmlspecialchars($certificate['pet_type']); ?></p>
            <p><strong>Pet Breed:</strong> <?php echo htmlspecialchars($certificate['pet_breed']); ?></p>
        </div>

        <!-- Vaccination Details Column -->
        <div class="details">
            <h2>Vaccination Details</h2>
            <p><strong>Vaccination Name:</strong> <?php echo htmlspecialchars($certificate['vaccination_name']); ?></p>
            <p><strong>Vaccination Date:</strong> <?php echo htmlspecialchars($certificate['vaccination_date']); ?></p>
            <p><strong>Next Vaccination Date:</strong> <?php echo htmlspecialchars($certificate['next_vaccination_date']); ?></p>
        </div>
    </div>

    <button class="button" onclick="window.print()">Print Certificate</button>
    
    <div class="footer">
        &copy; <?php echo date("Y"); ?> Pet Care Management System
    </div>
</div>

</body>
</html>
