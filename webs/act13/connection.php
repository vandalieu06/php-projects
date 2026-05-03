<?php
$server = "database";
$user = "vehicles2026";
$password = "vehicles2026";
$db = "vehicles2026";
$connection = mysqli_connect($server, $user, $password, $db);

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}
?>
