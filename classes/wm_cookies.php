<?php
/**
 * Cookie manager.
 */
class WM_cookies {

    /**
     * Constructor
     */
    public function __construct(){}

    /**
     * Create or Update cookie.
     */
    public function create( $name, $value = "", $expires = 0, $path = "", $domain = "", $secure = false, $http_only = true ){

        if( $expires != 0 ){
            // Create a date
            $date = new DateTime();
            // Modify it (+1hours; +1days; +20years; -2days etc)
            $date->modify( $expires );
            // Store the date in UNIX timestamp.
            $expires = $date->getTimestamp();
        }

        // Use PHP to set the cookie if headers have not been sent yet
        if( !headers_sent() ){
            return setcookie( $name, $value, $expires, $path, $domain, $secure, $http_only );
        }

        // Use JavaScript to set the cookie since headers have already been sent. Respect security though!
        if( $http_only == false ){
            $data = $name . '=' . $value . '; expires=' . $date->format('D, d M Y G:i:s') . ' GMT';
            if( $path ){
                $data .= '; path=' . $path;
            } else {
                $data .= '; path=' . wp_make_link_relative( home_url() );
            }
            if( $domain ){
                $data .= '; domain=' . $domain;
            }
            if( $secure ){
                $data .= '; secure';
            }
            echo '<script>document.cookie="' . $data . '";</script>';
            return true;
        }

        // We could not set this cookie
        return false;
    }

    /**
     * Return a cookie
     * @return mixed
     */
    public function get( $name ){
        if( $_COOKIE[ $name ] ){
            return $_COOKIE[ $name ];
        }
        return NULL;
    }

    /** Alias for create() */
    public function set( $name, $value, $expires = 0, $path = "", $domain = "", $secure = false, $http_only = true ){
        if( $name ){
            return create( $name, $value, $expires, $path, $domain, $secure, $http_only );
        }
        return false;
    }

    /**
     * Delete cookie.
     * @return bool
     */
    public function delete( $name, $path, $domain, $secure, $http_only ){
        if( $_COOKIE[ $name ] ){
            if( $path && $domain && $secure && $http_only ){
                return setcookie( $name, '', time() - 3600, $path, $domain, $secure, $http_only );
            } elseif ( $path && $domain && $secure ) {
                return setcookie( $name, '', time() - 3600, $path, $domain, $secure );
            } elseif ( $path && $domain ) {
                return setcookie( $name, '', time() - 3600, $path, $domain );
            } elseif ( $path) {
                return setcookie( $name, '', time() - 3600, $path );
            } else {
                return setcookie( $name, '', time() - 3600 );
            }
        }
        return false;
    }

}
?>
