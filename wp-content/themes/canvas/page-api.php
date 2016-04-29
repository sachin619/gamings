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

        return $home;
    }

    function getSlider() {
        $args = [ 'post_type' => 'slider', 'meta_key' => 'active', 'meta_value' => 'Yes'];
        return $this->getResult($args);
    }

    function popularMatches() {
        $args = ['post_type' => 'matches', 'meta_key' => 'total_bets', 'orderby' => 'meta_value', 'order' => 'DESC'];
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
        $dateFormat = time();
        $args = [
            'post_type' => 'matches',
            'meta_key' => 'start_date',
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

    function upcomingTournaments($categorySlug, $getPageCount) {
        $postPerPage = $getPageCount;
        $dateFormat = date('Ymd');
        $args = [ 'post_type' => 'tournaments', 'category_name' => $categorySlug, 'posts_per_page' => $postPerPage, 'meta_key' => 'start_date', 'orderby' => 'meta_value_num', 'order' => 'ASC',
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
        $args = [ 'post_type' => 'tournaments', 'category_name' => $categorySlug, 'posts_per_page' => $postPerPage, 'meta_key' => 'start_date', 'orderby' => 'meta_value_num', 'order' => 'ASC',
            'meta_query' => [
                'key'=>'end_date',
                'value'=>$dateFormat,
                'compare'=>'>='
              ]
        ];
        return $this->getResult($args);
    }

    function listingTournaments($getCatSlug) {
        $categorySlug = $getCatSlug['data']['categoryName'];
        if (!empty($getCatSlug['data']['getCount'])):
            $getPageCount = $getCatSlug['data']['getCount'];
        else:
            $getPageCount = 4;
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
            $getPageCount = 4;
        endif;
        $dateFormat = time();
        $getCat = $this->getCategories(['parent' => 1]);
        $args = [
            'post_type' => 'matches',
            'meta_key' => 'start_date',
            'order_by' => 'meta_value_num',
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
            $tradeInfo = ['mid' => $getPost['id']];
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
            return "Points should be greater than 0";
        endif;
    }

    function tradeMatch($tradeInfo) {
        global $wpdb;
        $userId = $this->userId;
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
        $getEndTime = strtotime($getTeams[0]['end_date']);
        $getCurrentTime = time();
        $getWinnerCount = count($count);/** get count of eliminated team** */
        $wpBets = ['uid' => $userId, 'mid' => $mId, 'tid' => $getTeams[0]['tournament_name']->ID, 'team_id' => $teamId, 'pts' => $points];
        if (!empty($tradeInfo['data']['pts'])):
            if ($points > 0):
                if ($getEndTime >= $getCurrentTime && $getWinnerCount != 1):
                    if ($points <= $uPoints):
                        $remaining = $uPoints - $points;
                        update_user_meta($userId, 'points', $remaining);
                        update_user_meta($userId, 'points_used', $usedCalc);
                        $wpdb->insert('wp_bets', $wpBets);
                        return "You had bet " . $points . " Points";
                    else:
                        return "Not have enough points";
                    endif;
                else:
                    return "Tournament had been over";
                endif;
            else:
                return "Points should be greater than 0";
            endif;
        else:
            return "Points should be greater than 0";
        endif;
    }

    function trade($tradeInfo) {
        global $wpdb;
        $userId = $this->userId;
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
        if (!empty($tradeInfo['data']['pts'])):
            if ($points > 0 && !empty($tradeInfo['data']['pts'])):
                if ($getEndTime >= $getCurrentTime && $getNoCount != 1):
                    if (!in_array($teamId, $elimiatedTeamId)):
                        if ($points <= $uPoints):
                            $remaining = $uPoints - $points;
                            update_user_meta($userId, 'points', $remaining);
                            update_user_meta($userId, 'points_used', $usedCalc);
                            $wpdb->insert('wp_bets', $wpBets);
                            if (!empty(trim($getPrem))):
                                return "You had bet " . $points . " Points";
                            elseif (empty(trim($getPrem))):
                                return "You had bet " . $points . " Points";
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
                return "Points should be greater than 0";
            endif;
        else:
            return "Points should be greater than 0";
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
            return "success_login";
        else:
            return "Not a valid username or password";
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
            return ['msg' => "Email Id already exist", 'errorType' => 'warning'];
        elseif ($username != ""):
            return ['msg' => "Username already exist", 'errorType' => 'warning'];
        else:
            $user_id = wp_insert_user($userData);
            update_user_meta($user_id, 'phone', $userInfo['data']['phone']);
            if (!is_wp_error($user_id)):
                update_user_meta($user_id, 'points', '500');
                return ['msg' => 'Registered & You had got 500 points', 'errorType' => 'success'];
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
                elseif ($k == 'end_date'):$post['matchEndDate'] = date('M', strtotime($v));
                    $post['matchEndTime'] = date('H:i', strtotime($v));
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

}
