<?php
get_header();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<section ng-controller="leaderBoardCtrl">
    <section>
        <div class="background-image clearfix" style="background: url('<?= get_template_directory_uri() ?>/images/grass_bg.jpg') no-repeat;">
            <div class="background-image-overly"></div>
            <div class="container">
                <div class="row">
                    <div class="widget">
                        <div id="post-list-footer">
                            <div class="spost clearfix">
                                <div class="bannerheight">
                                    <div class="col-md-4">
                                        <div class="proile_img">

                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="profile_text">
                                            <div class="entry-title">
                                                <h2>Leader Board</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <section>
        <br><br><br>
        <div class="container bootstrap snippet">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-box no-header clearfix">
                        <div class="main-box-body clearfix">
                            <div class="table-responsive">
                                <table class="table user-list">
                                    <thead>
                                        <tr>
                                            <th><span>User</span></th>

                                            <th><span>Points</span></th>


                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr ng-repeat="userInfo in userDetails['userDetails']">
                                            <td>
        <!--                                        <img ng-src="{{userDetails['userImg'][$index]}}" style="height: 100px;width:100px" alt="">-->
                                                <span class="user-subhead">{{userInfo['data']['display_name']}}</span>
                                            </td>

                                            <td>
                                                {{userDetails['pts'][$index]}}
                                            </td>

                                        </tr>
                                   <tr  ng-hide="userDetails['userDetails'].length"><td colspan="2" align="center">There are no users to display at the moment please check again later!</td></tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

</section>
<br><br><br><br><br><br><br><br><br><br><br><br>
<?php
get_footer();
?>
<style>

    body{
        background:#eee;    
    }
    .main-box.no-header {
        padding-top: 20px;
    }
    .main-box {
        background: #FFFFFF;
        -webkit-box-shadow: 1px 1px 2px 0 #CCCCCC;
        -moz-box-shadow: 1px 1px 2px 0 #CCCCCC;
        -o-box-shadow: 1px 1px 2px 0 #CCCCCC;
        -ms-box-shadow: 1px 1px 2px 0 #CCCCCC;
        box-shadow: 1px 1px 2px 0 #CCCCCC;
        margin-bottom: 16px;
        -webikt-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
    }
    .table a.table-link.danger {
        color: #e74c3c;
    }
    .label {
        border-radius: 3px;
        font-size: 0.875em;
        font-weight: 600;
    }
    .user-list tbody td .user-subhead {
        font-size: 0.875em;
        font-style: italic;
    }
    .user-list tbody td .user-link {
        display: block;
        font-size: 1.25em;
        padding-top: 3px;
        margin-left: 60px;
    }
    a {
        color: #3498db;
        outline: none!important;
    }
    .user-list tbody td>img {
        position: relative;
        max-width: 50px;
        float: left;
        margin-right: 15px;
    }

    .table thead tr th {
        text-transform: uppercase;
        font-size: 0.875em;
    }
    .table thead tr th {
        border-bottom: 2px solid #e7ebee;
    }
    .table tbody tr td:first-child {
        font-size: 1.125em;
        font-weight: 300;
    }
    .table tbody tr td {
        font-size: 0.875em;
        vertical-align: middle;
        border-top: 1px solid #e7ebee;
        padding: 12px 8px;
    }
</style>