WPUSB( 'WPUSB.FeaturedReferrer', function(FeaturedReferrer, $, utils) {

	FeaturedReferrer.create = function(container) {
		this.prefix = WPUSB.vars.prefix + '-';
		this.$el    = container;
		this.init();
	};

	FeaturedReferrer.init = function() {
		if ( this.$el.attr('class').match( '-fixed' ) ) {
			return;
		}

		this.setReferrer();
	};

	FeaturedReferrer.setReferrer = function() {
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

	FeaturedReferrer.showReferrer = function(referrer) {
		var className = this.prefix + 'referrer'
		  , element   = this.$el.byReferrer( referrer );

		this.$el.find( '.' + this.prefix + 'count' ).hide();
		element.addClass( className );
		element.addClass( className + '-' + referrer );

		this.refTitle( element );
	};

	FeaturedReferrer.refTitle = function(element) {
		if ( !element.find( 'span[data-title]' ).length ) {
			var title = '<span data-title="' + element.data( 'ref-title' ) + '"></span>';
			element.find( 'a' ).append( title );
		}
	};

	FeaturedReferrer.isMatch = function(name) {
		var ref     = document.referrer
		  , pattern = new RegExp( '^https?:\/\/([^\/]+\\.)?' + name + '\\.com?(\/|$)', 'i' )
		;

		return ref.match( pattern );
	};

}, {} );