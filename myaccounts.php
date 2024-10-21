<?php
session_start();
$link = mysqli_connect("localhost", "root", "", "phpmyadmin");
if($link === false)
{
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
$login_session = $_SESSION['login_user'];

// Correct the query by using the variable $login_session
$qry = "SELECT id FROM pma__users WHERE username='$login_session'";
$res = mysqli_query($link, $qry);

// Fetch the result
$row = mysqli_fetch_assoc($res);
$user_id = $row['id'];

// Correct the second query by using the fetched $user_id
$sql = "SELECT firstname, lastname FROM pma__users WHERE id='$user_id'";
$user_welcome = mysqli_query($link, $sql);

// Fetch the user's first and last name
$user_data = mysqli_fetch_assoc($user_welcome);
$firstname = $user_data['firstname'];
$lastname = $user_data['lastname'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Catamaran|Poiret+One">
    <title>Appointments</title>
    <style>
        body {
            font-family: 'Catamaran', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #4CAF50; /* Green background for header */
            color: white;
            padding: 20px;
            text-align: center;
        }

        .logo {
            height: 130px;
            width: 130px;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #4CAF50; /* Changed to green */
            font-family: 'Poiret One', cursive;
        }

        li {
            float: left;
        }

        li a, .dropbtn {
            display: inline-block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        li a:hover, .dropdown:hover .dropbtn {
            background-color: #3e8e41; /* A darker green on hover */
        }

        li.dropdown {
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }

        .dropdown-content a:hover {
            background-color: #a4c7e4;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        h2 {
            color: black;
            text-align: center;
            margin-top: 20px;
        }

        .appointment-table {
            width: 50%;
            border-collapse: collapse;
            margin: 25px auto;
            font-size: 18px;
            text-align: left;
        }

        .appointment-table th, .appointment-table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
        }

        .appointment-table th {
            background-color: #f2f2f2;
            color: #333;
        }

        .appointment-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .appointment-table tr:hover {
            background-color: #f1f1f1;
        }

        .appointment-table a {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #007BFF;
            text-decoration: none;
        }
    </style>
</head>
<body>
<header>
    <h1><a href="index.html"><img src="images/Logo.png" class="logo" alt="Logo"></a></h1>
    <h2>
        <ul>
            <li><a href="myaccounts.php">Home</a></li>
            <li><a href="apptt.php">Book an appointment</a></li>
            <li><a href="Logout.php">LogOut</a></li>
            <li><a href="certificates1.php">Certificate</a></li>
            <li><a href="view_prescriptions.php">Prescription</a></li>

        </ul>
    </h2>
</header>

<br><br>
<h2>Welcome <?php echo $firstname . " " . $lastname; ?></h2>

<?php
// Fetching appointments
$sql = "SELECT Time, ApptDate, service FROM pet_clinic WHERE uid='$user_id'";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<br><br><h2>YOUR APPOINTMENTS</h2><br>";
    echo "<table class='appointment-table'>";
    echo "<tr><th>Appointment Date</th><th>Time</th><th>Service</th></tr>";
    
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["ApptDate"] . "</td>";
        echo "<td>" . $row["Time"] . "</td>";
        echo "<td>" . $row["service"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No Appointments booked!";
    echo "<a href='apptt.php'><br>Book An Appointment here!</a>";
}

mysqli_close($link);
?>
</body>
</html>
