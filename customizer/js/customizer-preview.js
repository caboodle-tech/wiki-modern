( function( $ ) {

wp.customize( 'wm_saf_a', function( value ) {
    value.bind( function( hex) {
        $('.wm-control-btns').css("color", hex);
        $('#wm-wrapper #wm-left-sidebar a').css("color", hex);
        $('#wm-wrapper #wm-left-sidebar #wm-nav-container .wm-nav .wm-nav-item').css("color", hex);
        $('#wm-wrapper #wm-right-sidebar a').css("color", hex);
        $('#wm-wrapper #wm-right-sidebar .wm-widget .wm-widget-info .wm-tags').css("color", hex);
        $('#wm-wrapper #wm-footer a').css("color", hex);
    } );
} );
wp.customize( 'wm_saf_a_active', function( value ) {
    value.bind( function( hex) {
        $('#wm-wrapper #wm-left-sidebar #wm-nav-container .wm-nav .wm-active > .wm-nav-item').css("background-color", hex);
    } );
} );
wp.customize( 'wm_saf_a_hover', function( value ) {
    value.bind( function( hex) {
        var style = "#wm-wrapper #wm-left-sidebar #wm-nav-container .wm-nav .wm-nav-item:hover {";
            style += "background-color: " + hex + ";";
            style += "}";
        $('style[id=wm-preview-style-wm_saf_a_hover]').remove();
        $('head').append('<style id="wm-preview-style-wm_saf_a_hover" type="text/css">' + style + '</style>');
    } );
} );
wp.customize( 'wm_saf_a_pointer', function( value ) {
    value.bind( function( hex) {
        $('#wm-wrapper #wm-left-sidebar #wm-nav-container .wm-nav .wm-nav-item').css("border-color", hex);
        var style = "#wm-wrapper #wm-left-sidebar #wm-nav-container .wm-nav .wm-active > .wm-nav-item:before {";
            style += "border-right-color: " + hex + ";";
            style += "}";
        $('style[id=wm-preview-style-wm_saf_a_pointer]').remove();
        $('head').append('<style id="wm-preview-style-wm_saf_a_pointer" type="text/css">' + style + '</style>');
    } );
} );
wp.customize( 'wm_saf_bg_color', function( value ) {
    value.bind( function( hex) {
        $('#wm-wrapper #wm-left-sidebar').css("background-color", hex);
        $('#wm-wrapper #wm-footer').css("background-color", hex);
        $('#wm-wrapper #wm-right-sidebar').css("background-color", hex);
    } );
} );
wp.customize( 'wm_saf_color', function( value ) {
    value.bind( function( hex) {
        $('#wm-wrapper #wm-left-sidebar').css("color", hex);
        $('#wm-wrapper #wm-footer').css("color", hex);
        $('#wm-wrapper #wm-right-sidebar').css("color", hex);
    } );
} );
wp.customize( 'wm_saf_bg_color', function( value ) {
    value.bind( function( hex) {
        $('.wm-control-btns').css("background-color", hex);
        $('#wm-wrapper #wm-left-sidebar').css("background-color", hex);
        $('#wm-wrapper #wm-right-sidebar').css("background-color", hex);
        $('#wm-wrapper #wm-footer').css("background-color", hex);
    } );
} );
wp.customize( 'wm_pg_a', function( value ) {
    value.bind( function( hex) {
        $('#wm-wrapper #wm-page-content a').css("color", hex);
    } );
} );
wp.customize( 'wm_pg_bg_color', function( value ) {
    value.bind( function( hex) {
        $('#wm-wrapper #wm-page-content').css("background-color", hex);
    } );
} );
wp.customize( 'wm_pg_border_color', function( value ) {
    value.bind( function( hex) {
        $('#wm-wrapper #wm-page-content').css("border-color", hex);
        $('#wm-wrapper #wm-page-content .wm-control-btns').css("border-color", hex);
        $('#wm-wrapper #wm-page-content #wm-search-row #wm-search-wrapper #wm-search').css("border-color", hex);
    } );
} );
wp.customize( 'wm_pg_border_color_hover', function( value ) {
    value.bind( function( hex) {
        var style = "#wm-wrapper #wm-page-content .wm-control-btns:hover {";
            style += "border-color: " + hex + ";";
            style += "}";
            style += "#wm-wrapper #wm-page-content #wm-search-row #wm-search-wrapper #wm-search:hover {";
            style += "border-color: " + hex + ";";
            style += "}";
        $('style[id=wm-preview-style-wm_pg_border_color_hover]').remove();
        $('head').append('<style id="wm-preview-style-wm_pg_border_color_hover" type="text/css">' + style + '</style>');
    } );
} );
wp.customize( 'wm_pg_btn', function( value ) {
    value.bind( function( hex) {
        $('#wm-wrapper #wm-page-content .wm-control-btns').css("color", hex);
        $('#wm-wrapper #wm-page-content #wm-search-row #wm-search-wrapper .wm-search-icon').css("color", hex);
    } );
} );
wp.customize( 'wm_pg_btn_bg_color', function( value ) {
    value.bind( function( hex) {
        $('#wm-wrapper #wm-page-content .wm-control-btns').css("background-color", hex);
    } );
} );
wp.customize( 'wm_pg_color', function( value ) {
    value.bind( function( hex) {
        $('#wm-wrapper #wm-page-content #wm-post').css("color", hex);
    } );
} );
wp.customize( 'wm_toggle_logo', function( value ) {
    value.bind( function( val ) {
        var elem = $('#wm-identity-container');
        if( elem ){
            if( $( elem ).attr( 'data-wm-hidden' ) == '1' ){
                $( elem ).attr( 'data-wm-hidden', '0' );
                $( elem ).css( 'display', 'block' );
            } else {
                $( elem ).attr( 'data-wm-hidden', '1' );
                $( elem ).css( 'display', 'none' );
            }
        }
    } );
} );
wp.customize( 'wm_toggle_site_title', function( value ) {
    value.bind( function( val ) {
        var elem = $('#wm-site-title');
        if( elem ){
            if( $( elem ).attr( 'data-wm-hidden' ) == '1' ){
                $( elem ).attr( 'data-wm-hidden', '0' );
                $( elem ).css( 'display', 'block' );
            } else {
                $( elem ).attr( 'data-wm-hidden', '1' );
                $( elem ).css( 'display', 'none' );
            }
        }
    } );
} );
wp.customize( 'wm_site_title_alignment', function( value ) {
    value.bind( function( val ) {
        var elem = $('#wm-site-title');
        if( elem ){
            $( elem ).removeClass('wm-align-left');
            $( elem ).removeClass('wm-align-center');
            $( elem ).removeClass('wm-align-right');
            if( val == 'centered' ){ val = 'center'; }
            $( elem ).addClass( 'wm-align-' + val );
        }
    } );
} );
wp.customize( 'wm_toggle_tagline', function( value ) {
    value.bind( function( val ) {
        var elem = $('#wm-site-tagline');
        if( elem ){
            if( $( elem ).attr( 'data-wm-hidden' ) == '1' ){
                $( elem ).attr( 'data-wm-hidden', '0' );
                $( elem ).css( 'display', 'block' );
            } else {
                $( elem ).attr( 'data-wm-hidden', '1' );
                $( elem ).css( 'display', 'none' );
            }
        }
    } );
} );
wp.customize( 'wm_site_tagline_alignment', function( value ) {
    value.bind( function( val ) {
        var elem = $('#wm-site-tagline');
        if( elem ){
            $( elem ).removeClass('wm-align-left');
            $( elem ).removeClass('wm-align-center');
            $( elem ).removeClass('wm-align-right');
            if( val == 'centered' ){ val = 'center'; }
            $( elem ).addClass( 'wm-align-' + val );
        }
    } );
} );
wp.customize( 'wm_col1_alignment', function( value ) {
    value.bind( function( val ) {
        var elem = $('#wm-footer-column-1');
        if( elem ){
            $( elem ).removeClass('wm-align-left');
            $( elem ).removeClass('wm-align-center');
            $( elem ).removeClass('wm-align-right');
            if( val == 'centered' ){ val = 'center'; }
            $( elem ).addClass( 'wm-align-' + val );
        }
    } );
} );
wp.customize( 'wm_col2_alignment', function( value ) {
    value.bind( function( val ) {
        var elem = $('#wm-footer-column-2');
        if( elem ){
            $( elem ).removeClass('wm-align-left');
            $( elem ).removeClass('wm-align-center');
            $( elem ).removeClass('wm-align-right');
            if( val == 'centered' ){ val = 'center'; }
            $( elem ).addClass( 'wm-align-' + val );
        }
    } );
} );
wp.customize( 'wm_col3_alignment', function( value ) {
    value.bind( function( val ) {
        var elem = $('#wm-footer-column-3');
        if( elem ){
            $( elem ).removeClass('wm-align-left');
            $( elem ).removeClass('wm-align-center');
            $( elem ).removeClass('wm-align-right');
            if( val == 'centered' ){ val = 'center'; }
            $( elem ).addClass( 'wm-align-' + val );
        }
    } );
} );
wp.customize( 'wm_col4_alignment', function( value ) {
    value.bind( function( val ) {
        var elem = $('#wm-footer-column-4');
        if( elem ){
            $( elem ).removeClass('wm-align-left');
            $( elem ).removeClass('wm-align-center');
            $( elem ).removeClass('wm-align-right');
            if( val == 'centered' ){ val = 'center'; }
            $( elem ).addClass( 'wm-align-' + val );
        }
    } );
} );

} )( jQuery );