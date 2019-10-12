<?php
/*
// Make sure the core files needed for this process are in place

$temp_file = getcwd() . '/etc/_timestamp.json';
$less_file = getcwd() . '/less/_timestamp.json';

$update = false;
if( !file_exists( $temp_file ) ){
    $update = true;
}

if( !file_exists( $less_file ) ){
    $update = true;
}

if( !$update ){
    // Check the timestamp to see if an update is needed
    $temp_time = json_decode( file_get_contents( $temp_file ), true );
    $less_time = json_decode( file_get_contents( $less_file ), true );

    if( $temp_time != null && $less_time != null ){
        if( $temp_time['time'] != $less_time['time'] ){
            $update = true;
        }
    } else {
        $update = true;
    }
}

if( $update ){

    // We are going to run the update so update the timestamps
    $timestamp = '{"time":' . time() . '}';
    file_put_contents( $temp_file, $timestamp );
    file_put_contents( $less_file, $timestamp );
}*/
?>
<!doctype html>
<html lang="en">
    <head>
        <?php
        if( !$update && 3 == 2 ){
        ?>
        <link rel="stylesheet/less" type="text/css" href="./etc/template.less">
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
            1) Hide page or show some kind of loading screen.
            2) JS HERE That sends VIA AJAX the compiled css to replace the old file.
            3) Reload the preview iframe
        -->
        <?php
        }
        ?>
    </head>
    <body>
        This file is used as a means to re-compile the sites less files when you change the themes colors in WordPress's customizer.
    </body>
</html>
