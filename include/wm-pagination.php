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

        $pagination .= '<div class="wm-pagination-column wm-center"><i class="fas fa-newspaper wm-link"></i> ' . wm_inline_dropdown( 'wm_post_limit', $wp_query->post_count, 10, 50, $reverse );

        if( $wp_query->found_posts == 1 ){
            $pagination .= ' post showing.</div>';
        } else {
            $pagination .= ' posts showing.</div>';
        }

        $pagination .= '<div class="wm-pagination-column wm-right"><i class="fas fa-file-alt wm-link"></i> Page ' . wm_inline_dropdown( 'wm_view_page', $current_page, 1, $max_page, $reverse ) . ' of ' . $max_page . '.</div></div>';

        echo $pagination;
    }
}
?>
