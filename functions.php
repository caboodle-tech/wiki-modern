<?php
/**
* The starting point of Wiki Modern setup. Load, call, and hook everything
* needed by Wiki Modern.
*
* @package Wiki Modern Theme
*/

/** When in DEBUG mode load the Kint PHP parser to help debug PHP code. */
if( WP_DEBUG ){
    require( 'include/kint.phar' );
} else {
    require( 'include/kint-fake.php');
}

/** Load custom classes and functions for the Wiki Modern theme. */
require( 'include/trim-html-tags.php' );
require( 'include/wm-auto-copyright.php' );
require( 'include/wm-auto-menu.php' );
require( 'include/wm-get-image-widths.php' );
require( 'include/wm-get-user-ip.php' );
//require( 'classes/mobile_detect.php' );
require( 'classes/wm_cookies.php' );
require( 'classes/wm_page_html.php' );
require( 'classes/wm_pagination.php' );
require( 'classes/wm_walker.php' );

$WM_cookies = new WM_cookies();
//$WM_device = new Mobile_Detect();
$WM_page_html = new WM_page_html();


//$WM_cookies->delete( 'wm_user_device', '', '', false, true );

/* Record device types now.
if( $WM_cookies->get('wm_user_device') ){
    $WM_device_meta = json_decode( str_replace( '\\', '', $WM_cookies->get('wm_user_device') ) );
} else {
    // Determine device type.
    $desktop = false;
    $mobile = $WM_device->isMobile();
    $tablet = $WM_device->isTablet();
    if( !$mobile && !$tablet ){
        $desktop = true;
    }
    // Record device meta data.
    $WM_device_meta = array( 'desktop' => $desktop, 'tablet' => $tablet, 'mobile' => $mobile );
    // Set a cookie so we can load faster next time.
    // TODO: Change false (HTTPS) if site is in https mode
    $WM_cookies->create( 'wm_user_device', json_encode( $WM_device_meta ), '+30days', '', '', false, true );
}
*/

//Kint::dump( $WM_device_meta );

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
    wp_enqueue_style( 'wm-normalize-css', get_template_directory_uri() . '/css/normalize.css', array(), $ctime);
    $ctime = filemtime( get_template_directory() . '/css/main.css' );
    wp_enqueue_style( 'wm-main-css', get_template_directory_uri() . '/css/main.css', array(), $ctime);

    /** QR code generator JavaScript file. */
    $ctime = filemtime( get_template_directory() . '/js/QR.js' );
    wp_enqueue_script( 'wm-qr-js', get_template_directory_uri() . '/js/QR.js' , array() , $ctime, true);

    /** Wiki Modern's primary JavaScript file. */
    $ctime = filemtime( get_template_directory() . '/js/WikiModern.js' );
    wp_enqueue_script( 'wm-wikimodern-js', get_template_directory_uri() . '/js/WikiModern.js' , array() , $ctime, true);
}
add_action( 'wp_enqueue_scripts', 'wm_enqueue_assets' );

// TODO: Chnage this to default menu???
// MENU HELP: http://justintadlock.com/archives/2010/06/01/goodbye-headaches-hello-menus

/** Register the Primary Menu. */
function wm_register_primary_menu() {
	register_nav_menu( 'primary-menu', __( 'Primary Menu' ) );
}
add_action( 'init', 'wm_register_primary_menu' );

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

// Remove the read more link completely from the theme
function wm_remove_read_more_link() {
    return '';
}
add_filter( 'the_content_more_link', 'wm_remove_read_more_link' );

/** Add all AJAX form handlers. */
require( 'forms/wm-comment-pagination.php' );

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
    $sizes = '';
    foreach ( $widths as $width ) {
        $width = intval( $width );
        $sizes .= '(max-width: ' . ( $width + 100 ) . 'px) ' . ( $width - 100 ) . 'px, ';
    }

    //$sizes = substr( $sizes, 0, strlen( $sizes ) - 2 );

	return $sizes .'100vw';
}
add_filter( 'wp_calculate_image_sizes', 'twentysixteen_content_image_sizes_attr', 10 , 2 );

// Register WikiModern's Widget areas
function wm_widget_areas(){
    require('include/wm-widgets.php');
}
add_action('widgets_init', 'wm_widget_areas');

/* Prefix lock icon in post titles. */
function wm_protected_post_prefix( $title ) {
    return '<i class="fas fa-lock"></i> ' . $title ;
}
add_filter( 'protected_title_format', 'wm_protected_post_prefix' );


function my_theme_dependencies() {
    if( !class_exists( 'FortAwesome\FontAwesome' ) ){
        $search_link = get_site_url() . '/wp-admin/plugin-install.php?s=font+awesome&tab=search&type=term';
        echo '<div class="error" id="wm-fa-warning"><p>' . __( 'Warning: The Wiki Modern Theme needs the <a href="' . $search_link . '">Font Aweseom plugin</a> installed and activated to display properly. Your site will be missing icons until you <a href="' . $search_link . '">install this plugin</a>.', 'my-theme' ) . '</p></div>';
    }
}
add_action( 'admin_notices', 'my_theme_dependencies' );

function set_posts_per_page( $query ) {

    global $wp_the_query;

    $limit = $_COOKIE['wm_pagination_limit'];
    if( !empty( $limit ) ){
        $limit = intval( strip_tags( $limit ) );
        if( $limit < 0 || $limit > 50 ){
            $limit = 50;
        }
        $query->set( 'posts_per_page', $limit );
    }

    $sort_by = $_COOKIE['wm_pagination_sort'];
    if( !empty( $sort_by ) ){
        $sort_by = strip_tags( $sort_by );

        if( $sort_by == 'oldest'){
            $sort_by = 'ASC';
        } else {
            $sort_by = 'DESC';
        }

        $query->set( 'order', $sort_by );
    }
    $query->set( 'orderby', 'modified' );
}
add_action( 'pre_get_posts',  'set_posts_per_page'  );

function wpb_change_search_url() {
    if ( is_search() && ! empty( $_GET['s'] ) ){
        wp_redirect( home_url( "/search/" ) . urlencode( get_query_var( 's' ) ) );
        exit();
    }
}
add_action( 'template_redirect', 'wpb_change_search_url' );
?>
