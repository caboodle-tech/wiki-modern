var WikiModern = (function(){

    var status = {
        'tablet': false,
        'page': true,
        'laptop': false
    };

    var theme_url = '';

    /**
    * Check if a string, number, array, or object is empty.
    *
    * NOTE: This correctly handles the built-in typeOf null equals object bug because a
    * custom typeOf function. Example: http://2ality.com/2013/10/typeof-null.html
    *
    * @author Stack Overflow Community
    * @author Christopher Keers <source@caboodle.tech>
    * @return boolean True if empty, null, 0, false, or of length 0 otherwise false is returned.
    */
    var empty = function( unknown ) {

        /** Don't waste time. */
        if (unknown==null || unknown=='undefined'){ return true; }

        /**
        * Fast way to get variables datatype. Original code: https://stackoverflow.com/a/7390612/3193156
        * Altered with Lily Finley's RegEx in the comments.
        */
        var type = typeOf(unknown);
        switch (type){
            case 'ARRAY':
                /** If the array is 0 it's empty. */
                if(unknown.length<1){ return true; }
                /** See if there is anything saved inside. */
                var tmp;
                for (var index in unknown) {
                    tmp = typeOf(unknown[index]);
                    if(tmp=='ARRAY' || tmp=='OBJECT'){
                        if(!empty(unknown[index])){ return false; }
                    } else {
                        if(unknown[index].length>0){ return false; }
                    }
                }
                return true;
                break;
            case 'NUMBER':
                if(unknown<0 || unknown>0){ return false; }
                return true;
                break;
                case 'FILE':
                /** If this is a true file object it should have a file size. */
                if (unknown.size>0){ return false; }
                return true;
                break;
            case 'OBJECT':
                /**
                * Original Code: https://stackoverflow.com/a/4994244/3193156
                */
                /** Assume if it has a length property with a non-zero value that that property is correct. */
                if (unknown.length > 0){ return false; }
                if (unknown.length === 0){ return true; }
                /**
                * Otherwise, does it have any properties of its own?
                * This doesn't handle toString and valueOf enumeration bugs in IE < 9
                */
                for (var key in unknown) {
                   if (hasOwnProperty.call(unknown, key)){ return false; }
                }
                return true;
                break;
            case 'STRING':
                /** Catch null that was cast as a string. */
                if(unknown.toLowerCase()=='null'){ return true; }
                /** Check that a empty string or number is not sneaking by. */
                if(unknown.length>0&&parseInt(unknown)!=0){ return false; }
                return true;
                break;
            case 'UNDEFINED':
            default:
                return true;
        }
    }

    var attachEvents = function(){

        /**
        * Shorten the code by adding events via loop.
        * 0 => Where to attach event to: window (w) or document (d).
        * 1 => Element to get by ID and attach this event to. Only valid when 0 => d
        * 2 => The type of event to listen for.
        * 3 => Function to call when the event happens.
        * 4 => Paramater to bind to (pass into) this function call.
        */
        var events = [
            [ 'w', null, 'resize', recordResize, null ],
            [ 'd', 'wm-hide-left-btn', 'click', toggleVisibility, 'wm-left-sidebar' ],
            [ 'd', 'wm-hide-left-laptop-btn', 'click', toggleVisibility, 'wm-left-sidebar' ],
            [ 'd', 'wm-hide-right-btn', 'click', toggleVisibility, 'wm-right-sidebar' ],
            [ 'd', 'wm-hide-right-laptop-btn', 'click', toggleVisibility, 'wm-right-sidebar' ],
            [ 'd', 'wm-reading-btn', 'click', toggleReadingMode, null ],
            [ 'd', 'wm-toggle-article-top-btn', 'click', toggleArticle, false ],
            [ 'd', 'wm-toggle-comments-top-btn', 'click', toggleComments, false ],
            [ 'd', 'wm-toggle-article-bottom-btn', 'click', toggleArticle, true ],
            [ 'd', 'wm-toggle-comments-bottom-btn', 'click', toggleComments, true ],
            [ 'd', 'wm-print-btn', 'click', printerStart, null ],
            [ 'd', 'wm-pagination-comment', 'change', handleCommentPagination, null ],
            [ 'd', 'wm-pagination-sort', 'change', handleCommentPagination, null ],
            [ 'd', 'wm-pagination-page', 'change', handleCommentPagination, null ],
        ];

        var len = events.length;
        var elem = '';
        for( var x = 0; x < len; x++ ){

            /** Get the element if this is one to get. */
            if( !empty( events[x][1] ) ){
                elem = document.getElementById( events[x][1] );
            }

            /** Attach the current event. */
            switch( events[x][0] ){
                case 'w':
                case 'W':
                case 'window':
                    window.addEventListener( events[x][2], events[x][3].bind( null, events[x][4] ) );
                    break;
                case 'd':
                case 'D':
                case 'document':
                    if( elem ){
                        elem.addEventListener( events[x][2], events[x][3].bind( null, events[x][4] ) );
                    }
                    break;
            }

            /** Reset any reference saved in elem. */
            elem = '';
        }
    };

    var handleCommentPagination = function(){
        var elems = [ 'wm-pagination-comment', 'wm-pagination-sort', 'wm-pagination-page' ];
        var flag = false;
        for( var x = 0; x < 3; x++ ){
            elems[x] = document.getElementById( elems[x] );
            if( elems[x] ){
                elems[x] = elems[x].value;
            } else {
                flag = true;
                break;
            }
        }
        if( !flag ){
            /*
            jQuery.post(
                my_foobar_client.ajaxurl,
                {
                    'action': 'foobar',
                    'foobar_id':   123
                },
                function(response) {
                    console.log('The server responded: ', response);
                }
            );
            */
            var elem = document.getElementById('wm-post-id');
            if( elem ){
                elems.unshift( elem.dataset.wmPostId );
                var data = {'options': elems };
                console.log(data);
                var xmlhttp;
                // compatible with IE7+, Firefox, Chrome, Opera, Safari
                //var url = theme_url + '/forms/wm-comment-pagination.php';
                var url = 'http://local.com/WORDPRESS/wp-admin/admin-ajax.php'
                xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function(){
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
                        var data = xmlhttp.responseText.split('||||');
                        var elem = '';
                        elem = document.getElementById('wm-comment-pagination-top-controls');
                        elem.innerHTML = data[0];
                        elem = document.getElementById('wm-comment-pagination-bottom-controls');
                        elem.innerHTML = data[0];
                        elem = document.getElementById('wm-comment-display-wrapper');
                        elem.innerHTML = data[1];

                        // WILL NEED TO RESET ALL EVENT LISTENERS. So far just the pagination controls.
                    }
                }
                xmlhttp.open("POST", url, true);
                xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xmlhttp.send('action=wm_comment_pagination&data='+JSON.stringify(data));
            }
        } else {
            // TODO: Show WARNING
        }
    };

    var printerStart = function(){

    };

    /**
    * Vanilla Javascript DOM Ready function supporting IE 8+.
    * @param {function} fn A function to call when the DOM is ready.
    * @see {@link http://youmightnotneedjquery.com/>}
    * @author adamfschwartz
    * @author zackbloom
    */
    var domReady = function(fn) {
        if (document.readyState != 'loading'){
            fn();
        } else if (document.addEventListener) {
            document.addEventListener('DOMContentLoaded', fn);
        } else {
            document.attachEvent('onreadystatechange', function(){
                if (document.readyState != 'loading'){
                    fn();
                }
            });
        }
    };

    var recordResize = function(){
        var elem = document.getElementById('wm-wrapper');
        if(!elem){ elem = document.body; }
        if(elem){
            var width = elem.clientWidth;
            if(width>1300){
                status.tablet = false;
                status.laptop = false;
            } else if(width>=1024) {
                status.tablet = false;
                status.laptop = true;
            } else {
                status.tablet = true;
                status.laptop = false;
            }
            /** Reset slide settings. */
            elem = document.getElementById('wm-left-sidebar');
            if(elem){
                if (elem.style.removeProperty) {
                    elem.style.removeProperty('width');
                    elem.style.removeProperty('opacity');
                    elem.style.removeProperty('display');
                    elem.style.removeProperty('left');
                } else {
                    elem.style.removeAttribute('width');
                    elem.style.removeAttribute('opacity');
                    elem.style.removeAttribute('display');
                    elem.style.removeAttribute('left');
                }
                elem.dataset.wmOriginalWidth = elem.clientWidth;
            }
            elem = document.getElementById('wm-right-sidebar');
            if(elem){
                if (elem.style.removeProperty) {
                    elem.style.removeProperty('width');
                    elem.style.removeProperty('opacity');
                    elem.style.removeProperty('display');
                    elem.style.removeProperty('right');
                } else {
                    elem.style.removeAttribute('width');
                    elem.style.removeAttribute('opacity');
                    elem.style.removeAttribute('display');
                    elem.style.removeAttribute('right');
                }
                elem.dataset.wmOriginalWidth = elem.clientWidth;
            }
        } else {
            /** Fatal error we need the browsers width! */
            console.error('Wiki Modern: We could not locate the #wm-wrapper element or the document.body element. Wiki Modern will not work without one of these!');
        }
    };

    var toggleArticle = function(bottom){
        var elems = [
            document.getElementById('wm-toggle-article-top-btn'),
            document.getElementById('wm-toggle-comments-top-btn'),
            document.getElementById('wm-toggle-article-bottom-btn'),
            document.getElementById('wm-toggle-comments-bottom-btn')
        ];
        var active = JSON.parse(elems[0].dataset.wmActive.toLowerCase());
        /** If already active ignore the button press. */
        if(!active){
            /** If at the bottom move to the top. */
            if(bottom){
                window.scrollTo({top: 0, behavior: "smooth"});
                /** Calculate how long to delay the transition. */
                var top = window.pageYOffset || document.documentElement.scrollTop;
                if( top && top > 1000 ){
                    top = parseInt( top * .10, 10);
                } else {
                    top = 0;
                }
                /** Transition with delay. */
                transition(document.getElementById('wm-post-container'), document.getElementById('wm-comments-container'), 0, top);
            } else {
                /** Transition now. */
                transition(document.getElementById('wm-post-container'), document.getElementById('wm-comments-container'), 0, 0);
            }
            /** Update dataset and styles. */
            elems[0].dataset.wmActive = true;
            elems[0].classList.add('wm-active');
            elems[2].classList.add('wm-active');
            elems[1].dataset.wmActive = false;
            elems[1].classList.remove('wm-active');
            elems[3].classList.remove('wm-active');
        }
        /** Force garbage collection. */
        elems = null;
    };

    var toggleComments = function(bottom){
        var elems = [
            document.getElementById('wm-toggle-article-top-btn'),
            document.getElementById('wm-toggle-comments-top-btn'),
            document.getElementById('wm-toggle-article-bottom-btn'),
            document.getElementById('wm-toggle-comments-bottom-btn')
        ];
        var active = JSON.parse(elems[1].dataset.wmActive.toLowerCase());
        /** If already active ignore the button press. */
        if(!active){
            /** If at the bottom move to the top. */
            if(bottom){
                window.scrollTo({top: 0, behavior: "smooth"});
                /** Calculate how long to delay the transition. */
                var top = window.pageYOffset || document.documentElement.scrollTop;
                if( top && top > 1000 ){
                    top = parseInt( top * .10, 10);
                } else {
                    top = 0;
                }
                /** Transition. */
                transition(document.getElementById('wm-comments-container'), document.getElementById('wm-post-container'), 0, top);
            } else {
                /** Transition. */
                transition(document.getElementById('wm-comments-container'), document.getElementById('wm-post-container'), 0, 0);
            }
            /** Update dataset and styles. */
            elems[0].dataset.wmActive = false;
            elems[0].classList.remove('wm-active');
            elems[2].classList.remove('wm-active');
            elems[1].dataset.wmActive = true;
            elems[1].classList.add('wm-active');
            elems[3].classList.add('wm-active');
        }
        /** Force garbage collection. */
        elems = null;
    };

    var transition = function(inElem, outElem, step, delay){

        var block = false;
        if( !empty(delay) ){
            if( delay > 0 ){
                block = true;
                setTimeout(function(){
                    transition(inElem, outElem, step, delay-950);
                }, 950);
            }
        }

        if( !block ){
            switch(step){
                case 0:
                    outElem.style.opacity = 1;
                    inElem.style.opacity = -.20;
                    break;
                case 5:
                    outElem.style.display = 'none';
                    inElem.style.display = 'block';
                    break;
                case 10:
                    inElem.style.opacity = 1;
                    break;
                default:
                    outElem.style.opacity = parseFloat(outElem.style.opacity) - .10;
                    inElem.style.opacity = parseFloat(inElem.style.opacity) + .10;
                    break;
            }
            if(step<10){
                setTimeout(function(){
                    transition(inElem, outElem, step+1, 0);
                }, 100);
            } else {
                /** Force garbage collection. */
                inElem = null;
                outElem = null;
                step = null;
            }
        }
    };

    var toggleProgress = function(toggleFlag, stopWidth, elem, slide){
        if(toggleFlag){
            if(slide==false){
                /** Open via sliding open. */
                if(elem.clientWidth<stopWidth){
                    elem.style.width = (elem.clientWidth + 10) + 'px';
                    setTimeout(toggleProgress.bind(null, toggleFlag, stopWidth, elem, false), 16);
                } else {
                    elem.style.width = stopWidth+'px';
                    elem.dataset.wmToggleBlock = 0;
                }
            } else {
                /** Open via slide out overlay. */
                var width = parseInt(elem.style[slide]);
                if(width<stopWidth){
                    elem.style[slide] = (width + 10) + 'px';
                    setTimeout(toggleProgress.bind(null, toggleFlag, stopWidth, elem, slide), 12);
                } else {
                    elem.style[slide] = '0px';
                    elem.dataset.wmToggleBlock = 0;
                }
            }
        } else {
            if(slide==false){
                /** Close via sliding close. */
                if(elem.clientWidth>stopWidth){
                    elem.style.width = (elem.clientWidth - 10) + 'px';
                    setTimeout(toggleProgress.bind(null, toggleFlag, stopWidth, elem, false), 16);
                } else {
                    elem.style.width = stopWidth+'px';
                    elem.style.display = 'none';
                    elem.dataset.wmToggleBlock = 0;
                }
            } else {
                /** Close via sliding out the overlay. */
                var width = parseInt(elem.style[slide]);
                if(width>stopWidth){
                    elem.style[slide] = (width - 10) + 'px';
                    setTimeout(toggleProgress.bind(null, toggleFlag, stopWidth, elem, slide), 12);
                } else {
                    elem.style[slide] = stopWidth+'px';
                    elem.dataset.wmToggleBlock = 0;
                    elem.style.opacity = 0;
                }
            }
        }
    };

    var toggleReadingMode = function(){
        /** Only respond to this if the page is showing both sides: desktop mode. */
        if(!status.laptop && !status.tablet){
            var flag = true;
            var elem = document.getElementById('wm-left-sidebar');
            if(elem){
                if(elem.clientWidth>0){
                    toggleVisibility('wm-left-sidebar');
                    flag = false;
                }
            }
            var elem = document.getElementById('wm-right-sidebar');
            if(elem){
                if(elem.clientWidth>0){
                    toggleVisibility('wm-right-sidebar');
                    flag = false;
                }
            }
            if(flag){
                toggleVisibility('wm-left-sidebar');
                toggleVisibility('wm-right-sidebar');
            }
        }
    }

    var toggleVisibility = function(id){
        var elem = document.getElementById(id);
        if(elem){
            if(status.laptop && !status.page){
                /** If on a post in laptop mode (1024 - 1300) overlay left sidebar. */
                if(id=="wm-left-sidebar"){
                    /** Check if we need to close. */
                    if(elem.style.left){
                        if(parseInt(elem.style.left)==0){
                            /** Close. */
                            var width = parseInt('-'+elem.dataset.wmOriginalWidth);
                            toggleProgress(false, width, elem, 'left');
                            return;
                        }
                    }
                    /** Auto-close left side if open.
                    var leftSide = document.getElementById('wm-left-sidebar');
                    if(leftSide){
                        if(leftSide.style.left){
                            if(parseInt(leftSide.style.left)==0){
                                /** Close.
                                var width = parseInt('-'+leftSide.dataset.wmOriginalWidth);
                                toggleProgress(false, width, leftSide, 'left');
                            }
                        }
                    }
                    */
                    /** Open. */
                    elem.style.opacity = 0;
                    elem.style.display = "block";
                    elem.dataset.wmOriginalWidth = elem.clientWidth;
                    elem.style.left = '-'+elem.clientWidth+'px';
                    elem.style.opacity = 1;
                    toggleProgress(true, 0, elem, 'left');
                    return;
                }
            } else if(status.tablet){
                /** Mobile mode (< 1024) overlay both sides instead. */
                if(id=="wm-left-sidebar"){
                    /** Check if we need to close. */
                    if(elem.style.left){
                        if(parseInt(elem.style.left)==0){
                            /** Close. */
                            var width = parseInt('-'+elem.dataset.wmOriginalWidth);
                            toggleProgress(false, width, elem, 'left');
                            return;
                        }
                    }
                    /** If on a post page auto-close right side if open. */
                    if(!status.page){
                        var rightSide = document.getElementById('wm-right-sidebar');
                        if(rightSide){
                            if(rightSide.style.right){
                                if(parseInt(rightSide.style.right)==0){
                                    /** Close. */
                                    var width = parseInt('-'+rightSide.dataset.wmOriginalWidth);
                                    toggleProgress(false, width, rightSide, 'right');
                                }
                            }
                        }
                    }
                    /** Open. */
                    elem.style.opacity = 0;
                    elem.style.display = "block";
                    elem.dataset.wmOriginalWidth = elem.clientWidth;
                    elem.style.left = '-'+elem.clientWidth+'px';
                    elem.style.opacity = 1;
                    toggleProgress(true, 0, elem, 'left');
                    return;
                }
                /** Right side; don't bother when on a page. */
                if(!status.page){
                    if(id=="wm-right-sidebar"){
                        /** Check if we need to close. */
                        if(elem.style.right){
                            if(parseInt(elem.style.right)==0){
                                /** Close. */
                                var width = parseInt('-'+elem.dataset.wmOriginalWidth);
                                toggleProgress(false, width, elem, 'right');
                                return;
                            }
                        }
                        /** Auto-close left side if open. */
                        var leftSide = document.getElementById('wm-left-sidebar');
                        if(leftSide){
                            if(leftSide.style.left){
                                if(parseInt(leftSide.style.left)==0){
                                    /** Close. */
                                    var width = parseInt('-'+leftSide.dataset.wmOriginalWidth);
                                    toggleProgress(false, width, leftSide, 'left');
                                }
                            }
                        }
                        /** Open. */
                        elem.style.opacity = 0;
                        elem.style.display = "block";
                        elem.dataset.wmOriginalWidth = elem.clientWidth;
                        elem.style.right = '-'+elem.clientWidth+'px';
                        elem.style.opacity = 1;
                        toggleProgress(true, 0, elem, 'right');
                        return;
                    }
                }
                return;
            }
            /** Dektop mode toggle normally. */
            if(typeOf(elem.dataset.wmToggleBlock)=='UNDEFINED'){
                elem.dataset.wmToggleBlock = 0;
            }
            if(elem.dataset.wmToggleBlock!=1){
                elem.dataset.wmToggleBlock = 1;
                if(elem.clientWidth>0){
                    /** Close side. */
                    elem.dataset.wmOriginalWidth = elem.clientWidth;
                    toggleProgress(false, 0, elem, false);
                } else {
                    /** Open side. */
                    var width = elem.dataset.wmOriginalWidth;
                    if (elem.style.removeProperty) {
                        elem.style.removeProperty('display');
                    } else {
                        elem.style.removeAttribute('display');
                    }
                    if(!width){ width = 280; }
                    toggleProgress(true, width, elem, false);
                }
            }
        }
    };

    /**
    * @author Stack Overflow Community
    * @return string Return the type (name) of what was sent in; result is in uppercase.
    */
    function typeOf(unknown){
        return ({}).toString.call(unknown).match(/\s([^\]]+)/)[1].toUpperCase();
    }

    /**
    * Once the DOM is ready this is called to setup everything we
    * need so the website works correctly and responsivly.
    */
    var initialize = function(){
        recordPage();
        recordResize();
        attachEvents();
        /** If on a post page activate the article, comments are hidden. */
        var elem = document.getElementById('wm-toggle-article-top-btn');
        if(elem){
            elem.dataset.wmActive = true;
        }
        elem = document.getElementById('wm-toggle-comments-top-btn');
        if(elem){
            elem.dataset.wmActive = false;
        }
    };

    /**
    * Getter to show WikiModern's state in a secure way.
    */
    var printStatus = function(){
        return status;
    }

    var recordPage = function(){
        var elem = document.getElementById('wm-wrapper');
        if(elem){
            var page = elem.dataset.wmPage;
            if(typeOf(page)!='UNDEFINED'){
                status.page = JSON.parse(page.toLowerCase());
            }
        }

        var elem = document.getElementById('wm-template-directory');
        if(elem){
            theme_url = elem.dataset.wmTemplateDirectory;
        }
    };

    /**
    * Self-initialize Wiki Modern scripts.
    * We can't just call initialize() because we need a lot of DOM elements.
    */
    domReady(initialize); // THIS MUST BE RIGHT BEFORE THE RETURN STATEMENT!

    return {
        'status': printStatus
    };
})();
