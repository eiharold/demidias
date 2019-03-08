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
define('DB_NAME', 'demidias_wp361');

/** MySQL database username */
define('DB_USER', 'demidias_wp361');

/** MySQL database password */
define('DB_PASSWORD', 'tp7SD1]1.k');

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
define('AUTH_KEY',         'e0pqutwquomjdpvui5dolcezfcg79ntesc3mf7hlg6amqhzrd665rv7mc4xbsahy');
define('SECURE_AUTH_KEY',  '9xpjdstlwbdwfvavpnwfvxnycbuw3nta2qgp7sy5bszzmf4mi6oolickbaatasxz');
define('LOGGED_IN_KEY',    'qoixpdu4z7rhgrtj5sjzms2kfrvxqq8s83bu1shywleynhuvokt83aec58dlk45u');
define('NONCE_KEY',        'qvaxqicf3t8uxq0feaupmspub5ergbh1uykddsax61zqq4eboelaf9lsjettvb8y');
define('AUTH_SALT',        'epotissqf5jz4iglyw8aalpl0fhnb4c89nsovnboim0sp5tnuyjkcfdh98nyyb6z');
define('SECURE_AUTH_SALT', 'aophzgo36wbvsukswvdqytqyukoggpyrn968ykflccyjmt8jl8yf0rr8gmabtqdk');
define('LOGGED_IN_SALT',   'm4aua2v2n8exnvykx9xac1dlfdzq4hzji7widfk8stzlvo8rgfxiwy8udxbs0wni');
define('NONCE_SALT',       '7eioujaphywm6np4r6lc35yizizcuitvmd1q0ma0b3zjjxtvmtunyvaf0qihurqw');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wphb_';

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
