<?php
/** Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
* This class adds a toggle control in the Customizer.
*
* @access   public
* @author   Rich Tabor
* @link     https://richtabor.com/customizer-toggle-control/ Original author of this class.
*/
class WM_Customizer_Toggle_Control extends WP_Customize_Control {

	/**
    * The type of customize control.
    *
    * @access public
    * @since  1.0.0
    * @var    string
    */
	public $type = 'toggle';

	/**
	* Add custom parameters to pass to the JS via JSON.
	*
	* @access public
	* @return void
	* @since  1.0.0
	*/
	public function to_json() {
		parent::to_json();
		// The setting value.
		$this->json['id']           = $this->id;
		$this->json['value']        = $this->value();
		$this->json['link']         = $this->get_link();
		$this->json['defaultValue'] = $this->setting->default;
	}

	/**
	* Don't render the content via PHP. This control is handled with a JS template.
	*
	* @access  public
	* @since   1.0.0
	* @return  void
	*/
	public function render_content() {}

	/**
	* An Underscore (JS) template for this control's content.
	*
	* Class variables for this control class are available in the `data` JS object;
	* export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	*
	* @access  protected
	* @return  void
	* @see     WP_Customize_Control::print_template()
	* @since   1.0.0
	*/
	protected function content_template() {
		?>
		<label class="toggle">
			<div class="toggle--wrapper">

				<# if ( data.label ) { #>
					<span class="customize-control-title">{{ data.label }}</span>
				<# } #>

				<input id="toggle-{{ data.id }}" type="checkbox" class="toggle--input" value="{{ data.value }}" {{{ data.link }}} <# if ( data.value ) { #> checked="checked" <# } #> />
				<label for="toggle-{{ data.id }}" class="toggle--label"></label>
			</div>

			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{ data.description }}</span>
			<# } #>
		</label>
		<?php
	}
}

/** Register the custom control type. */
$wp_customize->register_control_type( 'WM_Customizer_Toggle_Control' );
