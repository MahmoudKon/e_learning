<?php
ob_start();
session_start();
$title = "Course Details";
$active = "Categories";
include "inhi.php";
$courseid = isset($_GET['courseid']) && is_numeric(($_GET['courseid'])) ? intval($_GET['courseid']) : 0;

$stmt = $conn->prepare("SELECT courses.*, users.UserName, users.UserImage, categories.Name AS Cat_Name FROM `courses`
												INNER JOIN users ON users.UserID = courses.User_ID
												INNER JOIN categories ON categories.ID = courses.Categories_ID
												WHERE Course_ID = ?");
$stmt->execute(array($courseid));
$details = $stmt->fetch();
$tags = explode(',',$details['Tags']);
if(empty($details)){
	echo "Sorry No Sutch ID..";
}else{
	$stmt = $conn->prepare("SELECT * FROM `cart` WHERE `CourseID` = ?");
	$stmt->execute(array($courseid));
	$row = $stmt->fetch();
?>

<link rel="stylesheet" type="text/css" href="css/course-details.css">


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
							<li><a href="categories.php?pageid=<?php echo $details["Categories_ID"];?>&pagename=<?php echo $details["Cat_Name"];?>"><i class="fa fa-chevron-right fa-fw"></i> Courses </a></li>
							<li><i class="fa fa-chevron-right fa-fw"></i> Course Details [ <?php echo $details["Name"]; ?> ] </li>
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
	<!-- Course -->

	<div class="course">
		<div class="container">
			<div class="row">

				<!-- Course -->
				<div class="col-lg-8">
					
					<div class="course_container">
						<div class="course_title">
								<?php
									echo $details["Name"]; 
									if($details["Price"] == 0 && ! empty($row)){
											echo "<a class='float-right mt-2 btn btn-primary' href='course.php?courseid=".$details['Course_ID']."'>Start Course</a>" . $details["Price"];
									}else{
										if(isset($sessionUserID)){
											echo "<a class='float-right mt-2 btn btn-primary' id='sell' href='#' data-user='".$sessionUserID."' data-course='".$details['Course_ID']."'>
													Buy It
												</a>";
										}else{
											echo "<a class='float-right mt-2 btn btn-light' href='login.php' >Login To buy it...</a>";
										}
									}
								?>
						</div>

						<div class="course_info d-flex flex-lg-row flex-column align-items-lg-center align-items-start justify-content-start">

							<!-- Course Info Item -->
							<div class="course_info_item">
								<div class="course_info_title">Teacher:</div>
								<div class="course_info_text">
									<a href="userprofile.php?userid=<?php echo $details['User_ID']; ?>"><?php echo $details["UserName"]; ?></a>
								</div>
							</div>

							<!-- Course Info Item -->
							<div class="course_info_item">
								<div class="course_info_title">Reviews:</div>
								<div class="rating_r rating_r_4">
									<?php 
										for($i = 0 ; $i < $details["Rating"] ; $i++){
												echo "<i class='fa fa-star'></i>";
										}
										for($i = 5 ; $i > $details["Rating"] ; $i--){
												echo "<i class='far fa-star'></i>";
										}
									?>
								</div>
							</div>

							<!-- Course Info Item -->
							<div class="course_info_item">
								<div class="course_info_title">Categories:</div>
								<div class="course_info_text"><a href="#"><?php echo $details["Cat_Name"]; ?></a></div>
							</div>

						</div>

						<!-- Course Image -->
						<div class="course_image"><img width=100% src="<?php echo $details["Img"]; ?>" alt=""></div>

						<!-- Course Tabs -->
						<div class="course_tabs_container">
							<div class="tabs d-flex flex-row align-items-center justify-content-start">
								<div class="tab active">description</div>
								<div class="tab">curriculum</div>
								<div class="tab">reviews</div>
							</div>
							<div class="tab_panels">

								<!-- Description -->
								<div class="tab_panel active">
									<div class="tab_panel_title"><?php echo $details["Name"]; ?></div>
									<div class="tab_panel_content">
										<div class="tab_panel_text">
											<p>Lorem Ipsn gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auci elit consequat ipsutis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat auctor eu in elit. Class aptent taciti sociosquad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue. Sed non mauris vitae erat consequat auctor eu in elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue. Sed non neque elit. Sed ut imperdiet nisi. Proin condimentum fermentum nunc. Lorem Ipsn gravida nibh vel velit auctor aliquet. Class aptent taciti sociosquad litora torquent per conubia nostra, per inceptos himenaeos.</p>
										</div>
										<div class="tab_panel_section">
											<div class="tab_panel_subtitle">Requirements</div>
											<ul class="tab_panel_bullets">
												<li>Lorem Ipsn gravida nibh vel velit auctor aliquet. Class aptent taciti sociosquad litora torquent.</li>
												<li>Cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a.</li>
												<li>Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat.</li>
												<li>Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio.</li>
											</ul>
										</div>
										<div class="tab_panel_section">
											<div class="tab_panel_subtitle">What is the target audience?</div>
											<div class="tab_panel_text">
												<p>This course is intended for anyone interested in learning to master his or her own body.This course is aimed at beginners, so no previous experience with hand balancing skillts is necessary Aenean viverra tincidunt nibh, in imperdiet nunc. Suspendisse eu ante pretium, consectetur leo at, congue quam. Nullam hendrerit porta ante vitae tristique. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae.</p>
											</div>
										</div>
										<div class="tab_panel_faq" id="faq">
											<div class="tab_panel_title">FAQ</div>

											<!-- Accordions -->
											<div id="accordion" class="accordions">

												<div class="card">
													<div class="card-header">
														<a class="card-link" data-toggle="collapse" href="#collapseOne">
																Can I just enroll in a single course?
														</a>
													</div>
													<div id="collapseOne" class="collapse show" data-parent="#accordion">
														<div class="card-body">
																	Lorem ipsun gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auci elit consequat ipsutis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a.
														</div>
													</div>
												</div>

												<div class="card">
													<div class="card-header">
														<a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
																I'm not interested in the entire Specialization?
														</a>
													</div>
													<div id="collapseTwo" class="collapse" data-parent="#accordion">
														<div class="card-body">
																	Lorem ipsun gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auci elit consequat ipsutis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a.
														</div>
													</div>
												</div>

												<div class="card">
													<div class="card-header">
														<a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
																What is the refund policy?
														</a>
													</div>
													<div id="collapseThree" class="collapse" data-parent="#accordion">
														<div class="card-body">
																	Lorem ipsun gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auci elit consequat ipsutis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a.
														</div>
													</div>
												</div>

												<div class="card">
													<div class="card-header">
														<a class="collapsed card-link" data-toggle="collapse" href="#collapseFore">
																What background knowledge is necessary?
														</a>
													</div>
													<div id="collapseFore" class="collapse" data-parent="#accordion">
														<div class="card-body">
																	Lorem ipsun gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auci elit consequat ipsutis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a.
														</div>
													</div>
												</div>

												<div class="card">
													<div class="card-header">
														<a class="collapsed card-link" data-toggle="collapse" href="#collapseFive">
																Do i need to take the courses in a specific order?
														</a>
													</div>
													<div id="collapseFive" class="collapse" data-parent="#accordion">
														<div class="card-body">
																	Lorem ipsun gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auci elit consequat ipsutis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a.
														</div>
													</div>
												</div>

												</div> 
										</div>
									</div>
								</div>

								<!-- Curriculum -->
								<div class="tab_panel tab_panel_2">
									<div class="tab_panel_content">
										<div class="tab_panel_title"><?php echo $details["Name"]?></div>
										<div class="tab_panel_content">
											<div class="tab_panel_text">
												<p>Lorem Ipsn gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auci elit consequat ipsutis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio.</p>
											</div>

											<!-- Dropdowns -->

											<div class="card custom-card">
												<div class="card-custom-head"><i class="far fa-file-alt pr-1"></i> Lecture 1: Lorem Ipsn gravida nibh vel velit auctor aliquet.</div>
												<div class="card-body card-custom-body">Lorem Ipsn gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auci elit consequat ipsutis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus.</div>
											</div>

											<div class="card custom-card">
												<div class="card-custom-head"><i class="far fa-file-alt pr-1"></i> Lecture 2: Lorem Ipsn gravida nibh vel velit auctor aliquet.</div>
												<div class="card-body card-custom-body">Lorem Ipsn gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auci elit consequat ipsutis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus.</div>
											</div>

											<div class="card custom-card">
												<div class="card-custom-head"><i class="far fa-file-alt pr-1"></i> Lecture 3: Lorem Ipsn gravida nibh vel velit auctor aliquet.</div>
												<div class="card-body card-custom-body">Lorem Ipsn gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auci elit consequat ipsutis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus.</div>
											</div>

											<div class="card custom-card">
												<div class="card-custom-head"><i class="far fa-file-alt pr-1"></i> Lecture 4: Lorem Ipsn gravida nibh vel velit auctor aliquet.</div>
												<div class="card-body card-custom-body">Lorem Ipsn gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auci elit consequat ipsutis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus.</div>
											</div>

											<div class="card custom-card">
												<div class="card-custom-head"><i class="far fa-file-alt pr-1"></i> Lecture 5: Lorem Ipsn gravida nibh vel velit auctor aliquet.</div>
												<div class="card-body card-custom-body">Lorem Ipsn gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auci elit consequat ipsutis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus.</div>
											</div>

										</div>
									</div>
								</div>

								<!-- Reviews -->
								<div class="tab_panel tab_panel_3">
									<div class="tab_panel_title">Course Review</div>

									<!-- Rating -->
									<div class="review_rating_container">
										<div class="review_rating">
											<div class="review_rating_num">4.5</div>
											<div class="review_rating_stars">
												<div class="rating_r rating_r_4"><i></i><i></i><i></i><i></i><i></i></div>
											</div>
											<div class="review_rating_text">(28 Ratings)</div>
										</div>
										<div class="review_rating_bars">
											<ul>
												<li><span>5 Star</span><div class="review_rating_bar"><div style="width:90%;"></div></div></li>
												<li><span>4 Star</span><div class="review_rating_bar"><div style="width:75%;"></div></div></li>
												<li><span>3 Star</span><div class="review_rating_bar"><div style="width:32%;"></div></div></li>
												<li><span>2 Star</span><div class="review_rating_bar"><div style="width:10%;"></div></div></li>
												<li><span>1 Star</span><div class="review_rating_bar"><div style="width:3%;"></div></div></li>
											</ul>
										</div>
									</div>
									
									<!-- Comments -->
									<div class="comments_container">
										<ul class="comments_list" id="comm-list">
<?php
$stmt = $conn->prepare("SELECT course_comment.*, users.UserName, users.UserImage, courses.Name
								FROM `course_comment`
								INNER JOIN users ON users.UserID = course_comment.User_ID 
								INNER JOIN courses ON courses.Course_ID = course_comment.Course_ID 
								WHERE course_comment.Course_ID = ?");
$stmt->execute(array($details["Course_ID"]));
$comments = $stmt->fetchAll();
if(!empty($comments)){
	foreach ($comments as $comment) {
?>
											<li>
												<div class="comment_item d-flex flex-row align-items-start jutify-content-start">
													<div class="comment_image"><div><img src="<?php echo $comment['UserImage'] ;?>" alt=""></div></div>
													<div class="comment_content">
														<div class="comment_title_container d-flex flex-row align-items-center justify-content-start">
															<div class="comment_author"><a href="#"><?php echo $comment['UserName'] ;?></a></div>
															<div class="comment_rating"><div class="rating_r rating_r_4"><i></i><i></i><i></i><i></i><i></i></div></div>
															<div class="comment_time ml-auto"><?php echo date('l j F Y', strtotime($comment['Date'])) ;?></div>
														</div>
														<div class="comment_text">
															<p><?php echo $comment['Comment'] ;?>.</p>
														</div>
														<div class="comment_extras d-flex flex-row align-items-center justify-content-start">
															<div class="comment_extra comment_likes"><a href="#"><i class="far fa-heart" aria-hidden="true"></i><span>15</span></a></div>
														</div>
													</div>
												</div>
											</li>
<?php } }?>
										</ul>
										<!-- End Comments -->

										<div class="add_comment_container">
												<div class="add_comment_title">Add a review</div>
<?php if(!isset($_SESSION["user"])){ ?>
												<div class="add_comment_text">You must be <a href="login.php">logged</a> in to post a comment.</div>
<?php }else{ ?>
												<form class="pl-4 pr-4 mt-3" action="" method="POST" id="fomt-comm-list">
														<textarea id="usercomment" class="input-group p-3" placeholder="Leave Your Comment" required></textarea>
														<input type="submit" value="Comment" class="btn btn-info mt-3">
														<input type="text" hidden id="comm-user" value="<?= $sessionUserID;?>">
														<input type="text" hidden id="comm-course" value="<?= $details["Course_ID"];?>">
												</form>
<?php }?>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>

				<!-- Course Sidebar -->
				<div class="col-lg-4">
					<div class="sidebar">

						<!-- Feature -->
						<div class="sidebar_section">
							<div class="sidebar_section_title">Course Feature</div>
							<div class="sidebar_feature">
								<div class="course_price">$<?php echo $details["Price"]; ?></div>

								<!-- Features -->
								<div class="feature_list">

									<!-- Feature -->
									<div class="feature d-flex flex-row align-items-center justify-content-start">
										<div class="feature_title"><i class="far fa-clock"></i><span>Duration:</span></div>
										<div class="feature_text ml-auto">2 weeks</div>
									</div>

									<!-- Feature -->
									<div class="feature d-flex flex-row align-items-center justify-content-start">
										<div class="feature_title"><i class="far fa-file-alt"></i><span>Lectures:</span></div>
										<div class="feature_text ml-auto">10</div>
									</div>

									<!-- Feature -->
									<div class="feature d-flex flex-row align-items-center justify-content-start">
										<div class="feature_title"><i class="fa fa-question-circle" aria-hidden="true"></i><span>Lectures:</span></div>
										<div class="feature_text ml-auto">6</div>
									</div>

									<!-- Feature -->
									<div class="feature d-flex flex-row align-items-center justify-content-start">
										<div class="feature_title"><i class="fa fa-list-alt" aria-hidden="true"></i><span>Lectures:</span></div>
										<div class="feature_text ml-auto">Yes</div>
									</div>

									<!-- Feature -->
									<div class="feature d-flex flex-row align-items-center justify-content-start">
										<div class="feature_title"><i class="fa fa-users" aria-hidden="true"></i><span>Lectures:</span></div>
										<div class="feature_text ml-auto">35</div>
									</div>

								</div>
							</div>
						</div>

						<!-- Feature -->
						<div class="sidebar_section">
							<div class="sidebar_section_title">Teacher</div>
							<div class="sidebar_teacher">
								<div class="teacher_title_container d-flex flex-row align-items-center justify-content-start">
									<div class="teacher_image"><img style="height: 102px; width: 100%" src="<?php echo $details['UserImage']; ?>" alt=""></div>
									<div class="teacher_title">
										<div class="teacher_name">
										<a href="userprofile.php?userid=<?php echo $details['User_ID']; ?>"><?php echo $details["UserName"]; ?></a>
										</div>
										<div class="teacher_position">Marketing & Management</div>
									</div>
								</div>
								<div class="teacher_meta_container">
									<!-- Teacher Rating -->
									<div class="teacher_meta d-flex flex-row align-items-center justify-content-start">
										<div class="teacher_meta_title">Average Rating:</div>
										<div class="teacher_meta_text ml-auto"><span>4.7</span><i class="fa fa-star" aria-hidden="true"></i></div>
									</div>
									<!-- Teacher Review -->
									<div class="teacher_meta d-flex flex-row align-items-center justify-content-start">
										<div class="teacher_meta_title">Review:</div>
										<div class="teacher_meta_text ml-auto"><span>12k</span><i class="fa fa-comment" aria-hidden="true"></i></div>
									</div>
									<!-- Teacher Quizzes -->
									<div class="teacher_meta d-flex flex-row align-items-center justify-content-start">
										<div class="teacher_meta_title">Quizzes:</div>
										<div class="teacher_meta_text ml-auto"><span>600</span><i class="fa fa-user" aria-hidden="true"></i></div>
									</div>
								</div>
								<div class="teacher_info">
									<p>Hi! I am Masion, I’m a marketing & management  eros pulvinar velit laoreet, sit amet egestas erat dignissim. Sed quis rutrum tellus, sit amet viverra felis. Cras sagittis sem sit amet urna feugiat rutrum nam nulla ipsum.</p>
								</div>
							</div>
						</div>

<!-- ============================================================================================================================ -->
<!-- 
===================
Start Latest Course
===================
 -->
 <div class="sidebar_section latests">
		<div class="sidebar_section_title">Latest Courses</div>
				<div class="sidebar_latest">
<?php
$stmt = $conn->prepare("SELECT * FROM `courses` WHERE Approve = 1 ORDER BY Course_ID DESC LIMIT 3");
$stmt->execute();
$rows = $stmt->fetchAll();
	foreach ($rows as $row) :
?>
								<!-- Latest Course -->
								<div class="latest d-flex flex-row align-items-start justify-content-start">
									<div class="latest_image"><div><img src="<?= $row['Img']; ?>" alt=""></div></div>
									<div class="latest_content">
										<div class="latest_title"><a href="course-details.php?courseid=<?= $row['Course_ID'] ?>"><?= $row['Name']; ?></a></div>
										<div class="latest_price">
												<span class="price"><?php $price = ($row['Price'] == 0) ? "FREE" : "$ ". $row['Price']; echo $price ?></span>
										</div>
									</div>
								</div>
<?php endforeach; ?>
			</div>
		</div>
		 <!-- ============================================================================================================================ -->
<!-- 
===================
Start Tags
===================
 -->
 <div class="sidebar_section latests">
		<div class="sidebar_section_title">Tags</div>
			<div class="sidebar_latest">
					<div class="tags col-12"> <!--  Start Tags DIV  -->
						<span>
							<?php
									if(!empty($details['Tags'])){
										foreach ($tags as $tag) {
											echo '<a href="all-course.php?filter=Tag&name='. $tag .'"> '. strtoupper($tag) .' </a>';
										}
									}else{
											echo "<span>NO Tags</span>";
									}
							?>
						</span>
					</div> <!--  End Tags DIV  -->
			</div>
		</div>
</div>
<!-- 
===================
End Tags
===================
 -->
</div>
<!-- 
===================
End Latest Course
===================
 -->
				</div>
			</div>
		</div>
	</div>

<?php 
}
include "template/footer.php";
ob_end_flush();
?>
<script src="js/course-details.js"></script>
