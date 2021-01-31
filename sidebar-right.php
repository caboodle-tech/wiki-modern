<?php
/**
 * The right sidebar for the Wiki Modern theme.
 *
 * Displays the left sidebar which is used as Wiki Modern's primary <header>.
 * Site navigation should go in this area. Users can add content to this area
 * with widgets.
 *
 * @package Wiki Modern Theme
 */

?>
<header class="wm-col wm-right-sidebar">
    <div class="wm-mobile-button">
        <div class="wm-close-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm4.597 17.954l-4.591-4.55-4.555 4.596-1.405-1.405 4.547-4.592-4.593-4.552 1.405-1.405 4.588 4.543 4.545-4.589 1.416 1.403-4.546 4.587 4.592 4.548-1.403 1.416z"/></svg>
        </div>
    </div>
    <div id="wm-logo-wrapper">
        <?php
            // Show the sites logo if the user uploaded one.
            if ( function_exists( 'the_custom_logo' ) ) {
                the_custom_logo();
            }
            // Show the site title and tagline if not empty and set to show.
            require 'include/wm-title-and-tag.php';
        ?>
        <!--
        <img id="wm-logo" src="https://via.placeholder.com/250x250">
        <div id="wm-business-name">
            Caboodle Tech Inc.
        </div>
        <div id="wm-business-tagline">
            Everything Technology &trade;
        </div>
-->
    </div>
    <nav id="wm-nav-wrapper">
        <ul>
            <li>
                <a href="">Test A</a>
            </li>
            <li>
                Test B
            </li>
            <li>
                Test C
            </li>
            <li>
                Test D
            </li>
        </ul>
    </nav>
    <div class="wm-module-area">
<?php
    // Load right sidebar widget area.
    dynamic_sidebar( 'right_sidebar_widget' );
?>
    </div>
    <div id="wm-dark-mode-wrapper">
        <div id="wm-dark-mode-toggle" title="Toggle dark mode">
            <label>
                <?php
                $checked = '';
                if ( DARK_MODE ) {
                    $checked = 'checked="checked"';
                }
                ?>
                <input type="checkbox" name="" <?php echo esc_attr( $checked ); ?>>
                <?php
                unset( $checked );
                ?>
                <span></span>
            </label>
        </div>
    </div>
</header>
