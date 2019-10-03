<?php
if ( !class_exists( 'WM_pagination' ) ){

    /**
    * Responsible for pagination
    */
	class WM_pagination {

        private $ready = false;
        private $links = null;
        private $post_count = 0;
        private $post_found = 0;
        private $current_page = 1;
        private $max_page = 1;
        private $sort_by = null;

        public function __construct (){}

        private function get_result_html(){
            $html = '<div class="wm-pagination-column wm-center"><i class="fas fa-poll wm-link"></i> ' . $this->post_found . ' results. ';

            if( $this->sort_by == 'newest' ){
                $html .= '<span class="wm-inline-dropdown wm-dropdown-closed" data-wm-dropdown="closed" onclick="WikiModern.dropdown();">';
                $html .= 'Newest<ul class="wm-inline-options" data-wm-cookie-name="wm_pagination_sort">';
                $html .= '<li onclick="WikiModern.dropdown();" data-wm-show-value="oldest">Oldest</li>';
            } else {
                $html .= '<span class="wm-inline-dropdown wm-dropdown-closed" data-wm-dropdown="closed" onclick="WikiModern.dropdown();">';
                $html .= 'Oldest<ul class="wm-inline-options" data-wm-cookie-name="wm_pagination_sort">';
                $html .= '<li onclick="WikiModern.dropdown();" data-wm-show-value="newest">Newest</li>';
            }

            $html .= '</ul></span> first.</div>';

            return $html;
        }

        private function get_ready(){

            global $wp_query;

            $links = paginate_links( ['type' => 'array', 'prev_next' => false, 'show_all' => false, 'mid_size' => 5] );

            if( isset( $links ) ){
                foreach( $links as $key => $value ){

                    // Is this actually a link or the current page HTML?
                    if( strpos( $value, '</a>') !== false ){

                        // Try to pull a URL out
                        preg_match( '/href=(["\'])([^\1]*)\1/i', $value, $matches );
                        if( isset( $matches[2] ) ){
                            $links[ $key ] = $matches[2];
                            // Restart loop so we don't NULL this index out
                            continue;
                        }
                    }

                    // Anything not actually a link should be ignored
                    $links[ $key ] = NULL;
                }
                unset( $value );
                // Update the class value
                $this->links = $links;
            }

            $current_page = $wp_query->query_vars['paged'];
            if( $current_page < 1 ){ $current_page = 1; }
            $this->current_page = $current_page;

            $max_page = $wp_query->max_num_pages;
            if( $max_page < 1 ){ $max_page = 1; }
            $this->max_page = $max_page;

            $this->post_count = $wp_query->post_count;

            $this->post_found = $wp_query->found_posts;

            $this->sort_by = $_COOKIE['wm_pagination_sort'];
            if( empty( $this->sort_by ) ){
                $this->sort_by = 'newest';
            }

            $this->ready = true;
        }

        private function get_limit_html( $reverse ){
            $html = '<div class="wm-pagination-column wm-center"><i class="fas fa-newspaper wm-link"></i> ';
            $html .= '<span class="wm-inline-dropdown wm-dropdown-closed" data-wm-dropdown="closed" onclick="WikiModern.dropdown();">';
            $html .= $this->post_count . '<ul class="wm-inline-options" data-wm-cookie-name="wm_pagination_limit">';

            if( $reverse ){
                for( $x = 50; $x > 0; $x -=10 ){
                    if( $x != $this->post_count ){
                        $html .= '<li onclick="WikiModern.dropdown();" data-wm-show-value="' . $x . '">' . $x . '</li>';
                    }
                }
            } else {
                for( $x = 10; $x < 60; $x +=10 ){
                    if( $x != $this->post_count ){
                        $html .= '<li onclick="WikiModern.dropdown();" data-wm-show-value="' . $x . '">' . $x . '</li>';
                    }
                }
            }

            $html .= '</ul></span> posts showing.</div>';

            return $html;
        }

        private function get_page_html( $reverse ){

            $html = '<div class="wm-pagination-column wm-left"><i class="fas fa-file-alt wm-link"></i> Page ';
            $html .= '<span class="wm-inline-dropdown wm-dropdown-closed" data-wm-dropdown="closed" onclick="WikiModern.dropdown();">';
            $html .= $this->current_page . '<ul class="wm-inline-options" data-wm-cookie-name="wm_pagination_page">';

            if( $this->max_page > 10 ){

                if( $reverse ){

                    $min = $this->current_page - 6;
                    if( $min < 1 ){ $min = 1; }

                    $max = $this->current_page + 5;
                    if( $max > $this->max_page ){
                        $max = $this->max_page;
                    }

                    for( $x = $max; $x > $min; $x-- ){
                        if( $x != $this->current_page ){
                            if( isset( $this->links[ $x - 1 ] ) ){
                                $html .= '<li onclick="WikiModern.dropdown();" data-wm-link-value="' . $this->links[ $x - 1 ] . '">' . $x . '</li>';
                            } else {
                                $html .= '<li onclick="WikiModern.dropdown();" data-wm-show-value="' . $x . '">' . $x . '</li>';
                            }
                        }
                    }

                    // Stop bug where page 1 is not shown when current page is to clase to 0
                    if( $x == 1 ){
                        $html .= '<li onclick="WikiModern.dropdown();" data-wm-show-value="1">1</li>';
                    }
                } else {

                    $min = $this->current_page - 5;
                    if( $min < 1 ){ $min = 1; }

                    $max = $this->current_page + 6;
                    if( $max > $this->max_page ){
                        $max = $this->max_page;
                    }

                    for( $x = $min; $x < $max; $x++ ){
                        if( $x != $this->current_page ){
                            if( isset( $this->links[ $x - 1 ] ) ){
                                $html .= '<li onclick="WikiModern.dropdown();" data-wm-link-value="' . $this->links[ $x - 1 ] . '">' . $x . '</li>';
                            } else {
                                $html .= '<li onclick="WikiModern.dropdown();" data-wm-show-value="' . $x . '">' . $x . '</li>';
                            }
                        }
                    }
                }
            } else {

                if( $reverse ){
                    for( $x = $this->max_page; $x > 0; $x -= 1 ){
                        if( $x != $this->current_page ){
                            if( isset( $this->links[ $x - 1 ] ) ){
                                $html .= '<li onclick="WikiModern.dropdown();" data-wm-link-value="' . $this->links[ $x - 1 ] . '">' . $x . '</li>';
                            } else {
                                $html .= '<li onclick="WikiModern.dropdown();" data-wm-show-value="' . $x . '">' . $x . '</li>';
                            }
                        }
                    }
                } else {
                    for( $x = 1; $x <= $this->max_page; $x += 1 ){
                        if( $x != $this->current_page ){
                            if( isset( $this->links[ $x - 1 ] ) ){
                                $html .= '<li onclick="WikiModern.dropdown();" data-wm-link-value="' . $this->links[ $x - 1 ] . '">' . $x . '</li>';
                            } else {
                                $html .= '<li onclick="WikiModern.dropdown();" data-wm-show-value="' . $x . '">' . $x . '</li>';
                            }
                        }
                    }
                }
            }

            $html .= '</ul></span> of ' . $this->max_page . '.</div>';

            return $html;
        }

        public function get_html( $position = 'top' ){

            // Make sure we have the information we need
            if( !$this->ready ){ $this->get_ready(); }

            // Do not make a bottom control for a single page of results
            if( $this->max_page == 1 && $position == 'bottom' ){
                return '';
            }

            // Set reverse flag
            $reverse = false;
            if( $position == 'bottom' ){ $reverse = true; }

            $html = '<div class="wm-pagination wm-position-' . $position . '">';
            $html .= $this->get_page_html( $reverse );
            $html .= $this->get_result_html( $reverse );
            $html .= $this->get_limit_html( $reverse );
            $html .= '</div>';

            return $html;
        }

        public function show_bottom(){
            echo $this->get_html('bottom');
        }

        public function show_top(){
            echo $this->get_html('top');
        }
    }
}
