<?php

/**
 * Lario Sport API enviroment.
 * DO NOT MODIFY !!!
 * @package Mimotic.com
 */
require_once __DIR__ . '/dotEnvReader.php';


/**
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL,
 * prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} .
 * Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

define( 'WPCACHEHOME', '/home/gs-shop/gas-servei.shop/public/wp-content/plugins/wp-super-cache/' );
define('WP_CACHE', true);

// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/**
 * The name of the database for WordPress
 */
define('DB_NAME', dotEnvReader('DB_NAME', 'gsshopdb'));

/**
 * Database username
 */
define('DB_USER', dotEnvReader('DB_USER', 'root'));
/**
 * Database password
 */
define('DB_PASSWORD', dotEnvReader('DB_PASSWORD', 'root'));
/**
 * Hostname
 */
define('DB_HOST', dotEnvReader('DB_HOST', 'www'));

/**
 * Codificación de caracteres para la base de datos.
 */
define('DB_CHARSET', 'utf8');

// lang default
define('WPLANG', 'es_ES');


/**
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/
 * servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar
 * todas las cookies existentes.
 * Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */

define('AUTH_KEY',         '[LD_)jZj[0Wh|0RTftZs]_#f|7 )mcHO-#eC -j>OMpbr<afR[5{S4qNdLo&W5&I');
define('SECURE_AUTH_KEY',  '4?~]_Rz3[)(-nL5gfv@)J[G*sss+CEI[|P(P^=OrC.Qlr4^N*a)4,Bp7nI(a Cx-');
define('LOGGED_IN_KEY',    '6dOuyU{RU+,nvK#sTs+lAh/KhF1]FA]h0TP?iawD%|}[pR*r#(QhMHbb/g$WK?Y*');
define('NONCE_KEY',        '4t:5|EA}o >z]F-B_Met1Jae1=9vHBsb~Ls3q,^#(^VqJ^D.U.`f4;P5`=|RubQ1');
define('AUTH_SALT',        'PE1vbA$PZxGTUR| ,LEk@8RA*5nD3JsQszD% T-mh@7<Rs.NZm+!lX-6jnub|5eA');
define('SECURE_AUTH_SALT', '}YK[pH55eC{HwOiY0A-C9ScNJdBgiTwEA*goR+?0b.;lXvd0+>8>8s]M8<{W?DB6');
define('LOGGED_IN_SALT',   '<aRhUTkd>S6B(c`in#m2K(#Dbtr+UM@H-BnyTb,Z95ng#sf-ZT{EX5#fPD4wI1S%');
define('NONCE_SALT',       'B_,4#gOb+Qi{Yg/2zOLDNqe.8M-TM6$5CYcdi=5.:;zI>qXW@vd9,.A1tXAB|tCD');
/*

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix = dotEnvReader('TABLE_PREFIX', 'gss_');

define('WP_HOME', dotEnvReader('SITE_URL', 'https://gas-servei.shop/'));
define('WP_SITEURL', dotEnvReader('SITE_URL', 'https://gas-servei.shop/'));

/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas
 * y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */

if (dotEnvReader('SITE_ENVIROMENT') === 'production') { // production server
    //ssl
    define('FORCE_SSL_ADMIN', true);
    define('FORCE_SSL_LOGIN', true);

    // debug
    define('WP_DEBUG', false);
    define('SCRIPT_DEBUG', false);
    @ini_set('display_errors', 0);
    define('WP_DEBUG_LOG', false);
    define('WP_DEBUG_DISPLAY', false);
    define('SAVEQUERIES', false);

} else if (dotEnvReader('SITE_ENVIROMENT') === 'stagin') {
    //ssl
    define('FORCE_SSL_ADMIN', true);
    define('FORCE_SSL_LOGIN', true);

    // debug
    define('WP_DEBUG', true);
    define('SCRIPT_DEBUG', true);
    define('WP_DEBUG_LOG', true);
    define('WP_DEBUG_DISPLAY', true);
    define('SAVEQUERIES', true);

} else { // local/stagin server
    // ssl
    define('FORCE_SSL_ADMIN', false);
    define('FORCE_SSL_LOGIN', false);

    // debug
    define('WP_DEBUG', true);
    define('SCRIPT_DEBUG', true);
    define('WP_DEBUG_LOG', true);
    define('WP_DEBUG_DISPLAY', true);
    define('SAVEQUERIES', true);
}


/*
|--------------------------------------------------------------------------
| Add-on: SendGrid
|--------------------------------------------------------------------------
|
| By default, WordPress uses PHP's mail function to send emails. We
| strongly recommend using SendGrid to ensure messages are delivered to
| both you and your users.
|
*/
//define('SENDGRID_USERNAME', '' );
//define('SENDGRID_PASSWORD', '');
//define('SENDGRID_SEND_METHOD', 'api');
//
//define('SENDGRID_FROM_NAME', '');
//define('SENDGRID_FROM_EMAIL', '');
//define('SENDGRID_REPLY_TO', '');
//define('SENDGRID_CATEGORIES', '');

/*
|--------------------------------------------------------------------------
| AWS media deslocalizada S3 -  4 RIA
|--------------------------------------------------------------------------
|
|
*/
// AWS CREDENTIALS
//define( 'AWS_ACCESS_KEY_ID', '');
//define( 'AWS_SECRET_ACCESS_KEY', '');

// perfomance
define('DISABLE_WP_CRON', true);
//define('EMPTY_TRASH_DAYS', 0);
define('WP_MEMORY_LIMIT', '256M');
//define('WP_POST_REVISIONS', false);


/*
|--------------------------------------------------------------------------
| SECURITY
|--------------------------------------------------------------------------
|
|
*/
define('DISALLOW_FILE_EDIT', true);
define( 'WP_AUTO_UPDATE_CORE', true );
//header('X-Frame-Options: SAMEORIGIN');
//header('X-Frame-Options: DENY');

/*
|--------------------------------------------------------------------------
| RECOMENDATIONS
|--------------------------------------------------------------------------
|
|
*/

/* ¡Eso es todo, deja de editar! Feliz blogging */

/**
 * WordPress absolute path to the Wordpress directory.
 */
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/');
}


/**
 * Sets up WordPress vars and included files.
 */
require_once ABSPATH . 'wp-settings.php';

