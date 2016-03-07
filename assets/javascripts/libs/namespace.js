;(function(context) {

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
          callback.call( null, parent, jQuery );
        }

        return parent;
  };

  WPUPPER.instantiate = function() {
    var Instantiate       = function() {}
      , ObjectConstructor = function() {
          var instance;

          instance = new Instantiate();
          instance.start.apply( instance, arguments );

          return instance;
      }
    ;

    Instantiate.prototype             = ObjectConstructor.prototype;
    ObjectConstructor.prototype.start = function() {};

    return ObjectConstructor;
  };

 context.WPUPPER = WPUPPER;

})( window );