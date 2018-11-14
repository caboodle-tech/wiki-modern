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
    global $WM_POST_PAGE;
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
                    echo $WM_POST_PAGE->get_post_dates();
                    echo $WM_POST_PAGE->get_post_authors();
                    echo $WM_POST_PAGE->get_post_categories();
                    echo $WM_POST_PAGE->get_post_tags();
                ?>
            </table>
        </div>
    </div>
</aside>
<?php
/** Close if. */
}
?>
