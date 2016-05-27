<?php

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
$uid = isset($_REQUEST['userId']) ? $_REQUEST['userId'] : '';
$output = null;
$api = new API();

switch ($action) {
    case 'home':
        $output = $api->home();
        break;
    case 'home-match-listing':
        $output = $api->homeMatchListing($_REQUEST);
        break;
    case 'get-slider':
        $output = $api->getSlider();
        break;
    case 'upcomming-tournament':
        $output = $api->upcomingTournaments();
        break;
    case 'upcomming-matches':
        $output = $api->upcomingMatches();
        break;
    case 'registration':
        $output = $api->registration($_REQUEST);
        break;
    case 'login':
        $output = $api->login($_REQUEST);
        break;
    case 'logout':
        $output = $api->logout();
        break;
    case 'tournaments-detail':
        $output = $api->tournamentsDetail($_REQUEST);
        break;
    case 'matches-detail':
        $output = $api->matchesDetail($_REQUEST);
        break;
    case 'trade':
        $output = $api->trade($_REQUEST);
        break;
    case 'get-user-trade':
        $output = $api->getUserTrade($_REQUEST);
        break;
    case 'listing-tournaments':
        $output = $api->listingTournaments($_REQUEST);
        break;
    case 'listing-matches':
        $output = $api->listingMatches($_REQUEST);
        break;
    case 'premium-trade':
        $tradeInfo['tid'] = 89;
        $tradeInfo['team_id'] = '';
        $output = $api->premiumTrade('tid', $tradeInfo);
        break;
    case 'multi-trade-match':
        $output = $api->multiTradeMatch($_REQUEST);
        break;
    case 'admin-tour-filter':
        $output = $api->adminTourFilter($_REQUEST);
        break;
    case 'admin-match-filter':
        $output = $api->adminMatchFilter($_REQUEST);
        break;
    case 'admin-distribution':
        $output = $api->adminDistribution();
        break;
    case 'my-account':
        $output = $api->myAccount($_REQUEST);
        break;
    case 'update-user-info':
        $output = $api->updateUserInfo($_REQUEST);
        break;
    case 'password-update':
        $output = $api->passwordUpdate($_REQUEST);
        break;
    case 'upload-img':
        $output = $api->uploadImg($_REQUEST);
        break;
    case 'contact-us':
        $output = $api->contacUs($_REQUEST);
        break;
    case 'forgot-password':
        $output = $api->forgotPassword($_REQUEST);
        break;
    case 'forgot-password-reset':
        $output = $api->forgotPasswordReset($_REQUEST);
        break;
    default:
        $output = ['error' => 'invalid action'];
        break;
}

if ($output) {
    if (isset($_REQUEST["callback"])) {
        header("Content-Type: application/javascript");
        echo $_REQUEST['callback'] . '(' . json_encode($output) . ')';
    } else {
        header("Content-Type: application/json");
        echo json_encode($output);
    }
}
die();

class API {

    public $userId;

    function __construct() {
        global $user_ID;
        if (!empty($user_ID))
            $this->userId = $user_ID;
        else if (!empty($_REQUEST['userId']))
            $this->userId = $_REQUEST['userId'];
        else
            $this->userId = NULL;
    }

    function home() {

        $home['slider'] = $this->getSlider();
        $home['popularTournaments'] = $this->popularTournaments();
        //$home['popularMatches'] = $this->popularMatches();
        // $home['upcomingTournaments'] = $this->upcomingTournaments();
        // $home['upcomingMatches'] = $this->listingPopularMatches();
        //$home['category'] = $this->getCategories(['parent' => 1]);
        $home['siteUrl'] = get_site_url();
        return $home;
    }

    function homeMatchListing($info) {

        //$home['slider'] = $this->getSlider();
        // $home['popularTournaments'] = $this->popularTournaments();
        //$home['popularMatches'] = $this->popularMatches();
        // $home['upcomingTournaments'] = $this->upcomingTournaments();
        $home['upcomingMatches'] = $this->listingPopularMatches($info);
        //$home['category'] = $this->getCategories(['parent' => 1]);
        $home['siteUrl'] = get_site_url();
        return $home;
    }

    function myAccount($info) {
        $myAccount['userInfo'] = $this->getUserDetails();
        $myAccount['userBets'] = $this->getUserBets($info);
        $myAccount['unClearedPoints'] = $this->getUnclearedPoints();
        $myAccount['winLoss'] = $this->getWinLossBets($info);
        return $myAccount;
    }

    function getSlider() {
        $args = [ 'post_type' => 'slider', 'meta_key' => 'active', 'meta_value' => 'Yes'];
        return $this->getResult($args);
    }

    function popularMatches() {
        $args = ['post_type' => 'matches', 'posts_per_page' => 12, 'meta_key' => 'total_bets', 'orderby' => 'meta_value', 'order' => 'DESC'];
        return $this->getResult($args);
    }

    function matchesDetail($postId) {
        $args = ['post_type' => 'matches', 'name' => $postId['data']['postId']];
        $userId = $this->userId;
        //$args = ['post_type' => 'tournaments', 'name' => $postId['postId']];
        $result = $this->getResult($args);
        $allResult = $this->getResult($args);
        $tId = $result[0]['id'];
        foreach ($result[0]['select_teams'] as $result) {
            $teamInfo = (array) $result['team_name'];
            $teamId = $teamInfo['ID'];

            $tradeInfo = ['tid' => $tId, 'team_id' => $teamId, 'user_id' => $userId];
            $var[] = $this->getUserTrade($tradeInfo, 'mid');
        }
        $tradeInfo = ['tid' => $tId, 'user_id' => $userId];
        $userTotalTrade = $this->getUserTotalTrade($tradeInfo, 'mid');
        $getTotalBets = $this->getTotalTrade($tradeInfo, 'mid');
        $detailsData = ['details' => $allResult, 'pts' => $var, 'totalBets' => $getTotalBets, 'userTotalTrade' => $userTotalTrade];
        return $detailsData;
    }

    function upcomingMatches() {
        //$dateFormat = strtotime('+18 hour 1 minute');
        $dateFormat = time();
        $args = [
            'post_type' => 'matches',
            'meta_key' => 'start_date',
            'posts_per_page' => 12,
            'order_by' => 'meta_value_num',
            'order' => 'ASC',
            'meta_query' =>
            [
                'key' => 'start_date',
                'value' => $dateFormat,
                'compare' => '>',
            ],
        ];
        return $this->getResult($args);
    }

    function tournamentsMatches($tid) {
        global $wpdb;
        $userId = $this->userId;
        $tourId = get_the_ID();
        //date_default_timezone_set('Asia/Calcutta');
        $dateTime = date("Y-m-d H:i:s"); // time in India
        //$dateFormat = strtotime($dateTime);
//        print_r($dateFormat);exit;
        //$dateFormat = time();
        $getDate = current_time('mysql');
        $dateFormat = strtotime($getDate);
        //start end date time
        $startTime = strtotime(date('Y-m-d', $dateFormat));
        $endTimeConvert = date('Y-m-d H:i:s', $startTime + 86399);
        $endTime = strtotime($endTimeConvert);
        $args = [
            'post_type' => 'matches',
            'meta_key' => 'start_date',
            'posts_per_page' => 100,
            'order_by' => 'meta_value_num',
            'order' => 'ASC',
            'meta_query' => ['relation' => 'AND',
                [ 'key' => 'start_date', 'value' => $dateFormat, 'compare' => '>'],
                [ 'key' => 'points_distributed', 'value' => 'No', 'compare' => '='], [
                    'key' => 'tournament_name',
                    'value' => get_the_ID(),
                    'compare' => '='
                ]
            ]
        ];
        $result = $this->getResult($args);
        $allResult = $this->getResult($args);
        foreach ($allResult as $getPost) {
            $tId = $getPost['id'];
            foreach ($getPost['select_teams'] as $resultN) {
                $teamInfo = (array) $resultN['team_name'];
                $teamId = $teamInfo['ID'];
                $tradeInfo = ['tid' => $tId, 'team_id' => $teamId, 'user_id' => $userId];
                $var[$tId][] = $this->getUserTrade($tradeInfo, 'mid');
            }
        }

        return ['details' => $allResult, 'totalPoints' => $getTotal, 'tradeTotal' => $var];
    }

    function popularTournaments() {
        //$currentTime = time();
        $getDate = current_time('mysql');
        $dateFormat = strtotime($getDate);
        $currentTime = $dateFormat;
        $args = [
            'post_type' => 'tournaments',
            'posts_per_page' => 12,
            'meta_key' => 'total_tour_bets',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'meta_query' => [
                'relation' => 'AND',
                [
                    'key' => 'betting_allowed_till',
                    'value' => $currentTime,
                    'compare' => '>'
                ],
                [ 'key' => 'points_distributed', 'value' => 'No', 'compare' => '=']
            ]
        ];
        return $this->getResult($args);
    }

    function tournamentsDetail($postId) {
        $args = ['post_type' => 'tournaments', 'name' => $postId['data']['postId']];
        $userId = $this->userId;
        $result = $this->getResult($args);
        $allResult = $this->getResult($args);
        $tId = $result[0]['id'];
        foreach ($result[0]['participating_team'] as $result) {
            $teamInfo = (array) $result['team'];
            $teamId = $teamInfo['ID'];
            $tradeInfo = ['tid' => $tId, 'team_id' => $teamId, 'user_id' => $userId];
            $var[] = $this->getUserTrade($tradeInfo, 'tid');
        }
        $tradeInfo = ['tid' => $tId, 'user_id' => $userId];
        $getTotalBets = $this->getTotalTrade($tradeInfo, 'tid');
        $userTotalTrade = $this->getUserTotalTrade($tradeInfo, 'tid');
        $detailsData = ['details' => $allResult, 'pts' => $var, 'totalBets' => $getTotalBets, 'userTotalTrade' => $userTotalTrade, 'matches' => $this->tournamentsMatches($postId)];
        return $detailsData;
    }

    function upcomingTournaments() {
        $dateFormat = date('Ymd');
        $args = [ 'post_type' => 'tournaments', 'posts_per_page' => 12, 'meta_key' => 'start_date', 'orderby' => 'meta_value_num', 'order' => 'ASC',
            'meta_query' => [
                'key' => 'start_date',
                'value' => $dateFormat,
                'compare' => '>'
            ]
        ];
        return $this->getResult($args);
    }

    function upcomingOngoingTournaments($categorySlug, $getPageCount) {
        $getDate = current_time('mysql');
        $dateFormat = strtotime($getDate);
        $currentTime = $dateFormat;
        $postPerPage = $getPageCount;
        //$dateFormat = date('Ymd');
        $args = [ 'post_type' => 'tournaments', 'category_name' => $categorySlug, 'posts_per_page' => $postPerPage, 'meta_key' => 'total_tour_bets', 'orderby' => 'meta_value_num', 'order' => 'DESC',
            'meta_query' => [
                'relation' => 'AND',
                [
                    'key' => 'betting_allowed_till',
                    'value' => $currentTime,
                    'compare' => '>'
                ],
                [ 'key' => 'points_distributed', 'value' => 'No', 'compare' => '=']
            ]
        ];
        return $this->getResult($args);
    }

    function listingTournaments($getCatSlug) {
        $categorySlug = $getCatSlug['data']['categoryName'];
        if (!empty($getCatSlug['data']['getCount'])):
            $getPageCount = $getCatSlug['data']['getCount'];
        else:

            $getPageCount = 6;
        endif;
        $getCat = $this->getCategories(['parent' => 1]);
        $result = $this->upcomingOngoingTournaments($categorySlug, $getPageCount);
        foreach ($getCat as $categories) {
            $catName = (array) $categories;
            $cat[] = ['catName' => $catName['name']];
        }

        foreach ($result as $getPost) {
            $tradeInfo = ['tid' => $getPost['id']];
            $getTrade = $this->getTotalTrade($tradeInfo, 'tid');
            $converTrade[] = (array) $getTrade[0];
        }
        $output = ['catName' => $cat, 'catPost' => $result, 'tradeTotal' => $converTrade];
        return $output;
    }

    function listingMatches($getCatSlug) {

        global $wpdb;
        $userId = $this->userId;
        $categorySlug = $getCatSlug['data']['categoryName'];
        $getCatDetail = get_terms('category', array('name__like' => $categorySlug));
        $getCatId = $getCatDetail[0]->term_id;
        if (!empty($getCatSlug['data']['getCount'])):
            $getPageCount = $getCatSlug['data']['getCount'];
        else:
            $getPageCount = 50;
        endif;
        $getDate = current_time('mysql');
        $dateFormat = strtotime($getDate);
        //start end date time
        $startTime = strtotime(date('Y-m-d', $dateFormat));
        $endTimeConvert = date('Y-m-d H:i:s', $startTime + 86399);
        $endTime = strtotime($endTimeConvert);
        //start end date time
        $currStartDate = date("Y-m-d H:i:s", strtotime('-13 hours')); //not in use
        $currEndDate = date("Y-m-d H:i:s", strtotime('+11 hours')); //not in use
        $currStartConvert = strtotime($currStartDate); //not in use
        $currEndConvert = strtotime($currEndDate); //not in use
        $getCat = $this->getCategories(['parent' => 1]);
        if ($getCatSlug['data']['type'] == 'today'):
            $args = [
                'post_type' => 'matches',
                'meta_key' => 'total_bets',
                'orderby' => 'meta_value_num',
                'category_name' => $categorySlug,
                'posts_per_page' => $getPageCount,
                'order' => 'DESC',
                'meta_query' => ['relation' => 'AND',
                    [
                        'key' => 'start_date', 'value' => $startTime, 'compare' => '>'
                    ],
                    [
                        'key' => 'end_date', 'value' => $endTime, 'compare' => '<'
                    ]
                ],
            ];
        elseif ($getCatSlug['data']['type'] == 'daysBefore'):
            $sevenDaysBefore = strtotime(date('Y-m-d', $dateFormat) . "-7 days");
            $args = [
                'post_type' => 'matches',
                'meta_key' => 'start_date',
                'orderby' => 'meta_value_num',
                'category_name' => $categorySlug,
                'posts_per_page' => $getPageCount,
                'order' => 'DESC',
                'meta_query' => ['relation' => 'AND',
                    [
                        'key' => 'start_date', 'value' => $startTime, 'compare' => '<'
                    ],
                    [
                        'key' => 'start_date', 'value' => $sevenDaysBefore, 'compare' => '>'
                    ],
                    [ 'key' => 'points_distributed', 'value' => 'Yes', 'compare' => '=']
                ],
            ];
        elseif ($getCatSlug['data']['type'] == 'upcomming'):
            $args = [
                'post_type' => 'matches',
                'meta_key' => 'start_date',
                'orderby' => 'meta_value_num',
                'category_name' => $categorySlug,
                'posts_per_page' => $getPageCount,
                'order' => 'ASC',
                'meta_query' => ['relation' => 'AND',
                    [ 'key' => 'start_date', 'value' => $dateFormat, 'compare' => '>',],
                    [ 'key' => 'points_distributed', 'value' => 'No', 'compare' => '=']
                ],
            ];
        elseif ($getCatSlug['data']['type'] == 'ongoing'):
            $args = [
                'post_type' => 'matches',
                'meta_key' => 'start_date',
                'orderby' => 'meta_value_num',
                'category_name' => $categorySlug,
                'posts_per_page' => $getPageCount,
                'order' => 'DESC',
                'meta_query' => ['relation' => 'AND',
                    [
                        'key' => 'start_date', 'value' => $startTime, 'compare' => '>'
                    ],
                    [
                        'key' => 'end_date', 'value' => $endTime, 'compare' => '<'
                    ],
                    [
                        'key' => 'start_date', 'value' => $dateFormat, 'compare' => '<'
                    ],
                    [ 'key' => 'points_distributed', 'value' => 'No', 'compare' => '=']
                ],
            ];
        else:
            $args = [
                'post_type' => 'matches',
                'meta_key' => 'total_bets',
                'orderby' => 'meta_value_num',
                'category_name' => $categorySlug,
                'posts_per_page' => $getPageCount,
                'order' => 'DESC',
                'meta_query' => ['relation' => 'AND',
                    [ 'key' => 'start_date', 'value' => $dateFormat, 'compare' => '>'],
                    [ 'key' => 'points_distributed', 'value' => 'No', 'compare' => '=']
                ],
            ];
        endif;
        $result = $this->getResult($args);
        foreach ($getCat as $categories) {
            $catName = (array) $categories;
            $cat[] = ['catName' => $catName['name']];
        }

        foreach ($result as $getPost) {
            $tId = $getPost['id'];
            foreach ($getPost['select_teams'] as $resultN) {
                $teamInfo = (array) $resultN['team_name'];
                $teamId = $teamInfo['ID'];
                $tradeInfo = ['tid' => $tId, 'team_id' => $teamId, 'user_id' => $userId,];
                $var[$tId][] = $this->getUserTrade($tradeInfo, 'mid');
            }
        }

        $output = ['catName' => $cat, 'catPost' => $result, 'tradeTotal' => $var, 'getOngoing' => $collectOngoing];
        return $output;
    }

    function listingPopularMatches($getCatSlug) {
        //print_r($getCatSlug);exit;
        $userId = $this->userId;
        $categorySlug = $getCatSlug['data']['categoryName'];
        if (!empty($getCatSlug['data']['getCount'])):
            $getPageCount = $getCatSlug['data']['getCount'];
        else:
            $getPageCount = 5;
        endif;
        $dateFormat = time();
        $getCat = $this->getCategories(['parent' => 1]);

        $args = [
            'post_type' => 'matches',
            'meta_key' => 'total_bets',
            'orderby' => 'meta_value_num',
            'posts_per_page' => $getPageCount,
            'order' => 'DESC',
            'meta_query' => [ 'key' => 'start_date', 'value' => $dateFormat, 'compare' => '>=',],
        ];

        $result = $this->getResult($args);
        foreach ($getCat as $categories) {
            $catName = (array) $categories;
            $cat[] = ['catName' => $catName['name']];
        }

        foreach ($result as $getPost) {
            $tId = $getPost['id'];
            foreach ($getPost['select_teams'] as $resultN) {
                $teamInfo = (array) $resultN['team_name'];
                $teamId = $teamInfo['ID'];
                $tradeInfo = ['tid' => $tId, 'team_id' => $teamId, 'user_id' => $userId,];
                $var[$tId][] = $this->getUserTrade($tradeInfo, 'mid');
            }
        }
        $output = ['catName' => $cat, 'catPost' => $result, 'tradeTotal' => $var];
        return $output;
    }

    function multiTradeMatch($tradeInfo) {
        if (!empty($tradeInfo['data']['pts'])):
            foreach ($tradeInfo['data']['pts'] as $teamId => $points) {
                $tradeInfo['data']['team_id'] = $teamId;
                $tradeInfo['data']['pts'] = $points;
                $get_result[] = $this->tradeMatch($tradeInfo);
            }
            $tradeInfo["tid"] = $tradeInfo['data']['mid'];
            $getTotalBets = $this->getTotalTrade($tradeInfo, 'mid');
            $getTotalBetsFilter = (array) $getTotalBets[0];
            $mid = $tradeInfo['data']['mid'];
            update_post_meta($mid, 'total_bets', $getTotalBetsFilter['total']);
            return $get_result[0];
        else:
            return "Points should be greater than zero";
        endif;
    }

    function tradeMatch($tradeInfo) {
        global $wpdb;
        $userId = $this->userId;
        $getMinimumBetAmount = get_option('minimum_bet_amount');
        $tId = isset($tradeInfo['data']['tid']) ? $tradeInfo['data']['tid'] : 0;
        $mId = isset($tradeInfo['data']['mid']) ? $tradeInfo['data']['mid'] : 0;
        $teamId = $tradeInfo['data']['team_id'];
        $points = $tradeInfo['data']['pts'];
        $uPointsR = get_user_meta($userId, 'points');
        $uPoints = round($uPointsR[0]);
        $getUsedPoints = get_user_meta($userId, 'points_used');
        $usedPoints = round($getUsedPoints[0]);
        $usedCalc = $usedPoints + $points;                 //adding bet points and current remaining points
        $slug = isset($tradeInfo['data']['slug']) ? $tradeInfo['data']['slug'] : 0;/** get count of eliminated team** */
        $args = ['post_type' => 'matches', 'name' => $slug];
        $getTeams = $this->getResult($args);

        foreach ($getTeams[0]['select_teams'] as $team) {
            $teamFilter[] = (array) $team['team_name'];
            if ($team['winner'] == 'Yes') :
                $count[] = $teamFilter[0]['ID'];
            endif;
        }
        $getEndTime = strtotime($getTeams[0]['end_date_original']);
        $getStartTime = strtotime($getTeams[0]['start_date_original']);
        $getDate = current_time('mysql');
        $curTime = strtotime($getDate);
        //$getCurrentTime = time();
        $getCurrentTime = $curTime;
        $getWinnerCount = count($count);/** get count of eliminated team** */
        $getTourId = isset($getTeams[0]['tournament_name']->ID) ? $getTeams[0]['tournament_name']->ID : 0;
        $wpBets = ['uid' => $userId, 'mid' => $mId, 'tid' => $getTourId, 'team_id' => $teamId, 'pts' => $points];
        if (!empty($tradeInfo['data']['pts'])):
            if ($points >= $getMinimumBetAmount):


                if ($points <= $uPoints):
                    $remaining = $uPoints - $points;
                    update_user_meta($userId, 'points', $remaining);
                    update_user_meta($userId, 'points_used', $usedCalc);
                    $wpdb->insert('wp_bets', $wpBets);
                    return "Your trade has been placed successfully!";
                else:
                    return "Not have enough points";
                endif;


            else:
                return "Minimum Points should be $getMinimumBetAmount";
            endif;
        else:
            return "Minimum Points should be  $getMinimumBetAmount";
        endif;
    }

    function trade($tradeInfo) {
        global $wpdb;
        $userId = $this->userId;
        $getMinimumBetAmount = get_option('minimum_bet_amount');
        $tId = isset($tradeInfo['data']['tid']) ? $tradeInfo['data']['tid'] : 0;
        $mId = isset($tradeInfo['data']['mid']) ? $tradeInfo['data']['mid'] : 0;
        $teamId = $tradeInfo['data']['team_id'];
        $points = isset($tradeInfo['data']['pts']) ? $tradeInfo['data']['pts'] : 0;
        $uPointsR = get_user_meta($userId, 'points');
        $uPoints = round($uPointsR[0]);
        $getUsedPoints = get_user_meta($userId, 'points_used');
        $usedPoints = round($getUsedPoints[0]);
        $slug = isset($tradeInfo['data']['slug']) ? $tradeInfo['data']['slug'] : 0;/** get count of eliminated team** */
        $args = ['post_type' => 'tournaments', 'name' => $slug];
        $getTeams = $this->getResult($args);
        foreach ($getTeams[0]['participating_team'] as $team) {
            $teamFilter = (array) $team['team'];
            if ($team['eliminated'] == 'Yes') :
                $count[] = $team['eliminated'];
                $elimiatedTeamId[] = $teamFilter['ID'];
            else:
                $countNo[] = $team['eliminated']; //get count of non eliminated team
            endif;
        }
        $getEndTime = strtotime($getTeams[0]['betting_allowed_till']);
        $getDate = current_time('mysql');
        //$currDate = time();
        $currDate = strtotime($getDate);
             //   print_r($currDate);exit;
        $getCurrentTime = $currDate;
        $getPrem = $getTeams[0]['premium']; //premium calculation
        //$premCalc = round($points / $getPrem); //premium calculation
        $premCalc = $points * $getPrem; //premium calculation which will deduct from kitty
        $usedCalc = $usedPoints + ceil($premCalc);                 //adding bet points and current remaining points
        $getCount = count($count); //get count of eliminated team
        $getNoCount = count($countNo); //get count of non eliminated team
        $wpBets = ['uid' => $userId, 'mid' => $mId, 'tid' => $tId, 'team_id' => $teamId, 'pts' => $points, 'stage' => $getCount, 'premium' => $getPrem];
        if (!empty($tradeInfo['data']['pts']) && is_numeric($tradeInfo['data']['pts'])):
            if ($points >= $getMinimumBetAmount && !empty($tradeInfo['data']['pts'])):
                if ($getEndTime >= $getCurrentTime && $getNoCount != 1):
                    if (!in_array($teamId, $elimiatedTeamId)):
                        if (ceil($premCalc) <= $uPoints):
                            $remaining = $uPoints - ceil($premCalc);
                            update_user_meta($userId, 'points', $remaining);
                            update_user_meta($userId, 'points_used', $usedCalc);
                            $wpdb->insert('wp_bets', $wpBets);
                            $tradeInfo["tid"] = $tId; //update total bets
                            $getTotalBets = $this->getTotalTrade($tradeInfo, 'tid');
                            $getTotalBetsFilter = (array) $getTotalBets[0];
                            $mid = $tradeInfo['data']['tid'];
                            update_post_meta($mid, 'total_tour_bets', $getTotalBetsFilter['total']); //update total bets
                            if (!empty(trim($getPrem))):
                                return "Your trade has been placed successfully!";
                            elseif (empty(trim($getPrem))):
                                return "Your trade has been placed successfully!";
                            endif;
                        else:
                            return "Not have enough points";
                        endif;
                    else:
                        return "Team Eliminated!";
                    endif;
                else:
                    return "Tournament had been over";
                endif;
            else:
                return "Minimimum Bet point should be $getMinimumBetAmount";
            endif;
        else:
            return "Minimimum Bet point should be $getMinimumBetAmount";
        endif;
    }

    function getUserTrade($tradeInfo, $Tradetype) {
        global $wpdb;
        $result = $wpdb->get_results("SELECT sum(pts) as total FROM wp_bets WHERE $Tradetype='" . $tradeInfo['tid'] . "' AND team_id='" . $tradeInfo['team_id'] . "' AND uid='" . $tradeInfo['user_id'] . "' ");
        return $result;
    }

    function getTotalTrade($tradeInfo, $Tradetype) {
        global $wpdb;
        $result = $wpdb->get_results("SELECT sum(pts) as total FROM wp_bets WHERE $Tradetype='" . $tradeInfo["tid"] . "' ");
        return $result;
    }

    function getUserTotalTrade($tradeInfo, $Tradetype) {
        global $wpdb;
        $result = $wpdb->get_results("SELECT sum(pts) as total FROM wp_bets WHERE $Tradetype='" . $tradeInfo["tid"] . "' AND uid='" . $tradeInfo["user_id"] . "' GROUP BY uid ");
        $getResult = (array) $result[0];
        return $getResult['total'];
    }

    function login($userInfo) {
        $username = $userInfo['data']['userName'];
        $password = $userInfo['data']['password'];
        $credential = ['user_login' => $username, 'user_password' => $password];
        $userid = wp_signon($credential, false);
        if (!is_wp_error($userid)):
            $getId = (array) $userid->data;
            return ['msg' => "success_login", 'userData' => get_userdata($getId['ID'])];
        else:
            return ['msg' => "Not a valid username or password", 'errorType' => 'danger'];

        endif;
    }

    function logout() {
        wp_logout();
        wp_redirect(get_site_url() . '/register');
    }

    function registration($userInfo) {
        $userData = [
            'user_login' => $userInfo['data']['user_login'],
            'first_name' => $userInfo['data']['first_name'],
            'last_name' => $userInfo['data']['last_name'],
            'user_email' => $userInfo['data']['user_email'],
            'user_pass' => $userInfo['data']['user_pass'],
        ];
        $userName = $userInfo['data']['first_name'];
        $userEmail = $userInfo['data']['user_email'];
        $email = email_exists($userInfo['data']['user_email']); //check if email id exist
        $username = username_exists($userInfo['data']['user_login']); //check username exists
        if ($email != ""):
            return ['msg' => "Email Id already exist", 'errorType' => 'danger'];
        elseif ($username != ""):
            return ['msg' => "Username already exist", 'errorType' => 'danger'];
        else:
            $user_id = wp_insert_user($userData);
            update_user_meta($user_id, 'phone', $userInfo['data']['phone']);
            if (!is_wp_error($user_id)):
                $headers = 'Content-type: text/html';
                $body = "Hi $userName, <br>Thanks for signing up. <br> Your account has been activated and you should be able to login on <a href='http://gaming-inf.cruxservers.in/register/'>http://gaming-inf.cruxservers.in/register/</a>";
                wp_mail($userEmail, "User Registration", $body, $headers);
                update_user_meta($user_id, 'points', get_option("token_amt"));
                $userInfo['data']['userName'] = $userInfo['data']['user_email'];
                $userInfo['data']['password'] = $userInfo['data']['user_pass'];
                return $this->login($userInfo);
            // return ['msg' => 'Registered Successfully & You have got 500 points', 'errorType' => 'success'];
            else:
                return ['msg' => "Something goes wrong try again later", 'errorType' => 'danger'];
            endif;
        endif;
    }

    function getResult($args) {
        $userId = $this->userId;
        $output = [];
        $query = new WP_Query($args);
        while ($query->have_posts()):
            $query->the_post();
            $id = get_the_ID();
            $postType = get_post_type($id);
            $post = [
                'id' => $id,
                'uid' => $userId,
                'title' => get_the_title(),
                'img' => $this->getFeaturedImg($id),
                'content' => get_the_content(),
                'postLink' => get_permalink($post->ID),
                'category' => get_the_category($post->ID),
                'siteUrl' => get_site_url(),
            ];
            foreach (get_fields($id) as $k => $v) {
                $getDate = current_time('mysql');
                //$currDate = time();
                $currDate = strtotime($getDate);
                $post[$k] = $v;
                if ($k == "start_date"):
                    $matchDate = strtotime($v);
                    $post['ong'] = $matchDate < $currDate ? "Yes" : "No";
                endif;
                if ($k == 'start_date'):$post['matchStartDate'] = date('M', strtotime($v));
                    $post['matchStartTime'] = date('H:i', strtotime($v));
                    $post['start_date_original'] = $v;
                    if ($postType == 'matches'):
                        $post['start_date'] = "";
                    else:
                        $post['start_date'] = date('d M, Y', strtotime($v));

                    endif;
                elseif ($k == 'end_date'):$post['matchEndDate'] = date('M', strtotime($v));
                    $post['end_date_original'] = $v;
                    $post['matchEndTime'] = date('H:i', strtotime($v));
                    if ($postType == 'matches'):
                        $post['end_date'] = date('d M, Y H:i a', strtotime($v));
                        $post['onlySDate'] = date('d M, Y ', strtotime($v));
                    else:
                        $post['onlyEDate'] = date('d M, Y ', strtotime($v));
                        $post['end_date'] = date('d M, Y', strtotime($v));

                    endif;

                endif;
            }

            array_push($output, $post);
        endwhile;
        return $output;
    }

    function getFeaturedImg($id) {
        $image = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'full'); //post image
        $getCategoryByID = get_the_category($id); //category image starts
        $getCatByIdFilter = (array) $getCategoryByID[0];
        $getTaxanomy = get_option('category_' . $getCatByIdFilter['term_id'] . '_image');
        $getFeatImg = wp_get_attachment_url($getTaxanomy); //category image ends
        $fallBackImg = get_template_directory_uri() . "/images/default.jpg";
        if (!empty($image)):
            return $image['0'];
        elseif (!empty($getFeatImg)):
            return $getFeatImg;
        else:
            return $fallBackImg;
        endif;
    }

    function getCategories($args) {
        return get_categories($args);
    }

    function adminTourFilter($filterInfo) {
        $args = ['post_type' => 'tournaments', 's' => $filterInfo['term']];
        $allResult = $this->getResult($args);
        foreach ($allResult as $getTitle):
            $getTitleName[] = $getTitle['title'];
        endforeach;
        return $getTitleName;
    }

    function adminMatchFilter($filterInfo) {
        $args = ['post_type' => 'matches', 's' => $filterInfo['term']];
        $allResult = $this->getResult($args);
        foreach ($allResult as $getTitle):
            if ($getTitle['tournament_name']->post_title == $filterInfo['tname']):
                $getTitleName[] = $getTitle['title'];
            endif;
        endforeach;
        return $getTitleName;
//$getTitleName[] = $getTitle['tournament_name']->post_title;
    }

    function adminDistribution($userid) {
        global $wpdb;
        $getDistributionDays = get_option('distributing_days');
        $getResults = $wpdb->get_results('SELECT * FROM wp_distribution where uid =' . $userid);
        foreach ($getResults as $results):
            $getCurrTime = time();
            $disDateAdd = strtotime($results->date . "+$getDistributionDays hour");
            if ($disDateAdd < $getCurrTime && $results->cleared != 1):
                $getCurrentPoints = get_user_meta($userid, 'points');
                $wpdb->update('wp_distribution', ['cleared' => '1'], ['uid' => $userid]);
                update_user_meta($userid, 'points', $getCurrentPoints[0] + $results->gain_points);
            endif;
        endforeach;
    }

    function getUserBets($info) {
// print_r($info);
// exit;
        $startDate = $info['data']['startDate'];
        $endDate = $info['data']['endDate'];
        if (isset($startDate) && isset($endDate)): //start and end date
            $whereM.=" AND bet_at BETWEEN '" . $startDate . "' AND '" . $endDate . "' ";
        endif;
        global $wpdb;
        $getAccount = [];
        $result = $wpdb->get_results("SELECT * FROM wp_bets where uid= $this->userId  $whereM order by bet_at DESC");
        $this->getCsv($result);
        $i = 1;
        foreach ($result as $getBetDetails):
            $tourDetails['id'] = $i++;
            $tourDetails['tourTitle'] = get_the_title($getBetDetails->tid);
            $tourDetails['matchTitle'] = $getBetDetails->mid != 0 ? get_the_title($getBetDetails->mid) : '-';
            $tourDetails['teamTitle'] = get_the_title($getBetDetails->team_id);
            $tourDetails['pts'] = $getBetDetails->pts;
            $tourDetails['bet_at'] = $getBetDetails->bet_at;
            array_push($getAccount, ['tourDetails' => $tourDetails]);

        endforeach;

        return $getAccount;
    }

    function getWinLossBets($info) {
// print_r($info);
// exit;
        $startDate = $info['data']['startDate'];
        $endDate = $info['data']['endDate'];
        if (isset($startDate) && isset($endDate)): //start and end date
            $whereM.=" AND bet_at BETWEEN '" . $startDate . "' AND '" . $endDate . "' ";
        endif;
        global $wpdb;
        $getAccount = [];
        $result = $wpdb->get_results("SELECT id,uid,tid,mid,team_id,sum(pts)as pts,bet_at FROM wp_bets where uid= $this->userId group by tid,team_id  order by bet_at DESC");
//$this->getCsv($result);
        $i = 1;
        foreach ($result as $getBetDetails):
            $getWin = $wpdb->get_results("SELECT id FROM wp_distribution WHERE tid=$getBetDetails->tid AND team_id=$getBetDetails->team_id");
            $tourDetails['win'] = !empty($getWin) ? "Yes" : "No";
            $tourDetails['id'] = $i++;
            $tourDetails['tourTitle'] = get_the_title($getBetDetails->tid);
            $tourDetails['matchTitle'] = $getBetDetails->mid != 0 ? get_the_title($getBetDetails->mid) : '-';
            $tourDetails['teamTitle'] = get_the_title($getBetDetails->team_id);
            $tourDetails['pts'] = $getBetDetails->pts;
            $tourDetails['bet_at'] = $getBetDetails->bet_at;
            array_push($getAccount, ['tourDetails' => $tourDetails]);

        endforeach;

        return $getAccount;
    }

    function getUserDetails() {
        $getUserDetails = get_userdata($this->userId);

        $firstName = get_user_meta($this->userId, 'first_name');
        $lastName = get_user_meta($this->userId, 'last_name');
        $phone = get_user_meta($this->userId, 'phone');
        $points = get_user_meta($this->userId, 'points');
        $loaderUrl = get_template_directory_uri() . "/images/pageload1.gif";
        $info = ['firstName' => $firstName, 'lastName' => $lastName, 'userDetails' => $getUserDetails, 'phone' => $phone, 'loaderImg' => $loaderUrl, 'points' => $points];
        return $info;
    }

    function updateUserInfo($info) {
        wp_update_user(['ID' => $this->userId, 'user_email' => esc_attr($info['data']['email'])]);
//wp_update_user(['ID' => $this->userId, 'user_login' => $info['data']['ulogin']]);
        wp_update_user(['ID' => $this->userId, 'first_name' => esc_attr($info['data']['fname'])]);
        wp_update_user(['ID' => $this->userId, 'last_name' => esc_attr($info['data']['lname'])]);
        update_user_meta($this->userId, 'phone', $info['data']['phone']);
        return "Profile updated successfully";
    }

    function passwordUpdate($info) {
        $getUserDetails = (array) get_userdata($this->userId);
        $currentPassword = $getUserDetails['data']->user_pass;
        $confirmPassword = $info['data']['oldPass'];
        $newPassword = $info['data']['newPassword'];
        if (wp_check_password($confirmPassword, $currentPassword, $this->userId)):
            if ($newPassword != ""):
                wp_set_password($newPassword, $this->userId);
                return "Password changed successfully";
            else:
                return "New Password cannot be empty";
            endif;
        else:
            return "Old Password doesn't Match";
        endif;
        print_r($info);
        exit;
    }

    function uploadImg($imgInfo) {
        $rand = rand(0, 99999999999);
        $fileName = $rand . $_FILES['file']['name'];
        $getDir = wp_upload_dir();
        $getDirUrl = $getDir['basedir'];
        if (0 < $_FILES['file']['error']) {
            echo 'Error: ' . $_FILES['file']['error'] . '<br>';
        } else {
            move_uploaded_file($_FILES['file']['tmp_name'], $getDirUrl . '/profile/' . $fileName);
        }

        $getId = get_user_meta($this->userId, 'profile_pic');
        if ($_FILES['file']['name'] != ""):
            if ($getId[0] != ""):
                wp_delete_attachment($getId[0]);
                $imgInfo = ['img' => $fileName];
                $getImgId = $this->uploadPic($imgInfo);
                update_user_meta($this->userId, 'profile_pic', $getImgId);
            else:
                $imgInfo = ['img' => $fileName];
                $getImgId = $this->uploadPic($imgInfo);
                update_user_meta($this->userId, 'profile_pic', $getImgId);
            endif;
        endif;
    }

    function uploadPic($imgInfo) {
        $filename = 'profile/' . $imgInfo['img'];
        $parent_post_id = 0;
        $filetype = wp_check_filetype(basename($filename), null);
        $wp_upload_dir = wp_upload_dir();
        $attachment = array(
            'guid' => $wp_upload_dir['url'] . '/' . basename($filename),
            'post_mime_type' => $filetype['type'],
            'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
            'post_content' => '',
            'post_status' => 'inherit'
        );
        $attach_id = wp_insert_attachment($attachment, $filename, $parent_post_id);
        return $attach_id;
    }

    function getUnclearedPoints() {
        global $wpdb;
        $userId = $this->userId;
        $getUnClearedPoints = $wpdb->get_results("SELECT sum(gain_points) as unclearedPoints FROM wp_distribution  WHERE uid=$userId AND cleared=0 GROUP BY uid");
        return $getUnClearedPoints[0]->unclearedPoints;
    }

    public function getCsv($query) {
//print_r($query);exit;
        $combineRes[] = ['id', 'Users', 'Tournaments', 'Matches', 'Teams', 'Points', 'Bet At'];
        $combineRes[] = ['', '', '', '', '', '', ''];
        foreach ($query as $getResult):
            //echo $getResult->id;echo "<br>";
            $getUsername = get_userdata($getResult->uid);
            $userName = $getUsername->data->display_name;
            $tourName = get_the_title($getResult->tid);
            $matchTitle = !empty($getResult->mid) ? get_the_title($getResult->mid) : '-';
            $teamTitle = get_the_title($getResult->team_id);
            $combineRes[] = array($getResult->id, $userName, $tourName, $matchTitle, $teamTitle, $getResult->pts, $getResult->bet_at);
        endforeach;
        $fp = fopen(get_template_directory() . '/csv/' . $this->userId . 'file.csv', 'w');
        foreach ($combineRes as $fields) {
            fputcsv($fp, $fields);
        }
        fclose($fp);
    }

    public function contacUs($getData) {
        global $wpdb;
        $userDetails = [];
        parse_str($getData['data'], $userDetails);
        $results = $wpdb->insert("wp_contact_us", $userDetails);
        if (!$results):
            return ['msg' => "Something goes wrong try again later", 'errorType' => 'danger'];
        else:
            $headers = 'Content-type: text/html';
            $name = $userDetails['fname'];
            $email = $userDetails['email'];
            $phone = $userDetails['phone'];
            $message = $userDetails['message'];
            $body = "<p>Name : $name</p><p>Email : $email</p>Phone : $phone <p>Message : $message</p>";
            wp_mail(get_option('smtp_user'), "Contact Us", $body, $headers);
            $bodyUser = "Dear $name,<br> Thank you for contacting us. We will get back to you shortly.";
            wp_mail($email, "Contact Us", $bodyUser, $headers);
            return ['msg' => "Thank you for getting in touch. We will respond to you shortly.", 'errorType' => 'success'];
        endif;
    }

    public function forgotPassword($userInfo) {
        $email = email_exists($userInfo['user_login']); //check if email id exist
        $username = username_exists($userInfo['user_login']); //check username exists
        if ($email != ""):
            return "Yes";
        elseif ($username != ""):
            return "Yes";
        else:
            return "No";
        endif;
    }

    public function forgotPasswordReset($info) {

        $getPassword = $info['data']['newPassword'];
        $getkey = $info['data']['key'];
        $getLogin = $info['data']['login'];
        $result = check_password_reset_key($getkey, $getLogin);
        //print_r($result);exit;

        if (isset($result->errors)):
            return ['msg' => "Invalid key", 'errorType' => 'danger'];
        else:
            $user_id = (array) $result->data;
            $getResult = wp_set_password($getPassword, $user_id['ID']);
            if (!is_wp_error($getResult)):
                return ['msg' => "Password Changed Successfully", 'errorType' => 'success'];
            else:
                return ['msg' => "Invalid key", 'errorType' => 'danger'];
            endif;
        endif;
    }

    public function header() {
        
    }

}
