<?php
if ( !class_exists( 'WM_page_manager' ) ){

    /**
    * Responsible for everything shown on a post page.
    */
	class WM_page_manager {

        public function __construct (){}

        private function prep_home_page_html( $title, $raw_html ){

            // TODO: CLEAN POST TITLE!!!!

            $raw_html = apply_filters('the_content', $raw_html );

            // Create an empty array and then fill it with images if any are found
            $images = [];
            preg_match_all( '/<img.+\/{0,1}>/', $raw_html, $images );

            // Remove all references to images including WordPress 5+ image comments
            $raw_html = preg_replace( '/<figure.+<\/figure>/', '', $raw_html );
            $raw_html = preg_replace( '/<img.*?>/', '', $raw_html );

            $html = '<div class="wm-article"><div class="wm-article-title">' . $title . '</div>';
            if( count( $images ) > 0 ){
                $image_html = '';
                foreach( $images as $image ){
                    Kint::dump( $image );
                    $image_html .= '<div class="wm-artilce-image">' . $image[0] . '</div>';
                }
                $html .= '<div class="wm-article-image-wrapper">' . $image_html . '</div>';
                $html .= '<div class="wm-article-content">' . $raw_html . '</div>';
            } else {
                $html .= '<div class="wm-article-content">' . $raw_html . '</div>';
            }

            return $html;
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
                //the_title(); // TO DO CHNAGE THIS
                //echo '<br>';
                echo $this->prep_home_page_html( get_the_title( $post->ID ), get_the_content() );
                //Kint::dump( apply_filters('the_content', $content[0] ) );
                //echo apply_filters('the_content', $content[0] );
                //Kint::dump( $content );
                // NOTE: I could remove shortcodes here??? For security reasons or something???? []
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
