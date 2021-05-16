<?php
ob_start();
session_start();
$title = "Contact";
$active = "Contact";
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
							<li><i class="fa fa-chevron-right fa-fw"></i> Contact</li>
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
Start Section Contact
======================= 
-->

	<div class="contact">
		
		<!-- Contact Map -->

		<div class="contact_map">

			<!-- Google Map -->
			
			<div class="map">
				<div id="google_map" class="google_map">
					<div class="map_container">
                        <div id="Map">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3417.430664018438!2d31.390669903058907!3d31.0699454626164!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14f7762803b7913f%3A0xfcbed774a0768201!2z2YXYudmH2K8g2KfZhNiv2YTYqtinINin2YTYudin2YTZiSDZhNmE2YfZhtiv2LPYqSDZiNin2YTYqtmD2YbZiNmE2YjYrNmK2Kc!5e0!3m2!1sar!2seg!4v1540410961556" width="100%" height="600" frameborder="0" style="border:0" allowfullscreen></iframe>
                        </div>
                        
					</div>
				</div>
			</div>

		</div>
<!--
=======================
End Section Contact
======================= 
-->

<!--
========================
Start Section Contact Info
========================
-->

		<div class="contact_info_container">
			<div class="container">
				<div class="row">

					<!-- Contact Form -->
					<div class="col-lg-6">
						<div class="contact_form">
							<div class="contact_info_title">Contact Form</div>
							<form action="#" class="comment_form">
								<div>
									<div class="form_title">Name</div>
									<input type="text" class="comment_input">
								</div>
								<div>
									<div class="form_title">Email</div>
									<input type="text" class="comment_input">
								</div>
								<div>
									<div class="form_title">Message</div>
									<textarea class="comment_input comment_textarea"></textarea>
								</div>
								<div>
									<button type="submit" class="comment_button trans_200">submit now</button>
								</div>
							</form>
						</div>
					</div>

					<!-- Contact Info -->
					<div class="col-lg-6">
						<div class="contact_info">
							<div class="contact_info_title">Contact Info</div>
							<div class="contact_info_text">
								<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a distribution of letters.</p>
							</div>
							<div class="contact_info_location">
								<div class="contact_info_location_title">Mansoura Office</div>
								<ul class="location_list">
									<li>Talkha St-Sherbin, Talkha City, Talkha, El Dakahleya</li>
									<li>050 2529808</li>
									<li>info.famous@gmail.com</li>
								</ul>
							</div>
							<div class="contact_info_location">
								<div class="contact_info_location_title">Mansoura Office</div>
								<ul class="location_list">
									<li>Talkha St-Sherbin, Talkha City, Talkha, El Dakahleya</li>
									<li>050 2529808</li>
									<li>info.sanntoryu@gmail.com</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!--
========================
Start Section Contact Info
========================
-->


<?php
include "template/footer.php";
ob_end_flush();
?>