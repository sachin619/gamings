<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ApiClass extends API {

    function leaderBoard() {
        $args = ['post_type' => 'scheme', 'meta_query' => [[
            'key' => 'status',
            'value' => 'Active',
            'compare' => '=']
        ]];
        $collectSchemeInfo = $this->getResult($args);
        $getFormatStartDate = date('d M Y', strtotime($collectSchemeInfo[0]['from_date']));
        $getFormatEndDate = date('d M Y', strtotime($collectSchemeInfo[0]['to_date']));
        $getStartDate = $collectSchemeInfo[0]['from_date'] . " 00:00:00";
        $getEndDate = $collectSchemeInfo[0]['to_date'] . " 23:59:00";
        $getMinMatch = $collectSchemeInfo[0]['min_no_of_matches'];
        $getImg = $collectSchemeInfo[0]['img'];
        $getContent = $collectSchemeInfo[0]['award'];
        global $wpdb;
        $getAccount = [];
        $result = $wpdb->get_results("SELECT id,uid,tid,mid,team_id,sum(pts)as pts,bet_at FROM wp_bets WHERE bet_at >= '" . $getStartDate . "' AND  bet_at <= '" . $getEndDate . "'  group by tid,team_id,mid,uid  order by pts ");
        $i = 1;
        foreach ($result as $getBetDetails):
            $getTourStatus = get_field('points_distributed', $getBetDetails->tid);
            $getMatchStatus = get_field('points_distributed', $getBetDetails->mid);
            $getTourCancel = get_field('tournament_abandoned', $getBetDetails->tid);
            $getMatchCancel = get_field('match_abandoned', $getBetDetails->mid);
            $getMatchDraw = get_field('match_draw', $getBetDetails->mid);
            $getTourDraw = get_field('tournament_draw', $getBetDetails->mid);
            $getWinStatus = get_field('select_teams', $getBetDetails->mid);
            if ($getWinStatus[0]['winner'] == 'No' && $getWinStatus[1]['winner'] == 'No'):
                $getAccount = $this->getDrawMatch($getMatchDraw, $getBetDetails, $wpdb, $getAccount, $i);
            else:
                if (($getMatchStatus == "Yes" && $getMatchCancel == 'No' && $getBetDetails->team_id != 0 && $getMatchDraw == 'No' ) || ($getTourStatus == 'Yes' && $getTourCancel == 'No' && $getMatchDraw == 'No' && $getTourDraw == 'No' )):
                    $getWin = $wpdb->get_results("SELECT id FROM wp_distribution WHERE uid= $getBetDetails->uid AND tid=$getBetDetails->tid AND mid=$getBetDetails->mid AND team_id=$getBetDetails->team_id ");
                    $tourDetails['win'] = !empty($getWin) ? "Yes" : "No";
                    if (!empty($getWin)):
                        $collectWinpoints[$getBetDetails->uid][] = $getBetDetails->pts; //get win points
                    else:
                        $collectLosspoints[$getBetDetails->uid][] = $getBetDetails->pts;   //get loss points
                    endif;
                    $tourDetails['id'] = $i++;
                    $getMid[$getBetDetails->uid][] = $getBetDetails->mid;
                endif;
            endif;
        endforeach;
        $limitUser = 0;
        foreach ($collectLosspoints as $getUserId => $getLossPts):
            if (count(array_unique($getMid[$getUserId])) >= $getMinMatch):
                $getTotal = array_sum($collectWinpoints[$getUserId]) - array_sum($getLossPts); //substract win - loss
                if ($getTotal > 0 && $limitUser <= 2):          //only top 3 results (0,1,2)
                    $userName = get_user_by('id', $getUserId);
                    $userFirstName = get_user_meta($getUserId, 'first_name');
                    $userLastName = get_user_meta($getUserId, 'last_name');
                    $userFullName = $userFirstName[0] . " " . $userLastName[0];
                    $geImgId = get_user_meta($getUserId, 'profile_pic');
                    $userImg[] = $this->getProfileImg($geImgId[0]);
                    $getInfo[] = ['userId' => $getUserId, 'userName' => $userFullName, 'pts' => $getTotal, 'mid' => count(array_unique($getMid[$getUserId]))];
                    update_field('winner_' . $limitUser, $userName->data->display_name, $collectSchemeInfo[0]['id']);
                endif;
            endif;
            $limitUser++;
        endforeach;
        return ['info' => $getInfo, 'startDate' => $getFormatStartDate, 'endDate' => $getFormatEndDate, 'img' => $getImg, 'award' => $getContent, 'getUserImg' => $userImg];
    }

    function formatNumberAbbreviation() {
        $getUserPoints = get_user_meta($this->userId, 'points');
        $number = $getUserPoints[0];
        $abbrevs = array(12 => "T", 9 => "B", 6 => "M", 3 => "K", 0 => "");

        foreach ($abbrevs as $exponent => $abbrev) {
            if ($number >= pow(10, $exponent)) {
                return round(number_format($number / pow(10, $exponent), 2)) . $abbrev;
            }
        }
    }

}
