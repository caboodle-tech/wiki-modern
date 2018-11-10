/**
* Handles live updates to the website triggered by the user
* toggling options on or off in the Customizer.
*
* @see ../classes/wm_customiser_toggle_control.php
* @since 1.0.0
*/

/** Show/hide website logo. */
wp.customize( 'wm_toggle_logo', function( value ) {
    value.bind( function( val ) {
        var elem = $('#wm-wrapper #wm-left-sidebar #wm-logo-container #wm-logo');
        console.log( elem );
        if( elem ){
            if( $( elem ).attr( 'data-wm-hidden' ) ){
                if( $( elem ).attr( 'data-wm-hidden' ) == '1' ){
                    $( elem ).attr( 'data-wm-hidden', '0' );
                    $( elem ).css( 'display', 'block' );
                }
            } else {
                $( elem ).attr( 'data-wm-hidden', '1' );
                $( elem ).css( 'display', 'none' );
            }
        }
    } );
} );

/** Show/hide website title. */
wp.customize( 'wm_toggle_site_title', function( value ) {
    value.bind( function( val ) {
        var elem = $('#wm-wrapper #wm-left-sidebar #wm-logo-container #wm-site-title');
        if( elem ){
            if( $( elem ).attr( 'data-wm-hidden' ) ){
                if( $( elem ).attr( 'data-wm-hidden' ) == '1' ){
                    $( elem ).attr( 'data-wm-hidden', '0' );
                    $( elem ).css( 'display', 'block' );
                }
            } else {
                $( elem ).attr( 'data-wm-hidden', '1' );
                $( elem ).css( 'display', 'none' );
            }
        }
    } );
} );

/** Show/hide website tag line. */
wp.customize( 'wm_toggle_tagline', function( value ) {
    value.bind( function( val ) {
        var elem = $('#wm-wrapper #wm-left-sidebar #wm-logo-container #wm-tagline');
        if( elem ){
            if( $( elem ).attr( 'data-wm-hidden' ) ){
                if( $( elem ).attr( 'data-wm-hidden' ) == '1' ){
                    $( elem ).attr( 'data-wm-hidden', '0' );
                    $( elem ).css( 'display', 'block' );
                }
            } else {
                $( elem ).attr( 'data-wm-hidden', '1' );
                $( elem ).css( 'display', 'none' );
            }
        }
    } );
} );
