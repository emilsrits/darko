<?php
/**
 * Custom customizer control for slider
 *
 * @package Darko
 */

class Darko_Customize_Slider_Control extends WP_Customize_Control {
    /**
     * Customize control type
     *
     * @var string
     */
    public $type = 'darko-slider';

    /**
     * Add this customize control JS and CSS to customizer
     */
    public function enqueue() {
        wp_enqueue_style( 'darko-slider-control', DARKO_THEME_URI . '/inc/customizer/controls/slider/style.css' );
        wp_enqueue_script( 'darko-slider-control', DARKO_THEME_URI . '/inc/customizer/controls/slider/script.js', array( 'jquery', 'customize-base', 'jquery-ui-slider' ), false, true );
    }

    /**
     * Add custom JSON parameters to use in the JS template
     */
    public function to_json() {
        parent::to_json();

        $this->json['id'] = $this->id;
        $this->json['link'] = $this->get_link();
        $this->json['inputAttrs'] = array();
        foreach ( $this->input_attrs as $attr => $value ) {
            $this->json['inputAttrs'][$attr] = $value ;
        }
    }

    /**
     * Don't render the control content from PHP, as it's rendered via JS
     */
    protected function render_content() {}

    /**
     * An Underscore (JS) template for this control's content
     */
    protected function content_template() {
        ?>
        <# if ( data.label ) { #>
            <span class="customize-control-title">{{{ data.label }}}</span>
        <# } #>

        <# if ( data.description ) { #>
            <span class="description customize-control-description">{{{ data.description }}}</span>
        <# } #>
            
        <# if ( data.inputAttrs ) { #>
            <div class="darko-slider-container"></div>
            <div class="darko-slider-input-container">
                <input type="number" min="{{ data.inputAttrs['min'] }}" max="{{ data.inputAttrs['max'] }}" step="{{ data.inputAttrs['step'] }}" value="{{ data.inputAttrs['value'] }}" id="{{ data.id }}" class="darko-slider-input" {{{ data.link }}}>
                <span class="darko-slider-reset" data-default="{{ data.inputAttrs['value'] }}"></span>
            </div>
        <# } #>
        <?php
    }
}