<?php
/**
* The footer for the Wiki Modern theme.
*
* Displays the pages footer section. NOTE: The main page (index.php) handles
* loading JavaScript files called in the footer of the theme and the closing
* <body> and <html> tag, not this file.
*
* @package Wiki Modern Theme
*/
?>
<div id="wm-footer-wrapper">
    <footer id="wm-footer">
        <?php
            // Display the amount of columns the user seleted in the customizer
            $columns = intval( get_theme_mod('wm_footer_column_count') );
            for( $number = 1; $number <= $columns; $number++ ){

                // Get the text alignment setting for this column
                $align = get_theme_mod('wm_col' . $number . '_alignment');
                if( $align == 'centered' ){ $align = 'center'; }

                // Output the correct HTML and content for this column
                echo '<div id="wm-footer-column-' . $number . '" class="wm-footer-column wm-align-' . $align . '">';
                dynamic_sidebar( 'col' . $number . '_footer_widget' );
                echo '</div>';
            }
        ?>
        <div class="wm-copyright wm-align-center">
            <?php
                $legal = get_option( 'wm-footer-legal-text', false );
                if( $legal == false ){
                    $legal = wm_auto_copyright() . ' ' . get_bloginfo('name');
                    if( substr( $legal, -1 ) != '.' ){
                        $legal .= '.';
                    }
                    $legal .= ' All Rights Reserved.';
                    update_option( 'wm-footer-legal-text', $legal );
                }
                echo $legal;
            ?>
            <br>
            Powered by <a href="https://wordpress.org/" target="_blank"><i class="fab fa-wordpress-simple"></i></a> with the <a href="https://github.com/caboodle-tech/wiki-modern" target="_blank">Wiki Modern Theme</a>.
        </div>
    </footer>
</div>
