<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
get_header();
?>
<style type="text/css">
	.feature-box h3{color: #000!important;}
	.feature-box h3 span.subtitle{color: #000!important;}
</style>
		<!-- Page Title
		============================================= -->
		<section id="page-title">

			<div class="container clearfix">
				<h1>Contact</h1>				
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li class="active">Contact</li>
				</ol>
			</div>

		</section><!-- #page-title end -->
=
		<!-- Content
		============================================= -->
		<section id="content">

			<div class="content-wrap">

				<div class="container clearfix">

					<!-- Contact Form
					============================================= -->
					<div class="col-md-6">

						<div class="fancy-title title-dotted-border">
							<h3>Send us an Email</h3>
						</div>

						<div class="contact-widget">

							<div class="contact-form-result"></div>

							<form class="nobottommargin" id="template-contactform" name="template-contactform" action="include/sendemail.php" method="post">

								<div class="form-process"></div>

								<div class="col-md-12 form-group">
									<input type="text" id="template-contactform-name" placeholder="Name*" name="template-contactform-name" value="" class="sm-form-control required" />
								</div>

								<div class="col-md-12 form-group">
									<input type="email" id="template-contactform-email" placeholder="Email*" name="template-contactform-email" value="" class="required email sm-form-control" />
								</div>

								<div class="col-md-12 form-group">
									<input type="text" id="template-contactform-phone" placeholder="Phone No.*" name="template-contactform-phone" value="" class="required sm-form-control" />
								</div>
								
								<div class="col-md-12 form-group">
									<textarea class="required sm-form-control" id="template-contactform-message" name="template-contactform-message" rows="6" cols="30">Messages</textarea>
								</div>
								<br>
								<div class="col-md-12">
									<button name="submit" type="submit" id="submit-button" placeholder="Name" tabindex="5" value="Submit" class="button btn-danger button-3d nomargin">Submit</button>
								</div>

							</form>
						</div>

					</div><!-- Contact Form End -->

					<!-- Google Map
					============================================= -->
					<div class="col-md-6">

						<section id="google-map" class="gmap" style="height: 410px;">
							<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d241316.64332746214!2d72.74111778178768!3d19.082522320695563!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7c6306644edc1%3A0x5da4ed8f8d648c69!2sMumbai%2C+Maharashtra!5e0!3m2!1sen!2sin!4v1462358263946" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
						</section>

					</div><!-- Google Map End -->

					<div class="clear"></div>
					<br><br>

					<!-- Contact Info
					============================================= -->
					<div class="row clear-bottommargin">

						<div class="col-md-3 col-sm-6 bottommargin clearfix">
							<div class="feature-box fbox-center fbox-bg fbox-plain">
								<div class="fbox-icon">
									<a href="#"><i class="icon-map-marker2"></i></a>
								</div>
								<h3>Our Headquarters<span class="subtitle">Melbourne, Australia</span></h3>
							</div>
						</div>

						<div class="col-md-3 col-sm-6 bottommargin clearfix">
							<div class="feature-box fbox-center fbox-bg fbox-plain">
								<div class="fbox-icon">
									<a href="#"><i class="icon-phone3"></i></a>
								</div>
								<h3>Speak to Us<span class="subtitle">(123) 456 7890</span></h3>
							</div>
						</div>

						<div class="col-md-3 col-sm-6 bottommargin clearfix">
							<div class="feature-box fbox-center fbox-bg fbox-plain">
								<div class="fbox-icon">
									<a href="#"><i class="icon-skype2"></i></a>
								</div>
								<h3>Make a Video Call<span class="subtitle">CanvasOnSkype</span></h3>
							</div>
						</div>

						<div class="col-md-3 col-sm-6 bottommargin clearfix">
							<div class="feature-box fbox-center fbox-bg fbox-plain">
								<div class="fbox-icon">
									<a href="#"><i class="icon-twitter2"></i></a>
								</div>
								<h3>Follow on Twitter<span class="subtitle">2.3M Followers</span></h3>
							</div>
						</div>

					</div><!-- Contact Info End -->

				</div>

			</div>

		</section><!-- #content end -->



<?php
get_footer();
?>
