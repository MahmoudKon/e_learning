<?php
use phpDocumentor\Reflection\Location;

ob_start();
// Start Session
session_start();
$title = "Create New Course";
$active = "";
$limitCourses = 6;
include "inhi.php";
if(isset($_SESSION["user"])){
  $stmt = $conn->prepare("SELECT * FROM users WHERE UserID = ?");
  $stmt->execute(array($sessionUserID));
  $result = $stmt->fetch();

    if($_SERVER["REQUEST_METHOD"] == "POST"){

      $name        = filter_var($_POST["name"] , FILTER_SANITIZE_STRING);
      $description = filter_var($_POST["description"] , FILTER_SANITIZE_STRING);
      $price       = filter_var($_POST["price"] , FILTER_SANITIZE_NUMBER_INT);
      $country     = filter_var($_POST["country"] , FILTER_SANITIZE_STRING);
      $status      = filter_var($_POST["status"] , FILTER_SANITIZE_STRING);
      $category    = filter_var($_POST["category"] , FILTER_SANITIZE_STRING);
      $tags        = $_POST["tags"];
      $approve = $result['Admin'] == 1 ? 1 : 0;
        
      $av_name     = $_FILES["img"]['name'];
      $avtmp       = $_FILES["img"]['tmp_name'];
      $avtype      = $_FILES["img"]['type'];
  
    move_uploaded_file( $avtmp, "files/images-items/". $av_name );
    copy('files/images-items/'. $av_name, 'admin/files/images-items/'. $av_name);
    $img = empty($av_name) ? "" : "files/images-items/". $av_name;

      $errors = array();
      if(strlen($name) < 4 || strlen($name) > 15){
        $errors[] = "The Name Muse Be Between 4 & 15 Chars.";
      }
      if(strlen($description) < 4){
        $errors[] = "The Description Muse Be More Than 4 Chars.";
      }
      if(strlen($price) > 5){
        $errors[] = "The Price IS Very Expensive.";
      }
      if(strlen($country) < 2 || strlen($country) > 15){
        $errors[] = "Type Your Country Name Correctly.";
      }
      if(empty($status)){
        $errors[] = "Please Choose The Status Of Course.";
      }
      if(empty($category)){
        $errors[] = "Please Choose The Category.";
      }
      if(empty($img)){
        $errors[] = "files/images-items/default_Item.png";
      }

      if(empty($errors)){
        $stmt = $conn->prepare("INSERT INTO `courses`(`Name`, `Course_Describe`, Tags, `Price`,`Add-Date`, `Status`, `Categories_ID`,                              `User_ID`, `Country`, Img, Approve) VALUES (?,?,?,?,now(),?,?,?,?,?,?)");
        $stmt->execute(array($name, $description, $tags, $price, $status, $category, $sessionUserID, $country, $img,$approve));
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
							<li><i class="fa fa-chevron-right fa-fw"></i> Create Courses</li>
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
<h1 class="headerTitle text-center" style="font-size: 30px;">Create New Course</h1>
<div class="container"> <!-- Start Container Bootstrap Class [ Container ] -->
<!-- 
=====================================================================================================================================
                                               Start Information Section
=====================================================================================================================================
 -->
<section  class="form mb-5"> <!-- Start Section Class [ Information ] -->
  <div class="card"> <!-- Start Card Bootstrap Class [ Card ] -->

          <div class="card-header bg-primary" style="color: #fff;"> <!-- Start Card-header Bootstrap Class [ Header ] -->
              <i class='fa fa-info-circle fa-fw'></i> Create New Course
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
            <label class="pt-1 col-sm-2 text-md-center control-label">Image</label>
            <div class="col-sm-8">
                <div class="upload-btn-wrapper form-control ">
                  <input type="file" name="img" id="Up-image" class="form-control img-upload" placeholder="Name of Course" data-class=".live-img" />
                  <label class="upload" for="Up-image">Upload Your Image</label>
                </div>
            </div>
        </div>
        <!-- End Image Field -->

        <!-- Start Name Field -->
        <div class="form-group row text-center">
            <label class="pt-1 col-sm-2 text-md-center control-label">Name</label>
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

        <!-- Start Price Field -->
        <div class="form-group row text-center">
            <label class="pt-1 col-sm-2 text-md-center control-label">Price</label>
            <div class="col-sm-8">
                <input type="text" name="price" class="form-control live" required="required" placeholder="IF The Field IS Empty The Price Will Be Free" data-class=".live-price">
            </div>
        </div>
        <!-- End Price Field -->

        <!-- Start Country Field -->
        <div class="form-group row text-center">
            <label class="pt-1 col-sm-2 text-md-center control-label">Country</label>
            <div class="col-sm-8">
                <input type="text" name="country" class="form-control" required="required" placeholder="Country of Item">
            </div>
        </div>
        <!-- End Country Field -->

        <!-- Start Status Field -->
        <div class="form-group row text-center">
            <label class="pt-1 col-sm-2 text-md-center control-label">Status</label>
            <div class="col-sm-8">
                <select name="status" class="form-control live" data-class="live-status">
                    <option value="Finished">Finished</option>
                    <option value="Continuous">Continuous</option>
                </select>
            </div>
        </div>
        <!-- End Status Field -->

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

        <!-- Start Tags Field -->
        <div class="form-group row text-center">
            <label class="pt-1 col-sm-2 text-md-right control-label">Tags</label>
            <div class="col-sm-8">
                <input type="text" name="tags" id="input-tags" class="form-control live" data-class=".live-tags">
            </div>
        </div>
        <!-- End Tags Field -->

        <!-- Start Submit Field -->
        <div class="form-group col-12 mt-4">
            <div class="m-auto">
                <input type="submit" value="Add Item" class="btn btn-lg btn-primary">
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
                          <img class="card-img-top live-img" src="images/uploadImage.PNG" alt="Card image cap">
                          <div class="price" style="transform: scale(1,1);">$
                                <span class="live-price"> [Price]</span>
                          </div>
                      </div>

                      <div class="card-block live-preview"> <!--  Start card-block DIV  -->
                          <h4 class="card-title live-name"> [ Course Name ] </h4>
                          <h5 class="card-title"> Mr. [ <?php echo $sessionUser; ?> ] </h5>
                          <div class="card-text">
                              <h5 class="desc"> Description:</h5>
                              <p class="live-desc"> [ Some Text ] </p>
                              <p class="live-tags"> [ Some Tags ] </p>
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
    header("Refresh: .5; url=add-video.php");
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