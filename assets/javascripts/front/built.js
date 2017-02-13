;(function(context, $) {

    'use strict';

    var WPUSB = function(namespace, callback) {
        var parts  = namespace.split( '\.' )
          , loader = WPUSB.Core()
          , parent = context
          , count  = parts.length
          , index  = 0
        ;

        for ( index; index < count; index++ ) {
            parent[parts[index]] = ( count - 1 === index ) ? loader : parent[parts[index]] || {};
            parent               = parent[parts[index]];
        }

        if ( 'function' === typeof callback ) {
            parent.utils = WPUSB.utils;
            callback.call( null, parent, $ );
        }

        return parent;
    };

    WPUSB.Core = function() {
        var self        = this
          , Core        = function() {}
          , Constructor = function(context) {
                var instance;

                instance          = new Core();
                instance.$el      = context;
                instance.data     = context.data();
                instance.utils    = self.utils;
                instance.elements = self.getDataByName( context, 'element' );

                instance.start.apply( instance, arguments );

                return instance;
            }
        ;

        Constructor.fn       = Constructor.prototype;
        Core.prototype       = Constructor.fn;
        Constructor.fn.start = function() {};

        return Constructor;
    };

    WPUSB.getDataByName = function(context, name) {
        var items = {}
          , self  = this
        ;

        context.find( '[data-' + name + ']' ).each(function(index, element) {
            var itemName = self.utils.toDataSetName( element.dataset[name] )
              , method   = 'by' + self.utils.ucfirst( name )
            ;

            if ( items[itemName] ) {
                return;
            }

            items[itemName] = context[method]( element.dataset[name] );
        });

        return items;
    };

    WPUSB.utils = {

        prefix: 'wpusb',

        getGlobalVars: function(name) {
            return ( window.WPUSBVars || {} )[name];
        },

        getAjaxUrl: function() {
            return this.getGlobalVars( 'ajaxUrl' );
        },

        getContext: function() {
            return this.getGlobalVars( 'context' );
        },

        getLocale: function() {
            return this.getGlobalVars( 'WPLANG' );
        },

        getPreviewTitles: function() {
            return this.getGlobalVars( 'previewTitles' );
        },

        getPathUrl: function(url) {
            return decodeURIComponent( url ).split(/[?#]/)[0];
        },

        getTime: function() {
            return ( new Date() ).getTime();
        },

        decodeUrl: function(url) {
            return decodeURIComponent( url );
        },

        ucfirst: function(text) {
            return this.parseName( text, /(\b[a-z])/g );
        },

        toDataSetName: function(text) {
            return this.parseName( text, /(-)\w/g );
        },

        isMobile: function() {
            return ( /Android|webOS|iPhone|iPad|iPod|BlackBerry|Tablet OS|IEMobile|Opera Mini/i.test(
                navigator.userAgent
            ) );
        },

        parseName: function(text, regex) {
            return text.replace( regex, function(match) {
                return match.toUpperCase();
            }).replace( /-/g, '' );
        },

        remove: function(element) {
            element.fadeOut( 'fast', function() {
                element.remove();
            });
        },

        hashStr: function(str) {
            var hash   = 0
              , i      = 0
              , length = str.length
              , char
            ;

            if ( !length ) {
                return hash;
            }

            for ( i; i < length; i++ ) {
                char = str.charCodeAt( i );
                hash = ( ( hash << 10 ) - hash ) + char;
                hash = hash & hash;
            }

            return Math.abs( hash );
        }
    };

    context.WPUSB = WPUSB;

})( window, jQuery );;WPUSB( 'WPUSB.BuildComponents', function(Model, $) {

	Model.create = function(container) {
		var components = '[data-' + Model.utils.prefix + '-component]';
		container.findComponent( components, $.proxy( this, '_start' ) );
	};

	Model._start = function(elements) {
		if ( typeof WPUSB.Components == 'undefined' ) {
			return;
		}

		this._iterator( elements );
	};

	Model._iterator = function(elements) {
		var name;

		elements.each( function(index, element) {
			element = $( element );
			name    = this.utils.ucfirst( this.getComponent( element ) );
			this._callback( name, element );
		}.bind( this ) );
	};

	Model.getComponent = function(element) {
		var component = element.data( this.utils.prefix + '-component' );

		if ( !component ) {
			return '';
		}

		return component;
	};

	Model._callback = function(name, element) {
		var callback = WPUSB.Components[name];

		if ( typeof callback == 'function' ) {
			callback.call( null, element );
			return;
		}

		console.log( 'Component "' + name + '" is not a function.' );
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

	$.fn.addEvent = function(event, action, context) {
        var handle = context.utils.ucfirst( [ '_on', event, action ].join( '-' ) );
        this.byAction( action ).on( event, $.proxy( context, handle ) );
	};

	$.fn.findComponent = function(selector, callback) {
		var elements = $(this).find( selector );

		if ( elements.length && typeof callback == 'function' ) {
			callback.call( null, elements, $(this) );
		}

		return elements.length;
	};

})( jQuery );;WPUSB( 'WPUSB.Application', function(Application, $) {

	Application.init = function(container) {
		WPUSB.BuildComponents.create( container );
		WPUSB.FixedTop.create( container );
	};

});;WPUSB( 'WPUSB.Components.CounterSocialShare', function(Model, $) {

	Model.fn.start = function() {
		if ( this.isShareCountsDisabled() ) {
			this.renderExtras();
			return;
		}

		this.setParams();
		this.init();
	};

	Model.fn.isShareCountsDisabled = function() {
		return ( this.data.disabledShareCounts === 1 );
	};

	Model.fn.setParams = function() {
		this.prefix           = this.utils.prefix + '-';
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
	};

	Model.fn.init = function() {
		this.renderExtras();
		this.addEventListeners();
		this.request();
	};

	Model.fn.addEventListeners = function() {
		this.$el.addEvent( 'click', 'open-popup', this );
		WPUSB.ToggleButtons.create( this.$el.data( 'element' ), this.$el );
	};

	Model.fn.request = function() {
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
				return ( parseInt( response.count ) || 0 );
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

			return parseInt( data.globalCounts.count );
		}

		console.log( 'Google+ count fail' );

		return 0;
	};

	Model.fn.getTotalShareFacebook = function(response) {
		if ( typeof response === 'object' ) {
			return parseInt( response.share_count );
		}

		return 0;
	};

	Model.fn.getTotalShareTumblr = function(response) {
		if ( typeof response === 'object' ) {
			return parseInt( response.note_count );
		}

		return 0;
	};

	Model.fn.getParamsGoogle = function() {
		return JSON.stringify({
			id         : this.utils.decodeUrl( this.data.elementUrl ),
			key        : 'p',
			method     : 'pos.plusones.get',
			jsonrpc    : '2.0',
			apiVersion : 'v1',
			params     : {
				nolog   : true,
				id      : this.utils.decodeUrl( this.data.elementUrl ),
				source  : 'widget',
				userId  : '@viewer',
				groupId : '@self'
			}
		});
	};

	Model.fn._onClickOpenPopup = function(event) {
		if ( this.data.report ) {
			return;
		}

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
	       url    : this.utils.getAjaxUrl(),
	       data   : params
	   });
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

	Model.fn.renderExtras = function() {
		WPUSB.FeaturedReferrer.create( this.$el );
		WPUSB.OpenPopup.create( this.$el );
		WPUSB.FixedContext.create( this.$el );
	};

});;WPUSB( 'WPUSB.Components.ButtonsSection', function(Modal, $) {

	var modalIds = {};

	Modal.fn.start = function() {
		this.prefix  = '.' + this.utils.prefix;
		this.id      = this.$el.find( this.prefix + '-share a' ).data( 'modal-id' );
		this.modalId = this.utils.prefix + '-modal-container-' + this.id;
		this.maskId  = this.utils.prefix + '-modal-' + this.id;
		this.init();
	};

	Modal.fn.init = function() {
		this.setModal();
		this.setMask();

		WPUSB.OpenPopup.create( this.modal );
		this.addEventListener();

		modalIds[this.id] = true;
	};

	Modal.fn.setModal = function() {
		var modal = this.$el.byElement( this.modalId );

		if ( !modalIds[this.id] ) {
			WPUSB.vars.body.append( modal.clone() );
		}

		modal.show();

		this.modal = WPUSB.vars.body.byElement( this.modalId );
		this.close = this.modal.find( this.prefix + '-btn-close' );

		this.setSizes();
		this.setPosition();

		modal.remove();
	};

	Modal.fn.setMask = function() {
		var mask = this.$el.byElement( this.maskId );

		if ( !modalIds[this.id] ) {
			WPUSB.vars.body.append( mask.clone() );
		}

		this.mask = WPUSB.vars.body.byElement( this.maskId );
		mask.remove();
	};

	Modal.fn.addEventListener = function() {
		this.mask.addEvent( 'click', 'close-popup', this );
		this.mask.on( 'click', this._onClickClosePopup.bind( this ) );
		this.$el.on( 'click', '[data-modal-id="' + this.id + '"]', this._onClickOpenModalNetworks.bind( this ) );
	};

	Modal.fn._onClickClosePopup = function(event) {
		event.preventDefault();
		this.closeModal();
	};

	Modal.fn._onClickOpenModalNetworks = function(event) {
		event.preventDefault();
		this.openModal();
	};

	Modal.fn.setSizes = function() {
		this.setTop();
		this.setLeft();
	};

	Modal.fn.closeModal = function() {
		this.mask.css( 'opacity', 0 );
		this.mask.hide();
		this.modal.hide();
	};

	Modal.fn.openModal = function() {
		this.mask.css( 'opacity', 1 );
		this.mask.show();
		this.modal.show();
	};

	Modal.fn.setTop = function() {
		var height   = ( window.innerHeight * 0.5 )
		  ,	elHeight = ( this.modal.height() * 0.5 )
		  , position = ( height - elHeight )
		;

		this.btnTop = ( position - 20 ) + 'px';
		this.top    = position + 'px';
	};

	Modal.fn.setLeft = function() {
		var width    = ( window.innerWidth * 0.5 )
		  ,	elWidth  = ( this.modal.width() * 0.5 )
		  , position = ( width - elWidth )
		;

		this.btnRight = ( position - 40 ) + 'px';
		this.left     =  position + 'px';
	};

	Modal.fn.setPosition = function() {
		this.modal.css({
			top  : this.top,
			left : this.left
		});

		this.close.css({
			top   : this.btnTop,
			right : this.btnRight
		});
	};

});;WPUSB( 'WPUSB.FeaturedReferrer', function(Referrer, $) {

	Referrer.create = function(container) {
		this.prefix = this.utils.prefix + '-';
		this.$el    = container;
		this.init();
	};

	Referrer.init = function() {
		if ( this.$el.attr('class').match( '-fixed' ) ) {
			return;
		}

		this.setReferrer();
	};

	Referrer.setReferrer = function() {
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

	Referrer.showReferrer = function(referrer) {
		var className = this.prefix + 'referrer'
		  , element   = this.$el.byReferrer( referrer )
		;

		this.$el.find( '.' + this.prefix + 'count' ).remove();
		this.$el.find( '.' + this.prefix + 'counter' ).remove();

		this.$el.prepend( element );

		element.addClass( className );

		this.refTitle( element );
	};

	Referrer.refTitle = function(element) {
		if ( !element.find( 'span[data-title]' ).length ) {
			var title = '<span data-title="' + element.data( 'ref-title' ) + '"></span>';
			element.find( 'a' ).append( title );
		}
	};

	Referrer.isMatch = function(name) {
		var ref     = document.referrer
		  , pattern = new RegExp( '^https?:\/\/([^\/]+\\.)?' + name + '\\.com?(\/|$)', 'i' )
		;

		return ref.match( pattern );
	};

}, {} );;WPUSB( 'WPUSB.FixedContext', function(Model, $) {

	Model.create = function(container) {
		this.$el = container;
		this.id  = this.utils.getContext();

		if ( ! this.id || ! this.isLayoutFixed() || ! this.issetContext() ) {
			return;
		}

        this.init();
	};

	Model.isLayoutFixed = function() {
		return this.$el.attr('class').match( '-fixed-' );
	};

	Model.issetContext = function() {
		return this.getContext( true );
	};

	Model.init = function() {
		this.setContext();
		this.alignButtons();
	};

	Model.setContext = function() {
		this.context = this.getContext();
		this.setRect();
	};

	Model.setRect = function() {
		this.rect = this.context.getBoundingClientRect();
		this.top  = this.rect.top;

		this.setLeft( this.rect.left );
	};

	Model.setLeft = function(left) {
		this.left = ( left - this.$el.width() );
	};

	Model.alignButtons = function() {
		this.$el.byAction( 'close-buttons' ).remove();
		this.changeClass();
		this.$el.css({
			left : this.left
		});

		this.setLeftMobile();
	};

	Model.setLeftMobile = function() {
		if ( window.innerWidth > 769 ) {
			return;
		}

		this.$el.css({
			left : 'initial'
		});
	};

	Model.changeClass = function() {
		var prefix  = WPUSB.vars.prefix
		  , classes = this.$el.attr('class');

		if ( classes.match( '-fixed-left' ) ) {
			return;
		}

		this.$el.removeClass( prefix + '-fixed-right' );
		this.$el.addClass( prefix + '-fixed-left' );
	};

	Model.getContext = function(verify) {
		var id = this.id.replace( /[^A-Z0-9a-z-_]/g, '' )
		  , el
		;

		if ( !id ) {
			return false;
		}

		el = document.getElementById( id );

		( verify ) ? this.addNotice( el ) : '';

		return el;
	};

	Model.addNotice = function(el) {
		if ( ! el ) {
			console.log( 'WPUSB: Context not found.' );
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
        this.init();
    };

    OpenPopup.init = function() {
    	if ( this.utils.isMobile() ) {
    		return this.setMessengerUrl();
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

	OpenPopup.setMessengerUrl = function() {
		var messenger = this.$el.find( '[data-messenger-mobile]' );

		if ( !messenger.length ) {
			return;
		}

		messenger.attr( 'href', messenger.data( 'messenger-mobile' ) );
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

	WPUSB.Application.init.apply( WPUSB.utils, [context] );
});