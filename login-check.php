<?php 

//Authorization Access Control
//Check Whether the User is logged in or not
if(!isset($_SESSION['user'])) //If User Session is not Set
{
  //User is not logged in
  //Redirect to login page with message
  $_SESSION['no-login-message'] = "<div class='error text-center'>Please login to access Admin Panel.</div>";
  //Redirect to Login Page
  header('location:'.SITEURL.'admin/login.php');

}


?>