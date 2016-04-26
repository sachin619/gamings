<?php
wp_head();
?>
<?php
error_reporting(1);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//echo  $_SERVER['REQUEST_URI'];exit;

//get category image

$img= get_template_directory_uri()."/images/default.jpg";
echo "<img src=$img >";
$getCategoryImage=get_the_category(89);
$getCategoryFilter=(array)$getCategoryImage[0];
$getCatTerm=  get_option('category_'.$getCategoryFilter['term_id'].'_image');
$getCateFeatImg=wp_get_attachment_url($getCatTerm);
echo $getCateFeatImg;exit;
//ge category image
echo floor(1.80);exit;
echo time();echo "<br>";
echo strtotime(date('Y-m-d h:m a')) ;exit;
echo get_the_excerpt(98);exit;
echo round('0.844060198',2);exit;
 $result = $wpdb->get_results("SELECT sum(pts) as total FROM wp_bets WHERE tid=89 AND uid=1 GROUP BY uid ");
   $getResult= (array)$result[0];
    print_r($getResult['total']);
        exit;

      global $wpdb;
       $result=$wpdb->get_results('SELECT sum(pts) as total FROM wp_bets WHERE tid="89" AND team_id="'.$tradeInfo["team_id"].'" AND user_id="'.$tradeInfo["user_id"].'" ');
       return $result;

       
       
       
exit;

$data=['uid'=>'1','mid'=>'2','tid'=>'3','team_id'=>'4','pts'=>'5'];
$result=$wpdb->insert('wp_bets',$data);
return $result;exit;


$user_id=get_current_user_id();
$args=['post_type'=>'tournaments','p'=>'80'];
$query=new WP_Query($args);
//echo "<pre>";print_r($query);exit;
while($query->have_posts()){
    $query->the_post();
    echo get_the_title();
}exit;
if(strpos($_SERVER['REQUEST_URI'],'testing')):
    echo "true";
else:echo "false";
endif;
exit;
wp_logout();exit;
$credential=['user_login'=>'admin','user_password'=>'admin'];
$getId['data']=wp_signon($credential,false);
print_r($getId);exit;
$username="echo.sm4b@gmail.com";
$id=email_exists( $username );
 if($id==""){
     echo "yes";
 }else{
     echo "no";
 }

$username="admin4";
 $id=username_exists( $username );
 print_r($id);exit;

$args=['post_type'=>'matches'];
$query=new WP_Query($args);
while($query->have_posts()){
    $query->the_post();
    $output= get_post_meta($post->ID,'start_date');
    $date_format=date('h:i a',$output[0]);
    print_r($date_format);echo "<br>";
    
}
?>