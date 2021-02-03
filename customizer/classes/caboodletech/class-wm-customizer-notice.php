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
 * This class allows you to add a notice to any section in the
 * Customizer. Instead of rendering a custom control this just
 * shows a paragrah of text that allows limited HTML tags:
 * a, br, em, strong, i, span, code
 *
 * @access   public
 * @author   Anthony Hortin <http://maddisondesigns.com>
 * @license  http://www.gnu.org/licenses/gpl-2.0.html
 * @link     https://github.com/maddisondesigns/customizer-custom-controls/blob/master/inc/custom-controls.php Original source of this class.
 */
class WM_Customizer_Notice extends WP_Customize_Control {

    /**
     * The type of control being rendered.
     *
     * @access public
     * @since  1.0.0
     * @var    string
     */
    public $type = 'notice';

    /**
     * Render the notice in the Customizer.
     *
     * @access  public
     * @since   1.0.0
     */
    public function render_content() {
        $allowed_html = array(
            'a'      => array(
                'href'   => array(),
                'title'  => array(),
                'class'  => array(),
                'target' => array(),
            ),
            'br'     => array(),
            'em'     => array(),
            'strong' => array(),
            'i'      => array(
                'class' => array(),
            ),
            'span'   => array(
                'class' => array(),
            ),
            'code'   => array(),
        );
    ?>
        <div class="wm-customizer-notice">
            <?php if ( ! empty( $this->label ) ) { ?>
                <span class="wm-customizer-notice-title"><?php echo esc_html( $this->label ); ?></span>
            <?php } ?>
            <?php if ( ! empty( $this->description ) ) { ?>
                <span class="wm-customizer-notice-description"><?php echo wp_kses( $this->description, $allowed_html ); ?></span>
            <?php } ?>
        </div>
    <?php
    }
}

/**
* Since this is not an actual control DO NOT register
* the custom control type or it will break.
*/
