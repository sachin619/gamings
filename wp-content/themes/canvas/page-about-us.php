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
        <h1>About Us</h1>				
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li class="active">Contact</li>
        </ol>
    </div>

</section><!-- #page-title end -->

<!-- Content
============================================= -->
<section id="content" class="bg-img-container">

    <div class="content-wrap">

        <div class="container clearfix">


                        <div class="row">

                            <div class="col-md-12">
                                <p class="nobottommargin">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                </p>
                            </div>

                        </div>

            <div class="clear"></div>
            <br><br>

            <!-- Contact Info
            ============================================= -->
            <?php
            while (have_posts()) : the_post();
                the_content();
            endwhile;
            ?>
            <!-- Contact Info End -->

        </div>

    </div>

</section><!-- #content end -->



<?php
get_footer();
?>
