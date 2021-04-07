<?php
ob_start();
// Start Session
session_start();
$title = "Show Course";
$active = "";
include "inhi.php";

$videoid = isset($_GET['videoid']) && is_numeric(($_GET['videoid'])) ? intval($_GET['videoid']) : 0;
$courseid = isset($_GET['courseid']) && is_numeric(($_GET['courseid'])) ? intval($_GET['courseid']) : 0;
$stmt = $conn->prepare("SELECT video_list.*, courses.Approve FROM video_list 
                        INNER JOIN courses ON courses.Course_ID = video_list.Course_ID
                        WHERE Video_ID = ? AND courses.Approve = 1");
$stmt->execute(array($videoid));
$videos = $stmt->fetch();
if(!empty($videos)){
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
							<li> <a href="course.php?courseid=<?php echo $videos['Course_ID'];?>"> <i class="fa fa-chevron-right fa-fw"></i> Course</a> </li>
							<li><i class="fa fa-chevron-right fa-fw"></i> <?php echo $videos["Video_Name"]; ?></li>
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
<h1 class="course-name"><?php echo $videos["Video_Name"]; ?></h1>
<div class="container mb-5"> <!-- Start Container Bootstrap Class [ Container ] -->


<!-- 
==========================================================================
													Start Body's Page
==========================================================================
-->

<div class="row"> <!-- Start Div Class Bootstrap [ ROW ] -->
  <div class="col-3"> <!-- Start Div Class Bootstrap [ COL - 3 Left Section ] -->
    <div class="list-content"> <!-- Start Div Class Bootstrap [ list-content ] -->
    <div class="title">Play List:</div>
      <?php
          $stmt = $conn->prepare("SELECT * FROM video_list WHERE Course_ID = ?");
          $stmt->execute(array($courseid));
          $videos = $stmt->fetchAll();
          if(empty($videos)){
            echo "<h6 class='alert alert-light'>No Videos Here.</h6>";
          }else{
            foreach ($videos as $video) :
              $playing = "";
              if($video['Video_ID'] == $videoid){
                  $playing = "playing active";
              }
      ?>
      <div class="list mb-2">
            <div class="row">
                <div class="col-5 pr-2"> 
                    <a href="video-play.php?<?php echo "courseid=".$video["Course_ID"]."&videoid=".$video["Video_ID"];?>">
                      <video width="100%">
                        <source src="<?php echo $video["Video_Src"]; ?>" type="video/mp4">
                          Your browser does not support the video tag.
                      </video>
                    </a>
                </div>
                <div class="pl-2 col-7 video-name <?php echo $playing;?>"><a href="video-play.php?<?php echo "courseid=".$video["Course_ID"]."&videoid=".$video["Video_ID"];?>"> <?php echo $video["Video_Name"]; ?> </a> </div>
            </div>
      </div>
      <?php endforeach; } ?>
    </div> <!-- End Div Class [ list-content ] -->
  </div> <!-- End Div Class Bootstrap [ COL - 3 Left Section ] -->
<!--
**************************************************************************************************************************************************************************************************************************************************************************-->
  <div class="col-md-6">
    <div class="play">
<?php
          $stmt = $conn->prepare("SELECT video_list.*, courses.Tags FROM video_list 
                                  INNER JOIN courses ON courses.Course_ID = video_list.Course_ID
                                  WHERE Video_ID = ?");
          $stmt->execute(array($videoid));
          $video = $stmt->fetch();
          $tags = explode(',',$video['Tags']);
?>
              <div class=" ">
                  <video width="100%" controls autoplay >
                    <source src="<?php echo $video["Video_Src"]; ?>" type="video/mp4">
                      Your browser does not support the video tag.
                  </video>
                  <div class="body">
                    <h6><i class="fa fa-tags"></i> Tags</h6>
                    <div class="tags col-12"> <!--  Start Tags DIV  -->
                      <span> <i class="fa fa-tags"></i>
                          <?php
                                if(!empty($video['Tags'])){
                                  foreach ($tags as $tag) {
                                    echo '<a href="all-course.php?filter=Tag&name='. $tag .'"> '. strtoupper($tag) .' </a>';
                                  }
                                }else{
                                    echo "<span>NO Tags</span>";
                                }
                          ?>
                      </span>
                     </div> <!--  End Tags DIV  -->
                    <h3 class="description"><i class="fa fa-pen-nib"></i> Description:</h3>
                    <p class="desc">
                      <?php echo $video["Video_Desc"] ; ?>
                    </p>
                  </div>
              </div>
    </div>
  </div>
<!--
**************************************************************************************************************************************************************************************************************************************************************************-->
  <div class="col-3"> <!-- Start Div Class Bootstrap [ COL - 3 Left Section ] -->
    <div class="list-content"> <!-- Start Div Class Bootstrap [ list-content ] -->
    <div class="title">Popular Videos:</div>
      <?php
          $stmt = $conn->prepare("SELECT video_list.*, courses.Approve FROM video_list 
                                  INNER JOIN courses ON courses.Course_ID = video_list.Course_ID
                                  WHERE Video_ID <> ? AND courses.Approve = 1  LIMIT 6");
          $stmt->execute(array($videoid));
          $videos = $stmt->fetchAll();
          if(empty($videos)){
            echo "<h6 class='alert alert-light'>No Videos Here.</h6>";
          }else{
            foreach ($videos as $video) :
      ?>
      <div class="list mb-2">
            <div class="row">
                <div class="col-5 pr-2"> 
                    <a href="video-play.php?<?php echo "courseid=".$video["Course_ID"]."&videoid=".$video["Video_ID"];?>">
                      <video width="100%">
                        <source src="<?php echo $video["Video_Src"]; ?>" type="video/mp4">
                          Your browser does not support the video tag.
                      </video>
                    </a>
                </div>
                <div class="pl-2 col-7 video-name"><a href="video-play.php?<?php echo "courseid=".$video["Course_ID"]."&videoid=".$video["Video_ID"];?>"> <?php echo $video["Video_Name"]; ?> </a> </div>
            </div>
      </div>
      <?php endforeach; } ?>
    </div> <!-- End Div Class [ list-content ] -->
  </div> <!-- End Div Class Bootstrap [ COL - 3 Left Section ] -->

</div> <!-- End Div Class Bootstrap [ ROW ] -->
<!--
**************************************************************************************************************************************************************************************************************************************************************************-->
<div class="row">
  <div class="offset-md-3 col-md-6">
<div class="video-comment" id="video-comment">
<h3><i class="fa fa-comments"></i> Comments</h3>
<?php
$stmt = $conn->prepare("SELECT comments.* , users.UserName, users.UserImage FROM comments
												INNER JOIN users ON users.UserID = comments.User_ID
												WHERE Video_List_ID = ?
                        ORDER BY comments.Comment_Date DESC");
$stmt->execute(array($videoid));
$comments = $stmt->fetchAll();
if(!empty($comments)){
	foreach ($comments as $comment) :
?>
<div class="comment-list">
                          <div class="row">
                              <div class="col-3 pr-2">
                                  <img src="<?php echo $comment['UserImage']; ?>">
                              </div>
                              <div class="col-9 pl-2">
                                  <div class="title">
                                    <a class="name" href="userprofile.php?userid=<?php echo $comment['User_ID']; ?>"> <?php echo $comment['UserName']; ?></a>
                                    <span class="date float-right"> on <?php echo date('l j F Y', strtotime($comment['Comment_Date'])); ?></span>
                                  </div>
                                  <div class="body-comment">
                                    <p> <?php echo $comment['Comment']; ?> </p>
                                  </div>
                              </div>
                          </div>
</div>
  <?php endforeach; }?>
										<!-- End Comments -->

										<div class="add_comment_container">
												<div class="add_comment_title">Add a review</div>
<?php if(!isset($_SESSION["user"])){ ?>
												<div class="add_comment_text">You must be <a href="login.php">logged</a> in to post a comment.</div>
<?php }else{ ?>
												<form id="comment-video" class="pl-4 pr-4 mt-3" action="<?php echo $_SERVER['PHP_SELF']."?courseid=".$courseid."&videoid=".$videoid ;?>" method="POST">
														<textarea name="usercomment" class="input-group p-3" placeholder="Leave Your Comment" required></textarea>
														<input type="text" hidden value="<?= $sessionUserID;?>" class="userid">
														<input type="submit" hidden value="<?= $videoid;?>" class="videoid">
														<input type="submit" hidden value="<?= $courseid;?>" class="courseid">
														<input type="submit" value="Comment" class="btn btn-info mt-3">
												</form>
<?php } ?>
										</div>
									</div>
                </div>
   </div>
</div>
<!-- 
==========================================================================
													End Body's Page
==========================================================================
-->
<!-- End IF Else Statment To Check The Fetch Data -->
<?php }else{ echo "<h3 class='mt-5 alert alert-danger'>Sorry This Page Not Available</h3>"; } ?>
</div> <!-- End Container Bootstrap Class [ Container ] -->

<?php
include "template/footer.php";
ob_end_flush();
?>