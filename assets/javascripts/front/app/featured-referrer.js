WPUPPER( 'SB.FeaturedReferrer', function(FeaturedReferrer, $) {

	FeaturedReferrer.create = function(container) {
		this.prefix = SB.vars.prefix + '-';
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
		}

		if ( this.isMatch( 'google' ) ) {
			this.showReferrer( 'google-plus' );
		}

		if ( this.isMatch( 'facebook' ) ) {
			this.showReferrer( 'facebook' );
		}

		if ( this.isMatch( 'linkedin' ) ) {
			this.showReferrer( 'linkedin' );
		}
	};

	FeaturedReferrer.showReferrer = function(element) {
		var className = this.prefix + 'referrer';

		this.$el.find( '.' + this.prefix + 'count' ).hide();
		this.$el.byReferrer( element ).addClass( className );
		this.$el.byReferrer( element ).addClass( className + '-' + element );
	};

	FeaturedReferrer.isMatch = function(name) {
		var ref     = document.referrer
		  , pattern = new RegExp( '^https?:\/\/([^\/]+\\.)?' + name + '\\.com?(\/|$)', 'i' )
		;

		return ref.match( pattern );
	};

}, {} );