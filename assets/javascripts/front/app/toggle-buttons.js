WPUPPER( 'SB.ToggleButtons', function(ToggleButtons, $) {

	ToggleButtons.create = function(context, container) {
		if ( context !== 'fixed' ) {
			return;
		}

		this.$el          = container;
		this.prefix       = SB.vars.prefix + '-';
		this.closeButtons = SB.vars.body.byAction( 'close-buttons' );
		this.buttons      = container.byElement( 'buttons' );
		this.init();
	};

	ToggleButtons.init = function() {
		this.addEventListener();
	};

	ToggleButtons.addEventListener = function() {
		this.closeButtons.on( 'click', this._onCloseButtons.bind( this ) );
	};

	ToggleButtons._onCloseButtons = function(event) {
		event.preventDefault();

		var iconRight = this.prefix + 'icon-right'
		  , active    = this.prefix + 'toggle-active';

		this.buttons.toggleClass( this.prefix + 'buttons' );
		this.closeButtons.toggleClass( iconRight + ' ' + active );
	};

});