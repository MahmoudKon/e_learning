<?php
ob_start();
session_start();
$pageTitle = "VIDEOS";
$active = "videos";
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
        echo "<h1 class='text-center'>Manage Videos</h1>";
        // Use in MYSQL join To Can Select User Name And Cartigory Name 
        $stmt = $conn->prepare("SELECT video_list.*, categories.Name AS Category_Name, users.UserName, courses.Name AS Course_Name
                                FROM `video_list`
                                INNER JOIN categories ON categories.ID = video_list.Cat_ID 
                                INNER JOIN users ON users.UserID = video_list.User_ID
                                INNER JOIN courses ON courses.Course_ID = video_list.Course_ID
                                ORDER BY Video_ID DESC");
        $stmt->execute();
        $videos = $stmt->fetchAll();
?>

<a href="videos.php?action=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add Item</a>
<table class="custom-table table table-bordered text-center">
    <thead>
        <tr>
            <td>#ID</td>
            <td>Name</td>
            <td>Description</td>
            <td>Date</td>
            <td>Owner</td>
            <td>Course Name</td>
            <td>Catigories</td>
            <td>Controls</td>
        </tr>
    </thead>
<?php 
    foreach ($videos as $video) {
          echo "<tr>";
                echo "<td>" . $video["Video_ID"] . "</td>";
                echo "<td>" . $video["Video_Name"] . "</td>";
                echo "<td>" . $video["Video_Desc"] . "</td>";
                echo "<td>" . date('l j F Y', strtotime($video["Video_Date"])) . "</td>";
                echo "<td>" . $video["UserName"] . "</td>";
                echo "<td>" . $video["Course_Name"] . "</td>";
                echo "<td>" . $video["Category_Name"] . "</td>";
          echo "<td>";
            echo "<a href='#' class='btn btn-danger del-comments' data-id='".$video['Video_ID']."' data-action='video' data-type='delete' ><i class='fa fa-close'></i> Delete</a>";
          echo "</td>";
        echo "</tr>";
      }
?>
</table>
<?php if(empty($videos)){ echo "<p class='alert alert-danger text-center container'>No Videos To Display It !!</p>" ; } ?>
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
        <h1 class="text-center text-center">Add New Video</h1>
<section  class="form mb-5"> <!-- Start Section Class [ Information ] -->
  <div class="card"> <!-- Start Card Bootstrap Class [ Card ] -->

          <div class="card-header bg-primary" style="color: #fff;"> <!-- Start Card-header Bootstrap Class [ Header ] -->
              <i class='fa fa-info-circle fa-fw'></i> New Video
          </div> <!-- End Card-header Bootstrap Class [ Header ] -->

      <div class="card-body"> <!-- Start Card-Body Bootstrap Class [ Body ] -->
<div class="row">  <!-- Start Div Bootstrap Class [ Row ] -->

  <div class="col-8"> <!-- Start Div Bootstrap Class [ Col-8  Left Section ] -->
    <form class="form-horizontal text-center" action="?action=Insert" method="POST" enctype="multipart/form-data"> <!-- End Form -->

        <!-- Start Image Field -->
        <div class="form-group row text-center">
            <label class="pt-1 col-sm-2 text-md-center control-label">Video</label>
            <div class="col-sm-8">
                <!-- <input type="file" name="img" class="form-control img-upload" required="required" placeholder="Name of Course" data-class=".live-img"> -->
                

                <div class="upload-btn-wrapper form-control ">
                  <input type="file" name="src" id="Up-image" class="form-control img-upload" placeholder="Name of Course" data-class=".live-img" />
                  <label class="upload" for="Up-image">Upload Your Video</label>
                </div>


            </div>
        </div>
        <!-- End Image Field -->

        <!-- Start Name Field -->
        <div class="form-group row text-center">
            <label class="pt-1 col-sm-2 text-md-center control-label">Title</label>
            <div class="col-sm-8">
                <input type="text" name="name" class="form-control live" required="required" placeholder="Name of Course" data-class=".live-name">
            </div>
        </div>
        <!-- End Name Field -->

        <!-- Start Description Field -->
        <div class="form-group row text-center">
            <label class="pt-1 col-sm-2 text-md-center text-md-right control-label">Description</label>
            <div class="col-sm-8">
                <input type="text" name="description" class="form-control live" required="required" placeholder="Description of Course" data-class=".live-desc">
            </div>
        </div>
        <!-- End Description Field -->

        <!-- Start Categories Field -->
        <div class="form-group row text-center">
            <label class="pt-1 col-sm-2 text-md-right control-label">Category</label>
            <div class="col-sm-8">
                <select name="category" class="form-control">
                    <option value="0">Select Categories</option>
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

        <!-- Start Course List Field -->
        <div class="form-group row text-center">
            <label class="pt-1 col-sm-2 text-md-right control-label">Course List</label>
            <div class="col-sm-8">
                <select name="course" class="form-control">
                    <option value="0">Course List</option>
                    <?php
                        $stmt = $conn->prepare("SELECT * FROM `courses` WHERE User_ID = ?");
                        $stmt->execute(array($_SESSION["ID"]));
                        $courses = $stmt->fetchAll();
                        foreach ($courses as $course) {
                            echo "<option value=" . $course["Course_ID"] . ">" . $course["Name"] . "</option>";
                        }
                    ?>
                </select>
            </div>
        </div>
        <!-- End Course List Field -->

        <!-- Start Submit Field -->
        <div class="form-group col-12 mt-4">
            <div class="m-auto">
                <input type="submit" value="Add Item" class="btn btn-lg btn-primary">
            </div>
        </div>
        <!-- End Submit Field -->

    </form> <!-- End Form -->
  </div> <!-- End Div Bootstrap Class [ Col-8  Left Section ] -->


  <div class="col-4"> <!-- Start Div Bootstrap Class [ Col-4  Right Section ] -->
  
                    <div class="card"> <!--  Start card DIV  -->
                      <div class="card-price-img">
                          <video class="card-img-top live-img" width="100%">
                              <source src="">
                          </video>
                      </div>

                      <div class="card-block live-preview"> <!--  Start card-block DIV  -->
                          <h4 class="card-title live-name"> [ Video Title ] </h4>
                          <h5 class="card-title"> Mr. [ <?php echo $_SESSION["Username"]; ?> ] </h5>
                          <div class="card-text">
                              <h5 class="desc"> Description:</h5>
                              <p class="live-desc"> [ Some Text ] </p>
                          </div>
                          
                      </div> <!--  End card-block DIV  -->

                    </div> <!--  End card DIV  -->
  </div> <!-- End Div Bootstrap Class [ Col-4  Right Section ] -->

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
    echo "<h1 class='text-center'>Insert Item</h1>";
    $name        = filter_var($_POST["name"] , FILTER_SANITIZE_STRING);
    $description = filter_var($_POST["description"] , FILTER_SANITIZE_STRING);
    $category    = $_POST["category"];
    $course      = $_POST["course"];

    $av_name     = $_FILES["src"]['name'];
    $avtmp       = $_FILES["src"]['tmp_name'];
    $avtype      = $_FILES["src"]['type'];
   move_uploaded_file($avtmp, "files/videos/". $av_name);
   copy("files/videos/". $av_name, '../files/videos/'. $av_name);
   if(!copy("files/videos/". $av_name, '../files/videos/'. $av_name)){
    $errors[] = "The Video Can't Be Load.";
   }
   $src = empty($av_name) ? "" : "files/videos/". $av_name;

    $errors = array();
    if(strlen($name) < 4 || strlen($name) > 15){
      $errors[] = "The Name Muse Be Between 4 & 15 Chars.";
    }
    if($category == 0){
      $errors[] = "Please Choose The Category.";
    }
    if($course == 0){
      $errors[] = "Please Choose The Course List.";
    }

    if(empty($errors)){
      $stmt = $conn->prepare("INSERT INTO `video_list`(`Video_Name`, `Video_Src`, `Video_Desc`, `Video_Date`, `User_ID`,                         `Course_ID`, `Cat_ID`) VALUES (?,?,?,now(),?,?,?)");
      $stmt->execute(array($name, $src, $description, $_SESSION["ID"], $course, $category));
      if($stmt){
        $msg = "Ad Content Created Successfully";
      }
    }else{
      echo '<div class="error offset-md-3 col-md-6">';
      foreach ($errors as $error) {
        echo "<h6 class='mt-1 mb-0'>" . $error . "</h6>";
        header("Refresh: 20; url=videos.php?action=Add");
      }
    }
    if(isset($msg)){
      echo "<h5 class='alert alert-success'>" . $msg . "</h5>";
      header("Refresh: 100; url=videos.php");
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