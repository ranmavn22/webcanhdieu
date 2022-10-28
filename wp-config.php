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
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'webcanhdieu' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'e_#q3B;,FMFN^7[1jU,?N@p4^<0J|37aLd9-yO!m-&7l neJQmfJs4!LyhNH/vBV' );
define( 'SECURE_AUTH_KEY',  '8$@^Kp^Iwo8@aQAnn@L(^r]7u@_w7E{Waej$G9is&ls*pn<Spy&O0dfsMbp8QP^#' );
define( 'LOGGED_IN_KEY',    'Ej/KY[cM6i-.s)%]&CwJ/zEcxvo%S-i$#(5214xD>*|01#e:34x=,`@&A7e]JfbW' );
define( 'NONCE_KEY',        'F~kEvP:63VJuPIaJs_Yt]Se023{Cp59.qk*cedeHn OO-~f:% 5h%6LyapQi17wC' );
define( 'AUTH_SALT',        'M Vz1]roG)C% U)kDa3Rn3mPT3!uYlo/h=sZp%[@jbD4R<g,Y&59AV t1|B#Xe&f' );
define( 'SECURE_AUTH_SALT', '=?84rD+pWXD@itxd0AL`Qa?eD *MkwpwY ZE7|sn.--pIIe;}]2%QeL8(5GW<NEi' );
define( 'LOGGED_IN_SALT',   '%rX-1.J|3)Zv=tfVZ7,`)FD#.Xb_AG^/mkYPANi-~I@$a1/`Q8s/OEf:]P)gmva=' );
define( 'NONCE_SALT',       '8XUnXC4!)Xd%]s/w[SrS;J30CA5Ji%R|,]NIbgj$cdr*bKy:O[Md@p!z9iV(#}}v' );

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



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
