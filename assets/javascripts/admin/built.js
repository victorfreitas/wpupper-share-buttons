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

})( window, jQuery );;/*!

 handlebars v4.0.5

Copyright (C) 2011-2015 by Yehuda Katz

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

@license
*/
(function webpackUniversalModuleDefinition(root, factory) {
	if(typeof exports === 'object' && typeof module === 'object')
		module.exports = factory();
	else if(typeof define === 'function' && define.amd)
		define([], factory);
	else if(typeof exports === 'object')
		exports["Handlebars"] = factory();
	else
		root["Handlebars"] = factory();
})(this, function() {
return /******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};

/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {

/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;

/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};

/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;

/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}


/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;

/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;

/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";

/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	var _interopRequireWildcard = __webpack_require__(1)['default'];

	var _interopRequireDefault = __webpack_require__(2)['default'];

	exports.__esModule = true;

	var _handlebarsBase = __webpack_require__(3);

	var base = _interopRequireWildcard(_handlebarsBase);

	// Each of these augment the Handlebars object. No need to setup here.
	// (This is done to easily share code between commonjs and browse envs)

	var _handlebarsSafeString = __webpack_require__(17);

	var _handlebarsSafeString2 = _interopRequireDefault(_handlebarsSafeString);

	var _handlebarsException = __webpack_require__(5);

	var _handlebarsException2 = _interopRequireDefault(_handlebarsException);

	var _handlebarsUtils = __webpack_require__(4);

	var Utils = _interopRequireWildcard(_handlebarsUtils);

	var _handlebarsRuntime = __webpack_require__(18);

	var runtime = _interopRequireWildcard(_handlebarsRuntime);

	var _handlebarsNoConflict = __webpack_require__(19);

	var _handlebarsNoConflict2 = _interopRequireDefault(_handlebarsNoConflict);

	// For compatibility and usage outside of module systems, make the Handlebars object a namespace
	function create() {
	  var hb = new base.HandlebarsEnvironment();

	  Utils.extend(hb, base);
	  hb.SafeString = _handlebarsSafeString2['default'];
	  hb.Exception = _handlebarsException2['default'];
	  hb.Utils = Utils;
	  hb.escapeExpression = Utils.escapeExpression;

	  hb.VM = runtime;
	  hb.template = function (spec) {
	    return runtime.template(spec, hb);
	  };

	  return hb;
	}

	var inst = create();
	inst.create = create;

	_handlebarsNoConflict2['default'](inst);

	inst['default'] = inst;

	exports['default'] = inst;
	module.exports = exports['default'];

/***/ },
/* 1 */
/***/ function(module, exports) {

	"use strict";

	exports["default"] = function (obj) {
	  if (obj && obj.__esModule) {
	    return obj;
	  } else {
	    var newObj = {};

	    if (obj != null) {
	      for (var key in obj) {
	        if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key];
	      }
	    }

	    newObj["default"] = obj;
	    return newObj;
	  }
	};

	exports.__esModule = true;

/***/ },
/* 2 */
/***/ function(module, exports) {

	"use strict";

	exports["default"] = function (obj) {
	  return obj && obj.__esModule ? obj : {
	    "default": obj
	  };
	};

	exports.__esModule = true;

/***/ },
/* 3 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	var _interopRequireDefault = __webpack_require__(2)['default'];

	exports.__esModule = true;
	exports.HandlebarsEnvironment = HandlebarsEnvironment;

	var _utils = __webpack_require__(4);

	var _exception = __webpack_require__(5);

	var _exception2 = _interopRequireDefault(_exception);

	var _helpers = __webpack_require__(6);

	var _decorators = __webpack_require__(14);

	var _logger = __webpack_require__(16);

	var _logger2 = _interopRequireDefault(_logger);

	var VERSION = '4.0.5';
	exports.VERSION = VERSION;
	var COMPILER_REVISION = 7;

	exports.COMPILER_REVISION = COMPILER_REVISION;
	var REVISION_CHANGES = {
	  1: '<= 1.0.rc.2', // 1.0.rc.2 is actually rev2 but doesn't report it
	  2: '== 1.0.0-rc.3',
	  3: '== 1.0.0-rc.4',
	  4: '== 1.x.x',
	  5: '== 2.0.0-alpha.x',
	  6: '>= 2.0.0-beta.1',
	  7: '>= 4.0.0'
	};

	exports.REVISION_CHANGES = REVISION_CHANGES;
	var objectType = '[object Object]';

	function HandlebarsEnvironment(helpers, partials, decorators) {
	  this.helpers = helpers || {};
	  this.partials = partials || {};
	  this.decorators = decorators || {};

	  _helpers.registerDefaultHelpers(this);
	  _decorators.registerDefaultDecorators(this);
	}

	HandlebarsEnvironment.prototype = {
	  constructor: HandlebarsEnvironment,

	  logger: _logger2['default'],
	  log: _logger2['default'].log,

	  registerHelper: function registerHelper(name, fn) {
	    if (_utils.toString.call(name) === objectType) {
	      if (fn) {
	        throw new _exception2['default']('Arg not supported with multiple helpers');
	      }
	      _utils.extend(this.helpers, name);
	    } else {
	      this.helpers[name] = fn;
	    }
	  },
	  unregisterHelper: function unregisterHelper(name) {
	    delete this.helpers[name];
	  },

	  registerPartial: function registerPartial(name, partial) {
	    if (_utils.toString.call(name) === objectType) {
	      _utils.extend(this.partials, name);
	    } else {
	      if (typeof partial === 'undefined') {
	        throw new _exception2['default']('Attempting to register a partial called "' + name + '" as undefined');
	      }
	      this.partials[name] = partial;
	    }
	  },
	  unregisterPartial: function unregisterPartial(name) {
	    delete this.partials[name];
	  },

	  registerDecorator: function registerDecorator(name, fn) {
	    if (_utils.toString.call(name) === objectType) {
	      if (fn) {
	        throw new _exception2['default']('Arg not supported with multiple decorators');
	      }
	      _utils.extend(this.decorators, name);
	    } else {
	      this.decorators[name] = fn;
	    }
	  },
	  unregisterDecorator: function unregisterDecorator(name) {
	    delete this.decorators[name];
	  }
	};

	var log = _logger2['default'].log;

	exports.log = log;
	exports.createFrame = _utils.createFrame;
	exports.logger = _logger2['default'];

/***/ },
/* 4 */
/***/ function(module, exports) {

	'use strict';

	exports.__esModule = true;
	exports.extend = extend;
	exports.indexOf = indexOf;
	exports.escapeExpression = escapeExpression;
	exports.isEmpty = isEmpty;
	exports.createFrame = createFrame;
	exports.blockParams = blockParams;
	exports.appendContextPath = appendContextPath;
	var escape = {
	  '&': '&amp;',
	  '<': '&lt;',
	  '>': '&gt;',
	  '"': '&quot;',
	  "'": '&#x27;',
	  '`': '&#x60;',
	  '=': '&#x3D;'
	};

	var badChars = /[&<>"'`=]/g,
	    possible = /[&<>"'`=]/;

	function escapeChar(chr) {
	  return escape[chr];
	}

	function extend(obj /* , ...source */) {
	  for (var i = 1; i < arguments.length; i++) {
	    for (var key in arguments[i]) {
	      if (Object.prototype.hasOwnProperty.call(arguments[i], key)) {
	        obj[key] = arguments[i][key];
	      }
	    }
	  }

	  return obj;
	}

	var toString = Object.prototype.toString;

	exports.toString = toString;
	// Sourced from lodash
	// https://github.com/bestiejs/lodash/blob/master/LICENSE.txt
	/* eslint-disable func-style */
	var isFunction = function isFunction(value) {
	  return typeof value === 'function';
	};
	// fallback for older versions of Chrome and Safari
	/* istanbul ignore next */
	if (isFunction(/x/)) {
	  exports.isFunction = isFunction = function (value) {
	    return typeof value === 'function' && toString.call(value) === '[object Function]';
	  };
	}
	exports.isFunction = isFunction;

	/* eslint-enable func-style */

	/* istanbul ignore next */
	var isArray = Array.isArray || function (value) {
	  return value && typeof value === 'object' ? toString.call(value) === '[object Array]' : false;
	};

	exports.isArray = isArray;
	// Older IE versions do not directly support indexOf so we must implement our own, sadly.

	function indexOf(array, value) {
	  for (var i = 0, len = array.length; i < len; i++) {
	    if (array[i] === value) {
	      return i;
	    }
	  }
	  return -1;
	}

	function escapeExpression(string) {
	  if (typeof string !== 'string') {
	    // don't escape SafeStrings, since they're already safe
	    if (string && string.toHTML) {
	      return string.toHTML();
	    } else if (string == null) {
	      return '';
	    } else if (!string) {
	      return string + '';
	    }

	    // Force a string conversion as this will be done by the append regardless and
	    // the regex test will do this transparently behind the scenes, causing issues if
	    // an object's to string has escaped characters in it.
	    string = '' + string;
	  }

	  if (!possible.test(string)) {
	    return string;
	  }
	  return string.replace(badChars, escapeChar);
	}

	function isEmpty(value) {
	  if (!value && value !== 0) {
	    return true;
	  } else if (isArray(value) && value.length === 0) {
	    return true;
	  } else {
	    return false;
	  }
	}

	function createFrame(object) {
	  var frame = extend({}, object);
	  frame._parent = object;
	  return frame;
	}

	function blockParams(params, ids) {
	  params.path = ids;
	  return params;
	}

	function appendContextPath(contextPath, id) {
	  return (contextPath ? contextPath + '.' : '') + id;
	}

/***/ },
/* 5 */
/***/ function(module, exports) {

	'use strict';

	exports.__esModule = true;

	var errorProps = ['description', 'fileName', 'lineNumber', 'message', 'name', 'number', 'stack'];

	function Exception(message, node) {
	  var loc = node && node.loc,
	      line = undefined,
	      column = undefined;
	  if (loc) {
	    line = loc.start.line;
	    column = loc.start.column;

	    message += ' - ' + line + ':' + column;
	  }

	  var tmp = Error.prototype.constructor.call(this, message);

	  // Unfortunately errors are not enumerable in Chrome (at least), so `for prop in tmp` doesn't work.
	  for (var idx = 0; idx < errorProps.length; idx++) {
	    this[errorProps[idx]] = tmp[errorProps[idx]];
	  }

	  /* istanbul ignore else */
	  if (Error.captureStackTrace) {
	    Error.captureStackTrace(this, Exception);
	  }

	  if (loc) {
	    this.lineNumber = line;
	    this.column = column;
	  }
	}

	Exception.prototype = new Error();

	exports['default'] = Exception;
	module.exports = exports['default'];

/***/ },
/* 6 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	var _interopRequireDefault = __webpack_require__(2)['default'];

	exports.__esModule = true;
	exports.registerDefaultHelpers = registerDefaultHelpers;

	var _helpersBlockHelperMissing = __webpack_require__(7);

	var _helpersBlockHelperMissing2 = _interopRequireDefault(_helpersBlockHelperMissing);

	var _helpersEach = __webpack_require__(8);

	var _helpersEach2 = _interopRequireDefault(_helpersEach);

	var _helpersHelperMissing = __webpack_require__(9);

	var _helpersHelperMissing2 = _interopRequireDefault(_helpersHelperMissing);

	var _helpersIf = __webpack_require__(10);

	var _helpersIf2 = _interopRequireDefault(_helpersIf);

	var _helpersLog = __webpack_require__(11);

	var _helpersLog2 = _interopRequireDefault(_helpersLog);

	var _helpersLookup = __webpack_require__(12);

	var _helpersLookup2 = _interopRequireDefault(_helpersLookup);

	var _helpersWith = __webpack_require__(13);

	var _helpersWith2 = _interopRequireDefault(_helpersWith);

	function registerDefaultHelpers(instance) {
	  _helpersBlockHelperMissing2['default'](instance);
	  _helpersEach2['default'](instance);
	  _helpersHelperMissing2['default'](instance);
	  _helpersIf2['default'](instance);
	  _helpersLog2['default'](instance);
	  _helpersLookup2['default'](instance);
	  _helpersWith2['default'](instance);
	}

/***/ },
/* 7 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _utils = __webpack_require__(4);

	exports['default'] = function (instance) {
	  instance.registerHelper('blockHelperMissing', function (context, options) {
	    var inverse = options.inverse,
	        fn = options.fn;

	    if (context === true) {
	      return fn(this);
	    } else if (context === false || context == null) {
	      return inverse(this);
	    } else if (_utils.isArray(context)) {
	      if (context.length > 0) {
	        if (options.ids) {
	          options.ids = [options.name];
	        }

	        return instance.helpers.each(context, options);
	      } else {
	        return inverse(this);
	      }
	    } else {
	      if (options.data && options.ids) {
	        var data = _utils.createFrame(options.data);
	        data.contextPath = _utils.appendContextPath(options.data.contextPath, options.name);
	        options = { data: data };
	      }

	      return fn(context, options);
	    }
	  });
	};

	module.exports = exports['default'];

/***/ },
/* 8 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	var _interopRequireDefault = __webpack_require__(2)['default'];

	exports.__esModule = true;

	var _utils = __webpack_require__(4);

	var _exception = __webpack_require__(5);

	var _exception2 = _interopRequireDefault(_exception);

	exports['default'] = function (instance) {
	  instance.registerHelper('each', function (context, options) {
	    if (!options) {
	      throw new _exception2['default']('Must pass iterator to #each');
	    }

	    var fn = options.fn,
	        inverse = options.inverse,
	        i = 0,
	        ret = '',
	        data = undefined,
	        contextPath = undefined;

	    if (options.data && options.ids) {
	      contextPath = _utils.appendContextPath(options.data.contextPath, options.ids[0]) + '.';
	    }

	    if (_utils.isFunction(context)) {
	      context = context.call(this);
	    }

	    if (options.data) {
	      data = _utils.createFrame(options.data);
	    }

	    function execIteration(field, index, last) {
	      if (data) {
	        data.key = field;
	        data.index = index;
	        data.first = index === 0;
	        data.last = !!last;

	        if (contextPath) {
	          data.contextPath = contextPath + field;
	        }
	      }

	      ret = ret + fn(context[field], {
	        data: data,
	        blockParams: _utils.blockParams([context[field], field], [contextPath + field, null])
	      });
	    }

	    if (context && typeof context === 'object') {
	      if (_utils.isArray(context)) {
	        for (var j = context.length; i < j; i++) {
	          if (i in context) {
	            execIteration(i, i, i === context.length - 1);
	          }
	        }
	      } else {
	        var priorKey = undefined;

	        for (var key in context) {
	          if (context.hasOwnProperty(key)) {
	            // We're running the iterations one step out of sync so we can detect
	            // the last iteration without have to scan the object twice and create
	            // an itermediate keys array.
	            if (priorKey !== undefined) {
	              execIteration(priorKey, i - 1);
	            }
	            priorKey = key;
	            i++;
	          }
	        }
	        if (priorKey !== undefined) {
	          execIteration(priorKey, i - 1, true);
	        }
	      }
	    }

	    if (i === 0) {
	      ret = inverse(this);
	    }

	    return ret;
	  });
	};

	module.exports = exports['default'];

/***/ },
/* 9 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	var _interopRequireDefault = __webpack_require__(2)['default'];

	exports.__esModule = true;

	var _exception = __webpack_require__(5);

	var _exception2 = _interopRequireDefault(_exception);

	exports['default'] = function (instance) {
	  instance.registerHelper('helperMissing', function () /* [args, ]options */{
	    if (arguments.length === 1) {
	      // A missing field in a {{foo}} construct.
	      return undefined;
	    } else {
	      // Someone is actually trying to call something, blow up.
	      throw new _exception2['default']('Missing helper: "' + arguments[arguments.length - 1].name + '"');
	    }
	  });
	};

	module.exports = exports['default'];

/***/ },
/* 10 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _utils = __webpack_require__(4);

	exports['default'] = function (instance) {
	  instance.registerHelper('if', function (conditional, options) {
	    if (_utils.isFunction(conditional)) {
	      conditional = conditional.call(this);
	    }

	    // Default behavior is to render the positive path if the value is truthy and not empty.
	    // The `includeZero` option may be set to treat the condtional as purely not empty based on the
	    // behavior of isEmpty. Effectively this determines if 0 is handled by the positive path or negative.
	    if (!options.hash.includeZero && !conditional || _utils.isEmpty(conditional)) {
	      return options.inverse(this);
	    } else {
	      return options.fn(this);
	    }
	  });

	  instance.registerHelper('unless', function (conditional, options) {
	    return instance.helpers['if'].call(this, conditional, { fn: options.inverse, inverse: options.fn, hash: options.hash });
	  });
	};

	module.exports = exports['default'];

/***/ },
/* 11 */
/***/ function(module, exports) {

	'use strict';

	exports.__esModule = true;

	exports['default'] = function (instance) {
	  instance.registerHelper('log', function () /* message, options */{
	    var args = [undefined],
	        options = arguments[arguments.length - 1];
	    for (var i = 0; i < arguments.length - 1; i++) {
	      args.push(arguments[i]);
	    }

	    var level = 1;
	    if (options.hash.level != null) {
	      level = options.hash.level;
	    } else if (options.data && options.data.level != null) {
	      level = options.data.level;
	    }
	    args[0] = level;

	    instance.log.apply(instance, args);
	  });
	};

	module.exports = exports['default'];

/***/ },
/* 12 */
/***/ function(module, exports) {

	'use strict';

	exports.__esModule = true;

	exports['default'] = function (instance) {
	  instance.registerHelper('lookup', function (obj, field) {
	    return obj && obj[field];
	  });
	};

	module.exports = exports['default'];

/***/ },
/* 13 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _utils = __webpack_require__(4);

	exports['default'] = function (instance) {
	  instance.registerHelper('with', function (context, options) {
	    if (_utils.isFunction(context)) {
	      context = context.call(this);
	    }

	    var fn = options.fn;

	    if (!_utils.isEmpty(context)) {
	      var data = options.data;
	      if (options.data && options.ids) {
	        data = _utils.createFrame(options.data);
	        data.contextPath = _utils.appendContextPath(options.data.contextPath, options.ids[0]);
	      }

	      return fn(context, {
	        data: data,
	        blockParams: _utils.blockParams([context], [data && data.contextPath])
	      });
	    } else {
	      return options.inverse(this);
	    }
	  });
	};

	module.exports = exports['default'];

/***/ },
/* 14 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	var _interopRequireDefault = __webpack_require__(2)['default'];

	exports.__esModule = true;
	exports.registerDefaultDecorators = registerDefaultDecorators;

	var _decoratorsInline = __webpack_require__(15);

	var _decoratorsInline2 = _interopRequireDefault(_decoratorsInline);

	function registerDefaultDecorators(instance) {
	  _decoratorsInline2['default'](instance);
	}

/***/ },
/* 15 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _utils = __webpack_require__(4);

	exports['default'] = function (instance) {
	  instance.registerDecorator('inline', function (fn, props, container, options) {
	    var ret = fn;
	    if (!props.partials) {
	      props.partials = {};
	      ret = function (context, options) {
	        // Create a new partials stack frame prior to exec.
	        var original = container.partials;
	        container.partials = _utils.extend({}, original, props.partials);
	        var ret = fn(context, options);
	        container.partials = original;
	        return ret;
	      };
	    }

	    props.partials[options.args[0]] = options.fn;

	    return ret;
	  });
	};

	module.exports = exports['default'];

/***/ },
/* 16 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	exports.__esModule = true;

	var _utils = __webpack_require__(4);

	var logger = {
	  methodMap: ['debug', 'info', 'warn', 'error'],
	  level: 'info',

	  // Maps a given level value to the `methodMap` indexes above.
	  lookupLevel: function lookupLevel(level) {
	    if (typeof level === 'string') {
	      var levelMap = _utils.indexOf(logger.methodMap, level.toLowerCase());
	      if (levelMap >= 0) {
	        level = levelMap;
	      } else {
	        level = parseInt(level, 10);
	      }
	    }

	    return level;
	  },

	  // Can be overridden in the host environment
	  log: function log(level) {
	    level = logger.lookupLevel(level);

	    if (typeof console !== 'undefined' && logger.lookupLevel(logger.level) <= level) {
	      var method = logger.methodMap[level];
	      if (!console[method]) {
	        // eslint-disable-line no-console
	        method = 'log';
	      }

	      for (var _len = arguments.length, message = Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
	        message[_key - 1] = arguments[_key];
	      }

	      console[method].apply(console, message); // eslint-disable-line no-console
	    }
	  }
	};

	exports['default'] = logger;
	module.exports = exports['default'];

/***/ },
/* 17 */
/***/ function(module, exports) {

	// Build out our basic SafeString type
	'use strict';

	exports.__esModule = true;
	function SafeString(string) {
	  this.string = string;
	}

	SafeString.prototype.toString = SafeString.prototype.toHTML = function () {
	  return '' + this.string;
	};

	exports['default'] = SafeString;
	module.exports = exports['default'];

/***/ },
/* 18 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	var _interopRequireWildcard = __webpack_require__(1)['default'];

	var _interopRequireDefault = __webpack_require__(2)['default'];

	exports.__esModule = true;
	exports.checkRevision = checkRevision;
	exports.template = template;
	exports.wrapProgram = wrapProgram;
	exports.resolvePartial = resolvePartial;
	exports.invokePartial = invokePartial;
	exports.noop = noop;

	var _utils = __webpack_require__(4);

	var Utils = _interopRequireWildcard(_utils);

	var _exception = __webpack_require__(5);

	var _exception2 = _interopRequireDefault(_exception);

	var _base = __webpack_require__(3);

	function checkRevision(compilerInfo) {
	  var compilerRevision = compilerInfo && compilerInfo[0] || 1,
	      currentRevision = _base.COMPILER_REVISION;

	  if (compilerRevision !== currentRevision) {
	    if (compilerRevision < currentRevision) {
	      var runtimeVersions = _base.REVISION_CHANGES[currentRevision],
	          compilerVersions = _base.REVISION_CHANGES[compilerRevision];
	      throw new _exception2['default']('Template was precompiled with an older version of Handlebars than the current runtime. ' + 'Please update your precompiler to a newer version (' + runtimeVersions + ') or downgrade your runtime to an older version (' + compilerVersions + ').');
	    } else {
	      // Use the embedded version info since the runtime doesn't know about this revision yet
	      throw new _exception2['default']('Template was precompiled with a newer version of Handlebars than the current runtime. ' + 'Please update your runtime to a newer version (' + compilerInfo[1] + ').');
	    }
	  }
	}

	function template(templateSpec, env) {
	  /* istanbul ignore next */
	  if (!env) {
	    throw new _exception2['default']('No environment passed to template');
	  }
	  if (!templateSpec || !templateSpec.main) {
	    throw new _exception2['default']('Unknown template object: ' + typeof templateSpec);
	  }

	  templateSpec.main.decorator = templateSpec.main_d;

	  // Note: Using env.VM references rather than local var references throughout this section to allow
	  // for external users to override these as psuedo-supported APIs.
	  env.VM.checkRevision(templateSpec.compiler);

	  function invokePartialWrapper(partial, context, options) {
	    if (options.hash) {
	      context = Utils.extend({}, context, options.hash);
	      if (options.ids) {
	        options.ids[0] = true;
	      }
	    }

	    partial = env.VM.resolvePartial.call(this, partial, context, options);
	    var result = env.VM.invokePartial.call(this, partial, context, options);

	    if (result == null && env.compile) {
	      options.partials[options.name] = env.compile(partial, templateSpec.compilerOptions, env);
	      result = options.partials[options.name](context, options);
	    }
	    if (result != null) {
	      if (options.indent) {
	        var lines = result.split('\n');
	        for (var i = 0, l = lines.length; i < l; i++) {
	          if (!lines[i] && i + 1 === l) {
	            break;
	          }

	          lines[i] = options.indent + lines[i];
	        }
	        result = lines.join('\n');
	      }
	      return result;
	    } else {
	      throw new _exception2['default']('The partial ' + options.name + ' could not be compiled when running in runtime-only mode');
	    }
	  }

	  // Just add water
	  var container = {
	    strict: function strict(obj, name) {
	      if (!(name in obj)) {
	        throw new _exception2['default']('"' + name + '" not defined in ' + obj);
	      }
	      return obj[name];
	    },
	    lookup: function lookup(depths, name) {
	      var len = depths.length;
	      for (var i = 0; i < len; i++) {
	        if (depths[i] && depths[i][name] != null) {
	          return depths[i][name];
	        }
	      }
	    },
	    lambda: function lambda(current, context) {
	      return typeof current === 'function' ? current.call(context) : current;
	    },

	    escapeExpression: Utils.escapeExpression,
	    invokePartial: invokePartialWrapper,

	    fn: function fn(i) {
	      var ret = templateSpec[i];
	      ret.decorator = templateSpec[i + '_d'];
	      return ret;
	    },

	    programs: [],
	    program: function program(i, data, declaredBlockParams, blockParams, depths) {
	      var programWrapper = this.programs[i],
	          fn = this.fn(i);
	      if (data || depths || blockParams || declaredBlockParams) {
	        programWrapper = wrapProgram(this, i, fn, data, declaredBlockParams, blockParams, depths);
	      } else if (!programWrapper) {
	        programWrapper = this.programs[i] = wrapProgram(this, i, fn);
	      }
	      return programWrapper;
	    },

	    data: function data(value, depth) {
	      while (value && depth--) {
	        value = value._parent;
	      }
	      return value;
	    },
	    merge: function merge(param, common) {
	      var obj = param || common;

	      if (param && common && param !== common) {
	        obj = Utils.extend({}, common, param);
	      }

	      return obj;
	    },

	    noop: env.VM.noop,
	    compilerInfo: templateSpec.compiler
	  };

	  function ret(context) {
	    var options = arguments.length <= 1 || arguments[1] === undefined ? {} : arguments[1];

	    var data = options.data;

	    ret._setup(options);
	    if (!options.partial && templateSpec.useData) {
	      data = initData(context, data);
	    }
	    var depths = undefined,
	        blockParams = templateSpec.useBlockParams ? [] : undefined;
	    if (templateSpec.useDepths) {
	      if (options.depths) {
	        depths = context !== options.depths[0] ? [context].concat(options.depths) : options.depths;
	      } else {
	        depths = [context];
	      }
	    }

	    function main(context /*, options*/) {
	      return '' + templateSpec.main(container, context, container.helpers, container.partials, data, blockParams, depths);
	    }
	    main = executeDecorators(templateSpec.main, main, container, options.depths || [], data, blockParams);
	    return main(context, options);
	  }
	  ret.isTop = true;

	  ret._setup = function (options) {
	    if (!options.partial) {
	      container.helpers = container.merge(options.helpers, env.helpers);

	      if (templateSpec.usePartial) {
	        container.partials = container.merge(options.partials, env.partials);
	      }
	      if (templateSpec.usePartial || templateSpec.useDecorators) {
	        container.decorators = container.merge(options.decorators, env.decorators);
	      }
	    } else {
	      container.helpers = options.helpers;
	      container.partials = options.partials;
	      container.decorators = options.decorators;
	    }
	  };

	  ret._child = function (i, data, blockParams, depths) {
	    if (templateSpec.useBlockParams && !blockParams) {
	      throw new _exception2['default']('must pass block params');
	    }
	    if (templateSpec.useDepths && !depths) {
	      throw new _exception2['default']('must pass parent depths');
	    }

	    return wrapProgram(container, i, templateSpec[i], data, 0, blockParams, depths);
	  };
	  return ret;
	}

	function wrapProgram(container, i, fn, data, declaredBlockParams, blockParams, depths) {
	  function prog(context) {
	    var options = arguments.length <= 1 || arguments[1] === undefined ? {} : arguments[1];

	    var currentDepths = depths;
	    if (depths && context !== depths[0]) {
	      currentDepths = [context].concat(depths);
	    }

	    return fn(container, context, container.helpers, container.partials, options.data || data, blockParams && [options.blockParams].concat(blockParams), currentDepths);
	  }

	  prog = executeDecorators(fn, prog, container, depths, data, blockParams);

	  prog.program = i;
	  prog.depth = depths ? depths.length : 0;
	  prog.blockParams = declaredBlockParams || 0;
	  return prog;
	}

	function resolvePartial(partial, context, options) {
	  if (!partial) {
	    if (options.name === '@partial-block') {
	      partial = options.data['partial-block'];
	    } else {
	      partial = options.partials[options.name];
	    }
	  } else if (!partial.call && !options.name) {
	    // This is a dynamic partial that returned a string
	    options.name = partial;
	    partial = options.partials[partial];
	  }
	  return partial;
	}

	function invokePartial(partial, context, options) {
	  options.partial = true;
	  if (options.ids) {
	    options.data.contextPath = options.ids[0] || options.data.contextPath;
	  }

	  var partialBlock = undefined;
	  if (options.fn && options.fn !== noop) {
	    options.data = _base.createFrame(options.data);
	    partialBlock = options.data['partial-block'] = options.fn;

	    if (partialBlock.partials) {
	      options.partials = Utils.extend({}, options.partials, partialBlock.partials);
	    }
	  }

	  if (partial === undefined && partialBlock) {
	    partial = partialBlock;
	  }

	  if (partial === undefined) {
	    throw new _exception2['default']('The partial ' + options.name + ' could not be found');
	  } else if (partial instanceof Function) {
	    return partial(context, options);
	  }
	}

	function noop() {
	  return '';
	}

	function initData(context, data) {
	  if (!data || !('root' in data)) {
	    data = data ? _base.createFrame(data) : {};
	    data.root = context;
	  }
	  return data;
	}

	function executeDecorators(fn, prog, container, depths, data, blockParams) {
	  if (fn.decorator) {
	    var props = {};
	    prog = fn.decorator(prog, props, container, depths && depths[0], data, blockParams, depths);
	    Utils.extend(prog, props);
	  }
	  return prog;
	}

/***/ },
/* 19 */
/***/ function(module, exports) {

	/* WEBPACK VAR INJECTION */(function(global) {/* global window */
	'use strict';

	exports.__esModule = true;

	exports['default'] = function (Handlebars) {
	  /* istanbul ignore next */
	  var root = typeof global !== 'undefined' ? global : window,
	      $Handlebars = root.Handlebars;
	  /* istanbul ignore next */
	  Handlebars.noConflict = function () {
	    if (root.Handlebars === Handlebars) {
	      root.Handlebars = $Handlebars;
	    }
	    return Handlebars;
	  };
	};

	module.exports = exports['default'];
	/* WEBPACK VAR INJECTION */}.call(exports, (function() { return this; }())))

/***/ }
/******/ ])
});
;;WPUSB( 'WPUSB.BuildComponents', function(Model, $) {

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

})( jQuery );;(function() {
var template = Handlebars.template, templates = WPUSB.Templates = WPUSB.Templates || {};
templates['fixed'] = template({"1":function(container,depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=container.escapeExpression;

  return "\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.first : depth0),{"name":"if","hash":{},"fn":container.program(2, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "\n	<div class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-item "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias3(((helper = (helper = helpers.item_class || (depth0 != null ? depth0.item_class : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_class","hash":{},"data":data}) : helper)))
    + "\">\n		<a title=\"Tweet\" class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias3(((helper = (helper = helpers.btn_class || (depth0 != null ? depth0.btn_class : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"btn_class","hash":{},"data":data}) : helper)))
    + "\" data-item=\"bg-color\">\n			<i class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-icon-"
    + alias3(((helper = (helper = helpers.item_class || (depth0 != null ? depth0.item_class : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_class","hash":{},"data":data}) : helper)))
    + "-"
    + alias3(((helper = (helper = helpers.fixed_layout || (depth0 != null ? depth0.fixed_layout : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"fixed_layout","hash":{},"data":data}) : helper)))
    + "\" data-item=\"icons-color\"></i>\n		</a>\n	</div>\n\n";
},"2":function(container,depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=container.escapeExpression;

  return "		<div id=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-container-fixed\"\n		     data-preview-layout=\""
    + alias3(((helper = (helper = helpers.layout || (depth0 != null ? depth0.layout : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"layout","hash":{},"data":data}) : helper)))
    + "\"\n			 class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "\n			 "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias3(((helper = (helper = helpers.layout || (depth0 != null ? depth0.layout : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"layout","hash":{},"data":data}) : helper)))
    + "-container\n			 "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias3(((helper = (helper = helpers.fixed_layout || (depth0 != null ? depth0.fixed_layout : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"fixed_layout","hash":{},"data":data}) : helper)))
    + "\n			 "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias3(((helper = (helper = helpers.layout || (depth0 != null ? depth0.layout : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"layout","hash":{},"data":data}) : helper)))
    + "\n			 social-share\">\n\n			<div class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-item "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-total-share\">\n				<div class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-counts\">\n					<span data-element=\"total-share\" data-item=\"text\">\n						"
    + alias3(((helper = (helper = helpers.counter || (depth0 != null ? depth0.counter : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"counter","hash":{},"data":data}) : helper)))
    + "\n					</span>\n\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.is_fixed_2 : depth0),{"name":"if","hash":{},"fn":container.program(3, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "\n				</div>\n			</div>\n";
},"3":function(container,depth0,helpers,partials,data) {
    return "						<span data-element=\"fixed-label-text\"\n							  data-item=\"text\">Shares</span>\n";
},"compiler":[7,">= 4.0.0"],"main":function(container,depth0,helpers,partials,data) {
    var stack1, helper;

  return ((stack1 = helpers.each.call(depth0,depth0,{"name":"each","hash":{},"fn":container.program(1, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "	<span class=\""
    + container.escapeExpression(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-toggle\"></span>\n</div>";
},"useData":true});

templates['share-preview'] = template({"1":function(container,depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=container.escapeExpression;

  return "\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.first : depth0),{"name":"if","hash":{},"fn":container.program(2, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "\n	<div class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-item "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias3(((helper = (helper = helpers.item_class || (depth0 != null ? depth0.item_class : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_class","hash":{},"data":data}) : helper)))
    + "\">\n		<a class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-button\" title=\""
    + alias3(((helper = (helper = helpers.item_title || (depth0 != null ? depth0.item_title : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_title","hash":{},"data":data}) : helper)))
    + "\"\n		   data-item=\"bg-color\">\n\n			<i class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-icon-"
    + alias3(((helper = (helper = helpers.item_class || (depth0 != null ? depth0.item_class : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_class","hash":{},"data":data}) : helper)))
    + "-"
    + alias3(((helper = (helper = helpers.layout || (depth0 != null ? depth0.layout : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"layout","hash":{},"data":data}) : helper)))
    + "\"\n			   data-item=\"icons-color\"></i>\n\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.item_inside : depth0),{"name":"if","hash":{},"fn":container.program(5, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "		</a>\n\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.has_counter : depth0),{"name":"if","hash":{},"fn":container.program(7, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "	</div>\n\n";
},"2":function(container,depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=container.escapeExpression;

  return "		<div id=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-container"
    + alias3(((helper = (helper = helpers.container_buttons || (depth0 != null ? depth0.container_buttons : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"container_buttons","hash":{},"data":data}) : helper)))
    + "\"\n             data-preview-layout=\""
    + alias3(((helper = (helper = helpers.layout || (depth0 != null ? depth0.layout : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"layout","hash":{},"data":data}) : helper)))
    + "\"\n			 class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + " "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias3(((helper = (helper = helpers.layout || (depth0 != null ? depth0.layout : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"layout","hash":{},"data":data}) : helper)))
    + " social-share "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-preview\">\n\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.title : depth0),{"name":"if","hash":{},"fn":container.program(3, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "");
},"3":function(container,depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=container.escapeExpression;

  return "			<div class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-title\">\n			 	<span>"
    + alias3(((helper = (helper = helpers.title || (depth0 != null ? depth0.title : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"title","hash":{},"data":data}) : helper)))
    + "</span>\n			 </div>\n";
},"5":function(container,depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=container.escapeExpression;

  return "				<span class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-title\"\n					  data-item=\"inside\">"
    + alias3(((helper = (helper = helpers.item_inside || (depth0 != null ? depth0.item_inside : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_inside","hash":{},"data":data}) : helper)))
    + "</span>\n";
},"7":function(container,depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=container.escapeExpression;

  return "			<style data-element-style></style>\n			<span class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-count "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-counter\"\n				  data-item=\"text\">"
    + alias3(((helper = (helper = helpers.counter || (depth0 != null ? depth0.counter : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"counter","hash":{},"data":data}) : helper)))
    + "</span>\n";
},"compiler":[7,">= 4.0.0"],"main":function(container,depth0,helpers,partials,data) {
    var stack1;

  return ((stack1 = helpers.each.call(depth0,depth0,{"name":"each","hash":{},"fn":container.program(1, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "</div>\n<button class=\"button\" data-action=\"no-title\"></button>\n<button class=\"button\" data-action=\"no-counter\"></button>";
},"useData":true});

templates['square-plus'] = template({"1":function(container,depth0,helpers,partials,data) {
    var stack1;

  return "\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.first : depth0),{"name":"if","hash":{},"fn":container.program(2, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "\n"
    + ((stack1 = helpers.unless.call(depth0,(depth0 != null ? depth0.first : depth0),{"name":"unless","hash":{},"fn":container.program(7, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "");
},"2":function(container,depth0,helpers,partials,data) {
    var stack1, helper, alias1=helpers.helperMissing, alias2="function", alias3=container.escapeExpression;

  return "\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.title : depth0),{"name":"if","hash":{},"fn":container.program(3, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "\n		<div id=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-container-square-plus\"\n		     data-preview-layout=\""
    + alias3(((helper = (helper = helpers.layout || (depth0 != null ? depth0.layout : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"layout","hash":{},"data":data}) : helper)))
    + "\"\n		     class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + " "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias3(((helper = (helper = helpers.layout || (depth0 != null ? depth0.layout : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"layout","hash":{},"data":data}) : helper)))
    + " social-share "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-preview\">\n\n			<div class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-item "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-counter "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-total-share\">\n				<div class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-shares-count\" data-item=\"text\">"
    + alias3(((helper = (helper = helpers.counter || (depth0 != null ? depth0.counter : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"counter","hash":{},"data":data}) : helper)))
    + "</div>\n\n				<div class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-shares-text\"\n					 data-element=\"square-plus-text\"\n					 data-item=\"text\"\n					 data-title=\""
    + alias3(((helper = (helper = helpers.share_count_label || (depth0 != null ? depth0.share_count_label : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"share_count_label","hash":{},"data":data}) : helper)))
    + "\"></div>\n\n				<span class=\"wpusb-pipe\" data-pipe=\"&#x0007C;\" data-item=\"text\"></span>\n			</div>\n\n			<div class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-item "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias3(((helper = (helper = helpers.item_class || (depth0 != null ? depth0.item_class : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_class","hash":{},"data":data}) : helper)))
    + " "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-full "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-inside\">\n				<a href=\"#\" class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-link\" title=\""
    + alias3(((helper = (helper = helpers.item_title || (depth0 != null ? depth0.item_title : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_title","hash":{},"data":data}) : helper)))
    + "\" data-item=\"bg-color\">\n\n					<i class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-icon-"
    + alias3(((helper = (helper = helpers.item_class || (depth0 != null ? depth0.item_class : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_class","hash":{},"data":data}) : helper)))
    + "-square-plus\" data-item=\"icons-color\"></i>\n\n"
    + ((stack1 = helpers["if"].call(depth0,(depth0 != null ? depth0.inside : depth0),{"name":"if","hash":{},"fn":container.program(5, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "				</a>\n			</div>\n";
},"3":function(container,depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=container.escapeExpression;

  return "			<div class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-title\">\n			 	<span>"
    + alias3(((helper = (helper = helpers.title || (depth0 != null ? depth0.title : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"title","hash":{},"data":data}) : helper)))
    + "</span>\n			 </div>\n";
},"5":function(container,depth0,helpers,partials,data) {
    var helper;

  return "						<span class=\"wpusb-title\"\n							  data-item=\"inside\"\n							  data-title=\""
    + container.escapeExpression(((helper = (helper = helpers.item_name || (depth0 != null ? depth0.item_name : depth0)) != null ? helper : helpers.helperMissing),(typeof helper === "function" ? helper.call(depth0,{"name":"item_name","hash":{},"data":data}) : helper)))
    + "\"></span>\n";
},"7":function(container,depth0,helpers,partials,data) {
    var helper, alias1=helpers.helperMissing, alias2="function", alias3=container.escapeExpression;

  return "		<div class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-item "
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-"
    + alias3(((helper = (helper = helpers.item_class || (depth0 != null ? depth0.item_class : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_class","hash":{},"data":data}) : helper)))
    + "\">\n			<a href=\"#\" class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-link\" title=\""
    + alias3(((helper = (helper = helpers.item_title || (depth0 != null ? depth0.item_title : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_title","hash":{},"data":data}) : helper)))
    + "\" data-item=\"bg-color\">\n				<i class=\""
    + alias3(((helper = (helper = helpers.prefix || (depth0 != null ? depth0.prefix : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"prefix","hash":{},"data":data}) : helper)))
    + "-icon-"
    + alias3(((helper = (helper = helpers.item_class || (depth0 != null ? depth0.item_class : depth0)) != null ? helper : alias1),(typeof helper === alias2 ? helper.call(depth0,{"name":"item_class","hash":{},"data":data}) : helper)))
    + "-square-plus\" data-item=\"icons-color\"></i>\n			</a>\n		</div>\n";
},"compiler":[7,">= 4.0.0"],"main":function(container,depth0,helpers,partials,data) {
    var stack1;

  return ((stack1 = helpers.each.call(depth0,depth0,{"name":"each","hash":{},"fn":container.program(1, data, 0),"inverse":container.noop,"data":data})) != null ? stack1 : "")
    + "</div>\n<button class=\"button\" data-action=\"no-title\"></button>\n<button class=\"button\" data-action=\"no-counter\"></button>";
},"useData":true});
}());;/*! highlight.js v9.6.0 | BSD3 License | git.io/hljslicense */
!function(e){var n="object"==typeof window&&window||"object"==typeof self&&self;"undefined"!=typeof exports?e(exports):n&&(n.hljs=e({}),"function"==typeof define&&define.amd&&define([],function(){return n.hljs}))}(function(e){function n(e){return e.replace(/[&<>]/gm,function(e){return I[e]})}function t(e){return e.nodeName.toLowerCase()}function r(e,n){var t=e&&e.exec(n);return t&&0===t.index}function a(e){return k.test(e)}function i(e){var n,t,r,i,o=e.className+" ";if(o+=e.parentNode?e.parentNode.className:"",t=B.exec(o))return R(t[1])?t[1]:"no-highlight";for(o=o.split(/\s+/),n=0,r=o.length;r>n;n++)if(i=o[n],a(i)||R(i))return i}function o(e,n){var t,r={};for(t in e)r[t]=e[t];if(n)for(t in n)r[t]=n[t];return r}function u(e){var n=[];return function r(e,a){for(var i=e.firstChild;i;i=i.nextSibling)3===i.nodeType?a+=i.nodeValue.length:1===i.nodeType&&(n.push({event:"start",offset:a,node:i}),a=r(i,a),t(i).match(/br|hr|img|input/)||n.push({event:"stop",offset:a,node:i}));return a}(e,0),n}function c(e,r,a){function i(){return e.length&&r.length?e[0].offset!==r[0].offset?e[0].offset<r[0].offset?e:r:"start"===r[0].event?e:r:e.length?e:r}function o(e){function r(e){return" "+e.nodeName+'="'+n(e.value)+'"'}l+="<"+t(e)+w.map.call(e.attributes,r).join("")+">"}function u(e){l+="</"+t(e)+">"}function c(e){("start"===e.event?o:u)(e.node)}for(var s=0,l="",f=[];e.length||r.length;){var g=i();if(l+=n(a.substr(s,g[0].offset-s)),s=g[0].offset,g===e){f.reverse().forEach(u);do c(g.splice(0,1)[0]),g=i();while(g===e&&g.length&&g[0].offset===s);f.reverse().forEach(o)}else"start"===g[0].event?f.push(g[0].node):f.pop(),c(g.splice(0,1)[0])}return l+n(a.substr(s))}function s(e){function n(e){return e&&e.source||e}function t(t,r){return new RegExp(n(t),"m"+(e.cI?"i":"")+(r?"g":""))}function r(a,i){if(!a.compiled){if(a.compiled=!0,a.k=a.k||a.bK,a.k){var u={},c=function(n,t){e.cI&&(t=t.toLowerCase()),t.split(" ").forEach(function(e){var t=e.split("|");u[t[0]]=[n,t[1]?Number(t[1]):1]})};"string"==typeof a.k?c("keyword",a.k):E(a.k).forEach(function(e){c(e,a.k[e])}),a.k=u}a.lR=t(a.l||/\w+/,!0),i&&(a.bK&&(a.b="\\b("+a.bK.split(" ").join("|")+")\\b"),a.b||(a.b=/\B|\b/),a.bR=t(a.b),a.e||a.eW||(a.e=/\B|\b/),a.e&&(a.eR=t(a.e)),a.tE=n(a.e)||"",a.eW&&i.tE&&(a.tE+=(a.e?"|":"")+i.tE)),a.i&&(a.iR=t(a.i)),null==a.r&&(a.r=1),a.c||(a.c=[]);var s=[];a.c.forEach(function(e){e.v?e.v.forEach(function(n){s.push(o(e,n))}):s.push("self"===e?a:e)}),a.c=s,a.c.forEach(function(e){r(e,a)}),a.starts&&r(a.starts,i);var l=a.c.map(function(e){return e.bK?"\\.?("+e.b+")\\.?":e.b}).concat([a.tE,a.i]).map(n).filter(Boolean);a.t=l.length?t(l.join("|"),!0):{exec:function(){return null}}}}r(e)}function l(e,t,a,i){function o(e,n){var t,a;for(t=0,a=n.c.length;a>t;t++)if(r(n.c[t].bR,e))return n.c[t]}function u(e,n){if(r(e.eR,n)){for(;e.endsParent&&e.parent;)e=e.parent;return e}return e.eW?u(e.parent,n):void 0}function c(e,n){return!a&&r(n.iR,e)}function g(e,n){var t=N.cI?n[0].toLowerCase():n[0];return e.k.hasOwnProperty(t)&&e.k[t]}function h(e,n,t,r){var a=r?"":y.classPrefix,i='<span class="'+a,o=t?"":C;return i+=e+'">',i+n+o}function p(){var e,t,r,a;if(!E.k)return n(B);for(a="",t=0,E.lR.lastIndex=0,r=E.lR.exec(B);r;)a+=n(B.substr(t,r.index-t)),e=g(E,r),e?(M+=e[1],a+=h(e[0],n(r[0]))):a+=n(r[0]),t=E.lR.lastIndex,r=E.lR.exec(B);return a+n(B.substr(t))}function d(){var e="string"==typeof E.sL;if(e&&!x[E.sL])return n(B);var t=e?l(E.sL,B,!0,L[E.sL]):f(B,E.sL.length?E.sL:void 0);return E.r>0&&(M+=t.r),e&&(L[E.sL]=t.top),h(t.language,t.value,!1,!0)}function b(){k+=null!=E.sL?d():p(),B=""}function v(e){k+=e.cN?h(e.cN,"",!0):"",E=Object.create(e,{parent:{value:E}})}function m(e,n){if(B+=e,null==n)return b(),0;var t=o(n,E);if(t)return t.skip?B+=n:(t.eB&&(B+=n),b(),t.rB||t.eB||(B=n)),v(t,n),t.rB?0:n.length;var r=u(E,n);if(r){var a=E;a.skip?B+=n:(a.rE||a.eE||(B+=n),b(),a.eE&&(B=n));do E.cN&&(k+=C),E.skip||(M+=E.r),E=E.parent;while(E!==r.parent);return r.starts&&v(r.starts,""),a.rE?0:n.length}if(c(n,E))throw new Error('Illegal lexeme "'+n+'" for mode "'+(E.cN||"<unnamed>")+'"');return B+=n,n.length||1}var N=R(e);if(!N)throw new Error('Unknown language: "'+e+'"');s(N);var w,E=i||N,L={},k="";for(w=E;w!==N;w=w.parent)w.cN&&(k=h(w.cN,"",!0)+k);var B="",M=0;try{for(var I,j,O=0;;){if(E.t.lastIndex=O,I=E.t.exec(t),!I)break;j=m(t.substr(O,I.index-O),I[0]),O=I.index+j}for(m(t.substr(O)),w=E;w.parent;w=w.parent)w.cN&&(k+=C);return{r:M,value:k,language:e,top:E}}catch(T){if(T.message&&-1!==T.message.indexOf("Illegal"))return{r:0,value:n(t)};throw T}}function f(e,t){t=t||y.languages||E(x);var r={r:0,value:n(e)},a=r;return t.filter(R).forEach(function(n){var t=l(n,e,!1);t.language=n,t.r>a.r&&(a=t),t.r>r.r&&(a=r,r=t)}),a.language&&(r.second_best=a),r}function g(e){return y.tabReplace||y.useBR?e.replace(M,function(e,n){return y.useBR&&"\n"===e?"<br>":y.tabReplace?n.replace(/\t/g,y.tabReplace):void 0}):e}function h(e,n,t){var r=n?L[n]:t,a=[e.trim()];return e.match(/\bhljs\b/)||a.push("hljs"),-1===e.indexOf(r)&&a.push(r),a.join(" ").trim()}function p(e){var n,t,r,o,s,p=i(e);a(p)||(y.useBR?(n=document.createElementNS("http://www.w3.org/1999/xhtml","div"),n.innerHTML=e.innerHTML.replace(/\n/g,"").replace(/<br[ \/]*>/g,"\n")):n=e,s=n.textContent,r=p?l(p,s,!0):f(s),t=u(n),t.length&&(o=document.createElementNS("http://www.w3.org/1999/xhtml","div"),o.innerHTML=r.value,r.value=c(t,u(o),s)),r.value=g(r.value),e.innerHTML=r.value,e.className=h(e.className,p,r.language),e.result={language:r.language,re:r.r},r.second_best&&(e.second_best={language:r.second_best.language,re:r.second_best.r}))}function d(e){y=o(y,e)}function b(){if(!b.called){b.called=!0;var e=document.querySelectorAll("pre code");w.forEach.call(e,p)}}function v(){addEventListener("DOMContentLoaded",b,!1),addEventListener("load",b,!1)}function m(n,t){var r=x[n]=t(e);r.aliases&&r.aliases.forEach(function(e){L[e]=n})}function N(){return E(x)}function R(e){return e=(e||"").toLowerCase(),x[e]||x[L[e]]}var w=[],E=Object.keys,x={},L={},k=/^(no-?highlight|plain|text)$/i,B=/\blang(?:uage)?-([\w-]+)\b/i,M=/((^(<[^>]+>|\t|)+|(?:\n)))/gm,C="</span>",y={classPrefix:"hljs-",tabReplace:null,useBR:!1,languages:void 0},I={"&":"&amp;","<":"&lt;",">":"&gt;"};return e.highlight=l,e.highlightAuto=f,e.fixMarkup=g,e.highlightBlock=p,e.configure=d,e.initHighlighting=b,e.initHighlightingOnLoad=v,e.registerLanguage=m,e.listLanguages=N,e.getLanguage=R,e.inherit=o,e.IR="[a-zA-Z]\\w*",e.UIR="[a-zA-Z_]\\w*",e.NR="\\b\\d+(\\.\\d+)?",e.CNR="(-?)(\\b0[xX][a-fA-F0-9]+|(\\b\\d+(\\.\\d*)?|\\.\\d+)([eE][-+]?\\d+)?)",e.BNR="\\b(0b[01]+)",e.RSR="!|!=|!==|%|%=|&|&&|&=|\\*|\\*=|\\+|\\+=|,|-|-=|/=|/|:|;|<<|<<=|<=|<|===|==|=|>>>=|>>=|>=|>>>|>>|>|\\?|\\[|\\{|\\(|\\^|\\^=|\\||\\|=|\\|\\||~",e.BE={b:"\\\\[\\s\\S]",r:0},e.ASM={cN:"string",b:"'",e:"'",i:"\\n",c:[e.BE]},e.QSM={cN:"string",b:'"',e:'"',i:"\\n",c:[e.BE]},e.PWM={b:/\b(a|an|the|are|I'm|isn't|don't|doesn't|won't|but|just|should|pretty|simply|enough|gonna|going|wtf|so|such|will|you|your|like)\b/},e.C=function(n,t,r){var a=e.inherit({cN:"comment",b:n,e:t,c:[]},r||{});return a.c.push(e.PWM),a.c.push({cN:"doctag",b:"(?:TODO|FIXME|NOTE|BUG|XXX):",r:0}),a},e.CLCM=e.C("//","$"),e.CBCM=e.C("/\\*","\\*/"),e.HCM=e.C("#","$"),e.NM={cN:"number",b:e.NR,r:0},e.CNM={cN:"number",b:e.CNR,r:0},e.BNM={cN:"number",b:e.BNR,r:0},e.CSSNM={cN:"number",b:e.NR+"(%|em|ex|ch|rem|vw|vh|vmin|vmax|cm|mm|in|pt|pc|px|deg|grad|rad|turn|s|ms|Hz|kHz|dpi|dpcm|dppx)?",r:0},e.RM={cN:"regexp",b:/\//,e:/\/[gimuy]*/,i:/\n/,c:[e.BE,{b:/\[/,e:/\]/,r:0,c:[e.BE]}]},e.TM={cN:"title",b:e.IR,r:0},e.UTM={cN:"title",b:e.UIR,r:0},e.METHOD_GUARD={b:"\\.\\s*"+e.UIR,r:0},e});hljs.registerLanguage("php",function(e){var c={b:"\\$+[a-zA-Z_-ÿ][a-zA-Z0-9_-ÿ]*"},i={cN:"meta",b:/<\?(php)?|\?>/},t={cN:"string",c:[e.BE,i],v:[{b:'b"',e:'"'},{b:"b'",e:"'"},e.inherit(e.ASM,{i:null}),e.inherit(e.QSM,{i:null})]},a={v:[e.BNM,e.CNM]};return{aliases:["php3","php4","php5","php6, php7"],cI:!0,k:"and include_once list abstract global private echo interface as static endswitch array null if endwhile or const for endforeach self var while isset public protected exit foreach throw elseif include __FILE__ empty require_once do xor return parent clone use __CLASS__ __LINE__ else break print eval new catch __METHOD__ case exception default die require __FUNCTION__ enddeclare final try switch continue endfor endif declare unset true false trait goto instanceof insteadof __DIR__ __NAMESPACE__ yield finally",c:[e.HCM,e.C("//","$",{c:[i]}),e.C("/\\*","\\*/",{c:[{cN:"doctag",b:"@[A-Za-z]+"}]}),e.C("__halt_compiler.+?;",!1,{eW:!0,k:"__halt_compiler",l:e.UIR}),{cN:"string",b:/<<<['"]?\w+['"]?$/,e:/^\w+;?$/,c:[e.BE,{cN:"subst",v:[{b:/\$\w+/},{b:/\{\$/,e:/\}/}]}]},i,{cN:"keyword",b:/\$this\b/},c,{b:/(::|->)+[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*/},{cN:"function",bK:"function",e:/[;{]/,eE:!0,i:"\\$|\\[|%",c:[e.UTM,{cN:"params",b:"\\(",e:"\\)",c:["self",c,e.CBCM,t,a]}]},{cN:"class",bK:"class interface",e:"{",eE:!0,i:/[:\(\$"]/,c:[{bK:"extends implements"},e.UTM]},{bK:"namespace",e:";",i:/[\.']/,c:[e.UTM]},{bK:"use",e:";",c:[e.UTM]},{b:"=>"},t,a]}});;WPUSB( 'WPUSB.Application', function(Application, $) {

	Application.init = function(container) {
		WPUSB.BuildComponents.create( container );
		WPUSB.ColorPicker.create( container );
		Application.highlight( container );
	};

	Application.highlight = function(container) {
		container.byElement( 'highlight' ).each(function(i, block) {
			hljs.highlightBlock( block );
		});
	};

}, {} );;WPUSB( 'WPUSB.ColorPicker', function(Model, $) {

	Model.create = function(container) {
		this.init();
	};

	Model.init = function() {
		this.renderColorPicker();
	};

	Model.renderColorPicker = function() {
		var className = '.' + this.utils.prefix + '-colorpicker'
		  , options   = {
		    change: this._onChangeColorPicker.bind( this )
		};

		$( className ).wpColorPicker( options );
	};

	Model._onChangeColorPicker = function(event, ui) {
		event.preventDefault();
		this.activePreview( event.target );

		var color   = ui.color.toString()
    	  , element = event.target.dataset.element
    	  , item    = $( '[data-item="' + element + '"]' )
    	  , layout  = $( '[data-preview-layout]' ).data( 'preview-layout' )
    	  , style   = event.target.dataset.style
    	;

    	if ( !item.length ) {
    		return;
    	}

    	switch ( layout ) {
    		case 'buttons':
    			this.styleCountPseudo( element, style, color );
    			this.styleShadow( element, color );
    			this.setItemColorBg( item, style, color );
    			return;

    		case 'square-plus':
    			this.styleShadow( element, color );
    			this.setItemColorBg( item, style, color );
    			return;

    		case 'default':
    		case 'rounded':
    		case 'square' :
    			this.styleCountPseudo( element, style, color );
    			this.setItemColor( item, style, color, element );
    			break;

    		case 'fixed-left':
    		case 'fixed-right':
    			this.styleCountPseudo( element, style, color );
    			this.setItemColorBg( item, style, color );
    			return;
    	}
    };

    Model.setItemColorBg = function(item, style, color) {
    	item.css( style, color );
    };

    Model.setItemColor = function(item, style, color, element) {
    	if ( style !== 'color' && element !== 'text' ) {
    		return;
    	}

    	item.css( style, color );
    };

    Model.activePreview = function(target) {
    	if ( $( '[data-element="preview"]' ).hasClass( 'preview-active' ) ) {
    		return;
    	}

    	$( '.wpusb-layout-options input:checked' ).click();
    };

    Model.styleCountPseudo = function(element, style, color) {
    	if ( !( element === 'text' && style === 'background-color' ) ) {
    		return;
    	}

		var styles = '.wpusb-count:after{border-color:transparent ' + color + ' transparent transparent}';
		$( '[data-element-style]' ).text( styles );    	
    };

    Model.styleShadow = function(element, color) {
    	if ( element !== 'bg-color' ) {
    		return;
    	}

		$( '.wpusb-button, .wpusb-link' ).css( 'box-shadow', '0 2px ' + color );    	
    };

}, {} );;WPUSB( 'WPUSB.Components.CustomCss', function(Model, $) {

	Model.fn.start = function() {
		this.init();
	};

	Model.fn.init = function() {
		this.addNotice();
		this.setCodeMirror();
		this.addEventListener();
		this.setSize();
	};

	Model.fn.addNotice = function() {
		if ( ~window.location.href.indexOf( '#save-success' ) ) {
			$( '#updated-notice' ).show();
			window.location.hash = '';
		}
	};

	Model.fn.setCodeMirror = function() {
		this.codeMirror = CodeMirror.fromTextArea( this.elements.cssField.get(0), {
			lineNumbers       : true,
			lineWrapping      : true,
			mode              : 'css',
			theme             : 'seti',
			autoCloseBrackets : true,
			styleActiveLine   : true,
			matchBrackets     : true,
			showTrailingSpace : true,
			gutters           : ['CodeMirror-linenumbers']
		});
	};

	Model.fn.addEventListener = function() {
		this.codeMirror.on( 'keyup', this._onKeyupCodeMirror.bind( this ) );
		this.$el.addEvent( 'click', 'save-custom-css', this );
	};

	Model.fn.setSize = function() {
		var height = ( window.innerHeight - 300 );
		this.codeMirror.setSize( '100%', height );
	};

	Model.fn._onKeyupCodeMirror = function(cm, event) {
		var keyCode = event.keyCode;

		if ( keyCode >= 65 && keyCode <= 95 ) {
			CodeMirror.showHint( cm, CodeMirror.hint.css, { completeSingle : true } );
		}
	};

	Model.fn._onClickSaveCustomCss = function(event) {
		this.elements.btnSave.prop( 'disabled', true );
		this.elements.spinner.addClass( 'ajax-spinner-visible' );
		this.elements.error.text('');

		event.preventDefault();
		this.request();
	};

	Model.fn.request = function() {
		var params = {
			action     : this.utils.prefix + '_save_custom_css',
			custom_css : this.codeMirror.getValue(),
		};

		var ajax = $.ajax({
			type : 'POST',
			url  : this.utils.getAjaxUrl(),
			data : params
		});

		ajax.then( $.proxy( this, '_done' ), $.proxy( this, '_fail' ) );
	};

	Model.fn._done = function(response) {
		this.clear();

		if ( response.success ) {
			window.location.hash = 'save-success';
			window.location.reload(true);
			return;
		}

		this.elements.error.text( response.data );
	};

	Model.fn._fail = function(xhr, status, thrownError) {
		this.clear();
	};

	Model.fn.clear = function() {
		this.elements.btnSave.prop( 'disabled', false );
		this.elements.spinner.removeClass( 'ajax-spinner-visible' );
	};

});;WPUSB( 'WPUSB.Components.SharePreview', function(Model, $) {

	var SPINNER   = '<span class="ajax-spinner" style="visibility:visible">loading...</span>'
	  , CLOSE_BTN = '<button class="button wpusb-preview-close" data-action="preview-close">x</button>'
	;

	Model.fn.start = function() {
		this.spinner       = $( '.ajax-spinner' );
		this.prefix        = this.utils.prefix;
		this.wrap          = this.$el.closest( '.wpusb-wrap' );
		this.order         = this.wrap.byElement( 'sortable' );
		this.inputOrder    = this.wrap.byElement( 'order' );
		this.layoutOptions = $( '.layout-preview' );
		this.list          = $( '.wpusb-select-item input' );
		this.init();
	};

	Model.fn.init = function() {
		this.addEventListener();
	};

	Model.fn.addEventListener = function() {
		this.layoutOptions.on( 'click', this._onClickLayout.bind( this ) );
		this.list.on( 'click', this._onClick.bind( this ) );
		this.order.sortable( this.sortOptions() );
	};

	Model.fn._onClickLayout = function(event) {
		this.layout = event.currentTarget.value;

		if ( event.currentTarget.className.match( 'fixed-layout' ) ) {
			this.layout = $( '[data-element="position-fixed"]:checked' ).val();
		}

		$( '.' + this.prefix + '-layout-options' ).trigger( 'changeLayout', this.layout );

		this._onClick();
	};

	Model.fn._onClick = function(event) {
		if ( event ) {
			this.layout = $( '.layout-preview:checked' ).val();
		}

		this._update();
		this._stop();
	};

	Model.fn.sortOptions = function() {
		return {
			opacity     : 0.5,
			cursor      : 'move',
			tolerance   : 'pointer',
			items       : '> td',
			placeholder : this.prefix + '-highlight',
	        update      : this._update.bind( this ),
	        stop        : this._stop.bind( this )
		};
	};

	Model.fn._update = function(event, ui) {
		if ( ui ) {
			this.layout = $( '.layout-preview:checked' ).val();
		}

		var order = this.order.sortable( 'toArray' );
		this.inputOrder.val( JSON.stringify( order ) );
	};

	Model.fn._stop = function(event, ui) {
		this.itemsChecked = [];

		this.each( this.order.find( 'input:checked' ) );
		this.request();
	};

	Model.fn.each = function(items) {
		var self = this;

	    items.each(function(index, item) {
	    	self.itemsChecked.push( item.value );
	    });
	};

	Model.fn.request = function() {
		this.elements
			.preview
			.addClass( this.prefix + '-preview-container preview-active' )
			.append( SPINNER );

		var fixed_layout = $( '.fixed-layout:checked' )
		  , params       = {
				action       : 'wpusb_share_preview',
				layout       : this.layout,
			    fixed_layout : fixed_layout.val(),
				checked      : JSON.stringify( this.itemsChecked )
			}
		;

		var ajax = $.ajax({
			type     : 'POST',
			url      : this.utils.getAjaxUrl(),
			data     : params,
			dataType : 'json'
		});

		ajax.then( $.proxy( this, '_done' ), $.proxy( this, '_fail' ) );
	};

	Model.fn._done = function(response) {
		this.elements.preview.html( this.render( response ) ).append( CLOSE_BTN );
		WPUSB.Preview.create( this.$el, this.elements.preview );
	};

	Model.fn._fail = function(xhr, status, thrownError) {

	};

	Model.fn.render = function(response) {
		return WPUSB.Templates[this.templateName()]
		            .call( null, response );
	};

	Model.fn.templateName = function() {
		var layout;

		switch ( this.layout ) {
			case 'square-plus' :
				layout = 'square-plus';
				break;

			case 'fixed-left'  :
			case 'fixed-right' :
				layout = 'fixed';
				break;

			default:
				layout = 'share-preview';
		}

		return layout;
	};

});;WPUSB( 'WPUSB.Components.ShareSettings', function(Model, $) {

	Model.fn.start = function() {
		this.init();
	};

	Model.fn.init = function() {
		this.addEventListener();
	};

	Model.fn.addEventListener = function() {
		this.elements.positionFixed.on( 'change', this._onChangeFixedLeft.bind( this ) );
		this.$el.addEvent( 'click', 'fixed-disabled', this );
		this.$el.addEvent( 'change', 'fixed-layout', this );
		this.$el.addEvent( 'keyup', 'fixed-label', this );
		this.$el.addEvent( 'keyup', 'plus-share-label', this );
		this.$el.addEvent( 'focus', 'plus-share-label', this );
		this.$el.addEvent( 'change', 'primary-layout', this );
	};

	Model.fn._onChangeFixedLeft = function(event) {
		if ( this.elements.positionFixed.is( ':checked' ) ) {
			this.elements.fixed.val( 'on' );
			this.elements.trFixedLayout.fadeIn();
			this.setLabel();
			return;
		}

		this.clear();
	};

	Model.fn._onChangeFixedLayout = function(event) {
		this.activeLabel( event.currentTarget.value );
	};

	Model.fn._onKeyupFixedLabel = function(event) {
		var value = event.currentTarget.value
		  , label = $( '[data-element="fixed-label-text"]' )
		;

		if ( value ) {
			return label.text( value );
		}

		label.text( 'SHARES' );
	};

	Model.fn._onKeyupPlusShareLabel = function(event) {
		var value = event.currentTarget.value
		  , label = $( '[data-element="square-plus-text"]' )
		;

		if ( value ) {
			return label.attr({ 'data-title': value });
		}

		label.attr({ 'data-title': 'SHARES' });
	};

	Model.fn._onFocusPlusShareLabel = function(event) {
		$( '#' + this.utils.prefix + '-square-plus' ).click();
	};

	Model.fn._onChangePrimaryLayout = function(event) {
		var squarePlus     = 'fadeOut'
		  , countBgColor   = 'fadeOut'
		  , buttonsBgColor = 'fadeOut'
		;

		switch ( event.currentTarget.value ) {
			case 'buttons' :
				countBgColor   = 'fadeIn';
				buttonsBgColor = 'fadeIn';
				break;

			case 'default' :
			case 'rounded' :
			case 'square'  :
				countBgColor   = 'fadeIn';
				break;

			case 'square-plus' :
				squarePlus     = 'fadeIn';
				buttonsBgColor = 'fadeIn';
				break;
		}

		this.elements.trButtonBgColor[buttonsBgColor]();
		this.elements.trShareCountBgColor[countBgColor]();
		this.elements.trSharePlusLabel[squarePlus]();
	};

	Model.fn._onClickFixedDisabled = function(event) {
		this.clear();
	};

	Model.fn.clear = function() {
		this.elements.positionFixed.prop( 'checked', false );
		this.elements.fixed.val( '' );
		this.elements.trFixedLayout.fadeOut().find( '.fixed-layout' ).prop( 'checked', false );
		this.elements.trFixedLabel.fadeOut();
		$( '[data-action="preview-close"]' ).click();
	};

	Model.fn.setLabel = function() {
		var label = this.elements.trFixedLayout
		  , field = label.find( 'input' )
		;

		if ( !field.is( ':checked' ) ) {
			$( field.get(0) ).prop( 'checked', true );
		}

		this.activeLabel( label.find( 'input:checked' ).val() );
	};

	Model.fn.activeLabel = function(value) {
		if ( value === 'default' ) {
			return this.elements.trFixedLabel.fadeIn();
		}

		this.elements.trFixedLabel.fadeOut();
	};

});;WPUSB( 'WPUSB.Preview', function(Model, $) {

	Model.create = function(container, preview) {
		this.$el     = container;
		this.preview = preview;
		this.title   = $( '[data-action="no-title"]' );
		this.counter = $( '[data-action="no-counter"]' );
		this.titles  = this.utils.getPreviewTitles();
		this.init();
	};

	Model.init = function() {
		this.addEventListener();
	};

	Model.addEventListener = function() {
		this.title.text( this.titles.titleRemove );
		this.counter.text( this.titles.counterRemove );
		this.$el.addEvent( 'click', 'preview-close', this );
		this.title.on( 'click', this._onClickTitle.bind( this ) );
		this.counter.on( 'click', this._onClickCounter.bind( this ) );
	};

	Model._onClickPreviewClose = function(event) {
		event.preventDefault();
		this.preview.attr( 'class', '' ).empty();
	};

	Model._onClickTitle = function(event) {
		event.preventDefault();
		var text = this.titleChangeText( this.title.text() );
		this.title.text( text );
		$( '.wpusb-title' ).toggle( 'fast' );
	};

	Model._onClickCounter = function(event) {
		event.preventDefault();
		var text = this.counterChangeText( this.counter.text() );
		this.counter.text( text );
		$( '.wpusb-counter' ).toggle( 'fast' );
	};

	Model.counterChangeText = function(text) {
		if ( text == this.titles.counterRemove ) {
			return this.titles.counterInsert;
		}

		return this.titles.counterRemove;
	};

	Model.titleChangeText = function(text) {
		if ( text == this.titles.titleRemove ) {
			return this.titles.titleInsert;
		}

		return this.titles.titleRemove;
	};

}, {} );;WPUSB( 'WPUSB.Sortable', function(Model, $) {

	Model.create = function(container) {
		if ( !container.length ) {
			return;
		}

		this.element = container;
		this.init();
	};

	Model.init = function() {
		this.element.sortable( this.sortOptions() );
	};

	Model.sortOptions = function() {
		return {
			opacity     : 0.4,
			cursor      : 'move',
			tolerance   : 'pointer',
			items       : '> td',
			placeholder : this.utils.prefix + '-sortable-placeholder',
		};
	};

}, {} );;jQuery(function($) {
	var context = $( 'body' );

	WPUSB.vars = {
		  body   : context
		, prefix : 'wpusb'
	};

	WPUSB.Application.init.apply( WPUSB.utils, [context] );
});