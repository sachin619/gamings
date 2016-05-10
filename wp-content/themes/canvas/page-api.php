<?php

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
$uid = isset($_REQUEST['userId']) ? $_REQUEST['userId'] : '';
$output = null;
$api = new API();

switch ($action) {
    case 'home':
        $output = $api->home();
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
        $home['popularMatches'] = $this->popularMatches();
        $home['upcomingTournaments'] = $this->upcomingTournaments();
        $home['upcomingMatches'] = $this->upcomingMatches();
        $home['category'] = $this->getCategories(['parent' => 1]);
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

    function popularTournaments() {
        $args = [
            'post_type' => 'tournaments',
            'posts_per_page' => 12,
            'meta_key' => 'total_tour_bets',
            'orderby' => 'meta_value',
            'order' => 'DESC'
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
        $detailsData = ['details' => $allResult, 'pts' => $var, 'totalBets' => $getTotalBets, 'userTotalTrade' => $userTotalTrade, 'matches' => $this->upcomingMatches()];
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
        $postPerPage = $getPageCount;
        $dateFormat = date('Ymd');
        $args = [ 'post_type' => 'tournaments', 'category_name' => $categorySlug, 'posts_per_page' => $postPerPage, 'meta_key' => 'start_date', 'orderby' => 'start_date', 'order' => 'ASC',
            'meta_query' => [
                'key' => 'end_date',
                'value' => $dateFormat,
                'compare' => '>='
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
        $categorySlug = $getCatSlug['data']['categoryName'];
        if (!empty($getCatSlug['data']['getCount'])):
            $getPageCount = $getCatSlug['data']['getCount'];
        else:
            $getPageCount = 6;
        endif;
        $dateFormat = time();
        $getCat = $this->getCategories(['parent' => 1]);
        $args = [
            'post_type' => 'matches',
            'meta_key' => 'start_date',
            'order_by' => 'start_date',
            'category_name' => $categorySlug,
            'posts_per_page' => $getPageCount,
            'order' => 'ASC',
            'meta_query' =>
            [
                'key' => 'end_date',
                'value' => $dateFormat,
                'compare' => '>=',
            ],
        ];
        $result = $this->getResult($args);
        foreach ($getCat as $categories) {
            $catName = (array) $categories;
            $cat[] = ['catName' => $catName['name']];
        }
        foreach ($result as $getPost) {
            $tradeInfo = ['tid' => $getPost['id']];
            $getTrade = $this->getTotalTrade($tradeInfo, 'mid');
            $converTrade[] = (array) $getTrade[0];
        }

        $output = ['catName' => $cat, 'catPost' => $result, 'tradeTotal' => $converTrade];
        return $output;
    }

    function multiTradeMatch($tradeInfo) {
        if (!empty($tradeInfo['data']['pts'])):

            foreach ($tradeInfo['data']['pts'] as $teamId => $points) {
                $tradeInfo['data']['team_id'] = $teamId;
                $tradeInfo['data']['pts'] = $points;
                $get_result[] = $this->tradeMatch($tradeInfo);
            }
            return $get_result;
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
        $getCurrentTime = time();
        $getWinnerCount = count($count);/** get count of eliminated team** */
        $getTourId = isset($getTeams[0]['tournament_name']->ID) ? $getTeams[0]['tournament_name']->ID : 0;
        $wpBets = ['uid' => $userId, 'mid' => $mId, 'tid' => $getTourId, 'team_id' => $teamId, 'pts' => $points];
        if (!empty($tradeInfo['data']['pts'])):
            if ($points >= $getMinimumBetAmount):
                if ($getEndTime >= $getCurrentTime && $getWinnerCount != 1):
                    if ($points <= $uPoints):
                        $remaining = $uPoints - $points;
                        update_user_meta($userId, 'points', $remaining);
                        update_user_meta($userId, 'points_used', $usedCalc);
                        $wpdb->insert('wp_bets', $wpBets);
                        return "You have traded " . $points . " Point's";
                    else:
                        return "Not have enough points";
                    endif;
                else:
                    return "Match had been over";
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
        $usedCalc = $usedPoints + $points;                 //adding bet points and current remaining points
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
        $getCurrentTime = time();
        $getPrem = $getTeams[0]['premium']; //premium calculation
        $premCalc = round($points / $getPrem); //premium calculation
        $getCount = count($count); //get count of eliminated team
        $getNoCount = count($countNo); //get count of non eliminated team
        $wpBets = ['uid' => $userId, 'mid' => $mId, 'tid' => $tId, 'team_id' => $teamId, 'pts' => $premCalc, 'stage' => $getCount, 'premium' => $getPrem];
        if (!empty($tradeInfo['data']['pts']) && is_numeric($tradeInfo['data']['pts'])):
            if ($points >= $getMinimumBetAmount && !empty($tradeInfo['data']['pts'])):
                if ($getEndTime >= $getCurrentTime && $getNoCount != 1):
                    if (!in_array($teamId, $elimiatedTeamId)):
                        if ($points <= $uPoints):
                            $remaining = $uPoints - $points;
                            update_user_meta($userId, 'points', $remaining);
                            update_user_meta($userId, 'points_used', $usedCalc);
                            $wpdb->insert('wp_bets', $wpBets);
                            if (!empty(trim($getPrem))):
                                return "You have traded " . $points . " Point's";
                            elseif (empty(trim($getPrem))):
                                return "You have traded" . $points . " Point's";
                            endif;
                        else:
                            return "Not have enough points";
                        endif;
                    else:
                        return "This team had been Eliminated";
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
            //$this->adminDistribution($userid->ID);
            return "success_login";
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
                update_user_meta($user_id, 'points', get_option("token_amt"));
                return ['msg' => 'Registered Successfully & You have got 500 points', 'errorType' => 'success'];
            else:
                return ['msg' => "Something goes wrong try again later", 'errorType' => 'danger'];
            endif;
        endif;
    }

    function getResult($args) {
        $userId = $this->userId;
        $output = [];
        $query = new WP_Query($args);
        while ($query->have_posts()): $query->the_post();
            $id = get_the_ID();
            $postType = get_post_type($id);
            $post = [
                'id' => $id,
                'uid' => $userId,
                'title' => get_the_title(),
                'img' => $this->getFeaturedImg($id),
                'content' => get_the_content(),
                'postLink' => get_permalink($post->ID),
                'category' => get_the_category($post->ID)
            ];
            foreach (get_fields($id) as $k => $v) {
                $post[$k] = $v;
                if ($k == 'start_date'):$post['matchStartDate'] = date('M', strtotime($v));
                    $post['matchStartTime'] = date('H:i', strtotime($v));
                    $post['start_date_original'] = $v;
                    if ($postType == 'matches'):
                        $post['start_date'] = date('d M, Y H:i a', strtotime($v));
                    else:
                        $post['start_date'] = date('d M, Y', strtotime($v));

                    endif;
                elseif ($k == 'end_date'):$post['matchEndDate'] = date('M', strtotime($v));
                    $post['end_date_original'] = $v;
                    $post['matchEndTime'] = date('H:i', strtotime($v));
                    if ($postType == 'matches'):
                        $post['end_date'] = date('d M, Y H:i a', strtotime($v));
                    else:
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
        return "Successfully Updated";
    }

    function passwordUpdate($info) {
        $getUserDetails = (array) get_userdata($this->userId);
        $currentPassword = $getUserDetails['data']->user_pass;
        $confirmPassword = $info['data']['oldPass'];
        $newPassword = $info['data']['newPassword'];
        if (wp_check_password($confirmPassword, $currentPassword, $this->userId)):
            if ($newPassword != ""):
                wp_set_password($newPassword, $this->userId);
                return "Successfully Updated";
            else:
                return "New Password cannot be empty";
            endif;
        else:
            return "Old Password Doesn't Match";
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

}
