WPUSB( 'WPUSB.Components.ShareSettings', function(ShareSettings, $, utils) {

	ShareSettings.fn.start = function(container) {
		this.prefix   = WPUSB.vars.prefix;
		this.posFixed = container.byElement( 'position-fixed' );
		this.fixed    = container.byElement( 'fixed' );
		this.clear    = container.byAction( 'fixed-disabled' );
		this.elNotice = $( '.wpusb-admin-notice' );
		this.init();
	};

	ShareSettings.fn.init = function() {
		this.addEventListener();
	};

	ShareSettings.fn.addEventListener = function() {
		this.posFixed.on( 'change', this._onChangeFixedLeft.bind( this ) );
		this.clear.on( 'click', this._onclickClear.bind( this ) );
		this.elNotice.on( 'click', '.notice-dismiss', this._onClickNotice.bind( this ) );
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

	ShareSettings.fn._onClickNotice = function(event) {
		var nonce = this.elNotice.data( 'nonce' );
		$.ajax({
			type : 'POST',
			url  : utils.getAjaxUrl(),
			data : {
				action : 'wpusb_admin_notices',
				nonce  : nonce
			}
		});
	};

});