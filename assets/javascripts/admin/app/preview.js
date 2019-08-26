WPUSB( 'WPUSB.Preview', function(Model, $, utils) {

	Model.create = function(container, preview) {
		this.$el     = container;
		this.preview = preview;
		this.title   = preview.byAction( 'no-title' );
		this.counter = preview.byAction( 'no-counter' );
    this.titles  = utils.getPreviewTitles();
    this.layout  = preview.find( '[data-preview-layout]' ).data( 'previewLayout' );

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
    event.preventDefault();

    this.title.text( this.titleChangeText( this.title.text() ) );
    this.preview.find( this.className( 'title' ) ).toggle( 'fast' );

    if ( this.layout === 'square-plus' ) {
      this.preview.find( this.className( 'full' ) )
        .toggleClass( utils.addPrefix( 'inside' ) );
    }
	};

	Model._onClickCounter = function(event) {
    var text = this.counterChangeText( this.counter.text() );

    this.counter.text( text );
    this.preview.find( this.className( 'counter')  ).toggle( 'fast' );

    event.preventDefault();
  };

  Model.className = function(name) {
    return '.'.concat( utils.prefix, '-', name );
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
