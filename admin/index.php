<?php
// To Start Session To Save The User Was Login In any other Pages
session_start();
// To Make No Navbar In this Page
$noNavbar = "";
// To Change The Page Title
$pageTitle = "LOGIN";
// To Check If Session Have data of User or not
if (isset($_SESSION["Username"])) {
  // Go To Dashboard Pages
  header("Location: dashboard.php");
}

// Include To init Routes File It have all Files included
include "init.php";

// Check If User Coming From HTTP Post Request or From Form Request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["user"];
  $password = sha1($_POST["password"]);  // To Make The Password More Securite
  // Check If The User Exist In Database
  $stmt = $conn->prepare("SELECT `UserID`,`UserName`,`Password` FROM `users` WHERE `UserName` = ? AND `Password` = ? AND	Admin = 1");
  // To Run The Query
  $stmt->execute(array($username, $password));
  // To Fetch The Data From Database
  $row = $stmt->fetch();
  // To Calculate The Rows That's Fetch From Database
  $count = $stmt->rowCount();

  // If rows > 0 This Mean The Database Contain Record About This Username
  if ($count > 0) {

    // Register Session array That Have User Name
    $_SESSION["Username"] = $row["UserName"];
    // Register Session array That Have UserID
    $_SESSION["ID"] = $row["UserID"];
    // Redirect To Dashbard Page
    header("Location: dashboard.php");
    // Must Be Write This Code To Exit From This Page
    exit();
  } else { // End If Statment That Do Check Th Count Of Rows
    $error =  "Wrong Data";
  }
} // End If Statment That Do Check The Request
?>
<!--
======================
Start Login Form
======================
-->
<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
  <h4> <?php echo lang("USERLOGIN") ?> </h4>
  <?php if (isset($error) && $error !== null) { ?>
    <div class="alert alert-danger"> <?= $error ?> </div>
  <?php } ?>
  <input class="form-control" type="text" name="user" placeholder="User Name" autocomplete="off" value="Mahmoud">
  <input class="form-control  " type="password" name="password" placeholder="Password" autocomplete="new-password" value=123>
  <input class="btn btn-primary btn-block" type="submit" value="login">
</form>
<!--
======================
End Login Form
======================
-->
<!--
======================
Include To Footer File
======================
-->
<?php include $tpl . "footer.php"; ?>
