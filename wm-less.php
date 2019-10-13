<?php
if( !empty( $_POST['wm-textarea'] ) ){

    // TODO: Add more validation!!!!
    $css = $_POST['wm-textarea'];

    // Load WordPress functions
    require_once('../../../wp-load.php');

    // Save this new css
    file_put_contents( get_template_directory() . '/css/main.css', $css );

    // Register the fact that we no longer need to do an update
    update_option( 'wm-less-template-rebuild', false );

    // Delete the temporary template file
    unlink( get_template_directory() . '/etc/_template.less' );
?>
<!doctype html>
<html lang="en">
    <head>
        <script type="text/javascript">
            window.parent.location.reload();
        </script>
    </head>
    <body>
        Done.
    </body>
</html>
<?php
}
?>
