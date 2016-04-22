<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
get_header();
?>

<!-- Page Title
        ============================================= -->
<section id="page-title">

    <div class="container clearfix">
        <h1>My Account</h1>
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li><a href="#">Pages</a></li>
            <li class="active">Login</li>
        </ol>
    </div>

</section><!-- #page-title end -->

<!-- Content
============================================= -->
<section id="content" ng-controller="signupCtrl">

    <div class="content-wrap">

        <div class="container clearfix">

            <div class="tabs divcenter nobottommargin clearfix" id="tab-login-register" style="max-width: 500px;">

                <ul class="tab-nav tab-nav2 center clearfix">
                    <li class="inline-block"><a href="#tab-login">Login</a></li>
                    <li class="inline-block"><a href="#tab-register">Register</a></li>
                </ul>

                <div class="tab-container">

                    <div class="tab-content clearfix" id="tab-login">
                        <div class="panel panel-default nobottommargin">
                            <div class="panel-body" style="padding: 40px;">
                                <form id="login-form" name="loginForm" class="nobottommargin" action="#" method="post">

                                    <h3>Login to your Account</h3>

                                    <div class="col_full">
                                        <label for="login-form-username">Username/Email:</label>
                                        <input type="text" id="login-form-username" name="username" value="" class="form-control" />
                                    </div>

                                    <div class="col_full">
                                        <label for="login-form-password">Password:</label>
                                        <input type="password" id="login-form-password" name="password" value="" class="form-control" />
                                    </div>

                                    <div class="col_full nobottommargin">
                                        <button onclick="return false" ng-click="signIn()" class="button button-3d button-black nomargin" id="login-form-submit" name="login-form-submit" value="login">Login</button>
                                        <p>{{errorLog}}</p>
                                        <a href="#" class="fright">Forgot Password?</a>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="tab-content clearfix" id="tab-register">
                        <div class="panel panel-default nobottommargin">
                            <div class="panel-body" style="padding: 40px;">
                                <h3>Register for an Account</h3>

                                <form id="register-form" name="registerForm" class="nobottommargin" action="#" method="post">

                                    <div class="col_full">
                                        <label for="register-form-name">First Name:</label>
                                        <input type="text" id="register-form-name" name="fName" value="" class="form-control" />
                                    </div>

                                    <div class="col_full">
                                        <label for="register-form-name">Last Name:</label>
                                        <input type="text" id="register-form-name" name="lName" value="" class="form-control" />
                                    </div>

                                    <div class="col_full">
                                        <label for="register-form-email">Email Address:</label>
                                        <input type="text" id="register-form-email" name="email" value="" class="form-control" />
                                    </div>

                                    <div class="col_full">
                                        <label for="register-form-username">Choose a Username:</label>
                                        <input type="text" id="register-form-username" name="username" value="" class="form-control" />
                                    </div>

                                    <div class="col_full">
                                        <label for="register-form-phone">Phone:</label>
                                        <input type="text" id="register-form-phone" name="phone" value="" class="form-control" />
                                    </div>

                                    <div class="col_full">
                                        <label for="register-form-password">Choose Password:</label>
                                        <input type="password" id="register-form-password" name="password" value="" class="form-control" />
                                    </div>

                                    <div class="col_full">
                                        <label for="register-form-repassword">Re-enter Password:</label>
                                        <input type="password" id="register-form-repassword" name="register-form-repassword" value="" class="form-control" />
                                    </div>

                                    <div class="col_full nobottommargin">
                                        <button onclick="return false" ng-click="signUp()" class="button button-3d button-black nomargin" id="register-form-submit" name="register-form-submit" value="register">Register Now</button>
                                        <p>{{errorReg}}</p>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</section><!-- #content end -->

<?php
get_footer();
?>