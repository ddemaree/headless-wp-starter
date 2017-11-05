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



if($_ENV['WORDPRESS_DEBUG']) {
  define('WP_DEBUG', true);
}


// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', ($_ENV['WORDPRESS_DB_NAME'] ?: "wordpress") );

/** MySQL database username */
define( 'DB_USER', ($_ENV['WORDPRESS_DB_USER'] ?: "root") );

/** MySQL database password */
define( 'DB_PASSWORD', ($_ENV['WORDPRESS_DB_PASSWORD'] ?: '') );

/** MySQL hostname */
define( 'DB_HOST', ($_ENV['WORDPRESS_DB_HOST'] ?: 'mysql') );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '+Y3|gRk5uLe<Y}qbHohWDt[}D}]J?L+Rg@Z?WT]?HW{]w(k1xQkW[Z<[jVFok*t6' );
define( 'SECURE_AUTH_KEY',  'QNY#>0),wK#=:|mny`5BCFc.t(o;P{C/7eE?Wt1v1z<~_:iI i^K|R@[A3JbkQN{' );
define( 'LOGGED_IN_KEY',    'NR?>1y^_y,%_DHR:4)`tk4V(6_0,H[P>`f9]zxhwN}_d*~5w {){`cn,l} wG6,k' );
define( 'NONCE_KEY',        'PkiL*$$B]F5rKvk!Nft}%byoI~El[rDT8Odzst3rUF.%!2_)?zN_:c*y>5%KdoP.' );
define( 'AUTH_SALT',        '>n(|RB9O-|rK_@$KqiEKcW(8F:Yg46]5)@ALKO8oI**$7)V3MxzBOYN(X#nyQW*Q' );
define( 'SECURE_AUTH_SALT', '6tJrpZG5%UR~9t|iDA9zU*B`i#Jtf^<N}&8?S!US;pF/MV%>GV e{9I@PxZS. g^' );
define( 'LOGGED_IN_SALT',   '{3^Jouu?#4m5@gMfcl5Trb`qMa.#$H^MpJ!US9@{!@,aWIJ]TIzoQ29P#!`RSmy@' );
define( 'NONCE_SALT',       ' gimA02dNL_LN#A]v]imS9XmmCLdkDJs nV_Qx+A3}V9}pR+k `C__et_4DX}.IK' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = ($_ENV['WORDPRESS_TABLE_PREFIX'] ?: 'wp_');


// Override the site/home URLs to make it easier to reuse production data dumps
if( $_ENV['WP_SITEURL'] ) define( 'WP_SITEURL', $_ENV['WP_SITEURL'] );
if( $_ENV['WP_HOME'] ) define( 'WP_HOME', $_ENV['WP_HOME'] );

// Enable multisite
if(isset($_ENV['WORDPRESS_NETWORK_DOMAIN'])) {
  define('WP_ALLOW_MULTISITE', true);
  define('MULTISITE', true);
  define('WP_DEFAULT_THEME', 'postlight-headless-wp');
  define('COOKIE_DOMAIN', $_SERVER['HTTP_HOST']);
  define('MULTISITE', true);
  define('DOMAIN_CURRENT_SITE', $_ENV['WORDPRESS_NETWORK_DOMAIN']);
  define('PATH_CURRENT_SITE', '/');

  // TODO: Make these configurable?
  define('SUBDOMAIN_INSTALL', true);
  define('SITE_ID_CURRENT_SITE', 1);
  define('BLOG_ID_CURRENT_SITE', 1);
}


// Disable automatic updates; they won't work inside the Docker container anyway so the prompts would just be annoying
define( 'DISALLOW_FILE_EDIT', true );
define( 'DISALLOW_FILE_MODS', true );
define( 'AUTOMATIC_UPDATER_DISABLED', true );
define( 'WP_AUTO_UPDATE_CORE', false );

if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
  $_SERVER['HTTPS'] = 'on';
}


/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
