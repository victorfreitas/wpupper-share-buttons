;(function(context, $) {

    'use strict';

    var WPUSB = function(namespace, callback) {
        var parts  = namespace.split( '\.' )
          , loader = WPUSB.instantiate()
          , parent = context
          , count  = parts.length
          , index  = 0
        ;
        for ( index; index < count; index++ ) {
            parent[parts[index]] = ( count - 1 === index ) ? loader : parent[parts[index]] || {};
            parent               = parent[parts[index]];
        }

        if ( 'function' === typeof callback ) {
            callback.call( null, parent, $, WPUSB.utils );
        }

        return parent;
    };

    WPUSB.instantiate = function() {
        var Instantiate = function() {}
          , Constructor = function(context) {
                var instance, elements;

                instance          = new Instantiate();
                instance.$el      = context;
                instance.data     = context.data();
                instance.elements = {};
                elements          = context.find( '[data-element]' );

                elements.each(function(index, element) {
                    instance.elements[WPUSB.utils.ucfirst( element.dataset.element )] = $( element );
                });

                instance.start.apply( instance, arguments );

                return instance;
            }
        ;

        Constructor.fn        = Constructor.prototype;
        Instantiate.prototype = Constructor.fn;
        Constructor.fn.start  = function() {};

        return Constructor;
    };

    WPUSB.utils = {

        prefix: 'wpusb',

        ucfirst: function(text) {
            text = text.replace( /(?:-)\w/g, function(match) {
              return match.toUpperCase();
            });

            return text.replace( /-/g, '' );
        },

        getAjaxUrl: function() {
            return ( window.WPUSBVars || {} ).ajaxUrl;
        },

        getContext: function() {
            return ( window.WPUSBVars || {} ).context;
        },

        getLocale: function() {
            return ( window.WPUSBVars || {} ).WPLANG;
        },

        getPreviewTitles: function() {
            return ( window.WPUSBVars || {} ).previewTitles;
        },

        getPathUrl: function(url) {
            var uri = decodeURIComponent( url );
            return uri.split(/[?#]/)[0];
        },

        getTime: function() {
            return ( new Date() ).getTime();
        },

        hashStr: function(str) {
            var hash = 0
              , i    = 0
              , char
            ;

            if ( !str.length ) {
                return hash;
            }

            for ( i; i < str.length; i++ ) {
                char = str.charCodeAt( i );
                hash = ( ( hash << 10 ) - hash ) + char;
                hash = hash & hash;
            }

            return Math.abs( hash );
        }
    };

    context.WPUSB = WPUSB;

})( window, jQuery );;WPUSB( 'WPUSB.BuildComponents', function(BuildComponents, $, utils) {

	BuildComponents.create = function(container) {
		var components = '[data-' + utils.prefix + '-component]';
		container.findComponent( components, $.proxy( this, '_start' ) );
	};

	BuildComponents._start = function(elements) {
		if ( typeof WPUSB.Components == 'undefined' ) {
			return;
		}

		this._iterator( elements );
	};

	BuildComponents._iterator = function(elements) {
		var name;

		elements.each( function(index, element) {
			element = $( element );
			name    = elements.ucfirst( this.getComponent( element ) );
			this._callback( name, element );
		}.bind( this ) );
	};

	BuildComponents.getComponent = function(element) {
		var component = element.data( utils.prefix + '-component' );

		if ( !component ) {
			return '';
		}

		return component;
	};

	BuildComponents._callback = function(name, element) {
		var callback = WPUSB.Components[name];

		if ( typeof callback == 'function' ) {
			callback.call( null, element );
			return;
		}

		console.warn( 'Component "' + name + '" is not a function.' );
	};

}, {} );;;(function($) {

	$.fn.byElement = function(name) {
		return this.find( '[data-element="' + name + '"]' );
	};

	$.fn.byAction = function(name) {
		return this.find( '[data-action="' + name + '"]' );
	};

	$.fn.byReferrer = function(name) {
		return this.find( '[data-referrer="' + name + '"]' );
	};

	$.fn.byComponent = function(name, prefix) {
		return this.find( '[data-' + prefix + '-component="' + name + '"]' );
	};

	$.fn.findComponent = function(selector, callback) {
		var elements = $(this).find( selector );

		if ( elements.length && typeof callback == 'function' ) {
			callback.call( null, elements, $(this) );
		}

		return elements.length;
	};

	$.fn.ucfirst = function(text) {
	    text = text.replace(/(?:^|-)\w/g, function(match) {
	        return match.toUpperCase();
	    });

	    return text.replace(/-/g, '');
    };

	$.fn.addEvent = function(event, action, context) {
        var handle = $.fn.ucfirst( [ '_on', event, action ].join( '-' ) );

        this.byAction( action )
        	.on( event, $.proxy( context, handle ) );
	};;

})( jQuery );;WPUSB( 'WPUSB.Application', function(Application, $) {

	Application.init = function(container) {
		WPUSB.BuildComponents.create( container );
		WPUSB.FixedTop.create( container );
	};

});;WPUSB( 'WPUSB.Components.CounterSocialShare', function(CounterSocialShare, $, utils) {

	CounterSocialShare.fn.start = function() {
		this.prefix           = utils.prefix + '-';
		this.facebook         = this.elements.facebook;
		this.twitter          = this.elements.twitter;
		this.google           = this.elements.googlePlus;
		this.pinterest        = this.elements.pinterest;
		this.linkedin         = this.elements.linkedin;
		this.tumblr           = this.elements.tumblr;
		this.totalShare       = this.elements.totalShare;
		this.totalCounter     = 0;
		this.facebookCounter  = 0;
		this.twitterCounter   = 0;
		this.googleCounter    = 0;
		this.linkedinCounter  = 0;
		this.pinterestCounter = 0;
		this.tumblrCounter    = 0;
		this.max              = 6;

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
				reference : 'tumblrCounter',
				element   : 'tumblr',
				url       : 'https://api.tumblr.com/v2/share/stats?url=' + this.data.elementUrl
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
			this[request.element].text( this.formatCounts( number ) );
		}

		if ( !this.max && this.totalShare ) {
			this.totalShare.text( this.formatCounts( this.totalCounter ) );
		}
	};

	CounterSocialShare.fn._fail = function(request, throwError, status) {
		this[request.reference] = 0;

		if ( this[request.element] ) {
			this[request.element].text( 0 );
		}
	};

	CounterSocialShare.fn.getNumberByData = function(element, data) {
		if ( element === 'facebook' ) {
			return this.getTotalShareFacebook( data.share );
		}

		if ( element === 'tumblr' ) {
			return this.getTotalShareTumblr( data.response );
		}

		return ( parseFloat( data.count ) || 0 );
	};

	CounterSocialShare.fn.getTotalShareFacebook = function(data) {
		if ( typeof data === 'object' ) {
			return parseFloat( data.share_count );
		}

		return 0;
	};

	CounterSocialShare.fn.getTotalShareTumblr = function(data) {
		if ( typeof data === 'object' ) {
			return parseFloat( data.note_count );
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
		    count_tumblr    : this.tumblrCounter,
		    nonce           : this.data.attrNonce
	    };

		$.ajax({
	       method : 'POST',
	       url    : utils.getAjaxUrl(),
	       data   : params
	   });
	};

	CounterSocialShare.fn.formatCounts = function(counts) {
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

	CounterSocialShare.fn.t = function(d) {
		return this.c.substring( 0, d );
	};

	CounterSocialShare.fn.i = function(d, c) {
		var i = this.c.substring( d, c );
		return ( i && i !== '0' ) ? '.' + i : '';
	};

});;WPUSB( 'WPUSB.Components.SocialModal', function(SocialModal, $, utils) {

	var href = [];

	SocialModal.fn.start = function() {
		this.prefix = '.' + utils.prefix;
		this.body   = WPUSB.vars.body;
		this.modal  = this.body.find( this.prefix + '-modal-networks' );
		this.close  = this.modal.find( this.prefix + '-btn-close' );

		this.init();
	};

	SocialModal.fn.init = function() {
		WPUSB.OpenPopup.create( this.modal );

		this.modal.show();
		this.addEventListener();
		this.setSizes();
		this.setPosition();
		this.modal.hide();
	};

	SocialModal.fn.addEventListener = function() {
		this.$el.addEvent( 'click', 'close-popup', this );
		this.$el.on( 'click', this._onClickMask.bind( this ) );
		this.body.addEvent( 'click', 'open-modal-networks', this );
	};

	SocialModal.fn._onClickClosePopup = function(event) {
		event.preventDefault();
		this.closeModal();
	};

	SocialModal.fn._onClickMask = function(event) {
		event.preventDefault();
		this.closeModal();
	};

	SocialModal.fn._onClickOpenModalNetworks = function(event) {
		event.preventDefault();
		this.renderLinksUrl( event );
		this.openModal();
	};

	SocialModal.fn.renderLinksUrl = function(event) {
		if ( !this.body.hasClass( 'home' ) ) {
			return;
		}

		var component = $( event.currentTarget ).closest( this.prefix )
		  , data      = component.data()
		  , buttons   = this.modal.find( this.prefix + '-button-popup' )
		;

		buttons.each(function(index, element) {
			if ( !href[index] ) {
				href[index] = this.href;
			}

			this.href = this.href.replace( /_permalink_/g, data.elementUrl ).replace( /_title_/g, data.elementTitle );
		});
	};

	SocialModal.fn.setSizes = function() {
		this.setTop();
		this.setLeft();
	};

	SocialModal.fn.closeModal = function() {
		this.$el.css( 'opacity', 0 );
		this.$el.hide();
		this.modal.hide();

		if ( !this.body.hasClass( 'home' ) ) {
			return;
		}

		var buttons = this.modal.find( this.prefix + '-button-popup' );

		buttons.each(function(index, element) {
			this.href = href[index];
		});

	};

	SocialModal.fn.openModal = function() {
		this.$el.css( 'opacity', 1 );
		this.$el.show();
		this.modal.show();
	};

	SocialModal.fn.setTop = function() {
		var height   = ( window.innerHeight * 0.5 )
		  ,	elHeight = ( this.modal.height() * 0.5 )
		  , position = ( height - elHeight )
		;

		this.btnTop = ( position - 20 ) + 'px';
		this.top    = position + 'px';
	};

	SocialModal.fn.setLeft = function() {
		var width    = ( window.innerWidth * 0.5 )
		  ,	elWidth  = ( this.modal.width() * 0.5 )
		  , position = ( width - elWidth )
		;

		this.btnRight = ( position - 40 ) + 'px';
		this.left     =  position + 'px';
	};

	SocialModal.fn.setPosition = function() {
		this.modal.css({
			top  : this.top,
			left : this.left
		});
		this.close.css({
			top   : this.btnTop,
			right : this.btnRight
		});
	};

});;WPUSB( 'WPUSB.FeaturedReferrer', function(FeaturedReferrer, $, utils) {

	FeaturedReferrer.create = function(container) {
		this.prefix = WPUSB.vars.prefix + '-';
		this.$el    = container;
		this.init();
	};

	FeaturedReferrer.init = function() {
		if ( this.$el.attr('class').match( '-fixed' ) ) {
			return;
		}

		this.setReferrer();
	};

	FeaturedReferrer.setReferrer = function() {
		if ( this.isMatch( 'twitter' ) || this.isMatch( 't' ) ) {
			this.showReferrer( 'twitter' );
			return;
		}

		if ( this.isMatch( 'google' ) ) {
			this.showReferrer( 'google-plus' );
			return;
		}

		if ( this.isMatch( 'facebook' ) ) {
			this.showReferrer( 'facebook' );
			return;
		}

		if ( this.isMatch( 'linkedin' ) ) {
			this.showReferrer( 'linkedin' );
		}
	};

	FeaturedReferrer.showReferrer = function(referrer) {
		var className = this.prefix + 'referrer'
		  , element   = this.$el.byReferrer( referrer );

		this.$el.find( '.' + this.prefix + 'count' ).hide();
		element.addClass( className );
		element.addClass( className + '-' + referrer );

		this.refTitle( element );
	};

	FeaturedReferrer.refTitle = function(element) {
		if ( !element.find( 'span[data-title]' ).length ) {
			var title = '<span data-title="' + element.data( 'ref-title' ) + '"></span>';
			element.find( 'a' ).append( title );
		}
	};

	FeaturedReferrer.isMatch = function(name) {
		var ref     = document.referrer
		  , pattern = new RegExp( '^https?:\/\/([^\/]+\\.)?' + name + '\\.com?(\/|$)', 'i' )
		;

		return ref.match( pattern );
	};

}, {} );;WPUSB( 'WPUSB.FixedContext', function(FixedContext, $, utils) {

	FixedContext.create = function(container) {
		this.$el = container;

		if ( ! this.isLayoutFixed() || ! this.issetContext() ) {
			return;
		}

        this.init();
	};

	FixedContext.isLayoutFixed = function() {
		return this.$el.attr('class').match( '-fixed-' );
	};

	FixedContext.issetContext = function() {
		this.id = utils.getContext();
		return this.getContext( true );
	};

	FixedContext.init = function() {
		this.setContext();
		this.alignButtons();
	};

	FixedContext.setContext = function() {
		this.context = this.getContext();
		this.setRect();
	};

	FixedContext.setRect = function() {
		this.rect = this.context.getBoundingClientRect();
		this.top  = this.rect.top;

		this.setLeft( this.rect.left );
	};

	FixedContext.setLeft = function(left) {
		this.left = ( left - this.$el.width() );
	};

	FixedContext.alignButtons = function() {
		this.$el.byAction( 'close-buttons' ).remove();
		this.changeClass();
		this.$el.css({
			left : this.left
		});

		this.setLeftMobile();
	};

	FixedContext.setLeftMobile = function() {
		if ( window.innerWidth > 769 ) {
			return;
		}

		this.$el.css({
			left : 'initial'
		});
	};

	FixedContext.changeClass = function() {
		var prefix  = WPUSB.vars.prefix
		  , classes = this.$el.attr('class');

		if ( classes.match( '-fixed-left' ) ) {
			return;
		}

		this.$el.removeClass( prefix + '-fixed-right' );
		this.$el.addClass( prefix + '-fixed-left' );
	};

	FixedContext.getContext = function(verify) {
		var id = this.id.replace( /[^A-Z0-9a-z-_]/g, '' )
		  , el = document.getElementById( id );

		( verify ) ? this.sendNotice( id, el ) : '';

		return el;
	};

	FixedContext.sendNotice = function(id, el) {
		if ( id && ! el ) {
			console.warn( 'WPUSB: Context not found.' );
		}
	};

}, {} );;WPUSB( 'WPUSB.FixedTop', function(FixedTop, $) {

	FixedTop.create = function(container) {
		this.class = WPUSB.vars.prefix + '-fixed-top';
		this.$el   = container.byElement( this.class );

		if ( !this.$el.length ) {
			return;
		}

		this.$el = $( this.$el.get(0) );
        this.init();
	};

	FixedTop.init = function() {
		this.scroll = this.$el.get(0).getBoundingClientRect();

		if ( this.isInvalidScroll() ) {
			this.scroll.static = 300;
		}

		this.context = window;
		this.addEventListener();
	};

	FixedTop.addEventListener = function() {
		$(this.context).scroll( this._setPositionFixed.bind( this ) );
	};

	FixedTop._setPositionFixed = function() {
		var scroll = ( this.scroll.static || this.scroll.top );

		if ( $(this.context).scrollTop() > scroll ) {
			this.$el.addClass( this.class );
			return;
		}

		this.$el.removeClass( this.class );
	};

	FixedTop.isInvalidScroll = function() {
		return 1 > this.scroll.top;
	};

}, {} );;WPUSB( 'WPUSB.OpenPopup', function(OpenPopup, $) {

	OpenPopup.create = function(container) {
        this.$el = container;
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
}, {} );;WPUSB( 'WPUSB.ShortUrl', function(ShortUrl, $) {

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

}, {} );;WPUSB( 'WPUSB.ToggleButtons', function(ToggleButtons, $) {

	ToggleButtons.create = function(context, container) {
		if ( context !== 'fixed' ) {
			return;
		}

		this.$el          = container;
		this.prefix       = WPUSB.vars.prefix + '-';
		this.closeButtons = WPUSB.vars.body.byAction( 'close-buttons' );
		this.buttons      = container.byElement( 'buttons' );
		this.init();
	};

	ToggleButtons.init = function() {
		this.addEventListener();
	};

	ToggleButtons.addEventListener = function() {
		this.closeButtons.on( 'click', this._onCloseButtons.bind( this ) );
	};

	ToggleButtons._onCloseButtons = function(event) {
		event.preventDefault();

		var iconRight = this.prefix + 'icon-right'
		  , active    = this.prefix + 'toggle-active';

		this.buttons.toggleClass( this.prefix + 'buttons' );
		this.closeButtons.toggleClass( iconRight + ' ' + active );
	};

});;jQuery(function($) {
	var context = $( 'body' );

	WPUSB.vars = {
		  body   : context
		, prefix : 'wpusb'
	};

	WPUSB.Application.init.apply( null, [context] );
});