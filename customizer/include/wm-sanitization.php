<?php
/** 
 * This file is for any custom sanitization functions Wiki Modern needs.
 *
 * @package Wiki Modern Theme 
 */

if ( ! function_exists( 'wm_sanitize_toggle' ) ) {

    /**
     * Toggle (checkbox) sanitization.
     *
     * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
     * as a boolean value, either TRUE or FALSE.
     *
     * @param bool $checked Whether the checkbox is checked.
     * @return bool Whether the checkbox is checked.
     */
    function wm_sanitize_toggle( $checked ) {
        return ( ( isset( $checked ) && true === $checked ) ? true : false );
    }
}

if ( ! function_exists( 'wm_text_sanitization' ) ) {

    /**
     * Text sanitization.
     *
     * @param string $input Input to be sanitized (either a string containing a single string or multiple, separated by commas).
     * @return string Sanitized input
     */
    function wm_text_sanitization( $input ) {
        if ( strpos( $input, ',' ) !== false ) {
            $input = explode( ',', $input );
        }
        if ( is_array( $input ) ) {
            foreach ( $input as $key => $value ) {
                $input[ $key ] = sanitize_text_field( $value );
            }
            $input = implode( ',', $input );
        } else {
            $input = sanitize_text_field( $input );
        }
        return $input;
    }
}

if ( ! function_exists( 'wm_select_sanitization' ) ) {

    /**
     * Select sanitization.
     * 
     * @param string $input   The slug for this select option.
     * @param object $setting A select object.
     */
    function wm_select_sanitization( $input, $setting ) {

        // Input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only.
        $input = sanitize_key( $input );

        // Get the list of possible select options.
        $choices = $setting->manager->get_control( $setting->id )->choices;

        // Return input if valid or return default option.
        return ( array_key_exists( $input, $choices ) ? $input : $setting->default );

    }
}
