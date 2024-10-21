<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Home Page</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Catamaran|Poiret+One">
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
        .container {
            margin: 30px auto;
            max-width: 900px;
            text-align: center;
        }
        h1 {
            font-size: 36px;
            color: #333;
        }
        p {
            font-size: 20px;
            color: #666;
        }
        .btn {
            display: inline-block;
            margin: 10px;
            padding: 12px 25px;
            font-size: 18px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #45a049;
        }
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            width: 100%;
            bottom: 0;
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

<div class="container">
    <h1>Doctor Dashboard</h1>
    <p>As a doctor, you can manage your appointments, patients, and personal information here.</p>
    
    <a href="view_appointments.php" class="btn">View Today's Appointments</a>
   
    <a href="update_profile.php" class="btn">Update Your Profile</a>
</div>

<footer>
    <p>&copy; 2024 Pet Care Management System. All rights reserved.</p>
</footer>

</body>
</html>
