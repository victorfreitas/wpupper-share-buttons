WPUSB( 'WPUSB.Components.ExtraSettings', function(Model, $, utils) {

	Model.fn.start = function() {
		this.validToken = false;
		this.init();
	};

	Model.fn.init = function() {
		this.addEventListener();
	};

	Model.fn.addEventListener = function() {
		this.$el.addEvent( 'submit', 'form', this );
	};

	Model.fn._onSubmitForm = function(event) {
		var token = this.elements.bitlyToken;

		if ( token.isEmptyValue() || this.validToken ) {
			return true;
		}

		this.preload();
		this.request( token.val() );

		return false;
	};

	Model.fn.request = function(token) {
		var params = {
			long_url : this.getHomeUrl()
		};

		var ajax = $.ajax({
			url         : 'https://api-ssl.bitly.com/v4/shorten',
      type        : 'POST',
			data        : JSON.stringify( params ),
      contentType : 'application/json',
			dataType    : 'json',
      headers     : {
        'Authorization': 'Bearer '.concat( token ),
      }
		});

		ajax.then(
			$.proxy( this, '_done' ),
			$.proxy( this, '_fail' )
		);
	};

	Model.fn._done = function(response, textStatus) {
		this.clear();

		if ( ! ( textStatus === 'success' && response && response.link ) ) {
			this.elements.bitlyMessage.text( 'Invalid Bitly token.' ).slideDown(200);
			return;
		}

		this.validToken = true;
		this.$el.find( '#submit' ).click();
	};

	Model.fn._fail = function(xhr, status, thrownError) {
		this.clear();
	};

	Model.fn.preload = function() {
		this.$el.find( '#submit' ).prop( 'disabled', true );
		this.elements.bitlyMessage.text('').slideUp(200);
	};

	Model.fn.clear = function() {
		this.$el.find( '#submit' ).prop( 'disabled', false );
	};

	Model.fn.getHomeUrl = function() {
		var homeUrl = utils.getGlobalVars( 'homeUrl' );
		return encodeURI( homeUrl );
	};

});
