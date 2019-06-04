wp.customize.controlConstructor['darko-slider'] = wp.customize.Control.extend({

    ready: function() {
        var control = this,
            sliderContainer = control.container.find( '.darko-slider-container' ),
            sliderInput = sliderContainer.next( '.darko-slider-input-container' ).find( '.darko-slider-input' ),
            sliderReset = sliderContainer.next( '.darko-slider-input-container' ).find( '.darko-slider-reset' ),
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
            sliderUi = $this.parent().prev( '.darko-slider-container' );
            sliderUi.slider( 'value', val );
        } );

        sliderReset.on( 'click', function () {
            $this = jQuery( this );
            val = +$this.attr( 'data-default' );
            sliderInput.val( val ).change();
        } );
    }

});