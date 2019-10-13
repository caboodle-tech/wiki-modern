<?php

$update = false;

// Make sure we have a previous file to compare to
if( !file_exists( get_template_directory() . '/etc/previous.json' ) ){
    // Forece update since there was no file to compare to
    $previous = json_decode( file_get_contents( get_template_directory() . '/etc/colors.json' ), true );
} else {
    $previous = json_decode( file_get_contents( get_template_directory() . '/etc/previous.json' ), true );
}

// Check if any of the colors have changed
foreach( $previous as $key => &$color ){

    if( get_theme_mod( $key ) != $color ){
        $tmp .= 'Previous: ' . $previous[ $key ] . ' ==> ' . get_theme_mod( $key ) . PHP_EOL;
        $previous[ $key ] = get_theme_mod( $key );
        $update = true;
    }
}


if( $update ){

    // Register the fact that we need to do an update
    update_option( 'wm-less-template-rebuild', true );

    // Convert JSON into LESS
    $less = '';
    foreach( $previous as $key => &$color ){
        $less .= '@' . $key . ': ' . $color . ';' . PHP_EOL;
    }

    // Load LESS template and replace color import
    $template = file_get_contents( get_template_directory() . '/etc/template.less' );
    $template = str_replace( '@import "colors.less";', $less, $template );

    // Save a temporary template file
    file_put_contents( get_template_directory() . '/etc/_template.less', $template );

    // Record the current colors
    file_put_contents( get_template_directory() . '/etc/previous.json', json_encode( $previous ) );
}
