<?php
if ( !class_exists( 'WM_page_html' ) ){

    /**
    * Responsible for all site pages, post or static page
    */
	class WM_page_html {

        public function __construct (){}

        /**
        * Build the HTML for the 404 page
        *
        * @return string HTML for the page.
        */
        public function get_404_page(){

            $html = '<article class="wm-article" id="page-404"><h1 class="wm-article-title">404 - Page Not Found</h1>';
            $html .= '<h2 class="wm-article-title">Uh oh.</h2><p>The content you requested could not be found. You can try searching with the search bar above or go back to the <a href="' . get_home_url() . '">home page</a>.</p>';
            $html .= '</article>';

            return $html;
        }

        /**
        * Build the HTMl for the current results (posts) author
        *
        * @param WP_Post $post The current WordPress post object.
        */
        public function get_author_meta( $post ){
            $author = get_the_author_meta( 'display_name', $post->post_author );
            return '<div><span class="wm-title">Author:</span> ' . $author . '</div>';
        }

        /**
        * Return the HTML for the post or page title.
        *
        * @param string $title The current WordPress post object.
        * @param string $permalink The permalink to this post.
        * @param bool $disabled Is this a locked post.
        *
        * @return string The HTML for the post or page title.
        */
        public function get_html_title( $post, $link_flag = true ){

            if( post_password_required( $post->ID ) && $link_flag ){
                return '<h1 class="wm-article-title wm-link wm-disabled">' . apply_filters( 'protected_title_format', $post->post_title ) . '</h1>';
            } elseif( $link_flag ){
                return '<h1 class="wm-article-title wm-link"><a href="' . get_permalink( $post->ID ) . '">' . apply_filters( 'the_title', $post->post_title ) . '</a></h1>';
            } else {
                return '<h1 class="wm-article-title' . $disabled . '">' . apply_filters( 'the_title', $post->post_title ) . '</h1>';
            }
        }

        /**
        * Build the HTML for a post page
        *
        * @return string HTML for the page.
        */
        public function get_post_page(){

            global $wp_query;

            $post = $wp_query->posts[0];

            if( !post_password_required( $post->ID ) ){

                // TODO: PULL IN ALL THE $WM_posts FUNCTIONS AND DELETE THAT CLASS

                $dates = $this->get_raw_dates( $post->ID );
                $published = date_create_from_format( get_option('date_format'), $dates[0] );
                $published = $published->format('Y-m-d') . ' 00:00';

                $html = '<article class="wm-article-content"><div id="wm-article-header"><div id="wm-article-header-left"><div class="wm-article-title">';
                $html .= $this->get_html_title( $post, false);
                $html .= '</div><div class="wm-article-meta"><div>Published <time datetime="' . $published . '" title="published">' . $dates[0] . '</time>.';

                if( $dates[1] ){
                    $updated = date_create_from_format( get_option('date_format'), $dates[1] );
                    $updated = $updated->format('Y-m-d') . ' 00:00';

                    $html .= ' Updated <time datetime="' . $updated . '" title="updated">' . $dates[1] . '</time>.';
                }

                $html .= '</div>';
                $html .= $this->get_author_meta( $post );
                $html .= '</div></div><div id="wm-article-header-right"><canvas id="wm-article-qrcode"></canvas></div></div>';
                $html .= apply_filters( 'the_content', $post->post_content );
                $html .= '</article>';
            } else {
                $html = '<article class="wm-article" id="post-' . $post->ID . '">' . $this->get_html_title( $post, false);
                $html .= get_the_password_form( $post->ID );
                $html .= '</article>';
            }

            return $html;
        }

        /**
        * Return an array with the original and updated dates for this post.
        *
        * @param int $id (Optional) The ID of the post you want to gt the dates for.
        * @return array The original and updated dates for this post.
        */
        public function get_raw_dates( $id = null ){
            if( strtotime( get_the_date( null, $id ) ) < strtotime( get_the_modified_date( null, $id ) ) ){
                return [ get_the_date( null, $id ), get_the_modified_date( null, $id ) ];
            } else {
                return [ get_the_date( null, $id ), '' ];
            }
        }

        /**
        * Build the HTMl for any page showing multiple posts
        *
        * @return string HTML for the page.
        */
        public function get_result_page(){

            global $wp_query;

            $pagination = new wm_pagination();

            $html = $pagination->get_top();

            foreach( $wp_query->posts as $post ){

                setup_postdata( $post );

                $html .= $this->prep_result_html( $post );
            }

            $html .= $pagination->get_bottom();

            return $html;
        }

        /**
        * Build the HTML for a static website page
        *
        * @return string HTML for the page.
        */
        public function get_static_page(){

            global $wp_query;

            // Get initial page data
            $post = $wp_query->posts[0];
            setup_postdata( $post );
            $title = $this->get_html_title( $post, false );

            // Is this page locked?
            if( !post_password_required( $post->ID ) ){
                // No. The password has already been entered
                $raw_html = get_the_content( null, false, $post->ID );
                $html = '<article class="wm-article" id="post-' . $post->ID . '">' . $title;
                $html .= apply_filters('the_content', $raw_html );
                $html .= '</article>';
            } else {
                // Yes. The user needs to enter the password to this page
                $html = '<article class="wm-article" id="post-' . $post->ID . '">' . $title;
                $html .= get_the_password_form( $post->ID );
                $html .= '</article>';
            }

            return $html;
        }

        /**
        * Build the HTMl for the current result (post)
        *
        * @param WP_Post $post The current WordPress post object.
        */
        private function prep_result_html( $post ){

            $title = $this->get_html_title( $post, true );
            $permalink = get_permalink( $post->ID );
            $raw_html = get_the_content( null, false, $post->ID );
            $published = $post->post_date;
            $updated = $post->post_modified;

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

                $html = '<article class="wm-article" id="post-' . $post->ID . '">' . $title;
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
                $html = '<article class="wm-article" id="post-' . $post->ID . '">' . $title;
                $html .= '<div class="wm-article-times">Published <time itemprop="datePublished" datetime="' . $published . '">' . $formated_published . '</time>.';
                $html .= $formated_updated;
                $html .= '</div><div class="wm-article-flex-wrapper">';
                $html .= '<div class="wm-article-password">' . $raw_html . '</div>';
                $html .= '</div></article>';
            }
            return $html;
        }
    }
}
?>
