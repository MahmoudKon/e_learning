<?php
$dsn = "mysql:host=localhost;dbname=e_learning"; // DB Name and
$user = "root"; // User Name in DB
$pass = ""; // User Password in DB
$option = array(
  PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8" // To Database
);

// Connected
try {
  $conn = new PDO($dsn, $user, $pass, $option); // To Connected
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // To Send Errors to Catch
  // echo "Connected Database";
} catch (PDOException $e) {
  echo "faild To Connect" . $e->getMessage(); // Error Message
}
