<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
get_header();
$userInfo = wp_get_current_user();
$userEmail = $userInfo->user_email;
?>
<section ng-controller="myAccount">
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

    <section class="container clearfix">

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bhoechie-tab-container">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 bhoechie-tab-menu">
                    <div class="list-group">

                        <a href="#" class="list-group-item active text-center">
                            <h4 class="fa fa-money fa-lg"></h4><br/>MY POINTS
                        </a>   <!--My points -->
                        <a href="#" class="list-group-item text-center">
                            <h4 class="fa fa-thumbs-up fa-lg"></h4><br/>MY BETS
                        </a>    <!-- My bets-->                   
                        <a href="#" class="list-group-item text-center">
                            <h4 class="fa fa-shopping-cart fa-lg"></h4><br/>PURCHASE HISTORY
                        </a>   <!-- Purchase History -->
                        <a href="#" class="list-group-item text-center">
                            <h4 class="fa fa-database fa-lg"></h4><br/>BUY MORE POINTS
                        </a>   <!-- Buy More Points -->
                        <a href="#" class="list-group-item text-center">
                            <h4 class="fa fa-money fa-lg"></h4><br/>ENCASH MY POINTS
                        </a>   <!-- Encash My Points -->
                        <a href="#" class="list-group-item  text-center">
                            <h4 class="fa fa-user fa-lg"></h4><br/>EDIT PROFILE
                        </a>   <!-- edit profile-->
                        <a href="#" class="list-group-item text-center">
                            <h4 class="fa fa-user fa-lg"></h4><br/>CHANGE PASSWORD
                        </a>   <!-- Change Password -->

                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 bhoechie-tab">

                    <div class="bhoechie-tab-content">
                        <form class="form-horizontal">

                            <div class="form-group">
                                <label for="oPass" class="col-sm-3 control-label">Cleared Points</label>
                                <div class="col-sm-9">
                                    {{myAccount['userInfo']['points'][0]}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-3 control-label">Uncleared Points</label>
                                <div class="col-sm-9">
                                    {{myAccount['unClearedPoints']}}
                                </div>
                            </div>


                        </form>
                    </div> <!-- My points -->
                    <div class="bhoechie-tab-content">
                        <div class="tabColumn">
                            <table class = "table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Tournaments</th>
                                        <th>Match</th>
                                        <th>Team</th>
                                        <th>Points</th>
                                        <th>Bet Placed On</th>

                                    </tr>
                                </thead>						   
                                <tbody>
                                    <tr ng-repeat="myInfo in myAccount['userBets']">
                                        <td >{{myInfo['tourTitle'][$index]}}</td>
                                        <td>{{myInfo['matchTitle'][$index]}}</td>
                                        <td>{{myInfo['teamTitle'][$index]}}</td>
                                        <td>{{myInfo['pts'][$index]}}</td>
                                        <td>{{myInfo['bet_at'][$index]}}</td>

                                    </tr>						      

                                </tbody>							
                            </table>
                        </div>
                    </div>   <!-- My bets-->
                    <div class="bhoechie-tab-content">
                        <div class="tabColumn">
                            <table class = "table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Transaction Id</th>
                                        <th>Points Purchased On</th>
                                        <th>Points Paid</th>
                                    </tr>
                                </thead>						   
                                <tbody>

                                </tbody>							
                            </table>
                        </div>
                    </div>   <!-- Purchase History -->
                    <div class="bhoechie-tab-content">
                        <div class="tabColumn">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <label for="name" class="col-sm-3 control-label">Buy Points</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="name" placeholder="Buy Points">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <button type="submit" class="btn btn-danger">Pay Now</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>   <!-- Buy More Points -->
                    <div class="bhoechie-tab-content">
                        <div class="tabColumn">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <label for="name" class="col-sm-3 control-label">Encash Points</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="name" placeholder="Encash Points">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <button type="submit" class="btn btn-danger">Pay Now</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>   <!--  Encash My Points -->
                    <div class="bhoechie-tab-content active">
                        <div class="tabColumn">
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">First Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="fname" name='fname' ng-model="fname" value={{myAccount['userInfo']['firstName'][0]}} placeholder="First Name" required="" ng-minlength="3">
                                    </div>
                                </div>	
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Last Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="lname" name='lname' value={{myAccount['userInfo']['lastName'][0]}} placeholder="Last Name">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" value={{myAccount['userInfo']['userDetails']['data']['user_email']}} id="email" name="email" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="mobile" class="col-sm-2 control-label">Mobile</label>
                                    <div class="col-sm-10">
                                        <input type="text" value={{myAccount['userInfo']['phone'][0]}} class="form-control" id="mobile" name="mobile" placeholder="Mobile">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="mobile" class="col-sm-2 control-label">Upload Profile Image</label>
                                    <div class="col-sm-10">
                                        <input type="file"  id="img" name="file" value="browse" />

                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" onclick="return false;" ng-click="userUpdate()" class="btn btn-danger">Submit</button> <span style="display: none" class="loader"><img src={{myAccount['userInfo']['loaderImg']}} /></span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>   <!-- edit profile-->
                    <div class="bhoechie-tab-content">
                        <form id="changePassword" name="changePassword" class="form-horizontal">

                            <div class="form-group">
                                <label for="oPass" class="col-sm-3 control-label">Old Password</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="" ng-model="oldPassword" id="oldPassword" name="oldPassword" placeholder="Old Password" required="">
                                    <div ng-show="changePassword.oldPassword.$dirty">
                                        <span ng-show="changePassword.oldPassword.$error.required">Required</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-3 control-label">New Password</label>
                                <div class="col-sm-9"><!-- ID and NAME should be same -->
                                    <input type="password" ng-model="newPassword" value="" class="form-control" id="newPassword" name="newPassword" placeholder="New Password" required="" ng-minlength="5">
                                    <div ng-show="changePassword.newPassword.$dirty">
                                        <span ng-show="changePassword.newPassword.$error.required">Required</span>
                                        <span ng-show="changePassword.newPassword.$error.minlength">Minimum length should be 5</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="confirmPassword" class="col-sm-3 control-label">Confirm Password</label>
                                <div class="col-sm-9">
                                    <input type="password" value="" class="form-control" ng-model="confirmPassword" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required="" ng-pattern={{newPassword}} >
                                    <div ng-show="changePassword.confirmPassword.$dirty">
                                        <span ng-show="changePassword.confirmPassword.$error.required" >Required</span>
                                        <span ng-show="changePassword.confirmPassword.$error.pattern">Password does not match</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button ng-disabled="!changePassword.$dirty || changePassword.$invalid" type="submit" onclick="return false;" ng-click="updatePassword()" class="btn btn-danger">Submit</button> <span style="display: none" class="loader"><img src={{myAccount['userInfo']['loaderImg']}} /></span>
                                </div>
                            </div>
                        </form>
                    </div>  <!-- Change Password -->

                </div>
            </div>
        </div>

        </div>

    </section>

</section>

<?php
get_footer();
?>
<script type="text/javascript">
    $(document).ready(function () {
        $("div.bhoechie-tab-menu>div.list-group>a").click(function (e) {
            e.preventDefault();
            $(this).siblings('a.active').removeClass("active");
            $(this).addClass("active");
            var index = $(this).index();
            $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
            $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
        });
    });
</script>
