<?php
ob_start();
$title = "Courses";
$active = "";
include "inhi.php";
$link = "";
$title = "";
$filter = $_GET["filter"];
if($filter == "All"){
  $link = "all-Courses";
  $title = "all-Courses";
  $courses = getAllCourses();
}elseif($filter == "Tag"){
  $link = "Tag [ " . $_GET['name'] . " ]";
  $title = "Filter By Tag Name [ " . $_GET['name'] . " ]";
  $tag = $_GET['name'];
  $courses = filterByTags("AND Tags LIKE '%$tag%'");
}elseif($filter == "Course"){
  $link = "all-Courses";
  $id = $_GET["userid"];
  $courses = getCourses("User_ID", $id,1 ,"");
}
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
							<li> <i class="fa fa-chevron-right fa-fw"></i> <?php echo $link; ?> </li>
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
<div class="popular"> <!-- Start Parent DIV -->

  <div class="container"> <!-- Start Container DIV -->
<h1 class="text-center headerTitle"> <?php echo $title;?> </h1>
    <div class="row"> <!--  Start Row DIV  -->
<?php
if(! empty($courses)){
$delay = 0;
foreach( $courses as $course ){
  $tags = explode(',',$course['Tags']);
  $delay += .1;
  $rand = $animation[ rand(0, count($animation)-1) ];
?>
      <div class="col-12 col-lg-4 mb-4">  <!--  Start Grid DIV  -->
        <div class="card wow <?php echo  $rand;?>" data-wow-delay="<?php echo  $delay . "s";?>"> <!--  Start card DIV  -->
          <div class="card-price-img">
              <img class="card-img-top" src="<?php echo $course['Img']; ?>" alt="Card image cap">
              <div class="price">
                    <span> <?php $price = ($course['Price'] == 0) ? "FREE" : "$".$course['Price']; echo $price ?></span>
              </div>
          </div>
          <div class="card-block"> <!--  Start card-block DIV  -->
              <h4 class="card-title">
                  <?php
                    if($course == 0){
                      echo "<a href='course.php?courseid=".$course["Course_ID"]."'>".$course['Name']."</a> ";
                    }else{
                      echo "<a href='course-details.php?courseid=".$course["Course_ID"]."'>".$course['Name']."</a> ";
                    }
                  ?>
                <span class="date"> <i class="far fa-clock"></i> <?php echo date('l j F Y', strtotime($course["Add-Date"])); ?></span>
              </h4>
              <h5 class="card-title"><a href="userprofile.php?userid=<?php echo $course['User_ID']; ?>"> Mr. <?php echo $course['UserName']; ?> </a></h5>
              <div class="card-text">
                  <h5 class="desc"> <i class="fa fa-pen-nib"></i> Description:</h5>
                  <p> <?php echo $course['Course_Describe']; ?> </p>
              </div>
              <div class="card-footer">
                  <div class="row">
                    <div class="student col-5">
                        <span> <i class="fa fa-graduation-cap"></i> <?php echo $course['Registered']; ?>  Student</span>
                    </div>
                    <div class="student col-2">
                        <span> <i class="fa fa-comments"></i> <?php echo countComment($course['Course_ID']); ?> </span>
                    </div>
                    <div class="rating col-4 pr-0 text-right">
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
          </div>
          <a href="course-details.php?courseid=<?php echo $course['Course_ID']; ?>" class="info">More Information</a>
        </div> <!--  End card DIV  -->
      </div>  <!--  End Grid DIV  -->
    <?php } ?>  
<?php
}else{
    echo "<h6 class='alert alert-danger col-12'> No Courses To Display IT.</h6>";
}?>
    </div>  <!--  End Row DIV  -->
  </div>  <!--  End Container DIV  -->
</div> <!-- End Parent DIV -->
<?php 
include "template/footer.php";
ob_end_flush();
?>