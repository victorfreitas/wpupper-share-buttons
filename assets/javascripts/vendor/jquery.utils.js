;(function($) {

	$.prototype.byElement = function(name) {
		return this.find( '[data-element="' + name + '"]' );
	};

	$.prototype.byAction = function(name) {
		return this.find( '[data-action="' + name + '"]' );
	};

	$.prototype.byReferrer = function(name) {
		return this.find( '[data-referrer="' + name + '"]' );
	};

	$.prototype.byComponent = function(name) {
		return this.find( '[data-component="' + name + '"]' );
	};

	$.prototype.getAjaxUrl = function() {
		return ( window.WPUpperVars || {} ).ajaxUrl;
	};

	$.prototype.getLocale = function() {
		return ( window.WPUpperVars || {} ).WPLANG;
	};

	$.prototype.findComponent = function(selector, callback) {
		var elements = $(this).find( selector );

		if ( elements.length && typeof callback == 'function' ) {
			callback.call( null, elements, $(this) );
		}

		return elements.length;
	};

	$.prototype.ucfirst = function(text) {
	    text = text.replace(/(?:^|-)\w/g, function(match) {
	        return match.toUpperCase();
	    });

	    return text.replace(/-/g, '');
    };

	$.prototype.getTime = function() {
		return ( new Date() ).getTime();
	};

	$.prototype.hashStr = function(str) {
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

var wpupperCallback = function(response) {};