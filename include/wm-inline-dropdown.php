<?php

if( !function_exists( 'wm_inline_dropdown' ) ){

    function wm_inline_dropdown( $cookie_name, $label, $increment, $max ){

        $html = '<span class="wm-inline-dropdown" data-wm-cookie-name="' . $cookie_name . '">' . $label . '<ul class="wm-inline-options">';

        $compare = intval( $label );

        for( $x = $increment; $x <= $max; $x += $increment ){
            if( $x != $compare ){
                $html .= '<li onclick="WikiModern.dropdown();" data-wm-option-value="' . $x . '">' . $x . '</li>';
            }
        }

        $html .= '</ul></span>';

        return $html;
    }
}
?>
