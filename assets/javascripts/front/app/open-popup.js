WPUSB( 'WPUSB.OpenPopup', function(Model, $, utils) {

	Model.create = function(container, context) {
		this.$el = container;

        this.init();
    };

    Model.init = function() {
        this.addEventListener();
	};

	Model.addEventListener = function() {
		this.$el.addEvent( 'click', 'open-popup', this );
	};

	Model._onClickOpenPopup = function(event) {
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

	Model.popupCenter = function(name, url, width, height) {
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


}, {} );