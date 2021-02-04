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
<footer class="wm-row wm-footer">
    <?php
        // Display the amount of columns the user seleted in the customizer
        $columns = intval( get_theme_mod( 'wm_footer_column_count' ) );
        for ( $number = 1; $number <= $columns; $number++ ) {

            // Get the text alignment setting for this column
            $align = get_theme_mod( 'wm_col' . $number . '_alignment' );
            if ( $align === 'centered' ) {
                $align = 'center';
            }

            // Output the correct HTML and content for this column
            echo '<div id="wm-column-' . esc_attr( $number ) . '" class="wm-column wm-align-' . esc_attr( $align ) . '">';
            dynamic_sidebar( 'col' . esc_html( $number ) . '_footer_widget' );
            echo '</div>';
        }

        // Build variables for footer.
        $established_year = get_theme_mod( 'wm_establishment_year' );
        if ( ! empty( $established_year ) ) {
            $established_year .= ' &ndash; ';
        } else {
            $established_year = '';
        }
        $current_year = gmdate( 'Y' );

        $business = get_bloginfo( 'name' );
        if ( ! empty( $business ) ) {
            if ( $business[ strlen( $business ) - 1 ] !== '.' ) {
                $business .= '.';
            }
            $business = ' ' . $business;
        } else {
            $business = '.';
        }
    ?>
    <div id="wm-copyright">
        <svg class="wm-copyright-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm0 15.781c-2.084 0-3.781-1.696-3.781-3.781s1.696-3.781 3.781-3.781c1.172 0 2.306.523 3.136 1.669l1.857-1.218c-1.281-1.826-3.133-2.67-4.993-2.67-3.308 0-6 2.692-6 6s2.691 6 6 6c1.881 0 3.724-.859 4.994-2.67l-1.857-1.218c-.828 1.14-1.959 1.669-3.137 1.669z"/></svg> <?php echo esc_html( $established_year . $current_year . $business ); ?> All Rights Reserved.
        <div class="wm-mobile-break"></div>
        Powered by <a href="https://wordpress.org/" target="_blank" rel="nofollow noopener noreferrer"><svg class="wm-worpress-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M2.597 7.81l4.911 13.454c-3.434-1.668-5.802-5.19-5.802-9.264 0-1.493.32-2.91.891-4.19zm16.352 3.67c0-1.272-.457-2.153-.849-2.839-.521-.849-1.011-1.566-1.011-2.415 0-.978.747-1.88 1.862-1.819-1.831-1.677-4.271-2.701-6.951-2.701-3.596 0-6.76 1.845-8.601 4.64.625.02 1.489.032 3.406-.118.555-.034.62.782.066.847 0 0-.558.065-1.178.098l3.749 11.15 2.253-6.756-1.604-4.394c-.555-.033-1.08-.098-1.08-.098-.555-.033-.49-.881.065-.848 2.212.17 3.271.171 5.455 0 .555-.033.621.783.066.848 0 0-.559.065-1.178.098l3.72 11.065 1.027-3.431c.444-1.423.783-2.446.783-3.327zm-6.768 1.42l-3.089 8.975c.922.271 1.898.419 2.908.419 1.199 0 2.349-.207 3.418-.583-.086-.139-3.181-8.657-3.237-8.811zm8.852-5.839c.224 1.651-.099 3.208-.713 4.746l-3.145 9.091c3.061-1.784 5.119-5.1 5.119-8.898 0-1.79-.457-3.473-1.261-4.939zm2.967 4.939c0 6.617-5.384 12-12 12s-12-5.383-12-12 5.383-12 12-12 12 5.383 12 12zm-.55 0c0-6.313-5.137-11.45-11.45-11.45s-11.45 5.137-11.45 11.45 5.137 11.45 11.45 11.45 11.45-5.137 11.45-11.45z"/></svg></a> with the <a href="https://github.com/caboodle-tech/wiki-modern" target="_blank" rel="nofollow noopener noreferrer">Wiki Modern Theme</a>.
    </div>
<?php
/*
var_dump( count( get_declared_classes() ) );
foreach ( get_declared_classes() as $cls ) {
    echo "$cls<br>";
}
*/
?>
</footer>
<!-- Load scripts and close the page. -->
<?php wp_footer(); ?>
</body>
</html>
