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
    <div id="wm-left-laptop-controls">
        <div id="wm-hide-left-laptop-btn" class="wm-control-btns">
            <i class="fas fa-times"></i> close
        </div>
    </div>
    <div id="wm-logo-container">
<?php
if ( function_exists( 'the_custom_logo' ) ) {
    the_custom_logo();
}
include('include/title-and-tag.php');
?>
    </div>
    <span class="wm-nav-separator" aria-hidden="true"></span>
    <nav id="wm-nav-container" role="navigation">
<?php
if (has_nav_menu('primary')){
    echo 'P';
} else {
    echo 'No main menu! Generate a simple default one and warn the user.';
    wp_nav_menu( array(
		'theme_location' => 'primary',
		'walker' => new wm_Walker()
	 ) );
}
?>
        <!-- wp_nav_menu(); -->
        <ul class="wm-nav">
            <li class="wm-active">
                <span class="wm-nav-item">Home</span>
            </li>
            <li>
                <span class="wm-nav-item">About Us</span>
                <ul>
                    <li>
                        <span class="wm-nav-item">Home</span>
                    </li>
                    <li>
                        <span class="wm-nav-item">About Us</span>
                        <ul>
                            <li>
                                <span class="wm-nav-item">Home</span>
                            </li>
                            <li>
                                <span class="wm-nav-item">About Us</span>
                            </li>
                            <li>
                                <span class="wm-nav-item">Contact Us</span>
                                <ul>
                                    <li>
                                        <span class="wm-nav-item">Home</span>
                                    </li>
                                    <li>
                                        <span class="wm-nav-item">About Us</span>
                                    </li>
                                    <li>
                                        <span class="wm-nav-item">Contact Us</span>
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
