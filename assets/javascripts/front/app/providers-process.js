WPUSB( 'WPUSB.ProvidersProcess', function(Model, $, utils) {

	Model.create = function(container) {
		this.init();
	};

	Model.init = function() {
		if ( utils.isMobile() ) {
			this.parseMessengerLink();
		} else {
			this.parseWhatsAppLink();
		}
	};

	Model.parseMessengerLink = function() {
		this.parseProviderLink( 'messenger' );
	};

	Model.parseWhatsAppLink = function() {
		this.parseProviderLink( 'whatsapp', 'whatsapp://', true );
	};

	Model.parseProviderLink = function(provider, search, changes) {
		var i      = 0
		  , links  = document.querySelectorAll( '[data-' + provider + '-wpusb]' )
		  , length = links.length
		  , value
		;

		if ( !length ) {
			return;
		}

		for ( i; i < length; i++ ) {
			value = links[i].dataset[provider + 'Wpusb'];
			links[i].setAttribute( 'href', changes ? links[i].href.replace( search, value ) : value );
		}
	};

});