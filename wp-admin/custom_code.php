<?php 
require_once( dirname( __FILE__ ) . '/admin.php' );


$args=array(
		'post_type'=>'tournaments',
		'post_per_page'=>100,
	
	);

$the_query=new WP_Query($args);
$post_id=35;
$repeater_value = get_post_meta($post_id, 'participating_team', true);
if ($repeater_value) {
   //echo $repeater_value;

  for ($i=0; $i<$repeater_value; $i++) {
    $meta_key = 'participating_team_'.$i.'_team';
    $sub_field_value = get_post_meta($post_id, $meta_key, true);
    $get_field_id[]=$sub_field_value;
   
  }
}
//print_r($get_field_id);
$args1=array(
    'post_type'=>'teams',
    'post_per_page'=>100,
);
$query1=new WP_Query($args1);
while($query1->have_posts()){
    $query1->the_post();
    
    if(in_array($post->ID,$get_field_id)){
        print_r(get_the_title());echo "<br>";
    }
}

//$imageurl = get_post_meta(35, 'participating_team_0_team', true);
//print_r($imageurl);
//while ($the_query->have_posts()) {
//$the_query->the_post();
//
//echo "<br>";
//
//}
?>