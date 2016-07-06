<?php

/**
 * Twenty Sixteen functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
/**
 * Twenty Sixteen only works in WordPress 4.4 or later.
 */
if (version_compare($GLOBALS['wp_version'], '4.4-alpha', '<')) {
    require get_template_directory() . '/inc/back-compat.php';
}

if (!function_exists('twentysixteen_setup')) :

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     *
     * Create your own twentysixteen_setup() function to override in a child theme.
     *
     * @since Twenty Sixteen 1.0
     */
    function twentysixteen_setup() {

        // date_default_timezone_set( 'UTC');
        // date_default_timezone_set( $_COOKIE['wordpress_useclientstimezone_timezone']);
//echo $getTimezone;
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Twenty Sixteen, use a find and replace
         * to change 'twentysixteen' to the name of your theme in all the template files
         */
        load_theme_textdomain('twentysixteen', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(1200, 9999);

        // This theme uses wp_nav_menu() in two locations.
        register_nav_menus(array(
            'primary' => __('Primary Menu', 'twentysixteen'),
            'social' => __('Social Links Menu', 'twentysixteen'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        /*
         * Enable support for Post Formats.
         *
         * See: https://codex.wordpress.org/Post_Formats
         */
        add_theme_support('post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
            'gallery',
            'status',
            'audio',
            'chat',
        ));

        /*
         * This theme styles the visual editor to resemble the theme style,
         * specifically font, colors, icons, and column width.
         */
        add_editor_style(array('css/editor-style.css', twentysixteen_fonts_url()));
    }

endif; // twentysixteen_setup
add_action('after_setup_theme', 'twentysixteen_setup');

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_content_width() {
    $GLOBALS['content_width'] = apply_filters('twentysixteen_content_width', 840);
}

add_action('after_setup_theme', 'twentysixteen_content_width', 0);

/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_widgets_init() {
    register_sidebar(array(
        'name' => __('Sidebar', 'twentysixteen'),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here to appear in your sidebar.', 'twentysixteen'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => __('Content Bottom 1', 'twentysixteen'),
        'id' => 'sidebar-2',
        'description' => __('Appears at the bottom of the content on posts and pages.', 'twentysixteen'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => __('Content Bottom 2', 'twentysixteen'),
        'id' => 'sidebar-3',
        'description' => __('Appears at the bottom of the content on posts and pages.', 'twentysixteen'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}

add_action('widgets_init', 'twentysixteen_widgets_init');

if (!function_exists('twentysixteen_fonts_url')) :

    /**
     * Register Google fonts for Twenty Sixteen.
     *
     * Create your own twentysixteen_fonts_url() function to override in a child theme.
     *
     * @since Twenty Sixteen 1.0
     *
     * @return string Google fonts URL for the theme.
     */
    function twentysixteen_fonts_url() {
        $fonts_url = '';
        $fonts = array();
        $subsets = 'latin,latin-ext';

        /* translators: If there are characters in your language that are not supported by Merriweather, translate this to 'off'. Do not translate into your own language. */
        if ('off' !== _x('on', 'Merriweather font: on or off', 'twentysixteen')) {
            $fonts[] = 'Merriweather:400,700,900,400italic,700italic,900italic';
        }

        /* translators: If there are characters in your language that are not supported by Montserrat, translate this to 'off'. Do not translate into your own language. */
        if ('off' !== _x('on', 'Montserrat font: on or off', 'twentysixteen')) {
            $fonts[] = 'Montserrat:400,700';
        }

        /* translators: If there are characters in your language that are not supported by Inconsolata, translate this to 'off'. Do not translate into your own language. */
        if ('off' !== _x('on', 'Inconsolata font: on or off', 'twentysixteen')) {
            $fonts[] = 'Inconsolata:400';
        }

        if ($fonts) {
            $fonts_url = add_query_arg(array(
                'family' => urlencode(implode('|', $fonts)),
                'subset' => urlencode($subsets),
                    ), 'https://fonts.googleapis.com/css');
        }

        return $fonts_url;
    }

endif;

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_javascript_detection() {
    echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}

add_action('wp_head', 'twentysixteen_javascript_detection', 0);

/**
 * Enqueues scripts and styles.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_scripts() {
    // Add custom fonts, used in the main stylesheet.
    wp_enqueue_style('twentysixteen-fonts', twentysixteen_fonts_url(), array(), null);
    wp_enqueue_script('angular-min', get_template_directory_uri() . '/js/angular.min.js');
    //wp_enqueue_script('jstz-min', get_template_directory_uri() . '/js/jstz.min.js'); //to get user time zone
    //wp_enqueue_script('jstz', get_template_directory_uri() . '/js/jstz.js'); //to get user time zone
    wp_enqueue_script('jquery-min', get_template_directory_uri() . '/js/jquery.min.js');
    wp_enqueue_script('ng-app', get_template_directory_uri() . '/js/ng-app.js');
    wp_enqueue_script('sweetalert-min', get_template_directory_uri() . '/js/sweetalert.min.js');
    wp_enqueue_style('sweetalert-min', get_template_directory_uri() . '/css/sweetalert.min.css');
    wp_enqueue_script('simplePagination', get_template_directory_uri() . '/js/simplePagination.js');
    wp_enqueue_script('custom', get_template_directory_uri() . '/js/custom.js');
    wp_enqueue_script('jquery-validate-min', get_template_directory_uri() . '/js/jquery.validate.min.js');
    //wp_enqueue_style('jqueryUi', get_template_directory_uri() . '/css/jqueryUi.css');
    // Add Genericons, used in the main stylesheet.
    wp_enqueue_style('genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.4.1');

    // Theme stylesheet.
    wp_enqueue_style('twentysixteen-style', get_stylesheet_uri());

    // Load the Internet Explorer specific stylesheet.
    wp_enqueue_style('twentysixteen-ie', get_template_directory_uri() . '/css/ie.css', array('twentysixteen-style'), '20150930');
    wp_style_add_data('twentysixteen-ie', 'conditional', 'lt IE 10');

    // Load the Internet Explorer 8 specific stylesheet.
    wp_enqueue_style('twentysixteen-ie8', get_template_directory_uri() . '/css/ie8.css', array('twentysixteen-style'), '20151230');
    wp_style_add_data('twentysixteen-ie8', 'conditional', 'lt IE 9');

    // Load the Internet Explorer 7 specific stylesheet.
    wp_enqueue_style('twentysixteen-ie7', get_template_directory_uri() . '/css/ie7.css', array('twentysixteen-style'), '20150930');
    wp_style_add_data('twentysixteen-ie7', 'conditional', 'lt IE 8');

    // Load the html5 shiv.
    wp_enqueue_script('twentysixteen-html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.3');
    wp_script_add_data('twentysixteen-html5', 'conditional', 'lt IE 9');

    wp_enqueue_script('twentysixteen-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151112', true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    if (is_singular() && wp_attachment_is_image()) {
        wp_enqueue_script('twentysixteen-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array('jquery'), '20151104');
    }

    wp_enqueue_script('twentysixteen-script', get_template_directory_uri() . '/js/functions.js', array('jquery'), '20151204', true);

    wp_localize_script('twentysixteen-script', 'screenReaderText', array(
        'expand' => __('expand child menu', 'twentysixteen'),
        'collapse' => __('collapse child menu', 'twentysixteen'),
    ));
}

add_action('wp_enqueue_scripts', 'twentysixteen_scripts');

/**
 * Adds custom classes to the array of body classes.
 *
 * @since Twenty Sixteen 1.0
 *
 * @param array $classes Classes for the body element.
 * @return array (Maybe) filtered body classes.
 */
function twentysixteen_body_classes($classes) {
    // Adds a class of custom-background-image to sites with a custom background image.
    if (get_background_image()) {
        $classes[] = 'custom-background-image';
    }

    // Adds a class of group-blog to sites with more than 1 published author.
    if (is_multi_author()) {
        $classes[] = 'group-blog';
    }

    // Adds a class of no-sidebar to sites without active sidebar.
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    return $classes;
}

add_filter('body_class', 'twentysixteen_body_classes');

/**
 * Converts a HEX value to RGB.
 *
 * @since Twenty Sixteen 1.0
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */
function twentysixteen_hex2rgb($color) {
    $color = trim($color, '#');

    if (strlen($color) === 3) {
        $r = hexdec(substr($color, 0, 1) . substr($color, 0, 1));
        $g = hexdec(substr($color, 1, 1) . substr($color, 1, 1));
        $b = hexdec(substr($color, 2, 1) . substr($color, 2, 1));
    } else if (strlen($color) === 6) {
        $r = hexdec(substr($color, 0, 2));
        $g = hexdec(substr($color, 2, 2));
        $b = hexdec(substr($color, 4, 2));
    } else {
        return array();
    }

    return array('red' => $r, 'green' => $g, 'blue' => $b);
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 *
 * @since Twenty Sixteen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function twentysixteen_content_image_sizes_attr($sizes, $size) {
    $width = $size[0];

    840 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';

    if ('page' === get_post_type()) {
        840 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
    } else {
        840 > $width && 600 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
        600 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
    }

    return $sizes;
}

add_filter('wp_calculate_image_sizes', 'twentysixteen_content_image_sizes_attr', 10, 2);

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails
 *
 * @since Twenty Sixteen 1.0
 *
 * @param array $attr Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function twentysixteen_post_thumbnail_sizes_attr($attr, $attachment, $size) {
    if ('post-thumbnail' === $size) {
        is_active_sidebar('sidebar-1') && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px';
        !is_active_sidebar('sidebar-1') && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
    }
    return $attr;
}

add_filter('wp_get_attachment_image_attributes', 'twentysixteen_post_thumbnail_sizes_attr', 10, 3);

/**
 * Modifies tag cloud widget arguments to have all tags in the widget same font size.
 *
 * @since Twenty Sixteen 1.1
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array A new modified arguments.
 */
function twentysixteen_widget_tag_cloud_args($args) {
    $args['largest'] = 1;
    $args['smallest'] = 1;
    $args['unit'] = 'em';
    return $args;
}

add_filter('widget_tag_cloud_args', 'twentysixteen_widget_tag_cloud_args');

function updatePremium($postId) {

    $tradeInfo["tid"] = $postId;
    if (get_post_type($postId) == 'tournaments'):
        global $wpdb;
        $args = ['post_type' => 'tournaments', 'p' => $postId];
        $getTeams = getResult($args);
        $i = 0;
        $j = 0;
        $Tradetype = 'tid';
        $tradeInfo['tid'] = $postId;
        foreach ($getTeams[0]['participating_team'] as $team) {
            if ($team['eliminated'] == 'Yes') {
                $teams = (array) $team['team'];
                $result[] = $wpdb->get_results("SELECT sum(pts) as pts FROM wp_bets WHERE $Tradetype='" . $tradeInfo['tid'] . "' AND team_id= '" . $teams['ID'] . "' AND team_id!=0 AND mid=0  ");
                $getVal[] = (array) $result[$i++][0];
                $getLoss+=$getVal[$j++]['pts'];
                $getCount[] = $team['eliminated'];
            }
        }

        $countStage = count($getCount);
        $checkStage = (array) $wpdb->get_results("SELECT sum(pts) as pts FROM wp_bets WHERE $Tradetype='" . $tradeInfo['tid'] . "'  AND team_id!=0 AND mid=0 AND stage='" . $countStage . "' GROUP BY stage   ");
        $checkStageFilter = (array) $checkStage[0];
        if ($checkStageFilter['pts'] > 0) {       //array_pop only when one more than one value exist in wp_bets table  
            $getTotal = (array) $wpdb->get_results("SELECT sum(pts) as pts FROM wp_bets WHERE $Tradetype='" . $tradeInfo['tid'] . "' AND team_id!=0 AND mid=0 GROUP BY stage   ");
            array_pop($getTotal);
        } else {
            $getTotal = (array) $wpdb->get_results("SELECT sum(pts) as pts FROM wp_bets WHERE $Tradetype='" . $tradeInfo['tid'] . "' AND team_id!=0 AND mid=0 GROUP BY stage   ");
        }

        foreach ($getTotal as $getPts) {
            $points = (array) $getPts;
            $addPts+=$points['pts'];
        }

        if ($countStage > 1) {
            $calcTotal = round($getLoss / ($addPts - $getLoss), 2) + 1;
        } else {
            $calcTotal = round($getLoss / ($addPts), 2) + 1;
        }
        update_post_meta($postId, 'premium', $calcTotal);
        /*         * ********points distribution******** */
        getPremium('tournaments', 'tid', $postId);

    endif;
}

add_action('save_post', 'updatePremium'); //for tournaments
add_action('save_post', 'updateMatchPremium'); //for matches

function updateMatchPremium($postId) {
    $tradeInfo["tid"] = $postId;
    $getTotalBets = getTotalTrade($tradeInfo, 'mid');
    if (get_post_type($postId) == 'matches'):
        global $wpdb;
        $getBetLoss = [];
        $Tradetype = 'mid';
        $type = "matches";
        $args = ['post_type' => $type, 'p' => $postId];
        $getTeams = getResult($args);
        foreach ($getTeams[0]['select_teams'] as $team) {
            if ($team['winner'] == 'Yes') {
                $countElimntd[] = $team['winner'];
                $teams = (array) $team['team_name'];
                $resultBets = $wpdb->get_results("SELECT sum(pts) as pts FROM wp_bets WHERE $Tradetype='" . $postId . "' AND team_id= '" . $teams['ID'] . "'  ");
                $totalWinBets = (array) $resultBets[0];
                $resultDis = $wpdb->get_results("SELECT sum(pts) as pts,uid,team_id FROM wp_bets WHERE $Tradetype='" . $postId . "' AND team_id= '" . $teams['ID'] . "' GROUP BY uid ");
            } else {
                $countElimntdLoss[] = $team['winner']; //for match abondoned
                $teamsLoss = (array) $team['team_name'];
                $teamId = $team['team_name']->ID;
                $resultBetsLoss = $wpdb->get_results("SELECT sum(pts) as pts,uid,tid,mid,team_id FROM wp_bets WHERE $Tradetype='" . $postId . "' AND team_id=$teamId  group by uid ");
                array_push($getBetLoss, $resultBetsLoss);
                $resultTieLoss = $wpdb->get_results("SELECT sum(pts) as pts,uid,tid,mid,team_id FROM wp_bets WHERE $Tradetype='" . $postId . "' AND team_id= 0 group by uid ");
            }
        }

        if (count($countElimntd) == 1 && $getTeams[0]['points_distributed'] !== 'Yes') { //if one winner left distribute points
            $getTotalBets = $wpdb->get_results("SELECT sum(pts) as pts FROM wp_bets WHERE $Tradetype='" . $postId . "'   ");
            $totBets = (array) $getTotalBets[0];
            $betsCalc = $totBets['pts'] / $totalWinBets['pts']; //total no of bet divide by total no winner
            foreach ($resultDis as $distribution) {
                $disFilter = (array) $distribution;
                $disCalc = ((int) $disFilter['pts'] * $betsCalc);
                $totalFloor = floor($disCalc);
                $getTotalTrade = teamTotalTrade($disFilter['uid'], $getTeams[0]['tournament_name']->ID, $postId, $disFilter['team_id']);
                $data = ['uid' => $disFilter['uid'], 'tid' => $getTeams[0]['tournament_name']->ID, 'mid' => $postId, 'team_id' => $disFilter['team_id'], 'gain_points' => $totalFloor, 'total_trade' => $getTotalTrade->pts];
                $wpdb->insert('wp_distribution', $data); //insert data
            }
            matchLossEntry($resultBetsLoss, $resultTieLoss, $wpdb); //enter match loss details
            update_post_meta($postId, 'points_distributed', 'Yes'); //if one winner left distribute points
        } else if (count($countElimntdLoss) == 2 && $getTeams[0]['match_abandoned'] == 'Yes' && $getTeams[0]['points_distributed'] != 'Yes') {  //for match abondoned
            matchCancelledEntry($getBetLoss, $resultTieLoss, $wpdb); //enter match cancelled details //some error
            update_post_meta($postId, 'points_distributed', 'Yes');
        } else if (count($countElimntdLoss) == 2 && $getTeams[0]['match_draw'] == 'Yes' && $getTeams[0]['points_distributed'] != 'Yes'):
            matchDraw($getBetLoss, $resultTieLoss, $getTeams, $wpdb, $Tradetype, $postId);
        endif;
    endif;  //for match abondoned
}

show_admin_bar(false);

$apiEndpoint = get_site_url() . '/api?action=';

function matchLossEntry($resultBetsLoss, $resultTieLoss, $wpdb) {
    foreach ($resultBetsLoss as $getResult):
        $dataLoss = ['uid' => $getResult->uid, 'tid' => $getResult->tid, 'mid' => $getResult->mid, 'team_id' => $getResult->team_id, 'total_trade' => $getResult->pts, 'gain_points' => $getResult->pts, 'status' => 1];
        $wpdb->insert('wp_distribution', $dataLoss);
    endforeach;
    foreach ($resultTieLoss as $getTieResult):
        if ($getTieResult->pts != ''):
            $dataTie = ['uid' => $getTieResult->uid, 'tid' => $getTieResult->tid, 'mid' => $getTieResult->mid, 'team_id' => $getTieResult->team_id, 'total_trade' => $getTieResult->pts, 'gain_points' => $getTieResult->pts, 'status' => 1];
            $wpdb->insert('wp_distribution', $dataTie);
        endif;
    endforeach;
}

function matchCancelledEntry($getBetLoss, $resultTieLoss, $wpdb) {
    foreach ($getBetLoss as $getResult):
        foreach ($getResult as $getTeamResult):
            $dataLoss = ['uid' => $getTeamResult->uid, 'tid' => $getTeamResult->tid, 'mid' => $getTeamResult->mid, 'team_id' => $getTeamResult->team_id, 'total_trade' => $getTeamResult->pts, 'gain_points' => $getTeamResult->pts, 'status' => 2];
            $wpdb->insert('wp_distribution', $dataLoss);
        endforeach;
    endforeach;
    foreach ($resultTieLoss as $getTieResult):
        if ($getTieResult->pts != ''):
            $dataTie = ['uid' => $getTieResult->uid, 'tid' => $getTieResult->tid, 'mid' => $getTieResult->mid, 'team_id' => $getTieResult->team_id, 'total_trade' => $getTieResult->pts, 'gain_points' => $getTieResult->pts, 'status' => 2];
            $wpdb->insert('wp_distribution', $dataTie);
        endif;
    endforeach;
}

function matchTieEntry($resultBetsLoss, $resultTieLoss, $wpdb) {
    foreach ($resultBetsLoss as $getLossTeam):
        foreach ($getLossTeam as $getLossTeamInd):
            $dataLoss = ['uid' => $getLossTeamInd->uid, 'tid' => $getLossTeamInd->tid, 'mid' => $getLossTeamInd->mid, 'team_id' => $getLossTeamInd->team_id, 'total_trade' => $getLossTeamInd->pts, 'gain_points' => $getLossTeamInd->pts, 'status' => 1];
            $wpdb->insert('wp_distribution', $dataLoss);
        endforeach;
    endforeach;
}

function teamTotalTrade($uid, $tid, $mid, $teamId) {
    global $wpdb;
    $getTotalBetsTeam = $wpdb->get_row("SELECT sum(pts) as pts FROM wp_bets WHERE uid= $uid AND tid=$tid AND mid=$mid AND team_id=$teamId");
    return $getTotalBetsTeam;
}

function matchDraw($getBetLoss, $resultTieLoss, $getTeams, $wpdb, $Tradetype, $postId) {
    $resultDisTie = $wpdb->get_results("SELECT sum(pts) as pts,uid,team_id FROM wp_bets WHERE $Tradetype='" . $postId . "' AND team_id= 0 GROUP BY uid ");
    $getTotalTradeTie = $wpdb->get_row("SELECT sum(pts) as pts FROM wp_bets WHERE $Tradetype='" . $postId . "' AND team_id= 0 group by team_id");
    $getTotalBets = $wpdb->get_row("SELECT sum(pts) as pts FROM wp_bets WHERE   $Tradetype='" . $postId . "'   ");
    foreach ($resultDisTie as $distribution) {
        $disFilter = (array) $distribution;
        $betsCalc = $getTotalBets->pts / $getTotalTradeTie->pts; //total no of bets divide by total no tie(bets/tie)
        $disCalc = ((int) $disFilter['pts'] * $betsCalc); //above result multiply by my bets
        $totalFloor = floor($disCalc);
        $data = ['uid' => $disFilter['uid'], 'tid' => $getTeams[0]['tournament_name']->ID, 'mid' => $postId, 'team_id' => $disFilter['team_id'], 'gain_points' => $totalFloor, 'total_trade' => $disFilter['pts']];
        $wpdb->insert('wp_distribution', $data);
    }
    matchTieEntry($getBetLoss, $resultTieLoss, $wpdb); //enter match loss details
    update_post_meta($postId, 'points_distributed', 'Yes'); //if one winner left distribute points
}

function api($url) {
    $response = wp_remote_get($url);
    return $api_response = json_decode(wp_remote_retrieve_body($response), true);
}

function getResult($args) {
    $output = [];
    $query = new WP_Query($args);
    while ($query->have_posts()): $query->the_post();
        $id = get_the_ID();
        $post = [
            'id' => $id,
            'title' => get_the_title(),
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

function getPremium($type, $Tradetype, $postId) {   //tournament distribution logic
    global $wpdb;
    $args = ['post_type' => $type, 'p' => $postId];
    $getTeams = getResult($args);
    foreach ($getTeams[0]['participating_team'] as $team) {
        if ($team['eliminated'] == 'No') {
            $countElimntd[] = $team['eliminated'];
            $teams = (array) $team['team'];
            $resultBets = $wpdb->get_results("SELECT sum(pts) as pts FROM wp_bets WHERE $Tradetype='" . $postId . "' AND team_id= '" . $teams['ID'] . "' AND mid=0  ");
            $totalWinBets = (array) $resultBets[0];
            $resultDis = $wpdb->get_results("SELECT sum(pts) as pts,uid,team_id FROM wp_bets WHERE $Tradetype='" . $postId . "' AND team_id= '" . $teams['ID'] . "' AND mid=0 GROUP BY uid ");
            $teamTieId[] = $team['team']->ID;
            $teamCancel[] = $team['team']->ID;
        } else {
            $teamTieId[] = $team['team']->ID;
            $teamId[] = $team['team']->ID;
            $teamCancel[] = $team['team']->ID;
        }
    }
    if (count($countElimntd) == 1 && $getTeams[0]['points_distributed'] !== 'Yes') { //if winner declare
        $getTotalBets = $wpdb->get_results("SELECT sum(pts) as pts FROM wp_bets WHERE $Tradetype='" . $postId . "' AND mid=0  ");
        $totBets = (array) $getTotalBets[0];
        $betsCalc = $totBets['pts'] / $totalWinBets['pts']; //total no of bet divide by total no winner
        foreach ($resultDis as $distribution) {
            $disFilter = (array) $distribution;
            $disCalc = ((int) $disFilter['pts'] * $betsCalc);
            $floorTotal = floor($disCalc);
            $data = ['uid' => $disFilter['uid'], 'tid' => $postId, 'team_id' => $disFilter['team_id'], 'gain_points' => $floorTotal, 'total_trade' => $disFilter['pts']];
            $wpdb->insert('wp_distribution', $data);
            $getCurrentPoints = get_user_meta($disFilter['uid'], 'points'); //** update users points
            foreach ($teamId as $getTeamId): //for loss distirbution
                $uid = $disFilter['uid'];
                $resultBetsLoss = $wpdb->get_row("SELECT sum(pts) as pts,uid,tid,mid,team_id FROM wp_bets WHERE $Tradetype='" . $postId . "' AND uid=$uid AND team_id=$getTeamId AND mid=0  group by uid");
                $dataLoss = ['uid' => $resultBetsLoss->uid, 'tid' => $resultBetsLoss->tid, 'team_id' => $resultBetsLoss->team_id, 'total_trade' => $resultBetsLoss->pts, 'gain_points' => $resultBetsLoss->pts, 'status' => 1];
                $wpdb->insert('wp_distribution', $dataLoss);
            endforeach;
            $resultTieLoss = $wpdb->get_row("SELECT sum(pts) as pts,uid,tid,mid,team_id FROM wp_bets WHERE $Tradetype='" . $postId . "' AND uid=$uid AND team_id=0 AND mid=0  group by uid");
            $dataTieLoss = ['uid' => $resultTieLoss->uid, 'tid' => $resultTieLoss->tid, 'team_id' => $resultTieLoss->team_id, 'total_trade' => $resultTieLoss->pts, 'gain_points' => $resultTieLoss->pts, 'status' => 1];
            $wpdb->insert('wp_distribution', $dataTieLoss); //for loss distirbution
        }
        update_post_meta($postId, 'points_distributed', 'Yes');
    } else if (count($countElimntd) >= 2 && $getTeams[0]['tournament_abandoned'] == 'Yes' && $getTeams[0]['points_distributed'] != 'Yes') :    //if match abandoned
        tournamentCancel($teamCancel, $wpdb, $Tradetype, $postId);
        update_post_meta($postId, 'points_distributed', 'Yes');
    endif;             //if match abandoned
    if ($getTeams[0]['tournament_draw'] == 'Yes' && $getTeams[0]['points_distributed'] != 'Yes'):    //tournament tie
        $resultDisTie = $wpdb->get_results("SELECT sum(pts) as pts,uid,team_id FROM wp_bets WHERE $Tradetype='" . $postId . "' AND team_id=0 AND mid=0 GROUP BY uid ");
        $getTotalTradeTie = $wpdb->get_row("SELECT sum(pts) as pts FROM wp_bets WHERE $Tradetype='" . $postId . "' AND team_id= 0 AND mid=0 group by team_id");
        $getTotalBets = $wpdb->get_row("SELECT sum(pts) as pts FROM wp_bets WHERE   $Tradetype='" . $postId . "' AND mid=0   ");
        foreach ($resultDisTie as $distributionTie) {
            $disFilter = (array) $distributionTie;
            $disCalc = floor((int) $disFilter['pts'] * ($getTotalBets->pts / $getTotalTradeTie->pts));
            $data = ['uid' => $disFilter['uid'], 'tid' => $postId, 'team_id' => $disFilter['team_id'], 'gain_points' => $disCalc, 'total_trade' => $disFilter['pts']];
            $wpdb->insert('wp_distribution', $data);
            foreach ($teamTieId as $getTeamId): //for loss distirbution
                $uid = $disFilter['uid'];
                $resultBetsLoss = $wpdb->get_row("SELECT sum(pts) as pts,uid,tid,mid,team_id FROM wp_bets WHERE $Tradetype='" . $postId . "' AND uid=$uid AND team_id=$getTeamId AND mid=0  group by uid");
                $dataLoss = ['uid' => $resultBetsLoss->uid, 'tid' => $resultBetsLoss->tid, 'team_id' => $resultBetsLoss->team_id, 'total_trade' => $resultBetsLoss->pts, 'gain_points' => $resultBetsLoss->pts, 'status' => 1];
                $wpdb->insert('wp_distribution', $dataLoss);
            endforeach;
        }
        update_post_meta($postId, 'points_distributed', 'Yes');
    endif;
}

function tournamentCancel($teamCancel, $wpdb, $Tradetype, $postId) {
    foreach ($teamCancel as $getTeamId): //for loss distirbution
        $resultBetsLoss = $wpdb->get_results("SELECT sum(pts) as pts,uid,tid,mid,team_id FROM wp_bets WHERE $Tradetype='" . $postId . "'  AND team_id=$getTeamId AND mid=0  group by uid");
        foreach ($resultBetsLoss as $userBetsLoss):
            $dataLoss = ['uid' => $userBetsLoss->uid, 'tid' => $userBetsLoss->tid, 'team_id' => $userBetsLoss->team_id, 'total_trade' => $userBetsLoss->pts, 'gain_points' => $userBetsLoss->pts, 'status' => 2];
            $wpdb->insert('wp_distribution', $dataLoss);
        endforeach;
    endforeach;
    $resultTieLoss = $wpdb->get_results("SELECT sum(pts) as pts,uid,tid,mid,team_id FROM wp_bets WHERE tid='" . $postId . "'  AND team_id=0 AND mid=0  group by uid");
    foreach ($resultTieLoss as $getTeamTieId): //for loss distirbution
        $dataTieCancel = ['uid' => $getTeamTieId->uid, 'tid' => $getTeamTieId->tid, 'team_id' => $getTeamTieId->team_id, 'total_trade' => $getTeamTieId->pts, 'gain_points' => $getTeamTieId->pts, 'status' => 2];
        $wpdb->insert('wp_distribution', $dataTieCancel);
    endforeach;
}

function getTotalTrade($tradeInfo, $Tradetype) {
    global $wpdb;
    $result = $wpdb->get_results("SELECT sum(pts) as total FROM wp_bets WHERE $Tradetype='" . $tradeInfo["tid"] . "' ");
    return $result;
}

add_filter('admin_init', 'my_general_settings_register_fields');

function my_general_settings_register_fields() {
    register_setting('general', 'token_amt', 'esc_attr');
    add_settings_field('token_amt', '<label for="token_amt">' . __('Post Registration Points', 'token_amt') . '</label>', 'my_general_settings_fields_html', 'general');
    register_setting('general', 'distributing_days', 'esc_attr');
    add_settings_field('distributing_days', '<label for="distributing_days">' . __('Distribution Days', 'distributing_days') . '</label>', 'distributing_days_field', 'general');
    register_setting('general', 'minimum_bet_amount', 'esc_attr');
    add_settings_field('minimum_bet_amount', '<label for="minimum_bet_amount">' . __('Minimum Bet Amount', 'minimum_bet_amount') . '</lable>', 'minimum_bet_amount_field', 'general');
}

function my_general_settings_fields_html() {
    $value = get_option('token_amt', '');
    echo '<input type="text" id="token_amt" name="token_amt" value="' . $value . '" />';
}

function distributing_days_field() {
    $value = get_option('distributing_days', '');
    echo '<input type="text" id="distributing_days" name="distributing_days" value="' . $value . '" > ';
}

function minimum_bet_amount_field() {
    $value = get_option('minimum_bet_amount', '');
    echo '<input type="text" id="minimum_bet_amount" name="minimum_bet_amount" value="' . $value . '" ';
}

function formatNumberAbbreviation($number) {
    $abbrevs = array(12 => "T", 9 => "B", 6 => "M", 3 => "K", 0 => "");

    foreach ($abbrevs as $exponent => $abbrev) {
        if ($number >= pow(10, $exponent)) {
            return round(number_format($number / pow(10, $exponent), 2)) . $abbrev;
        }
    }
}

function adminDistribution($userid) {
    global $wpdb;
    $getDistributionDays = get_option('distributing_days');
    $getResults = $wpdb->get_results("SELECT * FROM wp_distribution where uid =$userid AND status=0");
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

function remove_menus() {
    if (get_current_user_id() != 1) {
        remove_menu_page('edit.php');
        remove_menu_page('upload.php');                 //Media
        remove_menu_page('edit.php?post_type=page');    //Pages
        remove_menu_page('edit-comments.php');          //Comments
        remove_menu_page('themes.php');                 //Appearance
        remove_menu_page('plugins.php');                //Plugins
        remove_menu_page('edit.php?post_type=acf-field-group');
        remove_menu_page('tools.php');
    }
}

add_action('admin_menu', 'remove_menus');

function teams() {
    $args = array(
        'labels' => array('name' => 'Teams', 'singular-name' => 'Teams'),
        'public' => true,
        'supports' => array('title', 'thumbnail', 'page-attributes'),
        'menu_icon' => 'dashicons-groups'
    );
    register_post_type('teams', $args);
}

add_action('init', 'teams');

function tournaments() {
    $args = array(
        'labels' => array('name' => 'Tournaments', 'singular_name' => 'Tournament'),
        'public' => true,
        'supports' => array('title', 'thumbnail', 'page-attributes'),
        'taxonomies' => array('category'),
        'menu_icon' => 'dashicons-admin-site'
    );
    register_post_type('tournaments', $args);
}

add_action('init', 'tournaments');

function matches() {
    $args = array(
        'labels' => array('name' => 'Matches', 'singular_name' => 'Match'),
        'public' => true,
        'supports' => array('title', 'thumbnail', 'page-attributes'),
        'taxonomies' => array('category'),
        'menu_icon' => 'dashicons-carrot'
    );
    register_post_type('matches', $args);
}

add_action('init', 'matches');

function slider() {
    $args = array(
        'labels' => array('name' => 'Sliders', 'singular_name' => 'Slider'),
        'public' => true,
        'supports' => array('title', 'page-attributes', 'thumbnail'),
        'menu_icon' => 'dashicons-images-alt2'
    );
    register_post_type('slider', $args);
}

add_action('init', 'slider');

function scheme() {
    $args = ['labels' => ['name' => 'Scheme', 'singular_name' => 'Scheme'],
        'public' => true,
        'supports' => ['title', 'page_attributes', 'thumbnail']
    ];
    register_post_type('scheme', $args);
}

;

add_action('init', 'scheme');


