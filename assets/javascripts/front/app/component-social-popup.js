WPUPPER( 'SB.Components.SocialPopup', function(SocialPopup, $) {


	SocialPopup.prototype.start = function(container) {
		this.prefix    = '.' + SB.vars.prefix + '-';
		this.container = container;
		this.$el       = container.find( this.prefix + 'networks' );
		this.close     = this.$el.byAction( 'close-popup' );
		this.open      = SB.vars.body.byAction( 'open-modal-networks' );
		this.init();
	};

	SocialPopup.prototype.init = function() {
		SB.OpenPopup.create( this.$el );
		this.addEventListener();
		this.container.show();
		this.setSizes();
		this.setPosition();
		this.container.hide();
	};

	SocialPopup.prototype.addEventListener = function() {
		this.close.on( 'click', this._onClickClose.bind( this ) );
		SB.vars.body.on( 'click', this._onClickBody.bind( this ) );
		this.open.on( 'click', this._onClickOpen.bind( this ) );
	};

	SocialPopup.prototype._onClickClose = function(event) {
		event.preventDefault();
		this.closeModal();
	};

	SocialPopup.prototype._onClickBody = function(event) {
		var target = $( event.target ).is( this.prefix + 'popup-content' );

		if ( target ) {
			this.closeModal();
		}
	};

	SocialPopup.prototype._onClickOpen = function(event) {
		event.preventDefault();
		this.container.fadeTo( 'slow', 1 );
	};

	SocialPopup.prototype.setSizes = function() {
		this.setTop();
		this.setLeft();
	};

	SocialPopup.prototype.closeModal = function() {
		this.container.fadeOut( 'slow' );
	};

	SocialPopup.prototype.setTop = function() {
		var height   = ( window.innerHeight * 0.5 )
		  ,	elHeight = ( this.$el.height() * 0.5 )
		;

		this.top = ( height - elHeight ) + 'px';
	};

	SocialPopup.prototype.setLeft = function() {
		var width   = ( window.innerWidth * 0.5 )
		  ,	elWidth = ( this.$el.width() * 0.5 )
		;

		this.left = ( width - elWidth ) + 'px';
	};

	SocialPopup.prototype.setPosition = function() {
		this.$el.css({
			top  : this.top,
			left : this.left
		});
	};

});