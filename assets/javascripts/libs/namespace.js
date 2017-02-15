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

        getId: function(id) {
            if ( !id ) {
                return false;
            }

            return document.getElementById( id );
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

})( window, jQuery );