<?php
$css = file_get_contents( './css/main.css' );
echo md5( trim($css) );
echo '<hr>';
echo md5( trim( strip_tags( $css ) ) );
echo '<hr><pre>';
echo $css;
echo '</pre>';
echo '<hr><pre>';
echo htmlentities( strip_tags( $css ), ENT_NOQUOTES );
echo '</pre>';
?>
