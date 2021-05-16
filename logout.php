<?php
// Start The Session
session_start();
// Unset The Data
session_unset();
// Destroy The Session
session_destroy();
// Send The User To Index Page
header("location: login.php");
exit();