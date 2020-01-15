<?php
/**
 * The header for the Wiki Modern theme.
 *
 * Displays all of the <head> section starting from the <!doctype html> tag down
 * to the <body> tag.
 *
 * @package Wiki Modern Theme
 */

// [TODO][BP20F4843] Change language to the sites language.
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title('|', true, 'right'); ?></title>
    <?php wp_head(); ?>
</head>
<?php
/** Output the correct body tag for the page. */
if( is_single() ){
    /** This is a post (article) page. */
    echo '<body id="wm-page-wrapper" role="main">';
    global $WM_posts;
} else {
    /** This is an actual website page. */
    echo '<body id="wm-page-wrapper" class="wm-page" role="main">';
}
?>
