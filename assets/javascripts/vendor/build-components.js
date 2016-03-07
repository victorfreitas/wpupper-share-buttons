WPUPPER( 'SB.BuildComponents', function(BuildComponents, $) {

	BuildComponents.create = function(container) {
		container.findComponent( '[data-component]', $.proxy( this, '_start' ) );
	};

	BuildComponents._start = function(elements) {
		if ( typeof SB.Components == 'undefined' ) {
			console.warn( 'Component not defined in its structure.' );
			return;
		}

		this._iterator( elements );
	};

	BuildComponents._iterator = function(elements) {
		var name;

		elements.each( function(index, element) {
			element = $( element );
			name    = elements.ucfirst( element.data( 'component' ) );
			this._callback( name, element );
		}.bind( this ) );
	};

	BuildComponents._callback = function(name, element) {
		var callback = SB.Components[name];

		if ( typeof callback == 'function' ) {
			callback.call( null, element );
		}
	};

}, {} );