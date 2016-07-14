;(function(context, $) {

    'use strict';

    var WPUPPER = function(namespace, callback) {
        var parts  = namespace.split( '\.' )
          , loader = WPUPPER.instantiate()
          , parent = context
          , count  = parts.length
          , index  = 0
        ;
        for ( index; index < count; index++ ) {
            parent[parts[index]] = ( count - 1 === index ) ? loader : parent[parts[index]] || {};
            parent               = parent[parts[index]];
        }

        if ( 'function' === typeof callback ) {
            callback.call( null, parent, $ );
        }

        return parent;
    };

    WPUPPER.instantiate = function() {
        var Instantiate = function() {}
          , Constructor = function() {
                var instance;

                instance = new Instantiate();
                instance.start.apply( instance, arguments );

                return instance;
            }
        ;

        Constructor.fn        = Constructor.prototype;
        Instantiate.prototype = Constructor.fn;
        Constructor.fn.start  = function() {};

        return Constructor;
    };

    context.WPUPPER = WPUPPER;

})( window, jQuery );