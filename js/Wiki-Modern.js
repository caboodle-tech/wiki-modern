var WikiModern = (function(){

    var status = {
        'tablet': false,
        'page': true,
        'laptop': false
    };

    var attachEvents = function(){
        /** Watch the window for resizing. */
        window.addEventListener('resize', recordResize);
        /** Handle button clicks that effect the page. */
        var elem = document.getElementById('wm-hide-left-btn');
        if(elem){
            elem.addEventListener('click', toggleVisibility.bind(null, 'wm-left-sidebar'));
        }
        elem = document.getElementById('wm-hide-left-laptop-btn');
        if(elem){
            elem.addEventListener('click', toggleVisibility.bind(null, 'wm-left-sidebar'));
        }
        elem = document.getElementById('wm-hide-right-btn');
        if(elem){
            elem.addEventListener('click', toggleVisibility.bind(null, 'wm-right-sidebar'));
        }
        elem = document.getElementById('wm-hide-right-laptop-btn');
        if(elem){
            elem.addEventListener('click', toggleVisibility.bind(null, 'wm-right-sidebar'));
        }
        elem = document.getElementById('wm-reading-btn');
        if(elem){
            elem.addEventListener('click', toggleReadingMode);
        }
        elem = document.getElementById('wm-toggle-article-top-btn');
        if(elem){
            elem.addEventListener('click', toggleArticle.bind(null, false));
        }
        elem = document.getElementById('wm-toggle-comments-top-btn');
        if(elem){
            elem.addEventListener('click', toggleComments.bind(null, false));
        }
        elem = document.getElementById('wm-toggle-article-bottom-btn');
        if(elem){
            elem.addEventListener('click', toggleArticle.bind(null, true));
        }
        elem = document.getElementById('wm-toggle-comments-bottom-btn');
        if(elem){
            elem.addEventListener('click', toggleComments.bind(null, true));
        }
        /** Handle printing. */
        elem = document.getElementById('wm-print-btn');
        if(elem){
            elem.addEventListener('click', printerStart);
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
                elem.dataset.wkOriginalWidth = elem.clientWidth;
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
                elem.dataset.wkOriginalWidth = elem.clientWidth;
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
        var active = JSON.parse(elems[0].dataset.wkActive.toLowerCase());
        /** If already active ignore the button press. */
        if(!active){
            /** If at the bottom move to the top. */
            if(bottom){
                window.scrollTo({top: 0, behavior: "smooth"});
            }
            /** Transition. */
            transition(document.getElementById('wm-post-container'), document.getElementById('wm-comments-container'), 0);
            /** Update dataset and styles. */
            elems[0].dataset.wkActive = true;
            elems[0].classList.add('wm-active');
            elems[2].classList.add('wm-active');
            elems[1].dataset.wkActive = false;
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
        var active = JSON.parse(elems[1].dataset.wkActive.toLowerCase());
        /** If already active ignore the button press. */
        if(!active){
            /** If at the bottom move to the top. */
            if(bottom){
                window.scrollTo({top: 0, behavior: "smooth"});
            }
            /** Transition. */
            transition(document.getElementById('wm-comments-container'), document.getElementById('wm-post-container'), 0);
            /** Update dataset and styles. */
            elems[0].dataset.wkActive = false;
            elems[0].classList.remove('wm-active');
            elems[2].classList.remove('wm-active');
            elems[1].dataset.wkActive = true;
            elems[1].classList.add('wm-active');
            elems[3].classList.add('wm-active');
        }
        /** Force garbage collection. */
        elems = null;
    };

    var transition = function(inElem, outElem, step){
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
                transition(inElem, outElem, step+1);
            }, 100);
        } else {
            /** Force garbage collection. */
            inElem = null;
            outElem = null;
            step = null;
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
                    elem.dataset.wkToggleBlock = 0;
                }
            } else {
                /** Open via slide out overlay. */
                var width = parseInt(elem.style[slide]);
                if(width<stopWidth){
                    elem.style[slide] = (width + 10) + 'px';
                    setTimeout(toggleProgress.bind(null, toggleFlag, stopWidth, elem, slide), 12);
                } else {
                    elem.style[slide] = '0px';
                    elem.dataset.wkToggleBlock = 0;
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
                    elem.dataset.wkToggleBlock = 0;
                }
            } else {
                /** Close via sliding out the overlay. */
                var width = parseInt(elem.style[slide]);
                if(width>stopWidth){
                    elem.style[slide] = (width - 10) + 'px';
                    setTimeout(toggleProgress.bind(null, toggleFlag, stopWidth, elem, slide), 12);
                } else {
                    elem.style[slide] = stopWidth+'px';
                    elem.dataset.wkToggleBlock = 0;
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
                            var width = parseInt('-'+elem.dataset.wkOriginalWidth);
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
                                var width = parseInt('-'+leftSide.dataset.wkOriginalWidth);
                                toggleProgress(false, width, leftSide, 'left');
                            }
                        }
                    }
                    */
                    /** Open. */
                    elem.style.opacity = 0;
                    elem.style.display = "block";
                    elem.dataset.wkOriginalWidth = elem.clientWidth;
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
                            var width = parseInt('-'+elem.dataset.wkOriginalWidth);
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
                                    var width = parseInt('-'+rightSide.dataset.wkOriginalWidth);
                                    toggleProgress(false, width, rightSide, 'right');
                                }
                            }
                        }
                    }
                    /** Open. */
                    elem.style.opacity = 0;
                    elem.style.display = "block";
                    elem.dataset.wkOriginalWidth = elem.clientWidth;
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
                                var width = parseInt('-'+elem.dataset.wkOriginalWidth);
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
                                    var width = parseInt('-'+leftSide.dataset.wkOriginalWidth);
                                    toggleProgress(false, width, leftSide, 'left');
                                }
                            }
                        }
                        /** Open. */
                        elem.style.opacity = 0;
                        elem.style.display = "block";
                        elem.dataset.wkOriginalWidth = elem.clientWidth;
                        elem.style.right = '-'+elem.clientWidth+'px';
                        elem.style.opacity = 1;
                        toggleProgress(true, 0, elem, 'right');
                        return;
                    }
                }
                return;
            }
            /** Dektop mode toggle normally. */
            if(typeOf(elem.dataset.wkToggleBlock)=='UNDEFINED'){
                elem.dataset.wkToggleBlock = 0;
            }
            if(elem.dataset.wkToggleBlock!=1){
                elem.dataset.wkToggleBlock = 1;
                if(elem.clientWidth>0){
                    /** Close side. */
                    elem.dataset.wkOriginalWidth = elem.clientWidth;
                    toggleProgress(false, 0, elem, false);
                } else {
                    /** Open side. */
                    var width = elem.dataset.wkOriginalWidth;
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
            elem.dataset.wkActive = true;
        }
        elem = document.getElementById('wm-toggle-comments-top-btn');
        if(elem){
            elem.dataset.wkActive = false;
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
            var page = elem.dataset.wkPage;
            if(typeOf(page)!='UNDEFINED'){
                status.page = JSON.parse(page.toLowerCase());
            }
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
