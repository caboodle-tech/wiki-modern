/**
* Handles live updates to the website triggered by the user altering
* theme colors from the Theme Color panel of the Customizer.
*
* @see ../theme-options.php
* @since 1.0.0
*/

// Hook into the Publish button
$('#save').on('click', function(){
    var preview = $('#customize-preview');
    var frame = preview.first('iframe');
    frame = frame[0].firstElementChild;
    // Force reload the preview frame to show the new css file
    setTimeout( function(){
        frame.contentDocument.location.reload( true );
    }, 1000 );
    // Wait 1 second to avoid any possible race conditions
});
