WPUPPER( 'SB.OpenPopup', function(OpenPopup, $) {

	OpenPopup.create = function(container) {
        this.$el = container;
        this.addEventListener();
	};

	OpenPopup.addEventListener = function() {
		var action = this.$el.byAction( 'open-popup' );
		action.on( 'click', this._onClick.bind( this ) );
	};

	OpenPopup._onClick = function(event) {
		event.preventDefault();

		var target = jQuery( event.currentTarget )
		  , width  = '685'
		  , height = '500'
		;

		this.popupCenter(
			target.attr( 'href' ),
			'Compartilhar',
			width,
			height
		);
	};

	OpenPopup.popupCenter = function(url, title, width, height) {
		var left
		  , top
		;

		width  = ( width  || screen.width );
		height = ( height || screen.height );
		left   = ( screen.width * 0.5 ) - ( width * 0.5 );
		top    = ( screen.height * 0.5 ) - ( height * 0.5 );

		return window.open(
			  url
			, title
			, 'menubar=no,toolbar=no,status=no,width=' + width + ',height=' + height + ',toolbar=no,left=' + left + ',top=' + top
		);
	};
}, {} );