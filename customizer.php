<!doctype html>
<html lang="en">
    <head>
        <link rel="stylesheet/less" type="text/css" href="./etc/_template.less">
        <script>
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
        <!--
            HOLD 1) Hide page or show some kind of loading screen.
            3) Reload the preview iframe
        -->
    </head>
    <body>
        This file is used as a means to re-compile the sites less files when you change the themes colors in WordPress's customizer.
        <form method="post" action="" id="wm-form">
            <textarea name="wm-textarea" id="wm-textarea"></textarea>
        </form>
        <script type="text/javascript">
            var frame = window.parent.document;
            frame = frame.getElementById('wm-theme-customizer');


            var doc = frame.contentDocument || frame.contentWindow.document;

            var form = doc.getElementById('wm-form');
            var textarea = doc.getElementById('wm-textarea');

            form.action = frame.dataset.wmFormAction;

            var counter = 0;

            var intervalId = setInterval( function(){

                var style = doc.head.querySelector('style');

                if( style ){
                    clearInterval( intervalId );
                    textarea.value = style.innerHTML;
                    form.submit();
                }

                if( counter < 30 ){
                    counter++;
                } else {
                    console.error( 'There was an error compiling your theme!' );
                    clearInterval( intervalId );
                }
            }, 100 );
        </script>
    </body>
</html>
