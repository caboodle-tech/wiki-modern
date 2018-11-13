<?php
if ( ! class_exists( 'WM_post_page' ) ){

	class WM_post_page {

        private $_aacp = false;

        public function __construct () {
            /** Check if the Wiki Modern Authors and Contributors plugin is active. */
        }

        public function get_post_authors() {

            $html = '<tr class="wm-widget-sub-title"><td>{{author-title}}:</td></tr>';

            /**
            * Display the authors section using Wiki Modern Authors and Contributors plugin
            * data or default to the standard WordPress Post author.
            */
            if( $this->_aacp ){
                /** Gather all authors. */

                /** Gather all co-authors. */

                /** Gather all contributors. */
            } else {
                /** Use default WordPress Post author. */
                $post = get_post();
                $author = get_the_author_meta( 'display_name', $post->post_author );
                $html .= '<tr class="wm-widget-info"><td>' . $author . '</td></tr>';
                /** Replace the author title to be singular. */
                $html = str_replace( '{{author-title}}', 'Author', $html );
            }

            return $html;
        }

        public function get_post_categories(){

            $html = '<tr class="wm-widget-sub-title"><td>{{categories-title}}:</td></tr><tr class="wm-widget-info"><td>';

            $categories = get_the_category();
            $output = '';
            foreach( $categories as $category ){
                $id = get_cat_ID( $category->name );
                $url =  get_category_link( $id );
                $output .= '<span class="wm-tags"><a href="' . $url . '">' . $category->name . '</a></span>, ';
            }

            if( count( $categories ) > 1 ){
                /** Replace the author title to be plural. */
                $html = str_replace( '{{categories-title}}', 'Categories', $html );
            } else {
                /** Replace the author title to be singular. */
                $html = str_replace( '{{categories-title}}', 'Category', $html );
            }
            $html .= substr( $output, 0, strlen( $output ) - 2 ) . '</td></tr>';
            return $html;
        }

        public function get_post_comments(){

            /**
            * Don't show anything if post is password protected and not unlocked.
            *
            * NOTE: The post page should have already been blocked from loading
            * this is just a fail safe in case someone is trying to bypass theme
            * block.
            */
            $html = '';
            if( !post_password_required() ){

                /** Is there comments to show? */
                if ( get_comments_number() > 0 ){
                    $post_id = get_post();

                    if( !empty($post_id->ID) ){
                        $per_page = 4;

                        $comments_query = new WP_Comment_Query;

                        /** How many top level comments are there? */
                        $args = array(
                            'count' => true,
                            'parent' => 0,
                            'post_id' => $post_id,
                            'status' => 'all'
                        );
                        $count = $comments_query->query( $args );

                        /** Build pagination if we need it. */
                        $pagination = '';
                        if( $count > $per_page ){
                            $pages = ceil( $count / $per_page );
                            $pagination .= '<div class="wm-pagination">Showing <form><select name=""><option value="50" selected>50</option><option value="75">75</option><option value="100">100</option><option value="125">125</option><option value="150">150</option></select></form> comments per page. <span class="wm-pagenation-page-numbers">Viewing page <form><select name="">';
                            for( $x = 1; $x <= $pages; $x++ ){
                                if( $x > 1 ){
                                    $pagination .= '<option value="' . $x . '">' . $x .'</option>';
                                } else {
                                    $pagination .= '<option value="' . $x . '" selected>' . $x .'</option>';
                                }
                            }
                            $pagination .= '</select></form> of ' . $pages . '.</span></div>';
                        }

                        $html .= $pagination;
                        $html .= wm_format_comments( $post_id->ID, 1, $per_page );
                        $html .= $pagination;

                    }
                }
            }
            return $html;
        }

        public function get_post_comment_form(){
            return wm_format_comment_form();
        }

        public function get_post_dates(){

            $html = '<tr class="wm-widget-sub-title"><td>Published:</td></tr><tr class="wm-widget-info"><td>';
            $html .= get_the_date() . '</td></tr>';

            if( strtotime( get_the_date() ) < strtotime( get_the_modified_date() ) ){
                $html .= '<tr class="wm-widget-sub-title"><td>Last Updated:</td></tr><tr class="wm-widget-info"><td>';
                $html .= get_the_modified_date() . '</td></tr>';
            }

            return $html;
        }

        public function get_post_tags(){

            $html = '<tr class="wm-widget-sub-title"><td>{{tag-title}}</td></tr><tr class="wm-widget-info"><td>';

            $tags = get_the_tags();

            if( $tags ){
                $output = '';
                foreach( $tags as $tag ){
                    $url = get_tag_link( $tag->term_id );
                    $output .= '<span class="wm-tags"><a href="' . $url . '">' . $tag->name . '</a></span>, ';
                }
                $html .= substr( $output, 0, strlen( $output ) - 2 ) . '</td></tr>';
                if( count( $tags ) > 1 ){
                    /** Replace the author title to be plural. */
                    $html = str_replace( '{{tag-title}}', 'Tags', $html );
                } else {
                    /** Replace the author title to be singular. */
                    $html = str_replace( '{{tag-title}}', 'Tag', $html );
                }
                return $html;
            }
            /** There was no tags found hide the whole Tag section. */
            return '';
        }

        public function get_post_title(){
            return '<h1>' . get_the_title() . '</h1>';
        }

    /** End Class. */
    }

}
