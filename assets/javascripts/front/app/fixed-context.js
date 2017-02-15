WPUSB( 'WPUSB.FixedContext', function(Model, $) {

	Model.create = function(container) {
		this.$el = container.find( '#' + this.utils.prefix + '-container-fixed' );
		this.id  = this.utils.getContext();

		if ( !this.id || !this.$el.length ) {
			return;
		}

        this.init();
	};

	Model.init = function() {
		this.setContext();

		if ( !this.context ) {
			return;
		}

		this.setRect();
		this.setLeft( this.rect.left );
		this.alignButtons();
	};

	Model.setContext = function() {
		this.context = this.getElement();
	};

	Model.setRect = function() {
		this.rect = this.context.getBoundingClientRect();
		this.top  = this.rect.top;
	};

	Model.setLeft = function(left) {
		this.left = ( left - this.$el.width() );
	};

	Model.alignButtons = function() {
		this.$el.byAction( 'close-buttons' ).remove();
		this.changeClass();

		this.$el.css( 'left', this.left );

		this.setLeftMobile();
	};

	Model.setLeftMobile = function() {
		if ( window.innerWidth > 769 ) {
			return;
		}

		this.$el.css( 'left', 'initial' );
	};

	Model.changeClass = function() {
		var prefix = this.utils.prefix;

		if ( this.$el.hasClass( prefix + '-fixed-left' ) ) {
			return;
		}

		this.$el.removeClass( prefix + '-fixed-right' );
		this.$el.addClass( prefix + '-fixed-left' );
	};

	Model.getElement = function() {
		var id = this.id.replace( /[^A-Z0-9a-z-_]/g, '' )
		  , el = this.utils.getId( id )
		;

		( !el ) ? this.addNotice( el, id ) : '';

		return el;
	};

	Model.addNotice = function(el, id) {
		if ( !el ) {
			console.log( 'WPUSB: ID (' + id + ') not found' );
		}
	};

}, {} );