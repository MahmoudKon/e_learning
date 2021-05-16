<?php
ob_start();
// Start Session
session_start();
// To Change The Page Title
$title  = "LogIn";
$active = "";
$errors = array();
// To Check If Session Have data of User or not
if(isset($_SESSION["user"])){
  // Go To Index Page
    header("Location: index.php");
  }
// To Include The Main File That Have All Files Include
include "inhi.php";

// Check If User Coming From HTTP Post Request or From Form Request
if($_SERVER["REQUEST_METHOD"] == "POST"){
  if(isset($_POST["login"])){
      $name = $_POST["name"];
      $password = sha1($_POST["password"]);  // To Make The Password More Securite

    // Check If The User Exist In Database
    $stmt = $conn->prepare("SELECT `UserID`,`UserName`,`Password` FROM `users` WHERE `UserName` = ? AND `Password` = ?");
      // To Run The Query
      $stmt->execute(array($name, $password));
      $userInfo = $stmt->fetch();
      // To Calculate The Rows That's Fetch From Database
      $count = $stmt->rowCount(); 

      // If rows > 0 This Mean The Database Contain Record About This Username
      if($count > 0){

          // Register Session array That Have User Name
          $_SESSION["user"] = $name;
          $_SESSION["uID"] = $userInfo["UserID"];
          // Redirect To Index Page
          $url = "";
          if(isset($_SERVER["HTTP_REFERER"]) && !empty($_SERVER["HTTP_REFERER"])){
            $url = $_SERVER["HTTP_REFERER"];
          }else{
            $url = "index.php";
          }
          header("refresh:0;url=$url");
          // Must Be Write This Code To Exit From This Page
          exit();

      }else{ // End If Statment That Do Check Th Count Of Rows
        $errors[] =  "<h6 class='alert alert-danger'>Your Password or User Name IS Wrong !!</h6>";
      }
    }else{

      $username    = $_POST["name"];
      $nickname    = $_POST["name"];
      $password    = sha1($_POST["password"]);
      $ComPassword = $_POST["Com-password"];
      $email       = $_POST["email"];
      $fullname    = $_POST["fullname"];
      $phone       = $_POST["phone"];
      $country     = $_POST["country"];
      $gender      = $_POST["gender"];
      if(empty($_POST["avatar"])){
        $avatar      = 'files/images-users/profile.png';
      }
      $extention   = array('jpg' , 'png' , 'jpeg');
      $av_name     = $_FILES["avatar"]['name'];
      $avtmp       = $_FILES["avatar"]['tmp_name'];
      $avtype      = $_FILES["avatar"]['type'];
   
     move_uploaded_file( $avtmp, "files/images-users/". $av_name );
     copy('files/images-users/'. $av_name, 'admin/files/images-users/'. $av_name);
     $avatar = empty($av_name) ? "" : "files/images-users/". $av_name;

      if(isset($_POST["name"])){
        $filterUser = filter_var($_POST["name"] , FILTER_SANITIZE_STRING);
        $check = checkItem("UserName" , "users" , $_POST["name"]);
          if(strlen($filterUser) < 5){
            $errors[] = "This User Name Must Be More Than 5 Characters.";
          }
          if($check == 1){
            $errors[] = "This User Name IS Exist.";
          }
      } // IF To Check The User Name
      if(isset($_POST["password"]) && isset($_POST["Com-password"])){
        $filterPassword = filter_var($_POST["password"] , FILTER_SANITIZE_STRING);
        if($_POST["password"] !== $_POST["Com-password"] || empty($_POST["password"])){
          $errors[] = "Password Must Be Match.";
        }
      } // IF To Check The Password
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
      } // IF To Check The Avatar
      if(isset($_POST["avatar"])){
        $ex = explode(".",strtolower($_POST["avatar"]));
        if(!in_array(end($ex), $extention)){
          $errors[] = "The Avatar Extention Must Be [ jpg , jpeg , png ].";
        }
      } // IF To Check The Avatar
      if(isset($_POST["email"])){
        $filterEmail = filter_var($_POST["country"] , FILTER_SANITIZE_EMAIL);
        if(empty($filterEmail)){
          $errors[] = "This Email IS Not Valid.";
        }
      } // IF To Check The Phone

      if(empty($errors)){
        $stmt = $conn->prepare("INSERT INTO `users`(`UserName`, `NickName`, `Password`, `FullName`, `Email`, `Gender`, `Country`, `Phone`, `Date`, `UserImage`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, now(), ?)");
        $stmt->execute(array($username,$nickname,$password,$fullname,$email,$gender,$country,$phone,$avatar));

        $count = $stmt->rowCount();
        if($count > 0){
          echo" <script> alert('Successfully Created Account..');</script> ";
          header("refresh:.5;url=login.php");
        }
      }

  } // End If Statment That Do Check The Request From SignUp Form
} // End If Statment That Do Check The Request
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
							<li><i class="fa fa-chevron-right fa-fw"></i> Login </li>
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


<!-- Start Container -->
<!-- 
=====================================================================================================================================
                                                      ===================
                                                      Start Forms Section
                                                      ===================
=====================================================================================================================================
 -->

<section class="forms"> <!-- Start Div Class [ Forms ] -->
    <div class="layout"> <!-- Start Div Class [ BG - Layout ] -->
        <div class="container"> <!-- Start Div Class [ Container ] -->
        
          <div class="header mt-5"> <!-- Start Div Class [ Main - Head ] -->
            <h1 class="p-0 m-0 text-center"><span class="active" data-class="Login">Login</span> | <span data-class="Signup">Signup</span></h1>
          </div> <!-- End Div Class [ Main - Head ] -->

          <div class="body pb-5 pt-5"> <!-- Start Div Class [ Header ] -->
              
            <div class="row">
<!-- 
=====================================================================================================================================
                                                      ===================
                                                      Start LogIn Section
                                                      ===================
=====================================================================================================================================
 -->
          <!-- End Form Login -->
              <form id="Login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="col-12 offset-0 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-5 offset-lg-3">
<?php if(!empty($err)){ echo $err; } ?>
                  <!-- Start Name Feild -->
                      <div class="input-group mb-4">
                        <div class="input-group-prepend">
                          <span class="input-group-text"> <i class="fa fa-user fa-fw"></i> </span>
                        </div>
                        <input type="text" class="form-control" placeholder="User Name" name="name" required="required" value="Mahmoud">
                      </div>
                  <!-- End Name Feild -->

                  <!-- Start Password Feild -->
                      <div class="input-group mb-4">
                        <div class="input-group-prepend">
                          <span class="input-group-text"> <i class="toggle-pass fa fa-eye fa-fw"></i> </span>
                        </div>
                        <input type="password" class="form-control" placeholder="Password" name="password" required="required" value=123>
                      </div>
                  <!-- End Password Feild -->

                  <!-- Start Check Box Feild -->
                      <div class="login-check">
                        <label class="checkbox"><input type="checkbox" name="checkbox" checked=""><i> </i> Keep me logged in</label>
                      </div>
                  <!-- End Check Box Feild -->

                  <!-- Start Submit Feild -->
                      <div class="input-group">
                        <button name="login" class="btn btn-primary pl-5 pr-5 pt-2 pb-2"> <i class="fa fa-sign-in-alt fa-fw"></i> LogIn</button>
                      </div>
                  <!-- End Submit Feild -->

                  <!-- End Links Feild -->
                    <div class="links">
                      <p class="links-text"><a href="#">Forgot Password?</a></p>
                      <p class="right links-text"><a href="sigin.php?action=sign">New User? Register</a></p>
                    </div>
                  <!-- End Links Feild -->
              </form>
          <!-- End Form Login -->
<!-- 
=====================================================================================================================================
                                                      ===================
                                                      Start SignUp Section
                                                      ===================
=====================================================================================================================================
 -->
          <!-- Start Form Signup -->
              <form id="Signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="col-12 col-lg-10 offset-lg-1"  enctype="multipart/form-data">
              <div class="row">

                    <!-- Start Name Feild -->
                        <div class="input-group mb-4 col-12 col-lg-6">
                            <div class="input-group-prepend">
                              <span class="input-group-text"> <i class="fa fa-user fa-fw"></i> </span>
                            </div>
                            <input type="text" class="form-control" placeholder="User Name" name="name" pattern=".{5,}" title="This Field Must Be More Than 5 Chars">
                        </div>
                    <!-- End Name Feild -->

                    <!-- Start Password Feild -->
                        <div class="input-group mb-4 col-12 col-lg-6">
                            <div class="input-group-prepend">
                              <span class="input-group-text"> <i class="toggle-pass fa fa-eye fa-fw"></i> </span>
                            </div>
                            <input type="password" class="form-control" placeholder="Password" name="password" minlength="4">
                        </div>
                    <!-- End Password Feild -->

                    <!-- Start Email Feild -->
                        <div class="input-group mb-4 col-12 col-lg-6">
                            <div class="input-group-prepend">
                              <span class="input-group-text"> <i class="fa fa-at fa-fw"></i> </span>
                            </div>
                            <input type="email" class="form-control" placeholder="Email" name="email">
                        </div>
                    <!-- End Email Feild -->

                    <!-- Start Confirm Password Feild -->
                        <div class="input-group mb-4 col-12 col-lg-6">
                            <div class="input-group-prepend">
                              <span class="input-group-text"> <i class="toggle-pass fa fa-eye fa-fw"></i> </span>
                            </div>
                            <input type="password" class="form-control" placeholder="Confirm Password" name="Com-password" minlength="4">
                        </div>
                    <!-- End Confirm Password Feild -->

                    <!-- Start Full Name Feild -->
                        <div class="input-group mb-4 col-12 col-lg-6">
                            <div class="input-group-prepend">
                              <span class="input-group-text"> <i class="fa fa-info-circle fa-fw"></i> </span>
                            </div>
                            <input type="text" class="form-control" placeholder="Full Name" name="fullname" pattern=".{5,15}" title="This Field Must Be Bettwen 5 & 15 Chars">
                        </div>
                    <!-- End Full Name Feild -->

                    <!-- Start phone Feild -->
                        <div class="input-group mb-4 col-12 col-lg-6">
                            <div class="input-group-prepend">
                              <span class="input-group-text"> <i class="fa fa-phone fa-fw"></i> </span>
                            </div>
                            <input type="number" class="form-control" placeholder="Phone Number" name="phone">
                        </div>
                    <!-- End phone Feild -->

                    <!-- Start country Feild -->
                        <div class="input-group mb-4 col-12 col-lg-6">
                            <div class="input-group-prepend">
                              <span class="input-group-text"> <i class="fa fa-city fa-fw"></i> </span>
                            </div>
                            <input type="text" class="form-control" placeholder="Country" name="country">
                        </div>
                    <!-- End country Feild -->

                    <!-- Start Gender Feild -->
                        <div class="input-group mb-4 col-12 col-lg-6">
                            <div class="input-group-prepend">
                              <span class="input-group-text"> <i class="fa fa-venus-mars fa-fw"></i> </span>
                            </div>
                            <select name="gender" class="form-control">
                              <option value="male">Male</option>
                              <option value="female">Female</option>
                            </select>
                        </div>
                    <!-- End Gender Feild -->

                    <!-- Start Name Feild -->
                        <div class="input-group mb-4 col-12 col-lg-6">
                            <div class="avatar">
                                Upload Your Avatar
                              <input type="file" name='avatar' id='avatar'>
                              <img src='files/images-users/profile.png'>
                            </div>
                        </div>
                    <!-- End Name Feild -->

                    <!-- Start Submit Feild -->
                        <div class="input-group col-6">
                            <button name="signup" class="btn btn-info mb-0 pl-5 pr-5 pt-2 pb-2"> <i class="fa fa-user-plus  fa-fw"></i> SignUp</button>
                        </div>
                    <!-- End Submit Feild -->
                    </div>
              </form>
          <!-- End Form SignUp -->
<div class="error offset-md-3 col-md-6 col-lg-5">
<?php
  if(!empty($errors)){
    foreach ($errors as $error) {
      echo "<h6 class='mt-1 mb-0'>" . $error . "</h6>";
    }
  }
?>
</div>
            </div> <!-- End Div Class [ Row ] -->

          </div> <!-- End Div Class [ Header ] -->

        </div> <!-- Start Div Class [ Container ] -->
    </div> <!-- End Div Class [ BG - Layout ] -->
</section> <!-- Start Div Class [ Forms ] -->
<!-- 
=====================================================================================================================================
                                                            =================
                                                            End Forms Section
                                                            =================
=====================================================================================================================================
 -->

<?php  include "template/footer.php"; ob_end_flush();?>