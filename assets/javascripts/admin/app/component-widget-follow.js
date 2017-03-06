WPUSB( 'WPUSB.Components.WidgetFollow', function(Model, $, utils) {

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
		this.$el.addEvent( 'change', 'networks', this );
		this.$el.addEvent( 'keyup', 'field-url', this );
		this.$el.addEvent( 'focusout', 'field-url', this );
	};

	Model.fn._onClickTitle = function(event) {
		var current = this.elements[event.currentTarget.dataset.item]
		  , arrow
		;

		if ( !current ) {
			return;
		}

		this.$el.find( '[data-field="content"]:visible' ).slideUp( 200 );
		this.$el.find( '[data-element="arrow"].active' ).removeClass( 'active' ).html( '&#9662;' );

		if ( !current.is( ':visible' ) ) {
			arrow = $( event.currentTarget ).find( '[data-element="arrow"]' );
			current.slideDown( 200 );
			arrow.addClass( 'active' ).html( '&#9652;' );
		}

		event.preventDefault();
	};

	Model.fn._onChangeNetworks = function(event) {
		event.preventDefault();

		var name    = event.currentTarget.value
		  , element = this.elements[name + 'Url']
		  , info    = this.elements.infoMessage
		;

		if ( !event.currentTarget.checked || !element ) {
			info.fadeOut();
			return;
		}

		if ( element.isEmptyValue() ) {
			info.text( info.data( 'message' ).replace( '[item]', name ) ).slideDown( 200 );
			return;
		}
	};

	Model.fn._onKeyupFieldUrl = function(event) {
		this.validateFieldUrl( event );
	};

	Model.fn._onFocusoutFieldUrl = function(event) {
		this.validateFieldUrl( event );
	};

	Model.fn.validateFieldUrl = function(event) {
		var regex  = /(https?:)\/\/(www\.)?.+(\.\w{2,})/
		  , target = $( event.currentTarget )
		;

		if ( target.isEmptyValue() ) {
			target.css({
				'background-color' : '#fff',
				'border-color'     : '#ddd'
			});
			return;
		}

		if ( !event.currentTarget.value.match( regex ) ) {
			target.css({
				'background-color' : '#ebccd1',
				'border-color'     : '#ff9cac',
				'box-shadow'       : 'none'
			});
			return;
		}

		target.css({
			'background-color' : '#caffd4',
			'border-color'     : '#caffd4'
		});
	};

});