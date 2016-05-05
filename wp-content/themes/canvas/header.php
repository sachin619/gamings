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
$userInfo = wp_get_current_user();
$userName = $userInfo->user_login;
if (is_page('register') && is_user_logged_in()):
    wp_redirect(get_site_url());
endif;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js" ng-app="gaming" >
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="author" content="SemiColonWeb" />
        <!-- Stylesheets
        ============================================= -->
        <link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/css/bootstrap.css" type="text/css" />
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/style.css" type="text/css" />
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/css/swiper.css" type="text/css" />
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/css/dark.css" type="text/css" />
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/css/font-icons.css" type="text/css" />
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/css/animate.css" type="text/css" />
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/css/magnific-popup.css" type="text/css" />
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/css/responsive.css" type="text/css" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <!--[if lt IE 9]>
                <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
        <![endif]-->

        <!-- Document Title
        ============================================= -->
        <title> Gaming </title>
        <?php wp_head(); ?>
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

                        <!-- Primary Navigation
                        ============================================= -->
                        <nav id="primary-menu">

                            <ul>
                                <li class=" <?= strcmp('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],get_site_url().'/')==0?'current':'' ; ?>"><a href="<?= get_site_url() ?>"><div><i class=""></i>Home</div></a>

                                </li>
                                <li class="<?= strpos($_SERVER['REQUEST_URI'],'matches')>0?'current':'' ; ?>"><a href="<?= get_site_url() ?>/matches"><div><i class=""></i>Matches</div></a>

                                </li>
                                <li class="mega-menu <?= strpos($_SERVER['REQUEST_URI'],'tournaments')>0?'current':'' ; ?>"><a href="<?= get_site_url() ?>/tournaments"><div><i class=""></i>Tournaments</div></a>

                                </li>
                                <li class="mega-menu <?= strpos($_SERVER['REQUEST_URI'],'about')>0?'current':'' ; ?>"><a href="#"><div><i class=""></i>About</div></a>

                                </li>
                                <li class="mega-menu <?= strpos($_SERVER['REQUEST_URI'],'contact')>0?'current':'' ; ?>"><a href="#"><div><i class=""></i>Contact</div></a>								
                                </li>
                                <?php if (empty($userName)): ?>
                                    <li class="mega-menu <?= strpos($_SERVER['REQUEST_URI'],'register')>0?'current':'' ; ?>"><a href="<?= get_site_url() . '/register' ?>"><div><i class=""></i>Login/Register</div></a>								
                                    </li>
                                <?php else: ?>
                                    <li class="mega-menu <?= strpos($_SERVER['REQUEST_URI'],'account')>0?'current':'' ; ?>"><a href="<?= get_site_url() . '/my-account' ?>"><div><i class=""></i>My Account</div></a>
                                    </li>
                                    <li class="mega-menu "><a href="<?= get_site_url() . '/api?action=logout' ?>"> Logout</a></li>
                                <?php endif ?>
                                </li>
                            </ul>


                            <!-- Top Search
                            ============================================= -->
                            <?php
                            if (!empty($userName)):
                                $getUserPoints = get_user_meta($user_ID, 'points');
                                $getFilterPoints = formatNumberAbbreviation($getUserPoints[0]);
                                ?>
                                <div id="top-cart">
                                    <a href="#" id="top-cart-trigger"><i class="fa fa-money fa-lg" style="font-size:36px;"></i><span><?= $getFilterPoints ?></span></a>
                                </div><!-- #top-cart end -->
                            <?php endif; ?>
                            <?php if (empty($userName)): ?>
                                <div id="top-search">
                                    <a href="#" class=""><span class=""><i class="icon-facebook"></i></span><span class="ts-text"></span></a>
                                </div><!-- #top-search end -->
                            <?php endif; ?>
                        </nav><!-- #primary-menu end -->

                    </div>

                </div>

            </header><!-- #header end -->
