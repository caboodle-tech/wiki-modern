<?php
/**
 * Add support for uploading and displaying a custom site logo.
 *
 * @package Wiki Modern Theme
 * @since 1.0.0
 */

// Turn on logo support in WordPress's theme customizer.
function wm_custom_logo_setup() {

    /** Logo settings. */
    $defaults = array(
        'height'      => 140,
        'width'       => 280,
        'flex-height' => true,
        'flex-width'  => true,
    );
    add_theme_support( 'custom-logo', $defaults );

}
add_action( 'after_setup_theme', 'wm_custom_logo_setup' );

// Make sure to add the .wm-logo class to our custom logo.
function wm_change_logo_html( $html ) {

    // Build logo title.
    $site    = htmlentities( get_bloginfo( 'name' ), ENT_COMPAT );
    $tagline = htmlentities( get_bloginfo( 'description' ), ENT_COMPAT );

    // Is there a site title?
    if ( strlen( $site ) > 0 ) {
        // Yes.
        $title = $site;
        // Is there a tag line?
        if ( strlen( $tagline ) > 0 ) {
            // Yes. Show both.
            $title .= ' &ndash; ' . $tagline;
        }
    } else {
        // No. How about a tag line?
        if ( strlen( $tagline ) > 0 ) {
            // Yes. Show just the tag line.
            $title = $tagline;
        } else {
            // No. Show nothing.
            $title = '';
        }

    }

    // Replace HTML parts.
    $html = str_replace( 'custom-logo', 'wm-logo', $html );
    $html = str_replace( 'custom-logo-link', 'wm-logo-link', $html );
    $html = str_replace( 'class="wm-logo"', 'class="wm-logo" title="' . $title . '"', $html );

    /**
    * Should the site logo be shown or hidden?
    * Also and the logo ID to the HTML.
    */
    if ( get_theme_mod( 'wm_toggle_logo' ) ) {
        $html = str_replace( 'class="wm-logo"', 'id="wm-logo" class="wm-logo" style="display:none;" data-wm-hidden="1"', $html );
    } else {
        $html = str_replace( 'class="wm-logo"', 'id="wm-logo" class="wm-logo" data-wm-hidden="0"', $html );
    }
    return $html;
}
add_filter( 'get_custom_logo', 'wm_change_logo_html' );
