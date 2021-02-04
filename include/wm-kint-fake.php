<?php
/**
 * This handles defining things the real Kint class expects to exist.
 * To help the dev out who may have accidentally left Kint calls
 * in the code we catch all the calls and ignore them. See the
 * fake Kint class in classes/Kint/KintFake.php
 * 
 * NOTE: The autoloader will catch and load the correct class.
 * 
 * @package Wiki Modern Theme
 */

if ( WP_DEBUG ) {

    \define('KINT_DIR', get_template_directory() . '/classes/Kint' );
    \define('KINT_WIN', DIRECTORY_SEPARATOR !== '/');
    \define('KINT_PHP70', (\version_compare(PHP_VERSION, '7.0') >= 0));
    \define('KINT_PHP71', (\version_compare(PHP_VERSION, '7.1') >= 0));
    \define('KINT_PHP72', (\version_compare(PHP_VERSION, '7.2') >= 0));
    \define('KINT_PHP73', (\version_compare(PHP_VERSION, '7.3') >= 0));
    \define('KINT_PHP74', (\version_compare(PHP_VERSION, '7.4') >= 0));
    \define('KINT_PHP80', (\version_compare(PHP_VERSION, '8.0') >= 0));

}
