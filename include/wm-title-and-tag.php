<?php
/**
 * Determines if the Site Tile and Tag Line should be displayed. If one or both
 * are to be displayed this will output the HTML.
 * 
 * @package Wiki Modern Theme
 */

$business = htmlentities( get_bloginfo( 'name' ), ENT_QUOTES );
$tagline  = htmlentities( get_bloginfo( 'description' ), ENT_QUOTES );

if ( ! empty( $business ) && get_theme_mod( 'wm_toggle_site_title' ) ) {
    $align = get_theme_mod( 'wm_site_title_alignment' );
    if ( $align === 'centered' ) {
        $align = 'center';
    }
    echo '<div id="wm-site-title" class="wm-align-' . esc_attr( $align ) . '">' . esc_html( $business ) . '</div>';
}

if ( ! empty( $tagline ) && get_theme_mod( 'wm_toggle_tagline' ) ) {
    $align = get_theme_mod( 'wm_site_tagline_alignment' );
    if ( $align === 'centered' ) {
        $align = 'center';
    }
    echo '<div id="wm-site-tagline" class="wm-align-' . esc_attr( $align ) . '">' . esc_html( $tagline ) . '</div>';
}
