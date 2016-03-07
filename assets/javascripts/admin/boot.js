jQuery(function($) {
	var context = $( 'body' );

	SB.vars = {
		  body   : context
		, prefix : 'wpusb'
	};

	SB.Application.init.apply( null, [context] );
});