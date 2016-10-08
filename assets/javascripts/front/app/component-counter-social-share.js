WPUSB( 'WPUSB.Components.CounterSocialShare', function(CounterSocialShare, $, utils) {

	CounterSocialShare.fn.start = function() {
		this.prefix           = utils.prefix + '-';
		this.facebook         = this.elements.facebook;
		this.twitter          = this.elements.twitter;
		this.google           = this.elements.googlePlus;
		this.pinterest        = this.elements.pinterest;
		this.linkedin         = this.elements.linkedin;
		this.totalShare       = this.elements.totalShare;
		this.totalCounter     = 0;
		this.facebookCounter  = 0;
		this.twitterCounter   = 0;
		this.googleCounter    = 0;
		this.linkedinCounter  = 0;
		this.pinterestCounter = 0;
		this.max              = 5;

		this.init();
	};

	CounterSocialShare.fn.init = function() {
		WPUSB.FeaturedReferrer.create( this.$el );
		WPUSB.OpenPopup.create( this.$el );
		WPUSB.FixedContext.create( this.$el );

		this.addEventListeners();
		this.request();
	};

	CounterSocialShare.fn.addEventListeners = function() {
		this.$el.addEvent( 'click', 'open-popup', this );
		WPUSB.ToggleButtons.create( this.$el.data( 'element' ), this.$el );
	};

	CounterSocialShare.fn.request = function() {
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
				reference : 'googleCounter',
				element   : 'google',
				url       : utils.getAjaxUrl(),
				data      : this.getParamsGoogle()
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
			}
		];

		this._eachAjaxSocial();
	};

	CounterSocialShare.fn._eachAjaxSocial = function() {
		this.items.forEach( this._iterateItems.bind( this ) );
	};

	CounterSocialShare.fn._iterateItems = function(item, index) {
		var counter = 0;

		if ( this.totalShare ) {
			this.totalShare.text( counter );
		}

		if ( this[item.element] ) {
			this[item.element].text( counter );
		}

		this._getJSON( item );
	};

	CounterSocialShare.fn._getJSON = function(request) {
		var args = $.extend({
				dataType : 'jsonp'
			}, request )
		  , ajax = $.ajax( args )
		;

		ajax.done( $.proxy( this, '_done', request ) );
		ajax.fail( $.proxy( this, '_fail', request ) );
	};

	CounterSocialShare.fn._done = function(request, response) {
		var number              = this.getNumberByData( request.element, response );
		this[request.reference] = number;
		this.max               -= 1;
		this.totalCounter      += number;

		if ( this[request.element] ) {
			this[request.element].text( number );
		}

		if ( !this.max && this.totalShare ) {
			this.totalShare.text( this.totalCounter );
		}
	};

	CounterSocialShare.fn._fail = function(request, throwError, status) {
		this[request.reference] = 0;

		if ( this[request.element] ) {
			this[request.element].text( 0 );
		}
	};

	CounterSocialShare.fn.getNumberByData = function(element, data) {
		var fbShare = this.getTotalShareFacebook( element, data.share )
		  , count   = parseFloat( data['count'] )
		;

		return ( fbShare || count || 0 );
	};

	CounterSocialShare.fn.getTotalShareFacebook = function(element, data) {
		if ( element === 'facebook' && typeof data === 'object' ) {
			return parseFloat( data.share_count );
		}

		return 0;
	};

	CounterSocialShare.fn.getParamsGoogle = function() {
		return {
			action : 'wpusb_gplus_counts',
			url    : decodeURIComponent( this.data.elementUrl ),
		    nonce  : this.data.attrNonceGplus
		};
	};

	CounterSocialShare.fn._onClickOpenPopup = function(event) {
		var params = {
	       	action          : 'wpusb_share_count_reports',
		    reference       : this.data.attrReference,
		    count_facebook  : this.facebookCounter,
		    count_twitter   : this.twitterCounter,
		    count_google    : this.googleCounter,
		    count_linkedin  : this.linkedinCounter,
		    count_pinterest : this.pinterestCounter,
		    nonce           : this.data.attrNonce
	    };

		$.ajax({
	       method : 'POST',
	       url    : utils.getAjaxUrl(),
	       data   : params
	   });
	};

});