<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
get_header();
?>

<section ng-controller="listingMatch"> 
    <!-- Page Title
            ============================================= -->
    <!-- #page-menu end -->

    <!-- Page Title
    ============================================= -->
    <section id="page-title">

        <div class="container clearfix">
            <h1>Ongoing / Upcoming Matches - {{categoryName}}</h1>
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
                <div class="row">
                    <div class="col-lg-12 matches_banner">
                        <a href="#"> <img src="<?= get_template_directory_uri() ?>/images/matches_banner.jpg"></a>
                    </div>
                </div>
                <!-- Portfolio Filter
                ============================================= -->
                <ul id="portfolio-filter" class="portfolio-filter clearfix" data-container="#portfolio">
                    <li class="" ng-class="{activeFilter: selectedIndex === $index || selectedIndex == 'home' }"><a href="#" data-filter="*" onclick="return false;" ng-click="filter('popular')">Popular</a></li>
                    <li><a href="#" onclick="return false;"  ng-click="filter('all')" data-filter=".pf-{{categories['catName']}}">All Matches</a></li>
                    <li><a href="#" onclick="return false;"  ng-click="filter('today')" data-filter=".pf-{{categories['catName']}}">Today</a></li>
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
                    <table class="table table-bordered nobottommargin">

                        <thead>
                            <tr>
                                <th width="18%">Time and Location</th>
                                <th>Tournament</th>
                                <th>Team 1</th>
                                <th>Trade</th>
                                <th>Team 2</th>
                                <th>Trade</th>
                                <th>Action</th>
                                <th>Total Trade</th>
                            </tr>
                        </thead>
                        <tbody> 

                            <tr ng-repeat="matches in getDetails.catPost">
                                <td> {{matches['onlySDate']}}&nbsp;{{matches['matchStartTime']}} - {{matches['matchEndTime']}} <br> <!--<i ng-if="matches['venue'] != ''" class="icon-map-marker2"></i>--> {{matches['venue']}}</a></td>
                                <td><a href="{{matches['siteUrl'] + '/tournaments/' + matches['tournament_name']['post_name']}}">{{matches['tournament_name']['post_title']}}</a> <b>({{matches['category'][0]['name']}})</td>
                                <td  ng-repeat-start="teams in matches['select_teams']"> {{teams['team_name']['post_title']}} </td>
                                <td  ng-repeat-end> <input type="text" class="trade form-control" style="display: {{hideTrade}}" ng-model="$parent.points[teams['team_name']['ID']]" style="width: 100%;" placeholder=" Add Trade"> Your Trade: {{getDetails['tradeTotal'][matches['id']][$index][0]['total']}} <span ng-if="getDetails['tradeTotal'][matches['id']][$index][0]['total'] ==null"> 0</span>
                                    <b style="color:#d43f3a" ng-if="teams['winner'] == 'Yes'">Win</b> 
                                    <b style="color:#d43f3a" ng-if="teams['winner'] == 'No' && matches['points_distributed'] == 'Yes'">Lose</b>  </td>
                                <td><a href="#" style="display: {{hideTrade}}" onclick="return false" ng-click="tradeMatch(matches['postLink'], matches['id'], points, getDetails.catPost[0]['uid'])" class="btn btn-danger">Trade</a></td>
                                <td>{{matches["total_bets"]}} <span ng-if="matches['total_bets']=='' ">0</span></td>
                            </tr>                            
                        </tbody>
                    </table>
                </div>

                <div class="col-lg-12 loadMoreBlock" ng-if="getDetails.catPost.length >= 5" style="text-align: center">
                    <button type="button" class="btn btn-primary hide-loadMore" ng-click="loadMore(getCat, getDetails.catPost.length + 5)">Load More </button>
                </div>

            </div>

    </section><!-- #content end -->
</section>
<style>
    .loadMoreBlock{
        padding-top:6px;
    }
</style>
<?php
get_footer();
?>