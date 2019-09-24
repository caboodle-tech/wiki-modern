<?php

if( !function_exists( 'wm_inline_dropdown' ) ){

    function wm_inline_dropdown( $cookie_name, $label, $increment, $max, $reverse = false, $links = [] ){

        $html = '<span class="wm-inline-dropdown wm-dropdown-closed" data-wm-dropdown="closed" onclick="WikiModern.dropdown();">' . $label . '<ul class="wm-inline-options" data-wm-cookie-name="' . $cookie_name . '">';

        $compare = intval( $label );

        if( !$reverse ){
            for( $x = $increment; $x <= $max; $x += $increment ){
                if( $x != $compare ){
                    if( isset( $links[ $x - 1 ] ) ){
                        $html .= '<li onclick="WikiModern.dropdown();" data-wm-link-value="' . $links[ $x - 1 ] . '">' . $x . '</li>';
                    } else {
                        $html .= '<li onclick="WikiModern.dropdown();" data-wm-show-value="' . $x . '">' . $x . '</li>';
                    }
                }
            }
        } else {
            for( $x = $max; $x > 0; $x -= $increment ){
                if( $x != $compare ){
                    if( isset( $links[ $x - 1 ] ) ){
                        $html .= '<li onclick="WikiModern.dropdown();" data-wm-link-value="' . $links[ $x - 1 ] . '">' . $x . '</li>';
                    } else {
                        $html .= '<li onclick="WikiModern.dropdown();" data-wm-show-value="' . $x . '">' . $x . '</li>';
                    }
                }
            }
        }

        $html .= '</ul></span>';

        return $html;
    }
}
?>
