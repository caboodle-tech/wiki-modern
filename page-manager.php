<?php
// Are we in a position that we can and should show a page?
if( is_main_query() ){

    $page_html = '<div id="wm-article-container">';
    $comment_html = '';

    // Determine what type of page load we are dealing with
    if( is_home() || is_archive() || is_search() ){
        // Show the sites home page of posts, an archive page of posts, or the search page with post results
        $page_html .= $WM_page_html->get_result_page();
    } elseif( is_front_page() || is_page() ){
        // Show the select page
        $page_html .= $WM_page_html->get_static_page();
    } elseif( is_singular() ){
        // Show the selected post
        $page_html .= $WM_page_html->get_post_page();

        // Build the comment html
        $comment_html = '<div id="wm-comment-container">';
        $comment_html .= 'Comments are currently disabled. Please check back later.';
        $comment_html .= '</div>';
    } else {
        // Nothing was triggered this must be a 404
        $page_html .= $WM_page_html->get_404_page();
    }

    // Show the complete page
    echo $page_html . '</div>' . $comment_html;
}
?>
