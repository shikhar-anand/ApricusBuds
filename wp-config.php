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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'apricustravel3' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'KS^kdaR,*)h>ZpYhNF$U#*%;h)XtY4jlxIO2+K)P+aJqTBNNl26Q};pXPOjmz(N@' );
define( 'SECURE_AUTH_KEY',  '.!cuaaJ?49q>|B+j!d,XZ-$Ot9OZpnt|Rf{?1VB~OlZr<v?[^GAwMCV$<i +vh4L' );
define( 'LOGGED_IN_KEY',    'tSQf+wPBp8FhafK$ 8[ar{YR$c6s5e<;9fY)!m]b$@x!wEq6Y%4qz-MtZ`C]0 6<' );
define( 'NONCE_KEY',        'zh)Wbmh69:rKb&g(6<3#q`w56.Zz!0uGo3U{tQ|xD~%WUL}R*-ma[myS^.,U`V!y' );
define( 'AUTH_SALT',        '%qsMWfQ&;T_~;p`j0C/AHC+1oq|laM}|ylk;[k.}**4YHyTeX1k[Z@Y][2.[bU{S' );
define( 'SECURE_AUTH_SALT', '.EMM]8R_#Jf6c;M?j:5^84(Z%I @Sg/tw@a.CaTZ=2+L$N/-v3J & hX:Q8tfgMD' );
define( 'LOGGED_IN_SALT',   'dMd@9Axd(0wYh;2:|9l>w*)!s($a+Wg,Ra=HUS}m&{s6BoQK@DYv}aAH!6Sb4t{%' );
define( 'NONCE_SALT',       'q>P6T=ewdrRIU@* ])HP#gpHfNxy4)aJpOd3mIxFYGhT;l-2xt%V5km~LD:*TZOM' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
