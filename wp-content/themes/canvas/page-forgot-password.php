<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
get_header();
?>
<section id="page-title">

    <div class="container clearfix">
        <h1>Forgot Password</h1>
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li class="active">Login / Register</li>
        </ol>
    </div>

</section>

<section ng-controller="forgotPasswordCtrl" id="content" class="ng-scope" style="margin-bottom: 0px;">
    <div class="content-wrap">

        <div class="container clearfix">

            <div style="max-width: 500px;" id="tab-login-register" class="tabs divcenter nobottommargin clearfix ui-tabs ui-widget ui-widget-content ui-corner-all">



                <div class="tab-container">

                    <div id="tab-login" class="tab-content clearfix ui-tabs-panel ui-widget-content ui-corner-bottom" aria-labelledby="ui-id-1" role="tabpanel" aria-hidden="false">
                        <div class="panel panel-default nobottommargin">
                            <div style="padding: 40px;" class="panel-body">
                                <form method="post" action="#" class="nobottommargin" name="forgotPassword" id="forgotPassword">

                                    <h3>Change Your Password</h3>



                                    <div class="col_full">
                                        <label for="login-form-password">Password:</label>
                                        <input type="password" class="form-control" value="" ng-model="password" name="password" id="password" required="">
                                    </div>

                                    <div class="col_full">
                                        <button  class="button loginButton button-3d button-black nomargin" onclick="return false" ng-click="resetPassword()" >Reset Password</button>
                                        <img ng-src={{loaderSrc}} class="loader" />
                                    </div>
                                    
                                    <div ng-if="errorReg != null" class="alert  alert-{{errorReg['errorType']}} col_full nobottommargin">
                                        {{errorReg['msg']}}
                                    </div>
                                    <div class="customAlert">
                                        <!-- ngIf: errorLog != null -->
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>



                </div>

            </div>

        </div>

        <!-- Modal -->

    </div>
</section>
<style>
    #password-error{
        display: block !important;
    }
</style>
<?php

get_footer();
?>