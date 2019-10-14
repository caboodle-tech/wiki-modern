// Hook into the Publish button
$('#save').on('click', function(){
    var preview = $('#customize-preview');
    var frame = preview.first('iframe');
    frame = frame[0].firstElementChild;
    // Force reload the preview frame to show the new css file
    setTimeout( function(){
        frame.contentDocument.location.reload( true );
    }, 1000 );
    // Wait 1 second to avaoid any possible race conditions
});
