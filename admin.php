<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Catamaran&display=swap" rel="stylesheet">
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
        .options {
            display: flex;
            justify-content: space-around;
            margin-top: 30px;
            gap:30px ;
        }
        .option {
            width: 30%;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 10px;
            background-color: #fff;
        }
    </style>
</head>
<body>

<header>
    <h1>Admin Dashboard</h1>
</header>

<nav>
    <a href="admin.php">Home</a>
    <a href="register_doctor.php">Register Doctor</a>
    <a href="view_users.php">View Users</a>
    <a href="view_doctors.php">View Doctors</a>
    <a href="logout.php">Logout</a>
</nav>

<div class="container">
    <h1>Welcome Admin!</h1>
    <p>Manage all aspects of the system from here.</p>

    <div class="options">
        <div class="option">
            <h2>Register a New Doctor</h2>
            <p>Add a new doctor to the system</p>
            <a href="register_doctor.php" class="btn">Register Doctor</a>
        </div>

        <div class="option">
            <h2>Manage Users</h2>
            <p>View and manage registered users.</p>
            <a href="view_users.php" class="btn">View Users</a>
        </div>
  
        <div class="option">
            <h2>Manage Doctors</h2>
            <p>View and manage registered doctors.</p>
            <a href="view_doctors.php" class="btn">View Doctors</a>
        </div>

    </div>
</div>

<footer>
    <p>&copy; 2024 Admin Dashboard - Pet Care Management</p>
</footer>

</body>
</html>
