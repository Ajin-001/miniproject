<?php
session_start();
$link = mysqli_connect("localhost", "root", "", "phpmyadmin");

if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$login_session = $_SESSION['login_user'];

// Get user ID
$qry = "SELECT id FROM pma__users WHERE username='$login_session'";
$res = mysqli_query($link, $qry);
$row = mysqli_fetch_assoc($res);
$user_id = $row['id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaccination Certificates</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Catamaran|Poiret+One">
    <style>
        body {
            font-family: 'Catamaran', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .certificate-table {
            width: 80%;
            margin: 25px auto;
            border-collapse: collapse;
            font-size: 18px;
            text-align: left;
        }
        .certificate-table th, .certificate-table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
        }
        .certificate-table th {
            background-color: #f2f2f2;
            color: #333;
        }
        .certificate-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .certificate-table tr:hover {
            background-color: #f1f1f1;
        }
        .button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<header>
    <h1>Vaccination Certificates</h1>
</header>

<?php
// Fetching certificates along with pet names
$sql = "SELECT vc.pet_id, vc.vaccination_name, vc.vaccination_date, vc.next_vaccination_date, pi.Name 
        FROM vaccination_certificates vc 
        JOIN pet_info pi ON vc.pet_id = pi.id 
        WHERE vc.owner_id='$user_id'";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<table class='certificate-table'>";
    echo "<tr><th>Pet Name</th><th>Vaccination Name</th><th>Vaccination Date</th><th>Next Vaccination Date</th><th>Action</th></tr>";
    
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["Name"] . "</td>"; // Display Pet Name instead of Pet ID
        echo "<td>" . $row["vaccination_name"] . "</td>";
        echo "<td>" . $row["vaccination_date"] . "</td>";
        echo "<td>" . $row["next_vaccination_date"] . "</td>";
        echo "<td><a href='view_certificate1.php?pet_id=" . $row["pet_id"] . "' class='button'>View Certificate</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No vaccination certificates found!</p>";
}

mysqli_close($link);
?>
</body>
</html>
