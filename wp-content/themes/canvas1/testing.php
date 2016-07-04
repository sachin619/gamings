
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
        $output = $api->listingTournaments();
        break;
    case 'premium-trade':
        $tradeInfo['tid'] = 89;
        $tradeInfo['team_id'] = '';
        $output = $api->premiumTrade('tid', $tradeInfo);
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
        return [];
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
        $tradeInfo = ['tid' => $tId];
        $getTotalBets = $this->getTotalTrade($tradeInfo, 'mid');
        $detailsData = ['details' => $allResult, 'pts' => $var, 'totalBets' => $getTotalBets];
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
                'key' => 'end_date',
                'value' => $dateFormat,
                'compare' => '>=',
            ],
        ];
        return $this->getResult($args);
    }

    function popularTournaments() {
        return [];
    }

    function tournamentsDetail($postId) {
        $args = ['post_type' => 'tournaments', 'name' => $postId['data']['postId']];
        $userId = $this->userId;
        //$args = ['post_type' => 'tournaments', 'name' => $postId['postId']];
        $result = $this->getResult($args);
        $allResult = $this->getResult($args);
        $tId = $result[0]['id'];
        foreach ($result[0]['participating_team'] as $result) {
            $teamInfo = (array) $result['team'];
            $teamId = $teamInfo['ID'];
            $tradeInfo = ['tid' => $tId, 'team_id' => $teamId, 'user_id' => $userId];
            $var[] = $this->getUserTrade($tradeInfo, 'tid');
        }
        $tradeInfo = ['tid' => $tId];
        $getTotalBets = $this->getTotalTrade($tradeInfo, 'tid');
        $detailsData = ['details' => $allResult, 'pts' => $var, 'totalBets' => $getTotalBets];
        return $detailsData;
    }

    function upcomingTournaments() {
        $dateFormat = date('Ymd');
        $args = [ 'post_type' => 'tournaments', 'meta_key' => 'start_date', 'orderby' => 'meta_value_num', 'order' => 'ASC',
            'meta_query' => [
                'key' => 'end_date',
                'value' => $dateFormat,
                'compare' => '>='
            ],
        ];
        return $this->getResult($args);
    }

    function listingTournaments() {
        $getCat = $this->getCategories();
        $args = ['post_type' => 'tournaments'];
        $result = $this->getResult($args);
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

    function trade($tradeInfo) {
        global $wpdb;
        $userId = $this->userId;
        $tId = isset($tradeInfo['data']['tid']) ? $tradeInfo['data']['tid'] : 0;
        $mId = isset($tradeInfo['data']['mid']) ? $tradeInfo['data']['mid'] : 0;
        $teamId = $tradeInfo['data']['team_id'];
        $points = $tradeInfo['data']['pts'];
        $uPoints = get_user_meta($userId, 'points');
        $usedPoints = get_user_meta($userId, 'points_used');
        $usedCalc = $usedPoints[0] + $points;                 //adding bet points and current remaining points
        $wpBets = ['uid' => $userId, 'mid' => $mId, 'tid' => $tId, 'team_id' => $teamId, 'pts' => $points];
        if ($points <= $uPoints[0]):
            $remaining = $uPoints[0] - $points;
            update_user_meta($userId, 'points', $remaining);
            update_user_meta($userId, 'points_used', $usedCalc);
            $wpdb->insert('wp_bets', $wpBets);
            return "You had bet " . $points . " Points";
        else:
            return "Not have enough points";
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

    function premiumTrade($Tradetype, $tradeInfo) {
        global $wpdb;
        $args = ['post_type' => 'tournaments', 'name' => 'ipl-2'];
        $getTeams = $this->getResult($args);
        $i = 0;
        $j = 0;
        //get loss
        foreach ($getTeams[0]['participating_team'] as $team) {
            if ($team['eliminated'] == 'Yes') {
                $teams = (array) $team['team'];
                $result[] = $wpdb->get_results("SELECT sum(pts) as pts FROM wp_bets WHERE $Tradetype='" . $tradeInfo['tid'] . "' AND team_id= '" . $teams['ID'] . "'   ");
                $getVal[] = (array) $result[$i++][0];
                $getLoss+=$getVal[$j++]['pts'];
            }
        }


        $getTotal = (array) $wpdb->get_results("SELECT sum(pts) as pts FROM wp_bets WHERE $Tradetype='" . $tradeInfo['tid'] . "'    ");
        $totalPts = (array) $getTotal[0];
        foreach ($getTeams[0]['participating_team'] as $teamTotal) {
           $k = 0;
            if ($teamTotal['eliminated'] == 'Yes') {
                $getId = (array) $teamTotal['team'];
                $getResult = (array) $wpdb->get_results("SELECT sum(pts) as pts FROM wp_bets WHERE $Tradetype='" . $tradeInfo['tid'] . "' AND team_id = '" . $getId['ID'] . "'   ");
                $filterTotlal[] = (array) $getResult[0];
                $filter=array_slice($filterTotlal,0,count($filterTotlal)-2);
                $addPts+=$filter[$k]['pts'];
                $toalPts+= ($totalPts['pts']);
            }
            
           $k++;
        }
    // echo "<pre>";   print_r($totalPtsq);exit;
        $calcTotal = $getLoss / ($toalPts - $getLoss);
        echo "<pre>"; print_r($toalPts);
        //print_r($transport );



        //
        //return $result;
    }

    function getFeaturedImg($id) {
        $image = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'full');
        return $image['0'];
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
            return "Email Id already exist";
        elseif ($username != ""):
            return "Username already exist";
        else:
            $user_id = wp_insert_user($userData);
            update_user_meta($user_id, 'phone', $userInfo['data']['phone']);
            if (!is_wp_error($user_id)):
                return "Successfully Registered";
            else:
                return "Something goes wrong try again later";
            endif;
        endif;
    }

    function getResult($args) {
        $output = [];
        $query = new WP_Query($args);
        while ($query->have_posts()): $query->the_post();
            $id = get_the_ID();

            $post = [
                'id' => $id,
                'title' => get_the_title(),
                'img' => $this->getFeaturedImg($id),
                'content' => get_the_content(),
                'postLink' => get_permalink($post->ID),
                'category' => get_the_category($post->ID)
            ];
            foreach (get_fields($id) as $k => $v) {
                $post[$k] = $v;
            }

            array_push($output, $post);
        endwhile;
        return $output;
    }

    function getCategories($args) {
        return get_categories($args);
    }

}

