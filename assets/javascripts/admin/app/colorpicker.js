WPUSB( 'WPUSB.ColorPicker', function(Model, $) {

	Model.create = function(container) {
		this.init();
	};

	Model.init = function() {
		this.renderColorPicker();
	};

	Model.renderColorPicker = function() {
		$( '.' + this.utils.prefix + '-colorpicker' ).wpColorPicker();
	};

}, {} );