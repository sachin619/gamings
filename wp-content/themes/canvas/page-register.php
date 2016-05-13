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
        <h1>Login / Register</h1>
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li class="active">Login / Register</li>
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

                                    <div class="col_full">
                                        <button onclick="return false"  ng-click="signIn()" class="button loginButton button-3d button-black nomargin" id="login-form-submit" name="login-form-submit" value="login">Login</button>
                                        <span class="loader loaderAlign"><img src={{myAccount['userInfo']['loaderImg']}} /></span>

                                        <a href="#" class="fright" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Forgot Password?</a>
                                    </div>
                                    <div class='customAlert'>
                                        <div ng-if="errorLog != null" class="alert  alert-{{errorLog['errorType']}} col_full nobottommargin">
                                            {{errorLog['msg']}}
                                        </div>
                                    </div>
                                    <div class="col_full"><br>
                                        <?php do_action('facebook_login_button'); ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="tab-content clearfix" id="tab-register">
                        <div class="panel panel-default nobottommargin">
                            <div class="panel-body" style="padding: 40px;">
                                <h3>Register for an Account</h3>

                                <form id="register-form" name="registerForm" class="nobottommargin" >

                                    <div class="col_full">
                                        <label for="register-form-name">First Name:</label>
                                        <input type="text" ng-pattern="/^[a-zA-Z]+$/" id="register-form-name" ng-model="user.fName" name="fName" value="" class="form-control" ng-minlength="3" required="" />
                                        <div ng-show="registerForm.fName.$dirty">
                                            <span ng-show="registerForm.fName.$error.required">Required</span>
                                            <span ng-show="registerForm.fName.$error.pattern">Only Alphabets are allowed</span>
                                            <span ng-show="registerForm.fName.$error.minlength">Minimum 3 Characters</span>
                                        </div>

                                        <div class="col_full">
                                            <label for="register-form-name">Last Name:</label>
                                            <input type="text" ng-pattern="/^[a-zA-Z]+$/" id="register-form-name" ng-model="user.lName" name="lName" value=""  ng-minlength="3" class="form-control" required="" />
                                            <div ng-show="registerForm.lName.$dirty">
                                                <span ng-show="registerForm.lName.$error.required">Required</span>
                                                <span ng-show="registerForm.lName.$error.pattern">Only Alphabets are allowed</span>
                                                <span ng-show="registerForm.lName.$error.minlength">Minimum 3 Characters</span>

                                            </div>
                                        </div>

                                        <div class="col_full">
                                            <label for="register-form-email">Email Address:</label>
                                            <input  type="email"  id="register-form-email" ng-model="user.email" name="email" value="" class="form-control" required="" />

                                            <div ng-show="registerForm.email.$dirty">
                                                <span ng-show="registerForm.email.$error.required">Required</span>
                                                <span ng-show="registerForm.email.$error.email">This is not a valid email.</span>
                                            </div>
                                        </div>

                                        <div class="col_full">
                                            <label for="register-form-username">Choose a Username:</label>
                                            <input type="text" id="register-form-username" name="username" ng-model="user.username" value="" class="form-control" ng-minlength="5" required="" />
                                            <span ng-show="registerForm.username.$error.required">Required</span>
                                            <span ng-show="registerForm.username.$error.minlength">Minimum 5 Characters</span>
                                        </div>

                                        <div class="col_full">
                                            <label for="register-form-phone">Phone:</label>
                                            <input ng-pattern="/^[0-9]{10}$/"  type="text" id="register-form-phone" ng-model="user.phone" name="phone" value="" class="form-control" />
                                            <div ng-show="registerForm.phone.$dirty" >
                                                <span ng-show="registerForm.phone.$error.pattern">Mobile Number should be of 10 digit</span>
                                            </div>
                                        </div>

                                        <div class="col_full">
                                            <label for="register-form-password">Choose Password:</label>
                                            <input type="password" id="register-form-password" ng-model="user.password" name="password" value="" class="form-control" ng-minlength="5" required="" />
                                            <span ng-show="registerForm.password.$error.required">Required</span>
                                            <span ng-show="registerForm.password.$error.minlength">Minimum 5 Characters </span>
                                        </div>

                                        <div class="col_full ">
                                            <button  ng-disabled="registerForm.$invalid || !registerForm.$dirty"  ng-click="signUp()" class="button button-3d button-black nomargin" id="register-form-submit" name="register-form-submit" value="register">Register Now</button>                                       
                                        </div>           
                                        <div ng-if="errorReg != null" class="alert  alert-{{errorReg['errorType']}} col_full nobottommargin">
                                            {{errorReg['msg']}}
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Forgot Password</h4>Please enter your username or email address. You will receive a link to create a new password via email.

                </div>
                <div class="modal-body header-modal">
                    <div class="form-group">
                        <label for="usr">Username/Email:</label>
                        <input type="email" class="form-control" id="user_login" placeholder="Username/Email">
                    </div>  

                    <div class="form-group">  
                        <button type="button" ng-click="forgotPassword()" class="btn btn-danger">Submit</button>
                        <img src="{{loadImg}}" class="loaderForgot" />
                        <div class="alert alert-danger  forgotPassword-error">
                           User or Email does not exist.
                        </div>
                        <div class="alert alert-success  forgotPassword-success">
                          Email send successfully
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>   
</section><!-- #content end -->
<style>
    .loaderAlign{
        display: none;float:left
    }
    .loginButton{
        float:left;
    }
    .customAlert{
        padding-top: 46px;
    }
</style>
<?php
get_footer();
?>