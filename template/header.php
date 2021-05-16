<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $title; ?></title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Unicat project">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css"> -->

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="css/select/bootstrap-select.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/jquery.tagsinput.min.css">
<link rel="stylesheet" type="text/css" href="css/animate.css">
<link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>

<!--
==========================
   Start Section Upper-Bar
==========================
-->
<!-- Top Bar -->
<?php
if(isset($_SESSION["user"])){

  }else{
?>
<div class="top_bar">
			<div class="container">
					<div class="row">
						<div class="col wow lightSpeedIn" data-wow-delay=".2s">
							<div class="top_bar_content d-flex flex-row align-items-center justify-content-start">
								<ul class="top_bar_contact_list">
									<li><div class="question">Have any questions?</div></li>
									<li>
										<i class="fa fa-phone" aria-hidden="true"></i>
										<div>02-01156-455369</div>
									</li>
									<li>
										<i class="fa fa-envelope" aria-hidden="true"></i>
										<div>info.famousTeam@gmail.com</div>
									</li>
								</ul>
								
							</div>
            </div>
            <div class="top_bar_login ml-auto">
									<div class="login_button"><a href="login.php">Register | Login</a></div>
								</div>
					</div>
				</div>
			</div>				
		</div>
<?php }?>
<!--
========================
   End Section Upper-Bar
========================
-->



<!-- 
  ====================
  Start Navbar Section
  ====================
 -->
<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="#">
      D
      <span class="left">e</span>
      l
      <span class="center">t</span>
      a <br>
      <img src="images/logo.jpg">
    </a>
    
    <button class="navbar-toggler navbar-light" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item <?php if($active == 'Home'){echo 'active';} ?>">
          <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item <?php if($active == 'About'){echo 'active';} ?>">
          <a class="nav-link" href="about.php">About</a>
        </li>
        <li class="nav-item dropdown <?php if($active == 'Categories'){echo 'active';} ?>">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Categories
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <?php foreach(getCats() as $cat): ?>
                      <a class="dropdown-item" href="categories.php?pageid=<?php echo $cat['ID']; ?>&pagename=<?php echo str_replace(" ","",$cat['Name']); ?>" data-toggle='tooltip' data-placement='right' title="<?php echo $cat["Description"]; ?>" >
                            <?php echo $cat["Name"]; ?>
                      </a>
                <?php endforeach; ?>
            </div>
        </li>
        <li class="nav-item <?php if($active == 'Blog'){echo 'active';} ?>">
          <a class="nav-link" href="blog.php">Blog</a>
        </li>
        <li class="nav-item <?php if($active == 'Contact'){echo 'active';} ?>">
          <a class="nav-link" href="contact.php">Contact Us</a>
        </li>
      </ul>
      <form class="ml-md-3">
        <i class="fa fa-search p-2"></i>                
        <?php 
            if(isset($_SESSION["user"])){
                   
                $stmt = $conn->prepare("SELECT * FROM users WHERE UserID = ?");
                $stmt->execute(array($sessionUserID));
                $imguser = $stmt->fetch();
                $count = $stmt->rowCount();
                ?>

                  <div class="dropdown d-inline userlink ml-5">
                      <a href="profile.php" class="userimage dropdown-toggle" data-toggle="dropdown"><?php echo $imguser["NickName"];?>  <?php 
                            if($count == 0){
                              echo "<img src='images/profile.png'>";
                            }else{
                              echo "<img src='" . $imguser['UserImage'] . "'>";
                            }
                      ?> 
                    </a>
                    <div class="dropdown-menu drop-user-info mt-3">
                      <a class="dropdown-item" href="profile.php?userid=<?php echo $sessionUserID; ?>">Profile</a>
                      <a class="dropdown-item" href="edit-profile.php">Edit Profile</a>
                      <a class="dropdown-item" href="newCourse.php">Create New Course</a>
                      <a class="dropdown-item" href="add-video.php">Add Videos</a>
                      <a class="dropdown-item" href="profile.php#courses">My Courses</a>
                      <a class="dropdown-item" href="logout.php">Exit <i class='fa fa-sign-out-alt fa-fw'></i></a>
                    </div>
                  </div>
            <?php 
            }else{
              echo '<a href="login.php"> <i class="fa fa-user p-2"></i> </a>';
            }
        ?>
      </form>
    </div>
    
  </div>
  <div class="search">
    <input type="submit" class="btn" value="Search">
    <input class="search" type="search">
  </div>
</nav>


<!-- 
====================
End Navbar Section
====================
-->