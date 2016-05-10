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
            <h1>Ongoing / Upcoming Matches</h1>
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

                    <li class="" ng-class="{activeFilter: selectedIndex===$index || selectedIndex=='home' }"><a href="#" data-filter="*" onclick="return false;" ng-click="filter('',$index)">Show All</a></li>
                    <li ng-repeat="categories in getDetails.catName" ng-class="{activeFilter:selectedIndex===$index}"><a href="#" onclick="return false;"  ng-click="filter(categories['catName'],$index)" data-filter=".pf-{{categories['catName']}}">{{categories['catName']}}</a></li>
                </ul><!-- #portfolio-filter end -->

                <div id="portfolio-shuffle" class="portfolio-shuffle" data-container="#portfolio">
                    <i class="icon-random"></i>
                </div>

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
                                <th width="12%">Time / Location</th>
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
                            <tr>
                               <th colspan="9" style="background: rgba(0,0,0,0.05);">Today</thToday> 
                            </tr>
                            <tr ng-repeat="getPost in getDetails.catPost">
                                <td><i class="icon-time"></i> {{getPost['start_date']}} - {{getPost['end_date']}},
                                <br><i class="icon-map-marker2"></i> {{getPost['venue']}}
                                </td>          
                                <td><a href="#">Tournament Name</a></td>
                                <td><a href="{{getPost['postLink']}}">{{getPost['title']}}</a></td>             
                                <td><input type="text" ng-model="$parent.points[teams['team_name']['ID']]" >
                                <br>Yor Trade : 5000K</td>
                                <td>V/S</td>
                                <td><a href="{{getPost['postLink']}}">{{getPost['title']}}</a></td>
                                <td><input type="text" ng-model="$parent.points[teams['team_name']['ID']]" >
                                <br>Yor Trade : 5000K</td>
                                <td><a href="#" onclick="return false" ng-click="tradeMatch(matches['postLink'], matches['id'], points, getDetails['details'][0].uid)" class="btn btn-danger">Trade</a></td>
                                <td>10000K</td>
                            </tr>                            
                        </tbody>
                    </table>
                    </div>

                <div class="col-lg-12" ng-if="getDetails.catPost.length>=4" style="text-align: center">
                    <button type="button" class="btn btn-primary hide-loadMore" ng-click="loadMore(getCat, getDetails.catPost.length + 4)">Load More </button>
                </div>

            </div>

    </section><!-- #content end -->
</section>
<?php

get_footer();
?>