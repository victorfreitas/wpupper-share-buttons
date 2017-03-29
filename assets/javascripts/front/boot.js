jQuery(function($) {
	var context = $( 'body' );

	WPUSB.vars = {
		body : context
	};

	if ( document.getElementsByClassName( WPUSB.utils.prefix ).length ) {
		WPUSB.Application.init.apply( WPUSB.utils, [context] );
	}
});