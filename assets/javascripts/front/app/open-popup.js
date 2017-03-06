WPUSB( 'WPUSB.OpenPopup', function(OpenPopup, $, utils) {

	OpenPopup.create = function(container) {
		this.$el = container;
        this.init();
    };

    OpenPopup.init = function() {
    	if ( utils.isMobile() ) {
    		this.setMessengerUrl();
    	}

        this.addEventListener();
	};

	OpenPopup.addEventListener = function() {
		this.$el.addEvent( 'click', 'open-popup', this );
	};

	OpenPopup._onClickOpenPopup = function(event) {
		var target = $( event.currentTarget )
		  , width  = '685'
		  , height = '500'
		;

		this.popupCenter(
			target.attr( 'target' ),
			target.attr( 'href' ),
			width,
			height
		);

		event.preventDefault();
	};

	OpenPopup.popupCenter = function(name, url, width, height) {
		var left
		  , top
		;

		width  = ( width  || screen.width );
		height = ( height || screen.height );
		left   = ( screen.width * 0.5 ) - ( width * 0.5 );
		top    = ( screen.height * 0.5 ) - ( height * 0.5 );

		return window.open(
			  url
			, name
			, 'menubar=no,toolbar=no,status=no,width=' + width + ',height=' + height + ',toolbar=no,left=' + left + ',top=' + top
		);
	};

	OpenPopup.setMessengerUrl = function() {
		var messenger = this.$el.find( '[data-messenger-mobile]' );

		if ( !messenger.length ) {
			return;
		}

		messenger.attr( 'href', messenger.data( 'messenger-mobile' ) );
	};

}, {} );