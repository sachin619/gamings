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
        $checkResult = $wpdb->get_results("SELECT sum(gain_points)-(SELECT sum(gain_points) FROM wp_distribution WHERE  status=1 and date between '" . $getStartDate . "'  and  '" . $getEndDate . "'  ) as total,count(mid) as getMid,uid FROM wp_distribution WHERE   status=0 and date between  '" . $getStartDate . "'  and  '" . $getEndDate . "'  group by uid having total>0 AND getMid>= $getMinMatch order by getMid desc limit 5");
        if (empty($checkResult)):            //if no results found unset winner
            update_field('winner_0', '', $collectSchemeInfo[0]['id']);
            update_field('winner_1', '', $collectSchemeInfo[0]['id']);
            update_field('winner_2', '', $collectSchemeInfo[0]['id']);
            return false;
        endif;
        $limitUser = 0;
        foreach ($checkResult as $fetchResult):
            $getUserRole = get_userdata($fetchResult->uid);
            $getUserId = $fetchResult->uid;
            if ($fetchResult->total > 0 && $getUserRole->caps['administrator'] != 1):          //only top 3 results (0,1,2)
                $userName = get_user_by('id', $getUserId);
                $userFirstName = get_user_meta($getUserId, 'first_name');
                $userLastName = get_user_meta($getUserId, 'last_name');
                $userFullName = $userFirstName[0] . " " . $userLastName[0];
                $geImgId = get_user_meta($getUserId, 'profile_pic');
                $userFbUrl = get_userdata($getUserId);
                $userFbUrlFilter = $userFbUrl->data->user_url;
                $getUsrfbImg = explode('/', $userFbUrlFilter);
                $userImg[] = $this->getProfileImg($geImgId[0]);
                $getInfo[] = ['pts' => $fetchResult->total, 'userId' => $getUserId, 'userName' => $userFullName, 'fbUrl' => $getUsrfbImg[4]];
                update_field('winner_' . $limitUser, $userName->data->display_name, $collectSchemeInfo[0]['id']);
            endif;
            $limitUser++;
        endforeach;
        $getTop3users = array_slice($getInfo, 0, 3);
        return ['info' => $getTop3users, 'startDate' => $getFormatStartDate, 'endDate' => $getFormatEndDate, 'img' => $getImg, 'award' => $getContent, 'getUserImg' => $userImg];
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
