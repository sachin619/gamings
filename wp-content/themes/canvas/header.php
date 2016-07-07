<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
/******* speed increase code files located in php_speedy **/
require(get_template_directory().'/php_speedy/php_speedy.php');
$compressor->options['document_root'] = get_template_directory();
$compressor->options['javascript']['cachedir'] = get_template_directory()."/php_speedy/";
$compressor->options['css']['cachedir'] = get_template_directory()."/php_speedy/";
/******* speed increase code files located in php_speedy **/
$userInfo = wp_get_current_user();
$userName = $userInfo->user_login;
if ((is_page('register') && is_user_logged_in()) || (is_page('my-account') && !is_user_logged_in())):
    wp_redirect(get_site_url());
endif;

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js" ng-app="gaming" >
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="author" content="Infini System" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
       
        <link rel="shortcut icon" type="image/x-icon" href="<?= get_template_directory_uri() ?>/images/favicon.ico">
        <!-- Stylesheets
        ============================================= -->
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/css/bootstrap.css" type="text/css" />
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/style.css" type="text/css" />
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/css/swiper.css" type="text/css" />
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/css/dark.css" type="text/css" />
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/css/font-icons.css" type="text/css" />        
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/css/animate.css" type="text/css" />
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/css/magnific-popup.css" type="text/css" />
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/css/responsive.css" type="text/css" />
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/css/datepicker.css" type="text/css" />
        <!--[if lt IE 9]>
                <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
        <![endif]-->


        <?php wp_head(); ?>  
       <script src="<?= get_template_directory_uri() ?>/js/jquery.1.9.js"></script> 
    </head>

    <body class="stretched">

        <!-- Document Wrapper
        ============================================= -->
        <div id="wrapper" class="clearfix">

            <!-- Header
            ============================================= -->
            <header id="header" class="full-header">

                <div id="header-wrap">

                    <div class="container clearfix">

                        <div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

                        <!-- Logo
                        ============================================= -->
                        <div id="logo">
                            <a href="<?= get_site_url() ?>" class="standard-logo" data-dark-logo="<?= get_template_directory_uri() ?>/images/logos.png"><img src="<?= get_template_directory_uri() ?>/images/logos.png" alt="Canvas Logo"></a>
                            <a href="<?= get_site_url() ?>" class="retina-logo" data-dark-logo="<?= get_template_directory_uri() ?>/images/logos.png"><img src="<?= get_template_directory_uri() ?>/images/logos.png" alt="Canvas Logo"></a>
                        </div><!-- #logo end -->

                        <div class="ad-banner col-md-3 hidden-md hidden-sm hidden-xs">
                            <div class="ad-ban-hold">
                                <img src="<?= get_template_directory_uri() ?>/images/header-ad.gif" class="imgaddbanner" alt="Banner" style="height:60px !important; display:block;">
                            </div>
                        </div>

                        <!-- Primary Navigation
                        ============================================= -->
                        <nav id="primary-menu">

                            <ul> 
                                <li><a class="<?= strcmp('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], get_site_url() . '/') == 0 ? 'currentMain' : ''; ?>" href="<?= get_site_url() ?>"> Home </a></li>

                                <li><a class="<?= strpos($_SERVER['REQUEST_URI'], 'about') > 0 ? 'currentMain' : ''; ?>" href="<?= get_site_url() ?>/about-us"> About </a></li>
                                
                                <li><a class="<?= strpos($_SERVER['REQUEST_URI'], 'contact') > 0 ? 'currentMain' : ''; ?>" href="<?= get_site_url() ?>/contact-us"> Contact </a></li>
                            
                                <?php if (empty($userName)): ?>
                                    <li><a class="<?= strpos($_SERVER['REQUEST_URI'], 'register') > 0 ? 'currentMain' : ''; ?>" href="<?= get_site_url() . '/register' ?>"> Login/Register </a></li>
                                <?php else: ?>
                                    <li><a class="<?= strpos($_SERVER['REQUEST_URI'], 'account') > 0 ? 'currentMain' : ''; ?>" href="<?= get_site_url() . '/my-account' ?>"> My Account</a></li>
                                    <li><a href="<?= get_site_url() . '/api?action=logout' ?>"> Logout</a></li>
                                <?php endif ?>
                                </li>
                            </ul>


                            <!-- Top Search
                            ============================================= -->
                            <?php
                            if (!empty($userName)):
                                //adminDistribution($user_ID);
                                $getUserPoints = get_user_meta($user_ID, 'points');
                                $getFilterPoints = formatNumberAbbreviation($getUserPoints[0]);
                                ?>
                                <div id="top-cart">
									<center>
										<a href="<?= get_site_url() . '/my-account' ?>">
											<!--<i class="fa fa-money fa-lg" style="font-size:36px;"></i>-->
											<div class="bag"></div>
											<span class="updateUserKit"><?= isset($getFilterPoints) ? $getFilterPoints : 0; ?></span>
										</a>
									</center>
                                </div><!-- #top-cart end -->
                            <?php endif; ?>
                            <!--<?php if (empty($userName)): ?>
                                <div id="top-search">
                                    <a href="#" class=""><span class=""><i class="icon-facebook"></i></span><span class="ts-text"></span></a>
                                </div>
                            <?php endif; ?>-->
                        </nav><!-- #primary-menu end -->

                    </div>

            </header><!-- #header end -->

            <!-- Page Sub Menu
        ============================================= -->
            <div id="page-menu">

                            <div id="page-menu-wrap">

                                <div class="container clearfix">

                                    <nav>
                                        <ul>
                                            <?php
                                            $args = ['parent' => 1];
                                            $getCategoires = get_categories($args);
                                            foreach ($getCategoires as $catName):
                                                ?>
                                                <li class="current"><a href=""><div><?= $catName->name ?></div></a>
                                                    <ul>
                                                        <li><a href="<?= get_site_url() . '/tournaments/?category=' . $catName->name ?>"><div>Tournaments</div> </a> </li>
                                                        <li><a href="<?= get_site_url() . '/matches/?category=' . $catName->name ?>"><div>Matches </div> </a> </li>
                                                    </ul>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </nav>

                                    <div id="page-submenu-trigger">Sports <i class="fa fa-angle-down"></i> <!--<i class="icon-reorder"></i>--></div>

                                </div>

                            </div>

                        </div>

