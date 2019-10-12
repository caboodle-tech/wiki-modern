<?php

$files = scandir( get_template_directory() . '/less/' );

$less_files = [];
$comp_files = [];

$content = '';
$count = 0;
echo '<pre>';
foreach( $files as $file ){

    if( $file != '.' && $file != '..' && $file != 'colors.less' ){

        if( substr( $file, -4 ) == 'less' ){

            $content = file_get_contents( get_template_directory() . '/less/' . $file );

            // Remove all comments
            $content = preg_replace( '/(\/\*([^\*]|[\r\n]|(\*+([^\*\/]|[\r\n])))*\*+\/)|((?<= |^|\t)\/\/.*)/m', '', $content );

            preg_match_all( '/@import.+;/', $content, $matches );

            if( count( $matches[0] ) < 1 ){
                $comp_files[ $file ] = $content;
            } else {
                $less_files[ $file ] = $content;
            }
        }
    }
}

$counter = 1;

while( count( $less_files ) > 0 ){

    foreach( $less_files as $file => $content ){

        foreach ( $comp_files as $key => $less ) {
            $content = preg_replace( '/@import.+"' . $key . '";/', $less, $content );
        }

        // Remove all comments
        $content = preg_replace( '/(\/\*([^\*]|[\r\n]|(\*+([^\*\/]|[\r\n])))*\*+\/)|((?<= |^|\t)\/\/.*)/m', '', $content );

        preg_match_all( '/@import.+;/', $content, $matches );

        // If there are no more imports move this to the completed list
        if( count( $matches[0] ) < 1 ){
            $comp_files[ $file ] = $content;
            unset( $less_files[ $file ] );
            continue;
        }

        // If there is only one more file left and the only import(s) are colors add it to the completed list
        if( count( $matches[0] ) == 1 ){

            $value = trim( preg_replace( array('/"/', '/;/', '/\(.+\)/', '/@import/'), '', $matches[0][0] ) );

            if( $value == 'colors.less' ){
                $comp_files[ $file ] = $content;
                unset( $less_files[ $file ] );
                continue;
            }
        }

        // Keep going
        $less_files[ $file ] = $content;
    }

    // Emergency stop, do not recurse more than 10 times
    if( $counter < 10 ){
        $counter++;
    } else {
        break;
    }
}

file_put_contents( get_template_directory() . '/etc/template.less', $comp_files['main.less'] );
?>
