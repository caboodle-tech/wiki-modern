<?php
/**
* Determines if the Site Tile and Tag Line should be displayed. If one or both
* are to be displayed this will output the HTML.
*/

$title = htmlentities( get_bloginfo('name'), ENT_QUOTES );
$tagline = htmlentities( get_bloginfo('description'), ENT_QUOTES );

if( !empty($title) && get_theme_mod('wm_toggle_site_title') ){
    $align = get_theme_mod('wm_site_title_alignment');
    if( $align == 'centered' ){ $align = 'center'; }
    echo '<div id="wm-site-title" class="wm-align-' . $align . '">' . $title . '</div>';
}

if( !empty($tagline) && get_theme_mod('wm_toggle_tagline') ){
    $align = get_theme_mod('wm_site_tagline_alignment');
    if( $align == 'centered' ){ $align = 'center'; }
    echo '<div id="wm-site-tagline" class="wm-align-' . $align . '">' . $tagline . '</div>';
}

// Only show a top navigation separator if there is stuff above the nav.
if( ( !empty($title) && get_theme_mod('wm_toggle_site_title') ) || ( !empty($tagline) && get_theme_mod('wm_toggle_tagline') ) || !get_theme_mod('wm_toggle_logo') ){
    echo '<span class="wm-nav-separator" aria-hidden="true"></span>';
}
