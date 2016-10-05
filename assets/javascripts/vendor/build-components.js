WPUSB( 'WPUSB.BuildComponents', function(BuildComponents, $, utils) {

	BuildComponents.create = function(container) {
		var components = '[data-' + utils.prefix + '-component]';
		container.findComponent( components, $.proxy( this, '_start' ) );
	};

	BuildComponents._start = function(elements) {
		if ( typeof WPUSB.Components == 'undefined' ) {
			return;
		}

		this._iterator( elements );
	};

	BuildComponents._iterator = function(elements) {
		var name;

		elements.each( function(index, element) {
			element = $( element );
			name    = elements.ucfirst( this.getComponent( element ) );
			this._callback( name, element );
		}.bind( this ) );
	};

	BuildComponents.getComponent = function(element) {
		var component = element.data( utils.prefix + '-component' );

		if ( !component ) {
			return '';
		}

		return component;
	};

	BuildComponents._callback = function(name, element) {
		var callback = WPUSB.Components[name];

		if ( typeof callback == 'function' ) {
			callback.call( null, element );
			return;
		}

		console.warn( 'Component "' + name + '" is not a function.' );
	};

}, {} );