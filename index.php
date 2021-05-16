<?php
ob_start();
// Start Session
session_start();
$title = "Home";
$active = "Home";
include "inhi.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){
  $name    = FILTER_var( $_POST["name"] , FILTER_SANITIZE_STRING );
  $email   = filter_var( $_POST["email"] , FILTER_SANITIZE_EMAIL );
  $phone   = FILTER_var( $_POST["phone"] , FILTER_SANITIZE_NUMBER_INT );
  $massage = FILTER_var( $_POST["massage"] , FILTER_SANITIZE_STRING );
  $subject = $_POST["subject"];
}
?>

<!-- 
======================
Start Section Carousel
======================
-->
<div id="option">
  <form>
    <label class="upload">Navbar BG Color</label>
    <input type="color" data-name="nav" data-place="bg" class="input-group"/>
    <label class="upload">Navbar Color</label>
    <input type="color" data-name="a" data-place="color" class="input-group"/>

    <label class="upload">h1 BG Color</label>
    <input type="color" data-name="h1" data-place="bg" class="input-group"/>
    <label class="upload">h1 Color</label>
    <input type="color" data-name="h1" data-place="color" class="input-group"/>

    <label class="upload">p BG Color</label>
    <input type="color" data-name="p" data-place="bg" class="input-group"/>
    <label class="upload">p Color</label>
    <input type="color" data-name="p" data-place="color" class="input-group"/>

    <label class="upload">icone BG Color</label>
    <input type="color" data-name="i" data-place="bg" class="input-group"/>
    <label class="upload">icone Color</label>
    <input type="color" data-name="i" data-place="color" class="input-group"/>
  </form>
  <i class="fas fa-cog"></i>
</div>


<div id="demo" class="carousel slide" data-ride="carousel">

  <!-- Indicators -->
  <ul class="carousel-indicators">
    <li data-target="#demo" data-slide-to="0" class="active"></li>
    <li data-target="#demo" data-slide-to="1"></li>
    <li data-target="#demo" data-slide-to="2"></li>
    <li data-target="#demo" data-slide-to="3"></li>
  </ul>

  <!-- The slideshow -->
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="images/carousel_4.jpg" alt="Los Angeles">
      <div class="carousel-caption">
        <h3>E-Learning</h3>
        <p>easy to use!</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="images/carousel_5.jpg" alt="Chicago">
      <div class="carousel-caption">
        <h3>E-Learning</h3>
        <p>Use at any time!</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="images/carousel_6.jpg" alt="New York">
      <div class="carousel-caption">
        <h3>E-Learning</h3>
        <p>Lots of sources!</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="images/carousel_7.jpg" alt="New York">
      <div class="carousel-caption">
        <h3>E-Learning</h3>
        <p>time saving!</p>
      </div>
    </div>

  </div>

  <!-- Left and right controls -->
  <a class="carousel-control-prev" href="#demo" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#demo" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>

</div>
<!-- 
======================
End Section Carousel
======================
-->


<!-- 
=========================
Start Section Information
=========================
-->

<div class="info"><!--  Start Parent DIV  -->

<div class="container">  <!--  Start Container DIV  -->

  <div class="info-title text-center mb-5">
      <h1>Welcome To Delta E-Learning</h1>
      <div class="row">
        <div class="col-xs-12 col-md-8 offset-md-2 mt-4">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel gravida arcu. Vestibulum feugiat, sapien ultrices fermentum congue, quam velit venenatis sem</p>
        </div>
    </div><!--  End Row DIV  -->
  </div><!--  End info-title DIV  -->

  <div class="info-items text-center"><!--  Start info-items DIV  -->
    <div class="row"><!--  Start Row DIV  -->

      <div class="col-12 col-sm-6 col-md-3 mb-5 mb-md-0">
        <div class="info-item"><!--  Start info-item DIV  -->
            <i class="fa fa-cogs fa-fw"></i>
            <h3 class="m-3">The Expert</h3>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit
            </p>
        </div><!--  Start info-item DIV  -->
      </div>


      <div class="col-12 col-sm-6 col-md-3 mb-5 mb-md-0">
        <div class="info-item"><!--  Start info-item DIV  -->
            <i class="fa fa-book fa-fw"></i>
            <h3 class="m-3">Book & Library</h3>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit
            </p>
        </div><!--  Start info-item DIV  -->
      </div>


      <div class="col-12 col-sm-6 col-md-3 mb-5 mb-md-0">
        <div class="info-item"><!--  Start info-item DIV  -->
            <i class="fa fa-code fa-fw"></i>
            <h3 class="m-3">Best Courses</h3>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit
            </p>
        </div><!--  Start info-item DIV  -->
      </div>


      <div class="col-12 col-sm-6 col-md-3 mb-5 mb-md-0">
        <div class="info-item"><!--  Start info-item DIV  -->
        <i class="fa fa-laptop"></i>
            <h3 class="m-3">Award & Reward</h3>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit
            </p>
        </div><!--  Start info-item DIV  -->
      </div>

    </div><!--  End Row DIV  -->
  </div><!--  End info-items DIV  -->

</div>  <!--  End Container DIV  -->

</div><!--  End Parent DIV  -->

<!-- 
=======================
End Section Information
=======================
-->

<!-- 
=========================
Start Section Popular 
=========================
-->

<div class="popular"> <!-- Start Parent DIV -->
  <div class="container"> <!-- Start Container DIV -->


    <div class="popular-title text-center mb-5">
        <h1>Popular Online Courses</h1>
        <div class="row">
          <div class="col-xs-12 col-md-8 offset-md-2 mt-4">
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel gravida arcu. Vestibulum feugiat, sapien ultrices fermentum congue, quam velit venenatis sem.</p>
          </div>
      </div><!--  End Row DIV  -->
    </div><!--  End Popular-title DIV  -->


    <div class="row"> <!--  Start Row DIV  -->

<?php 
  $stmt = $conn->prepare("SELECT courses.*, users.UserName FROM `courses`
                          INNER JOIN users ON users.UserID = courses.User_ID WHERE Approve = 1 LIMIT 3");
  $stmt->execute();
  $courses = $stmt->fetchAll();
  foreach ($courses as $course): 
    $tags = explode(',',$course['Tags']);
    $rand = $animation[ rand(0, count($animation)-1) ];
  ?>
  <div class="col-12 col-lg-4 mb-4">  <!--  Start Grid DIV  -->
    <div class="card wow <?php echo  $rand;?>"> <!--  Start card DIV  -->
      <div class="card-price-img">
          <img class="card-img-top" src="<?php echo $course['Img']; ?>" alt="Card image cap">
          <div class="price">
                <span> <?php $price = ($course['Price'] == 0) ? "FREE" : "$".$course['Price']; echo $price ?></span>
          </div>
      </div>
      <div class="card-block"> <!--  Start card-block DIV  -->
          <h4 class="card-title"> 
            <?php
              if($course['Price'] == 0){
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
              <div class="student col-6 pr-0">
                    <span> <i class="fa fa-graduation-cap"></i> <?php echo $course['Registered']; ?>  Student</span>
                </div>
                <div class="student col-2 p-0">
                    <span> <i class="fa fa-comments"></i> <?php echo countComment($course['Course_ID']); ?> </span>
                </div>
                <div class="rating col-4 pl-0 text-right">
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
      <a href="course-details.php?courseid=<?php echo urlencode($course['Course_ID']); ?>" class="info">More Information</a>

    </div> <!--  End card DIV  -->
  </div>  <!--  End Grid DIV  -->
<?php
endforeach; ?>
    </div> <!--  End Row DIV  -->

    <div class="row">
        <a href="all-course.php?filter=All" class="btn all-corses col-6 offset-3 col-md-4 offset-md-4 col-lg-2 offset-lg-5">View All Courses</a>
    </div>

  </div> <!-- End Container DIV -->
</div> <!-- End Parent DIV -->

<!-- 
=======================
End Section Popular 
=======================
-->


<!-- 
=======================
Start Section Register 
=======================
-->

<div class="register"><!-- Start Register DIV -->
<div class="container"><!-- Start Container DIV -->

    <div class="row"><!-- Start Row DIV -->
    
      <div class="col-12 col-md-6 pt-md-5"><!-- Start register-now DIV -->
        <div class="register-now pt-md-5">
          <h1 class="register-header pt-md-5">Register Now</h1>
          <p>Simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dumy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
          
          <div class="row text-center text-md-center mb-5 mb-md-5">
            <div class="col-6 col-md-3 mb-4 mb-md-0">
              <h1 class="register-numb register-like">0</h1>
              <span>Liks</span>
            </div>

            <div class="col-6 col-md-3 mb-4 mb-md-0">
              <h1 class="register-numb register-comm">0</h1>
              <span>Comments</span>
            </div>
            
            <div class="col-6 col-md-3 mb-4 mb-md-0">
              <h1 class="register-numb register-cats">0</h1>
              <span>Catigories</span>
            </div>

            <div class="col-6 col-md-3 mb-4 mb-md-0">
              <h1 class="register-numb register-curs">0</h1>
              <span>Courses</span>
            </div>

          </div>

        </div>
      </div><!-- Start register-now DIV -->
      
      <div class="col-12 col-md-6 offset-0 offset-md-0"><!-- Start Col DIV -->
        <div class="register-form"><!-- Start register-form DIV -->
            <form id="register-course-now" action="<?= $_SERVER['PHP_SELF'];?>" method="POST">
              <h1 class="form-header">COURSES NOW</h1>
              <div id="register-form-erorr"></div> <!-- Start / End DIV To View Errors -->
              <div class="form-group"> <input id="register-name" type="text" name="name" placeholder="Your Name :" > </div>
              <div class="form-group"> <input id="register-email" type="text" name="email" placeholder="Your Email :" > </div>
              <div class="form-group"> <input id="register-phone" type="text" name="phone" placeholder="Phone :" > </div>
              <div class="form-group"> 
                <select id="register-subject" name="subject">
                  <option value="0">Choose Subject</option>
                    <?php
                        $stmt = $conn->prepare("SELECT courses.* , categories.Name AS CatName FROM courses
                                                INNER JOIN categories ON categories.ID = courses.Categories_ID");
                        $stmt->execute();
                        $courses = $stmt->fetchAll();
                        foreach ($courses as $course) :
                          echo "<option value='" . $course["Course_ID"] . "'>" . $course["Name"] . "</option>";
                        endforeach;
                    ?>
                </select>
              </div>
              <div class="form-group"> <textarea id="register-msg" placeholder="Message :" name="massage" ></textarea> </div>
              <input class="m-25" type="submit" value="Submit Now">
            </form>
        </div><!-- Start register-form DIV -->
      </div><!-- Start Col DIV -->
    
    </div><!-- End Row DIV -->

  </div><!-- End Container DIV -->
</div><!-- End Register DIV -->

<!-- 
=======================
End Section Register 
=======================
-->

<!-- 
=======================
Start Section Upcoming  
=======================
-->

<div class="tutors ">  <!-- Start The Best Tutors Section Parent -->

<div class="container">  <!-- Start Container Section -->

    <div class="tutors-title text-center">  <!-- Start upcoming-title Section -->
      
        <h1>The Best Tutors in Town</h1>
        <div class="row">
          <p class="col-xs-12 col-md-8 offset-md-2 mt-4">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel gravida arcu. Vestibulum feugiat, sapien ultrices fermentum congue, quam velit venenatis sem
          </p>
        </div>
        
    </div>  <!-- End upcoming-title Section -->


    <div class="teachers">  <!-- Start Teacher Section -->
      <div class="row">  <!-- Start row Section -->

          <div class="col-12 col-sm-6 mb-5 mt-2 mb-md-0 col-md-3">
              <div class="text-center teacher">  <!-- Start teacher Section -->
                <img src="images/teacher_1.jpg">
                <div class="about-teacher">
                  <h4> <a href="#">Jacke Masito</a> </h4>
                  <p>Marketing & Management</p>
                  <a href="#"> <i class="fab fa-facebook-f fa-fw"></i> </a>
                  <a href="#"> <i class="fab fa-google fa-fw"></i> </a>
                  <a href="#"> <i class="fab fa-twitter fa-fw"></i> </a>
                </div>
              </div>  <!-- Start teacher Section -->
          </div>

          <div class="col-12 col-sm-6 mb-5 mt-2 mb-md-0 col-md-3">
              <div class="text-center teacher">  <!-- Start teacher Section -->
                <img src="images/teacher_2.jpg">
                <div class="about-teacher">
                  <h4> <a href="#">Jacke Masito</a> </h4>
                  <p>Marketing & Management</p>
                  <a href="#"> <i class="fab fa-facebook-f fa-fw"></i> </a>
                  <a href="#"> <i class="fab fa-google fa-fw"></i> </a>
                  <a href="#"> <i class="fab fa-twitter fa-fw"></i> </a>
                </div>
              </div>  <!-- Start teacher Section -->
          </div>

          <div class="col-12 col-sm-6 mb-5 mt-2 mb-md-0 col-md-3">
              <div class="text-center teacher">  <!-- Start teacher Section -->
                <img src="images/teacher_3.jpg">
                <div class="about-teacher">
                  <h4> <a href="#">Jacke Masito</a> </h4>
                  <p>Marketing & Management</p>
                  <a href="#"> <i class="fab fa-facebook-f fa-fw"></i> </a>
                  <a href="#"> <i class="fab fa-google fa-fw"></i> </a>
                  <a href="#"> <i class="fab fa-twitter fa-fw"></i> </a>
                </div>
              </div>  <!-- Start teacher Section -->
          </div>

          <div class="col-12 col-sm-6 mb-5 mt-2 mb-md-0 col-md-3">
              <div class="text-center teacher">  <!-- Start teacher Section -->
                <img src="images/teacher_4.jpg">
                <div class="about-teacher">
                  <h4> <a href="#">Jacke Masito</a> </h4>
                  <p>Marketing & Management</p>
                  <a href="#"> <i class="fab fa-facebook-f fa-fw"></i> </a>
                  <a href="#"> <i class="fab fa-google fa-fw"></i> </a>
                  <a href="#"> <i class="fab fa-twitter fa-fw"></i> </a>
                </div>
              </div>  <!-- Start teacher Section -->
          </div>

      </div>  <!-- End row Section -->
    </div>  <!-- End Teachers Section -->

</div>  <!-- End Container Section -->

</div>  <!-- End The Best Tutors Section Parent -->

<!-- 
=======================
End Section Upcoming  
=======================
-->




<?php
include "template/footer.php";
ob_end_flush();
?>