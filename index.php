<?php
/**
* Load the pages header.
* File: header.php
*/
get_header();

// TODO: ADD post_password_required check to block viewing locked post without password.
// Make sure the sidebar doesn't load anything either except maybe the widget?

/** Output the correct #wm-wrapper div for our page. */
if( !is_page() && is_singular() ){
    /** This is a Post page. */
    echo '<div id="wm-wrapper" class="wm-post" role="main" data-wm-page="false">';
    global $WM_POST_PAGE;
} else {
    /** This is an actual website Page. */
    echo '<div id="wm-wrapper" class="wm-page" role="main" data-wm-page="true">';
}

/**
* Load the pages left (Site navigation & widgets) sidebar.
* File: sidebar-left.php
*/
get_sidebar('left');
?>
        <main id="wm-page-content">
            <header id="wm-search-row">
                <div id="wm-hide-left-btn" class="wm-control-btns">
                    <i class="fas fa-bars"></i>
                </div>
                <div id="wm-search-wrapper">
                    <input id="wm-search" type="text" placeholder="Search"><div class="wm-search-icon"><i class="fas fa-search fa-flip-horizontal"></i></div>
                </div>
                <div id="wm-hide-right-btn" class="wm-control-btns">
                    <i class="fas fa-info-circle"></i>
                </div>
            </header>
            <header id="wm-contorls-row">
                <div id="wm-print-btn" class="wm-control-btns">
                    <i class="fas fa-print"></i>
                </div>
                <div class="wm-contorls-wrapper">
                    <div id="wm-toggle-article-top-btn" class="wm-article-btn wm-control-btns wm-active">
                        <i class="far fa-newspaper"></i><span class="wm-mobile-hide"> article<span>
                    </div>
                    <div id="wm-toggle-comments-top-btn" class="wm-comments-btn wm-control-btns">
                        <i class="far fa-comments"></i><span class="wm-mobile-hide"> comments</span>
                    </div>
                </div>
                <div id="wm-reading-btn" class="wm-control-btns">
                    <i class="fas fa-book-reader"></i>
                </div>
            </header>
            <article id="wm-post-container">
                <?php echo $WM_POST_PAGE->get_post_title(); ?>
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
the_content();
endwhile; else: ?>
<p>Sorry, no posts matched your criteria.</p>
<?php endif; ?>
                <?php
                    //$post = get_post();
                    //echo $post->post_content;
                ?>
            </article>
            <section id="wm-comments-container">
                <?php
                    if( !is_page() && is_singular() ){
                        echo $WM_POST_PAGE->get_post_title();
                        $pagination = $WM_POST_PAGE->get_post_comment_pagination();
                        echo $pagination;
                        echo $WM_POST_PAGE->get_post_comments();
                        echo $pagination;
                        echo $WM_POST_PAGE->get_post_comment_form();
                    }
                ?>
            </section>
            <footer id="wm-article-footer">
                <div id="wm-next-post-btn" class="wm-control-btns">
                    <i class="fas fa-angle-left wm-larger-icon"></i><span class="wm-mobile-hide"> Next</span>
                </div>
                <div class="wm-contorls-wrapper">
                    <div id="wm-toggle-article-bottom-btn" class="wm-article-btn wm-control-btns wm-active">
                        <i class="far fa-newspaper"></i><span class="wm-mobile-hide"> article</span>
                    </div>
                    <div id="wm-toggle-comments-bottom-btn" class="wm-comments-btn wm-control-btns">
                        <i class="far fa-comments"></i><span class="wm-mobile-hide"> comments</span>
                    </div>
                </div>
                <div id="wm-previous-post-btn" class="wm-control-btns">
                    <span class="wm-mobile-hide">Previous </span><i class="fas fa-angle-right wm-larger-icon"></i>
                </div>
            </footer>
        </main>
<?php
/**
* Load the pages right (Post meta & widgets) sidebar.
* File: sidebar-right.php
*/
get_sidebar('right');

/**
* Load the pages footer.
* File: footer.php
*/
get_footer();
?>
