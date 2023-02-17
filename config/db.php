<?php
$servername = "localhost";
$port = "3307";
$username = "root";
$password = "youssef";
$dbname= "gallery";

try {
  $GLOBALS['conn'] = new PDO("mysql:host=$servername:$port;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $GLOBALS['conn']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>

