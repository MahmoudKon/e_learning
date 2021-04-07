<?php
ob_start();
// Start Session
session_start();
$title = "Profile";
$active = "";
include "inhi.php";
// Start IF Else Statment To Check IF This User Have Session OR Not
if(isset($_SESSION["user"])){
  $stmt = $conn->prepare("SELECT * FROM users WHERE UserID = ?");
  $stmt->execute(array($sessionUserID));
  $userInfo = $stmt->fetch();
?>
<!-- 
=====================================================================================================================================
                                             Header Page
=====================================================================================================================================
 -->

<section  class="Courses" id="courses" style="border-top: 1px solid #f0f0f0;"> <!-- Start Section Class [ Courses ] -->
<div class="container"> <!-- Start Container Bootstrap Class [ Container ] -->
<h1 class="headerTitle  text-center">Edit Information</h1>
  <div class="card mb-4"> <!-- Start Card Bootstrap Class [ Card ] -->

      <div class="card-header"> <!-- Start Card-header Bootstrap Class [ Header ] -->
          <i class='fa fa-book-reader fa-fw'></i> Edit Information
      </div> <!-- End Card-header Bootstrap Class [ Header ] -->

      <div class="card-body"> <!-- Start Card-Body Bootstrap Class [ Body ] -->
<!--
=====================================================================================================================================
                                                    Start Edit Information Body
=====================================================================================================================================
-->
<form class="form-horizontal text-center" action="?action=Update" method="POST" enctype="multipart/form-data">
    <div class="row"> <!-- Start Div Class [ Row ] -->

      <!-- Start Name Feild -->
          <div class="input-group mb-4 col-12 col-lg-6">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-user fa-fw"></i> </span>
              </div>
              <input type="text" class="form-control" placeholder="NickName" name="name" value='<?= $userInfo["NickName"]; ?>'>
              <input type="text" hidden name="id" value='<?= $userInfo["UserID"]; ?>'>
          </div>
      <!-- End Name Feild -->

      <!-- Start Password Feild -->
          <div class="input-group mb-4 col-12 col-lg-6">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="toggle-pass fa fa-eye fa-fw"></i> </span>
              </div>
              <input type="password" hidden class="form-control" name="password" value='<?= $userInfo["Password"]; ?>'>
              <input type="password" class="form-control" placeholder="Write New Password IF You Want Or leave It Empty" name="new-password">
          </div>
      <!-- End Password Feild -->

      <!-- Start Email Feild -->
          <div class="input-group mb-4 col-12 col-lg-6">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-at fa-fw"></i> </span>
              </div>
              <input type="email" class="form-control" placeholder="Email" name="email" value='<?= $userInfo["Email"]; ?>'>
          </div>
      <!-- End Email Feild -->

      <!-- Start Full Name Feild -->
          <div class="input-group mb-4 col-12 col-lg-6">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-info-circle fa-fw"></i> </span>
              </div>
              <input type="text" class="form-control" placeholder="Full Name" name="fullname" value='<?= $userInfo["FullName"]; ?>'>
          </div>
      <!-- End Full Name Feild -->

      <!-- Start phone Feild -->
          <div class="input-group mb-4 col-12 col-lg-6">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-phone fa-fw"></i> </span>
              </div>
              <input type="tel" class="form-control" placeholder="Phone Number" name="phone"  value='<?= $userInfo["Phone"]; ?>'>
          </div>
      <!-- End phone Feild -->

      <!-- Start country Feild -->
          <div class="input-group mb-4 col-12 col-lg-6">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-city fa-fw"></i> </span>
              </div>
              <input type="text" class="form-control" placeholder="Country" name="country"  value='<?= $userInfo["Country"]; ?>'>
          </div>
      <!-- End country Feild -->

      <!-- Start Gender Feild -->
          <div class="input-group mb-4 col-12 col-lg-6">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-venus-mars fa-fw"></i> </span>
              </div>
              <select name="gender" class="form-control"  value='<?= $userInfo["Gender"]; ?>'>
                <option value="male">Male</option>
                <option value="female">Female</option>
              </select>
          </div>
      <!-- End Gender Feild -->

      <!-- Start country Feild -->
          <div class="input-group mb-4 col-12 col-lg-6">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-image fa-fw"></i> </span>
              </div>
              <div class="avatar">
                <input class="form-control" type="file" name='Navatar' id='avatar'>
                <input hidden type="text" name='Lavatar' value="<?= $userInfo['UserImage'];?>">
              </div>
          </div>
      <!-- End country Feild -->


      <!-- Start Submit Feild -->
          <div class="input-group col-md-12 text-center">
              <button name="save" class="btn btn-info pl-5 pr-5 pt-2 pb-2"> <i class="fa fa-user-plus  fa-fw"></i> Save</button>
          </div>
      <!-- End Submit Feild -->

    </div> <!-- End Div Class [ Row ] -->
</form>
<!-- 
=====================================================================================================================================
                                                    End Edit Information Body
=====================================================================================================================================
 -->
      </div> <!-- End Card-Body Bootstrap Class [ Body ] -->

  </div> <!-- End Card Bootstrap Class [ Card ] -->
</div> <!-- End Container Bootstrap Class [ Container ] -->
</section> <!-- End Section Class [ Courses ] -->

<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
      $name        = $_POST["name"];
      $id          = $_POST["id"];
      $password    = "";
      $email       = $_POST["email"];
      $fullname    = $_POST["fullname"];
      $phone       = $_POST["phone"];
      $country     = $_POST["country"];
      $gender      = $_POST["gender"];

      $avatar      = "";
      $extention   = array('image/jpg' , 'image/png' , 'image/jpeg');
      if(empty($_FILES["Navatar"]['name'])){
        $avatar = $_POST['Lavatar'];
      }else{
        $av_name     = $_FILES["Navatar"]['name'];
        $avtmp       = $_FILES["Navatar"]['tmp_name'];
        $avtype      = $_FILES["Navatar"]['type'];

        if(! in_array($avtype, $extention)){
          $errors[] = "This Image Extention IS Avaibal.";
        }else{
          $avatar     = "files/images-users/".$av_name;
          move_uploaded_file( $avtmp, "files/images-users/". $av_name );
          copy('files/images-users/'. $av_name, 'admin/files/images-users/'. $av_name);
        }
      }

      if(isset($_POST["name"])){
        $filterUser = filter_var($_POST["name"] , FILTER_SANITIZE_STRING);
          if(strlen($filterUser) < 5){
            $errors[] = "This User Name Must Be More Than 5 Characters.";
          }else{
            $stmt = $conn->prepare("SELECT * FROM users WHERE UserName = ?");
            $stmt->execute(array($name));
            $count = $stmt->rowCount();
            $stmt = $conn->prepare("SELECT * FROM users WHERE UserName = ? AND UserID = ?");
            $stmt->execute(array($name , $id));
            $count1 = $stmt->rowCount();
            if($count != 0 && $count1 != 1){
              $errors[] = "This User Name IS Exist.";
            }
          }
      } // IF To Check The User Password
      if(empty($_POST["new-password"])){
        $password = $_POST["password"];
      }else{
        $password = sha1($_POST["new-password"]);
      }// IF To Check The Password
      if(isset($_POST["fullname"])){
        $filterFullname = filter_var($_POST["fullname"] , FILTER_SANITIZE_STRING);
        if($filterFullname > 4){
          $errors[] = "The Full Name Must Be More Than 8 Characters.";
        }
      } // IF To Check The Country
      if(isset($_POST["country"])){
        $filterCountry = filter_var($_POST["country"] , FILTER_SANITIZE_STRING);
        if(empty($_POST["country"])){
          $errors[] = "The Country Must Be not empty.";
        }
      }// IF To Check The Email
      if(isset($_POST["email"])){
        $filterEmail = filter_var($_POST["country"] , FILTER_SANITIZE_EMAIL);
        if(empty($filterEmail)){
          $errors[] = "This Email IS Not Valid.";
        }
      }// IF To Check The Phone
      if(empty($_POST["phone"])){
        $errors[] = "Please Write The Correct Phone Number.";
      }
      
      if(empty($errors)){

        $stmt = $conn->prepare("UPDATE `users` SET `NickName`= ?,`Password`= ?,`FullName`= ?,`Email`= ?,`Gender`= ?,`Country`= ?,                           `Phone`= ?,`UserImage`= ? WHERE UserID = ?");
        $stmt->execute(array($name,$password,$fullname,$email,$gender,$country,$phone,$avatar,$sessionUserID));

        $count = $stmt->rowCount();
        if($count > 0){
          echo" <script> alert('Successfully Update Account..');</script> ";
          header("refresh:.5;url=" . $_SERVER['PHP_SELF']);
        }
      }else{
        echo '<div class="error offset-md-3 col-md-6 col-lg-5 mb-5">';
          if(!empty($errors)){
            foreach ($errors as $error) {
              echo "<h6 class='mt-1 mb-0'>" . $error . "</h6>";
            }
          }
        echo '</div>';
      }
    }else{
        $msg = "Sorry You Can't Come In This Link Directry";
    }
?>
<!-- 
=====================================================================================================================================
                                             Footer Page
=====================================================================================================================================
 -->
<?php
// End IF Else Statment To Check IF This User Have Session OR Not
}else{ header("Location: login.php");  exit(); }
include "template/footer.php";
ob_end_flush();
?>