<?php
/**
 * Load the pages header.
 * 
 * @file header.php
 * @package Optimal Ship Theme
 */

get_header();

// [TODO][BP20F4850] ADD post_password_required check to block viewing locked post without password.
// Make sure the sidebar doesn't load anything either except maybe widgets?

// Hidden divs used to calculate the browsers scrollbar width.
?>
<!-- This is hidden from site users. -->
<div id="wm-scrollbar-check-outter">
    <div id="wm-scrollbar-check-inner">
    </div>
</div>
<div class="wm-row">
    <main class="wm-col wm-main-content">
        <!-- Print Controls -->
<?php
if ( isset( $_COOKIE['wm-print-settings'] ) ) {
    $cookie         = sanitize_meta( 'wm_cookie', wp_unslash( $_COOKIE['wm-print-settings'] ), 'json' );
    $print_settings = json_decode( $cookie, true );
} else {
    $print_settings = array(
        'wm-print-no-images' => false,
        'wm-print-no-media'  => false,
        'wm-print-no-forms'  => false,
        'wm-print-no-qr'     => false,
    );
}
?>
        <div id="wm-print-controls-wrapper">
            <div class="wm-close-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm4.597 17.954l-4.591-4.55-4.555 4.596-1.405-1.405 4.547-4.592-4.593-4.552 1.405-1.405 4.588 4.543 4.545-4.589 1.416 1.403-4.546 4.587 4.592 4.548-1.403 1.416z"/></svg>
            </div>
            <div class="wm-left-column">
                <div class="wm-title">
                    Hide Document Parts:
                </div>
                <div class="wm-option" id="wm-image-option">
                    <div class="wm-title">
                        Images
                    </div>
                    <div class="wm-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M5 8.5c0-.828.672-1.5 1.5-1.5s1.5.672 1.5 1.5c0 .829-.672 1.5-1.5 1.5s-1.5-.671-1.5-1.5zm9 .5l-2.519 4-2.481-1.96-4 5.96h14l-5-8zm8-4v14h-20v-14h20zm2-2h-24v18h24v-18z"/></svg>
                    </div>
<?php
$checked = '';
if ( $print_settings['wm-print-no-images'] ) {
$checked = 'checked="checked"';
}
?>
                    <div class="wm-button">
                        <label>
                            <input type="checkbox" name="wm-print-no-images" <?php esc_attr( $checked ); ?>>
                            <span></span>
                        </label>
                    </div>
                </div>
                <div class="wm-option" id="wm-media-option">
                    <div class="wm-title">
                        Digital Media
                    </div>
                    <div class="wm-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M22 1v2h-2v-2h-2v4h-12v-4h-2v2h-2v-2h-2v22h2v-2h2v2h2v-4h12v4h2v-2h2v2h2v-22h-2zm-18 18h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2v-2h2v2zm6 8v-6l5 3-5 3zm12 4h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2v-2h2v2z"/></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M5 17h-5v-10h5v10zm2-10v10l9 5v-20l-9 5zm17 4h-5v2h5v-2zm-1.584-6.232l-4.332 2.5 1 1.732 4.332-2.5-1-1.732zm1 12.732l-4.332-2.5-1 1.732 4.332 2.5 1-1.732z"/></svg>
                    </div>
<?php
$checked = '';
if ( $print_settings['wm-print-no-media'] ) {
$checked = 'checked="checked"';
}
?>
                    <div class="wm-button">
                        <label>
                            <input type="checkbox" name="wm-print-no-media" <?php echo esc_attr( $checked ); ?>>
                            <span></span>
                        </label>
                    </div>
                </div>
                <div class="wm-option" id="wm-form-option">
                    <div class="wm-title">
                        Forms
                    </div>
                    <div class="wm-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M2 0v24h20v-24h-20zm18 22h-16v-15h16v15zm-3-4h-10v-1h10v1zm0-3h-10v-1h10v1zm0-3h-10v-1h10v1z"/></svg>
                    </div>
<?php
$checked = '';
if ( $print_settings['wm-print-no-forms'] ) {
$checked = 'checked="checked"';
}
?>
                    <div class="wm-button">
                        <label>
                            <input type="checkbox" name="wm-print-no-forms" <?php echo esc_attr( $checked ); ?>>
                            <span></span>
                        </label>
                    </div>
                </div>
                <div class="wm-option" id="wm-qr-option">
                    <div class="wm-title">
                        QR Code
                    </div>
                    <div class="wm-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M21 21v3h3v-3h-1v-1h-1v1h-1zm2 1v1h-1v-1h1zm-23 2h8v-8h-8v8zm1-7h6v6h-6v-6zm20 3v-1h1v1h-1zm-19-2h4v4h-4v-4zm8-3v2h-1v-2h1zm2-8h1v1h-1v-1zm1-1h1v1h-1v-1zm1 2v-1h1v1h-1zm0-2h1v-6h-3v1h-3v1h3v1h2v3zm-1-4v-1h1v1h-1zm-7 4h-4v-4h4v4zm6 0h-1v-2h-2v-1h3v1h1v1h-1v1zm-4-6h-8v8h8v-8zm-1 7h-6v-6h6v6zm3 0h-1v-1h2v2h-1v-1zm-3 3v1h-1v-1h1zm15 6h2v3h-1v-1h-2v1h-1v-1h-1v-1h1v-1h1v1h1v-1zm-4 2h-1v1h-1v-1h-1v-1h1v-1h-2v-1h-1v1h-1v1h-2v1h-1v6h5v-1h-1v-2h-1v2h-2v-1h1v-1h-1v-1h3v-1h2v2h-1v1h1v2h1v-2h1v1h1v-1h1v-2h1v-1h-2v-1zm-1 3h-1v-1h1v1zm6-6v-2h1v2h-1zm-9 5v1h-1v-1h1zm5 3v-1h1v2h-2v-1h1zm-3-23v8h8v-8h-8zm7 7h-6v-6h6v6zm-1-1h-4v-4h4v4zm1 4h1v2h-1v1h-2v-4h1v2h1v-1zm-4 6v-3h1v3h-1zm-13-7v1h-2v1h1v1h-3v-1h1v-1h-2v1h-1v-2h6zm-1 4v-1h1v3h-1v-1h-1v1h-1v-1h-1v1h-2v-1h1v-1h4zm-4-1v1h-1v-1h1zm19-2h-1v-1h1v1zm-13 4h1v1h-1v-1zm15 2h-1v-1h1v1zm-5 1v-1h1v1h-1zm-1-1h1v-3h2v-1h1v-1h-1v-1h-2v-1h-1v1h-1v-1h-1v1h-1v-1h-1v1h-1v1h-1v-1h1v-1h-4v1h2v1h-2v1h1v2h1v-1h2v2h1v-4h1v2h3v1h-2v1h2v1zm1-5h1v1h-1v-1zm-2 1h-1v-1h1v1z"/></svg>
                    </div>
<?php
$checked = '';
if ( $print_settings['wm-print-no-qr'] ) {
$checked = 'checked="checked"';
}
?>
                    <div class="wm-button">
                        <label>
                            <input type="checkbox" name="wm-print-no-qr" <?php echo esc_attr( $checked ); ?>>
                            <span></span>
                        </label>
                    </div>
<?php
unset( $checked );
?>
                </div>
            </div>
            <div class="wm-right-column">
                <div class="wm-title">
                    Output Options:
                </div>
                <div class="wm-option">
                    <div class="wm-title">
                        Print Document
                    </div>
                    <div class="wm-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M14 20h-6v-1h6v1zm10-15v13h-4v6h-16v-6h-4v-13h4v-5h16v5h4zm-6 10h-12v7h12v-7zm0-13h-12v3h12v-3zm4 5.5c0-.276-.224-.5-.5-.5s-.5.224-.5.5.224.5.5.5.5-.224.5-.5zm-6 9.5h-8v1h8v-1z"/></svg>
                    </div>
                    <div class="wm-button">
                        <input type="button" class="wm-print" value="Print">
                    </div>
                </div>
                <div class="wm-option">
                    <div class="wm-title">
                        Download PDF
                    </div>
                    <div class="wm-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12.819 14.427c.064.267.077.679-.021.948-.128.351-.381.528-.754.528h-.637v-2.12h.496c.474 0 .803.173.916.644zm3.091-8.65c2.047-.479 4.805.279 6.09 1.179-1.494-1.997-5.23-5.708-7.432-6.882 1.157 1.168 1.563 4.235 1.342 5.703zm-7.457 7.955h-.546v.943h.546c.235 0 .467-.027.576-.227.067-.123.067-.366 0-.489-.109-.198-.341-.227-.576-.227zm13.547-2.732v13h-20v-24h8.409c4.858 0 3.334 8 3.334 8 3.011-.745 8.257-.42 8.257 3zm-12.108 2.761c-.16-.484-.606-.761-1.224-.761h-1.668v3.686h.907v-1.277h.761c.619 0 1.064-.277 1.224-.763.094-.292.094-.597 0-.885zm3.407-.303c-.297-.299-.711-.458-1.199-.458h-1.599v3.686h1.599c.537 0 .961-.181 1.262-.535.554-.659.586-2.035-.063-2.693zm3.701-.458h-2.628v3.686h.907v-1.472h1.49v-.732h-1.49v-.698h1.721v-.784z"/></svg>
                    </div>
                    <div class="wm-button">
                        <input type="button" class="wm-download" value="Download">
                    </div>
                </div>
            </div>
        </div>
<?php
$search_text = wp_strip_all_tags( urldecode( get_query_var( 's' ) ) );
?>
        <!-- Page Controls -->
        <div id="wm-top-controls-wrapper">
            <div id="wm-search-wrapper">
                <div id="wm-fake-input">
                    <input type="text" placeholder="Search" aria-label="Search" id="wm-search" value="<?php echo esc_html( $search_text ); ?>">
                    <div id="wm-search-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" transform="scale(-1, 1)"><path d="M23.809 21.646l-6.205-6.205c1.167-1.605 1.857-3.579 1.857-5.711 0-5.365-4.365-9.73-9.731-9.73-5.365 0-9.73 4.365-9.73 9.73 0 5.366 4.365 9.73 9.73 9.73 2.034 0 3.923-.627 5.487-1.698l6.238 6.238 2.354-2.354zm-20.955-11.916c0-3.792 3.085-6.877 6.877-6.877s6.877 3.085 6.877 6.877-3.085 6.877-6.877 6.877c-3.793 0-6.877-3.085-6.877-6.877z"/></svg>
                    </div>
                </div>
            </div>
            <div class="wm-left-toggle">
                <div class="wm-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-.001 5.75c.69 0 1.251.56 1.251 1.25s-.561 1.25-1.251 1.25-1.249-.56-1.249-1.25.559-1.25 1.249-1.25zm2.001 12.25h-4v-1c.484-.179 1-.201 1-.735v-4.467c0-.534-.516-.618-1-.797v-1h3v6.265c0 .535.517.558 1 .735v.999z"/></svg>
                </div>
            </div>
            <div class="wm-read">
                <div class="wm-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" xml:space="preserve" preserveAspectRatio='xMinYMin'><path d="M12 4.706c-2.938-1.83-7.416-2.566-12-2.706v17.714c3.937.12 7.795.681 10.667 1.995.846.388 1.817.388 2.667 0 2.872-1.314 6.729-1.875 10.666-1.995v-17.714c-4.584.14-9.062.876-12 2.706zm-10 13.104v-13.704c5.157.389 7.527 1.463 9 2.334v13.168c-1.525-.546-4.716-1.504-9-1.798zm20 0c-4.283.293-7.475 1.252-9 1.799v-13.171c1.453-.861 3.83-1.942 9-2.332v13.704zm-2-10.214c-2.086.312-4.451 1.023-6 1.672v-1.064c1.668-.622 3.881-1.315 6-1.626v1.018zm0 3.055c-2.119.311-4.332 1.004-6 1.626v1.064c1.549-.649 3.914-1.361 6-1.673v-1.017zm0-2.031c-2.119.311-4.332 1.004-6 1.626v1.064c1.549-.649 3.914-1.361 6-1.673v-1.017zm0 6.093c-2.119.311-4.332 1.004-6 1.626v1.064c1.549-.649 3.914-1.361 6-1.673v-1.017zm0-2.031c-2.119.311-4.332 1.004-6 1.626v1.064c1.549-.649 3.914-1.361 6-1.673v-1.017zm-16-6.104c2.119.311 4.332 1.004 6 1.626v1.064c-1.549-.649-3.914-1.361-6-1.672v-1.018zm0 5.09c2.086.312 4.451 1.023 6 1.673v-1.064c-1.668-.622-3.881-1.315-6-1.626v1.017zm0-2.031c2.086.312 4.451 1.023 6 1.673v-1.064c-1.668-.622-3.881-1.316-6-1.626v1.017zm0 6.093c2.086.312 4.451 1.023 6 1.673v-1.064c-1.668-.622-3.881-1.315-6-1.626v1.017zm0-2.031c2.086.312 4.451 1.023 6 1.673v-1.064c-1.668-.622-3.881-1.315-6-1.626v1.017z"/></svg>
                </div>
            </div>
            <div class="wm-print">
                <div class="wm-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M14 20h-6v-1h6v1zm10-15v13h-4v6h-16v-6h-4v-13h4v-5h16v5h4zm-6 10h-12v7h12v-7zm0-13h-12v3h12v-3zm4 5.5c0-.276-.224-.5-.5-.5s-.5.224-.5.5.224.5.5.5.5-.224.5-.5zm-6 9.5h-8v1h8v-1z"/></svg>
                </div>
            </div>
            <div class="wm-right-toggle">
                <div class="wm-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M24 6h-24v-4h24v4zm0 4h-24v4h24v-4zm0 8h-24v4h24v-4z"/></svg>
                </div>
            </div>
        </div>
        <!-- Page Content -->
        <div id="wm-page-content">
<?php
require 'include/wm-page-manager.php';
?>
        </div>
    </main>
<?php
/**
 * Load the pages left (post meta & widgets) sidebar.
 * File: sidebar-left.php
 */
get_sidebar( 'left' );

/**
 * Load the pages right (site navigation & widgets) sidebar.
 * File: sidebar-right.php
 */
get_sidebar( 'right' );
?>
</div>
<?php
/**
 * Load the pages footer.
 * File: footer.php
 */
get_footer();
?>
