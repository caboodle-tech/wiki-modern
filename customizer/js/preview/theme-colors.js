/**
* Handles live updates to the website triggered by the user altering
* theme colors from the Theme Color panel of the Customizer.
*
* @see ../theme-colors.php
* @since 1.0.0
*/

wp.customize( 'wm_saf_a', function( value ) {
    // Good
    value.bind( function( hex ) {
        $('#wm-page-wrapper #wm-left-sidebar .wm-control-btn').css("color", hex );
        $('#wm-page-wrapper #wm-content-outter-wrapper #wm-left-sidebar a').css("color", hex );
        $('#wm-page-wrapper #wm-right-sidebar .wm-control-btn').css("color", hex );
        $('#wm-page-wrapper #wm-content-outter-wrapper #wm-right-sidebar a').css("color", hex );
        $('#wm-page-wrapper #wm-left-sidebar a').css("color", hex );
        $('#wm-page-wrapper #wm-right-sidebar a').css("color", hex );
        $('#wm-footer-wrapper #wm-footer a').css("color", hex );
        $('#wm-page-wrapper #wm-right-sidebar .wm-widget .wm-widget-info .wm-tags').css("color", hex );
    } );
} );

wp.customize( 'wm_saf_a_active', function( value ) {
    // Good
    value.bind( function( hex ) {
        $('#wm-page-wrapper #wm-content-outter-wrapper #wm-left-sidebar #wm-nav-container .wm-nav .wm-active > .wm-nav-item').css("background-color", hex );
    } );
} );

wp.customize( 'wm_saf_a_hover', function( value ) {
    // GOOD
    value.bind( function( hex ) {
        var style = "#wm-page-wrapper #wm-content-outter-wrapper #wm-left-sidebar #wm-nav-container .wm-nav .wm-nav-item:hover {";
            style += "background-color: " + hex + ";";
            style += "}";
        $('style[id=wm-preview-style-wm_saf_a_hover]').remove();
        $('head').append('<style id="wm-preview-style-wm_saf_a_hover" type="text/css">' + style + '</style>');
    } );
} );

wp.customize( 'wm_saf_a_pointer', function( value ) {
    // GOOD
    value.bind( function( hex ) {
        $('#wm-page-wrapper #wm-content-outter-wrapper #wm-left-sidebar #wm-nav-container .wm-nav .wm-active > .wm-nav-item').css("border-color", hex );
        var style = "#wm-page-wrapper #wm-content-outter-wrapper #wm-left-sidebar #wm-nav-container .wm-nav .wm-active > .wm-nav-item:before {";
            style += "border-right-color: " + hex + ";";
            style += "}";
        $('style[id=wm-preview-style-wm_saf_a_pointer]').remove();
        $('head').append('<style id="wm-preview-style-wm_saf_a_pointer" type="text/css">' + style + '</style>');
    } );
} );

wp.customize( 'wm_saf_bg_color', function( value ) {
    value.bind( function( hex ) {
        // GOOD
        $('#wm-page-wrapper #wm-content-outter-wrapper #wm-left-sidebar').css("background-color", hex );
        $('#wm-footer-wrapper').css("background-color", hex );
        $('#wm-page-wrapper #wm-content-outter-wrapper #wm-right-sidebar').css("background-color", hex );
    } );
} );

wp.customize( 'wm_saf_color', function( value ) {
    // Good
    value.bind( function( hex ) {
        $('#wm-page-wrapper #wm-left-sidebar').css("color", hex );
        $('#wm-page-wrapper #wm-footer').css("color", hex );
        $('#wm-page-wrapper #wm-right-sidebar').css("color", hex );
    } );
} );

wp.customize( 'wm_saf_bg_color', function( value ) {
    // Good
    value.bind( function( hex ) {
        $('#wm-page-wrapper #wm-content-outter-wrapper #wm-left-sidebar .wm-mobile-controls .wm-control-btn').css("background-color", hex );
        $('#wm-left-sidebar').css("background-color", hex );
        $('#wm-page-wrapper #wm-content-outter-wrapper #wm-right-sidebar .wm-mobile-controls .wm-control-btn').css("background-color", hex );
        $('#wm-right-sidebar').css("background-color", hex );
        $('#wm-footer').css("background-color", hex );
    } );
} );



wp.customize( 'wm_pg_a', function( value ) {
    // Good
    value.bind( function( hex ) {
        $('#wm-page-wrapper #wm-content-inner-wrapper #wm-main-content a').css("color", hex );
    } );
} );

wp.customize( 'wm_pg_bg_color', function( value ) {
    // Good
    value.bind( function( hex ) {
        $('#wm-page-wrapper #wm-content-inner-wrapper').css("background-color", hex );
    } );
} );

wp.customize( 'wm_pg_border_color', function( value ) {
    value.bind( function( hex ) {
        $('#wm-page-wrapper #wm-content-inner-wrapper').css("border-color", hex );
        $('#wm-page-wrapper #wm-content-inner-wrapper .wm-control-btns').css("border-color", hex );
        $('#wm-page-wrapper #wm-content-inner-wrapper #wm-search-row #wm-search-wrapper #wm-search').css("border-color", hex );
    } );
} );

wp.customize( 'wm_pg_border_color_hover', function( value ) {
    value.bind( function( hex ) {
        var style = "#wm-page-wrapper #wm-content-inner-wrapper .wm-control-btns:hover {";
            style += "border-color: " + hex + ";";
            style += "}";
            style += "#wm-page-wrapper #wm-content-inner-wrapper #wm-search-row #wm-search-wrapper #wm-search:hover {";
            style += "border-color: " + hex + ";";
            style += "}";
        $('style[id=wm-preview-style-wm_pg_border_color_hover]').remove();
        $('head').append('<style id="wm-preview-style-wm_pg_border_color_hover" type="text/css">' + style + '</style>');
    } );
} );

wp.customize( 'wm_pg_btn', function( value ) {
    value.bind( function( hex ) {
        $('#wm-page-wrapper #wm-content-inner-wrapper .wm-control-btns').css("color", hex );
        $('#wm-page-wrapper #wm-content-inner-wrapper #wm-search-row #wm-search-wrapper .wm-search-icon').css("color", hex );
    } );
} );

wp.customize( 'wm_pg_btn_bg_color', function( value ) {
    value.bind( function( hex ) {
        $('#wm-page-wrapper #wm-content-inner-wrapper .wm-control-btns').css("background-color", hex );
    } );
} );

wp.customize( 'wm_pg_color', function( value ) {
    value.bind( function( hex ) {
        $('#wm-page-wrapper #wm-content-inner-wrapper #wm-post').css("color", hex );
    } );
} );
