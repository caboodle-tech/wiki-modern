<?php
if( !function_exists( 'wm_auto_copyright' ) ){

    // https://www.wpbeginner.com/wp-tutorials/how-to-add-a-dynamic-copyright-date-in-wordpress-footer/
    function wm_auto_copyright() {
        global $wpdb;

        $query = "SELECT YEAR( min( post_date_gmt ) ) AS firstdate FROM $wpdb->posts WHERE post_status = 'publish'";

        $dates = $wpdb->get_results( $query );

        $copyright = '<i class="far fa-copyright"></i> ';

        if( $dates ){
            $copyright .= $dates[0]->firstdate;
            if( $dates[0]->firstdate != date('Y') ){
                $copyright .= ' &ndash; ' . date('Y');
            }
        } else {
            $copyright .= date('Y');
        }
        return $copyright;
    }
}

?>
