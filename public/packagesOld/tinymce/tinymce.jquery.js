// 4.2.6 (2015-09-28)

/**
 * Compiled inline version. (Library mode)
 */

/*jshint smarttabs:true, undef:true, latedef:true, curly:true, bitwise:true, camelcase:true */
/*globals $code */

(function(exports, undefined) {
	"use strict";

	var modules = {};

	function require(ids, callback) {
		var module, defs = [];

		for (var i = 0; i < ids.length; ++i) {
			module = modules[ids[i]] || resolve(ids[i]);
			if (!module) {
				throw 'module definition dependecy not found: ' + ids[i];
			}

			defs.push(module);
		}

		callback.apply(null, defs);
	}

	function define(id, dependencies, definition) {
		if (typeof id !== 'string') {
			throw 'invalid module definition, module id must be defined and be a string';
		}

		if (dependencies === undefined) {
			throw 'invalid module definition, dependencies must be specified';
		}

		if (definition === undefined) {
			throw 'invalid module definition, definition function must be specified';
		}

		require(dependencies, function() {
			modules[id] = definition.apply(null, arguments);
		});
	}

	function defined(id) {
		return !!modules[id];
	}

	function resolve(id) {
		var target = exports;
		var fragments = id.split(/[.\/]/);

		for (var fi = 0; fi < fragments.length; ++fi) {
			if (!target[fragments[fi]]) {
				return;
			}

			target = target[fragments[fi]];
		}

		return target;
	}

	function expose(ids) {
		var i, target, id, fragments, privateModules;

		for (i = 0; i < ids.length; i++) {
			target = exports;
			id = ids[i];
			fragments = id.split(/[.\/]/);

			for (var fi = 0; fi < fragments.length - 1; ++fi) {
				if (target[fragments[fi]] === undefined) {
					target[fragments[fi]] = {};
				}

				target = target[fragments[fi]];
			}

			target[fragments[fragments.length - 1]] = modules[id];
		}
		
		// Expose private modules for unit tests
		if (exports.AMDLC_TESTS) {
			privateModules = exports.privateModules || {};

			for (id in modules) {
				privateModules[id] = modules[id];
			}

			for (i = 0; i < ids.length; i++) {
				delete privateModules[ids[i]];
			}

			exports.privateModules = privateModules;
		}
	}

// Included from: js/tinymce/classes/dom/EventUtils.js

/**
 * EventUtils.js
 *
 * Released under LGPL License.
 * Copyright (c) 1999-2015 Ephox Corp. All rights reserved
 *
 * License: http://www.tinymce.com/license
 * Contributing: http://www.tinymce.com/contributing
 */

/*jshint loopfunc:true*/
/*eslint no-loop-func:0 */

/**
 * This class wraps the browsers native event logic with more convenient methods.
 *
 * @class tinymce.dom.EventUtils
 */
define("tinymce/dom/EventUtils", [], function() {
	"use strict";

	var eventExpandoPrefix = "mce-data-";
	var mouseEventRe = /^(?:mouse|contextmenu)|click/;
	var deprecated = {keyLocation: 1, layerX: 1, layerY: 1, returnValue: 1, webkitMovementX: 1, webkitMovementY: 1};

	/**
	 * Binds a native event to a callback on the speified target.
	 */
	function addEvent(target, name, callback, capture) {
		if (target.addEventListener) {
			target.addEventListener(name, callback, capture || false);
		} else if (target.attachEvent) {
			target.attachEvent('on' + name, callback);
		}
	}

	/**
	 * Unbinds a native event callback on the specified target.
	 */
	function removeEvent(target, name, callback, capture) {
		if (target.removeEventListener) {
			target.removeEventListener(name, callback, capture || false);
		} else if (target.detachEvent) {
			target.detachEvent('on' + name, callback);
		}
	}

	/**
	 * Normalizes a native event object or just adds the event specific methods on a custom event.
	 */
	function fix(originalEvent, data) {
		var name, event = data || {}, undef;

		// Dummy function that gets replaced on the delegation state functions
		function returnFalse() {
			return false;
		}

		// Dummy function that gets replaced on the delegation state functions
		function returnTrue() {
			return true;
		}

		// Copy all properties from the original event
		for (name in originalEvent) {
			// layerX/layerY is deprecated in Chrome and produces a warning
			if (!deprecated[name]) {
				event[name] = originalEvent[name];
			}
		}

		// Normalize target IE uses srcElement
		if (!event.target) {
			event.target = event.srcElement || document;
		}

		// Calculate pageX/Y if missing and clientX/Y available
		if (originalEvent && mouseEventRe.test(originalEvent.type) && originalEvent.pageX === undef && originalEvent.clientX !== undef) {
			var eventDoc = event.target.ownerDocument || document;
			var doc = eventDoc.documentElement;
			var body = eventDoc.body;

			event.pageX = originalEvent.clientX + (doc && doc.scrollLeft || body && body.scrollLeft || 0) -
				(doc && doc.clientLeft || body && body.clientLeft || 0);

			event.pageY = originalEvent.clientY + (doc && doc.scrollTop || body && body.scrollTop || 0) -
				(doc && doc.clientTop || body && body.clientTop || 0);
		}

		// Add preventDefault method
		event.preventDefault = function() {
			event.isDefaultPrevented = returnTrue;

			// Execute preventDefault on the original event object
			if (originalEvent) {
				if (originalEvent.preventDefault) {
					originalEvent.preventDefault();
				} else {
					originalEvent.returnValue = false; // IE
				}
			}
		};

		// Add stopPropagation
		event.stopPropagation = function() {
			event.isPropagationStopped = returnTrue;

			// Execute stopPropagation on the original event object
			if (originalEvent) {
				if (originalEvent.stopPropagation) {
					originalEvent.stopPropagation();
				} else {
					originalEvent.cancelBubble = true; // IE
				}
			}
		};

		// Add stopImmediatePropagation
		event.stopImmediatePropagation = function() {
			event.isImmediatePropagationStopped = returnTrue;
			event.stopPropagation();
		};

		// Add event delegation states
		if (!event.isDefaultPrevented) {
			event.isDefaultPrevented = returnFalse;
			event.isPropagationStopped = returnFalse;
			event.isImmediatePropagationStopped = returnFalse;
		}

		// Add missing metaKey for IE 8
		if (typeof event.metaKey == 'undefined') {
			event.metaKey = false;
		}

		return event;
	}

	/**
	 * Bind a DOMContentLoaded event across browsers and executes the callback once the page DOM is initialized.
	 * It will also set/check the domLoaded state of the event_utils instance so ready isn't called multiple times.
	 */
	function bindOnReady(win, callback, eventUtils) {
		var doc = win.document, event = {type: 'ready'};

		if (eventUtils.domLoaded) {
			callback(event);
			return;
		}

		// Gets called when the DOM is ready
		function readyHandler() {
			if (!eventUtils.domLoaded) {
				eventUtils.domLoaded = true;
				callback(event);
			}
		}

		function waitForDomLoaded() {
			// Check complete or interactive state if there is a body
			// element on some iframes IE 8 will produce a null body
			if (doc.readyState === "complete" || (doc.readyState === "interactive" && doc.body)) {
				removeEvent(doc, "readystatechange", waitForDomLoaded);
				readyHandler();
			}
		}

		function tryScroll() {
			try {
				// If IE is used, use the trick by Diego Perini licensed under MIT by request to the author.
				// http://javascript.nwbox.com/IEContentLoaded/
				doc.documentElement.doScroll("left");
			} catch (ex) {
				setTimeout(tryScroll, 0);
				return;
			}

			readyHandler();
		}

		// Use W3C method
		if (doc.addEventListener) {
			if (doc.readyState === "complete") {
				readyHandler();
			} else {
				addEvent(win, 'DOMContentLoaded', readyHandler);
			}
		} else {
			// Use IE method
			addEvent(doc, "readystatechange", waitForDomLoaded);

			// Wait until we can scroll, when we can the DOM is initialized
			if (doc.documentElement.doScroll && win.self === win.top) {
				tryScroll();
			}
		}

		// Fallback if any of the above methods should fail for some odd reason
		addEvent(win, 'load', readyHandler);
	}

	/**
	 * This class enables you to bind/unbind native events to elements and normalize it's behavior across browsers.
	 */
	function EventUtils() {
		var self = this, events = {}, count, expando, hasFocusIn, hasMouseEnterLeave, mouseEnterLeave;

		expando = eventExpandoPrefix + (+new Date()).toString(32);
		hasMouseEnterLeave = "onmouseenter" in document.documentElement;
		hasFocusIn = "onfocusin" in document.documentElement;
		mouseEnterLeave = {mouseenter: 'mouseover', mouseleave: 'mouseout'};
		count = 1;

		// State if the DOMContentLoaded was executed or not
		self.domLoaded = false;
		self.events = events;

		/**
		 * Executes all event handler callbacks for a specific event.
		 *
		 * @private
		 * @param {Event} evt Event object.
		 * @param {String} id Expando id value to look for.
		 */
		function executeHandlers(evt, id) {
			var callbackList, i, l, callback, container = events[id];

			callbackList = container && container[evt.type];
			if (callbackList) {
				for (i = 0, l = callbackList.length; i < l; i++) {
					callback = callbackList[i];

					// Check if callback exists might be removed if a unbind is called inside the callback
					if (callback && callback.func.call(callback.scope, evt) === false) {
						evt.preventDefault();
					}

					// Should we stop propagation to immediate listeners
					if (evt.isImmediatePropagationStopped()) {
						return;
					}
				}
			}
		}

		/**
		 * Binds a callback to an event on the specified target.
		 *
		 * @method bind
		 * @param {Object} target Target node/window or custom object.
		 * @param {String} names Name of the event to bind.
		 * @param {function} callback Callback function to execute when the event occurs.
		 * @param {Object} scope Scope to call the callback function on, defaults to target.
		 * @return {function} Callback function that got bound.
		 */
		self.bind = function(target, names, callback, scope) {
			var id, callbackList, i, name, fakeName, nativeHandler, capture, win = window;

			// Native event handler function patches the event and executes the callbacks for the expando
			function defaultNativeHandler(evt) {
				executeHandlers(fix(evt || win.event), id);
			}

			// Don't bind to text nodes or comments
			if (!target || target.nodeType === 3 || target.nodeType === 8) {
				return;
			}

			// Create or get events id for the target
			if (!target[expando]) {
				id = count++;
				target[expando] = id;
				events[id] = {};
			} else {
				id = target[expando];
			}

			// Setup the specified scope or use the target as a default
			scope = scope || target;

			// Split names and bind each event, enables you to bind multiple events with one call
			names = names.split(' ');
			i = names.length;
			while (i--) {
				name = names[i];
				nativeHandler = defaultNativeHandler;
				fakeName = capture = false;

				// Use ready instead of DOMContentLoaded
				if (name === "DOMContentLoaded") {
					name = "ready";
				}

				// DOM is already ready
				if (self.domLoaded && name === "ready" && target.readyState == 'complete') {
					callback.call(scope, fix({type: name}));
					continue;
				}

				// Handle mouseenter/mouseleaver
				if (!hasMouseEnterLeave) {
					fakeName = mouseEnterLeave[name];

					if (fakeName) {
						nativeHandler = function(evt) {
							var current, related;

							current = evt.currentTarget;
							related = evt.relatedTarget;

							// Check if related is inside the current target if it's not then the event should
							// be ignored since it's a mouseover/mouseout inside the element
							if (related && current.contains) {
								// Use contains for performance
								related = current.contains(related);
							} else {
								while (related && related !== current) {
									related = related.parentNode;
								}
							}

							// Fire fake event
							if (!related) {
								evt = fix(evt || win.event);
								evt.type = evt.type === 'mouseout' ? 'mouseleave' : 'mouseenter';
								evt.target = current;
								executeHandlers(evt, id);
							}
						};
					}
				}

				// Fake bubbeling of focusin/focusout
				if (!hasFocusIn && (name === "focusin" || name === "focusout")) {
					capture = true;
					fakeName = name === "focusin" ? "focus" : "blur";
					nativeHandler = function(evt) {
						evt = fix(evt || win.event);
						evt.type = evt.type === 'focus' ? 'focusin' : 'focusout';
						executeHandlers(evt, id);
					};
				}

				// Setup callback list and bind native event
				callbackList = events[id][name];
				if (!callbackList) {
					events[id][name] = callbackList = [{func: callback, scope: scope}];
					callbackList.fakeName = fakeName;
					callbackList.capture = capture;
					//callbackList.callback = callback;

					// Add the nativeHandler to the callback list so that we can later unbind it
					callbackList.nativeHandler = nativeHandler;

					// Check if the target has native events support

					if (name === "ready") {
						bindOnReady(target, nativeHandler, self);
					} else {
						addEvent(target, fakeName || name, nativeHandler, capture);
					}
				} else {
					if (name === "ready" && self.domLoaded) {
						callback({type: name});
					} else {
						// If it already has an native handler then just push the callback
						callbackList.push({func: callback, scope: scope});
					}
				}
			}

			target = callbackList = 0; // Clean memory for IE

			return callback;
		};

		/**
		 * Unbinds the specified event by name, name and callback or all events on the target.
		 *
		 * @method unbind
		 * @param {Object} target Target node/window or custom object.
		 * @param {String} names Optional event name to unbind.
		 * @param {function} callback Optional callback function to unbind.
		 * @return {EventUtils} Event utils instance.
		 */
		self.unbind = function(target, names, callback) {
			var id, callbackList, i, ci, name, eventMap;

			// Don't bind to text nodes or comments
			if (!target || target.nodeType === 3 || target.nodeType === 8) {
				return self;
			}

			// Unbind event or events if the target has the expando
			id = target[expando];
			if (id) {
				eventMap = events[id];

				// Specific callback
				if (names) {
					names = names.split(' ');
					i = names.length;
					while (i--) {
						name = names[i];
						callbackList = eventMap[name];

						// Unbind the event if it exists in the map
						if (callbackList) {
							// Remove specified callback
							if (callback) {
								ci = callbackList.length;
								while (ci--) {
									if (callbackList[ci].func === callback) {
										var nativeHandler = callbackList.nativeHandler;
										var fakeName = callbackList.fakeName, capture = callbackList.capture;

										// Clone callbackList since unbind inside a callback would otherwise break the handlers loop
										callbackList = callbackList.slice(0, ci).concat(callbackList.slice(ci + 1));
										callbackList.nativeHandler = nativeHandler;
										callbackList.fakeName = fakeName;
										callbackList.capture = capture;

										eventMap[name] = callbackList;
									}
								}
							}

							// Remove all callbacks if there isn't a specified callback or there is no callbacks left
							if (!callback || callbackList.length === 0) {
								delete eventMap[name];
								removeEvent(target, callbackList.fakeName || name, callbackList.nativeHandler, callbackList.capture);
							}
						}
					}
				} else {
					// All events for a specific element
					for (name in eventMap) {
						callbackList = eventMap[name];
						removeEvent(target, callbackList.fakeName || name, callbackList.nativeHandler, callbackList.capture);
					}

					eventMap = {};
				}

				// Check if object is empty, if it isn't then we won't remove the expando map
				for (name in eventMap) {
					return self;
				}

				// Delete event object
				delete events[id];

				// Remove expando from target
				try {
					// IE will fail here since it can't delete properties from window
					delete target[expando];
				} catch (ex) {
					// IE will set it to null
					target[expando] = null;
				}
			}

			return self;
		};

		/**
		 * Fires the specified event on the specified target.
		 *
		 * @method fire
		 * @param {Object} target Target node/window or custom object.
		 * @param {String} name Event name to fire.
		 * @param {Object} args Optional arguments to send to the observers.
		 * @return {EventUtils} Event utils instance.
		 */
		self.fire = function(target, name, args) {
			var id;

			// Don't bind to text nodes or comments
			if (!target || target.nodeType === 3 || target.nodeType === 8) {
				return self;
			}

			// Build event object by patching the args
			args = fix(null, args);
			args.type = name;
			args.target = target;

			do {
				// Found an expando that means there is listeners to execute
				id = target[expando];
				if (id) {
					executeHandlers(args, id);
				}

				// Walk up the DOM
				target = target.parentNode || target.ownerDocument || target.defaultView || target.parentWindow;
			} while (target && !args.isPropagationStopped());

			return self;
		};

		/**
		 * Removes all bound event listeners for the specified target. This will also remove any bound
		 * listeners to child nodes within that target.
		 *
		 * @method clean
		 * @param {Object} target Target node/window object.
		 * @return {EventUtils} Event utils instance.
		 */
		self.clean = function(target) {
			var i, children, unbind = self.unbind;

			// Don't bind to text nodes or comments
			if (!target || target.nodeType === 3 || target.nodeType === 8) {
				return self;
			}

			// Unbind any element on the specificed target
			if (target[expando]) {
				unbind(target);
			}

			// Target doesn't have getElementsByTagName it's probably a window object then use it's document to find the children
			if (!target.getElementsByTagName) {
				target = target.document;
			}

			// Remove events from each child element
			if (target && target.getElementsByTagName) {
				unbind(target);

				children = target.getElementsByTagName('*');
				i = children.length;
				while (i--) {
					target = children[i];

					if (target[expando]) {
						unbind(target);
					}
				}
			}

			return self;
		};

		/**
		 * Destroys the event object. Call this on IE to remove memory leaks.
		 */
		self.destroy = function() {
			events = {};
		};

		// Legacy function for canceling events
		self.cancel = function(e) {
			if (e) {
				e.preventDefault();
				e.stopImmediatePropagation();
			}

			return false;
		};
	}

	EventUtils.Event = new EventUtils();
	EventUtils.Event.bind(window, 'ready', function() {});

	return EventUtils;
});

// Included from: js/tinymce/classes/dom/Sizzle.jQuery.js

/**
 * Sizzle.jQuery.js
 *
 * Released under LGPL License.
 * Copyright (c) 1999-2015 Ephox Corp. All rights reserved
 *
 * License: http://www.tinymce.com/license
 * Contributing: http://www.tinymce.com/contributing
 */

/*global jQuery:true */

/*
 * Fake Sizzle using jQuery.
 */
define("tinymce/dom/Sizzle", [], function() {
	// Detect if jQuery is loaded
	if (!window.jQuery) {
		throw new Error("Load jQuery first");
	}

	return jQuery.find;
});

// Included from: js/tinymce/classes/Env.js

/**
 * Env.js
 *
 * Released under LGPL License.
 * Copyright (c) 1999-2015 Ephox Corp. All rights reserved
 *
 * License: http://www.tinymce.com/license
 * Contributing: http://www.tinymce.com/contributing
 */

/**
 * This class contains various environment constants like browser versions etc.
 * Normally you don't want to sniff specific browser versions but sometimes you have
 * to when it's impossible to feature detect. So use this with care.
 *
 * @class tinymce.Env
 * @static
 */
define("tinymce/Env", [], function() {
	var nav = navigator, userAgent = nav.userAgent;
	var opera, webkit, ie, ie11, ie12, gecko, mac, iDevice, android, fileApi;

	opera = window.opera && window.opera.buildNumber;
	android = /Android/.test(userAgent);
	webkit = /WebKit/.test(userAgent);
	ie = !webkit && !opera && (/MSIE/gi).test(userAgent) && (/Explorer/gi).test(nav.appName);
	ie = ie && /MSIE (\w+)\./.exec(userAgent)[1];
	ie11 = userAgent.indexOf('Trident/') != -1 && (userAgent.indexOf('rv:') != -1 || nav.appName.indexOf('Netscape') != -1) ? 11 : false;
	ie12 = (userAgent.indexOf('Edge/') != -1 && !ie && !ie11) ? 12 : false;
	ie = ie || ie11 || ie12;
	gecko = !webkit && !ie11 && /Gecko/.test(userAgent);
	mac = userAgent.indexOf('Mac') != -1;
	iDevice = /(iPad|iPhone)/.test(userAgent);
	fileApi = "FormData" in window && "FileReader" in window && "URL" in window && !!URL.createObjectURL;

	if (ie12) {
		webkit = false;
	}

	// Is a iPad/iPhone and not on iOS5 sniff the WebKit version since older iOS WebKit versions
	// says it has contentEditable support but there is no visible caret.
	var contentEditable = !iDevice || fileApi || userAgent.match(/AppleWebKit\/(\d*)/)[1] >= 534;

	return {
		/**
		 * Constant that is true if the browser is Opera.
		 *
		 * @property opera
		 * @type Boolean
		 * @final
		 */
		opera: opera,

		/**
		 * Constant that is true if the browser is WebKit (Safari/Chrome).
		 *
		 * @property webKit
		 * @type Boolean
		 * @final
		 */
		webkit: webkit,

		/**
		 * Constant that is more than zero if the browser is IE.
		 *
		 * @property ie
		 * @type Boolean
		 * @final
		 */
		ie: ie,

		/**
		 * Constant that is true if the browser is Gecko.
		 *
		 * @property gecko
		 * @type Boolean
		 * @final
		 */
		gecko: gecko,

		/**
		 * Constant that is true if the os is Mac OS.
		 *
		 * @property mac
		 * @type Boolean
		 * @final
		 */
		mac: mac,

		/**
		 * Constant that is true if the os is iOS.
		 *
		 * @property iOS
		 * @type Boolean
		 * @final
		 */
		iOS: iDevice,

		/**
		 * Constant that is true if the os is android.
		 *
		 * @property android
		 * @type Boolean
		 * @final
		 */
		android: android,

		/**
		 * Constant that is true if the browser supports editing.
		 *
		 * @property contentEditable
		 * @type Boolean
		 * @final
		 */
		contentEditable: contentEditable,

		/**
		 * Transparent image data url.
		 *
		 * @property transparentSrc
		 * @type Boolean
		 * @final
		 */
		transparentSrc: "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7",

		/**
		 * Returns true/false if the browser can or can't place the caret after a inline block like an image.
		 *
		 * @property noCaretAfter
		 * @type Boolean
		 * @final
		 */
		caretAfter: ie != 8,

		/**
		 * Constant that is true if the browser supports native DOM Ranges. IE 9+.
		 *
		 * @property range
		 * @type Boolean
		 */
		range: window.getSelection && "Range" in window,

		/**
		 * Returns the IE document mode for non IE browsers this will fake IE 10.
		 *
		 * @property documentMode
		 * @type Number
		 */
		documentMode: ie && !ie12 ? (document.documentMode || 7) : 10,

		/**
		 * Constant that is true if the browser has a modern file api.
		 *
		 * @property fileApi
		 * @type Boolean
		 */
		fileApi: fileApi
	};
});

// Included from: js/tinymce/classes/util/Arr.js

/**
 * Arr.js
 *
 * Released under LGPL License.
 * Copyright (c) 1999-2015 Ephox Corp. All rights reserved
 *
 * License: http://www.tinymce.com/license
 * Contributing: http://www.tinymce.com/contributing
 */

/**
 * Array utility class.
 *
 * @private
 * @class tinymce.util.Arr
 */
define("tinymce/util/Arr", [], function() {
	var isArray = Array.isArray || function(obj) {
		return Object.prototype.toString.call(obj) === "[object Array]";
	};

	function toArray(obj) {
		var array = obj, i, l;

		if (!isArray(obj)) {
			array = [];
			for (i = 0, l = obj.length; i < l; i++) {
				array[i] = obj[i];
			}
		}

		return array;
	}

	function each(o, cb, s) {
		var n, l;

		if (!o) {
			return 0;
		}

		s = s || o;

		if (o.length !== undefined) {
			// Indexed arrays, needed for Safari
			for (n = 0, l = o.length; n < l; n++) {
				if (cb.call(s, o[n], n, o) === false) {
					return 0;
				}
			}
		} else {
			// Hashtables
			for (n in o) {
				if (o.hasOwnProperty(n)) {
					if (cb.call(s, o[n], n, o) === false) {
						return 0;
					}
				}
			}
		}

		return 1;
	}

	function map(array, callback) {
		var out = [];

		each(array, function(item, index) {
			out.push(callback(item, index, array));
		});

		return out;
	}

	function filter(a, f) {
		var o = [];

		each(a, function(v) {
			if (!f || f(v)) {
				o.push(v);
			}
		});

		return o;
	}

	function indexOf(a, v) {
		var i, l;

		if (a) {
			for (i = 0, l = a.length; i < l; i++) {
				if (a[i] === v) {
					return i;
				}
			}
		}

		return -1;
	}

	function reduce(collection, iteratee, accumulator, thisArg) {
		var i = 0;

		if (arguments.length < 3) {
			accumulator = collection[0];
			i = 1;
		}

		for (; i < collection.length; i++) {
			accumulator = iteratee.call(thisArg, accumulator, collection[i], i);
		}

		return accumulator;
	}

	return {
		isArray: isArray,
		toArray: toArray,
		each: each,
		map: map,
		filter: filter,
		indexOf: indexOf,
		reduce: reduce
	};
});

// Included from: js/tinymce/classes/util/Tools.js

/**
 * Tools.js
 *
 * Released under LGPL License.
 * Copyright (c) 1999-2015 Ephox Corp. All rights reserved
 *
 * License: http://www.tinymce.com/license
 * Contributing: http://www.tinymce.com/contributing
 */

/**
 * This class contains various utlity functions. These are also exposed
 * directly on the tinymce namespace.
 *
 * @class tinymce.util.Tools
 */
define("tinymce/util/Tools", [
	"tinymce/Env",
	"tinymce/util/Arr"
], function(Env, Arr) {
	/**
	 * Removes whitespace from the beginning and end of a string.
	 *
	 * @method trim
	 * @param {String} s String to remove whitespace from.
	 * @return {String} New string with removed whitespace.
	 */
	var whiteSpaceRegExp = /^\s*|\s*$/g;

	function trim(str) {
		return (str === null || str === undefined) ? '' : ("" + str).replace(whiteSpaceRegExp, '');
	}

	/**
	 * Checks if a object is of a specific type for example an array.
	 *
	 * @method is
	 * @param {Object} obj Object to check type of.
	 * @param {string} type Optional type to check for.
	 * @return {Boolean} true/false if the object is of the specified type.
	 */
	function is(obj, type) {
		if (!type) {
			return obj !== undefined;
		}

		if (type == 'array' && Arr.isArray(obj)) {
			return true;
		}

		return typeof obj == type;
	}

	/**
	 * Makes a name/object map out of an array with names.
	 *
	 * @method makeMap
	 * @param {Array/String} items Items to make map out of.
	 * @param {String} delim Optional delimiter to split string by.
	 * @param {Object} map Optional map to add items to.
	 * @return {Object} Name/value map of items.
	 */
	function makeMap(items, delim, map) {
		var i;

		items = items || [];
		delim = delim || ',';

		if (typeof items == "string") {
			items = items.split(delim);
		}

		map = map || {};

		i = items.length;
		while (i--) {
			map[items[i]] = {};
		}

		return map;
	}

	/**
	 * Creates a class, subclass or static singleton.
	 * More details on this method can be found in the Wiki.
	 *
	 * @method create
	 * @param {String} s Class name, inheritage and prefix.
	 * @param {Object} p Collection of methods to add to the class.
	 * @param {Object} root Optional root object defaults to the global window object.
	 * @example
	 * // Creates a basic class
	 * tinymce.create('tinymce.somepackage.SomeClass', {
	 *     SomeClass: function() {
	 *         // Class constructor
	 *     },
	 *
	 *     method: function() {
	 *         // Some method
	 *     }
	 * });
	 *
	 * // Creates a basic subclass class
	 * tinymce.create('tinymce.somepackage.SomeSubClass:tinymce.somepackage.SomeClass', {
	 *     SomeSubClass: function() {
	 *         // Class constructor
	 *         this.parent(); // Call parent constructor
	 *     },
	 *
	 *     method: function() {
	 *         // Some method
	 *         this.parent(); // Call parent method
	 *     },
	 *
	 *     'static': {
	 *         staticMethod: function() {
	 *             // Static method
	 *         }
	 *     }
	 * });
	 *
	 * // Creates a singleton/static class
	 * tinymce.create('static tinymce.somepackage.SomeSingletonClass', {
	 *     method: function() {
	 *         // Some method
	 *     }
	 * });
	 */
	function create(s, p, root) {
		var self = this, sp, ns, cn, scn, c, de = 0;

		// Parse : <prefix> <class>:<super class>
		s = /^((static) )?([\w.]+)(:([\w.]+))?/.exec(s);
		cn = s[3].match(/(^|\.)(\w+)$/i)[2]; // Class name

		// Create namespace for new class
		ns = self.createNS(s[3].replace(/\.\w+$/, ''), root);

		// Class already exists
		if (ns[cn]) {
			return;
		}

		// Make pure static class
		if (s[2] == 'static') {
			ns[cn] = p;

			if (this.onCreate) {
				this.onCreate(s[2], s[3], ns[cn]);
			}

			return;
		}

		// Create default constructor
		if (!p[cn]) {
			p[cn] = function() {};
			de = 1;
		}

		// Add constructor and methods
		ns[cn] = p[cn];
		self.extend(ns[cn].prototype, p);

		// Extend
		if (s[5]) {
			sp = self.resolve(s[5]).prototype;
			scn = s[5].match(/\.(\w+)$/i)[1]; // Class name

			// Extend constructor
			c = ns[cn];
			if (de) {
				// Add passthrough constructor
				ns[cn] = function() {
					return sp[scn].apply(this, arguments);
				};
			} else {
				// Add inherit constructor
				ns[cn] = function() {
					this.parent = sp[scn];
					return c.apply(this, arguments);
				};
			}
			ns[cn].prototype[cn] = ns[cn];

			// Add super methods
			self.each(sp, function(f, n) {
				ns[cn].prototype[n] = sp[n];
			});

			// Add overridden methods
			self.each(p, function(f, n) {
				// Extend methods if needed
				if (sp[n]) {
					ns[cn].prototype[n] = function() {
						this.parent = sp[n];
						return f.apply(this, arguments);
					};
				} else {
					if (n != cn) {
						ns[cn].prototype[n] = f;
					}
				}
			});
		}

		// Add static methods
		/*jshint sub:true*/
		/*eslint dot-notation:0*/
		self.each(p['static'], function(f, n) {
			ns[cn][n] = f;
		});
	}

	function extend(obj, ext) {
		var i, l, name, args = arguments, value;

		for (i = 1, l = args.length; i < l; i++) {
			ext = args[i];
			for (name in ext) {
				if (ext.hasOwnProperty(name)) {
					value = ext[name];

					if (value !== undefined) {
						obj[name] = value;
					}
				}
			}
		}

		return obj;
	}

	/**
	 * Executed the specified function for each item in a object tree.
	 *
	 * @method walk
	 * @param {Object} o Object tree to walk though.
	 * @param {function} f Function to call for each item.
	 * @param {String} n Optional name of collection inside the objects to walk for example childNodes.
	 * @param {String} s Optional scope to execute the function in.
	 */
	function walk(o, f, n, s) {
		s = s || this;

		if (o) {
			if (n) {
				o = o[n];
			}

			Arr.each(o, function(o, i) {
				if (f.call(s, o, i, n) === false) {
					return false;
				}

				walk(o, f, n, s);
			});
		}
	}

	/**
	 * Creates a namespace on a specific object.
	 *
	 * @method createNS
	 * @param {String} n Namespace to create for example a.b.c.d.
	 * @param {Object} o Optional object to add namespace to, defaults to window.
	 * @return {Object} New namespace object the last item in path.
	 * @example
	 * // Create some namespace
	 * tinymce.createNS('tinymce.somepackage.subpackage');
	 *
	 * // Add a singleton
	 * var tinymce.somepackage.subpackage.SomeSingleton = {
	 *     method: function() {
	 *         // Some method
	 *     }
	 * };
	 */
	function createNS(n, o) {
		var i, v;

		o = o || window;

		n = n.split('.');
		for (i = 0; i < n.length; i++) {
			v = n[i];

			if (!o[v]) {
				o[v] = {};
			}

			o = o[v];
		}

		return o;
	}

	/**
	 * Resolves a string and returns the object from a specific structure.
	 *
	 * @method resolve
	 * @param {String} n Path to resolve for example a.b.c.d.
	 * @param {Object} o Optional object to search though, defaults to window.
	 * @return {Object} Last object in path or null if it couldn't be resolved.
	 * @example
	 * // Resolve a path into an object reference
	 * var obj = tinymce.resolve('a.b.c.d');
	 */
	function resolve(n, o) {
		var i, l;

		o = o || window;

		n = n.split('.');
		for (i = 0, l = n.length; i < l; i++) {
			o = o[n[i]];

			if (!o) {
				break;
			}
		}

		return o;
	}

	/**
	 * Splits a string but removes the whitespace before and after each value.
	 *
	 * @method explode
	 * @param {string} s String to split.
	 * @param {string} d Delimiter to split by.
	 * @example
	 * // Split a string into an array with a,b,c
	 * var arr = tinymce.explode('a, b,   c');
	 */
	function explode(s, d) {
		if (!s || is(s, 'array')) {
			return s;
		}

		return Arr.map(s.split(d || ','), trim);
	}

	function _addCacheSuffix(url) {
		var cacheSuffix = Env.cacheSuffix;

		if (cacheSuffix) {
			url += (url.indexOf('?') === -1 ? '?' : '&') + cacheSuffix;
		}

		return url;
	}

	return {
		trim: trim,

		/**
		 * Returns true/false if the object is an array or not.
		 *
		 * @method isArray
		 * @param {Object} obj Object to check.
		 * @return {boolean} true/false state if the object is an array or not.
		 */
		isArray: Arr.isArray,

		is: is,

		/**
		 * Converts the specified object into a real JavaScript array.
		 *
		 * @method toArray
		 * @param {Object} obj Object to convert into array.
		 * @return {Array} Array object based in input.
		 */
		toArray: Arr.toArray,
		makeMap: makeMap,

		/**
		 * Performs an iteration of all items in a collection such as an object or array. This method will execure the
		 * callback function for each item in the collection, if the callback returns false the iteration will terminate.
		 * The callback has the following format: cb(value, key_or_index).
		 *
		 * @method each
		 * @param {Object} o Collection to iterate.
		 * @param {function} cb Callback function to execute for each item.
		 * @param {Object} s Optional scope to execute the callback in.
		 * @example
		 * // Iterate an array
		 * tinymce.each([1,2,3], function(v, i) {
		 *     console.debug("Value: " + v + ", Index: " + i);
		 * });
		 *
		 * // Iterate an object
		 * tinymce.each({a: 1, b: 2, c: 3], function(v, k) {
		 *     console.debug("Value: " + v + ", Key: " + k);
		 * });
		 */
		each: Arr.each,

		/**
		 * Creates a new array by the return value of each iteration function call. This enables you to convert
		 * one array list into another.
		 *
		 * @method map
		 * @param {Array} array Array of items to iterate.
		 * @param {function} callback Function to call for each item. It's return value will be the new value.
		 * @return {Array} Array with new values based on function return values.
		 */
		map: Arr.map,

		/**
		 * Filters out items from the input array by calling the specified function for each item.
		 * If the function returns false the item will be excluded if it returns true it will be included.
		 *
		 * @method grep
		 * @param {Array} a Array of items to loop though.
		 * @param {function} f Function to call for each item. Include/exclude depends on it's return value.
		 * @return {Array} New array with values imported and filtered based in input.
		 * @example
		 * // Filter out some items, this will return an array with 4 and 5
		 * var items = tinymce.grep([1,2,3,4,5], function(v) {return v > 3;});
		 */
		grep: Arr.filter,

		/**
		 * Returns true/false if the object is an array or not.
		 *
		 * @method isArray
		 * @param {Object} obj Object to check.
		 * @return {boolean} true/false state if the object is an array or not.
		 */
		inArray: Arr.indexOf,

		extend: extend,
		create: create,
		walk: walk,
		createNS: createNS,
		resolve: resolve,
		explode: explode,
		_addCacheSuffix: _addCacheSuffix
	};
});

// Included from: js/tinymce/classes/dom/DomQuery.js

/**
 * DomQuery.js
 *
 * Released under LGPL License.
 * Copyright (c) 1999-2015 Ephox Corp. All rights reserved
 *
 * License: http://www.tinymce.com/license
 * Contributing: http://www.tinymce.com/contributing
 */

/**
 * This class mimics most of the jQuery API:
 *
 * This is whats currently implemented:
 * - Utility functions
 * - DOM traversial
 * - DOM manipulation
 * - Event binding
 *
 * This is not currently implemented:
 * - Dimension
 * - Ajax
 * - Animation
 * - Advanced chaining
 *
 * @example
 * var $ = tinymce.dom.DomQuery;
 * $('p').attr('attr', 'value').addClass('class');
 *
 * @class tinymce.dom.DomQuery
 */
define("tinymce/dom/DomQuery", [
	"tinymce/dom/EventUtils",
	"tinymce/dom/Sizzle",
	"tinymce/util/Tools",
	"tinymce/Env"
], function(EventUtils, Sizzle, Tools, Env) {
	var doc = document, push = Array.prototype.push, slice = Array.prototype.slice;
	var rquickExpr = /^(?:[^#<]*(<[\w\W]+>)[^>]*$|#([\w\-]*)$)/;
	var Event = EventUtils.Event, undef;
	var skipUniques = Tools.makeMap('children,contents,next,prev');

	function isDefined(obj) {
		return typeof obj !== 'undefined';
	}

	function isString(obj) {
		return typeof obj === 'string';
	}

	function isWindow(obj) {
		return obj && obj == obj.window;
	}

	function createFragment(html, fragDoc) {
		var frag, node, container;

		fragDoc = fragDoc || doc;
		container = fragDoc.createElement('div');
		frag = fragDoc.createDocumentFragment();
		container.innerHTML = html;

		while ((node = container.firstChild)) {
			frag.appendChild(node);
		}

		return frag;
	}

	function domManipulate(targetNodes, sourceItem, callback, reverse) {
		var i;

		if (isString(sourceItem)) {
			sourceItem = createFragment(sourceItem, getElementDocument(targetNodes[0]));
		} else if (sourceItem.length && !sourceItem.nodeType) {
			sourceItem = DomQuery.makeArray(sourceItem);

			if (reverse) {
				for (i = sourceItem.length - 1; i >= 0; i--) {
					domManipulate(targetNodes, sourceItem[i], callback, reverse);
				}
			} else {
				for (i = 0; i < sourceItem.length; i++) {
					domManipulate(targetNodes, sourceItem[i], callback, reverse);
				}
			}

			return targetNodes;
		}

		if (sourceItem.nodeType) {
			i = targetNodes.length;
			while (i--) {
				callback.call(targetNodes[i], sourceItem);
			}
		}

		return targetNodes;
	}

	function hasClass(node, className) {
		return node && className && (' ' + node.className + ' ').indexOf(' ' + className + ' ') !== -1;
	}

	function wrap(elements, wrapper, all) {
		var lastParent, newWrapper;

		wrapper = DomQuery(wrapper)[0];

		elements.each(function() {
			var self = this;

			if (!all || lastParent != self.parentNode) {
				lastParent = self.parentNode;
				newWrapper = wrapper.cloneNode(false);
				self.parentNode.insertBefore(newWrapper, self);
				newWrapper.appendChild(self);
			} else {
				newWrapper.appendChild(self);
			}
		});

		return elements;
	}

	var numericCssMap = Tools.makeMap('fillOpacity fontWeight lineHeight opacity orphans widows zIndex zoom', ' ');
	var booleanMap = Tools.makeMap('checked compact declare defer disabled ismap multiple nohref noshade nowrap readonly selected', ' ');
	var propFix = {
		'for': 'htmlFor',
		'class': 'className',
		'readonly': 'readOnly'
	};
	var cssFix = {
		'float': 'cssFloat'
	};

	var attrHooks = {}, cssHooks = {};

	function DomQuery(selector, context) {
		/*eslint new-cap:0 */
		return new DomQuery.fn.init(selector, context);
	}

	function inArray(item, array) {
		var i;

		if (array.indexOf) {
			return array.indexOf(item);
		}

		i = array.length;
		while (i--) {
			if (array[i] === item) {
				return i;
			}
		}

		return -1;
	}

	var whiteSpaceRegExp = /^\s*|\s*$/g;

	function trim(str) {
		return (str === null || str === undef) ? '' : ("" + str).replace(whiteSpaceRegExp, '');
	}

	function each(obj, callback) {
		var length, key, i, undef, value;

		if (obj) {
			length = obj.length;

			if (length === undef) {
				// Loop object items
				for (key in obj) {
					if (obj.hasOwnProperty(key)) {
						value = obj[key];
						if (callback.call(value, key, value) === false) {
							break;
						}
					}
				}
			} else {
				// Loop array items
				for (i = 0; i < length; i++) {
					value = obj[i];
					if (callback.call(value, i, value) === false) {
						break;
					}
				}
			}
		}

		return obj;
	}

	function grep(array, callback) {
		var out = [];

		each(array, function(i, item) {
			if (callback(item, i)) {
				out.push(item);
			}
		});

		return out;
	}

	function getElementDocument(element) {
		if (!element) {
			return doc;
		}

		if (element.nodeType == 9) {
			return element;
		}

		return element.ownerDocument;
	}

	DomQuery.fn = DomQuery.prototype = {
		constructor: DomQuery,

		/**
		 * Selector for the current set.
		 *
		 * @property selector
		 * @type String
		 */
		selector: "",

		/**
		 * Context used to create the set.
		 *
		 * @property context
		 * @type Element
		 */
		context: null,

		/**
		 * Number of items in the current set.
		 *
		 * @property length
		 * @type Number
		 */
		length: 0,

		/**
		 * Constructs a new DomQuery instance with the specified selector or context.
		 *
		 * @constructor
		 * @method init
		 * @param {String/Array/DomQuery} selector Optional CSS selector/Array or array like object or HTML string.
		 * @param {Document/Element} context Optional context to search in.
		 */
		init: function(selector, context) {
			var self = this, match, node;

			if (!selector) {
				return self;
			}

			if (selector.nodeType) {
				self.context = self[0] = selector;
				self.length = 1;

				return self;
			}

			if (context && context.nodeType) {
				self.context = context;
			} else {
				if (context) {
					return DomQuery(selector).attr(context);
				}

				self.context = context = document;
			}

			if (isString(selector)) {
				self.selector = selector;

				if (selector.charAt(0) === "<" && selector.charAt(selector.length - 1) === ">" && selector.length >= 3) {
					match = [null, selector, null];
				} else {
					match = rquickExpr.exec(selector);
				}

				if (match) {
					if (match[1]) {
						node = createFragment(selector, getElementDocument(context)).firstChild;

						while (node) {
							push.call(self, node);
							node = node.nextSibling;
						}
					} else {
						node = getElementDocument(context).getElementById(match[2]);

						if (!node) {
							return self;
						}

						if (node.id !== match[2]) {
							return self.find(selector);
						}

						self.length = 1;
						self[0] = node;
					}
				} else {
					return DomQuery(context).find(selector);
				}
			} else {
				this.add(selector, false);
			}

			return self;
		},

		/**
		 * Converts the current set to an array.
		 *
		 * @method toArray
		 * @param {Array} Array of all nodes in set.
		 */
		toArray: function() {
			return Tools.toArray(this);
		},

		/**
		 * Adds new nodes to the set.
		 *
		 * @method add
		 * @param {Array/tinymce.dom.DomQuery} items Array of all nodes to add to set.
		 * @return {tinymce.dom.DomQuery} New instance with nodes added.
		 */
		add: function(items, sort) {
			var self = this, nodes, i;

			if (isString(items)) {
				return self.add(DomQuery(items));
			}

			if (sort !== false) {
				nodes = DomQuery.unique(self.toArray().concat(DomQuery.makeArray(items)));
				self.length = nodes.length;
				for (i = 0; i < nodes.length; i++) {
					self[i] = nodes[i];
				}
			} else {
				push.apply(self, DomQuery.makeArray(items));
			}

			return self;
		},

		/**
		 * Sets/gets attributes on the elements in the current set.
		 *
		 * @method attr
		 * @param {String/Object} name Name of attribute to get or an object with attributes to set.
		 * @param {String} value Optional value to set.
		 * @return {tinymce.dom.DomQuery/String} Current set or the specified attribute when only the name is specified.
		 */
		attr: function(name, value) {
			var self = this, hook;

			if (typeof name === "object") {
				each(name, function(name, value) {
					self.attr(name, value);
				});
			} else if (isDefined(value)) {
				this.each(function() {
					var hook;

					if (this.nodeType === 1) {
						hook = attrHooks[name];
						if (hook && hook.set) {
							hook.set(this, value);
							return;
						}

						if (value === null) {
							this.removeAttribute(name, 2);
						} else {
							this.setAttribute(name, value, 2);
						}
					}
				});
			} else {
				if (self[0] && self[0].nodeType === 1) {
					hook = attrHooks[name];
					if (hook && hook.get) {
						return hook.get(self[0], name);
					}

					if (booleanMap[name]) {
						return self.prop(name) ? name : undef;
					}

					value = self[0].getAttribute(name, 2);

					if (value === null) {
						value = undef;
					}
				}

				return value;
			}

			return self;
		},

		/**
		 * Removes attributse on the elements in the current set.
		 *
		 * @method removeAttr
		 * @param {String/Object} name Name of attribute to remove.
		 * @return {tinymce.dom.DomQuery/String} Current set.
		 */
		removeAttr: function(name) {
			return this.attr(name, null);
		},

		/**
		 * Sets/gets properties on the elements in the current set.
		 *
		 * @method attr
		 * @param {String/Object} name Name of property to get or an object with properties to set.
		 * @param {String} value Optional value to set.
		 * @return {tinymce.dom.DomQuery/String} Current set or the specified property when only the name is specified.
		 */
		prop: function(name, value) {
			var self = this;

			name = propFix[name] || name;

			if (typeof name === "object") {
				each(name, function(name, value) {
					self.prop(name, value);
				});
			} else if (isDefined(value)) {
				this.each(function() {
					if (this.nodeType == 1) {
						this[name] = value;
					}
				});
			} else {
				if (self[0] && self[0].nodeType && name in self[0]) {
					return self[0][name];
				}

				return value;
			}

			return self;
		},

		/**
		 * Sets/gets styles on the elements in the current set.
		 *
		 * @method css
		 * @param {String/Object} name Name of style to get or an object with styles to set.
		 * @param {String} value Optional value to set.
		 * @return {tinymce.dom.DomQuery/String} Current set or the specified style when only the name is specified.
		 */
		css: function(name, value) {
			var self = this, elm, hook;

			function camel(name) {
				return name.replace(/-(\D)/g, function(a, b) {
					return b.toUpperCase();
				});
			}

			function dashed(name) {
				return name.replace(/[A-Z]/g, function(a) {
					return '-' + a;
				});
			}

			if (typeof name === "object") {
				each(name, function(name, value) {
					self.css(name, value);
				});
			} else {
				if (isDefined(value)) {
					name = camel(name);

					// Default px suffix on these
					if (typeof value === 'number' && !numericCssMap[name]) {
						value += 'px';
					}

					self.each(function() {
						var style = this.style;

						hook = cssHooks[name];
						if (hook && hook.set) {
							hook.set(this, value);
							return;
						}

						try {
							this.style[cssFix[name] || name] = value;
						} catch (ex) {
							// Ignore
						}

						if (value === null || value === '') {
							if (style.removeProperty) {
								style.removeProperty(dashed(name));
							} else {
								style.removeAttribute(name);
							}
						}
					});
				} else {
					elm = self[0];

					hook = cssHooks[name];
					if (hook && hook.get) {
						return hook.get(elm);
					}

					if (elm.ownerDocument.defaultView) {
						try {
							return elm.ownerDocument.defaultView.getComputedStyle(elm, null).getPropertyValue(dashed(name));
						} catch (ex) {
							return undef;
						}
					} else if (elm.currentStyle) {
						return elm.currentStyle[camel(name)];
					}
				}
			}

			return self;
		},

		/**
		 * Removes all nodes in set from the document.
		 *
		 * @method remove
		 * @return {tinymce.dom.DomQuery} Current set with the removed nodes.
		 */
		remove: function() {
			var self = this, node, i = this.length;

			while (i--) {
				node = self[i];
				Event.clean(node);

				if (node.parentNode) {
					node.parentNode.removeChild(node);
				}
			}

			return this;
		},

		/**
		 * Empties all elements in set.
		 *
		 * @method empty
		 * @return {tinymce.dom.DomQuery} Current set with the empty nodes.
		 */
		empty: function() {
			var self = this, node, i = this.length;

			while (i--) {
				node = self[i];
				while (node.firstChild) {
					node.removeChild(node.firstChild);
				}
			}

			return this;
		},

		/**
		 * Sets or gets the HTML of the current set or first set node.
		 *
		 * @method html
		 * @param {String} value Optional innerHTML value to set on each element.
		 * @return {tinymce.dom.DomQuery/String} Current set or the innerHTML of the first element.
		 */
		html: function(value) {
			var self = this, i;

			if (isDefined(value)) {
				i = self.length;

				try {
					while (i--) {
						self[i].innerHTML = value;
					}
				} catch (ex) {
					// Workaround for "Unknown runtime error" when DIV is added to P on IE
					DomQuery(self[i]).empty().append(value);
				}

				return self;
			}

			return self[0] ? self[0].innerHTML : '';
		},

		/**
		 * Sets or gets the text of the current set or first set node.
		 *
		 * @method text
		 * @param {String} value Optional innerText value to set on each element.
		 * @return {tinymce.dom.DomQuery/String} Current set or the innerText of the first element.
		 */
		text: function(value) {
			var self = this, i;

			if (isDefined(value)) {
				i = self.length;
				while (i--) {
					if ("innerText" in self[i]) {
						self[i].innerText = value;
					} else {
						self[0].textContent = value;
					}
				}

				return self;
			}

			return self[0] ? (self[0].innerText || self[0].textContent) : '';
		},

		/**
		 * Appends the specified node/html or node set to the current set nodes.
		 *
		 * @method append
		 * @param {String/Element/Array/tinymce.dom.DomQuery} content Content to append to each element in set.
		 * @return {tinymce.dom.DomQuery} Current set.
		 */
		append: function() {
			return domManipulate(this, arguments, function(node) {
				if (this.nodeType === 1) {
					this.appendChild(node);
				}
			});
		},

		/**
		 * Prepends the specified node/html or node set to the current set nodes.
		 *
		 * @method prepend
		 * @param {String/Element/Array/tinymce.dom.DomQuery} content Content to prepend to each element in set.
		 * @return {tinymce.dom.DomQuery} Current set.
		 */
		prepend: function() {
			return domManipulate(this, arguments, function(node) {
				if (this.nodeType === 1) {
					this.insertBefore(node, this.firstChild);
				}
			}, true);
		},

		/**
		 * Adds the specified elements before current set nodes.
		 *
		 * @method before
		 * @param {String/Element/Array/tinymce.dom.DomQuery} content Content to add before to each element in set.
		 * @return {tinymce.dom.DomQuery} Current set.
		 */
		before: function() {
			var self = this;

			if (self[0] && self[0].parentNode) {
				return domManipulate(self, arguments, function(node) {
					this.parentNode.insertBefore(node, this);
				});
			}

			return self;
		},

		/**
		 * Adds the specified elements after current set nodes.
		 *
		 * @method after
		 * @param {String/Element/Array/tinymce.dom.DomQuery} content Content to add after to each element in set.
		 * @return {tinymce.dom.DomQuery} Current set.
		 */
		after: function() {
			var self = this;

			if (self[0] && self[0].parentNode) {
				return domManipulate(self, arguments, function(node) {
					this.parentNode.insertBefore(node, this.nextSibling);
				}, true);
			}

			return self;
		},

		/**
		 * Appends the specified set nodes to the specified selector/instance.
		 *
		 * @method appendTo
		 * @param {String/Element/Array/tinymce.dom.DomQuery} val Item to append the current set to.
		 * @return {tinymce.dom.DomQuery} Current set with the appended nodes.
		 */
		appendTo: function(val) {
			DomQuery(val).append(this);

			return this;
		},

		/**
		 * Prepends the specified set nodes to the specified selector/instance.
		 *
		 * @method prependTo
		 * @param {String/Element/Array/tinymce.dom.DomQuery} val Item to prepend the current set to.
		 * @return {tinymce.dom.DomQuery} Current set with the prepended nodes.
		 */
		prependTo: function(val) {
			DomQuery(val).prepend(this);

			return this;
		},

		/**
		 * Replaces the nodes in set with the specified content.
		 *
		 * @method replaceWith
		 * @param {String/Element/Array/tinymce.dom.DomQuery} content Content to replace nodes with.
		 * @return {tinymce.dom.DomQuery} Set with replaced nodes.
		 */
		replaceWith: function(content) {
			return this.before(content).remove();
		},

		/**
		 * Wraps all elements in set with the specified wrapper.
		 *
		 * @method wrap
		 * @param {String/Element/Array/tinymce.dom.DomQuery} content Content to wrap nodes with.
		 * @return {tinymce.dom.DomQuery} Set with wrapped nodes.
		 */
		wrap: function(wrapper) {
			return wrap(this, wrapper);
		},

		/**
		 * Wraps all nodes in set with the specified wrapper. If the nodes are siblings all of them
		 * will be wrapped in the same wrapper.
		 *
		 * @method wrapAll
		 * @param {String/Element/Array/tinymce.dom.DomQuery} content Content to wrap nodes with.
		 * @return {tinymce.dom.DomQuery} Set with wrapped nodes.
		 */
		wrapAll: function(wrapper) {
			return wrap(this, wrapper, true);
		},

		/**
		 * Wraps all elements inner contents in set with the specified wrapper.
		 *
		 * @method wrapInner
		 * @param {String/Element/Array/tinymce.dom.DomQuery} content Content to wrap nodes with.
		 * @return {tinymce.dom.DomQuery} Set with wrapped nodes.
		 */
		wrapInner: function(wrapper) {
			this.each(function() {
				DomQuery(this).contents().wrapAll(wrapper);
			});

			return this;
		},

		/**
		 * Unwraps all elements by removing the parent element of each item in set.
		 *
		 * @method unwrap
		 * @return {tinymce.dom.DomQuery} Set with unwrapped nodes.
		 */
		unwrap: function() {
			return this.parent().each(function() {
				DomQuery(this).replaceWith(this.childNodes);
			});
		},

		/**
		 * Clones all nodes in set.
		 *
		 * @method clone
		 * @return {tinymce.dom.DomQuery} Set with cloned nodes.
		 */
		clone: function() {
			var result = [];

			this.each(function() {
				result.push(this.cloneNode(true));
			});

			return DomQuery(result);
		},

		/**
		 * Adds the specified class name to the current set elements.
		 *
		 * @method addClass
		 * @param {String} className Class name to add.
		 * @return {tinymce.dom.DomQuery} Current set.
		 */
		addClass: function(className) {
			return this.toggleClass(className, true);
		},

		/**
		 * Removes the specified class name to the current set elements.
		 *
		 * @method removeClass
		 * @param {String} className Class name to remove.
		 * @return {tinymce.dom.DomQuery} Current set.
		 */
		removeClass: function(className) {
			return this.toggleClass(className, false);
		},

		/**
		 * Toggles the specified class name on the current set elements.
		 *
		 * @method toggleClass
		 * @param {String} className Class name to add/remove.
		 * @param {Boolean} state Optional state to toggle on/off.
		 * @return {tinymce.dom.DomQuery} Current set.
		 */
		toggleClass: function(className, state) {
			var self = this;

			// Functions are not supported
			if (typeof className != 'string') {
				return self;
			}

			if (className.indexOf(' ') !== -1) {
				each(className.split(' '), function() {
					self.toggleClass(this, state);
				});
			} else {
				self.each(function(index, node) {
					var existingClassName, classState;

					classState = hasClass(node, className);
					if (classState !== state) {
						existingClassName = node.className;

						if (classState) {
							node.className = trim((" " + existingClassName + " ").replace(' ' + className + ' ', ' '));
						} else {
							node.className += existingClassName ? ' ' + className : className;
						}
					}
				});
			}

			return self;
		},

		/**
		 * Returns true/false if the first item in set has the specified class.
		 *
		 * @method hasClass
		 * @param {String} className Class name to check for.
		 * @return {Boolean} True/false if the set has the specified class.
		 */
		hasClass: function(className) {
			return hasClass(this[0], className);
		},

		/**
		 * Executes the callback function for each item DomQuery collection. If you return false in the
		 * callback it will break the loop.
		 *
		 * @method each
		 * @param {function} callback Callback function to execute for each item.
		 * @return {tinymce.dom.DomQuery} Current set.
		 */
		each: function(callback) {
			return each(this, callback);
		},

		/**
		 * Binds an event with callback function to the elements in set.
		 *
		 * @method on
		 * @param {String} name Name of the event to bind.
		 * @param {function} callback Callback function to execute when the event occurs.
		 * @return {tinymce.dom.DomQuery} Current set.
		 */
		on: function(name, callback) {
			return this.each(function() {
				Event.bind(this, name, callback);
			});
		},

		/**
		 * Unbinds an event with callback function to the elements in set.
		 *
		 * @method off
		 * @param {String} name Optional name of the event to bind.
		 * @param {function} callback Optional callback function to execute when the event occurs.
		 * @return {tinymce.dom.DomQuery} Current set.
		 */
		off: function(name, callback) {
			return this.each(function() {
				Event.unbind(this, name, callback);
			});
		},

		/**
		 * Triggers the specified event by name or event object.
		 *
		 * @method trigger
		 * @param {String/Object} name Name of the event to trigger or event object.
		 * @return {tinymce.dom.DomQuery} Current set.
		 */
		trigger: function(name) {
			return this.each(function() {
				if (typeof name == 'object') {
					Event.fire(this, name.type, name);
				} else {
					Event.fire(this, name);
				}
			});
		},

		/**
		 * Shows all elements in set.
		 *
		 * @method show
		 * @return {tinymce.dom.DomQuery} Current set.
		 */
		show: function() {
			return this.css('display', '');
		},

		/**
		 * Hides all elements in set.
		 *
		 * @method hide
		 * @return {tinymce.dom.DomQuery} Current set.
		 */
		hide: function() {
			return this.css('display', 'none');
		},

		/**
		 * Slices the current set.
		 *
		 * @method slice
		 * @param {Number} start Start index to slice at.
		 * @param {Number} end Optional ened index to end slice at.
		 * @return {tinymce.dom.DomQuery} Sliced set.
		 */
		slice: function() {
			return new DomQuery(slice.apply(this, arguments));
		},

		/**
		 * Makes the set equal to the specified index.
		 *
		 * @method eq
		 * @param {Number} index Index to set it equal to.
		 * @return {tinymce.dom.DomQuery} Single item set.
		 */
		eq: function(index) {
			return index === -1 ? this.slice(index) : this.slice(index, +index + 1);
		},

		/**
		 * Makes the set equal to first element in set.
		 *
		 * @method first
		 * @return {tinymce.dom.DomQuery} Single item set.
		 */
		first: function() {
			return this.eq(0);
		},

		/**
		 * Makes the set equal to last element in set.
		 *
		 * @method last
		 * @return {tinymce.dom.DomQuery} Single item set.
		 */
		last: function() {
			return this.eq(-1);
		},

		/**
		 * Finds elements by the specified selector for each element in set.
		 *
		 * @method find
		 * @param {String} selector Selector to find elements by.
		 * @return {tinymce.dom.DomQuery} Set with matches elements.
		 */
		find: function(selector) {
			var i, l, ret = [];

			for (i = 0, l = this.length; i < l; i++) {
				DomQuery.find(selector, this[i], ret);
			}

			return DomQuery(ret);
		},

		/**
		 * Filters the current set with the specified selector.
		 *
		 * @method filter
		 * @param {String/function} selector Selector to filter elements by.
		 * @return {tinymce.dom.DomQuery} Set with filtered elements.
		 */
		filter: function(selector) {
			if (typeof selector == 'function') {
				return DomQuery(grep(this.toArray(), function(item, i) {
					return selector(i, item);
				}));
			}

			return DomQuery(DomQuery.filter(selector, this.toArray()));
		},

		/**
		 * Gets the current node or any partent matching the specified selector.
		 *
		 * @method closest
		 * @param {String/Element/tinymce.dom.DomQuery} selector Selector or element to find.
		 * @return {tinymce.dom.DomQuery} Set with closest elements.
		 */
		closest: function(selector) {
			var result = [];

			if (selector instanceof DomQuery) {
				selector = selector[0];
			}

			this.each(function(i, node) {
				while (node) {
					if (typeof selector == 'string' && DomQuery(node).is(selector)) {
						result.push(node);
						break;
					} else if (node == selector) {
						result.push(node);
						break;
					}

					node = node.parentNode;
				}
			});

			return DomQuery(result);
		},

		/**
		 * Returns the offset of the first element in set or sets the top/left css properties of all elements in set.
		 *
		 * @method offset
		 * @param {Object} offset Optional offset object to set on each item.
		 * @return {Object/tinymce.dom.DomQuery} Returns the first element offset or the current set if you specified an offset.
		 */
		offset: function(offset) {
			var elm, doc, docElm;
			var x = 0, y = 0, pos;

			if (!offset) {
				elm = this[0];

				if (elm) {
					doc = elm.ownerDocument;
					docElm = doc.documentElement;

					if (elm.getBoundingClientRect) {
						pos = elm.getBoundingClientRect();
						x = pos.left + (docElm.scrollLeft || doc.body.scrollLeft) - docElm.clientLeft;
						y = pos.top + (docElm.scrollTop || doc.body.scrollTop) - docElm.clientTop;
					}
				}

				return {
					left: x,
					top: y
				};
			}

			return this.css(offset);
		},

		push: push,
		sort: [].sort,
		splice: [].splice
	};

	// Static members
	Tools.extend(DomQuery, {
		/**
		 * Extends the specified object with one or more objects.
		 *
		 * @static
		 * @method extend
		 * @param {Object} target Target object to extend with new items.
		 * @param {Object..} object Object to extend the target with.
		 * @return {Object} Extended input object.
		 */
		extend: Tools.extend,

		/**
		 * Creates an array out of an array like object.
		 *
		 * @static
		 * @method makeArray
		 * @param {Object} object Object to convert to array.
		 * @return {Arrau} Array produced from object.
		 */
		makeArray: function(array) {
			if (isWindow(array) || array.nodeType) {
				return [array];
			}

			return Tools.toArray(array);
		},

		/**
		 * Returns the index of the specified item inside the array.
		 *
		 * @static
		 * @method inArray
		 * @param {Object} item Item to look for.
		 * @param {Array} array Array to look for item in.
		 * @return {Number} Index of the item or -1.
		 */
		inArray: inArray,

		/**
		 * Returns true/false if the specified object is an array or not.
		 *
		 * @static
		 * @method isArray
		 * @param {Object} array Object to check if it's an array or not.
		 * @return {Boolean} True/false if the object is an array.
		 */
		isArray: Tools.isArray,

		/**
		 * Executes the callback function for each item in array/object. If you return false in the
		 * callback it will break the loop.
		 *
		 * @static
		 * @method each
		 * @param {Object} obj Object to iterate.
		 * @param {function} callback Callback function to execute for each item.
		 */
		each: each,

		/**
		 * Removes whitespace from the beginning and end of a string.
		 *
		 * @static
		 * @method trim
		 * @param {String} str String to remove whitespace from.
		 * @return {String} New string with removed whitespace.
		 */
		trim: trim,

		/**
		 * Filters out items from the input array by calling the specified function for each item.
		 * If the function returns false the item will be excluded if it returns true it will be included.
		 *
		 * @static
		 * @method grep
		 * @param {Array} array Array of items to loop though.
		 * @param {function} callback Function to call for each item. Include/exclude depends on it's return value.
		 * @return {Array} New array with values imported and filtered based in input.
		 * @example
		 * // Filter out some items, this will return an array with 4 and 5
		 * var items = DomQuery.grep([1, 2, 3, 4, 5], function(v) {return v > 3;});
		 */
		grep: grep,

		// Sizzle
		find: Sizzle,
		expr: Sizzle.selectors,
		unique: Sizzle.uniqueSort,
		text: Sizzle.getText,
		contains: Sizzle.contains,
		filter: function(expr, elems, not) {
			var i = elems.length;

			if (not) {
				expr = ":not(" + expr + ")";
			}

			while (i--) {
				if (elems[i].nodeType != 1) {
					elems.splice(i, 1);
				}
			}

			if (elems.length === 1) {
				elems = DomQuery.find.matchesSelector(elems[0], expr) ? [elems[0]] : [];
			} else {
				elems = DomQuery.find.matches(expr, elems);
			}

			return elems;
		}
	});

	function dir(el, prop, until) {
		var matched = [], cur = el[prop];

		if (typeof until != 'string' && until instanceof DomQuery) {
			until = until[0];
		}

		while (cur && cur.nodeType !== 9) {
			if (until !== undefined) {
				if (cur === until) {
					break;
				}

				if (typeof until == 'string' && DomQuery(cur).is(until)) {
					break;
				}
			}

			if (cur.nodeType === 1) {
				matched.push(cur);
			}

			cur = cur[prop];
		}

		return matched;
	}

	function sibling(node, siblingName, nodeType, until) {
		var result = [];

		if (until instanceof DomQuery) {
			until = until[0];
		}

		for (; node; node = node[siblingName]) {
			if (nodeType && node.nodeType !== nodeType) {
				continue;
			}

			if (until !== undefined) {
				if (node === until) {
					break;
				}

				if (typeof until == 'string' && DomQuery(node).is(until)) {
					break;
				}
			}

			result.push(node);
		}

		return result;
	}

	function firstSibling(node, siblingName, nodeType) {
		for (node = node[siblingName]; node; node = node[siblingName]) {
			if (node.nodeType == nodeType) {
				return node;
			}
		}

		return null;
	}

	each({
		/**
		 * Returns a new collection with the parent of each item in current collection matching the optional selector.
		 *
		 * @method parent
		 * @param {String} selector Selector to match parents agains.
		 * @return {tinymce.dom.DomQuery} New DomQuery instance with all matching parents.
		 */
		parent: function(node) {
			var parent = node.parentNode;

			return parent && parent.nodeType !== 11 ? parent : null;
		},

		/**
		 * Returns a new collection with the all the parents of each item in current collection matching the optional selector.
		 *
		 * @method parents
		 * @param {String} selector Selector to match parents agains.
		 * @return {tinymce.dom.DomQuery} New DomQuery instance with all matching parents.
		 */
		parents: function(node) {
			return dir(node, "parentNode");
		},

		/**
		 * Returns a new collection with next sibling of each item in current collection matching the optional selector.
		 *
		 * @method next
		 * @param {String} selector Selector to match the next element against.
		 * @return {tinymce.dom.DomQuery} New DomQuery instance with all matching elements.
		 */
		next: function(node) {
			return firstSibling(node, 'nextSibling', 1);
		},

		/**
		 * Returns a new collection with previous sibling of each item in current collection matching the optional selector.
		 *
		 * @method prev
		 * @param {String} selector Selector to match the previous element against.
		 * @return {tinymce.dom.DomQuery} New DomQuery instance with all matching elements.
		 */
		prev: function(node) {
			return firstSibling(node, 'previousSibling', 1);
		},

		/**
		 * Returns all child elements matching the optional selector.
		 *
		 * @method children
		 * @param {String} selector Selector to match the elements against.
		 * @return {tinymce.dom.DomQuery} New DomQuery instance with all matching elements.
		 */
		children: function(node) {
			return sibling(node.firstChild, 'nextSibling', 1);
		},

		/**
		 * Returns all child nodes matching the optional selector.
		 *
		 * @method contents
		 * @return {tinymce.dom.DomQuery} New DomQuery instance with all matching elements.
		 */
		contents: function(node) {
			return Tools.toArray((node.nodeName === "iframe" ? node.contentDocument || node.contentWindow.document : node).childNodes);
		}
	}, function(name, fn) {
		DomQuery.fn[name] = function(selector) {
			var self = this, result = [];

			self.each(function() {
				var nodes = fn.call(result, this, selector, result);

				if (nodes) {
					if (DomQuery.isArray(nodes)) {
						result.push.apply(result, nodes);
					} else {
						result.push(nodes);
					}
				}
			});

			// If traversing on multiple elements we might get the same elements twice
			if (this.length > 1) {
				if (!skipUniques[name]) {
					result = DomQuery.unique(result);
				}

				if (name.indexOf('parents') === 0) {
					result = result.reverse();
				}
			}

			result = DomQuery(result);

			if (selector) {
				return result.filter(selector);
			}

			return result;
		};
	});

	each({
		/**
		 * Returns a new collection with the all the parents until the matching selector/element
		 * of each item in current collection matching the optional selector.
		 *
		 * @method parentsUntil
		 * @param {String/Element/tinymce.dom.DomQuery} until Until the matching selector or element.
		 * @return {tinymce.dom.DomQuery} New DomQuery instance with all matching parents.
		 */
		parentsUntil: function(node, until) {
			return dir(node, "parentNode", until);
		},

		/**
		 * Returns a new collection with all next siblings of each item in current collection matching the optional selector.
		 *
		 * @method nextUntil
		 * @param {String/Element/tinymce.dom.DomQuery} until Until the matching selector or element.
		 * @return {tinymce.dom.DomQuery} New DomQuery instance with all matching elements.
		 */
		nextUntil: function(node, until) {
			return sibling(node, 'nextSibling', 1, until).slice(1);
		},

		/**
		 * Returns a new collection with all previous siblings of each item in current collection matching the optional selector.
		 *
		 * @method prevUntil
		 * @param {String/Element/tinymce.dom.DomQuery} until Until the matching selector or element.
		 * @return {tinymce.dom.DomQuery} New DomQuery instance with all matching elements.
		 */
		prevUntil: function(node, until) {
			return sibling(node, 'previousSibling', 1, until).slice(1);
		}
	}, function(name, fn) {
		DomQuery.fn[name] = function(selector, filter) {
			var self = this, result = [];

			self.each(function() {
				var nodes = fn.call(result, this, selector, result);

				if (nodes) {
					if (DomQuery.isArray(nodes)) {
						result.push.apply(result, nodes);
					} else {
						result.push(nodes);
					}
				}
			});

			// If traversing on multiple elements we might get the same elements twice
			if (this.length > 1) {
				result = DomQuery.unique(result);

				if (name.indexOf('parents') === 0 || name === 'prevUntil') {
					result = result.reverse();
				}
			}

			result = DomQuery(result);

			if (filter) {
				return result.filter(filter);
			}

			return result;
		};
	});

	/**
	 * Returns true/false if the current set items matches the selector.
	 *
	 * @method is
	 * @param {String} selector Selector to match the elements against.
	 * @return {Boolean} True/false if the current set matches the selector.
	 */
	DomQuery.fn.is = function(selector) {
		return !!selector && this.filter(selector).length > 0;
	};

	DomQuery.fn.init.prototype = DomQuery.fn;

	DomQuery.overrideDefaults = function(callback) {
		var defaults;

		function sub(selector, context) {
			defaults = defaults || callback();

			if (arguments.length === 0) {
				selector = defaults.element;
			}

			if (!context) {
				context = defaults.context;
			}

			return new sub.fn.init(selector, context);
		}

		DomQuery.extend(sub, this);

		return sub;
	};

	function appendHooks(targetHooks, prop, hooks) {
		each(hooks, function(name, func) {
			targetHooks[name] = targetHooks[name] || {};
			targetHooks[name][prop] = func;
		});
	}

	if (Env.ie && Env.ie < 8) {
		appendHooks(attrHooks, 'get', {
			maxlength: function(elm) {
				var value = elm.maxLength;

				if (value === 0x7fffffff) {
					return undef;
				}

				return value;
			},

			size: function(elm) {
				var value = elm.size;

				if (value === 20) {
					return undef;
				}

				return value;
			},

			'class': function(elm) {
				return elm.className;
			},

			style: function(elm) {
				var value = elm.style.cssText;

				if (value.length === 0) {
					return undef;
				}

				return value;
			}
		});

		appendHooks(attrHooks, 'set', {
			'class': function(elm, value) {
				elm.className = value;
			},

			style: function(elm, value) {
				elm.style.cssText = value;
			}
		});
	}

	if (Env.ie && Env.ie < 9) {
		/*jshint sub:true */
		/*eslint dot-notation: 0*/
		cssFix['float'] = 'styleFloat';

		appendHooks(cssHooks, 'set', {
			opacity: function(elm, value) {
				var style = elm.style;

				if (value === null || value === '') {
					style.removeAttribute('filter');
				} else {
					style.zoom = 1;
					style.filter = 'alpha(opacity=' + (value * 100) + ')';
				}
			}
		});
	}

	DomQuery.attrHooks = attrHooks;
	DomQuery.cssHooks = cssHooks;

	return DomQuery;
});

// Included from: js/tinymce/classes/html/Styles.js

/**
 * Styles.js
 *
 * Released under LGPL License.
 * Copyright (c) 1999-2015 Ephox Corp. All rights reserved
 *
 * License: http://www.tinymce.com/license
 * Contributing: http://www.tinymce.com/contributing
 */

/**
 * This class is used to parse CSS styles it also compresses styles to reduce the output size.
 *
 * @example
 * var Styles = new tinymce.html.Styles({
 *    url_converter: function(url) {
 *       return url;
 *    }
 * });
 *
 * styles = Styles.parse('border: 1px solid red');
 * styles.color = 'red';
 *
 * console.log(new tinymce.html.StyleSerializer().serialize(styles));
 *
 * @class tinymce.html.Styles
 * @version 3.4
 */
define("tinymce/html/Styles", [], function() {
	return function(settings, schema) {
		/*jshint maxlen:255 */
		/*eslint max-len:0 */
		var rgbRegExp = /rgb\s*\(\s*([0-9]+)\s*,\s*([0-9]+)\s*,\s*([0-9]+)\s*\)/gi,
			urlOrStrRegExp = /(?:url(?:(?:\(\s*\"([^\"]+)\"\s*\))|(?:\(\s*\'([^\']+)\'\s*\))|(?:\(\s*([^)\s]+)\s*\))))|(?:\'([^\']+)\')|(?:\"([^\"]+)\")/gi,
			styleRegExp = /\s*([^:]+):\s*([^;]+);?/g,
			trimRightRegExp = /\s+$/,
			undef, i, encodingLookup = {}, encodingItems, validStyles, invalidStyles, invisibleChar = '\uFEFF';

		settings = settings || {};

		if (schema) {
			validStyles = schema.getValidStyles();
			invalidStyles = schema.getInvalidStyles();
		}

		encodingItems = ('\\" \\\' \\; \\: ; : ' + invisibleChar).split(' ');
		for (i = 0; i < encodingItems.length; i++) {
			encodingLookup[encodingItems[i]] = invisibleChar + i;
			encodingLookup[invisibleChar + i] = encodingItems[i];
		}

		function toHex(match, r, g, b) {
			function hex(val) {
				val = parseInt(val, 10).toString(16);

				return val.length > 1 ? val : '0' + val; // 0 -> 00
			}

			return '#' + hex(r) + hex(g) + hex(b);
		}

		return {
			/**
			 * Parses the specified RGB color value and returns a hex version of that color.
			 *
			 * @method toHex
			 * @param {String} color RGB string value like rgb(1,2,3)
			 * @return {String} Hex version of that RGB value like #FF00FF.
			 */
			toHex: function(color) {
				return color.replace(rgbRegExp, toHex);
			},

			/**
			 * Parses the specified style value into an object collection. This parser will also
			 * merge and remove any redundant items that browsers might have added. It will also convert non hex
			 * colors to hex values. Urls inside the styles will also be converted to absolute/relative based on settings.
			 *
			 * @method parse
			 * @param {String} css Style value to parse for example: border:1px solid red;.
			 * @return {Object} Object representation of that style like {border: '1px solid red'}
			 */
			parse: function(css) {
				var styles = {}, matches, name, value, isEncoded, urlConverter = settings.url_converter;
				var urlConverterScope = settings.url_converter_scope || this;

				function compress(prefix, suffix, noJoin) {
					var top, right, bottom, left;

					top = styles[prefix + '-top' + suffix];
					if (!top) {
						return;
					}

					right = styles[prefix + '-right' + suffix];
					if (!right) {
						return;
					}

					bottom = styles[prefix + '-bottom' + suffix];
					if (!bottom) {
						return;
					}

					left = styles[prefix + '-left' + suffix];
					if (!left) {
						return;
					}

					var box = [top, right, bottom, left];
					i = box.length - 1;
					while (i--) {
						if (box[i] !== box[i + 1]) {
							break;
						}
					}

					if (i > -1 && noJoin) {
						return;
					}

					styles[prefix + suffix] = i == -1 ? box[0] : box.join(' ');
					delete styles[prefix + '-top' + suffix];
					delete styles[prefix + '-right' + suffix];
					delete styles[prefix + '-bottom' + suffix];
					delete styles[prefix + '-left' + suffix];
				}

				/**
				 * Checks if the specific style can be compressed in other words if all border-width are equal.
				 */
				function canCompress(key) {
					var value = styles[key], i;

					if (!value) {
						return;
					}

					value = value.split(' ');
					i = value.length;
					while (i--) {
						if (value[i] !== value[0]) {
							return false;
						}
					}

					styles[key] = value[0];

					return true;
				}

				/**
				 * Compresses multiple styles into one style.
				 */
				function compress2(target, a, b, c) {
					if (!canCompress(a)) {
						return;
					}

					if (!canCompress(b)) {
						return;
					}

					if (!canCompress(c)) {
						return;
					}

					// Compress
					styles[target] = styles[a] + ' ' + styles[b] + ' ' + styles[c];
					delete styles[a];
					delete styles[b];
					delete styles[c];
				}

				// Encodes the specified string by replacing all \" \' ; : with _<num>
				function encode(str) {
					isEncoded = true;

					return encodingLookup[str];
				}

				// Decodes the specified string by replacing all _<num> with it's original value \" \' etc
				// It will also decode the \" \' if keep_slashes is set to fale or omitted
				function decode(str, keep_slashes) {
					if (isEncoded) {
						str = str.replace(/\uFEFF[0-9]/g, function(str) {
							return encodingLookup[str];
						});
					}

					if (!keep_slashes) {
						str = str.replace(/\\([\'\";:])/g, "$1");
					}

					return str;
				}

				function processUrl(match, url, url2, url3, str, str2) {
					str = str || str2;

					if (str) {
						str = decode(str);

						// Force strings into single quote format
						return "'" + str.replace(/\'/g, "\\'") + "'";
					}

					url = decode(url || url2 || url3);

					if (!settings.allow_script_urls) {
						var scriptUrl = url.replace(/[\s\r\n]+/, '');

						if (/(java|vb)script:/i.test(scriptUrl)) {
							return "";
						}

						if (!settings.allow_svg_data_urls && /^data:image\/svg/i.test(scriptUrl)) {
							return "";
						}
					}

					// Convert the URL to relative/absolute depending on config
					if (urlConverter) {
						url = urlConverter.call(urlConverterScope, url, 'style');
					}

					// Output new URL format
					return "url('" + url.replace(/\'/g, "\\'") + "')";
				}

				if (css) {
					css = css.replace(/[\u0000-\u001F]/g, '');

					// Encode \" \' % and ; and : inside strings so they don't interfere with the style parsing
					css = css.replace(/\\[\"\';:\uFEFF]/g, encode).replace(/\"[^\"]+\"|\'[^\']+\'/g, function(str) {
						return str.replace(/[;:]/g, encode);
					});

					// Parse styles
					while ((matches = styleRegExp.exec(css))) {
						name = matches[1].replace(trimRightRegExp, '').toLowerCase();
						value = matches[2].replace(trimRightRegExp, '');

						// Decode escaped sequences like \65 -> e
						/*jshint loopfunc:true*/
						/*eslint no-loop-func:0 */
						value = value.replace(/\\[0-9a-f]+/g, function(e) {
							return String.fromCharCode(parseInt(e.substr(1), 16));
						});

						if (name && value.length > 0) {
							// Don't allow behavior name or expression/comments within the values
							if (!settings.allow_script_urls && (name == "behavior" || /expression\s*\(|\/\*|\*\//.test(value))) {
								continue;
							}

							// Opera will produce 700 instead of bold in their style values
							if (name === 'font-weight' && value === '700') {
								value = 'bold';
							} else if (name === 'color' || name === 'background-color') { // Lowercase colors like RED
								value = value.toLowerCase();
							}

							// Convert RGB colors to HEX
							value = value.replace(rgbRegExp, toHex);

							// Convert URLs and force them into url('value') format
							value = value.replace(urlOrStrRegExp, processUrl);
							styles[name] = isEncoded ? decode(value, true) : value;
						}

						styleRegExp.lastIndex = matches.index + matches[0].length;
					}
					// Compress the styles to reduce it's size for example IE will expand styles
					compress("border", "", true);
					compress("border", "-width");
					compress("border", "-color");
					compress("border", "-style");
					compress("padding", "");
					compress("margin", "");
					compress2('border', 'border-width', 'border-style', 'border-color');

					// Remove pointless border, IE produces these
					if (styles.border === 'medium none') {
						delete styles.border;
					}

					// IE 11 will produce a border-image: none when getting the style attribute from <p style="border: 1px solid red"></p>
					// So lets asume it shouldn't be there
					if (styles['border-image'] === 'none') {
						delete styles['border-image'];
					}
				}

				return styles;
			},

			/**
			 * Serializes the specified style object into a string.
			 *
			 * @method serialize
			 * @param {Object} styles Object to serialize as string for example: {border: '1px solid red'}
			 * @param {String} elementName Optional element name, if specified only the styles that matches the schema will be serialized.
			 * @return {String} String representation of the style object for example: border: 1px solid red.
			 */
			serialize: function(styles, elementName) {
				var css = '', name, value;

				function serializeStyles(name) {
					var styleList, i, l, value;

					styleList = validStyles[name];
					if (styleList) {
						for (i = 0, l = styleList.length; i < l; i++) {
							name = styleList[i];
							value = styles[name];

							if (value !== undef && value.length > 0) {
								css += (css.length > 0 ? ' ' : '') + name + ': ' + value + ';';
							}
						}
					}
				}

				function isValid(name, elementName) {
					var styleMap;

					styleMap = invalidStyles['*'];
					if (styleMap && styleMap[name]) {
						return false;
					}

					styleMap = invalidStyles[elementName];
					if (styleMap && styleMap[name]) {
						return false;
					}

					return true;
				}

				// Serialize styles according to schema
				if (elementName && validStyles) {
					// Serialize global styles and element specific styles
					serializeStyles('*');
					serializeStyles(elementName);
				} else {
					// Output the styles in the order they are inside the object
					for (name in styles) {
						value = styles[name];

						if (value !== undef && value.length > 0) {
							if (!invalidStyles || isValid(name, elementName)) {
								css += (css.length > 0 ? ' ' : '') + name + ': ' + value + ';';
							}
						}
					}
				}

				return css;
			}
		};
	};
});

// Included from: js/tinymce/classes/dom/TreeWalker.js

/**
 * TreeWalker.js
 *
 * Released under LGPL License.
 * Copyright (c) 1999-2015 Ephox Corp. All rights reserved
 *
 * License: http://www.tinymce.com/license
 * Contributing: http://www.tinymce.com/contributing
 */

/**
 * TreeWalker class enables you to walk the DOM in a linear manner.
 *
 * @class tinymce.dom.TreeWalker
 * @example
 * var walker = new tinymce.dom.TreeWalker(startNode);
 *
 * do {
 *     console.log(walker.current());
 * } while (walker.next());
 */
define("tinymce/dom/TreeWalker", [], function() {
	/**
	 * Constructs a new TreeWalker instance.
	 *
	 * @constructor
	 * @method TreeWalker
	 * @param {Node} startNode Node to start walking from.
	 * @param {node} rootNode Optional root node to never walk out of.
	 */
	return function(startNode, rootNode) {
		var node = startNode;

		function findSibling(node, startName, siblingName, shallow) {
			var sibling, parent;

			if (node) {
				// Walk into nodes if it has a start
				if (!shallow && node[startName]) {
					return node[startName];
				}

				// Return the sibling if it has one
				if (node != rootNode) {
					sibling = node[siblingName];
					if (sibling) {
						return sibling;
					}

					// Walk up the parents to look for siblings
					for (parent = node.parentNode; parent && parent != rootNode; parent = parent.parentNode) {
						sibling = parent[siblingName];
						if (sibling) {
							return sibling;
						}
					}
				}
			}
		}

		/**
		 * Returns the current node.
		 *
		 * @method current
		 * @return {Node} Current node where the walker is.
		 */
		this.current = function() {
			return node;
		};

		/**
		 * Walks to the next node in tree.
		 *
		 * @method next
		 * @return {Node} Current node where the walker is after moving to the next node.
		 */
		this.next = function(shallow) {
			node = findSibling(node, 'firstChild', 'nextSibling', shallow);
			return node;
		};

		/**
		 * Walks to the previous node in tree.
		 *
		 * @method prev
		 * @return {Node} Current node where the walker is after moving to the previous node.
		 */
		this.prev = function(shallow) {
			node = findSibling(node, 'lastChild', 'previousSibling', shallow);
			return node;
		};
	};
});

// Included from: js/tinymce/classes/dom/Range.js

/**
 * Range.js
 *
 * Released under LGPL License.
 * Copyright (c) 1999-2015 Ephox Corp. All rights reserved
 *
 * License: http://www.tinymce.com/license
 * Contributing: http://www.tinymce.com/contributing
 */

/**
 * Old IE Range.
 *
 * @private
 * @class tinymce.dom.Range
 */
define("tinymce/dom/Range", [
	"tinymce/util/Tools"
], function(Tools) {
	// Range constructor
	function Range(dom) {
		var self = this,
			doc = dom.doc,
			EXTRACT = 0,
			CLONE = 1,
			DELETE = 2,
			TRUE = true,
			FALSE = false,
			START_OFFSET = 'startOffset',
			START_CONTAINER = 'startContainer',
			END_CONTAINER = 'endContainer',
			END_OFFSET = 'endOffset',
			extend = Tools.extend,
			nodeIndex = dom.nodeIndex;

		function createDocumentFragment() {
			return doc.createDocumentFragment();
		}

		function setStart(n, o) {
			_setEndPoint(TRUE, n, o);
		}

		function setEnd(n, o) {
			_setEndPoint(FALSE, n, o);
		}

		function setStartBefore(n) {
			setStart(n.parentNode, nodeIndex(n));
		}

		function setStartAfter(n) {
			setStart(n.parentNode, nodeIndex(n) + 1);
		}

		function setEndBefore(n) {
			setEnd(n.parentNode, nodeIndex(n));
		}

		function setEndAfter(n) {
			setEnd(n.parentNode, nodeIndex(n) + 1);
		}

		function collapse(ts) {
			if (ts) {
				self[END_CONTAINER] = self[START_CONTAINER];
				self[END_OFFSET] = self[START_OFFSET];
			} else {
				self[START_CONTAINER] = self[END_CONTAINER];
				self[START_OFFSET] = self[END_OFFSET];
			}

			self.collapsed = TRUE;
		}

		function selectNode(n) {
			setStartBefore(n);
			setEndAfter(n);
		}

		function selectNodeContents(n) {
			setStart(n, 0);
			setEnd(n, n.nodeType === 1 ? n.childNodes.length : n.nodeValue.length);
		}

		function compareBoundaryPoints(h, r) {
			var sc = self[START_CONTAINER], so = self[START_OFFSET], ec = self[END_CONTAINER], eo = self[END_OFFSET],
			rsc = r.startContainer, rso = r.startOffset, rec = r.endContainer, reo = r.endOffset;

			// Check START_TO_START
			if (h === 0) {
				return _compareBoundaryPoints(sc, so, rsc, rso);
			}

			// Check START_TO_END
			if (h === 1) {
				return _compareBoundaryPoints(ec, eo, rsc, rso);
			}

			// Check END_TO_END
			if (h === 2) {
				return _compareBoundaryPoints(ec, eo, rec, reo);
			}

			// Check END_TO_START
			if (h === 3) {
				return _compareBoundaryPoints(sc, so, rec, reo);
			}
		}

		function deleteContents() {
			_traverse(DELETE);
		}

		function extractContents() {
			return _traverse(EXTRACT);
		}

		function cloneContents() {
			return _traverse(CLONE);
		}

		function insertNode(n) {
			var startContainer = this[START_CONTAINER],
				startOffset = this[START_OFFSET], nn, o;

			// Node is TEXT_NODE or CDATA
			if ((startContainer.nodeType === 3 || startContainer.nodeType === 4) && startContainer.nodeValue) {
				if (!startOffset) {
					// At the start of text
					startContainer.parentNode.insertBefore(n, startContainer);
				} else if (startOffset >= startContainer.nodeValue.length) {
					// At the end of text
					dom.insertAfter(n, startContainer);
				} else {
					// Middle, need to split
					nn = startContainer.splitText(startOffset);
					startContainer.parentNode.insertBefore(n, nn);
				}
			} else {
				// Insert element node
				if (startContainer.childNodes.length > 0) {
					o = startContainer.childNodes[startOffset];
				}

				if (o) {
					startContainer.insertBefore(n, o);
				} else {
					if (startContainer.nodeType == 3) {
						dom.insertAfter(n, startContainer);
					} else {
						startContainer.appendChild(n);
					}
				}
			}
		}

		function surroundContents(n) {
			var f = self.extractContents();

			self.insertNode(n);
			n.appendChild(f);
			self.selectNode(n);
		}

		function cloneRange() {
			return extend(new Range(dom), {
				startContainer: self[START_CONTAINER],
				startOffset: self[START_OFFSET],
				endContainer: self[END_CONTAINER],
				endOffset: self[END_OFFSET],
				collapsed: self.collapsed,
				commonAncestorContainer: self.commonAncestorContainer
			});
		}

		// Private methods

		function _getSelectedNode(container, offset) {
			var child;

			if (container.nodeType == 3 /* TEXT_NODE */) {
				return container;
			}

			if (offset < 0) {
				return container;
			}

			child = container.firstChild;
			while (child && offset > 0) {
				--offset;
				child = child.nextSibling;
			}

			if (child) {
				return child;
			}

			return container;
		}

		function _isCollapsed() {
			return (self[START_CONTAINER] == self[END_CONTAINER] && self[START_OFFSET] == self[END_OFFSET]);
		}

		function _compareBoundaryPoints(containerA, offsetA, containerB, offsetB) {
			var c, offsetC, n, cmnRoot, childA, childB;

			// In the first case the boundary-points have the same container. A is before B
			// if its offset is less than the offset of B, A is equal to B if its offset is
			// equal to the offset of B, and A is after B if its offset is greater than the
			// offset of B.
			if (containerA == containerB) {
				if (offsetA == offsetB) {
					return 0; // equal
				}

				if (offsetA < offsetB) {
					return -1; // before
				}

				return 1; // after
			}

			// In the second case a child node C of the container of A is an ancestor
			// container of B. In this case, A is before B if the offset of A is less than or
			// equal to the index of the child node C and A is after B otherwise.
			c = containerB;
			while (c && c.parentNode != containerA) {
				c = c.parentNode;
			}

			if (c) {
				offsetC = 0;
				n = containerA.firstChild;

				while (n != c && offsetC < offsetA) {
					offsetC++;
					n = n.nextSibling;
				}

				if (offsetA <= offsetC) {
					return -1; // before
				}

				return 1; // after
			}

			// In the third case a child node C of the container of B is an ancestor container
			// of A. In this case, A is before B if the index of the child node C is less than
			// the offset of B and A is after B otherwise.
			c = containerA;
			while (c && c.parentNode != containerB) {
				c = c.parentNode;
			}

			if (c) {
				offsetC = 0;
				n = containerB.firstChild;

				while (n != c && offsetC < offsetB) {
					offsetC++;
					n = n.nextSibling;
				}

				if (offsetC < offsetB) {
					return -1; // before
				}

				return 1; // after
			}

			// In the fourth case, none of three other cases hold: the containers of A and B
			// are siblings or descendants of sibling nodes. In this case, A is before B if
			// the container of A is before the container of B in a pre-order traversal of the
			// Ranges' context tree and A is after B otherwise.
			cmnRoot = dom.findCommonAncestor(containerA, containerB);
			childA = containerA;

			while (childA && childA.parentNode != cmnRoot) {
				childA = childA.parentNode;
			}

			if (!childA) {
				childA = cmnRoot;
			}

			childB = containerB;
			while (childB && childB.parentNode != cmnRoot) {
				childB = childB.parentNode;
			}

			if (!childB) {
				childB = cmnRoot;
			}

			if (childA == childB) {
				return 0; // equal
			}

			n = cmnRoot.firstChild;
			while (n) {
				if (n == childA) {
					return -1; // before
				}

				if (n == childB) {
					return 1; // after
				}

				n = n.nextSibling;
			}
		}

		function _setEndPoint(st, n, o) {
			var ec, sc;

			if (st) {
				self[START_CONTAINER] = n;
				self[START_OFFSET] = o;
			} else {
				self[END_CONTAINER] = n;
				self[END_OFFSET] = o;
			}

			// If one boundary-point of a Range is set to have a root container
			// other than the current one for the Range, the Range is collapsed to
			// the new position. This enforces the restriction that both boundary-
			// points of a Range must have the same root container.
			ec = self[END_CONTAINER];
			while (ec.parentNode) {
				ec = ec.parentNode;
			}

			sc = self[START_CONTAINER];
			while (sc.parentNode) {
				sc = sc.parentNode;
			}

			if (sc == ec) {
				// The start position of a Range is guaranteed to never be after the
				// end position. To enforce this restriction, if the start is set to
				// be at a position after the end, the Range is collapsed to that
				// position.
				if (_compareBoundaryPoints(self[START_CONTAINER], self[START_OFFSET], self[END_CONTAINER], self[END_OFFSET]) > 0) {
					self.collapse(st);
				}
			} else {
				self.collapse(st);
			}

			self.collapsed = _isCollapsed();
			self.commonAncestorContainer = dom.findCommonAncestor(self[START_CONTAINER], self[END_CONTAINER]);
		}

		function _traverse(how) {
			var c, endContainerDepth = 0, startContainerDepth = 0, p, depthDiff, startNode, endNode, sp, ep;

			if (self[START_CONTAINER] == self[END_CONTAINER]) {
				return _traverseSameContainer(how);
			}

			for (c = self[END_CONTAINER], p = c.parentNode; p; c = p, p = p.parentNode) {
				if (p == self[START_CONTAINER]) {
					return _traverseCommonStartContainer(c, how);
				}

				++endContainerDepth;
			}

			for (c = self[START_CONTAINER], p = c.parentNode; p; c = p, p = p.parentNode) {
				if (p == self[END_CONTAINER]) {
					return _traverseCommonEndContainer(c, how);
				}

				++startContainerDepth;
			}

			depthDiff = startContainerDepth - endContainerDepth;

			startNode = self[START_CONTAINER];
			while (depthDiff > 0) {
				startNode = startNode.parentNode;
				depthDiff--;
			}

			endNode = self[END_CONTAINER];
			while (depthDiff < 0) {
				endNode = endNode.parentNode;
				depthDiff++;
			}

			// ascend the ancestor hierarchy until we have a common parent.
			for (sp = startNode.parentNode, ep = endNode.parentNode; sp != ep; sp = sp.parentNode, ep = ep.parentNode) {
				startNode = sp;
				endNode = ep;
			}

			return _traverseCommonAncestors(startNode, endNode, how);
		}

		function _traverseSameContainer(how) {
			var frag, s, sub, n, cnt, sibling, xferNode, start, len;

			if (how != DELETE) {
				frag = createDocumentFragment();
			}

			// If selection is empty, just return the fragment
			if (self[START_OFFSET] == self[END_OFFSET]) {
				return frag;
			}

			// Text node needs special case handling
			if (self[START_CONTAINER].nodeType == 3 /* TEXT_NODE */) {
				// get the substring
				s = self[START_CONTAINER].nodeValue;
				sub = s.substring(self[START_OFFSET], self[END_OFFSET]);

				// set the original text node to its new value
				if (how != CLONE) {
					n = self[START_CONTAINER];
					start = self[START_OFFSET];
					len = self[END_OFFSET] - self[START_OFFSET];

					if (start === 0 && len >= n.nodeValue.length - 1) {
						n.parentNode.removeChild(n);
					} else {
						n.deleteData(start, len);
					}

					// Nothing is partially selected, so collapse to start point
					self.collapse(TRUE);
				}

				if (how == DELETE) {
					return;
				}

				if (sub.length > 0) {
					frag.appendChild(doc.createTextNode(sub));
				}

				return frag;
			}

			// Copy nodes between the start/end offsets.
			n = _getSelectedNode(self[START_CONTAINER], self[START_OFFSET]);
			cnt = self[END_OFFSET] - self[START_OFFSET];

			while (n && cnt > 0) {
				sibling = n.nextSibling;
				xferNode = _traverseFullySelected(n, how);

				if (frag) {
					frag.appendChild(xferNode);
				}

				--cnt;
				n = sibling;
			}

			// Nothing is partially selected, so collapse to start point
			if (how != CLONE) {
				self.collapse(TRUE);
			}

			return frag;
		}

		function _traverseCommonStartContainer(endAncestor, how) {
			var frag, n, endIdx, cnt, sibling, xferNode;

			if (how != DELETE) {
				frag = createDocumentFragment();
			}

			n = _traverseRightBoundary(endAncestor, how);

			if (frag) {
				frag.appendChild(n);
			}

			endIdx = nodeIndex(endAncestor);
			cnt = endIdx - self[START_OFFSET];

			if (cnt <= 0) {
				// Collapse to just before the endAncestor, which
				// is partially selected.
				if (how != CLONE) {
					self.setEndBefore(endAncestor);
					self.collapse(FALSE);
				}

				return frag;
			}

			n = endAncestor.previousSibling;
			while (cnt > 0) {
				sibling = n.previousSibling;
				xferNode = _traverseFullySelected(n, how);

				if (frag) {
					frag.insertBefore(xferNode, frag.firstChild);
				}

				--cnt;
				n = sibling;
			}

			// Collapse to just before the endAncestor, which
			// is partially selected.
			if (how != CLONE) {
				self.setEndBefore(endAncestor);
				self.collapse(FALSE);
			}

			return frag;
		}

		function _traverseCommonEndContainer(startAncestor, how) {
			var frag, startIdx, n, cnt, sibling, xferNode;

			if (how != DELETE) {
				frag = createDocumentFragment();
			}

			n = _traverseLeftBoundary(startAncestor, how);
			if (frag) {
				frag.appendChild(n);
			}

			startIdx = nodeIndex(startAncestor);
			++startIdx; // Because we already traversed it

			cnt = self[END_OFFSET] - startIdx;
			n = startAncestor.nextSibling;
			while (n && cnt > 0) {
				sibling = n.nextSibling;
				xferNode = _traverseFullySelected(n, how);

				if (frag) {
					frag.appendChild(xferNode);
				}

				--cnt;
				n = sibling;
			}

			if (how != CLONE) {
				self.setStartAfter(startAncestor);
				self.collapse(TRUE);
			}

			return frag;
		}

		function _traverseCommonAncestors(startAncestor, endAncestor, how) {
			var n, frag, startOffset, endOffset, cnt, sibling, nextSibling;

			if (how != DELETE) {
				frag = createDocumentFragment();
			}

			n = _traverseLeftBoundary(startAncestor, how);
			if (frag) {
				frag.appendChild(n);
			}

			startOffset = nodeIndex(startAncestor);
			endOffset = nodeIndex(endAncestor);
			++startOffset;

			cnt = endOffset - startOffset;
			sibling = startAncestor.nextSibling;

			while (cnt > 0) {
				nextSibling = sibling.nextSibling;
				n = _traverseFullySelected(sibling, how);

				if (frag) {
					frag.appendChild(n);
				}

				sibling = nextSibling;
				--cnt;
			}

			n = _traverseRightBoundary(endAncestor, how);

			if (frag) {
				frag.appendChild(n);
			}

			if (how != CLONE) {
				self.setStartAfter(startAncestor);
				self.collapse(TRUE);
			}

			return frag;
		}

		function _traverseRightBoundary(root, how) {
			var next = _getSelectedNode(self[END_CONTAINER], self[END_OFFSET] - 1), parent, clonedParent;
			var prevSibling, clonedChild, clonedGrandParent, isFullySelected = next != self[END_CONTAINER];

			if (next == root) {
				return _traverseNode(next, isFullySelected, FALSE, how);
			}

			parent = next.parentNode;
			clonedParent = _traverseNode(parent, FALSE, FALSE, how);

			while (parent) {
				while (next) {
					prevSibling = next.previousSibling;
					clonedChild = _traverseNode(next, isFullySelected, FALSE, how);

					if (how != DELETE) {
						clonedParent.insertBefore(clonedChild, clonedParent.firstChild);
					}

					isFullySelected = TRUE;
					next = prevSibling;
				}

				if (parent == root) {
					return clonedParent;
				}

				next = parent.previousSibling;
				parent = parent.parentNode;

				clonedGrandParent = _traverseNode(parent, FALSE, FALSE, how);

				if (how != DELETE) {
					clonedGrandParent.appendChild(clonedParent);
				}

				clonedParent = clonedGrandParent;
			}
		}

		function _traverseLeftBoundary(root, how) {
			var next = _getSelectedNode(self[START_CONTAINER], self[START_OFFSET]), isFullySelected = next != self[START_CONTAINER];
			var parent, clonedParent, nextSibling, clonedChild, clonedGrandParent;

			if (next == root) {
				return _traverseNode(next, isFullySelected, TRUE, how);
			}

			parent = next.parentNode;
			clonedParent = _traverseNode(parent, FALSE, TRUE, how);

			while (parent) {
				while (next) {
					nextSibling = next.nextSibling;
					clonedChild = _traverseNode(next, isFullySelected, TRUE, how);

					if (how != DELETE) {
						clonedParent.appendChild(clonedChild);
					}

					isFullySelected = TRUE;
					next = nextSibling;
				}

				if (parent == root) {
					return clonedParent;
				}

				next = parent.nextSibling;
				parent = parent.parentNode;

				clonedGrandParent = _traverseNode(parent, FALSE, TRUE, how);

				if (how != DELETE) {
					clonedGrandParent.appendChild(clonedParent);
				}

				clonedParent = clonedGrandParent;
			}
		}

		function _traverseNode(n, isFullySelected, isLeft, how) {
			var txtValue, newNodeValue, oldNodeValue, offset, newNode;

			if (isFullySelected) {
				return _traverseFullySelected(n, how);
			}

			if (n.nodeType == 3 /* TEXT_NODE */) {
				txtValue = n.nodeValue;

				if (isLeft) {
					offset = self[START_OFFSET];
					newNodeValue = txtValue.substring(offset);
					oldNodeValue = txtValue.substring(0, offset);
				} else {
					offset = self[END_OFFSET];
					newNodeValue = txtValue.substring(0, offset);
					oldNodeValue = txtValue.substring(offset);
				}

				if (how != CLONE) {
					n.nodeValue = oldNodeValue;
				}

				if (how == DELETE) {
					return;
				}

				newNode = dom.clone(n, FALSE);
				newNode.nodeValue = newNodeValue;

				return newNode;
			}

			if (how == DELETE) {
				return;
			}

			return dom.clone(n, FALSE);
		}

		function _traverseFullySelected(n, how) {
			if (how != DELETE) {
				return how == CLONE ? dom.clone(n, TRUE) : n;
			}

			n.parentNode.removeChild(n);
		}

		function toStringIE() {
			return dom.create('body', null, cloneContents()).outerText;
		}

		extend(self, {
			// Inital states
			startContainer: doc,
			startOffset: 0,
			endContainer: doc,
			endOffset: 0,
			collapsed: TRUE,
			commonAncestorContainer: doc,

			// Range constants
			START_TO_START: 0,
			START_TO_END: 1,
			END_TO_END: 2,
			END_TO_START: 3,

			// Public methods
			setStart: setStart,
			setEnd: setEnd,
			setStartBefore: setStartBefore,
			setStartAfter: setStartAfter,
			setEndBefore: setEndBefore,
			setEndAfter: setEndAfter,
			collapse: collapse,
			selectNode: selectNode,
			selectNodeContents: selectNodeContents,
			compareBoundaryPoints: compareBoundaryPoints,
			deleteContents: deleteContents,
			extractContents: extractContents,
			cloneContents: cloneContents,
			insertNode: insertNode,
			surroundContents: surroundContents,
			cloneRange: cloneRange,
			toStringIE: toStringIE
		});

		return self;
	}

	// Older IE versions doesn't let you override toString by it's constructor so we have to stick it in the prototype
	Range.prototype.toString = function() {
		return this.toStringIE();
	};

	return Range;
});

// Included from: js/tinymce/classes/html/Entities.js

/**
 * Entities.js
 *
 * Released under LGPL License.
 * Copyright (c) 1999-2015 Ephox Corp. All rights reserved
 *
 * License: http://www.tinymce.com/license
 * Contributing: http://www.tinymce.com/contributing
 */

/*jshint bitwise:false */
/*eslint no-bitwise:0 */

/**
 * Entity encoder class.
 *
 * @class tinymce.html.Entities
 * @static
 * @version 3.4
 */
define("tinymce/html/Entities", [
	"tinymce/util/Tools"
], function(Tools) {
	var makeMap = Tools.makeMap;

	var namedEntities, baseEntities, reverseEntities,
		attrsCharsRegExp = /[&<>\"\u0060\u007E-\uD7FF\uE000-\uFFEF]|[\uD800-\uDBFF][\uDC00-\uDFFF]/g,
		textCharsRegExp = /[<>&\u007E-\uD7FF\uE000-\uFFEF]|[\uD800-\uDBFF][\uDC00-\uDFFF]/g,
		rawCharsRegExp = /[<>&\"\']/g,
		entityRegExp = /&#([a-z0-9]+);?|&([a-z0-9]+);/gi,
		asciiMap = {
			128: "\u20AC", 130: "\u201A", 131: "\u0192", 132: "\u201E", 133: "\u2026", 134: "\u2020",
			135: "\u2021", 136: "\u02C6", 137: "\u2030", 138: "\u0160", 139: "\u2039", 140: "\u0152",
			142: "\u017D", 145: "\u2018", 146: "\u2019", 147: "\u201C", 148: "\u201D", 149: "\u2022",
			150: "\u2013", 151: "\u2014", 152: "\u02DC", 153: "\u2122", 154: "\u0161", 155: "\u203A",
			156: "\u0153", 158: "\u017E", 159: "\u0178"
		};

	// Raw entities
	baseEntities = {
		'\"': '&quot;', // Needs to be escaped since the YUI compressor would otherwise break the code
		"'": '&#39;',
		'<': '&lt;',
		'>': '&gt;',
		'&': '&amp;',
		'\u0060': '&#96;'
	};

	// Reverse lookup table for raw entities
	reverseEntities = {
		'&lt;': '<',
		'&gt;': '>',
		'&amp;': '&',
		'&quot;': '"',
		'&apos;': "'"
	};

	// Decodes text by using the browser
	function nativeDecode(text) {
		var elm;

		elm = document.createElement("div");
		elm.innerHTML = text;

		return elm.textContent || elm.innerText || text;
	}

	// Build a two way lookup table for the entities
	function buildEntitiesLookup(items, radix) {
		var i, chr, entity, lookup = {};

		if (items) {
			items = items.split(',');
			radix = radix || 10;

			// Build entities lookup table
			for (i = 0; i < items.length; i += 2) {
				chr = String.fromCharCode(parseInt(items[i], radix));

				// Only add non base entities
				if (!baseEntities[chr]) {
					entity = '&' + items[i + 1] + ';';
					lookup[chr] = entity;
					lookup[entity] = chr;
				}
			}

			return lookup;
		}
	}

	// Unpack entities lookup where the numbers are in radix 32 to reduce the size
	namedEntities = buildEntitiesLookup(
		'50,nbsp,51,iexcl,52,cent,53,pound,54,curren,55,yen,56,brvbar,57,sect,58,uml,59,copy,' +
		'5a,ordf,5b,laquo,5c,not,5d,shy,5e,reg,5f,macr,5g,deg,5h,plusmn,5i,sup2,5j,sup3,5k,acute,' +
		'5l,micro,5m,para,5n,middot,5o,cedil,5p,sup1,5q,ordm,5r,raquo,5s,frac14,5t,frac12,5u,frac34,' +
		'5v,iquest,60,Agrave,61,Aacute,62,Acirc,63,Atilde,64,Auml,65,Aring,66,AElig,67,Ccedil,' +
		'68,Egrave,69,Eacute,6a,Ecirc,6b,Euml,6c,Igrave,6d,Iacute,6e,Icirc,6f,Iuml,6g,ETH,6h,Ntilde,' +
		'6i,Ograve,6j,Oacute,6k,Ocirc,6l,Otilde,6m,Ouml,6n,times,6o,Oslash,6p,Ugrave,6q,Uacute,' +
		'6r,Ucirc,6s,Uuml,6t,Yacute,6u,THORN,6v,szlig,70,agrave,71,aacute,72,acirc,73,atilde,74,auml,' +
		'75,aring,76,aelig,77,ccedil,78,egrave,79,eacute,7a,ecirc,7b,euml,7c,igrave,7d,iacute,7e,icirc,' +
		'7f,iuml,7g,eth,7h,ntilde,7i,ograve,7j,oacute,7k,ocirc,7l,otilde,7m,ouml,7n,divide,7o,oslash,' +
		'7p,ugrave,7q,uacute,7r,ucirc,7s,uuml,7t,yacute,7u,thorn,7v,yuml,ci,fnof,sh,Alpha,si,Beta,' +
		'sj,Gamma,sk,Delta,sl,Epsilon,sm,Zeta,sn,Eta,so,Theta,sp,Iota,sq,Kappa,sr,Lambda,ss,Mu,' +
		'st,Nu,su,Xi,sv,Omicron,t0,Pi,t1,Rho,t3,Sigma,t4,Tau,t5,Upsilon,t6,Phi,t7,Chi,t8,Psi,' +
		't9,Omega,th,alpha,ti,beta,tj,gamma,tk,delta,tl,epsilon,tm,zeta,tn,eta,to,theta,tp,iota,' +
		'tq,kappa,tr,lambda,ts,mu,tt,nu,tu,xi,tv,omicron,u0,pi,u1,rho,u2,sigmaf,u3,sigma,u4,tau,' +
		'u5,upsilon,u6,phi,u7,chi,u8,psi,u9,omega,uh,thetasym,ui,upsih,um,piv,812,bull,816,hellip,' +
		'81i,prime,81j,Prime,81u,oline,824,frasl,88o,weierp,88h,image,88s,real,892,trade,89l,alefsym,' +
		'8cg,larr,8ch,uarr,8ci,rarr,8cj,darr,8ck,harr,8dl,crarr,8eg,lArr,8eh,uArr,8ei,rArr,8ej,dArr,' +
		'8ek,hArr,8g0,forall,8g2,part,8g3,exist,8g5,empty,8g7,nabla,8g8,isin,8g9,notin,8gb,ni,8gf,prod,' +
		'8gh,sum,8gi,minus,8gn,lowast,8gq,radic,8gt,prop,8gu,infin,8h0,ang,8h7,and,8h8,or,8h9,cap,8ha,cup,' +
		'8hb,int,8hk,there4,8hs,sim,8i5,cong,8i8,asymp,8j0,ne,8j1,equiv,8j4,le,8j5,ge,8k2,sub,8k3,sup,8k4,' +
		'nsub,8k6,sube,8k7,supe,8kl,oplus,8kn,otimes,8l5,perp,8m5,sdot,8o8,lceil,8o9,rceil,8oa,lfloor,8ob,' +
		'rfloor,8p9,lang,8pa,rang,9ea,loz,9j0,spades,9j3,clubs,9j5,hearts,9j6,diams,ai,OElig,aj,oelig,b0,' +
		'Scaron,b1,scaron,bo,Yuml,m6,circ,ms,tilde,802,ensp,803,emsp,809,thinsp,80c,zwnj,80d,zwj,80e,lrm,' +
		'80f,rlm,80j,ndash,80k,mdash,80o,lsquo,80p,rsquo,80q,sbquo,80s,ldquo,80t,rdquo,80u,bdquo,810,dagger,' +
		'811,Dagger,81g,permil,81p,lsaquo,81q,rsaquo,85c,euro', 32);

	var Entities = {
		/**
		 * Encodes the specified string using raw entities. This means only the required XML base entities will be endoded.
		 *
		 * @method encodeRaw
		 * @param {String} text Text to encode.
		 * @param {Boolean} attr Optional flag to specify if the text is attribute contents.
		 * @return {String} Entity encoded text.
		 */
		encodeRaw: function(text, attr) {
			return text.replace(attr ? attrsCharsRegExp : textCharsRegExp, function(chr) {
				return baseEntities[chr] || chr;
			});
		},

		/**
		 * Encoded the specified text with both the attributes and text entities. This function will produce larger text contents
		 * since it doesn't know if the context is within a attribute or text node. This was added for compatibility
		 * and is exposed as the DOMUtils.encode function.
		 *
		 * @method encodeAllRaw
		 * @param {String} text Text to encode.
		 * @return {String} Entity encoded text.
		 */
		encodeAllRaw: function(text) {
			return ('' + text).replace(rawCharsRegExp, function(chr) {
				return baseEntities[chr] || chr;
			});
		},

		/**
		 * Encodes the specified string using numeric entities. The core entities will be
		 * encoded as named ones but all non lower ascii characters will be encoded into numeric entities.
		 *
		 * @method encodeNumeric
		 * @param {String} text Text to encode.
		 * @param {Boolean} attr Optional flag to specify if the text is attribute contents.
		 * @return {String} Entity encoded text.
		 */
		encodeNumeric: function(text, attr) {
			return text.replace(attr ? attrsCharsRegExp : textCharsRegExp, function(chr) {
				// Multi byte sequence convert it to a single entity
				if (chr.length > 1) {
					return '&#' + (((chr.charCodeAt(0) - 0xD800) * 0x400) + (chr.charCodeAt(1) - 0xDC00) + 0x10000) + ';';
				}

				return baseEntities[chr] || '&#' + chr.charCodeAt(0) + ';';
			});
		},

		/**
		 * Encodes the specified string using named entities. The core entities will be encoded
		 * as named ones but all non lower ascii characters will be encoded into named entities.
		 *
		 * @method encodeNamed
		 * @param {String} text Text to encode.
		 * @param {Boolean} attr Optional flag to specify if the text is attribute contents.
		 * @param {Object} entities Optional parameter with entities to use.
		 * @return {String} Entity encoded text.
		 */
		encodeNamed: function(text, attr, entities) {
			entities = entities || namedEntities;

			return text.replace(attr ? attrsCharsRegExp : textCharsRegExp, function(chr) {
				return baseEntities[chr] || entities[chr] || chr;
			});
		},

		/**
		 * Returns an encode function based on the name(s) and it's optional entities.
		 *
		 * @method getEncodeFunc
		 * @param {String} name Comma separated list of encoders for example named,numeric.
		 * @param {String} entities Optional parameter with entities to use instead of the built in set.
		 * @return {function} Encode function to be used.
		 */
		getEncodeFunc: function(name, entities) {
			entities = buildEntitiesLookup(entities) || namedEntities;

			function encodeNamedAndNumeric(text, attr) {
				return text.replace(attr ? attrsCharsRegExp : textCharsRegExp, function(chr) {
					return baseEntities[chr] || entities[chr] || '&#' + chr.charCodeAt(0) + ';' || chr;
				});
			}

			function encodeCustomNamed(text, attr) {
				return Entities.encodeNamed(text, attr, entities);
			}

			// Replace + with , to be compatible with previous TinyMCE versions
			name = makeMap(name.replace(/\+/g, ','));

			// Named and numeric encoder
			if (name.named && name.numeric) {
				return encodeNamedAndNumeric;
			}

			// Named encoder
			if (name.named) {
				// Custom names
				if (entities) {
					return encodeCustomNamed;
				}

				return Entities.encodeNamed;
			}

			// Numeric
			if (name.numeric) {
				return Entities.encodeNumeric;
			}

			// Raw encoder
			return Entities.encodeRaw;
		},

		/**
		 * Decodes the specified string, this will replace entities with raw UTF characters.
		 *
		 * @method decode
		 * @param {String} text Text to entity decode.
		 * @return {String} Entity decoded string.
		 */
		decode: function(text) {
			return text.replace(entityRegExp, function(all, numeric) {
				if (numeric) {
					if (numeric.charAt(0).toLowerCase() === 'x') {
						numeric = parseInt(numeric.substr(1), 16);
					} else {
						numeric = parseInt(numeric, 10);
					}

					// Support upper UTF
					if (numeric > 0xFFFF) {
						numeric -= 0x10000;

						return String.fromCharCode(0xD800 + (numeric >> 10), 0xDC00 + (numeric & 0x3FF));
					}

					return asciiMap[numeric] || String.fromCharCode(numeric);
				}

				return reverseEntities[all] || namedEntities[all] || nativeDecode(all);
			});
		}
	};

	return Entities;
});

// Included from: js/tinymce/classes/dom/StyleSheetLoader.js

/**
 * StyleSheetLoader.js
 *
 * Released under LGPL License.
 * Copyright (c) 1999-2015 Ephox Corp. All rights reserved
 *
 * License: http://www.tinymce.com/license
 * Contributing: http://www.tinymce.com/contributing
 */

/**
 * This class handles loading of external stylesheets and fires events when these are loaded.
 *
 * @class tinymce.dom.StyleSheetLoader
 * @private
 */
define("tinymce/dom/StyleSheetLoader", [
	"tinymce/util/Tools"
], function(Tools) {
	"use strict";

	return function(document, settings) {
		var idCount = 0, loadedStates = {}, maxLoadTime;

		settings = settings || {};
		maxLoadTime = settings.maxLoadTime || 5000;

		function appendToHead(node) {
			document.getElementsByTagName('head')[0].appendChild(node);
		}

		/**
		 * Loads the specified css style sheet file and call the loadedCallback once it's finished loading.
		 *
		 * @method load
		 * @param {String} url Url to be loaded.
		 * @param {Function} loadedCallback Callback to be executed when loaded.
		 * @param {Function} errorCallback Callback to be executed when failed loading.
		 */
		function load(url, loadedCallback, errorCallback) {
			var link, style, startTime, state;

			function passed() {
				var callbacks = state.passed, i = callbacks.length;

				while (i--) {
					callbacks[i]();
				}

				state.status = 2;
				state.passed = [];
				state.failed = [];
			}

			function failed() {
				var callbacks = state.failed, i = callbacks.length;

				while (i--) {
					callbacks[i]();
				}

				state.status = 3;
				state.passed = [];
				state.failed = [];
			}

			// Sniffs for older WebKit versions that have the link.onload but a broken one
			function isOldWebKit() {
				var webKitChunks = navigator.userAgent.match(/WebKit\/(\d*)/);
				return !!(webKitChunks && webKitChunks[1] < 536);
			}

			// Calls the waitCallback until the test returns true or the timeout occurs
			function wait(testCallback, waitCallback) {
				if (!testCallback()) {
					// Wait for timeout
					if ((new Date().getTime()) - startTime < maxLoadTime) {
						window.setTimeout(waitCallback, 0);
					} else {
						failed();
					}
				}
			}

			// Workaround for WebKit that doesn't properly support the onload event for link elements
			// Or WebKit that fires the onload event before the StyleSheet is added to the document
			function waitForWebKitLinkLoaded() {
				wait(function() {
					var styleSheets = document.styleSheets, styleSheet, i = styleSheets.length, owner;

					while (i--) {
						styleSheet = styleSheets[i];
						owner = styleSheet.ownerNode ? styleSheet.ownerNode : styleSheet.owningElement;
						if (owner && owner.id === link.id) {
							passed();
							return true;
						}
					}
				}, waitForWebKitLinkLoaded);
			}

			// Workaround for older Geckos that doesn't have any onload event for StyleSheets
			function waitForGeckoLinkLoaded() {
				wait(function() {
					try {
						// Accessing the cssRules will throw an exception until the CSS file is loaded
						var cssRules = style.sheet.cssRules;
						passed();
						return !!cssRules;
					} catch (ex) {
						// Ignore
					}
				}, waitForGeckoLinkLoaded);
			}

			url = Tools._addCacheSuffix(url);

			if (!loadedStates[url]) {
				state = {
					passed: [],
					failed: []
				};

				loadedStates[url] = state;
			} else {
				state = loadedStates[url];
			}

			if (loadedCallback) {
				state.passed.push(loadedCallback);
			}

			if (errorCallback) {
				state.failed.push(errorCallback);
			}

			// Is loading wait for it to pass
			if (state.status == 1) {
				return;
			}

			// Has finished loading and was success
			if (state.status == 2) {
				passed();
				return;
			}

			// Has finished loading and was a failure
			if (state.status == 3) {
				failed();
				return;
			}

			// Start loading
			state.status = 1;
			link = document.createElement('link');
			link.rel = 'stylesheet';
			link.type = 'text/css';
			link.id = 'u' + (idCount++);
			link.async = false;
			link.defer = false;
			startTime = new Date().getTime();

			// Feature detect onload on link element and sniff older webkits since it has an broken onload event
			if ("onload" in link && !isOldWebKit()) {
				link.onload = waitForWebKitLinkLoaded;
				link.onerror = failed;
			} else {
				// Sniff for old Firefox that doesn't support the onload event on link elements
				// TODO: Remove this in the future when everyone uses modern browsers
				if (navigator.userAgent.indexOf("Firefox") > 0) {
					style = document.createElement('style');
					style.textContent = '@import "' + url + '"';
					waitForGeckoLinkLoaded();
					appendToHead(style);
					return;
				}

				// Use the id owner on older webkits
				waitForWebKitLinkLoaded();
			}

			appendToHead(link);
			link.href = url;
		}

		this.load = load;
	};
});

// Included from: js/tinymce/classes/dom/DOMUtils.js

/**
 * DOMUtils.js
 *
 * Released under LGPL License.
 * Copyright (c) 1999-2015 Ephox Corp. All rights reserved
 *
 * License: http://www.tinymce.com/license
 * Contributing: http://www.tinymce.com/contributing
 */

/**
 * Utility class for various DOM manipulation and retrieval functions.
 *
 * @class tinymce.dom.DOMUtils
 * @example
 * // Add a class to an element by id in the page
 * tinymce.DOM.addClass('someid', 'someclass');
 *
 * // Add a class to an element by id inside the editor
 * tinymce.activeEditor.dom.addClass('someid', 'someclass');
 */
define("tinymce/dom/DOMUtils", [
	"tinymce/dom/Sizzle",
	"tinymce/dom/DomQuery",
	"tinymce/html/Styles",
	"tinymce/dom/EventUtils",
	"tinymce/dom/TreeWalker",
	"tinymce/dom/Range",
	"tinymce/html/Entities",
	"tinymce/Env",
	"tinymce/util/Tools",
	"tinymce/dom/StyleSheetLoader"
], function(Sizzle, $, Styles, EventUtils, TreeWalker, Range, Entities, Env, Tools, StyleSheetLoader) {
	// Shorten names
	var each = Tools.each, is = Tools.is, grep = Tools.grep, trim = Tools.trim;
	var isIE = Env.ie;
	var simpleSelectorRe = /^([a-z0-9],?)+$/i;
	var whiteSpaceRegExp = /^[ \t\r\n]*$/;

	function setupAttrHooks(domUtils, settings) {
		var attrHooks = {}, keepValues = settings.keep_values, keepUrlHook;

		keepUrlHook = {
			set: function($elm, value, name) {
				if (settings.url_converter) {
					value = settings.url_converter.call(settings.url_converter_scope || domUtils, value, name, $elm[0]);
				}

				$elm.attr('data-mce-' + name, value).attr(name, value);
			},

			get: function($elm, name) {
				return $elm.attr('data-mce-' + name) || $elm.attr(name);
			}
		};

		attrHooks = {
			style: {
				set: function($elm, value) {
					if (value !== null && typeof value === 'object') {
						$elm.css(value);
						return;
					}

					if (keepValues) {
						$elm.attr('data-mce-style', value);
					}

					$elm.attr('style', value);
				},

				get: function($elm) {
					var value = $elm.attr('data-mce-style') || $elm.attr('style');

					value = domUtils.serializeStyle(domUtils.parseStyle(value), $elm[0].nodeName);

					return value;
				}
			}
		};

		if (keepValues) {
			attrHooks.href = attrHooks.src = keepUrlHook;
		}

		return attrHooks;
	}

	function updateInternalStyleAttr(domUtils, $elm) {
		var value = $elm.attr('style');

		value = domUtils.serializeStyle(domUtils.parseStyle(value), $elm[0].nodeName);

		if (!value) {
			value = null;
		}

		$elm.attr('data-mce-style', value);
	}

	/**
	 * Constructs a new DOMUtils instance. Consult the Wiki for more details on settings etc for this class.
	 *
	 * @constructor
	 * @method DOMUtils
	 * @param {Document} d Document reference to bind the utility class to.
	 * @param {settings} s Optional settings collection.
	 */
	function DOMUtils(doc, settings) {
		var self = this, blockElementsMap;

		self.doc = doc;
		self.win = window;
		self.files = {};
		self.counter = 0;
		self.stdMode = !isIE || doc.documentMode >= 8;
		self.boxModel = !isIE || doc.compatMode == "CSS1Compat" || self.stdMode;
		self.styleSheetLoader = new StyleSheetLoader(doc);
		self.boundEvents = [];
		self.settings = settings = settings || {};
		self.schema = settings.schema;
		self.styles = new Styles({
			url_converter: settings.url_converter,
			url_converter_scope: settings.url_converter_scope
		}, settings.schema);

		self.fixDoc(doc);
		self.events = settings.ownEvents ? new EventUtils(settings.proxy) : EventUtils.Event;
		self.attrHooks = setupAttrHooks(self, settings);
		blockElementsMap = settings.schema ? settings.schema.getBlockElements() : {};
		self.$ = $.overrideDefaults(function() {
			return {
				context: doc,
				element: self.getRoot()
			};
		});

		/**
		 * Returns true/false if the specified element is a block element or not.
		 *
		 * @method isBlock
		 * @param {Node/String} node Element/Node to check.
		 * @return {Boolean} True/False state if the node is a block element or not.
		 */
		self.isBlock = function(node) {
			// Fix for #5446
			if (!node) {
				return false;
			}

			// This function is called in module pattern style since it might be executed with the wrong this scope
			var type = node.nodeType;

			// If it's a node then check the type and use the nodeName
			if (type) {
				return !!(type === 1 && blockElementsMap[node.nodeName]);
			}

			return !!blockElementsMap[node];
		};
	}

	DOMUtils.prototype = {
		$$: function(elm) {
			if (typeof elm == 'string') {
				elm = this.get(elm);
			}

			return this.$(elm);
		},

		root: null,

		fixDoc: function(doc) {
			var settings = this.settings, name;

			if (isIE && settings.schema) {
				// Add missing HTML 4/5 elements to IE
				('abbr article aside audio canvas ' +
				'details figcaption figure footer ' +
				'header hgroup mark menu meter nav ' +
				'output progress section summary ' +
				'time video').replace(/\w+/g, function(name) {
					doc.createElement(name);
				});

				// Create all custom elements
				for (name in settings.schema.getCustomElements()) {
					doc.createElement(name);
				}
			}
		},

		clone: function(node, deep) {
			var self = this, clone, doc;

			// TODO: Add feature detection here in the future
			if (!isIE || node.nodeType !== 1 || deep) {
				return node.cloneNode(deep);
			}

			doc = self.doc;

			// Make a HTML5 safe shallow copy
			if (!deep) {
				clone = doc.createElement(node.nodeName);

				// Copy attribs
				each(self.getAttribs(node), function(attr) {
					self.setAttrib(clone, attr.nodeName, self.getAttrib(node, attr.nodeName));
				});

				return clone;
			}

			return clone.firstChild;
		},

		/**
		 * Returns the root node of the document. This is normally the body but might be a DIV. Parents like getParent will not
		 * go above the point of this root node.
		 *
		 * @method getRoot
		 * @return {Element} Root element for the utility class.
		 */
		getRoot: function() {
			var self = this;

			return self.settings.root_element || self.doc.body;
		},

		/**
		 * Returns the viewport of the window.
		 *
		 * @method getViewPort
		 * @param {Window} win Optional window to get viewport of.
		 * @return {Object} Viewport object with fields x, y, w and h.
		 */
		getViewPort: function(win) {
			var doc, rootElm;

			win = !win ? this.win : win;
			doc = win.document;
			rootElm = this.boxModel ? doc.documentElement : doc.body;

			// Returns viewport size excluding scrollbars
			return {
				x: win.pageXOffset || rootElm.scrollLeft,
				y: win.pageYOffset || rootElm.scrollTop,
				w: win.innerWidth || rootElm.clientWidth,
				h: win.innerHeight || rootElm.clientHeight
			};
		},

		/**
		 * Returns the rectangle for a specific element.
		 *
		 * @method getRect
		 * @param {Element/String} elm Element object or element ID to get rectangle from.
		 * @return {object} Rectangle for specified element object with x, y, w, h fields.
		 */
		getRect: function(elm) {
			var self = this, pos, size;

			elm = self.get(elm);
			pos = self.getPos(elm);
			size = self.getSize(elm);

			return {
				x: pos.x, y: pos.y,
				w: size.w, h: size.h
			};
		},

		/**
		 * Returns the size dimensions of the specified element.
		 *
		 * @method getSize
		 * @param {Element/String} elm Element object or element ID to get rectangle from.
		 * @return {object} Rectangle for specified element object with w, h fields.
		 */
		getSize: function(elm) {
			var self = this, w, h;

			elm = self.get(elm);
			w = self.getStyle(elm, 'width');
			h = self.getStyle(elm, 'height');

			// Non pixel value, then force offset/clientWidth
			if (w.indexOf('px') === -1) {
				w = 0;
			}

			// Non pixel value, then force offset/clientWidth
			if (h.indexOf('px') === -1) {
				h = 0;
			}

			return {
				w: parseInt(w, 10) || elm.offsetWidth || elm.clientWidth,
				h: parseInt(h, 10) || elm.offsetHeight || elm.clientHeight
			};
		},

		/**
		 * Returns a node by the specified selector function. This function will
		 * loop through all parent nodes and call the specified function for each node.
		 * If the function then returns true indicating that it has found what it was looking for, the loop execution will then end
		 * and the node it found will be returned.
		 *
		 * @method getParent
		 * @param {Node/String} node DOM node to search parents on or ID string.
		 * @param {function} selector Selection function or CSS selector to execute on each node.
		 * @param {Node} root Optional root element, never go below this point.
		 * @return {Node} DOM Node or null if it wasn't found.
		 */
		getParent: function(node, selector, root) {
			return this.getParents(node, selector, root, false);
		},

		/**
		 * Returns a node list of all parents matching the specified selector function or pattern.
		 * If the function then returns true indicating that it has found what it was looking for and that node will be collected.
		 *
		 * @method getParents
		 * @param {Node/String} node DOM node to search parents on or ID string.
		 * @param {function} selector Selection function to execute on each node or CSS pattern.
		 * @param {Node} root Optional root element, never go below this point.
		 * @return {Array} Array of nodes or null if it wasn't found.
		 */
		getParents: function(node, selector, root, collect) {
			var self = this, selectorVal, result = [];

			node = self.get(node);
			collect = collect === undefined;

			// Default root on inline mode
			root = root || (self.getRoot().nodeName != 'BODY' ? self.getRoot().parentNode : null);

			// Wrap node name as func
			if (is(selector, 'string')) {
				selectorVal = selector;

				if (selector === '*') {
					selector = function(node) {
						return node.nodeType == 1;
					};
				} else {
					selector = function(node) {
						return self.is(node, selectorVal);
					};
				}
			}

			while (node) {
				if (node == root || !node.nodeType || node.nodeType === 9) {
					break;
				}

				if (!selector || selector(node)) {
					if (collect) {
						result.push(node);
					} else {
						return node;
					}
				}

				node = node.parentNode;
			}

			return collect ? result : null;
		},

		/**
		 * Returns the specified element by ID or the input element if it isn't a string.
		 *
		 * @method get
		 * @param {String/Element} n Element id to look for or element to just pass though.
		 * @return {Element} Element matching the specified id or null if it wasn't found.
		 */
		get: function(elm) {
			var name;

			if (elm && this.doc && typeof elm == 'string') {
				name = elm;
				elm = this.doc.getElementById(elm);

				// IE and Opera returns meta elements when they match the specified input ID, but getElementsByName seems to do the trick
				if (elm && elm.id !== name) {
					return this.doc.getElementsByName(name)[1];
				}
			}

			return elm;
		},

		/**
		 * Returns the next node that matches selector or function
		 *
		 * @method getNext
		 * @param {Node} node Node to find siblings from.
		 * @param {String/function} selector Selector CSS expression or function.
		 * @return {Node} Next node item matching the selector or null if it wasn't found.
		 */
		getNext: function(node, selector) {
			return this._findSib(node, selector, 'nextSibling');
		},

		/**
		 * Returns the previous node that matches selector or function
		 *
		 * @method getPrev
		 * @param {Node} node Node to find siblings from.
		 * @param {String/function} selector Selector CSS expression or function.
		 * @return {Node} Previous node item matching the selector or null if it wasn't found.
		 */
		getPrev: function(node, selector) {
			return this._findSib(node, selector, 'previousSibling');
		},

		// #ifndef jquery

		/**
		 * Selects specific elements by a CSS level 3 pattern. For example "div#a1 p.test".
		 * This function is optimized for the most common patterns needed in TinyMCE but it also performs well enough
		 * on more complex patterns.
		 *
		 * @method select
		 * @param {String} selector CSS level 3 pattern to select/find elements by.
		 * @param {Object} scope Optional root element/scope element to search in.
		 * @return {Array} Array with all matched elements.
		 * @example
		 * // Adds a class to all paragraphs in the currently active editor
		 * tinymce.activeEditor.dom.addClass(tinymce.activeEditor.dom.select('p'), 'someclass');
		 *
		 * // Adds a class to all spans that have the test class in the currently active editor
		 * tinymce.activeEditor.dom.addClass(tinymce.activeEditor.dom.select('span.test'), 'someclass')
		 */
		select: function(selector, scope) {
			var self = this;

			/*eslint new-cap:0 */
			return Sizzle(selector, self.get(scope) || self.settings.root_element || self.doc, []);
		},

		/**
		 * Returns true/false if the specified element matches the specified css pattern.
		 *
		 * @method is
		 * @param {Node/NodeList} elm DOM node to match or an array of nodes to match.
		 * @param {String} selector CSS pattern to match the element against.
		 */
		is: function(elm, selector) {
			var i;

			// If it isn't an array then try to do some simple selectors instead of Sizzle for to boost performance
			if (elm.length === undefined) {
				// Simple all selector
				if (selector === '*') {
					return elm.nodeType == 1;
				}

				// Simple selector just elements
				if (simpleSelectorRe.test(selector)) {
					selector = selector.toLowerCase().split(/,/);
					elm = elm.nodeName.toLowerCase();

					for (i = selector.length - 1; i >= 0; i--) {
						if (selector[i] == elm) {
							return true;
						}
					}

					return false;
				}
			}

			// Is non element
			if (elm.nodeType && elm.nodeType != 1) {
				return false;
			}

			var elms = elm.nodeType ? [elm] : elm;

			/*eslint new-cap:0 */
			return Sizzle(selector, elms[0].ownerDocument || elms[0], null, elms).length > 0;
		},

		// #endif

		/**
		 * Adds the specified element to another element or elements.
		 *
		 * @method add
		 * @param {String/Element/Array} parentElm Element id string, DOM node element or array of ids or elements to add to.
		 * @param {String/Element} name Name of new element to add or existing element to add.
		 * @param {Object} attrs Optional object collection with arguments to add to the new element(s).
		 * @param {String} html Optional inner HTML contents to add for each element.
		 * @return {Element/Array} Element that got created, or an array of created elements if multiple input elements
		 * were passed in.
		 * @example
		 * // Adds a new paragraph to the end of the active editor
		 * tinymce.activeEditor.dom.add(tinymce.activeEditor.getBody(), 'p', {title: 'my title'}, 'Some content');
		 */
		add: function(parentElm, name, attrs, html, create) {
			var self = this;

			return this.run(parentElm, function(parentElm) {
				var newElm;

				newElm = is(name, 'string') ? self.doc.createElement(name) : name;
				self.setAttribs(newElm, attrs);

				if (html) {
					if (html.nodeType) {
						newElm.appendChild(html);
					} else {
						self.setHTML(newElm, html);
					}
				}

				return !create ? parentElm.appendChild(newElm) : newElm;
			});
		},

		/**
		 * Creates a new element.
		 *
		 * @method create
		 * @param {String} name Name of new element.
		 * @param {Object} attrs Optional object name/value collection with element attributes.
		 * @param {String} html Optional HTML string to set as inner HTML of the element.
		 * @return {Element} HTML DOM node element that got created.
		 * @example
		 * // Adds an element where the caret/selection is in the active editor
		 * var el = tinymce.activeEditor.dom.create('div', {id: 'test', 'class': 'myclass'}, 'some content');
		 * tinymce.activeEditor.selection.setNode(el);
		 */
		create: function(name, attrs, html) {
			return this.add(this.doc.createElement(name), name, attrs, html, 1);
		},

		/**
		 * Creates HTML string for element. The element will be closed unless an empty inner HTML string is passed in.
		 *
		 * @method createHTML
		 * @param {String} name Name of new element.
		 * @param {Object} attrs Optional object name/value collection with element attributes.
		 * @param {String} html Optional HTML string to set as inner HTML of the element.
		 * @return {String} String with new HTML element, for example: <a href="#">test</a>.
		 * @example
		 * // Creates a html chunk and inserts it at the current selection/caret location
		 * tinymce.activeEditor.selection.setContent(tinymce.activeEditor.dom.createHTML('a', {href: 'test.html'}, 'some line'));
		 */
		createHTML: function(name, attrs, html) {
			var outHtml = '', key;

			outHtml += '<' + name;

			for (key in attrs) {
				if (attrs.hasOwnProperty(key) && attrs[key] !== null && typeof attrs[key] != 'undefined') {
					outHtml += ' ' + key + '="' + this.encode(attrs[key]) + '"';
				}
			}

			// A call to tinymce.is doesn't work for some odd reason on IE9 possible bug inside their JS runtime
			if (typeof html != "undefined") {
				return outHtml + '>' + html + '</' + name + '>';
			}

			return outHtml + ' />';
		},

		/**
		 * Creates a document fragment out of the specified HTML string.
		 *
		 * @method createFragment
		 * @param {String} html Html string to create fragment from.
		 * @return {DocumentFragment} Document fragment node.
		 */
		createFragment: function(html) {
			var frag, node, doc = this.doc, container;

			container = doc.createElement("div");
			frag = doc.createDocumentFragment();

			if (html) {
				container.innerHTML = html;
			}

			while ((node = container.firstChild)) {
				frag.appendChild(node);
			}

			return frag;
		},

		/**
		 * Removes/deletes the specified element(s) from the DOM.
		 *
		 * @method remove
		 * @param {String/Element/Array} node ID of element or DOM element object or array containing multiple elements/ids.
		 * @param {Boolean} keepChildren Optional state to keep children or not. If set to true all children will be
		 * placed at the location of the removed element.
		 * @return {Element/Array} HTML DOM element that got removed, or an array of removed elements if multiple input elements
		 * were passed in.
		 * @example
		 * // Removes all paragraphs in the active editor
		 * tinymce.activeEditor.dom.remove(tinymce.activeEditor.dom.select('p'));
		 *
		 * // Removes an element by id in the document
		 * tinymce.DOM.remove('mydiv');
		 */
		remove: function(node, keepChildren) {
			node = this.$$(node);

			if (keepChildren) {
				node.each(function() {
					var child;

					while ((child = this.firstChild)) {
						if (child.nodeType == 3 && child.data.length === 0) {
							this.removeChild(child);
						} else {
							this.parentNode.insertBefore(child, this);
						}
					}
				}).remove();
			} else {
				node.remove();
			}

			return node.length > 1 ? node.toArray() : node[0];
		},

		/**
		 * Sets the CSS style value on a HTML element. The name can be a camelcase string
		 * or the CSS style name like background-color.
		 *
		 * @method setStyle
		 * @param {String/Element/Array} n HTML element/Array of elements to set CSS style value on.
		 * @param {String} na Name of the style value to set.
		 * @param {String} v Value to set on the style.
		 * @example
		 * // Sets a style value on all paragraphs in the currently active editor
		 * tinymce.activeEditor.dom.setStyle(tinymce.activeEditor.dom.select('p'), 'background-color', 'red');
		 *
		 * // Sets a style value to an element by id in the current document
		 * tinymce.DOM.setStyle('mydiv', 'background-color', 'red');
		 */
		setStyle: function(elm, name, value) {
			elm = this.$$(elm).css(name, value);

			if (this.settings.update_styles) {
				updateInternalStyleAttr(this, elm);
			}
		},

		/**
		 * Returns the current style or runtime/computed value of an element.
		 *
		 * @method getStyle
		 * @param {String/Element} elm HTML element or element id string to get style from.
		 * @param {String} name Style name to return.
		 * @param {Boolean} computed Computed style.
		 * @return {String} Current style or computed style value of an element.
		 */
		getStyle: function(elm, name, computed) {
			elm = this.$$(elm);

			if (computed) {
				return elm.css(name);
			}

			// Camelcase it, if needed
			name = name.replace(/-(\D)/g, function(a, b) {
				return b.toUpperCase();
			});

			if (name == 'float') {
				name = Env.ie && Env.ie < 12 ? 'styleFloat' : 'cssFloat';
			}

			return elm[0] && elm[0].style ? elm[0].style[name] : undefined;
		},

		/**
		 * Sets multiple styles on the specified element(s).
		 *
		 * @method setStyles
		 * @param {Element/String/Array} e DOM element, element id string or array of elements/ids to set styles on.
		 * @param {Object} o Name/Value collection of style items to add to the element(s).
		 * @example
		 * // Sets styles on all paragraphs in the currently active editor
		 * tinymce.activeEditor.dom.setStyles(tinymce.activeEditor.dom.select('p'), {'background-color': 'red', 'color': 'green'});
		 *
		 * // Sets styles to an element by id in the current document
		 * tinymce.DOM.setStyles('mydiv', {'background-color': 'red', 'color': 'green'});
		 */
		setStyles: function(elm, styles) {
			elm = this.$$(elm).css(styles);

			if (this.settings.update_styles) {
				updateInternalStyleAttr(this, elm);
			}
		},

		/**
		 * Removes all attributes from an element or elements.
		 *
		 * @method removeAllAttribs
		 * @param {Element/String/Array} e DOM element, element id string or array of elements/ids to remove attributes from.
		 */
		removeAllAttribs: function(e) {
			return this.run(e, function(e) {
				var i, attrs = e.attributes;
				for (i = attrs.length - 1; i >= 0; i--) {
					e.removeAttributeNode(attrs.item(i));
				}
			});
		},

		/**
		 * Sets the specified attribute of an element or elements.
		 *
		 * @method setAttrib
		 * @param {Element/String/Array} e DOM element, element id string or array of elements/ids to set attribute on.
		 * @param {String} n Name of attribute to set.
		 * @param {String} v Value to set on the attribute - if this value is falsy like null, 0 or '' it will remove the attribute instead.
		 * @example
		 * // Sets class attribute on all paragraphs in the active editor
		 * tinymce.activeEditor.dom.setAttrib(tinymce.activeEditor.dom.select('p'), 'class', 'myclass');
		 *
		 * // Sets class attribute on a specific element in the current page
		 * tinymce.dom.setAttrib('mydiv', 'class', 'myclass');
		 */
		setAttrib: function(elm, name, value) {
			var self = this, originalValue, hook, settings = self.settings;

			if (value === '') {
				value = null;
			}

			elm = self.$$(elm);
			originalValue = elm.attr(name);

			if (!elm.length) {
				return;
			}

			hook = self.attrHooks[name];
			if (hook && hook.set) {
				hook.set(elm, value, name);
			} else {
				elm.attr(name, value);
			}

			if (originalValue != value && settings.onSetAttrib) {
				settings.onSetAttrib({
					attrElm: elm,
					attrName: name,
					attrValue: value
				});
			}
		},

		/**
		 * Sets two or more specified attributes of an element or elements.
		 *
		 * @method setAttribs
		 * @param {Element/String/Array} elm DOM element, element id string or array of elements/ids to set attributes on.
		 * @param {Object} attrs Name/Value collection of attribute items to add to the element(s).
		 * @example
		 * // Sets class and title attributes on all paragraphs in the active editor
		 * tinymce.activeEditor.dom.setAttribs(tinymce.activeEditor.dom.select('p'), {'class': 'myclass', title: 'some title'});
		 *
		 * // Sets class and title attributes on a specific element in the current page
		 * tinymce.DOM.setAttribs('mydiv', {'class': 'myclass', title: 'some title'});
		 */
		setAttribs: function(elm, attrs) {
			var self = this;

			self.$$(elm).each(function(i, node) {
				each(attrs, function(value, name) {
					self.setAttrib(node, name, value);
				});
			});
		},

		/**
		 * Returns the specified attribute by name.
		 *
		 * @method getAttrib
		 * @param {String/Element} elm Element string id or DOM element to get attribute from.
		 * @param {String} name Name of attribute to get.
		 * @param {String} defaultVal Optional default value to return if the attribute didn't exist.
		 * @return {String} Attribute value string, default value or null if the attribute wasn't found.
		 */
		getAttrib: function(elm, name, defaultVal) {
			var self = this, hook, value;

			elm = self.$$(elm);

			if (elm.length) {
				hook = self.attrHooks[name];

				if (hook && hook.get) {
					value = hook.get(elm, name);
				} else {
					value = elm.attr(name);
				}
			}

			if (typeof value == 'undefined') {
				value = defaultVal || '';
			}

			return value;
		},

		/**
		 * Returns the absolute x, y position of a node. The position will be returned in an object with x, y fields.
		 *
		 * @method getPos
		 * @param {Element/String} elm HTML element or element id to get x, y position from.
		 * @param {Element} rootElm Optional root element to stop calculations at.
		 * @return {object} Absolute position of the specified element object with x, y fields.
		 */
		getPos: function(elm, rootElm) {
			var self = this, x = 0, y = 0, offsetParent, doc = self.doc, body = doc.body, pos;

			elm = self.get(elm);
			rootElm = rootElm || body;

			if (elm) {
				// Use getBoundingClientRect if it exists since it's faster than looping offset nodes
				// Fallback to offsetParent calculations if the body isn't static better since it stops at the body root
				if (rootElm === body && elm.getBoundingClientRect && $(body).css('position') === 'static') {
					pos = elm.getBoundingClientRect();
					rootElm = self.boxModel ? doc.documentElement : body;

					// Add scroll offsets from documentElement or body since IE with the wrong box model will use d.body and so do WebKit
					// Also remove the body/documentelement clientTop/clientLeft on IE 6, 7 since they offset the position
					x = pos.left + (doc.documentElement.scrollLeft || body.scrollLeft) - rootElm.clientLeft;
					y = pos.top + (doc.documentElement.scrollTop || body.scrollTop) - rootElm.clientTop;

					return {x: x, y: y};
				}

				offsetParent = elm;
				while (offsetParent && offsetParent != rootElm && offsetParent.nodeType) {
					x += offsetParent.offsetLeft || 0;
					y += offsetParent.offsetTop || 0;
					offsetParent = offsetParent.offsetParent;
				}

				offsetParent = elm.parentNode;
				while (offsetParent && offsetParent != rootElm && offsetParent.nodeType) {
					x -= offsetParent.scrollLeft || 0;
					y -= offsetParent.scrollTop || 0;
					offsetParent = offsetParent.parentNode;
				}
			}

			return {x: x, y: y};
		},

		/**
		 * Parses the specified style value into an object collection. This parser will also
		 * merge and remove any redundant items that browsers might have added. It will also convert non-hex
		 * colors to hex values. Urls inside the styles will also be converted to absolute/relative based on settings.
		 *
		 * @method parseStyle
		 * @param {String} cssText Style value to parse, for example: border:1px solid red;.
		 * @return {Object} Object representation of that style, for example: {border: '1px solid red'}
		 */
		parseStyle: function(cssText) {
			return this.styles.parse(cssText);
		},

		/**
		 * Serializes the specified style object into a string.
		 *
		 * @method serializeStyle
		 * @param {Object} styles Object to serialize as string, for example: {border: '1px solid red'}
		 * @param {String} name Optional element name.
		 * @return {String} String representation of the style object, for example: border: 1px solid red.
		 */
		serializeStyle: function(styles, name) {
			return this.styles.serialize(styles, name);
		},

		/**
		 * Adds a style element at the top of the document with the specified cssText content.
		 *
		 * @method addStyle
		 * @param {String} cssText CSS Text style to add to top of head of document.
		 */
		addStyle: function(cssText) {
			var self = this, doc = self.doc, head, styleElm;

			// Prevent inline from loading the same styles twice
			if (self !== DOMUtils.DOM && doc === document) {
				var addedStyles = DOMUtils.DOM.addedStyles;

				addedStyles = addedStyles || [];
				if (addedStyles[cssText]) {
					return;
				}

				addedStyles[cssText] = true;
				DOMUtils.DOM.addedStyles = addedStyles;
			}

			// Create style element if needed
			styleElm = doc.getElementById('mceDefaultStyles');
			if (!styleElm) {
				styleElm = doc.createElement('style');
				styleElm.id = 'mceDefaultStyles';
				styleElm.type = 'text/css';

				head = doc.getElementsByTagName('head')[0];
				if (head.firstChild) {
					head.insertBefore(styleElm, head.firstChild);
				} else {
					head.appendChild(styleElm);
				}
			}

			// Append style data to old or new style element
			if (styleElm.styleSheet) {
				styleElm.styleSheet.cssText += cssText;
			} else {
				styleElm.appendChild(doc.createTextNode(cssText));
			}
		},

		/**
		 * Imports/loads the specified CSS file into the document bound to the class.
		 *
		 * @method loadCSS
		 * @param {String} u URL to CSS file to load.
		 * @example
		 * // Loads a CSS file dynamically into the current document
		 * tinymce.DOM.loadCSS('somepath/some.css');
		 *
		 * // Loads a CSS file into the currently active editor instance
		 * tinymce.activeEditor.dom.loadCSS('somepath/some.css');
		 *
		 * // Loads a CSS file into an editor instance by id
		 * tinymce.get('someid').dom.loadCSS('somepath/some.css');
		 *
		 * // Loads multiple CSS files into the current document
		 * tinymce.DOM.loadCSS('somepath/some.css,somepath/someother.css');
		 */
		loadCSS: function(url) {
			var self = this, doc = self.doc, head;

			// Prevent inline from loading the same CSS file twice
			if (self !== DOMUtils.DOM && doc === document) {
				DOMUtils.DOM.loadCSS(url);
				return;
			}

			if (!url) {
				url = '';
			}

			head = doc.getElementsByTagName('head')[0];

			each(url.split(','), function(url) {
				var link;

				url = Tools._addCacheSuffix(url);

				if (self.files[url]) {
					return;
				}

				self.files[url] = true;
				link = self.create('link', {rel: 'stylesheet', href: url});

				// IE 8 has a bug where dynamically loading stylesheets would produce a 1 item remaining bug
				// This fix seems to resolve that issue by recalcing the document once a stylesheet finishes loading
				// It's ugly but it seems to work fine.
				if (isIE && doc.documentMode && doc.recalc) {
					link.onload = function() {
						if (doc.recalc) {
							doc.recalc();
						}

						link.onload = null;
					};
				}

				head.appendChild(link);
			});
		},

		/**
		 * Adds a class to the specified element or elements.
		 *
		 * @method addClass
		 * @param {String/Element/Array} elm Element ID string or DOM element or array with elements or IDs.
		 * @param {String} cls Class name to add to each element.
		 * @return {String/Array} String with new class value or array with new class values for all elements.
		 * @example
		 * // Adds a class to all paragraphs in the active editor
		 * tinymce.activeEditor.dom.addClass(tinymce.activeEditor.dom.select('p'), 'myclass');
		 *
		 * // Adds a class to a specific element in the current page
		 * tinymce.DOM.addClass('mydiv', 'myclass');
		 */
		addClass: function(elm, cls) {
			this.$$(elm).addClass(cls);
		},

		/**
		 * Removes a class from the specified element or elements.
		 *
		 * @method removeClass
		 * @param {String/Element/Array} elm Element ID string or DOM element or array with elements or IDs.
		 * @param {String} cls Class name to remove from each element.
		 * @return {String/Array} String of remaining class name(s), or an array of strings if multiple input elements
		 * were passed in.
		 * @example
		 * // Removes a class from all paragraphs in the active editor
		 * tinymce.activeEditor.dom.removeClass(tinymce.activeEditor.dom.select('p'), 'myclass');
		 *
		 * // Removes a class from a specific element in the current page
		 * tinymce.DOM.removeClass('mydiv', 'myclass');
		 */
		removeClass: function(elm, cls) {
			this.toggleClass(elm, cls, false);
		},

		/**
		 * Returns true if the specified element has the specified class.
		 *
		 * @method hasClass
		 * @param {String/Element} n HTML element or element id string to check CSS class on.
		 * @param {String} c CSS class to check for.
		 * @return {Boolean} true/false if the specified element has the specified class.
		 */
		hasClass: function(elm, cls) {
			return this.$$(elm).hasClass(cls);
		},

		/**
		 * Toggles the specified class on/off.
		 *
		 * @method toggleClass
		 * @param {Element} elm Element to toggle class on.
		 * @param {[type]} cls Class to toggle on/off.
		 * @param {[type]} state Optional state to set.
		 */
		toggleClass: function(elm, cls, state) {
			this.$$(elm).toggleClass(cls, state).each(function() {
				if (this.className === '') {
					$(this).attr('class', null);
				}
			});
		},

		/**
		 * Shows the specified element(s) by ID by setting the "display" style.
		 *
		 * @method show
		 * @param {String/Element/Array} elm ID of DOM element or DOM element or array with elements or IDs to show.
		 */
		show: function(elm) {
			this.$$(elm).show();
		},

		/**
		 * Hides the specified element(s) by ID by setting the "display" style.
		 *
		 * @method hide
		 * @param {String/Element/Array} e ID of DOM element or DOM element or array with elements or IDs to hide.
		 * @example
		 * // Hides an element by id in the document
		 * tinymce.DOM.hide('myid');
		 */
		hide: function(elm) {
			this.$$(elm).hide();
		},

		/**
		 * Returns true/false if the element is hidden or not by checking the "display" style.
		 *
		 * @method isHidden
		 * @param {String/Element} e Id or element to check display state on.
		 * @return {Boolean} true/false if the element is hidden or not.
		 */
		isHidden: function(elm) {
			return this.$$(elm).css('display') == 'none';
		},

		/**
		 * Returns a unique id. This can be useful when generating elements on the fly.
		 * This method will not check if the element already exists.
		 *
		 * @method uniqueId
		 * @param {String} prefix Optional prefix to add in front of all ids - defaults to "mce_".
		 * @return {String} Unique id.
		 */
		uniqueId: function(prefix) {
			return (!prefix ? 'mce_' : prefix) + (this.counter++);
		},

		/**
		 * Sets the specified HTML content inside the element or elements. The HTML will first be processed. This means
		 * URLs will get converted, hex color values fixed etc. Check processHTML for details.
		 *
		 * @method setHTML
		 * @param {Element/String/Array} elm DOM element, element id string or array of elements/ids to set HTML inside of.
		 * @param {String} h HTML content to set as inner HTML of the element.
		 * @example
		 * // Sets the inner HTML of all paragraphs in the active editor
		 * tinymce.activeEditor.dom.setHTML(tinymce.activeEditor.dom.select('p'), 'some inner html');
		 *
		 * // Sets the inner HTML of an element by id in the document
		 * tinymce.DOM.setHTML('mydiv', 'some inner html');
		 */
		setHTML: function(elm, html) {
			elm = this.$$(elm);

			if (isIE) {
				elm.each(function(i, target) {
					if (target.canHaveHTML === false) {
						return;
					}

					// Remove all child nodes, IE keeps empty text nodes in DOM
					while (target.firstChild) {
						target.removeChild(target.firstChild);
					}

					try {
						// IE will remove comments from the beginning
						// unless you padd the contents with something
						target.innerHTML = '<br>' + html;
						target.removeChild(target.firstChild);
					} catch (ex) {
						// IE sometimes produces an unknown runtime error on innerHTML if it's a div inside a p
						$('<div>').html('<br>' + html).contents().slice(1).appendTo(target);
					}

					return html;
				});
			} else {
				elm.html(html);
			}
		},

		/**
		 * Returns the outer HTML of an element.
		 *
		 * @method getOuterHTML
		 * @param {String/Element} elm Element ID or element object to get outer HTML from.
		 * @return {String} Outer HTML string.
		 * @example
		 * tinymce.DOM.getOuterHTML(editorElement);
		 * tinymce.activeEditor.getOuterHTML(tinymce.activeEditor.getBody());
		 */
		getOuterHTML: function(elm) {
			elm = this.get(elm);

			// Older FF doesn't have outerHTML 3.6 is still used by some orgaizations
			return elm.nodeType == 1 && "outerHTML" in elm ? elm.outerHTML : $('<div>').append($(elm).clone()).html();
		},

		/**
		 * Sets the specified outer HTML on an element or elements.
		 *
		 * @method setOuterHTML
		 * @param {Element/String/Array} elm DOM element, element id string or array of elements/ids to set outer HTML on.
		 * @param {Object} html HTML code to set as outer value for the element.
		 * @param {Document} doc Optional document scope to use in this process - defaults to the document of the DOM class.
		 * @example
		 * // Sets the outer HTML of all paragraphs in the active editor
		 * tinymce.activeEditor.dom.setOuterHTML(tinymce.activeEditor.dom.select('p'), '<div>some html</div>');
		 *
		 * // Sets the outer HTML of an element by id in the document
		 * tinymce.DOM.setOuterHTML('mydiv', '<div>some html</div>');
		 */
		setOuterHTML: function(elm, html) {
			var self = this;

			self.$$(elm).each(function() {
				try {
					// Older FF doesn't have outerHTML 3.6 is still used by some orgaizations
					if ("outerHTML" in this) {
						this.outerHTML = html;
						return;
					}
				} catch (ex) {
					// Ignore
				}

				// OuterHTML for IE it sometimes produces an "unknown runtime error"
				self.remove($(this).html(html), true);
			});
		},

		/**
		 * Entity decodes a string. This method decodes any HTML entities, such as &aring;.
		 *
		 * @method decode
		 * @param {String} s String to decode entities on.
		 * @return {String} Entity decoded string.
		 */
		decode: Entities.decode,

		/**
		 * Entity encodes a string. This method encodes the most common entities, such as <>"&.
		 *
		 * @method encode
		 * @param {String} text String to encode with entities.
		 * @return {String} Entity encoded string.
		 */
		encode: Entities.encodeAllRaw,

		/**
		 * Inserts an element after the reference element.
		 *
		 * @method insertAfter
		 * @param {Element} node Element to insert after the reference.
		 * @param {Element/String/Array} reference_node Reference element, element id or array of elements to insert after.
		 * @return {Element/Array} Element that got added or an array with elements.
		 */
		insertAfter: function(node, referenceNode) {
			referenceNode = this.get(referenceNode);

			return this.run(node, function(node) {
				var parent, nextSibling;

				parent = referenceNode.parentNode;
				nextSibling = referenceNode.nextSibling;

				if (nextSibling) {
					parent.insertBefore(node, nextSibling);
				} else {
					parent.appendChild(node);
				}

				return node;
			});
		},

		/**
		 * Replaces the specified element or elements with the new element specified. The new element will
		 * be cloned if multiple input elements are passed in.
		 *
		 * @method replace
		 * @param {Element} newElm New element to replace old ones with.
		 * @param {Element/String/Array} oldELm Element DOM node, element id or array of elements or ids to replace.
		 * @param {Boolean} k Optional keep children state, if set to true child nodes from the old object will be added to new ones.
		 */
		replace: function(newElm, oldElm, keepChildren) {
			var self = this;

			return self.run(oldElm, function(oldElm) {
				if (is(oldElm, 'array')) {
					newElm = newElm.cloneNode(true);
				}

				if (keepChildren) {
					each(grep(oldElm.childNodes), function(node) {
						newElm.appendChild(node);
					});
				}

				return oldElm.parentNode.replaceChild(newElm, oldElm);
			});
		},

		/**
		 * Renames the specified element and keeps its attributes and children.
		 *
		 * @method rename
		 * @param {Element} elm Element to rename.
		 * @param {String} name Name of the new element.
		 * @return {Element} New element or the old element if it needed renaming.
		 */
		rename: function(elm, name) {
			var self = this, newElm;

			if (elm.nodeName != name.toUpperCase()) {
				// Rename block element
				newElm = self.create(name);

				// Copy attribs to new block
				each(self.getAttribs(elm), function(attrNode) {
					self.setAttrib(newElm, attrNode.nodeName, self.getAttrib(elm, attrNode.nodeName));
				});

				// Replace block
				self.replace(newElm, elm, 1);
			}

			return newElm || elm;
		},

		/**
		 * Find the common ancestor of two elements. This is a shorter method than using the DOM Range logic.
		 *
		 * @method findCommonAncestor
		 * @param {Element} a Element to find common ancestor of.
		 * @param {Element} b Element to find common ancestor of.
		 * @return {Element} Common ancestor element of the two input elements.
		 */
		findCommonAncestor: function(a, b) {
			var ps = a, pe;

			while (ps) {
				pe = b;

				while (pe && ps != pe) {
					pe = pe.parentNode;
				}

				if (ps == pe) {
					break;
				}

				ps = ps.parentNode;
			}

			if (!ps && a.ownerDocument) {
				return a.ownerDocument.documentElement;
			}

			return ps;
		},

		/**
		 * Parses the specified RGB color value and returns a hex version of that color.
		 *
		 * @method toHex
		 * @param {String} rgbVal RGB string value like rgb(1,2,3)
		 * @return {String} Hex version of that RGB value like #FF00FF.
		 */
		toHex: function(rgbVal) {
			return this.styles.toHex(Tools.trim(rgbVal));
		},

		/**
		 * Executes the specified function on the element by id or dom element node or array of elements/id.
		 *
		 * @method run
		 * @param {String/Element/Array} Element ID or DOM element object or array with ids or elements.
		 * @param {function} f Function to execute for each item.
		 * @param {Object} s Optional scope to execute the function in.
		 * @return {Object/Array} Single object, or an array of objects if multiple input elements were passed in.
		 */
		run: function(elm, func, scope) {
			var self = this, result;

			if (typeof elm === 'string') {
				elm = self.get(elm);
			}

			if (!elm) {
				return false;
			}

			scope = scope || this;
			if (!elm.nodeType && (elm.length || elm.length === 0)) {
				result = [];

				each(elm, function(elm, i) {
					if (elm) {
						if (typeof elm == 'string') {
							elm = self.get(elm);
						}

						result.push(func.call(scope, elm, i));
					}
				});

				return result;
			}

			return func.call(scope, elm);
		},

		/**
		 * Returns a NodeList with attributes for the element.
		 *
		 * @method getAttribs
		 * @param {HTMLElement/string} elm Element node or string id to get attributes from.
		 * @return {NodeList} NodeList with attributes.
		 */
		getAttribs: function(elm) {
			var attrs;

			elm = this.get(elm);

			if (!elm) {
				return [];
			}

			if (isIE) {
				attrs = [];

				// Object will throw exception in IE
				if (elm.nodeName == 'OBJECT') {
					return elm.attributes;
				}

				// IE doesn't keep the selected attribute if you clone option elements
				if (elm.nodeName === 'OPTION' && this.getAttrib(elm, 'selected')) {
					attrs.push({specified: 1, nodeName: 'selected'});
				}

				// It's crazy that this is faster in IE but it's because it returns all attributes all the time
				var attrRegExp = /<\/?[\w:\-]+ ?|=[\"][^\"]+\"|=\'[^\']+\'|=[\w\-]+|>/gi;
				elm.cloneNode(false).outerHTML.replace(attrRegExp, '').replace(/[\w:\-]+/gi, function(a) {
					attrs.push({specified: 1, nodeName: a});
				});

				return attrs;
			}

			return elm.attributes;
		},

		/**
		 * Returns true/false if the specified node is to be considered empty or not.
		 *
		 * @example
		 * tinymce.DOM.isEmpty(node, {img: true});
		 * @method isEmpty
		 * @param {Object} elements Optional name/value object with elements that are automatically treated as non-empty elements.
		 * @return {Boolean} true/false if the node is empty or not.
		 */
		isEmpty: function(node, elements) {
			var self = this, i, attributes, type, walker, name, brCount = 0;

			node = node.firstChild;
			if (node) {
				walker = new TreeWalker(node, node.parentNode);
				elements = elements || (self.schema ? self.schema.getNonEmptyElements() : null);

				do {
					type = node.nodeType;

					if (type === 1) {
						// Ignore bogus elements
						if (node.getAttribute('data-mce-bogus')) {
							continue;
						}

						// Keep empty elements like <img />
						name = node.nodeName.toLowerCase();
						if (elements && elements[name]) {
							// Ignore single BR elements in blocks like <p><br /></p> or <p><span><br /></span></p>
							if (name === 'br') {
								brCount++;
								continue;
							}

							return false;
						}

						// Keep elements with data-bookmark attributes or name attribute like <a name="1"></a>
						attributes = self.getAttribs(node);
						i = attributes.length;
						while (i--) {
							name = attributes[i].nodeName;
							if (name === "name" || name === 'data-mce-bookmark') {
								return false;
							}
						}
					}

					// Keep comment nodes
					if (type == 8) {
						return false;
					}

					// Keep non whitespace text nodes
					if ((type === 3 && !whiteSpaceRegExp.test(node.nodeValue))) {
						return false;
					}
				} while ((node = walker.next()));
			}

			return brCount <= 1;
		},

		/**
		 * Creates a new DOM Range object. This will use the native DOM Range API if it's
		 * available. If it's not, it will fall back to the custom TinyMCE implementation.
		 *
		 * @method createRng
		 * @return {DOMRange} DOM Range object.
		 * @example
		 * var rng = tinymce.DOM.createRng();
		 * alert(rng.startContainer + "," + rng.startOffset);
		 */
		createRng: function() {
			var doc = this.doc;

			return doc.createRange ? doc.createRange() : new Range(this);
		},

		/**
		 * Returns the index of the specified node within its parent.
		 *
		 * @method nodeIndex
		 * @param {Node} node Node to look for.
		 * @param {boolean} normalized Optional true/false state if the index is what it would be after a normalization.
		 * @return {Number} Index of the specified node.
		 */
		nodeIndex: function(node, normalized) {
			var idx = 0, lastNodeType, nodeType;

			if (node) {
				for (lastNodeType = node.nodeType, node = node.previousSibling; node; node = node.previousSibling) {
					nodeType = node.nodeType;

					// Normalize text nodes
					if (normalized && nodeType == 3) {
						if (nodeType == lastNodeType || !node.nodeValue.length) {
							continue;
						}
					}
					idx++;
					lastNodeType = nodeType;
				}
			}

			return idx;
		},

		/**
		 * Splits an element into two new elements and places the specified split
		 * element or elements between the new ones. For example splitting the paragraph at the bold element in
		 * this example <p>abc<b>abc</b>123</p> would produce <p>abc</p><b>abc</b><p>123</p>.
		 *
		 * @method split
		 * @param {Element} parentElm Parent element to split.
		 * @param {Element} splitElm Element to split at.
		 * @param {Element} replacementElm Optional replacement element to replace the split element with.
		 * @return {Element} Returns the split element or the replacement element if that is specified.
		 */
		split: function(parentElm, splitElm, replacementElm) {
			var self = this, r = self.createRng(), bef, aft, pa;

			// W3C valid browsers tend to leave empty nodes to the left/right side of the contents - this makes sense
			// but we don't want that in our code since it serves no purpose for the end user
			// For example splitting this html at the bold element:
			//   <p>text 1<span><b>CHOP</b></span>text 2</p>
			// would produce:
			//   <p>text 1<span></span></p><b>CHOP</b><p><span></span>text 2</p>
			// this function will then trim off empty edges and produce:
			//   <p>text 1</p><b>CHOP</b><p>text 2</p>
			function trimNode(node) {
				var i, children = node.childNodes, type = node.nodeType;

				function surroundedBySpans(node) {
					var previousIsSpan = node.previousSibling && node.previousSibling.nodeName == 'SPAN';
					var nextIsSpan = node.nextSibling && node.nextSibling.nodeName == 'SPAN';
					return previousIsSpan && nextIsSpan;
				}

				if (type == 1 && node.getAttribute('data-mce-type') == 'bookmark') {
					return;
				}

				for (i = children.length - 1; i >= 0; i--) {
					trimNode(children[i]);
				}

				if (type != 9) {
					// Keep non whitespace text nodes
					if (type == 3 && node.nodeValue.length > 0) {
						// If parent element isn't a block or there isn't any useful contents for example "<p>   </p>"
						// Also keep text nodes with only spaces if surrounded by spans.
						// eg. "<p><span>a</span> <span>b</span></p>" should keep space between a and b
						var trimmedLength = trim(node.nodeValue).length;
						if (!self.isBlock(node.parentNode) || trimmedLength > 0 || trimmedLength === 0 && surroundedBySpans(node)) {
							return;
						}
					} else if (type == 1) {
						// If the only child is a bookmark then move it up
						children = node.childNodes;

						// TODO fix this complex if
						if (children.length == 1 && children[0] && children[0].nodeType == 1 &&
							children[0].getAttribute('data-mce-type') == 'bookmark') {
							node.parentNode.insertBefore(children[0], node);
						}

						// Keep non empty elements or img, hr etc
						if (children.length || /^(br|hr|input|img)$/i.test(node.nodeName)) {
							return;
						}
					}

					self.remove(node);
				}

				return node;
			}

			if (parentElm && splitElm) {
				// Get before chunk
				r.setStart(parentElm.parentNode, self.nodeIndex(parentElm));
				r.setEnd(splitElm.parentNode, self.nodeIndex(splitElm));
				bef = r.extractContents();

				// Get after chunk
				r = self.createRng();
				r.setStart(splitElm.parentNode, self.nodeIndex(splitElm) + 1);
				r.setEnd(parentElm.parentNode, self.nodeIndex(parentElm) + 1);
				aft = r.extractContents();

				// Insert before chunk
				pa = parentElm.parentNode;
				pa.insertBefore(trimNode(bef), parentElm);

				// Insert middle chunk
				if (replacementElm) {
					pa.replaceChild(replacementElm, splitElm);
				} else {
					pa.insertBefore(splitElm, parentElm);
				}

				// Insert after chunk
				pa.insertBefore(trimNode(aft), parentElm);
				self.remove(parentElm);

				return replacementElm || splitElm;
			}
		},

		/**
		 * Adds an event handler to the specified object.
		 *
		 * @method bind
		 * @param {Element/Document/Window/Array} target Target element to bind events to.
		 * handler to or an array of elements/ids/documents.
		 * @param {String} name Name of event handler to add, for example: click.
		 * @param {function} func Function to execute when the event occurs.
		 * @param {Object} scope Optional scope to execute the function in.
		 * @return {function} Function callback handler the same as the one passed in.
		 */
		bind: function(target, name, func, scope) {
			var self = this;

			if (Tools.isArray(target)) {
				var i = target.length;

				while (i--) {
					target[i] = self.bind(target[i], name, func, scope);
				}

				return target;
			}

			// Collect all window/document events bound by editor instance
			if (self.settings.collect && (target === self.doc || target === self.win)) {
				self.boundEvents.push([target, name, func, scope]);
			}

			return self.events.bind(target, name, func, scope || self);
		},

		/**
		 * Removes the specified event handler by name and function from an element or collection of elements.
		 *
		 * @method unbind
		 * @param {Element/Document/Window/Array} target Target element to unbind events on.
		 * @param {String} name Event handler name, for example: "click"
		 * @param {function} func Function to remove.
		 * @return {bool/Array} Bool state of true if the handler was removed, or an array of states if multiple input elements
		 * were passed in.
		 */
		unbind: function(target, name, func) {
			var self = this, i;

			if (Tools.isArray(target)) {
				i = target.length;

				while (i--) {
					target[i] = self.unbind(target[i], name, func);
				}

				return target;
			}

			// Remove any bound events matching the input
			if (self.boundEvents && (target === self.doc || target === self.win)) {
				i = self.boundEvents.length;

				while (i--) {
					var item = self.boundEvents[i];

					if (target == item[0] && (!name || name == item[1]) && (!func || func == item[2])) {
						this.events.unbind(item[0], item[1], item[2]);
					}
				}
			}

			return this.events.unbind(target, name, func);
		},

		/**
		 * Fires the specified event name with object on target.
		 *
		 * @method fire
		 * @param {Node/Document/Window} target Target element or object to fire event on.
		 * @param {String} name Name of the event to fire.
		 * @param {Object} evt Event object to send.
		 * @return {Event} Event object.
		 */
		fire: function(target, name, evt) {
			return this.events.fire(target, name, evt);
		},

		// Returns the content editable state of a node
		getContentEditable: function(node) {
			var contentEditable;

			// Check type
			if (!node || node.nodeType != 1) {
				return null;
			}

			// Check for fake content editable
			contentEditable = node.getAttribute("data-mce-contenteditable");
			if (contentEditable && contentEditable !== "inherit") {
				return contentEditable;
			}

			// Check for real content editable
			return node.contentEditable !== "inherit" ? node.contentEditable : null;
		},

		getContentEditableParent: function(node) {
			var root = this.getRoot(), state = null;

			for (; node && node !== root; node = node.parentNode) {
				state = this.getContentEditable(node);

				if (state !== null) {
					break;
				}
			}

			return state;
		},

		/**
		 * Destroys all internal references to the DOM to solve IE leak issues.
		 *
		 * @method destroy
		 */
		destroy: function() {
			var self = this;

			// Unbind all events bound to window/document by editor instance
			if (self.boundEvents) {
				var i = self.boundEvents.length;

				while (i--) {
					var item = self.boundEvents[i];
					this.events.unbind(item[0], item[1], item[2]);
				}

				self.boundEvents = null;
			}

			// Restore sizzle document to window.document
			// Since the current document might be removed producing "Permission denied" on IE see #6325
			if (Sizzle.setDocument) {
				Sizzle.setDocument();
			}

			self.win = self.doc = self.root = self.events = self.frag = null;
		},

		isChildOf: function(node, parent) {
			while (node) {
				if (parent === node) {
					return true;
				}

				node = node.parentNode;
			}

			return false;
		},

		// #ifdef debug

		dumpRng: function(r) {
			return (
				'startContainer: ' + r.startContainer.nodeName +
				', startOffset: ' + r.startOffset +
				', endContainer: ' + r.endContainer.nodeName +
				', endOffset: ' + r.endOffset
			);
		},

		// #endif

		_findSib: function(node, selector, name) {
			var self = this, func = selector;

			if (node) {
				// If expression make a function of it using is
				if (typeof func == 'string') {
					func = function(node) {
						return self.is(node, selector);
					};
				}

				// Loop all siblings
				for (node = node[name]; node; node = node[name]) {
					if (func(node)) {
						return node;
					}
				}
			}

			return null;
		}
	};

	/**
	 * Instance of DOMUtils for the current document.
	 *
	 * @static
	 * @property DOM
	 * @type tinymce.dom.DOMUtils
	 * @example
	 * // Example of how to add a class to some element by id
	 * tinymce.DOM.addClass('someid', 'someclass');
	 */
	DOMUtils.DOM = new DOMUtils(document);

	return DOMUtils;
});

// Included from: js/tinymce/classes/dom/ScriptLoader.js

/**
 * ScriptLoader.js
 *
 * Released under LGPL License.
 * Copyright (c) 1999-2015 Ephox Corp. All rights reserved
 *
 * License: http://www.tinymce.com/license
 * Contributing: http://www.tinymce.com/contributing
 */

/*globals console*/

/**
 * This class handles asynchronous/synchronous loading of JavaScript files it will execute callbacks
 * when various items gets loaded. This class is useful to load external JavaScript files.
 *
 * @class tinymce.dom.ScriptLoader
 * @example
 * // Load a script from a specific URL using the global script loader
 * tinymce.ScriptLoader.load('somescript.js');
 *
 * // Load a script using a unique instance of the script loader
 * var scriptLoader = new tinymce.dom.ScriptLoader();
 *
 * scriptLoader.load('somescript.js');
 *
 * // Load multiple scripts
 * var scriptLoader = new tinymce.dom.ScriptLoader();
 *
 * scriptLoader.add('somescript1.js');
 * scriptLoader.add('somescript2.js');
 * scriptLoader.add('somescript3.js');
 *
 * scriptLoader.loadQueue(function() {
 *    alert('All scripts are now loaded.');
 * });
 */
define("tinymce/dom/ScriptLoader", [
	"tinymce/dom/DOMUtils",
	"tinymce/util/Tools"
], function(DOMUtils, Tools) {
	var DOM = DOMUtils.DOM;
	var each = Tools.each, grep = Tools.grep;

	function ScriptLoader() {
		var QUEUED = 0,
			LOADING = 1,
			LOADED = 2,
			states = {},
			queue = [],
			scriptLoadedCallbacks = {},
			queueLoadedCallbacks = [],
			loading = 0,
			undef;

		/**
		 * Loads a specific script directly without adding it to the load queue.
		 *
		 * @method load
		 * @param {String} url Absolute URL to script to add.
		 * @param {function} callback Optional callback function to execute ones this script gets loaded.
		 * @param {Object} scope Optional scope to execute callback in.
		 */
		function loadScript(url, callback) {
			var dom = DOM, elm, id;

			// Execute callback when script is loaded
			function done() {
				dom.remove(id);

				if (elm) {
					elm.onreadystatechange = elm.onload = elm = null;
				}

				callback();
			}

			function error() {
				/*eslint no-console:0 */

				// Report the error so it's easier for people to spot loading errors
				if (typeof console !== "undefined" && console.log) {
					console.log("Failed to load: " + url);
				}

				// We can't mark it as done if there is a load error since
				// A) We don't want to produce 404 errors on the server and
				// B) the onerror event won't fire on all browsers.
				// done();
			}

			id = dom.uniqueId();

			// Create new script element
			elm = document.createElement('script');
			elm.id = id;
			elm.type = 'text/javascript';
			elm.src = Tools._addCacheSuffix(url);

			// Seems that onreadystatechange works better on IE 10 onload seems to fire incorrectly
			if ("onreadystatechange" in elm) {
				elm.onreadystatechange = function() {
					if (/loaded|complete/.test(elm.readyState)) {
						done();
					}
				};
			} else {
				elm.onload = done;
			}

			// Add onerror event will get fired on some browsers but not all of them
			elm.onerror = error;

			// Add script to document
			(document.getElementsByTagName('head')[0] || document.body).appendChild(elm);
		}

		/**
		 * Returns true/false if a script has been loaded or not.
		 *
		 * @method isDone
		 * @param {String} url URL to check for.
		 * @return {Boolean} true/false if the URL is loaded.
		 */
		this.isDone = function(url) {
			return states[url] == LOADED;
		};

		/**
		 * Marks a specific script to be loaded. This can be useful if a script got loaded outside
		 * the script loader or to skip it from loading some script.
		 *
		 * @method markDone
		 * @param {string} u Absolute URL to the script to mark as loaded.
		 */
		this.markDone = function(url) {
			states[url] = LOADED;
		};

		/**
		 * Adds a specific script to the load queue of the script loader.
		 *
		 * @method add
		 * @param {String} url Absolute URL to script to add.
		 * @param {function} callback Optional callback function to execute ones this script gets loaded.
		 * @param {Object} scope Optional scope to execute callback in.
		 */
		this.add = this.load = function(url, callback, scope) {
			var state = states[url];

			// Add url to load queue
			if (state == undef) {
				queue.push(url);
				states[url] = QUEUED;
			}

			if (callback) {
				// Store away callback for later execution
				if (!scriptLoadedCallbacks[url]) {
					scriptLoadedCallbacks[url] = [];
				}

				scriptLoadedCallbacks[url].push({
					func: callback,
					scope: scope || this
				});
			}
		};

		/**
		 * Starts the loading of the queue.
		 *
		 * @method loadQueue
		 * @param {function} callback Optional callback to execute when all queued items are loaded.
		 * @param {Object} scope Optional scope to execute the callback in.
		 */
		this.loadQueue = function(callback, scope) {
			this.loadScripts(queue, callback, scope);
		};

		/**
		 * Loads the specified queue of files and executes the callback ones they are loaded.
		 * This method is generally not used outside this class but it might be useful in some scenarios.
		 *
		 * @method loadScripts
		 * @param {Array} scripts Array of queue items to load.
		 * @param {function} callback Optional callback to execute ones all items are loaded.
		 * @param {Object} scope Optional scope to execute callback in.
		 */
		this.loadScripts = function(scripts, callback, scope) {
			var loadScripts;

			function execScriptLoadedCallbacks(url) {
				// Execute URL callback functions
				each(scriptLoadedCallbacks[url], function(callback) {
					callback.func.call(callback.scope);
				});

				scriptLoadedCallbacks[url] = undef;
			}

			queueLoadedCallbacks.push({
				func: callback,
				scope: scope || this
			});

			loadScripts = function() {
				var loadingScripts = grep(scripts);

				// Current scripts has been handled
				scripts.length = 0;

				// Load scripts that needs to be loaded
				each(loadingScripts, function(url) {
					// Script is already loaded then execute script callbacks directly
					if (states[url] == LOADED) {
						execScriptLoadedCallbacks(url);
						return;
					}

					// Is script not loading then start loading it
					if (states[url] != LOADING) {
						states[url] = LOADING;
						loading++;

						loadScript(url, function() {
							states[url] = LOADED;
							loading--;

							execScriptLoadedCallbacks(url);

							// Load more scripts if they where added by the recently loaded script
							loadScripts();
						});
					}
				});

				// No scripts are currently loading then execute all pending queue loaded callbacks
				if (!loading) {
					each(queueLoadedCallbacks, function(callback) {
						callback.func.call(callback.scope);
					});

					queueLoadedCallbacks.length = 0;
				}
			};

			loadScripts();
		};
	}

	ScriptLoader.ScriptLoader = new ScriptLoader();

	return ScriptLoader;
});

// Included from: js/tinymce/classes/AddOnManager.js

/**
 * AddOnManager.js
 *
 * Released under LGPL License.
 * Copyright (c) 1999-2015 Ephox Corp. All rights reserved
 *
 * License: http://www.tinymce.com/license
 * Contributing: http://www.tinymce.com/contributing
 */

/**
 * This class handles the loading of themes/plugins or other add-ons and their language packs.
 *
 * @class tinymce.AddOnManager
 */
define("tinymce/AddOnManager", [
	"tinymce/dom/ScriptLoader",
	"tinymce/util/Tools"
], function(ScriptLoader, Tools) {
	var each = Tools.each;

	function AddOnManager() {
		var self = this;

		self.items = [];
		self.urls = {};
		self.lookup = {};
	}

	AddOnManager.prototype = {
		/**
		 * Returns the specified add on by the short name.
		 *
		 * @method get
		 * @param {String} name Add-on to look for.
		 * @return {tinymce.Theme/tinymce.Plugin} Theme or plugin add-on instance or undefined.
		 */
		get: function(name) {
			if (this.lookup[name]) {
				return this.lookup[name].instance;
			}

			return undefined;
		},

		dependencies: function(name) {
			var result;

			if (this.lookup[name]) {
				result = this.lookup[name].dependencies;
			}

			return result || [];
		},

		/**
		 * Loads a language pack for the specified add-on.
		 *
		 * @method requireLangPack
		 * @param {String} name Short name of the add-on.
		 * @param {String} languages Optional comma or space separated list of languages to check if it matches the name.
		 */
		requireLangPack: function(name, languages) {
			var language = AddOnManager.language;

			if (language && AddOnManager.languageLoad !== false) {
				if (languages) {
					languages = ',' + languages + ',';

					// Load short form sv.js or long form sv_SE.js
					if (languages.indexOf(',' + language.substr(0, 2) + ',') != -1) {
						language = language.substr(0, 2);
					} else if (languages.indexOf(',' + language + ',') == -1) {
						return;
					}
				}

				ScriptLoader.ScriptLoader.add(this.urls[name] + '/langs/' + language + '.js');
			}
		},

		/**
		 * Adds a instance of the add-on by it's short name.
		 *
		 * @method add
		 * @param {String} id Short name/id for the add-on.
		 * @param {tinymce.Theme/tinymce.Plugin} addOn Theme or plugin to add.
		 * @return {tinymce.Theme/tinymce.Plugin} The same theme or plugin instance that got passed in.
		 * @example
		 * // Create a simple plugin
		 * tinymce.create('tinymce.plugins.TestPlugin', {
		 *   TestPlugin: function(ed, url) {
		 *   ed.on('click', function(e) {
		 *      ed.windowManager.alert('Hello World!');
		 *   });
		 *   }
		 * });
		 *
		 * // Register plugin using the add method
		 * tinymce.PluginManager.add('test', tinymce.plugins.TestPlugin);
		 *
		 * // Initialize TinyMCE
		 * tinymce.init({
		 *  ...
		 *  plugins: '-test' // Init the plugin but don't try to load it
		 * });
		 */
		add: function(id, addOn, dependencies) {
			this.items.push(addOn);
			this.lookup[id] = {instance: addOn, dependencies: dependencies};

			return addOn;
		},

		createUrl: function(baseUrl, dep) {
			if (typeof dep === "object") {
				return dep;
			}

			return {prefix: baseUrl.prefix, resource: dep, suffix: baseUrl.suffix};
		},

		/**
		 * Add a set of components that will make up the add-on. Using the url of the add-on name as the base url.
		 * This should be used in development mode.  A new compressor/javascript munger process will ensure that the
		 * components are put together into the plugin.js file and compressed correctly.
		 *
		 * @method addComponents
		 * @param {String} pluginName name of the plugin to load scripts from (will be used to get the base url for the plugins).
		 * @param {Array} scripts Array containing the names of the scripts to load.
		 */
		addComponents: function(pluginName, scripts) {
			var pluginUrl = this.urls[pluginName];

			each(scripts, function(script) {
				ScriptLoader.ScriptLoader.add(pluginUrl + "/" + script);
			});
		},

		/**
		 * Loads an add-on from a specific url.
		 *
		 * @method load
		 * @param {String} name Short name of the add-on that gets loaded.
		 * @param {String} addOnUrl URL to the add-on that will get loaded.
		 * @param {function} callback Optional callback to execute ones the add-on is loaded.
		 * @param {Object} scope Optional scope to execute the callback in.
		 * @example
		 * // Loads a plugin from an external URL
		 * tinymce.PluginManager.load('myplugin', '/some/dir/someplugin/plugin.js');
		 *
		 * // Initialize TinyMCE
		 * tinymce.init({
		 *  ...
		 *  plugins: '-myplugin' // Don't try to load it again
		 * });
		 */
		load: function(name, addOnUrl, callback, scope) {
			var self = this, url = addOnUrl;

			function loadDependencies() {
				var dependencies = self.dependencies(name);

				each(dependencies, function(dep) {
					var newUrl = self.createUrl(addOnUrl, dep);

					self.load(newUrl.resource, newUrl, undefined, undefined);
				});

				if (callback) {
					if (scope) {
						callback.call(scope);
					} else {
						callback.call(ScriptLoader);
					}
				}
			}

			if (self.urls[name]) {
				return;
			}

			if (typeof addOnUrl === "object") {
				url = addOnUrl.prefix + addOnUrl.resource + addOnUrl.suffix;
			}

			if (url.indexOf('/') !== 0 && url.indexOf('://') == -1) {
				url = AddOnManager.baseURL + '/' + url;
			}

			self.urls[name] = url.substring(0, url.lastIndexOf('/'));

			if (self.lookup[name]) {
				loadDependencies();
			} else {
				ScriptLoader.ScriptLoader.add(url, loadDependencies, scope);
			}
		}
	};

	AddOnManager.PluginManager = new AddOnManager();
	AddOnManager.ThemeManager = new AddOnManager();

	return AddOnManager;
});

/**
 * TinyMCE theme class.
 *
 * @class tinymce.Theme
 */

/**
 * This method is responsible for rendering/generating the overall user interface with toolbars, buttons, iframe containers etc.
 *
 * @method renderUI
 * @param {Object} obj Object parameter containing the targetNode DOM node that will be replaced visually with an editor instance.
 * @return {Object} an object with items like iframeContainer, editorContainer, sizeContainer, deltaWidth, deltaHeight.
 */

/**
 * Plugin base class, this is a pseudo class that describes how a plugin is to be created for TinyMCE. The methods below are all optional.
 *
 * @class tinymce.Plugin
 * @example
 * tinymce.PluginManager.add('example', function(editor, url) {
 *     // Add a button that opens a window
 *     editor.addButton('example', {
 *         text: 'My button',
 *         icon: false,
 *         onclick: function() {
 *             // Open window
 *             editor.windowManager.open({
 *                 title: 'Example plugin',
 *                 body: [
 *                     {type: 'textbox', name: 'title', label: 'Title'}
 *                 ],
 *                 onsubmit: function(e) {
 *                     // Insert content when the window form is submitted
 *                     editor.insertContent('Title: ' + e.data.title);
 *                 }
 *             });
 *         }
 *     });
 *
 *     // Adds a menu item to the tools menu
 *     editor.addMenuItem('example', {
 *         text: 'Example plugin',
 *         context: 'tools',
 *         onclick: function() {
 *             // Open window with a specific url
 *             editor.windowManager.open({
 *                 title: 'TinyMCE site',
 *                 url: 'http://www.tinymce.com',
 *                 width: 800,
 *                 height: 600,
 *                 buttons: [{
 *                     text: 'Close',
 *                     onclick: 'close'
 *                 }]
 *             });
 *         }
 *     });
 * });
 */

// Included from: js/tinymce/classes/dom/RangeUtils.js

/**
 * RangeUtils.js
 *
 * Released under LGPL License.
 * Copyright (c) 1999-2015 Ephox Corp. All rights reserved
 *
 * License: http://www.tinymce.com/license
 * Contributing: http://www.tinymce.com/contributing
 */

/**
 * This class contains a few utility methods for ranges.
 *
 * @class tinymce.dom.RangeUtils
 */
define("tinymce/dom/RangeUtils", [
	"tinymce/util/Tools",
	"tinymce/dom/TreeWalker"
], function(Tools, TreeWalker) {
	var each = Tools.each;

	function getEndChild(container, index) {
		var childNodes = container.childNodes;

		index--;

		if (index > childNodes.length - 1) {
			index = childNodes.length - 1;
		} else if (index < 0) {
			index = 0;
		}

		return childNodes[index] || container;
	}

	function RangeUtils(dom) {
		/**
		 * Walks the specified range like object and executes the callback for each sibling collection it finds.
		 *
		 * @private
		 * @method walk
		 * @param {Object} rng Range like object.
		 * @param {function} callback Callback function to execute for each sibling collection.
		 */
		this.walk = function(rng, callback) {
			var startContainer = rng.startContainer,
				startOffset = rng.startOffset,
				endContainer = rng.endContainer,
				endOffset = rng.endOffset,
				ancestor, startPoint,
				endPoint, node, parent, siblings, nodes;

			// Handle table cell selection the table plugin enables
			// you to fake select table cells and perform formatting actions on them
			nodes = dom.select('td.mce-item-selected,th.mce-item-selected');
			if (nodes.length > 0) {
				each(nodes, function(node) {
					callback([node]);
				});

				return;
			}

			/**
			 * Excludes start/end text node if they are out side the range
			 *
			 * @private
			 * @param {Array} nodes Nodes to exclude items from.
			 * @return {Array} Array with nodes excluding the start/end container if needed.
			 */
			function exclude(nodes) {
				var node;

				// First node is excluded
				node = nodes[0];
				if (node.nodeType === 3 && node === startContainer && startOffset >= node.nodeValue.length) {
					nodes.splice(0, 1);
				}

				// Last node is excluded
				node = nodes[nodes.length - 1];
				if (endOffset === 0 && nodes.length > 0 && node === endContainer && node.nodeType === 3) {
					nodes.splice(nodes.length - 1, 1);
				}

				return nodes;
			}

			/**
			 * Collects siblings
			 *
			 * @private
			 * @param {Node} node Node to collect siblings from.
			 * @param {String} name Name of the sibling to check for.
			 * @return {Array} Array of collected siblings.
			 */
			function collectSiblings(node, name, end_node) {
				var siblings = [];

				for (; node && node != end_node; node = node[name]) {
					siblings.push(node);
				}

				return siblings;
			}

			/**
			 * Find an end point this is the node just before the common ancestor root.
			 *
			 * @private
			 * @param {Node} node Node to start at.
			 * @param {Node} root Root/ancestor element to stop just before.
			 * @return {Node} Node just before the root element.
			 */
			function findEndPoint(node, root) {
				do {
					if (node.parentNode == root) {
						return node;
					}

					node = node.parentNode;
				} while (node);
			}

			function walkBoundary(start_node, end_node, next) {
				var siblingName = next ? 'nextSibling' : 'previousSibling';

				for (node = start_node, parent = node.parentNode; node && node != end_node; node = parent) {
					parent = node.parentNode;
					siblings = collectSiblings(node == start_node ? node : node[siblingName], siblingName);

					if (siblings.length) {
						if (!next) {
							siblings.reverse();
						}

						callback(exclude(siblings));
					}
				}
			}

			// If index based start position then resolve it
			if (startContainer.nodeType == 1 && startContainer.hasChildNodes()) {
				startContainer = startContainer.childNodes[startOffset];
			}

			// If index based end position then resolve it
			if (endContainer.nodeType == 1 && endContainer.hasChildNodes()) {
				endContainer = getEndChild(endContainer, endOffset);
			}

			// Same container
			if (startContainer == endContainer) {
				return callback(exclude([startContainer]));
			}

			// Find common ancestor and end points
			ancestor = dom.findCommonAncestor(startContainer, endContainer);

			// Process left side
			for (node = startContainer; node; node = node.parentNode) {
				if (node === endContainer) {
					return walkBoundary(startContainer, ancestor, true);
				}

				if (node === ancestor) {
					break;
				}
			}

			// Process right side
			for (node = endContainer; node; node = node.parentNode) {
				if (node === startContainer) {
					return walkBoundary(endContainer, ancestor);
				}

				if (node === ancestor) {
					break;
				}
			}

			// Find start/end point
			startPoint = findEndPoint(startContainer, ancestor) || startContainer;
			endPoint = findEndPoint(endContainer, ancestor) || endContainer;

			// Walk left leaf
			walkBoundary(startContainer, startPoint, true);

			// Walk the middle from start to end point
			siblings = collectSiblings(
				startPoint == startContainer ? startPoint : startPoint.nextSibling,
				'nextSibling',
				endPoint == endContainer ? endPoint.nextSibling : endPoint
			);

			if (siblings.length) {
				callback(exclude(siblings));
			}

			// Walk right leaf
			walkBoundary(endContainer, endPoint);
		};

		/**
		 * Splits the specified range at it's start/end points.
		 *
		 * @private
		 * @param {Range/RangeObject} rng Range to split.
		 * @return {Object} Range position object.
		 */
		this.split = function(rng) {
			var startContainer = rng.startContainer,
				startOffset = rng.startOffset,
				endContainer = rng.endContainer,
				endOffset = rng.endOffset;

			function splitText(node, offset) {
				return node.splitText(offset);
			}

			// Handle single text node
			if (startContainer == endContainer && startContainer.nodeType == 3) {
				if (startOffset > 0 && startOffset < startContainer.nodeValue.length) {
					endContainer = splitText(startContainer, startOffset);
					startContainer = endContainer.previousSibling;

					if (endOffset > startOffset) {
						endOffset = endOffset - startOffset;
						startContainer = endContainer = splitText(endContainer, endOffset).previousSibling;
						endOffset = endContainer.nodeValue.length;
						startOffset = 0;
					} else {
						endOffset = 0;
					}
				}
			} else {
				// Split startContainer text node if needed
				if (startContainer.nodeType == 3 && startOffset > 0 && startOffset < startContainer.nodeValue.length) {
					startContainer = splitText(startContainer, startOffset);
					startOffset = 0;
				}

				// Split endContainer text node if needed
				if (endContainer.nodeType == 3 && endOffset > 0 && endOffset < endContainer.nodeValue.length) {
					endContainer = splitText(endContainer, endOffset).previousSibling;
					endOffset = endContainer.nodeValue.length;
				}
			}

			return {
				startContainer: startContainer,
				startOffset: startOffset,
				endContainer: endContainer,
				endOffset: endOffset
			};
		};

		/**
		 * Normalizes the specified range by finding the closest best suitable caret location.
		 *
		 * @private
		 * @param {Range} rng Range to normalize.
		 * @return {Boolean} True/false if the specified range was normalized or not.
		 */
		this.normalize = function(rng) {
			var normalized, collapsed;

			function normalizeEndPoint(start) {
				var container, offset, walker, body = dom.getRoot(), node, nonEmptyElementsMap;
				var directionLeft, isAfterNode;

				function hasBrBeforeAfter(node, left) {
					var walker = new TreeWalker(node, dom.getParent(node.parentNode, dom.isBlock) || body);

					while ((node = walker[left ? 'prev' : 'next']())) {
						if (node.nodeName === "BR") {
							return true;
						}
					}
				}

				function isPrevNode(node, name) {
					return node.previousSibling && node.previousSibling.nodeName == name;
				}

				// Walks the dom left/right to find a suitable text node to move the endpoint into
				// It will only walk within the current parent block or body and will stop if it hits a block or a BR/IMG
				function findTextNodeRelative(left, startNode) {
					var walker, lastInlineElement, parentBlockContainer;

					startNode = startNode || container;
					parentBlockContainer = dom.getParent(startNode.parentNode, dom.isBlock) || body;

					// Lean left before the BR element if it's the only BR within a block element. Gecko bug: #6680
					// This: <p><br>|</p> becomes <p>|<br></p>
					if (left && startNode.nodeName == 'BR' && isAfterNode && dom.isEmpty(parentBlockContainer)) {
						container = startNode.parentNode;
						offset = dom.nodeIndex(startNode);
						normalized = true;
						return;
					}

					// Walk left until we hit a text node we can move to or a block/br/img
					walker = new TreeWalker(startNode, parentBlockContainer);
					while ((node = walker[left ? 'prev' : 'next']())) {
						// Break if we hit a non content editable node
						if (dom.getContentEditableParent(node) === "false") {
							return;
						}

						// Found text node that has a length
						if (node.nodeType === 3 && node.nodeValue.length > 0) {
							container = node;
							offset = left ? node.nodeValue.length : 0;
							normalized = true;
							return;
						}

						// Break if we find a block or a BR/IMG/INPUT etc
						if (dom.isBlock(node) || nonEmptyElementsMap[node.nodeName.toLowerCase()]) {
							return;
						}

						lastInlineElement = node;
					}

					// Only fetch the last inline element when in caret mode for now
					if (collapsed && lastInlineElement) {
						container = lastInlineElement;
						normalized = true;
						offset = 0;
					}
				}

				container = rng[(start ? 'start' : 'end') + 'Container'];
				offset = rng[(start ? 'start' : 'end') + 'Offset'];
				isAfterNode = container.nodeType == 1 && offset === container.childNodes.length;
				nonEmptyElementsMap = dom.schema.getNonEmptyElements();
				directionLeft = start;

				if (container.nodeType == 1 && offset > container.childNodes.length - 1) {
					directionLeft = false;
				}

				// If the container is a document move it to the body element
				if (container.nodeType === 9) {
					container = dom.getRoot();
					offset = 0;
				}

				// If the container is body try move it into the closest text node or position
				if (container === body) {
					// If start is before/after a image, table etc
					if (directionLeft) {
						node = container.childNodes[offset > 0 ? offset - 1 : 0];
						if (node) {
							if (nonEmptyElementsMap[node.nodeName] || node.nodeName == "TABLE") {
								return;
							}
						}
					}

					// Resolve the index
					if (container.hasChildNodes()) {
						offset = Math.min(!directionLeft && offset > 0 ? offset - 1 : offset, container.childNodes.length - 1);
						container = container.childNodes[offset];
						offset = 0;

						// Don't walk into elements that doesn't have any child nodes like a IMG
						if (container.hasChildNodes() && !/TABLE/.test(container.nodeName)) {
							// Walk the DOM to find a text node to place the caret at or a BR
							node = container;
							walker = new TreeWalker(container, body);

							do {
								// Found a text node use that position
								if (node.nodeType === 3 && node.nodeValue.length > 0) {
									offset = directionLeft ? 0 : node.nodeValue.length;
									container = node;
									normalized = true;
									break;
								}

								// Found a BR/IMG element that we can place the caret before
								if (nonEmptyElementsMap[node.nodeName.toLowerCase()]) {
									offset = dom.nodeIndex(node);
									container = node.parentNode;

									// Put caret after image when moving the end point
									if (node.nodeName == "IMG" && !directionLeft) {
										offset++;
									}

									normalized = true;
									break;
								}
							} while ((node = (directionLeft ? walker.next() : walker.prev())));
						}
					}
				}

				// Lean the caret to the left if possible
				if (collapsed) {
					// So this: <b>x</b><i>|x</i>
					// Becomes: <b>x|</b><i>x</i>
					// Seems that only gecko has issues with this
					if (container.nodeType === 3 && offset === 0) {
						findTextNodeRelative(true);
					}

					// Lean left into empty inline elements when the caret is before a BR
					// So this: <i><b></b><i>|<br></i>
					// Becomes: <i><b>|</b><i><br></i>
					// Seems that only gecko has issues with this.
					// Special edge case for <p><a>x</a>|<br></p> since we don't want <p><a>x|</a><br></p>
					if (container.nodeType === 1) {
						node = container.childNodes[offset];

						// Offset is after the containers last child
						// then use the previous child for normalization
						if (!node) {
							node = container.childNodes[offset - 1];
						}

						if (node && node.nodeName === 'BR' && !isPrevNode(node, 'A') &&
							!hasBrBeforeAfter(node) && !hasBrBeforeAfter(node, true)) {
							findTextNodeRelative(true, node);
						}
					}
				}

				// Lean the start of the selection right if possible
				// So this: x[<b>x]</b>
				// Becomes: x<b>[x]</b>
				if (directionLeft && !collapsed && container.nodeType === 3 && offset === container.nodeValue.length) {
					findTextNodeRelative(false);
				}

				// Set endpoint if it was normalized
				if (normalized) {
					rng['set' + (start ? 'Start' : 'End')](container, offset);
				}
			}

			collapsed = rng.collapsed;

			normalizeEndPoint(true);

			if (!collapsed) {
				normalizeEndPoint();
			}

			// If it was collapsed then make sure it still is
			if (normalized && collapsed) {
				rng.collapse(true);
			}

			return normalized;
		};
	}

	/**
	 * Compares two ranges and checks if they are equal.
	 *
	 * @static
	 * @method compareRanges
	 * @param {DOMRange} rng1 First range to compare.
	 * @param {DOMRange} rng2 First range to compare.
	 * @return {Boolean} true/false if the ranges are equal.
	 */
	RangeUtils.compareRanges = function(rng1, rng2) {
		if (rng1 && rng2) {
			// Compare native IE ranges
			if (rng1.item || rng1.duplicate) {
				// Both are control ranges and the selected element matches
				if (rng1.item && rng2.item && rng1.item(0) === rng2.item(0)) {
					return true;
				}

				// Both are text ranges and the range matches
				if (rng1.isEqual && rng2.isEqual && rng2.isEqual(rng1)) {
					return true;
				}
			} else {
				// Compare w3c ranges
				return rng1.startContainer == rng2.startContainer && rng1.startOffset == rng2.startOffset;
			}
		}

		return false;
	};

	/**
	 * Gets the caret range for the given x/y location.
	 *
	 * @static
	 * @method getCaretRangeFromPoint
	 * @param {Number} x X coordinate for range
	 * @param {Number} y Y coordinate for range
	 * @param {Document} doc Document that x/y are relative to
	 * @returns {Range} caret range
	 */
	RangeUtils.getCaretRangeFromPoint = function(x, y, doc) {
		var rng, point;

		if (doc.caretPositionFromPoint) {
			point = doc.caretPositionFromPoint(x, y);
			rng = doc.createRange();
			rng.setStart(point.offsetNode, point.offset);
			rng.collapse(true);
		} else if (doc.caretRangeFromPoint) {
			rng = doc.caretRangeFromPoint(x, y);
		} else if (doc.body.createTextRange) {
			rng = doc.body.createTextRange();

			try {
				rng.moveToPoint(x, y);
				rng.collapse(true);
			} catch (ex) {
				// Append to top or bottom depending on drop location
				rng.collapse(y < doc.body.clientHeight);
			}
		}

		return rng;
	};

	RangeUtils.getNode = function(container, offset) {
		if (container.nodeType == 1 && container.hasChildNodes()) {
			if (offset >= container.childNodes.length) {
				offset = container.childNodes.length - 1;
			}

			container = container.childNodes[offset];
		}

		return container;
	};

	return RangeUtils;
});

// Included from: js/tinymce/classes/NodeChange.js

/**
 * NodeChange.js
 *
 * Released under LGPL License.
 * Copyright (c) 1999-2015 Ephox Corp. All rights reserved
 *
 * License: http://www.tinymce.com/license
 * Contributing: http://www.tinymce.com/contributing
 */

/**
 * This class handles the nodechange event dispatching both manual and through selection change events.
 *
 * @class tinymce.NodeChange
 * @private
 */
define("tinymce/NodeChange", [
	"tinymce/dom/RangeUtils",
	"tinymce/Env"
], function(RangeUtils, Env) {
	return function(editor) {
		var lastRng, lastPath = [];

		/**
		 * Returns true/false if the current element path has been changed or not.
		 *
		 * @private
		 * @return {Boolean} True if the element path is the same false if it's not.
		 */
		function isSameElementPath(startElm) {
			var i, currentPath;

			currentPath = editor.$(startElm).parentsUntil(editor.getBody()).add(startElm);
			if (currentPath.length === lastPath.length) {
				for (i = currentPath.length; i >= 0; i--) {
					if (currentPath[i] !== lastPath[i]) {
						break;
					}
				}

				if (i === -1) {
					lastPath = currentPath;
					return true;
				}
			}

			lastPath = currentPath;

			return false;
		}

		// Gecko doesn't support the "selectionchange" event
		if (!('onselectionchange' in editor.getDoc())) {
			editor.on('NodeChange Click MouseUp KeyUp Focus', function(e) {
				var nativeRng, fakeRng;

				// Since DOM Ranges mutate on modification
				// of the DOM we need to clone it's contents
				nativeRng = editor.selection.getRng();
				fakeRng = {
					startContainer: nativeRng.startContainer,
					startOffset: nativeRng.startOffset,
					endContainer: nativeRng.endContainer,
					endOffset: nativeRng.endOffset
				};

				// Always treat nodechange as a selectionchange since applying
				// formatting to the current range wouldn't update the range but it's parent
				if (e.type == 'nodechange' || !RangeUtils.compareRanges(fakeRng, lastRng)) {
					editor.fire('SelectionChange');
				}

				lastRng = fakeRng;
			});
		}

		// IE has a bug where it fires a selectionchange on right click that has a range at the start of the body
		// When the contextmenu event fires the selection is located at the right location
		editor.on('contextmenu', function() {
			editor.fire('SelectionChange');
		});

		// Selection change is delayed ~200ms on IE when you click inside the current range
		editor.on('SelectionChange', function() {
			var startElm = editor.selection.getStart(true);

			// IE 8 will fire a selectionchange event with an incorrect selection
			// when focusing out of table cells. Click inside cell -> toolbar = Invalid SelectionChange event
			if (!Env.range && editor.selection.isCollapsed()) {
				return;
			}

			if (!isSameElementPath(startElm) && editor.dom.isChildOf(startElm, editor.getBody())) {
				editor.nodeChanged({selectionChange: true});
			}
		});

		// Fire an extra nodeChange on mouseup for compatibility reasons
		editor.on('MouseUp', function(e) {
			if (!e.isDefaultPrevented()) {
				// Delay nodeChanged call for WebKit edge case issue where the range
				// isn't updated until after you click outside a selected image
				if (editor.selection.getNode().nodeName == 'IMG') {
					setTimeout(function() {
						editor.nodeChanged();
					}, 0);
				} else {
					editor.nodeChanged();
				}
			}
		});

		/**
		 * Dispatches out a onNodeChange event to all observers. This method should be called when you
		 * need to update the UI states or element path etc.
		 *
		 * @method nodeChanged
		 * @param {Object} args Optional args to pass to NodeChange event handlers.
		 */
		this.nodeChanged = function(args) {
			var selection = editor.selection, node, parents, root;

			// Fix for bug #1896577 it seems that this can not be fired while the editor is loading
			if (editor.initialized && selection && !editor.settings.disable_nodechange && !editor.settings.readonly) {
				// Get start node
				root = editor.getBody();
				node = selection.getStart() || root;
				node = node.ownerDocument != editor.getDoc() ? editor.getBody() : node;

				// Edge case for <p>|<img></p>
				if (node.nodeName == 'IMG' && selection.isCollapsed()) {
					node = node.parentNode;
				}

				// Get parents and add them to object
				parents = [];
				editor.dom.getParent(node, function(node) {
					if (node === root) {
						return true;
					}

					parents.push(node);
				});

				args = args || {};
				args.element = node;
				args.parents = parents;

				editor.fire('NodeChange', args);
			}
		};
	};
});

// Included from: js/tinymce/classes/html/Node.js

/**
 * Node.js
 *
 * Released under LGPL License.
 * Copyright (c) 1999-2015 Ephox Corp. All rights reserved
 *
 * License: http://www.tinymce.com/license
 * Contributing: http://www.tinymce.com/contributing
 */

/**
 * This class is a minimalistic implementation of a DOM like node used by the DomParser class.
 *
 * @example
 * var node = new tinymce.html.Node('strong', 1);
 * someRoot.append(node);
 *
 * @class tinymce.html.Node
 * @version 3.4
 */
define("tinymce/html/Node", [], function() {
	var whiteSpaceRegExp = /^[ \t\r\n]*$/, typeLookup = {
		'#text': 3,
		'#comment': 8,
		'#cdata': 4,
		'#pi': 7,
		'#doctype': 10,
		'#document-fragment': 11
	};

	// Walks the tree left/right
	function walk(node, root_node, prev) {
		var sibling, parent, startName = prev ? 'lastChild' : 'firstChild', siblingName = prev ? 'prev' : 'next';

		// Walk into nodes if it has a start
		if (node[startName]) {
			return node[startName];
		}

		// Return the sibling if it has one
		if (node !== root_node) {
			sibling = node[siblingName];

			if (sibling) {
				return sibling;
			}

			// Walk up the parents to look for siblings
			for (parent = node.parent; parent && parent !== root_node; parent = parent.parent) {
				sibling = parent[siblingName];

				if (sibling) {
					return sibling;
				}
			}
		}
	}

	/**
	 * Constructs a new Node instance.
	 *
	 * @constructor
	 * @method Node
	 * @param {String} name Name of the node type.
	 * @param {Number} type Numeric type representing the node.
	 */
	function Node(name, type) {
		this.name = name;
		this.type = type;

		if (type === 1) {
			this.attributes = [];
			this.attributes.map = {};
		}
	}

	Node.prototype = {
		/**
		 * Replaces the current node with the specified one.
		 *
		 * @example
		 * someNode.replace(someNewNode);
		 *
		 * @method replace
		 * @param {tinymce.html.Node} node Node to replace the current node with.
		 * @return {tinymce.html.Node} The old node that got replaced.
		 */
		replace: function(node) {
			var self = this;

			if (node.parent) {
				node.remove();
			}

			self.insert(node, self);
			self.remove();

			return self;
		},

		/**
		 * Gets/sets or removes an attribute by name.
		 *
		 * @example
		 * someNode.attr("name", "value"); // Sets an attribute
		 * console.log(someNode.attr("name")); // Gets an attribute
		 * someNode.attr("name", null); // Removes an attribute
		 *
		 * @method attr
		 * @param {String} name Attribute name to set or get.
		 * @param {String} value Optional value to set.
		 * @return {String/tinymce.html.Node} String or undefined on a get operation or the current node on a set operation.
		 */
		attr: function(name, value) {
			var self = this, attrs, i, undef;

			if (typeof name !== "string") {
				for (i in name) {
					self.attr(i, name[i]);
				}

				return self;
			}

			if ((attrs = self.attributes)) {
				if (value !== undef) {
					// Remove attribute
					if (value === null) {
						if (name in attrs.map) {
							delete attrs.map[name];

							i = attrs.length;
							while (i--) {
								if (attrs[i].name === name) {
									attrs = attrs.splice(i, 1);
									return self;
								}
							}
						}

						return self;
					}

					// Set attribute
					if (name in attrs.map) {
						// Set attribute
						i = attrs.length;
						while (i--) {
							if (attrs[i].name === name) {
								attrs[i].value = value;
								break;
							}
						}
					} else {
						attrs.push({name: name, value: value});
					}

					attrs.map[name] = value;

					return self;
				}

				return attrs.map[name];
			}
		},

		/**
		 * Does a shallow clones the node into a new node. It will also exclude id attributes since
		 * there should only be one id per document.
		 *
		 * @example
		 * var clonedNode = node.clone();
		 *
		 * @method clone
		 * @return {tinymce.html.Node} New copy of the original node.
		 */
		clone: function() {
			var self = this, clone = new Node(self.name, self.type), i, l, selfAttrs, selfAttr, cloneAttrs;

			// Clone element attributes
			if ((selfAttrs = self.attributes)) {
				cloneAttrs = [];
				cloneAttrs.map = {};

				for (i = 0, l = selfAttrs.length; i < l; i++) {
					selfAttr = selfAttrs[i];

					// Clone everything except id
					if (selfAttr.name !== 'id') {
						cloneAttrs[cloneAttrs.length] = {name: sel