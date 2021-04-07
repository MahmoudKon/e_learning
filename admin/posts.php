<?php
ob_start();
session_start();
$pageTitle = "POSTS";
$active = "posts";
if(!isset($_SESSION["Username"])){
  header("Location: index.php"); // Back To Login Page
  exit();
}
include "init.php";  //  Include To init Routes File
$action = isset($_GET["action"]) ? $_GET["action"] : "Manage";
//  IF Sstatment To join [ Manage ] Page
if($action == "Manage"){
/***********************************************
******* START Manage Items Page **********
***********************************************/
        // Use in MYSQL join To Can Select User Name And Cartigory Name 
        $stmt = $conn->prepare("SELECT posts.*, categories.Name, users.UserName, users.Admin FROM `posts`
                                INNER JOIN categories ON categories.ID = posts.Cat_ID 
                                INNER JOIN users ON users.UserID = posts.User_ID
                                ORDER BY PostID DESC");
        $stmt->execute();
        $posts = $stmt->fetchAll();
?>

<div class="container mb-3">
  <h1 class="text-center">Manage Posts</h1>
  <a href="posts.php?action=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add Post</a>
  <input type='text' name='search' placeholder="Search By" id="searchByName" data-action="searchPost">
  <select id='searchBy'>
    <option value='PostID'> ID </option>
    <option value='Post_Title'> Title </option>
    <option value='Post_Description'> Description </option>
    <option value='UserName'> Owner </option>
    <option value='Name'> Category </option>
  </select> 
</div>

<div class="table-responsive">
<table class="custom-table table table-bordered text-center">
    <thead>
      <tr>
        <td>#ID</td>
        <td>Title</td>
        <td>Description</td>
        <td>Date</td>
        <td>Tags</td>
        <td>Owner</td>
        <td>Catigories</td>
        <td>Controls</td>
      </tr>
    </thead>
    <tbody>
      <?php 
        foreach ($posts as $post) {
            echo "<tr>";
                  echo "<td>" . $post["PostID"] . "</td>";
                  echo "<td>" . $post["Post_Title"] . "</td>";
                  echo "<td>" . $post["Post_Description"] . "</td>";
                  echo "<td>" . date('l j F Y', strtotime($post["Post_Date"])) . "</td>";
                  echo "<td>" . $post["Post_Tags"] . "</td>";
                  echo "<td>" . $post["UserName"] . "</td>";
                  echo "<td>" . $post["Name"] . "</td>";
                if($post['Admin'] == 1){
                  echo "<td><span class='alert alert-danger'>ADMIN</span></td>";
                }else{
                  echo "<td>";
                    echo "<a href='#' class='btn btn-danger del-comments' data-id='".$post['PostID']."' data-action='post' data-type='delete' ><i class='fa fa-close'></i> Delete</a>";
                    if($post["Post_Approve"] == 0){
                      echo "<a href='#' data-action='post' data-id='".$post["PostID"]."' data-type='approve' class='btn btn-info btn-sm del-dash'> <i class='fa fa-check'></i> Activate</a>";
                    } 
                  echo "</td>";
                }
          echo "</tr>";
        }
      ?>
    </tbody>
</table>
</div>
<?php if(empty($posts)){ echo "<p class='alert alert-danger text-center container'>No Videos To Display It !!</p>" ; } ?>
<?php
/***********************************************
  ******* End Manage Items Page **********
***********************************************/
//  End IF Sstatment To join [ Manage ] Page and Start To [ Add ] Page
/***********************************************
  ******* End Manage Items Page **********
***********************************************/
}elseif($action == "Add"){
echo "<div class='container'>"; // Start Container
/***********************************************
  ******* START Add Items Page **********
***********************************************/
?>
        <h1 class="text-center text-center">Create a New Post</h1>
<section  class="form mb-5"> <!-- Start Section Class [ Information ] -->
  <div class="card"> <!-- Start Card Bootstrap Class [ Card ] -->

          <div class="card-header bg-primary" style="color: #fff;"> <!-- Start Card-header Bootstrap Class [ Header ] -->
              <i class='fa fa-info-circle fa-fw'></i> New Post
          </div> <!-- End Card-header Bootstrap Class [ Header ] -->

      <div class="card-body"> <!-- Start Card-Body Bootstrap Class [ Body ] -->
<div class="row">  <!-- Start Div Bootstrap Class [ Row ] -->

  <div class="col-8"> <!-- Start Div Bootstrap Class [ Col-8  Left Section ] -->
  <form class="blog-create-post pl-4 pr-4 mt-3" action="?action=Insert" method="POST" enctype="multipart/form-data"> <!-- Start DIV [ Form ] -->

<!-- Start Tags Field -->
    <div class="form-group row text-center">
        <label class="pt-1 col-sm-3 text-md-right control-label">Title</label>
        <div class="col-sm-9">
            <input type="text" name="post-header" id="post-header" class="form-control" placeholder="Title">
        </div>
    </div>
<!-- End Tags Field -->

<!-- Start Categories Field -->
    <div class="form-group row text-center">
      <label class="pt-1 col-sm-3 text-md-right control-label">Category</label>
      <div class="col-sm-9">
          <select id="post-cat" name="post-cat" class="form-control">
              <?php
                  $stmt = $conn->prepare("SELECT * FROM categories");
                  $stmt->execute();
                  $cats = $stmt->fetchAll();
                  foreach ($cats as $cat) {
                      echo "<option value=" . $cat["ID"] . ">" . $cat["Name"] . "</option>";
                  }
              ?>
          </select>
      </div>
    </div>
<!-- End Categories Field -->

<!-- Start Tags Field -->
    <div class="form-group row text-center">
        <label class="pt-1 col-sm-3 text-md-right control-label">Tags</label>
        <div class="col-sm-9">
            <input type="text" name="post-tags" id="input-tags" class="form-control">
        </div>
    </div>
<!-- End Tags Field -->

<!-- Start Description Field -->
    <div class="form-group row text-center">
      <label class="pt-1 col-sm-3 text-md-right control-label">Description</label>
      <div class="col-sm-9">
        <textarea id="post-desc" name="post-desc" class="form-control" placeholder="Description"></textarea>
      </div>
    </div>
<!-- End Description Field -->

<div class="text-center"> <input type="submit" value="Post" class="btn btn-primary"> </div>

</form> <!-- Start DIV [ Form ] -->
  </div> <!-- End Div Bootstrap Class [ Col-8  Left Section ] -->

<div class="error offset-md-1 col-md-6 col-lg-5">
<?php
  if(!empty($errors)){
    foreach ($errors as $error) {
      echo "<h6 class='mt-1 mb-0'>" . $error . "</h6>";
    }
  }
  if(isset($msg)){
    echo "<h5 class='alert alert-success'>" . $msg . "</h5>";
    header("Refresh: .5; url=videos.php");
  }
?>
</div>
</div> <!-- End Div Class Bootstrap [ Row ] -->
      </div> <!-- End Card-Body Bootstrap Class [ Card-Body ] -->

  </div> <!-- End Card Bootstrap Class [ Card ] -->
</section> <!-- End Section Class [ Form Create ] -->
<?php
/***********************************************
  ******* End Add Items Page **********
***********************************************/
//  End IF Sstatment To join [ Add ] Page and Start To [ Insert ] Page
}elseif($action == "Insert"){
/***********************************************
  ******* Start Insert Items Page **********
***********************************************/
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    echo "<h1 class='text-center'>POST</h1>";
    $userid = $_SESSION["ID"]; 
    $header          = filter_var($_POST["post-header"] , FILTER_SANITIZE_STRING);
    $cat             = filter_var($_POST["post-cat"] , FILTER_SANITIZE_STRING);
    $tags            = filter_var($_POST["post-tags"] , FILTER_SANITIZE_STRING);
    $desc            = filter_var($_POST["post-desc"] , FILTER_SANITIZE_STRING);
    

    $errors = array();
    if(empty($header)){
      $errors[] = "Please Write Title To Your Post.";
    }
    if(empty($desc)){
      $errors[] = "Please Write anything To Description Your Post.";
    }

    if(empty($errors)){
      $stmt = $conn->prepare("INSERT INTO `posts`
            (`Post_Title`, `Post_Description`, `Post_Tags`, `Post_Date`, `User_ID`, `Cat_ID`, `Post_Approve`) VALUES (? , ? , ? , now() , ? , ? , 1)");
      $stmt->execute(array($header, $desc, $tags,$userid,$cat));
      $count = $stmt->rowCount();
      if($stmt){
        $msg = "The Post Has Created.";
      }
    }else{
      echo '<div class="error offset-md-3 col-md-6">';
      foreach ($errors as $error) {
        echo "<h6 class='mt-1 mb-0'>" . $error . "</h6>";
        header("Refresh: 3; url=posts.php?action=Add");
      }
    }
    if(isset($msg)){
      echo "<h5 class='alert alert-success'>" . $msg . "</h5>";
      header("Refresh: 2; url=posts.php");
    }
    echo '</div>';
  }else{
    reHome("This Page Not Found","danger","back" , 1);
  }
/***********************************************
******* End Insert Courses Page **********
***********************************************/

//  End IF Sstatment To join [ Insert ] Page and Start To [ Edit ] Page
}else{
  header("Location: index.php"); // Back To Login Page
  exit();
}
//  End IF Sstatment To join [ Else ]
echo "</div>";
include $tpl."footer.php";  //  Include To Header File