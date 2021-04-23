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
define( 'DB_NAME', 'IE_db' );

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
define( 'AUTH_KEY',         ':G`|9cW<e$(])3P !gY{4~lL|,B@f`eTHN{.(St+7Nef8.g_I*^x]Q^Ce!B].jZ2' );
define( 'SECURE_AUTH_KEY',  '0m6CH<8n84p9gmjN) px,7W:(F74m72/7AlCq(!XNB2j5jG#kq1l52=^^i6)xR#l' );
define( 'LOGGED_IN_KEY',    '(g*bl#5#!8.ohH|zB<uK>.AQqm;dNE_mf$ q7H3f[+$^Y/ 9f>1Iug3f2az&EFB.' );
define( 'NONCE_KEY',        '%8c+)R/f31qu#Qs-|ghS:;DV9S|~}(h%]p{5_mtO rmn!oc[@Sd(H lf5(tYR&m?' );
define( 'AUTH_SALT',        'J1=R8|%2Q2xb;V-7@E&&wAF&1qZvxJVy$]QF-Quo<+m5.=*2TDOYnxzf;BM@`//Y' );
define( 'SECURE_AUTH_SALT', 'sl1Im-fV}f;RS/:~li?PM6D%5u#;w7a86.5EV?bvf{`wAr3%MI( Dq]8+-|ZcS7F' );
define( 'LOGGED_IN_SALT',   '1!CJ2f2B].^ZMy0Kjg#{,]<%(:Um/zg+l`UXD/C~]p2lt[{4NYnirTk)]ym2,/AH' );
define( 'NONCE_SALT',       'wAvHYvP*o*^ijG!o3pg%)Dt{OY:GxG`<+Y,VGuHCsfJ)44uU/k6Jge!cMUanl(VD' );

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
