<?php
if ( !class_exists( 'WM_page_html' ) ){

    /**
    * Responsible for all site pages, post or static page
    */
	class WM_page_html {

        public function __construct (){}

            private function prep_page_html( $post, $link_flag = true ){

                $title = get_the_title( $post->ID );
                $permalink = get_permalink( $post->ID );
                $raw_html = get_the_content( null, false, $post->ID );
                $published = $post->post_date;
                $updated = $post->post_modified;

                // TODO: CLEAN POST TITLE!!!!
                $html = '';

                if( $link_flag ){
                    // NOTE: We wrap the published datetime later
                    if( $published == $updated ){
                        $formated_published = date( get_option('date_format'), strtotime( $published ) );
                        $formated_updated = '';
                    } else {
                        $formated_published = date( get_option('date_format'), strtotime( $published ) );
                        $formated_updated = date( get_option('date_format'), strtotime( $updated ) );
                        $formated_updated = ' Last updated <time itemprop="dateModified" datetime="' . $updated . '">' . $formated_updated . '</time>.';
                    }
                }

                $raw_html = apply_filters('the_content', $raw_html );

                if( !post_password_required( $post->ID ) ){

                    // Capture all figure blocks
                    preg_match_all( '/(?:<figure.*?>(?:.*?|\n)*?<\/figure>)/', $raw_html, $figures );

                    // Process figure blocks and keep only video ones
                    if( !empty( $figures[0] ) ){
                        $replacment = [];
                        foreach( $figures[0] as $val ){
                            if( stripos( $val, 'wp-block-video' ) || stripos( $val, 'is-type-video' ) ){
                                array_push( $replacment, $val );
                            }
                        }
                        unset($val);
                        $figures = $replacment;
                    }

                    // Capture all images
                    preg_match_all( '/<img.*?>/', $raw_html, $images );

                    // Remove all <div> tags before proceeding; yes this tosses out anything inside divs
                    $raw_html = preg_replace( '/(?:<div.*?>(?:.*?|\n)*?<\/div>)/', '', $raw_html );

                    // Capture all paragraphs. NOTE: If a line starts with certain characters the opening <p> tag is not added
                    preg_match_all( '/(?:<p.*?>(?:.*?|\n)*?<\/p>)/', $raw_html, $paragraphs );

                    // If at least one paragraph was found process it
                    if( count( $paragraphs[0] ) > 0 ){

                        // We will process and show up to 3 paragraphs
                        $counter = 0;
                        $raw_html = '';

                        foreach( $paragraphs[0] as $key => $val ){
                            if( $counter < 3 ){
                                // Add the missing opening <p> tag if needed
                                $val = trim( $val );
                                if( substr( $val, 0, 2 ) != '<p' ){
                                    $val = '<p>' . $val;
                                }
                                // Add this paragraph to the HTML to output
                                $raw_html .= $val;
                                $counter++;
                            } else {
                                break;
                            }
                        }
                        unset($val);

                    } else {
                        // TODO: Fix this. There are no paragraphs to this post! Show something to the user
                        $raw_html = 'This post is missing an introduction.';
                    }

                    //Kint::dump($raw_html);

                    // Remove all references to images and figures
                    $raw_html = preg_replace( '/(<figure(.+\n.+|.)+<\/figure>)/', '', $raw_html );
                    $raw_html = preg_replace( '/<img.*?>/', '', $raw_html );

                    $html = '<article class="wm-article" id="post-' . $post->ID . '"><h1 class="wm-article-title"><a href="' . $permalink . '">' . $title . '</a></h1>';
                    $html .= '<div class="wm-article-times">Published <time itemprop="datePublished" datetime="' . $published . '">' . $formated_published . '</time>.';
                    $html .= $formated_updated;
                    $html .= '</div><div class="wm-article-flex-wrapper">';

                    if( !empty( $figures[0] ) ){

                        $image_html = '<div class="wm-artilce-image wm-pointer">' . $figures[0] . '</div>';

                        $html .= '<div class="wm-article-image-wrapper">' . $image_html . '</div>';
                        $html .= '<div class="wm-article-content" onclick="WikiModern.navigate();" data-wm-navigation="' . $permalink . '">' . $raw_html . '</div>';

                    } elseif( count( $images[0] ) > 0 ){

                        $image_html = '<div class="wm-artilce-image wm-pointer" onclick="WikiModern.toggle(\'image-carousel\')">' . $images[0][0];
                        $image_html .= '</div><div class="wm-image-sources"><!--';
                        foreach( $images[0] as $image ){
                            $image_html .= $image .'||';
                        }
                        $image_html = substr( $image_html, 0, -2 );
                        $image_html .= '--></div>';

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

        /**
        * Build the HTML for a static website page
        *
        * @return string The HTML for the requested page.
        */
        public function get_static_page(){

            global $wp_query;

            $post = $wp_query->posts[0];

            if( !post_password_required( $post->ID ) ){

                setup_postdata( $post );

                $title = get_the_title( $post->ID );
                $raw_html = get_the_content( null, false, $post->ID );

                $html = '<article class="wm-article" id="post-' . $post->ID . '"><h1 class="wm-article-title">' . $title . '</h1>';
                $html .= apply_filters('the_content', $raw_html );
                $html .= '</article>';

            } else {
                // Page needs password
                $html = 'Page needs password';
            }

            return $html;
        }

        public function get_404_page(){
            $html = '<article class="wm-article" id="page-404"><h1 class="wm-article-title">404 - Page Not Found</h1>';
            $html .= '<h2 class="wm-article-title">Uh oh.</h2><p>The content you requested could not be found. You can try searching with the search bar above or go back to the <a href="' . get_home_url() . '">home page</a>.</p>';
            $html .= '</article>';

            return $html;
        }

        public function get_result_page(){

            global $wp_query;

            $pagination = new wm_pagination();

            $html = $pagination->get_top();

            foreach( $wp_query->posts as $post ){

                setup_postdata( $post );

                $html .= $this->prep_page_html( $post );
            }

            $html .= $pagination->get_bottom();

            return $html;
        }

        public function get_post_page(){

            global $WM_posts;

            // TODO: PULL IN ALL THE $WM_posts FUNCTIONS AND DELETE THAT CLASS

            $d = $WM_posts->get_raw_dates();
            $published = date_create_from_format( get_option('date_format'), $d[0] );
            $published = $published->format('Y-m-d') . ' 00:00';

            $html = '<article class="wm-article-content"><div id="wm-article-header"><div id="wm-article-header-left"><div class="wm-article-title">';
            $html .= $WM_posts->get_html_title();
            $html .= '</div><div class="wm-article-meta"><div>Published <time datetime="' . $published . '" title="published">' . $d[0] . '</time>.';

            if( $d[1] ){
                $updated = date_create_from_format( get_option('date_format'), $d[1] );
                $updated = $updated->format('Y-m-d') . ' 00:00';

                $html .= ' Updated <time datetime="' . $updated . '" title="updated">' . $d[1] . '</time>.';
            }

            $html .= '</div>';
            $html .= $WM_posts->get_html_meta_authors();
            $html .= '</div></div><div id="wm-article-header-right"><canvas id="wm-article-qrcode"></canvas></div></div>';
            $html .= $WM_posts->get_content();
            $html .= '</article>';

            return $html;
        }
    }
}


?>
