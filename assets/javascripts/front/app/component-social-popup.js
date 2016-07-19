WPUSB( 'WPUSB.Components.SocialPopup', function(SocialPopup, $) {

	SocialPopup.fn.start = function(container) {
		this.prefix    = '.' + WPUSB.vars.prefix + '-';
		this.container = container;
		this.body      = WPUSB.vars.body;
		this.$el       = container.find( this.prefix + 'networks' );
		this.close     = this.$el.find( this.prefix + 'btn-close' );
		this.init();
	};

	SocialPopup.fn.init = function() {
		WPUSB.OpenPopup.create( this.$el );
		this.addEventListener();
		this.container.show();
		this.setSizes();
		this.setPosition();
		this.container.hide();
	};

	SocialPopup.fn.addEventListener = function() {
		this.$el.addEvent( 'click', 'close-popup', this );
		this.body.addEvent( 'click', 'open-modal-networks', this );
		this.body.on( 'click', this._onClickBody.bind( this ) );
	};

	SocialPopup.fn._onClickClosePopup = function(event) {
		event.preventDefault();
		this.closeModal();
	};

	SocialPopup.fn._onClickBody = function(event) {
		var target = $( event.target ).is( this.prefix + 'popup-content' );

		if ( target ) {
			this.closeModal();
		}
	};

	SocialPopup.fn._onClickOpenModalNetworks = function(event) {
		event.preventDefault();
		this.container.css( 'opacity', 1 );
		this.container.show();
	};

	SocialPopup.fn.setSizes = function() {
		this.setTop();
		this.setLeft();
	};

	SocialPopup.fn.closeModal = function() {
		this.container.css( 'opacity', 0 );
		this.container.hide();
	};

	SocialPopup.fn.setTop = function() {
		var height   = ( window.innerHeight * 0.5 )
		  ,	elHeight = ( this.$el.height() * 0.5 )
		  , position = ( height - elHeight )
		;

		this.btnTop = ( position - 20 ) + 'px';
		this.top    = position + 'px';
	};

	SocialPopup.fn.setLeft = function() {
		var width    = ( window.innerWidth * 0.5 )
		  ,	elWidth  = ( this.$el.width() * 0.5 )
		  , position = ( width - elWidth )
		;

		this.btnRight = ( position - 40 ) + 'px';
		this.left     =  position + 'px';
	};

	SocialPopup.fn.setPosition = function() {
		this.$el.css({
			top  : this.top,
			left : this.left
		});
		this.close.css({
			top   : this.btnTop,
			right : this.btnRight
		});
	};

});