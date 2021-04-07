<?php
ob_start();
$animation = ["fadeIn"];

// Save The Value OF Session IN variable [ sessionUser ]
$sessionUser = "";
if(isset($_SESSION["user"])){
  $sessionUser = $_SESSION["user"];
  $sessionUserID = $_SESSION["uID"];
}

include "connection.php";
include "functions/functions.php";
include "template/header.php";
