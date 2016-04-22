<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
get_header();
$userInfo=wp_get_current_user();
$userEmail=$userInfo->user_email;
?>
<section id="page-title">

    <div class="container clearfix">
        <h1>My Account</h1>
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li><a href="#">Pages</a></li>
            <li class="active">My Account</li>
        </ol>
    </div>

</section><!-- #page-title end -->
<h1><?= $userEmail ?> </h1>
<section>
    
    
</section>
<?php
get_footer();
?>

