WPUSB( 'WPUSB.Components.SocialModal', function(SocialModal, $) {

	SocialModal.fn.start = function(container) {
		this.prefix    = '.' + WPUSB.vars.prefix + '-';
		this.container = container;
		this.body      = WPUSB.vars.body;
		this.$el       = this.body.find( this.prefix + 'modal-networks' );
		this.close     = this.$el.find( this.prefix + 'btn-close' );

		this.init();
	};

	SocialModal.fn.init = function() {
		WPUSB.OpenPopup.create( this.$el );

		this.$el.show();
		this.addEventListener();
		this.setSizes();
		this.setPosition();
		this.$el.hide();
	};

	SocialModal.fn.addEventListener = function() {
		this.container.addEvent( 'click', 'close-popup', this );
		this.container.on( 'click', this._onClickMask.bind( this ) );
		this.body.addEvent( 'click', 'open-modal-networks', this );
	};

	SocialModal.fn._onClickClosePopup = function(event) {
		event.preventDefault();
		this.closeModal();
	};

	SocialModal.fn._onClickMask = function(event) {
		event.preventDefault();
		this.closeModal();
	};

	SocialModal.fn._onClickOpenModalNetworks = function(event) {
		event.preventDefault();
		this.openModal();
	};

	SocialModal.fn.setSizes = function() {
		this.setTop();
		this.setLeft();
	};

	SocialModal.fn.closeModal = function() {
		this.container.css( 'opacity', 0 );
		this.container.hide();
		this.$el.hide();
	};

	SocialModal.fn.openModal = function() {
		this.container.css( 'opacity', 1 );
		this.container.show();
		this.$el.show();
	};

	SocialModal.fn.setTop = function() {
		var height   = ( window.innerHeight * 0.5 )
		  ,	elHeight = ( this.$el.height() * 0.5 )
		  , position = ( height - elHeight )
		;

		this.btnTop = ( position - 20 ) + 'px';
		this.top    = position + 'px';
	};

	SocialModal.fn.setLeft = function() {
		var width    = ( window.innerWidth * 0.5 )
		  ,	elWidth  = ( this.$el.width() * 0.5 )
		  , position = ( width - elWidth )
		;

		this.btnRight = ( position - 40 ) + 'px';
		this.left     =  position + 'px';
	};

	SocialModal.fn.setPosition = function() {
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