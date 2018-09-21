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
define('DB_NAME', 'wootest');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'YOUR_PASSWORD');

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
define('AUTH_KEY',         'GLA1vOMTu,$7~f4/~ag/zJ^YO?!QH6ACVpHiXq&3PRgy)m!6y)F`ox!+j!cleaD_');
define('SECURE_AUTH_KEY',  '`rBB$1*O-c?-k6]Ij8j=x;2*Jf*csyzh.DBv%sjk!snt2eNKEBQtUt@,Qb5sesUC');
define('LOGGED_IN_KEY',    'kW@Up#|dJD ~STT4SyK?>Rjs4?L#d+,y2uXm>+3LaE}u^,MS68{,+FjiMdYm NLU');
define('NONCE_KEY',        'c48|j%`6$)3&G};Y[=W<URUM#z.-MC/)J,&(c|8c!]jtvJ-[Zw<g?yxs={1QHur1');
define('AUTH_SALT',        'CL#lOP$M]rS%fstn$I=6E7B>8H,ER^:]7!+}KRdJg&FKgh7Mvzu ~Rr,3yqe1Cx ');
define('SECURE_AUTH_SALT', 'VvdHZh| 9Tm.DZ[fD6v$ZF#N/Pb;*=  24uM$Q;kADcXTkV~4aNhBwLoLE)+Z=id');
define('LOGGED_IN_SALT',   'SQ`C&i|I=+KSKGDP?$8P2RX^1$GR:s0~Xald2%3:^4.5_m/Z([PE];f>:iEcVO P');
define('NONCE_SALT',       'z_<,eO%c?D_-)~(D_eKe3u.k<y.!=AUpxy7is#zH._@LEwkS {>NSh;l$s_$r?TV');

/**#@-*/
define('FS_METHOD', 'direct');
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
