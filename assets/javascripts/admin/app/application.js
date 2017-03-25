WPUSB( 'WPUSB.Application', function(Application, $, utils) {

	Application.init = function(container) {
		WPUSB.BuildComponents.create( container );
		WPUSB.ColorPicker.create( container );
		Application.highlight( container );
	};

	Application.highlight = function(container) {
		var context = $( '.' + utils.addPrefix( 'settings' ) );

		if ( typeof hljs !== 'object' ) {
			return;
		}

		context.byElement( 'highlight' ).each(function(index, element) {
			hljs.highlightBlock( element );
		});
	};

}, {} );