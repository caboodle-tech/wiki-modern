<?php
$css = $_POST['wm-textarea'];

$check = '';
$fingerprint = '';

if( !empty( $css ) ){

    /**
    * Do some security validation on the CSS. A threat actor could try to
    * send something malicious into this function.
    */
    $fingerprint = md5( trim( $css ) );
    $check = md5( trim( strip_tags( $css ) ) );

    if( $fingerprint == $check ){

        // Load WordPress functions
        require_once('../../../wp-load.php');

        // Save this new css
        file_put_contents( get_template_directory() . '/css/main.css', $css );

        // Register the fact that we no longer need to do an update
        update_option( 'wm-less-template-rebuild', false );

        // Delete the temporary template file
        @unlink( get_template_directory() . '/etc/_template.less' );
    }
}
?>
<!doctype html>
<html lang="en">
    <?php
    if( $fingerprint == $check ){
    ?>
    <head>
        <script type="text/javascript">
            // Reload the preview page and force it not to use the cache
            setTimeout( function(){
                window.parent.location.reload( true );
            }, 1000 );
        </script>
    </head>
    <body>
        The LESS has been compiled and saved as the new main.css file. Auto refreshing the page please wait.
    </body>
    <?php
    } else {
    ?>
    <head>
        <!-- Remove the page blocker? -->
    </head>
    <body>
        There was an issue saving your new CSS and for security reason the file was not saved:<br>
        <?php
        echo '[' . $fingerprint . ']<br>';
        echo '[' . $check . ']';
        ?>
    </body>
    <?php
    }
    ?>
</html>
