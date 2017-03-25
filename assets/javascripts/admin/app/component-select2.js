WPUSB( 'WPUSB.Components.Select2', function(Model, $, utils) {

	Model.fn.start = function() {
		this.init();
	};

	Model.fn.init = function() {
		this.$el.select2( this.getOptions() );
	};

	Model.fn.getOptions = function() {
		var options = {
			minimumResultsForSearch: 10
		};

		return $.extend( options, ( this.data.options || {} ) );
	};

});