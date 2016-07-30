WPUSB( 'WPUSB.Components.SharePreview', function(SharePreview, $, utils) {

	SharePreview.fn.start = function(container) {
		this.$el           = container;
		this.spinner       = $( '.ajax-spinner' );
		this.prefix        = WPUSB.vars.prefix;
		this.container     = container.closest( '.wpusb-wrap' );
		this.order         = this.container.byElement( 'sortable' );
		this.inputOrder    = this.container.byElement( 'order' );
		this.layoutOptions = $( '.layout-preview' );
		this.elements      = $( '.wpusb-select-item input' );
		this.init();
	};

	SharePreview.fn.init = function() {
		this.addEventListener();
	};

	SharePreview.fn.addEventListener = function() {
		this.layoutOptions.on( 'click', this._onClickLayout.bind( this ) );
		this.elements.on( 'click', this._onClick.bind( this ) );
		this.order.sortable( this.sortOptions() );
	};

	SharePreview.fn._onClickLayout = function(event) {
		this.layout = event.currentTarget.value;

		if ( event.currentTarget.className.match( 'fixed-layout' ) ) {
			this.layout = $( '[data-element="position-fixed"]:checked' ).val();
		}

		this._onClick();
	};

	SharePreview.fn._onClick = function(event) {
		if ( event ) {
			this.layout = $( '.layout-preview:checked' ).val();
		}

		this._update();
		this._stop();
	};

	SharePreview.fn.sortOptions = function() {
		return {
			opacity     : 0.5,
			cursor      : 'move',
			axis        : 'x',
			tolerance   : 'pointer',
			items       : '> td',
			placeholder : this.prefix + '-highlight',
	        update      : this._update.bind( this ),
	        stop        : this._stop.bind( this )
		};
	};

	SharePreview.fn._update = function(event, ui) {
		if ( ui ) {
			this.layout = $( '.layout-preview:checked' ).val();
		}

		this.itemsOrder = this.order.sortable( 'toArray' );
		this.inputOrder.val( JSON.stringify( this.itemsOrder ) );
	};

	SharePreview.fn._stop = function(event, ui) {
		this.itemsChecked = [];
		this.order.find( 'input:checked' )
		    .each(function(index, value) {
		    	this.itemsChecked.push( $( value ).val() );
		    }.bind( this ) );

		this.request();
	};

	SharePreview.fn.request = function() {
		this.spinner.css( 'visibility', 'visible' );
		var fixed_layout = $( '.fixed-layout:checked' )
		  , params       = {
				action       : 'wpusb_share_preview',
				layout       : this.layout,
			    fixed_layout : fixed_layout.val(),
				items        : JSON.stringify( this.itemsOrder ),
				checked      : JSON.stringify( this.itemsChecked )
			}
		;

		var ajax = $.ajax({
			type     : 'POST',
			url      : utils.getAjaxUrl(),
			data     : params,
			dataType : 'json'
		});

		ajax.then( $.proxy( this, '_done' ), $.proxy( this, '_fail' ) );
	};

	SharePreview.fn._done = function(response) {
		this.spinner.css( 'visibility', 'hidden' );
		this.$el
		     .byElement( this.prefix )
		      .addClass( this.prefix + '-preview-container' )
		      .html( this.render( response ) );
		WPUSB.Preview.create( this.$el );
	};

	SharePreview.fn._fail = function(throwError, status) {
		this.spinner.css( 'visibility', 'hidden' );
		console.warn( throwError );
	};

	SharePreview.fn.render = function(response) {
		return WPUSB.Templates[this.templateName()]
		                .call( null, response );
	};

	SharePreview.fn.templateName = function() {
		var layout;

		switch ( this.layout ) {
			case 'square-plus' :
				layout = 'square-plus';
				break;

			case 'fixed-left'  :
			case 'fixed-right' :
				layout = 'fixed';
				break;

			default:
				layout = 'share-preview';
		}

		return layout;
	};

});