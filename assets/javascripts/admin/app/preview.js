WPUPPER( 'SB.Preview', function(Preview, $) {

	Preview.create = function(container) {
		this.locale  = $.prototype.getLocale();
		this.title   = $( '[data-action="remove-title"]' );
		this.counter = $( '[data-action="remove-counter"]' );
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
				this.titleRemove   = 'Remover titúlo';
				this.counterRemove = 'Remover contador';
				this.titleInsert   = 'Adicionar titúlo';
				this.counterInsert = 'Adicionar contador';
				break;

			case 'es_ES' :
				this.titleRemove   = 'Retire del título';
				this.counterRemove = 'Retire contador';
				this.titleInsert   = 'Añadir del título';
				this.counterInsert = 'Añadir contador';
				break;

			default:
				this.titleRemove   = 'Remove title';
				this.counterRemove = 'Remove counter';
				this.titleInsert   = 'Add title';
				this.counterInsert = 'Add counter';
		}
	};

}, {} );