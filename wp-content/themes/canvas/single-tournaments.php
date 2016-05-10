<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
get_header();
?>
<section ng-controller="tourDetails">
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

                            <a href={{getDetails['details'][0].postLink}}><img src={{getDetails['details'][0].img}} alt={{getDetails['details'][0].title}}></a>
                        </div><!-- .entry-image end -->



                    </div>
                    <div class="col-md-6">
                        <p class="mb20">{{getDetails['details'][0].description}}</p>
                        <p class="bld mb20">{{getDetails['details'][0].start_date}}– {{getDetails['details'][0].end_date}} ({{getDetails['details'][0].venue}})</p>
                        <p class="mb20"><span class="bld"> Official Website: </span><a href={{getDetails['details'][0].website_link}} target="_blank">{{getDetails['details'][0].website_link}}</a></p>


                        <h4 ng-if="getDetails['totalBets'][0].total > 0">Total Points Traded So far: {{getDetails['totalBets'][0].total}} Points</h4>

                        <h5 ng-if="getDetails['details'][0].premium > 1">Premium value : {{getDetails['details'][0].premium}} </h5>
                    </div>

                </div>

                <h3 class="text-center mtb20">Team Participating</h3>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">

                        <thead>
                            <tr>

                                <th>Team</th>

                                <th >Your Trade</th>
                                <th >Add Trade</th>
                                <th >Action</th>
                            </tr>
                        </thead>
                        <tbody> 

                            <tr   ng-repeat="teamInfo in getDetails['details'][0].participating_team">

                                <td class="demo" width="30%"> {{teamInfo.team['post_title']}}</td>               
                                <td > <span ng-if="getDetails['details'][0].uid != null"> {{getDetails['pts'][$index][0].total}} </span></td>
                                <td class="blockTrade" ng-class="statusInfo"  >
                                    <input ng-if="teamInfo.eliminated === 'No' && getDetails['details'][0]['points_distributed'] === 'No'" type="text" name="pts" ng-model="$parent.points"   placeholder="Trade">
                                    <span ng-if="getDetails['details'][0]['points_distributed'] === 'Yes' && teamInfo.eliminated === 'No'">Winner </span>
                                    <span  class="stage" ng-if="teamInfo.eliminated !== 'No'"><span>This Team had been Eliminated.</span></span>       

                                </td>
                                <td class="blockAction" >
                                    <button  ng-if="teamInfo.eliminated === 'No' && getDetails['details'][0]['points_distributed'] === 'No'" ng-click="trade(getDetails['details'][0].id, teamInfo.team['ID'], points, getDetails['details'][0].uid)" >Add</button>

                                </td>

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


                <h3 class="text-center mtb20">	Ongoing & Upcoming Matches</h3>
                <div class="bothsidebar">
                    <div class="row events small-thumbs">
                        <div class="row">
                            <div ng-repeat="matches in getDetails.matches" class="entry clearfix col-md-6">
                                <div class="entry-image hidden-sm">
                                    <a href={{matches['postLink']}}>
                                        <img src={{matches['img']}} alt="">
                                        <div class="entry-date"><span>{{matches['matchEndDate']}}</span></div>
                                    </a>
                                </div>
                                <div class="entry-c">
                                    <div class="entry-title">
                                        <h2><a href={{matches['postLink']}}>{{matches['title']}}</a></h2>
                                    </div>
                                    <ul class="entry-meta clearfix">

                                        <li><a href="#"><i class="icon-time"></i> {{matches['matchStartTime']}} - {{matches['matchEndTime']}}</a></li>
                                        <li><a href="#"><i class="icon-map-marker2"></i> {{matches['venue']}}</a></li>
                                    </ul>
                                    <div class="clearfix"></div>
                                    <div class="row mb15" ng-repeat="teams in matches['select_teams']">
                                        <div class="col-md-4">{{teams['team_name']['post_title']}}: </div>
                                        <div class="col-md-8" > <input type="text" ng-model="$parent.points[teams['team_name']['ID']]" ></div>
                                    </div>


                                    <div class="row mb15">
                                        <div class="col-md-4"> </div>
                                        <div class="col-md-8"><a href="#" onclick="return false" ng-click="tradeMatch(matches['postLink'], matches['id'], points, getDetails['details'][0].uid)" class="btn btn-danger">Trade</a></div>
                                    </div>





                                </div>
                            </div>
                        </div>


                    </div>

                </div>		


                <div class="table-responsive">
                    <table class="table table-bordered table-striped">

                        <thead>
                            <tr>
                                <th width="20%">Time / Location</th>
                                <th>Tournament</th>
                                <th>Team 1</th>
                                <th>Trade</th>
                                <th>V/S</th>
                                <th>Team 2</th>
                                <th>Trade</th>
                                <th>Action</th>
                                <th>Total Trade</th>
                            </tr>
                        </thead>
                        <tbody> 
                            <tr ng-repeat="matches in getDetails.matches">
                                <td><i class="icon-time"></i> {{matches['matchStartTime']}} - {{matches['matchEndTime']}} <br> <i class="icon-map-marker2"></i> {{matches['venue']}}</a></td>          
                                <td>Tournament Name</td>
                                <td><a href={{matches['postLink']}}>{{matches['title']}}</a></td>             
                                <td><input type="text" ng-model="$parent.points[teams['team_name']['ID']]" >
                                <br>Yor Trade : 5000K</td>
                                <td>V/S</td>
                                <td><a href={{matches['postLink']}}>{{matches['title']}}</a></td>
                                <td><input type="text" ng-model="$parent.points[teams['team_name']['ID']]" >
                                <br>Yor Trade : 5000K</td>
                                <td><a href="#" onclick="return false" ng-click="tradeMatch(matches['postLink'], matches['id'], points, getDetails['details'][0].uid)" class="btn btn-danger">Trade</a></td>
                                <td>10000K</td>
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