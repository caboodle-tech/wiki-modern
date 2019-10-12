<?php

$main_less = file_get_contents( './less/main.less' );

// Find all import statements
preg_match_all( '/@import.+;/', $main_less, $less_files );

// Build an array of files names needing import
foreach( $less_files[0] as $key => $value ){
    $value = trim( preg_replace( array('/"/', '/;/', '/\(.+\)/', '/@import/'), '', $value ) );
    // Remove the color file, we need to leave that import in place to swap later
    if( $value == 'colors.less' ){
        unset( $less_files[0][ $key ] );
    } else {
        $less_files[0][ $key ] = $value;
    }
}

//https://www.php.net/manual/en/function.array-unique.php#70786
// Swap array keys and values, remove duplicates, and re-index
$less_files = array_keys( array_flip( $less_files[0] ) );

$less_map = [];

$nested_less = [];

$content = '';

foreach ( $less_files as $value ) {

    $content = file_get_contents( './less/' . $value );

    preg_match_all( '/@import.+;/', $content, $nested );

    if( count( $nested[0] ) > 0 ){
        foreach( $nested[0] as $key => $nested_value ){
            $nested_value = trim( preg_replace( array('/"/', '/;/', '/\(.+\)/', '/@import/'), '', $nested_value ) );
            // Remove the color file, we need to leave that import in place to swap later
            if( $nested_value == 'colors.less' ){
                unset( $nested[0][ $key ] );
            } else {
                $nested[0][ $key ] = $nested_value;
            }
        }
        $nested_less = array_unique( array_merge( $nested_less, $nested[0] ) );
    }

    $less_map[ $value ] = $content;
}

// Recursively add nested import files
foreach( $nested_less as $file ){
    if( !array_key_exists( $file, $less_map ) ){
        recursive_add( $file, $less_map );
    }
}

foreach ( $less_map as $key => $value ) {
    $main_less = preg_replace( '/@import.+"' . $key . '";/', $value, $main_less );
}

// Remove all comments
$main_less = preg_replace( '/(\/\*([^\*]|[\r\n]|(\*+([^\*\/]|[\r\n])))*\*+\/)|((?<= |^|\t)\/\/.*)/m', '', $main_less );

file_put_contents( './etc/template.less', $main_less );

function recursive_add( $file, $less_map ){

    $less = file_get_contents( './less/' . $file );

    // Find all import statements
    preg_match_all( '/@import.+;/', $less, $less_files );

    // Build an array of files names needing import
    foreach( $less_files[0] as $key => $value ){
        $value = trim( preg_replace( array('/"/', '/;/', '/\(.+\)/', '/@import/'), '', $value ) );
        // Remove the color file, we need to leave that import in place to swap later
        if( $value == 'colors.less' ){
            unset( $less_files[0][ $key ] );
        } else {
            $less_files[0][ $key ] = $value;
        }
    }

    // Swap array keys and values, remove duplicates, and re-index
    $less_files = array_keys( array_flip( $less_files[0] ) );

    // Recursively add nested import files
    foreach( $less_files as $file ){
        if( !array_key_exists( $file, $less_map ) ){
            recursive_add( $file, $less_map );
        }
    }
}
?>
