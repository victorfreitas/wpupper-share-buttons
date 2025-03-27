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
		this.request();
	};

	Model.fn.addEventListeners = function() {
		WPUSB.ToggleButtons.create( this.$el.data( 'element' ), this );
	};

	Model.fn.request = function() {
		this.setPropNames();
		this.fireRequest();
	};

	Model.fn.setPropNames = function() {
		this.facebook         = this.elements.facebook;
		this.tumblr           = this.elements.tumblr;
		this.pinterest        = this.elements.pinterest;
		this.buffer           = this.elements.buffer;
		this.totalShare       = this.elements.totalShare;
		this.totalCounter     = 0;
		this.pinterestCounter = 0;
		this.bufferCounter    = 0;
		this.max              = 2;
		this.minCount         = utils.getMinCount();
  };

	Model.fn.fireRequest = function() {
		this.items = [
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

	Model.fn._iterateItems = function(item) {
		var counter = 0;

		if ( this.totalShare ) {
			this.totalShare.text( counter );
		}

		if ( this[item.element] ) {
			this[item.element].text( counter );
		}

		this._getJSON( item );
	};

	Model.fn._getJSON = function( request ) {
		var args = $.extend({
				dataType : 'jsonp'
			}, request )
		  , ajax = $.ajax( args )
		;

		ajax.done( $.proxy( this, '_done', request ) );
		ajax.fail( $.proxy( this, '_fail', request ) );
	};

	Model.fn._done = function( request, response ) {
		var classHide = this.addPrefix( 'hide' )
		  , number    = this.getNumberByData( request.element, response )
		;

		this[request.reference] = number;
		this.max               -= 1;
		this.totalCounter      += number;

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

	Model.fn._fail = function( request ) {
		this[request.reference] = 0;

		if ( this[request.element] ) {
			this[request.element].text( 0 );
		}
	};

	Model.fn.getNumberByData = function(element, response) {
		switch ( element ) {
			case 'facebook' :
				return this.getTotalShareFacebook( response.og_object );

			case 'tumblr' :
				return this.getTotalShareTumblr( response.response );

			default :
				return parseInt( response.count || response.shares || 0 );
		}
	};

	Model.fn.getTotalShareFacebook = function(response) {
    try {
      return parseInt( response.engagement.count, 10 );
    } catch (e) {
      return 0;
    }
	};

	Model.fn.getTotalShareTumblr = function(response) {
		if ( typeof response === 'object' ) {
			return parseInt( response.note_count || 0 );
		}

		return 0;
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

	Model.fn.renderExtras = function() {
		this.addEventListeners();

		WPUSB.FeaturedReferrer.create( this.$el );
		WPUSB.OpenPopup.create( this.$el, this );
	};

});
