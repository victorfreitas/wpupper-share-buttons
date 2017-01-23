WPUSB( 'WPUSB.FixedContext', function(FixedContext, $) {

	FixedContext.create = function(container) {
		this.$el = container;

		if ( ! this.isLayoutFixed() || ! this.issetContext() ) {
			return;
		}

        this.init();
	};

	FixedContext.isLayoutFixed = function() {
		return this.$el.attr('class').match( '-fixed-' );
	};

	FixedContext.issetContext = function() {
		this.id = this.utils.getContext();
		return this.getContext( true );
	};

	FixedContext.init = function() {
		this.setContext();
		this.alignButtons();
	};

	FixedContext.setContext = function() {
		this.context = this.getContext();
		this.setRect();
	};

	FixedContext.setRect = function() {
		this.rect = this.context.getBoundingClientRect();
		this.top  = this.rect.top;

		this.setLeft( this.rect.left );
	};

	FixedContext.setLeft = function(left) {
		this.left = ( left - this.$el.width() );
	};

	FixedContext.alignButtons = function() {
		this.$el.byAction( 'close-buttons' ).remove();
		this.changeClass();
		this.$el.css({
			left : this.left
		});

		this.setLeftMobile();
	};

	FixedContext.setLeftMobile = function() {
		if ( window.innerWidth > 769 ) {
			return;
		}

		this.$el.css({
			left : 'initial'
		});
	};

	FixedContext.changeClass = function() {
		var prefix  = WPUSB.vars.prefix
		  , classes = this.$el.attr('class');

		if ( classes.match( '-fixed-left' ) ) {
			return;
		}

		this.$el.removeClass( prefix + '-fixed-right' );
		this.$el.addClass( prefix + '-fixed-left' );
	};

	FixedContext.getContext = function(verify) {
		var id = this.id.replace( /[^A-Z0-9a-z-_]/g, '' )
		  , el = document.getElementById( id );

		( verify ) ? this.sendNotice( id, el ) : '';

		return el;
	};

	FixedContext.sendNotice = function(id, el) {
		if ( id && ! el ) {
			console.warn( 'WPUSB: Context not found.' );
		}
	};

}, {} );