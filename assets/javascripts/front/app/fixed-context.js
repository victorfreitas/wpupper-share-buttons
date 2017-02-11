WPUSB( 'WPUSB.FixedContext', function(Model, $) {

	Model.create = function(container) {
		this.$el = container;
		this.id  = this.utils.getContext();

		if ( ! this.id || ! this.isLayoutFixed() || ! this.issetContext() ) {
			return;
		}

        this.init();
	};

	Model.isLayoutFixed = function() {
		return this.$el.attr('class').match( '-fixed-' );
	};

	Model.issetContext = function() {
		return this.getContext( true );
	};

	Model.init = function() {
		this.setContext();
		this.alignButtons();
	};

	Model.setContext = function() {
		this.context = this.getContext();
		this.setRect();
	};

	Model.setRect = function() {
		this.rect = this.context.getBoundingClientRect();
		this.top  = this.rect.top;

		this.setLeft( this.rect.left );
	};

	Model.setLeft = function(left) {
		this.left = ( left - this.$el.width() );
	};

	Model.alignButtons = function() {
		this.$el.byAction( 'close-buttons' ).remove();
		this.changeClass();
		this.$el.css({
			left : this.left
		});

		this.setLeftMobile();
	};

	Model.setLeftMobile = function() {
		if ( window.innerWidth > 769 ) {
			return;
		}

		this.$el.css({
			left : 'initial'
		});
	};

	Model.changeClass = function() {
		var prefix  = WPUSB.vars.prefix
		  , classes = this.$el.attr('class');

		if ( classes.match( '-fixed-left' ) ) {
			return;
		}

		this.$el.removeClass( prefix + '-fixed-right' );
		this.$el.addClass( prefix + '-fixed-left' );
	};

	Model.getContext = function(verify) {
		var id = this.id.replace( /[^A-Z0-9a-z-_]/g, '' )
		  , el
		;

		if ( !id ) {
			return false;
		}

		el = document.getElementById( id );

		( verify ) ? this.addNotice( el ) : '';

		return el;
	};

	Model.addNotice = function(el) {
		if ( ! el ) {
			console.log( 'WPUSB: Context not found.' );
		}
	};

}, {} );