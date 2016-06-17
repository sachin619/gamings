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
    #phone-error{ display:block !important}
    #fname-error{ display:block !important}
    #email-error{ display:block !important}
    #message-error{ display:block !important}
    .col-ch{padding-top: 380px;}
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

<!-- Content
============================================= -->
<section id="content" ng-controller="contactCtrl" class="bg-img-container">
<?php
while (have_posts()):
    the_post();
    print_r(get_the_content());
endwhile;
?>

</section><!-- #content end -->


<?php

get_footer();
?>
