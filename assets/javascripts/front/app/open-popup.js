WPUSB( 'WPUSB.OpenPopup', function(OpenPopup, $) {

	OpenPopup.create = function(container) {
		this.$el = container;
        this.init();
    };

    OpenPopup.init = function() {
    	if ( this.isMobile() ) {
    		this.mobileUrl();
    		return;
    	}

        this.addEventListener();
	};

	OpenPopup.addEventListener = function() {
		this.$el.addEvent( 'click', 'open-popup', this );
	};

	OpenPopup._onClickOpenPopup = function(event) {
		event.preventDefault();

		var target = jQuery( event.currentTarget )
		  , width  = '685'
		  , height = '500'
		;

		this.popupCenter(
			target.attr( 'href' ),
			'Share',
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

	OpenPopup.isMobile = function() {
		if ( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test( navigator.userAgent ) ) {
			return true;
		}

		return false;
	};

	OpenPopup.mobileUrl = function() {
		var messenger = this.$el.find( '[data-messenger-mobile]' );
		messenger.attr( 'href', messenger.data( 'messenger-mobile' ) );
	};

}, {} );