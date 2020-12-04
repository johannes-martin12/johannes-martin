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

define( 'DB_NAME', "portfolio_db" );


/** MySQL database username */

define( 'DB_USER', "root" );


/** MySQL database password */

define( 'DB_PASSWORD', "root" );


/** MySQL hostname */

define( 'DB_HOST', "localhost" );


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

define( 'AUTH_KEY',         'E4=8k[/8vNLh -k3J:jXvDhGG,@NP -G)$N9A{/nHl7%)P^KiE^Bc%6:L>SIdE!E' );

define( 'SECURE_AUTH_KEY',  'siK)ObuxFM(@7XNDce<*m%W5{keYQ0hP5q|SE@+VUGW71y*F!d>;q1+iTLlI]D3>' );

define( 'LOGGED_IN_KEY',    'AK}[?:hEp+4WCmJpj_],%W^I}%4%HD&6l:Qc2$sIV6lXO{W;Ac n|&aKM#[JS 7]' );

define( 'NONCE_KEY',        'b&Yccc]=828n!G`Fleb]yIzve;ezN6#5pBK$<Q^za^,BQY>qg*D4w (&>$`q2:7l' );

define( 'AUTH_SALT',        '}#}5L>drw@|.Sv0iKOR0z7`QSJGUnnIJEQ(M)&)f$9=;eOMg/gRm@xwil#;ABQ}N' );

define( 'SECURE_AUTH_SALT', '.h2LM$<6-!8lO3UO,3_Y?>vfW?cq:4`/1&6>lz`*_|]tMx^BmB3terh5y@Rg<|CT' );

define( 'LOGGED_IN_SALT',   'rBCs8Zz|S$k^ %a56JZa6h3/sC^ #3-3ExQ(M`}E/aQ6FFPDx#E-^Ow?e/!73PQ/' );

define( 'NONCE_SALT',       '7q#e-Xx(lT~<&HZ ^6Yz45ytfd{V3?bCD]5F/!O3*M:K3T,=b*1h%A|I;||e16&%' );


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

define( 'WP_DEBUG', true );


/* That's all, stop editing! Happy publishing. */


/** Absolute path to the WordPress directory. */

if ( ! defined( 'ABSPATH' ) ) {

	define( 'ABSPATH', __DIR__ . '/' );

}


/** Sets up WordPress vars and included files. */

require_once ABSPATH . 'wp-settings.php';

