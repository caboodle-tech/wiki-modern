( function( $ ) {

$('#save').on('click', function(){
    var preview = $('#customize-preview');
    var frame = preview.first('iframe');
    frame = frame[0].firstElementChild;
    setTimeout( function(){
        frame.contentDocument.location.reload( true );
    }, 1000 );
});

} )( jQuery );
