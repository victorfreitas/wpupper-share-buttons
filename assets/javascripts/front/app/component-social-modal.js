WPUSB( 'WPUSB.Components.SocialModal', function(SocialModal, $, utils) {

	SocialModal.fn.start = function() {
		this.prefix = '.' + utils.prefix + '-';
		this.body   = WPUSB.vars.body;
		this.modal  = this.body.find( this.prefix + 'modal-networks' );
		this.close  = this.modal.find( this.prefix + 'btn-close' );

		this.init();
	};

	SocialModal.fn.init = function() {
		WPUSB.OpenPopup.create( this.modal );

		this.modal.show();
		this.addEventListener();
		this.setSizes();
		this.setPosition();
		this.modal.hide();
	};

	SocialModal.fn.addEventListener = function() {
		this.$el.addEvent( 'click', 'close-popup', this );
		this.$el.on( 'click', this._onClickMask.bind( this ) );
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
		this.$el.css( 'opacity', 0 );
		this.$el.hide();
		this.modal.hide();
	};

	SocialModal.fn.openModal = function() {
		this.$el.css( 'opacity', 1 );
		this.$el.show();
		this.modal.show();
	};

	SocialModal.fn.setTop = function() {
		var height   = ( window.innerHeight * 0.5 )
		  ,	elHeight = ( this.modal.height() * 0.5 )
		  , position = ( height - elHeight )
		;

		this.btnTop = ( position - 20 ) + 'px';
		this.top    = position + 'px';
	};

	SocialModal.fn.setLeft = function() {
		var width    = ( window.innerWidth * 0.5 )
		  ,	elWidth  = ( this.modal.width() * 0.5 )
		  , position = ( width - elWidth )
		;

		this.btnRight = ( position - 40 ) + 'px';
		this.left     =  position + 'px';
	};

	SocialModal.fn.setPosition = function() {
		this.modal.css({
			top  : this.top,
			left : this.left
		});
		this.close.css({
			top   : this.btnTop,
			right : this.btnRight
		});
	};

});