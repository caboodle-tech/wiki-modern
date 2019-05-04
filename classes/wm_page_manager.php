<?php
if ( !class_exists( 'WM_page_manager' ) ){

    /**
    * Responsible for everything shown on a post page.
    */
	class WM_page_manager {

        public function __construct (){}

        private function prep_home_page_images( $html ){

            // TODO: ADD DEVICE CHECKING HERE
            // > get alt and title first
            // > save file exstension to help with comparing
            // > lookup file path and then file name by size and device

            // Create an empty array and then fill it with images if any are found
            $images = [];
            preg_match_all( '/<img.+\/{0,1}>/', $html, $images );

            // Remove all references to images including WordPress 5+ image comments
            $html = preg_replace( '/<img.+\/{0,1}>/', '', $html );
            $html = preg_replace( '/<!-- wp:image.+\/wp:image -->/ms', '', $html );

            foreach ($images[0] as $key => $value) {
                $value = preg_match( '/src="([^"]*)"/i', $value, $ary ) ;
                $value = preg_replace( '/(.*)-\d{1,}[xX]{0,1}\d{1,}/', '${1}', $ary[1] );
                //$value = preg_replace( '/width=".*"|height=".*"/', '', $value );
                $images[0][$key] = [ substr( $value, 0, strrpos( $value, '/' ) ), substr( $value, strrpos( $value, '/' ) + 1 ) ];
            }

            // TODO: SEND BACK CORRECTED IMAGE URLS FOR DEVICE SIZE

            // Send back the cleaned HTML and images as seperate indexes in an array
            return [ $html, $images[0] ];
        }

        public function get_home_page(){

            // Bring in the database class
            global $wpdb;
            global $WM_device;

            // Get the post limit from settings: Settings > Reading > Blog pages show at most
            $post_limit = get_option( 'posts_per_page' );

            // Force at least 1 post to be shown.
            if( $post_limit < 1 ){
                $post_limit = 1;
            }

            // We need to build a string of post ID's to load and display
            $int_string = '';

            // Load and show all sticky posts regardless of the post limit
            $sticky = get_option( 'sticky_posts' );
            $sticky_count = count( $sticky );
            $sticky_result = [];

            if( $sticky_count > 0 ){
                foreach( $sticky as $int ){
                    $int_string .= "$int, ";
                }
                $int_string = substr( $int_string, 0, -2 );

                $query = "SELECT * FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' AND ID IN ($int_string) ORDER BY post_modified DESC;";

                $sticky_result = $wpdb->get_results( $query );

                $post_limit -= count( $sticky_result );
            }

            // If we have not gone over the post limit load the latest post now until we do
            $normal_result = [];

            if( $post_limit > 0 ){

                $query = "SELECT * FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' AND ID NOT IN ($int_string) ORDER BY post_date DESC LIMIT $post_limit";

                $normal_result = $wpdb->get_results( $query );
            }

            // Merge the array of sticky posts with normal posts
            $normal_result = array_merge( $sticky_result, $normal_result );

            // Display the posts
            foreach( $normal_result as $post ){
                setup_postdata( $post );
                the_title(); // TO DO CHNAGE THIS
                echo '<br>';
                $content = get_the_content();
                $content = $this->prep_home_page_images( $content );
                echo apply_filters('the_content', $content[0] );
                Kint::dump( $content );
                // NOTE: I could remove shortcodes here??? For security reasons or something???? []
                echo '<br>';
                echo '<br>';
                echo '<br>';
            }

            // Discreate table of sticky post in order already
            // SELECT * FROM `wm_posts` WHERE `post_type` = 'post' AND `post_status` = 'publish' AND `ID` IN (410, 1, 375) ORDER BY `post_modified` DESC

            // Discreate table of latest posts minus any sticky posts
            // SELECT * FROM `wm_posts` WHERE `post_type` = 'post' AND `post_status` = 'publish' AND `ID` NOT IN (410, 1, 375) ORDER BY `post_date` DESC LIMIT 2

            // If we haven't reached our limit yet show newest posts until we do.

            // https://stackoverflow.com/a/19814472/3193156

            //print_r( $sticky );
            //var_dump( $query );
        }

    /** End Class. */
    }
/** End check for class. */
}
