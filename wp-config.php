<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'gamings');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'IIB2Jp)3*X<$@GR:5z|b7jmU>:>oQWW_yn)$(wP}`+`)-4Xo&^gXxk.G(x-j3`|Z');
define('SECURE_AUTH_KEY',  'XoVZ^-BI1dhv5Ma5`)^I0&Ajo6setJf)*tF@MtF=jF>TMuz<8!OqE_`,6<Y1--_4');
define('LOGGED_IN_KEY',    'z{x7Fy2esNSxg(mn6EiHp~jD@4X~4p^QnAxwVq(5OVem?}}F,V.VabQhd~}&|<{Q');
define('NONCE_KEY',        ')8&KM 3v |mn9=[ ;gX@90tZ5jJ?C@,t9;t-Ub(G<*rKZb&}^ov3V=F@;W|Lt+v|');
define('AUTH_SALT',        '.iGWT/=Pq.@|2k]Sm8wk-SV-i%YR <&(HLv]d&CNW+gRF59l1*I2 h=P)XhG-nH%');
define('SECURE_AUTH_SALT', 'iS:{d=|ls0wAYDW-q27h8^K3_$,EhSxIh*P_H;G|D55oxQkAfxt&~LxD_u^ Hzr0');
define('LOGGED_IN_SALT',   'T=JV;cS5@DT<sV1Hli!z+EP$zpga:cd-VlPuHvl^U3+C2D2s$fj37cpKqg@]Sa1=');
define('NONCE_SALT',       'HK*bj(C:yU/-zpt33H7seHBt5vTc+FGc3nGW-%xA+lV_T3IYe<Mkw$%5Isao)f#a');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
