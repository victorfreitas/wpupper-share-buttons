WPUPPER( 'SB.Components.SharePreview', function(SharePreview, $) {

	SharePreview.prototype.start = function(container) {
		this.preview       = container;
		this.spinner       = $( '.ajax-spinner' );
		this.prefix        = SB.vars.prefix;
		this.container     = container.closest( '.wpusb-wrap' );
		this.sort          = this.container.byElement( 'sortable' );
		this.inputOrder    = this.container.byElement( 'order' );
		this.layoutOptions = $( '.layout-preview' );
		this.elements      = $( '.wpusb-select-item input' );
		this.contentBefore = $( '#' + this.prefix + '-before:checked' );
		this.contentAfter  = $( '#' + this.prefix + '-after:checked' );
		this.init();
	};

	SharePreview.prototype.init = function() {
		this.addEventListener();
	};

	SharePreview.prototype.addEventListener = function() {
		this.layoutOptions.on( 'click', this._onClickLayout.bind( this ) );
		this.elements.on( 'click', this._onClick.bind( this ) );
		this.sort.sortable( this.sortOptions() );
	};

	SharePreview.prototype._onClickLayout = function(event) {
		if ( 'fixed-left' !== event.currentTarget.value ) {
			$( '.layout-fixed, .wpusb-fixed' ).prop( 'checked', false );

			if ( this.contentAfter.length ) {
				this.contentAfter.prop( 'checked', true );
			}

			if ( this.contentBefore.length ) {
				this.contentBefore.prop( 'checked', true );
			}
		}

		this._onClick();
	};

	SharePreview.prototype._onClick = function(event) {
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
		this.layoutPreview = $( '.layout-preview:checked' );
		this.layout        = this.layoutName();
		this.itemsOrder    = this.sort.sortable( 'toArray' );
		this.inputOrder.val( JSON.stringify( this.itemsOrder ) );
	};

	SharePreview.prototype._stop = function(event, ui) {
		this.itemsChecked = [];
		this.sort.find( 'input:checked' )
		    .each(function(index, value) {
		    	this.itemsChecked.push( $( value ).val() );
		    }.bind( this ) );

		this.request();
	};

	SharePreview.prototype.request = function() {
		this.spinner.css( 'visibility', 'visible' );
		var done   = $.proxy( this, '_done' )
		  , fail   = $.proxy( this, '_fail' )
		  ,	params = {
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

		ajax.then( done, fail );
	};

	SharePreview.prototype._done = function(response) {
		this.spinner.css( 'visibility', 'hidden' );
		this.preview.html( this.render( response ) );
		SB.Preview.create( this.preview );
	};

	SharePreview.prototype._fail = function(throwError, status) {
		this.spinner.css( 'visibility', 'hidden' );
		console.warn( throwError );
	};

	SharePreview.prototype.render = function(response) {
		return WPUPPER.Templates[this.templateName()]
		                .call( null, response );
	};

	SharePreview.prototype.layoutName = function() {
		var layout = this.layoutPreview;

		if ( layout[1] ) {
			return $( layout[1] ).val();
		}

		return layout.val();
	};

	SharePreview.prototype.templateName = function() {
		var layout;

		switch ( this.layout ) {
			case 'square-plus' :
				layout = 'square-plus';
				break;
			case 'fixed-left' :
				layout = 'fixed-left';
				break;

			default:
				layout = 'share-preview';
		}

		return layout;
	};

});