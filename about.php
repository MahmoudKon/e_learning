<?php
ob_start();
session_start();
$title = "About";
$active = "About";
include "inhi.php";
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
							<li><i class="fa fa-chevron-right fa-fw"></i> About</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
</div>
<!--
=======================
End Section Back Link
======================= 
-->


<!--
=======================
Start Section Welcome
======================= 
-->

<section class="info"> <!-- Start Section Class [ Welcome ] -->
<div class="container">  <!--  Start DIV Class [ Container ]  -->

  <div class="info-title text-center mb-5">
      <h1>Welcome To Delta E-Learning</h1>
      <div class="row">
        <div class="col-xs-12 col-md-8 offset-md-2 mt-4">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel gravida arcu. Vestibulum feugiat, sapien ultrices fermentum congue, quam velit venenatis sem</p>
        </div>
    </div><!--  End Row DIV  -->
  </div><!--  End info-title DIV  -->

  <div class="info-items"><!--  Start info-items DIV  -->
    <div class="row"><!--  Start Row DIV  -->

    <!-- First Div [ Left ] -->
      <div class="col-12 col-sm-6 col-md-4"> <!--  Start DIV Class [ Col-4 ] -->
          <div class="card"> <!--  Start DIV Class Bootstrab [ Card ]  -->
            <div class="card-img"> <img class="card-img-top" src="images/about_1.jpg" alt="Card image"> </div>
            <div class="card-body">
              <h4 class="card-title">Our Stories</h4>
              <p class="card-desc">
                      Lorem ipsum dolor sit , consectet adipisi elit, sed do eiusmod tempor for enim en consectet       adipisi elit, sed doconsectet adipisi elit, sed doadesg.
              </p>
            </div>
          </div> <!--  End DIV Class Bootstrab [ Card ]  -->
      </div> <!--  End DIV Class [ Col-4 ] -->

    <!-- Second Div [ Center ] -->
      <div class="col-12 col-sm-6 col-md-4"> <!--  Start DIV Class [ Col-4 ] -->
          <div class="card"> <!--  Start DIV Class Bootstrab [ Card ]  -->
            <div class="card-img"> <img class="card-img-top" src="images/about_2.jpg" alt="Card image"> </div>
            <div class="card-body">
              <h4 class="card-title">Our Mission</h4>
              <p class="card-desc">
                      Lorem ipsum dolor sit , consectet adipisi elit, sed do eiusmod tempor for enim en consectet adipisi elit, sed do consectet adipisi elit, sed doadesg.
              </p>
            </div>
          </div> <!--  End DIV Class Bootstrab [ Card ]  -->
      </div> <!--  End DIV Class [ Col-4 ] -->

    <!-- Second Div [ Center ] -->
      <div class="col-12 col-sm-6 col-md-4"> <!--  Start DIV Class [ Col-4 ] -->
          <div class="card"> <!--  Start DIV Class Bootstrab [ Card ]  -->
            <div class="card-img"> <img class="card-img-top" src="images/about_1.jpg" alt="Card image"> </div>
            <div class="card-body">
              <h4 class="card-title">Our Vision</h4>
              <p class="card-desc">
                      Lorem ipsum dolor sit , consectet adipisi elit, sed do eiusmod tempor for enim en consectet adipisi elit, sed do consectet adipisi elit, sed doadesg.
              </p>
            </div>
          </div> <!--  End DIV Class Bootstrab [ Card ]  -->
      </div> <!--  End DIV Class [ Col-4 ] -->
      

    </div><!--  End Row DIV  -->
  </div><!--  End info-items DIV  -->


</div>  <!--  End DIV Class [ Container ]  -->
</section> <!-- End Section Class [ Welcome ] -->

<!--
=======================
End Section Welcome
======================= 
-->


<!--
=======================
Start Section Choose Us
======================= 
-->

<section class="choose-us"> <!-- Start Section Class [ Choose - Us ] -->
<div class="container">  <!--  Start DIV Class [ Container ]  -->

    <div class="choose-us-title text-center mb-5">
        <h1>Welcome To Delta E-Learning</h1>
        <div class="row">
          <div class="col-xs-12 col-md-8 offset-md-2 mt-4">
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel gravida arcu. Vestibulum feugiat, sapien ultrices fermentum congue, quam velit venenatis sem</p>
          </div>
      </div><!--  End Row DIV  -->
    </div> <!--  End info-title DIV  -->

    <div class="row"> <!--  Start DIV Class Bootstrap [ ROW ] -->
    <!-- First DIV [ Left ] -->
        <div class="col-12 col-md-6">
        <div id="accordion">
        <!-- Card Number [ 1 ] -->
            <div class="card">
              <div class="card-header" data-toggle="collapse" href="#collapseOne">
                    Award for Best Academy 2019
              </div>
              <div id="collapseOne" class="collapse show" data-parent="#accordion">
                <div class="card-body">
                      Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                </div>
              </div>
            </div>
        <!-- Card Number [ 2 ] -->
            <div class="card">
              <div class="card-header collapsed" data-toggle="collapse" href="#collapseTwo">
                    You’re learning from the best.
              </div>
              <div id="collapseTwo" class="collapse" data-parent="#accordion">
                <div class="card-body">
                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                </div>
              </div>
            </div>
        <!-- Card Number [ 3 ] -->
            <div class="card">
              <div class="card-header collapsed" data-toggle="collapse" href="#collapseThree">
                    Our degrees are recognized worldwide.
              </div>
              <div id="collapseThree" class="collapse" data-parent="#accordion">
                <div class="card-body">
                      Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                </div>
              </div>
            </div>

        <!-- Card Number [ 3 ] -->
            <div class="card">
              <div class="card-header collapsed" data-toggle="collapse" href="#collapseFour">
                    We encourage our students to go global.
              </div>
              <div id="collapseFour" class="collapse" data-parent="#accordion">
                <div class="card-body">
                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                </div>
              </div>
            </div>

            </div> <!--  Start DIV ID Bootstrap [ Accordion ] -->
        </div> <!--  Start DIV Class Bootstrap [ Col - 6 ] -->

        <div class="col-12 col-md-6"> <!--  Start DIV Class Bootstrap [ Col - 6 ] -->
            <div class="show-video">
              <video controls>
                <source src="media/delta.mp4" type="video/mp4">
                  Your browser does not support the video tag.
              </video>
            </div>
        </div> <!--  End DIV Class Bootstrap [ Col - 6 ] -->

    </div> <!--  Start DIV Class Bootstrap [ ROW ] -->
</div>  <!--  End DIV Class [ Container ]  -->
</section> <!-- End Section Class [ Choose - Us ] -->

<!--
=======================
End Section Choose Us
======================= 
-->

<!-- 
=======================
Start Section Upcoming  
=======================
-->

<div class="tutors" style="background-image: none;">  <!-- Start The Best Tutors Section Parent -->

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