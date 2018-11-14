<?php
/**
*
*/

if( !function_exists( 'wm_format_comment_form' ) ){

    function wm_format_comment_form(){

        /** Capture the default Word Press form. */
        ob_start();
        comment_form();
        $form = ob_get_clean();

        /** Remove submit button HTML and replace with plain button HTML. */
        $form = str_replace( 'type="submit"', 'type="button"', $form );

        /** Add the .wm-control-btns class to the submit button. */
        $form = str_replace( 'class="submit"', 'class="submit wm-control-btns"', $form );

        /** Display the form. */
        return $form;
    }
}
