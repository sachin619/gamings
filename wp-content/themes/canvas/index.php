<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
get_header();
?>
<style>

</style>
<section ng-controller="homeCtrl">

    <section  id="slider" class="slider-parallax" style="background-color: #222;">
        <div id="oc-slider" class="owl-carousel carousel-widget" data-margin="0" data-items="1" data-pagi="false" data-loop="true" data-speed="450" data-autoplay="5000">

            <?php
            $slider = api($apiEndpoint . "get-slider");
            foreach ($slider as $sliderImg):
                ?>
                <a href="#"><img ng-src="<?= $sliderImg['img'] ?>" alt="Slider"></a>
            <?php endforeach ?>

        </div>

    </section>
   <!-- Content
    ============================================= -->
    <section id="content" class="">

        <div class="content-wrap">

            <div class="container clearfix">
                <div class="center">
                    <h2>POPULAR MATCHES</h2>
                    <div class="divider divider-short divider-center"><i class="icon-circle-blank"></i></div>

                </div>

<div class="container clearfix">

                <!-- Portfolio Filter
                ============================================= -->

                <div class="clear"></div>

                <div class="table-responsive">
                    <table class="table table-bordered nobottommargin">

                        <thead>
                            <tr>
                                <th width="18%">Time / Location</th>
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
<!--                     {{home['upcomingMatches']['catPost']}}-->
                            <tr ng-repeat="matches in homeMatchListing['upcomingMatches']['catPost']">
                                <td> {{matches['onlySDate']}}<br> {{matches['matchStartTime']}} - {{matches['matchEndTime']}} <br> <!--<i ng-if="matches['venue']!=''" class="icon-map-marker2"></i>--> {{matches['venue']}}</a></td>
                                <td><a href="{{matches['siteUrl']+'/tournaments/'+matches['tournament_name']['post_name']}}">{{matches['tournament_name']['post_title']}}</a></td>
                                <td  ng-repeat-start="teams in matches['select_teams']"><b>{{teams['team_name']['post_title']}}</b></td>
                                <td  ng-repeat-end> <input type="text" ng-model="$parent.points[teams['team_name']['ID']]" style="width: 100%;" placeholder=" Add Trade" ><br>Your Trade : {{homeMatchListing['upcomingMatches']['tradeTotal'][matches['id']][$index][0]['total']}} </td>
                                <td><a href="#" onclick="return false" ng-click="tradeMatch(matches['postLink'], matches['id'], points,homeMatchListing['upcomingMatches']['catPost'][0]['uid'])" class="btn btn-danger">Trade</a></td>
                                <td>{{matches["total_bets"]}}</td>
                            </tr>                            
                        </tbody>
                    </table>
                </div>

                <div class="col-lg-12 loadMoreBlock" ng-if="homeMatchListing['upcomingMatches']['catPost'].length >= 5" style="text-align: center">
                    <button type="button" class="btn btn-primary hide-loadMore" ng-click="loadMore(getCat, homeMatchListing['upcomingMatches']['catPost'].length + 5)">Load More </button>
                </div>

            </div>

                <div class="clear"></div><!-- <div class="line"></div> -->

            </div>

        </div>

    </section><!-- #content end -->

  
    <!-- Content
    ============================================= -->
    <section id="content" >

        <div class="content-wrap">

            <div class="container clearfix">
                <div class="center">
                    <h2>POPULAR TOURNAMENTS</h2>
                    <div class="divider divider-short divider-center"><i class="icon-circle-blank"></i></div>

                </div>
                <data-owl-carousel class="owl-carousel" data-options="{navigation: true, pagination: false, rewindNav : false}">
                    <div owl-carousel-item="" ng-repeat="popular in home.popularTournaments" >
                        <div class="ipost clearfix">
                            <div class="feature-box center media-box fbox-bg">
                                <div class="fbox-media">
                                    <a href={{popular.postLink}}><img class="image_fade" ng-src={{popular.img}} alt={{popular.title}}></a>
                                </div>
                                <div class="fbox-desc">
                                    <h3 class="imagetex">{{popular.title}}<span class="subtitle">{{popular.start_date}} &nbsp;To &nbsp;{{ popular.end_date}}</span><span>{{popular.venue}}</span></h3>
                                    <h3><span class="subtitle" ng-if="popular.total_tour_bets > 0">Total Points Traded So far: {{popular.total_tour_bets}} Points</span></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </data-owl-carousel>

                <div class="clear"></div><!-- <div class="line"></div> -->

            </div>

        </div>

    </section><!-- #content end -->

   <!-- Content
    ============================================= -->
    <section id="content" >

        <div class="content-wrap">

            <div class="container clearfix">
                <div class="center">
                    <h2>UPCOMING TOURNAMENTS</h2>



                    <div class="divider divider-short divider-center"><i class="icon-circle-blank"></i></div>	
                </div>



                <data-owl-carousel class="owl-carousel" data-options="{navigation: true, pagination: false, rewindNav : false}">
                    <div owl-carousel-item="" ng-repeat="slide in  home.upcomingTournaments" class="item">
                        <div class="ipost clearfix">
                            <div class="feature-box center media-box fbox-bg">
                                <div class="fbox-media">
                                    <a href={{slide.postLink}}><img class="image_fade" ng-src="{{slide.img}}" alt="{{ slide.title}}"></a>
                                </div>
                                <div class="fbox-desc">
                                    <h3 class="imagetex">{{slide.title}}<span class="subtitle">{{ slide.start_date}} &nbsp;To &nbsp;{{ slide.end_date}}</span><span>{{ slide.venue}}</span></h3>
                                    <h3><span class="subtitle" ng-if="slide.total_tour_bets > 0">Total Points Traded So far: {{slide.total_tour_bets}} Points</span></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </data-owl-carousel>
                <div class="clear"></div><!-- <div class="line"></div> -->

            </div>

        </div>

    </section><!-- #content end -->

    <!-- Content
    ============================================= -->
    <section id="content" class="hide">

        <div class="content-wrap">

            <div class="container clearfix">
                <div class="center">
                    <h2>UPCOMING MATCHES</h2>
                    <div class="divider divider-short divider-center"><i class="icon-circle-blank"></i></div>

                </div>

                <data-owl-carousel class="owl-carousel" data-options="{navigation: true, pagination: false, rewindNav : false}">
                    <div owl-carousel-item="" ng-repeat="upcomMat in home.upcomingMatches" class="item">
                        <div class="ipost clearfix">
                            <div class="feature-box center media-box fbox-bg">
                                <div class="fbox-media">
                                    <a href="{{upcomMat.postLink}}"><img class="image_fade" ng-src="{{upcomMat.img}}" alt="{{ upcomMat.title}}"></a>
                                </div>
                                <div class="fbox-desc">
                                    <h3 class="imagetex">{{upcomMat.title}}<span class="subtitle">{{upcomMat.start_date}} &nbsp;To &nbsp;{{upcomMat.end_date}}</span><span>{{upcomMat.venue}}</span></h3>
                                    <h3><span class="subtitle" ng-if="upcomMat.total_bets > 0">Total Points Traded So far: {{upcomMat.total_bets}} Points</span></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </data-owl-carousel>
                <div class="clear"></div><!-- <div class="line"></div> -->

            </div>

        </div>

    </section><!-- #content end -->
    <!-- Content
    ============================================= -->
    <section id="content" class="hide">

        <div class="content-wrap">

            <div class="container clearfix">


                <data-owl-carousel class="owl-carousel" data-options="{navigation: true, pagination: false, rewindNav : false}">
                    <div owl-carousel-item="" ng-repeat="categories in home.category" class="item">
                        <a href={{home.siteUrl}}/tournaments/?category={{categories['name']}}>
                            <div class="ipost clearfix">
                                <div class="feature-box center media-box fbox-bg">
                                    <div class="team">
                                        <div class="team-desc team-desc-bg">
                                            <div class="team-title">
                                                <h4>{{categories['name']}} </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </data-owl-carousel>                           

                <div class="clear"></div><!-- <div class="line"></div> -->

            </div>

        </div>

    </section><!-- #content end -->



    <!-- Content
    ============================================= -->
    <section id="content">

        <div class="content-wrap">

            <div class="container clearfix">
                <div class="">
                    <div class="container clearfix">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="center">
                                    <h2>ABOUT LAGAYEGA.COM</h2>
                                    <div class="divider divider-short divider-center"><i class="icon-bookmark"></i></div>
                                </div>
                                <p class="nobottommargin">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                </p>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="clear"></div><!-- <div class="line"></div> -->

            </div>

        </div>

    </section><!-- #content end -->
</section>
<?php get_footer(); ?>
