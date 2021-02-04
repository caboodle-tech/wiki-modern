<?php
/**
 * TODO comment later.
 * 
 * @package Wiki Modern Theme 
 */

namespace Caboodletech;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * This class adds collapsable (accordion) sections in the
 * WordPress Customizer; this requires JavaScript to work
 * correctly {@see ../js/customizer-accordion.js}.
 *
 * @access public
 * @author Caboodle Tech Inc. <source@caboodle.tech>
 */
class WM_Customizer_Accordion extends \WP_Customize_Control {

    /**
     * The type of control being rendered.
     *
     * @access public
     * @since  1.0.0
     * @var    string
     */
    public $type = 'accordion';

    /**
     * Render the accordion in the Customizer. If a label is
     * present this is the start of an accordion otherwise
     * it is treated as the closing.
     *
     * @since 1.0.0
     */
    public function render_content() {
        if ( ! empty( $this->label ) ) {
            ?>
                <span class="customize-control-title wm-customizer-accordion-toggle" onclick="toggleAccordion(this);"><?php echo esc_html( $this->label ); ?></span>
            <?php
        } else {
            ?>
                <span class="wm-customizer-accordion-toggle-end"></span>
            <?php
        }
    }
}

/**
* Since this is not an actual control DO NOT register
* the custom control type or it will break.
*/

/**
* OPEN
* $theme_options[] = array(
*    'class'         => 'WM_Customizer_Accordion',
*    'default'       => '',
*    'description'   => '',
*    'label'         => __('Hide Section'),
*    'sanitize'      => NULL,
*    'section'       => 'wm_theme_options',
*    'slug'          => NULL
* );
*/

/**
* CLOSE
* $theme_options[] = array(
*    'class'         => 'WM_Customizer_Accordion',
*    'default'       => '',
*    'description'   => '',
*    'label'         => '',
*    'sanitize'      => NULL,
*    'section'       => 'wm_theme_options',
*    'slug'          => NULL
* );
*/
