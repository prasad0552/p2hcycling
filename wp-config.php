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
define('DB_NAME', 'p2hwordpress');

/** MySQL database username */
define('DB_USER', 'wordpress');

/** MySQL database password */
define('DB_PASSWORD', 'prasad@ktree');

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
define('AUTH_KEY',         '+Mp%!|at)H.h~QI*9FQXE<AaSUzJ3?%E0v3]A|Rc{q7|sETj6j 4E-ts3!~qroDK');
define('SECURE_AUTH_KEY',  '5SRy( XHx12+O?0+O5<b;c QLKqbwGC4GW7]#%_k#K`/$I>k.L#QM4%|M{aOTUet');
define('LOGGED_IN_KEY',    'W8R=+fwHi;z2jG >Y)a{R&TR8dwNg2;K/Zv?$G&z5?Z|M6ky?g$*t,`$X.iUKcl6');
define('NONCE_KEY',        ':}o)xQJ&CtA$X1u=S^sc>?ixQW} tl)jUf}#:*}bgA-Qn#a5O6N5E?MHa/M6~X1s');
define('AUTH_SALT',        ',Ti;JF-{T:y0}8| e>gR}e-%R$S-8l8:w[7?gR;7H A|&A7B expEW^?B-2V@xSA');
define('SECURE_AUTH_SALT', 'wB!e#|{aHNwOT857F% n4I+;@ !<O^$Ih`qNfnc}P 65 B9rV8Hj,tX:)KIMJ#o>');
define('LOGGED_IN_SALT',   'TLd.o&$+XMdxPaPC3,R1S>EEe$*CVi9aw8Q.+1}P/|7)FO@SuB27fNm*+P10KU6N');
define('NONCE_SALT',       'P*!y.HbP#?ER$f$N`4uVwtnYCXP4f!45A6es<4vG570QRa]{n`xm@W39-yk* UA3');

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

