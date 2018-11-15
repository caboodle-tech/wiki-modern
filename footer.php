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
<footer id="wm-footer">
    <!--
        TODO: ADD DROPDOWN OPTION ALLOWING THIS SECTION TO BE OFF OR HAVE 1, 2, 3, OR 4 COLUMNS.
              wm-GRID-# IS DETERMINED BY WHO MANY COLUMNS WAS CHOSEN
              wm-COLO-# IS THE COL NUMBER
    -->
    <div class="wm-footer-widgets wm-row wm-grid-3">
        <div class="wm-widget wm-col-1">
            one
        </div>
        <div class="wm-widget wm-col-2">
            two
        </div>
        <div class="wm-widget wm-col-3">
            three
        </div><!--
        <div class="wm-widget wm-col-4">
            four
        </div>-->
    </div>
    <!-- FOOTER 1 -->
    <div id="wm-footer-bottom" class="wm-row">
        <div class="wm-copy-and-credits wm-center">
            <div class="wm-copyright">
                <span class="wm-copyright-text"><i class="far fa-copyright"></i> 2018 <?php echo get_bloginfo('name'); ?></span> <span class="wm-rights-text">All Rights Reserved.</span>
            </div>
            <div class="wm-credits">
                <span class="wm-powered">Powered by <a href="#" target="_blank"><i class="fab fa-wordpress-simple"></i></a></span><span class="wm-designer">&nbsp;Designed with the <a href="#" target="_blank">Wiki Modern Theme</a>.</span>
            </div>
        </div>
    </div>
    <!-- FOOTER 2

        TODO: ADD TOGGLE FOR SOCIAL ICONS (FOOTER 2)
              IF TOGGLE IS TRUE:
              ADD TOGGLE FOR SOCIAL ICONS TO RIGHT (LEFT IS DEFAULT)
              ADD OPTION TO ADD SOCIAL ICONS TO THE PAGE (SEE CUSTOMIZER THEME)

    <div id="wm-footer-bottom" class="wm-footer-bottom wm-row wm-grid-2">
        <div class="wm-social-icons wm-col-1 wm-left">
            <span class="wm-icon">[GH]</span>
            <span class="wm-icon">[YT]</span>
            <span class="wm-icon">[RS]</span>
        </div>
        <div class="wm-copy-and-credits wm-col-2 wm-right">
            <div class="wm-copyright">
                <span class="wm-copyright-text"><i class="far fa-copyright"></i> 2018 Caboodle Tech Inc.</span> <span class="wm-rights-text">All Rights Reserved.</span>
            </div>
            <div class="wm-credits">
                <span class="wm-powered">Powered by <a href="#" target="_blank"><i class="fab fa-wordpress-simple"></i></a></span><span class="wm-designer">&nbsp;Designed with the <a href="#" target="_blank">Wiki Modern Theme</a>.</span>
            </div>
        </div>
    </div>
    -->
</footer>
<!-- Close #wm-wrapper div. -->
</div>
<!-- Record the root URL to the theme directory for Wiki-Modern.js -->
<div id="wm-template-directory" data-wm-template-directory="<?php echo get_template_directory_uri(); ?>" style="display:none;"></div>
<!-- Load scripts & close page. -->
<?php wp_footer(); ?>
</body>
</html>
