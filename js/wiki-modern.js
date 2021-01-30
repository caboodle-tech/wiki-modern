var WM = ( function() {
    
    var elems = {};
    var timer = {};
    var stats = {};

    /** Attach event listeners as needed to the page. */
    var attachEvents = function(){

        var elem = '';

        // Watch the page for resize events and respond accoringly.
        window.addEventListener( 'resize', refreshLayout, true );

        // Toggle reading mode.
        document.getElementById( 'wm-dark-mode-toggle' ).addEventListener( 'change', toggleDarkMode );

        // Open print controls.
        elem = elems.topControls.querySelector( '.wm-print .wm-button' );
        elem.addEventListener( 'click', togglePrintMode, true );

        // Close print controls.
        elem = elems.printControls.querySelector( '.wm-close-button' );
        elem.addEventListener( 'click', togglePrintMode, true );

        // Print document.
        elem = elems.printControls.querySelector( '.wm-right-column .wm-print' );
        elem.addEventListener( 'click', window.print.bind( window ), true );

        // Print document.
        elem = elems.printControls.querySelector( '.wm-right-column .wm-download' );
        elem.addEventListener( 'click', downloadPdf, true );

        // Print document.
        elem = elems.printControls.querySelectorAll( '.wm-left-column input[type="checkbox"]' );
        elem.forEach( function( toggle ) {
            toggle.addEventListener( 'change', togglePrintSetting, true );
        } );

        // Toggle right sidebar.
        elem = elems.topControls.querySelector( '.wm-right-toggle .wm-button' );
        elem.addEventListener( 'click', toggleSiderbar.bind( null, 'right' ), true );

        // Toggle left sidebar.
        elem = elems.topControls.querySelector( '.wm-left-toggle .wm-button' );
        elem.addEventListener( 'click', toggleSiderbar.bind( null, 'left' ), true );

        // Toggle right sidebar mobile button.
        elem = elems.rightSidebar.querySelector( '.wm-mobile-button .wm-close-button' );
        elem.addEventListener( 'click', toggleSiderbar.bind( null, 'right' ), true );

        // Toggle left sidebar mobile button.
        elem = elems.leftSidebar.querySelector( '.wm-mobile-button .wm-close-button' );
        elem.addEventListener( 'click', toggleSiderbar.bind( null, 'left' ), true );

        // Toggle reading mode.
        elem = elems.topControls.querySelector( '.wm-read .wm-button' );
        elem.addEventListener( 'click', toggleReadingMode, true );

        // Toggle an inline dropdown menu.
        elem = elems.content.querySelectorAll( '.wm-inline-dropdown' );
        elem.forEach( function( inline ) {
            inline.addEventListener( 'click', toggleInlineDropdown );
        } );

        // Close open inline dropdowns when the user clicks elsewhere.
        document.body.addEventListener( 'click', closeInlineDropdowns );
    };

    var closeInlineDropdowns = function() {
        var elem = elems.content.querySelectorAll( '.wm-inline-dropdown.wm-open' );
        elem.forEach( function( inline ) {
            inline.classList.remove( 'wm-open' );
        } );
    };

    /**
     * Vanilla Javascript DOM Ready function supporting IE 8+.
     *
     * @param {function} fn A function to call when the DOM is ready.
     * @see {@link http://youmightnotneedjquery.com/>}
     * @author adamfschwartz
     * @author zackbloom
     */
    var domReady = function( fn ) {
        if ( document.readyState != 'loading' ){
            fn();
        } else if (document.addEventListener) {
            document.addEventListener( 'DOMContentLoaded', fn );
        } else {
            document.attachEvent( 'onreadystatechange', function(){
                if ( document.readyState != 'loading' ){
                    fn();
                }
            });
        }
    };

    var downloadPdf = function() {
        alert( 'Coming soon!' );
    };

    /**
     * Using a hidden div calculate the width of scroll bars in the users browser.
     * @returns {integer} The width in pixels of a scroll bar in the users browser.
     */
    var getScrollbarWidth = function(){
        var outter = document.getElementById('wm-scrollbar-check-outter');
        var inner = document.getElementById('wm-scrollbar-check-inner');
        return outter.offsetWidth - inner.offsetWidth;
    };

    var initialize = function() {

        // Record reference to elements.
        elems.page = document.body;
        elems.content = document.querySelector( 'main.wm-main-content' );
        elems.topControls = document.querySelector( '#wm-top-controls-wrapper' );
        elems.printControls = document.querySelector( '#wm-print-controls-wrapper' );
        elems.leftSidebar = document.querySelector( 'aside.wm-left-sidebar' );
        elems.rightSidebar = document.querySelector( 'header.wm-right-sidebar' );
        elems.footer = document.querySelector( 'footer.wm-footer' );

        // Setup the pages layout.
        refreshLayout();

        attachEvents();

    };

    var recordDevice = function() {

        // Get an updated scrollbar width.
        stats.scrollWidth = getScrollbarWidth();

        // Get the pages width.
        var width = parseInt( elems.page.clientWidth + stats.scrollWidth );
        

        if( width >= 1200 ){
            // Both sidebars showing.
            stats.device = 'desktop';
        } else if( width >= 1024 ) {
            // Left sidebar hidden, display left side as pop over.
            stats.device = 'laptop';
        } else {
            // Both sidebars hidden, display both sidebars as pop overs.
            stats.device = 'mobile';
        }

        // Update stats
        stats.widthLast    = stats.widthCurrent;
        stats.widthCurrent = width;
    };

    var refreshLayout = function(){

        recordDevice();

        /**
         * Prevent bug on mobile devices where resize is constantly triggered by
         * the phones navigation controls going into hidden mode and then forced
         * back on because the page resize.
         */
        if ( stats.widthLast != stats.widthCurrent ) {

            // Catch edge case where a sidebar is opening and the page resizes.
            if ( timer.leftSidebar ) {
                clearInterval( timer.leftSidebar );
                timer.leftSidebar = null;
            }
            if ( timer.rightSidebar ) {
                clearInterval( timer.rightSidebar );
                timer.rightSidebar = null;
            }

            // Reset the content areas margin.
            elems.content.style.marginLeft = 0;
            elems.content.style.marginRight = 0;

            if ( elems.leftSidebar ) {

                switch( stats.device ){
                    case 'laptop':
                    case 'mobile':
                        // Mobile mode has been triggered hide the right sidebar.
                        elems.leftSidebar.dataset.wmWidth = elems.leftSidebar.offsetWidth;
                        elems.leftSidebar.dataset.wmOffset = ( -1 * elems.leftSidebar.offsetWidth );
                        elems.leftSidebar.dataset.wmVisibility = 0;
                        elems.leftSidebar.style.opacity = 0;
                        elems.leftSidebar.style.marginLeft = ( -1 * elems.leftSidebar.offsetWidth ) + 'px';
                        elems.leftSidebar.classList.add( 'wm-closed' );
                        break;
                    default:
                        // Show the right sidebar again.
                        elems.leftSidebar.dataset.wmWidth = elems.leftSidebar.offsetWidth;
                        elems.leftSidebar.dataset.wmOffset = 0;
                        elems.leftSidebar.dataset.wmVisibility = 1;
                        elems.leftSidebar.style.opacity = 1;
                        elems.leftSidebar.style.marginLeft = 0 + 'px';
                        elems.leftSidebar.classList.remove( 'wm-closed' );
                        break;
                }
            }

            if ( elems.rightSidebar ) {

                if( stats.device == 'mobile' ){
                    // Mobile mode has been triggered hide the left sidebar.
                    elems.rightSidebar.dataset.wmWidth = elems.rightSidebar.offsetWidth;
                    elems.rightSidebar.dataset.wmOffset = ( -1 * elems.rightSidebar.offsetWidth );
                    elems.rightSidebar.dataset.wmVisibility = 0;
                    elems.rightSidebar.style.opacity = 0;
                    elems.rightSidebar.style.marginRight = ( -1 * elems.rightSidebar.offsetWidth ) + 'px';
                    elems.rightSidebar.classList.add( 'wm-closed' );
                } else {
                    // Show the left sidebar again.
                    elems.rightSidebar.dataset.wmWidth = elems.rightSidebar.offsetWidth;
                    elems.rightSidebar.dataset.wmOffset = 0;
                    elems.rightSidebar.dataset.wmVisibility = 1;
                    elems.rightSidebar.style.opacity = 1;
                    elems.rightSidebar.style.marginRight = 0 + 'px';
                    elems.rightSidebar.classList.remove( 'wm-closed' );
                }
            }
        } 

    };

    var toggleDarkMode = function() {
        setTimeout( function() {
            if ( Cookies.get( 'wm-dark-mode' ) ) {
                Cookies.remove( 'wm-dark-mode' );
            } else {
                Cookies.set( 'wm-dark-mode', 'True', { expires: 90 } );
            }
            window.location.reload();
        }, 750 );
    };

    var toggleInlineDropdown = function() {
        event.preventDefault();
        event.stopPropagation();
        if ( this.classList.contains( 'wm-open' ) ) {
            this.classList.remove( 'wm-open' );
        } else {
            closeInlineDropdowns();
            this.classList.add( 'wm-open' );
        }        
    };

    var togglePrintMode = function() {
        // Is print mode already open?
        if ( document.body.classList.contains( 'wm-print-mode' ) ) {
            // Yes. Remove print classes from body.
            document.body.classList.remove( 'wm-print-no-images' );
            document.body.classList.remove( 'wm-print-no-media' );
            document.body.classList.remove( 'wm-print-no-forms' );
            document.body.classList.remove( 'wm-print-no-qr' );
        } else {
            // No. Add any disabled print classes to the body.
            ops = elems.printControls.querySelectorAll( '.wm-left-column input[type="checkbox"]' );
            ops.forEach( function( op ) {
                if ( op.checked ) {
                    document.body.classList.add( op.name.toLowerCase() );
                }
            } );
        }
        // Toggle print mode visually.
        document.body.classList.toggle( 'wm-print-mode' );
    };

    var togglePrintSetting = function() {
        if ( this.name ) {
            // Do we have an existing cookie?
            var obj = Cookies.getJSON( 'wm-print-settings' );
            if ( ! obj ) {
                // No make it first.
                obj = {
                    'wm-print-no-images': false,
                    'wm-print-no-media': false,
                    'wm-print-no-forms': false,
                    'wm-print-no-qr': false
                }
            }
            // Update toggle on page.
            var name = this.name.toLowerCase();
            document.body.classList.toggle( name );
            // Update print settings object and save/update cookie.
            obj[ name ] = this.checked;
            Cookies.set( 'wm-print-settings', obj, { expires: 90 } );
        }
    };

    var toggleReadingMode = function() {
        if ( stats.device == 'laptop' || stats.device == 'desktop' ) {
            var closeFlag = false;
            // Close right sidebar if its open.
            if ( elems.rightSidebar.dataset.wmVisibility == '1' ) {
                toggleSiderbar( 'right' );
                closeFlag = true;
            }
            // Close left sidebar if its open.
            if ( elems.leftSidebar.dataset.wmVisibility == '1' ) {
                toggleSiderbar( 'left' );
                closeFlag = true;
            }
            // Open the sidebars if both were already closed.
            if ( ! closeFlag ) {
                toggleSiderbar( 'right' );
                toggleSiderbar( 'left' );
            }
        }
    };

    var toggleSiderbar = function( side ) {

        switch( side.toUpperCase() ) {
            case 'LEFT':
                // Do not allow multiple calls, abort if timer exists still.
                if ( timer.leftSidebar ) {
                    return;
                }
                if ( elems.leftSidebar.dataset.wmVisibility == '0' ) {
                    // Open.
                    if ( stats.device == 'mobile' && elems.rightSidebar.dataset.wmVisibility == '1' ) {
                        toggleSiderbar( 'right' );
                    }
                    elems.leftSidebar.classList.remove( 'wm-closed' );
                    elems.leftSidebar.style.opacity = 1;
                    elems.leftSidebar.dataset.wmVisibility = 1;
                    timer.leftSidebar = setInterval( function() {
                        var max = parseInt( elems.leftSidebar.dataset.wmWidth );
                        var cur = parseInt( elems.leftSidebar.dataset.wmOffset );
                        if ( cur < 0 ) {
                            if ( stats.device == 'mobile' || stats.device == 'laptop' ) {
                                elems.content.style.marginLeft = ( - ( max + cur + 15 ) ) + 'px';
                            }
                            elems.leftSidebar.dataset.wmOffset = cur + 15;
                            elems.leftSidebar.style.marginLeft = ( cur + 15 ) + 'px';
                        } else {
                            if ( stats.device == 'mobile' || stats.device == 'laptop' ) {
                                elems.content.style.marginLeft = ( - max ) + 'px';
                            }
                            clearInterval( timer.leftSidebar );
                            timer.leftSidebar = null;
                        }
                    }, 30 );
                } else {
                    // Close.
                    elems.leftSidebar.dataset.wmVisibility = 0;
                    timer.leftSidebar = setInterval( function() {
                        var max = parseInt( elems.leftSidebar.dataset.wmWidth );
                        var cur = parseInt( elems.leftSidebar.dataset.wmOffset );
                        if ( cur > max * - 1 ) {
                            if ( stats.device == 'mobile' || stats.device == 'laptop' ) {
                                elems.content.style.marginLeft = ( - ( max + cur ) + 15 ) + 'px';
                            }
                            elems.leftSidebar.dataset.wmOffset = cur - 15;
                            elems.leftSidebar.style.marginLeft = ( cur - 15 ) + 'px';
                        } else {
                            if ( stats.device == 'mobile' || stats.device == 'laptop' ) {
                                elems.content.style.marginLeft = '0px';
                            }
                            elems.leftSidebar.classList.add( 'wm-closed' );
                            elems.leftSidebar.style.opacity = 0;
                            clearInterval( timer.leftSidebar );
                            timer.leftSidebar = null;
                        }
                    }, 30 );
                }
                break;
            case 'RIGHT':
                // Do not allow multiple calls, abort if timer exists still.
                if ( timer.rightSidebar ) {
                    return;
                }
                if ( elems.rightSidebar.dataset.wmVisibility == '0' ) {
                    // Open.
                    if ( stats.device == 'mobile' && elems.leftSidebar.dataset.wmVisibility == '1' ) {
                        toggleSiderbar( 'left' );
                    }
                    elems.rightSidebar.classList.remove( 'wm-closed' );
                    elems.rightSidebar.style.opacity = 1;
                    elems.rightSidebar.dataset.wmVisibility = 1;
                    timer.rightSidebar = setInterval( function() {
                        var max = parseInt( elems.rightSidebar.dataset.wmWidth );
                        var cur = parseInt( elems.rightSidebar.dataset.wmOffset );
                        if ( cur < 0 ) {
                            if ( stats.device == 'mobile' ) {
                                elems.content.style.marginRight = ( - ( max + cur + 15 ) ) + 'px';
                            }
                            elems.rightSidebar.dataset.wmOffset = cur + 15;
                            elems.rightSidebar.style.marginRight = ( cur + 15 ) + 'px';
                        } else {
                            if ( stats.device == 'mobile' ) {
                                elems.content.style.marginRight = ( - max ) + 'px';
                            }
                            clearInterval( timer.rightSidebar );
                            timer.rightSidebar = null;
                        }
                    }, 25 );
                } else {
                    // Close.
                    elems.rightSidebar.dataset.wmVisibility = 0;
                    timer.rightSidebar = setInterval( function() {
                        var max = parseInt( elems.rightSidebar.dataset.wmWidth );
                        var cur = parseInt( elems.rightSidebar.dataset.wmOffset );
                        if ( cur > max * - 1 ) {
                            if ( stats.device == 'mobile' ) {
                                elems.content.style.marginRight = ( - ( max + cur ) + 15 ) + 'px';
                            }
                            elems.rightSidebar.dataset.wmOffset = cur - 15;
                            elems.rightSidebar.style.marginRight = ( cur - 15 ) + 'px';
                        } else {
                            if ( stats.device == 'mobile' ) {
                                elems.content.style.marginRight = '0px';
                            }
                            elems.rightSidebar.classList.add( 'wm-closed' );
                            elems.rightSidebar.style.opacity = 0;
                            clearInterval( timer.rightSidebar );
                            timer.rightSidebar = null;
                        }
                    }, 25 );
                }
                break;
            default:
                return;
        }

    };

    domReady( initialize );

    return {
        toggleSiderbar: toggleSiderbar,
        stats: stats
    };

} )();