<?php
/**
* Add Wiki Modern's Theme options to the Wordpress Customizer. When
* changes are saved run functions to update the theme as necessary.
*
* @package Wiki Modern Theme
*/

/** Include files that should always be present in the website. */
require('include/logo.php');

/**
* Make sure the WP_Customize_Control exsists or ignore
* loading or doing anything Customizer specific.
*/
if ( class_exists( 'WP_Customize_Control' ) ) {

    // Make sure the core files are present that we need!
    $file = get_template_directory() . '/etc/default.json';
    if( !file_exists( $file ) ){
        $colors = file_get_contents( get_template_directory() . '/less/colors.less' );
        $colors = str_replace( array( '@', ': ', ';', PHP_EOL ), array( '"', '": "', '",', '' ), $colors );
        $colors = '{' . substr( $colors, 0, -1 ) . '}';
        file_put_contents( $file, $colors );
    }

    $file = get_template_directory() . '/etc/colors.json';
    if( !file_exists( $file ) ){

        $colors = file_get_contents( get_template_directory() . '/less/colors.less' );
        $colors = str_replace( array( '@', ': ', ';', PHP_EOL ), array( '"', '": "', '",', '' ), $colors );
        $colors = '{' . substr( $colors, 0, -1 ) . '}';
        file_put_contents( $file, $colors );
        $colors = json_decode( $colors, true );

        // Check if there are previous colors saved in the database and use those instead
        $update = false;
        foreach( $colors as $key => &$color ){
            if( get_theme_mod( $key ) != $color ){
                $colors[ $key ] = get_theme_mod( $key );
                $update = true;
            }
        }

        if( $update ){
            file_put_contents( $file, json_encode( $colors ) );
        }
    }

    $file = get_template_directory() . '/etc/template.less';
    if( !file_exists( $file ) ){
        include( get_template_directory() . '/customizer/include/wm-less-template.php' );
    }

    /** Load sanitization functions needed by classes. */
    require('include/sanitization.php');

    /** Load custom classes for Wiki Modern. */
    require( 'classes/wm_customizer_accordion.php' );
    require( 'classes/wm_customizer_notice.php' );
    require( 'classes/wm_customizer_text_radio_control.php' );
    require( 'classes/wm_customizer_toggle_control.php' );

    /** Customizer (panel) JavaScript and CSS files. */
    function wm_customizer_panel_enqueue_assets(){
        $ctime = filemtime( get_template_directory() . '/customizer/css/customizer-panel.css' );
        wp_enqueue_style( 'wm-customizer-panel-css' , get_template_directory_uri() . '/customizer/css/customizer-panel.css', array( 'customize-controls' ), $ctime);
        $ctime = filemtime( get_template_directory() . '/customizer/js/customizer-panel.js' );
        wp_enqueue_script( 'wm-customizer-panel-js' , get_template_directory_uri() . '/customizer/js/customizer-panel.js' , array( 'jquery', 'customize-controls' ) , $ctime, true);
    }
    add_action( 'customize_controls_enqueue_scripts', 'wm_customizer_panel_enqueue_assets' );

    /** Customizer preview page JavaScript and CSS files. */
    function wm_customizer_preview_enqueue_assets(){
        $ctime = filemtime( get_template_directory() . '/customizer/css/customizer-preview.css' );
        wp_enqueue_style( 'wm-customizer-preview-css' , get_template_directory_uri() . '/customizer/css/customizer-preview.css', array(), $ctime);
        $ctime = filemtime( get_template_directory() . '/customizer/js/customizer-preview.js' );
        wp_enqueue_script( 'wm-customizer-preview-js' , get_template_directory_uri() . '/customizer/js/customizer-preview.js' , array( 'jquery' ) , $ctime, true);
    }
    add_action( 'customize_preview_init', 'wm_customizer_preview_enqueue_assets' );

    /** Functions that control what is shown in the Customizer. */
    function wm_customize_register( $wp_customize ) {

        /** Allow altering of Wiki Modern's theme colors. */
        require( 'theme-colors.php' );

        /** Allow users to toggle on and off some settings of Wiki Modern. */
        require( 'theme-options.php' );
    }
    add_action( 'customize_register', 'wm_customize_register' );

    /**
    * Functions that control what is done when the user saves (publishes) changes
    * made in the Customizer. This calls (includes) functions in the after
    * directory.
    */
    function wm_save_customizer_options(){

        /** Handle when Wiki Modern's theme colors change. */
        require( 'after/wm-less.php' );
    }
    add_action( 'customize_save_after', 'wm_save_customizer_options' );

}
