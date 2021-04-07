<?php
ob_start();
// File To Connect Database
include "connect.php";

// Routes
$tpl = "includes/templates/";  //  Template Directory
$lang = "includes/languages/";  //  Languages Directory
$func = "includes/functions/";  //  Functions Directory
$css = "layout/css/";  //  CSS Directory
$js = "layout/js/";  //  JS Directory


// Include The Important Files
include $lang."english.php";  //  Include To Languages File
include $func."functions.php";  //  Include To Functions File
include $tpl."header.php";  //  Include To Header File
// If The Page Have $noNavbar Variable Then Dont Show Navbar
if(!isset($noNavbar)){ include $tpl."navbar.php"; }  //  Include To Navbar File 