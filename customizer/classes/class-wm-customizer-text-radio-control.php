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
class WM_Customizer_Text_Radio_Control extends WP_Customize_Control {

    /**
     * Add a radio control to WordPress' Customizer.
     * 
     * @var string The type of control being rendered
     */
    public $type = 'text_radio_button';

    /**
     * Enqueue our scripts and styles
     */
    public function enqueue() {}

    /**
     * Render the control in the customizer
     */
    public function render_content() {
    ?>
        <div class="text_radio_button_control">
            <?php if ( ! empty( $this->label ) ) { ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php } ?>
            <?php if ( ! empty( $this->description ) ) { ?>
                <span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
            <?php } ?>

            <div class="radio-buttons">
                <?php
                    foreach ( $this->choices as $key => $value ) {
                ?>
                    <label class="radio-button-label">
                        <input type="radio" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php $this->link(); ?> <?php checked( esc_attr( $key ), $this->value() ); ?>/>
                        <span><?php echo esc_attr( $value ); ?></span>
                    </label>
                <?php	} ?>
            </div>
        </div>
    <?php
    }
}

// Register the custom control type.
$wp_customize->register_control_type( 'WM_Customizer_Text_Radio_Control' );
