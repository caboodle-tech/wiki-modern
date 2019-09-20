/**
* Handles live updates to the website triggered by the user
* changing options on the Theme Options panel of the  Customizer.
*
* @see ../classes/wm_customiser_toggle_control.php
* @since 1.0.0
*/

// Show/hide website logo.
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

// Show/hide website title.
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

// Change alignment of the website title
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

// Show/hide website tag line.
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

// Change alignment of the website tagline
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

// Change alignment of the footer column 1
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

// Change alignment of the footer column 2
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

// Change alignment of the footer column 3
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

// Change alignment of the footer column 4
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
