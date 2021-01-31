<?php
/**
 * Load, call, and hook everything needed by Wiki Modern.
 *
 * @package Wiki Modern Theme
 */

/**
 * NOTE:
 * Not included yet:
 * > Prefix lock icon in post titles.
 * > Add all AJAX form handlers. ???
 * > Dynamically set the post per page based on the users cookie if present.
 */

// Check if dark mode is enabled for this user.
$dark_mode = false;
if ( isset( $_COOKIE['wm-dark-mode'] ) ) {
    $dark_mode = true;
}
define( 'DARK_MODE', $dark_mode );

require 'include/wm-get-image-widths.php';

// Enqueue styles and scripts loaded with the built in wp_footer() function.
function wm_enqueue_assets() {

    // TODO: Fix $ctime.
    $ctime = random_bytes( 12 );

    /**
    * Theme's primary (default) style.css file. This file is not used by Wiki
    * Modern but users may try to add styles to it.
    */
    wp_enqueue_style( 'style-css', get_stylesheet_uri(), array(), $ctime );

    // Wiki Modern's primary CSS files.
    wp_enqueue_style( 'wm-normalize-css', get_template_directory_uri() . '/css/normalize.css', array(), $ctime );
    if ( DARK_MODE ) {
        wp_enqueue_style( 'wm-main-dark-css', get_template_directory_uri() . '/css/main-dark.css', array(), $ctime );
    } else {
        wp_enqueue_style( 'wm-main-css', get_template_directory_uri() . '/css/main.css', array(), $ctime );
    }

    // QR code generator JavaScript file.
    // wp_enqueue_script( 'wm-qr-js', get_template_directory_uri() . '/js/QR.js', array(), $ctime, true );

    // Wiki Modern's primary JavaScript files.
    wp_enqueue_script( 'wm-polyfill-js', get_template_directory_uri() . '/js/polyfills.js', array(), $ctime, true );
    wp_enqueue_script( 'wm-cookie-js', get_template_directory_uri() . '/js/cookie.js', array(), $ctime, true );
    wp_enqueue_script( 'wm-wikimodern-js', get_template_directory_uri() . '/js/wiki-modern.js', array(), $ctime, true );
}
add_action( 'wp_enqueue_scripts', 'wm_enqueue_assets' );

// Wiki Modern uses the WordPress Customizer, load that now.
require 'customizer/wm-customizer.php';

/**
* Register the fact that we want to allow a custom logo.
* Handled by: customizer/include/logo.php
*/
add_theme_support( 'custom-logo' );

// Register the Primary Menu.
function wm_register_primary_menu() {
    register_nav_menu( 'primary-menu', __( 'Primary Menu' ) );
}
add_action( 'init', 'wm_register_primary_menu' );

// Disable self pingbacks.
function wm_disable_self_ping( &$links ) {
    foreach ( $links as $key => $link ) {
        if ( 0 === strpos( $link, get_option( 'home' ) ) ) {
            unset( $links[ $key ] );
        }
    }
}
add_action( 'pre_ping', 'wm_disable_self_ping' );

// Remove the read more link completely from the theme.
function wm_remove_read_more_link() {
    return '';
}
add_filter( 'the_content_more_link', 'wm_remove_read_more_link' );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 *
 * @since Twenty Sixteen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function twentysixteen_content_image_sizes_attr( $sizes, $size ) {
    $widths = wm_get_image_widths();
    $sizes  = '';
    foreach ( $widths as $width ) {
        $width  = intval( $width );
        $sizes .= '(max-width: ' . ( $width + 100 ) . 'px) ' . ( $width - 100 ) . 'px, ';
    }
    return $sizes . '100vw';
}
add_filter( 'wp_calculate_image_sizes', 'twentysixteen_content_image_sizes_attr', 10, 2 );

// Register WikiModern's Widget areas.
function wm_widget_areas() {
    require 'include/wm-widgets.php';
}
add_action( 'widgets_init', 'wm_widget_areas' );

// Pretty print any site searches.
function wpb_change_search_url() {
    if ( is_search() && ! empty( $_GET['s'] ) ) {
        wp_safe_redirect( home_url( '/search/' ) . rawurlencode( get_query_var( 's' ) ) );
        exit;
    }
}
add_action( 'template_redirect', 'wpb_change_search_url' );

// A simple cookie sanitization function to make WordPress happy.
function wm_sanitize_cookie( $data ) {
    $cleaned = htmlspecialchars( $data, ENT_NOQUOTES );
    if ( strlen( $cleaned ) != strlen( $data ) ) {
        return '';
    }
    return $data;
}
add_filter( 'sanitize_json_wm_cookie', 'wm_sanitize_cookie' );
