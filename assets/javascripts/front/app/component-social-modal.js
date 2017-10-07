WPUSB( 'WPUSB.Components.ButtonsSection', function(Modal, $, utils) {

	var modalIds = {};

	Modal.fn.start = function() {
		this.id      = this.$el.find( '.' + this.addPrefix( 'share a' ) ).data( 'modal-id' );
		this.modalId = this.addPrefix( 'modal-container-' + this.id );
		this.maskId  = this.addPrefix( 'modal-' + this.id );
		this.init();
	};

	Modal.fn.init = function() {
		this.setModal();
		this.setMask();

		WPUSB.OpenPopup.create( this.modal, this );

		this.addEventListener();

		modalIds[this.id] = true;
	};

	Modal.fn.setModal = function() {
		var modal = this.$el.byElement( this.modalId );

		if ( !modalIds[this.id] ) {
			WPUSB.vars.body.append( modal.clone() );
		}

		modal.show();

		this.modal = WPUSB.vars.body.byElement( this.modalId );
		this.close = this.modal.find( this.addPrefix( 'btn-close' ) );

		this.setSizes();
		this.setPosition();

		modal.remove();
	};

	Modal.fn.setMask = function() {
		var mask = this.$el.byElement( this.maskId );

		if ( !modalIds[this.id] ) {
			WPUSB.vars.body.append( mask.clone() );
		}

		this.mask = WPUSB.vars.body.byElement( this.maskId );
		mask.remove();
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