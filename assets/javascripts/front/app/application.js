WPUSB( 'WPUSB.Application', function(Model, $, utils) {

	Model.init = function(container) {
		WPUSB.ProvidersProcess.create( container );
		WPUSB.BuildComponents.create( container );
		WPUSB.FixedTop.create( container );
		WPUSB.FixedContext.create( container );
	};

});