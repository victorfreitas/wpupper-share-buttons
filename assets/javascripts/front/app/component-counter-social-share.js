WPUPPER( 'SB.Components.CounterSocialShare', function(CounterSocialShare, $) {

	CounterSocialShare.fn.start = function(container) {
		this.$el              = container;
		this.prefix           = SB.vars.prefix + '-';
		this.data             = container.data();
		this.facebook         = this.$el.byElement( 'facebook' );
		this.twitter          = this.$el.byElement( 'twitter' );
		this.google           = this.$el.byElement( 'google-plus' );
		this.pinterest        = this.$el.byElement( 'pinterest' );
		this.linkedin         = this.$el.byElement( 'linkedin' );
		this.totalShare       = this.$el.byElement( 'total-share' );
		this.totalCounter     = 0;
		this.facebookCounter  = 0;
		this.twitterCounter   = 0;
		this.googleCounter    = 0;
		this.linkedinCounter  = 0;
		this.pinterestCounter = 0;
		this.max              = 5;
		this.items            = [];
		this.init();
	};

	CounterSocialShare.fn.init = function() {
		SB.FeaturedReferrer.create( this.$el );
		SB.OpenPopup.create( this.$el );
		SB.FixedContext.create( this.$el );
		this.addEventListeners();
		this.request();
	};

	CounterSocialShare.fn.addEventListeners = function() {
		this.$el.addEvent( 'click', 'open-popup', this );
		SB.ToggleButtons.create( this.$el.data( 'element' ), this.$el );
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
				url       : $.fn.getAjaxUrl(),
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
		this.totalShare.text( counter );
		this[item.element].text( counter );

		if ( !this._verifyTimeCache() ) {
			this.setCounterCache( counter, item );
			return;
		}

		this._getJSON( item );
	};

	CounterSocialShare.fn.setCounterCache = function(counter, item) {
		counter = parseFloat( this._getItem( item.element ) );
		this.totalCounter   += counter;
		this[item.reference] = counter;
		this[item.element].text( counter );
		this.totalShare.text( this.totalCounter );
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
		var number              = this.getNumberByData( response );
		this[request.reference] = number;
		this.max               -= 1;
		this.totalCounter      += parseFloat( number );
		this[request.element].text( number );
		this._setItem( request.element, number );

		if ( !this.max ) {
			this._setItem( 'cache', this._timerCache( 900 ) );
			this.totalShare.text( this.totalCounter );
		}
	};

	CounterSocialShare.fn._fail = function(request, throwError, status) {
		this[request.reference] = 0;
		this[request.element].text( 0 );
	};

	CounterSocialShare.fn.getNumberByData = function(data) {
		var fbTotal = parseFloat( data['shares'] ) + parseFloat( data['comments'] )
		  , fbShare = parseFloat( data['shares'] )
		  , count   = parseFloat( data['count'] )
		;

		return ( fbTotal || fbShare || count || 0 );
	};

	CounterSocialShare.fn.getParamsGoogle = function() {
		return {
			action : 'share_google_plus',
			url    : this.data.elementUrl
		};
	};

	CounterSocialShare.fn._onClickOpenPopup = function(event) {
		this.items.forEach( this.clearStorage.bind( this ) );
		var params = {
	       	action          : 'counts_social_share',
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
	       url    : $.fn.getAjaxUrl(),
	       data   : params
	   });
	};

	CounterSocialShare.fn.clearStorage = function(item, index, array) {
		this._removeItem( item.element );

		if ( ( index + 1 ) == array.length ) {
			this._removeItem( 'cache' );
		}
	};

	CounterSocialShare.fn._removeItem = function(element) {
		localStorage.removeItem( $.fn.hashStr( this.data.elementUrl + element ) );
	};

	CounterSocialShare.fn._getItem = function(element) {
		var storage = localStorage.getItem( $.fn.hashStr( this.data.elementUrl + element ) );

		return ( null === storage ) ? 0 : storage;
	};

	CounterSocialShare.fn._setItem = function(element, value) {
		localStorage.setItem( $.fn.hashStr( this.data.elementUrl + element ), value );
	};

	CounterSocialShare.fn._timerCache = function(time) {
		return $.fn.getTime() + 1000 * time;
	};

	CounterSocialShare.fn._verifyTimeCache = function() {
		return ( this._getItem( 'cache' ) < $.fn.getTime() );
	};

});