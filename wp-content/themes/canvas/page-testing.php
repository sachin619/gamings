<?php
//acf_form_head(); 
wp_head();
?>
<!--<img src="http://localhost/gamings/wp-content/uploads/profile/loader.gif" />-->
<?php

//get date of wordpress
$getDate= current_time('mysql');
$convertDate=strtotime($getDate."-7 days");
echo date('d-m-y',$convertDate);
//get date of wordpress
echo get_template_directory();
exit;
    $api=new API();
    $api->testing();
global $wpdb;

$query = $wpdb->get_results("SELECT * FROM wp_bets");
$i = 0;
$combineRes[]=['id','Users','Tournaments','Matches','Teams','Points','Bet At'];
$combineRes[]=['','','','','','',''];
foreach ($query as $getResult):
    //echo $getResult->id;echo "<br>";
    $getUsername = get_userdata($getResult->uid);
    $userName = $getUsername->data->display_name;
    $tourName=get_the_title($getResult->tid);
    $matchTitle= !empty( $getResult->mid)?get_the_title( $getResult->mid):'-' ;
    $teamTitle=  get_the_title($getResult->team_id);
    $combineRes[] = array($getResult->id, $userName,$tourName, $matchTitle,$teamTitle, $getResult->pts, $getResult->bet_at);
endforeach;


$fp = fopen('file.csv', 'w');

foreach ($combineRes as $fields) {

    fputcsv($fp, $fields);
}

fclose($fp);
exit;
exit;
//echo time();
$date = date('m/d/Y h:i:s a', time());
echo strtotime($date);
exit;
global $wpdb;
$getUnClearedPoints = $wpdb->get_results('SELECT sum(gain_points) as unclearedPoints FROM wp_distribution  WHERE uid=1 AND cleared=0 GROUP BY uid');
print_r($getUnClearedPoints[0]->unclearedPoints);
exit;

$getId = get_user_meta(12, 'profile_pic');

if ($getId[0] != ""):
    print_r($getId[0]);
    wp_delete_attachment($getId[0]);
    $imgInfo = ['img' => 'loader.gif'];
    $getImgId = uploadPic($imgInfo);
    echo $getImgId;
    echo "<br>";
    update_user_meta(12, 'profile_pic', $getImgId);
else:
    $imgInfo = ['img' => 'loader.gif'];
    $getImgId = uploadPic($imgInfo);
    echo $getImgId;
    echo "<br>";
    update_user_meta(12, 'profile_pic', $getImgId);
    echo "No";
endif;

//exit;
//$getImage=wp_get_attachment_image_src(184, 'full' );
//print_r($getImage);
//insert wp attachment

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

//insert wp attachment
exit;


$getImage = wp_get_attachment_image_src(64, 'full');
print_r($getImage);
exit;

$postarr = ['post_type' => 'attachment', 'guid' => 'http://localhost/gamings/wp-content/uploads/2016/05/kungfu.jpg'];
wp_insert_post($postarr);
exit;
exit;
$getId = get_user_meta(12, 'profile_pic');

print_r($getImage);
exit;
die();
$getImage = explode(".", the_field('profile_pic', 'user_12'));

echo get_avatar_url(15);
exit;
print_r(date('Y-m-d h:i:s', time()));
exit;
print_r(date('Y-m-d h:i a', '1462183200'));
exit;

function upcomingTournaments($categorySlug, $getPageCount) {
    $postPerPage = $getPageCount;
    $dateFormat = date('Ymd');
    $dateTimeFormat = time();
    $args = [ 'post_type' => 'tournaments', 'category_name' => $categorySlug, 'posts_per_page' => $postPerPage, 'meta_key' => 'start_date', 'orderby' => 'meta_value_num', 'order' => 'ASC',
        'meta_query' => ['relation' => 'AND', [
                'key' => 'end_date',
                'value' => $dateFormat,
                'compare' => '>='
            ], [
                'key' => 'betting_allowed_till',
                'value' => $dateTimeFormat,
                'compare' => '>='
            ]],
    ];
    return $this->getResult($args);
}

echo date('Ymd');
exit;

error_reporting(1);
$get = get_page_by_title('T20 Worldcup', OBJECT, 'tournaments');

print_r($get->ID);
exit;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//echo  $_SERVER['REQUEST_URI'];exit;
//get category image

echo date('d M Y ', strtotime('2016-04-12 12:00 am'));
exit;
$user = get_userdata(12);
print_r($user->data->user_login);
exit;

$img = get_template_directory_uri() . "/images/default.jpg";
echo "<img src=$img >";
$getCategoryImage = get_the_category(89);
$getCategoryFilter = (array) $getCategoryImage[0];
$getCatTerm = get_option('category_' . $getCategoryFilter['term_id'] . '_image');
$getCateFeatImg = wp_get_attachment_url($getCatTerm);
echo $getCateFeatImg;
exit;
//ge category image
echo floor(1.80);
exit;
echo time();
echo "<br>";
echo strtotime(date('Y-m-d h:m a'));
exit;
echo get_the_excerpt(98);
exit;
echo round('0.844060198', 2);
exit;
$result = $wpdb->get_results("SELECT sum(pts) as total FROM wp_bets WHERE tid=89 AND uid=1 GROUP BY uid ");
$getResult = (array) $result[0];
print_r($getResult['total']);
exit;

global $wpdb;
$result = $wpdb->get_results('SELECT sum(pts) as total FROM wp_bets WHERE tid="89" AND team_id="' . $tradeInfo["team_id"] . '" AND user_id="' . $tradeInfo["user_id"] . '" ');
return $result;




exit;

$data = ['uid' => '1', 'mid' => '2', 'tid' => '3', 'team_id' => '4', 'pts' => '5'];
$result = $wpdb->insert('wp_bets', $data);
return $result;
exit;


$user_id = get_current_user_id();
$args = ['post_type' => 'tournaments', 'p' => '80'];
$query = new WP_Query($args);
//echo "<pre>";print_r($query);exit;
while ($query->have_posts()) {
    $query->the_post();
    echo get_the_title();
}exit;
if (strpos($_SERVER['REQUEST_URI'], 'testing')):
    echo "true";
else:echo "false";
endif;
exit;
wp_logout();
exit;
$credential = ['user_login' => 'admin', 'user_password' => 'admin'];
$getId['data'] = wp_signon($credential, false);
print_r($getId);
exit;
$username = "echo.sm4b@gmail.com";
$id = email_exists($username);
if ($id == "") {
    echo "yes";
} else {
    echo "no";
}

$username = "admin4";
$id = username_exists($username);
print_r($id);
exit;

$args = ['post_type' => 'matches'];
$query = new WP_Query($args);
while ($query->have_posts()) {
    $query->the_post();
    $output = get_post_meta($post->ID, 'start_date');
    $date_format = date('h:i a', $output[0]);
    print_r($date_format);
    echo "<br>";
}
?>