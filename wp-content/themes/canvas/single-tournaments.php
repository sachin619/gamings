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


                        <h4>Total Trade So far: {{getDetails['totalBets'][0].total}} Points</h4>
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

                                <td width="30%"> {{teamInfo.team['post_title']}}</td>               
                                <td > <span ng-if="getDetails['details'][0].uid != null"> {{getDetails['pts'][$index][0].total}} </span></td>
                                <td class="blockTrade" ng-if="teamInfo.eliminated === 'No'"><input  type="text" name="pts" ng-model="$parent.$parent.points" ng-if="getDetails['details'][0].uid != null"  placeholder="Trade">
                                </td>
                                <td class="blockAction" ng-if="teamInfo.eliminated === 'No'"><button ng-if="getDetails['details'][0].uid != null" ng-click="trade(getDetails['details'][0].id, teamInfo.team['ID'], points)" >Add</button></td>
                                <td colspan="2" class="stage" ng-if="teamInfo.eliminated !== 'No'"><span ng-if="getDetails['details'][0].uid != null">This Team had been Eliminated.</span></td>       

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
                            <div  ng-repeat="matches in getDetails.matches" class="entry clearfix col-md-6">
                                <div class="entry-image hidden-sm">
                                    <a href={{matches['postLink']}}>
                                        <img src={{matches['img']}} alt="">
                                        <div class="entry-date">{{matches['start_date'] || date:'mm/dd/yyyy' }}<span>Apr</span></div>
                                    </a>
                                </div>
                                <div class="entry-c">
                                    <div class="entry-title">
                                        <h2><a href="#">{{matches['title']}}</a></h2>
                                    </div>
                                    <ul class="entry-meta clearfix">

                                        <li><a href="#"><i class="icon-time"></i> 11:00 - 19:00</a></li>
                                        <li><a href="#"><i class="icon-map-marker2"></i> {{matches['venue']}}</a></li>
                                    </ul>
                                    <div class="clearfix"></div>
                                    <div class="row mb15">
                                        <div class="col-md-4">India :</div>
                                        <div class="col-md-8"> <input type="text" placeholder=""></div>
                                    </div>
                                    <div class="row mb15">
                                        <div class="col-md-4">Pakistan :</div>
                                        <div class="col-md-8"> <input type="text" placeholder=""></div>
                                    </div>

                                    <div class="row mb15">
                                        <div class="col-md-4"> </div>
                                        <div class="col-md-8"><a href="#" class="btn btn-danger">Trade</a></div>
                                    </div>





                                </div>
                            </div>
                        </div>


                    </div>

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