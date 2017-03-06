WPUSB( 'WPUSB.Components.SharePreview', function(Model, $, utils) {

	var SPINNER   = '<span class="ajax-spinner" style="visibility:visible">loading...</span>'
	  , CLOSE_BTN = '<button class="button wpusb-preview-close" data-action="preview-close">x</button>'
	;

	Model.fn.start = function() {
		this.spinner       = $( '.ajax-spinner' );
		this.wrap          = this.$el.closest( '.' + this.addPrefix( 'wrap' ) );
		this.order         = this.wrap.byElement( 'sortable' );
		this.inputOrder    = this.wrap.byElement( 'order' );
		this.layoutOptions = $( '.layout-preview' );
		this.list          = $( '.' + this.addPrefix( 'select-item input' ) );
		this.init();
	};

	Model.fn.init = function() {
		this.addEventListener();
	};

	Model.fn.addEventListener = function() {
		this.layoutOptions.on( 'click', this._onClickLayout.bind( this ) );
		this.list.on( 'click', this._onClickList.bind( this ) );
		this.order.sortable( this.sortOptions() );
	};

	Model.fn._onClickLayout = function(event) {
		this.layout = event.currentTarget.value;

		if ( event.currentTarget.className.match( 'fixed-layout' ) ) {
			this.layout = $( '[data-element="position-fixed"]:checked' ).val();
		}

		$( '.' + this.addPrefix( 'layout-options' ) ).trigger( 'changeLayout', this.layout );

		this._update();
		this._stop();
	};

	Model.fn._onClickList = function(event) {
		this.layout = $( '.layout-preview:checked' ).val();

		this._update();
		this._stop();
	};

	Model.fn.sortOptions = function() {
		return {
			opacity     : 0.5,
			cursor      : 'move',
			tolerance   : 'pointer',
			items       : '> td',
			placeholder : this.addPrefix( 'highlight' ),
	        update      : this._update.bind( this ),
	        stop        : this._stop.bind( this )
		};
	};

	Model.fn._update = function(event, ui) {
		if ( ui ) {
			this.layout = $( '.layout-preview:checked' ).val();
		}

		var order = this.order.sortable( 'toArray' );
		this.inputOrder.val( JSON.stringify( order ) );
	};

	Model.fn._stop = function() {
		this.itemsChecked = [];

		this.each( this.order.find( 'input:checked' ) );
		this.request();
	};

	Model.fn.each = function(items) {
		var self = this;

	    items.each(function(index, item) {
	    	self.itemsChecked.push( item.value );
	    });
	};

	Model.fn.request = function() {
		this.elements
			.preview
			.addClass( this.addPrefix( 'preview-container preview-active' ) )
			.append( SPINNER );

		var fixed_layout = $( '.fixed-layout:checked' )
		  , params       = {
				action       : this.addPrefix( 'share_preview', '_' ),
				layout       : this.layout,
			    fixed_layout : fixed_layout.val(),
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

	Model.fn._done = function(response) {
		this.elements.preview.html( this.render( response ) ).append( CLOSE_BTN );
		WPUSB.Preview.create( this.$el, this.elements.preview );
	};

	Model.fn._fail = function(xhr, status, thrownError) {

	};

	Model.fn.render = function(response) {
		return WPUSB.Templates[this.templateName()]
		            .call( null, response );
	};

	Model.fn.templateName = function() {
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