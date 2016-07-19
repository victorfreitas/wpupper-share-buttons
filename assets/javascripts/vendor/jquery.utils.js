;(function($) {

	$.fn.byElement = function(name) {
		return this.find( '[data-element="' + name + '"]' );
	};

	$.fn.byAction = function(name) {
		return this.find( '[data-action="' + name + '"]' );
	};

	$.fn.byReferrer = function(name) {
		return this.find( '[data-referrer="' + name + '"]' );
	};

	$.fn.byComponent = function(name) {
		return this.find( '[data-component="' + name + '"]' );
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
	};

	$.fn.getTime = function() {
		return ( new Date() ).getTime();
	};

	$.fn.hashStr = function(str) {
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
	};

})( jQuery );