WPUSB( 'WPUSB.Preview', function(Preview, $) {

	Preview.create = function(container) {
		this.title   = $( '[data-action="no-title"]' );
		this.counter = $( '[data-action="no-counter"]' );
		this.preview = Preview.utils.getPreviewTitles();
		this.init();
	};

	Preview.init = function() {
		this.addEventListener();
	};

	Preview.addEventListener = function() {
		this.title.text( this.preview.titleRemove );
		this.counter.text( this.preview.counterRemove );
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
		if ( text == this.preview.counterRemove ) {
			return this.preview.counterInsert;
		}

		return this.preview.counterRemove;
	};

	Preview.titleChangeText = function(text) {
		if ( text == this.preview.titleRemove ) {
			return this.preview.titleInsert;
		}

		return this.preview.titleRemove;
	};

}, {} );