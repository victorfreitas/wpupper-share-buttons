WPUSB( 'WPUSB.BuildComponents', function(Model, $, utils) {

	Model.create = function(container) {
		var components = '[data-' + utils.addPrefix( 'component' ) + ']';
		container.findComponent( components, $.proxy( this, '_start' ) );
	};

	Model._start = function(elements) {
		if ( typeof WPUSB.Components == 'undefined' ) {
			return;
		}

		this._iterator( elements );
	};

	Model._iterator = function(elements) {
		var name;

		elements.each( function(index, element) {
			element = $( element );
			name    = utils.ucfirst( this.getComponent( element ) );
			this._callback( name, element );
		}.bind( this ) );
	};

	Model.getComponent = function(element) {
		var component = element.data( utils.addPrefix( 'component' ) );

		if ( !component ) {
			return '';
		}

		return component;
	};

	Model._callback = function(name, element) {
		var callback = WPUSB.Components[name];

		if ( typeof callback == 'function' ) {
			callback.call( null, element );
			return;
		}

		console.log( 'Component "' + name + '" is not a function.' );
	};

}, {} );