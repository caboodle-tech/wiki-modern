<?php

if( !function_exists( 'wm_comment_pagination' ) ){

    function wm_comment_pagination(){

        /** Create $POST which replaces $_POST. */
        $POST = json_decode( str_replace( '\\', '', $_POST['data']), true );
        $options = $POST['options'];

        if( $options && count($options) == 4 ){

            $WM_POST_PAGE = new WM_post_page();

            // 0 => The post ID.
            // 1 => Number of comments to display.
            // 2 => How to sort comments.
            // 3 => Page number.
            $pagination = $WM_POST_PAGE->get_post_comment_pagination( $options[0], $options[2], $options[1] );

            $comments = $WM_POST_PAGE->get_post_comments( $options[0], $options[2], $options[1], $options[3] );

            echo $pagination . '||||' . $comments;
        }
        echo '';
        /** Close connection otherwise a 0 is added to our response. */
        exit;
    }
}
