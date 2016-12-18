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
                var instance
                  , elements = {}
                ;

                instance      = new Instantiate();
                instance.$el  = context;
                instance.data = context.data();

                context.find( '[data-element]' ).each(function(index, element) {
                    var name = WPUSB.utils.ucfirst( element.dataset.element );

                    if ( elements[name] ) {
                        return;
                    }

                     elements[name] = context.byElement( element.dataset.element );
                });


                instance.elements = elements;
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
        },

        decodeUrl : function(uri) {
            return decodeURIComponent( uri );
        }
    };

    context.WPUSB = WPUSB;

})( window, jQuery );