<?php
/**
* Load the pages header.
* File: header.php
*/
get_header();

// TODO: ADD post_password_required check to block viewing locked post without password.
// Make sure the sidebar doesn't load anything either except maybe widgets?

/** Hidden divs used to calculate the browsers scrollbar width. */
?>
<div id="wm-scrollbar-check-outter">
    <div id="wm-scrollbar-check-inner">
    </div>
</div>
<div id="wm-content-outter-wrapper">
    <div id="wm-content-inner-wrapper">
        <header id="wm-top-controls">
            <div class="wm-top-row">
                <div class="wm-left-column">
                    <div class="wm-control-btn" aria-label="Toggle left sidebar: Navigation" onclick="WikiModern.toggle('left-sidebar');">
                        <i class="fas fa-bars"></i>
                    </div>
                    <div class="wm-control-btn wm-control-for-page" aria-label="Open Print Application" onclick="WikiModern.toggle('print-app');">
                        <i class="fas fa-print"></i>
                    </div>
                </div>
                <div class="wm-middle-column">
                    <div class="wm-search-wrapper">
                        <input type="text" placeholder="Search" aria-label="Search">
                        <div class="wm-search-btn" aria-label="Run Search Button">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>
                </div>
                <div class="wm-right-column">
                    <div class="wm-control-btn" aria-label="Toggle right sidebar: Aside information" onclick="WikiModern.toggle('right-sidebar');">
                        <i class="fas fa-info-circle"></i>
                    </div>
                </div>
            </div>
            <div class="wm-bottom-row">
                <div class="wm-left-column">
                    <div class="wm-control-btn" aria-label="Open Print Application" onclick="WikiModern.toggle('print-app');">
                        <i class="fas fa-print"></i>
                    </div>
                </div>
                <div class="wm-middle-column">
                    <div class="wm-control-btn wm-control-text-btn wm-float-left" aria-label="Open Article" onclick="WikiModern.toggle('show-article');">
                        <i class="fas fa-newspaper"></i> Article
                    </div>
                    <div class="wm-control-btn wm-control-text-btn wm-float-right" aria-label="Open Comments" onclick="WikiModern.toggle('show-comments');">
                        <i class="fas fa-comments"></i> Comments
                    </div>
                </div>
                <div class="wm-right-column">
                    <div class="wm-control-btn" aria-label="Toggle Reading Mode: Hides or shows sidebars" onclick="WikiModern.toggle('reading-mode');">
                        <i class="fab fa-readme"></i>
                    </div>
                </div>
            </div>
        </header>
        <main id="wm-main-content">
            <div id="wm-article-container">
                <?php require( 'page-manager.php'); ?>
            </div>
            <div id="wm-comment-container">
                Comments
            </div>
        </main>
        <footer id="wm-bottom-controls">
            <div class="wm-top-row">
                <div class="wm-left-column">
                    <?php
                        $next_post = get_next_post();
                        if (!empty( $next_post )){
                            $next_post = get_permalink( $next_post->ID );
                    ?>
                    <div class="wm-control-btn wm-control-text-btn wm-float-left" aria-label="Next Article">
                        <a href="<?php echo $next_post; ?>"><i class="fas fa-angle-left wm-bump-btn-icon"></i> Next</a>
                    </div>
                    <?php
                        }
                    ?>
                </div>
                <div class="wm-middle-column">
                    <div class="wm-control-btn wm-control-text-btn wm-float-left" aria-label="Open Article" onclick="WikiModern.toggle('bottom-show-article');">
                        <i class="fas fa-newspaper"></i> Article
                    </div>
                    <div class="wm-control-btn wm-control-text-btn wm-float-right" aria-label="Open Comments" onclick="WikiModern.toggle('bottom-show-comments');">
                        <i class="fas fa-comments"></i> Comments
                    </div>
                </div>
                <div class="wm-right-column">
                    <?php
                        $previous_post = get_previous_post();
                        if (!empty( $previous_post )){
                            $previous_post = get_permalink( $previous_post->ID );
                    ?>
                    <div class="wm-control-btn wm-control-text-btn wm-float-right" aria-label="Previous Article">
                        <a href="<?php echo $previous_post; ?>">Previous <i class="fas fa-angle-right wm-bump-btn-icon"></i></a>
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </footer>
    </div>
    <?php
        /**
        * Load the pages left (site navigation & widgets) sidebar.
        * File: sidebar-left.php
        */
        get_sidebar('left');

        /**
        * Load the pages right (Post meta & widgets) sidebar.
        * File: sidebar-right.php
        */
        get_sidebar('right');
    ?>
</div>
<?php
    /**
    * Load the pages footer.
    * File: footer.php
    */
    get_footer();
?>
<div id="wm-image-carousel">
    <div class="wm-control-btn wm-close" onclick="WikiModern.toggle('image-carousel');">
        <i class="fas fa-times"></i>
    </div>
    <div class="wm-control-btn" onclick="WikiModern.carouselRotate('left');">
        <i class="fas fa-angle-left"></i>
    </div>
    <div id="wm-image-stage">
    </div>
    <div class="wm-control-btn" onclick="WikiModern.carouselRotate('right');">
        <i class="fas fa-angle-right"></i>
    </div>
</div>
<div id="wm-print-wrapper">
    <div class="wm-control-btn" onclick="WikiModern.toggle('print-app');">
        <i class="fas fa-times"></i>
    </div>
</div>
<!-- Record the root URL to the theme directory for WikiModern.js -->
<div id="wm-template-directory" data-wm-template-directory="<?php echo get_template_directory_uri(); ?>" style="display:none;"></div>
<!-- Load scripts and close the page. -->
<?php wp_footer(); ?>
</body>
</html>
