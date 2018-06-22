<?php
/**
 * Custom customizer control for image select
 *
 * @package Mloc
 */

class Mloc_Control_Image_Select extends WP_Customize_Control {
	/**
	 * Customize control type
	 *
	 * @var string
	 */
	public $type = 'radio-image';

	/**
	 * Add this customize control JS and CSS to customizer
	 */
	public function enqueue() {
		wp_enqueue_style( 'mloc-control-image-select', get_template_directory_uri() . '/inc/customizer/mloc-control-image-select/mloc-control-image-select.css' );
		wp_enqueue_script( 'mloc-control-image-select', get_template_directory_uri() . '/inc/customizer/mloc-control-image-select/mloc-control-image-select.js', array( 'jquery' ), false, true );
	}

	/**
	 * Add custom JSON parameters to use in the JS template
	 *
	 * @return array
	 */
	public function json() {
		$json = parent::json();

		foreach ( $this->choices as $value => $args ) {
			$this->choices[$value]['url'] = esc_url( sprintf( $args['url'], MLOC_IMG ) );
		}

		$json['choices'] = $this->choices;
		$json['link']    = $this->get_link();
		$json['value']   = $this->value();
		$json['id']      = $this->id;

		return $json;
	}

	/**
	 * An Underscore (JS) template for this control's content
	 */
	protected function content_template() {
		?>
		<# if ( ! data.choices ) {
			return;
		} #>

		<# if ( data.label ) { #>
			<span class="customize-control-title">{{ data.label }}</span>
		<# } #>

		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>

		<# for ( key in data.choices ) { #>
			<label for="{{ data.id }}-{{ key }}" class="radio-image">
				<span class="screen-reader-text">{{ data.choices[ key ]['label'] }}</span>
				<input type="radio" value="{{ key }}" name="_customize-{{ data.type }}-{{ data.id }}" id="{{ data.id }}-{{ key }}" {{{ data.link }}} <# if ( key === data.value ) { #> checked="checked" <# } #> />
				<img src="{{ data.choices[ key ]['url'] }}" alt="{{ data.choices[ key ]['label'] }}" />
			</label>
		<# } #>
		<?php
	}
}