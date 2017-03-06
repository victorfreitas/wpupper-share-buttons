WPUSB( 'WPUSB.Application', function(Application, $, utils) {

	Application.init = function(container) {
		WPUSB.BuildComponents.create( container );
		WPUSB.FixedTop.create( container );
		WPUSB.FixedContext.create( container );
	};

});