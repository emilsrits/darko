<?php
/**
 * Custom customizer control for image select
 *
 * @package Darko
 */

class Darko_Customize_Image_Select_Control extends WP_Customize_Control {
	/**
	 * Customize control type
	 *
	 * @var string
	 */
	public $type = 'darko-image-select';

	/**
	 * Add this customize control JS and CSS to customizer
	 */
	public function enqueue() {
		wp_enqueue_style( 'darko-image-select-control', DARKO_THEME_URI . '/inc/customizer/controls/image-select/style.css' );
		wp_enqueue_script( 'darko-image-select-control', DARKO_THEME_URI . '/inc/customizer/controls/image-select/script.js', array( 'jquery' ), false, true );
	}

	/**
	 * Add custom JSON parameters to use in the JS template
	 *
	 * @return array
	 */
	public function json() {
		$json = parent::json();

		foreach ( $this->choices as $value => $args ) {
			$this->choices[$value]['url'] = esc_url( sprintf( $args['url'], DARKO_IMG_URI ) );
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
			<span class="customize-control-title">{{{ data.label }}}</span>
		<# } #>

		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>

		<# for ( key in data.choices ) { #>
			<label for="{{ data.id }}-{{ key }}" class="darko-image-select">
				<span class="screen-reader-text">{{ data.choices[key]['label'] }}</span>
				<input type="radio" value="{{ key }}" name="_customize-{{ data.type }}-{{ data.id }}" id="{{ data.id }}-{{ key }}" <# if ( key === data.value ) { #> checked="checked" <# } #> {{{ data.link }}} />
				<img src="{{ data.choices[key]['url'] }}" alt="{{ data.choices[key]['label'] }}" />
			</label>
		<# } #>
		<?php
	}
}