WPUSB( 'WPUSB.ToggleButtons', function(Model, $) {

	Model.create = function(layout, context) {
		if ( layout !== 'fixed' ) {
			return;
		}

		this.$el     = context.$el;
		this.buttons = context.elements.buttons;
		this.prefix  = this.utils.prefix + '-';
		this.init();
	};

	Model.init = function() {
		this.addEventListener();
	};

	Model.addEventListener = function() {
		this.$el.addEvent( 'click', 'close-buttons', this );
	};

	Model._onClickCloseButtons = function(event) {
		var iconRight = this.prefix + 'icon-right'
		  , active    = this.prefix + 'toggle-active'
		;

		this.buttons.toggleClass( this.prefix + 'buttons-hide' );
		$( event.currentTarget ).toggleClass( iconRight + ' ' + active );

		event.preventDefault();
	};

});