<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/petinfo.css">
  <link href="https://fonts.googleapis.com/css?family=Catamaran|Poiret+One" rel="stylesheet">
  <style>
    body {
      font-family: 'Catamaran', sans-serif;
      background-color: #f4f4f4;
      color: #333;
    }

    header {
      background-color: #4CAF50;
      padding: 20px;
      text-align: center;
    }

    header h1 {
      font-size: 2.5em;
      color: white;
    }

    header ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
      background-color: #4CAF50;
    }

    header ul li {
      float: left;
    }

    header ul li a {
      display: block;
      color: white;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
    }

    header ul li a:hover {
      background-color: #45a049;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 160px;
      z-index: 1;
    }

    .dropdown:hover .dropdown-content {
      display: block;
    }

    form {
      margin: 30px auto;
      padding: 20px;
      border: 1px solid #ccc;
      background-color: #fff;
      border-radius: 10px;
      width: 50%;
    }

    fieldset {
      border: 1px solid #4CAF50;
      border-radius: 5px;
      padding: 10px;
    }

    legend {
      color: #4CAF50;
      font-weight: bold;
    }

    input[type="text"], input[type="password"], input[type="number"], input[type="email"], input[type="tel"], select {
      width: 100%;
      padding: 12px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    input[type="submit"], button {
      width: 100%;
      background-color: #4CAF50;
      color: white;
      padding: 14px 20px;
      margin: 8px 0;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    input[type="submit"]:hover, button:hover {
      background-color: #45a049;
    }

    footer {
      text-align: center;
      margin-top: 20px;
    }

    .social-icon {
      width: 30px;
      height: 30px;
      margin: 5px;
    }

    #footer {
      font-size: 14px;
      color: #aaa;
    }
  </style>
</head>

<header>
  <center>
  <h1><a href="index.html"><img src="images/Logo.png" class="logo"></a></h1>
  </center>
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
  <form action="signup.php" method="post">
    <fieldset>
      <legend><b>Owner Information:</b></legend>
      First Name:<br>
      <input type="text" name="firstname">
      <br><br>
      Last name:<br>
      <input type="text" name="lastname">
      <br><br>
      <b>Address:</b><br><br>
      House Number:<br>
      <input type="text" name="housenumber">
      <br><br>
      Street:<br>
      <input type="text" name="street">
      <br><br>
      Pin Code:<br>
      <input type="number" name="num" size="6">
      <br><br>
      Phone number:<br>
      <input type="tel" name="urstel">
      <br><br>
      Email Id:<br>
      <input type="email" name="email">
      <br><br>
      Username:<br>
      <input type="text" name="username" id="username">
      <br><br>
      Password:<br>
      <input type="password" name="password" id="password">
      <br><br>
    </fieldset>
    <br>

    <fieldset>
      <legend><b>Pet Information:</b></legend>
      Name of Pet:<br>
      <input type="text" name="petname">
      <br><br>
      Gender:<br><br>
      <input type="radio" name="gender" value="Male">Male<br><br>
      <input type="radio" name="gender" value="Female">Female<br>
      <br>
      Age:<br>
      <input type="number" name="age">
      <br><br>
      Type:<br>
      <select name="type">
        <option value="Cat" name="type" id="cat">Cat</option>
        <option value="Dog" name="type" id="dog">Dog</option>
      </select>
      <br><br>
      Breed:<br>
      <select name="breed">
        <option value="American Bobtail" name="breed">American Bobtail</option>
        <option value="German Shepherd">German Shephard</option>
        <option value="Golden Retriever">Golden Retriever</option>
        <option value="Indian Pariah">Indian Pariah</option>
        <option value="Maine Coon">Maine Coon</option>
        <option value="Persian">Persian</option>
        <option value="Pugs">Pugs</option>
        <option value="Rottweiler">Rottweiler</option>
        <option value="Saint Bernard">Saint Bernard</option>
        <option value="Siamese">Siamese</option>
      </select>
      <br><br>
    </fieldset>
    <br><br>
    <input type="submit" value="Submit" id="btn"><br>
    <br><br>
  </form>

  <footer>
    <a href="http://www.facebook.com/pawsandclaws">
      <img src="images/facebook-wrap.png" alt="facebook logo" class="social-icon" id="fb">
    </a>
    <a href="http://www.twitter.com/pawsandclaws">
      <img src="images/twitter-wrap.png" alt="twitter logo" class="social-icon" id="twitter">
    </a>
    <p id="footer">&#169 2017 Paws and Claws</p>
  </footer>
</body>
</html>
