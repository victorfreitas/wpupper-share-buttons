WPUSB( 'WPUSB.Components.WidgetFollow', function(Model, $) {

	Model.fn.start = function() {
		if ( !this.$el.length ) {
			return;
		}

		this.init();
	};

	Model.fn.init = function() {
		WPUSB.Sortable.create( this.elements.socialItems );
		this._colorPicker();
		this.addEventListener();
	};

	Model.fn._colorPicker = function() {
		if ( typeof $.prototype.wpColorPicker !== 'function' ) {
			return;
		}

		this.elements.colorPicker.wpColorPicker();
	};

	Model.fn.addEventListener = function() {
		this.$el.addEvent( 'click', 'title', this );
	};

	Model.fn._onClickTitle = function(event) {
		var current = this.elements[event.currentTarget.dataset.item]
		  , arrow
		;

		this.$el.find( '[data-field="content"]:visible' ).slideUp(200);
		this.$el.find( '[data-element="arrow"].active' ).removeClass( 'active' ).html( '&#9662;' );

		if ( !current.is( ':visible' ) ) {
			arrow = $( event.currentTarget ).find( '[data-element="arrow"]' );
			current.slideDown(200);
			arrow.addClass( 'active' ).html( '&#9652;' );
		}

		event.preventDefault();
	};

});