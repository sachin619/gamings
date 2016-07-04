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