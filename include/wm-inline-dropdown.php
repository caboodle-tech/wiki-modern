<?php

if( !function_exists( 'wm_inline_dropdown' ) ){

    function wm_inline_dropdown( $cookie_name = 'NA', $label, $increment, $max, $reverse = false, $links = [] ){

        $html = '<span class="wm-inline-dropdown wm-dropdown-closed" data-wm-dropdown="closed" onclick="WikiModern.dropdown();">' . $label . '<ul class="wm-inline-options" data-wm-cookie-name="' . $cookie_name . '">';

        $compare = intval( $label );

        if( !$reverse ){

            // Is this a list of numbers that needs to be made or text?
            if( $increment < 1 || $max < 1 ){
                // Text
                foreach( $links as $val ){
                    if( $label != $val ){
                        $html .= '<li onclick="WikiModern.dropdown();" data-wm-show-value="' . strtolower($val) . '">' . $val . '</li>';
                    }
                }
            } else {
                // Numbers
                for( $x = $increment; $x <= $max; $x += $increment ){
                    if( $x != $compare ){
                        if( isset( $links[ $x - 1 ] ) ){
                            $html .= '<li onclick="WikiModern.dropdown();" data-wm-link-value="' . $links[ $x - 1 ] . '">' . $x . '</li>';
                        } else {
                            $html .= '<li onclick="WikiModern.dropdown();" data-wm-show-value="' . $x . '">' . $x . '</li>';
                        }
                    }
                }
            }

        } else {

            // Is this a list of numbers that needs to be made or text?
            if( $increment < 1 || $max < 1 ){
                // Text
                foreach( $links as $val ){
                    if( $label != $val ){
                        $html .= '<li onclick="WikiModern.dropdown();" data-wm-show-value="' . strtolower($val) . '">' . $val . '</li>';
                    }
                }
            } else {
                // Numbers
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
        }

        $html .= '</ul></span>';

        return $html;
    }
}
?>
