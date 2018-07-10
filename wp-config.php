<?php
define('FS_METHOD','direct');
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
define('DB_NAME', 'kadunandi');

/** MySQL database username */
define('DB_USER', 'razorbee');

/** MySQL database password */
define('DB_PASSWORD', 'razorbee123');

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
define('AUTH_KEY',         'AA)Bl,pWk3:e]W40JMghzcJk>LD5/87&.8hrRDbb( xsZROvspRhlun*:3u*:MSg');
define('SECURE_AUTH_KEY',  'C}{WDKaQfiDPdmIIUu`Svewzt>hMPj#@,XV&ew(VPONqNLh|LmmTHG+hL`vC>M/!');
define('LOGGED_IN_KEY',    '#v]b;jI| |kMw{w[^2t@|A)_V4y;{p+SJu(UPs#REw)#y>AUa<WE$iAZ<GmFUIf}');
define('NONCE_KEY',        '4(}^FSScs3@O,uYVu|zhCwUv`X#HZt`wa6lV99gGrAL5$8?P2]mmr7,`Q9aNZG|#');
define('AUTH_SALT',        'PNc2_Vra~-exZLt9L>`388{W6{gIx8c68>_35o&)&.>)#E,wz}S?M26raij>ac8C');
define('SECURE_AUTH_SALT', 'R@}~H}vZqMlK3ooJQAf!LJxTp_2xL|HV@-<A.POM*TFydPeQWrt<@{<Qddv,hYyW');
define('LOGGED_IN_SALT',   '-k^9LlVraXwXs.m,1($QS&$=yd072o#=7?CNM pD96?i?I}: Vx1Ue6O/!zD0PZ6');
define('NONCE_SALT',       '8@v/S)I$;Iot[B@^sq,!YF &nB}$l0:#:LA#t6En;K,5~=dRh[f9NeW5%H(S`Rz<');

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
