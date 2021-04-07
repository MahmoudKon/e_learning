<?php

function lang( $phrase ){

  static $lang = array(

    // Navbar Links
    'USERLOGIN' => "تسجيل دخول المستخدم",
    'ADMIN' => " منطقة المدير", 
    'SECTIONS' => "الأقسام",
    'ITEMS' => "بنود",
    'MEMBERS' => "الأعضاء",
    'STATISTICS' => "الإحصاءات",
    'LOGS' => "السجلات",
    'EDIT' => "تعديل",
    'OPTION' => "الإعدادات",
    'EXIT' => "خروج",
    'MESSAGE' => "مرحبا",
    'OPTION' => "خيارات",
    'LOGIN' => "تسجيل الدخول",
    'DASHBOARD' => "لوحة التحكم",

  );

  return $lang[$phrase];

}

?>