<?php
if( !function_exists( 'wm_get_user_ip' ) ){

    /**
    * Attempt to get the users current IP address.
    * @author Martin Khoury
    * @see https://www.beliefmedia.com.au/get-ip-address Original source code.
    * @return String IP address or 0.0.0.0 if one could not be found.
    */
    function wm_get_user_ip() {
        foreach ( array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR' ) as $key) {
            if ( array_key_exists( $key, $_SERVER ) === true ) {
                foreach ( explode( ',', $_SERVER[$key] ) as $ip ) {
                    if ( filter_var( $ip, FILTER_VALIDATE_IP ) !== false ) {
                        return $ip;
                    }
                }
            }
        }
        return '0.0.0.0';
    }

}
