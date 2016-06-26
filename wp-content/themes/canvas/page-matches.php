<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
get_header();
?>

<section ng-controller="listingMatch" class="bg-img-container"> 
    <!-- Page Title
            ============================================= -->
    <!-- #page-menu end -->

    <!-- Page Title
    ============================================= -->
    <section id="page-title">

        <div class="container clearfix">
            <h1>{{categoryName}} Matches</h1>
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>

                <li class="active">Matches</li>
            </ol>
        </div>

    </section><!-- #page-title end -->

    <!-- Content
    ============================================= -->
    <section id="content">

        <div class="content-wrap">

            <div class="container clearfix">

                <!-- Portfolio Filter
                ============================================= -->
                <ul id="portfolio-filter" class="portfolio-filter clearfix" data-container="#portfolio">
                    <li class="" ng-class="{activeFilter: selectedIndex === $index || selectedIndex == 'home' }"><a href="#" data-filter="*" onclick="return false;" ng-click="filter('popular')">Popular</a></li>
                    <li><a href="#" onclick="return false;"  ng-click="filter('upcomming')" data-filter=".pf-{{categories['catName']}}">Upcoming</a></li>
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

                <!-- Portfolio Items
                ============================================= -->
                <!-- <div  ng-init="i=1"  id="portfolio" class="portfolio grid-container portfolio-2 clearfix main-container">
                    <article ng-repeat="getPost in getDetails.catPost" class="col-md-4 pf-hide pf-media pf-{{getPost['category'][0]['name']}}">
                        <div ng-init="$parent.j=$parent.i=i+1" class="portfolio-image" >
                            <a href="{{getPost['postLink']}}">
                                <img src="{{getPost['img']}}" alt="Open Imagination">
                            </a>
                            <div class="portfolio-overlay">
                                <a href="{{getPost['postLink']}}" ><i class="icon-link"></i></a>
                            </div>
                        </div>
                        <div class="portfolio-desc">
                            <h3><a href="{{getPost['postLink']}}">{{getPost['title']}}</a></h3>
                            <span ><strong ng-if="getDetails.tradeTotal[$index].total>0">Total Trade: {{getDetails.tradeTotal[$index].total}} Points</strong>
                                <strong ng-if="getDetails.tradeTotal[$index].total<=0">Total Trade : Not yet bet</strong>
                                <br>
                                {{getPost['start_date']}} - {{getPost['end_date']}}, {{getPost['venue']}}
                            </span>
                        </div>
                    </article>

                    

                </div> --><!-- #portfolio end -->


                <div class="table-responsive">
                    <table class="table table-bordered table-striped nobottommargin">

                        <thead>
                            <tr>
                                <th width="18%">Time &amp; Location</th>
                                <th>Tournament</th>
                                <th>Team 1</th>
                                <th>Trade</th>
                                <th>Team 2</th>
                                <th>Trade</th>
                                <th>Trade For Tie</th>
                                <th> Action</th>
                                <th>Total Trade</th>

                            </tr>
                        </thead>
                        <tbody > 

                            <tr ng-repeat="matches in homeMatchListing">
                                <td> {{matches['matchStartDate']}}&nbsp;{{matches['matchStartTime']}} - {{matches['matchEndTime']}} <br> <!--<i ng-if="matches['venue'] != ''" class="icon-map-marker2"></i>--> {{matches['venue']}}</a></td>
                                <td ng-init="count = $index"><a href="{{matches['siteUrl'] + '/tournaments/' + matches['tournament_name']['post_name']}}">{{matches['tournament_name']['post_title']}}</a></td>
                                <td  ng-repeat-start="teams in matches['select_teams']"> {{teams['team_name']['post_title']}} <br> 
                                    <b style="color:green" ng-if="teams['winner'] == 'Yes'">Winner</b> 
                                    <b style="color:green" ng-if="matches['match_draw'] == 'Yes'">Tie</b>
                                    <b style="color:green" ng-if="matches['match_abandoned'] == 'Yes'">Canceled</b> 
                                </td>
                                <td  ng-repeat-end> 
                                    <input type="text"   class="trade form-control" style="display: {{hideTrade}};width: 100%; margin: 0 0 5px 0;" ng-model="$parent.$parent.points[teams['team_name']['ID']]" ng-if="matches['points_distributed'] === 'No' && matches['ong'] == 'No' && matches['uid'] != null" style="width: 100%;" placeholder=" Add Trade" >
                                    <span class="{{matches['id']}}-{{teams['team_name']['ID']}}">{{matches['mytradedTotal'][teams['team_name']['ID']]!==null ? "You've traded " + matches['mytradedTotal'][teams['team_name']['ID']] +" Pts." : ""}} </span>

<!--                                     <span ng-if=" (hideTrade != 'block' && hideTrade != null  ) || (homeMatchListing['uid']==null && matches['mytradedTotal'][teams['team_name']['ID']]==null)  ">-</span>-->
                                    <span ng-if="(category != 'upcomming' && category != 'popular' && matches['mytradedTotal'][teams['team_name']['ID']]==null) || (matches['uid'] == null && (category == 'upcomming' || category == 'popular'))">-</span>

                                </td>
                                <td>
                                    <input type="text"   class="trade form-control" style="display: {{hideTrade}} ;width: 100%; margin: 0 0 5px 0;" ng-model="$parent.$parent.pointsTie[$index]" ng-if="matches['points_distributed'] === 'No' && matches['ong'] == 'No' && matches['uid'] != null"  placeholder=" Add Trade" >
                                    <span class="{{matches['id']}}-tie"> {{matches['mytradedTotal']['mytradedTie']!==null? " You've traded "+ matches['mytradedTotal']['mytradedTie']+" Pts.":"" }} </span>
                                    <span ng-if="(matches['mytradedTotal']['mytradedTie'] == null && hideTrade != 'block' && hideTrade != null) || (matches['uid'] == null && (category == 'upcomming' || category == 'popular'))">-</span>

                                </td>
                                <td> 
                                    <button style="display: {{hideTrade}}"   ng-click="tradeMatch(matches['postLink'], matches['id'], points, homeMatchListing[0]['uid'], pointsTie[$index], $event)" class="btn btn-danger" ng-if="matches['points_distributed'] == 'No' && matches['ong'] == 'No'" >Trade </button>
                                    <span ng-if=" (hideTrade != 'block' && hideTrade != null)">-</span>

                                </td>
                                <td> <span class="{{matches['id']}}-totalMid">{{ matches['mytradedTotal']['tourTotal']}}</span> <span ng-if=" matches['mytradedTotal']['tourTotal'] == ''">0</span></td>
                            </tr>    
                            <tr  ng-hide="homeMatchListing.length"><td colspan="9" align="center">There are no matches at the moment please check again later!</td></tr>

                        </tbody>
                    </table>
                </div>

                <div class="col-lg-12 loadMoreBlock" ng-if="homeMatchListing.length >= 10" style="text-align: center">
                    <br>
                    <button type="button" class="btn btn-danger loadMoreBtn hide-loadMore" ng-click="loadMore(getCat)">Load More </button>
                    <br>
                </div>
                <br>

                <div class="row banner-match">
                    <div class="col-lg-12 matches_banner">
                        <a href="#"> <img src="<?= get_template_directory_uri() ?>/images/matches_banner.jpg"></a>
                    </div>
                </div>
            </div>

    </section><!-- #content end -->
</section>
<style>
    .loadMoreBlock{
        padding-top:6px;
    }
    .loadMoreBtn{
        background-color:#d9534f;
        border-color: #d9534f;
    }
</style>

<?php
get_footer();
?>