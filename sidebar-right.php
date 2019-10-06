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

 // TODO: Don't load post image either when not on a post page.
 ?>
<aside id="wm-right-sidebar">
    <div class="wm-mobile-controls">
        <div class="wm-align-center" onclick="WikiModern.toggle('right-sidebar');">
            <div class="wm-control-btn wm-control-text-btn">
                <i class="far fa-times"></i> Close
            </div>
        </div>
    </div>
    <div id="wm-featured-image-container">
        <!--<img id="wm-featured-image" src="https://wikiwp.com/wp-content/uploads/dummyImage07-1600x2409.jpg">-->
    </div>
    <?php
        /** Show the post meta information only on actual post pages. */
        if ( !is_page() && is_singular() ){
            /** Reference the global class for Post pages. */
            global $WM_posts;

            // TODO: Change hard coded Post Information to site language.
    ?>
    <div class="wm-widget">
        <div class="wm-widget-title">
            Post Information
        </div>
        <div class="wm-widget-content">
            <table>
                <?php
                    // TODO: MOVES THESE TO THE NEW WM_page_html CLASS!
                    echo $WM_posts->get_html_dates();
                    echo $WM_posts->get_html_authors();
                    echo $WM_posts->get_html_categories();
                    echo $WM_posts->get_html_tags();
                ?>
            </table>
        </div>
    </div>
    <?php
        // Right sidebar widget area
        dynamic_sidebar( 'right_sidebar_widget' );

        // Close IF()
        }
    ?>
</aside>
