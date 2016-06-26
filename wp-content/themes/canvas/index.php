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
<section ng-controller="homeCtrl" class="bg-img-container">

    <section  id="slider" class="slider-parallax clearfix" style="background-color: #222;">
        <div id="oc-slider" class="owl-carousel carousel-widget" data-margin="0" data-items="1" data-pagi="false" data-loop="true" data-speed="450" data-autoplay="5000">

            <?php
            $slider = api($apiEndpoint . "get-slider");
            foreach ($slider as $sliderImg):
                ?>
                <a href="#"><img ng-src="<?= $sliderImg['img'] ?>" alt="Slider"></a>
            <?php endforeach ?>

        </div>

    </section>







    <div class="clearfix"></div>
    <section  id="slider" class="slider-parallax clearfix" style="background-color: #222;">
        <img src="<?= get_template_directory_uri() ?>/images/cricket-stadium-1920x1080-image-1.jpg" class="img-responsive" alt="Banner">

    </section>
    <div class="clearfix"></div>


    <!-- Content
     ============================================= -->
    <section id="content">

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
                                    <th>Action</th>
                                    <th>Total Trade</th>
                                </tr>
                            </thead>
                            <tbody > 
                                <!--                     {{home['upcomingMatches']['catPost']}}-->
                                <tr ng-repeat="matches in homeMatchListing" >
                                    <td > {{matches['matchStartDate']}}&nbsp;{{matches['matchStartTime']}} - {{matches['matchEndTime']}} <br> <!--<i ng-if="matches['venue']!=''" class="icon-map-marker2"></i>--> {{matches['venue']}}</a></td>
                                    <td><a href="{{matches['siteUrl'] + '/tournaments/' + matches['tournament_name']['post_name']}}">{{matches['tournament_name']['post_title']}}</a><b> ({{matches['category'][0]['name']}})</td>
                                    <td  ng-repeat-start="teams in matches['select_teams']"> {{teams['team_name']['post_title']}} </td>
                                    <td  ng-repeat-end> 
                                        <input type="text" class="form-control" ng-model="$parent.$parent.points[teams['team_name']['ID']]" style="width: 100%; margin: 0 0 5px 0;" placeholder=" Add Trade" ng-if="matches['uid'] != null" > 
                                        <span class="{{matches['id']}}-{{teams['team_name']['ID']}}">{{matches['mytradedTotal'][teams['team_name']['ID']]!==null ? "You've traded " + matches['mytradedTotal'][teams['team_name']['ID']] +" Pts." : ""}} </span>
                                        <span ng-if="matches['uid'] == null">-</span>
                                    </td>
                                    <td>
                                        <input type="text"   class="trade form-control" style="display: {{hideTrade}}; width: 100%; margin: 0 0 5px 0;" ng-model="$parent.$parent.pointsTie[$index]" ng-if="matches['points_distributed'] === 'No' && matches['ong'] == 'No' && matches['uid'] != null" placeholder=" Add Trade" >
                                        <span class="{{matches['id']}}-tie"> {{matches['mytradedTotal']['mytradedTie']!==null? " You've traded "+ matches['mytradedTotal']['mytradedTie']+" Pts.":"" }} </span>
                                        <span ng-if="matches['uid'] == null">-</span>
                                    </td>

                                    <td>
                                        <button  ng-click="tradeMatch(matches['postLink'], matches['id'], points, homeMatchListing[0]['uid'], pointsTie[$index],$event)" class="btn btn-danger" >Trade </button>
                                    </td>
                                    <td ><span class="{{matches['id']}}-totalMid">{{matches['mytradedTotal']['tourTotal']}}</span></td>
                                </tr> 
                                <tr  ng-hide="homeMatchListing.length"><td colspan="9" align="center">There are no  matches at the moment please check again later!</td></tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-lg-12 loadMoreBlock" ng-if="homeMatchListing.length >= 5" style="text-align: center; margin: 20px 0px;">
                        <button type="button" class="btn btn-danger hide-loadMore" ng-click="loadMore(getCat, 1)">Load More </button>
                    </div>

                </div>

                <div class="clear"></div><!-- <div class="line"></div> -->

            </div>

        </div>

    </section><!-- #content end -->


    <!-- Content
    ============================================= -->
    <section id="content" >

        <div class="content-wrap padd-top0">

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
                                    <h3 class="imagetex">{{popular.title}} <b>({{popular['category'][0]['name']}})<span class="subtitle">{{popular.start_date}} &nbsp;To &nbsp;{{ popular.end_date}}</span>
                                            <span> {{ popular['venue'] | limitTo: 30 }}{{popular['venue'].length > 30 ? '...' : ''}}</span></h3>
                                    <h3><span class="subtitle" ng-if="popular.total_tour_bets > 0">Total Points Traded : {{popular.total_tour_bets}} Points</span></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </data-owl-carousel>

                <div class="clear"></div><!-- <div class="line"></div> -->

            </div>

        </div>

    </section>
	<!-- #content end -->


    <!-- Content
     ============================================= -->



    <section id="content" class="hide">

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
                                    <h3><span class="subtitle" ng-if="slide.total_tour_bets > 0">Total Points Traded : {{slide.total_tour_bets}} Points</span></h3>
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
                                    <h3><span class="subtitle" ng-if="upcomMat.total_bets > 0">Total Points Traded : {{upcomMat.total_bets}} Points</span></h3>
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


    <div class="container clearfix hidden-lg hidden-md">

        <div class="row topmargin-sm">

            <div class="heading-block center">
                <h3>Leadeboard</h3>
                <span class="divcenter">{{home.leaderBoard['startDate']}} - {{home.leaderBoard['endDate']}}</span>
            </div>

            <div class="col-md-3 col-sm-6 bottommargin" ng-repeat="leaderBoard in home.leaderBoard['info']">
                <div class="team">
                    <div class="team-image">
                        <img ng-if="home.leaderBoard['getUserImg'][$index] == null && leaderBoard['fbUrl'] == null" ng-src="<?= get_template_directory_uri() ?>/images/icons/avatar.jpg" alt="img">
                        <img ng-if="home.leaderBoard['getUserImg'][$index] != null && leaderBoard['fbUrl'] == null" ng-src="{{home.leaderBoard['getUserImg'][$index]}}" alt="img">
                        <img ng-if="leaderBoard['fbUrl'] != null" ng-src="https://graph.facebook.com/{{leaderBoard['fbUrl']}}/picture?type=large" alt="img">
                    </div>                               
                    <div class="team-desc team-desc-bg" style="height:auto; background:#eee;">
                        <div class="team-title" style="padding-top: 15px;">
                            <h4>{{leaderBoard['userName']}}</h4>
                            <span>Points : {{leaderBoard['pts']}}</span>
                        </div>
                    </div>
                </div>
            </div>    


            <div class="col-md-6 col-md-offset-5" style="margin-bottom: 40px;">    
                <a href="#" data-toggle="modal" data-target="#leadeBoard" class="button button-border button-dark button-rounded">View Prize & Other Details</a>
            </div>
        </div>
    </div>


    <!-- Content
    ============================================= -->
    <section id="content">

        <div class="content-wrap padd-top0">

            <div class="container clearfix">
                <div class="">
                    <div class="container clearfix">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="center">
                                    <h2 class="aboutTitle">ABOUT EVENT EXCHANGE</h2>
                                    <div class="divider divider-short divider-center"><i class="icon-circle-blank"></i></div>
                                </div>
                                <div class="aboutUs">
                                    
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="clear"></div><!-- <div class="line"></div> -->

            </div>

        </div>

    </section><!-- #content end -->



    <section  class="foot-fix hidden-sm hidden-xs popupLeaderBoard">
        <div class="container" >
            <div class="sticy_foot row">
                <div class="col-md-2 foot-col">
                    <h6>Leadeboard</h6>
                    <p class="crly_brk"> {{home.leaderBoard['startDate']}} - {{home.leaderBoard['endDate']}}</p>
                    <img src="<?= get_template_directory_uri() ?>/images/curly_brk.png" alt="img" style="margin:0 0 0 5px;">
                </div>
                <div class="col-md-2 foot-col" ng-repeat="leaderBoard in home.leaderBoard['info']" >
                    <div class="testi-image">
                        <img ng-if="home.leaderBoard['getUserImg'][$index] == null && leaderBoard['fbUrl'] == null" ng-src="<?= get_template_directory_uri() ?>/images/icons/avatar.jpg" alt="img">
                        <img ng-if="home.leaderBoard['getUserImg'][$index] != null && leaderBoard['fbUrl'] == null" ng-src="{{home.leaderBoard['getUserImg'][$index]}}" alt="img">
                        <img ng-if="leaderBoard['fbUrl'] != null" ng-src="https://graph.facebook.com/{{leaderBoard['fbUrl']}}/picture?type=large" alt="img">
                    </div>
                    <h6>{{leaderBoard['userName']}}</h6>
                    <p>Points : {{leaderBoard['pts']}}</p>
                </div>

                <div class="col-md-4 foot-col">
                    <button class="btn_leadBorad" id="leadeBoard_btn">View Prize & Other Details</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="leadeBoard" tabindex="-1" role="dialog" aria-labelledby="leadeBoard" aria-hidden="true">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Leaderboard Prizes & Other Details {{home.leaderBoard['startDate']}} - {{home.leaderBoard['endDate']}}</h4>
                </div>
                <div class="modal-body leadeBoard_cont">
                    <img ng-src="{{home.leaderBoard['img']}}" class="img-responsive" alt="Banner"><br>
                    <div class="awardContent"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
</section>

<?php get_footer(); ?>

<script>
    $('#leadeBoard_btn').click(function () {
        $('#leadeBoard').modal("show");
    });

</script>