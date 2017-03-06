WPUSB( 'WPUSB.ColorPicker', function(Model, $, utils) {

	Model.create = function(container) {
        this.$el = container.find( '.' + utils.addPrefix( 'wrap' ) );
		this.init();
	};

	Model.init = function() {
		this.renderColorPicker();
	};

	Model.renderColorPicker = function() {
		var options = {
		    change: this._onChangeColorPicker.bind( this )
		};

		this.$el.find( '[data-colorpicker="true"]' ).wpColorPicker( options );
	};

	Model._onChangeColorPicker = function(event, ui) {
		event.preventDefault();
		this.activePreview( event.target );

		var color   = ui.color.toString()
    	  , element = event.target.dataset.element
    	  , item    = $( '[data-item="' + element + '"]' )
    	  , layout  = $( '[data-preview-layout]' ).data( 'preview-layout' )
    	  , style   = event.target.dataset.style
    	;

    	if ( !item.length ) {
    		return;
    	}

    	switch ( layout ) {
    		case 'buttons':
    			this.styleCountPseudo( element, style, color );
    			this.styleShadow( element, color );
    			this.setItemColorBg( item, style, color );
    			return;

    		case 'square-plus':
    			this.styleShadow( element, color );
    			this.setItemColorBg( item, style, color );
    			return;

    		case 'default':
    		case 'rounded':
    		case 'square' :
    			this.styleCountPseudo( element, style, color );
    			this.setItemColor( item, style, color, element );
    			break;

    		case 'fixed-left':
    		case 'fixed-right':
    			this.styleCountPseudo( element, style, color );
    			this.setItemColorBg( item, style, color );
    			return;
    	}
    };

    Model.setItemColorBg = function(item, style, color) {
    	item.css( style, color );
    };

    Model.setItemColor = function(item, style, color, element) {
    	if ( style !== 'color' && element !== 'text' ) {
    		return;
    	}

    	item.css( style, color );
    };

    Model.activePreview = function(target) {
    	if ( $( '[data-element="preview"]' ).hasClass( 'preview-active' ) ) {
    		return;
    	}

    	$( '.wpusb-layout-options input:checked' ).click();
    };

    Model.styleCountPseudo = function(element, style, color) {
    	if ( !( element === 'text' && style === 'background-color' ) ) {
    		return;
    	}

		var styles = '.wpusb-count:after{border-color:transparent ' + color + ' transparent transparent !important}';
		$( '[data-element-style]' ).text( styles );
    };

    Model.styleShadow = function(element, color) {
    	if ( element !== 'bg-color' ) {
    		return;
    	}

		$( '.wpusb-button, .wpusb-link' ).css( 'box-shadow', '0 2px ' + color );
    };

}, {} );