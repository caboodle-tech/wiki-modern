<?php
// Are we in a position that we can and should show a page?
if ( is_main_query() ) {

    // Pull in pagination class
    $pagination = new WM_pagination();

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

        $pagination->show_top();

        $WM_page->get_page();

        $pagination->show_bottom();
        //echo wm_pagination('bottom');
    } else {

        // Show Static Front page if set.
        if ( is_front_page() ) {
            echo 'Front Page (Static Home Page)<br><br>';
        }
    }

    // Show Archive / Category page but NOT the Search page.
    if ( is_archive() && !is_search() ) {
        echo 'Archive / Category Page<br>';

        //Kint::dump( $wp_query );
        echo wm_pagination( 'top' );

        echo 'Page';

        echo wm_pagination( 'bottom' );

        // NOTE: Just use the same URL that was requested and append or change page to page # you need
        //
        // ??? get current URL
        // $wp_query->requested            => The raw SQL used to display this whole search. Limit is used to only pull in that many post of X found.
        // $wp_query->found_posts          => Number of posts found (published and protected posts)
        // $wp_query->max_number_pages     => How many pages needed to show all post (pagination pages)
    }

    // Show the Search page.
    if ( is_search() ) {
        //'Search Page<br>';
        $pagination->show_top();

        $WM_page->get_page();

        $pagination->show_bottom();
    }

    // Show the requested Website page.
    if( is_page() ){
        echo "[[Website Page.]]<br>";
        echo $WM_posts->get_html_title();
        echo $WM_posts->get_content();
    }

    // Show the requested Post page.
    if ( is_singular() ) {
        get_search_form();
        // TODO TODO TODO
        // REDO THIS SECTION TO USE get_post() no need for all the extra work
        //     Kint::dump(get_post());

        //echo '[[Post Page]]<br>';
        // $WM_posts have been called in already by the right sidebar
        // TODO: Move this check from the right sidebar code to the header???
        //KINT::dump( $WM_posts );
        //https://codex.wordpress.org/Template_Tags
        //https://codex.wordpress.org/Customizing_the_Read_More
        $d = $WM_posts->get_raw_dates();
?>
    <article class="wm-article-content">
        <div id="wm-article-header">
            <div id="wm-article-header-left">
                <div class="wm-article-title">
<?php
                    echo $WM_posts->get_html_title();
?>
                </div>
                <div class="wm-article-meta">
<?php
    $published = date_create_from_format( get_option('date_format'), $d[0] );
    $published = $published->format('Y-m-d') . ' 00:00';


    $html = '<div>Published <time datetime="' . $published . '" title="published">' . $d[0] . '</time>.';

    if( $d[1] ){
        $updated = date_create_from_format( get_option('date_format'), $d[1] );
        $updated = $updated->format('Y-m-d') . ' 00:00';

        $html .= ' Updated <time datetime="' . $updated . '" title="updated">' . $d[1] . '</time>.';
    }

    echo $html . '</div>';
    echo $WM_posts->get_html_meta_authors();
?>
                </div>
            </div>
            <div id="wm-article-header-right">
                <canvas id="wm-article-qrcode"></canvas>
            </div>
        </div>
<?php
    echo $WM_posts->get_content();
?>
    </article>
<?php
    }
}
?>
