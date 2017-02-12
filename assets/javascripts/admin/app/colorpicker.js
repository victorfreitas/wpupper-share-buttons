WPUSB( 'WPUSB.ColorPicker', function(Model, $) {

	Model.create = function(container) {
		this.init();
	};

	Model.init = function() {
		this.renderColorPicker();
	};

	Model.renderColorPicker = function() {
		var className = '.' + this.utils.prefix + '-colorpicker'
		  , options   = {
		    change: function(event, ui) {
		    	var color = ui.color.toString();

		    	$( '.wpusb-item a' ).css({
		    		'background-color': color,
		    		'box-shadow': '0 2px ' + color
		    	});
		    }.bind( this )
		};

		$( className ).wpColorPicker( options );
	};

}, {} );