WPUSB( 'WPUSB.Components.Widgets', function(Model, $, utils) {

	Model.fn.start = function() {
		if ( !this.$el.length ) {
			return;
		}

		this.init();
	};

	Model.fn.init = function() {
		WPUSB.Sortable.create( this.elements.socialItems );
		this._colorPicker();
	};

	Model.fn._colorPicker = function() {
		if ( typeof $.prototype.wpColorPicker !== 'function' ) {
			return;
		}

		this.elements.colorPicker.wpColorPicker();
	};

});