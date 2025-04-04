<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'dongtamcorp-dongqueson1' );

/** Database username */
define( 'DB_USER', 'dongtamcorp-dongqueson1' );

/** Database password */
define( 'DB_PASSWORD', 'L74KUN76OZi5PTbF5IXK' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1:3306' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'x<~slaFgGXzrJy}{|[CZ a`fd%G4UM:0MG-01NWG@c5M!#et +;PFre);H`/P/.h' );
define( 'SECURE_AUTH_KEY',   ']{>Ko7VtZXQn6]l6&]Foo{#8$~Ozs7s#U|H_j.$sws+6U9c!MD~T6lQ=`bH/LEMS' );
define( 'LOGGED_IN_KEY',     '#=T2+bsN7oFvp1o[MuNQnpLHEWt5ukE,1J gv/q89;qpy6/q_rmQ LlzkbPlZiWO' );
define( 'NONCE_KEY',         '_P|?D9.O=7(Dj2QdP6;n=Z%:E86L>O5ZRZjsd.xEk*sJk% f2A{:T;I3)vDfPQX>' );
define( 'AUTH_SALT',         'aynXi8avL?zeJC2J7Fq{.VN+qB4E,5ml*d2cQ,<-p86>* [kRH{t!Lu,Ner=}p~%' );
define( 'SECURE_AUTH_SALT',  'yEX8$N`bY`(Ge~Z%WIHOC<)K-gbRp_w6MB_(a4u9:K<~#c)^W_}`t|+1Wi3tK;Lh' );
define( 'LOGGED_IN_SALT',    'QRNg`p+i}ndtze=piZgP>KDF5AWT|G&EDYm74wP$8tA(69qD_scn-8w,io1`?iH?' );
define( 'NONCE_SALT',        'o$<G<n*bUr9ui2lX^M!~]SYF%W0y0IbFRJExE6-mx;zwri)iFnT_;F6mnIs?,i;n' );
define( 'WP_CACHE_KEY_SALT', '+u%%*IZ5NN0_=w,tZK{8Hx2Q;d-A$v.GJhA=pl1~as:Nq0e?#;Zsa?S>u}?sT::9' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );


/* Add any custom values between this line and the "stop editing" line. */

define('JWT_AUTH_SECRET_KEY', 'tuananh');
define('JWT_AUTH_CORS_ENABLE', true);

define( 'FS_METHOD', 'direct' );
define( 'WP_DEBUG_DISPLAY', false );
define( 'WP_DEBUG_LOG', false );
define( 'CONCATENATE_SCRIPTS', false );
define( 'AUTOSAVE_INTERVAL', 600 );
define( 'WP_POST_REVISIONS', 5 );
define( 'EMPTY_TRASH_DAYS', 21 );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
