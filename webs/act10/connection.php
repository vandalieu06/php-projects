<?php
$server = "database";
$user = "gndaw2026";
$password = "gndaw2026";
$db = "gndaw2026";
$connection = mysqli_connect($server, $user, $password, $db);

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}
?>
