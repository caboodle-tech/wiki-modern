<?php
/**
 * The left sidebar for the Wiki Modern theme.
 *
 * Displays the left sidebar which is used as Wiki Modern's primary <header>.
 * Site navigation should go in this area. Users can add content to this area
 * with widgets.
 *
 * @package Wiki Modern Theme
 */
?>
<header id="wm-left-sidebar">
    <div class="wm-mobile-controls">
        <div class="wm-align-center" onclick="WikiModern.toggle('left-sidebar');">
            <div class="wm-control-btn wm-control-text-btn">
                <i class="far fa-times"></i> Close
            </div>
        </div>
    </div>
    <div id="wm-identity-container">
        <?php
            /** Show the sites logo if the user uploaded one. */
            if ( function_exists( 'the_custom_logo' ) ) {
                the_custom_logo();
            }
            /** Show the site title and tagline if not empty and set to show. */
            include('include/title-and-tag.php');
        ?>
    </div>
    <!-- Navigation -->
    <span class="wm-nav-separator" aria-hidden="true"></span>
    <nav id="wm-nav-container">
        <?php
            /*
            if ( has_nav_menu('primary') ){
                echo 'Primary Menu';
            } else {
                echo 'No main menu! Generate a simple default one and warn the user.';
                wp_nav_menu( array(
            		'theme_location' => 'primary',
            		'walker' => new wm_Walker()
            	 ) );
            }
            */
            wp_nav_menu( array( 'theme_location' => 'primary-menu' ) );
        ?>
        <!-- DELETE THIS EXAMPLE IN PRODUCTION -->
        <ul class="wm-nav">
            <li class="wm-active">
                <span class="wm-nav-item">Home</span>
            </li>
            <li>
                <span class="wm-nav-item">About Us</span>
                <ul>
                    <li>
                        <span class="wm-nav-item">Level 1</span>
                    </li>
                    <li>
                        <span class="wm-nav-item">Level 1</span>
                        <ul>
                            <li>
                                <span class="wm-nav-item">Level 2</span>
                            </li>
                            <li>
                                <span class="wm-nav-item">Level 2</span>
                            </li>
                            <li>
                                <span class="wm-nav-item">Level 2</span>
                                <ul>
                                    <li>
                                        <span class="wm-nav-item">Level 3</span>
                                    </li>
                                    <li>
                                        <span class="wm-nav-item">Level 3</span>
                                    </li>
                                    <li>
                                        <span class="wm-nav-item">Level 3</span>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <span class="wm-nav-item">Contact Us</span>
                    </li>
                </ul>
            </li>
            <li>
                <span class="wm-nav-item">Contact Us</span>
            </li>
        </ul>
    </nav>
    <span class="wm-nav-separator" aria-hidden="true"></span>
    <!-- WIDGETS: https://www.wpblog.com/how-to-add-custom-widget-area-to-wordpress-themes/ -->
</header>
