<?php

if( !function_exists( 'wm_inline_dropdown' ) ){

    function wm_inline_dropdown( $cookie_name, $label, $increment, $max, $reverse = false ){

        $html = '<span class="wm-inline-dropdown wm-dropdown-closed" data-wm-dropdown="closed" onclick="WikiModern.dropdown();">' . $label . '<ul class="wm-inline-options" data-wm-cookie-name="' . $cookie_name . '">';

        $compare = intval( $label );

        global $wp;
        Kint::dump( paginate_links( ['type' => 'array'] ) );

        if( !$reverse ){
            for( $x = $increment; $x <= $max; $x += $increment ){
                if( $x != $compare ){
                    $html .= '<li onclick="WikiModern.dropdown();" data-wm-option-value="' . $x . '">' . $x . '</li>';
                }
            }
        } else {
            for( $x = $max; $x > 0; $x -= $increment ){
                if( $x != $compare ){
                    $html .= '<li onclick="WikiModern.dropdown();" data-wm-option-value="' . $x . '">' . $x . '</li>';
                }
            }
        }

        $html .= '</ul></span>';

        return $html;
    }
}
?>
