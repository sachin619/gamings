<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ApiClass extends API {

    function leaderBoard() {

        $getCurrentDate = $this->getDate;
        $getDate = strtotime(date('Y-m-d '), $getCurrentDate);
        $createDate = date('Y-m-d h:i:s', $getDate - 259197);
        $getUsers = $this->wpdb->get_results("SELECT uid,mid,tid,sum(pts) as total,bet_at,count(distinct mid) as get_count FROM wp_bets WHERE bet_at < '" . $getCurrentDate . "' AND  bet_at>'" . $createDate . "' group by uid having count(distinct mid)>=2 order by total DESC ");
        foreach ($getUsers as $getUsersFilter):
            $userId = $getUsersFilter->uid;
            $geImgId = get_user_meta($userId, 'profile_pic');
            $userDetails[] = get_userdata($userId);
            $getTour[]=  get_the_title($getUsersFilter->tid);
            $getMatch[]=  get_the_title($getUsersFilter->mid);
            $userImg[] = $this->getProfileImg($geImgId[0]);
            $getPts[]=$getUsersFilter->total;
        endforeach;
        return ['userDetails'=>$userDetails,'userImg'=>$userImg,'tid'=>$getTour,'mid'=>$getMatch,'pts'=>$getPts];
    }

}
