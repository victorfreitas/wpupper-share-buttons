WPUPPER( 'SB.ShortUrl', function(ShortUrl, $) {

	ShortUrl.create = function(container) {
		this.$el        = container;
		this.data       = this.$el.data();
		this.shareUrls  = this.$el.find( 'a[href]' );
		this.checkToken();
	};

	ShortUrl.checkToken = function() {
		if ( !this.data.token.trim() ) {
			return;
		}

		this.request();
	};

	ShortUrl.request = function() {
		var done   = $.proxy( this, '_done' )
		  , fail   = $.proxy( this, '_fail' )
		  , params = {
			access_token : this.data.token,
			longUrl      : this.longUrl()
		};

		var ajax = $.ajax({
			url      : 'https://api-ssl.bitly.com/v3/shorten',
			data     : params,
			dataType : 'jsonp'
		});

		ajax.then( done, fail );
	};

	ShortUrl.longUrl = function() {
		return this.data.elementUrl + this.data.tracking;
	};

	ShortUrl._done = function(response) {
		if ( 500 === response.status_code ) {
			console.warn( 'Bitly: ' + response.status_txt );
			return;
		}

		this.shareUrls.each( $.proxy( this, '_each', response ) );
	};

	ShortUrl._fail = function(throwError, status) {
		console.warn(throwError);
	};

	ShortUrl._each = function(response, index, value) {
		var element    = $( value )
		  , elementUrl = element.attr( 'href' )
		  , urlShort   = this.replaceUrl( response, elementUrl )
		;

		element.attr( 'href', urlShort );
	};

	ShortUrl.replaceUrl = function(response, url) {
		var urlEncode = encodeURIComponent( response.data.url )
		  , newUri    = url.replace( /\[.*\]/, urlEncode )
		;

		return newUri;
	};

}, {} );