WPUPPER( 'SB.Application', function(Application, $) {

	Application.init = function(container) {
		SB.BuildComponents.create( container );
		SB.FixedTop.create( container );
	};

});