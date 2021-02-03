<?php
/**
 * Wiki Modern Theme autoloader.
 * 
 * @package Wiki Modern Theme
 */

/**
 * Wiki Modern Theme autoloader.
 *
 * @param class $class The class to attemt to autoload.
 * @return void
 */
function wm_autoloader( $class ) {

    if ( ! class_exists( $class, false ) ) {

        // Is this a WordPress class?
        if ( substr( $class, 0, 2 ) === 'WP' ) {
            // Yes.
            $filename = str_replace( '_', '-', strtolower( $class ) ) . '.php';
            $file     = ABSPATH . 'wp-includes/class-' . $filename;
            // Is this a normal include?
            if ( file_exists( $file ) ) {
                // Yes.
                require $file;
            } else {
                // No, try admin.
                $file = ABSPATH . 'wp-admin/includes/class-' . $filename;
                require $file;
            }
        // No. How about a Customizer class?
        } elseif ( strpos( $class, 'Customizer' ) !== false ) {
            // Yes.
            echo 'CUSTOMIZER';
        } else {
            // No. This is a plain 'ol class.
            $filename = str_replace( array( '_', '\\' ), array( '-', '/' ), strtolower( $class ) );
            $filename = substr( $filename, 0, strrpos( $filename, '/' ) ) . '/class-' .
                        substr( $filename, strrpos( $filename, '/' ) + 1 ) . '.php';
            $file     = get_template_directory() . '/classes/' . $filename;
            // Did we find the WordPress’ procedural style class?
            if ( file_exists( $file ) ) {
                // Yes.
                require $file;
            } else {
                // No. Try to load this class PSR style.
                $filename = str_replace( array( '_', '\\' ), array( '-', '/' ), $class );
                $filename = substr( $filename, 0, strrpos( $filename, '/' ) ) .
                            substr( $filename, strrpos( $filename, '/' ) ) . '.php';
                $file     = get_template_directory() . '/classes/' . $filename;
                if ( file_exists( $file ) ) {
                    wm_autoload_use( $file );
                    require $file;
                }
            }
        }
    }
}

/**
 * Check a class file for use statements and load those file(s) too.
 *
 * @param string $file The path to a class file.
 * @return void
 */
function wm_autoload_use( $file ) {
    $contents = file_get_contents( $file );
    preg_match_all( '/use (.*);\n/', $contents, $uses );
    if ( $uses[1] ) {
        foreach ( $uses[1] as $use ) {
            echo "[$use]";
            wm_autoloader( $use );
        }
    }
}

spl_autoload_register( 'wm_autoloader' );
