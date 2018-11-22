<?php
/**
* The starting point of Wiki Modern setup. Load, call, and hook everything
* needed by Wiki Modern.
*
* @package Wiki Modern Theme
*/

/** When in DEBUG mode load the Kint PHP parser to help debug PHP code. */
if( !WP_DEBUG ){
    require( 'include/kint.phar' );
} else {

    /**
    * If not in debug mode help the dev out who may have accidently left Kint calls
    * in the code by catching all calls and ignoring them. REMOVING THIS SOON.
    */
    class Kint {

        const static_blackhole = '';

        public function blackhole( $a ){
            return;
        }

        public function __call( $m, $a ) {
            return call_user_func_array( array( $this, $this->blackhole ), $a );
        }

        public static function __callStatic( $m, $a ) {
            return self::static_blackhole;
        }
    }
    $kint = new Kint();

}

/** Load custom classes and functions for the Wiki Modern theme. */
require( 'include/wm-get-user-ip.php' );
require( 'include/trim-html-tags.php' );
require('classes/wm_walker.php');
require( 'classes/wm_post_page.php' );
require( 'classes/simple_html_dom.php' );

$WM_posts = new WM_posts();

require('customizer/customizer.php');


/** Enqueue styles and scripts loaded with the built in wp_footer() function. */
function wm_enqueue_assets() {

    /**
    * Theme's primary (default) style.css file. This file is not used by Wiki
    * Modern but users may try to add styles to it.
    */
    $ctime = filemtime( get_template_directory() . '/style.css' );
    wp_enqueue_style( 'style-css', get_stylesheet_uri(), array(), $ctime);

    /** Wiki Modern's primary CSS files. */
    $ctime = filemtime( get_template_directory() . '/css/normalize.css' );
    wp_enqueue_style( 'wm-normalize-css' , get_template_directory_uri() . '/css/normalize.css', array(), $ctime);
    $ctime = filemtime( get_template_directory() . '/css/main.css' );
    wp_enqueue_style( 'wm-main-css' , get_template_directory_uri() . '/css/main.css', array(), $ctime);

    /** Wiki Modern's primary JavaScript files. */
    $ctime = filemtime( get_template_directory() . '/js/Wiki-Modern.js' );
    wp_enqueue_script( 'wm-main-js' , get_template_directory_uri() . '/js/Wiki-Modern.js' , array() , $ctime, true);
    $ctime = filemtime( get_template_directory() . '/js/fontawesome.min.js' );
    wp_enqueue_script( 'wm-font-awesome-js' , get_template_directory_uri() . '/js/fontawesome.min.js' , array() , $ctime, true);
}
add_action( 'wp_enqueue_scripts', 'wm_enqueue_assets' );

/**
* Register the fact that we want to allow a custom logo.
* Handled by: customizer/include/logo.php
*/
add_theme_support( 'custom-logo' );

/** Disable self pingbacks. */
function wm_disable_self_ping( &$links ) {
    foreach ( $links as $key => $link ){
        if ( 0 === strpos( $link, get_option( 'home' ) ) ){
            unset( $links[$key] );
        }
    }
}
add_action( 'pre_ping', 'wm_disable_self_ping' );

/** Add all AJAX form handlers. */
require( 'forms/wm-comment-pagination.php' );
?>
