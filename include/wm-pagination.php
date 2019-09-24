<?php
if( !function_exists( 'wm_pagination' ) ){

    require( get_template_directory() . '/include/wm-inline-dropdown.php');

    function wm_pagination( $position ){

        global $wp_query;

        switch( strtolower($position) ){
            case 'top':
            case 'bottom':
                $position = 'wm-position-' . $position;
                break;
            default:
                $position = 'wm-position-bottom';
        }

        $reverse = false;
        if( $position == 'wm-position-bottom' ){
            $reverse = true;
        }

        // Get the pagination links but remove all the HTML code
        $links = paginate_links( ['type' => 'array', 'prev_next' => false, 'show_all' => true] );

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
        }

        $current_page = $wp_query->query_vars['paged'];
        if( $current_page < 1 ){ $current_page = 1; }

        $max_page = $wp_query->max_num_pages;
        if( $max_page < 1 ){ $max_page = 1; }

        // Do not make a bottom control for a single page or results
        if( $max_page == 1 && $position == 'wm-position-bottom' ){
            return '';
        }

        $pagination = '<div class="wm-pagination ' . $position . '"><div class="wm-pagination-column wm-left"><i class="fas fa-poll wm-link"></i> ' . $wp_query->found_posts;

        if( $wp_query->found_posts == 1 ){
            $pagination .= ' result.</div>';
        } else {
            $pagination .= ' results.</div>';
        }

        $pagination .= '<div class="wm-pagination-column wm-center"><i class="fas fa-newspaper wm-link"></i> ' . wm_inline_dropdown( 'wm_post_limit', $wp_query->post_count, 10, 50, $reverse, $links );

        if( $wp_query->found_posts == 1 ){
            $pagination .= ' post showing.</div>';
        } else {
            $pagination .= ' posts showing.</div>';
        }

        $pagination .= '<div class="wm-pagination-column wm-right"><i class="fas fa-file-alt wm-link"></i> Page ' . wm_inline_dropdown( 'wm_view_page', $current_page, 1, $max_page, $reverse, $links ) . ' of ' . $max_page . '.</div></div>';

        echo $pagination;
    }
}
?>
