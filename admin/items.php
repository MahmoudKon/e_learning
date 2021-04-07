<?php
ob_start();
session_start();
$pageTitle = "ITEMS";
$active = "items";
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
$stmt = $conn->prepare("SELECT courses.*, categories.Name AS Category_Name, users.UserName FROM `courses`
                        INNER JOIN categories ON categories.ID = courses.Categories_ID 
                        INNER JOIN users ON users.UserID = courses.User_ID
                        ORDER BY Course_ID DESC");
$stmt->execute();
$courses = $stmt->fetchAll();


?>

<div class="container mb-3">
  <h1 class="text-center">Manage Items</h1>
  <a href="items.php?action=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add Item</a>
  <input type='text' name='search' placeholder="Search By" id="searchByName" data-action="searchItem">
  <select id='searchBy'>
    <option value='Course_ID'> ID </option>
    <option value='Course_Describe'> Description </option>
    <option value='UserName'> Owner </option>
  </select> 
</div>

<div class="table-responsive">
<table class="custom-table table table-bordered text-center">
    <thead>
      <tr>
              <td>#ID</td>
              <td>Name</td>
              <td>Description</td>
              <td>Price</td>
              <td>Adding Date</td>
              <td>Country</td>
              <td>Status</td>
              <td>Owner</td>
              <td>Catigories</td>
              <td>Controls</td>
        </tr>
    </thead>
    <tbody>
<?php 
    foreach ($courses as $course) {
      $price = $course["Price"] == 0 || $course["Price"] == "free" ? "Free" : "$".$course["Price"];
          echo "<tr>";
                echo "<td>" . $course["Course_ID"] . "</td>";
                echo "<td>" . $course["Name"] . "</td>";
                echo "<td>" . $course["Course_Describe"] . "</td>";
                echo "<td>" . $price . "</td>";
                echo "<td>" . date('l j F Y', strtotime($course["Add-Date"])) . "</td>";
                echo "<td>" . $course["Country"] . "</td>";
                echo "<td>" . $course["Status"] . "</td>";
                echo "<td>" . $course["UserName"] . "</td>";
                echo "<td>" . $course["Category_Name"] . "</td>";
          echo "<td>";
            echo "<a href='items.php?action=Edit&courseid=" . $course['Course_ID'] ."&name=" . $course['Name'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>";

            echo "<a href='' data-type='delete' data-action='item' data-id='". $course['Course_ID'] . "' class='btn btn-danger del-comments ml-2 mr-2'><i class='fa fa-close'></i> Delete</a>";

            if($course["Approve"] == 0){
              echo "<a href='' data-type='approve' data-action='item' data-id='". $course['Course_ID'] . "' class='btn btn-info del-comments'><i class='fa fa-check'></i> Approve</a>";
            }
          echo "</td>";
        echo "</tr>";
      }
?>
      </tbody>
</table>
</div>
<?php if(empty($courses)){ echo "<p class='alert alert-danger text-center container'>No Courses To View It !!</p>" ; } ?>
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
        <h1 class="text-center text-center">Add New Item</h1>
<section  class="form mb-5"> <!-- Start Section Class [ Information ] -->
  <div class="card"> <!-- Start Card Bootstrap Class [ Card ] -->

          <div class="card-header bg-primary" style="color: #fff;"> <!-- Start Card-header Bootstrap Class [ Header ] -->
              <i class='fa fa-info-circle fa-fw'></i> Create New Course
          </div> <!-- End Card-header Bootstrap Class [ Header ] -->

      <div class="card-body"> <!-- Start Card-Body Bootstrap Class [ Body ] -->
<div class="row">  <!-- Start Div Bootstrap Class [ Row ] -->

  <div class="col-8"> <!-- Start Div Bootstrap Class [ Col-8  Left Section ] -->
    <form class="form-horizontal text-center" action="?action=Insert" method="POST" enctype="multipart/form-data"> <!-- End Form -->

        <!-- Start Image Field -->
        <div class="form-group row text-center">
            <label class="pt-1 col-sm-2 text-md-center control-label">Image</label>
            <div class="col-sm-8">
                <!-- <input type="file" name="img" class="form-control img-upload" required="required" placeholder="Name of Course" data-class=".live-img"> -->
                

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

        <!-- Start Categories Field -->
        <div class="form-group row text-center">
            <label class="pt-1 col-sm-2 text-md-right control-label">Tags</label>
            <div class="col-sm-8">
                <input type="text" name="tags" id="input-tags" class="form-control live" data-class=".live-tags">
            </div>
        </div>
        <!-- End Categories Field -->

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
                          <img class="card-img-top live-img" src="images/uploadImage.PNG" alt="Card image cap">
                          <div class="price" style="transform: scale(1,1);">$
                                <span class="live-price"> [Price]</span>
                          </div>
                      </div>

                      <div class="card-block live-preview"> <!--  Start card-block DIV  -->
                          <h4 class="card-title live-name"> [ Course Name ] </h4>
                          <h5 class="card-title"> Mr. [ <?php echo $_SESSION["Username"]; ?> ] </h5>
                          <div class="card-text">
                              <h5 class="desc"> Description:</h5>
                              <p class="live-desc"> [ Some Text ] </p>
                              <p class="live-tags"> [ Some Tags ] </p>
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
    header("Refresh: .5; url=add-video.php");
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
    $price       = filter_var($_POST["price"] , FILTER_SANITIZE_NUMBER_INT);
    $country     = filter_var($_POST["country"] , FILTER_SANITIZE_STRING);
    $status      = filter_var($_POST["status"] , FILTER_SANITIZE_STRING);
    $category    = filter_var($_POST["category"] , FILTER_SANITIZE_STRING);
    $tags        = $_POST["tags"];

    $av_name     = $_FILES["img"]['name'];
    $avtmp       = $_FILES["img"]['tmp_name'];
    $avtype      = $_FILES["img"]['type'];
 
   move_uploaded_file( $avtmp, "files/images-items/". $av_name );
   copy('files/images-items/'. $av_name, '../files/images-items/'. $av_name);
   $img = empty($av_name) ? "" : "files/images-items/". $av_name;

    $errors = array();
    if(strlen($name) < 4 || strlen($name) > 15){
      $errors[] = "The Name Muse Be Between 4 & 15 Chars.";
    }
    if(strlen($description) < 4 || strlen($description) > 40){
      $errors[] = "The Description Muse Be Between 4 & 25 Chars.";
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
      $stmt = $conn->prepare("INSERT INTO `courses`(`Name`, `Course_Describe`, Tags, `Price`,`Add-Date`, `Status`, `Categories_ID`,                              `User_ID`, `Country`, Img, `Approve`) VALUES (?,?,?,?,now(),?,?,?,?,?,1)");
      $stmt->execute(array($name, $description, $tags, $price, $status, $category, $_SESSION["ID"], $country, $img));
      if($stmt){
        $msg = "Ad Content Created Successfully";
      }
    }else{
      echo '<div class="error offset-md-3 col-md-6">';
      foreach ($errors as $error) {
        echo "<h6 class='mt-1 mb-0'>" . $error . "</h6>";
        header("Refresh: 1.5; url=items.php?action=Add");
      }
    }
    if(isset($msg)){
      echo "<h5 class='alert alert-success'>" . $msg . "</h5>";
      header("Refresh: 1.5; url=items.php");
    }
    echo '</div>';
  }else{
    reHome("This Page Not Found","danger","back" , 1);
  }
/***********************************************
******* End Insert Courses Page **********
***********************************************/

//  End IF Sstatment To join [ Insert ] Page and Start To [ Edit ] Page
}elseif($action == "Edit"){
/***********************************************
    ******* Start Edit Courses Page **********
***********************************************/
  $courseid = isset($_GET["courseid"]) && is_numeric($_GET["courseid"]) ? intval($_GET["courseid"]) : 0;
  $stmt = $conn->prepare("SELECT * FROM `courses` WHERE `Course_ID` = ?");
  $stmt->execute(array($courseid));
  $course = $stmt->fetch();
  $count = $stmt->rowCount();
  if($count > 0){  
?>

<h1 class="text-center text-center">Edit To <?php echo "[ " . $course["Name"] . " ]"; ?></h1>
<form class="form-horizontal text-center overflow-hidden pt-1" action="?action=Update " method="POST">

  <!-- Start course ID Filed -->
  <input type="hidden" name="id" value="<?php echo $course['Course_ID']; ?>">
  <!-- End course ID Filed -->

    <!-- Start Name Field -->
    <div class="form-group row text-center">
      <label class="pt-2 col-sm-12 offset-md-2 col-md-3 offset-lg-1 text-md-right control-label">Name</label>
      <div class="col-sm-12 col-md-6 col-lg-5">
          <input type="text" name="name" class="form-control"  placeholder="Name of Item" value = "<?php echo $course["Name"];?>">
      </div>
    </div>
    <!-- End Name Field -->

    <!-- Start Description Field -->
    <div class="form-group row text-center">
      <label class="pt-2 col-sm-12 offset-md-2 col-md-3 offset-lg-1 text-md-right control-label">Description</label>
      <div class="col-sm-12 col-md-6 col-lg-5">
          <input type="text" name="description" class="form-control" required="required" placeholder="Description of Course" value = "<?php echo $course["Course_Describe"];?>">
      </div>
    </div>
    <!-- End Description Field -->

    <!-- Start Price Field -->
    <div class="form-group row text-center">
      <label class="pt-2 col-sm-12 offset-md-2 col-md-3 offset-lg-1 text-md-right control-label">Price</label>
      <div class="col-sm-12 col-md-6 col-lg-5">
          <input type="text" name="price" class="form-control" required="required" placeholder="Price of Course" value = "<?php echo $course["Price"];?>">
      </div>
    </div>
    <!-- End Price Field -->

    <!-- Start Country Field -->
    <div class="form-group row text-center">
      <label class="pt-2 col-sm-12 offset-md-2 col-md-3 offset-lg-1 text-md-right control-label">Country</label>
      <div class="col-sm-12 col-md-6 col-lg-5">
          <input type="text" name="country" class="form-control" required="required" placeholder="Country of Course" value = "<?php echo $course["Country"];?>">
      </div>
    </div>
    <!-- End Country Field -->

    <!-- Start Status Field -->
    <div class="form-group row text-center">
      <label class="pt-2 col-sm-12 offset-md-2 col-md-3 offset-lg-1 text-md-right control-label">Status</label>
      <div class="col-sm-12 col-md-6 col-lg-5">
          <select name="status" class="form-control"  value = "<?php echo $course["Status"];?>">
              <option value="Finished" <?php if($course["Status"] == "Finished"){ echo "selected"; }?>>Finished</option>
              <option value="Continuous" <?php if($course["Status"] == "Continuous"){ echo "selected"; }?>>Continuous</option>
          </select>
      </div>
    </div>
    <!-- End Status Field -->

    <!-- Start Members Field -->
    <div class="form-group row text-center">
      <label class="pt-2 col-sm-12 offset-md-2 col-md-3 offset-lg-1 text-md-right control-label">Members</label>
      <div class="col-sm-12 col-md-6 col-lg-5">
          <select name="member" class="form-control">
              <option value="0">Select User</option>
              <?php
                  $stmt = $conn->prepare("SELECT * FROM users");
                  $stmt->execute();
                  $users = $stmt->fetchAll();
                  foreach ($users as $user) {
                        echo "<option value='" . $user["UserID"] . "'";
                              if($course["User_ID"] == $user["UserID"]){ echo "selected"; }
                              echo ">" . $user["UserName"] ; 
                        echo "</option>";
                  }
                  
              ?>
          </select>
      </div>
    </div>
    <!-- End Members Field -->

    <!-- Start Categories Field -->
    <div class="form-group row text-center">
      <label class="pt-2 col-sm-12 offset-md-2 col-md-3 offset-lg-1 text-md-right control-label">Category</label>
      <div class="col-sm-12 col-md-6 col-lg-5">
          <select name="category" class="form-control">
              <option value="0">Select Categories</option>
              <?php
                  $stmt = $conn->prepare("SELECT * FROM categories");
                  $stmt->execute();
                  $cats = $stmt->fetchAll();
                  foreach ($cats as $cat) {
                        echo "<option value='" . $cat["ID"] . "'";
                              if($course["Categories_ID"] == $cat["ID"]){ echo "selected"; }
                              echo ">" . $cat["Name"]; 
                        echo "</option>";
                  }
                  
              ?>
          </select>
      </div>
    </div>
    <!-- End Categories Field -->

          <!-- Start Tags Field -->
          <div class="form-group row text-center">
            <label class="pt-2 col-sm-12 offset-md-2 col-md-3 offset-lg-1 text-md-right control-label">Tags</label>
            <div class="col-sm-12 col-md-6 col-lg-5">
            <?php
                  $stmt = $conn->prepare("SELECT Tags FROM courses WHERE Course_ID = ?");
                  $stmt->execute(array($courseid));
                  $tags = $stmt->fetch();
              ?>
              <input type="text" value="<?php echo $tags['Tags']; ?>" name="tags" id="input-tags" class="form-control">
            </div>
          </div>
          <!-- End Tags Field -->

    <!-- Start Submit Field -->
    <div class="form-group row">
      <div class="m-auto">
      <input type="submit" value="Save" class="btn btn-lg btn-primary">
      </div>
    </div>
    <!-- End Submit Field -->
</form>

<!--
  ==============================
   End Manage Comments Item's
  ==============================
-->

<?php 
  }
/***********************************************
******* End Edit Items Page **********
***********************************************/
//  End IF Sstatment To join [ Edit ] Page and Start To [ Update ] Page
}elseif($action == "Update"){
/***********************************************
  ******* End Update Items Page **********
***********************************************/

      if($_SERVER["REQUEST_METHOD"] == "POST"){
        echo "<h1 class='text-center'>Update Item [ " . $_POST["name"] . " ]</h1>";
        $id           = $_POST["id"];
        $name         = $_POST["name"];
        $description  = $_POST["description"];
        $price        = $_POST["price"];
        $country      = $_POST["country"];
        $status       = $_POST["status"];
        $member       = $_POST["member"];
        $category     = $_POST["category"];
        $tags     = $_POST["tags"];
        $formErrors   = array(); // Save Errors From Form In It

        if(empty($name)){
          $formErrors[] = "User Name Filed Can't Be Empty";
        }
        if(empty($price)){
          $formErrors[] = "Must Be But a Price";
        }
        if(empty($country)){
          $formErrors[] = "Must Be But Your Country";
        } 
        if(empty($status)){
          $formErrors[] = "Select The Status";
        }
        if($member == 0){
          $formErrors[] = "Must Select The Owner";
        }
        if($category == 0){
          $formErrors[] = "Must Select The Category";
        }

        // Loop Into Error Array And Echo It
        foreach($formErrors as $error){
          echo "<div class='alert alert-danger'>" . $error . "</div>";
        }
        // Check If Var Have Errors Or Not
        if(empty($formErrors)){
        //Update The Database With This INFO
          $stmt  = $conn->prepare("UPDATE `courses` SET `Name` = ?, `Course_Describe` = ?, `Price` = ? , `Tags` = ?, `Country` = ? ,
                                                    `Status` = ? , `Categories_ID` = ? , `User_ID` = ? WHERE Course_ID = ?");
          $stmt->execute(array($name, $description, $price, $tags, $country, $status, $category, $member, $id));
          $count = $stmt->rowCount();
          // echo Success Message
          $msg = $count . " Statments Updated";
          reHome($msg,"success","back",2);
        }else{
                
        }

      }else{
      $msg = "Sorry You Can't Come In This Link Directry";
      reHome($msg,"danger","back",2);
      }

//  End IF Sstatment To join [ Delete ] Page and Start To [ Approve ] Page
}elseif($action == "Approve"){
/***********************************************
  ******* End Approve Items Page **********
***********************************************/
echo "<h1 class='text-center'>Approve Courses</h1>";
      $courseid = isset($_GET["courseid"]) && is_numeric($_GET["courseid"]) ? intval($_GET["courseid"]) : 0;
      $check = checkItem("Course_ID","courses",$courseid);
      if($check > 0){  
        $stmt = $conn->prepare("UPDATE courses SET Approve = 1 WHERE Course_ID = ?");
        $stmt->execute(array($courseid));
        $count = $stmt->rowCount();
        if($count > 0){
          $msg = $count . " Statments Updated</div>";
          reHome($msg,"success","back",2);
        }else{
          $msg = "Sorry You Can't Delete This User";
          reHome($msg,"danger","back",2);
        }
      }else{
        $msg = "This ID IS Not Exist";
        reHome($msg,"danger","back",2);
      }
/***********************************************
  ******* End Approve Items Page **********
***********************************************/
//  End IF Sstatment To join [ Approve ] Page and Start To [ else ] Page
}elseif($action == "Approve"){
  header("Location: index.php"); // Back To Login Page
  exit();
  }
//  End IF Sstatment To join [ Else ]
echo "</div>";
include $tpl."footer.php";  //  Include To Header File