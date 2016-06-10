<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
get_header();
?>
<section ng-controller="tourDetails" class="bg-img-container">
    <!-- Page Title
            ============================================= -->
    <!--<section id="page-title">

        <div class="container clearfix">

            <h1 >{{getDetails['details'][0].title}}</h1>
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">Tournaments</a></li>
                <li class="active">{{getDetails['details'][0].title}}</li>
            </ol>
        </div>

    </section>--><!-- #page-title end -->

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
                                            <span class="nobg"><img class="profilimg" ng-src={{getDetails['details'][0].img}} alt={{getDetails['details'][0].title}}></span>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="profile_text">
                                            <div class="entry-title">
                                                <h2 class="ng-binding">{{getDetails['details'][0].title}} </h2>
                                                <p class="ng-binding">{{getDetails['details'][0].description}}</p>
                                                <p class="ng-binding">Time & Location: {{getDetails['details'][0].start_date}} – {{getDetails['details'][0].end_date}} ({{getDetails['details'][0].venue}})</p>
                                                <p>Official Website: <a href={{getDetails['details'][0].website_link}} target="_blank" class="celeb-web ng-binding">{{getDetails['details'][0].website_link}}</a></p>
                                                <p ng-if="getDetails['details'][0].premium > 1">Premium Value: {{getDetails['details'][0].premium}} </p>
                                                <h4 ng-if="getDetails['totalBets'][0].total > 0">Total Points Traded So Far: {{getDetails['totalBets'][0].total}} Points</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div></section>

    <!-- Content
    ============================================= -->
    <section>

        <div class="content-wrap">

            <div class="container clearfix">

                <!--<div class="row">

                    <div class="col-md-6">		
                        <div class="entry-image">

                            <a href={{getDetails['details'][0].postLink}}><img ng-src={{getDetails['details'][0].img}} alt={{getDetails['details'][0].title}}></a>
                        </div>



                    </div>
                    <div class="col-md-6">
                        <p class="mb20">{{getDetails['details'][0].description}}</p>
                        <p class="bld mb20">{{getDetails['details'][0].start_date}}– {{getDetails['details'][0].end_date}} ({{getDetails['details'][0].venue}})</p>
                        <p class="mb20"><span class="bld"> Official Website: </span><a href={{getDetails['details'][0].website_link}} target="_blank">{{getDetails['details'][0].website_link}}</a></p>


                        <h4 ng-if="getDetails['totalBets'][0].total > 0">Total Points Traded So far: {{getDetails['totalBets'][0].total}} Points</h4>

                        <h5 ng-if="getDetails['details'][0].premium > 1">Premium value : {{getDetails['details'][0].premium}} </h5>
                    </div>

                </div>-->

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
                                <td > <span ng-if="getDetails['details'][0].uid != null"> {{getDetails['pts'][$index][0].total}} </span> <span ng-if="getDetails['pts'][$index][0].total == null">0</span> </td>
                                <td class="blockTrade" ng-class="statusInfo"  >
                                    <input ng-if="(teamInfo.eliminated === 'No' && getDetails['details'][0]['points_distributed'] === 'No') && getDetails['details'][0].uid != null" type="text" name="pts" ng-model="$parent.points"   placeholder="Trade">
                                    <span ng-if="getDetails['details'][0]['points_distributed'] === 'Yes' && teamInfo.eliminated === 'No' && getDetails['details'][0]['tournament_draw']!='Yes' &&  getDetails['details'][0]['tournament_abandoned']!='Yes' ">Winner </span>
                                    <span  class="stage" ng-if="teamInfo.eliminated !== 'No'"><span>Eliminated!</span></span>  
                                    <span ng-if="(getDetails['details'][0].uid == null && teamInfo.eliminated != 'Yes' && getDetails['details'][0]['points_distributed']=='No' ) ">-</span>
                                    <span  class="stage" ng-if="getDetails['details'][0]['tournament_draw']!= 'No' && teamInfo.eliminated== 'No'"><span>Tie</span></span> 
                                    <span  class="stage" ng-if="getDetails['details'][0]['tournament_abandoned']!= 'No' && teamInfo.eliminated== 'No'"><span>Canceled</span></span> 
                                </td>
                                <td class="blockAction" >
                                    <button class="btn btn-danger" ng-if=" (getDetails['details'][0].uid==null) ||( teamInfo.eliminated === 'No' && getDetails['details'][0]['points_distributed'] === 'No')" ng-click="trade(getDetails['details'][0].id, teamInfo.team['ID'], points, getDetails['details'][0].uid)" >Trade</button>
                                </td>
                            </tr>

                            <tr>
                                <td>Trade For Tie </td>
                                <td>{{getDetails['tradeTie']!=null?getDetails['tradeTie']:0}} </td>
                                <td>
                                    <input ng-if="getDetails['details'][0].uid!=null && getDetails['details'][0]['points_distributed'] != 'Yes' " type="text" name="pts" ng-model="$parent.pointsTie"   placeholder="Trade"> 
                                    <span ng-if="(getDetails['details'][0].uid==null) || (getDetails['details'][0]['points_distributed'] == 'Yes' )">-</span></td>
                                <td><button class="btn btn-danger" ng-if="(getDetails['details'][0].uid==null) || (getDetails['details'][0]['points_distributed'] != 'Yes' )"  ng-click="trade(getDetails['details'][0].id, '0', pointsTie, getDetails['details'][0].uid)" >Trade</button> </td>
                            </tr>


                            <tr>
                                <th>Total</th>
                                <th>{{ getDetails['userTotalTrade']}} </th>
                                <th> </th>
                                <th></th>
                            </tr>




                        </tbody>
                    </table>
                </div>


                <!-- <div class="bothsidebar">
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
                </div> -->		


            </div>

        </div>

    </section><!-- #content end -->

    <section id="content">
        <h3 class="text-center mtb20">Upcoming Matches</h3>

        <div class="content-wrap">

            <div class="container clearfix">

                <!-- Portfolio Filter
                ============================================= -->
                <ul id="portfolio-filter" class="portfolio-filter clearfix" data-container="#portfolio">

                    <li ng-class="{activeFilter: selectedIndex === $index || selectedIndex == 'home' }"><a href="#" onclick="return false;"  ng-click="filter('upcomming')" data-filter=".pf-{{categories['catName']}}">Upcoming</a></li>
                    <li class="hide"><a href="#" onclick="return false;"  ng-click="filter('today')" data-filter=".pf-{{categories['catName']}}">Today</a></li>
                    <li><a href="#" onclick="return false;"  ng-click="filter('daysBefore')" data-filter=".pf-{{categories['catName']}}">Completed</a></li>
                    <li><a href="#" onclick="return false;"  ng-click="filter('ongoing')" data-filter=".pf-{{categories['catName']}}">In Play</a></li>
                </ul>
                <!-- <ul id="portfolio-filter" class="portfolio-filter clearfix" data-container="#portfolio">

                    <li class="" ng-class="{activeFilter: selectedIndex===$index || selectedIndex=='home' }"><a href="#" data-filter="*" onclick="return false;" ng-click="filter('',$index)">Show All</a></li>
                    <li ng-repeat="categories in getDetails.catName" ng-class="{activeFilter:selectedIndex===$index}"><a href="#" onclick="return false;"  ng-click="filter(categories['catName'],$index)" data-filter=".pf-{{categories['catName']}}">{{categories['catName']}}</a></li>
                </ul> --><!-- #portfolio-filter end -->

                <!-- <div id="portfolio-shuffle" class="portfolio-shuffle" data-container="#portfolio">
                    <i class="icon-random"></i>
                </div> -->

                <div class="clear"></div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped nobottommargin">

                        <thead>
                            <tr>
                                <th width="18%">Time and Location</th>
                                <th>Tournament</th>
                                <th>Team 1</th>
                                <th>Trade</th>
                                <th>Team 2</th>
                                <th>Trade</th>
                                <th>Trade For Tie</th>
                                <th>Total Trade</th>
                            </tr>
                        </thead>
                        <tbody > 

                            <tr ng-repeat="matches in getMatchDetails.catPost">
                                <td> {{matches['onlySDate']}}&nbsp;{{matches['matchStartTime']}} - {{matches['matchEndTime']}} <br> <!--<i ng-if="matches['venue'] != ''" class="icon-map-marker2"></i>--> {{matches['venue']}}</a></td>
                                <td ng-init="count = $index"><a href="{{matches['siteUrl'] + '/tournaments/' + matches['tournament_name']['post_name']}}">{{matches['tournament_name']['post_title']}}</a></td>
                                <td  ng-repeat-start="teams in matches['select_teams']"> {{teams['team_name']['post_title']}} <br> 
                                    <b style="color:green" ng-if="teams['winner'] == 'Yes'">Winner</b> 
                                    <b style="color:green" ng-if="matches['match_draw'] == 'Yes'">Tie</b>
                                    <b style="color:green" ng-if="matches['match_abandoned'] == 'Yes'">Canceled</b> 
                                </td>
                                <td  ng-repeat-end> 
                                    <input type="text"   class="trade form-control" style="display: {{hideTrade}}" ng-model="$parent.$parent.points[$index][teams['team_name']['ID']]" ng-if="matches['points_distributed'] === 'No' && matches['ong'] == 'No' && matches['uid'] != null" style="width: 100%;" placeholder=" Add Trade" >
                                    <span ng-if="getMatchDetails['tradeTotal'][matches['id']][$index][0]['total'] != null && matches['uid'] != null"> You've traded {{getMatchDetails['tradeTotal'][matches['id']][$index][0]['total']}} Pts. </span>
                                    <span ng-if=" hideTrade != 'block' && hideTrade != null && getMatchDetails['tradeTotal'][matches['id']][$index][0]['total'] == null">-</span>
                                    <a href="#" style="display: {{hideTrade}}" onclick="return false" ng-click="tradeMatch(matches['postLink'], matches['id'], points[$index], getMatchDetails.catPost[0]['uid'])" class="btn btn-danger" ng-if="matches['points_distributed'] == 'No' && matches['ong'] == 'No'">Trade </a>
                                </td>
                                <td>
                                    <input type="text"   class="trade form-control" style="display: {{hideTrade}}" ng-model="$parent.$parent.pointsTie[$index][0]" ng-if="matches['points_distributed'] === 'No' && matches['ong'] == 'No' && matches['uid'] != null" style="width: 100%;" placeholder=" Add Trade" >
                                    <span ng-if="getMatchDetails['tradeTie'][$index] != null"> You've traded {{getMatchDetails["tradeTie"][$index]}} Pts </span>
                                    <span ng-if="getMatchDetails['tradeTie'][$index] == null && hideTrade != 'block' && hideTrade != null"> - </span>
                                    <a href="#" style="display: {{hideTrade}}" onclick="return false" ng-click="tradeMatch(matches['postLink'], matches['id'], pointsTie[$index], getMatchDetails.catPost[0]['uid'])" class="btn btn-danger" ng-if="matches['points_distributed'] == 'No' && matches['ong'] == 'No'">Trade </a>
                                </td>
                                <td>{{matches["total_bets"]}} <span ng-if="matches['total_bets'] == ''">0</span></td>
                            </tr>  

                            <tr  ng-hide="getMatchDetails.catPost.length"><td colspan="8" align="center">There are no open matches at the moment please check again later!</td></tr>

                        </tbody>
                    </table>
                </div>

                <div class="col-lg-12 loadMoreBlock" ng-if="getMatchDetails.catPost.length >= 50" style="text-align: center">
                    <br>
                    <button type="button" class="btn btn-danger hide-loadMore" ng-click="loadMore(getCat, getMatchDetails.catPost.length + 50)">Load More </button>
                </div>

            </div>

    </section><!-- #content end -->     

    <!-- Footer
    ============================================= -->
</section>
<?php
get_footer();
?>