<?php
/*
    == Manage Members Page
    == You Can Make [ Add | Edit | Delete ] Members From Here
*/
  session_start();
  if(isset($_SESSION["Username"])){
    $pageTitle = "MEMBERS";
    $active = "members";
    include "init.php";  //  Include To init Routes File
    $action = isset($_GET["action"]) ? $_GET["action"] : "Manage";

    if($action == "Manage"){
      $query = "";
      if(isset($_GET["page"]) && $_GET["page"] == "Pending"){
        $query = "WHERE RegStatus = 0";
      }
      $rowInPage = 5;
      $stmt = $conn->prepare("SELECT * FROM users $query ORDER BY UserID DESC");
      $stmt->execute();
      $rowCount = $stmt->rowCount();
      // Select All Users Except Admins
      $stmt = $conn->prepare("SELECT * FROM users $query LIMIT 0, $rowInPage ");
      // Execute The Statment
      $stmt->execute();
      $rows = $stmt->fetchAll();
      $countPages= ceil($rowCount / $rowInPage);
      /***********************************************
        ******* START Manage Members Page **********
      ***********************************************/
      ?>
      <div class="container">
        <h1 class="text-center">Manage Members</h1>
        <a href="members.php?action=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Member</a>
        <input type='text' name='search' placeholder="Search By" id="searchByName" data-action="searchUser">
        <select id='searchBy'>
          <option value='UserID'> ID </option>
          <option value='UserName'> Name </option>
          <option value='NickName'> NickName </option>
          <option value='Phone'> Phone </option>
        </select>
        <ul class="change-page">
          <?php
            for($i = 1; $i <= $countPages; $i++){
              echo "<li> <a href='#' data-page='".$i."' data-rowInPage='".$rowInPage."'>".$i."</a> </li>";
            }
          ?>
        </ul>
      </div>
      <div class="table-responsive">
        <table class="custom-table table table-bordered text-center">
          <thead>
            <tr>
              <td>#ID</td>
              <td>NickName</td>
              <td>Full Name</td>
              <td>Email</td>
              <td>Gender</td>
              <td>Country</td>
              <td>Phone</td>
              <td>Registerd Date</td>
              <td>Controls</td>
            </tr>
          </thead>
          <tbody>
          <?php 
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
                if($row["Admin"]==1){
                  echo "<td><span class='alert alert-danger'>ADMIN</span></td>";
                }else{
                echo "<td>";
                  echo "<a href='members.php?action=Edit&userid=" . $row['UserID'] . "&name=". $row['UserName'] ."' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>";

                  echo "<a href=''data-action='members' data-type='delete' data-id='".$row['UserID'] ."' class='btn btn-danger del-comments ml-2 mr-2'><i class='fa fa-close'></i> Delete</a>";

                  if($row["Regstatus"] == 0){
                    echo "<a href=''data-action='members' data-type='approve' data-id='".$row['UserID'] ."' class='btn btn-info del-comments'><i class='fa fa-check'></i> Approve</a>";
                  }
                echo "</td>";
                }
              echo "</tr>";
            }
          ?>
          </tbody>
        </table>
      </div>
<?php if(!empty($rows)){ }else{ echo "<p class='alert alert-danger text-center container'>No Users To Display It !!</p>" ; } ?>
      <?php
      /***********************************************
        *************** END Manage Members Page ***************
      ***********************************************/
    }elseif($action == "Add"){
      /***********************************************
        ***************** Add Page *****************
      ***********************************************/
      echo "<div class='container'>";
      ?>

      <!-- Start Add Page -->
      <h1 class="text-center">Add New Members</h1>
      <form class="form-horizontal text-center" id="Signup" action="?action=Insert" method="POST" enctype="multipart/form-data">
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
                <span class="input-group-text"> <i class="show-pass fa fa-eye fa-fw"></i> </span>
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
                <span class="input-group-text"> <i class="show-pass fa fa-eye fa-fw"></i> </span>
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
              <input type="tel" class="form-control" placeholder="Phone Number" name="phone">
          </div>
      <!-- End phone Feild -->

      <!-- Start country Feild -->
          <div class="input-group mb-4 col-12 col-lg-6">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-building fa-fw"></i> </span>
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
      <!-- End Add Page -->
    <?php
      /***********************************************
        *************** END Add Page ***************
      ***********************************************/

    }elseif($action == "Insert"){
      /***********************************************
        ************* START Insert Page **************
      ***********************************************/
if($_SERVER["REQUEST_METHOD"] == "POST"){
        echo "<h1 class='text-center'>Insert Members [ " . $_POST["name"]. " ]</h1>";
        $username    = $_POST["name"];
        $nicName     = $_POST["name"];
        $password    = sha1($_POST["password"]);
        $ComPassword = $_POST["Com-password"];
        $email       = $_POST["email"];
        $fullname    = $_POST["fullname"];
        $phone       = $_POST["phone"];
        $country     = $_POST["country"];
        $gender      = $_POST["gender"];
        $extention   = array('jpg' , 'png' , 'jpeg');

        $av_name     = $_FILES["avatar"]['name'];
        $avtmp       = $_FILES["avatar"]['tmp_name'];
        $avtype      = $_FILES["avatar"]['type'];
     

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
        if(isset($_FILES["avatar"])){
          if(! empty($_FILES["avatar"])){
                move_uploaded_file( $avtmp, "files/images-users/". $av_name );
                copy('files/images-users/'. $av_name, '../files/images-users/'. $av_name);
                $avatar = empty($av_name) ? "" : "files/images-users/". $av_name;
          }else{
            $avatar = "files/images-users/profile.png";
          }
        } // IF To Check The Avatar
        if(isset($_POST["email"])){
          $filterEmail = filter_var($_POST["country"] , FILTER_SANITIZE_EMAIL);
          if(empty($filterEmail)){
            $errors[] = "This Email IS Not Valid.";
          }
        } // IF To Check The Phone
        // Check If Var Have Errors Or Not
        if(empty($errors)){
          $stmt = $conn->prepare("INSERT INTO `users`(`UserName`, `NickName`, `Password`, `FullName`, `Email`, `Gender`, `Country`, `Phone`, `Date`, `UserImage`, `Admin`, `Regstatus`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, now(), ?, 1, 1)");
          $stmt->execute(array($username,$nicName,$password,$fullname,$email,$gender,$country,$phone,$avatar));
  
          $count = $stmt->rowCount();
          if($count > 0){
            echo" <script> alert('Successfully Created Account..');</script> ";
            header("refresh:.5;url=members.php");
          }
        }else{
          // Loop Into Error Array And Echo It
          echo "<div class=''>";
            foreach ($errors as $error) {
              echo "<h6 class='mt-1 mb-0 alert alert-danger'>" . $error . "</h6>";
            }
          echo "</div>";
        }
      }else{ // If The User Come To Page By External Link or Not By Method Post
        $smg = "Sorry You Can't Come In This Link Directry";
        reHome($smg,"danger","back",.5);
      }
      /***********************************************
        ************* END Insert Page **************
      ***********************************************/

    }elseif($action == "Edit"){
      /***********************************************
        ************* START Edit Page **************
      ***********************************************/
      $userid = isset($_GET["userid"]) && is_numeric($_GET["userid"]) ? intval($_GET["userid"]) : 0;
      $stmt = $conn->prepare("SELECT * FROM `users` WHERE `UserID` = ?");
      $stmt->execute(array($userid));
      $user = $stmt->fetch();
      $count = $stmt->rowCount();
      if($count > 0){  
        ?>
      <!-- Start Edit Page -->
      <h1 class="text-center">Edit Members <?= "[ " .$user["UserName"] . " ]" ?></h1>
      <form class="form-horizontal text-center" id="Signup" action="?action=Update" method="POST" enctype="multipart/form-data">
        <div class="row">

      <!-- Start Name Feild -->
          <div class="input-group mb-4 col-12 col-lg-6">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-user fa-fw"></i> </span>
              </div>
              <input type="text" class="form-control" placeholder="NickName" name="name" value='<?= $user["NickName"]; ?>'>
              <input type="text" name="userid" hidden value='<?= $userid; ?>'>
          </div>
      <!-- End Name Feild -->

      <!-- Start Password Feild -->
          <div class="input-group mb-4 col-12 col-lg-6">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="show-pass fa fa-eye fa-fw"></i> </span>
              </div>
              <input type="password" hidden class="form-control" placeholder="Write New Password IF You Want Or leave It Empty" name="password" value='<?= $user["Password"]; ?>'>
              <input type="password" class="form-control" placeholder="Write New Password IF You Want Or leave It Empty" name="password-new">
          </div>
      <!-- End Password Feild -->

      <!-- Start Email Feild -->
          <div class="input-group mb-4 col-12 col-lg-6">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-at fa-fw"></i> </span>
              </div>
              <input type="email" class="form-control" placeholder="Email" name="email" value='<?= $user["Email"]; ?>'>
          </div>
      <!-- End Email Feild -->

      <!-- Start Email Feild -->
          <div class="input-group mb-4 col-12 col-lg-6">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="show-pass fa fa-eye fa-fw"></i> </span>
              </div>
              <input type="password" class="form-control" placeholder="Confirm Password" name="Com-password">
          </div>
      <!-- End Email Feild -->

      <!-- Start Full Name Feild -->
          <div class="input-group mb-4 col-12 col-lg-6">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-info-circle fa-fw"></i> </span>
              </div>
              <input type="text" class="form-control" placeholder="Full Name" name="fullname" value='<?= $user["FullName"]; ?>'>
          </div>
      <!-- End Full Name Feild -->

      <!-- Start phone Feild -->
          <div class="input-group mb-4 col-12 col-lg-6">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-phone fa-fw"></i> </span>
              </div>
              <input type="number" class="form-control" placeholder="Phone Number" name="phone"  value='<?= $user["Phone"]; ?>'>
          </div>
      <!-- End phone Feild -->

      <!-- Start country Feild -->
          <div class="input-group mb-4 col-12 col-lg-6">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-city fa-fw"></i> </span>
              </div>
              <input type="text" class="form-control" placeholder="Country" name="country"  value='<?= $user["Country"]; ?>'>
          </div>
      <!-- End country Feild -->

      <!-- Start Gender Feild -->
          <div class="input-group mb-4 col-12 col-lg-6">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-venus-mars fa-fw"></i> </span>
              </div>
              <select name="gender" class="form-control"  value='<?= $user["Gender"]; ?>'>
                <option value="male">Male</option>
                <option value="female">Female</option>
              </select>
          </div>
      <!-- End Gender Feild -->

      <!-- Start Name Feild -->
          <div class="input-group mb-4 col-12 col-lg-6">
              <div class="avatar">
                  Upload Your Avatar
                <input type="file" name='Navatar' id='avatar'>
                <input hidden type="text" name='Lavatar' value='<?= $user["UserImage"]; ?>'>
                <img src='<?= $user["UserImage"]; ?>'>
              </div>
          </div>
      <!-- End Name Feild -->

      <!-- Start Submit Feild -->
          <div class="input-group col-6">
              <button name="save" class="btn btn-info mb-0 pl-5 pr-5 pt-2 pb-2"> <i class="fa fa-user-plus  fa-fw"></i> Save</button>
          </div>
      <!-- End Submit Feild -->
      </div>
      </form>
    <?php
      }else{
        reHome("Error ID","danger");
      }
      /***********************************************
        *************** END Edit Page *************
      ***********************************************/
    }elseif($action == "Update"){
      /***********************************************
        ************ START Update Page *************
      ***********************************************/
      if($_SERVER["REQUEST_METHOD"] == "POST"){
        echo "<h1 class='text-center'>Updated Member " . $_POST["name"] . "</h1>";
        $userid      = $_POST["userid"];
        $name        = $_POST["name"];
        $password    = $_POST["password-new"];
        $ComPassword = $_POST["Com-password"];
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
            copy('files/images-users/'. $av_name, '../files/images-users/'. $av_name);
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
              $stmt->execute(array($name , $userid));
              $count1 = $stmt->rowCount();
              if($count != 0 && $count1 != 1){
                $errors[] = "This User Name IS Exist.";
              }
            }
        } // IF To Check The User Name
        if(! empty($_POST["password-new"]) && ! empty($_POST["Com-password"])){
          if($_POST["password-new"] !== $_POST["Com-password"]){
            $errors[] = "Password Must Be Match.";
          }else{
            $password = sha1($_POST['password-new']);
          }
        }else{
          $password = $_POST['password'];
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
        }
        if(isset($_POST["email"])){
          $filterEmail = filter_var($_POST["country"] , FILTER_SANITIZE_EMAIL);
          if(empty($filterEmail)){
            $errors[] = "This Email IS Not Valid.";
          }
        } // IF To Check The Phone
        
        if(empty($errors)){

          $stmt = $conn->prepare("UPDATE `users` SET `NickName`= ?,`Password`= ?,`FullName`= ?,`Email`= ?,`Gender`= ?,`Country`= ?,                           `Phone`= ?,`UserImage`= ? WHERE UserID = ?");
          $stmt->execute(array($name,$password,$fullname,$email,$gender,$country,$phone,$avatar,$userid));

          $count = $stmt->rowCount();
            echo" <script> alert('Successfully Update Account..');</script> ";
            header("refresh:.5;url=" . $_SERVER['PHP_SELF']);
        }else{
          echo '<div class="error offset-md-3 col-md-6 col-lg-5">';
            if(!empty($errors)){
              foreach ($errors as $error) {
                echo "<h6 class='mt-1 mb-0 alert alert-danger'>" . $error . "</h6>";
              }
            }
            $msg = "";
            header("refresh:1.5;url=" . $_SERVER["HTTP_REFERER"]);
          echo '</div>';
        }
      }else{
          $msg = "Sorry You Can't Come In This Link Directry";
          reHome($msg,"danger","back",.3);
      }
      /***********************************************
        ************ END Update Page ***************
      ***********************************************/

    }else{
      $msg = "Sorry This Page Not Found";
      reHome($msg,"danger","back",2);
    }
    echo "</div>";
}else{
    header("Location: index.php"); // Back To Login Page
    exit();
}

  include $tpl."footer.php";  //  Include To Header File