<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet"  href="css/login.css">
  <link href="https://fonts.googleapis.com/css?family=Catamaran|Poiret+One" rel="stylesheet">
<title>Login Page</title>
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

      h3 {
          color: #333;
          text-align: center;
          margin-top: 40px;
          font-size: 30px;
      }

      p {
          font-size: 18px;
          text-align: center;
          margin: 20px;
          line-height: 1.6;
          color: #333;
      }

      .background {
          background-color: #e8f5e9; /* Light greenish background for content area */
          padding: 50px;
          border-radius: 10px;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
          margin: 20px;
      }
  </style>
</head>
<header>
  <h1><a href="index.html"><img src="images/Logo.png" class="logo" alt="Logo"></a></h1>
  <h2>
    <ul>
      <li><a href="index.html">Home</a></li>
      <li><a href="about us.html">About Us</a></li>
      <li class="dropdown">
        <a href="javascript:void(0)" class="dropbtn">User</a>
        <div class="dropdown-content">
          <a href="login.php">Login</a>
          <a href="petinfo.php">Register</a>
          <a href="myaccounts.php">My Account</a>
        </div>
      </li>
      <li><a href="petclinic.html">Pet Clinic</a></li>
      <li><a href="contactus.html">Contact Us</a></li>
    </ul>
  </h2>
</header>
<body>

<br><br><br>
<div class="left">
<form action = "" method = "post" >
<fieldset>
  <legend>Log In</legend>
<label>UserName  :</label><br><input type = "text" name="username"  placeholder="Username..."><br /><br />
<label>Password  :</label><br><input type = "password" name = "password" placeholder="Password..."><br/><br />
<!-- <label>Confirm Password  :</label><br><input type = "password" name="confirmpassword" placeholder="Confirm Password..."><br/><br/>
-->
<input type = "submit" value = " Submit " id="btn" ><br />

<p>Not a registered user ? </p>
<a href="petinfo.php" target="_blank">Register here!<br></a>
<?php

$link = mysqli_connect("localhost", "root", "","phpmyadmin");
 if($link === false)
{
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

session_start();
   if($_SERVER["REQUEST_METHOD"] == "POST")
    {
      $myusername = mysqli_real_escape_string($link,$_POST['username']);
      $mypassword = mysqli_real_escape_string($link,$_POST['password']);
      // $confirmpassword = mysqli_real_escape_string($link,$_POST['confirmpassword']);
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $myusername = mysqli_real_escape_string($link, $_POST['username']);
        $mypassword = mysqli_real_escape_string($link, $_POST['password']);
    
        // Check user credentials
        $sql = "SELECT id, utype, password FROM pma__users WHERE username = '$myusername' AND password = '$mypassword'";
        $result = mysqli_query($link, $sql);
        $count = mysqli_num_rows($result);
    
        if ($count == 1) {
            $row = mysqli_fetch_assoc($result); // Fetch the user data
    
            $_SESSION['login_user'] = $myusername; // Store username in session
            
            // Check user type and redirect
            if ($row['utype'] == "user") {
                header("location: myaccounts.php");
                exit(); // Exit after redirection
            } elseif ($row['utype'] == "doctor") {
                header("location: doctor.php");
                exit(); // Exit after redirection
            }
            elseif ($row['utype'] == "admin") {
              header("location: admin.php");
              exit(); // Exit after redirection
          }
        } else {
            echo "<p style='color:red;'>Your Login Name or Password is invalid. Try Again!</p>";
        }
    }
    
        else
        {
            echo "<p style='color:red;'> Your Login Name or Password is invalid,Try Again!</p>";

        }
      }
      else
      {
            echo  "Your passwords dont match!";

      }

    
?>

</fieldset>
</form>
</div>

</body>



</footer>

</html>
