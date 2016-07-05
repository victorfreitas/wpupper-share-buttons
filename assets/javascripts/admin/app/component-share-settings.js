WPUPPER( 'SB.Components.ShareSettings', function(ShareSettings, $) {

	ShareSettings.prototype.start = function(container) {
		this.prefix    = SB.vars.prefix;
		this.pos_fixed = container.byElement( 'fixed-left' );
		this.fixed     = container.byElement( 'fixed' );
		this.init();
	};

	ShareSettings.prototype.init = function() {
		this.addEventListener();
	};

	ShareSettings.prototype.addEventListener = function() {
		this.fixed.on( 'change', this._onChangeFixed.bind( this ) );
		this.pos_fixed.on( 'change', this._onChangeFixedLeft.bind( this ) );
	};

	ShareSettings.prototype._onChangeFixed = function(event) {
		if ( event.currentTarget.checked ) {
			this.pos_fixed.prop( 'checked', true );
			return;
		}

		this.pos_fixed.prop( 'checked', false );
	};

	ShareSettings.prototype._onChangeFixedLeft = function(event) {
		if ( event.currentTarget.checked ) {
			this.fixed.prop( 'checked', true );
			return;
		}

		this.fixed.prop( 'checked', false );
	};

});