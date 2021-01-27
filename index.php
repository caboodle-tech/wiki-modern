<!DOCTYPE html>
<html>
    <head>
        <title>Demo</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <script src="js/wiki-modern.js"></script>
        <script src="js/fa.min.js"></script>
    </head>
    <body>
        <!-- This is hidden from site users. -->
        <div id="wm-scrollbar-check-outter">
            <div id="wm-scrollbar-check-inner">
            </div>
        </div>
        <div class="wm-row">
            <main class="wm-col">
                <!-- Page controls -->
                <div id="wm-top-controls-wrapper">
                    <div id="wm-search-wrapper">
                        <div id="wm-fake-input">
                            <input type="text" placeholder="Search" aria-label="Search" id="wm-search">
                            <span id="wm-search-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" transform="scale(-1, 1)"><path d="M23.809 21.646l-6.205-6.205c1.167-1.605 1.857-3.579 1.857-5.711 0-5.365-4.365-9.73-9.731-9.73-5.365 0-9.73 4.365-9.73 9.73 0 5.366 4.365 9.73 9.73 9.73 2.034 0 3.923-.627 5.487-1.698l6.238 6.238 2.354-2.354zm-20.955-11.916c0-3.792 3.085-6.877 6.877-6.877s6.877 3.085 6.877 6.877-3.085 6.877-6.877 6.877c-3.793 0-6.877-3.085-6.877-6.877z"/></svg>
                            </span>
                        </div>
                    </div>
                    <div class="wm-left-toggle">
                        <div class="wm-button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M24 6h-24v-4h24v4zm0 4h-24v4h24v-4zm0 8h-24v4h24v-4z"/></svg>
                        </div>
                    </div>
                    <div class="wm-print">
                        <div class="wm-button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M14 20h-6v-1h6v1zm10-15v13h-4v6h-16v-6h-4v-13h4v-5h16v5h4zm-6 10h-12v7h12v-7zm0-13h-12v3h12v-3zm4 5.5c0-.276-.224-.5-.5-.5s-.5.224-.5.5.224.5.5.5.5-.224.5-.5zm-6 9.5h-8v1h8v-1z"/></svg>
                        </div>
                    </div>
                    <div class="wm-read">
                        <div class="wm-button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" xml:space="preserve" preserveAspectRatio='xMinYMin'><path d="M12 4.706c-2.938-1.83-7.416-2.566-12-2.706v17.714c3.937.12 7.795.681 10.667 1.995.846.388 1.817.388 2.667 0 2.872-1.314 6.729-1.875 10.666-1.995v-17.714c-4.584.14-9.062.876-12 2.706zm-10 13.104v-13.704c5.157.389 7.527 1.463 9 2.334v13.168c-1.525-.546-4.716-1.504-9-1.798zm20 0c-4.283.293-7.475 1.252-9 1.799v-13.171c1.453-.861 3.83-1.942 9-2.332v13.704zm-2-10.214c-2.086.312-4.451 1.023-6 1.672v-1.064c1.668-.622 3.881-1.315 6-1.626v1.018zm0 3.055c-2.119.311-4.332 1.004-6 1.626v1.064c1.549-.649 3.914-1.361 6-1.673v-1.017zm0-2.031c-2.119.311-4.332 1.004-6 1.626v1.064c1.549-.649 3.914-1.361 6-1.673v-1.017zm0 6.093c-2.119.311-4.332 1.004-6 1.626v1.064c1.549-.649 3.914-1.361 6-1.673v-1.017zm0-2.031c-2.119.311-4.332 1.004-6 1.626v1.064c1.549-.649 3.914-1.361 6-1.673v-1.017zm-16-6.104c2.119.311 4.332 1.004 6 1.626v1.064c-1.549-.649-3.914-1.361-6-1.672v-1.018zm0 5.09c2.086.312 4.451 1.023 6 1.673v-1.064c-1.668-.622-3.881-1.315-6-1.626v1.017zm0-2.031c2.086.312 4.451 1.023 6 1.673v-1.064c-1.668-.622-3.881-1.316-6-1.626v1.017zm0 6.093c2.086.312 4.451 1.023 6 1.673v-1.064c-1.668-.622-3.881-1.315-6-1.626v1.017zm0-2.031c2.086.312 4.451 1.023 6 1.673v-1.064c-1.668-.622-3.881-1.315-6-1.626v1.017z"/></svg>
                        </div>
                    </div>
                    <div class="wm-right-toggle">
                        <div class="wm-button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-.001 5.75c.69 0 1.251.56 1.251 1.25s-.561 1.25-1.251 1.25-1.249-.56-1.249-1.25.559-1.25 1.249-1.25zm2.001 12.25h-4v-1c.484-.179 1-.201 1-.735v-4.467c0-.534-.516-.618-1-.797v-1h3v6.265c0 .535.517.558 1 .735v.999z"/></svg>
                        </div>
                    </div>
                </div>
            </main>
            <aside class="wm-col wm-left-sidebar">
                <div class="wm-mobile-button">
                    Close
                </div>
                <div class="wm-article-meta">
                    ...
                </div>
                <div class="wm-module-area">
                    mod
                </div>
            </aside>
            <header class="wm-col wm-right-sidebar">
                <div class="wm-mobile-button">
                    Close
                </div>
                <div id="wm-logo-wrapper">
                    <img id="wm-logo" src="https://via.placeholder.com/250x250">
                </div>
                <nav id="wm-nav-wrapper">
                    ...
                </nav>
                <div class="wm-module-area">
                    mod
                </div>
                <div id="wm-dark-mode-wrapper">
                    <div id="wm-dark-mode-toggle" title="Toggle dark mode">
                        <label>
                            <input type="checkbox" name="">
                            <span></span>
                        </label>
                    </div>
                </div>
            </header>
        </div>
        <footer class="wm-row">
            Footer
        </footer>
    </body>
</html>