wp.customize.controlConstructor['mloc-image-select'] = wp.customize.Control.extend({

	ready: function() {
		var control = this,
            value = ( undefined !== control.setting._value ) ? control.setting._value : '';

		this.container.on( 'change', 'input:radio', function() {
			value = jQuery( this ).val();
			control.setting.set( value );
			wp.customize.previewer.refresh();
		});
	}

});