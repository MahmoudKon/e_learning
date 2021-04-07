<?php
ob_start();
// Start Session
session_start();
$title = "Profile";
$action = "";
$active = "";
include "inhi.php";
if(isset($_SESSION["user"])){
  
  $stmt = $conn->prepare("SELECT * FROM users WHERE UserName = ?");
  $stmt->execute(array($sessionUser));
  $userInfo = $stmt->fetch();
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
							<li><i class="fa fa-chevron-right fa-fw"></i> Profile [ <?php echo $userInfo["UserName"]; ?> ]</li>
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
<h1 class="headerTitle text-center" style="font-size: 30px;"> Welcome [ <?php echo $sessionUser; ?> ] In Your Profile </h1>
<div class="container"> <!-- Start Container Bootstrap Class [ Container ] -->
<!-- 
=====================================================================================================================================
                                               Start Information Section
=====================================================================================================================================
 -->
    <section  class="information"> <!-- Start Section Class [ Information ] -->
          <div class="card mb-4"> <!-- Start Card Bootstrap Class [ Card ] -->

              <div class="card-header"> <!-- Start Card-header Bootstrap Class [ Header ] -->
                  <i class='fa fa-info-circle fa-fw'></i> Information
              </div> <!-- End Card-header Bootstrap Class [ Header ] -->

              <div class="card-body"> <!-- Start Card-Body Bootstrap Class [ ROW ] -->
                  <div class="row">
                      <div class="col-md-4">
                          <div class="avatar"> <img width="100%" src="<?php echo $userInfo['UserImage']; ;?>"> </div>
                      </div>
                      <div class="col-md-6 pt-4">
                        <div class="all-info">
                            <div class="information">
                              <span class="text">Name </span>: <span class="data"> <?php echo $userInfo['UserName']; ?> </span>
                            </div>
                            <div class="information">
                              <span class="text">Full Name </span>: <span class="data"> <?php echo $userInfo['FullName']; ?> </span>
                            </div>
                            <div class="information">
                              <span class="text">Email </span>: <span class="data"> <?php echo $userInfo['Email']; ?> </span>
                            </div>
                            <div class="information">
                              <span class="text">Country </span>: <span class="data"> <?php echo $userInfo['Country']; ?> </span>
                            </div>
                            <div class="information">
                              <span class="text">Phone </span>: <span class="data"> <?php echo $userInfo['Phone']; ?> </span>
                            </div>
                            <div class="information">
                              <span class="text">Gender </span>: <span class="data"> <?php echo $userInfo['Gender']; ?> </span>
                            </div>
                            <div class="information">
                              <?php if($userInfo['Admin'] > 0): ?>
                                <span class="admin">Admin</span>
                              <?php endif; ?>
                            </div>
                            <!-- Button to Open the Modal -->
                            <a type="button" class="float-right btn btn-primary" href="edit-profile.php">
                              <i class="fa fa-edit"></i> Edit Info
                            </a>
                        </div>
                      </div>
                      <div class="col-md-2 pt-4">
                        <ul class="social">
                          <h6> <i class="fas fa-share-alt fa-fw"></i> Social Link </h6>
                          <li> <a href="#"> <i class="fab fa-facebook-f fa-fw"></i> FaceBook</a> </li>
                          <li> <a href="#"> <i class="fab fa-twitter fa-fw"></i> Twitter</a> </li>
                          <li> <a href="#"> <i class="fab fa-google fa-fw"></i> Google</a> </li>
                          <li> <a href="#"> <i class="fab fa-instagram fa-fw"></i> Instagram</a> </li>
                        </ul>
                      </div>
                  </div> <!-- End Card-Body Bootstrap Class [ ROW ] -->
              </div> <!-- End Card-Body Bootstrap Class [ Body ] -->

          </div> <!-- End Card-Body Bootstrap Class [ Card ] -->
    </section> <!-- End Section Class [ Information ] -->
<!-- 
=====================================================================================================================================
                                                    Start Courses Section
=====================================================================================================================================
 -->
<section  class="Courses" id="courses"> <!-- Start Section Class [ Courses ] -->
  <div class="card mb-4"> <!-- Start Card Bootstrap Class [ Card ] -->

      <div class="card-header"> <!-- Start Card-header Bootstrap Class [ Header ] -->
          <i class='fa fa-book-reader fa-fw'></i> Latest Courses
      </div> <!-- End Card-header Bootstrap Class [ Header ] -->

      <div class="card-body" id="ViewCourses"> <!-- Start Card-Body Bootstrap Class [ Body ] -->

      <div class="row"> <!-- Start Div Class [ Row ] -->
  <?php
      $courses = getCourses("User_ID", $userInfo['UserID'],"0" ,"LIMIT 6");
      
      if(empty($courses)){
        echo "<h5 class='text-center alert alert-info'> Sorry No Courses To Display IT !! </h5>";
      }else{
        foreach ($courses as $course): 
            $tags = explode(',',$course['Tags']);
            $rand = $animation[ rand(0, count($animation)-1) ];
          ?>
          <div class="col-12 col-lg-4 mb-4">  <!--  Start Grid DIV  -->
            <div class="card wow <?php echo  $rand;?>"> <!--  Start card DIV  -->
              <div class="card-price-img">
                  <span class="approve <?php if($course['Approve'] != 0){ echo "d-none"; } ?>">Waiting For Approval</span>
                  <img class="card-img-top" src="<?php echo $course['Img']; ?>" alt="Card image cap">
                  <div class="price">
                        <span> <?php $price = ($course['Price'] == 0) ? "FREE" : "$".$course['Price']; echo $price ?></span>
                  </div>
              </div>

              <div class="card-block"> <!--  Start card-block DIV  -->
                  <h4 class="card-title">
                    <a href='course.php?courseid=<?=$course["Course_ID"];?>'><?= $course['Name'];?></a>
                    <span class="date"> <i class="far fa-clock"></i> <?php echo date('l j F Y', strtotime($course["Add-Date"])); ?></span>
                  </h4>
                  <div class="card-text">
                      <h5 class="desc"> <i class="fa fa-pen-nib"></i> Description:</h5>
                      <p> <?php echo $course['Course_Describe']; ?> </p>
                  </div>
                  <div class="card-footer">
                      <div class="row">
                      <div class="student col-6 pr-0">
                            <span> <i class="fa fa-graduation-cap"></i> <?php echo $course['Registered']; ?>  Student</span>
                        </div>
                        <div class="student col-3 p-0">
                            <span> <i class="fa fa-comments"></i> <?php echo countComment($course['Course_ID']); ?> </span>
                        </div>
                        <div class="rating col-3 pl-0 text-right">
                            <span><?php for($i = 1;$i<=$course['Rating'];$i++){ echo "<i class='fa fa-star'></i>" ;} if($course['Rating'] == 0){echo "0 Rating";} ?> </span>
                        </div>
                      </div>
                  </div>
                  <div class="tags col-12"> <!--  Start Tags DIV  -->
                      <span> <i class="fa fa-tags"></i>
                          <?php
                                if(!empty($course['Tags'])){
                                  foreach ($tags as $tag) {
                                    echo '<a href="all-course.php?filter=Tag&name='. $tag .'"> '. strtoupper($tag) .' </a>';
                                  }
                                }else{
                                    echo "<span>NO Tags</span>";
                                }
                          ?>
                      </span>
                  </div> <!--  End Tags DIV  -->
              </div> <!--  End card-block DIV  -->

              <a href="course-details.php?courseid=<?php echo $course['Course_ID']; ?>" class="info">More Information</a>
            </div> <!--  End card DIV  -->
          </div>  <!--  End Grid DIV  -->
          <?php endforeach; ?>
          </div> <!-- End Div Class [ Row ] -->
          <div class="mb-4 text-center">
            <button id="view-Courses" class="btn btn-info"> View All Courses </button>
            <input id="course-userid" hidden value="<?= $sessionUserID;?>">
          </div>
          <?php } ?>
    </div> <!-- End Card-Body Bootstrap Class [ Body ] -->
  </div> <!-- End Card-Body Bootstrap Class [ Card ] -->
</section> <!-- End Section Class [ Courses ] -->
<!-- 
=====================================================================================================================================
                                                    Start Comments Section
=====================================================================================================================================
 -->

 <!-- 
=====================================================================================================================================
                                                    Start Posts Section
=====================================================================================================================================
 -->
<section class="posts"> <!-- Start Section Class [ posts ] -->
  <div class="card post mb-4"> <!-- Start Card Bootstrap Class [ Card ] -->
      <div class="card-header"> <!-- Start Card-header Bootstrap Class [ Header ] -->
          <i class='fa fa-book-reader fa-fw'></i> Latest Posts
      </div> <!-- End Card-header Bootstrap Class [ Header ] -->
      <div class="card-body" id="profile-posts"> <!-- Start Card-Body Bootstrap Class [ Body ] -->
        <div class="row"> <!-- Start Div Class [ Row ] -->
          <?php
            $stmt = $conn->prepare("SELECT posts.*, users.UserName, users.UserImage, categories.Name FROM posts
                                    INNER JOIN users ON users.UserID = posts.User_ID
                                    INNER JOIN categories ON categories.ID = posts.Cat_ID
                                    WHERE User_ID = ?
                                    ORDER BY `PostID` DESC
                                    LIMIT 6");
            $stmt->execute(array($sessionUserID));
            $posts = $stmt->fetchAll();
            if(empty($posts)){
              echo "<h5 class='text-center alert alert-info'> Sorry No Posts To Display IT !! </h5>";
            }else{
              foreach($posts as $post) :
          ?>
              <div class="col-4">
                <div class="post">
                  <div class="card">
                    <div class="card-header pt-0 pb-0 pr-0 pl-0"> <img width="100%" src="<?= $post['Post_File'];?>"> </div>
                    <div class="card-body pt-0">
                      <span>on <?= date('l j F Y', strtotime($post["Post_Date"])); ?></span>
                      <h5> <a href="full-post.php?post=<?= $post["PostID"];?>"> <?= $post["Post_Title"];?> </a> </h5>
                      <span class="post-approve <?php if($post['Post_Approve'] != 0){ echo "d-none"; } ?>">Waiting For Approve</span>
                    </div>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
            </div> <!-- End Div Class [ Row ] -->
            <div class="mb-4 text-center">
              <button id="view-posts" class="btn btn-info"> View All Posts </button>
              <input id="post-userid" hidden value="<?= $sessionUserID;?>">
            </div>
            <?php }?>
      </div> <!-- End Card-Body Bootstrap Class [ Body ] -->
  </div> <!-- End Card Bootstrap Class [ Card ] -->
</section> <!-- End Section Class [ posts ] -->
 <!-- 
=====================================================================================================================================
                                                    Start Posts Section
=====================================================================================================================================
 -->
</div> <!-- End Container Bootstrap Class [ Container ] -->

<?php
}else{ header("Location: login.php");  exit(); }
include "template/footer.php";
ob_end_flush();
?>