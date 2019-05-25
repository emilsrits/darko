wp.customize.controlConstructor['mloc-slider'] = wp.customize.Control.extend({

    ready: function() {
        var control = this,
            sliderContainer = control.container.find( '.mloc-slider-container' ),
            sliderInput = sliderContainer.next( '.mloc-slider-input-container' ).find( '.mloc-slider-input' ),
            inputDefault = sliderInput.val(),
            inputMin = +sliderInput.attr( 'min' ),
            inputMax = +sliderInput.attr( 'max' ),
            sliderUi;

        sliderContainer.slider({
            range: 'min',
            value: inputDefault,
            min: inputMin,
            max: inputMax,
            step: +sliderInput.attr( 'step' ),
            slide: function( event, ui ) {
                sliderInput.val( ui.value ).change();
            },
            change: function( event, ui ) {
                control.setting.set( ui.value );
            }
        });

        sliderInput.on( 'change', function() {
            $this = jQuery( this );
            val = $this.val();
            sliderUi = $this.parent().prev( '.mloc-slider-container' );
            sliderUi.slider( 'value', val );
        } );
    }

});