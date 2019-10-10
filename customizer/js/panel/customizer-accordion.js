/**
* Alters the page to add collapsable (accordion) sections in the
* Wordpress Customizer. This allows you to hide large groups of
* options in one section instead of needing to add multiple
* sections or panels.
*
* @see ../classes/wm_customiser_accordion.php
* @since 1.0.0
*/

// NOT IN USE. BUGGY AND BROKEN.

function toggleAccordion(){
    var e = event || window.event;
    var elem = e.target || e.srcElement;
    console.log( elem );
}

function makeAccordions(){

    /** Make variable needed in multiple places. */
    var counter;
    var failsafe;

    /** Find all closing markers and add the mark to the LI. */
    var closingMarkers = $( '.wm-customizer-accordion-toggle-end' );
    var markerCount = closingMarkers.length;
    for( var z = 0; z < markerCount; z++ ){

        /** Reset tracking variables on each loop. */
        failsafe = 0;

        /** The marker is inside a LI, climb up to the LI. */
        while( closingMarkers[z].nodeName != 'LI' ){
            closingMarkers[z] = closingMarkers[z].parentElement;
            /** The marker should not be very deep in the DOM. */
            if( failsafe > 3 ){
                closingMarkers[z] = null;
                break;
            }
            failsafe++;
        }

        if( closingMarkers[z] != null ){
            $( closingMarkers[z] ).addClass( 'wm-customizer-accordion-toggle-end' );
        }
    }

    /** Find all accordion sections in the Customizer panel. */
    var accordions = $( '.wm-customizer-accordion-toggle' );

    /** Loop through each section and build the accordion. */
    var accordionCount = accordions.length;
    for( var x = 0; x < accordionCount; x++ ){

        /** Reset tracking variables on each loop. */
        failsafe = 0;
        counter = 1;

        /** The marker for an accordion section is inside a LI, climb up to the LI. */
        while( accordions[x].nodeName != 'LI' ){
            accordions[x] = accordions[x].parentElement;
            /** The marker should not be very deep in the DOM. */
            if( failsafe > 3 ){
                accordions[x] = null;
                break;
            }
            failsafe++;
        }

        /** Move each LI node found in this section into our new accordion. */
        var ul = document.createElement('ul');
        if( accordions[x] != null ){
            ul.className = 'wm-customizer-accordion';
            var startLi = document.createElement('li');
            $( startLi ).addClass( 'wm-customizer-accordion-top' );
            var endLi = document.createElement('li');
            $( endLi ).addClass( 'wm-customizer-accordion-bottom' );
            ul.appendChild( startLi );
            /** Build an array of the nodes needing to be moved. */
            var nodes = [ accordions[x].parentElement ];
            var next = accordions[x].nextElementSibling;
            while( next != null && $(next).hasClass('wm-customizer-accordion-toggle-end') == false ){
                ul.appendChild( next.cloneNode( true ) );
                next.id = 'wm-remove-elem-' + counter;
                nodes.push( next );
                next = next.nextElementSibling;
                counter++;
            }
            ul.appendChild( endLi );
        }

        /** Remove the original LI from the DOM. */
        var sectionCount = nodes.length;
        for( var y = 1; y < sectionCount; y++){
            $( '#wm-remove-elem-' + y ).remove();
        }

        /** Add the accordion to the page. */
        //$( accordions[x] ).append( ul );
    }
}
