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
        <div id="wm-print-wrapper">
            <div id="wm-print-options">
                <div id="wm-print-controls">
                    <div class="wm-section-title">
                        Hide Document Parts:
                    </div>
                    <div class="wm-section">
                        <div class="wm-option" onclick="WikiModern.toggle('print-hide-images');">
                            <i class="fas fa-image wm-icon"></i>
                            <span class="wm-option-title">Images</span>
                        </div>
                        <div class="wm-option" onclick="WikiModern.toggle('print-hide-media');">
                            <i class="fas fa-film wm-icon"></i>&nbsp;&nbsp;<i class="fas fa-volume-up wm-icon"></i>
                            <span class="wm-option-title">Digital Media</span>
                        </div>
                        <div class="wm-option" onclick="WikiModern.toggle('print-hide-forms');">
                            <i class="fas fa-receipt wm-icon"></i>
                            <span class="wm-option-title">Forms</span>
                        </div>
                        <div class="wm-option" onclick="WikiModern.toggle('print-hide-qrcode');">
                            <i class="fas fa-qrcode wm-icon"></i>
                            <span class="wm-option-title">QR Code</span>
                        </div>
                    </div>
                </div>
                <div id="wm-print-output">
                    <div class="wm-section-title">
                        Output Options:
                    </div>
                    <div class="wm-section">
                        <div class="wm-option" onclick="WikiModern.toggle('print-page');">
                            <i class="fas fa-print wm-icon"></i> Print Document
                        </div>
                        <div class="wm-option" onclick="WikiModern.toggle('print-pdf');">
                            <i class="fas fa-file-pdf wm-icon"></i> Download PDF
                        </div>
                    </div>
                </div>
            </div>
            <div id="wm-print-exit" onclick="WikiModern.toggle('print-app');">
                <i class="fas fa-times wm-icon"></i>
            </div>
            <!--
            <div id="wm-print-close-btn" class="wm-control-btn" onclick="WikiModern.toggle('print-app');">
                <i class="fas fa-times"></i>
            </div>
            <div id="wm-print-controls">
                <div class="wm-section-title">Hide Document Parts:</div>
                <div id="wm-print-controls-hide-options">
                    <div class="wm-option" onclick="WikiModern.toggle('print-hide-images');">
                        <i class="fas fa-image wm-icon"></i>
                        <span class="wm-option-title">Images</span>
                    </div>
                    <div class="wm-option" onclick="WikiModern.toggle('print-hide-video');">
                        <i class="fas fa-film wm-icon"></i>
                        <span class="wm-option-title">Videos</span>
                    </div>
                    <div class="wm-option" onclick="WikiModern.toggle('print-hide-forms');">
                        <i class="fas fa-receipt wm-icon"></i>
                        <span class="wm-option-title">Forms</span>
                    </div>
                    <div class="wm-option">
                        <i class="fas fa-qrcode wm-icon" onclick="WikiModern.toggle('print-hide-qr');"></i>
                        <span class="wm-option-title">QR Code</span>
                    </div>
                </div>
                <div class="wm-section-title">Output Options:</div>
                <div id="wm-print-controls-output-options">
                    <div class="wm-option">
                        <i class="fas fa-print"></i> Print Document
                    </div>
                    <div class="wm-option">
                        <i class="fas fa-file-pdf"></i> Download PDF
                    </div>
                </div>
            </div>
            -->
        </div>
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
<?php
    $search_text = strip_tags( urldecode( get_query_var('s') ) );
?>
                        <input type="text" placeholder="Search" id="wm-search" aria-label="Search" value="<?php echo $search_text; ?>">
                        <div class="wm-search-btn" id="wm-search-button" aria-label="Run Search Button" onclick="WikiModern.search();">
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
            <?php require( 'page-manager.php'); ?>
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
<div id="wm-site-root" data-wm-template-directory="<?php echo get_site_url(); ?>" style="display:none;"></div>
<!-- Load scripts and close the page. -->
<?php wp_footer(); ?>
</body>
</html>
