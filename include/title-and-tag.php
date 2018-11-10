<?php
/**
* Determines if the Site Tile and Tag Line should be displayed. If one or both
* are to be displayed this will output the HTML.
*/

$title = htmlentities( get_bloginfo('name'), ENT_QUOTES );
$tagline = htmlentities( get_bloginfo('description'), ENT_QUOTES );

// TODO: ADD AND FIX HTML

if( !empty($title) && get_theme_mod('wm_toggle_site_title') ){
    echo '<div id="wm-site-title">' . $title . '</div>';
}

if( !empty($tagline) && get_theme_mod('wm_toggle_tagline') ){
    echo '<div id="wm-tagline">' . $tagline . '</div>';
}
