<?php
  session_start();
  if(isset($_SESSION["Username"])){
    $pageTitle = "COMMENTS";
    $active = "comments";
    $comm = "";
    include "init.php";  //  Include To init Routes File
    $comment = isset($_GET["comment"]) ? $_GET["comment"] : "posts";

if($comment == "posts"){ // Start Page Posts Comments
      $stmt = $conn->prepare("SELECT post_comments.*, users.UserName, users.Admin, posts.Post_Title FROM post_comments
                              INNER JOIN users ON users.UserID = post_comments.User_ID
                              INNER JOIN posts ON posts.PostID = post_comments.Post_ID
                              ORDER BY Post_ComentsID DESC");
      $stmt->execute();
      $rows = $stmt->fetchAll();
?>
<h1 class="text-center">Posts Comments</h1>
<div class="table-responsive"> <!-- Start Div Parent Class table-responsive -->
    <table class="custom-table table table-bordered text-center">   <!-- Start Table -->
        <thead>
          <tr>
            <td>#ID</td>
            <td>Comments</td>
            <td>Post Title</td>
            <td>User Name</td>
            <td>Date</td>
            <td>Controls</td>
          </tr>
        </thead>
          <div id="show-content">
            <?php 
              foreach ($rows as $row) { // Start Foreach Loop
                echo "<tr>";
                  echo "<td>" . $row["Post_ComentsID"] . "</td>"; // To echo The Comment ID
                  echo "<td>" . $row["Post_Comment_Desc"] . "</td>"; // To echo The Comment Content
                  echo "<td>" . $row["Post_Title"] . "</td>"; // To echo Where The Comments In [ Posts ]
                  echo "<td>" . $row["UserName"] . "</td>"; // To echo The Writen Comments [ User Name ]
                  echo "<td>" . date('l j F Y', strtotime($row["Post_Comment_Date"])) . "</td>"; // To echo The Comment's Date
                if($row['Admin'] == 1){
                  echo "<td><span class='alert alert-danger'>ADMIN</span></td>";
                }else{
                  echo "<td>";
                    // Button To Delete The Comment
                    echo "<button data-action='comment' data-id='".$row["Post_ComentsID"]."' data-type='posts' class='btn btn-danger del-comments'> <i class='fa fa-close'></i> </button>";
                  echo "</td>";
                }
                echo "</tr>";
              } // End Foreach Loop
            ?>
          </div>
    </table> <!-- End Table -->
<?php if(empty($rows)){ echo "<p class='alert alert-danger text-center container'>No Comments To View It !!</p>" ; } ?>

</div> <!-- End Div Parent Class table-responsive -->

<?php
// End Page Posts Comments
}elseif($comment == "courses"){  // Start Page Courses Comments
      $title = "Courses";
      $stmt = $conn->prepare("SELECT course_comment.*, users.UserName, users.Admin, users.UserImage, courses.Name
                              FROM `course_comment`
                              INNER JOIN users ON users.UserID = course_comment.User_ID 
                              INNER JOIN courses ON courses.Course_ID = course_comment.Course_ID 
                              ORDER BY CommentID DESC");
      $stmt->execute();
      $rows = $stmt->fetchAll();
?>

<h1 class="text-center">Courses Comments</h1>
<div class="table-responsive"> <!-- Start Div Parent Class table-responsive -->
    <table class="custom-table table table-bordered text-center">   <!-- Start Table -->
        <thead>
          <tr>
            <td>#ID</td>
            <td>Comments</td>
            <td>Course Name</td>
            <td>User Name</td>
            <td>Date</td>
            <td>Controls</td>
          </tr>
        </thead>
    <div id="show-content">
      <?php 
        foreach ($rows as $row) { // Start Foreach Loop
          echo "<tr>";
            echo "<td>" . $row["CommentID"] . "</td>"; // To echo The Comment ID
            echo "<td>" . $row["Comment"] . "</td>"; // To echo The Comment Content
            echo "<td>" . $row["Name"] . "</td>"; // To echo Where The Comments In [ Posts ]
            echo "<td>" . $row["UserName"] . "</td>"; // To echo The Writen Comments [ User Name ]
            echo "<td>" . date('l j F Y', strtotime($row["Date"])) . "</td>"; // To echo The Comment's Date
            if($row['Admin'] == 1){
              echo "<td><span class='alert alert-danger'>ADMIN</span></td>";
            }else{
              echo "<td>";
                echo "<button data-action='comment' data-id='".$row["CommentID"]."' data-type='course' class='btn btn-danger del-comments'> <i class='fa fa-close'></i> </button>";
              echo "</td>";
            }
          echo "</tr>";
        } // End Foreach Loop
      ?>
    </div>
  </table> <!-- End Table -->
<?php if(empty($rows)){ echo "<p class='alert alert-danger text-center container'>No Comments To View It !!</p>" ; } ?>

</div> <!-- End Div Parent Class table-responsive -->


<?php
// End Page Courses Comments
    }elseif($comment == "videos"){ // Start Page Videos Comments
      $title = "Videos";
      $stmt = $conn->prepare("SELECT comments.*, users.UserName, users.Admin, video_list.Video_Name, courses.Name FROM comments
                              INNER JOIN users ON users.UserID = comments.User_ID
                              INNER JOIN video_list ON video_list.Video_ID = comments.Video_List_ID
                              INNER JOIN courses ON courses.Course_ID = comments.Course_ID
                              ORDER BY Comment_ID DESC");
      $stmt->execute();
      $rows = $stmt->fetchAll();


?>
<h1 class="text-center">Videos Comments</h1>
<div class="table-responsive"> <!-- Start Div Parent Class table-responsive -->
    <table class="custom-table table table-bordered text-center">   <!-- Start Table -->
        <thead>
          <tr>
            <td>#ID</td>
            <td>Comments</td>
            <td>Course Name</td>
            <td>Video_Name</td>
            <td>User Name</td>
            <td>Date</td>
            <td>Controls</td>
          </tr>
        </thead>
    <div id="show-content">
      <?php 
        foreach ($rows as $row) { // Start Foreach Loop
          echo "<tr>";
            echo "<td>" . $row["Comment_ID"] . "</td>"; // To echo The Comment ID
            echo "<td>" . $row["Comment"] . "</td>"; // To echo The Comment Content
            echo "<td>" . $row["Name"] . "</td>"; // To echo Where The Comments In [ Posts ]
            echo "<td>" . $row["Video_Name"] . "</td>"; // To echo Where The Comments In [ Posts ]
            echo "<td>" . $row["UserName"] . "</td>"; // To echo The Writen Comments [ User Name ]
            echo "<td>" . date('l j F Y', strtotime($row["Comment_Date"])) . "</td>"; // To echo The Comment's Date
            if($row['Admin'] == 1){
              echo "<td><span class='alert alert-danger'>ADMIN</span></td>";
            }else{
              echo "<td>";
                echo "<button data-action='comment' data-id='".$row["Comment_ID"]."' data-type='videos' class='btn btn-danger del-comments'> <i class='fa fa-close'></i> </button>";
              echo "</td>";
            }
          echo "</tr>";
        } // End Foreach Loop
      ?>
    </div>
  </table> <!-- End Table -->
<?php if(empty($rows)){ echo "<p class='alert alert-danger text-center container'>No Comments To View It !!</p>" ; } ?>

</div> <!-- End Div Parent Class table-responsive -->

<?php
  } // End Page Videos Comments
  
}else{
    header("Location: index.php"); // Back To Login Page
    exit();
}
include $tpl."footer.php";  //  Include To Header File
?>