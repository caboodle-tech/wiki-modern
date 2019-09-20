<?php
if ( !class_exists( 'WM_page_manager' ) ){

    /**
    * Responsible for everything shown on a post page.
    */
	class WM_page_manager {

        public function __construct (){}

        private function prep_articles_html( $post ){

            //Kint::dump( $post );

            $title = get_the_title( $post->ID );
            $permalink = get_permalink( $post->ID );
            $published = $post->post_date;
            $updated = $post->post_modified;
            $raw_html = get_the_content( null, false, $post->ID );

            // TODO: CLEAN POST TITLE!!!!
            $html = '';

            // NOTE: We wrap the published datetime later
            if( $published == $updated ){
                $formated_published = date( get_option('date_format'), strtotime( $published ) );
                $formated_updated = '';
            } else {
                $formated_published = date( get_option('date_format'), strtotime( $published ) );
                $formated_updated = date( get_option('date_format'), strtotime( $updated ) );
                $formated_updated = ' Last updated <time itemprop="dateModified" datetime="' . $updated . '">' . $formated_updated . '</time>.';
            }

            $raw_html = apply_filters('the_content', $raw_html );

            if( !post_password_required( $post->ID ) ){

                // Create an empty array and then fill it with images if any are found
                $images = [];
                preg_match_all( '/<img.*?>/', $raw_html, $images );

                // Remove all references to images including WordPress 5+ image comments
                $raw_html = preg_replace( '/<figure.+<\/figure>/', '', $raw_html );
                $raw_html = preg_replace( '/<img.*?>/', '', $raw_html );

                $html = '<article class="wm-article" id="post-' . $post->ID . '"><h1 class="wm-article-title"><a href="' . $permalink . '">' . $title . '</a></h1>';
                $html .= '<div class="wm-article-times">Published <time itemprop="datePublished" datetime="' . $published . '">' . $formated_published . '</time>.';
                $html .= $formated_updated;
                $html .= '</div><div class="wm-article-flex-wrapper">';

                if( count( $images[0] ) > 0 ){
                    if( count( $images[0] ) > 1 ){
                        $image_html = '<div class="wm-artilce-image wm-pointer" onclick="WikiModern.toggle(\'image-carousel\')">' . $images[0][0];
                        // Add multiple image icon and close div
                        //$image_html .= '<div class="wm-control-btn"><i class="fas fa-images"></i></div></div><div class="wm-image-sources"><!--';
                        $image_html .= '</div><div class="wm-image-sources"><!--';
                        foreach( $images[0] as $image ){
                            $image_html .= $image .'||';
                        }
                        $image_html = substr( $image_html, 0, -2 );
                        $image_html .= '--></div>';
                    } else {
                        $image_html = '<div class="wm-artilce-image">' . $images[0][0] . '</div>';
                    }
                    $html .= '<div class="wm-article-image-wrapper">' . $image_html . '</div>';
                    $html .= '<div class="wm-article-content" onclick="WikiModern.navigate();" data-wm-navigation="' . $permalink . '">' . $raw_html . '</div>';
                } else {
                    $html .= '<div class="wm-article-content" onclick="WikiModern.navigate();" data-wm-navigation="' . $permalink . '">' . $raw_html . '</div>';
                }
                $html .= '</div></article>';

            } else {
                $html = '<article class="wm-article" id="post-' . $post->ID . '"><h1 class="wm-article-title wm-link wm-disabled">' . $title . '</h1>';
                $html .= '<div class="wm-article-times">Published <time itemprop="datePublished" datetime="' . $published . '">' . $formated_published . '</time>.';
                $html .= $formated_updated;
                $html .= '</div><div class="wm-article-flex-wrapper">';
                $html .= '<div class="wm-article-password">' . $raw_html . '</div>';
                $html .= '</div></article>';
            }
            return $html;
        }

        public function get_home_page(){

            // Bring in the database class
            global $wpdb;

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

                echo $this->prep_articles_html( $post );
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
