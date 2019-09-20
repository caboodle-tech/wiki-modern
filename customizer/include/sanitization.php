<?php
/** This file is for any custom sanitization functions Wiki Modern needs. */

/**
* Toggle (checkbox) sanitization.
*
* Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
* as a boolean value, either TRUE or FALSE.
*
* @param bool $checked Whether the checkbox is checked.
* @return bool Whether the checkbox is checked.
*/
if ( ! function_exists( 'wm_sanitize_toggle' ) ) {
    function wm_sanitize_toggle( $checked ) {
    	return ( ( isset( $checked ) && true === $checked ) ? true : false );
    }
}

/**
 * Text sanitization
 *
 * @param  string	Input to be sanitized (either a string containing a single string or multiple, separated by commas)
 * @return string	Sanitized input
 */
if ( ! function_exists( 'wm_text_sanitization' ) ) {
	function wm_text_sanitization( $input ) {
		if ( strpos( $input, ',' ) !== false) {
			$input = explode( ',', $input );
		}
		if( is_array( $input ) ) {
			foreach ( $input as $key => $value ) {
				$input[$key] = sanitize_text_field( $value );
			}
			$input = implode( ',', $input );
		}
		else {
			$input = sanitize_text_field( $input );
		}
		return $input;
	}
}

if ( ! function_exists( 'wm_select_sanitization' ) ) {
    function wm_select_sanitization( $input, $setting ){

        //input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
        $input = sanitize_key($input);

        //get the list of possible select options
        $choices = $setting->manager->get_control( $setting->id )->choices;

        //return input if valid or return default option
        return ( array_key_exists( $input, $choices ) ? $input : $setting->default );

    }
}
