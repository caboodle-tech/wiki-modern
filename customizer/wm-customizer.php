<?php
/**
 * Add Wiki Modern's Theme options to the WordPress Customizer. When
 * changes are saved run functions to update the theme as necessary.
 *
 * @package Wiki Modern Theme
 */

// Include files that should always be present in the website.
require 'include/wm-logo.php';

/**
* Make sure the WP_Customize_Control exsists or ignore
* loading or doing anything Customizer specific.
*/
if ( class_exists( 'WP_Customize_Control' ) ) {

    // Load sanitization functions needed by classes.
    require 'include/wm-sanitization.php';

    // Load custom classes for Wiki Modern.
    //require 'classes/class-wm-customizer-accordion.php';
    //require 'classes/class-wm-customizer-notice.php';
    //require 'classes/class-wm-customizer-text-radio-control.php';
    //require 'classes/class-wm-customizer-toggle-control.php';

    // Customizer (panel) JavaScript and CSS files.
    function wm_customizer_panel_enqueue_assets() {
        $ctime = filemtime( get_template_directory() . '/customizer/css/wm-customizer-panel.css' );
        wp_enqueue_style( 'wm-customizer-panel-css', get_template_directory_uri() . '/customizer/css/wm-customizer-panel.css', array( 'customize-controls' ), $ctime );
        $ctime = filemtime( get_template_directory() . '/customizer/js/wm-customizer-panel.js' );
        wp_enqueue_script( 'wm-customizer-panel-js', get_template_directory_uri() . '/customizer/js/wm-customizer-panel.js', array( 'jquery', 'customize-controls' ), $ctime, true );
    }
    add_action( 'customize_controls_enqueue_scripts', 'wm_customizer_panel_enqueue_assets' );

    // Customizer preview page JavaScript and CSS files.
    function wm_customizer_preview_enqueue_assets() {
        $ctime = filemtime( get_template_directory() . '/customizer/css/wm-customizer-preview.css' );
        wp_enqueue_style( 'wm-customizer-preview-css', get_template_directory_uri() . '/customizer/css/wm-customizer-preview.css', array(), $ctime );
        $ctime = filemtime( get_template_directory() . '/customizer/js/wm-customizer-preview.js' );
        wp_enqueue_script( 'wm-customizer-preview-js', get_template_directory_uri() . '/customizer/js/wm-customizer-preview.js', array( 'jquery' ), $ctime, true );
    }
    add_action( 'customize_preview_init', 'wm_customizer_preview_enqueue_assets' );

    // Functions that control what is shown in the Customizer.
    function wm_customize_register( $wp_customize ) {

        // Allow users to toggle on and off some settings of Wiki Modern.
        require 'wm-theme-options.php';
    }
    add_action( 'customize_register', 'wm_customize_register' );

    /**
     * Functions that control what is done when the user saves (publishes) changes
     * made in the Customizer. This calls (includes) functions in the after
     * directory.
     * 
     * @depreciated
    function wm_save_customizer_options() {

        // Handle when Wiki Modern's theme colors change.
        require( 'after/wm-less.php' );
    }
    add_action( 'customize_save_after', 'wm_save_customizer_options' );
    */

}
