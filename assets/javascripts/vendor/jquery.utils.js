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

})( jQuery );