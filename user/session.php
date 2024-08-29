<?php
$link = mysqli_connect("localhost", "root", "","phpmyadmin");
 if($link === false)
{
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
   session_start();
/*
   $user_check = $_SESSION['login_user'];

   $ses_sql = mysqli_query($link,"select id from pma__users where id = '$user_check' ");

   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);

   $login_session = $row['id'];

   if(!isset($_SESSION['login_user']))
   {
      header("location:login.php");
   }*/
?>
