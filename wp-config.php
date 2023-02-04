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
define( 'DB_NAME', 'qasino' );

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
define( 'AUTH_KEY',         '59e54,drrvL[k/om$Eq@)oHpzbN&`(L&)j?3x~kMYQfqIU.Y0kJm:[I[Q5RB:lsi' );
define( 'SECURE_AUTH_KEY',  'bV*mo.nDQFHce~~&htYrrW}7K21)it,0)]P$ksYQ#d:Vqr(PZjY;TBQcq_`.u9sh' );
define( 'LOGGED_IN_KEY',    'YVui>Sx$i:}Keq8R2dDI?Dx>Hx%N*K^nJ&0 b,xF>i  r>*{4uqm{K5X|~Bv?jj4' );
define( 'NONCE_KEY',        'j?JI5!2*T_3j_}&`:Yo?y6.*4ic`O8=RksMMx&_L;fn6&Bl-qW3;k7DMu r6fuME' );
define( 'AUTH_SALT',        '*e7A]@h}$jo~fo;sx!/zYJ9cNg*4j>?>Kq:{G(i+9Bw]+AxR8jx7Stw1*sN,Y5a+' );
define( 'SECURE_AUTH_SALT', '?d=G7I9G)baYv#O@-6B[4caK2UveW k!9}LjFh&Q4y:-:.aPDJ`@N$e{?!{?0&,*' );
define( 'LOGGED_IN_SALT',   'A6!<O%^7Ivh;|Tr%AZ<>Y{6Xy#3@#Td)W,<M:mBF#N)~l?<,wsg>_DM_Cf;W`3#w' );
define( 'NONCE_SALT',       'NLWx#aK<W7{ $1mJIr/PN&oRIos|_k1aEJghe8(ECDhI/{i@FUs_!,F(<|37_YBl' );

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
