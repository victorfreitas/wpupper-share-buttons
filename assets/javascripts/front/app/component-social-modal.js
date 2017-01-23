WPUSB( 'WPUSB.Components.ButtonsSection', function(Modal, $) {

	Modal.fn.start = function() {
		this.prefix = '.' + this.utils.prefix;
		this.id     = this.$el.find( this.prefix + '-share a' ).data( 'modal-id' );
		this.modal  = this.$el.byElement( this.utils.prefix + '-modal-container-' + this.id );
		this.close  = this.modal.find( this.prefix + '-btn-close' );
		this.mask   = this.$el.byElement( this.utils.prefix + '-modal-' + this.id );
		this.init();
	};

	Modal.fn.init = function() {
		WPUSB.OpenPopup.create( this.modal );

		this.modal.show();
		this.addEventListener();
		this.setSizes();
		this.setPosition();
		this.modal.hide();
	};

	Modal.fn.addEventListener = function() {
		this.mask.addEvent( 'click', 'close-popup', this );
		this.mask.on( 'click', this._onClickClosePopup.bind( this ) );
		this.$el.on( 'click', '[data-modal-id="' + this.id + '"]', this._onClickOpenModalNetworks.bind( this ) );
	};

	Modal.fn._onClickClosePopup = function(event) {
		event.preventDefault();
		this.closeModal();
	};

	Modal.fn._onClickOpenModalNetworks = function(event) {
		event.preventDefault();
		this.openModal();
	};

	Modal.fn.setSizes = function() {
		this.setTop();
		this.setLeft();
	};

	Modal.fn.closeModal = function() {
		this.mask.css( 'opacity', 0 );
		this.mask.hide();
		this.modal.hide();
	};

	Modal.fn.openModal = function() {
		this.mask.css( 'opacity', 1 );
		this.mask.show();
		this.modal.show();
	};

	Modal.fn.setTop = function() {
		var height   = ( window.innerHeight * 0.5 )
		  ,	elHeight = ( this.modal.height() * 0.5 )
		  , position = ( height - elHeight )
		;

		this.btnTop = ( position - 20 ) + 'px';
		this.top    = position + 'px';
	};

	Modal.fn.setLeft = function() {
		var width    = ( window.innerWidth * 0.5 )
		  ,	elWidth  = ( this.modal.width() * 0.5 )
		  , position = ( width - elWidth )
		;

		this.btnRight = ( position - 40 ) + 'px';
		this.left     =  position + 'px';
	};

	Modal.fn.setPosition = function() {
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