<?php
// File To Connect Database
include "connect.php";

$action = isset($_POST['action']) ? $_POST['action'] : "";



/*
=====================================================================================================================================
=============================================== Start Delete Comments ===============================================================
=====================================================================================================================================
*/
if ($action == "comment") {
   $id = $_POST['id'];
   $type   = $_POST['type'];
   if ($type == "posts") {
      $stmt = $conn->prepare("DELETE FROM `post_comments` WHERE `Post_ComentsID` = ?");
      $stmt->execute(array($id));
      if ($stmt) {
         $stmt = $conn->prepare("SELECT post_comments.*, users.UserName, posts.Post_Title FROM post_comments
                                    INNER JOIN users ON users.UserID = post_comments.User_ID
                                    INNER JOIN posts ON posts.PostID = post_comments.Post_ID
                                    ORDER BY Post_ComentsID DESC");
         $stmt->execute();
         $rows = $stmt->fetchAll();
      }
   } elseif ($type == "course") {
      $id = $_POST['id'];
      $type   = $_POST['type'];
      $stmt = $conn->prepare("DELETE FROM `course_comment` WHERE `CommentID` = ?");
      $stmt->execute(array($id));
      if ($stmt) {
         $stmt = $conn->prepare("SELECT course_comment.*, users.UserName, users.UserImage, courses.Name
                                    FROM `course_comment`
                                    INNER JOIN users ON users.UserID = course_comment.User_ID 
                                    INNER JOIN courses ON courses.Course_ID = course_comment.Course_ID 
                                    ORDER BY CommentID DESC");
         $stmt->execute();
         $rows = $stmt->fetchAll();
      }
   } elseif ($type == "videos") {
      $id = $_POST['id'];
      $type   = $_POST['type'];
      $stmt = $conn->prepare("DELETE FROM `comments` WHERE `Comment_ID` = ?");
      $stmt->execute(array($id));
      if ($stmt) {
         $stmt = $conn->prepare("SELECT comments.*, users.UserName, video_list.Video_Name, courses.Name FROM comments
                                    INNER JOIN users ON users.UserID = comments.User_ID
                                    INNER JOIN video_list ON video_list.Video_ID = comments.Video_List_ID
                                    INNER JOIN courses ON courses.Course_ID = comments.Course_ID
                                    ORDER BY Comment_ID DESC");
         $stmt->execute();
         $rows = $stmt->fetchAll();
      }
   }
   /*
=====================================================================================================================================
=============================================== End Delete Comments =================================================================
=====================================================================================================================================
*/



   /*
=====================================================================================================================================
=============================================== Start Delete Items ==================================================================
=====================================================================================================================================
*/
} elseif ($action == "item") {
   $id = $_POST['id'];
   $type = $_POST['type'];

   if ($type == "delete") {
      $stmt = $conn->prepare("DELETE FROM `courses` WHERE `Course_ID` = ?");
      $stmt->execute(array($id));
   } elseif ($type == "approve") {
      $stmt = $conn->prepare("UPDATE `courses` SET `Approve` = 1 WHERE `Course_ID` = ?");
      $stmt->execute(array($id));
   }
   if ($stmt) {
      $stmt = $conn->prepare("SELECT courses.*, categories.Name AS Category_Name, users.UserName FROM `courses`
                              INNER JOIN categories ON categories.ID = courses.Categories_ID 
                              INNER JOIN users ON users.UserID = courses.User_ID
                              ORDER BY Course_ID DESC");
      $stmt->execute();
      $rows = $stmt->fetchAll();
   }

   /*
=====================================================================================================================================
=============================================== End Delete Items ====================================================================
=====================================================================================================================================
*/

   /*
=====================================================================================================================================
=============================================== Start Delete Videos =================================================================
=====================================================================================================================================
*/
} elseif ($action == "video") {
   $id = $_POST['id'];
   $type = $_POST['type'];

   if ($type == "delete") {
      $stmt = $conn->prepare("DELETE FROM `video_list` WHERE `Video_ID` = ?");
      $stmt->execute(array($id));
   }
   if ($stmt) {
      $stmt = $conn->prepare("SELECT video_list.*, categories.Name AS Category_Name, users.UserName, courses.Name
                              FROM `video_list`
                              INNER JOIN categories ON categories.ID = video_list.Cat_ID 
                              INNER JOIN courses ON courses.Course_ID = video_list.Course_ID 
                              INNER JOIN users ON users.UserID = video_list.User_ID
                              ORDER BY Video_ID DESC");
      $stmt->execute();
      $rows = $stmt->fetchAll();
   }

   /*
=====================================================================================================================================
=============================================== End Delete Videos ===================================================================
=====================================================================================================================================
*/


   /*
=====================================================================================================================================
=============================================== Start Delete Members ================================================================
=====================================================================================================================================
*/
} elseif ($action == "members") {
   $id = $_POST['id'];
   $type = $_POST['type'];

   if ($type == "delete") {
      $stmt = $conn->prepare("DELETE FROM `users` WHERE `UserID` = ?");
      $stmt->execute(array($id));
   } elseif ($type == "approve") {
      $stmt = $conn->prepare("UPDATE `users` SET `Regstatus` = 1 WHERE `UserID` = ?");
      $stmt->execute(array($id));
   }
   // Select All Users Except Admins
   $stmt = $conn->prepare("SELECT * FROM users WHERE Admin != 1 ORDER BY UserID DESC");
   // Execute The Statment
   $stmt->execute();
   $rows = $stmt->fetchAll();

   /*
=====================================================================================================================================
=============================================== End Delete Members ==================================================================
=====================================================================================================================================
*/


   /*
=====================================================================================================================================
=============================================== Start Delete Posts ================================================================
=====================================================================================================================================
*/
} elseif ($action == "post") {
   $id = $_POST['id'];
   $type = $_POST['type'];

   if ($type == "delete") {
      $stmt = $conn->prepare("DELETE FROM `posts` WHERE `PostID` = ?");
      $stmt->execute(array($id));
   } elseif ($type == "approve") {
      $stmt = $conn->prepare("UPDATE `posts` SET `Post_Approve` = 1 WHERE `PostID` = ?");
      $stmt->execute(array($id));
   }
   // Select All Posts Except Admins
   $stmt = $conn->prepare("SELECT posts.*, categories.Name, users.UserName FROM `posts`
                              INNER JOIN categories ON categories.ID = posts.Cat_ID 
                              INNER JOIN users ON users.UserID = posts.User_ID
                              ORDER BY PostID DESC LIMIT $numItems");
   // Execute The Statment
   $stmt->execute();
   $rows = $stmt->fetchAll();

   /*
=====================================================================================================================================
=============================================== End Delete Posts ==================================================================
=====================================================================================================================================
*/


   /*
=====================================================================================================================================
=============================================== Start Delete Posts ================================================================
=====================================================================================================================================
*/
} elseif ($action == "cats") {
   $id = $_POST['id'];
   $type = $_POST['type'];

   if ($type == "delete") {
      $stmt = $conn->prepare("DELETE FROM `categories` WHERE `ID` = ?");
      $stmt->execute(array($id));
   } elseif ($type == "visibile") {
      $stmt = $conn->prepare("UPDATE `categories` SET `Visibility` = 1 WHERE `ID` = ?");
      $stmt->execute(array($id));
   } elseif ($type == "ads") {
      $stmt = $conn->prepare("UPDATE `categories` SET `Ads` = 1 WHERE `ID` = ?");
      $stmt->execute(array($id));
   } elseif ($type == "comment") {
      $stmt = $conn->prepare("UPDATE `categories` SET `Comments` = 1 WHERE `ID` = ?");
      $stmt->execute(array($id));
   } elseif ($type == "approve") {
      $stmt = $conn->prepare("UPDATE `categories` SET ` ` = 1 WHERE `ID` = ?");
      $stmt->execute(array($id));
   }

   // Select All Catigories Except Admins
   $stmt = $conn->prepare("SELECT * FROM `categories` ORDER BY ID DESC LIMIT $numCats");
   // Execute The Statment
   $stmt->execute();
   $rows = $stmt->fetchAll();
} elseif ($action == "option") {
   $id = $_POST['id'];
   $type = $_POST['type'];

   $stmt = $conn->prepare("SELECT * FROM categories WHERE ID = ?");
   $stmt->execute(array($id));
   $row = $stmt->fetch();
   if ($type == "ads") {
      if ($row["Ads"] == 1) {
         $stmt = $conn->prepare("UPDATE `categories` SET `Ads` = 0 WHERE `ID` = ?");
         $stmt->execute(array($id));
      } else {
         $stmt = $conn->prepare("UPDATE `categories` SET `Ads` = 1 WHERE `ID` = ?");
         $stmt->execute(array($id));
      }
   } elseif ($type == "comment") {
      if ($row["Comments"] == 1) {
         $stmt = $conn->prepare("UPDATE `categories` SET `Comments` = 0 WHERE `ID` = ?");
         $stmt->execute(array($id));
      } else {
         $stmt = $conn->prepare("UPDATE `categories` SET `Comments` = 1 WHERE `ID` = ?");
         $stmt->execute(array($id));
      }
   } elseif ($type == "visibil") {
      if ($row["Visibility"] == 1) {
         $stmt = $conn->prepare("UPDATE `categories` SET `Visibility` = 0 WHERE `ID` = ?");
         $stmt->execute(array($id));
      } else {
         $stmt = $conn->prepare("UPDATE `categories` SET `Visibility` = 1 WHERE `ID` = ?");
         $stmt->execute(array($id));
      }
   }

   /*
=====================================================================================================================================
=============================================== End Delete Posts ====================================================================
=====================================================================================================================================
*/
} elseif ($action == "change") {
   /*
=====================================================================================================================================
============================================= Start Create Pages To Print Users =====================================================
=====================================================================================================================================
*/
   $page = $_POST['page'];
   $pageCount = $_POST['pageCount'];
   $range = ($page - 1) * $pageCount;

   $stmt = $conn->prepare("SELECT * FROM `users` LIMIT $range , $pageCount ");
   // Execute The Statment
   $stmt->execute();
   $rows = $stmt->fetchAll();
   foreach ($rows as $row) {
      echo "<tr>";
      echo "<td>" . $row["UserID"] . "</td>";
      echo "<td>" . $row["NickName"] . "</td>";
      echo "<td>" . $row["FullName"] . "</td>";
      echo "<td>" . $row["Email"] . "</td>";
      echo "<td>" . $row["Gender"] . "</td>";
      echo "<td>" . $row["Country"] . "</td>";
      echo "<td>" . $row["Phone"] . "</td>";
      echo "<td>" . $row["Date"] . "</td>";
      if ($row["Admin"] == 1) {
         echo "<td><span class='alert alert-danger'>ADMIN</span></td>";
      } else {
         echo "<td>";
         echo "<a href='members.php?action=Edit&userid=" . $row['UserID'] . "&name=" . $row['UserName'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>";

         echo "<a href=''data-action='members' data-type='delete' data-id='" . $row['UserID'] . "' class='btn btn-danger del-comments ml-2 mr-2'><i class='fa fa-close'></i> Delete</a>";

         if ($row["Regstatus"] == 0) {
            echo "<a href=''data-action='members' data-type='approve' data-id='" . $row['UserID'] . "' class='btn btn-info del-comments'><i class='fa fa-check'></i> Approve</a>";
         }
         echo "</td>";
      }
      echo "</tr>";
   }


   /*
=====================================================================================================================================
============================================= End Create Pages To Print Users =======================================================
=====================================================================================================================================
*/
} elseif ($action == "searchUser") {
   /*
   =====================================================================================================================================
   ============================================= Start Search By User Name =====================================================
   =====================================================================================================================================
   */
   $name = $_POST['name'];
   $type = $_POST['type'];

   $query = empty($name) ? " LIMIT 0,5 " : "  WHERE `" . $type . "` LIKE '%$name%' ";

   $stmt = $conn->prepare("SELECT * FROM `users` $query ");
   // Execute The Statment
   $stmt->execute();
   $rows = $stmt->fetchAll();
   foreach ($rows as $row) {
      echo "<tr>";
      echo "<td>" . $row["UserID"] . "</td>";
      echo "<td>" . $row["NickName"] . "</td>";
      echo "<td>" . $row["FullName"] . "</td>";
      echo "<td>" . $row["Email"] . "</td>";
      echo "<td>" . $row["Gender"] . "</td>";
      echo "<td>" . $row["Country"] . "</td>";
      echo "<td>" . $row["Phone"] . "</td>";
      echo "<td>" . $row["Date"] . "</td>";
      if ($row["Admin"] == 1) {
         echo "<td><span class='alert alert-danger'>ADMIN</span></td>";
      } else {
         echo "<td>";
         echo "<a href='members.php?action=Edit&userid=" . $row['UserID'] . "&name=" . $row['UserName'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>";

         echo "<a href=''data-action='members' data-type='delete' data-id='" . $row['UserID'] . "' class='btn btn-danger del-comments ml-2 mr-2'><i class='fa fa-close'></i> Delete</a>";

         if ($row["Regstatus"] == 0) {
            echo "<a href=''data-action='members' data-type='approve' data-id='" . $row['UserID'] . "' class='btn btn-info del-comments'><i class='fa fa-check'></i> Approve</a>";
         }
         echo "</td>";
      }
      echo "</tr>";
   }


   /*
   =====================================================================================================================================
   ============================================= End Search By User Name =====================================================
   =====================================================================================================================================
   */
} elseif ($action == "searchItem") {
   /*
   =====================================================================================================================================
   ============================================= Start Search By Item Name =====================================================
   =====================================================================================================================================
   */
   $name = $_POST['name'];
   $type = $_POST['type'];

   $query = empty($name) ? "" : "  WHERE `" . $type . "` LIKE '%$name%' ";

   $stmt = $conn->prepare("SELECT courses.*, categories.Name AS Category_Name, users.UserName FROM `courses`
                              INNER JOIN categories ON categories.ID = courses.Categories_ID 
                              INNER JOIN users ON users.UserID = courses.User_ID
                              $query
                              ORDER BY Course_ID DESC");
   // Execute The Statment
   $stmt->execute();
   $rows = $stmt->fetchAll();
   foreach ($rows as $row) {
      $price = $row["Price"] == 0 || $row["Price"] == "free" ? "Free" : "$" . $row["Price"];
      echo "<tr>";
      echo "<td>" . $row["Course_ID"] . "</td>";
      echo "<td>" . $row["Name"] . "</td>";
      echo "<td>" . $row["Course_Describe"] . "</td>";
      echo "<td>" . $price . "</td>";
      echo "<td>" . date('l j F Y', strtotime($row["Add-Date"])) . "</td>";
      echo "<td>" . $row["Country"] . "</td>";
      echo "<td>" . $row["Status"] . "</td>";
      echo "<td>" . $row["UserName"] . "</td>";
      echo "<td>" . $row["Category_Name"] . "</td>";
      echo "<td>";
      echo "<a href='items.php?action=Edit&courseid=" . $row['Course_ID'] . "&name=" . $row['Name'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>";

      echo "<a href='' data-type='delete' data-action='item' data-id='" . $row['Course_ID'] . "' class='btn btn-danger del-comments ml-2 mr-2'><i class='fa fa-close'></i> Delete</a>";

      if ($row["Approve"] == 0) {
         echo "<a href='' data-type='approve' data-action='item' data-id='" . $row['Course_ID'] . "' class='btn btn-info del-comments'><i class='fa fa-check'></i> Approve</a>";
      }
      echo "</td>";
      echo "</tr>";
   }


   /*
   =====================================================================================================================================
   ============================================= End Search By Item Name =====================================================
   =====================================================================================================================================
   */
} elseif ($action == "searchPost") {

   /*
   =====================================================================================================================================
   ============================================= Start Search By Item Name =====================================================
   =====================================================================================================================================
   */
   $name = $_POST['name'];
   $type = $_POST['type'];

   $query = empty($name) ? "" : "  WHERE `" . $type . "` LIKE '%$name%' ";

   $stmt = $conn->prepare("SELECT posts.*, categories.Name, users.UserName, users.Admin FROM `posts`
                           INNER JOIN categories ON categories.ID = posts.Cat_ID 
                           INNER JOIN users ON users.UserID = posts.User_ID
                           $query
                           ORDER BY PostID DESC");
   // Execute The Statment
   $stmt->execute();
   $rows = $stmt->fetchAll();
   foreach ($rows as $row) {
      echo "<tr>";
      echo "<td>" . $row["PostID"] . "</td>";
      echo "<td>" . $row["Post_Title"] . "</td>";
      echo "<td>" . $row["Post_Description"] . "</td>";
      echo "<td>" . date('l j F Y', strtotime($row["Post_Date"])) . "</td>";
      echo "<td>" . $row["Post_Tags"] . "</td>";
      echo "<td>" . $row["UserName"] . "</td>";
      echo "<td>" . $row["Name"] . "</td>";
      if ($row['Admin'] == 1) {
         echo "<td><span class='alert alert-danger'>ADMIN</span></td>";
      } else {
         echo "<td>";
         echo "<a href='#' class='btn btn-danger del-comments' data-id='" . $row['PostID'] . "' data-action='post' data-type='delete' ><i class='fa fa-close'></i> Delete</a>";
         if ($post["Post_Approve"] == 0) {
            echo "<a href='#' data-action='post' data-id='" . $post["PostID"] . "' data-type='approve' class='btn btn-info btn-sm del-dash'> <i class='fa fa-check'></i> Activate</a>";
         }
         echo "</td>";
      }
      echo "</tr>";
   }


   /*
   =====================================================================================================================================
   ============================================= End Search By Item Name =====================================================
   =====================================================================================================================================
   */
}
