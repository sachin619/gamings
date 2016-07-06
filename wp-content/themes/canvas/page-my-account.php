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
<section ng-controller="myAccount" class="bg-img-container">
    <section id="page-title">

        <div class="container clearfix">
            <h1>My Account</h1>
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
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
                            <h4 class="fa fa-money fa-lg"></h4><br/> My Points
                        </a>   <!--My points -->
                        <a href="#" class="list-group-item text-center">
                            <h4 class="fa fa-thumbs-up fa-lg"></h4><br/>My Trades
                        </a>    <!-- My bets--> 
                        <a href="#" class="list-group-item text-center">
                            <h4 class="fa fa-thumbs-up fa-lg"></h4><br/>Trade Results
                        </a>    <!-- My Win Loss points -->    
                        <a href="#" class="list-group-item text-center hide">
                            <h4 class="fa fa-shopping-cart fa-lg "></h4><br/> Purchase History
                        </a>   <!-- Purchase History -->
                        <a href="#" class="list-group-item text-center">
                            <h4 class="fa fa-database fa-lg"></h4><br/>Get More Points
                        </a>   <!-- Buy More Points -->
                        <a href="#" class="list-group-item text-center hide">
                            <h4 class="fa fa-money fa-lg"></h4><br/> Encash My Points
                        </a>   <!-- Encash My Points -->
                        <a href="#" class="list-group-item  text-center">
                            <h4 class="fa fa-user fa-lg"></h4><br/> Edit Profile
                        </a>   <!-- edit profile-->
                        <a ng-hide="myAccount['userInfo']['userDetails']['data']['user_url'] != ''" href="#" class="list-group-item text-center">
                            <h4 class="fa fa-user fa-lg"></h4><br/> Change Password
                        </a>   <!-- Change Password -->

                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 bhoechie-tab">

                    <div class="bhoechie-tab-content active">
                        <div class="tabColumn">	
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <label for="oPass" class="col-sm-3">Cleared Points</label>
                                    <div class="col-sm-9">
                                        {{myAccount['userInfo']['points'][0]}} <span ng-if="myAccount['userInfo']['points'][0] == null">0</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="col-sm-3">Uncleared Points <span ><a href="#" class='toolMsg' data-toggle="tooltip" title="These points will be credited to your 'Cleared Points' after {{myAccount['bufferDay']}} days of winning Tournament/Match result. "><i class="fa fa-info-circle"></i></a></span></label>
                                    <div class="col-sm-9">
                                        {{myAccount['unClearedPoints']}}   <span ng-if="myAccount['unClearedPoints'] == null">0</span>
                                    </div>
                                </div>
                            </form>
                        </div>	
                    </div> <!-- My points -->
                    <div class="bhoechie-tab-content">
                        <div class="tabColumn">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <div class="col-lg-12" style="margin: 0 0 20px 0;">
                                        <form action="#" class="searchMyBets" style="margin:0px; padding:0px;">                                   
                                            <div class="col-md-6">                                             
                                                <span class="input-daterange input-group">     
                                                    <input type="text" id="startDate" class="datepickerStart startDate sm-form-control tleft required" value="<?= $_POST['startDate'] ?>" ng-model="startDate" name="startDate" placeholder="Start Date" required="" />

                                                    <span class="filter"></span>
                                                    <span class="input-group-addon">to</span>
                                                    <input type="text" class="datepickerEnd endDate sm-form-control tleft required" name="endDate" value="<?= $_POST['endDate'] ?>" ng-model="endDate"  placeholder="End Date" required="" />
                                                </span>
                                                <span class="errorStartDate" style="display:none;color:red">This field is required</span> <span class="errorEndDate" style="display:none;color:red;padding-left:59px" >This field is required</span>
                                            </div>
                                            <div class="col-md-6">
                                                <button onclick="return false"   ng-click="searchByDate()" class="button button-mini button-dark button-rounded">Search</button>
                                                <button onclick="return false"   ng-click="searchByDate('yes')" class="reset button button-mini button-dark button-rounded">Reset</button>
                                                <button onclick="return false"  ng-click="downloadCsv()" class="button button-mini button-dark button-rounded">Download</button>
                                                <span style="display: none" class="loaderDownload"><img ng-src={{myAccount['userInfo']['loaderImg']}} /></span>

                                            </div>  
                                        </form>
                                    </div> 
                                    <tr>
                                        <th>No</th>
                                        <th>Tournaments</th>
                                        <th>Match</th>
                                        <th>Traded On</th>
                                        <th>Points</th>
                                        <th>Trade Placed At</th>
                                    </tr>
                                    </thead>						   
                                    <tbody >
                                        <tr ng-repeat="myInfo in posts">
                                            <td>{{myInfo['tourDetails']['id']}}</td>
                                            <td >{{myInfo['tourDetails']['tourTitle']}}</td>
                                            <td>{{myInfo['tourDetails']['matchTitle']}}
                                                <br>{{myInfo['tourDetails']['startDate']}} 
                                                {{myInfo['tourDetails']['venue'] != '' && myInfo['tourDetails']['venue'] != null ? '(' + myInfo['tourDetails']['venue'] + ')' : ''}}
                                            </td>
                                            <td  ng-if="myInfo['tourDetails']['teamTitle'] == 'Api'" >Tie</td>
                                            <td ng-if="myInfo['tourDetails']['teamTitle'] != 'Api'">{{myInfo['tourDetails']['teamTitle']}}</td>
                                            <td>{{myInfo['tourDetails']['pts']}}</td>
                                            <td>{{myInfo['tourDetails']['bet_at']}}</td>
                                        </tr>
                                        <tr>   
                                            <td align="center" colspan="6" ng-if="posts.length <= 0">No results found</td>
                                        </tr>

                                    </tbody>							
                                </table>
                            </div>
                            <div class="col-lg-12">
                                <button  class="button button-mini button-dark button-rounded paginatePrev">Previous</button>
                                <button ng-hide="posts.length < 10" class="button paginateNext button-mini button-dark button-rounded pull-right">Next</button>
                            </div>
                        </div>
                    </div>   <!-- My bets-->

                    <div class="bhoechie-tab-content">
                        <div class="tabColumn">
                            <div class="table-responsive">
                                <table class = "table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tournaments</th>
                                            <th>Match</th>
                                            <th>Traded On</th> 
                                            <th>Total Trade</th>
                                            <th>Result</th>


                                        </tr>
                                    </thead>						   
                                    <tbody >
                                        <tr ng-repeat="myInfo in winList">
                                            <td>{{myInfo['tourDetails']['id']}}</td>
                                            <td >{{myInfo['tourDetails']['tourTitle']}}</td>
                                            <td>{{myInfo['tourDetails']['matchTitle']}}
                                                <br>{{myInfo['tourDetails']['startDate']}} 
                                                {{myInfo['tourDetails']['venue'] != '' && myInfo['tourDetails']['venue'] !=null ? '(' + myInfo['tourDetails']['venue'] + ')' : ''}}
                                            </td>
                                            <td ng-if="myInfo['tourDetails']['teamTitle'] == 'Api'" >Tie</td>
                                            <td ng-if="myInfo['tourDetails']['teamTitle'] != 'Api'">{{myInfo['tourDetails']['teamTitle']}}</td>
                                            <td>{{myInfo['tourDetails']['teamTotal']}}</td>
                                            {{getstatus=myInfo['tourDetails']['win']}}
                                            <td ng-class="myInfo['tourDetails']['status']==0 ?'win':myInfo['tourDetails']['status']==1 ?'loss':myInfo['tourDetails']['status']==2 ?'cancelColor':''">{{myInfo['tourDetails']['pts']}} </td>


                                        </tr>   
                                        <tr>   
                                            <td align="center" colspan="6" ng-if="winList.length == null || winList.length == 0">No results found</td>
                                        </tr>

                                </table>
                            </div>
                            <div class="col-lg-12">
                                <button  class="button button-mini button-dark button-rounded paginatePrevWin">Previous</button>
                                <button ng-if="winList.length >= 10" class="button paginateNextWin button-mini button-dark button-rounded pull-right">Next</button> </div>
                        </div>
                    </div>   <!--  My Win Loss points-->
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
                            <p>To get more points please mail <b> <a href="mailto:support@eventexchange.co.in?Subject=Hello%20again" target="_top">support@eventexchange.co.in</a></b> with the subject "<b>Request for more points</b>" . Kindly email from the registered Email Id or mention the same in the mail.</p>
                            <!--                            <form class="form-horizontal">
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
                                                        </form>-->
                        </div>
                    </div>   <!-- Buy More Points -->
                    <div class="bhoechie-tab-content">
                        <div class="tabColumn">
                            <p>To get more points please mail <a href="mailto:support@eventexchange.co.in?Subject=Hello%20again" target="_top">support@eventexchange.co.in</a>  with the Subject "Request for more points" . Kindly email from the registered Email Id or mentioned the same in the mail.</p>
                            <!--                            <form class="form-horizontal">
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
                                                        </form>-->
                        </div>
                    </div>   <!--  Encash My Points -->
                    <div class="bhoechie-tab-content">
                        <div class="tabColumn">
                            <form class="form-horizontal userInfoForm">
                                <div class="form-group">
                                    <label for="name" class="col-sm-3 control-label">First Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="fname" name='fname'  value={{myAccount['userInfo']['firstName'][0]}} placeholder="First Name" required="" ng-minlength="3">
                                    </div>
                                </div>	
                                <div class="form-group">
                                    <label for="name" class="col-sm-3 control-label">Last Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="lname" name='lname' value={{myAccount['userInfo']['lastName'][0]}} placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label for="username" class="col-sm-3 control-label">Username</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" value={{myAccount['userInfo']['userDetails']['data']['user_login']}} id="username" name="username" placeholder="Username" disabled="">
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label for="email" class="col-sm-3 control-label">Email</label>
                                    <div class="col-sm-8">
                                        <input type="email" class="form-control" value={{myAccount['userInfo']['userDetails']['data']['user_email']}} id="email" name="email" placeholder="Email" disabled="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="mobile" class="col-sm-3 control-label">Mobile</label>
                                    <div class="col-sm-8">
                                        <input type="text" value={{myAccount['userInfo']['phone'][0]}} class="form-control" id="mobile" name="mobile" placeholder="Mobile">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="dob" class="col-sm-3 control-label">Date Of Birth</label>
                                    <div class="col-sm-8">
                                        <input type="text" value={{myAccount['userInfo']['dateOfBirth'][0]}} class="form-control" id="dob" name="dob" placeholder="Date Of Birth" disabled="">
                                    </div>
                                </div>
                                <div class="form-group" ng-hide="myAccount['userInfo']['userDetails']['data']['user_url'] != ''">
                                    <label for="mobile" class="col-sm-3 control-label">Upload Profile Image</label>
                                    <div class="col-sm-8">
                                        <input type="file"  id="img" name="file" value="browse" />

                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-10">
                                        <button type="submit" onclick="return false;" ng-click="userUpdate()" class="btn btn-danger">Submit</button> <span style="display: none" class="loader"><img ng-src={{myAccount['userInfo']['loaderImg']}} /></span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>   <!-- edit profile-->
                    <div class="bhoechie-tab-content">
                        <div class="tabColumn">	
                            <form id="changePassword" name="changePassword" class="form-horizontal">
                                <div class="form-group">
                                    <label for="oPass" class="col-sm-3 control-label">Old Password</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" value="" ng-model="oldPassword" id="oldPassword" name="oldPassword" placeholder="Old Password" required="">
                                        <div ng-show="changePassword.oldPassword.$dirty">
                                            <span class="errorColor" ng-show="changePassword.oldPassword.$error.required">Required</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="col-sm-3 control-label">New Password</label>
                                    <div class="col-sm-8"><!-- ID and NAME should be same -->
                                        <input type="password" ng-model="newPassword" value="" class="form-control" id="newPassword" name="newPassword" placeholder="New Password" required="" ng-minlength="5">
                                        <div ng-show="changePassword.newPassword.$dirty">
                                            <span class="errorColor" ng-show="changePassword.newPassword.$error.required">Required</span>
                                            <span class="errorColor" ng-show="changePassword.newPassword.$error.minlength">Minimum length should be 5</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="confirmPassword" class="col-sm-3 control-label">Confirm Password</label>
                                    <div class="col-sm-8">
                                        <input type="password" value="" class="form-control" ng-model="confirmPassword" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required="" ng-pattern={{newPassword}} >
                                        <div ng-show="changePassword.confirmPassword.$dirty">
                                            <span class="errorColor" ng-show="changePassword.confirmPassword.$error.required" >Required</span>
                                            <span class="errorColor" ng-show="changePassword.confirmPassword.$error.pattern">Password does not match</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <button ng-disabled="!changePassword.$dirty || changePassword.$invalid" type="submit" onclick="return false;" ng-click="updatePassword()" class="btn btn-danger">Submit</button> <span style="display: none" class="loader"><img ng-src={{myAccount['userInfo']['loaderImg']}} /></span>
                                    </div>
                                </div>
                            </form>
                        </div> 
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
<script src="<?= get_template_directory_uri() ?>/js/bootstrap.min.js"></script>
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


<style>
    .win{background-color: #adebad;}   
    .loss{background-color: #ff6666;}
    .cancelColor{background-color: #f2f900;}
    #mobile-error{ display:block !important}
    #fname-error{ display:block !important}
    #email-error{ display:block !important}
    #lname-error{ display:block !important}
    #lname-error{ display:block !important}
    #startDate-error{ display:block !important}
    .errorColor{color:red;}
    .form-horizontal .control-label{ text-align:left!important;}
</style>