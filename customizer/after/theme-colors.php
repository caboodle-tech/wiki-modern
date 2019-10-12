<?php
/**
* Save the new theme colors after a user publishes changes
* made in the Customizer.
*/

function get_theme_mod( $key ){
    return '';
}

$less_colors = '../../less/colors.less';
$json_colors = '../../etc/colors.json';

if( !file_exists( $json_colors ) ){
    $data = file_get_contents( $less_colors );
    $data = str_replace( array( '@', ': ', ';', PHP_EOL ), array( '"', '": "', '",', '' ), $data );
    $data = trim( $data );
    $data = '{' . substr( $data, 0, -1 ) . '}';
    file_put_contents( $json_colors, $data );
}

$colors = json_decode( file_get_contents( $json_colors ), true );

// Loop through values add see if an update is needed.
$update = false;
foreach( $colors as $key => &$color ){
    if( get_theme_mod( $key ) != $color ){
        //$colors[ $key ] = get_theme_mod( $key );
        $update = true;
    }
}

$update = true;

if( $update ){

    // Update the color file for use next time
    file_put_contents( $json_colors, json_encode( $colors ) );

    // Convert JSON into LESS
    $less = '';
    foreach( $colors as $key => &$color ){
        $less .= '@' . $key . ': ' . $color . ';' . PHP_EOL;
    }

    // Load LESS template and replace color import
    $template = file_get_contents( '../../etc/template.less' );
    $template = str_replace( '@import "colors.less";', $less, $template );

    // Update the timestamp file
    file_put_contents( '../../etc/_timestamp.json', '{"time":' . time() . '}' );
}

/* Wiki Modern's default color keys.
$colors = json_decode( file_get_contents( get_template_directory() . '/etc/theme-colors.json' ), true );

Loop through values add see if an update is needed.
$update = false;
foreach( $colors as $key => &$color ){
    if( get_theme_mod( $key ) != $color ){
        $update = true;
        break;
    }
}

If a change was detected re-compile the production style sheet.
if( $update ){

Loop through our defaults and use the keys to build a custom colors.less file.
    $less = ' Auto generated file of colors for the sites theme choosen in the Customizer. ' . PHP_EOL;
    foreach( $colors as $key => &$value ){
        if ( !empty( get_theme_mod( $key ) ) ){
            $less .= '@' . $key . ': ' . get_theme_mod($key) . ';' . PHP_EOL;
        } else {
            $less .= '@' . $key . ': ' . $colors[$key] . ';' . PHP_EOL;
        }
    }

    / Save the custom colors.less file to the etc directory.
    file_put_contents( get_template_directory() . '/etc/colors.less', $less );

    /** Load the LESS compiler.
    require( get_template_directory() . '/include/less' );
    $less_compiler = new lessc;

    /** Move the production file temporarily.
    rename( get_template_directory() . '/less/colors.less', get_template_directory() . '/less/__tmp-colors.less' );
    copy( get_template_directory() . '/etc/colors.less', get_template_directory() . '/less/colors.less' );

    /** Attempt to compile LESS.
    try {
        $source = $less_compiler->compileFile( get_template_directory() .'/less/main.less' );
        file_put_contents( get_template_directory() . '/css/main.css', $source );
    } catch(Exception $e){
        // TODO: Handle this.
    }

    /** Restore files.
    unlink( get_template_directory() . '/less/colors.less' );
    rename( get_template_directory() . '/less/__tmp-colors.less', get_template_directory() . '/less/colors.less' );

    /** Clean up.
    $less_compiler = NULL;
    unset($less_compiler);
}
*/
