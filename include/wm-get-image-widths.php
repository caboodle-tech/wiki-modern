<?php
/**
 * Get size information for all currently-registered image sizes.
 * 
 * @package Wiki Modern Theme
 */

if ( ! function_exists( 'wm_get_image_widths' ) ) {
    /**
     * Get size information for all currently-registered image sizes
     * Source from {@link: https://codex.wordpress.org/Function_Reference/get_intermediate_image_sizes|WordPress}
     *
     * @global $_wp_additional_image_sizes
     * @uses get_intermediate_image_sizes()
     * @return array $widths All currently-registered image widths sorted smallest to largest.
     */
    function wm_get_image_widths() {
        global $_wp_additional_image_sizes;

        $widths = array();

        foreach ( get_intermediate_image_sizes() as $_size ) {
            if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
                array_push( $widths, get_option( "{$_size}_size_w" ) );
            } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
                array_push( $widths, $_wp_additional_image_sizes[ $_size ]['width'] );
            }
        }

        asort( $widths );

        return $widths;
    }
}
