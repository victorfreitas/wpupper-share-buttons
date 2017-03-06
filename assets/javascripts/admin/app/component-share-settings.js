WPUSB( 'WPUSB.Components.ShareSettings', function(Model, $, utils) {

	var currentIconSize;

	Model.fn.start = function() {
		this.init();
	};

	Model.fn.init = function() {
		this.addEventListener();
	};

	Model.fn.addEventListener = function() {
		this.elements.positionFixed.on( 'change', this._onChangeFixedLeft.bind( this ) );
		this.$el.addEvent( 'click', 'fixed-disabled', this );
		this.$el.addEvent( 'change', 'fixed-layout', this );
		this.$el.addEvent( 'keyup', 'fixed-label', this );
		this.$el.addEvent( 'keyup', 'plus-share-label', this );
		this.$el.addEvent( 'focus', 'plus-share-label', this );
		this.$el.addEvent( 'change', 'primary-layout', this );
		this.$el.addEvent( 'change', 'position-fixed', this );
		this.$el.addEvent( 'keyup', 'icons-size', this );
		this.$el.addEvent( 'mouseup', 'icons-size', this );
	};

	Model.fn._onChangeFixedLeft = function(event) {
		if ( this.elements.positionFixed.is( ':checked' ) ) {
			this.elements.fixed.val( 'on' );
			this.elements.trFixedLayout.fadeIn();
			this.setLabel();
			return;
		}

		this.clear();
	};

	Model.fn._onKeyupIconsSize= function(event) {
		var value  = Math.abs( event.currentTarget.value )
		  , item   = $( '.wpusb-item i' )
		  , layout = $( '[data-preview-layout]' ).data( 'preview-layout' )
		;

		if ( value > 100 ) {
			value = 100;
		}

		event.currentTarget.value = ( value ) ? value : '';

		currentIconSize = ( currentIconSize ) ? currentIconSize : item.css( 'font-size' );

		if ( !value ) {
			value = currentIconSize.replace( 'px', '' );
		}

		item.css( { 'font-size' : value + 'px' } );
	};

	Model.fn._onMouseupIconsSize= function(event) {
		this._onKeyupIconsSize( event );
	};

	Model.fn._onChangePositionFixed = function(event) {
		this.elements.trButtonBgColor.fadeIn();
	};

	Model.fn._onChangeFixedLayout = function(event) {
		this.activeLabel( event.currentTarget.value );
	};

	Model.fn._onKeyupFixedLabel = function(event) {
		var value = event.currentTarget.value
		  , label = $( '[data-element="fixed-label-text"]' )
		;

		if ( value ) {
			return label.text( value );
		}

		label.text( 'SHARES' );
	};

	Model.fn._onKeyupPlusShareLabel = function(event) {
		var value = event.currentTarget.value
		  , label = $( '[data-element="square-plus-text"]' )
		;

		if ( value ) {
			return label.attr({ 'data-title': value });
		}

		label.attr({ 'data-title': 'SHARES' });
	};

	Model.fn._onFocusPlusShareLabel = function(event) {
		if ( this.elements.preview.hasClass( 'preview-active' ) ) {
			return;
		}

		$( '#' + this.addPrefix( 'square-plus' ) ).click();
	};

	Model.fn._onChangePrimaryLayout = function(event) {
		var squarePlus     = 'fadeOut'
		  , countBgColor   = 'fadeOut'
		  , buttonsBgColor = 'fadeOut'
		;

		switch ( event.currentTarget.value ) {
			case 'buttons' :
				countBgColor   = 'fadeIn';
				buttonsBgColor = 'fadeIn';
				break;

			case 'default' :
			case 'rounded' :
			case 'square'  :
				countBgColor   = 'fadeIn';
				break;

			case 'square-plus' :
				squarePlus     = 'fadeIn';
				buttonsBgColor = 'fadeIn';
				break;
		}

		this.elements.trButtonBgColor[buttonsBgColor]();
		this.elements.trShareCountBgColor[countBgColor]();
		this.elements.trSharePlusLabel[squarePlus]();
	};

	Model.fn._onClickFixedDisabled = function(event) {
		this.clear();
	};

	Model.fn.clear = function() {
		this.elements.positionFixed.prop( 'checked', false );
		this.elements.fixed.val( '' );
		this.elements.trFixedLayout.fadeOut().find( '.fixed-layout' ).prop( 'checked', false );
		this.elements.trFixedLabel.fadeOut();
		$( '[data-action="preview-close"]' ).click();
	};

	Model.fn.setLabel = function() {
		var label = this.elements.trFixedLayout
		  , field = label.find( 'input' )
		;

		if ( !field.is( ':checked' ) ) {
			$( field.get(0) ).prop( 'checked', true );
		}

		this.activeLabel( label.find( 'input:checked' ).val() );
	};

	Model.fn.activeLabel = function(value) {
		if ( value === 'default' ) {
			return this.elements.trFixedLabel.fadeIn();
		}

		this.elements.trFixedLabel.fadeOut();
	};

});