<?php
/**
 * The header for the Wiki Modern theme.
 *
 * Displays all of the <head> section starting from the <!doctype html> tag down
 * to the <body> tag.
 *
 * @package Wiki Modern Theme
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title('&vert;', true, 'right'); ?></title>
     <?php wp_head(); ?>
</head>
<body>
