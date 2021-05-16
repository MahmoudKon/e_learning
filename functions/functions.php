<?php

  // Create Function To Make Selecte Data Catigories From Database
  function getCats(){
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM categories");
    $stmt->execute();
    $cats = $stmt->fetchAll();
    return $cats;
  }

  // Create Function To Make Selecte Data courses From Database [ All Courses ]
  function getAllCourses(){
    global $conn;
    $stmt = $conn->prepare("SELECT courses.*, users.UserName FROM `courses`
                        INNER JOIN users ON users.UserID = courses.User_ID
                        WHERE Approve = 1
                        ORDER BY Course_ID DESC");
    $stmt->execute();
    $cats = $stmt->fetchAll();
    return $cats;
  }

    // Filter Courses By Tags
    function filterByTags($tag){
      global $conn;
      $stmt = $conn->prepare("SELECT courses.*, users.UserName FROM `courses`
                          INNER JOIN users ON users.UserID = courses.User_ID
                          WHERE Approve = 1  $tag
                          ORDER BY Course_ID DESC");
      $stmt->execute();
      $tags = $stmt->fetchAll();
      return $tags;
    }

  // Create Function To Make Selecte Data courses From Database [ Some Courses ]
  function getCourses($where, $courseID, $approve=NULL, $limit=""){
    global $conn;
    $query = $approve == 1 ? "AND Approve = 1" : "";
    $stmt = $conn->prepare("SELECT courses.*, users.UserName FROM `courses`
                        INNER JOIN users ON users.UserID = courses.User_ID
                        WHERE $where = ? $query
                        ORDER BY Course_ID DESC $limit");
    $stmt->execute(array($courseID));
    $cats = $stmt->fetchAll();
    return $cats;
  }

// Count Number OF Items Function
function countComment($value){
  global $conn;
  $stmt = $conn->prepare("SELECT count(Comment) FROM comments WHERE Course_ID = ?");
  $stmt->execute(array($value));
  $rows = $stmt->fetchColumn();
  return $rows;
}

// Check If The User Statues Is Activate
function userStatus($user){
  global $conn;
  $stmt = $conn->prepare("SELECT * FROM users WHERE UserName = ? & Regstatus = 0");
  $stmt->execute(array($user));
  $count = $stmt->rowCount();
  return $count;
}

  // Make Function To Change The Title Page
  function pageTitle(){
    global $pageTitle;
    if(isset($pageTitle)){
      echo lang($pageTitle);
    }else{
      echo lang("ADMIN");
    }
  }

  // Home Redirect Function [ This Function Accept Param ]
function reHome($msg,$class, $url=null , $sec = 2){
  if($url === null){
    $url = "dashboard.php";
  }else{
    if(isset($_SERVER["HTTP_REFERER"]) && !empty($_SERVER["HTTP_REFERER"])){
      $url = $_SERVER["HTTP_REFERER"];
    }else{
      $url = "dashboard.php";
    }
  }
  echo "<div class='alert alert-$class'>$msg</div>";
  echo "<div class='alert alert-info'>
          You Will Back After $sec Second.
        </div>";
  header("refresh:$sec;url=$url");
  exit();
}

// Check Items From Database
function checkItem($select, $from, $value){
  global $conn;
  $stmt = $conn->prepare("SELECT $select FROM $from WHERE $select = ?");
  $stmt->execute(array($value));
  $count = $stmt->rowCount();
  return $count;
}

// Check User From Database
function checkuser($name , $id){
  global $conn;
  $stmt = $conn->prepare("SELECT * FROM users WHERE UserName = ? AND UserID = ?");
  $stmt->execute(array($name , $id));
  $count = $stmt->rowCount();
  return $count;
}


// Count Number OF Items Function
function countItems($item, $table){
  global $conn;
  $stmt = $conn->prepare("SELECT count($item) FROM $table");
  $stmt->execute();
  $rows = $stmt->fetchColumn();
  return $rows;
}

//  To Get Latest any Thing From Database
function getLatest($select, $table, $order, $limit = 5){
  global $conn;
  $stmt = $conn->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
  $stmt->execute();
  $rows = $stmt->fetchAll();
  return $rows;
}
