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
define( 'DB_NAME', 'u935674355_8qfNs' );

/** Database username */
define( 'DB_USER', 'u935674355_47kxI' );

/** Database password */
define( 'DB_PASSWORD', 'xVaiw1x2q2' );

/** Database hostname */
define( 'DB_HOST', 'mysql' );

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
define( 'AUTH_KEY',          'f?Szc%!o].&@O1=bJ5!!{9fY&z}z)F];9q.!kJ_]U,V[`Un6dDK//ev&`YlS<h3R' );
define( 'SECURE_AUTH_KEY',   '^&KaLKp%jd1E#IU{dc69m[a04B)$6tM:G/]m~y< l[teU*fm@~qW|UypakfWA[+z' );
define( 'LOGGED_IN_KEY',     'Kw5ckgX?;{x]}BCyEziZu=fSEH%d.H#_-86Q}HR78[d[~&wHuUu>5;_;H5H6YGVA' );
define( 'NONCE_KEY',         'J#_ZIQw#6koz8$%DkB0M]7Tn2r1++*B<5j+((/ qgDW-PmM;s~)l@GnfU+ v|J9G' );
define( 'AUTH_SALT',         '@7/t99@xm?Ot4`R[PrE>7dU>PpR-Z_[XM/X#(u<(-<|R0`$HK>;PoM^)r)e*@:V_' );
define( 'SECURE_AUTH_SALT',  ' ymlH[kJv_BZPxxxn:1^w>@KuQ)/<4L@&sBL> zK*W}h!(]_F4tzJ__y}F?nSa3(' );
define( 'LOGGED_IN_SALT',    ';v4;R29cLqhL1X$d)szQ*u}U/,Q$O/fdLt_OU+mMXzT9)SfUMV.W9sNi$8In~]H*' );
define( 'NONCE_SALT',        'n2{8*$vC]:AYQTvv7d72>]MbAzUR@-F8N]9lmGPokuL~OZUq(&7It)e8pd6Dm;j_' );
define( 'WP_CACHE_KEY_SALT', '4tk+t^6vZ$SVhgVf5zo74+6(%:9Sq.roJ7?0oQ6&iAhvCnA</+LN{QV1,K#1Xb&[' );


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



define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
