<!doctype html>
<html lang="en">
    <head>
        <link rel="stylesheet/less" type="text/css" href="./etc/_template.less">
        <script>
            // Setup LESS compiler settings
            less = {
                env: "development",
                async: false,
                fileAsync: false,
                poll: 1000,
                functions: {},
                relativeUrls: false
            };
        </script>
        <script src="./js/less.min.js" type="text/javascript"></script>
    </head>
    <body>
        This file is used as a means to re-compile the sites less files when you change the themes colors in WordPress's customizer.
        This page will be loaded in an iframe and will be hidden from the users view.
        <form method="post" action="" id="wm-form">
            <textarea name="wm-textarea" id="wm-textarea"></textarea>
        </form>
        <script type="text/javascript">

            // Find the iframe this page is inside of
            var frame = window.parent.document;
            frame = frame.getElementById('wm-theme-customizer');

            // Find the document
            var doc = frame.contentDocument || frame.contentWindow.document;

            // Find elements we need to check in the document
            var form = doc.getElementById('wm-form');
            var textarea = doc.getElementById('wm-textarea');

            // Point the forms action to the correct URL
            form.action = frame.dataset.wmFormAction;

            // Limit the amount of time we went for LESS to be compiled
            var counter = 0;

            // Check every 100 milliseconds if the LESS has been compiled
            var intervalId = setInterval( function(){

                // Grab the compiled CSS
                var style = doc.head.querySelector('style');

                if( style ){

                    // Make sure the LESS is done processing
                    if( style.innerHTML.length > 500 ){
                        // Clear interval and submit form
                        clearInterval( intervalId );
                        textarea.value = style.innerHTML;
                        form.submit();
                    }
                }

                // Check on the counter
                if( counter < 30 ){
                    counter++;
                } else {
                    console.error( 'There was an error compiling the LESS for your theme!' );
                    clearInterval( intervalId );
                }
            }, 100 );
        </script>
    </body>
</html>
