<?php
ob_start();
// Start Session
session_start();
$title = "Show Course";
$active = "";
include "inhi.php";

$courseid = isset($_GET['courseid']) && is_numeric(($_GET['courseid'])) ? intval($_GET['courseid']) : 0;
$stmt = $conn->prepare("SELECT * FROM courses WHERE Course_ID = ?");
$stmt->execute(array($courseid));
$course = $stmt->fetch();
if(!empty($course)){
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
							<li> <a href="course-details.php?courseid=<?php echo $courseid;?>"> <i class="fa fa-chevron-right fa-fw"></i> Course-Details </a> </li>
							<li><i class="fa fa-chevron-right fa-fw"></i> <?php echo $course["Name"]; ?></li>
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
<div class="container mb-5 mt-5"> <!-- Start Container Bootstrap Class [ Container ] -->


<!-- 
==========================================================================
													Start Body's Page
==========================================================================
-->


<div class="row"> <!-- Start Div Class Bootstrab [ ROW ] -->

	<div class="col-md-3 bg-left"> <!-- Start Div Class Bootstrab [ COL - 3  FLOAT-LEFT ] -->
			<div class="cats"> <!-- Start Div Class [ CATS ] -->
						<form>
							<input class="search-videos" type="search" name="search" placeholder="Search">
						</form>
						<ul>
									<?php
									$stmt = $conn->prepare("SELECT * FROM categories");
									$stmt->execute();
									$cats = $stmt->fetchAll();
									if(empty($cats)){
										echo "<h6 class='alert alert-light'>No Categories Here.</h6>";
									}else{
										echo "<li> <span data-id='0'> All </span> </li>";
										foreach ($cats as $cat) :
									?>
											<li>
													<span data-id="<?= $cat['ID'];?>">
															<?php echo $cat['Name']; ?> 
													</span>
											</li>
									<?php endforeach; } ?>
						</ul>
			</div> <!-- End Div Class [ CATS ] -->
	</div> <!-- End Div Class Bootstrab [ COL - 3  FLOAT-LEFT ] -->

<!-- ************************* -->

  <div class="col-md-9 bg-right"> <!-- Start Div Class Bootstrab [ COL - 9  FLOAT-RIGTH ] -->
      <div class="view"> <!-- Start Div Class [ View ] -->
          <h3>Play List</h3>
          <div class="all-videos" id="ViewVideos"> <!-- Start Div Class [ All - Videos ] -->
              <div class="row"> <!-- Start Div Class Bootstrap [ ROW ] -->
										<?php
										$stmt = $conn->prepare("SELECT video_list.*, users.UserName, courses.Tags FROM video_list
																			INNER JOIN courses ON courses.Course_ID = video_list.Course_ID
																			INNER JOIN users ON users.UserID = video_list.User_ID
																			WHERE video_list.Course_ID = ?");
										$stmt->execute(array($courseid));
										$list = $stmt->fetchAll();
										if(empty($list)){
											echo "<h3 class='col-12 videos-msg'>No Videos In This List</h3>";
										}else{
											foreach ($list as $item) :
												$tags = explode(',',$item['Tags']);
										?>
										<div class="col-md-3"> <!-- Start Div Class Bootstrap [ COL - 3 ] -->
												<div class="single-video mb-3"> <!-- Start Div Class [ Single - Video ] -->

													<div class="preview"> <!-- Start Div Class [ Preview ] -->
															<a href="video-play.php?<?php echo "courseid=".$courseid."&videoid=".$item["Video_ID"];?>">
																	<video width="100%">
																		<source src="<?php echo $item["Video_Src"]; ?>" type="video/mp4">
																			Your browser does not support the video tag.
																	</video>
															</a>
													</div> <!-- End Div Class [ Preview ] -->

													<div class="data"> <!-- Start Div Class [ Date ] -->
															<div class="date">
																	<a class="float-left name" href="userprofile.php?userid=<?php echo $item['User_ID']; ?>"><?php echo $item["UserName"]; ?></a>
																	<span><?php echo date('j F Y', strtotime($item["Video_Date"])); ?></span> 
															</div>
															<h3>
																	<a href="video-play.php?<?php echo "courseid=".$courseid."&videoid=".$item["Video_ID"];?>"><?php echo $item["Video_Desc"]; ?> </a> 
															</h3>
															<div class="tags"> <!--  Start Tags DIV  -->
																<p> <i class="fa fa-tags"></i>
																		<?php
																				if(!empty($item['Tags'])){
																				foreach ($tags as $tag) {
																					echo '<span class="single-tag"> '. strtoupper($tag) .' </span>';
																				}
																				}else{
																					echo "<i>NO Tags</i>";
																				}
																		?>
																</p>
															</div> <!--  End Tags DIV  -->
													</div> <!-- End Div Class [ Date ] -->
												</div> <!-- End Div Class [ Single - Video ] -->
										</div> <!-- End Div Class Bootstrap [ COL - 3 ] -->
										<?php endforeach; } ?>
                </div> <!-- Start Div Class Bootstrap [ ROW ] -->
          </div> <!-- End Div Class [ All - Videos ] -->
			</div> <!-- End Div Class [ View ] -->
			
			<!-- *********************** -->

			<div class="view mt-4 mb-4"> <!-- Start Div Class [ View ] -->
          <h3>Popular Videos</h3>
          <div class="all-videos"> <!-- Start Div Class [ All - Videos ] -->
              <div class="row"> <!-- Start Div Class Bootstrap [ ROW ] -->
										<?php
										$stmt = $conn->prepare("SELECT video_list.*, users.UserName, courses.Tags FROM video_list
																			INNER JOIN courses ON courses.Course_ID = video_list.Course_ID
																			INNER JOIN users ON users.UserID = video_list.User_ID
																			WHERE courses.Approve = 1");
										$stmt->execute();
										$list = $stmt->fetchAll();
										$count = $stmt->rowCount();
										if(empty($list)){
											echo "<h6 class='alert alert-light'>No Videos In This List.</h6>";
										}else{
											foreach ($list as $item) :
												$tags = explode(',',$item['Tags']);
										?>
										<div class="col-md-3"> <!-- Start Div Class Bootstrap [ COL - 3 ] -->
												<div class="single-video mb-3"> <!-- Start Div Class [ Single - Video ] -->

													<div class="preview"> <!-- Start Div Class [ Preview ] -->
															<a href="video-play.php?<?php echo "courseid=".$courseid."&videoid=".$item["Video_ID"];?>">
																	<video width="100%">
																		<source src="<?php echo $item["Video_Src"]; ?>" type="video/mp4">
																			Your browser does not support the video tag.
																	</video>
															</a>
													</div> <!-- End Div Class [ Preview ] -->

													<div class="data"> <!-- Start Div Class [ Date ] -->
															<div class="date">
															<a class="float-left name" href="userprofile.php?userid=<?php echo $item['User_ID']; ?>"><?php echo $item["UserName"]; ?></a>
																	<span><?php echo date('j F Y', strtotime($item["Video_Date"])); ?></span> 
															</div>
															<h3>
																	<a href="video-play.php?<?php echo "courseid=".$courseid."&videoid=".$item["Video_ID"];?>"><?php echo $item["Video_Desc"]; ?> </a> 
															</h3>
															<div class="tags"> <!--  Start Tags DIV  -->
																<p> <i class="fa fa-tags"></i>
																		<?php
																				if(!empty($item['Tags'])){
																				foreach ($tags as $tag) {
																					echo '<span class="single-tag"> '. strtoupper($tag) .' </span>';
																				}
																				}else{
																					echo "<i>NO Tags</i>";
																				}
																		?>
																</p>
															</div> <!--  End Tags DIV  -->
													</div> <!-- End Div Class [ Date ] -->
												</div> <!-- End Div Class [ Single - Video ] -->
										</div> <!-- End Div Class Bootstrap [ COL - 3 ] -->
<?php endforeach; } ?>
                </div> <!-- Start Div Class Bootstrap [ ROW ] -->
          </div> <!-- End Div Class [ All - Videos ] -->
			</div> <!-- End Div Class [ View ] -->
			
  </div> <!-- End Div Class Bootstrab [ COL - 9  FLOAT-RIGHT ] -->

</div> <!-- End Div Class Bootstrab [ ROW ] -->

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