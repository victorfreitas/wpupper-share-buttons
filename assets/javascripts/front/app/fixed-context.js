WPUPPER( 'SB.FixedContext', function(FixedContext, $) {

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
		this.id = this.$el.getContext();
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
			top  : this.top,
			left : this.left
		});
	};

	FixedContext.changeClass = function() {
		var prefix  = SB.vars.prefix
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
			console.warn( 'WPUPPER: Context not found.' );
		}
	};

}, {} );