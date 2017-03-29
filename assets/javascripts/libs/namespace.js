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
            callback.call( null, parent, $, WPUSB.utils );
        }

        return parent;
    };

    WPUSB.Core = function() {
        var self        = this
          , Core        = function() {}
          , Constructor = function(context) {
                var instance;

                instance           = new Core();
                instance.$el       = context;
                instance.data      = context.data();
                instance.elements  = self.getElements( context, 'element' );
                instance.addPrefix = self.utils.addPrefix;
                instance.prefix    = self.utils.prefix;

                instance.start.apply( instance, arguments );

                return instance;
            }
        ;

        Constructor.fn       = Constructor.prototype;
        Core.prototype       = Constructor.fn;
        Constructor.fn.start = function() {};

        return Constructor;
    };

    WPUSB.getElements = function(context, name) {
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

        addPrefix: function(tag, separator) {
            var sep = ( separator ) ? separator : '-';
            return this.prefix + sep + tag;
        },

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

        getMinCount: function() {
            var minCount = ( this.getGlobalVars( 'minCount' ) || 0 );
            return parseInt( minCount );
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

        hasParam: function() {
            return ~window.location.href.indexOf( '?' );
        },

        isStorageAvailable: function() {
            return this.storageAvailable( 'localStorage' );
        },

        getPathName: function() {
            return this.addPrefix( window.location.pathname, 'r' );
        },

        timeKey: function() {
            return this.strToCode( this.getPathName() + '/storage-time' );
        },

        setCacheTime: function() {
            this.setItem( this.timeKey(), this.getTime() );
        },

        setItem: function(key, value) {
            if ( !this.isStorageAvailable() ) {
                return;
            }

            localStorage.setItem( key, value );
        },

        getItem: function(key) {
            if ( !this.isStorageAvailable() ) {
                return 0;
            }

            return localStorage.getItem( key );
        },

        hasExpiredCache: function() {
            if ( !this.isStorageAvailable() ) {
                return true;
            }

            return ( ( this.getTime() - this.getItem( this.timeKey() ) ) > ( 5 * 60 * 1000 ) );
        },

        getSpinner: function() {
            var img       = document.createElement( 'img' );
            img.src       = this.getSpinnerUrl();
            img.className = this.prefix + '-spinner';

            return img;
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

        storageAvailable: function(type) {
            try {
                var storage = window[type]
                  , x       = '__storage_test__'
                ;

                storage.setItem(x, x);
                storage.removeItem(x);
                return true;
            } catch(e) {
                return false;
            }
        },

        get: function(key, defaultVal) {
            var query, vars, varsLength, pair, i;

            if ( !this.hasParam() ) {
                return ( defaultVal || '' );
            }

            query      = window.location.search.substring(1);
            vars       = query.split( '&' );
            varsLength = vars.length;

            for ( i = 0; i < varsLength; i++ ) {
                pair = vars[i].split( '=' );

                if ( pair[0] === key ) {
                    return pair[1];
                }
            }

            return ( defaultVal || '' );
        },

        strToCode: function(str) {
            var hash   = 0
              , strLen = str.length
              , i
              , chr
            ;

            if ( !strLen ) {
                return hash;
            }

            for ( i = 0; i < strLen; i++ ) {
                chr   = str.charCodeAt( i );
                hash  = ( ( hash << 5 ) - hash ) + chr;
                hash |= 0;
            }

            return Math.abs( hash );
        }
    };

    context.WPUSB = WPUSB;

})( window, jQuery );