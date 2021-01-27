var WM = ( function() {
    
    var elems = {};
    var timer = {};
    var stats = {};

    /** Attach event listeners as needed to the page. */
    var attachEvents = function(){

        // Watch the page for resize events and respond accoringly.
        window.addEventListener( 'resize', refreshLayout, true );

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
        elems.content = document.querySelector( 'main' );
        elems.leftSidebar = document.querySelector( 'aside' );
        elems.rightSidebar = document.querySelector( 'header' );
        elems.footer = document.querySelector( 'footer' );

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

    };

    var refreshLayout = function(){

        recordDevice();

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
                if ( timer.leftSidebar ) {
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
        toggleSiderbar: toggleSiderbar
    };

} )();