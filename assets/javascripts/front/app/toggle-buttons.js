WPUSB( 'WPUSB.ToggleButtons', function(Model, $, utils) {

	Model.create = function(layout, context) {
		if ( layout !== 'fixed' ) {
			return;
		}

		this.$el     = context.$el;
		this.buttons = context.elements.buttons;
		this.init();
	};

	Model.init = function() {
		this.addEventListener();
	};

	Model.addEventListener = function() {
		this.$el.addEvent( 'click', 'close-buttons', this );
	};

	Model._onClickCloseButtons = function(event) {
		var iconRight = utils.addPrefix( 'icon-right' )
		  , active    = utils.addPrefix( 'toggle-active' )
		;

		this.buttons.toggleClass( utils.addPrefix( 'buttons-hide' ) );
		$( event.currentTarget ).toggleClass( iconRight + ' ' + active );

		event.preventDefault();
	};

});