<?php
// Are we in a position that we can and should show a page?
if ( is_main_query() ) {

    $stop_page_loading = false;

    // Show 404 page.
    if ( is_404() ) {

        echo '<pre style="text-align:center;">
        .o     .oooo.         .o
      .d88    d8P\'`Y8b      .d88
    .d\'888   888    888   .d\'888
  .d\'  888   888    888 .d\'  888
 88ooo888oo 888    888 88ooo888oo
       888   `88b  d88\'      888
      o888o   `Y8bd8P\'      o888o
</pre>';
    }

    // Show the default blog Home page with the latest posts.
    if ( is_home() ) {
        $WM_page_manager->get_home_page();
    } else {

        // Show Static Front page if set.
        if ( is_front_page() ) {
            echo 'Front Page (Static Home Page)<br><br>';
        }
    }

    // Show Archive / Category page but NOT the Search page.
    if ( is_archive() && !is_search() ) {
        echo 'Archive / Category Page<br>';
    }

    // Show the Search page.
    if ( is_search() ) {
        echo 'Search Page<br>';
    }

    // Show the requested Website page.
    if( is_page() ){
        echo "Website Page.";
        echo $WM_posts->get_post_title();
        echo $WM_posts->get_post_page_content();
    }

    // Show the requested Post page.
    if ( is_singular() ) {
        echo 'Post Page<br>';
        // $WM_posts have been called in already by the right sidebar
        // TODO: Move this check from the right sidebar code to the header???
        //KINT::dump( $WM_posts );
        //https://codex.wordpress.org/Template_Tags
        //https://codex.wordpress.org/Customizing_the_Read_More
        $d = $WM_posts->get_post_page_dates_raw();
?>
    <article class="wm-article-content">
        <div class="wm-article-title">
            <div class="wm-article-meta">
                <div>Published <time datetime=""><?php echo $d[0] ?></time>. (Updated <time datetime=""><?php echo $d[1] ?></time>)</div>
            </div>
<?php
        echo $WM_posts->get_post_title();
?>
        </div>
<?php
        echo $WM_posts->get_post_page_content();
?>
    </article>
<?php
    }
}
?>
