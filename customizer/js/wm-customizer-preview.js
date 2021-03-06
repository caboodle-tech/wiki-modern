( function( $ ) {

wp.customize( 'wm_toggle_logo', function( value ) {
    value.bind( function( val ) {
        var elem = $('#wm-logo');
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
        alert(val+" >>> "+value);
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
        var elem = $('#wm-column-1');
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
        var elem = $('#wm-column-2');
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
        var elem = $('#wm-column-3');
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
        var elem = $('#wm-column-4');
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