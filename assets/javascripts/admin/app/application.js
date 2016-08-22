WPUSB( 'WPUSB.Application', function(Application, $) {

	Application.init = function(container) {
		WPUSB.BuildComponents.create( container );
		Application.highlight( container );
	};

	Application.highlight = function(container) {
		container.byElement( 'highlight' ).each(function(i, block) {
			hljs.highlightBlock( block );
		});
	};

}, {} );