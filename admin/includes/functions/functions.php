<?php

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

// Check Items From Database by 2 Condition
function checkuser($name , $id){
  global $conn;
  $stmt = $conn->prepare("SELECT UserName FROM users WHERE UserName = ? AND UserID = ?");
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
function getLatest($select, $table, $where, $order, $limit = 5){
  global $conn;
  $stmt = $conn->prepare("SELECT $select FROM $table $where ORDER BY $order DESC LIMIT $limit");
  $stmt->execute();
  $rows = $stmt->fetchAll();
  return $rows;
}
