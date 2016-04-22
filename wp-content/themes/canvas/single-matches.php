<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
get_header();
?>
<section ng-controller="matchesDetails">
    <!-- Page Title
            ============================================= -->
    <section id="page-title">

        <div class="container clearfix">
           
            <h1 >{{getDetails['details'][0].title}}</h1>
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">Tournaments</a></li>
                <li class="active">{{getDetails['details'][0].title}}</li>
            </ol>
        </div>

    </section><!-- #page-title end -->

    <!-- Content
    ============================================= -->
    <section>

        <div class="content-wrap">

            <div class="container clearfix">

                <div class="row">

                    <div class="col-md-6">		
                        <div class="entry-image">
<!--                            <p>{{getDetails}}</p>-->
                            <a href={{getDetails['details'][0].postLink}}><img src={{getDetails['details'][0].img}} alt={{getDetails['details'][0].title}}></a>
                        </div><!-- .entry-image end -->



                    </div>
                    <div class="col-md-6">
                        <p class="mb20">{{getDetails['details'][0].description}}</p>
                        <p class="bld mb20">{{getDetails['details'][0].start_date}}– {{getDetails['details'][0].end_date}} ({{getDetails['details'][0].venue}})</p>
                        <p class="mb20"><span class="bld"> Official Website: </span><a href={{getDetails['details'][0].website_link}} target="_blank">{{getDetails['details'][0].website_link}}</a></p>


                        <h4>Total Trade So far: {{getDetails['totalBets'][0].total}} Points</h4>
                    </div>

                </div>

                <h3 class="text-center mtb20">Team Participating</h3>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">

                        <thead>
                            <tr>

                                <th>Team</th>

                                <th>Your Trade</th>
                                <th>Add Trade</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr  ng-repeat="teamInfo in getDetails['details'][0].select_teams">
                        
                        <td width="30%"> {{teamInfo.team_name['post_title']}}</td>
                        <td > {{getDetails['pts'][$index][0].total}}</td>
                        <td class="blockTrade" ng-if="teamInfo.winner==='No'"><input type="text" name="pts" ng-model="$parent.points"  placeholder="Trade"></td>
                        <td class="blockAction" ng-if="teamInfo.winner==='No'"><button ng-click="trade(getDetails['details'][0].id,teamInfo.team_name['ID'],points)" >Add</button></td>
                        <td colspan="2" ng-if="teamInfo.winner !== 'No'">Looser</td>  
                        </tr>


                        <tr>
                            <th>Total</th>
                            <th>{{ getDetails['userTotalTrade']}}</th>
                            <th> </th>
                            <th></th>
                        </tr>




                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </section><!-- #content end -->

    <!-- Footer
    ============================================= -->
</section>
<?php
get_footer();
?>