( function( $ ) {

function toggleAccordion(){
    var e = event || window.event;
    var elem = e.target || e.srcElement;
    console.log( elem );
}
function makeAccordions(){
    var counter;
    var failsafe;
    var closingMarkers = $( '.wm-customizer-accordion-toggle-end' );
    var markerCount = closingMarkers.length;
    for( var z = 0; z < markerCount; z++ ){
        failsafe = 0;
        while( closingMarkers[z].nodeName != 'LI' ){
            closingMarkers[z] = closingMarkers[z].parentElement;
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
    var accordions = $( '.wm-customizer-accordion-toggle' );
    var accordionCount = accordions.length;
    for( var x = 0; x < accordionCount; x++ ){
        failsafe = 0;
        counter = 1;
        while( accordions[x].nodeName != 'LI' ){
            accordions[x] = accordions[x].parentElement;
            if( failsafe > 3 ){
                accordions[x] = null;
                break;
            }
            failsafe++;
        }
        var ul = document.createElement('ul');
        if( accordions[x] != null ){
            ul.className = 'wm-customizer-accordion';
            var startLi = document.createElement('li');
            $( startLi ).addClass( 'wm-customizer-accordion-top' );
            var endLi = document.createElement('li');
            $( endLi ).addClass( 'wm-customizer-accordion-bottom' );
            ul.appendChild( startLi );
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
        var sectionCount = nodes.length;
        for( var y = 1; y < sectionCount; y++){
            $( '#wm-remove-elem-' + y ).remove();
        }
    }
}

$('#save').on('click', function(){
    var preview = $('#customize-preview');
    var frame = preview.first('iframe');
    frame = frame[0].firstElementChild;
    setTimeout( function(){
        frame.contentDocument.location.reload();
    }, 990 );
});

} )( jQuery );
