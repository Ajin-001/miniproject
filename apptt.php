<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Catamaran|Poiret+One">
  <link rel="stylesheet" type="text/css" href="project.css">
</head>
<style>

    header{
      background-color: #4CAF50;
    }
 ul{
  background-color: #4CAF50;
 }
 .one
 {
  background-color: #4CAF50;
 }
</style>

<body>
<header>
    <center><h1><a href="index.html"><img src="images/Logo.png" class="logo" alt="Logo"></a></h1></center>
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
  <form name="clinicform" class="box" action="" method="post">
    <img src="images/forms.png" height="700px">
    <h2>We require details for what's bothering that little one!<br></h2><br><br>

    <label for="city">City:</label><br>
    <select name="city">
      <option value="Delhi">Kottayam</option>
    </select>
    <br><br>

    <label for="service">Clinic Service:</label><br>
    <select name="service">
      <option value="Vaccination">Vaccination</option>
      <option value="X and Ultrasound">X-ray and Ultrasound</option>
      <option value="Laser">Laser Therapy</option>
      <option value="PE">Physical Exams</option>
      <option value="Surgery">Surgery</option>
    </select>
    <br><br>

    <label for="grooming">Grooming:</label><br>
    <select name="grooming">
      <option value="Nail Cutting and Nail Polish">Nail Cutting and Nail Polish</option>
      <option value="Hair Cutting">Hair Cutting</option>
      <option value="Bath">Bath</option>
      <option value="Prophy">Prophy</option>
    </select>
    <br><br>

    <h3>BOOK AN APPOINTMENT! <br>ENTER DATE AND TIME SUITABLE TO YOU...</h3>

    4 time slots are available, except on <b>SUNDAY</b>, when we need a rest!<br>
    <ul class="a">
      <br>09:00 AM
      <br>12:00 NOON
      <br>16:00 PM
    </ul>
    <br>

    <label for="time"><br>Time:</label><br>
    <select name="time">
      <option value="9 AM">09:00 AM</option>
      <option value="10 AM">10:00 AM</option>
      <option value="11 AM">11:00 AM</option>
      <option value="12 PM">12:00 NOON</option>
      <option value="01 PM">01:00 PM</option>
      <option value="02 PM">02:00 PM</option>
      <option value="03 PM">03:00 PM</option>
      <option value="04 PM">04:00 PM</option>
    </select>
    <br>

    <label for="Apptdate">Date:</label><br>
    <input type="date" name="Apptdate" id="Apptdate" required><br>

    <label for="Doctor"><br>Doctor:</label><br>
    <select name="Doctor" id="Doctor">
      <?php
      // Database connection
      $link = mysqli_connect("localhost", "root", "", "phpmyadmin");

      // Check the connection
      if($link === false) {
          die("ERROR: Could not connect. " . mysqli_connect_error());
      }

      // Fetch the doctors from the database
      $sql = "SELECT doctor_name, email FROM doctor"; // Select both doctor name and email
      $result = mysqli_query($link, $sql);

      // Display doctors in the dropdown
      if(mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
              echo '<option value="' . $row['email'] . '">' . $row['doctor_name'] . '</option>'; // Store email in the value attribute
          }
      } else {
          echo '<option value="">No doctors available</option>';
      }

      // Close the connection
      mysqli_close($link);
      ?>
    </select>
    <br><br>

    <input style="background-color: #4CAF50;" type="submit" value="Submit"><br>

    <?php
    session_start();
    $link = mysqli_connect("localhost", "root", "", "phpmyadmin");
    if($link === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    $login_session = $_SESSION['login_user'];

    // Correct the query by using the appropriate column name
    $qry = "SELECT id FROM pma__users WHERE username='$login_session'";
    $res = mysqli_query($link, $qry);

    // Fetch the result
    $row = mysqli_fetch_assoc($res);
    $uid = $row['id'];

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $time = mysqli_real_escape_string($link, $_REQUEST['time']);
        $Apptdate = mysqli_real_escape_string($link, $_REQUEST['Apptdate']);
        $Doctor = mysqli_real_escape_string($link, $_REQUEST['Doctor']); // This now holds the email
        $service = mysqli_real_escape_string($link, $_REQUEST['service']);

        // Check if the appointment is available
        $results = "SELECT * FROM pet_clinic WHERE (`Time` LIKE '%".$time."%') AND (`Apptdate` LIKE '%".$Apptdate."%') AND (`Doctor` LIKE '%".$Doctor."%')";
        $result = mysqli_query($link, $results);

        if (mysqli_num_rows($result) > 0) {
            echo '<span style="color: red;" /><center>No Appointment available, kindly select another option!</center></span>';
        } else {
            $sql = "INSERT INTO pet_clinic (uid, Time, Apptdate, Doctor, service,done) VALUES ('$uid', '$time', '$Apptdate', '$Doctor', '$service',0)";
            if(mysqli_query($link, $sql)) {
              header("Location: apptt.php");
                echo "Appointment Booked!";
            } else {
                echo "Not booked!";
            }
        }
    }

    mysqli_close($link);
    ?>
  </form>

</body>
</html>
