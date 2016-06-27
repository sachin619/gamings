<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
get_header();
?>

<section ng-controller="listingTour" class="bg-img-container"> 
    <!-- Page Title
            ============================================= -->
    <!-- #page-menu end -->

    <!-- Page Title
    ============================================= -->
    <section id="page-title">

        <div class="container clearfix">
            <h1><?=$_GET['category']?> Tournaments</h1>
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>

                <li class="active">Tournaments</li>
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
                <!-- <ul id="portfolio-filter" class="portfolio-filter clearfix" data-container="#portfolio">

                    <li class="" ng-class="{activeFilter: selectedIndex==='home' || selectedIndex===$index }"><a href="#" data-filter="*"  onclick="return false;" ng-click="filter('')"  >Show All</a></li>
                    <li ng-repeat="categories in getDetails.catName" ng-class="{activeFilter: $index===selectedIndex}"><a href="#" onclick="return false;" ng-click="filter(categories['catName'],$index)"  data-filter=".pf-{{categories['catName']}}">{{categories['catName']}}</a></li>

                </ul> --><!-- #portfolio-filter end -->

                <!-- <div id="portfolio-shuffle" class="portfolio-shuffle" data-container="#portfolio">
                    <i class="icon-random"></i>
                </div> -->

                <div class="clear"></div>
                <h2 ng-hide="tourListing.length">There are no tournaments at the moment please check again later!</h2>
                <!-- Portfolio Items
                ============================================= -->
                <div  ng-init="i = 1" class="portfolio grid-container portfolio-2 clearfix main-container">

                    <article ng-repeat="getPost in tourListing" class="col-md-4 pf-hide pf-media pf-{{getPost['category'][0]['name']}}" style="margin: 0 0 20px 0;">
                        <a href={{getPost['postLink']}}>
                        <div class="portfolio-image" ng-init="$parent.j = $parent.i = i + 1" >
                            
                                <img ng-src={{getPost['img']}} alt="Open Imagination" width="100%" height="200px">
                           
                            <!-- <div class="portfolio-overlay">
                                <a href={{getPost['postLink']}} ><i class="icon-link"></i></a>
                            </div> -->
                        </div>
                        <div class="portfolio-desc">
                            <h3>{{getPost['title']}} </h3>
                            <span>
                                <strong ng-if="getPost.mytradedTotal > 0">Total Trade: {{getPost.mytradedTotal}} Points</strong>
                                <br>
                                {{getPost['start_date']}} - {{getPost['end_date']}},  {{ getPost['venue'] | limitTo: 20 }}{{getPost['venue'].length > 20 ? '...' : ''}}
                            </span>
                        </div>
                         </a>
                    </article>
					<div class="clearfix"></div>

                </div><!-- #portfolio end -->
                <div class="col-lg-12" style="margin: 20px 0px;">
                <div class="col-md-4"></div>
                <div ng-if="i>=6" class="col-md-4 hide-loadMore">
                    <button type="button" class="btn btn-danger btn-lg btn-block "  ng-click="loadMore(getCat)">Load More </button>
                    <br>
                </div>
				
				
                <div class="col-md-4"></div>
                </div>
            </div>

        </div>

    </section><!-- #content end -->
</section>
<script src="<?= get_template_directory_uri() ?>/js/jquery.1.9.js"></script> 


<?php

get_footer();
?>
