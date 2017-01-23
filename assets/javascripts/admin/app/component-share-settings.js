WPUSB( 'WPUSB.Components.ShareSettings', function(ShareSettings, $) {

	ShareSettings.fn.start = function() {
		this.init();
	};

	ShareSettings.fn.init = function() {
		this.addEventListener();
	};

	ShareSettings.fn.addEventListener = function() {
		this.elements.positionFixed.on( 'change', this._onChangeFixedLeft.bind( this ) );
		this.$el.addEvent( 'click', 'fixed-disabled', this );
	};

	ShareSettings.fn._onChangeFixedLeft = function(event) {
		if ( this.elements.positionFixed.is( ':checked' ) ) {
			this.elements.fixed.val( 'on' );
			return;
		}

		this.elements.fixed.val( '' );
	};

	ShareSettings.fn._onClickFixedDisabled = function(event) {
		this.elements.positionFixed.prop( 'checked', false );
		this.elements.fixed.val( '' );
	};

});