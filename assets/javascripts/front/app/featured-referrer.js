WPUSB( 'WPUSB.FeaturedReferrer', function(Referrer, $) {

	Referrer.create = function(container) {
		this.prefix = this.utils.prefix + '-';
		this.$el    = container;
		this.init();
	};

	Referrer.init = function() {
		if ( this.$el.attr('class').match( '-fixed' ) ) {
			return;
		}

		this.setReferrer();
	};

	Referrer.setReferrer = function() {
		if ( this.isMatch( 'twitter' ) || this.isMatch( 't' ) ) {
			this.showReferrer( 'twitter' );
			return;
		}

		if ( this.isMatch( 'google' ) ) {
			this.showReferrer( 'google-plus' );
			return;
		}

		if ( this.isMatch( 'facebook' ) ) {
			this.showReferrer( 'facebook' );
			return;
		}

		if ( this.isMatch( 'linkedin' ) ) {
			this.showReferrer( 'linkedin' );
		}
	};

	Referrer.showReferrer = function(referrer) {
		var className = this.prefix + 'referrer'
		  , element   = this.$el.byReferrer( referrer )
		;

		this.$el.find( '.' + this.prefix + 'count' ).remove();
		this.$el.find( '.' + this.prefix + 'counter' ).remove();

		this.$el.prepend( element );

		element.addClass( className );

		this.refTitle( element );
	};

	Referrer.refTitle = function(element) {
		if ( !element.find( 'span[data-title]' ).length ) {
			var title = '<span data-title="' + element.data( 'ref-title' ) + '"></span>';
			element.find( 'a' ).append( title );
		}
	};

	Referrer.isMatch = function(name) {
		var ref     = document.referrer
		  , pattern = new RegExp( '^https?:\/\/([^\/]+\\.)?' + name + '\\.com?(\/|$)', 'i' )
		;

		return ref.match( pattern );
	};

}, {} );