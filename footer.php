<?php
/**
* The footer for the Wiki Modern theme.
*
* Displays the pages footer section followed by any JavaScript called in the
* footer of the theme and the closing <body> and <html> tag.
*
* @package Wiki Modern Theme
*/
?>
<div id="wm-footer-wrapper">
    <footer id="wm-footer">
        <?php
            $columns = intval( get_theme_mod('wm_footer_column_count') );
            for( $number = 1; $number <= $columns; $number++ ){
        ?>
                <div class="wm-footer-column">
                    <?php
                        dynamic_sidebar( 'col' . $number . '_footer_widget' );
                    ?>
                </div>
        <?php
            }
        ?>
        <div class="wm-copyright wm-align-center">
            <?php echo wm_auto_copyright() . ' ' .get_bloginfo('name'); ?>. All Rights Reserved.
            <br>
            Powered by <a href="#" target="_blank"><i class="fab fa-wordpress-simple"></i></a> with the <a href="#" target="_blank">Wiki Modern Theme</a>.
        </div>
    </footer>
</div>
