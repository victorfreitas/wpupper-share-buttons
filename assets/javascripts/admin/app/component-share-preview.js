WPUSB( 'WPUSB.Components.SharePreview', function(SharePreview, $) {

	SharePreview.fn.start = function() {
		this.spinner       = $( '.ajax-spinner' );
		this.prefix        = this.utils.prefix;
		this.wrap          = this.$el.closest( '.wpusb-wrap' );
		this.order         = this.wrap.byElement( 'sortable' );
		this.inputOrder    = this.wrap.byElement( 'order' );
		this.layoutOptions = $( '.layout-preview' );
		this.list          = $( '.wpusb-select-item input' );
		this.init();
	};

	SharePreview.fn.init = function() {
		this.addEventListener();
	};

	SharePreview.fn.addEventListener = function() {
		this.layoutOptions.on( 'click', this._onClickLayout.bind( this ) );
		this.list.on( 'click', this._onClick.bind( this ) );
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

		var order = this.order.sortable( 'toArray' );
		this.inputOrder.val( JSON.stringify( order ) );
	};

	SharePreview.fn._stop = function(event, ui) {
		this.itemsChecked = [];

		this.each( this.order.find( 'input:checked' ) );
		this.request();
	};

	SharePreview.fn.each = function(items) {
		var self = this;

	    items.each(function(index, item) {
	    	self.itemsChecked.push( item.value );
	    });
	};

	SharePreview.fn.request = function() {
		this.spinner.css( 'visibility', 'visible' );

		var fixed_layout = $( '.fixed-layout:checked' )
		  , params       = {
				action       : 'wpusb_share_preview',
				layout       : this.layout,
			    fixed_layout : fixed_layout.val(),
				checked      : JSON.stringify( this.itemsChecked )
			}
		;

		var ajax = $.ajax({
			type     : 'POST',
			url      : this.utils.getAjaxUrl(),
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

	SharePreview.fn._fail = function(xhr, status, thrownError) {
		this.spinner.css( 'visibility', 'hidden' );
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