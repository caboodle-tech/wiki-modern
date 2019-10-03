var WikiModern = (function(){

    /** Declare all variables needed for Wiki Modern. */
    var status = {
        'device': 'desktop',
        'page': 'page',
        'scrollWidth': 15,
        'siteRoot': ''
    };

    var addQR = function(){
        var elem = document.getElementById('wm-article-qrcode');
        if( elem ){
            if( elem.dataset.wmCode != '1' ){
                var qr = new QRious( { element: elem } );
                qr.set({
                    background: 'white',
                    foreground: 'black',
                    level: 'H',
                    padding: 0,
                    size: 115,
                    value: location.protocol + '//' + location.host + location.pathname
                });
                elem.dataset.wmCode = '1';
            }
        }
    };

    /** Attach event listeners as needed to the page. */
    var attachEvents = function(){

        // Watch the page for resize events and respond accoringly.
        // Listen for the enter key and launch a search
        if( window.addEventListener ) {
            window.addEventListener( 'resize', refreshLayout, true );
            window.addEventListener( 'keydown', search, true );
        } else if( window.attachEvent ) {
            window.attachEvent('onresize', refreshLayout );
            window.attachEvent('keydown', search );
        } else {
            // Unsupported browser
        }
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
        if (document.readyState != 'loading'){
            fn();
        } else if (document.addEventListener) {
            document.addEventListener( 'DOMContentLoaded', fn );
        } else {
            document.attachEvent( 'onreadystatechange', function(){
                if (document.readyState != 'loading'){
                    fn();
                }
            });
        }
    };

    var dropdown = function(){
        var elem = event.target || event.srcElement;

        // This dropdown is for changing the post per page
        if( elem.dataset.wmShowValue ){
            var value = elem.dataset.wmShowValue;
            var cookie = elem.parentElement.dataset.wmCookieName;

            document.cookie = cookie + '=' + value + '; expires=' + getTimestamp() + '; path=/';
            location.reload();
        }

        // This dropdown is for changing the current page
        if( elem.dataset.wmLinkValue ){
            var value = elem.dataset.wmLinkValue;
            window.location.href = value;
        }

        // The user is toggling a dropdown, open or close it as needed
        if( elem.dataset.wmDropdown ){
            var value = elem.dataset.wmDropdown;

            if( value == 'open' ){
                // Close
                elem.classList.remove("wm-dropdown-open");
                elem.classList.add("wm-dropdown-closed");
                elem.dataset.wmDropdown = 'closed';
            } else {
                // Open
                elem.classList.remove("wm-dropdown-closed");
                elem.classList.add("wm-dropdown-open");
                elem.dataset.wmDropdown = 'open';
            }
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

    /** Returns the status (state) of Wiki Modern to the user. Meant for debugging only. */
    var getStatus = function(){
        return status;
    };

    var getTimestamp = function(){
        var date = new Date();
        date = date.setMonth( date.getMonth() + 1 );

        // We have to convert back to a date object
        date = new Date( date );
        var days = [ 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat' ];
        var months = [ 'Jan', 'Feb', 'Mar', 'April', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        var hours = date.getHours();
        if( hours < 10 ){ hours = '0' + hours; }
        var minutes = date.getMinutes();
        if( minutes < 10 ){ minutes = '0' + minutes; }
        var seconds = date.getSeconds();
        if( seconds < 10 ){ seconds = '0' + seconds; }
        return days[ date.getDay() ] + ', ' + date.getDate() + ' ' + months[ date.getMonth() ] + ' ' + date.getFullYear() + ' ' +  hours + ':' + minutes + ':' + seconds + ' UTC';
    };

    /**
    * Backwards compatible way to check if an DOM element contains a CSS class.
    * @see {@link https://stackoverflow.com/a/5898748/3193156}
    * @author Felix Kling
    * @param {element} elem The DOM element to check.
    * @param {string} className The class name to check for.
    * @returns {boolean} True if the element contains the class, false if not.
    */
    var hasClass = function( elem, className ) {
        return (' ' + elem.className + ' ').indexOf(' ' + className + ' ') > -1;
    };

    var recordDevice = function(){

        /** Get the main wrapper element or default to the page body. */
        var elem = document.getElementById('wm-page-wrapper');
        if( !elem ){
            elem = document.body;
        }

        /** Get an updated scrollbar width. */
        status.scrollWidth = getScrollbarWidth();

        /** Record what type of page we're on. */
        if( hasClass( elem, 'wm-page') ){
            status.page = 'page';
        } else {
            status.page = 'article';
        }

        /** Get the pages width. */
        var width = parseInt( elem.clientWidth + status.scrollWidth );

        if( width >= 1100 ){
            /** Both sidebars showing. */
            status.device = 'desktop';
        } else if( width >= 950 ) {
            /** Right sidebar hidden, display right side as pop over. */
            status.device = 'laptop';
        } else {
            /** Both sidebars hidden, display both sidebars as pop overs. */
            status.device = 'mobile';
        }
    };

    var recordSiteURL = function(){
        var elem = document.getElementById('wm-site-root');
        if( elem ){
            var url = elem.dataset.wmTemplateDirectory;
            elem.parentElement.removeChild( elem );
            var base = window.location.protocol + '//' + window.location.hostname;

            if( base == url ){
                status.siteRoot = base;
            } else if( base == url.substr( 0, base.length ) ){
                status.siteRoot = url;
            }
        }
    };

    var refreshLayout = function(){

        recordDevice();

        var elem = document.getElementById('wm-left-sidebar');

        if( status.device == 'mobile' ){
            /** Mobile mode has been triggered hide the left sidebar. */
            elem.dataset.wmWidth = elem.offsetWidth;
            elem.dataset.wmOffset = ( -1 * elem.offsetWidth );
            elem.dataset.wmVisibility = 0;
            elem.style.opacity = 0;
            elem.style.marginLeft = ( -1 * elem.offsetWidth ) + 'px';
            /** Update the margins on the content area in case the menu was already closed. */
            elem = document.getElementById('wm-content-inner-wrapper');
            elem.style.marginLeft = '0px';
        } else {
            /** Show the left sidebar again. */
            elem.dataset.wmWidth = elem.offsetWidth;
            elem.dataset.wmOffset = 0;
            elem.dataset.wmVisibility = 1;
            elem.style.opacity = 1;
            elem.style.marginLeft = 0 + 'px';
            /** Update the margins on the content area in case the menu was already closed. */
            //elem = document.getElementById('wm-content-inner-wrapper');
            //elem.style.marginLeft = '0px';
        }

        elem = document.getElementById('wm-right-sidebar');

        /** Don't do anything to the right sidebar if it's not visible on this page type. */
        if( status.page == 'article' ){

            switch( status.device ){
                case 'laptop':
                case 'mobile':
                    /** Mobile mode has been triggered hide the right sidebar. */
                    elem.dataset.wmWidth = elem.offsetWidth;
                    elem.dataset.wmOffset = ( -1 * elem.offsetWidth );
                    elem.dataset.wmVisibility = 0;
                    elem.style.opacity = 0;
                    elem.style.marginRight = ( -1 * elem.offsetWidth ) + 'px';
                    /** Update the margins on the content area in case the menu was already closed. */
                    elem = document.getElementById('wm-content-inner-wrapper');
                    elem.style.marginRight = '0px';
                    break;
                default:
                    /** Show the right sidebar again. */
                    elem.dataset.wmWidth = elem.offsetWidth;
                    elem.dataset.wmOffset = 0;
                    elem.dataset.wmVisibility = 1;
                    elem.style.opacity = 1;
                    elem.style.marginRight = 0 + 'px';
                    /** Update the margins on the content area in case the menu was already closed. */
                    //elem = document.getElementById('wm-content-inner-wrapper');
                    //elem.style.marginRight = '0px';
                    break;
            }
        }
    }

    var search = function(){
        var override = false;
        var elem = event.target || event.srcElement;
        if( elem.nodeName != 'DIV' ){
            elem = elem.parentElement;
        }
        if( elem.id == 'wm-search-button' ){
            override = true;
        }

        if ( ( event.which == 13 || event.keyCode == 13 ) == true || override == true ) {

            if( override ){
                elem = document.getElementById('wm-search');
            } else {
                elem = event.target || event.srcElement;
            }

            if( elem.id == 'wm-search' ){
                if( elem.value ){
                    if( status.siteRoot.length > 10 ){
                        window.location = encodeURI( status.siteRoot + '?s=' + elem.value );
                    } else {
                        window.location = encodeURI( location.protocol + '//' + location.host + location.pathname + '?s=' + elem.value );
                    }
                }
            }
        }
    };

    /**
    * Routes and runs the correct commands or functions in response
    * to the user pressing a toggle button; shows or hides things.
    *
    * @param {string} location The element in the page to toggle.
    */
    var toggle = function( location ){
        var elem = event.target || event.srcElement;
        switch( location ){
            case 'image-carousel':
                // TODO: Finish
                var container = document.getElementById('wm-image-carousel');
                if( container.dataset.wmDisplayStatus == 0 ){
                    // Open
                    carouselLoad( elem );
                    document.getElementById('wm-content-outter-wrapper').style.display = 'none';
                    document.getElementById('wm-footer-wrapper').style.display = 'none';
                    document.getElementById('wm-image-carousel').style.display = 'flex';
                    container.dataset.wmDisplayStatus = 1;
                } else {
                    // Close
                    // CAN NOT DO THIS LATER BECAUSE FLEX PREFIXES. ADD AND REMOVE A CLASS INSTEAD.
                    document.getElementById('wm-content-outter-wrapper').style.display = 'flex';
                    document.getElementById('wm-footer-wrapper').style.display = 'block';
                    document.getElementById('wm-image-carousel').style.display = 'none';
                    container.dataset.wmDisplayStatus = 0;
                }
                break;
            case 'left-sidebar':
                elem = document.getElementById('wm-left-sidebar');
                if( elem.dataset.wmVisibility == 0 ){
                    toggleOn( elem, 'Left' );
                } else {
                    toggleOff( elem, 'Left' );
                }
                break;
            case 'print-app':
                var container = document.getElementById('wm-page-wrapper');
                if( container.dataset.wmPrinterStatus == 0 ){
                    // Open print mode
                    container.classList.add('wm-print-mode');
                    container.dataset.wmPrinterStatus = 1;
                    // Change print font size
                    document.documentElement.classList.add('wm-alter-rem-12');
                    // Build and add the QR code if needed
                    addQR();
                } else {
                    // Close print mode
                    container.classList.remove('wm-print-mode');
                    container.dataset.wmPrinterStatus = 0;
                    // Wipe all print settings from the page
                    container.dataset.wmPrinterForms = 0;
                    container.classList.remove('wm-print-noform');
                    container.dataset.wmPrinterImages = 0;
                    container.classList.remove('wm-print-noimage');
                    container.dataset.wmPrinterMedia = 0;
                    container.classList.remove('wm-print-nomedia');
                    container.dataset.wmPrinterQrcode = 0;
                    container.classList.remove('wm-print-noqrcode');
                    // Change page font size
                    document.documentElement.classList.remove('wm-alter-rem-12');
                }
                break;
            case 'print-hide-forms':
                var container = document.getElementById('wm-page-wrapper');
                if( container.dataset.wmPrinterForms == 0 ){
                    // Hide images on print
                    container.classList.add('wm-print-noform');
                    container.dataset.wmPrinterForms = 1;
                } else {
                    // Show images on print
                    container.classList.remove('wm-print-noform');
                    container.dataset.wmPrinterForms = 0;
                }
                break;
            case 'print-hide-images':
                var container = document.getElementById('wm-page-wrapper');
                if( container.dataset.wmPrinterImages == 0 ){
                    // Hide images on print
                    container.classList.add('wm-print-noimage');
                    container.dataset.wmPrinterImages = 1;
                } else {
                    // Show images on print
                    container.classList.remove('wm-print-noimage');
                    container.dataset.wmPrinterImages = 0;
                }
                break;
            case 'print-hide-media':
                var container = document.getElementById('wm-page-wrapper');
                if( container.dataset.wmPrinterMedia == 0 ){
                    // Hide images on print
                    container.classList.add('wm-print-nomedia');
                    container.dataset.wmPrinterMedia = 1;
                } else {
                    // Show images on print
                    container.classList.remove('wm-print-nomedia');
                    container.dataset.wmPrinterMedia = 0;
                }
                break;
            case 'print-hide-qrcode':
                var container = document.getElementById('wm-page-wrapper');
                if( container.dataset.wmPrinterQrcode == 0 ){
                    // Hide qrcode on print
                    container.classList.add('wm-print-noqrcode');
                    container.dataset.wmPrinterQrcode = 1;
                } else {
                    // Show qrcode on print
                    container.classList.remove('wm-print-noqrcode');
                    container.dataset.wmPrinterQrcode = 0;
                }
                break;
            case 'print-page':
                window.print();
                break;
            case 'print-pdf':
                window.alert('This feature is not yet available. Please click the print button and then choose the PDF option.');
                break;
            case 'right-sidebar':
                elem = document.getElementById('wm-right-sidebar');
                if( elem.dataset.wmVisibility == 0 ){
                    toggleOn( elem, 'Right' );
                } else {
                    toggleOff( elem, 'Right' );
                }
                break;
            case 'reading-mode':
                toggleReadingMode();
                break;
            case 'show-article':
                togglePageContent( 'article' );
                break;
            case 'show-comments':
                togglePageContent( 'comments' );
                break;
            case 'bottom-show-article':
                var container = document.getElementById('wm-main-content');
                if( container.dataset.wmActive != 'article' ){
                    window.scrollTo( { top: 0, behavior: "smooth" } );
                    var wait = document.getElementById('wm-content-inner-wrapper').offsetHeight;
                    if( wait > 6000 ){
                        wait = Math.floor( wait / 10 );
                    } else {
                        wait = 10;
                    }
                    setTimeout( togglePageContent.bind( null, 'article' ), wait);
                }
                break;
            case 'bottom-show-comments':
                var container = document.getElementById('wm-main-content');
                if( container.dataset.wmActive != 'comments' ){
                    window.scrollTo( { top: 0, behavior: "smooth" } );
                    var wait = document.getElementById('wm-content-inner-wrapper').offsetHeight;
                    if( wait > 6000 ){
                        wait = Math.floor( wait / 10 );
                    } else {
                        wait = 10;
                    }
                    setTimeout( togglePageContent.bind( null, 'comments' ), wait);
                }
                break;
        }
    };

    /**
    * Gracefully hide the element from the page.
    * This function is only for the sidebars.
    *
    * @param {element} elem The element (sidebar) the user is trying to hide.
    * @param {string} side The sidebar we will be hiding.
    */
    var toggleOff = function( elem, side ){

        elem.dataset.wmWidth = elem.offsetWidth;
        elem.dataset.wmOffset = 0;
        elem.dataset.wmVisibility = 0;

        if( side == 'Right' && status.device == 'laptop' || status.device == 'mobile' ){

            /** If the page is in mobile or laptop mode. */
            var content = document.getElementById('wm-content-inner-wrapper');

            var interval = setInterval( function(){
                if( parseInt( elem.dataset.wmOffset ) < parseInt( elem.dataset.wmWidth ) && elem.dataset.wmVisibility == 0 ){
                    elem.dataset.wmOffset = parseInt( elem.dataset.wmOffset ) + 15;
                    elem.style['margin' + side] = ( -1 * parseInt( elem.dataset.wmOffset ) ) + 'px';

                    content.dataset.wmRightOffset = parseInt( content.dataset.wmRightOffset ) + 15;
                    content.style['margin' + side] = parseInt( content.dataset.wmRightOffset ) + 'px';
                } else {
                    elem.style['margin' + side] = ( -1 * parseInt( elem.dataset.wmWidth ) ) + 'px';
                    elem.dataset.wmOffset = '-' + elem.dataset.wmWidth;
                    elem.style.opacity = 0;

                    content.style['margin' + side] = '0px';
                    content.dataset.wmRightOffset = 0;
                    clearInterval( interval );
                }
            }, 25 );

        } else if ( side == 'Left' && status.device == 'mobile' ){

            /** If page is in mobile mode. */
            var content = document.getElementById('wm-content-inner-wrapper');

            var interval = setInterval( function(){
                if( parseInt( elem.dataset.wmOffset ) < parseInt( elem.dataset.wmWidth ) && elem.dataset.wmVisibility == 0 ){
                    elem.dataset.wmOffset = parseInt( elem.dataset.wmOffset ) + 15;
                    elem.style['margin' + side] = ( -1 * parseInt( elem.dataset.wmOffset ) ) + 'px';

                    content.dataset.wmLeftOffset = parseInt( content.dataset.wmLeftOffset ) + 15;
                    content.style['margin' + side] = parseInt( content.dataset.wmLeftOffset ) + 'px';
                } else {
                    elem.style['margin' + side] = ( -1 * parseInt( elem.dataset.wmWidth ) ) + 'px';
                    elem.dataset.wmOffset = '-' + elem.dataset.wmWidth;
                    elem.style.opacity = 0;

                    content.style['margin' + side] = '0px';
                    content.dataset.wmLeftOffset = 0;
                    clearInterval( interval );
                }
            }, 25 );
        } else {

            var interval = setInterval( function(){
                if( parseInt( elem.dataset.wmOffset ) < parseInt( elem.dataset.wmWidth ) && elem.dataset.wmVisibility == 0 ){
                    elem.dataset.wmOffset = parseInt( elem.dataset.wmOffset ) + 15;
                    elem.style['margin' + side] = ( -1 * parseInt( elem.dataset.wmOffset ) ) + 'px';
                } else {
                    elem.style['margin' + side] = ( -1 * parseInt( elem.dataset.wmWidth ) ) + 'px';
                    elem.dataset.wmOffset = '-' + elem.dataset.wmWidth;
                    elem.style.opacity = 0;
                    clearInterval( interval );
                }
            }, 25 );
        }
    }

    /**
    * Gracefully show the element on the page.
    * This function is only for the sidebars.
    *
    * @param {element} elem The element (sidebar) the user is trying to show.
    * @param {string} side The sidebar we will be showing.
    */
    var toggleOn = function( elem, side ){

        elem.dataset.wmVisibility = 1;
        elem.style.opacity = 1;

        if( status.device == 'mobile' ){

            if( side == 'Left' ){
                var opposite = document.getElementById('wm-right-sidebar');
                var oppositeSide = 'Right';
            } else {
                var opposite = document.getElementById('wm-left-sidebar');
                var oppositeSide = 'Left';
            }

            if( opposite.dataset.wmVisibility == 1 ){
                toggleOff( opposite, oppositeSide );
            }
        }

        if( side == 'Right' && status.device == 'laptop' || status.device == 'mobile' ){

            /** If the page is in any mode other than desktop mode. */
            var content = document.getElementById('wm-content-inner-wrapper');
            content.dataset.wmRightOffset = 0;

            var interval = setInterval( function(){
                if( parseInt( elem.dataset.wmOffset ) < 0 && elem.dataset.wmVisibility == 1 ){
                    elem.dataset.wmOffset = parseInt( elem.dataset.wmOffset ) + 15;
                    elem.style['margin' + side] = parseInt( elem.dataset.wmOffset ) + 'px';
                    content.dataset.wmRightOffset = parseInt( content.dataset.wmRightOffset ) - 15;
                    content.style['margin' + side] = parseInt( content.dataset.wmRightOffset ) + 'px';
                } else {
                    elem.style['margin' + side] = '0px';
                    content.style['margin' + side] = '-' + elem.dataset.wmWidth + 'px';
                    elem.dataset.wmOffset = 0;

                    content.dataset.wmRightOffset = -1 * parseInt( elem.dataset.wmWidth );
                    clearInterval( interval );
                }
            }, 25 );

        } else if ( side == 'Left' && status.device == 'mobile' ){

            /** If the page is in any mode other than desktop mode. */
            var content = document.getElementById('wm-content-inner-wrapper');
            content.dataset.wmLeftOffset = 0;

            var interval = setInterval( function(){
                if( parseInt( elem.dataset.wmOffset ) < 0 && elem.dataset.wmVisibility == 1 ){
                    elem.dataset.wmOffset = parseInt( elem.dataset.wmOffset ) + 15;
                    elem.style['margin' + side] = parseInt( elem.dataset.wmOffset ) + 'px';
                    content.dataset.wmLeftOffset = parseInt( content.dataset.wmLeftOffset ) - 15;
                    content.style['margin' + side] = parseInt( content.dataset.wmLeftOffset ) + 'px';
                } else {
                    elem.style['margin' + side] = '0px';
                    content.style['margin' + side] = '-' + elem.dataset.wmWidth + 'px';
                    elem.dataset.wmOffset = 0;

                    content.dataset.wmLeftOffset = -1 * parseInt( elem.dataset.wmWidth );
                    clearInterval( interval );
                }
            }, 25 );
        } else {

            var interval = setInterval( function(){
                if( parseInt( elem.dataset.wmOffset ) < 0 && elem.dataset.wmVisibility == 1 ){
                    elem.dataset.wmOffset = parseInt( elem.dataset.wmOffset ) + 15;
                    elem.style['margin' + side] = parseInt( elem.dataset.wmOffset ) + 'px';
                } else {
                    elem.style['margin' + side] = '0px';
                    elem.dataset.wmOffset = 0;
                    clearInterval( interval );
                }
            }, 25 );
        }
    }

    var togglePageContent = function( flag ){

        var container = document.getElementById('wm-main-content');

        /**
        * Only run the toggle after the previous call has finished.
        * This prevents ugly visual effects on the page.
        */
        if( container.dataset.wmSwitchingActive == 0 && container.dataset.wmActive != flag ){

            var articleContainer = document.getElementById('wm-article-container');
            var commentContainer = document.getElementById('wm-comment-container');
            container.dataset.wmSwitchingActive = 1;
            container.dataset.wmActive = flag;

            if( flag == 'article' ){

                articleContainer.style.opacity = 0;
                commentContainer.style.opacity = 1;
                var interval = setInterval( function(){
                    if( parseFloat( commentContainer.style.opacity ) > .1 ){
                        commentContainer.style.opacity = parseFloat( commentContainer.style.opacity ) - .1;
                    } else if( parseFloat( articleContainer.style.opacity ) == 0 ){
                        commentContainer.style.opacity = 0;
                        commentContainer.style.display = 'none';
                        articleContainer.style.display = 'block';
                        articleContainer.style.opacity = .1;
                    } else if( parseFloat( articleContainer.style.opacity ) < .9 ){
                        articleContainer.style.opacity = parseFloat( articleContainer.style.opacity ) + .1;
                    } else {
                        articleContainer.style.opacity = 1;
                        container.dataset.wmSwitchingActive = 0;
                        clearInterval( interval );
                    }
                }, 75 );
            }

            if( flag == 'comments' ){

                articleContainer.style.opacity = 1;
                commentContainer.style.opacity = 0;

                var interval = setInterval( function(){
                    if( parseFloat( articleContainer.style.opacity ) > .1 ){
                        articleContainer.style.opacity = parseFloat( articleContainer.style.opacity ) - .1;
                    } else if( parseFloat( commentContainer.style.opacity ) == 0 ){
                        articleContainer.style.opacity = 0;
                        articleContainer.style.display = 'none';
                        commentContainer.style.display = 'block';
                        commentContainer.style.opacity = .1;
                    } else if( parseFloat( commentContainer.style.opacity ) < .9 ){
                        commentContainer.style.opacity = parseFloat( commentContainer.style.opacity ) + .1;
                    } else {
                        commentContainer.style.opacity = 1;
                        container.dataset.wmSwitchingActive = 0;
                        clearInterval( interval );
                    }
                }, 75 );
            }
        }
    };

    /**
    * Gracefully hides or shows elements (sidebars) from the page.
    */
    var toggleReadingMode = function(){
        var left = document.getElementById('wm-left-sidebar');
        var right = document.getElementById('wm-right-sidebar');
        if( left.dataset.wmVisibility == 0 && right.dataset.wmVisibility == 0 ){
            toggleOn( left, 'Left' );
            toggleOn( right, 'Right' );
        } else if( left.dataset.wmVisibility == 1 && right.dataset.wmVisibility == 1 ) {
            toggleOff( left, 'Left' );
            toggleOff( right, 'Right' );
        } else {
            if( !left.dataset.wmVisibility ){
                toggleOff( left, 'Left' );
            } else if( left.dataset.wmVisibility == 1 ){
                toggleOff( left, 'Left' );
            }
            if( !right.dataset.wmVisibility ){
                toggleOff( right, 'Right' );
            } else if( right.dataset.wmVisibility == 1 ){
                toggleOff( right, 'Right' );
            }
        }
    }

    var carouselRotate = function( direction ){
        var stage = document.getElementById('wm-image-stage');
        var active = stage.querySelector('.wm-active');
        var replacement = '';
        if( direction == 'left' ){
            replacement = active.previousElementSibling;
            if( !replacement  ){
                replacement = stage.lastElementChild;
            }
        } else {
            replacement = active.nextElementSibling;
            if( !replacement  ){
                replacement = stage.firstElementChild;
            }
        }
        active.classList.remove('wm-active');
        active.style.opacity = '.9';
        active.style.zIndex = '0';
        replacement.classList.add('wm-active');
        replacement.style.opacity = '.1';
        replacement.style.zIndex = '5';
        replacement.style.display = 'flex';
        var imageFade = setInterval( function(){
            var activeOpacity = parseFloat( active.style.opacity );
            var replacementOpacity = parseFloat( replacement.style.opacity );
            if( activeOpacity > 0 ){
                active.style.opacity = activeOpacity - .10;
                replacement.style.opacity = replacementOpacity + .10;
            } else {
                active.style.opacity = 0;
                active.style.display = 'none';
                replacement.style.opacity = 1;
                clearInterval( imageFade );
            }
        }, 90 );
    };

    var carouselLoad = function( elem ){
        elem = elem.parentElement.parentElement;
        var sources = elem.querySelector('.wm-image-sources');
        sources = sources.innerHTML;
        sources = sources.replace( '<!--', '');
        sources = sources.replace( '-->', '');
        sources = sources.split('||');

        var html = '';
        var len = sources.length;
        var dynamicHtml = 'class="wm-image-on-stage wm-active" style="display: flex; opacity: 1;"';
        for( var x = 0; x < len; x++ ){
            if( x > 0 ){ dynamicHtml = 'class="wm-image-on-stage" style="display: none; opacity: 0;"'; }
            html += '<div ' + dynamicHtml + '>' + sources[x] + '</div>';
        }

        document.getElementById('wm-image-stage').innerHTML = html;
    };

    var navigate = function(){
        var elem = event.target || event.srcElement;
        if( !elem.classList.contains('wm-article-content') ){
            elem = elem.closest('.wm-article-content');
        }
        var url = elem.dataset.wmNavigation;
        if( url ){
            window.location.href = url;
        }
    };

    /** ==========[ INITIALIZATION FUNCTION & RETURN CALL ONLY PAST THIS POINT ]========== */

    /**
    * Once the DOM is ready this is called to setup everything we
    * need so the website works correctly and responsivly.
    */
    var initialize = function(){

        // Record the site root URL
        recordSiteURL();

        /** Refresh the layout: Record device category and resize page as needed. */
        refreshLayout();

        /** Attach event listeners. */
        attachEvents();

        /** Set printer state to off when page first loads. */
        var container = document.getElementById('wm-page-wrapper');
        container.dataset.wmPrinterStatus = 0;
        container.dataset.wmPrinterForms = 0;
        container.dataset.wmPrinterImages = 0;
        container.dataset.wmPrinterMedia = 0;
        container.dataset.wmPrinterQrcode = 0;

        /** Set image carousel state to off when page first loads. */
        container = document.getElementById('wm-image-carousel');
        container.dataset.wmDisplayStatus = 0;

        /** Set default dataset values needed by toggle() and it's helper functions. */
        container = document.getElementById('wm-main-content');
        container.dataset.wmSwitchingActive = 0;
        container.dataset.wmActive = 'article';
    };

    /**
    * Self-initialize Wiki Modern scripts.
    *
    * This must be right before the return statment! We can not just call
    * initialize() because we need a lot of DOM elements in place first.
    */
    domReady( initialize );

    return {
        'carouselRotate': carouselRotate,
        'dropdown': dropdown,
        'navigate': navigate,
        'search': search,
        'status': getStatus,
        'toggle': toggle
    };

})();
