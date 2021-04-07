<?php

function lang($phrase){

  static $lang = array(
          // Home Page

    // Navbar Links      
    'USERLOGIN' => "User Login",
    'ADMIN' => "Admin Area", 
    'SECTIONS' => "Categories",
    'Insert' => 'Insert',
    'ITEMS' => "Items",
    'VIDEOS' => "Videos",
    'MEMBERS' => "Members",
    'COMMENTS' => "Comments",
    'POSTS' => "Posts",
    'LOGS' => "Logs",
    'EDIT' => "Edit Profile",
    'OPTION' => "Settings",
    'EXIT' => "Logout",
    'LOGIN' => "Login",
    'DASHBOARD' => "Dashboard",
    'MEMBERS' => "Members",

    // Body
    'MESSAGE' => "Welcome",
  );
  return $lang[$phrase];
}