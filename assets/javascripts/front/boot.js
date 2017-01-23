jQuery(function($) {
	var context = $( 'body' );

	WPUSB.vars = {
		  body   : context
		, prefix : 'wpusb'
	};

	WPUSB.Application.init.apply( WPUSB.utils, [context] );
});