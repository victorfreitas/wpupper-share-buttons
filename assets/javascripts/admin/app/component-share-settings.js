WPUSB( 'WPUSB.Components.ShareSettings', function(ShareSettings, $, utils) {

	ShareSettings.fn.start = function() {
		this.posFixed = this.$el.byElement( 'position-fixed' );
		this.fixed    = this.elements.fixed;
		this.init();
	};

	ShareSettings.fn.init = function() {
		this.addEventListener();
	};

	ShareSettings.fn.addEventListener = function() {
		this.posFixed.on( 'change', this._onChangeFixedLeft.bind( this ) );
		this.$el.addEvent( 'click', 'fixed-disabled', this );
	};

	ShareSettings.fn._onChangeFixedLeft = function(event) {
		if ( this.posFixed.is( ':checked' ) ) {
			this.fixed.val( 'on' );
			return;
		}

		this.fixed.val( '' );
	};

	ShareSettings.fn._onClickFixedDisabled = function(event) {
		this.posFixed.prop( 'checked', false );
		this.fixed.val( '' );
	};

});