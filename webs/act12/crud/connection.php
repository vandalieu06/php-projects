<?php
$server = "database";
$user = "botiga2026";
$password = "botiga2026";
$db = "botiga2026";
$connection = mysqli_connect($server, $user, $password, $db);

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}
?>
