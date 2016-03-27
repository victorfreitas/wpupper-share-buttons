WPUPPER( 'SB.Preview', function(Preview, $) {

	Preview.create = function(container) {
		this.locale  = $.prototype.getLocale();
		this.title   = $( '[data-action="no-title"]' );
		this.counter = $( '[data-action="no-counter"]' );
		this.init();
	};

	Preview.init = function() {
		this.defineTextByLocale();
		this.addEventListener();
	};

	Preview.addEventListener = function() {
		this.title.text( this.titleRemove );
		this.counter.text( this.counterRemove );
		this.title.on( 'click', this._onClickTitle.bind( this ) );
		this.counter.on( 'click', this._onClickCounter.bind( this ) );
	};

	Preview._onClickTitle = function(event) {
		event.preventDefault();
		var text = this.titleChangeText( this.title.text() );
		this.title.text( text );
		$( '.wpusb-title' ).toggle( 'fast' );
	};

	Preview._onClickCounter = function(event) {
		event.preventDefault();
		var text = this.counterChangeText( this.counter.text() );
		this.counter.text( text );
		$( '.wpusb-counter' ).toggle( 'fast' );
	};

	Preview.counterChangeText = function(text) {
		if ( text == this.counterRemove ) {
			return this.counterInsert;
		}

		return this.counterRemove;
	};

	Preview.titleChangeText = function(text) {
		if ( text == this.titleRemove ) {
			return this.titleInsert;
		}

		return this.titleRemove;
	};

	Preview.defineTextByLocale = function() {
		switch( this.locale ) {
			case 'pt_BR' :
				this.titleRemove   = 'Sem titúlo';
				this.counterRemove = 'Sem contador';
				this.titleInsert   = 'Com titúlo';
				this.counterInsert = 'Com contador';
				break;

			case 'es_ES' :
				this.titleRemove   = 'Con el título';
				this.counterRemove = 'Con el recuento';
				this.titleInsert   = 'Sin título';
				this.counterInsert = 'Sin recuento';
				break;

			default:
				this.titleRemove   = 'Untitled';
				this.counterRemove = 'No count';
				this.titleInsert   = 'With title';
				this.counterInsert = 'With count';
		}
	};

}, {} );