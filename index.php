<!DOCTYPE html>
<html>
    <head>
        <title>Demo</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/normalize.css">
<?php
$dark_mode = false;
if ( isset( $_COOKIE['wm-dark-mode'] ) ) {
    $dark_mode = true;
?>
        <link rel="stylesheet" href="css/main-dark.css">
<?php
} else {
?>
        <link rel="stylesheet" href="css/main.css">
<?php
}
?>
        <script src="js/polyfills.js"></script>
        <script src="js/cookie.js"></script>
        <script src="js/wiki-modern.js"></script>
    </head>
    <body>
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
    $print_settings = json_decode( $_COOKIE['wm-print-settings'], true );
} else {
    $print_settings = array(
        'wm-print-no-images' => false,
        'wm-print-no-media' => false,
        'wm-print-no-forms' => false,
        'wm-print-no-qr' => false,
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
if( $print_settings[ 'wm-print-no-images'] ) {
    $checked = 'checked="checked"';
}
?>
                            <div class="wm-button">
                                <label>
                                    <input type="checkbox" name="wm-print-no-images" <?php echo $checked; ?>>
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
if( $print_settings[ 'wm-print-no-media'] ) {
    $checked = 'checked="checked"';
}
?>
                            <div class="wm-button">
                                <label>
                                    <input type="checkbox" name="wm-print-no-media" <?php echo $checked; ?>>
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
if( $print_settings[ 'wm-print-no-forms'] ) {
    $checked = 'checked="checked"';
}
?>
                            <div class="wm-button">
                                <label>
                                    <input type="checkbox" name="wm-print-no-forms" <?php echo $checked; ?>>
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
if( $print_settings[ 'wm-print-no-qr'] ) {
    $checked = 'checked="checked"';
}
?>
                            <div class="wm-button">
                                <label>
                                    <input type="checkbox" name="wm-print-no-qr" <?php echo $checked; ?>>
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
                <!-- Page Controls -->
                <div id="wm-top-controls-wrapper">
                    <div id="wm-search-wrapper">
                        <div id="wm-fake-input">
                            <input type="text" placeholder="Search" aria-label="Search" id="wm-search">
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
                <!--Top Pagination Controls -->
                <div class="wm-pagination" id="wm-top-pagination">
                    <div class="wm-page">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M13.744 8s1.522-8-3.335-8h-8.409v24h20v-13c0-3.419-5.247-3.745-8.256-3zm.256 11h-8v-1h8v1zm4-3h-12v-1h12v1zm0-3h-12v-1h12v1zm-3.432-12.925c2.202 1.174 5.938 4.883 7.432 6.881-1.286-.9-4.044-1.657-6.091-1.179.222-1.468-.185-4.534-1.341-5.702z"/></svg>
                        Page
                        <div class="wm-inline-dropdown">
                            1
                            <ul class="wm-inline-options" data-wm-cookie-name="wm_pagination_limit">
                                <li onclick="WikiModern.dropdown();" data-wm-show-value="10">10</li><li onclick="WikiModern.dropdown();" data-wm-show-value="20">20</li><li onclick="WikiModern.dropdown();" data-wm-show-value="30">30</li><li onclick="WikiModern.dropdown();" data-wm-show-value="40">40</li><li onclick="WikiModern.dropdown();" data-wm-show-value="50">50</li>
                            </ul>
                        </div>
                        of 1.
                    </div>
                    <div class="wm-sort">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M8 10v4h4l-6 7-6-7h4v-4h-4l6-7 6 7h-4zm16 5h-10v2h10v-2zm0 6h-10v-2h10v2zm0-8h-10v-2h10v2zm0-4h-10v-2h10v2zm0-4h-10v-2h10v2z"/></svg>
                        <div class="wm-inline-dropdown">
                            newest
                            <ul class="wm-inline-options" data-wm-cookie-name="wm_pagination_limit">
                                <li onclick="WikiModern.dropdown();" data-wm-show-value="10">10</li><li onclick="WikiModern.dropdown();" data-wm-show-value="20">20</li><li onclick="WikiModern.dropdown();" data-wm-show-value="30">30</li><li onclick="WikiModern.dropdown();" data-wm-show-value="40">40</li><li onclick="WikiModern.dropdown();" data-wm-show-value="50">50</li>
                            </ul>
                        </div>
                        results first.
                    </div>
                    <div class="wm-limit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M7 16h13v1h-13v-1zm13-3h-13v1h13v-1zm0-6h-5v1h5v-1zm0 3h-5v1h5v-1zm-17-8v17.199c0 .771-1 .771-1 0v-15.199h-2v15.98c0 1.115.905 2.02 2.02 2.02h19.958c1.117 0 2.022-.904 2.022-2.02v-17.98h-21zm19 17h-17v-15h17v15zm-9-12h-6v4h6v-4z"/></svg>
                        <div class="wm-inline-dropdown">
                            7
                            <ul class="wm-inline-options" data-wm-cookie-name="wm_pagination_limit">
                                <li onclick="WikiModern.dropdown();" data-wm-show-value="10">10</li><li onclick="WikiModern.dropdown();" data-wm-show-value="20">20</li><li onclick="WikiModern.dropdown();" data-wm-show-value="30">30</li><li onclick="WikiModern.dropdown();" data-wm-show-value="40">40</li><li onclick="WikiModern.dropdown();" data-wm-show-value="50">50</li>
                            </ul>
                        </div>
                        results per page.
                    </div>
                </div>
                <!-- Page Content -->
                <div id="wm-page-content">
<article class="wm-article" id="post-41"><h2 class="wm-article-title wm-link"><a href="https://caboodle.tech/2017/04/07/ultimate-member-plugin-403-forbidden-error/">Ultimate Member Plugin 403 Forbidden Error</a></h2><div class="wm-article-times">Published <time itemprop="datePublished" datetime="2017-04-07 20:04:49">April 7, 2017</time>. Last updated <time itemprop="dateModified" datetime="2019-10-10 20:11:02">October 10, 2019</time>.</div><div class="wm-article-wrapper"><div class="wm-article-content" onclick="WikiModern.navigate();" data-wm-navigation="https://caboodle.tech/2017/04/07/ultimate-member-plugin-403-forbidden-error/"><p>This post is dedicated to a simple but tricky gotcha in the&nbsp;<a rel="noreferrer noopener" href="https://wordpress.org/" target="_blank">WordPress</a>&nbsp;plugin&nbsp;<a rel="noreferrer noopener" href="https://ultimatemember.com/" target="_blank">Ultimate Member</a>. For those of you who may be unfamiliar with Ultimate Member it is a plugin that&nbsp;adds enhanced user account management abilities to your WordPress site. Put simply the plugin allows you to:</p><p>The list really could go on and on but suffice it to say that Ultimate Member adds a lot of free functionality to your WordPress site. If you manage a big WordPress site the paid extensions can take your site even further; I’m&nbsp;being serious, this is not a paid post, I really love what Ultimate Member is doing for WordPress.</p></div></div></article>
<article class="wm-article" id="post-25"><h2 class="wm-article-title wm-link"><a href="https://caboodle.tech/2017/06/14/knowing-when-its-time-to-toss-code-out/">Knowing when it’s time to toss code out!</a></h2><div class="wm-article-times">Published <time itemprop="datePublished" datetime="2017-06-14 10:20:53">June 14, 2017</time>. Last updated <time itemprop="dateModified" datetime="2019-10-10 20:04:38">October 10, 2019</time>.</div><div class="wm-article-wrapper"><div class="wm-article-image-wrapper"><div class="wm-artilce-image wm-pointer" onclick="WikiModern.toggle('image-carousel')"><img loading="lazy" width="1024" height="576" src="https://caboodle.tech/wp-content/uploads/2019/10/notification-and-form-manager-scripts-1024x576.jpg" alt="" class="wp-image-26" srcset="https://caboodle.tech/wp-content/uploads/2019/10/notification-and-form-manager-scripts.jpg 1024w, https://caboodle.tech/wp-content/uploads/2019/10/notification-and-form-manager-scripts-300x169.jpg 300w, https://caboodle.tech/wp-content/uploads/2019/10/notification-and-form-manager-scripts-768x432.jpg 768w" sizes="(max-width: 250px) 50px, (max-width: 400px) 200px, (max-width: 868px) 668px, (max-width: 1124px) 924px, (max-width: 1636px) 1436px, (max-width: 2148px) 1948px, 100vw"></div><div class="wm-image-sources"><!--<img loading="lazy" width="1024" height="576" src="https://caboodle.tech/wp-content/uploads/2019/10/notification-and-form-manager-scripts-1024x576.jpg" alt="" class="wp-image-26" srcset="https://caboodle.tech/wp-content/uploads/2019/10/notification-and-form-manager-scripts.jpg 1024w, https://caboodle.tech/wp-content/uploads/2019/10/notification-and-form-manager-scripts-300x169.jpg 300w, https://caboodle.tech/wp-content/uploads/2019/10/notification-and-form-manager-scripts-768x432.jpg 768w" sizes="(max-width: 250px) 50px, (max-width: 400px) 200px, (max-width: 868px) 668px, (max-width: 1124px) 924px, (max-width: 1636px) 1436px, (max-width: 2148px) 1948px, 100vw" />--></div></div><div class="wm-article-content" onclick="WikiModern.navigate();" data-wm-navigation="https://caboodle.tech/2017/06/14/knowing-when-its-time-to-toss-code-out/"><p>Rounding up slightly I have spent 10 hours this week redesigning the notification and form submission system… Actually, I seriously just thought of something else I missed.</p><p>So now that I’ve spent 10 hours on the completed&nbsp;notification and form submission system I’ve come to the point where I want to toss out all the old code that is taking up space in my project. I’m happy to see it go because it really cleans up the project but I don’t want to actually delete it forever so this post will serve as it’s final resting place. Well this code is being saved primarily for nostalgia’s sake I feel some programmers, especially those that are just starting out, would like to pick these apart and see the not so beautiful development process in action. For starters let me share with you a picture showing the layout of events these scripts were trying to accomplish. Early on as I developed these scripts it hit me that things were getting way out of hand so I stopped and mocked everything up to come up with a new plan of attack.</p></div></div></article>
<article class="wm-article" id="post-41"><h2 class="wm-article-title wm-link"><a href="https://caboodle.tech/2017/04/07/ultimate-member-plugin-403-forbidden-error/">Ultimate Member Plugin 403 Forbidden Error</a></h2><div class="wm-article-times">Published <time itemprop="datePublished" datetime="2017-04-07 20:04:49">April 7, 2017</time>. Last updated <time itemprop="dateModified" datetime="2019-10-10 20:11:02">October 10, 2019</time>.</div><div class="wm-article-wrapper"><div class="wm-article-content" onclick="WikiModern.navigate();" data-wm-navigation="https://caboodle.tech/2017/04/07/ultimate-member-plugin-403-forbidden-error/"><p>This post is dedicated to a simple but tricky gotcha in the&nbsp;<a rel="noreferrer noopener" href="https://wordpress.org/" target="_blank">WordPress</a>&nbsp;plugin&nbsp;<a rel="noreferrer noopener" href="https://ultimatemember.com/" target="_blank">Ultimate Member</a>. For those of you who may be unfamiliar with Ultimate Member it is a plugin that&nbsp;adds enhanced user account management abilities to your WordPress site. Put simply the plugin allows you to:</p><p>The list really could go on and on but suffice it to say that Ultimate Member adds a lot of free functionality to your WordPress site. If you manage a big WordPress site the paid extensions can take your site even further; I’m&nbsp;being serious, this is not a paid post, I really love what Ultimate Member is doing for WordPress.</p></div></div></article>
<article class="wm-article" id="post-38"><h2 class="wm-article-title wm-link"><a href="https://caboodle.tech/2017/05/31/is-that-a-url-uri-or-urn/">Is that a URL, URI, or URN?</a></h2><div class="wm-article-times">Published <time itemprop="datePublished" datetime="2017-05-31 19:54:46">May 31, 2017</time>. Last updated <time itemprop="dateModified" datetime="2019-10-10 20:01:25">October 10, 2019</time>.</div><div class="wm-article-wrapper"><div class="wm-article-image-wrapper"><div class="wm-artilce-image wm-pointer" onclick="WikiModern.toggle('image-carousel')"><img loading="lazy" width="640" height="604" src="https://via.placeholder.com/600x600" alt="" class="wp-image-39"></div><div class="wm-image-sources"><!--<img loading="lazy" width="640" height="604" src="https://caboodle.tech/wp-content/uploads/2019/10/URI-vs-URL.png" alt="" class="wp-image-39" srcset="https://caboodle.tech/wp-content/uploads/2019/10/URI-vs-URL.png 640w, https://caboodle.tech/wp-content/uploads/2019/10/URI-vs-URL-300x283.png 300w" sizes="(max-width: 250px) 50px, (max-width: 400px) 200px, (max-width: 868px) 668px, (max-width: 1124px) 924px, (max-width: 1636px) 1436px, (max-width: 2148px) 1948px, 100vw" />--></div></div><div class="wm-article-content" onclick="WikiModern.navigate();" data-wm-navigation="https://caboodle.tech/2017/05/31/is-that-a-url-uri-or-urn/"><p>Today I learned that I have been using the term URI (Uniform Resource Identifier) incorrectly. Apparently so many people misuse the acronyms URL, URI, and URN that there is entire blog posts out there trying to clear up the confusion.</p><p>So why&nbsp;is this random piece of knowledge so important I felt like doing a blog post on it? Well put simply I believe that it’s important to try and learn all you can about your trade even those random snippets of knowledge that honestly most people will never need to know. Unless you deal with web based software or technologies that deal directly with internet protocols you probably will never care what people call that magic string of characters that takes you across the internet.</p><p>Keeping that explanation in mind you should stop reading this post and have a glance at&nbsp;<a rel="noreferrer noopener" href="https://danielmiessler.com/study/url-uri/#gs.iKUw=ww" target="_blank">Daniel Miessler’s&nbsp;<em>The Difference Between URLs and URIs</em></a>. In case of link rot I have copied the image from his post below since it does a good job at summarizing what he talks about.</p></div></div></article>
                </div>
                <!--Bottom Pagination Controls -->
                <!--Top Pagination Controls -->
                <div class="wm-pagination" id="wm-bottom-pagination">
                    <div class="wm-page">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M13.744 8s1.522-8-3.335-8h-8.409v24h20v-13c0-3.419-5.247-3.745-8.256-3zm.256 11h-8v-1h8v1zm4-3h-12v-1h12v1zm0-3h-12v-1h12v1zm-3.432-12.925c2.202 1.174 5.938 4.883 7.432 6.881-1.286-.9-4.044-1.657-6.091-1.179.222-1.468-.185-4.534-1.341-5.702z"/></svg>
                        Page
                        <div class="wm-inline-dropdown">
                            1
                            <ul class="wm-inline-options" data-wm-cookie-name="wm_pagination_limit">
                                <li onclick="WikiModern.dropdown();" data-wm-show-value="10">10</li><li onclick="WikiModern.dropdown();" data-wm-show-value="20">20</li><li onclick="WikiModern.dropdown();" data-wm-show-value="30">30</li><li onclick="WikiModern.dropdown();" data-wm-show-value="40">40</li><li onclick="WikiModern.dropdown();" data-wm-show-value="50">50</li>
                            </ul>
                        </div>
                        of 1.
                    </div>
                    <div class="wm-sort">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M8 10v4h4l-6 7-6-7h4v-4h-4l6-7 6 7h-4zm16 5h-10v2h10v-2zm0 6h-10v-2h10v2zm0-8h-10v-2h10v2zm0-4h-10v-2h10v2zm0-4h-10v-2h10v2z"/></svg>
                        <div class="wm-inline-dropdown">
                            newest
                            <ul class="wm-inline-options" data-wm-cookie-name="wm_pagination_limit">
                                <li onclick="WikiModern.dropdown();" data-wm-show-value="10">10</li><li onclick="WikiModern.dropdown();" data-wm-show-value="20">20</li><li onclick="WikiModern.dropdown();" data-wm-show-value="30">30</li><li onclick="WikiModern.dropdown();" data-wm-show-value="40">40</li><li onclick="WikiModern.dropdown();" data-wm-show-value="50">50</li>
                            </ul>
                        </div>
                        results first.
                    </div>
                    <div class="wm-limit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M7 16h13v1h-13v-1zm13-3h-13v1h13v-1zm0-6h-5v1h5v-1zm0 3h-5v1h5v-1zm-17-8v17.199c0 .771-1 .771-1 0v-15.199h-2v15.98c0 1.115.905 2.02 2.02 2.02h19.958c1.117 0 2.022-.904 2.022-2.02v-17.98h-21zm19 17h-17v-15h17v15zm-9-12h-6v4h6v-4z"/></svg>
                        <div class="wm-inline-dropdown">
                            7
                            <ul class="wm-inline-options" data-wm-cookie-name="wm_pagination_limit">
                                <li onclick="WikiModern.dropdown();" data-wm-show-value="10">10</li><li onclick="WikiModern.dropdown();" data-wm-show-value="20">20</li><li onclick="WikiModern.dropdown();" data-wm-show-value="30">30</li><li onclick="WikiModern.dropdown();" data-wm-show-value="40">40</li><li onclick="WikiModern.dropdown();" data-wm-show-value="50">50</li>
                            </ul>
                        </div>
                        results per page.
                    </div>
                </div>
            </main>
            <aside class="wm-col wm-left-sidebar">
                <div class="wm-mobile-button">
                    <div class="wm-close-button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm4.597 17.954l-4.591-4.55-4.555 4.596-1.405-1.405 4.547-4.592-4.593-4.552 1.405-1.405 4.588 4.543 4.545-4.589 1.416 1.403-4.546 4.587 4.592 4.548-1.403 1.416z"/></svg>
                    </div>
                </div>
                <div class="wm-article-meta">
                    <div class="wm-title">
                        Article Information
                    </div>
                    <div class="wm-content">
                        <table>
                            <tbody><tr class="wm-sub-title"><td>Published:</td></tr><tr class="wm-info"><td>April 7, 2017</td></tr><tr class="wm-sub-title"><td>Last Updated:</td></tr><tr class="wm-info"><td>October 10, 2019</td></tr><tr class="wm-sub-title"><td>Author:</td></tr><tr class="wm-info"><td>Christopher Keers</td></tr><tr class="wm-sub-title"><td>Categories:</td></tr><tr class="wm-info"><td><span class="wm-tags"><a href="https://caboodle.tech/category/bug/">Bugs</a></span>, <span class="wm-tags"><a href="https://caboodle.tech/category/php/">PHP</a></span>, <span class="wm-tags"><a href="https://caboodle.tech/category/programming/">Programming</a></span></td></tr><tr class="wm-sub-title"><td>Tags:</td></tr><tr class="wm-info"><td><span class="wm-tags"><a href="https://caboodle.tech/tag/bug/">Bug</a></span>, <span class="wm-tags"><a href="https://caboodle.tech/tag/php/">PHP</a></span>, <span class="wm-tags"><a href="https://caboodle.tech/tag/plugin/">Plugin</a></span>, <span class="wm-tags"><a href="https://caboodle.tech/tag/programming/">Programming</a></span>, <span class="wm-tags"><a href="https://caboodle.tech/tag/wordpress/">WordPress</a></span></td></tr>            </tbody></table>
                    </div>
                </div>
                <div class="wm-module-area">
                    <div class="wm-title">
                        Test
                    </div>
                    Test
                </div>
            </aside>
            <header class="wm-col wm-right-sidebar">
                <div class="wm-mobile-button">
                    <div class="wm-close-button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm4.597 17.954l-4.591-4.55-4.555 4.596-1.405-1.405 4.547-4.592-4.593-4.552 1.405-1.405 4.588 4.543 4.545-4.589 1.416 1.403-4.546 4.587 4.592 4.548-1.403 1.416z"/></svg>
                    </div>
                </div>
                <div id="wm-logo-wrapper">
                    <img id="wm-logo" src="https://via.placeholder.com/250x250">
                    <div id="wm-business-name">
                        Caboodle Tech Inc.
                    </div>
                    <div id="wm-business-tagline">
                        Everything Technology &trade;
                    </div>
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
                    <div class="wm-title">
                        Test
                    </div>
                    Test
                </div>
                <div id="wm-dark-mode-wrapper">
                    <div id="wm-dark-mode-toggle" title="Toggle dark mode">
                        <label>
                            <input type="checkbox" name="" <?php if( $dark_mode ) { echo 'checked="checked"'; } ?>>
                            <span></span>
                        </label>
                    </div>
                </div>
            </header>
        </div>
        <footer class="wm-row wm-footer">
            <div class="wm-column">
                <div class="wm-title">
                    Test
                </div>
                1
            </div>
            <div class="wm-column">
                <div class="wm-title">
                    Test
                </div>
                2
            </div>
            <div class="wm-column">
                3
            </div>
            <div class="wm-column">
                4
            </div>
            <div id="wm-copyright">
                <svg class="wm-copyright-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm0 15.781c-2.084 0-3.781-1.696-3.781-3.781s1.696-3.781 3.781-3.781c1.172 0 2.306.523 3.136 1.669l1.857-1.218c-1.281-1.826-3.133-2.67-4.993-2.67-3.308 0-6 2.692-6 6s2.691 6 6 6c1.881 0 3.724-.859 4.994-2.67l-1.857-1.218c-.828 1.14-1.959 1.669-3.137 1.669z"/></svg> 1990 &ndash; 2021 Caboodle Tech Inc. All Rights Reserved.
                <div class="wm-mobile-break"></div>
                Powered by <a href="https://wordpress.org/" target="_blank" rel="nofollow noopener noreferrer"><svg class="wm-worpress-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M2.597 7.81l4.911 13.454c-3.434-1.668-5.802-5.19-5.802-9.264 0-1.493.32-2.91.891-4.19zm16.352 3.67c0-1.272-.457-2.153-.849-2.839-.521-.849-1.011-1.566-1.011-2.415 0-.978.747-1.88 1.862-1.819-1.831-1.677-4.271-2.701-6.951-2.701-3.596 0-6.76 1.845-8.601 4.64.625.02 1.489.032 3.406-.118.555-.034.62.782.066.847 0 0-.558.065-1.178.098l3.749 11.15 2.253-6.756-1.604-4.394c-.555-.033-1.08-.098-1.08-.098-.555-.033-.49-.881.065-.848 2.212.17 3.271.171 5.455 0 .555-.033.621.783.066.848 0 0-.559.065-1.178.098l3.72 11.065 1.027-3.431c.444-1.423.783-2.446.783-3.327zm-6.768 1.42l-3.089 8.975c.922.271 1.898.419 2.908.419 1.199 0 2.349-.207 3.418-.583-.086-.139-3.181-8.657-3.237-8.811zm8.852-5.839c.224 1.651-.099 3.208-.713 4.746l-3.145 9.091c3.061-1.784 5.119-5.1 5.119-8.898 0-1.79-.457-3.473-1.261-4.939zm2.967 4.939c0 6.617-5.384 12-12 12s-12-5.383-12-12 5.383-12 12-12 12 5.383 12 12zm-.55 0c0-6.313-5.137-11.45-11.45-11.45s-11.45 5.137-11.45 11.45 5.137 11.45 11.45 11.45 11.45-5.137 11.45-11.45z"/></svg></a> with the <a href="https://github.com/caboodle-tech/wiki-modern" target="_blank" rel="nofollow noopener noreferrer">Wiki Modern Theme</a>.
            </div>
        </footer>
    </body>
</html>
