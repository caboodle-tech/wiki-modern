<?php
function get_php_exec(){
    if ( defined('PHP_BINARY') && PHP_BINARY && in_array(PHP_SAPI, array('cli', 'cli-server')) && is_file(PHP_BINARY) ){
        return PHP_BINARY;
    } else if ( strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ){
        $paths = explode( PATH_SEPARATOR, getenv('PATH') );
        foreach ( $paths as $path ) {
            if ( substr( $path, strlen($path)-1 ) == DIRECTORY_SEPARATOR ) {
                $path=substr( $path, 0, strlen($path)-1 );
            }
            if ( substr( $path, strlen($path) - strlen('php')) == 'php' ) {
                $response=$path.DIRECTORY_SEPARATOR.'php.exe';
                if ( is_file($response) ) {
                    return $response;
                }
            } else if ( substr($path, strlen($path) - strlen('php.exe')) == 'php.exe' ) {
                if ( is_file($response) ) {
                    return $response;
                }
            }
        }
    } else {
        $paths = explode(PATH_SEPARATOR, getenv('PATH'));
        foreach ( $paths as $path ) {
            if ( substr($path, strlen($path)-1) == DIRECTORY_SEPARATOR ) {
                $path=substr($path, strlen($path)-1);
            }
            if ( substr($path, strlen($path) - strlen('php')) == 'php' ) {
                if ( is_file($path) ) {
                    return $path;
                }
                $response = $path . DIRECTORY_SEPARATOR . 'php';
                if (is_file($response)) {
                    return $response;
                }
            }
        }
    }
    return null;
}
echo get_php_exec();
?>
