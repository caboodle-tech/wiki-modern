<?php
/**
 * Extend Wordpress's Walker Class
 *
 * This extends the Walker Class by building any navigation menus with the
 * structure required by the Wiki Modern theme.
 *
 * @package Wiki Modern Theme
 */
class WM_Walker extends Walker_Nav_Menu {

    // TODO: COMPLETE THIS TO OUTPUT ANY MENUS WITH THE FOLLOWING FORMAT:
    // NOTE: INSIDE EACH <SPAN> THE TEXT SHOULD BE IN AN <A> I JUST LEFT IT OUT TO SAVE SPACE.
    //       IF A LINK GOES NOWHERE USE #
    //       !!! THE CLASS wm-NAVE SHOULD BE ADDED TO THE ACTIVE LI, wm-NAV-ITEM IS USED TO
    //       CONTROL THE ACTIVE EFFECT (STYLE)
    /*

    SIMPLE MENU
    <ul class="wm-nav">
            <li class="wm-active">
                <span class="wm-nav-item">Page 1</span>
            </li>
            <li class="wm-active">
                <span class="wm-nav-item">Page 2</span>
            </li>
            <li class="wm-active">
                <span class="wm-nav-item">Page 3</span>
            </li>
    </ul>

    NESTED MENU - 3 LEVELS, ANYMORE SHOULD BE ADDED AS LEVEL 3
    <ul class="wm-nav">
            <li class="wm-active">
                <span class="wm-nav-item">Page 1</span>
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
    */

}
