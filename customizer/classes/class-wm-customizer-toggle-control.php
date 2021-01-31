<?php
/**
 * TODO comment later.
 * 
 * @package Wiki Modern Theme 
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * This class adds a toggle control in the Customizer.
 *
 * @access   public
 * @author   maddisondesigns
 * @link     https://github.com/maddisondesigns/customizer-custom-controls Original author of this class core code.
 */
class WM_Customizer_Toggle_Control extends WP_Customize_Control {

    /**
     * Add a toggle control to WordPress' Customizer.
     * 
     * @var string The type of control being rendered
     */
    public $type = 'toggle';

    /**
     * Enqueue our scripts and styles
     */
    public function enqueue() {}

    /**
     * Render the control in the customizer
     */
    public function render_content() {
    ?>
        <div class="toggle-switch-control">
            <div class="toggle-switch">
                <input type="checkbox" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" class="toggle-switch-checkbox" value="<?php echo esc_attr( $this->value() ); ?>" 
                <?php
                    $this->link();
                    checked( $this->value() );
                ?>
                >
                <label class="toggle-switch-label" for="<?php echo esc_attr( $this->id ); ?>">
                    <span class="toggle-switch-inner"></span>
                    <span class="toggle-switch-switch"></span>
                </label>
            </div>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php if ( ! empty( $this->description ) ) { ?>
                <span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
            <?php } ?>
        </div>
    <?php
    }
}

// Register the custom control type.
$wp_customize->register_control_type( 'WM_Customizer_Toggle_Control' );
