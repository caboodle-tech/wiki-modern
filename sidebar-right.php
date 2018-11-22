<?php
/**
 * The right sidebar for the Wiki Modern theme.
 *
 * Displays the right sidebar which is used as Wiki Modern's primary <aside>.
 * Used only on Post pages to show the posts meta infroamtion.
 * Users can add content to this area with widgets.
 *
 * @package Wiki Modern Theme
 */

/** Show the right sidebar only if on a Post page. */
if ( !is_page() && is_singular() ){
    /** Reference the global class for Post pages. */
    global $WM_posts;
?>
<aside id="wm-right-sidebar">
    <div id="wm-right-laptop-controls">
        <div id="wm-hide-right-laptop-btn" class="wm-control-btns">
            <i class="fas fa-times"></i> close
        </div>
    </div>
    <div id="wm-featured-image-container">
        <!--<img id="wm-featured-image" src="https://wikiwp.com/wp-content/uploads/dummyImage07-1600x2409.jpg">-->
    </div>
    <div class="wm-widget">
        <div class="wm-widget-title">
            Post Information
        </div>
        <div class="wm-widget-content">
            <table>
                <?php
                    echo $WM_posts->get_post_page_dates();
                    echo $WM_posts->get_post_page_authors();
                    echo $WM_posts->get_post_page_categories();
                    echo $WM_posts->get_post_page_tags();
                ?>
            </table>
        </div>
    </div>
</aside>
<?php
/** Close if. */
}
?>
