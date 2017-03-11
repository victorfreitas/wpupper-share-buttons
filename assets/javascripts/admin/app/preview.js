WPUSB( 'WPUSB.Preview', function(Model, $, utils) {

	Model.create = function(container, preview) {
		this.$el     = container;
		this.preview = preview;
		this.title   = $( '[data-action="no-title"]' );
		this.counter = $( '[data-action="no-counter"]' );
		this.titles  = utils.getPreviewTitles();
		this.init();
	};

	Model.init = function() {
		this.addEventListener();
	};

	Model.addEventListener = function() {
		this.title.text( this.titles.titleRemove );
		this.counter.text( this.titles.counterRemove );
		this.$el.addEvent( 'click', 'preview-close', this );
		this.title.on( 'click', this._onClickTitle.bind( this ) );
		this.counter.on( 'click', this._onClickCounter.bind( this ) );
	};

	Model._onClickPreviewClose = function(event) {
		event.preventDefault();
		this.preview.attr( 'class', '' ).empty();
	};

	Model._onClickTitle = function(event) {
		this.title.text( this.titleChangeText( this.title.text() ) );
		$( '.wpusb-title' ).toggle( 'fast' );

		event.preventDefault();
	};

	Model._onClickCounter = function(event) {
		event.preventDefault();
		var text = this.counterChangeText( this.counter.text() );
		this.counter.text( text );
		$( '.wpusb-counter' ).toggle( 'fast' );
	};

	Model.counterChangeText = function(text) {
		if ( text == this.titles.counterRemove ) {
			return this.titles.counterInsert;
		}

		return this.titles.counterRemove;
	};

	Model.titleChangeText = function(text) {
		if ( text === this.titles.titleRemove ) {
			return this.titles.titleInsert;
		}

		return this.titles.titleRemove;
	};

}, {} );