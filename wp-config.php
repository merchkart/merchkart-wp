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
define( 'DB_NAME', 'merchkart_wpdb' );

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
define( 'AUTH_KEY',         'x!P.1F=8&JX<vuP<tA+Y-=&rrVUMdtJ%S`rv><#hVp}d;:b]F7~Tn~^i10jFHEgG' );
define( 'SECURE_AUTH_KEY',  'IoUkk5rd_w@0Tzvg;[AK9T7cmZkF-f$$uBez(Dg0k29pa2BKyu-cR,%-d`=E8?N`' );
define( 'LOGGED_IN_KEY',    '(qRshIr91] _%xtX6OlVHM4:i/)6-lz=o))R3.dA5%bJ9x}xzi6?Gol:fP/ti#_J' );
define( 'NONCE_KEY',        '3!xjl:ZNCM/.Ij>g;]Xm9td/?+alN-J;N}7A+nN?tB|]GfCJtriI+I}07KPaeJ U' );
define( 'AUTH_SALT',        'm&M3IrjHNonG;}q31M~ZwPp%)M1HOUq3H(Mb `?]m4MXCL=&rkwwpae!K9dE)yKW' );
define( 'SECURE_AUTH_SALT', '_dS5C_m7NKfrL;L*p%60lB5m5T|SnP%wP[2HoZ,ij4e68!wJkP<y<Zd`$c-=s%Ge' );
define( 'LOGGED_IN_SALT',   '(eW ^1rngsqP8t4{@6gv#g fy Y4<X[;[|S%[jJ^fy1mV)Z?31A-R|0Eqvc*DxJ|' );
define( 'NONCE_SALT',       '{(,BF0!EW|v`@FyC]4T]]N/u]rdKk:mKbkOH=-D}Df?*tpsX6Q6@biiG@.y#2X3h' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpmk_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
