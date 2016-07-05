WPUPPER( 'SB.FeaturedReferrer', function(FeaturedReferrer, $) {

	FeaturedReferrer.create = function(container) {
		this.prefix = SB.vars.prefix + '-';
		this.$el    = container;
		this.init();
	};

	FeaturedReferrer.init = function() {
		this.setReferrer( document.referrer );
	};

	FeaturedReferrer.setReferrer = function( referrer ) {
		var ref = referrer.replace( /(http(s)?):\/\/((www\.)?)/, '' );

		if ( ~ref.indexOf( 't.co' ) ) {
			this.showReferrer( 'twitter' );
		}

		if ( ~ref.indexOf( 'google' ) ) {
			this.showReferrer( 'google-plus' );
		}

		if ( ~ref.indexOf( 'facebook' ) ) {
			this.showReferrer( 'facebook' );
		}

		if ( ~ref.indexOf( 'linkedin' ) ) {
			this.showReferrer( 'linkedin' );
		}
	};

	FeaturedReferrer.showReferrer = function(element) {
		var className = this.prefix + 'referrer';

		this.$el.find( '.' + this.prefix + 'count' ).hide();
		this.$el.byReferrer( element ).addClass( className );
		this.$el.byReferrer( element ).addClass( className + '-' + element );
	};

}, {} );