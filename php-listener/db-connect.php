<?php
// Database credentials
$mysql_host = "localhost";
$mysql_user = "root";
$mysql_pass = "usbw";
$dbname = "listener";
$tbname = "requests";

// Create Database connection and handler
$dbconnection = new mysqli($mysql_host,$mysql_user,$mysql_pass);
if (mysqli_connect_errno()) {
  die(
  '<h2 style="color:Red;">Could not connect to the DataBase Engine</h2>'
  . '<p style="color:Red;">'.mysqli_connect_error().'</p>'
  . '<p>Please, check MySQL engine permissions</p>'
  );
}?>
<pre>Log: Connected to DB Engine successfully</pre>