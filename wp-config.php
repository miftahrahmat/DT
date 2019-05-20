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
define( 'DB_NAME', 'md' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'H[@C0htH-O|{bl`Ic}aWZR>9j `k$XV*.OQ,rdms%< =!bHX3*jg*RF,7X0Atlxq' );
define( 'SECURE_AUTH_KEY',  'G3=Q(S~(}8Uaw{B5FTJ. [?n=Y}fn1CD8n)0j`MS.EBj$^ls0Z2D(h:Z7OJ+%f)z' );
define( 'LOGGED_IN_KEY',    '$W]OvSi=AA(n+D.FZ@@S#a6/dj!I-mH;2bwl3Eyf%G4.:4#+8I-;I^ctSmW~GysG' );
define( 'NONCE_KEY',        ',6!z{*VeTLBYECY)bBYy?co/*GMSb7oNIY]K8WP 8H2*[qo?L[,Z^O_VWn_2qL;t' );
define( 'AUTH_SALT',        '(um*,zhi31`;=L+g/[[/!]?P^W/efD6M[10F3fpGaN<w}u:dpR4YPe)?aNF}MA+Q' );
define( 'SECURE_AUTH_SALT', '<$51[}D?6L*~Y{bA2_auzHnj+Z>VY,(i:ivzjvI/-iH~EqEH9CQhfEJZ,?HifUpo' );
define( 'LOGGED_IN_SALT',   'o(4D3jjZ?n.90).ytN)k1}<dpDY1#skWrcxLW#c|NXhOHYQMjMmU FGRETJv,+^S' );
define( 'NONCE_SALT',       'Kk]/E}sI`kzRxal#K=.Z4*c|`D_NBUwD==|vJ Nlp1eM<l#83+jkK}/AcFB{O4^B' );

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
