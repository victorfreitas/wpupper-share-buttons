WPUSB( 'WPUSB.Components.CounterSocialShare', function(Model, $, utils) {

	Model.fn.start = function() {
		if ( this.isShareCountsDisabled() ) {
			this.renderExtras();
			return;
		}

		this.init();
	};

	Model.fn.init = function() {
		this.renderExtras();
		this.request( false );
	};

	Model.fn.addEventListeners = function() {
		this.$el.addEvent( 'click', 'open-popup', this );
		WPUSB.ToggleButtons.create( this.$el.data( 'element' ), this );
	};

	Model.fn.request = function(isReport) {
		this.setPropNames( isReport );
		this.fireRequest();
	};

	Model.fn.setPropNames = function(isReport) {
		this.facebook         = this.elements.facebook;
		this.twitter          = this.elements.twitter;
		this.tumblr           = this.elements.tumblr;
		this.google           = this.elements.googlePlus;
		this.linkedin         = this.elements.linkedin;
		this.pinterest        = this.elements.pinterest;
		this.buffer           = this.elements.buffer;
		this.totalShare       = this.elements.totalShare;
		this.totalCounter     = 0;
		this.facebookCounter  = 0;
		this.twitterCounter   = 0;
		this.tumblrCounter    = 0;
		this.googleCounter    = 0;
		this.linkedinCounter  = 0;
		this.pinterestCounter = 0;
		this.bufferCounter    = 0;
		this.max              = 7;
		this.isReport         = isReport;
		this.minCount         = utils.getMinCount();
	};

	Model.fn.fireRequest = function() {
		this.items = [
			{
				reference : 'facebookCounter',
				element   : 'facebook',
				url       : 'https://graph.facebook.com/?id=' + this.data.elementUrl
			},
			{
				reference : 'twitterCounter',
				element   : 'twitter',
				url       : 'https://public.newsharecounts.com/count.json?url=' + this.data.elementUrl
			},
			{
				reference : 'tumblrCounter',
				element   : 'tumblr',
				url       : 'https://api.tumblr.com/v2/share/stats?url=' + this.data.elementUrl
			},
			{
				reference   : 'googleCounter',
				element     : 'google',
				url         : 'https://clients6.google.com/rpc',
				data        : this.getParamsGoogle(),
				method      : 'POST',
				dataType    : 'json',
				processData : true,
				contentType : 'application/json'
			},
			{
				reference : 'linkedinCounter',
				element   : 'linkedin',
				url       : 'https://www.linkedin.com/countserv/count/share?url=' + this.data.elementUrl
			},
			{
				reference : 'pinterestCounter',
				element   : 'pinterest',
				url       : 'https://api.pinterest.com/v1/urls/count.json?url=' + this.data.elementUrl
			},
			{
				reference : 'bufferCounter',
				element   : 'buffer',
				url       : 'https://api.bufferapp.com/1/links/shares.json?url=' + this.data.elementUrl
			}
		];

		this._eachAjaxSocial();
	};

	Model.fn._eachAjaxSocial = function() {
		this.items.forEach( this._iterateItems.bind( this ) );
	};

	Model.fn._iterateItems = function(item, index) {
		var counter = 0;

		if ( this.totalShare ) {
			this.totalShare.text( counter );
		}

		if ( this[item.element] ) {
			this[item.element].text( counter );
		}

		this._getJSON( item );
	};

	Model.fn._getJSON = function(request) {
		var args = $.extend({
				dataType : 'jsonp'
			}, request )
		  , ajax = $.ajax( args )
		;

		ajax.done( $.proxy( this, '_done', request ) );
		ajax.fail( $.proxy( this, '_fail', request ) );
	};

	Model.fn._done = function(request, response) {
		var classHide = this.addPrefix( 'hide' )
		  , number    = this.getNumberByData( request.element, response )
		;

		this[request.reference] = number;
		this.max               -= 1;
		this.totalCounter      += number;

		if ( !this.max && this.isReport ) {
			this.addReport();
			return;
		}

		if ( this[request.element] ) {
			this[request.element].text( this.formatCounts( number ) );

			if ( number >= this.minCount ) {
				this[request.element].removeClass( classHide );
			}
		}

		if ( !this.max && this.totalShare ) {
			this.totalShare.text( this.formatCounts( this.totalCounter ) );

			if ( this.totalCounter >= this.minCount ) {
				this.totalShare.closest( '.' + this.addPrefix( 'item' ) ).removeClass( classHide );
			}
		}
	};

	Model.fn._fail = function(request, throwError, status) {
		this[request.reference] = 0;

		if ( this[request.element] ) {
			this[request.element].text( 0 );
		}
	};

	Model.fn.getNumberByData = function(element, response) {
		switch ( element ) {
			case 'facebook' :
				return this.getTotalShareFacebook( response.share );

			case 'tumblr' :
				return this.getTotalShareTumblr( response.response );

			case 'google' :
				return this.getTotalShareGooglePlus( response );

			default :
				return parseInt( response.count || response.shares || 0 );
		}
	};

	Model.fn.getTotalShareGooglePlus = function(response) {
		var data = {};

		if ( typeof response.error === 'object' ) {
			console.log( 'Google+ count error: ' + response.error.message );
			return 0;
		}

		if ( typeof response.result === 'object' ) {
			data.metadata     = ( response.result.metadata || {} );
			data.globalCounts = ( data.metadata.globalCounts || {} );

			return parseInt( data.globalCounts.count || 0 );
		}

		console.log( 'Google+ count fail' );

		return 0;
	};

	Model.fn.getTotalShareFacebook = function(response) {
		if ( typeof response === 'object' ) {
			return parseInt( response.share_count || 0 );
		}

		return 0;
	};

	Model.fn.getTotalShareTumblr = function(response) {
		if ( typeof response === 'object' ) {
			return parseInt( response.note_count || 0 );
		}

		return 0;
	};

	Model.fn.getParamsGoogle = function() {
		return JSON.stringify({
			id         : utils.decodeUrl( this.data.elementUrl ),
			key        : 'p',
			method     : 'pos.plusones.get',
			jsonrpc    : '2.0',
			apiVersion : 'v1',
			params     : {
				nolog   : true,
				id      : utils.decodeUrl( this.data.elementUrl ),
				source  : 'widget',
				userId  : '@viewer',
				groupId : '@self'
			}
		});
	};

	Model.fn._onClickOpenPopup = function(event) {
		if ( utils.hasExpiredCache() && this.isShareCountsDisabled() && !this.notReport() ) {
			this.request( true );
			return;
		}

		this.addReport();
	};

	Model.fn.addReport = function() {
		if ( !utils.hasExpiredCache() || !this.totalCounter || this.notReport() ) {
			return;
		}

		var params = {
	       	action          : this.addPrefix( 'share_count_reports', '_' ),
		    reference       : this.data.attrReference,
		    count_facebook  : this.facebookCounter,
		    count_twitter   : this.twitterCounter,
		    count_tumblr    : this.tumblrCounter,
		    count_linkedin  : this.linkedinCounter,
		    count_google    : this.googleCounter,
		    count_pinterest : this.pinterestCounter,
		    count_buffer    : this.bufferCounter,
		    nonce           : this.data.attrNonce
	    };

		$.ajax({
		   method : 'POST',
		   url    : utils.getAjaxUrl(),
		   data   : params
		});

		utils.setCacheTime();
	};

	Model.fn.formatCounts = function(counts) {
		this.c = counts.toString();

		switch ( Math.pow( 10, this.c.length - 1 ) ) {
			case 100000000 :
				return this.t(3) + this.i(3, 4) + 'M';

			case 10000000 :
				return this.t(2) + this.i(2, 3) + 'M';

			case 1000000 :
				return this.t(1) + this.i(1, 2) + 'M';

			case 100000 :
				return this.t(3) + this.i(4, 3) + 'K';

			case 10000 :
				return this.t(2) + this.i(2, 3) + 'K';

			case 1000 :
				return this.t(1) + this.i(1, 2) + 'K';

			default :
				return counts;
		}
	};

	Model.fn.t = function(d) {
		return this.c.substring( 0, d );
	};

	Model.fn.i = function(d, c) {
		var i = this.c.substring( d, c );
		return ( i && i !== '0' ) ? '.' + i : '';
	};

	Model.fn.isShareCountsDisabled = function() {
		return ( this.data.disabledShareCounts === 1 );
	};

	Model.fn.notReport = function() {
		return ( this.data.report === 'no' || this.data.isTerm );
	};

	Model.fn.renderExtras = function() {
		this.addEventListeners();

		WPUSB.FeaturedReferrer.create( this.$el );
		WPUSB.OpenPopup.create( this.$el, this );
	};

});