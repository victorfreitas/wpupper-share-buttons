WPUPPER( 'SB.Components.SharePreview', function(SharePreview, $) {

	SharePreview.prototype.start = function(container) {
		this.$el           = container;
		this.spinner       = $( '.ajax-spinner' );
		this.prefix        = SB.vars.prefix;
		this.container     = container.closest( '.wpusb-wrap' );
		this.order         = this.container.byElement( 'sortable' );
		this.inputOrder    = this.container.byElement( 'order' );
		this.layoutOptions = $( '.layout-preview' );
		this.elements      = $( '.wpusb-select-item input' );
		this.init();
	};

	SharePreview.prototype.init = function() {
		this.addEventListener();
	};

	SharePreview.prototype.addEventListener = function() {
		this.layoutOptions.on( 'click', this._onClickLayout.bind( this ) );
		this.elements.on( 'click', this._onClick.bind( this ) );
		this.order.sortable( this.sortOptions() );
	};

	SharePreview.prototype._onClickLayout = function(event) {
		this.layout = event.currentTarget.value;
		this._onClick();
	};

	SharePreview.prototype._onClick = function(event) {
		if ( event ) {
			this.layout = $( '.layout-preview:checked' ).val();
		}

		this._update();
		this._stop();
	};

	SharePreview.prototype.sortOptions = function() {
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

	SharePreview.prototype._update = function(event, ui) {
		if ( ui ) {
			this.layout = $( '.layout-preview:checked' ).val();
		}

		this.itemsOrder = this.order.sortable( 'toArray' );
		this.inputOrder.val( JSON.stringify( this.itemsOrder ) );
	};

	SharePreview.prototype._stop = function(event, ui) {
		this.itemsChecked = [];
		this.order.find( 'input:checked' )
		    .each(function(index, value) {
		    	this.itemsChecked.push( $( value ).val() );
		    }.bind( this ) );

		this.request();
	};

	SharePreview.prototype.request = function() {
		this.spinner.css( 'visibility', 'visible' );
		var params = {
				action  : 'share_preview',
				layout  : this.layout,
				items   : JSON.stringify( this.itemsOrder ),
				checked : JSON.stringify( this.itemsChecked )
			}
		;

		var ajax = $.ajax({
			type     : 'POST',
			url      : $.prototype.getAjaxUrl(),
			data     : params,
			dataType : 'json'
		});

		ajax.then( $.proxy( this, '_done' ), $.proxy( this, '_fail' ) );
	};

	SharePreview.prototype._done = function(response) {
		this.spinner.css( 'visibility', 'hidden' );
		this.$el
		     .byElement( this.prefix )
		      .addClass( this.prefix + '-preview-container' )
		      .html( this.render( response ) );
		SB.Preview.create( this.$el );
	};

	SharePreview.prototype._fail = function(throwError, status) {
		this.spinner.css( 'visibility', 'hidden' );
		console.warn( throwError );
	};

	SharePreview.prototype.render = function(response) {
		return WPUPPER.Templates[this.templateName()]
		                .call( null, response );
	};

	SharePreview.prototype.templateName = function() {
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