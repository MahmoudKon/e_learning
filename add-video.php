<?php
ob_start();
// Start Session
session_start();
$title = "Create New Course";
$active = "";
$limitCourses = 6;
include "inhi.php";
if(isset($_SESSION["user"])){

    if($_SERVER["REQUEST_METHOD"] == "POST"){

      $name     = filter_var($_POST["video-name"] , FILTER_SANITIZE_STRING);
      $desc     = filter_var($_POST["video-desc"] , FILTER_SANITIZE_STRING);
      $category = $_POST["category"];
      $course   = $_POST["course"];

      $av_name     = $_FILES["video-src"]['name'];
      $avtmp       = $_FILES["video-src"]['tmp_name'];
      $avtype      = $_FILES["video-src"]['type'];
   
     move_uploaded_file( $avtmp, "files/videos/". $av_name );
     copy('files/videos/'. $av_name, 'admin/files/videos/'. $av_name);
     $src = empty($av_name) ? "" : "files/videos/". $av_name;

      $errors = array();
      if(empty($src)){
        $errors[] = "You Must Select a Video.";
      }
      if(strlen($name) < 4 || strlen($name) > 20){
        $errors[] = "The Title Must Be Between 4 & 20 Chars.";
      }
      if(strlen($desc) > 40){
        $errors[] = "The Description Must Be Less Than 40 Chars.";
      }
      if($category == 0){
        $errors[] = "Please Choose The Category.";
      }
      if($course == 0){
         $errors[] = "Please Choose The Course.";
      }

      if(empty($errors)){
        $stmt = $conn->prepare("INSERT INTO `video_list`(`Video_Name`, `Video_Src`, `Video_Desc`, `Video_Date`,                                                                         `User_ID`, `Course_ID`, `Cat_ID`)
                                             VALUES (?, ?, ?, now(), ?, ?, ?)");
        $stmt->execute(array($name, $src, $desc, $sessionUserID, $course, $category));
        if($stmt){
          $msg = "Ad Content Created Successfully";
        }
      }
      
    }
?>

<!--
=======================
Start Section Back Link
======================= 
-->
<div class="home">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="breadcrumbs">
						<ul>
							<li><a href="index.php">Home </a></li>
							<li><a href="newCourse.php"><i class="fa fa-chevron-right fa-fw"></i> Create Course</a></li>
							<li><i class="fa fa-chevron-right fa-fw"></i> Add Videos</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
</div>
<!--
=======================
Start Section Back Link
======================= 
-->

<!-- Start Header Page -->
<h1 class="headerTitle text-center" style="font-size: 30px;">Add New Video</h1>
<div class="container"> <!-- Start Container Bootstrap Class [ Container ] -->
<!-- 
=====================================================================================================================================
                                               Start Information Section
=====================================================================================================================================
 -->
<section  class="form mb-5"> <!-- Start Section Class [ Information ] -->
  <div class="card"> <!-- Start Card Bootstrap Class [ Card ] -->

          <div class="card-header bg-primary" style="color: #fff;"> <!-- Start Card-header Bootstrap Class [ Header ] -->
              <i class='fa fa-info-circle fa-fw'></i> Add New Video
          </div> <!-- End Card-header Bootstrap Class [ Header ] -->

      <div class="card-body"> <!-- Start Card-Body Bootstrap Class [ Body ] -->
<div class="row">  <!-- Start Div Bootstrap Class [ Row ] -->
<!-- 
=====================================================================================================================================
                                                    Start Section Create Course [ Form Left ]
=====================================================================================================================================
-->
  <div class="col-8"> <!-- Start Div Bootstrap Class [ Col-8  Left Section ] -->
    <form class="form-horizontal text-center" action="?action=Insert" method="POST" enctype="multipart/form-data"> <!-- End Form -->

        <!-- Start Image Field -->
        <div class="form-group row text-center">
            <label class="pt-1 col-sm-2 text-md-center control-label">Video</label>
            <div class="col-sm-8">
                <div class="upload-btn-wrapper form-control ">
                  <input type="file" name="video-src" id="Up-image" class="form-control img-upload" placeholder="Name of Course" data-class=".live-img" />
                  <label class="upload" for="Up-image">Upload Your Video</label>
                </div>
            </div>
        </div>
        <!-- End Image Field -->

        <!-- Start Name Field -->
        <div class="form-group row text-center">
            <label class="pt-1 col-sm-2 text-md-center control-label">Title</label>
            <div class="col-sm-8">
                <input type="text" name="video-name" class="form-control live" required="required" placeholder="Name of Course" data-class=".live-title">
            </div>
        </div>
        <!-- End Name Field -->

        <!-- Start Description Field -->
        <div class="form-group row text-center">
            <label class="pt-1 col-sm-2 text-md-center text-md-right control-label">Description</label>
            <div class="col-sm-8">
                <input type="text" name="video-desc" class="form-control live" required="required" placeholder="Description of Course" data-class=".live-desc">
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

                <!-- Start Categories Field -->
         <div class="form-group row text-center">
            <label class="pt-1 col-sm-2 text-md-right control-label">Course List</label>
            <div class="col-sm-8">
                <select name="course" class="form-control">
                    <option value="0">Select Course List</option>
                    <?php
                        $stmt = $conn->prepare("SELECT * FROM `courses` WHERE User_ID = ?");
                        $stmt->execute(array($_SESSION["uID"]));
                        $courses = $stmt->fetchAll();
                        foreach ($courses as $course) {
                            echo "<option value=" . $course["Course_ID"] . ">" . $course["Name"] . "</option>";
                        }
                    ?>
                </select>
            </div>
         </div>
        <!-- End Categories Field -->

        <!-- Start Submit Field -->
        <div class="form-group col-12 mt-4">
            <div class="m-auto">
                <input type="submit" value="Add Video" class="btn btn-lg btn-primary">
            </div>
        </div>
        <!-- End Submit Field -->

    </form> <!-- End Form -->
  </div> <!-- End Div Bootstrap Class [ Col-8  Left Section ] -->
  <!-- 
=====================================================================================================================================
                                                    End Section Form Create [ Left Section ]
=====================================================================================================================================
-->

<!-- 
=====================================================================================================================================
                                                    Start Section Live View [ Right Section ]
=====================================================================================================================================
-->

  <div class="col-4"> <!-- Start Div Bootstrap Class [ Col-4  Right Section ] -->
  
                    <div class="card"> <!--  Start card DIV  -->
                      <div class="card-price-img">
                          <video class="card-img-top live-img">
                              <source src="" type="video/mp4">
                              Your browser does not support the video tag.
                           </video> 
                      </div>

                      <div class="card-block live-preview"> <!--  Start card-block DIV  -->
                          <h4 class="card-title live-title"> [ Title ] </h4>
                          <h5 class="card-title"> Mr. [ <?php echo $sessionUser; ?> ] </h5>
                          <div class="card-text">
                              <h5 class="desc"> Description:</h5>
                              <p class="live-desc"> [ Some Text ] </p>
                          </div>
                          
                      </div> <!--  End card-block DIV  -->

                    </div> <!--  End card DIV  -->
  </div> <!-- End Div Bootstrap Class [ Col-4  Right Section ] -->
<!-- 
=====================================================================================================================================
                                                    End Section Live View [ Right Section ]
=====================================================================================================================================
-->
<div class="error offset-md-1 col-md-6 col-lg-5">
<?php
  if(!empty($errors)){
    foreach ($errors as $error) {
      echo "<h6 class='mt-1 mb-0'>" . $error . "</h6>";
    }
  }
  if(isset($msg)){
    echo "<h5 class='alert alert-success'>" . $msg . "</h5>";
  }
?>
</div>
</div> <!-- End Div Class Bootstrap [ Row ] -->
      </div> <!-- End Card-Body Bootstrap Class [ Card-Body ] -->

  </div> <!-- End Card Bootstrap Class [ Card ] -->
</section> <!-- End Section Class [ Form Create ] -->
<!-- 
=====================================================================================================================================
                                                    End Form [ Left ] Section
=====================================================================================================================================
-->
</div> <!-- End Container Bootstrap Class [ Container ] -->

<?php
}else{ header("Location: login.php");  exit(); }
include "template/footer.php";
ob_end_flush();
?>