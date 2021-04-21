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
define( 'DB_NAME', 'apricustravel' );

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
define( 'AUTH_KEY',         'JL_M(.sSt-0obr9pgqi;TFUSRQK6#yC3qE)`XG&ywed}3#`hO5dWFL3Z~V.=?^V!' );
define( 'SECURE_AUTH_KEY',  '`o,^t;K#.,F!o3qZ.2]UtM2pd.J$pN]MzY@8SX0TEx^@ij|a7hR.Ws @[/k=ECzM' );
define( 'LOGGED_IN_KEY',    '~Sn7`L8P uvxkb},omXw5[&H.GYlC}-KXd5h8+dr_uz<S;r5y(+W{[*MGA>iy8!_' );
define( 'NONCE_KEY',        '6TH}g(DP?U0Mb( cAh*lB<]cqPwXqHqJ~kn)8/6zTcLxR?7d[|IOKcW1b-k@Zx*?' );
define( 'AUTH_SALT',        '_-`_)c`Wza/$:<Mz8o:Km`-Aj?*$X(bvk>l@H+|.<5YR(3k)JFdwYw?=_7-=E2o9' );
define( 'SECURE_AUTH_SALT', '?;E,F+=^0lR3O8^?o7Y$x/ X1|E HqH,uq&83DY}NZSI^k#aNZW9NQOw]f{4]&nb' );
define( 'LOGGED_IN_SALT',   'cK^RA7(9-TgyvM-v>iyh,w(X$U]!wQ)zz+]+ncfj@-Y|jk[LGFF@o;w>^Zdhri!9' );
define( 'NONCE_SALT',       '8H8+yWj4cHR04EOc$fk[iWw7DFuc8PdQ_?K@Vg5+[]h.Mm~:1NU){@7W@:VU3.rT' );

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
