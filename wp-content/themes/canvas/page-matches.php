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
            <h1>Ongoing / Upcoming Tournaments</h1>
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
                <ul id="portfolio-filter" class="portfolio-filter clearfix" data-container="#portfolio">

                    <li class="activeFilter"><a href="#" data-filter="*" onclick="return false;" ng-click="filter('All')">Show All</a></li>
                    <li ng-repeat="categories in getDetails.catName"><a href="#" onclick="return false;" ng-click="filter(categories['catName'])" data-filter=".pf-{{categories['catName']}}">{{categories['catName']}}</a></li>
                    
                </ul><!-- #portfolio-filter end -->

                <div id="portfolio-shuffle" class="portfolio-shuffle" data-container="#portfolio">
                    <i class="icon-random"></i>
                </div>

                <div class="clear"></div>

                <!-- Portfolio Items
                ============================================= -->
                <div  id="portfolio" class="portfolio grid-container portfolio-2 clearfix main-container">

                    <article ng-repeat="getPost in getDetails.catPost" class="portfolio-item pf-hide pf-media pf-{{getPost['category'][0]['name']}}">
                        <div class="portfolio-image">
                            <a href="{{getPost['postLink']}}">
                                <img src="{{getPost['img']}}" alt="Open Imagination">
                            </a>
                            <div class="portfolio-overlay">
                                <a href="{{getPost['postLink']}}" ><i class="icon-link"></i></a>
                            </div>
                        </div>
                        <div class="portfolio-desc">
                            <h3><a href="{{getPost['postLink']}}">{{getPost['title']}}</a></h3>
                            <span><strong>Total Trade: {{getDetails.tradeTotal[$index].total}} Points</strong>
                                <br>
                                {{getPost['start_date']}} - {{getPost['end_date']}}, {{getPost['venue']}}
                            </span>
                        </div>
                    </article>









                </div><!-- #portfolio end -->


            </div>

        </div>

    </section><!-- #content end -->
</section>
<?php

get_footer();
?>