WPUPPER( 'SB.Components.ShareSettings', function(ShareSettings, $) {

	ShareSettings.fn.start = function(container) {
		this.prefix   = SB.vars.prefix;
		this.posFixed = container.byElement( 'position-fixed' );
		this.fixed    = container.byElement( 'fixed' );
		this.clear    = container.byAction( 'fixed-disabled' );
		this.init();
	};

	ShareSettings.fn.init = function() {
		this.addEventListener();
	};

	ShareSettings.fn.addEventListener = function() {
		this.posFixed.on( 'change', this._onChangeFixedLeft.bind( this ) );
		this.clear.on( 'click', this._onclickClear.bind( this ) );
	};

	ShareSettings.fn._onChangeFixedLeft = function(event) {
		if ( this.posFixed.is( ':checked' ) ) {
			this.fixed.val( 'on' );
			return;
		}

		this.fixed.val( '' );
	};

	ShareSettings.fn._onclickClear = function(event) {
		this.posFixed.prop( 'checked', false );
		this.fixed.val( '' );
	};

});