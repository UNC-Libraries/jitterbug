var __getOwnPropNames = Object.getOwnPropertyNames;
var __commonJS = (cb, mod) => function __require() {
  return mod || (0, cb[__getOwnPropNames(cb)[0]])((mod = { exports: {} }).exports, mod), mod.exports;
};
var require_app_002 = __commonJS({
  "assets/app-F2s3XCpE.js"(exports) {
    function getDefaultExportFromCjs(x) {
      return x && x.__esModule && Object.prototype.hasOwnProperty.call(x, "default") ? x["default"] : x;
    }
    var jquery$1 = { exports: {} };
    /*!
     * jQuery JavaScript Library v3.7.1
     * https://jquery.com/
     *
     * Copyright OpenJS Foundation and other contributors
     * Released under the MIT license
     * https://jquery.org/license
     *
     * Date: 2023-08-28T13:37Z
     */
    var jquery = jquery$1.exports;
    var hasRequiredJquery;
    function requireJquery() {
      if (hasRequiredJquery) return jquery$1.exports;
      hasRequiredJquery = 1;
      (function(module2) {
        (function(global, factory) {
          {
            module2.exports = global.document ? factory(global, true) : function(w) {
              if (!w.document) {
                throw new Error("jQuery requires a window with a document");
              }
              return factory(w);
            };
          }
        })(typeof window !== "undefined" ? window : jquery, function(window2, noGlobal) {
          var arr = [];
          var getProto = Object.getPrototypeOf;
          var slice = arr.slice;
          var flat = arr.flat ? function(array) {
            return arr.flat.call(array);
          } : function(array) {
            return arr.concat.apply([], array);
          };
          var push = arr.push;
          var indexOf = arr.indexOf;
          var class2type = {};
          var toString = class2type.toString;
          var hasOwn = class2type.hasOwnProperty;
          var fnToString = hasOwn.toString;
          var ObjectFunctionString = fnToString.call(Object);
          var support = {};
          var isFunction = function isFunction2(obj) {
            return typeof obj === "function" && typeof obj.nodeType !== "number" && typeof obj.item !== "function";
          };
          var isWindow = function isWindow2(obj) {
            return obj != null && obj === obj.window;
          };
          var document2 = window2.document;
          var preservedScriptAttributes = {
            type: true,
            src: true,
            nonce: true,
            noModule: true
          };
          function DOMEval(code, node, doc) {
            doc = doc || document2;
            var i2, val, script = doc.createElement("script");
            script.text = code;
            if (node) {
              for (i2 in preservedScriptAttributes) {
                val = node[i2] || node.getAttribute && node.getAttribute(i2);
                if (val) {
                  script.setAttribute(i2, val);
                }
              }
            }
            doc.head.appendChild(script).parentNode.removeChild(script);
          }
          function toType(obj) {
            if (obj == null) {
              return obj + "";
            }
            return typeof obj === "object" || typeof obj === "function" ? class2type[toString.call(obj)] || "object" : typeof obj;
          }
          var version = "3.7.1", rhtmlSuffix = /HTML$/i, jQuery = function(selector, context) {
            return new jQuery.fn.init(selector, context);
          };
          jQuery.fn = jQuery.prototype = {
            // The current version of jQuery being used
            jquery: version,
            constructor: jQuery,
            // The default length of a jQuery object is 0
            length: 0,
            toArray: function() {
              return slice.call(this);
            },
            // Get the Nth element in the matched element set OR
            // Get the whole matched element set as a clean array
            get: function(num2) {
              if (num2 == null) {
                return slice.call(this);
              }
              return num2 < 0 ? this[num2 + this.length] : this[num2];
            },
            // Take an array of elements and push it onto the stack
            // (returning the new matched element set)
            pushStack: function(elems) {
              var ret = jQuery.merge(this.constructor(), elems);
              ret.prevObject = this;
              return ret;
            },
            // Execute a callback for every element in the matched set.
            each: function(callback) {
              return jQuery.each(this, callback);
            },
            map: function(callback) {
              return this.pushStack(jQuery.map(this, function(elem, i2) {
                return callback.call(elem, i2, elem);
              }));
            },
            slice: function() {
              return this.pushStack(slice.apply(this, arguments));
            },
            first: function() {
              return this.eq(0);
            },
            last: function() {
              return this.eq(-1);
            },
            even: function() {
              return this.pushStack(jQuery.grep(this, function(_elem, i2) {
                return (i2 + 1) % 2;
              }));
            },
            odd: function() {
              return this.pushStack(jQuery.grep(this, function(_elem, i2) {
                return i2 % 2;
              }));
            },
            eq: function(i2) {
              var len = this.length, j = +i2 + (i2 < 0 ? len : 0);
              return this.pushStack(j >= 0 && j < len ? [this[j]] : []);
            },
            end: function() {
              return this.prevObject || this.constructor();
            },
            // For internal use only.
            // Behaves like an Array's method, not like a jQuery method.
            push,
            sort: arr.sort,
            splice: arr.splice
          };
          jQuery.extend = jQuery.fn.extend = function() {
            var options, name, src, copy, copyIsArray, clone, target = arguments[0] || {}, i2 = 1, length = arguments.length, deep = false;
            if (typeof target === "boolean") {
              deep = target;
              target = arguments[i2] || {};
              i2++;
            }
            if (typeof target !== "object" && !isFunction(target)) {
              target = {};
            }
            if (i2 === length) {
              target = this;
              i2--;
            }
            for (; i2 < length; i2++) {
              if ((options = arguments[i2]) != null) {
                for (name in options) {
                  copy = options[name];
                  if (name === "__proto__" || target === copy) {
                    continue;
                  }
                  if (deep && copy && (jQuery.isPlainObject(copy) || (copyIsArray = Array.isArray(copy)))) {
                    src = target[name];
                    if (copyIsArray && !Array.isArray(src)) {
                      clone = [];
                    } else if (!copyIsArray && !jQuery.isPlainObject(src)) {
                      clone = {};
                    } else {
                      clone = src;
                    }
                    copyIsArray = false;
                    target[name] = jQuery.extend(deep, clone, copy);
                  } else if (copy !== void 0) {
                    target[name] = copy;
                  }
                }
              }
            }
            return target;
          };
          jQuery.extend({
            // Unique for each copy of jQuery on the page
            expando: "jQuery" + (version + Math.random()).replace(/\D/g, ""),
            // Assume jQuery is ready without the ready module
            isReady: true,
            error: function(msg) {
              throw new Error(msg);
            },
            noop: function() {
            },
            isPlainObject: function(obj) {
              var proto, Ctor;
              if (!obj || toString.call(obj) !== "[object Object]") {
                return false;
              }
              proto = getProto(obj);
              if (!proto) {
                return true;
              }
              Ctor = hasOwn.call(proto, "constructor") && proto.constructor;
              return typeof Ctor === "function" && fnToString.call(Ctor) === ObjectFunctionString;
            },
            isEmptyObject: function(obj) {
              var name;
              for (name in obj) {
                return false;
              }
              return true;
            },
            // Evaluates a script in a provided context; falls back to the global one
            // if not specified.
            globalEval: function(code, options, doc) {
              DOMEval(code, { nonce: options && options.nonce }, doc);
            },
            each: function(obj, callback) {
              var length, i2 = 0;
              if (isArrayLike(obj)) {
                length = obj.length;
                for (; i2 < length; i2++) {
                  if (callback.call(obj[i2], i2, obj[i2]) === false) {
                    break;
                  }
                }
              } else {
                for (i2 in obj) {
                  if (callback.call(obj[i2], i2, obj[i2]) === false) {
                    break;
                  }
                }
              }
              return obj;
            },
            // Retrieve the text value of an array of DOM nodes
            text: function(elem) {
              var node, ret = "", i2 = 0, nodeType = elem.nodeType;
              if (!nodeType) {
                while (node = elem[i2++]) {
                  ret += jQuery.text(node);
                }
              }
              if (nodeType === 1 || nodeType === 11) {
                return elem.textContent;
              }
              if (nodeType === 9) {
                return elem.documentElement.textContent;
              }
              if (nodeType === 3 || nodeType === 4) {
                return elem.nodeValue;
              }
              return ret;
            },
            // results is for internal usage only
            makeArray: function(arr2, results) {
              var ret = results || [];
              if (arr2 != null) {
                if (isArrayLike(Object(arr2))) {
                  jQuery.merge(
                    ret,
                    typeof arr2 === "string" ? [arr2] : arr2
                  );
                } else {
                  push.call(ret, arr2);
                }
              }
              return ret;
            },
            inArray: function(elem, arr2, i2) {
              return arr2 == null ? -1 : indexOf.call(arr2, elem, i2);
            },
            isXMLDoc: function(elem) {
              var namespace = elem && elem.namespaceURI, docElem = elem && (elem.ownerDocument || elem).documentElement;
              return !rhtmlSuffix.test(namespace || docElem && docElem.nodeName || "HTML");
            },
            // Support: Android <=4.0 only, PhantomJS 1 only
            // push.apply(_, arraylike) throws on ancient WebKit
            merge: function(first, second) {
              var len = +second.length, j = 0, i2 = first.length;
              for (; j < len; j++) {
                first[i2++] = second[j];
              }
              first.length = i2;
              return first;
            },
            grep: function(elems, callback, invert) {
              var callbackInverse, matches = [], i2 = 0, length = elems.length, callbackExpect = !invert;
              for (; i2 < length; i2++) {
                callbackInverse = !callback(elems[i2], i2);
                if (callbackInverse !== callbackExpect) {
                  matches.push(elems[i2]);
                }
              }
              return matches;
            },
            // arg is for internal usage only
            map: function(elems, callback, arg) {
              var length, value, i2 = 0, ret = [];
              if (isArrayLike(elems)) {
                length = elems.length;
                for (; i2 < length; i2++) {
                  value = callback(elems[i2], i2, arg);
                  if (value != null) {
                    ret.push(value);
                  }
                }
              } else {
                for (i2 in elems) {
                  value = callback(elems[i2], i2, arg);
                  if (value != null) {
                    ret.push(value);
                  }
                }
              }
              return flat(ret);
            },
            // A global GUID counter for objects
            guid: 1,
            // jQuery.support is not used in Core but other projects attach their
            // properties to it so it needs to exist.
            support
          });
          if (typeof Symbol === "function") {
            jQuery.fn[Symbol.iterator] = arr[Symbol.iterator];
          }
          jQuery.each(
            "Boolean Number String Function Array Date RegExp Object Error Symbol".split(" "),
            function(_i, name) {
              class2type["[object " + name + "]"] = name.toLowerCase();
            }
          );
          function isArrayLike(obj) {
            var length = !!obj && "length" in obj && obj.length, type = toType(obj);
            if (isFunction(obj) || isWindow(obj)) {
              return false;
            }
            return type === "array" || length === 0 || typeof length === "number" && length > 0 && length - 1 in obj;
          }
          function nodeName(elem, name) {
            return elem.nodeName && elem.nodeName.toLowerCase() === name.toLowerCase();
          }
          var pop = arr.pop;
          var sort = arr.sort;
          var splice = arr.splice;
          var whitespace = "[\\x20\\t\\r\\n\\f]";
          var rtrimCSS = new RegExp(
            "^" + whitespace + "+|((?:^|[^\\\\])(?:\\\\.)*)" + whitespace + "+$",
            "g"
          );
          jQuery.contains = function(a, b) {
            var bup = b && b.parentNode;
            return a === bup || !!(bup && bup.nodeType === 1 && // Support: IE 9 - 11+
            // IE doesn't have `contains` on SVG.
            (a.contains ? a.contains(bup) : a.compareDocumentPosition && a.compareDocumentPosition(bup) & 16));
          };
          var rcssescape = /([\0-\x1f\x7f]|^-?\d)|^-$|[^\x80-\uFFFF\w-]/g;
          function fcssescape(ch, asCodePoint) {
            if (asCodePoint) {
              if (ch === "\0") {
                return "�";
              }
              return ch.slice(0, -1) + "\\" + ch.charCodeAt(ch.length - 1).toString(16) + " ";
            }
            return "\\" + ch;
          }
          jQuery.escapeSelector = function(sel) {
            return (sel + "").replace(rcssescape, fcssescape);
          };
          var preferredDoc = document2, pushNative = push;
          (function() {
            var i2, Expr, outermostContext, sortInput, hasDuplicate, push2 = pushNative, document3, documentElement2, documentIsHTML, rbuggyQSA, matches, expando = jQuery.expando, dirruns = 0, done = 0, classCache = createCache(), tokenCache = createCache(), compilerCache = createCache(), nonnativeSelectorCache = createCache(), sortOrder = function(a, b) {
              if (a === b) {
                hasDuplicate = true;
              }
              return 0;
            }, booleans = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped", identifier = "(?:\\\\[\\da-fA-F]{1,6}" + whitespace + "?|\\\\[^\\r\\n\\f]|[\\w-]|[^\0-\\x7f])+", attributes = "\\[" + whitespace + "*(" + identifier + ")(?:" + whitespace + // Operator (capture 2)
            "*([*^$|!~]?=)" + whitespace + // "Attribute values must be CSS identifiers [capture 5] or strings [capture 3 or capture 4]"
            `*(?:'((?:\\\\.|[^\\\\'])*)'|"((?:\\\\.|[^\\\\"])*)"|(` + identifier + "))|)" + whitespace + "*\\]", pseudos = ":(" + identifier + `)(?:\\((('((?:\\\\.|[^\\\\'])*)'|"((?:\\\\.|[^\\\\"])*)")|((?:\\\\.|[^\\\\()[\\]]|` + attributes + ")*)|.*)\\)|)", rwhitespace = new RegExp(whitespace + "+", "g"), rcomma = new RegExp("^" + whitespace + "*," + whitespace + "*"), rleadingCombinator = new RegExp("^" + whitespace + "*([>+~]|" + whitespace + ")" + whitespace + "*"), rdescend = new RegExp(whitespace + "|>"), rpseudo = new RegExp(pseudos), ridentifier = new RegExp("^" + identifier + "$"), matchExpr = {
              ID: new RegExp("^#(" + identifier + ")"),
              CLASS: new RegExp("^\\.(" + identifier + ")"),
              TAG: new RegExp("^(" + identifier + "|[*])"),
              ATTR: new RegExp("^" + attributes),
              PSEUDO: new RegExp("^" + pseudos),
              CHILD: new RegExp(
                "^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + whitespace + "*(even|odd|(([+-]|)(\\d*)n|)" + whitespace + "*(?:([+-]|)" + whitespace + "*(\\d+)|))" + whitespace + "*\\)|)",
                "i"
              ),
              bool: new RegExp("^(?:" + booleans + ")$", "i"),
              // For use in libraries implementing .is()
              // We use this for POS matching in `select`
              needsContext: new RegExp("^" + whitespace + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + whitespace + "*((?:-\\d)?\\d*)" + whitespace + "*\\)|)(?=[^-]|$)", "i")
            }, rinputs = /^(?:input|select|textarea|button)$/i, rheader = /^h\d$/i, rquickExpr2 = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/, rsibling = /[+~]/, runescape = new RegExp("\\\\[\\da-fA-F]{1,6}" + whitespace + "?|\\\\([^\\r\\n\\f])", "g"), funescape = function(escape, nonHex) {
              var high = "0x" + escape.slice(1) - 65536;
              if (nonHex) {
                return nonHex;
              }
              return high < 0 ? String.fromCharCode(high + 65536) : String.fromCharCode(high >> 10 | 55296, high & 1023 | 56320);
            }, unloadHandler = function() {
              setDocument();
            }, inDisabledFieldset = addCombinator(
              function(elem) {
                return elem.disabled === true && nodeName(elem, "fieldset");
              },
              { dir: "parentNode", next: "legend" }
            );
            function safeActiveElement() {
              try {
                return document3.activeElement;
              } catch (err) {
              }
            }
            try {
              push2.apply(
                arr = slice.call(preferredDoc.childNodes),
                preferredDoc.childNodes
              );
              arr[preferredDoc.childNodes.length].nodeType;
            } catch (e) {
              push2 = {
                apply: function(target, els) {
                  pushNative.apply(target, slice.call(els));
                },
                call: function(target) {
                  pushNative.apply(target, slice.call(arguments, 1));
                }
              };
            }
            function find(selector, context, results, seed) {
              var m, i3, elem, nid, match, groups, newSelector, newContext = context && context.ownerDocument, nodeType = context ? context.nodeType : 9;
              results = results || [];
              if (typeof selector !== "string" || !selector || nodeType !== 1 && nodeType !== 9 && nodeType !== 11) {
                return results;
              }
              if (!seed) {
                setDocument(context);
                context = context || document3;
                if (documentIsHTML) {
                  if (nodeType !== 11 && (match = rquickExpr2.exec(selector))) {
                    if (m = match[1]) {
                      if (nodeType === 9) {
                        if (elem = context.getElementById(m)) {
                          if (elem.id === m) {
                            push2.call(results, elem);
                            return results;
                          }
                        } else {
                          return results;
                        }
                      } else {
                        if (newContext && (elem = newContext.getElementById(m)) && find.contains(context, elem) && elem.id === m) {
                          push2.call(results, elem);
                          return results;
                        }
                      }
                    } else if (match[2]) {
                      push2.apply(results, context.getElementsByTagName(selector));
                      return results;
                    } else if ((m = match[3]) && context.getElementsByClassName) {
                      push2.apply(results, context.getElementsByClassName(m));
                      return results;
                    }
                  }
                  if (!nonnativeSelectorCache[selector + " "] && (!rbuggyQSA || !rbuggyQSA.test(selector))) {
                    newSelector = selector;
                    newContext = context;
                    if (nodeType === 1 && (rdescend.test(selector) || rleadingCombinator.test(selector))) {
                      newContext = rsibling.test(selector) && testContext(context.parentNode) || context;
                      if (newContext != context || !support.scope) {
                        if (nid = context.getAttribute("id")) {
                          nid = jQuery.escapeSelector(nid);
                        } else {
                          context.setAttribute("id", nid = expando);
                        }
                      }
                      groups = tokenize(selector);
                      i3 = groups.length;
                      while (i3--) {
                        groups[i3] = (nid ? "#" + nid : ":scope") + " " + toSelector(groups[i3]);
                      }
                      newSelector = groups.join(",");
                    }
                    try {
                      push2.apply(
                        results,
                        newContext.querySelectorAll(newSelector)
                      );
                      return results;
                    } catch (qsaError) {
                      nonnativeSelectorCache(selector, true);
                    } finally {
                      if (nid === expando) {
                        context.removeAttribute("id");
                      }
                    }
                  }
                }
              }
              return select(selector.replace(rtrimCSS, "$1"), context, results, seed);
            }
            function createCache() {
              var keys = [];
              function cache(key2, value) {
                if (keys.push(key2 + " ") > Expr.cacheLength) {
                  delete cache[keys.shift()];
                }
                return cache[key2 + " "] = value;
              }
              return cache;
            }
            function markFunction(fn) {
              fn[expando] = true;
              return fn;
            }
            function assert(fn) {
              var el = document3.createElement("fieldset");
              try {
                return !!fn(el);
              } catch (e) {
                return false;
              } finally {
                if (el.parentNode) {
                  el.parentNode.removeChild(el);
                }
                el = null;
              }
            }
            function createInputPseudo(type) {
              return function(elem) {
                return nodeName(elem, "input") && elem.type === type;
              };
            }
            function createButtonPseudo(type) {
              return function(elem) {
                return (nodeName(elem, "input") || nodeName(elem, "button")) && elem.type === type;
              };
            }
            function createDisabledPseudo(disabled) {
              return function(elem) {
                if ("form" in elem) {
                  if (elem.parentNode && elem.disabled === false) {
                    if ("label" in elem) {
                      if ("label" in elem.parentNode) {
                        return elem.parentNode.disabled === disabled;
                      } else {
                        return elem.disabled === disabled;
                      }
                    }
                    return elem.isDisabled === disabled || // Where there is no isDisabled, check manually
                    elem.isDisabled !== !disabled && inDisabledFieldset(elem) === disabled;
                  }
                  return elem.disabled === disabled;
                } else if ("label" in elem) {
                  return elem.disabled === disabled;
                }
                return false;
              };
            }
            function createPositionalPseudo(fn) {
              return markFunction(function(argument) {
                argument = +argument;
                return markFunction(function(seed, matches2) {
                  var j, matchIndexes = fn([], seed.length, argument), i3 = matchIndexes.length;
                  while (i3--) {
                    if (seed[j = matchIndexes[i3]]) {
                      seed[j] = !(matches2[j] = seed[j]);
                    }
                  }
                });
              });
            }
            function testContext(context) {
              return context && typeof context.getElementsByTagName !== "undefined" && context;
            }
            function setDocument(node) {
              var subWindow, doc = node ? node.ownerDocument || node : preferredDoc;
              if (doc == document3 || doc.nodeType !== 9 || !doc.documentElement) {
                return document3;
              }
              document3 = doc;
              documentElement2 = document3.documentElement;
              documentIsHTML = !jQuery.isXMLDoc(document3);
              matches = documentElement2.matches || documentElement2.webkitMatchesSelector || documentElement2.msMatchesSelector;
              if (documentElement2.msMatchesSelector && // Support: IE 11+, Edge 17 - 18+
              // IE/Edge sometimes throw a "Permission denied" error when strict-comparing
              // two documents; shallow comparisons work.
              // eslint-disable-next-line eqeqeq
              preferredDoc != document3 && (subWindow = document3.defaultView) && subWindow.top !== subWindow) {
                subWindow.addEventListener("unload", unloadHandler);
              }
              support.getById = assert(function(el) {
                documentElement2.appendChild(el).id = jQuery.expando;
                return !document3.getElementsByName || !document3.getElementsByName(jQuery.expando).length;
              });
              support.disconnectedMatch = assert(function(el) {
                return matches.call(el, "*");
              });
              support.scope = assert(function() {
                return document3.querySelectorAll(":scope");
              });
              support.cssHas = assert(function() {
                try {
                  document3.querySelector(":has(*,:jqfake)");
                  return false;
                } catch (e) {
                  return true;
                }
              });
              if (support.getById) {
                Expr.filter.ID = function(id) {
                  var attrId = id.replace(runescape, funescape);
                  return function(elem) {
                    return elem.getAttribute("id") === attrId;
                  };
                };
                Expr.find.ID = function(id, context) {
                  if (typeof context.getElementById !== "undefined" && documentIsHTML) {
                    var elem = context.getElementById(id);
                    return elem ? [elem] : [];
                  }
                };
              } else {
                Expr.filter.ID = function(id) {
                  var attrId = id.replace(runescape, funescape);
                  return function(elem) {
                    var node2 = typeof elem.getAttributeNode !== "undefined" && elem.getAttributeNode("id");
                    return node2 && node2.value === attrId;
                  };
                };
                Expr.find.ID = function(id, context) {
                  if (typeof context.getElementById !== "undefined" && documentIsHTML) {
                    var node2, i3, elems, elem = context.getElementById(id);
                    if (elem) {
                      node2 = elem.getAttributeNode("id");
                      if (node2 && node2.value === id) {
                        return [elem];
                      }
                      elems = context.getElementsByName(id);
                      i3 = 0;
                      while (elem = elems[i3++]) {
                        node2 = elem.getAttributeNode("id");
                        if (node2 && node2.value === id) {
                          return [elem];
                        }
                      }
                    }
                    return [];
                  }
                };
              }
              Expr.find.TAG = function(tag, context) {
                if (typeof context.getElementsByTagName !== "undefined") {
                  return context.getElementsByTagName(tag);
                } else {
                  return context.querySelectorAll(tag);
                }
              };
              Expr.find.CLASS = function(className, context) {
                if (typeof context.getElementsByClassName !== "undefined" && documentIsHTML) {
                  return context.getElementsByClassName(className);
                }
              };
              rbuggyQSA = [];
              assert(function(el) {
                var input;
                documentElement2.appendChild(el).innerHTML = "<a id='" + expando + "' href='' disabled='disabled'></a><select id='" + expando + "-\r\\' disabled='disabled'><option selected=''></option></select>";
                if (!el.querySelectorAll("[selected]").length) {
                  rbuggyQSA.push("\\[" + whitespace + "*(?:value|" + booleans + ")");
                }
                if (!el.querySelectorAll("[id~=" + expando + "-]").length) {
                  rbuggyQSA.push("~=");
                }
                if (!el.querySelectorAll("a#" + expando + "+*").length) {
                  rbuggyQSA.push(".#.+[+~]");
                }
                if (!el.querySelectorAll(":checked").length) {
                  rbuggyQSA.push(":checked");
                }
                input = document3.createElement("input");
                input.setAttribute("type", "hidden");
                el.appendChild(input).setAttribute("name", "D");
                documentElement2.appendChild(el).disabled = true;
                if (el.querySelectorAll(":disabled").length !== 2) {
                  rbuggyQSA.push(":enabled", ":disabled");
                }
                input = document3.createElement("input");
                input.setAttribute("name", "");
                el.appendChild(input);
                if (!el.querySelectorAll("[name='']").length) {
                  rbuggyQSA.push("\\[" + whitespace + "*name" + whitespace + "*=" + whitespace + `*(?:''|"")`);
                }
              });
              if (!support.cssHas) {
                rbuggyQSA.push(":has");
              }
              rbuggyQSA = rbuggyQSA.length && new RegExp(rbuggyQSA.join("|"));
              sortOrder = function(a, b) {
                if (a === b) {
                  hasDuplicate = true;
                  return 0;
                }
                var compare = !a.compareDocumentPosition - !b.compareDocumentPosition;
                if (compare) {
                  return compare;
                }
                compare = (a.ownerDocument || a) == (b.ownerDocument || b) ? a.compareDocumentPosition(b) : (
                  // Otherwise we know they are disconnected
                  1
                );
                if (compare & 1 || !support.sortDetached && b.compareDocumentPosition(a) === compare) {
                  if (a === document3 || a.ownerDocument == preferredDoc && find.contains(preferredDoc, a)) {
                    return -1;
                  }
                  if (b === document3 || b.ownerDocument == preferredDoc && find.contains(preferredDoc, b)) {
                    return 1;
                  }
                  return sortInput ? indexOf.call(sortInput, a) - indexOf.call(sortInput, b) : 0;
                }
                return compare & 4 ? -1 : 1;
              };
              return document3;
            }
            find.matches = function(expr, elements) {
              return find(expr, null, null, elements);
            };
            find.matchesSelector = function(elem, expr) {
              setDocument(elem);
              if (documentIsHTML && !nonnativeSelectorCache[expr + " "] && (!rbuggyQSA || !rbuggyQSA.test(expr))) {
                try {
                  var ret = matches.call(elem, expr);
                  if (ret || support.disconnectedMatch || // As well, disconnected nodes are said to be in a document
                  // fragment in IE 9
                  elem.document && elem.document.nodeType !== 11) {
                    return ret;
                  }
                } catch (e) {
                  nonnativeSelectorCache(expr, true);
                }
              }
              return find(expr, document3, null, [elem]).length > 0;
            };
            find.contains = function(context, elem) {
              if ((context.ownerDocument || context) != document3) {
                setDocument(context);
              }
              return jQuery.contains(context, elem);
            };
            find.attr = function(elem, name) {
              if ((elem.ownerDocument || elem) != document3) {
                setDocument(elem);
              }
              var fn = Expr.attrHandle[name.toLowerCase()], val = fn && hasOwn.call(Expr.attrHandle, name.toLowerCase()) ? fn(elem, name, !documentIsHTML) : void 0;
              if (val !== void 0) {
                return val;
              }
              return elem.getAttribute(name);
            };
            find.error = function(msg) {
              throw new Error("Syntax error, unrecognized expression: " + msg);
            };
            jQuery.uniqueSort = function(results) {
              var elem, duplicates = [], j = 0, i3 = 0;
              hasDuplicate = !support.sortStable;
              sortInput = !support.sortStable && slice.call(results, 0);
              sort.call(results, sortOrder);
              if (hasDuplicate) {
                while (elem = results[i3++]) {
                  if (elem === results[i3]) {
                    j = duplicates.push(i3);
                  }
                }
                while (j--) {
                  splice.call(results, duplicates[j], 1);
                }
              }
              sortInput = null;
              return results;
            };
            jQuery.fn.uniqueSort = function() {
              return this.pushStack(jQuery.uniqueSort(slice.apply(this)));
            };
            Expr = jQuery.expr = {
              // Can be adjusted by the user
              cacheLength: 50,
              createPseudo: markFunction,
              match: matchExpr,
              attrHandle: {},
              find: {},
              relative: {
                ">": { dir: "parentNode", first: true },
                " ": { dir: "parentNode" },
                "+": { dir: "previousSibling", first: true },
                "~": { dir: "previousSibling" }
              },
              preFilter: {
                ATTR: function(match) {
                  match[1] = match[1].replace(runescape, funescape);
                  match[3] = (match[3] || match[4] || match[5] || "").replace(runescape, funescape);
                  if (match[2] === "~=") {
                    match[3] = " " + match[3] + " ";
                  }
                  return match.slice(0, 4);
                },
                CHILD: function(match) {
                  match[1] = match[1].toLowerCase();
                  if (match[1].slice(0, 3) === "nth") {
                    if (!match[3]) {
                      find.error(match[0]);
                    }
                    match[4] = +(match[4] ? match[5] + (match[6] || 1) : 2 * (match[3] === "even" || match[3] === "odd"));
                    match[5] = +(match[7] + match[8] || match[3] === "odd");
                  } else if (match[3]) {
                    find.error(match[0]);
                  }
                  return match;
                },
                PSEUDO: function(match) {
                  var excess, unquoted = !match[6] && match[2];
                  if (matchExpr.CHILD.test(match[0])) {
                    return null;
                  }
                  if (match[3]) {
                    match[2] = match[4] || match[5] || "";
                  } else if (unquoted && rpseudo.test(unquoted) && // Get excess from tokenize (recursively)
                  (excess = tokenize(unquoted, true)) && // advance to the next closing parenthesis
                  (excess = unquoted.indexOf(")", unquoted.length - excess) - unquoted.length)) {
                    match[0] = match[0].slice(0, excess);
                    match[2] = unquoted.slice(0, excess);
                  }
                  return match.slice(0, 3);
                }
              },
              filter: {
                TAG: function(nodeNameSelector) {
                  var expectedNodeName = nodeNameSelector.replace(runescape, funescape).toLowerCase();
                  return nodeNameSelector === "*" ? function() {
                    return true;
                  } : function(elem) {
                    return nodeName(elem, expectedNodeName);
                  };
                },
                CLASS: function(className) {
                  var pattern = classCache[className + " "];
                  return pattern || (pattern = new RegExp("(^|" + whitespace + ")" + className + "(" + whitespace + "|$)")) && classCache(className, function(elem) {
                    return pattern.test(
                      typeof elem.className === "string" && elem.className || typeof elem.getAttribute !== "undefined" && elem.getAttribute("class") || ""
                    );
                  });
                },
                ATTR: function(name, operator, check) {
                  return function(elem) {
                    var result = find.attr(elem, name);
                    if (result == null) {
                      return operator === "!=";
                    }
                    if (!operator) {
                      return true;
                    }
                    result += "";
                    if (operator === "=") {
                      return result === check;
                    }
                    if (operator === "!=") {
                      return result !== check;
                    }
                    if (operator === "^=") {
                      return check && result.indexOf(check) === 0;
                    }
                    if (operator === "*=") {
                      return check && result.indexOf(check) > -1;
                    }
                    if (operator === "$=") {
                      return check && result.slice(-check.length) === check;
                    }
                    if (operator === "~=") {
                      return (" " + result.replace(rwhitespace, " ") + " ").indexOf(check) > -1;
                    }
                    if (operator === "|=") {
                      return result === check || result.slice(0, check.length + 1) === check + "-";
                    }
                    return false;
                  };
                },
                CHILD: function(type, what, _argument, first, last) {
                  var simple = type.slice(0, 3) !== "nth", forward = type.slice(-4) !== "last", ofType = what === "of-type";
                  return first === 1 && last === 0 ? (
                    // Shortcut for :nth-*(n)
                    function(elem) {
                      return !!elem.parentNode;
                    }
                  ) : function(elem, _context, xml) {
                    var cache, outerCache, node, nodeIndex, start, dir2 = simple !== forward ? "nextSibling" : "previousSibling", parent = elem.parentNode, name = ofType && elem.nodeName.toLowerCase(), useCache = !xml && !ofType, diff = false;
                    if (parent) {
                      if (simple) {
                        while (dir2) {
                          node = elem;
                          while (node = node[dir2]) {
                            if (ofType ? nodeName(node, name) : node.nodeType === 1) {
                              return false;
                            }
                          }
                          start = dir2 = type === "only" && !start && "nextSibling";
                        }
                        return true;
                      }
                      start = [forward ? parent.firstChild : parent.lastChild];
                      if (forward && useCache) {
                        outerCache = parent[expando] || (parent[expando] = {});
                        cache = outerCache[type] || [];
                        nodeIndex = cache[0] === dirruns && cache[1];
                        diff = nodeIndex && cache[2];
                        node = nodeIndex && parent.childNodes[nodeIndex];
                        while (node = ++nodeIndex && node && node[dir2] || // Fallback to seeking `elem` from the start
                        (diff = nodeIndex = 0) || start.pop()) {
                          if (node.nodeType === 1 && ++diff && node === elem) {
                            outerCache[type] = [dirruns, nodeIndex, diff];
                            break;
                          }
                        }
                      } else {
                        if (useCache) {
                          outerCache = elem[expando] || (elem[expando] = {});
                          cache = outerCache[type] || [];
                          nodeIndex = cache[0] === dirruns && cache[1];
                          diff = nodeIndex;
                        }
                        if (diff === false) {
                          while (node = ++nodeIndex && node && node[dir2] || (diff = nodeIndex = 0) || start.pop()) {
                            if ((ofType ? nodeName(node, name) : node.nodeType === 1) && ++diff) {
                              if (useCache) {
                                outerCache = node[expando] || (node[expando] = {});
                                outerCache[type] = [dirruns, diff];
                              }
                              if (node === elem) {
                                break;
                              }
                            }
                          }
                        }
                      }
                      diff -= last;
                      return diff === first || diff % first === 0 && diff / first >= 0;
                    }
                  };
                },
                PSEUDO: function(pseudo, argument) {
                  var args, fn = Expr.pseudos[pseudo] || Expr.setFilters[pseudo.toLowerCase()] || find.error("unsupported pseudo: " + pseudo);
                  if (fn[expando]) {
                    return fn(argument);
                  }
                  if (fn.length > 1) {
                    args = [pseudo, pseudo, "", argument];
                    return Expr.setFilters.hasOwnProperty(pseudo.toLowerCase()) ? markFunction(function(seed, matches2) {
                      var idx, matched = fn(seed, argument), i3 = matched.length;
                      while (i3--) {
                        idx = indexOf.call(seed, matched[i3]);
                        seed[idx] = !(matches2[idx] = matched[i3]);
                      }
                    }) : function(elem) {
                      return fn(elem, 0, args);
                    };
                  }
                  return fn;
                }
              },
              pseudos: {
                // Potentially complex pseudos
                not: markFunction(function(selector) {
                  var input = [], results = [], matcher = compile(selector.replace(rtrimCSS, "$1"));
                  return matcher[expando] ? markFunction(function(seed, matches2, _context, xml) {
                    var elem, unmatched = matcher(seed, null, xml, []), i3 = seed.length;
                    while (i3--) {
                      if (elem = unmatched[i3]) {
                        seed[i3] = !(matches2[i3] = elem);
                      }
                    }
                  }) : function(elem, _context, xml) {
                    input[0] = elem;
                    matcher(input, null, xml, results);
                    input[0] = null;
                    return !results.pop();
                  };
                }),
                has: markFunction(function(selector) {
                  return function(elem) {
                    return find(selector, elem).length > 0;
                  };
                }),
                contains: markFunction(function(text) {
                  text = text.replace(runescape, funescape);
                  return function(elem) {
                    return (elem.textContent || jQuery.text(elem)).indexOf(text) > -1;
                  };
                }),
                // "Whether an element is represented by a :lang() selector
                // is based solely on the element's language value
                // being equal to the identifier C,
                // or beginning with the identifier C immediately followed by "-".
                // The matching of C against the element's language value is performed case-insensitively.
                // The identifier C does not have to be a valid language name."
                // https://www.w3.org/TR/selectors/#lang-pseudo
                lang: markFunction(function(lang) {
                  if (!ridentifier.test(lang || "")) {
                    find.error("unsupported lang: " + lang);
                  }
                  lang = lang.replace(runescape, funescape).toLowerCase();
                  return function(elem) {
                    var elemLang;
                    do {
                      if (elemLang = documentIsHTML ? elem.lang : elem.getAttribute("xml:lang") || elem.getAttribute("lang")) {
                        elemLang = elemLang.toLowerCase();
                        return elemLang === lang || elemLang.indexOf(lang + "-") === 0;
                      }
                    } while ((elem = elem.parentNode) && elem.nodeType === 1);
                    return false;
                  };
                }),
                // Miscellaneous
                target: function(elem) {
                  var hash = window2.location && window2.location.hash;
                  return hash && hash.slice(1) === elem.id;
                },
                root: function(elem) {
                  return elem === documentElement2;
                },
                focus: function(elem) {
                  return elem === safeActiveElement() && document3.hasFocus() && !!(elem.type || elem.href || ~elem.tabIndex);
                },
                // Boolean properties
                enabled: createDisabledPseudo(false),
                disabled: createDisabledPseudo(true),
                checked: function(elem) {
                  return nodeName(elem, "input") && !!elem.checked || nodeName(elem, "option") && !!elem.selected;
                },
                selected: function(elem) {
                  if (elem.parentNode) {
                    elem.parentNode.selectedIndex;
                  }
                  return elem.selected === true;
                },
                // Contents
                empty: function(elem) {
                  for (elem = elem.firstChild; elem; elem = elem.nextSibling) {
                    if (elem.nodeType < 6) {
                      return false;
                    }
                  }
                  return true;
                },
                parent: function(elem) {
                  return !Expr.pseudos.empty(elem);
                },
                // Element/input types
                header: function(elem) {
                  return rheader.test(elem.nodeName);
                },
                input: function(elem) {
                  return rinputs.test(elem.nodeName);
                },
                button: function(elem) {
                  return nodeName(elem, "input") && elem.type === "button" || nodeName(elem, "button");
                },
                text: function(elem) {
                  var attr;
                  return nodeName(elem, "input") && elem.type === "text" && // Support: IE <10 only
                  // New HTML5 attribute values (e.g., "search") appear
                  // with elem.type === "text"
                  ((attr = elem.getAttribute("type")) == null || attr.toLowerCase() === "text");
                },
                // Position-in-collection
                first: createPositionalPseudo(function() {
                  return [0];
                }),
                last: createPositionalPseudo(function(_matchIndexes, length) {
                  return [length - 1];
                }),
                eq: createPositionalPseudo(function(_matchIndexes, length, argument) {
                  return [argument < 0 ? argument + length : argument];
                }),
                even: createPositionalPseudo(function(matchIndexes, length) {
                  var i3 = 0;
                  for (; i3 < length; i3 += 2) {
                    matchIndexes.push(i3);
                  }
                  return matchIndexes;
                }),
                odd: createPositionalPseudo(function(matchIndexes, length) {
                  var i3 = 1;
                  for (; i3 < length; i3 += 2) {
                    matchIndexes.push(i3);
                  }
                  return matchIndexes;
                }),
                lt: createPositionalPseudo(function(matchIndexes, length, argument) {
                  var i3;
                  if (argument < 0) {
                    i3 = argument + length;
                  } else if (argument > length) {
                    i3 = length;
                  } else {
                    i3 = argument;
                  }
                  for (; --i3 >= 0; ) {
                    matchIndexes.push(i3);
                  }
                  return matchIndexes;
                }),
                gt: createPositionalPseudo(function(matchIndexes, length, argument) {
                  var i3 = argument < 0 ? argument + length : argument;
                  for (; ++i3 < length; ) {
                    matchIndexes.push(i3);
                  }
                  return matchIndexes;
                })
              }
            };
            Expr.pseudos.nth = Expr.pseudos.eq;
            for (i2 in { radio: true, checkbox: true, file: true, password: true, image: true }) {
              Expr.pseudos[i2] = createInputPseudo(i2);
            }
            for (i2 in { submit: true, reset: true }) {
              Expr.pseudos[i2] = createButtonPseudo(i2);
            }
            function setFilters() {
            }
            setFilters.prototype = Expr.filters = Expr.pseudos;
            Expr.setFilters = new setFilters();
            function tokenize(selector, parseOnly) {
              var matched, match, tokens, type, soFar, groups, preFilters, cached = tokenCache[selector + " "];
              if (cached) {
                return parseOnly ? 0 : cached.slice(0);
              }
              soFar = selector;
              groups = [];
              preFilters = Expr.preFilter;
              while (soFar) {
                if (!matched || (match = rcomma.exec(soFar))) {
                  if (match) {
                    soFar = soFar.slice(match[0].length) || soFar;
                  }
                  groups.push(tokens = []);
                }
                matched = false;
                if (match = rleadingCombinator.exec(soFar)) {
                  matched = match.shift();
                  tokens.push({
                    value: matched,
                    // Cast descendant combinators to space
                    type: match[0].replace(rtrimCSS, " ")
                  });
                  soFar = soFar.slice(matched.length);
                }
                for (type in Expr.filter) {
                  if ((match = matchExpr[type].exec(soFar)) && (!preFilters[type] || (match = preFilters[type](match)))) {
                    matched = match.shift();
                    tokens.push({
                      value: matched,
                      type,
                      matches: match
                    });
                    soFar = soFar.slice(matched.length);
                  }
                }
                if (!matched) {
                  break;
                }
              }
              if (parseOnly) {
                return soFar.length;
              }
              return soFar ? find.error(selector) : (
                // Cache the tokens
                tokenCache(selector, groups).slice(0)
              );
            }
            function toSelector(tokens) {
              var i3 = 0, len = tokens.length, selector = "";
              for (; i3 < len; i3++) {
                selector += tokens[i3].value;
              }
              return selector;
            }
            function addCombinator(matcher, combinator, base) {
              var dir2 = combinator.dir, skip = combinator.next, key2 = skip || dir2, checkNonElements = base && key2 === "parentNode", doneName = done++;
              return combinator.first ? (
                // Check against closest ancestor/preceding element
                function(elem, context, xml) {
                  while (elem = elem[dir2]) {
                    if (elem.nodeType === 1 || checkNonElements) {
                      return matcher(elem, context, xml);
                    }
                  }
                  return false;
                }
              ) : (
                // Check against all ancestor/preceding elements
                function(elem, context, xml) {
                  var oldCache, outerCache, newCache = [dirruns, doneName];
                  if (xml) {
                    while (elem = elem[dir2]) {
                      if (elem.nodeType === 1 || checkNonElements) {
                        if (matcher(elem, context, xml)) {
                          return true;
                        }
                      }
                    }
                  } else {
                    while (elem = elem[dir2]) {
                      if (elem.nodeType === 1 || checkNonElements) {
                        outerCache = elem[expando] || (elem[expando] = {});
                        if (skip && nodeName(elem, skip)) {
                          elem = elem[dir2] || elem;
                        } else if ((oldCache = outerCache[key2]) && oldCache[0] === dirruns && oldCache[1] === doneName) {
                          return newCache[2] = oldCache[2];
                        } else {
                          outerCache[key2] = newCache;
                          if (newCache[2] = matcher(elem, context, xml)) {
                            return true;
                          }
                        }
                      }
                    }
                  }
                  return false;
                }
              );
            }
            function elementMatcher(matchers) {
              return matchers.length > 1 ? function(elem, context, xml) {
                var i3 = matchers.length;
                while (i3--) {
                  if (!matchers[i3](elem, context, xml)) {
                    return false;
                  }
                }
                return true;
              } : matchers[0];
            }
            function multipleContexts(selector, contexts, results) {
              var i3 = 0, len = contexts.length;
              for (; i3 < len; i3++) {
                find(selector, contexts[i3], results);
              }
              return results;
            }
            function condense(unmatched, map, filter, context, xml) {
              var elem, newUnmatched = [], i3 = 0, len = unmatched.length, mapped = map != null;
              for (; i3 < len; i3++) {
                if (elem = unmatched[i3]) {
                  if (!filter || filter(elem, context, xml)) {
                    newUnmatched.push(elem);
                    if (mapped) {
                      map.push(i3);
                    }
                  }
                }
              }
              return newUnmatched;
            }
            function setMatcher(preFilter, selector, matcher, postFilter, postFinder, postSelector) {
              if (postFilter && !postFilter[expando]) {
                postFilter = setMatcher(postFilter);
              }
              if (postFinder && !postFinder[expando]) {
                postFinder = setMatcher(postFinder, postSelector);
              }
              return markFunction(function(seed, results, context, xml) {
                var temp, i3, elem, matcherOut, preMap = [], postMap = [], preexisting = results.length, elems = seed || multipleContexts(
                  selector || "*",
                  context.nodeType ? [context] : context,
                  []
                ), matcherIn = preFilter && (seed || !selector) ? condense(elems, preMap, preFilter, context, xml) : elems;
                if (matcher) {
                  matcherOut = postFinder || (seed ? preFilter : preexisting || postFilter) ? (
                    // ...intermediate processing is necessary
                    []
                  ) : (
                    // ...otherwise use results directly
                    results
                  );
                  matcher(matcherIn, matcherOut, context, xml);
                } else {
                  matcherOut = matcherIn;
                }
                if (postFilter) {
                  temp = condense(matcherOut, postMap);
                  postFilter(temp, [], context, xml);
                  i3 = temp.length;
                  while (i3--) {
                    if (elem = temp[i3]) {
                      matcherOut[postMap[i3]] = !(matcherIn[postMap[i3]] = elem);
                    }
                  }
                }
                if (seed) {
                  if (postFinder || preFilter) {
                    if (postFinder) {
                      temp = [];
                      i3 = matcherOut.length;
                      while (i3--) {
                        if (elem = matcherOut[i3]) {
                          temp.push(matcherIn[i3] = elem);
                        }
                      }
                      postFinder(null, matcherOut = [], temp, xml);
                    }
                    i3 = matcherOut.length;
                    while (i3--) {
                      if ((elem = matcherOut[i3]) && (temp = postFinder ? indexOf.call(seed, elem) : preMap[i3]) > -1) {
                        seed[temp] = !(results[temp] = elem);
                      }
                    }
                  }
                } else {
                  matcherOut = condense(
                    matcherOut === results ? matcherOut.splice(preexisting, matcherOut.length) : matcherOut
                  );
                  if (postFinder) {
                    postFinder(null, results, matcherOut, xml);
                  } else {
                    push2.apply(results, matcherOut);
                  }
                }
              });
            }
            function matcherFromTokens(tokens) {
              var checkContext, matcher, j, len = tokens.length, leadingRelative = Expr.relative[tokens[0].type], implicitRelative = leadingRelative || Expr.relative[" "], i3 = leadingRelative ? 1 : 0, matchContext = addCombinator(function(elem) {
                return elem === checkContext;
              }, implicitRelative, true), matchAnyContext = addCombinator(function(elem) {
                return indexOf.call(checkContext, elem) > -1;
              }, implicitRelative, true), matchers = [function(elem, context, xml) {
                var ret = !leadingRelative && (xml || context != outermostContext) || ((checkContext = context).nodeType ? matchContext(elem, context, xml) : matchAnyContext(elem, context, xml));
                checkContext = null;
                return ret;
              }];
              for (; i3 < len; i3++) {
                if (matcher = Expr.relative[tokens[i3].type]) {
                  matchers = [addCombinator(elementMatcher(matchers), matcher)];
                } else {
                  matcher = Expr.filter[tokens[i3].type].apply(null, tokens[i3].matches);
                  if (matcher[expando]) {
                    j = ++i3;
                    for (; j < len; j++) {
                      if (Expr.relative[tokens[j].type]) {
                        break;
                      }
                    }
                    return setMatcher(
                      i3 > 1 && elementMatcher(matchers),
                      i3 > 1 && toSelector(
                        // If the preceding token was a descendant combinator, insert an implicit any-element `*`
                        tokens.slice(0, i3 - 1).concat({ value: tokens[i3 - 2].type === " " ? "*" : "" })
                      ).replace(rtrimCSS, "$1"),
                      matcher,
                      i3 < j && matcherFromTokens(tokens.slice(i3, j)),
                      j < len && matcherFromTokens(tokens = tokens.slice(j)),
                      j < len && toSelector(tokens)
                    );
                  }
                  matchers.push(matcher);
                }
              }
              return elementMatcher(matchers);
            }
            function matcherFromGroupMatchers(elementMatchers, setMatchers) {
              var bySet = setMatchers.length > 0, byElement = elementMatchers.length > 0, superMatcher = function(seed, context, xml, results, outermost) {
                var elem, j, matcher, matchedCount = 0, i3 = "0", unmatched = seed && [], setMatched = [], contextBackup = outermostContext, elems = seed || byElement && Expr.find.TAG("*", outermost), dirrunsUnique = dirruns += contextBackup == null ? 1 : Math.random() || 0.1, len = elems.length;
                if (outermost) {
                  outermostContext = context == document3 || context || outermost;
                }
                for (; i3 !== len && (elem = elems[i3]) != null; i3++) {
                  if (byElement && elem) {
                    j = 0;
                    if (!context && elem.ownerDocument != document3) {
                      setDocument(elem);
                      xml = !documentIsHTML;
                    }
                    while (matcher = elementMatchers[j++]) {
                      if (matcher(elem, context || document3, xml)) {
                        push2.call(results, elem);
                        break;
                      }
                    }
                    if (outermost) {
                      dirruns = dirrunsUnique;
                    }
                  }
                  if (bySet) {
                    if (elem = !matcher && elem) {
                      matchedCount--;
                    }
                    if (seed) {
                      unmatched.push(elem);
                    }
                  }
                }
                matchedCount += i3;
                if (bySet && i3 !== matchedCount) {
                  j = 0;
                  while (matcher = setMatchers[j++]) {
                    matcher(unmatched, setMatched, context, xml);
                  }
                  if (seed) {
                    if (matchedCount > 0) {
                      while (i3--) {
                        if (!(unmatched[i3] || setMatched[i3])) {
                          setMatched[i3] = pop.call(results);
                        }
                      }
                    }
                    setMatched = condense(setMatched);
                  }
                  push2.apply(results, setMatched);
                  if (outermost && !seed && setMatched.length > 0 && matchedCount + setMatchers.length > 1) {
                    jQuery.uniqueSort(results);
                  }
                }
                if (outermost) {
                  dirruns = dirrunsUnique;
                  outermostContext = contextBackup;
                }
                return unmatched;
              };
              return bySet ? markFunction(superMatcher) : superMatcher;
            }
            function compile(selector, match) {
              var i3, setMatchers = [], elementMatchers = [], cached = compilerCache[selector + " "];
              if (!cached) {
                if (!match) {
                  match = tokenize(selector);
                }
                i3 = match.length;
                while (i3--) {
                  cached = matcherFromTokens(match[i3]);
                  if (cached[expando]) {
                    setMatchers.push(cached);
                  } else {
                    elementMatchers.push(cached);
                  }
                }
                cached = compilerCache(
                  selector,
                  matcherFromGroupMatchers(elementMatchers, setMatchers)
                );
                cached.selector = selector;
              }
              return cached;
            }
            function select(selector, context, results, seed) {
              var i3, tokens, token, type, find2, compiled = typeof selector === "function" && selector, match = !seed && tokenize(selector = compiled.selector || selector);
              results = results || [];
              if (match.length === 1) {
                tokens = match[0] = match[0].slice(0);
                if (tokens.length > 2 && (token = tokens[0]).type === "ID" && context.nodeType === 9 && documentIsHTML && Expr.relative[tokens[1].type]) {
                  context = (Expr.find.ID(
                    token.matches[0].replace(runescape, funescape),
                    context
                  ) || [])[0];
                  if (!context) {
                    return results;
                  } else if (compiled) {
                    context = context.parentNode;
                  }
                  selector = selector.slice(tokens.shift().value.length);
                }
                i3 = matchExpr.needsContext.test(selector) ? 0 : tokens.length;
                while (i3--) {
                  token = tokens[i3];
                  if (Expr.relative[type = token.type]) {
                    break;
                  }
                  if (find2 = Expr.find[type]) {
                    if (seed = find2(
                      token.matches[0].replace(runescape, funescape),
                      rsibling.test(tokens[0].type) && testContext(context.parentNode) || context
                    )) {
                      tokens.splice(i3, 1);
                      selector = seed.length && toSelector(tokens);
                      if (!selector) {
                        push2.apply(results, seed);
                        return results;
                      }
                      break;
                    }
                  }
                }
              }
              (compiled || compile(selector, match))(
                seed,
                context,
                !documentIsHTML,
                results,
                !context || rsibling.test(selector) && testContext(context.parentNode) || context
              );
              return results;
            }
            support.sortStable = expando.split("").sort(sortOrder).join("") === expando;
            setDocument();
            support.sortDetached = assert(function(el) {
              return el.compareDocumentPosition(document3.createElement("fieldset")) & 1;
            });
            jQuery.find = find;
            jQuery.expr[":"] = jQuery.expr.pseudos;
            jQuery.unique = jQuery.uniqueSort;
            find.compile = compile;
            find.select = select;
            find.setDocument = setDocument;
            find.tokenize = tokenize;
            find.escape = jQuery.escapeSelector;
            find.getText = jQuery.text;
            find.isXML = jQuery.isXMLDoc;
            find.selectors = jQuery.expr;
            find.support = jQuery.support;
            find.uniqueSort = jQuery.uniqueSort;
          })();
          var dir = function(elem, dir2, until) {
            var matched = [], truncate = until !== void 0;
            while ((elem = elem[dir2]) && elem.nodeType !== 9) {
              if (elem.nodeType === 1) {
                if (truncate && jQuery(elem).is(until)) {
                  break;
                }
                matched.push(elem);
              }
            }
            return matched;
          };
          var siblings = function(n, elem) {
            var matched = [];
            for (; n; n = n.nextSibling) {
              if (n.nodeType === 1 && n !== elem) {
                matched.push(n);
              }
            }
            return matched;
          };
          var rneedsContext = jQuery.expr.match.needsContext;
          var rsingleTag = /^<([a-z][^\/\0>:\x20\t\r\n\f]*)[\x20\t\r\n\f]*\/?>(?:<\/\1>|)$/i;
          function winnow(elements, qualifier, not) {
            if (isFunction(qualifier)) {
              return jQuery.grep(elements, function(elem, i2) {
                return !!qualifier.call(elem, i2, elem) !== not;
              });
            }
            if (qualifier.nodeType) {
              return jQuery.grep(elements, function(elem) {
                return elem === qualifier !== not;
              });
            }
            if (typeof qualifier !== "string") {
              return jQuery.grep(elements, function(elem) {
                return indexOf.call(qualifier, elem) > -1 !== not;
              });
            }
            return jQuery.filter(qualifier, elements, not);
          }
          jQuery.filter = function(expr, elems, not) {
            var elem = elems[0];
            if (not) {
              expr = ":not(" + expr + ")";
            }
            if (elems.length === 1 && elem.nodeType === 1) {
              return jQuery.find.matchesSelector(elem, expr) ? [elem] : [];
            }
            return jQuery.find.matches(expr, jQuery.grep(elems, function(elem2) {
              return elem2.nodeType === 1;
            }));
          };
          jQuery.fn.extend({
            find: function(selector) {
              var i2, ret, len = this.length, self = this;
              if (typeof selector !== "string") {
                return this.pushStack(jQuery(selector).filter(function() {
                  for (i2 = 0; i2 < len; i2++) {
                    if (jQuery.contains(self[i2], this)) {
                      return true;
                    }
                  }
                }));
              }
              ret = this.pushStack([]);
              for (i2 = 0; i2 < len; i2++) {
                jQuery.find(selector, self[i2], ret);
              }
              return len > 1 ? jQuery.uniqueSort(ret) : ret;
            },
            filter: function(selector) {
              return this.pushStack(winnow(this, selector || [], false));
            },
            not: function(selector) {
              return this.pushStack(winnow(this, selector || [], true));
            },
            is: function(selector) {
              return !!winnow(
                this,
                // If this is a positional/relative selector, check membership in the returned set
                // so $("p:first").is("p:last") won't return true for a doc with two "p".
                typeof selector === "string" && rneedsContext.test(selector) ? jQuery(selector) : selector || [],
                false
              ).length;
            }
          });
          var rootjQuery, rquickExpr = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]+))$/, init = jQuery.fn.init = function(selector, context, root) {
            var match, elem;
            if (!selector) {
              return this;
            }
            root = root || rootjQuery;
            if (typeof selector === "string") {
              if (selector[0] === "<" && selector[selector.length - 1] === ">" && selector.length >= 3) {
                match = [null, selector, null];
              } else {
                match = rquickExpr.exec(selector);
              }
              if (match && (match[1] || !context)) {
                if (match[1]) {
                  context = context instanceof jQuery ? context[0] : context;
                  jQuery.merge(this, jQuery.parseHTML(
                    match[1],
                    context && context.nodeType ? context.ownerDocument || context : document2,
                    true
                  ));
                  if (rsingleTag.test(match[1]) && jQuery.isPlainObject(context)) {
                    for (match in context) {
                      if (isFunction(this[match])) {
                        this[match](context[match]);
                      } else {
                        this.attr(match, context[match]);
                      }
                    }
                  }
                  return this;
                } else {
                  elem = document2.getElementById(match[2]);
                  if (elem) {
                    this[0] = elem;
                    this.length = 1;
                  }
                  return this;
                }
              } else if (!context || context.jquery) {
                return (context || root).find(selector);
              } else {
                return this.constructor(context).find(selector);
              }
            } else if (selector.nodeType) {
              this[0] = selector;
              this.length = 1;
              return this;
            } else if (isFunction(selector)) {
              return root.ready !== void 0 ? root.ready(selector) : (
                // Execute immediately if ready is not present
                selector(jQuery)
              );
            }
            return jQuery.makeArray(selector, this);
          };
          init.prototype = jQuery.fn;
          rootjQuery = jQuery(document2);
          var rparentsprev = /^(?:parents|prev(?:Until|All))/, guaranteedUnique = {
            children: true,
            contents: true,
            next: true,
            prev: true
          };
          jQuery.fn.extend({
            has: function(target) {
              var targets = jQuery(target, this), l = targets.length;
              return this.filter(function() {
                var i2 = 0;
                for (; i2 < l; i2++) {
                  if (jQuery.contains(this, targets[i2])) {
                    return true;
                  }
                }
              });
            },
            closest: function(selectors, context) {
              var cur, i2 = 0, l = this.length, matched = [], targets = typeof selectors !== "string" && jQuery(selectors);
              if (!rneedsContext.test(selectors)) {
                for (; i2 < l; i2++) {
                  for (cur = this[i2]; cur && cur !== context; cur = cur.parentNode) {
                    if (cur.nodeType < 11 && (targets ? targets.index(cur) > -1 : (
                      // Don't pass non-elements to jQuery#find
                      cur.nodeType === 1 && jQuery.find.matchesSelector(cur, selectors)
                    ))) {
                      matched.push(cur);
                      break;
                    }
                  }
                }
              }
              return this.pushStack(matched.length > 1 ? jQuery.uniqueSort(matched) : matched);
            },
            // Determine the position of an element within the set
            index: function(elem) {
              if (!elem) {
                return this[0] && this[0].parentNode ? this.first().prevAll().length : -1;
              }
              if (typeof elem === "string") {
                return indexOf.call(jQuery(elem), this[0]);
              }
              return indexOf.call(
                this,
                // If it receives a jQuery object, the first element is used
                elem.jquery ? elem[0] : elem
              );
            },
            add: function(selector, context) {
              return this.pushStack(
                jQuery.uniqueSort(
                  jQuery.merge(this.get(), jQuery(selector, context))
                )
              );
            },
            addBack: function(selector) {
              return this.add(
                selector == null ? this.prevObject : this.prevObject.filter(selector)
              );
            }
          });
          function sibling(cur, dir2) {
            while ((cur = cur[dir2]) && cur.nodeType !== 1) {
            }
            return cur;
          }
          jQuery.each({
            parent: function(elem) {
              var parent = elem.parentNode;
              return parent && parent.nodeType !== 11 ? parent : null;
            },
            parents: function(elem) {
              return dir(elem, "parentNode");
            },
            parentsUntil: function(elem, _i, until) {
              return dir(elem, "parentNode", until);
            },
            next: function(elem) {
              return sibling(elem, "nextSibling");
            },
            prev: function(elem) {
              return sibling(elem, "previousSibling");
            },
            nextAll: function(elem) {
              return dir(elem, "nextSibling");
            },
            prevAll: function(elem) {
              return dir(elem, "previousSibling");
            },
            nextUntil: function(elem, _i, until) {
              return dir(elem, "nextSibling", until);
            },
            prevUntil: function(elem, _i, until) {
              return dir(elem, "previousSibling", until);
            },
            siblings: function(elem) {
              return siblings((elem.parentNode || {}).firstChild, elem);
            },
            children: function(elem) {
              return siblings(elem.firstChild);
            },
            contents: function(elem) {
              if (elem.contentDocument != null && // Support: IE 11+
              // <object> elements with no `data` attribute has an object
              // `contentDocument` with a `null` prototype.
              getProto(elem.contentDocument)) {
                return elem.contentDocument;
              }
              if (nodeName(elem, "template")) {
                elem = elem.content || elem;
              }
              return jQuery.merge([], elem.childNodes);
            }
          }, function(name, fn) {
            jQuery.fn[name] = function(until, selector) {
              var matched = jQuery.map(this, fn, until);
              if (name.slice(-5) !== "Until") {
                selector = until;
              }
              if (selector && typeof selector === "string") {
                matched = jQuery.filter(selector, matched);
              }
              if (this.length > 1) {
                if (!guaranteedUnique[name]) {
                  jQuery.uniqueSort(matched);
                }
                if (rparentsprev.test(name)) {
                  matched.reverse();
                }
              }
              return this.pushStack(matched);
            };
          });
          var rnothtmlwhite = /[^\x20\t\r\n\f]+/g;
          function createOptions(options) {
            var object = {};
            jQuery.each(options.match(rnothtmlwhite) || [], function(_, flag) {
              object[flag] = true;
            });
            return object;
          }
          jQuery.Callbacks = function(options) {
            options = typeof options === "string" ? createOptions(options) : jQuery.extend({}, options);
            var firing, memory, fired, locked, list = [], queue = [], firingIndex = -1, fire = function() {
              locked = locked || options.once;
              fired = firing = true;
              for (; queue.length; firingIndex = -1) {
                memory = queue.shift();
                while (++firingIndex < list.length) {
                  if (list[firingIndex].apply(memory[0], memory[1]) === false && options.stopOnFalse) {
                    firingIndex = list.length;
                    memory = false;
                  }
                }
              }
              if (!options.memory) {
                memory = false;
              }
              firing = false;
              if (locked) {
                if (memory) {
                  list = [];
                } else {
                  list = "";
                }
              }
            }, self = {
              // Add a callback or a collection of callbacks to the list
              add: function() {
                if (list) {
                  if (memory && !firing) {
                    firingIndex = list.length - 1;
                    queue.push(memory);
                  }
                  (function add(args) {
                    jQuery.each(args, function(_, arg) {
                      if (isFunction(arg)) {
                        if (!options.unique || !self.has(arg)) {
                          list.push(arg);
                        }
                      } else if (arg && arg.length && toType(arg) !== "string") {
                        add(arg);
                      }
                    });
                  })(arguments);
                  if (memory && !firing) {
                    fire();
                  }
                }
                return this;
              },
              // Remove a callback from the list
              remove: function() {
                jQuery.each(arguments, function(_, arg) {
                  var index;
                  while ((index = jQuery.inArray(arg, list, index)) > -1) {
                    list.splice(index, 1);
                    if (index <= firingIndex) {
                      firingIndex--;
                    }
                  }
                });
                return this;
              },
              // Check if a given callback is in the list.
              // If no argument is given, return whether or not list has callbacks attached.
              has: function(fn) {
                return fn ? jQuery.inArray(fn, list) > -1 : list.length > 0;
              },
              // Remove all callbacks from the list
              empty: function() {
                if (list) {
                  list = [];
                }
                return this;
              },
              // Disable .fire and .add
              // Abort any current/pending executions
              // Clear all callbacks and values
              disable: function() {
                locked = queue = [];
                list = memory = "";
                return this;
              },
              disabled: function() {
                return !list;
              },
              // Disable .fire
              // Also disable .add unless we have memory (since it would have no effect)
              // Abort any pending executions
              lock: function() {
                locked = queue = [];
                if (!memory && !firing) {
                  list = memory = "";
                }
                return this;
              },
              locked: function() {
                return !!locked;
              },
              // Call all callbacks with the given context and arguments
              fireWith: function(context, args) {
                if (!locked) {
                  args = args || [];
                  args = [context, args.slice ? args.slice() : args];
                  queue.push(args);
                  if (!firing) {
                    fire();
                  }
                }
                return this;
              },
              // Call all the callbacks with the given arguments
              fire: function() {
                self.fireWith(this, arguments);
                return this;
              },
              // To know if the callbacks have already been called at least once
              fired: function() {
                return !!fired;
              }
            };
            return self;
          };
          function Identity(v) {
            return v;
          }
          function Thrower(ex) {
            throw ex;
          }
          function adoptValue(value, resolve, reject, noValue) {
            var method;
            try {
              if (value && isFunction(method = value.promise)) {
                method.call(value).done(resolve).fail(reject);
              } else if (value && isFunction(method = value.then)) {
                method.call(value, resolve, reject);
              } else {
                resolve.apply(void 0, [value].slice(noValue));
              }
            } catch (value2) {
              reject.apply(void 0, [value2]);
            }
          }
          jQuery.extend({
            Deferred: function(func) {
              var tuples = [
                // action, add listener, callbacks,
                // ... .then handlers, argument index, [final state]
                [
                  "notify",
                  "progress",
                  jQuery.Callbacks("memory"),
                  jQuery.Callbacks("memory"),
                  2
                ],
                [
                  "resolve",
                  "done",
                  jQuery.Callbacks("once memory"),
                  jQuery.Callbacks("once memory"),
                  0,
                  "resolved"
                ],
                [
                  "reject",
                  "fail",
                  jQuery.Callbacks("once memory"),
                  jQuery.Callbacks("once memory"),
                  1,
                  "rejected"
                ]
              ], state = "pending", promise = {
                state: function() {
                  return state;
                },
                always: function() {
                  deferred.done(arguments).fail(arguments);
                  return this;
                },
                "catch": function(fn) {
                  return promise.then(null, fn);
                },
                // Keep pipe for back-compat
                pipe: function() {
                  var fns = arguments;
                  return jQuery.Deferred(function(newDefer) {
                    jQuery.each(tuples, function(_i, tuple) {
                      var fn = isFunction(fns[tuple[4]]) && fns[tuple[4]];
                      deferred[tuple[1]](function() {
                        var returned = fn && fn.apply(this, arguments);
                        if (returned && isFunction(returned.promise)) {
                          returned.promise().progress(newDefer.notify).done(newDefer.resolve).fail(newDefer.reject);
                        } else {
                          newDefer[tuple[0] + "With"](
                            this,
                            fn ? [returned] : arguments
                          );
                        }
                      });
                    });
                    fns = null;
                  }).promise();
                },
                then: function(onFulfilled, onRejected, onProgress) {
                  var maxDepth = 0;
                  function resolve(depth, deferred2, handler, special) {
                    return function() {
                      var that = this, args = arguments, mightThrow = function() {
                        var returned, then;
                        if (depth < maxDepth) {
                          return;
                        }
                        returned = handler.apply(that, args);
                        if (returned === deferred2.promise()) {
                          throw new TypeError("Thenable self-resolution");
                        }
                        then = returned && // Support: Promises/A+ section 2.3.4
                        // https://promisesaplus.com/#point-64
                        // Only check objects and functions for thenability
                        (typeof returned === "object" || typeof returned === "function") && returned.then;
                        if (isFunction(then)) {
                          if (special) {
                            then.call(
                              returned,
                              resolve(maxDepth, deferred2, Identity, special),
                              resolve(maxDepth, deferred2, Thrower, special)
                            );
                          } else {
                            maxDepth++;
                            then.call(
                              returned,
                              resolve(maxDepth, deferred2, Identity, special),
                              resolve(maxDepth, deferred2, Thrower, special),
                              resolve(
                                maxDepth,
                                deferred2,
                                Identity,
                                deferred2.notifyWith
                              )
                            );
                          }
                        } else {
                          if (handler !== Identity) {
                            that = void 0;
                            args = [returned];
                          }
                          (special || deferred2.resolveWith)(that, args);
                        }
                      }, process = special ? mightThrow : function() {
                        try {
                          mightThrow();
                        } catch (e) {
                          if (jQuery.Deferred.exceptionHook) {
                            jQuery.Deferred.exceptionHook(
                              e,
                              process.error
                            );
                          }
                          if (depth + 1 >= maxDepth) {
                            if (handler !== Thrower) {
                              that = void 0;
                              args = [e];
                            }
                            deferred2.rejectWith(that, args);
                          }
                        }
                      };
                      if (depth) {
                        process();
                      } else {
                        if (jQuery.Deferred.getErrorHook) {
                          process.error = jQuery.Deferred.getErrorHook();
                        } else if (jQuery.Deferred.getStackHook) {
                          process.error = jQuery.Deferred.getStackHook();
                        }
                        window2.setTimeout(process);
                      }
                    };
                  }
                  return jQuery.Deferred(function(newDefer) {
                    tuples[0][3].add(
                      resolve(
                        0,
                        newDefer,
                        isFunction(onProgress) ? onProgress : Identity,
                        newDefer.notifyWith
                      )
                    );
                    tuples[1][3].add(
                      resolve(
                        0,
                        newDefer,
                        isFunction(onFulfilled) ? onFulfilled : Identity
                      )
                    );
                    tuples[2][3].add(
                      resolve(
                        0,
                        newDefer,
                        isFunction(onRejected) ? onRejected : Thrower
                      )
                    );
                  }).promise();
                },
                // Get a promise for this deferred
                // If obj is provided, the promise aspect is added to the object
                promise: function(obj) {
                  return obj != null ? jQuery.extend(obj, promise) : promise;
                }
              }, deferred = {};
              jQuery.each(tuples, function(i2, tuple) {
                var list = tuple[2], stateString = tuple[5];
                promise[tuple[1]] = list.add;
                if (stateString) {
                  list.add(
                    function() {
                      state = stateString;
                    },
                    // rejected_callbacks.disable
                    // fulfilled_callbacks.disable
                    tuples[3 - i2][2].disable,
                    // rejected_handlers.disable
                    // fulfilled_handlers.disable
                    tuples[3 - i2][3].disable,
                    // progress_callbacks.lock
                    tuples[0][2].lock,
                    // progress_handlers.lock
                    tuples[0][3].lock
                  );
                }
                list.add(tuple[3].fire);
                deferred[tuple[0]] = function() {
                  deferred[tuple[0] + "With"](this === deferred ? void 0 : this, arguments);
                  return this;
                };
                deferred[tuple[0] + "With"] = list.fireWith;
              });
              promise.promise(deferred);
              if (func) {
                func.call(deferred, deferred);
              }
              return deferred;
            },
            // Deferred helper
            when: function(singleValue) {
              var remaining = arguments.length, i2 = remaining, resolveContexts = Array(i2), resolveValues = slice.call(arguments), primary = jQuery.Deferred(), updateFunc = function(i3) {
                return function(value) {
                  resolveContexts[i3] = this;
                  resolveValues[i3] = arguments.length > 1 ? slice.call(arguments) : value;
                  if (!--remaining) {
                    primary.resolveWith(resolveContexts, resolveValues);
                  }
                };
              };
              if (remaining <= 1) {
                adoptValue(
                  singleValue,
                  primary.done(updateFunc(i2)).resolve,
                  primary.reject,
                  !remaining
                );
                if (primary.state() === "pending" || isFunction(resolveValues[i2] && resolveValues[i2].then)) {
                  return primary.then();
                }
              }
              while (i2--) {
                adoptValue(resolveValues[i2], updateFunc(i2), primary.reject);
              }
              return primary.promise();
            }
          });
          var rerrorNames = /^(Eval|Internal|Range|Reference|Syntax|Type|URI)Error$/;
          jQuery.Deferred.exceptionHook = function(error, asyncError) {
            if (window2.console && window2.console.warn && error && rerrorNames.test(error.name)) {
              window2.console.warn(
                "jQuery.Deferred exception: " + error.message,
                error.stack,
                asyncError
              );
            }
          };
          jQuery.readyException = function(error) {
            window2.setTimeout(function() {
              throw error;
            });
          };
          var readyList = jQuery.Deferred();
          jQuery.fn.ready = function(fn) {
            readyList.then(fn).catch(function(error) {
              jQuery.readyException(error);
            });
            return this;
          };
          jQuery.extend({
            // Is the DOM ready to be used? Set to true once it occurs.
            isReady: false,
            // A counter to track how many items to wait for before
            // the ready event fires. See trac-6781
            readyWait: 1,
            // Handle when the DOM is ready
            ready: function(wait) {
              if (wait === true ? --jQuery.readyWait : jQuery.isReady) {
                return;
              }
              jQuery.isReady = true;
              if (wait !== true && --jQuery.readyWait > 0) {
                return;
              }
              readyList.resolveWith(document2, [jQuery]);
            }
          });
          jQuery.ready.then = readyList.then;
          function completed() {
            document2.removeEventListener("DOMContentLoaded", completed);
            window2.removeEventListener("load", completed);
            jQuery.ready();
          }
          if (document2.readyState === "complete" || document2.readyState !== "loading" && !document2.documentElement.doScroll) {
            window2.setTimeout(jQuery.ready);
          } else {
            document2.addEventListener("DOMContentLoaded", completed);
            window2.addEventListener("load", completed);
          }
          var access = function(elems, fn, key2, value, chainable, emptyGet, raw) {
            var i2 = 0, len = elems.length, bulk = key2 == null;
            if (toType(key2) === "object") {
              chainable = true;
              for (i2 in key2) {
                access(elems, fn, i2, key2[i2], true, emptyGet, raw);
              }
            } else if (value !== void 0) {
              chainable = true;
              if (!isFunction(value)) {
                raw = true;
              }
              if (bulk) {
                if (raw) {
                  fn.call(elems, value);
                  fn = null;
                } else {
                  bulk = fn;
                  fn = function(elem, _key, value2) {
                    return bulk.call(jQuery(elem), value2);
                  };
                }
              }
              if (fn) {
                for (; i2 < len; i2++) {
                  fn(
                    elems[i2],
                    key2,
                    raw ? value : value.call(elems[i2], i2, fn(elems[i2], key2))
                  );
                }
              }
            }
            if (chainable) {
              return elems;
            }
            if (bulk) {
              return fn.call(elems);
            }
            return len ? fn(elems[0], key2) : emptyGet;
          };
          var rmsPrefix = /^-ms-/, rdashAlpha = /-([a-z])/g;
          function fcamelCase(_all, letter) {
            return letter.toUpperCase();
          }
          function camelCase(string) {
            return string.replace(rmsPrefix, "ms-").replace(rdashAlpha, fcamelCase);
          }
          var acceptData = function(owner) {
            return owner.nodeType === 1 || owner.nodeType === 9 || !+owner.nodeType;
          };
          function Data() {
            this.expando = jQuery.expando + Data.uid++;
          }
          Data.uid = 1;
          Data.prototype = {
            cache: function(owner) {
              var value = owner[this.expando];
              if (!value) {
                value = {};
                if (acceptData(owner)) {
                  if (owner.nodeType) {
                    owner[this.expando] = value;
                  } else {
                    Object.defineProperty(owner, this.expando, {
                      value,
                      configurable: true
                    });
                  }
                }
              }
              return value;
            },
            set: function(owner, data, value) {
              var prop, cache = this.cache(owner);
              if (typeof data === "string") {
                cache[camelCase(data)] = value;
              } else {
                for (prop in data) {
                  cache[camelCase(prop)] = data[prop];
                }
              }
              return cache;
            },
            get: function(owner, key2) {
              return key2 === void 0 ? this.cache(owner) : (
                // Always use camelCase key (gh-2257)
                owner[this.expando] && owner[this.expando][camelCase(key2)]
              );
            },
            access: function(owner, key2, value) {
              if (key2 === void 0 || key2 && typeof key2 === "string" && value === void 0) {
                return this.get(owner, key2);
              }
              this.set(owner, key2, value);
              return value !== void 0 ? value : key2;
            },
            remove: function(owner, key2) {
              var i2, cache = owner[this.expando];
              if (cache === void 0) {
                return;
              }
              if (key2 !== void 0) {
                if (Array.isArray(key2)) {
                  key2 = key2.map(camelCase);
                } else {
                  key2 = camelCase(key2);
                  key2 = key2 in cache ? [key2] : key2.match(rnothtmlwhite) || [];
                }
                i2 = key2.length;
                while (i2--) {
                  delete cache[key2[i2]];
                }
              }
              if (key2 === void 0 || jQuery.isEmptyObject(cache)) {
                if (owner.nodeType) {
                  owner[this.expando] = void 0;
                } else {
                  delete owner[this.expando];
                }
              }
            },
            hasData: function(owner) {
              var cache = owner[this.expando];
              return cache !== void 0 && !jQuery.isEmptyObject(cache);
            }
          };
          var dataPriv = new Data();
          var dataUser = new Data();
          var rbrace = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/, rmultiDash = /[A-Z]/g;
          function getData(data) {
            if (data === "true") {
              return true;
            }
            if (data === "false") {
              return false;
            }
            if (data === "null") {
              return null;
            }
            if (data === +data + "") {
              return +data;
            }
            if (rbrace.test(data)) {
              return JSON.parse(data);
            }
            return data;
          }
          function dataAttr(elem, key2, data) {
            var name;
            if (data === void 0 && elem.nodeType === 1) {
              name = "data-" + key2.replace(rmultiDash, "-$&").toLowerCase();
              data = elem.getAttribute(name);
              if (typeof data === "string") {
                try {
                  data = getData(data);
                } catch (e) {
                }
                dataUser.set(elem, key2, data);
              } else {
                data = void 0;
              }
            }
            return data;
          }
          jQuery.extend({
            hasData: function(elem) {
              return dataUser.hasData(elem) || dataPriv.hasData(elem);
            },
            data: function(elem, name, data) {
              return dataUser.access(elem, name, data);
            },
            removeData: function(elem, name) {
              dataUser.remove(elem, name);
            },
            // TODO: Now that all calls to _data and _removeData have been replaced
            // with direct calls to dataPriv methods, these can be deprecated.
            _data: function(elem, name, data) {
              return dataPriv.access(elem, name, data);
            },
            _removeData: function(elem, name) {
              dataPriv.remove(elem, name);
            }
          });
          jQuery.fn.extend({
            data: function(key2, value) {
              var i2, name, data, elem = this[0], attrs = elem && elem.attributes;
              if (key2 === void 0) {
                if (this.length) {
                  data = dataUser.get(elem);
                  if (elem.nodeType === 1 && !dataPriv.get(elem, "hasDataAttrs")) {
                    i2 = attrs.length;
                    while (i2--) {
                      if (attrs[i2]) {
                        name = attrs[i2].name;
                        if (name.indexOf("data-") === 0) {
                          name = camelCase(name.slice(5));
                          dataAttr(elem, name, data[name]);
                        }
                      }
                    }
                    dataPriv.set(elem, "hasDataAttrs", true);
                  }
                }
                return data;
              }
              if (typeof key2 === "object") {
                return this.each(function() {
                  dataUser.set(this, key2);
                });
              }
              return access(this, function(value2) {
                var data2;
                if (elem && value2 === void 0) {
                  data2 = dataUser.get(elem, key2);
                  if (data2 !== void 0) {
                    return data2;
                  }
                  data2 = dataAttr(elem, key2);
                  if (data2 !== void 0) {
                    return data2;
                  }
                  return;
                }
                this.each(function() {
                  dataUser.set(this, key2, value2);
                });
              }, null, value, arguments.length > 1, null, true);
            },
            removeData: function(key2) {
              return this.each(function() {
                dataUser.remove(this, key2);
              });
            }
          });
          jQuery.extend({
            queue: function(elem, type, data) {
              var queue;
              if (elem) {
                type = (type || "fx") + "queue";
                queue = dataPriv.get(elem, type);
                if (data) {
                  if (!queue || Array.isArray(data)) {
                    queue = dataPriv.access(elem, type, jQuery.makeArray(data));
                  } else {
                    queue.push(data);
                  }
                }
                return queue || [];
              }
            },
            dequeue: function(elem, type) {
              type = type || "fx";
              var queue = jQuery.queue(elem, type), startLength = queue.length, fn = queue.shift(), hooks = jQuery._queueHooks(elem, type), next = function() {
                jQuery.dequeue(elem, type);
              };
              if (fn === "inprogress") {
                fn = queue.shift();
                startLength--;
              }
              if (fn) {
                if (type === "fx") {
                  queue.unshift("inprogress");
                }
                delete hooks.stop;
                fn.call(elem, next, hooks);
              }
              if (!startLength && hooks) {
                hooks.empty.fire();
              }
            },
            // Not public - generate a queueHooks object, or return the current one
            _queueHooks: function(elem, type) {
              var key2 = type + "queueHooks";
              return dataPriv.get(elem, key2) || dataPriv.access(elem, key2, {
                empty: jQuery.Callbacks("once memory").add(function() {
                  dataPriv.remove(elem, [type + "queue", key2]);
                })
              });
            }
          });
          jQuery.fn.extend({
            queue: function(type, data) {
              var setter = 2;
              if (typeof type !== "string") {
                data = type;
                type = "fx";
                setter--;
              }
              if (arguments.length < setter) {
                return jQuery.queue(this[0], type);
              }
              return data === void 0 ? this : this.each(function() {
                var queue = jQuery.queue(this, type, data);
                jQuery._queueHooks(this, type);
                if (type === "fx" && queue[0] !== "inprogress") {
                  jQuery.dequeue(this, type);
                }
              });
            },
            dequeue: function(type) {
              return this.each(function() {
                jQuery.dequeue(this, type);
              });
            },
            clearQueue: function(type) {
              return this.queue(type || "fx", []);
            },
            // Get a promise resolved when queues of a certain type
            // are emptied (fx is the type by default)
            promise: function(type, obj) {
              var tmp, count = 1, defer = jQuery.Deferred(), elements = this, i2 = this.length, resolve = function() {
                if (!--count) {
                  defer.resolveWith(elements, [elements]);
                }
              };
              if (typeof type !== "string") {
                obj = type;
                type = void 0;
              }
              type = type || "fx";
              while (i2--) {
                tmp = dataPriv.get(elements[i2], type + "queueHooks");
                if (tmp && tmp.empty) {
                  count++;
                  tmp.empty.add(resolve);
                }
              }
              resolve();
              return defer.promise(obj);
            }
          });
          var pnum = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source;
          var rcssNum = new RegExp("^(?:([+-])=|)(" + pnum + ")([a-z%]*)$", "i");
          var cssExpand = ["Top", "Right", "Bottom", "Left"];
          var documentElement = document2.documentElement;
          var isAttached = function(elem) {
            return jQuery.contains(elem.ownerDocument, elem);
          }, composed = { composed: true };
          if (documentElement.getRootNode) {
            isAttached = function(elem) {
              return jQuery.contains(elem.ownerDocument, elem) || elem.getRootNode(composed) === elem.ownerDocument;
            };
          }
          var isHiddenWithinTree = function(elem, el) {
            elem = el || elem;
            return elem.style.display === "none" || elem.style.display === "" && // Otherwise, check computed style
            // Support: Firefox <=43 - 45
            // Disconnected elements can have computed display: none, so first confirm that elem is
            // in the document.
            isAttached(elem) && jQuery.css(elem, "display") === "none";
          };
          function adjustCSS(elem, prop, valueParts, tween) {
            var adjusted, scale, maxIterations = 20, currentValue = tween ? function() {
              return tween.cur();
            } : function() {
              return jQuery.css(elem, prop, "");
            }, initial = currentValue(), unit = valueParts && valueParts[3] || (jQuery.cssNumber[prop] ? "" : "px"), initialInUnit = elem.nodeType && (jQuery.cssNumber[prop] || unit !== "px" && +initial) && rcssNum.exec(jQuery.css(elem, prop));
            if (initialInUnit && initialInUnit[3] !== unit) {
              initial = initial / 2;
              unit = unit || initialInUnit[3];
              initialInUnit = +initial || 1;
              while (maxIterations--) {
                jQuery.style(elem, prop, initialInUnit + unit);
                if ((1 - scale) * (1 - (scale = currentValue() / initial || 0.5)) <= 0) {
                  maxIterations = 0;
                }
                initialInUnit = initialInUnit / scale;
              }
              initialInUnit = initialInUnit * 2;
              jQuery.style(elem, prop, initialInUnit + unit);
              valueParts = valueParts || [];
            }
            if (valueParts) {
              initialInUnit = +initialInUnit || +initial || 0;
              adjusted = valueParts[1] ? initialInUnit + (valueParts[1] + 1) * valueParts[2] : +valueParts[2];
              if (tween) {
                tween.unit = unit;
                tween.start = initialInUnit;
                tween.end = adjusted;
              }
            }
            return adjusted;
          }
          var defaultDisplayMap = {};
          function getDefaultDisplay(elem) {
            var temp, doc = elem.ownerDocument, nodeName2 = elem.nodeName, display = defaultDisplayMap[nodeName2];
            if (display) {
              return display;
            }
            temp = doc.body.appendChild(doc.createElement(nodeName2));
            display = jQuery.css(temp, "display");
            temp.parentNode.removeChild(temp);
            if (display === "none") {
              display = "block";
            }
            defaultDisplayMap[nodeName2] = display;
            return display;
          }
          function showHide(elements, show) {
            var display, elem, values = [], index = 0, length = elements.length;
            for (; index < length; index++) {
              elem = elements[index];
              if (!elem.style) {
                continue;
              }
              display = elem.style.display;
              if (show) {
                if (display === "none") {
                  values[index] = dataPriv.get(elem, "display") || null;
                  if (!values[index]) {
                    elem.style.display = "";
                  }
                }
                if (elem.style.display === "" && isHiddenWithinTree(elem)) {
                  values[index] = getDefaultDisplay(elem);
                }
              } else {
                if (display !== "none") {
                  values[index] = "none";
                  dataPriv.set(elem, "display", display);
                }
              }
            }
            for (index = 0; index < length; index++) {
              if (values[index] != null) {
                elements[index].style.display = values[index];
              }
            }
            return elements;
          }
          jQuery.fn.extend({
            show: function() {
              return showHide(this, true);
            },
            hide: function() {
              return showHide(this);
            },
            toggle: function(state) {
              if (typeof state === "boolean") {
                return state ? this.show() : this.hide();
              }
              return this.each(function() {
                if (isHiddenWithinTree(this)) {
                  jQuery(this).show();
                } else {
                  jQuery(this).hide();
                }
              });
            }
          });
          var rcheckableType = /^(?:checkbox|radio)$/i;
          var rtagName = /<([a-z][^\/\0>\x20\t\r\n\f]*)/i;
          var rscriptType = /^$|^module$|\/(?:java|ecma)script/i;
          (function() {
            var fragment = document2.createDocumentFragment(), div = fragment.appendChild(document2.createElement("div")), input = document2.createElement("input");
            input.setAttribute("type", "radio");
            input.setAttribute("checked", "checked");
            input.setAttribute("name", "t");
            div.appendChild(input);
            support.checkClone = div.cloneNode(true).cloneNode(true).lastChild.checked;
            div.innerHTML = "<textarea>x</textarea>";
            support.noCloneChecked = !!div.cloneNode(true).lastChild.defaultValue;
            div.innerHTML = "<option></option>";
            support.option = !!div.lastChild;
          })();
          var wrapMap = {
            // XHTML parsers do not magically insert elements in the
            // same way that tag soup parsers do. So we cannot shorten
            // this by omitting <tbody> or other required elements.
            thead: [1, "<table>", "</table>"],
            col: [2, "<table><colgroup>", "</colgroup></table>"],
            tr: [2, "<table><tbody>", "</tbody></table>"],
            td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
            _default: [0, "", ""]
          };
          wrapMap.tbody = wrapMap.tfoot = wrapMap.colgroup = wrapMap.caption = wrapMap.thead;
          wrapMap.th = wrapMap.td;
          if (!support.option) {
            wrapMap.optgroup = wrapMap.option = [1, "<select multiple='multiple'>", "</select>"];
          }
          function getAll(context, tag) {
            var ret;
            if (typeof context.getElementsByTagName !== "undefined") {
              ret = context.getElementsByTagName(tag || "*");
            } else if (typeof context.querySelectorAll !== "undefined") {
              ret = context.querySelectorAll(tag || "*");
            } else {
              ret = [];
            }
            if (tag === void 0 || tag && nodeName(context, tag)) {
              return jQuery.merge([context], ret);
            }
            return ret;
          }
          function setGlobalEval(elems, refElements) {
            var i2 = 0, l = elems.length;
            for (; i2 < l; i2++) {
              dataPriv.set(
                elems[i2],
                "globalEval",
                !refElements || dataPriv.get(refElements[i2], "globalEval")
              );
            }
          }
          var rhtml = /<|&#?\w+;/;
          function buildFragment(elems, context, scripts, selection, ignored) {
            var elem, tmp, tag, wrap, attached, j, fragment = context.createDocumentFragment(), nodes = [], i2 = 0, l = elems.length;
            for (; i2 < l; i2++) {
              elem = elems[i2];
              if (elem || elem === 0) {
                if (toType(elem) === "object") {
                  jQuery.merge(nodes, elem.nodeType ? [elem] : elem);
                } else if (!rhtml.test(elem)) {
                  nodes.push(context.createTextNode(elem));
                } else {
                  tmp = tmp || fragment.appendChild(context.createElement("div"));
                  tag = (rtagName.exec(elem) || ["", ""])[1].toLowerCase();
                  wrap = wrapMap[tag] || wrapMap._default;
                  tmp.innerHTML = wrap[1] + jQuery.htmlPrefilter(elem) + wrap[2];
                  j = wrap[0];
                  while (j--) {
                    tmp = tmp.lastChild;
                  }
                  jQuery.merge(nodes, tmp.childNodes);
                  tmp = fragment.firstChild;
                  tmp.textContent = "";
                }
              }
            }
            fragment.textContent = "";
            i2 = 0;
            while (elem = nodes[i2++]) {
              if (selection && jQuery.inArray(elem, selection) > -1) {
                if (ignored) {
                  ignored.push(elem);
                }
                continue;
              }
              attached = isAttached(elem);
              tmp = getAll(fragment.appendChild(elem), "script");
              if (attached) {
                setGlobalEval(tmp);
              }
              if (scripts) {
                j = 0;
                while (elem = tmp[j++]) {
                  if (rscriptType.test(elem.type || "")) {
                    scripts.push(elem);
                  }
                }
              }
            }
            return fragment;
          }
          var rtypenamespace = /^([^.]*)(?:\.(.+)|)/;
          function returnTrue() {
            return true;
          }
          function returnFalse() {
            return false;
          }
          function on(elem, types, selector, data, fn, one) {
            var origFn, type;
            if (typeof types === "object") {
              if (typeof selector !== "string") {
                data = data || selector;
                selector = void 0;
              }
              for (type in types) {
                on(elem, type, selector, data, types[type], one);
              }
              return elem;
            }
            if (data == null && fn == null) {
              fn = selector;
              data = selector = void 0;
            } else if (fn == null) {
              if (typeof selector === "string") {
                fn = data;
                data = void 0;
              } else {
                fn = data;
                data = selector;
                selector = void 0;
              }
            }
            if (fn === false) {
              fn = returnFalse;
            } else if (!fn) {
              return elem;
            }
            if (one === 1) {
              origFn = fn;
              fn = function(event) {
                jQuery().off(event);
                return origFn.apply(this, arguments);
              };
              fn.guid = origFn.guid || (origFn.guid = jQuery.guid++);
            }
            return elem.each(function() {
              jQuery.event.add(this, types, fn, data, selector);
            });
          }
          jQuery.event = {
            global: {},
            add: function(elem, types, handler, data, selector) {
              var handleObjIn, eventHandle, tmp, events, t, handleObj, special, handlers, type, namespaces, origType, elemData = dataPriv.get(elem);
              if (!acceptData(elem)) {
                return;
              }
              if (handler.handler) {
                handleObjIn = handler;
                handler = handleObjIn.handler;
                selector = handleObjIn.selector;
              }
              if (selector) {
                jQuery.find.matchesSelector(documentElement, selector);
              }
              if (!handler.guid) {
                handler.guid = jQuery.guid++;
              }
              if (!(events = elemData.events)) {
                events = elemData.events = /* @__PURE__ */ Object.create(null);
              }
              if (!(eventHandle = elemData.handle)) {
                eventHandle = elemData.handle = function(e) {
                  return typeof jQuery !== "undefined" && jQuery.event.triggered !== e.type ? jQuery.event.dispatch.apply(elem, arguments) : void 0;
                };
              }
              types = (types || "").match(rnothtmlwhite) || [""];
              t = types.length;
              while (t--) {
                tmp = rtypenamespace.exec(types[t]) || [];
                type = origType = tmp[1];
                namespaces = (tmp[2] || "").split(".").sort();
                if (!type) {
                  continue;
                }
                special = jQuery.event.special[type] || {};
                type = (selector ? special.delegateType : special.bindType) || type;
                special = jQuery.event.special[type] || {};
                handleObj = jQuery.extend({
                  type,
                  origType,
                  data,
                  handler,
                  guid: handler.guid,
                  selector,
                  needsContext: selector && jQuery.expr.match.needsContext.test(selector),
                  namespace: namespaces.join(".")
                }, handleObjIn);
                if (!(handlers = events[type])) {
                  handlers = events[type] = [];
                  handlers.delegateCount = 0;
                  if (!special.setup || special.setup.call(elem, data, namespaces, eventHandle) === false) {
                    if (elem.addEventListener) {
                      elem.addEventListener(type, eventHandle);
                    }
                  }
                }
                if (special.add) {
                  special.add.call(elem, handleObj);
                  if (!handleObj.handler.guid) {
                    handleObj.handler.guid = handler.guid;
                  }
                }
                if (selector) {
                  handlers.splice(handlers.delegateCount++, 0, handleObj);
                } else {
                  handlers.push(handleObj);
                }
                jQuery.event.global[type] = true;
              }
            },
            // Detach an event or set of events from an element
            remove: function(elem, types, handler, selector, mappedTypes) {
              var j, origCount, tmp, events, t, handleObj, special, handlers, type, namespaces, origType, elemData = dataPriv.hasData(elem) && dataPriv.get(elem);
              if (!elemData || !(events = elemData.events)) {
                return;
              }
              types = (types || "").match(rnothtmlwhite) || [""];
              t = types.length;
              while (t--) {
                tmp = rtypenamespace.exec(types[t]) || [];
                type = origType = tmp[1];
                namespaces = (tmp[2] || "").split(".").sort();
                if (!type) {
                  for (type in events) {
                    jQuery.event.remove(elem, type + types[t], handler, selector, true);
                  }
                  continue;
                }
                special = jQuery.event.special[type] || {};
                type = (selector ? special.delegateType : special.bindType) || type;
                handlers = events[type] || [];
                tmp = tmp[2] && new RegExp("(^|\\.)" + namespaces.join("\\.(?:.*\\.|)") + "(\\.|$)");
                origCount = j = handlers.length;
                while (j--) {
                  handleObj = handlers[j];
                  if ((mappedTypes || origType === handleObj.origType) && (!handler || handler.guid === handleObj.guid) && (!tmp || tmp.test(handleObj.namespace)) && (!selector || selector === handleObj.selector || selector === "**" && handleObj.selector)) {
                    handlers.splice(j, 1);
                    if (handleObj.selector) {
                      handlers.delegateCount--;
                    }
                    if (special.remove) {
                      special.remove.call(elem, handleObj);
                    }
                  }
                }
                if (origCount && !handlers.length) {
                  if (!special.teardown || special.teardown.call(elem, namespaces, elemData.handle) === false) {
                    jQuery.removeEvent(elem, type, elemData.handle);
                  }
                  delete events[type];
                }
              }
              if (jQuery.isEmptyObject(events)) {
                dataPriv.remove(elem, "handle events");
              }
            },
            dispatch: function(nativeEvent) {
              var i2, j, ret, matched, handleObj, handlerQueue, args = new Array(arguments.length), event = jQuery.event.fix(nativeEvent), handlers = (dataPriv.get(this, "events") || /* @__PURE__ */ Object.create(null))[event.type] || [], special = jQuery.event.special[event.type] || {};
              args[0] = event;
              for (i2 = 1; i2 < arguments.length; i2++) {
                args[i2] = arguments[i2];
              }
              event.delegateTarget = this;
              if (special.preDispatch && special.preDispatch.call(this, event) === false) {
                return;
              }
              handlerQueue = jQuery.event.handlers.call(this, event, handlers);
              i2 = 0;
              while ((matched = handlerQueue[i2++]) && !event.isPropagationStopped()) {
                event.currentTarget = matched.elem;
                j = 0;
                while ((handleObj = matched.handlers[j++]) && !event.isImmediatePropagationStopped()) {
                  if (!event.rnamespace || handleObj.namespace === false || event.rnamespace.test(handleObj.namespace)) {
                    event.handleObj = handleObj;
                    event.data = handleObj.data;
                    ret = ((jQuery.event.special[handleObj.origType] || {}).handle || handleObj.handler).apply(matched.elem, args);
                    if (ret !== void 0) {
                      if ((event.result = ret) === false) {
                        event.preventDefault();
                        event.stopPropagation();
                      }
                    }
                  }
                }
              }
              if (special.postDispatch) {
                special.postDispatch.call(this, event);
              }
              return event.result;
            },
            handlers: function(event, handlers) {
              var i2, handleObj, sel, matchedHandlers, matchedSelectors, handlerQueue = [], delegateCount = handlers.delegateCount, cur = event.target;
              if (delegateCount && // Support: IE <=9
              // Black-hole SVG <use> instance trees (trac-13180)
              cur.nodeType && // Support: Firefox <=42
              // Suppress spec-violating clicks indicating a non-primary pointer button (trac-3861)
              // https://www.w3.org/TR/DOM-Level-3-Events/#event-type-click
              // Support: IE 11 only
              // ...but not arrow key "clicks" of radio inputs, which can have `button` -1 (gh-2343)
              !(event.type === "click" && event.button >= 1)) {
                for (; cur !== this; cur = cur.parentNode || this) {
                  if (cur.nodeType === 1 && !(event.type === "click" && cur.disabled === true)) {
                    matchedHandlers = [];
                    matchedSelectors = {};
                    for (i2 = 0; i2 < delegateCount; i2++) {
                      handleObj = handlers[i2];
                      sel = handleObj.selector + " ";
                      if (matchedSelectors[sel] === void 0) {
                        matchedSelectors[sel] = handleObj.needsContext ? jQuery(sel, this).index(cur) > -1 : jQuery.find(sel, this, null, [cur]).length;
                      }
                      if (matchedSelectors[sel]) {
                        matchedHandlers.push(handleObj);
                      }
                    }
                    if (matchedHandlers.length) {
                      handlerQueue.push({ elem: cur, handlers: matchedHandlers });
                    }
                  }
                }
              }
              cur = this;
              if (delegateCount < handlers.length) {
                handlerQueue.push({ elem: cur, handlers: handlers.slice(delegateCount) });
              }
              return handlerQueue;
            },
            addProp: function(name, hook) {
              Object.defineProperty(jQuery.Event.prototype, name, {
                enumerable: true,
                configurable: true,
                get: isFunction(hook) ? function() {
                  if (this.originalEvent) {
                    return hook(this.originalEvent);
                  }
                } : function() {
                  if (this.originalEvent) {
                    return this.originalEvent[name];
                  }
                },
                set: function(value) {
                  Object.defineProperty(this, name, {
                    enumerable: true,
                    configurable: true,
                    writable: true,
                    value
                  });
                }
              });
            },
            fix: function(originalEvent) {
              return originalEvent[jQuery.expando] ? originalEvent : new jQuery.Event(originalEvent);
            },
            special: {
              load: {
                // Prevent triggered image.load events from bubbling to window.load
                noBubble: true
              },
              click: {
                // Utilize native event to ensure correct state for checkable inputs
                setup: function(data) {
                  var el = this || data;
                  if (rcheckableType.test(el.type) && el.click && nodeName(el, "input")) {
                    leverageNative(el, "click", true);
                  }
                  return false;
                },
                trigger: function(data) {
                  var el = this || data;
                  if (rcheckableType.test(el.type) && el.click && nodeName(el, "input")) {
                    leverageNative(el, "click");
                  }
                  return true;
                },
                // For cross-browser consistency, suppress native .click() on links
                // Also prevent it if we're currently inside a leveraged native-event stack
                _default: function(event) {
                  var target = event.target;
                  return rcheckableType.test(target.type) && target.click && nodeName(target, "input") && dataPriv.get(target, "click") || nodeName(target, "a");
                }
              },
              beforeunload: {
                postDispatch: function(event) {
                  if (event.result !== void 0 && event.originalEvent) {
                    event.originalEvent.returnValue = event.result;
                  }
                }
              }
            }
          };
          function leverageNative(el, type, isSetup) {
            if (!isSetup) {
              if (dataPriv.get(el, type) === void 0) {
                jQuery.event.add(el, type, returnTrue);
              }
              return;
            }
            dataPriv.set(el, type, false);
            jQuery.event.add(el, type, {
              namespace: false,
              handler: function(event) {
                var result, saved = dataPriv.get(this, type);
                if (event.isTrigger & 1 && this[type]) {
                  if (!saved) {
                    saved = slice.call(arguments);
                    dataPriv.set(this, type, saved);
                    this[type]();
                    result = dataPriv.get(this, type);
                    dataPriv.set(this, type, false);
                    if (saved !== result) {
                      event.stopImmediatePropagation();
                      event.preventDefault();
                      return result;
                    }
                  } else if ((jQuery.event.special[type] || {}).delegateType) {
                    event.stopPropagation();
                  }
                } else if (saved) {
                  dataPriv.set(this, type, jQuery.event.trigger(
                    saved[0],
                    saved.slice(1),
                    this
                  ));
                  event.stopPropagation();
                  event.isImmediatePropagationStopped = returnTrue;
                }
              }
            });
          }
          jQuery.removeEvent = function(elem, type, handle) {
            if (elem.removeEventListener) {
              elem.removeEventListener(type, handle);
            }
          };
          jQuery.Event = function(src, props) {
            if (!(this instanceof jQuery.Event)) {
              return new jQuery.Event(src, props);
            }
            if (src && src.type) {
              this.originalEvent = src;
              this.type = src.type;
              this.isDefaultPrevented = src.defaultPrevented || src.defaultPrevented === void 0 && // Support: Android <=2.3 only
              src.returnValue === false ? returnTrue : returnFalse;
              this.target = src.target && src.target.nodeType === 3 ? src.target.parentNode : src.target;
              this.currentTarget = src.currentTarget;
              this.relatedTarget = src.relatedTarget;
            } else {
              this.type = src;
            }
            if (props) {
              jQuery.extend(this, props);
            }
            this.timeStamp = src && src.timeStamp || Date.now();
            this[jQuery.expando] = true;
          };
          jQuery.Event.prototype = {
            constructor: jQuery.Event,
            isDefaultPrevented: returnFalse,
            isPropagationStopped: returnFalse,
            isImmediatePropagationStopped: returnFalse,
            isSimulated: false,
            preventDefault: function() {
              var e = this.originalEvent;
              this.isDefaultPrevented = returnTrue;
              if (e && !this.isSimulated) {
                e.preventDefault();
              }
            },
            stopPropagation: function() {
              var e = this.originalEvent;
              this.isPropagationStopped = returnTrue;
              if (e && !this.isSimulated) {
                e.stopPropagation();
              }
            },
            stopImmediatePropagation: function() {
              var e = this.originalEvent;
              this.isImmediatePropagationStopped = returnTrue;
              if (e && !this.isSimulated) {
                e.stopImmediatePropagation();
              }
              this.stopPropagation();
            }
          };
          jQuery.each({
            altKey: true,
            bubbles: true,
            cancelable: true,
            changedTouches: true,
            ctrlKey: true,
            detail: true,
            eventPhase: true,
            metaKey: true,
            pageX: true,
            pageY: true,
            shiftKey: true,
            view: true,
            "char": true,
            code: true,
            charCode: true,
            key: true,
            keyCode: true,
            button: true,
            buttons: true,
            clientX: true,
            clientY: true,
            offsetX: true,
            offsetY: true,
            pointerId: true,
            pointerType: true,
            screenX: true,
            screenY: true,
            targetTouches: true,
            toElement: true,
            touches: true,
            which: true
          }, jQuery.event.addProp);
          jQuery.each({ focus: "focusin", blur: "focusout" }, function(type, delegateType) {
            function focusMappedHandler(nativeEvent) {
              if (document2.documentMode) {
                var handle = dataPriv.get(this, "handle"), event = jQuery.event.fix(nativeEvent);
                event.type = nativeEvent.type === "focusin" ? "focus" : "blur";
                event.isSimulated = true;
                handle(nativeEvent);
                if (event.target === event.currentTarget) {
                  handle(event);
                }
              } else {
                jQuery.event.simulate(
                  delegateType,
                  nativeEvent.target,
                  jQuery.event.fix(nativeEvent)
                );
              }
            }
            jQuery.event.special[type] = {
              // Utilize native event if possible so blur/focus sequence is correct
              setup: function() {
                var attaches;
                leverageNative(this, type, true);
                if (document2.documentMode) {
                  attaches = dataPriv.get(this, delegateType);
                  if (!attaches) {
                    this.addEventListener(delegateType, focusMappedHandler);
                  }
                  dataPriv.set(this, delegateType, (attaches || 0) + 1);
                } else {
                  return false;
                }
              },
              trigger: function() {
                leverageNative(this, type);
                return true;
              },
              teardown: function() {
                var attaches;
                if (document2.documentMode) {
                  attaches = dataPriv.get(this, delegateType) - 1;
                  if (!attaches) {
                    this.removeEventListener(delegateType, focusMappedHandler);
                    dataPriv.remove(this, delegateType);
                  } else {
                    dataPriv.set(this, delegateType, attaches);
                  }
                } else {
                  return false;
                }
              },
              // Suppress native focus or blur if we're currently inside
              // a leveraged native-event stack
              _default: function(event) {
                return dataPriv.get(event.target, type);
              },
              delegateType
            };
            jQuery.event.special[delegateType] = {
              setup: function() {
                var doc = this.ownerDocument || this.document || this, dataHolder = document2.documentMode ? this : doc, attaches = dataPriv.get(dataHolder, delegateType);
                if (!attaches) {
                  if (document2.documentMode) {
                    this.addEventListener(delegateType, focusMappedHandler);
                  } else {
                    doc.addEventListener(type, focusMappedHandler, true);
                  }
                }
                dataPriv.set(dataHolder, delegateType, (attaches || 0) + 1);
              },
              teardown: function() {
                var doc = this.ownerDocument || this.document || this, dataHolder = document2.documentMode ? this : doc, attaches = dataPriv.get(dataHolder, delegateType) - 1;
                if (!attaches) {
                  if (document2.documentMode) {
                    this.removeEventListener(delegateType, focusMappedHandler);
                  } else {
                    doc.removeEventListener(type, focusMappedHandler, true);
                  }
                  dataPriv.remove(dataHolder, delegateType);
                } else {
                  dataPriv.set(dataHolder, delegateType, attaches);
                }
              }
            };
          });
          jQuery.each({
            mouseenter: "mouseover",
            mouseleave: "mouseout",
            pointerenter: "pointerover",
            pointerleave: "pointerout"
          }, function(orig, fix) {
            jQuery.event.special[orig] = {
              delegateType: fix,
              bindType: fix,
              handle: function(event) {
                var ret, target = this, related = event.relatedTarget, handleObj = event.handleObj;
                if (!related || related !== target && !jQuery.contains(target, related)) {
                  event.type = handleObj.origType;
                  ret = handleObj.handler.apply(this, arguments);
                  event.type = fix;
                }
                return ret;
              }
            };
          });
          jQuery.fn.extend({
            on: function(types, selector, data, fn) {
              return on(this, types, selector, data, fn);
            },
            one: function(types, selector, data, fn) {
              return on(this, types, selector, data, fn, 1);
            },
            off: function(types, selector, fn) {
              var handleObj, type;
              if (types && types.preventDefault && types.handleObj) {
                handleObj = types.handleObj;
                jQuery(types.delegateTarget).off(
                  handleObj.namespace ? handleObj.origType + "." + handleObj.namespace : handleObj.origType,
                  handleObj.selector,
                  handleObj.handler
                );
                return this;
              }
              if (typeof types === "object") {
                for (type in types) {
                  this.off(type, selector, types[type]);
                }
                return this;
              }
              if (selector === false || typeof selector === "function") {
                fn = selector;
                selector = void 0;
              }
              if (fn === false) {
                fn = returnFalse;
              }
              return this.each(function() {
                jQuery.event.remove(this, types, fn, selector);
              });
            }
          });
          var rnoInnerhtml = /<script|<style|<link/i, rchecked = /checked\s*(?:[^=]|=\s*.checked.)/i, rcleanScript = /^\s*<!\[CDATA\[|\]\]>\s*$/g;
          function manipulationTarget(elem, content) {
            if (nodeName(elem, "table") && nodeName(content.nodeType !== 11 ? content : content.firstChild, "tr")) {
              return jQuery(elem).children("tbody")[0] || elem;
            }
            return elem;
          }
          function disableScript(elem) {
            elem.type = (elem.getAttribute("type") !== null) + "/" + elem.type;
            return elem;
          }
          function restoreScript(elem) {
            if ((elem.type || "").slice(0, 5) === "true/") {
              elem.type = elem.type.slice(5);
            } else {
              elem.removeAttribute("type");
            }
            return elem;
          }
          function cloneCopyEvent(src, dest) {
            var i2, l, type, pdataOld, udataOld, udataCur, events;
            if (dest.nodeType !== 1) {
              return;
            }
            if (dataPriv.hasData(src)) {
              pdataOld = dataPriv.get(src);
              events = pdataOld.events;
              if (events) {
                dataPriv.remove(dest, "handle events");
                for (type in events) {
                  for (i2 = 0, l = events[type].length; i2 < l; i2++) {
                    jQuery.event.add(dest, type, events[type][i2]);
                  }
                }
              }
            }
            if (dataUser.hasData(src)) {
              udataOld = dataUser.access(src);
              udataCur = jQuery.extend({}, udataOld);
              dataUser.set(dest, udataCur);
            }
          }
          function fixInput(src, dest) {
            var nodeName2 = dest.nodeName.toLowerCase();
            if (nodeName2 === "input" && rcheckableType.test(src.type)) {
              dest.checked = src.checked;
            } else if (nodeName2 === "input" || nodeName2 === "textarea") {
              dest.defaultValue = src.defaultValue;
            }
          }
          function domManip(collection, args, callback, ignored) {
            args = flat(args);
            var fragment, first, scripts, hasScripts, node, doc, i2 = 0, l = collection.length, iNoClone = l - 1, value = args[0], valueIsFunction = isFunction(value);
            if (valueIsFunction || l > 1 && typeof value === "string" && !support.checkClone && rchecked.test(value)) {
              return collection.each(function(index) {
                var self = collection.eq(index);
                if (valueIsFunction) {
                  args[0] = value.call(this, index, self.html());
                }
                domManip(self, args, callback, ignored);
              });
            }
            if (l) {
              fragment = buildFragment(args, collection[0].ownerDocument, false, collection, ignored);
              first = fragment.firstChild;
              if (fragment.childNodes.length === 1) {
                fragment = first;
              }
              if (first || ignored) {
                scripts = jQuery.map(getAll(fragment, "script"), disableScript);
                hasScripts = scripts.length;
                for (; i2 < l; i2++) {
                  node = fragment;
                  if (i2 !== iNoClone) {
                    node = jQuery.clone(node, true, true);
                    if (hasScripts) {
                      jQuery.merge(scripts, getAll(node, "script"));
                    }
                  }
                  callback.call(collection[i2], node, i2);
                }
                if (hasScripts) {
                  doc = scripts[scripts.length - 1].ownerDocument;
                  jQuery.map(scripts, restoreScript);
                  for (i2 = 0; i2 < hasScripts; i2++) {
                    node = scripts[i2];
                    if (rscriptType.test(node.type || "") && !dataPriv.access(node, "globalEval") && jQuery.contains(doc, node)) {
                      if (node.src && (node.type || "").toLowerCase() !== "module") {
                        if (jQuery._evalUrl && !node.noModule) {
                          jQuery._evalUrl(node.src, {
                            nonce: node.nonce || node.getAttribute("nonce")
                          }, doc);
                        }
                      } else {
                        DOMEval(node.textContent.replace(rcleanScript, ""), node, doc);
                      }
                    }
                  }
                }
              }
            }
            return collection;
          }
          function remove(elem, selector, keepData) {
            var node, nodes = selector ? jQuery.filter(selector, elem) : elem, i2 = 0;
            for (; (node = nodes[i2]) != null; i2++) {
              if (!keepData && node.nodeType === 1) {
                jQuery.cleanData(getAll(node));
              }
              if (node.parentNode) {
                if (keepData && isAttached(node)) {
                  setGlobalEval(getAll(node, "script"));
                }
                node.parentNode.removeChild(node);
              }
            }
            return elem;
          }
          jQuery.extend({
            htmlPrefilter: function(html) {
              return html;
            },
            clone: function(elem, dataAndEvents, deepDataAndEvents) {
              var i2, l, srcElements, destElements, clone = elem.cloneNode(true), inPage = isAttached(elem);
              if (!support.noCloneChecked && (elem.nodeType === 1 || elem.nodeType === 11) && !jQuery.isXMLDoc(elem)) {
                destElements = getAll(clone);
                srcElements = getAll(elem);
                for (i2 = 0, l = srcElements.length; i2 < l; i2++) {
                  fixInput(srcElements[i2], destElements[i2]);
                }
              }
              if (dataAndEvents) {
                if (deepDataAndEvents) {
                  srcElements = srcElements || getAll(elem);
                  destElements = destElements || getAll(clone);
                  for (i2 = 0, l = srcElements.length; i2 < l; i2++) {
                    cloneCopyEvent(srcElements[i2], destElements[i2]);
                  }
                } else {
                  cloneCopyEvent(elem, clone);
                }
              }
              destElements = getAll(clone, "script");
              if (destElements.length > 0) {
                setGlobalEval(destElements, !inPage && getAll(elem, "script"));
              }
              return clone;
            },
            cleanData: function(elems) {
              var data, elem, type, special = jQuery.event.special, i2 = 0;
              for (; (elem = elems[i2]) !== void 0; i2++) {
                if (acceptData(elem)) {
                  if (data = elem[dataPriv.expando]) {
                    if (data.events) {
                      for (type in data.events) {
                        if (special[type]) {
                          jQuery.event.remove(elem, type);
                        } else {
                          jQuery.removeEvent(elem, type, data.handle);
                        }
                      }
                    }
                    elem[dataPriv.expando] = void 0;
                  }
                  if (elem[dataUser.expando]) {
                    elem[dataUser.expando] = void 0;
                  }
                }
              }
            }
          });
          jQuery.fn.extend({
            detach: function(selector) {
              return remove(this, selector, true);
            },
            remove: function(selector) {
              return remove(this, selector);
            },
            text: function(value) {
              return access(this, function(value2) {
                return value2 === void 0 ? jQuery.text(this) : this.empty().each(function() {
                  if (this.nodeType === 1 || this.nodeType === 11 || this.nodeType === 9) {
                    this.textContent = value2;
                  }
                });
              }, null, value, arguments.length);
            },
            append: function() {
              return domManip(this, arguments, function(elem) {
                if (this.nodeType === 1 || this.nodeType === 11 || this.nodeType === 9) {
                  var target = manipulationTarget(this, elem);
                  target.appendChild(elem);
                }
              });
            },
            prepend: function() {
              return domManip(this, arguments, function(elem) {
                if (this.nodeType === 1 || this.nodeType === 11 || this.nodeType === 9) {
                  var target = manipulationTarget(this, elem);
                  target.insertBefore(elem, target.firstChild);
                }
              });
            },
            before: function() {
              return domManip(this, arguments, function(elem) {
                if (this.parentNode) {
                  this.parentNode.insertBefore(elem, this);
                }
              });
            },
            after: function() {
              return domManip(this, arguments, function(elem) {
                if (this.parentNode) {
                  this.parentNode.insertBefore(elem, this.nextSibling);
                }
              });
            },
            empty: function() {
              var elem, i2 = 0;
              for (; (elem = this[i2]) != null; i2++) {
                if (elem.nodeType === 1) {
                  jQuery.cleanData(getAll(elem, false));
                  elem.textContent = "";
                }
              }
              return this;
            },
            clone: function(dataAndEvents, deepDataAndEvents) {
              dataAndEvents = dataAndEvents == null ? false : dataAndEvents;
              deepDataAndEvents = deepDataAndEvents == null ? dataAndEvents : deepDataAndEvents;
              return this.map(function() {
                return jQuery.clone(this, dataAndEvents, deepDataAndEvents);
              });
            },
            html: function(value) {
              return access(this, function(value2) {
                var elem = this[0] || {}, i2 = 0, l = this.length;
                if (value2 === void 0 && elem.nodeType === 1) {
                  return elem.innerHTML;
                }
                if (typeof value2 === "string" && !rnoInnerhtml.test(value2) && !wrapMap[(rtagName.exec(value2) || ["", ""])[1].toLowerCase()]) {
                  value2 = jQuery.htmlPrefilter(value2);
                  try {
                    for (; i2 < l; i2++) {
                      elem = this[i2] || {};
                      if (elem.nodeType === 1) {
                        jQuery.cleanData(getAll(elem, false));
                        elem.innerHTML = value2;
                      }
                    }
                    elem = 0;
                  } catch (e) {
                  }
                }
                if (elem) {
                  this.empty().append(value2);
                }
              }, null, value, arguments.length);
            },
            replaceWith: function() {
              var ignored = [];
              return domManip(this, arguments, function(elem) {
                var parent = this.parentNode;
                if (jQuery.inArray(this, ignored) < 0) {
                  jQuery.cleanData(getAll(this));
                  if (parent) {
                    parent.replaceChild(elem, this);
                  }
                }
              }, ignored);
            }
          });
          jQuery.each({
            appendTo: "append",
            prependTo: "prepend",
            insertBefore: "before",
            insertAfter: "after",
            replaceAll: "replaceWith"
          }, function(name, original) {
            jQuery.fn[name] = function(selector) {
              var elems, ret = [], insert = jQuery(selector), last = insert.length - 1, i2 = 0;
              for (; i2 <= last; i2++) {
                elems = i2 === last ? this : this.clone(true);
                jQuery(insert[i2])[original](elems);
                push.apply(ret, elems.get());
              }
              return this.pushStack(ret);
            };
          });
          var rnumnonpx = new RegExp("^(" + pnum + ")(?!px)[a-z%]+$", "i");
          var rcustomProp = /^--/;
          var getStyles = function(elem) {
            var view = elem.ownerDocument.defaultView;
            if (!view || !view.opener) {
              view = window2;
            }
            return view.getComputedStyle(elem);
          };
          var swap = function(elem, options, callback) {
            var ret, name, old = {};
            for (name in options) {
              old[name] = elem.style[name];
              elem.style[name] = options[name];
            }
            ret = callback.call(elem);
            for (name in options) {
              elem.style[name] = old[name];
            }
            return ret;
          };
          var rboxStyle = new RegExp(cssExpand.join("|"), "i");
          (function() {
            function computeStyleTests() {
              if (!div) {
                return;
              }
              container.style.cssText = "position:absolute;left:-11111px;width:60px;margin-top:1px;padding:0;border:0";
              div.style.cssText = "position:relative;display:block;box-sizing:border-box;overflow:scroll;margin:auto;border:1px;padding:1px;width:60%;top:1%";
              documentElement.appendChild(container).appendChild(div);
              var divStyle = window2.getComputedStyle(div);
              pixelPositionVal = divStyle.top !== "1%";
              reliableMarginLeftVal = roundPixelMeasures(divStyle.marginLeft) === 12;
              div.style.right = "60%";
              pixelBoxStylesVal = roundPixelMeasures(divStyle.right) === 36;
              boxSizingReliableVal = roundPixelMeasures(divStyle.width) === 36;
              div.style.position = "absolute";
              scrollboxSizeVal = roundPixelMeasures(div.offsetWidth / 3) === 12;
              documentElement.removeChild(container);
              div = null;
            }
            function roundPixelMeasures(measure) {
              return Math.round(parseFloat(measure));
            }
            var pixelPositionVal, boxSizingReliableVal, scrollboxSizeVal, pixelBoxStylesVal, reliableTrDimensionsVal, reliableMarginLeftVal, container = document2.createElement("div"), div = document2.createElement("div");
            if (!div.style) {
              return;
            }
            div.style.backgroundClip = "content-box";
            div.cloneNode(true).style.backgroundClip = "";
            support.clearCloneStyle = div.style.backgroundClip === "content-box";
            jQuery.extend(support, {
              boxSizingReliable: function() {
                computeStyleTests();
                return boxSizingReliableVal;
              },
              pixelBoxStyles: function() {
                computeStyleTests();
                return pixelBoxStylesVal;
              },
              pixelPosition: function() {
                computeStyleTests();
                return pixelPositionVal;
              },
              reliableMarginLeft: function() {
                computeStyleTests();
                return reliableMarginLeftVal;
              },
              scrollboxSize: function() {
                computeStyleTests();
                return scrollboxSizeVal;
              },
              // Support: IE 9 - 11+, Edge 15 - 18+
              // IE/Edge misreport `getComputedStyle` of table rows with width/height
              // set in CSS while `offset*` properties report correct values.
              // Behavior in IE 9 is more subtle than in newer versions & it passes
              // some versions of this test; make sure not to make it pass there!
              //
              // Support: Firefox 70+
              // Only Firefox includes border widths
              // in computed dimensions. (gh-4529)
              reliableTrDimensions: function() {
                var table, tr, trChild, trStyle;
                if (reliableTrDimensionsVal == null) {
                  table = document2.createElement("table");
                  tr = document2.createElement("tr");
                  trChild = document2.createElement("div");
                  table.style.cssText = "position:absolute;left:-11111px;border-collapse:separate";
                  tr.style.cssText = "box-sizing:content-box;border:1px solid";
                  tr.style.height = "1px";
                  trChild.style.height = "9px";
                  trChild.style.display = "block";
                  documentElement.appendChild(table).appendChild(tr).appendChild(trChild);
                  trStyle = window2.getComputedStyle(tr);
                  reliableTrDimensionsVal = parseInt(trStyle.height, 10) + parseInt(trStyle.borderTopWidth, 10) + parseInt(trStyle.borderBottomWidth, 10) === tr.offsetHeight;
                  documentElement.removeChild(table);
                }
                return reliableTrDimensionsVal;
              }
            });
          })();
          function curCSS(elem, name, computed) {
            var width, minWidth, maxWidth, ret, isCustomProp = rcustomProp.test(name), style = elem.style;
            computed = computed || getStyles(elem);
            if (computed) {
              ret = computed.getPropertyValue(name) || computed[name];
              if (isCustomProp && ret) {
                ret = ret.replace(rtrimCSS, "$1") || void 0;
              }
              if (ret === "" && !isAttached(elem)) {
                ret = jQuery.style(elem, name);
              }
              if (!support.pixelBoxStyles() && rnumnonpx.test(ret) && rboxStyle.test(name)) {
                width = style.width;
                minWidth = style.minWidth;
                maxWidth = style.maxWidth;
                style.minWidth = style.maxWidth = style.width = ret;
                ret = computed.width;
                style.width = width;
                style.minWidth = minWidth;
                style.maxWidth = maxWidth;
              }
            }
            return ret !== void 0 ? (
              // Support: IE <=9 - 11 only
              // IE returns zIndex value as an integer.
              ret + ""
            ) : ret;
          }
          function addGetHookIf(conditionFn, hookFn) {
            return {
              get: function() {
                if (conditionFn()) {
                  delete this.get;
                  return;
                }
                return (this.get = hookFn).apply(this, arguments);
              }
            };
          }
          var cssPrefixes = ["Webkit", "Moz", "ms"], emptyStyle = document2.createElement("div").style, vendorProps = {};
          function vendorPropName(name) {
            var capName = name[0].toUpperCase() + name.slice(1), i2 = cssPrefixes.length;
            while (i2--) {
              name = cssPrefixes[i2] + capName;
              if (name in emptyStyle) {
                return name;
              }
            }
          }
          function finalPropName(name) {
            var final = jQuery.cssProps[name] || vendorProps[name];
            if (final) {
              return final;
            }
            if (name in emptyStyle) {
              return name;
            }
            return vendorProps[name] = vendorPropName(name) || name;
          }
          var rdisplayswap = /^(none|table(?!-c[ea]).+)/, cssShow = { position: "absolute", visibility: "hidden", display: "block" }, cssNormalTransform = {
            letterSpacing: "0",
            fontWeight: "400"
          };
          function setPositiveNumber(_elem, value, subtract) {
            var matches = rcssNum.exec(value);
            return matches ? (
              // Guard against undefined "subtract", e.g., when used as in cssHooks
              Math.max(0, matches[2] - (subtract || 0)) + (matches[3] || "px")
            ) : value;
          }
          function boxModelAdjustment(elem, dimension, box, isBorderBox, styles, computedVal) {
            var i2 = dimension === "width" ? 1 : 0, extra = 0, delta = 0, marginDelta = 0;
            if (box === (isBorderBox ? "border" : "content")) {
              return 0;
            }
            for (; i2 < 4; i2 += 2) {
              if (box === "margin") {
                marginDelta += jQuery.css(elem, box + cssExpand[i2], true, styles);
              }
              if (!isBorderBox) {
                delta += jQuery.css(elem, "padding" + cssExpand[i2], true, styles);
                if (box !== "padding") {
                  delta += jQuery.css(elem, "border" + cssExpand[i2] + "Width", true, styles);
                } else {
                  extra += jQuery.css(elem, "border" + cssExpand[i2] + "Width", true, styles);
                }
              } else {
                if (box === "content") {
                  delta -= jQuery.css(elem, "padding" + cssExpand[i2], true, styles);
                }
                if (box !== "margin") {
                  delta -= jQuery.css(elem, "border" + cssExpand[i2] + "Width", true, styles);
                }
              }
            }
            if (!isBorderBox && computedVal >= 0) {
              delta += Math.max(0, Math.ceil(
                elem["offset" + dimension[0].toUpperCase() + dimension.slice(1)] - computedVal - delta - extra - 0.5
                // If offsetWidth/offsetHeight is unknown, then we can't determine content-box scroll gutter
                // Use an explicit zero to avoid NaN (gh-3964)
              )) || 0;
            }
            return delta + marginDelta;
          }
          function getWidthOrHeight(elem, dimension, extra) {
            var styles = getStyles(elem), boxSizingNeeded = !support.boxSizingReliable() || extra, isBorderBox = boxSizingNeeded && jQuery.css(elem, "boxSizing", false, styles) === "border-box", valueIsBorderBox = isBorderBox, val = curCSS(elem, dimension, styles), offsetProp = "offset" + dimension[0].toUpperCase() + dimension.slice(1);
            if (rnumnonpx.test(val)) {
              if (!extra) {
                return val;
              }
              val = "auto";
            }
            if ((!support.boxSizingReliable() && isBorderBox || // Support: IE 10 - 11+, Edge 15 - 18+
            // IE/Edge misreport `getComputedStyle` of table rows with width/height
            // set in CSS while `offset*` properties report correct values.
            // Interestingly, in some cases IE 9 doesn't suffer from this issue.
            !support.reliableTrDimensions() && nodeName(elem, "tr") || // Fall back to offsetWidth/offsetHeight when value is "auto"
            // This happens for inline elements with no explicit setting (gh-3571)
            val === "auto" || // Support: Android <=4.1 - 4.3 only
            // Also use offsetWidth/offsetHeight for misreported inline dimensions (gh-3602)
            !parseFloat(val) && jQuery.css(elem, "display", false, styles) === "inline") && // Make sure the element is visible & connected
            elem.getClientRects().length) {
              isBorderBox = jQuery.css(elem, "boxSizing", false, styles) === "border-box";
              valueIsBorderBox = offsetProp in elem;
              if (valueIsBorderBox) {
                val = elem[offsetProp];
              }
            }
            val = parseFloat(val) || 0;
            return val + boxModelAdjustment(
              elem,
              dimension,
              extra || (isBorderBox ? "border" : "content"),
              valueIsBorderBox,
              styles,
              // Provide the current computed size to request scroll gutter calculation (gh-3589)
              val
            ) + "px";
          }
          jQuery.extend({
            // Add in style property hooks for overriding the default
            // behavior of getting and setting a style property
            cssHooks: {
              opacity: {
                get: function(elem, computed) {
                  if (computed) {
                    var ret = curCSS(elem, "opacity");
                    return ret === "" ? "1" : ret;
                  }
                }
              }
            },
            // Don't automatically add "px" to these possibly-unitless properties
            cssNumber: {
              animationIterationCount: true,
              aspectRatio: true,
              borderImageSlice: true,
              columnCount: true,
              flexGrow: true,
              flexShrink: true,
              fontWeight: true,
              gridArea: true,
              gridColumn: true,
              gridColumnEnd: true,
              gridColumnStart: true,
              gridRow: true,
              gridRowEnd: true,
              gridRowStart: true,
              lineHeight: true,
              opacity: true,
              order: true,
              orphans: true,
              scale: true,
              widows: true,
              zIndex: true,
              zoom: true,
              // SVG-related
              fillOpacity: true,
              floodOpacity: true,
              stopOpacity: true,
              strokeMiterlimit: true,
              strokeOpacity: true
            },
            // Add in properties whose names you wish to fix before
            // setting or getting the value
            cssProps: {},
            // Get and set the style property on a DOM Node
            style: function(elem, name, value, extra) {
              if (!elem || elem.nodeType === 3 || elem.nodeType === 8 || !elem.style) {
                return;
              }
              var ret, type, hooks, origName = camelCase(name), isCustomProp = rcustomProp.test(name), style = elem.style;
              if (!isCustomProp) {
                name = finalPropName(origName);
              }
              hooks = jQuery.cssHooks[name] || jQuery.cssHooks[origName];
              if (value !== void 0) {
                type = typeof value;
                if (type === "string" && (ret = rcssNum.exec(value)) && ret[1]) {
                  value = adjustCSS(elem, name, ret);
                  type = "number";
                }
                if (value == null || value !== value) {
                  return;
                }
                if (type === "number" && !isCustomProp) {
                  value += ret && ret[3] || (jQuery.cssNumber[origName] ? "" : "px");
                }
                if (!support.clearCloneStyle && value === "" && name.indexOf("background") === 0) {
                  style[name] = "inherit";
                }
                if (!hooks || !("set" in hooks) || (value = hooks.set(elem, value, extra)) !== void 0) {
                  if (isCustomProp) {
                    style.setProperty(name, value);
                  } else {
                    style[name] = value;
                  }
                }
              } else {
                if (hooks && "get" in hooks && (ret = hooks.get(elem, false, extra)) !== void 0) {
                  return ret;
                }
                return style[name];
              }
            },
            css: function(elem, name, extra, styles) {
              var val, num2, hooks, origName = camelCase(name), isCustomProp = rcustomProp.test(name);
              if (!isCustomProp) {
                name = finalPropName(origName);
              }
              hooks = jQuery.cssHooks[name] || jQuery.cssHooks[origName];
              if (hooks && "get" in hooks) {
                val = hooks.get(elem, true, extra);
              }
              if (val === void 0) {
                val = curCSS(elem, name, styles);
              }
              if (val === "normal" && name in cssNormalTransform) {
                val = cssNormalTransform[name];
              }
              if (extra === "" || extra) {
                num2 = parseFloat(val);
                return extra === true || isFinite(num2) ? num2 || 0 : val;
              }
              return val;
            }
          });
          jQuery.each(["height", "width"], function(_i, dimension) {
            jQuery.cssHooks[dimension] = {
              get: function(elem, computed, extra) {
                if (computed) {
                  return rdisplayswap.test(jQuery.css(elem, "display")) && // Support: Safari 8+
                  // Table columns in Safari have non-zero offsetWidth & zero
                  // getBoundingClientRect().width unless display is changed.
                  // Support: IE <=11 only
                  // Running getBoundingClientRect on a disconnected node
                  // in IE throws an error.
                  (!elem.getClientRects().length || !elem.getBoundingClientRect().width) ? swap(elem, cssShow, function() {
                    return getWidthOrHeight(elem, dimension, extra);
                  }) : getWidthOrHeight(elem, dimension, extra);
                }
              },
              set: function(elem, value, extra) {
                var matches, styles = getStyles(elem), scrollboxSizeBuggy = !support.scrollboxSize() && styles.position === "absolute", boxSizingNeeded = scrollboxSizeBuggy || extra, isBorderBox = boxSizingNeeded && jQuery.css(elem, "boxSizing", false, styles) === "border-box", subtract = extra ? boxModelAdjustment(
                  elem,
                  dimension,
                  extra,
                  isBorderBox,
                  styles
                ) : 0;
                if (isBorderBox && scrollboxSizeBuggy) {
                  subtract -= Math.ceil(
                    elem["offset" + dimension[0].toUpperCase() + dimension.slice(1)] - parseFloat(styles[dimension]) - boxModelAdjustment(elem, dimension, "border", false, styles) - 0.5
                  );
                }
                if (subtract && (matches = rcssNum.exec(value)) && (matches[3] || "px") !== "px") {
                  elem.style[dimension] = value;
                  value = jQuery.css(elem, dimension);
                }
                return setPositiveNumber(elem, value, subtract);
              }
            };
          });
          jQuery.cssHooks.marginLeft = addGetHookIf(
            support.reliableMarginLeft,
            function(elem, computed) {
              if (computed) {
                return (parseFloat(curCSS(elem, "marginLeft")) || elem.getBoundingClientRect().left - swap(elem, { marginLeft: 0 }, function() {
                  return elem.getBoundingClientRect().left;
                })) + "px";
              }
            }
          );
          jQuery.each({
            margin: "",
            padding: "",
            border: "Width"
          }, function(prefix, suffix) {
            jQuery.cssHooks[prefix + suffix] = {
              expand: function(value) {
                var i2 = 0, expanded = {}, parts = typeof value === "string" ? value.split(" ") : [value];
                for (; i2 < 4; i2++) {
                  expanded[prefix + cssExpand[i2] + suffix] = parts[i2] || parts[i2 - 2] || parts[0];
                }
                return expanded;
              }
            };
            if (prefix !== "margin") {
              jQuery.cssHooks[prefix + suffix].set = setPositiveNumber;
            }
          });
          jQuery.fn.extend({
            css: function(name, value) {
              return access(this, function(elem, name2, value2) {
                var styles, len, map = {}, i2 = 0;
                if (Array.isArray(name2)) {
                  styles = getStyles(elem);
                  len = name2.length;
                  for (; i2 < len; i2++) {
                    map[name2[i2]] = jQuery.css(elem, name2[i2], false, styles);
                  }
                  return map;
                }
                return value2 !== void 0 ? jQuery.style(elem, name2, value2) : jQuery.css(elem, name2);
              }, name, value, arguments.length > 1);
            }
          });
          function Tween(elem, options, prop, end, easing) {
            return new Tween.prototype.init(elem, options, prop, end, easing);
          }
          jQuery.Tween = Tween;
          Tween.prototype = {
            constructor: Tween,
            init: function(elem, options, prop, end, easing, unit) {
              this.elem = elem;
              this.prop = prop;
              this.easing = easing || jQuery.easing._default;
              this.options = options;
              this.start = this.now = this.cur();
              this.end = end;
              this.unit = unit || (jQuery.cssNumber[prop] ? "" : "px");
            },
            cur: function() {
              var hooks = Tween.propHooks[this.prop];
              return hooks && hooks.get ? hooks.get(this) : Tween.propHooks._default.get(this);
            },
            run: function(percent) {
              var eased, hooks = Tween.propHooks[this.prop];
              if (this.options.duration) {
                this.pos = eased = jQuery.easing[this.easing](
                  percent,
                  this.options.duration * percent,
                  0,
                  1,
                  this.options.duration
                );
              } else {
                this.pos = eased = percent;
              }
              this.now = (this.end - this.start) * eased + this.start;
              if (this.options.step) {
                this.options.step.call(this.elem, this.now, this);
              }
              if (hooks && hooks.set) {
                hooks.set(this);
              } else {
                Tween.propHooks._default.set(this);
              }
              return this;
            }
          };
          Tween.prototype.init.prototype = Tween.prototype;
          Tween.propHooks = {
            _default: {
              get: function(tween) {
                var result;
                if (tween.elem.nodeType !== 1 || tween.elem[tween.prop] != null && tween.elem.style[tween.prop] == null) {
                  return tween.elem[tween.prop];
                }
                result = jQuery.css(tween.elem, tween.prop, "");
                return !result || result === "auto" ? 0 : result;
              },
              set: function(tween) {
                if (jQuery.fx.step[tween.prop]) {
                  jQuery.fx.step[tween.prop](tween);
                } else if (tween.elem.nodeType === 1 && (jQuery.cssHooks[tween.prop] || tween.elem.style[finalPropName(tween.prop)] != null)) {
                  jQuery.style(tween.elem, tween.prop, tween.now + tween.unit);
                } else {
                  tween.elem[tween.prop] = tween.now;
                }
              }
            }
          };
          Tween.propHooks.scrollTop = Tween.propHooks.scrollLeft = {
            set: function(tween) {
              if (tween.elem.nodeType && tween.elem.parentNode) {
                tween.elem[tween.prop] = tween.now;
              }
            }
          };
          jQuery.easing = {
            linear: function(p) {
              return p;
            },
            swing: function(p) {
              return 0.5 - Math.cos(p * Math.PI) / 2;
            },
            _default: "swing"
          };
          jQuery.fx = Tween.prototype.init;
          jQuery.fx.step = {};
          var fxNow, inProgress, rfxtypes = /^(?:toggle|show|hide)$/, rrun = /queueHooks$/;
          function schedule() {
            if (inProgress) {
              if (document2.hidden === false && window2.requestAnimationFrame) {
                window2.requestAnimationFrame(schedule);
              } else {
                window2.setTimeout(schedule, jQuery.fx.interval);
              }
              jQuery.fx.tick();
            }
          }
          function createFxNow() {
            window2.setTimeout(function() {
              fxNow = void 0;
            });
            return fxNow = Date.now();
          }
          function genFx(type, includeWidth) {
            var which, i2 = 0, attrs = { height: type };
            includeWidth = includeWidth ? 1 : 0;
            for (; i2 < 4; i2 += 2 - includeWidth) {
              which = cssExpand[i2];
              attrs["margin" + which] = attrs["padding" + which] = type;
            }
            if (includeWidth) {
              attrs.opacity = attrs.width = type;
            }
            return attrs;
          }
          function createTween(value, prop, animation) {
            var tween, collection = (Animation.tweeners[prop] || []).concat(Animation.tweeners["*"]), index = 0, length = collection.length;
            for (; index < length; index++) {
              if (tween = collection[index].call(animation, prop, value)) {
                return tween;
              }
            }
          }
          function defaultPrefilter(elem, props, opts) {
            var prop, value, toggle, hooks, oldfire, propTween, restoreDisplay, display, isBox = "width" in props || "height" in props, anim = this, orig = {}, style = elem.style, hidden = elem.nodeType && isHiddenWithinTree(elem), dataShow = dataPriv.get(elem, "fxshow");
            if (!opts.queue) {
              hooks = jQuery._queueHooks(elem, "fx");
              if (hooks.unqueued == null) {
                hooks.unqueued = 0;
                oldfire = hooks.empty.fire;
                hooks.empty.fire = function() {
                  if (!hooks.unqueued) {
                    oldfire();
                  }
                };
              }
              hooks.unqueued++;
              anim.always(function() {
                anim.always(function() {
                  hooks.unqueued--;
                  if (!jQuery.queue(elem, "fx").length) {
                    hooks.empty.fire();
                  }
                });
              });
            }
            for (prop in props) {
              value = props[prop];
              if (rfxtypes.test(value)) {
                delete props[prop];
                toggle = toggle || value === "toggle";
                if (value === (hidden ? "hide" : "show")) {
                  if (value === "show" && dataShow && dataShow[prop] !== void 0) {
                    hidden = true;
                  } else {
                    continue;
                  }
                }
                orig[prop] = dataShow && dataShow[prop] || jQuery.style(elem, prop);
              }
            }
            propTween = !jQuery.isEmptyObject(props);
            if (!propTween && jQuery.isEmptyObject(orig)) {
              return;
            }
            if (isBox && elem.nodeType === 1) {
              opts.overflow = [style.overflow, style.overflowX, style.overflowY];
              restoreDisplay = dataShow && dataShow.display;
              if (restoreDisplay == null) {
                restoreDisplay = dataPriv.get(elem, "display");
              }
              display = jQuery.css(elem, "display");
              if (display === "none") {
                if (restoreDisplay) {
                  display = restoreDisplay;
                } else {
                  showHide([elem], true);
                  restoreDisplay = elem.style.display || restoreDisplay;
                  display = jQuery.css(elem, "display");
                  showHide([elem]);
                }
              }
              if (display === "inline" || display === "inline-block" && restoreDisplay != null) {
                if (jQuery.css(elem, "float") === "none") {
                  if (!propTween) {
                    anim.done(function() {
                      style.display = restoreDisplay;
                    });
                    if (restoreDisplay == null) {
                      display = style.display;
                      restoreDisplay = display === "none" ? "" : display;
                    }
                  }
                  style.display = "inline-block";
                }
              }
            }
            if (opts.overflow) {
              style.overflow = "hidden";
              anim.always(function() {
                style.overflow = opts.overflow[0];
                style.overflowX = opts.overflow[1];
                style.overflowY = opts.overflow[2];
              });
            }
            propTween = false;
            for (prop in orig) {
              if (!propTween) {
                if (dataShow) {
                  if ("hidden" in dataShow) {
                    hidden = dataShow.hidden;
                  }
                } else {
                  dataShow = dataPriv.access(elem, "fxshow", { display: restoreDisplay });
                }
                if (toggle) {
                  dataShow.hidden = !hidden;
                }
                if (hidden) {
                  showHide([elem], true);
                }
                anim.done(function() {
                  if (!hidden) {
                    showHide([elem]);
                  }
                  dataPriv.remove(elem, "fxshow");
                  for (prop in orig) {
                    jQuery.style(elem, prop, orig[prop]);
                  }
                });
              }
              propTween = createTween(hidden ? dataShow[prop] : 0, prop, anim);
              if (!(prop in dataShow)) {
                dataShow[prop] = propTween.start;
                if (hidden) {
                  propTween.end = propTween.start;
                  propTween.start = 0;
                }
              }
            }
          }
          function propFilter(props, specialEasing) {
            var index, name, easing, value, hooks;
            for (index in props) {
              name = camelCase(index);
              easing = specialEasing[name];
              value = props[index];
              if (Array.isArray(value)) {
                easing = value[1];
                value = props[index] = value[0];
              }
              if (index !== name) {
                props[name] = value;
                delete props[index];
              }
              hooks = jQuery.cssHooks[name];
              if (hooks && "expand" in hooks) {
                value = hooks.expand(value);
                delete props[name];
                for (index in value) {
                  if (!(index in props)) {
                    props[index] = value[index];
                    specialEasing[index] = easing;
                  }
                }
              } else {
                specialEasing[name] = easing;
              }
            }
          }
          function Animation(elem, properties, options) {
            var result, stopped, index = 0, length = Animation.prefilters.length, deferred = jQuery.Deferred().always(function() {
              delete tick.elem;
            }), tick = function() {
              if (stopped) {
                return false;
              }
              var currentTime = fxNow || createFxNow(), remaining = Math.max(0, animation.startTime + animation.duration - currentTime), temp = remaining / animation.duration || 0, percent = 1 - temp, index2 = 0, length2 = animation.tweens.length;
              for (; index2 < length2; index2++) {
                animation.tweens[index2].run(percent);
              }
              deferred.notifyWith(elem, [animation, percent, remaining]);
              if (percent < 1 && length2) {
                return remaining;
              }
              if (!length2) {
                deferred.notifyWith(elem, [animation, 1, 0]);
              }
              deferred.resolveWith(elem, [animation]);
              return false;
            }, animation = deferred.promise({
              elem,
              props: jQuery.extend({}, properties),
              opts: jQuery.extend(true, {
                specialEasing: {},
                easing: jQuery.easing._default
              }, options),
              originalProperties: properties,
              originalOptions: options,
              startTime: fxNow || createFxNow(),
              duration: options.duration,
              tweens: [],
              createTween: function(prop, end) {
                var tween = jQuery.Tween(
                  elem,
                  animation.opts,
                  prop,
                  end,
                  animation.opts.specialEasing[prop] || animation.opts.easing
                );
                animation.tweens.push(tween);
                return tween;
              },
              stop: function(gotoEnd) {
                var index2 = 0, length2 = gotoEnd ? animation.tweens.length : 0;
                if (stopped) {
                  return this;
                }
                stopped = true;
                for (; index2 < length2; index2++) {
                  animation.tweens[index2].run(1);
                }
                if (gotoEnd) {
                  deferred.notifyWith(elem, [animation, 1, 0]);
                  deferred.resolveWith(elem, [animation, gotoEnd]);
                } else {
                  deferred.rejectWith(elem, [animation, gotoEnd]);
                }
                return this;
              }
            }), props = animation.props;
            propFilter(props, animation.opts.specialEasing);
            for (; index < length; index++) {
              result = Animation.prefilters[index].call(animation, elem, props, animation.opts);
              if (result) {
                if (isFunction(result.stop)) {
                  jQuery._queueHooks(animation.elem, animation.opts.queue).stop = result.stop.bind(result);
                }
                return result;
              }
            }
            jQuery.map(props, createTween, animation);
            if (isFunction(animation.opts.start)) {
              animation.opts.start.call(elem, animation);
            }
            animation.progress(animation.opts.progress).done(animation.opts.done, animation.opts.complete).fail(animation.opts.fail).always(animation.opts.always);
            jQuery.fx.timer(
              jQuery.extend(tick, {
                elem,
                anim: animation,
                queue: animation.opts.queue
              })
            );
            return animation;
          }
          jQuery.Animation = jQuery.extend(Animation, {
            tweeners: {
              "*": [function(prop, value) {
                var tween = this.createTween(prop, value);
                adjustCSS(tween.elem, prop, rcssNum.exec(value), tween);
                return tween;
              }]
            },
            tweener: function(props, callback) {
              if (isFunction(props)) {
                callback = props;
                props = ["*"];
              } else {
                props = props.match(rnothtmlwhite);
              }
              var prop, index = 0, length = props.length;
              for (; index < length; index++) {
                prop = props[index];
                Animation.tweeners[prop] = Animation.tweeners[prop] || [];
                Animation.tweeners[prop].unshift(callback);
              }
            },
            prefilters: [defaultPrefilter],
            prefilter: function(callback, prepend) {
              if (prepend) {
                Animation.prefilters.unshift(callback);
              } else {
                Animation.prefilters.push(callback);
              }
            }
          });
          jQuery.speed = function(speed, easing, fn) {
            var opt = speed && typeof speed === "object" ? jQuery.extend({}, speed) : {
              complete: fn || !fn && easing || isFunction(speed) && speed,
              duration: speed,
              easing: fn && easing || easing && !isFunction(easing) && easing
            };
            if (jQuery.fx.off) {
              opt.duration = 0;
            } else {
              if (typeof opt.duration !== "number") {
                if (opt.duration in jQuery.fx.speeds) {
                  opt.duration = jQuery.fx.speeds[opt.duration];
                } else {
                  opt.duration = jQuery.fx.speeds._default;
                }
              }
            }
            if (opt.queue == null || opt.queue === true) {
              opt.queue = "fx";
            }
            opt.old = opt.complete;
            opt.complete = function() {
              if (isFunction(opt.old)) {
                opt.old.call(this);
              }
              if (opt.queue) {
                jQuery.dequeue(this, opt.queue);
              }
            };
            return opt;
          };
          jQuery.fn.extend({
            fadeTo: function(speed, to, easing, callback) {
              return this.filter(isHiddenWithinTree).css("opacity", 0).show().end().animate({ opacity: to }, speed, easing, callback);
            },
            animate: function(prop, speed, easing, callback) {
              var empty = jQuery.isEmptyObject(prop), optall = jQuery.speed(speed, easing, callback), doAnimation = function() {
                var anim = Animation(this, jQuery.extend({}, prop), optall);
                if (empty || dataPriv.get(this, "finish")) {
                  anim.stop(true);
                }
              };
              doAnimation.finish = doAnimation;
              return empty || optall.queue === false ? this.each(doAnimation) : this.queue(optall.queue, doAnimation);
            },
            stop: function(type, clearQueue, gotoEnd) {
              var stopQueue = function(hooks) {
                var stop = hooks.stop;
                delete hooks.stop;
                stop(gotoEnd);
              };
              if (typeof type !== "string") {
                gotoEnd = clearQueue;
                clearQueue = type;
                type = void 0;
              }
              if (clearQueue) {
                this.queue(type || "fx", []);
              }
              return this.each(function() {
                var dequeue = true, index = type != null && type + "queueHooks", timers = jQuery.timers, data = dataPriv.get(this);
                if (index) {
                  if (data[index] && data[index].stop) {
                    stopQueue(data[index]);
                  }
                } else {
                  for (index in data) {
                    if (data[index] && data[index].stop && rrun.test(index)) {
                      stopQueue(data[index]);
                    }
                  }
                }
                for (index = timers.length; index--; ) {
                  if (timers[index].elem === this && (type == null || timers[index].queue === type)) {
                    timers[index].anim.stop(gotoEnd);
                    dequeue = false;
                    timers.splice(index, 1);
                  }
                }
                if (dequeue || !gotoEnd) {
                  jQuery.dequeue(this, type);
                }
              });
            },
            finish: function(type) {
              if (type !== false) {
                type = type || "fx";
              }
              return this.each(function() {
                var index, data = dataPriv.get(this), queue = data[type + "queue"], hooks = data[type + "queueHooks"], timers = jQuery.timers, length = queue ? queue.length : 0;
                data.finish = true;
                jQuery.queue(this, type, []);
                if (hooks && hooks.stop) {
                  hooks.stop.call(this, true);
                }
                for (index = timers.length; index--; ) {
                  if (timers[index].elem === this && timers[index].queue === type) {
                    timers[index].anim.stop(true);
                    timers.splice(index, 1);
                  }
                }
                for (index = 0; index < length; index++) {
                  if (queue[index] && queue[index].finish) {
                    queue[index].finish.call(this);
                  }
                }
                delete data.finish;
              });
            }
          });
          jQuery.each(["toggle", "show", "hide"], function(_i, name) {
            var cssFn = jQuery.fn[name];
            jQuery.fn[name] = function(speed, easing, callback) {
              return speed == null || typeof speed === "boolean" ? cssFn.apply(this, arguments) : this.animate(genFx(name, true), speed, easing, callback);
            };
          });
          jQuery.each({
            slideDown: genFx("show"),
            slideUp: genFx("hide"),
            slideToggle: genFx("toggle"),
            fadeIn: { opacity: "show" },
            fadeOut: { opacity: "hide" },
            fadeToggle: { opacity: "toggle" }
          }, function(name, props) {
            jQuery.fn[name] = function(speed, easing, callback) {
              return this.animate(props, speed, easing, callback);
            };
          });
          jQuery.timers = [];
          jQuery.fx.tick = function() {
            var timer, i2 = 0, timers = jQuery.timers;
            fxNow = Date.now();
            for (; i2 < timers.length; i2++) {
              timer = timers[i2];
              if (!timer() && timers[i2] === timer) {
                timers.splice(i2--, 1);
              }
            }
            if (!timers.length) {
              jQuery.fx.stop();
            }
            fxNow = void 0;
          };
          jQuery.fx.timer = function(timer) {
            jQuery.timers.push(timer);
            jQuery.fx.start();
          };
          jQuery.fx.interval = 13;
          jQuery.fx.start = function() {
            if (inProgress) {
              return;
            }
            inProgress = true;
            schedule();
          };
          jQuery.fx.stop = function() {
            inProgress = null;
          };
          jQuery.fx.speeds = {
            slow: 600,
            fast: 200,
            // Default speed
            _default: 400
          };
          jQuery.fn.delay = function(time, type) {
            time = jQuery.fx ? jQuery.fx.speeds[time] || time : time;
            type = type || "fx";
            return this.queue(type, function(next, hooks) {
              var timeout = window2.setTimeout(next, time);
              hooks.stop = function() {
                window2.clearTimeout(timeout);
              };
            });
          };
          (function() {
            var input = document2.createElement("input"), select = document2.createElement("select"), opt = select.appendChild(document2.createElement("option"));
            input.type = "checkbox";
            support.checkOn = input.value !== "";
            support.optSelected = opt.selected;
            input = document2.createElement("input");
            input.value = "t";
            input.type = "radio";
            support.radioValue = input.value === "t";
          })();
          var boolHook, attrHandle = jQuery.expr.attrHandle;
          jQuery.fn.extend({
            attr: function(name, value) {
              return access(this, jQuery.attr, name, value, arguments.length > 1);
            },
            removeAttr: function(name) {
              return this.each(function() {
                jQuery.removeAttr(this, name);
              });
            }
          });
          jQuery.extend({
            attr: function(elem, name, value) {
              var ret, hooks, nType = elem.nodeType;
              if (nType === 3 || nType === 8 || nType === 2) {
                return;
              }
              if (typeof elem.getAttribute === "undefined") {
                return jQuery.prop(elem, name, value);
              }
              if (nType !== 1 || !jQuery.isXMLDoc(elem)) {
                hooks = jQuery.attrHooks[name.toLowerCase()] || (jQuery.expr.match.bool.test(name) ? boolHook : void 0);
              }
              if (value !== void 0) {
                if (value === null) {
                  jQuery.removeAttr(elem, name);
                  return;
                }
                if (hooks && "set" in hooks && (ret = hooks.set(elem, value, name)) !== void 0) {
                  return ret;
                }
                elem.setAttribute(name, value + "");
                return value;
              }
              if (hooks && "get" in hooks && (ret = hooks.get(elem, name)) !== null) {
                return ret;
              }
              ret = jQuery.find.attr(elem, name);
              return ret == null ? void 0 : ret;
            },
            attrHooks: {
              type: {
                set: function(elem, value) {
                  if (!support.radioValue && value === "radio" && nodeName(elem, "input")) {
                    var val = elem.value;
                    elem.setAttribute("type", value);
                    if (val) {
                      elem.value = val;
                    }
                    return value;
                  }
                }
              }
            },
            removeAttr: function(elem, value) {
              var name, i2 = 0, attrNames = value && value.match(rnothtmlwhite);
              if (attrNames && elem.nodeType === 1) {
                while (name = attrNames[i2++]) {
                  elem.removeAttribute(name);
                }
              }
            }
          });
          boolHook = {
            set: function(elem, value, name) {
              if (value === false) {
                jQuery.removeAttr(elem, name);
              } else {
                elem.setAttribute(name, name);
              }
              return name;
            }
          };
          jQuery.each(jQuery.expr.match.bool.source.match(/\w+/g), function(_i, name) {
            var getter = attrHandle[name] || jQuery.find.attr;
            attrHandle[name] = function(elem, name2, isXML) {
              var ret, handle, lowercaseName = name2.toLowerCase();
              if (!isXML) {
                handle = attrHandle[lowercaseName];
                attrHandle[lowercaseName] = ret;
                ret = getter(elem, name2, isXML) != null ? lowercaseName : null;
                attrHandle[lowercaseName] = handle;
              }
              return ret;
            };
          });
          var rfocusable = /^(?:input|select|textarea|button)$/i, rclickable = /^(?:a|area)$/i;
          jQuery.fn.extend({
            prop: function(name, value) {
              return access(this, jQuery.prop, name, value, arguments.length > 1);
            },
            removeProp: function(name) {
              return this.each(function() {
                delete this[jQuery.propFix[name] || name];
              });
            }
          });
          jQuery.extend({
            prop: function(elem, name, value) {
              var ret, hooks, nType = elem.nodeType;
              if (nType === 3 || nType === 8 || nType === 2) {
                return;
              }
              if (nType !== 1 || !jQuery.isXMLDoc(elem)) {
                name = jQuery.propFix[name] || name;
                hooks = jQuery.propHooks[name];
              }
              if (value !== void 0) {
                if (hooks && "set" in hooks && (ret = hooks.set(elem, value, name)) !== void 0) {
                  return ret;
                }
                return elem[name] = value;
              }
              if (hooks && "get" in hooks && (ret = hooks.get(elem, name)) !== null) {
                return ret;
              }
              return elem[name];
            },
            propHooks: {
              tabIndex: {
                get: function(elem) {
                  var tabindex = jQuery.find.attr(elem, "tabindex");
                  if (tabindex) {
                    return parseInt(tabindex, 10);
                  }
                  if (rfocusable.test(elem.nodeName) || rclickable.test(elem.nodeName) && elem.href) {
                    return 0;
                  }
                  return -1;
                }
              }
            },
            propFix: {
              "for": "htmlFor",
              "class": "className"
            }
          });
          if (!support.optSelected) {
            jQuery.propHooks.selected = {
              get: function(elem) {
                var parent = elem.parentNode;
                if (parent && parent.parentNode) {
                  parent.parentNode.selectedIndex;
                }
                return null;
              },
              set: function(elem) {
                var parent = elem.parentNode;
                if (parent) {
                  parent.selectedIndex;
                  if (parent.parentNode) {
                    parent.parentNode.selectedIndex;
                  }
                }
              }
            };
          }
          jQuery.each([
            "tabIndex",
            "readOnly",
            "maxLength",
            "cellSpacing",
            "cellPadding",
            "rowSpan",
            "colSpan",
            "useMap",
            "frameBorder",
            "contentEditable"
          ], function() {
            jQuery.propFix[this.toLowerCase()] = this;
          });
          function stripAndCollapse(value) {
            var tokens = value.match(rnothtmlwhite) || [];
            return tokens.join(" ");
          }
          function getClass(elem) {
            return elem.getAttribute && elem.getAttribute("class") || "";
          }
          function classesToArray(value) {
            if (Array.isArray(value)) {
              return value;
            }
            if (typeof value === "string") {
              return value.match(rnothtmlwhite) || [];
            }
            return [];
          }
          jQuery.fn.extend({
            addClass: function(value) {
              var classNames, cur, curValue, className, i2, finalValue;
              if (isFunction(value)) {
                return this.each(function(j) {
                  jQuery(this).addClass(value.call(this, j, getClass(this)));
                });
              }
              classNames = classesToArray(value);
              if (classNames.length) {
                return this.each(function() {
                  curValue = getClass(this);
                  cur = this.nodeType === 1 && " " + stripAndCollapse(curValue) + " ";
                  if (cur) {
                    for (i2 = 0; i2 < classNames.length; i2++) {
                      className = classNames[i2];
                      if (cur.indexOf(" " + className + " ") < 0) {
                        cur += className + " ";
                      }
                    }
                    finalValue = stripAndCollapse(cur);
                    if (curValue !== finalValue) {
                      this.setAttribute("class", finalValue);
                    }
                  }
                });
              }
              return this;
            },
            removeClass: function(value) {
              var classNames, cur, curValue, className, i2, finalValue;
              if (isFunction(value)) {
                return this.each(function(j) {
                  jQuery(this).removeClass(value.call(this, j, getClass(this)));
                });
              }
              if (!arguments.length) {
                return this.attr("class", "");
              }
              classNames = classesToArray(value);
              if (classNames.length) {
                return this.each(function() {
                  curValue = getClass(this);
                  cur = this.nodeType === 1 && " " + stripAndCollapse(curValue) + " ";
                  if (cur) {
                    for (i2 = 0; i2 < classNames.length; i2++) {
                      className = classNames[i2];
                      while (cur.indexOf(" " + className + " ") > -1) {
                        cur = cur.replace(" " + className + " ", " ");
                      }
                    }
                    finalValue = stripAndCollapse(cur);
                    if (curValue !== finalValue) {
                      this.setAttribute("class", finalValue);
                    }
                  }
                });
              }
              return this;
            },
            toggleClass: function(value, stateVal) {
              var classNames, className, i2, self, type = typeof value, isValidValue = type === "string" || Array.isArray(value);
              if (isFunction(value)) {
                return this.each(function(i3) {
                  jQuery(this).toggleClass(
                    value.call(this, i3, getClass(this), stateVal),
                    stateVal
                  );
                });
              }
              if (typeof stateVal === "boolean" && isValidValue) {
                return stateVal ? this.addClass(value) : this.removeClass(value);
              }
              classNames = classesToArray(value);
              return this.each(function() {
                if (isValidValue) {
                  self = jQuery(this);
                  for (i2 = 0; i2 < classNames.length; i2++) {
                    className = classNames[i2];
                    if (self.hasClass(className)) {
                      self.removeClass(className);
                    } else {
                      self.addClass(className);
                    }
                  }
                } else if (value === void 0 || type === "boolean") {
                  className = getClass(this);
                  if (className) {
                    dataPriv.set(this, "__className__", className);
                  }
                  if (this.setAttribute) {
                    this.setAttribute(
                      "class",
                      className || value === false ? "" : dataPriv.get(this, "__className__") || ""
                    );
                  }
                }
              });
            },
            hasClass: function(selector) {
              var className, elem, i2 = 0;
              className = " " + selector + " ";
              while (elem = this[i2++]) {
                if (elem.nodeType === 1 && (" " + stripAndCollapse(getClass(elem)) + " ").indexOf(className) > -1) {
                  return true;
                }
              }
              return false;
            }
          });
          var rreturn = /\r/g;
          jQuery.fn.extend({
            val: function(value) {
              var hooks, ret, valueIsFunction, elem = this[0];
              if (!arguments.length) {
                if (elem) {
                  hooks = jQuery.valHooks[elem.type] || jQuery.valHooks[elem.nodeName.toLowerCase()];
                  if (hooks && "get" in hooks && (ret = hooks.get(elem, "value")) !== void 0) {
                    return ret;
                  }
                  ret = elem.value;
                  if (typeof ret === "string") {
                    return ret.replace(rreturn, "");
                  }
                  return ret == null ? "" : ret;
                }
                return;
              }
              valueIsFunction = isFunction(value);
              return this.each(function(i2) {
                var val;
                if (this.nodeType !== 1) {
                  return;
                }
                if (valueIsFunction) {
                  val = value.call(this, i2, jQuery(this).val());
                } else {
                  val = value;
                }
                if (val == null) {
                  val = "";
                } else if (typeof val === "number") {
                  val += "";
                } else if (Array.isArray(val)) {
                  val = jQuery.map(val, function(value2) {
                    return value2 == null ? "" : value2 + "";
                  });
                }
                hooks = jQuery.valHooks[this.type] || jQuery.valHooks[this.nodeName.toLowerCase()];
                if (!hooks || !("set" in hooks) || hooks.set(this, val, "value") === void 0) {
                  this.value = val;
                }
              });
            }
          });
          jQuery.extend({
            valHooks: {
              option: {
                get: function(elem) {
                  var val = jQuery.find.attr(elem, "value");
                  return val != null ? val : (
                    // Support: IE <=10 - 11 only
                    // option.text throws exceptions (trac-14686, trac-14858)
                    // Strip and collapse whitespace
                    // https://html.spec.whatwg.org/#strip-and-collapse-whitespace
                    stripAndCollapse(jQuery.text(elem))
                  );
                }
              },
              select: {
                get: function(elem) {
                  var value, option, i2, options = elem.options, index = elem.selectedIndex, one = elem.type === "select-one", values = one ? null : [], max = one ? index + 1 : options.length;
                  if (index < 0) {
                    i2 = max;
                  } else {
                    i2 = one ? index : 0;
                  }
                  for (; i2 < max; i2++) {
                    option = options[i2];
                    if ((option.selected || i2 === index) && // Don't return options that are disabled or in a disabled optgroup
                    !option.disabled && (!option.parentNode.disabled || !nodeName(option.parentNode, "optgroup"))) {
                      value = jQuery(option).val();
                      if (one) {
                        return value;
                      }
                      values.push(value);
                    }
                  }
                  return values;
                },
                set: function(elem, value) {
                  var optionSet, option, options = elem.options, values = jQuery.makeArray(value), i2 = options.length;
                  while (i2--) {
                    option = options[i2];
                    if (option.selected = jQuery.inArray(jQuery.valHooks.option.get(option), values) > -1) {
                      optionSet = true;
                    }
                  }
                  if (!optionSet) {
                    elem.selectedIndex = -1;
                  }
                  return values;
                }
              }
            }
          });
          jQuery.each(["radio", "checkbox"], function() {
            jQuery.valHooks[this] = {
              set: function(elem, value) {
                if (Array.isArray(value)) {
                  return elem.checked = jQuery.inArray(jQuery(elem).val(), value) > -1;
                }
              }
            };
            if (!support.checkOn) {
              jQuery.valHooks[this].get = function(elem) {
                return elem.getAttribute("value") === null ? "on" : elem.value;
              };
            }
          });
          var location2 = window2.location;
          var nonce = { guid: Date.now() };
          var rquery = /\?/;
          jQuery.parseXML = function(data) {
            var xml, parserErrorElem;
            if (!data || typeof data !== "string") {
              return null;
            }
            try {
              xml = new window2.DOMParser().parseFromString(data, "text/xml");
            } catch (e) {
            }
            parserErrorElem = xml && xml.getElementsByTagName("parsererror")[0];
            if (!xml || parserErrorElem) {
              jQuery.error("Invalid XML: " + (parserErrorElem ? jQuery.map(parserErrorElem.childNodes, function(el) {
                return el.textContent;
              }).join("\n") : data));
            }
            return xml;
          };
          var rfocusMorph = /^(?:focusinfocus|focusoutblur)$/, stopPropagationCallback = function(e) {
            e.stopPropagation();
          };
          jQuery.extend(jQuery.event, {
            trigger: function(event, data, elem, onlyHandlers) {
              var i2, cur, tmp, bubbleType, ontype, handle, special, lastElement, eventPath = [elem || document2], type = hasOwn.call(event, "type") ? event.type : event, namespaces = hasOwn.call(event, "namespace") ? event.namespace.split(".") : [];
              cur = lastElement = tmp = elem = elem || document2;
              if (elem.nodeType === 3 || elem.nodeType === 8) {
                return;
              }
              if (rfocusMorph.test(type + jQuery.event.triggered)) {
                return;
              }
              if (type.indexOf(".") > -1) {
                namespaces = type.split(".");
                type = namespaces.shift();
                namespaces.sort();
              }
              ontype = type.indexOf(":") < 0 && "on" + type;
              event = event[jQuery.expando] ? event : new jQuery.Event(type, typeof event === "object" && event);
              event.isTrigger = onlyHandlers ? 2 : 3;
              event.namespace = namespaces.join(".");
              event.rnamespace = event.namespace ? new RegExp("(^|\\.)" + namespaces.join("\\.(?:.*\\.|)") + "(\\.|$)") : null;
              event.result = void 0;
              if (!event.target) {
                event.target = elem;
              }
              data = data == null ? [event] : jQuery.makeArray(data, [event]);
              special = jQuery.event.special[type] || {};
              if (!onlyHandlers && special.trigger && special.trigger.apply(elem, data) === false) {
                return;
              }
              if (!onlyHandlers && !special.noBubble && !isWindow(elem)) {
                bubbleType = special.delegateType || type;
                if (!rfocusMorph.test(bubbleType + type)) {
                  cur = cur.parentNode;
                }
                for (; cur; cur = cur.parentNode) {
                  eventPath.push(cur);
                  tmp = cur;
                }
                if (tmp === (elem.ownerDocument || document2)) {
                  eventPath.push(tmp.defaultView || tmp.parentWindow || window2);
                }
              }
              i2 = 0;
              while ((cur = eventPath[i2++]) && !event.isPropagationStopped()) {
                lastElement = cur;
                event.type = i2 > 1 ? bubbleType : special.bindType || type;
                handle = (dataPriv.get(cur, "events") || /* @__PURE__ */ Object.create(null))[event.type] && dataPriv.get(cur, "handle");
                if (handle) {
                  handle.apply(cur, data);
                }
                handle = ontype && cur[ontype];
                if (handle && handle.apply && acceptData(cur)) {
                  event.result = handle.apply(cur, data);
                  if (event.result === false) {
                    event.preventDefault();
                  }
                }
              }
              event.type = type;
              if (!onlyHandlers && !event.isDefaultPrevented()) {
                if ((!special._default || special._default.apply(eventPath.pop(), data) === false) && acceptData(elem)) {
                  if (ontype && isFunction(elem[type]) && !isWindow(elem)) {
                    tmp = elem[ontype];
                    if (tmp) {
                      elem[ontype] = null;
                    }
                    jQuery.event.triggered = type;
                    if (event.isPropagationStopped()) {
                      lastElement.addEventListener(type, stopPropagationCallback);
                    }
                    elem[type]();
                    if (event.isPropagationStopped()) {
                      lastElement.removeEventListener(type, stopPropagationCallback);
                    }
                    jQuery.event.triggered = void 0;
                    if (tmp) {
                      elem[ontype] = tmp;
                    }
                  }
                }
              }
              return event.result;
            },
            // Piggyback on a donor event to simulate a different one
            // Used only for `focus(in | out)` events
            simulate: function(type, elem, event) {
              var e = jQuery.extend(
                new jQuery.Event(),
                event,
                {
                  type,
                  isSimulated: true
                }
              );
              jQuery.event.trigger(e, null, elem);
            }
          });
          jQuery.fn.extend({
            trigger: function(type, data) {
              return this.each(function() {
                jQuery.event.trigger(type, data, this);
              });
            },
            triggerHandler: function(type, data) {
              var elem = this[0];
              if (elem) {
                return jQuery.event.trigger(type, data, elem, true);
              }
            }
          });
          var rbracket = /\[\]$/, rCRLF = /\r?\n/g, rsubmitterTypes = /^(?:submit|button|image|reset|file)$/i, rsubmittable = /^(?:input|select|textarea|keygen)/i;
          function buildParams(prefix, obj, traditional, add) {
            var name;
            if (Array.isArray(obj)) {
              jQuery.each(obj, function(i2, v) {
                if (traditional || rbracket.test(prefix)) {
                  add(prefix, v);
                } else {
                  buildParams(
                    prefix + "[" + (typeof v === "object" && v != null ? i2 : "") + "]",
                    v,
                    traditional,
                    add
                  );
                }
              });
            } else if (!traditional && toType(obj) === "object") {
              for (name in obj) {
                buildParams(prefix + "[" + name + "]", obj[name], traditional, add);
              }
            } else {
              add(prefix, obj);
            }
          }
          jQuery.param = function(a, traditional) {
            var prefix, s = [], add = function(key2, valueOrFunction) {
              var value = isFunction(valueOrFunction) ? valueOrFunction() : valueOrFunction;
              s[s.length] = encodeURIComponent(key2) + "=" + encodeURIComponent(value == null ? "" : value);
            };
            if (a == null) {
              return "";
            }
            if (Array.isArray(a) || a.jquery && !jQuery.isPlainObject(a)) {
              jQuery.each(a, function() {
                add(this.name, this.value);
              });
            } else {
              for (prefix in a) {
                buildParams(prefix, a[prefix], traditional, add);
              }
            }
            return s.join("&");
          };
          jQuery.fn.extend({
            serialize: function() {
              return jQuery.param(this.serializeArray());
            },
            serializeArray: function() {
              return this.map(function() {
                var elements = jQuery.prop(this, "elements");
                return elements ? jQuery.makeArray(elements) : this;
              }).filter(function() {
                var type = this.type;
                return this.name && !jQuery(this).is(":disabled") && rsubmittable.test(this.nodeName) && !rsubmitterTypes.test(type) && (this.checked || !rcheckableType.test(type));
              }).map(function(_i, elem) {
                var val = jQuery(this).val();
                if (val == null) {
                  return null;
                }
                if (Array.isArray(val)) {
                  return jQuery.map(val, function(val2) {
                    return { name: elem.name, value: val2.replace(rCRLF, "\r\n") };
                  });
                }
                return { name: elem.name, value: val.replace(rCRLF, "\r\n") };
              }).get();
            }
          });
          var r20 = /%20/g, rhash = /#.*$/, rantiCache = /([?&])_=[^&]*/, rheaders = /^(.*?):[ \t]*([^\r\n]*)$/mg, rlocalProtocol = /^(?:about|app|app-storage|.+-extension|file|res|widget):$/, rnoContent = /^(?:GET|HEAD)$/, rprotocol = /^\/\//, prefilters = {}, transports = {}, allTypes = "*/".concat("*"), originAnchor = document2.createElement("a");
          originAnchor.href = location2.href;
          function addToPrefiltersOrTransports(structure) {
            return function(dataTypeExpression, func) {
              if (typeof dataTypeExpression !== "string") {
                func = dataTypeExpression;
                dataTypeExpression = "*";
              }
              var dataType, i2 = 0, dataTypes = dataTypeExpression.toLowerCase().match(rnothtmlwhite) || [];
              if (isFunction(func)) {
                while (dataType = dataTypes[i2++]) {
                  if (dataType[0] === "+") {
                    dataType = dataType.slice(1) || "*";
                    (structure[dataType] = structure[dataType] || []).unshift(func);
                  } else {
                    (structure[dataType] = structure[dataType] || []).push(func);
                  }
                }
              }
            };
          }
          function inspectPrefiltersOrTransports(structure, options, originalOptions, jqXHR) {
            var inspected = {}, seekingTransport = structure === transports;
            function inspect(dataType) {
              var selected;
              inspected[dataType] = true;
              jQuery.each(structure[dataType] || [], function(_, prefilterOrFactory) {
                var dataTypeOrTransport = prefilterOrFactory(options, originalOptions, jqXHR);
                if (typeof dataTypeOrTransport === "string" && !seekingTransport && !inspected[dataTypeOrTransport]) {
                  options.dataTypes.unshift(dataTypeOrTransport);
                  inspect(dataTypeOrTransport);
                  return false;
                } else if (seekingTransport) {
                  return !(selected = dataTypeOrTransport);
                }
              });
              return selected;
            }
            return inspect(options.dataTypes[0]) || !inspected["*"] && inspect("*");
          }
          function ajaxExtend(target, src) {
            var key2, deep, flatOptions = jQuery.ajaxSettings.flatOptions || {};
            for (key2 in src) {
              if (src[key2] !== void 0) {
                (flatOptions[key2] ? target : deep || (deep = {}))[key2] = src[key2];
              }
            }
            if (deep) {
              jQuery.extend(true, target, deep);
            }
            return target;
          }
          function ajaxHandleResponses(s, jqXHR, responses) {
            var ct, type, finalDataType, firstDataType, contents = s.contents, dataTypes = s.dataTypes;
            while (dataTypes[0] === "*") {
              dataTypes.shift();
              if (ct === void 0) {
                ct = s.mimeType || jqXHR.getResponseHeader("Content-Type");
              }
            }
            if (ct) {
              for (type in contents) {
                if (contents[type] && contents[type].test(ct)) {
                  dataTypes.unshift(type);
                  break;
                }
              }
            }
            if (dataTypes[0] in responses) {
              finalDataType = dataTypes[0];
            } else {
              for (type in responses) {
                if (!dataTypes[0] || s.converters[type + " " + dataTypes[0]]) {
                  finalDataType = type;
                  break;
                }
                if (!firstDataType) {
                  firstDataType = type;
                }
              }
              finalDataType = finalDataType || firstDataType;
            }
            if (finalDataType) {
              if (finalDataType !== dataTypes[0]) {
                dataTypes.unshift(finalDataType);
              }
              return responses[finalDataType];
            }
          }
          function ajaxConvert(s, response, jqXHR, isSuccess) {
            var conv2, current, conv, tmp, prev, converters = {}, dataTypes = s.dataTypes.slice();
            if (dataTypes[1]) {
              for (conv in s.converters) {
                converters[conv.toLowerCase()] = s.converters[conv];
              }
            }
            current = dataTypes.shift();
            while (current) {
              if (s.responseFields[current]) {
                jqXHR[s.responseFields[current]] = response;
              }
              if (!prev && isSuccess && s.dataFilter) {
                response = s.dataFilter(response, s.dataType);
              }
              prev = current;
              current = dataTypes.shift();
              if (current) {
                if (current === "*") {
                  current = prev;
                } else if (prev !== "*" && prev !== current) {
                  conv = converters[prev + " " + current] || converters["* " + current];
                  if (!conv) {
                    for (conv2 in converters) {
                      tmp = conv2.split(" ");
                      if (tmp[1] === current) {
                        conv = converters[prev + " " + tmp[0]] || converters["* " + tmp[0]];
                        if (conv) {
                          if (conv === true) {
                            conv = converters[conv2];
                          } else if (converters[conv2] !== true) {
                            current = tmp[0];
                            dataTypes.unshift(tmp[1]);
                          }
                          break;
                        }
                      }
                    }
                  }
                  if (conv !== true) {
                    if (conv && s.throws) {
                      response = conv(response);
                    } else {
                      try {
                        response = conv(response);
                      } catch (e) {
                        return {
                          state: "parsererror",
                          error: conv ? e : "No conversion from " + prev + " to " + current
                        };
                      }
                    }
                  }
                }
              }
            }
            return { state: "success", data: response };
          }
          jQuery.extend({
            // Counter for holding the number of active queries
            active: 0,
            // Last-Modified header cache for next request
            lastModified: {},
            etag: {},
            ajaxSettings: {
              url: location2.href,
              type: "GET",
              isLocal: rlocalProtocol.test(location2.protocol),
              global: true,
              processData: true,
              async: true,
              contentType: "application/x-www-form-urlencoded; charset=UTF-8",
              /*
              timeout: 0,
              data: null,
              dataType: null,
              username: null,
              password: null,
              cache: null,
              throws: false,
              traditional: false,
              headers: {},
              */
              accepts: {
                "*": allTypes,
                text: "text/plain",
                html: "text/html",
                xml: "application/xml, text/xml",
                json: "application/json, text/javascript"
              },
              contents: {
                xml: /\bxml\b/,
                html: /\bhtml/,
                json: /\bjson\b/
              },
              responseFields: {
                xml: "responseXML",
                text: "responseText",
                json: "responseJSON"
              },
              // Data converters
              // Keys separate source (or catchall "*") and destination types with a single space
              converters: {
                // Convert anything to text
                "* text": String,
                // Text to html (true = no transformation)
                "text html": true,
                // Evaluate text as a json expression
                "text json": JSON.parse,
                // Parse text as xml
                "text xml": jQuery.parseXML
              },
              // For options that shouldn't be deep extended:
              // you can add your own custom options here if
              // and when you create one that shouldn't be
              // deep extended (see ajaxExtend)
              flatOptions: {
                url: true,
                context: true
              }
            },
            // Creates a full fledged settings object into target
            // with both ajaxSettings and settings fields.
            // If target is omitted, writes into ajaxSettings.
            ajaxSetup: function(target, settings) {
              return settings ? (
                // Building a settings object
                ajaxExtend(ajaxExtend(target, jQuery.ajaxSettings), settings)
              ) : (
                // Extending ajaxSettings
                ajaxExtend(jQuery.ajaxSettings, target)
              );
            },
            ajaxPrefilter: addToPrefiltersOrTransports(prefilters),
            ajaxTransport: addToPrefiltersOrTransports(transports),
            // Main method
            ajax: function(url, options) {
              if (typeof url === "object") {
                options = url;
                url = void 0;
              }
              options = options || {};
              var transport, cacheURL, responseHeadersString, responseHeaders, timeoutTimer, urlAnchor, completed2, fireGlobals, i2, uncached, s = jQuery.ajaxSetup({}, options), callbackContext = s.context || s, globalEventContext = s.context && (callbackContext.nodeType || callbackContext.jquery) ? jQuery(callbackContext) : jQuery.event, deferred = jQuery.Deferred(), completeDeferred = jQuery.Callbacks("once memory"), statusCode = s.statusCode || {}, requestHeaders = {}, requestHeadersNames = {}, strAbort = "canceled", jqXHR = {
                readyState: 0,
                // Builds headers hashtable if needed
                getResponseHeader: function(key2) {
                  var match;
                  if (completed2) {
                    if (!responseHeaders) {
                      responseHeaders = {};
                      while (match = rheaders.exec(responseHeadersString)) {
                        responseHeaders[match[1].toLowerCase() + " "] = (responseHeaders[match[1].toLowerCase() + " "] || []).concat(match[2]);
                      }
                    }
                    match = responseHeaders[key2.toLowerCase() + " "];
                  }
                  return match == null ? null : match.join(", ");
                },
                // Raw string
                getAllResponseHeaders: function() {
                  return completed2 ? responseHeadersString : null;
                },
                // Caches the header
                setRequestHeader: function(name, value) {
                  if (completed2 == null) {
                    name = requestHeadersNames[name.toLowerCase()] = requestHeadersNames[name.toLowerCase()] || name;
                    requestHeaders[name] = value;
                  }
                  return this;
                },
                // Overrides response content-type header
                overrideMimeType: function(type) {
                  if (completed2 == null) {
                    s.mimeType = type;
                  }
                  return this;
                },
                // Status-dependent callbacks
                statusCode: function(map) {
                  var code;
                  if (map) {
                    if (completed2) {
                      jqXHR.always(map[jqXHR.status]);
                    } else {
                      for (code in map) {
                        statusCode[code] = [statusCode[code], map[code]];
                      }
                    }
                  }
                  return this;
                },
                // Cancel the request
                abort: function(statusText) {
                  var finalText = statusText || strAbort;
                  if (transport) {
                    transport.abort(finalText);
                  }
                  done(0, finalText);
                  return this;
                }
              };
              deferred.promise(jqXHR);
              s.url = ((url || s.url || location2.href) + "").replace(rprotocol, location2.protocol + "//");
              s.type = options.method || options.type || s.method || s.type;
              s.dataTypes = (s.dataType || "*").toLowerCase().match(rnothtmlwhite) || [""];
              if (s.crossDomain == null) {
                urlAnchor = document2.createElement("a");
                try {
                  urlAnchor.href = s.url;
                  urlAnchor.href = urlAnchor.href;
                  s.crossDomain = originAnchor.protocol + "//" + originAnchor.host !== urlAnchor.protocol + "//" + urlAnchor.host;
                } catch (e) {
                  s.crossDomain = true;
                }
              }
              if (s.data && s.processData && typeof s.data !== "string") {
                s.data = jQuery.param(s.data, s.traditional);
              }
              inspectPrefiltersOrTransports(prefilters, s, options, jqXHR);
              if (completed2) {
                return jqXHR;
              }
              fireGlobals = jQuery.event && s.global;
              if (fireGlobals && jQuery.active++ === 0) {
                jQuery.event.trigger("ajaxStart");
              }
              s.type = s.type.toUpperCase();
              s.hasContent = !rnoContent.test(s.type);
              cacheURL = s.url.replace(rhash, "");
              if (!s.hasContent) {
                uncached = s.url.slice(cacheURL.length);
                if (s.data && (s.processData || typeof s.data === "string")) {
                  cacheURL += (rquery.test(cacheURL) ? "&" : "?") + s.data;
                  delete s.data;
                }
                if (s.cache === false) {
                  cacheURL = cacheURL.replace(rantiCache, "$1");
                  uncached = (rquery.test(cacheURL) ? "&" : "?") + "_=" + nonce.guid++ + uncached;
                }
                s.url = cacheURL + uncached;
              } else if (s.data && s.processData && (s.contentType || "").indexOf("application/x-www-form-urlencoded") === 0) {
                s.data = s.data.replace(r20, "+");
              }
              if (s.ifModified) {
                if (jQuery.lastModified[cacheURL]) {
                  jqXHR.setRequestHeader("If-Modified-Since", jQuery.lastModified[cacheURL]);
                }
                if (jQuery.etag[cacheURL]) {
                  jqXHR.setRequestHeader("If-None-Match", jQuery.etag[cacheURL]);
                }
              }
              if (s.data && s.hasContent && s.contentType !== false || options.contentType) {
                jqXHR.setRequestHeader("Content-Type", s.contentType);
              }
              jqXHR.setRequestHeader(
                "Accept",
                s.dataTypes[0] && s.accepts[s.dataTypes[0]] ? s.accepts[s.dataTypes[0]] + (s.dataTypes[0] !== "*" ? ", " + allTypes + "; q=0.01" : "") : s.accepts["*"]
              );
              for (i2 in s.headers) {
                jqXHR.setRequestHeader(i2, s.headers[i2]);
              }
              if (s.beforeSend && (s.beforeSend.call(callbackContext, jqXHR, s) === false || completed2)) {
                return jqXHR.abort();
              }
              strAbort = "abort";
              completeDeferred.add(s.complete);
              jqXHR.done(s.success);
              jqXHR.fail(s.error);
              transport = inspectPrefiltersOrTransports(transports, s, options, jqXHR);
              if (!transport) {
                done(-1, "No Transport");
              } else {
                jqXHR.readyState = 1;
                if (fireGlobals) {
                  globalEventContext.trigger("ajaxSend", [jqXHR, s]);
                }
                if (completed2) {
                  return jqXHR;
                }
                if (s.async && s.timeout > 0) {
                  timeoutTimer = window2.setTimeout(function() {
                    jqXHR.abort("timeout");
                  }, s.timeout);
                }
                try {
                  completed2 = false;
                  transport.send(requestHeaders, done);
                } catch (e) {
                  if (completed2) {
                    throw e;
                  }
                  done(-1, e);
                }
              }
              function done(status, nativeStatusText, responses, headers) {
                var isSuccess, success, error, response, modified, statusText = nativeStatusText;
                if (completed2) {
                  return;
                }
                completed2 = true;
                if (timeoutTimer) {
                  window2.clearTimeout(timeoutTimer);
                }
                transport = void 0;
                responseHeadersString = headers || "";
                jqXHR.readyState = status > 0 ? 4 : 0;
                isSuccess = status >= 200 && status < 300 || status === 304;
                if (responses) {
                  response = ajaxHandleResponses(s, jqXHR, responses);
                }
                if (!isSuccess && jQuery.inArray("script", s.dataTypes) > -1 && jQuery.inArray("json", s.dataTypes) < 0) {
                  s.converters["text script"] = function() {
                  };
                }
                response = ajaxConvert(s, response, jqXHR, isSuccess);
                if (isSuccess) {
                  if (s.ifModified) {
                    modified = jqXHR.getResponseHeader("Last-Modified");
                    if (modified) {
                      jQuery.lastModified[cacheURL] = modified;
                    }
                    modified = jqXHR.getResponseHeader("etag");
                    if (modified) {
                      jQuery.etag[cacheURL] = modified;
                    }
                  }
                  if (status === 204 || s.type === "HEAD") {
                    statusText = "nocontent";
                  } else if (status === 304) {
                    statusText = "notmodified";
                  } else {
                    statusText = response.state;
                    success = response.data;
                    error = response.error;
                    isSuccess = !error;
                  }
                } else {
                  error = statusText;
                  if (status || !statusText) {
                    statusText = "error";
                    if (status < 0) {
                      status = 0;
                    }
                  }
                }
                jqXHR.status = status;
                jqXHR.statusText = (nativeStatusText || statusText) + "";
                if (isSuccess) {
                  deferred.resolveWith(callbackContext, [success, statusText, jqXHR]);
                } else {
                  deferred.rejectWith(callbackContext, [jqXHR, statusText, error]);
                }
                jqXHR.statusCode(statusCode);
                statusCode = void 0;
                if (fireGlobals) {
                  globalEventContext.trigger(
                    isSuccess ? "ajaxSuccess" : "ajaxError",
                    [jqXHR, s, isSuccess ? success : error]
                  );
                }
                completeDeferred.fireWith(callbackContext, [jqXHR, statusText]);
                if (fireGlobals) {
                  globalEventContext.trigger("ajaxComplete", [jqXHR, s]);
                  if (!--jQuery.active) {
                    jQuery.event.trigger("ajaxStop");
                  }
                }
              }
              return jqXHR;
            },
            getJSON: function(url, data, callback) {
              return jQuery.get(url, data, callback, "json");
            },
            getScript: function(url, callback) {
              return jQuery.get(url, void 0, callback, "script");
            }
          });
          jQuery.each(["get", "post"], function(_i, method) {
            jQuery[method] = function(url, data, callback, type) {
              if (isFunction(data)) {
                type = type || callback;
                callback = data;
                data = void 0;
              }
              return jQuery.ajax(jQuery.extend({
                url,
                type: method,
                dataType: type,
                data,
                success: callback
              }, jQuery.isPlainObject(url) && url));
            };
          });
          jQuery.ajaxPrefilter(function(s) {
            var i2;
            for (i2 in s.headers) {
              if (i2.toLowerCase() === "content-type") {
                s.contentType = s.headers[i2] || "";
              }
            }
          });
          jQuery._evalUrl = function(url, options, doc) {
            return jQuery.ajax({
              url,
              // Make this explicit, since user can override this through ajaxSetup (trac-11264)
              type: "GET",
              dataType: "script",
              cache: true,
              async: false,
              global: false,
              // Only evaluate the response if it is successful (gh-4126)
              // dataFilter is not invoked for failure responses, so using it instead
              // of the default converter is kludgy but it works.
              converters: {
                "text script": function() {
                }
              },
              dataFilter: function(response) {
                jQuery.globalEval(response, options, doc);
              }
            });
          };
          jQuery.fn.extend({
            wrapAll: function(html) {
              var wrap;
              if (this[0]) {
                if (isFunction(html)) {
                  html = html.call(this[0]);
                }
                wrap = jQuery(html, this[0].ownerDocument).eq(0).clone(true);
                if (this[0].parentNode) {
                  wrap.insertBefore(this[0]);
                }
                wrap.map(function() {
                  var elem = this;
                  while (elem.firstElementChild) {
                    elem = elem.firstElementChild;
                  }
                  return elem;
                }).append(this);
              }
              return this;
            },
            wrapInner: function(html) {
              if (isFunction(html)) {
                return this.each(function(i2) {
                  jQuery(this).wrapInner(html.call(this, i2));
                });
              }
              return this.each(function() {
                var self = jQuery(this), contents = self.contents();
                if (contents.length) {
                  contents.wrapAll(html);
                } else {
                  self.append(html);
                }
              });
            },
            wrap: function(html) {
              var htmlIsFunction = isFunction(html);
              return this.each(function(i2) {
                jQuery(this).wrapAll(htmlIsFunction ? html.call(this, i2) : html);
              });
            },
            unwrap: function(selector) {
              this.parent(selector).not("body").each(function() {
                jQuery(this).replaceWith(this.childNodes);
              });
              return this;
            }
          });
          jQuery.expr.pseudos.hidden = function(elem) {
            return !jQuery.expr.pseudos.visible(elem);
          };
          jQuery.expr.pseudos.visible = function(elem) {
            return !!(elem.offsetWidth || elem.offsetHeight || elem.getClientRects().length);
          };
          jQuery.ajaxSettings.xhr = function() {
            try {
              return new window2.XMLHttpRequest();
            } catch (e) {
            }
          };
          var xhrSuccessStatus = {
            // File protocol always yields status code 0, assume 200
            0: 200,
            // Support: IE <=9 only
            // trac-1450: sometimes IE returns 1223 when it should be 204
            1223: 204
          }, xhrSupported = jQuery.ajaxSettings.xhr();
          support.cors = !!xhrSupported && "withCredentials" in xhrSupported;
          support.ajax = xhrSupported = !!xhrSupported;
          jQuery.ajaxTransport(function(options) {
            var callback, errorCallback;
            if (support.cors || xhrSupported && !options.crossDomain) {
              return {
                send: function(headers, complete) {
                  var i2, xhr = options.xhr();
                  xhr.open(
                    options.type,
                    options.url,
                    options.async,
                    options.username,
                    options.password
                  );
                  if (options.xhrFields) {
                    for (i2 in options.xhrFields) {
                      xhr[i2] = options.xhrFields[i2];
                    }
                  }
                  if (options.mimeType && xhr.overrideMimeType) {
                    xhr.overrideMimeType(options.mimeType);
                  }
                  if (!options.crossDomain && !headers["X-Requested-With"]) {
                    headers["X-Requested-With"] = "XMLHttpRequest";
                  }
                  for (i2 in headers) {
                    xhr.setRequestHeader(i2, headers[i2]);
                  }
                  callback = function(type) {
                    return function() {
                      if (callback) {
                        callback = errorCallback = xhr.onload = xhr.onerror = xhr.onabort = xhr.ontimeout = xhr.onreadystatechange = null;
                        if (type === "abort") {
                          xhr.abort();
                        } else if (type === "error") {
                          if (typeof xhr.status !== "number") {
                            complete(0, "error");
                          } else {
                            complete(
                              // File: protocol always yields status 0; see trac-8605, trac-14207
                              xhr.status,
                              xhr.statusText
                            );
                          }
                        } else {
                          complete(
                            xhrSuccessStatus[xhr.status] || xhr.status,
                            xhr.statusText,
                            // Support: IE <=9 only
                            // IE9 has no XHR2 but throws on binary (trac-11426)
                            // For XHR2 non-text, let the caller handle it (gh-2498)
                            (xhr.responseType || "text") !== "text" || typeof xhr.responseText !== "string" ? { binary: xhr.response } : { text: xhr.responseText },
                            xhr.getAllResponseHeaders()
                          );
                        }
                      }
                    };
                  };
                  xhr.onload = callback();
                  errorCallback = xhr.onerror = xhr.ontimeout = callback("error");
                  if (xhr.onabort !== void 0) {
                    xhr.onabort = errorCallback;
                  } else {
                    xhr.onreadystatechange = function() {
                      if (xhr.readyState === 4) {
                        window2.setTimeout(function() {
                          if (callback) {
                            errorCallback();
                          }
                        });
                      }
                    };
                  }
                  callback = callback("abort");
                  try {
                    xhr.send(options.hasContent && options.data || null);
                  } catch (e) {
                    if (callback) {
                      throw e;
                    }
                  }
                },
                abort: function() {
                  if (callback) {
                    callback();
                  }
                }
              };
            }
          });
          jQuery.ajaxPrefilter(function(s) {
            if (s.crossDomain) {
              s.contents.script = false;
            }
          });
          jQuery.ajaxSetup({
            accepts: {
              script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"
            },
            contents: {
              script: /\b(?:java|ecma)script\b/
            },
            converters: {
              "text script": function(text) {
                jQuery.globalEval(text);
                return text;
              }
            }
          });
          jQuery.ajaxPrefilter("script", function(s) {
            if (s.cache === void 0) {
              s.cache = false;
            }
            if (s.crossDomain) {
              s.type = "GET";
            }
          });
          jQuery.ajaxTransport("script", function(s) {
            if (s.crossDomain || s.scriptAttrs) {
              var script, callback;
              return {
                send: function(_, complete) {
                  script = jQuery("<script>").attr(s.scriptAttrs || {}).prop({ charset: s.scriptCharset, src: s.url }).on("load error", callback = function(evt) {
                    script.remove();
                    callback = null;
                    if (evt) {
                      complete(evt.type === "error" ? 404 : 200, evt.type);
                    }
                  });
                  document2.head.appendChild(script[0]);
                },
                abort: function() {
                  if (callback) {
                    callback();
                  }
                }
              };
            }
          });
          var oldCallbacks = [], rjsonp = /(=)\?(?=&|$)|\?\?/;
          jQuery.ajaxSetup({
            jsonp: "callback",
            jsonpCallback: function() {
              var callback = oldCallbacks.pop() || jQuery.expando + "_" + nonce.guid++;
              this[callback] = true;
              return callback;
            }
          });
          jQuery.ajaxPrefilter("json jsonp", function(s, originalSettings, jqXHR) {
            var callbackName, overwritten, responseContainer, jsonProp = s.jsonp !== false && (rjsonp.test(s.url) ? "url" : typeof s.data === "string" && (s.contentType || "").indexOf("application/x-www-form-urlencoded") === 0 && rjsonp.test(s.data) && "data");
            if (jsonProp || s.dataTypes[0] === "jsonp") {
              callbackName = s.jsonpCallback = isFunction(s.jsonpCallback) ? s.jsonpCallback() : s.jsonpCallback;
              if (jsonProp) {
                s[jsonProp] = s[jsonProp].replace(rjsonp, "$1" + callbackName);
              } else if (s.jsonp !== false) {
                s.url += (rquery.test(s.url) ? "&" : "?") + s.jsonp + "=" + callbackName;
              }
              s.converters["script json"] = function() {
                if (!responseContainer) {
                  jQuery.error(callbackName + " was not called");
                }
                return responseContainer[0];
              };
              s.dataTypes[0] = "json";
              overwritten = window2[callbackName];
              window2[callbackName] = function() {
                responseContainer = arguments;
              };
              jqXHR.always(function() {
                if (overwritten === void 0) {
                  jQuery(window2).removeProp(callbackName);
                } else {
                  window2[callbackName] = overwritten;
                }
                if (s[callbackName]) {
                  s.jsonpCallback = originalSettings.jsonpCallback;
                  oldCallbacks.push(callbackName);
                }
                if (responseContainer && isFunction(overwritten)) {
                  overwritten(responseContainer[0]);
                }
                responseContainer = overwritten = void 0;
              });
              return "script";
            }
          });
          support.createHTMLDocument = (function() {
            var body = document2.implementation.createHTMLDocument("").body;
            body.innerHTML = "<form></form><form></form>";
            return body.childNodes.length === 2;
          })();
          jQuery.parseHTML = function(data, context, keepScripts) {
            if (typeof data !== "string") {
              return [];
            }
            if (typeof context === "boolean") {
              keepScripts = context;
              context = false;
            }
            var base, parsed, scripts;
            if (!context) {
              if (support.createHTMLDocument) {
                context = document2.implementation.createHTMLDocument("");
                base = context.createElement("base");
                base.href = document2.location.href;
                context.head.appendChild(base);
              } else {
                context = document2;
              }
            }
            parsed = rsingleTag.exec(data);
            scripts = !keepScripts && [];
            if (parsed) {
              return [context.createElement(parsed[1])];
            }
            parsed = buildFragment([data], context, scripts);
            if (scripts && scripts.length) {
              jQuery(scripts).remove();
            }
            return jQuery.merge([], parsed.childNodes);
          };
          jQuery.fn.load = function(url, params, callback) {
            var selector, type, response, self = this, off = url.indexOf(" ");
            if (off > -1) {
              selector = stripAndCollapse(url.slice(off));
              url = url.slice(0, off);
            }
            if (isFunction(params)) {
              callback = params;
              params = void 0;
            } else if (params && typeof params === "object") {
              type = "POST";
            }
            if (self.length > 0) {
              jQuery.ajax({
                url,
                // If "type" variable is undefined, then "GET" method will be used.
                // Make value of this field explicit since
                // user can override it through ajaxSetup method
                type: type || "GET",
                dataType: "html",
                data: params
              }).done(function(responseText) {
                response = arguments;
                self.html(selector ? (
                  // If a selector was specified, locate the right elements in a dummy div
                  // Exclude scripts to avoid IE 'Permission Denied' errors
                  jQuery("<div>").append(jQuery.parseHTML(responseText)).find(selector)
                ) : (
                  // Otherwise use the full result
                  responseText
                ));
              }).always(callback && function(jqXHR, status) {
                self.each(function() {
                  callback.apply(this, response || [jqXHR.responseText, status, jqXHR]);
                });
              });
            }
            return this;
          };
          jQuery.expr.pseudos.animated = function(elem) {
            return jQuery.grep(jQuery.timers, function(fn) {
              return elem === fn.elem;
            }).length;
          };
          jQuery.offset = {
            setOffset: function(elem, options, i2) {
              var curPosition, curLeft, curCSSTop, curTop, curOffset, curCSSLeft, calculatePosition, position = jQuery.css(elem, "position"), curElem = jQuery(elem), props = {};
              if (position === "static") {
                elem.style.position = "relative";
              }
              curOffset = curElem.offset();
              curCSSTop = jQuery.css(elem, "top");
              curCSSLeft = jQuery.css(elem, "left");
              calculatePosition = (position === "absolute" || position === "fixed") && (curCSSTop + curCSSLeft).indexOf("auto") > -1;
              if (calculatePosition) {
                curPosition = curElem.position();
                curTop = curPosition.top;
                curLeft = curPosition.left;
              } else {
                curTop = parseFloat(curCSSTop) || 0;
                curLeft = parseFloat(curCSSLeft) || 0;
              }
              if (isFunction(options)) {
                options = options.call(elem, i2, jQuery.extend({}, curOffset));
              }
              if (options.top != null) {
                props.top = options.top - curOffset.top + curTop;
              }
              if (options.left != null) {
                props.left = options.left - curOffset.left + curLeft;
              }
              if ("using" in options) {
                options.using.call(elem, props);
              } else {
                curElem.css(props);
              }
            }
          };
          jQuery.fn.extend({
            // offset() relates an element's border box to the document origin
            offset: function(options) {
              if (arguments.length) {
                return options === void 0 ? this : this.each(function(i2) {
                  jQuery.offset.setOffset(this, options, i2);
                });
              }
              var rect, win, elem = this[0];
              if (!elem) {
                return;
              }
              if (!elem.getClientRects().length) {
                return { top: 0, left: 0 };
              }
              rect = elem.getBoundingClientRect();
              win = elem.ownerDocument.defaultView;
              return {
                top: rect.top + win.pageYOffset,
                left: rect.left + win.pageXOffset
              };
            },
            // position() relates an element's margin box to its offset parent's padding box
            // This corresponds to the behavior of CSS absolute positioning
            position: function() {
              if (!this[0]) {
                return;
              }
              var offsetParent, offset, doc, elem = this[0], parentOffset = { top: 0, left: 0 };
              if (jQuery.css(elem, "position") === "fixed") {
                offset = elem.getBoundingClientRect();
              } else {
                offset = this.offset();
                doc = elem.ownerDocument;
                offsetParent = elem.offsetParent || doc.documentElement;
                while (offsetParent && (offsetParent === doc.body || offsetParent === doc.documentElement) && jQuery.css(offsetParent, "position") === "static") {
                  offsetParent = offsetParent.parentNode;
                }
                if (offsetParent && offsetParent !== elem && offsetParent.nodeType === 1) {
                  parentOffset = jQuery(offsetParent).offset();
                  parentOffset.top += jQuery.css(offsetParent, "borderTopWidth", true);
                  parentOffset.left += jQuery.css(offsetParent, "borderLeftWidth", true);
                }
              }
              return {
                top: offset.top - parentOffset.top - jQuery.css(elem, "marginTop", true),
                left: offset.left - parentOffset.left - jQuery.css(elem, "marginLeft", true)
              };
            },
            // This method will return documentElement in the following cases:
            // 1) For the element inside the iframe without offsetParent, this method will return
            //    documentElement of the parent window
            // 2) For the hidden or detached element
            // 3) For body or html element, i.e. in case of the html node - it will return itself
            //
            // but those exceptions were never presented as a real life use-cases
            // and might be considered as more preferable results.
            //
            // This logic, however, is not guaranteed and can change at any point in the future
            offsetParent: function() {
              return this.map(function() {
                var offsetParent = this.offsetParent;
                while (offsetParent && jQuery.css(offsetParent, "position") === "static") {
                  offsetParent = offsetParent.offsetParent;
                }
                return offsetParent || documentElement;
              });
            }
          });
          jQuery.each({ scrollLeft: "pageXOffset", scrollTop: "pageYOffset" }, function(method, prop) {
            var top = "pageYOffset" === prop;
            jQuery.fn[method] = function(val) {
              return access(this, function(elem, method2, val2) {
                var win;
                if (isWindow(elem)) {
                  win = elem;
                } else if (elem.nodeType === 9) {
                  win = elem.defaultView;
                }
                if (val2 === void 0) {
                  return win ? win[prop] : elem[method2];
                }
                if (win) {
                  win.scrollTo(
                    !top ? val2 : win.pageXOffset,
                    top ? val2 : win.pageYOffset
                  );
                } else {
                  elem[method2] = val2;
                }
              }, method, val, arguments.length);
            };
          });
          jQuery.each(["top", "left"], function(_i, prop) {
            jQuery.cssHooks[prop] = addGetHookIf(
              support.pixelPosition,
              function(elem, computed) {
                if (computed) {
                  computed = curCSS(elem, prop);
                  return rnumnonpx.test(computed) ? jQuery(elem).position()[prop] + "px" : computed;
                }
              }
            );
          });
          jQuery.each({ Height: "height", Width: "width" }, function(name, type) {
            jQuery.each({
              padding: "inner" + name,
              content: type,
              "": "outer" + name
            }, function(defaultExtra, funcName) {
              jQuery.fn[funcName] = function(margin, value) {
                var chainable = arguments.length && (defaultExtra || typeof margin !== "boolean"), extra = defaultExtra || (margin === true || value === true ? "margin" : "border");
                return access(this, function(elem, type2, value2) {
                  var doc;
                  if (isWindow(elem)) {
                    return funcName.indexOf("outer") === 0 ? elem["inner" + name] : elem.document.documentElement["client" + name];
                  }
                  if (elem.nodeType === 9) {
                    doc = elem.documentElement;
                    return Math.max(
                      elem.body["scroll" + name],
                      doc["scroll" + name],
                      elem.body["offset" + name],
                      doc["offset" + name],
                      doc["client" + name]
                    );
                  }
                  return value2 === void 0 ? (
                    // Get width or height on the element, requesting but not forcing parseFloat
                    jQuery.css(elem, type2, extra)
                  ) : (
                    // Set width or height on the element
                    jQuery.style(elem, type2, value2, extra)
                  );
                }, type, chainable ? margin : void 0, chainable);
              };
            });
          });
          jQuery.each([
            "ajaxStart",
            "ajaxStop",
            "ajaxComplete",
            "ajaxError",
            "ajaxSuccess",
            "ajaxSend"
          ], function(_i, type) {
            jQuery.fn[type] = function(fn) {
              return this.on(type, fn);
            };
          });
          jQuery.fn.extend({
            bind: function(types, data, fn) {
              return this.on(types, null, data, fn);
            },
            unbind: function(types, fn) {
              return this.off(types, null, fn);
            },
            delegate: function(selector, types, data, fn) {
              return this.on(types, selector, data, fn);
            },
            undelegate: function(selector, types, fn) {
              return arguments.length === 1 ? this.off(selector, "**") : this.off(types, selector || "**", fn);
            },
            hover: function(fnOver, fnOut) {
              return this.on("mouseenter", fnOver).on("mouseleave", fnOut || fnOver);
            }
          });
          jQuery.each(
            "blur focus focusin focusout resize scroll click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup contextmenu".split(" "),
            function(_i, name) {
              jQuery.fn[name] = function(data, fn) {
                return arguments.length > 0 ? this.on(name, null, data, fn) : this.trigger(name);
              };
            }
          );
          var rtrim = /^[\s\uFEFF\xA0]+|([^\s\uFEFF\xA0])[\s\uFEFF\xA0]+$/g;
          jQuery.proxy = function(fn, context) {
            var tmp, args, proxy;
            if (typeof context === "string") {
              tmp = fn[context];
              context = fn;
              fn = tmp;
            }
            if (!isFunction(fn)) {
              return void 0;
            }
            args = slice.call(arguments, 2);
            proxy = function() {
              return fn.apply(context || this, args.concat(slice.call(arguments)));
            };
            proxy.guid = fn.guid = fn.guid || jQuery.guid++;
            return proxy;
          };
          jQuery.holdReady = function(hold) {
            if (hold) {
              jQuery.readyWait++;
            } else {
              jQuery.ready(true);
            }
          };
          jQuery.isArray = Array.isArray;
          jQuery.parseJSON = JSON.parse;
          jQuery.nodeName = nodeName;
          jQuery.isFunction = isFunction;
          jQuery.isWindow = isWindow;
          jQuery.camelCase = camelCase;
          jQuery.type = toType;
          jQuery.now = Date.now;
          jQuery.isNumeric = function(obj) {
            var type = jQuery.type(obj);
            return (type === "number" || type === "string") && // parseFloat NaNs numeric-cast false positives ("")
            // ...but misinterprets leading-number strings, particularly hex literals ("0x...")
            // subtraction forces infinities to NaN
            !isNaN(obj - parseFloat(obj));
          };
          jQuery.trim = function(text) {
            return text == null ? "" : (text + "").replace(rtrim, "$1");
          };
          var _jQuery = window2.jQuery, _$ = window2.$;
          jQuery.noConflict = function(deep) {
            if (window2.$ === jQuery) {
              window2.$ = _$;
            }
            if (deep && window2.jQuery === jQuery) {
              window2.jQuery = _jQuery;
            }
            return jQuery;
          };
          if (typeof noGlobal === "undefined") {
            window2.jQuery = window2.$ = jQuery;
          }
          return jQuery;
        });
      })(jquery$1);
      return jquery$1.exports;
    }
    var jqueryExports = requireJquery();
    const $$1 = /* @__PURE__ */ getDefaultExportFromCjs(jqueryExports);
    (function() {
      var t, e, s, i2, n = function(t2, e2) {
        return function() {
          return t2.apply(e2, arguments);
        };
      }, r = function(t2, e2) {
        function s2() {
          this.constructor = t2;
        }
        for (var i3 in e2) o.call(e2, i3) && (t2[i3] = e2[i3]);
        return s2.prototype = e2.prototype, t2.prototype = new s2(), t2.__super__ = e2.prototype, t2;
      }, o = {}.hasOwnProperty;
      (i2 = (function() {
        function t2() {
          this.options_index = 0, this.parsed = [];
        }
        return t2.prototype.add_node = function(t3) {
          return "OPTGROUP" === t3.nodeName.toUpperCase() ? this.add_group(t3) : this.add_option(t3);
        }, t2.prototype.add_group = function(t3) {
          var e2, s2, i3, n2, r2, o2;
          for (e2 = this.parsed.length, this.parsed.push({ array_index: e2, group: true, label: t3.label, title: t3.title ? t3.title : void 0, children: 0, disabled: t3.disabled, classes: t3.className }), o2 = [], s2 = 0, i3 = (r2 = t3.childNodes).length; s2 < i3; s2++) n2 = r2[s2], o2.push(this.add_option(n2, e2, t3.disabled));
          return o2;
        }, t2.prototype.add_option = function(t3, e2, s2) {
          if ("OPTION" === t3.nodeName.toUpperCase()) return "" !== t3.text ? (null != e2 && (this.parsed[e2].children += 1), this.parsed.push({ array_index: this.parsed.length, options_index: this.options_index, value: t3.value, text: t3.text, html: t3.innerHTML, title: t3.title ? t3.title : void 0, selected: t3.selected, disabled: true === s2 ? s2 : t3.disabled, group_array_index: e2, group_label: null != e2 ? this.parsed[e2].label : null, classes: t3.className, style: t3.style.cssText })) : this.parsed.push({ array_index: this.parsed.length, options_index: this.options_index, empty: true }), this.options_index += 1;
        }, t2;
      })()).select_to_array = function(t2) {
        var e2, s2, n2, r2, o2;
        for (r2 = new i2(), s2 = 0, n2 = (o2 = t2.childNodes).length; s2 < n2; s2++) e2 = o2[s2], r2.add_node(e2);
        return r2.parsed;
      }, e = (function() {
        function t2(e2, s2) {
          this.form_field = e2, this.options = null != s2 ? s2 : {}, this.label_click_handler = n(this.label_click_handler, this), t2.browser_is_supported() && (this.is_multiple = this.form_field.multiple, this.set_default_text(), this.set_default_values(), this.setup(), this.set_up_html(), this.register_observers(), this.on_ready());
        }
        return t2.prototype.set_default_values = function() {
          return this.click_test_action = /* @__PURE__ */ (function(t3) {
            return function(e2) {
              return t3.test_active_click(e2);
            };
          })(this), this.activate_action = /* @__PURE__ */ (function(t3) {
            return function(e2) {
              return t3.activate_field(e2);
            };
          })(this), this.active_field = false, this.mouse_on_container = false, this.results_showing = false, this.result_highlighted = null, this.is_rtl = this.options.rtl || /\bchosen-rtl\b/.test(this.form_field.className), this.allow_single_deselect = null != this.options.allow_single_deselect && null != this.form_field.options[0] && "" === this.form_field.options[0].text && this.options.allow_single_deselect, this.disable_search_threshold = this.options.disable_search_threshold || 0, this.disable_search = this.options.disable_search || false, this.enable_split_word_search = null == this.options.enable_split_word_search || this.options.enable_split_word_search, this.group_search = null == this.options.group_search || this.options.group_search, this.search_contains = this.options.search_contains || false, this.single_backstroke_delete = null == this.options.single_backstroke_delete || this.options.single_backstroke_delete, this.max_selected_options = this.options.max_selected_options || Infinity, this.inherit_select_classes = this.options.inherit_select_classes || false, this.display_selected_options = null == this.options.display_selected_options || this.options.display_selected_options, this.display_disabled_options = null == this.options.display_disabled_options || this.options.display_disabled_options, this.include_group_label_in_selected = this.options.include_group_label_in_selected || false, this.max_shown_results = this.options.max_shown_results || Number.POSITIVE_INFINITY, this.case_sensitive_search = this.options.case_sensitive_search || false, this.hide_results_on_select = null == this.options.hide_results_on_select || this.options.hide_results_on_select;
        }, t2.prototype.set_default_text = function() {
          return this.form_field.getAttribute("data-placeholder") ? this.default_text = this.form_field.getAttribute("data-placeholder") : this.is_multiple ? this.default_text = this.options.placeholder_text_multiple || this.options.placeholder_text || t2.default_multiple_text : this.default_text = this.options.placeholder_text_single || this.options.placeholder_text || t2.default_single_text, this.default_text = this.escape_html(this.default_text), this.results_none_found = this.form_field.getAttribute("data-no_results_text") || this.options.no_results_text || t2.default_no_result_text;
        }, t2.prototype.choice_label = function(t3) {
          return this.include_group_label_in_selected && null != t3.group_label ? "<b class='group-name'>" + this.escape_html(t3.group_label) + "</b>" + t3.html : t3.html;
        }, t2.prototype.mouse_enter = function() {
          return this.mouse_on_container = true;
        }, t2.prototype.mouse_leave = function() {
          return this.mouse_on_container = false;
        }, t2.prototype.input_focus = function(t3) {
          if (this.is_multiple) {
            if (!this.active_field) return setTimeout(/* @__PURE__ */ (function(t4) {
              return function() {
                return t4.container_mousedown();
              };
            })(this), 50);
          } else if (!this.active_field) return this.activate_field();
        }, t2.prototype.input_blur = function(t3) {
          if (!this.mouse_on_container) return this.active_field = false, setTimeout(/* @__PURE__ */ (function(t4) {
            return function() {
              return t4.blur_test();
            };
          })(this), 100);
        }, t2.prototype.label_click_handler = function(t3) {
          return this.is_multiple ? this.container_mousedown(t3) : this.activate_field();
        }, t2.prototype.results_option_build = function(t3) {
          var e2, s2, i3, n2, r2, o2, h;
          for (e2 = "", h = 0, n2 = 0, r2 = (o2 = this.results_data).length; n2 < r2 && (s2 = o2[n2], i3 = "", "" !== (i3 = s2.group ? this.result_add_group(s2) : this.result_add_option(s2)) && (h++, e2 += i3), (null != t3 ? t3.first : void 0) && (s2.selected && this.is_multiple ? this.choice_build(s2) : s2.selected && !this.is_multiple && this.single_set_selected_text(this.choice_label(s2))), !(h >= this.max_shown_results)); n2++) ;
          return e2;
        }, t2.prototype.result_add_option = function(t3) {
          var e2, s2;
          return t3.search_match && this.include_option_in_results(t3) ? (e2 = [], t3.disabled || t3.selected && this.is_multiple || e2.push("active-result"), !t3.disabled || t3.selected && this.is_multiple || e2.push("disabled-result"), t3.selected && e2.push("result-selected"), null != t3.group_array_index && e2.push("group-option"), "" !== t3.classes && e2.push(t3.classes), s2 = document.createElement("li"), s2.className = e2.join(" "), t3.style && (s2.style.cssText = t3.style), s2.setAttribute("data-option-array-index", t3.array_index), s2.innerHTML = t3.highlighted_html || t3.html, t3.title && (s2.title = t3.title), this.outerHTML(s2)) : "";
        }, t2.prototype.result_add_group = function(t3) {
          var e2, s2;
          return (t3.search_match || t3.group_match) && t3.active_options > 0 ? ((e2 = []).push("group-result"), t3.classes && e2.push(t3.classes), s2 = document.createElement("li"), s2.className = e2.join(" "), s2.innerHTML = t3.highlighted_html || this.escape_html(t3.label), t3.title && (s2.title = t3.title), this.outerHTML(s2)) : "";
        }, t2.prototype.results_update_field = function() {
          if (this.set_default_text(), this.is_multiple || this.results_reset_cleanup(), this.result_clear_highlight(), this.results_build(), this.results_showing) return this.winnow_results();
        }, t2.prototype.reset_single_select_options = function() {
          var t3, e2, s2, i3, n2;
          for (n2 = [], t3 = 0, e2 = (s2 = this.results_data).length; t3 < e2; t3++) (i3 = s2[t3]).selected ? n2.push(i3.selected = false) : n2.push(void 0);
          return n2;
        }, t2.prototype.results_toggle = function() {
          return this.results_showing ? this.results_hide() : this.results_show();
        }, t2.prototype.results_search = function(t3) {
          return this.results_showing ? this.winnow_results() : this.results_show();
        }, t2.prototype.winnow_results = function(t3) {
          var e2, s2, i3, n2, r2, o2, h, l, c, _, a, u, d, p, f;
          for (this.no_results_clear(), _ = 0, e2 = (h = this.get_search_text()).replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&"), c = this.get_search_regex(e2), i3 = 0, n2 = (l = this.results_data).length; i3 < n2; i3++) (r2 = l[i3]).search_match = false, a = null, u = null, r2.highlighted_html = "", this.include_option_in_results(r2) && (r2.group && (r2.group_match = false, r2.active_options = 0), null != r2.group_array_index && this.results_data[r2.group_array_index] && (0 === (a = this.results_data[r2.group_array_index]).active_options && a.search_match && (_ += 1), a.active_options += 1), f = r2.group ? r2.label : r2.text, r2.group && !this.group_search || (u = this.search_string_match(f, c), r2.search_match = null != u, r2.search_match && !r2.group && (_ += 1), r2.search_match ? (h.length && (d = u.index, o2 = f.slice(0, d), s2 = f.slice(d, d + h.length), p = f.slice(d + h.length), r2.highlighted_html = this.escape_html(o2) + "<em>" + this.escape_html(s2) + "</em>" + this.escape_html(p)), null != a && (a.group_match = true)) : null != r2.group_array_index && this.results_data[r2.group_array_index].search_match && (r2.search_match = true)));
          return this.result_clear_highlight(), _ < 1 && h.length ? (this.update_results_content(""), this.no_results(h)) : (this.update_results_content(this.results_option_build()), (null != t3 ? t3.skip_highlight : void 0) ? void 0 : this.winnow_results_set_highlight());
        }, t2.prototype.get_search_regex = function(t3) {
          var e2, s2;
          return s2 = this.search_contains ? t3 : "(^|\\s|\\b)" + t3 + "[^\\s]*", this.enable_split_word_search || this.search_contains || (s2 = "^" + s2), e2 = this.case_sensitive_search ? "" : "i", new RegExp(s2, e2);
        }, t2.prototype.search_string_match = function(t3, e2) {
          var s2;
          return s2 = e2.exec(t3), !this.search_contains && (null != s2 ? s2[1] : void 0) && (s2.index += 1), s2;
        }, t2.prototype.choices_count = function() {
          var t3, e2, s2;
          if (null != this.selected_option_count) return this.selected_option_count;
          for (this.selected_option_count = 0, t3 = 0, e2 = (s2 = this.form_field.options).length; t3 < e2; t3++) s2[t3].selected && (this.selected_option_count += 1);
          return this.selected_option_count;
        }, t2.prototype.choices_click = function(t3) {
          if (t3.preventDefault(), this.activate_field(), !this.results_showing && !this.is_disabled) return this.results_show();
        }, t2.prototype.keydown_checker = function(t3) {
          var e2, s2;
          switch (s2 = null != (e2 = t3.which) ? e2 : t3.keyCode, this.search_field_scale(), 8 !== s2 && this.pending_backstroke && this.clear_backstroke(), s2) {
            case 8:
              this.backstroke_length = this.get_search_field_value().length;
              break;
            case 9:
              this.results_showing && !this.is_multiple && this.result_select(t3), this.mouse_on_container = false;
              break;
            case 13:
            case 27:
              this.results_showing && t3.preventDefault();
              break;
            case 32:
              this.disable_search && t3.preventDefault();
              break;
            case 38:
              t3.preventDefault(), this.keyup_arrow();
              break;
            case 40:
              t3.preventDefault(), this.keydown_arrow();
          }
        }, t2.prototype.keyup_checker = function(t3) {
          var e2, s2;
          switch (s2 = null != (e2 = t3.which) ? e2 : t3.keyCode, this.search_field_scale(), s2) {
            case 8:
              this.is_multiple && this.backstroke_length < 1 && this.choices_count() > 0 ? this.keydown_backstroke() : this.pending_backstroke || (this.result_clear_highlight(), this.results_search());
              break;
            case 13:
              t3.preventDefault(), this.results_showing && this.result_select(t3);
              break;
            case 27:
              this.results_showing && this.results_hide();
              break;
            case 9:
            case 16:
            case 17:
            case 18:
            case 38:
            case 40:
            case 91:
              break;
            default:
              this.results_search();
          }
        }, t2.prototype.clipboard_event_checker = function(t3) {
          if (!this.is_disabled) return setTimeout(/* @__PURE__ */ (function(t4) {
            return function() {
              return t4.results_search();
            };
          })(this), 50);
        }, t2.prototype.container_width = function() {
          return null != this.options.width ? this.options.width : this.form_field.offsetWidth + "px";
        }, t2.prototype.include_option_in_results = function(t3) {
          return !(this.is_multiple && !this.display_selected_options && t3.selected) && (!(!this.display_disabled_options && t3.disabled) && !t3.empty);
        }, t2.prototype.search_results_touchstart = function(t3) {
          return this.touch_started = true, this.search_results_mouseover(t3);
        }, t2.prototype.search_results_touchmove = function(t3) {
          return this.touch_started = false, this.search_results_mouseout(t3);
        }, t2.prototype.search_results_touchend = function(t3) {
          if (this.touch_started) return this.search_results_mouseup(t3);
        }, t2.prototype.outerHTML = function(t3) {
          var e2;
          return t3.outerHTML ? t3.outerHTML : ((e2 = document.createElement("div")).appendChild(t3), e2.innerHTML);
        }, t2.prototype.get_single_html = function() {
          return '<a class="chosen-single chosen-default">\n  <span>' + this.default_text + '</span>\n  <div><b></b></div>\n</a>\n<div class="chosen-drop">\n  <div class="chosen-search">\n    <input class="chosen-search-input" type="text" autocomplete="off" />\n  </div>\n  <ul class="chosen-results"></ul>\n</div>';
        }, t2.prototype.get_multi_html = function() {
          return '<ul class="chosen-choices">\n  <li class="search-field">\n    <input class="chosen-search-input" type="text" autocomplete="off" value="' + this.default_text + '" />\n  </li>\n</ul>\n<div class="chosen-drop">\n  <ul class="chosen-results"></ul>\n</div>';
        }, t2.prototype.get_no_results_html = function(t3) {
          return '<li class="no-results">\n  ' + this.results_none_found + " <span>" + this.escape_html(t3) + "</span>\n</li>";
        }, t2.browser_is_supported = function() {
          return "Microsoft Internet Explorer" === window.navigator.appName ? document.documentMode >= 8 : !(/iP(od|hone)/i.test(window.navigator.userAgent) || /IEMobile/i.test(window.navigator.userAgent) || /Windows Phone/i.test(window.navigator.userAgent) || /BlackBerry/i.test(window.navigator.userAgent) || /BB10/i.test(window.navigator.userAgent) || /Android.*Mobile/i.test(window.navigator.userAgent));
        }, t2.default_multiple_text = "Select Some Options", t2.default_single_text = "Select an Option", t2.default_no_result_text = "No results match", t2;
      })(), (t = $$1).fn.extend({ chosen: function(i3) {
        return e.browser_is_supported() ? this.each(function(e2) {
          var n2, r2;
          r2 = (n2 = t(this)).data("chosen"), "destroy" !== i3 ? r2 instanceof s || n2.data("chosen", new s(this, i3)) : r2 instanceof s && r2.destroy();
        }) : this;
      } }), s = (function(s2) {
        function n2() {
          return n2.__super__.constructor.apply(this, arguments);
        }
        return r(n2, e), n2.prototype.setup = function() {
          return this.form_field_jq = t(this.form_field), this.current_selectedIndex = this.form_field.selectedIndex;
        }, n2.prototype.set_up_html = function() {
          var e2, s3;
          return (e2 = ["chosen-container"]).push("chosen-container-" + (this.is_multiple ? "multi" : "single")), this.inherit_select_classes && this.form_field.className && e2.push(this.form_field.className), this.is_rtl && e2.push("chosen-rtl"), s3 = { "class": e2.join(" "), title: this.form_field.title }, this.form_field.id.length && (s3.id = this.form_field.id.replace(/[^\w]/g, "_") + "_chosen"), this.container = t("<div />", s3), this.container.width(this.container_width()), this.is_multiple ? this.container.html(this.get_multi_html()) : this.container.html(this.get_single_html()), this.form_field_jq.hide().after(this.container), this.dropdown = this.container.find("div.chosen-drop").first(), this.search_field = this.container.find("input").first(), this.search_results = this.container.find("ul.chosen-results").first(), this.search_field_scale(), this.search_no_results = this.container.find("li.no-results").first(), this.is_multiple ? (this.search_choices = this.container.find("ul.chosen-choices").first(), this.search_container = this.container.find("li.search-field").first()) : (this.search_container = this.container.find("div.chosen-search").first(), this.selected_item = this.container.find(".chosen-single").first()), this.results_build(), this.set_tab_index(), this.set_label_behavior();
        }, n2.prototype.on_ready = function() {
          return this.form_field_jq.trigger("chosen:ready", { chosen: this });
        }, n2.prototype.register_observers = function() {
          return this.container.on("touchstart.chosen", /* @__PURE__ */ (function(t2) {
            return function(e2) {
              t2.container_mousedown(e2);
            };
          })(this)), this.container.on("touchend.chosen", /* @__PURE__ */ (function(t2) {
            return function(e2) {
              t2.container_mouseup(e2);
            };
          })(this)), this.container.on("mousedown.chosen", /* @__PURE__ */ (function(t2) {
            return function(e2) {
              t2.container_mousedown(e2);
            };
          })(this)), this.container.on("mouseup.chosen", /* @__PURE__ */ (function(t2) {
            return function(e2) {
              t2.container_mouseup(e2);
            };
          })(this)), this.container.on("mouseenter.chosen", /* @__PURE__ */ (function(t2) {
            return function(e2) {
              t2.mouse_enter(e2);
            };
          })(this)), this.container.on("mouseleave.chosen", /* @__PURE__ */ (function(t2) {
            return function(e2) {
              t2.mouse_leave(e2);
            };
          })(this)), this.search_results.on("mouseup.chosen", /* @__PURE__ */ (function(t2) {
            return function(e2) {
              t2.search_results_mouseup(e2);
            };
          })(this)), this.search_results.on("mouseover.chosen", /* @__PURE__ */ (function(t2) {
            return function(e2) {
              t2.search_results_mouseover(e2);
            };
          })(this)), this.search_results.on("mouseout.chosen", /* @__PURE__ */ (function(t2) {
            return function(e2) {
              t2.search_results_mouseout(e2);
            };
          })(this)), this.search_results.on("mousewheel.chosen DOMMouseScroll.chosen", /* @__PURE__ */ (function(t2) {
            return function(e2) {
              t2.search_results_mousewheel(e2);
            };
          })(this)), this.search_results.on("touchstart.chosen", /* @__PURE__ */ (function(t2) {
            return function(e2) {
              t2.search_results_touchstart(e2);
            };
          })(this)), this.search_results.on("touchmove.chosen", /* @__PURE__ */ (function(t2) {
            return function(e2) {
              t2.search_results_touchmove(e2);
            };
          })(this)), this.search_results.on("touchend.chosen", /* @__PURE__ */ (function(t2) {
            return function(e2) {
              t2.search_results_touchend(e2);
            };
          })(this)), this.form_field_jq.on("chosen:updated.chosen", /* @__PURE__ */ (function(t2) {
            return function(e2) {
              t2.results_update_field(e2);
            };
          })(this)), this.form_field_jq.on("chosen:activate.chosen", /* @__PURE__ */ (function(t2) {
            return function(e2) {
              t2.activate_field(e2);
            };
          })(this)), this.form_field_jq.on("chosen:open.chosen", /* @__PURE__ */ (function(t2) {
            return function(e2) {
              t2.container_mousedown(e2);
            };
          })(this)), this.form_field_jq.on("chosen:close.chosen", /* @__PURE__ */ (function(t2) {
            return function(e2) {
              t2.close_field(e2);
            };
          })(this)), this.search_field.on("blur.chosen", /* @__PURE__ */ (function(t2) {
            return function(e2) {
              t2.input_blur(e2);
            };
          })(this)), this.search_field.on("keyup.chosen", /* @__PURE__ */ (function(t2) {
            return function(e2) {
              t2.keyup_checker(e2);
            };
          })(this)), this.search_field.on("keydown.chosen", /* @__PURE__ */ (function(t2) {
            return function(e2) {
              t2.keydown_checker(e2);
            };
          })(this)), this.search_field.on("focus.chosen", /* @__PURE__ */ (function(t2) {
            return function(e2) {
              t2.input_focus(e2);
            };
          })(this)), this.search_field.on("cut.chosen", /* @__PURE__ */ (function(t2) {
            return function(e2) {
              t2.clipboard_event_checker(e2);
            };
          })(this)), this.search_field.on("paste.chosen", /* @__PURE__ */ (function(t2) {
            return function(e2) {
              t2.clipboard_event_checker(e2);
            };
          })(this)), this.is_multiple ? this.search_choices.on("click.chosen", /* @__PURE__ */ (function(t2) {
            return function(e2) {
              t2.choices_click(e2);
            };
          })(this)) : this.container.on("click.chosen", function(t2) {
            t2.preventDefault();
          });
        }, n2.prototype.destroy = function() {
          return t(this.container[0].ownerDocument).off("click.chosen", this.click_test_action), this.form_field_label.length > 0 && this.form_field_label.off("click.chosen"), this.search_field[0].tabIndex && (this.form_field_jq[0].tabIndex = this.search_field[0].tabIndex), this.container.remove(), this.form_field_jq.removeData("chosen"), this.form_field_jq.show();
        }, n2.prototype.search_field_disabled = function() {
          return this.is_disabled = this.form_field.disabled || this.form_field_jq.parents("fieldset").is(":disabled"), this.container.toggleClass("chosen-disabled", this.is_disabled), this.search_field[0].disabled = this.is_disabled, this.is_multiple || this.selected_item.off("focus.chosen", this.activate_field), this.is_disabled ? this.close_field() : this.is_multiple ? void 0 : this.selected_item.on("focus.chosen", this.activate_field);
        }, n2.prototype.container_mousedown = function(e2) {
          var s3;
          if (!this.is_disabled) return !e2 || "mousedown" !== (s3 = e2.type) && "touchstart" !== s3 || this.results_showing || e2.preventDefault(), null != e2 && t(e2.target).hasClass("search-choice-close") ? void 0 : (this.active_field ? this.is_multiple || !e2 || t(e2.target)[0] !== this.selected_item[0] && !t(e2.target).parents("a.chosen-single").length || (e2.preventDefault(), this.results_toggle()) : (this.is_multiple && this.search_field.val(""), t(this.container[0].ownerDocument).on("click.chosen", this.click_test_action), this.results_show()), this.activate_field());
        }, n2.prototype.container_mouseup = function(t2) {
          if ("ABBR" === t2.target.nodeName && !this.is_disabled) return this.results_reset(t2);
        }, n2.prototype.search_results_mousewheel = function(t2) {
          var e2;
          if (t2.originalEvent && (e2 = t2.originalEvent.deltaY || -t2.originalEvent.wheelDelta || t2.originalEvent.detail), null != e2) return t2.preventDefault(), "DOMMouseScroll" === t2.type && (e2 *= 40), this.search_results.scrollTop(e2 + this.search_results.scrollTop());
        }, n2.prototype.blur_test = function(t2) {
          if (!this.active_field && this.container.hasClass("chosen-container-active")) return this.close_field();
        }, n2.prototype.close_field = function() {
          return t(this.container[0].ownerDocument).off("click.chosen", this.click_test_action), this.active_field = false, this.results_hide(), this.container.removeClass("chosen-container-active"), this.clear_backstroke(), this.show_search_field_default(), this.search_field_scale(), this.search_field.blur();
        }, n2.prototype.activate_field = function() {
          if (!this.is_disabled) return this.container.addClass("chosen-container-active"), this.active_field = true, this.search_field.val(this.search_field.val()), this.search_field.focus();
        }, n2.prototype.test_active_click = function(e2) {
          var s3;
          return (s3 = t(e2.target).closest(".chosen-container")).length && this.container[0] === s3[0] ? this.active_field = true : this.close_field();
        }, n2.prototype.results_build = function() {
          return this.parsing = true, this.selected_option_count = null, this.results_data = i2.select_to_array(this.form_field), this.is_multiple ? this.search_choices.find("li.search-choice").remove() : (this.single_set_selected_text(), this.disable_search || this.form_field.options.length <= this.disable_search_threshold ? (this.search_field[0].readOnly = true, this.container.addClass("chosen-container-single-nosearch")) : (this.search_field[0].readOnly = false, this.container.removeClass("chosen-container-single-nosearch"))), this.update_results_content(this.results_option_build({ first: true })), this.search_field_disabled(), this.show_search_field_default(), this.search_field_scale(), this.parsing = false;
        }, n2.prototype.result_do_highlight = function(t2) {
          var e2, s3, i3, n3, r2;
          if (t2.length) {
            if (this.result_clear_highlight(), this.result_highlight = t2, this.result_highlight.addClass("highlighted"), i3 = parseInt(this.search_results.css("maxHeight"), 10), r2 = this.search_results.scrollTop(), n3 = i3 + r2, s3 = this.result_highlight.position().top + this.search_results.scrollTop(), (e2 = s3 + this.result_highlight.outerHeight()) >= n3) return this.search_results.scrollTop(e2 - i3 > 0 ? e2 - i3 : 0);
            if (s3 < r2) return this.search_results.scrollTop(s3);
          }
        }, n2.prototype.result_clear_highlight = function() {
          return this.result_highlight && this.result_highlight.removeClass("highlighted"), this.result_highlight = null;
        }, n2.prototype.results_show = function() {
          return this.is_multiple && this.max_selected_options <= this.choices_count() ? (this.form_field_jq.trigger("chosen:maxselected", { chosen: this }), false) : (this.container.addClass("chosen-with-drop"), this.results_showing = true, this.search_field.focus(), this.search_field.val(this.get_search_field_value()), this.winnow_results(), this.form_field_jq.trigger("chosen:showing_dropdown", { chosen: this }));
        }, n2.prototype.update_results_content = function(t2) {
          return this.search_results.html(t2);
        }, n2.prototype.results_hide = function() {
          return this.results_showing && (this.result_clear_highlight(), this.container.removeClass("chosen-with-drop"), this.form_field_jq.trigger("chosen:hiding_dropdown", { chosen: this })), this.results_showing = false;
        }, n2.prototype.set_tab_index = function(t2) {
          var e2;
          if (this.form_field.tabIndex) return e2 = this.form_field.tabIndex, this.form_field.tabIndex = -1, this.search_field[0].tabIndex = e2;
        }, n2.prototype.set_label_behavior = function() {
          if (this.form_field_label = this.form_field_jq.parents("label"), !this.form_field_label.length && this.form_field.id.length && (this.form_field_label = t("label[for='" + this.form_field.id + "']")), this.form_field_label.length > 0) return this.form_field_label.on("click.chosen", this.label_click_handler);
        }, n2.prototype.show_search_field_default = function() {
          return this.is_multiple && this.choices_count() < 1 && !this.active_field ? (this.search_field.val(this.default_text), this.search_field.addClass("default")) : (this.search_field.val(""), this.search_field.removeClass("default"));
        }, n2.prototype.search_results_mouseup = function(e2) {
          var s3;
          if ((s3 = t(e2.target).hasClass("active-result") ? t(e2.target) : t(e2.target).parents(".active-result").first()).length) return this.result_highlight = s3, this.result_select(e2), this.search_field.focus();
        }, n2.prototype.search_results_mouseover = function(e2) {
          var s3;
          if (s3 = t(e2.target).hasClass("active-result") ? t(e2.target) : t(e2.target).parents(".active-result").first()) return this.result_do_highlight(s3);
        }, n2.prototype.search_results_mouseout = function(e2) {
          if (t(e2.target).hasClass("active-result") || t(e2.target).parents(".active-result").first()) return this.result_clear_highlight();
        }, n2.prototype.choice_build = function(e2) {
          var s3, i3;
          return s3 = t("<li />", { "class": "search-choice" }).html("<span>" + this.choice_label(e2) + "</span>"), e2.disabled ? s3.addClass("search-choice-disabled") : ((i3 = t("<a />", { "class": "search-choice-close", "data-option-array-index": e2.array_index })).on("click.chosen", /* @__PURE__ */ (function(t2) {
            return function(e3) {
              return t2.choice_destroy_link_click(e3);
            };
          })(this)), s3.append(i3)), this.search_container.before(s3);
        }, n2.prototype.choice_destroy_link_click = function(e2) {
          if (e2.preventDefault(), e2.stopPropagation(), !this.is_disabled) return this.choice_destroy(t(e2.target));
        }, n2.prototype.choice_destroy = function(t2) {
          if (this.result_deselect(t2[0].getAttribute("data-option-array-index"))) return this.active_field ? this.search_field.focus() : this.show_search_field_default(), this.is_multiple && this.choices_count() > 0 && this.get_search_field_value().length < 1 && this.results_hide(), t2.parents("li").first().remove(), this.search_field_scale();
        }, n2.prototype.results_reset = function() {
          if (this.reset_single_select_options(), this.form_field.options[0].selected = true, this.single_set_selected_text(), this.show_search_field_default(), this.results_reset_cleanup(), this.trigger_form_field_change(), this.active_field) return this.results_hide();
        }, n2.prototype.results_reset_cleanup = function() {
          return this.current_selectedIndex = this.form_field.selectedIndex, this.selected_item.find("abbr").remove();
        }, n2.prototype.result_select = function(t2) {
          var e2, s3;
          if (this.result_highlight) return e2 = this.result_highlight, this.result_clear_highlight(), this.is_multiple && this.max_selected_options <= this.choices_count() ? (this.form_field_jq.trigger("chosen:maxselected", { chosen: this }), false) : (this.is_multiple ? e2.removeClass("active-result") : this.reset_single_select_options(), e2.addClass("result-selected"), s3 = this.results_data[e2[0].getAttribute("data-option-array-index")], s3.selected = true, this.form_field.options[s3.options_index].selected = true, this.selected_option_count = null, this.is_multiple ? this.choice_build(s3) : this.single_set_selected_text(this.choice_label(s3)), this.is_multiple && (!this.hide_results_on_select || t2.metaKey || t2.ctrlKey) ? t2.metaKey || t2.ctrlKey ? this.winnow_results({ skip_highlight: true }) : (this.search_field.val(""), this.winnow_results()) : (this.results_hide(), this.show_search_field_default()), (this.is_multiple || this.form_field.selectedIndex !== this.current_selectedIndex) && this.trigger_form_field_change({ selected: this.form_field.options[s3.options_index].value }), this.current_selectedIndex = this.form_field.selectedIndex, t2.preventDefault(), this.search_field_scale());
        }, n2.prototype.single_set_selected_text = function(t2) {
          return null == t2 && (t2 = this.default_text), t2 === this.default_text ? this.selected_item.addClass("chosen-default") : (this.single_deselect_control_build(), this.selected_item.removeClass("chosen-default")), this.selected_item.find("span").html(t2);
        }, n2.prototype.result_deselect = function(t2) {
          var e2;
          return e2 = this.results_data[t2], !this.form_field.options[e2.options_index].disabled && (e2.selected = false, this.form_field.options[e2.options_index].selected = false, this.selected_option_count = null, this.result_clear_highlight(), this.results_showing && this.winnow_results(), this.trigger_form_field_change({ deselected: this.form_field.options[e2.options_index].value }), this.search_field_scale(), true);
        }, n2.prototype.single_deselect_control_build = function() {
          if (this.allow_single_deselect) return this.selected_item.find("abbr").length || this.selected_item.find("span").first().after('<abbr class="search-choice-close"></abbr>'), this.selected_item.addClass("chosen-single-with-deselect");
        }, n2.prototype.get_search_field_value = function() {
          return this.search_field.val();
        }, n2.prototype.get_search_text = function() {
          return t.trim(this.get_search_field_value());
        }, n2.prototype.escape_html = function(e2) {
          return t("<div/>").text(e2).html();
        }, n2.prototype.winnow_results_set_highlight = function() {
          var t2, e2;
          if (e2 = this.is_multiple ? [] : this.search_results.find(".result-selected.active-result"), null != (t2 = e2.length ? e2.first() : this.search_results.find(".active-result").first())) return this.result_do_highlight(t2);
        }, n2.prototype.no_results = function(t2) {
          var e2;
          return e2 = this.get_no_results_html(t2), this.search_results.append(e2), this.form_field_jq.trigger("chosen:no_results", { chosen: this });
        }, n2.prototype.no_results_clear = function() {
          return this.search_results.find(".no-results").remove();
        }, n2.prototype.keydown_arrow = function() {
          var t2;
          return this.results_showing && this.result_highlight ? (t2 = this.result_highlight.nextAll("li.active-result").first()) ? this.result_do_highlight(t2) : void 0 : this.results_show();
        }, n2.prototype.keyup_arrow = function() {
          var t2;
          return this.results_showing || this.is_multiple ? this.result_highlight ? (t2 = this.result_highlight.prevAll("li.active-result")).length ? this.result_do_highlight(t2.first()) : (this.choices_count() > 0 && this.results_hide(), this.result_clear_highlight()) : void 0 : this.results_show();
        }, n2.prototype.keydown_backstroke = function() {
          var t2;
          return this.pending_backstroke ? (this.choice_destroy(this.pending_backstroke.find("a").first()), this.clear_backstroke()) : (t2 = this.search_container.siblings("li.search-choice").last()).length && !t2.hasClass("search-choice-disabled") ? (this.pending_backstroke = t2, this.single_backstroke_delete ? this.keydown_backstroke() : this.pending_backstroke.addClass("search-choice-focus")) : void 0;
        }, n2.prototype.clear_backstroke = function() {
          return this.pending_backstroke && this.pending_backstroke.removeClass("search-choice-focus"), this.pending_backstroke = null;
        }, n2.prototype.search_field_scale = function() {
          var e2, s3, i3, n3, r2, o2, h;
          if (this.is_multiple) {
            for (r2 = { position: "absolute", left: "-1000px", top: "-1000px", display: "none", whiteSpace: "pre" }, s3 = 0, i3 = (o2 = ["fontSize", "fontStyle", "fontWeight", "fontFamily", "lineHeight", "textTransform", "letterSpacing"]).length; s3 < i3; s3++) r2[n3 = o2[s3]] = this.search_field.css(n3);
            return (e2 = t("<div />").css(r2)).text(this.get_search_field_value()), t("body").append(e2), h = e2.width() + 25, e2.remove(), this.container.is(":visible") && (h = Math.min(this.container.outerWidth() - 10, h)), this.search_field.width(h);
          }
        }, n2.prototype.trigger_form_field_change = function(t2) {
          return this.form_field_jq.trigger("input", t2), this.form_field_jq.trigger("change", t2);
        }, n2;
      })();
    }).call(void 0);
    (function($2) {
      var d = $2(document);
      var h = $2("head");
      var drag = null;
      var tables = {};
      var count = 0;
      var ID = "id";
      var PX = "px";
      var SIGNATURE = "JColResizer";
      var FLEX = "JCLRFlex";
      var I = parseInt;
      var M = Math;
      var ie = navigator.userAgent.indexOf("Trident/4.0") > 0;
      var S;
      try {
        S = sessionStorage;
      } catch (e) {
      }
      h.append("<style type='text/css'>  .JColResizer{table-layout:fixed;} .JColResizer > tbody > tr > td, .JColResizer > tbody > tr > th{overflow:hidden}  .JPadding > tbody > tr > td, .JPadding > tbody > tr > th{padding-left:0!important; padding-right:0!important;} .JCLRgrips{ height:0px; position:relative;} .JCLRgrip{margin-left:-5px; position:absolute; z-index:5; } .JCLRgrip .JColResizer{position:absolute;background-color:red;filter:alpha(opacity=1);opacity:0;width:10px;height:100%;cursor: col-resize;top:0px} .JCLRLastGrip{position:absolute; width:1px; } .JCLRgripDrag{ border-left:1px dotted black;	} .JCLRFlex{width:auto!important;} .JCLRgrip.JCLRdisabledGrip .JColResizer{cursor:default; display:none;}</style>");
      var init = function(tb, options) {
        var t = $2(tb);
        t.opt = options;
        t.mode = options.resizeMode;
        t.dc = t.opt.disabledColumns;
        if (t.opt.removePadding) t.addClass("JPadding");
        if (t.opt.disable) return destroy(t);
        var id = t.id = t.attr(ID) || SIGNATURE + count++;
        t.p = t.opt.postbackSafe;
        if (!t.is("table") || tables[id] && !t.opt.partialRefresh) return;
        if (t.opt.hoverCursor !== "col-resize") h.append("<style type='text/css'>.JCLRgrip .JColResizer:hover{cursor:" + t.opt.hoverCursor + "!important}</style>");
        t.addClass(SIGNATURE).attr(ID, id).before('<div class="JCLRgrips"/>');
        t.g = [];
        t.c = [];
        t.w = t.width();
        t.gc = t.prev();
        t.f = t.opt.fixed;
        if (options.marginLeft) t.gc.css("marginLeft", options.marginLeft);
        if (options.marginRight) t.gc.css("marginRight", options.marginRight);
        t.cs = I(ie ? tb.cellSpacing || tb.currentStyle.borderSpacing : t.css("border-spacing")) || 2;
        t.b = I(ie ? tb.border || tb.currentStyle.borderLeftWidth : t.css("border-left-width")) || 1;
        tables[id] = t;
        createGrips(t);
      };
      var destroy = function(t) {
        var id = t.attr(ID), t = tables[id];
        if (!t || !t.is("table")) return;
        t.removeClass(SIGNATURE + " " + FLEX).gc.remove();
        delete tables[id];
      };
      var createGrips = function(t) {
        var th = t.find(">thead>tr:first>th,>thead>tr:first>td");
        if (!th.length) th = t.find(">tbody>tr:first>th,>tr:first>th,>tbody>tr:first>td, >tr:first>td");
        th = th.filter(":visible");
        t.cg = t.find("col");
        t.ln = th.length;
        if (t.p && S && S[t.id]) memento(t, th);
        th.each(function(i2) {
          var c = $2(this);
          var dc = t.dc.indexOf(i2) != -1;
          var g = $2(t.gc.append('<div class="JCLRgrip"></div>')[0].lastChild);
          g.append(dc ? "" : t.opt.gripInnerHtml).append('<div class="' + SIGNATURE + '"></div>');
          if (i2 == t.ln - 1) {
            g.addClass("JCLRLastGrip");
            if (t.f) g.html("");
          }
          g.bind("touchstart mousedown", onGripMouseDown);
          if (!dc) {
            g.removeClass("JCLRdisabledGrip").bind("touchstart mousedown", onGripMouseDown);
          } else {
            g.addClass("JCLRdisabledGrip");
          }
          g.t = t;
          g.i = i2;
          g.c = c;
          c.w = c.width();
          t.g.push(g);
          t.c.push(c);
          c.width(c.w).removeAttr("width");
          g.data(SIGNATURE, { i: i2, t: t.attr(ID), last: i2 == t.ln - 1 });
        });
        t.cg.removeAttr("width");
        t.find("td, th").not(th).not("table th, table td").each(function() {
          $2(this).removeAttr("width");
        });
        if (!t.f) {
          t.removeAttr("width").addClass(FLEX);
        }
        syncGrips(t);
      };
      var memento = function(t, th) {
        var w, m = 0, i2 = 0, aux = [], tw;
        if (th) {
          t.cg.removeAttr("width");
          if (t.opt.flush) {
            S[t.id] = "";
            return;
          }
          w = S[t.id].split(";");
          tw = w[t.ln + 1];
          if (!t.f && tw) {
            t.width(tw *= 1);
            if (t.opt.overflow) {
              t.css("min-width", tw + PX);
              t.w = tw;
            }
          }
          for (; i2 < t.ln; i2++) {
            aux.push(100 * w[i2] / w[t.ln] + "%");
            th.eq(i2).css("width", aux[i2]);
          }
          for (i2 = 0; i2 < t.ln; i2++)
            t.cg.eq(i2).css("width", aux[i2]);
        } else {
          S[t.id] = "";
          for (; i2 < t.c.length; i2++) {
            w = t.c[i2].width();
            S[t.id] += w + ";";
            m += w;
          }
          S[t.id] += m;
          if (!t.f) S[t.id] += ";" + t.width();
        }
      };
      var syncGrips = function(t) {
        for (var i2 = 0; i2 < t.ln; i2++) {
          var c = t.c[i2];
          t.g[i2].css({
            //height and position of the grip is updated according to the table layout
            left: c.offset().left - t.offset().left + c.outerWidth(false) + t.cs / 2 + PX,
            height: t.opt.headerOnly ? t.c[0].outerHeight(false) : t.outerHeight(false)
          });
        }
      };
      var syncCols = function(t, i2, isOver) {
        var inc = drag.x - drag.l, c = t.c[i2], c2 = t.c[i2 + 1];
        var w = c.w + inc;
        var w2 = c2.w - inc;
        c.width(w + PX);
        t.cg.eq(i2).width(w + PX);
        if (t.f) {
          c2.width(w2 + PX);
          t.cg.eq(i2 + 1).width(w2 + PX);
        } else if (t.opt.overflow) {
          t.css("min-width", t.w + inc);
        }
        if (isOver) {
          c.w = w;
          c2.w = t.f ? w2 : c2.w;
        }
      };
      var applyBounds = function(t) {
        var w = $2.map(t.c, function(c) {
          return c.width();
        });
        t.width(t.w = t.width()).removeClass(FLEX);
        $2.each(t.c, function(i2, c) {
          c.width(w[i2]).w = w[i2];
        });
        t.addClass(FLEX);
      };
      var onGripDrag = function(e) {
        if (!drag) return;
        var t = drag.t;
        var oe = e.originalEvent.touches;
        var ox = oe ? oe[0].pageX : e.pageX;
        var x = ox - drag.ox + drag.l;
        var mw = t.opt.minWidth, i2 = drag.i;
        var l = t.cs * 1.5 + mw + t.b;
        var last = i2 == t.ln - 1;
        var min = i2 ? t.g[i2 - 1].position().left + t.cs + mw : l;
        var max = t.f ? (
          //fixed mode?
          i2 == t.ln - 1 ? t.w - l : t.g[i2 + 1].position().left - t.cs - mw
        ) : Infinity;
        x = M.max(min, M.min(max, x));
        drag.x = x;
        drag.css("left", x + PX);
        if (last) {
          var c = t.c[drag.i];
          drag.w = c.w + x - drag.l;
        }
        if (t.opt.liveDrag) {
          if (last) {
            c.width(drag.w);
            if (!t.f && t.opt.overflow) {
              t.css("min-width", t.w + x - drag.l);
            } else {
              t.w = t.width();
            }
          } else {
            syncCols(t, i2);
          }
          syncGrips(t);
          var cb = t.opt.onDrag;
          if (cb) {
            e.currentTarget = t[0];
            cb(e);
          }
        }
        return false;
      };
      var onGripDragOver = function(e) {
        d.unbind("touchend." + SIGNATURE + " mouseup." + SIGNATURE).unbind("touchmove." + SIGNATURE + " mousemove." + SIGNATURE);
        $2("head :last-child").remove();
        if (!drag) return;
        drag.removeClass(drag.t.opt.draggingClass);
        if (!(drag.x - drag.l == 0)) {
          var t = drag.t;
          var cb = t.opt.onResize;
          var i2 = drag.i;
          var last = i2 == t.ln - 1;
          var c = t.g[i2].c;
          if (last) {
            c.width(drag.w);
            c.w = drag.w;
          } else {
            syncCols(t, i2, true);
          }
          if (!t.f) applyBounds(t);
          syncGrips(t);
          if (cb) {
            e.currentTarget = t[0];
            cb(e);
          }
          if (t.p && S) memento(t);
        }
        drag = null;
      };
      var onGripMouseDown = function(e) {
        var o = $2(this).data(SIGNATURE);
        var t = tables[o.t], g = t.g[o.i];
        var oe = e.originalEvent.touches;
        g.ox = oe ? oe[0].pageX : e.pageX;
        g.l = g.position().left;
        g.x = g.l;
        d.bind("touchmove." + SIGNATURE + " mousemove." + SIGNATURE, onGripDrag).bind("touchend." + SIGNATURE + " mouseup." + SIGNATURE, onGripDragOver);
        h.append("<style type='text/css'>*{cursor:" + t.opt.dragCursor + "!important}</style>");
        g.addClass(t.opt.draggingClass);
        drag = g;
        if (t.c[o.i].l) for (var i2 = 0, c; i2 < t.ln; i2++) {
          c = t.c[i2];
          c.l = false;
          c.w = c.width();
        }
        return false;
      };
      var onResize = function() {
        for (var t in tables) {
          if (tables.hasOwnProperty(t)) {
            t = tables[t];
            var i2, mw = 0;
            t.removeClass(SIGNATURE);
            if (t.f) {
              t.w = t.width();
              for (i2 = 0; i2 < t.ln; i2++) mw += t.c[i2].w;
              for (i2 = 0; i2 < t.ln; i2++) t.c[i2].css("width", M.round(1e3 * t.c[i2].w / mw) / 10 + "%").l = true;
            } else {
              applyBounds(t);
              if (t.mode == "flex" && t.p && S) {
                memento(t);
              }
            }
            syncGrips(t.addClass(SIGNATURE));
          }
        }
      };
      $2(window).bind("resize." + SIGNATURE, onResize);
      $2.fn.extend({
        colResizable: function(options) {
          var defaults2 = {
            //attributes:
            resizeMode: "fit",
            //mode can be 'fit', 'flex' or 'overflow'
            draggingClass: "JCLRgripDrag",
            //css-class used when a grip is being dragged (for visual feedback purposes)
            gripInnerHtml: "",
            //if it is required to use a custom grip it can be done using some custom HTML				
            liveDrag: false,
            //enables table-layout updating while dragging	
            minWidth: 15,
            //minimum width value in pixels allowed for a column 
            headerOnly: false,
            //specifies that the size of the the column resizing anchors will be bounded to the size of the first row 
            hoverCursor: "col-resize",
            //cursor to be used on grip hover
            dragCursor: "col-resize",
            //cursor to be used while dragging
            postbackSafe: false,
            //when it is enabled, table layout can persist after postback or page refresh. It requires browsers with sessionStorage support (it can be emulated with sessionStorage.js). 
            flush: false,
            //when postbakSafe is enabled, and it is required to prevent layout restoration after postback, 'flush' will remove its associated layout data 
            marginLeft: null,
            //in case the table contains any margins, colResizable needs to know the values used, e.g. "10%", "15em", "5px" ...
            marginRight: null,
            //in case the table contains any margins, colResizable needs to know the values used, e.g. "10%", "15em", "5px" ...
            disable: false,
            //disables all the enhancements performed in a previously colResized table	
            partialRefresh: false,
            //can be used in combination with postbackSafe when the table is inside of an updatePanel,
            disabledColumns: [],
            //column indexes to be excluded
            removePadding: true,
            //for some uses (such as multiple range slider), it is advised to set this modifier to true, it will remove padding from the header cells.
            //events:
            onDrag: null,
            //callback function to be fired during the column resizing process if liveDrag is enabled
            onResize: null
            //callback function fired when the dragging process is over
          };
          var options = $2.extend(defaults2, options);
          options.fixed = true;
          options.overflow = false;
          switch (options.resizeMode) {
            case "flex":
              options.fixed = false;
              break;
            case "overflow":
              options.fixed = false;
              options.overflow = true;
              break;
          }
          return this.each(function() {
            init(this, options);
          });
        }
      });
    })($$1);
    (function(factory) {
      if (typeof define === "function" && define.amd) {
        define(["jquery"], factory);
      } else if (typeof exports === "object" && typeof require === "function") {
        factory(require("jquery"));
      } else {
        factory($$1);
      }
    })(
      /**
       * @param {jQuery} $
       */
      function($2) {
        var utils = {
          escapeRegExChars: function(value) {
            return value.replace(/[|\\{}()[\]^$+*?.]/g, "\\$&");
          },
          createNode: function(containerClass) {
            var div = document.createElement("div");
            div.className = containerClass;
            div.style.position = "absolute";
            div.style.display = "none";
            return div;
          }
        }, keys = { ESC: 27, TAB: 9, RETURN: 13, UP: 38, RIGHT: 39, DOWN: 40 }, noop = $2.noop;
        function Autocomplete(el, options) {
          var that = this;
          that.element = el;
          that.el = $2(el);
          that.suggestions = [];
          that.badQueries = [];
          that.selectedIndex = -1;
          that.currentValue = that.element.value;
          that.timeoutId = null;
          that.cachedResponse = {};
          that.onChangeTimeout = null;
          that.onChange = null;
          that.isLocal = false;
          that.suggestionsContainer = null;
          that.noSuggestionsContainer = null;
          that.options = $2.extend(true, {}, Autocomplete.defaults, options);
          that.classes = {
            selected: "autocomplete-selected",
            suggestion: "autocomplete-suggestion"
          };
          that.hint = null;
          that.hintValue = "";
          that.selection = null;
          that.initialize();
          that.setOptions(options);
        }
        Autocomplete.utils = utils;
        $2.Autocomplete = Autocomplete;
        Autocomplete.defaults = {
          ajaxSettings: {},
          autoSelectFirst: false,
          appendTo: "body",
          serviceUrl: null,
          lookup: null,
          onSelect: null,
          onHint: null,
          width: "auto",
          minChars: 1,
          maxHeight: 300,
          deferRequestBy: 0,
          params: {},
          formatResult: _formatResult,
          formatGroup: _formatGroup,
          delimiter: null,
          zIndex: 9999,
          type: "GET",
          noCache: false,
          onSearchStart: noop,
          onSearchComplete: noop,
          onSearchError: noop,
          preserveInput: false,
          containerClass: "autocomplete-suggestions",
          tabDisabled: false,
          dataType: "text",
          currentRequest: null,
          triggerSelectOnValidInput: true,
          preventBadQueries: true,
          lookupFilter: _lookupFilter,
          paramName: "query",
          transformResult: _transformResult,
          showNoSuggestionNotice: false,
          noSuggestionNotice: "No results",
          orientation: "bottom",
          forceFixPosition: false
        };
        function _lookupFilter(suggestion, originalQuery, queryLowerCase) {
          return suggestion.value.toLowerCase().indexOf(queryLowerCase) !== -1;
        }
        function _transformResult(response) {
          return typeof response === "string" ? JSON.parse(response) : response;
        }
        function _formatResult(suggestion, currentValue) {
          if (!currentValue) {
            return suggestion.value;
          }
          var pattern = "(" + utils.escapeRegExChars(currentValue) + ")";
          return suggestion.value.replace(new RegExp(pattern, "gi"), "<strong>$1</strong>").replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/&lt;(\/?strong)&gt;/g, "<$1>");
        }
        function _formatGroup(suggestion, category) {
          return '<div class="autocomplete-group">' + category + "</div>";
        }
        Autocomplete.prototype = {
          initialize: function() {
            var that = this, suggestionSelector = "." + that.classes.suggestion, selected = that.classes.selected, options = that.options, container;
            that.element.setAttribute("autocomplete", "off");
            that.noSuggestionsContainer = $2('<div class="autocomplete-no-suggestion"></div>').html(this.options.noSuggestionNotice).get(0);
            that.suggestionsContainer = Autocomplete.utils.createNode(options.containerClass);
            container = $2(that.suggestionsContainer);
            container.appendTo(options.appendTo || "body");
            if (options.width !== "auto") {
              container.css("width", options.width);
            }
            container.on("mouseover.autocomplete", suggestionSelector, function() {
              that.activate($2(this).data("index"));
            });
            container.on("mouseout.autocomplete", function() {
              that.selectedIndex = -1;
              container.children("." + selected).removeClass(selected);
            });
            container.on("click.autocomplete", suggestionSelector, function() {
              that.select($2(this).data("index"));
            });
            container.on("click.autocomplete", function() {
              clearTimeout(that.blurTimeoutId);
            });
            that.fixPositionCapture = function() {
              if (that.visible) {
                that.fixPosition();
              }
            };
            $2(window).on("resize.autocomplete", that.fixPositionCapture);
            that.el.on("keydown.autocomplete", function(e) {
              that.onKeyPress(e);
            });
            that.el.on("keyup.autocomplete", function(e) {
              that.onKeyUp(e);
            });
            that.el.on("blur.autocomplete", function() {
              that.onBlur();
            });
            that.el.on("focus.autocomplete", function() {
              that.onFocus();
            });
            that.el.on("change.autocomplete", function(e) {
              that.onKeyUp(e);
            });
            that.el.on("input.autocomplete", function(e) {
              that.onKeyUp(e);
            });
          },
          onFocus: function() {
            var that = this;
            if (that.disabled) {
              return;
            }
            that.fixPosition();
            if (that.el.val().length >= that.options.minChars) {
              that.onValueChange();
            }
          },
          onBlur: function() {
            var that = this, options = that.options, value = that.el.val(), query = that.getQuery(value);
            that.blurTimeoutId = setTimeout(function() {
              that.hide();
              if (that.selection && that.currentValue !== query) {
                (options.onInvalidateSelection || $2.noop).call(that.element);
              }
            }, 200);
          },
          abortAjax: function() {
            var that = this;
            if (that.currentRequest) {
              that.currentRequest.abort();
              that.currentRequest = null;
            }
          },
          setOptions: function(suppliedOptions) {
            var that = this, options = $2.extend({}, that.options, suppliedOptions);
            that.isLocal = Array.isArray(options.lookup);
            if (that.isLocal) {
              options.lookup = that.verifySuggestionsFormat(options.lookup);
            }
            options.orientation = that.validateOrientation(options.orientation, "bottom");
            $2(that.suggestionsContainer).css({
              "max-height": options.maxHeight + "px",
              width: options.width + "px",
              "z-index": options.zIndex
            });
            this.options = options;
          },
          clearCache: function() {
            this.cachedResponse = {};
            this.badQueries = [];
          },
          clear: function() {
            this.clearCache();
            this.currentValue = "";
            this.suggestions = [];
          },
          disable: function() {
            var that = this;
            that.disabled = true;
            clearTimeout(that.onChangeTimeout);
            that.abortAjax();
          },
          enable: function() {
            this.disabled = false;
          },
          fixPosition: function() {
            var that = this, $container = $2(that.suggestionsContainer), containerParent = $container.parent().get(0);
            if (containerParent !== document.body && !that.options.forceFixPosition) {
              return;
            }
            var orientation = that.options.orientation, containerHeight = $container.outerHeight(), height = that.el.outerHeight(), offset = that.el.offset(), styles = { top: offset.top, left: offset.left };
            if (orientation === "auto") {
              var viewPortHeight = $2(window).height(), scrollTop = $2(window).scrollTop(), topOverflow = -scrollTop + offset.top - containerHeight, bottomOverflow = scrollTop + viewPortHeight - (offset.top + height + containerHeight);
              orientation = Math.max(topOverflow, bottomOverflow) === topOverflow ? "top" : "bottom";
            }
            if (orientation === "top") {
              styles.top += -containerHeight;
            } else {
              styles.top += height;
            }
            if (containerParent !== document.body) {
              var opacity = $container.css("opacity"), parentOffsetDiff;
              if (!that.visible) {
                $container.css("opacity", 0).show();
              }
              parentOffsetDiff = $container.offsetParent().offset();
              styles.top -= parentOffsetDiff.top;
              styles.top += containerParent.scrollTop;
              styles.left -= parentOffsetDiff.left;
              if (!that.visible) {
                $container.css("opacity", opacity).hide();
              }
            }
            if (that.options.width === "auto") {
              styles.width = that.el.outerWidth() + "px";
            }
            $container.css(styles);
          },
          isCursorAtEnd: function() {
            var that = this, valLength = that.el.val().length, selectionStart = that.element.selectionStart, range;
            if (typeof selectionStart === "number") {
              return selectionStart === valLength;
            }
            if (document.selection) {
              range = document.selection.createRange();
              range.moveStart("character", -valLength);
              return valLength === range.text.length;
            }
            return true;
          },
          onKeyPress: function(e) {
            var that = this;
            if (!that.disabled && !that.visible && e.which === keys.DOWN && that.currentValue) {
              that.suggest();
              return;
            }
            if (that.disabled || !that.visible) {
              return;
            }
            switch (e.which) {
              case keys.ESC:
                that.el.val(that.currentValue);
                that.hide();
                break;
              case keys.RIGHT:
                if (that.hint && that.options.onHint && that.isCursorAtEnd()) {
                  that.selectHint();
                  break;
                }
                return;
              case keys.TAB:
                if (that.hint && that.options.onHint) {
                  that.selectHint();
                  return;
                }
                if (that.selectedIndex === -1) {
                  that.hide();
                  return;
                }
                that.select(that.selectedIndex);
                if (that.options.tabDisabled === false) {
                  return;
                }
                break;
              case keys.RETURN:
                if (that.selectedIndex === -1) {
                  that.hide();
                  return;
                }
                that.select(that.selectedIndex);
                break;
              case keys.UP:
                that.moveUp();
                break;
              case keys.DOWN:
                that.moveDown();
                break;
              default:
                return;
            }
            e.stopImmediatePropagation();
            e.preventDefault();
          },
          onKeyUp: function(e) {
            var that = this;
            if (that.disabled) {
              return;
            }
            switch (e.which) {
              case keys.UP:
              case keys.DOWN:
                return;
            }
            clearTimeout(that.onChangeTimeout);
            if (that.currentValue !== that.el.val()) {
              that.findBestHint();
              if (that.options.deferRequestBy > 0) {
                that.onChangeTimeout = setTimeout(function() {
                  that.onValueChange();
                }, that.options.deferRequestBy);
              } else {
                that.onValueChange();
              }
            }
          },
          onValueChange: function() {
            if (this.ignoreValueChange) {
              this.ignoreValueChange = false;
              return;
            }
            var that = this, options = that.options, value = that.el.val(), query = that.getQuery(value);
            if (that.selection && that.currentValue !== query) {
              that.selection = null;
              (options.onInvalidateSelection || $2.noop).call(that.element);
            }
            clearTimeout(that.onChangeTimeout);
            that.currentValue = value;
            that.selectedIndex = -1;
            if (options.triggerSelectOnValidInput && that.isExactMatch(query)) {
              that.select(0);
              return;
            }
            if (query.length < options.minChars) {
              that.hide();
            } else {
              that.getSuggestions(query);
            }
          },
          isExactMatch: function(query) {
            var suggestions = this.suggestions;
            return suggestions.length === 1 && suggestions[0].value.toLowerCase() === query.toLowerCase();
          },
          getQuery: function(value) {
            var delimiter = this.options.delimiter, parts;
            if (!delimiter) {
              return value;
            }
            parts = value.split(delimiter);
            return parts[parts.length - 1].trim();
          },
          getSuggestionsLocal: function(query) {
            var that = this, options = that.options, queryLowerCase = query.toLowerCase(), filter = options.lookupFilter, limit = parseInt(options.lookupLimit, 10), data;
            data = {
              suggestions: $2.grep(options.lookup, function(suggestion) {
                return filter(suggestion, query, queryLowerCase);
              })
            };
            if (limit && data.suggestions.length > limit) {
              data.suggestions = data.suggestions.slice(0, limit);
            }
            return data;
          },
          getSuggestions: function(q) {
            var response, that = this, options = that.options, serviceUrl = options.serviceUrl, params, cacheKey, ajaxSettings;
            options.params[options.paramName] = q;
            if (options.onSearchStart.call(that.element, options.params) === false) {
              return;
            }
            params = options.ignoreParams ? null : options.params;
            if (typeof options.lookup === "function") {
              options.lookup(q, function(data) {
                that.suggestions = data.suggestions;
                that.suggest();
                options.onSearchComplete.call(that.element, q, data.suggestions);
              });
              return;
            }
            if (that.isLocal) {
              response = that.getSuggestionsLocal(q);
            } else {
              if (typeof serviceUrl === "function") {
                serviceUrl = serviceUrl.call(that.element, q);
              }
              cacheKey = serviceUrl + "?" + $2.param(params || {});
              response = that.cachedResponse[cacheKey];
            }
            if (response && Array.isArray(response.suggestions)) {
              that.suggestions = response.suggestions;
              that.suggest();
              options.onSearchComplete.call(that.element, q, response.suggestions);
            } else if (!that.isBadQuery(q)) {
              that.abortAjax();
              ajaxSettings = {
                url: serviceUrl,
                data: params,
                type: options.type,
                dataType: options.dataType
              };
              $2.extend(ajaxSettings, options.ajaxSettings);
              that.currentRequest = $2.ajax(ajaxSettings).done(function(data) {
                var result;
                that.currentRequest = null;
                result = options.transformResult(data, q);
                that.processResponse(result, q, cacheKey);
                options.onSearchComplete.call(that.element, q, result.suggestions);
              }).fail(function(jqXHR, textStatus, errorThrown) {
                options.onSearchError.call(
                  that.element,
                  q,
                  jqXHR,
                  textStatus,
                  errorThrown
                );
              });
            } else {
              options.onSearchComplete.call(that.element, q, []);
            }
          },
          isBadQuery: function(q) {
            if (!this.options.preventBadQueries) {
              return false;
            }
            var badQueries = this.badQueries, i2 = badQueries.length;
            while (i2--) {
              if (q.indexOf(badQueries[i2]) === 0) {
                return true;
              }
            }
            return false;
          },
          hide: function() {
            var that = this, container = $2(that.suggestionsContainer);
            if (typeof that.options.onHide === "function" && that.visible) {
              that.options.onHide.call(that.element, container);
            }
            that.visible = false;
            that.selectedIndex = -1;
            clearTimeout(that.onChangeTimeout);
            $2(that.suggestionsContainer).hide();
            that.onHint(null);
          },
          suggest: function() {
            if (!this.suggestions.length) {
              if (this.options.showNoSuggestionNotice) {
                this.noSuggestions();
              } else {
                this.hide();
              }
              return;
            }
            var that = this, options = that.options, groupBy = options.groupBy, formatResult = options.formatResult, value = that.getQuery(that.currentValue), className = that.classes.suggestion, classSelected = that.classes.selected, container = $2(that.suggestionsContainer), noSuggestionsContainer = $2(that.noSuggestionsContainer), beforeRender = options.beforeRender, html = "", category, formatGroup = function(suggestion) {
              var currentCategory = suggestion.data[groupBy];
              if (category === currentCategory) {
                return "";
              }
              category = currentCategory;
              return options.formatGroup(suggestion, category);
            };
            if (options.triggerSelectOnValidInput && that.isExactMatch(value)) {
              that.select(0);
              return;
            }
            $2.each(that.suggestions, function(i2, suggestion) {
              if (groupBy) {
                html += formatGroup(suggestion);
              }
              html += '<div class="' + className + '" data-index="' + i2 + '">' + formatResult(suggestion, value, i2) + "</div>";
            });
            this.adjustContainerWidth();
            noSuggestionsContainer.detach();
            container.html(html);
            if (typeof beforeRender === "function") {
              beforeRender.call(that.element, container, that.suggestions);
            }
            that.fixPosition();
            container.show();
            if (options.autoSelectFirst) {
              that.selectedIndex = 0;
              container.scrollTop(0);
              container.children("." + className).first().addClass(classSelected);
            }
            that.visible = true;
            that.findBestHint();
          },
          noSuggestions: function() {
            var that = this, beforeRender = that.options.beforeRender, container = $2(that.suggestionsContainer), noSuggestionsContainer = $2(that.noSuggestionsContainer);
            this.adjustContainerWidth();
            noSuggestionsContainer.detach();
            container.empty();
            container.append(noSuggestionsContainer);
            if (typeof beforeRender === "function") {
              beforeRender.call(that.element, container, that.suggestions);
            }
            that.fixPosition();
            container.show();
            that.visible = true;
          },
          adjustContainerWidth: function() {
            var that = this, options = that.options, width, container = $2(that.suggestionsContainer);
            if (options.width === "auto") {
              width = that.el.outerWidth();
              container.css("width", width > 0 ? width : 300);
            } else if (options.width === "flex") {
              container.css("width", "");
            }
          },
          findBestHint: function() {
            var that = this, value = that.el.val().toLowerCase(), bestMatch = null;
            if (!value) {
              return;
            }
            $2.each(that.suggestions, function(i2, suggestion) {
              var foundMatch = suggestion.value.toLowerCase().indexOf(value) === 0;
              if (foundMatch) {
                bestMatch = suggestion;
              }
              return !foundMatch;
            });
            that.onHint(bestMatch);
          },
          onHint: function(suggestion) {
            var that = this, onHintCallback = that.options.onHint, hintValue = "";
            if (suggestion) {
              hintValue = that.currentValue + suggestion.value.substr(that.currentValue.length);
            }
            if (that.hintValue !== hintValue) {
              that.hintValue = hintValue;
              that.hint = suggestion;
              if (typeof onHintCallback === "function") {
                onHintCallback.call(that.element, hintValue);
              }
            }
          },
          verifySuggestionsFormat: function(suggestions) {
            if (suggestions.length && typeof suggestions[0] === "string") {
              return $2.map(suggestions, function(value) {
                return { value, data: null };
              });
            }
            return suggestions;
          },
          validateOrientation: function(orientation, fallback) {
            orientation = (orientation || "").trim().toLowerCase();
            if ($2.inArray(orientation, ["auto", "bottom", "top"]) === -1) {
              orientation = fallback;
            }
            return orientation;
          },
          processResponse: function(result, originalQuery, cacheKey) {
            var that = this, options = that.options;
            result.suggestions = that.verifySuggestionsFormat(result.suggestions);
            if (!options.noCache) {
              that.cachedResponse[cacheKey] = result;
              if (options.preventBadQueries && !result.suggestions.length) {
                that.badQueries.push(originalQuery);
              }
            }
            if (originalQuery !== that.getQuery(that.currentValue)) {
              return;
            }
            that.suggestions = result.suggestions;
            that.suggest();
          },
          activate: function(index) {
            var that = this, activeItem, selected = that.classes.selected, container = $2(that.suggestionsContainer), children = container.find("." + that.classes.suggestion);
            container.find("." + selected).removeClass(selected);
            that.selectedIndex = index;
            if (that.selectedIndex !== -1 && children.length > that.selectedIndex) {
              activeItem = children.get(that.selectedIndex);
              $2(activeItem).addClass(selected);
              return activeItem;
            }
            return null;
          },
          selectHint: function() {
            var that = this, i2 = $2.inArray(that.hint, that.suggestions);
            that.select(i2);
          },
          select: function(i2) {
            var that = this;
            that.hide();
            that.onSelect(i2);
          },
          moveUp: function() {
            var that = this;
            if (that.selectedIndex === -1) {
              return;
            }
            if (that.selectedIndex === 0) {
              $2(that.suggestionsContainer).children("." + that.classes.suggestion).first().removeClass(that.classes.selected);
              that.selectedIndex = -1;
              that.ignoreValueChange = false;
              that.el.val(that.currentValue);
              that.findBestHint();
              return;
            }
            that.adjustScroll(that.selectedIndex - 1);
          },
          moveDown: function() {
            var that = this;
            if (that.selectedIndex === that.suggestions.length - 1) {
              return;
            }
            that.adjustScroll(that.selectedIndex + 1);
          },
          adjustScroll: function(index) {
            var that = this, activeItem = that.activate(index);
            if (!activeItem) {
              return;
            }
            var offsetTop, upperBound, lowerBound, heightDelta = $2(activeItem).outerHeight();
            offsetTop = activeItem.offsetTop;
            upperBound = $2(that.suggestionsContainer).scrollTop();
            lowerBound = upperBound + that.options.maxHeight - heightDelta;
            if (offsetTop < upperBound) {
              $2(that.suggestionsContainer).scrollTop(offsetTop);
            } else if (offsetTop > lowerBound) {
              $2(that.suggestionsContainer).scrollTop(
                offsetTop - that.options.maxHeight + heightDelta
              );
            }
            if (!that.options.preserveInput) {
              that.ignoreValueChange = true;
              that.el.val(that.getValue(that.suggestions[index].value));
            }
            that.onHint(null);
          },
          onSelect: function(index) {
            var that = this, onSelectCallback = that.options.onSelect, suggestion = that.suggestions[index];
            that.currentValue = that.getValue(suggestion.value);
            if (that.currentValue !== that.el.val() && !that.options.preserveInput) {
              that.el.val(that.currentValue);
            }
            that.onHint(null);
            that.suggestions = [];
            that.selection = suggestion;
            if (typeof onSelectCallback === "function") {
              onSelectCallback.call(that.element, suggestion);
            }
          },
          getValue: function(value) {
            var that = this, delimiter = that.options.delimiter, currentValue, parts;
            if (!delimiter) {
              return value;
            }
            currentValue = that.currentValue;
            parts = currentValue.split(delimiter);
            if (parts.length === 1) {
              return value;
            }
            return currentValue.substr(0, currentValue.length - parts[parts.length - 1].length) + value;
          },
          dispose: function() {
            var that = this;
            that.el.off(".autocomplete").removeData("autocomplete");
            $2(window).off("resize.autocomplete", that.fixPositionCapture);
            $2(that.suggestionsContainer).remove();
          }
        };
        $2.fn.devbridgeAutocomplete = function(options, args) {
          var dataKey = "autocomplete";
          if (!arguments.length) {
            return this.first().data(dataKey);
          }
          return this.each(function() {
            var inputElement = $2(this), instance = inputElement.data(dataKey);
            if (typeof options === "string") {
              if (instance && typeof instance[options] === "function") {
                instance[options](args);
              }
            } else {
              if (instance && instance.dispose) {
                instance.dispose();
              }
              instance = new Autocomplete(this, options);
              inputElement.data(dataKey, instance);
            }
          });
        };
        if (!$2.fn.autocomplete) {
          $2.fn.autocomplete = $2.fn.devbridgeAutocomplete;
        }
      }
    );
    var bootstrap_bundle_min$1 = { exports: {} };
    /*!
      * Bootstrap v5.3.7 (https://getbootstrap.com/)
      * Copyright 2011-2025 The Bootstrap Authors (https://github.com/twbs/bootstrap/graphs/contributors)
      * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
      */
    var bootstrap_bundle_min = bootstrap_bundle_min$1.exports;
    var hasRequiredBootstrap_bundle_min;
    function requireBootstrap_bundle_min() {
      if (hasRequiredBootstrap_bundle_min) return bootstrap_bundle_min$1.exports;
      hasRequiredBootstrap_bundle_min = 1;
      (function(module2, exports2) {
        !(function(t, e) {
          module2.exports = e();
        })(bootstrap_bundle_min, (function() {
          const t = /* @__PURE__ */ new Map(), e = { set(e2, i3, n2) {
            t.has(e2) || t.set(e2, /* @__PURE__ */ new Map());
            const s2 = t.get(e2);
            s2.has(i3) || 0 === s2.size ? s2.set(i3, n2) : console.error(`Bootstrap doesn't allow more than one instance per element. Bound instance: ${Array.from(s2.keys())[0]}.`);
          }, get: (e2, i3) => t.has(e2) && t.get(e2).get(i3) || null, remove(e2, i3) {
            if (!t.has(e2)) return;
            const n2 = t.get(e2);
            n2.delete(i3), 0 === n2.size && t.delete(e2);
          } }, i2 = "transitionend", n = (t2) => (t2 && window.CSS && window.CSS.escape && (t2 = t2.replace(/#([^\s"#']+)/g, ((t3, e2) => `#${CSS.escape(e2)}`))), t2), s = (t2) => {
            t2.dispatchEvent(new Event(i2));
          }, o = (t2) => !(!t2 || "object" != typeof t2) && (void 0 !== t2.jquery && (t2 = t2[0]), void 0 !== t2.nodeType), r = (t2) => o(t2) ? t2.jquery ? t2[0] : t2 : "string" == typeof t2 && t2.length > 0 ? document.querySelector(n(t2)) : null, a = (t2) => {
            if (!o(t2) || 0 === t2.getClientRects().length) return false;
            const e2 = "visible" === getComputedStyle(t2).getPropertyValue("visibility"), i3 = t2.closest("details:not([open])");
            if (!i3) return e2;
            if (i3 !== t2) {
              const e3 = t2.closest("summary");
              if (e3 && e3.parentNode !== i3) return false;
              if (null === e3) return false;
            }
            return e2;
          }, l = (t2) => !t2 || t2.nodeType !== Node.ELEMENT_NODE || !!t2.classList.contains("disabled") || (void 0 !== t2.disabled ? t2.disabled : t2.hasAttribute("disabled") && "false" !== t2.getAttribute("disabled")), c = (t2) => {
            if (!document.documentElement.attachShadow) return null;
            if ("function" == typeof t2.getRootNode) {
              const e2 = t2.getRootNode();
              return e2 instanceof ShadowRoot ? e2 : null;
            }
            return t2 instanceof ShadowRoot ? t2 : t2.parentNode ? c(t2.parentNode) : null;
          }, h = () => {
          }, d = (t2) => {
            t2.offsetHeight;
          }, u = () => window.jQuery && !document.body.hasAttribute("data-bs-no-jquery") ? window.jQuery : null, f = [], p = () => "rtl" === document.documentElement.dir, m = (t2) => {
            var e2;
            e2 = () => {
              const e3 = u();
              if (e3) {
                const i3 = t2.NAME, n2 = e3.fn[i3];
                e3.fn[i3] = t2.jQueryInterface, e3.fn[i3].Constructor = t2, e3.fn[i3].noConflict = () => (e3.fn[i3] = n2, t2.jQueryInterface);
              }
            }, "loading" === document.readyState ? (f.length || document.addEventListener("DOMContentLoaded", (() => {
              for (const t3 of f) t3();
            })), f.push(e2)) : e2();
          }, g = (t2, e2 = [], i3 = t2) => "function" == typeof t2 ? t2.call(...e2) : i3, _ = (t2, e2, n2 = true) => {
            if (!n2) return void g(t2);
            const o2 = ((t3) => {
              if (!t3) return 0;
              let { transitionDuration: e3, transitionDelay: i3 } = window.getComputedStyle(t3);
              const n3 = Number.parseFloat(e3), s2 = Number.parseFloat(i3);
              return n3 || s2 ? (e3 = e3.split(",")[0], i3 = i3.split(",")[0], 1e3 * (Number.parseFloat(e3) + Number.parseFloat(i3))) : 0;
            })(e2) + 5;
            let r2 = false;
            const a2 = ({ target: n3 }) => {
              n3 === e2 && (r2 = true, e2.removeEventListener(i2, a2), g(t2));
            };
            e2.addEventListener(i2, a2), setTimeout((() => {
              r2 || s(e2);
            }), o2);
          }, b = (t2, e2, i3, n2) => {
            const s2 = t2.length;
            let o2 = t2.indexOf(e2);
            return -1 === o2 ? !i3 && n2 ? t2[s2 - 1] : t2[0] : (o2 += i3 ? 1 : -1, n2 && (o2 = (o2 + s2) % s2), t2[Math.max(0, Math.min(o2, s2 - 1))]);
          }, v = /[^.]*(?=\..*)\.|.*/, y = /\..*/, w = /::\d+$/, A = {};
          let E = 1;
          const T = { mouseenter: "mouseover", mouseleave: "mouseout" }, C = /* @__PURE__ */ new Set(["click", "dblclick", "mouseup", "mousedown", "contextmenu", "mousewheel", "DOMMouseScroll", "mouseover", "mouseout", "mousemove", "selectstart", "selectend", "keydown", "keypress", "keyup", "orientationchange", "touchstart", "touchmove", "touchend", "touchcancel", "pointerdown", "pointermove", "pointerup", "pointerleave", "pointercancel", "gesturestart", "gesturechange", "gestureend", "focus", "blur", "change", "reset", "select", "submit", "focusin", "focusout", "load", "unload", "beforeunload", "resize", "move", "DOMContentLoaded", "readystatechange", "error", "abort", "scroll"]);
          function O(t2, e2) {
            return e2 && `${e2}::${E++}` || t2.uidEvent || E++;
          }
          function x(t2) {
            const e2 = O(t2);
            return t2.uidEvent = e2, A[e2] = A[e2] || {}, A[e2];
          }
          function k(t2, e2, i3 = null) {
            return Object.values(t2).find(((t3) => t3.callable === e2 && t3.delegationSelector === i3));
          }
          function L(t2, e2, i3) {
            const n2 = "string" == typeof e2, s2 = n2 ? i3 : e2 || i3;
            let o2 = I(t2);
            return C.has(o2) || (o2 = t2), [n2, s2, o2];
          }
          function S(t2, e2, i3, n2, s2) {
            if ("string" != typeof e2 || !t2) return;
            let [o2, r2, a2] = L(e2, i3, n2);
            if (e2 in T) {
              const t3 = (t4) => function(e3) {
                if (!e3.relatedTarget || e3.relatedTarget !== e3.delegateTarget && !e3.delegateTarget.contains(e3.relatedTarget)) return t4.call(this, e3);
              };
              r2 = t3(r2);
            }
            const l2 = x(t2), c2 = l2[a2] || (l2[a2] = {}), h2 = k(c2, r2, o2 ? i3 : null);
            if (h2) return void (h2.oneOff = h2.oneOff && s2);
            const d2 = O(r2, e2.replace(v, "")), u2 = o2 ? /* @__PURE__ */ (function(t3, e3, i4) {
              return function n3(s3) {
                const o3 = t3.querySelectorAll(e3);
                for (let { target: r3 } = s3; r3 && r3 !== this; r3 = r3.parentNode) for (const a3 of o3) if (a3 === r3) return P(s3, { delegateTarget: r3 }), n3.oneOff && N.off(t3, s3.type, e3, i4), i4.apply(r3, [s3]);
              };
            })(t2, i3, r2) : /* @__PURE__ */ (function(t3, e3) {
              return function i4(n3) {
                return P(n3, { delegateTarget: t3 }), i4.oneOff && N.off(t3, n3.type, e3), e3.apply(t3, [n3]);
              };
            })(t2, r2);
            u2.delegationSelector = o2 ? i3 : null, u2.callable = r2, u2.oneOff = s2, u2.uidEvent = d2, c2[d2] = u2, t2.addEventListener(a2, u2, o2);
          }
          function D(t2, e2, i3, n2, s2) {
            const o2 = k(e2[i3], n2, s2);
            o2 && (t2.removeEventListener(i3, o2, Boolean(s2)), delete e2[i3][o2.uidEvent]);
          }
          function $2(t2, e2, i3, n2) {
            const s2 = e2[i3] || {};
            for (const [o2, r2] of Object.entries(s2)) o2.includes(n2) && D(t2, e2, i3, r2.callable, r2.delegationSelector);
          }
          function I(t2) {
            return t2 = t2.replace(y, ""), T[t2] || t2;
          }
          const N = { on(t2, e2, i3, n2) {
            S(t2, e2, i3, n2, false);
          }, one(t2, e2, i3, n2) {
            S(t2, e2, i3, n2, true);
          }, off(t2, e2, i3, n2) {
            if ("string" != typeof e2 || !t2) return;
            const [s2, o2, r2] = L(e2, i3, n2), a2 = r2 !== e2, l2 = x(t2), c2 = l2[r2] || {}, h2 = e2.startsWith(".");
            if (void 0 === o2) {
              if (h2) for (const i4 of Object.keys(l2)) $2(t2, l2, i4, e2.slice(1));
              for (const [i4, n3] of Object.entries(c2)) {
                const s3 = i4.replace(w, "");
                a2 && !e2.includes(s3) || D(t2, l2, r2, n3.callable, n3.delegationSelector);
              }
            } else {
              if (!Object.keys(c2).length) return;
              D(t2, l2, r2, o2, s2 ? i3 : null);
            }
          }, trigger(t2, e2, i3) {
            if ("string" != typeof e2 || !t2) return null;
            const n2 = u();
            let s2 = null, o2 = true, r2 = true, a2 = false;
            e2 !== I(e2) && n2 && (s2 = n2.Event(e2, i3), n2(t2).trigger(s2), o2 = !s2.isPropagationStopped(), r2 = !s2.isImmediatePropagationStopped(), a2 = s2.isDefaultPrevented());
            const l2 = P(new Event(e2, { bubbles: o2, cancelable: true }), i3);
            return a2 && l2.preventDefault(), r2 && t2.dispatchEvent(l2), l2.defaultPrevented && s2 && s2.preventDefault(), l2;
          } };
          function P(t2, e2 = {}) {
            for (const [i3, n2] of Object.entries(e2)) try {
              t2[i3] = n2;
            } catch (e3) {
              Object.defineProperty(t2, i3, { configurable: true, get: () => n2 });
            }
            return t2;
          }
          function j(t2) {
            if ("true" === t2) return true;
            if ("false" === t2) return false;
            if (t2 === Number(t2).toString()) return Number(t2);
            if ("" === t2 || "null" === t2) return null;
            if ("string" != typeof t2) return t2;
            try {
              return JSON.parse(decodeURIComponent(t2));
            } catch (e2) {
              return t2;
            }
          }
          function M(t2) {
            return t2.replace(/[A-Z]/g, ((t3) => `-${t3.toLowerCase()}`));
          }
          const F = { setDataAttribute(t2, e2, i3) {
            t2.setAttribute(`data-bs-${M(e2)}`, i3);
          }, removeDataAttribute(t2, e2) {
            t2.removeAttribute(`data-bs-${M(e2)}`);
          }, getDataAttributes(t2) {
            if (!t2) return {};
            const e2 = {}, i3 = Object.keys(t2.dataset).filter(((t3) => t3.startsWith("bs") && !t3.startsWith("bsConfig")));
            for (const n2 of i3) {
              let i4 = n2.replace(/^bs/, "");
              i4 = i4.charAt(0).toLowerCase() + i4.slice(1), e2[i4] = j(t2.dataset[n2]);
            }
            return e2;
          }, getDataAttribute: (t2, e2) => j(t2.getAttribute(`data-bs-${M(e2)}`)) };
          class H {
            static get Default() {
              return {};
            }
            static get DefaultType() {
              return {};
            }
            static get NAME() {
              throw new Error('You have to implement the static method "NAME", for each component!');
            }
            _getConfig(t2) {
              return t2 = this._mergeConfigObj(t2), t2 = this._configAfterMerge(t2), this._typeCheckConfig(t2), t2;
            }
            _configAfterMerge(t2) {
              return t2;
            }
            _mergeConfigObj(t2, e2) {
              const i3 = o(e2) ? F.getDataAttribute(e2, "config") : {};
              return { ...this.constructor.Default, ..."object" == typeof i3 ? i3 : {}, ...o(e2) ? F.getDataAttributes(e2) : {}, ..."object" == typeof t2 ? t2 : {} };
            }
            _typeCheckConfig(t2, e2 = this.constructor.DefaultType) {
              for (const [n2, s2] of Object.entries(e2)) {
                const e3 = t2[n2], r2 = o(e3) ? "element" : null == (i3 = e3) ? `${i3}` : Object.prototype.toString.call(i3).match(/\s([a-z]+)/i)[1].toLowerCase();
                if (!new RegExp(s2).test(r2)) throw new TypeError(`${this.constructor.NAME.toUpperCase()}: Option "${n2}" provided type "${r2}" but expected type "${s2}".`);
              }
              var i3;
            }
          }
          class W extends H {
            constructor(t2, i3) {
              super(), (t2 = r(t2)) && (this._element = t2, this._config = this._getConfig(i3), e.set(this._element, this.constructor.DATA_KEY, this));
            }
            dispose() {
              e.remove(this._element, this.constructor.DATA_KEY), N.off(this._element, this.constructor.EVENT_KEY);
              for (const t2 of Object.getOwnPropertyNames(this)) this[t2] = null;
            }
            _queueCallback(t2, e2, i3 = true) {
              _(t2, e2, i3);
            }
            _getConfig(t2) {
              return t2 = this._mergeConfigObj(t2, this._element), t2 = this._configAfterMerge(t2), this._typeCheckConfig(t2), t2;
            }
            static getInstance(t2) {
              return e.get(r(t2), this.DATA_KEY);
            }
            static getOrCreateInstance(t2, e2 = {}) {
              return this.getInstance(t2) || new this(t2, "object" == typeof e2 ? e2 : null);
            }
            static get VERSION() {
              return "5.3.7";
            }
            static get DATA_KEY() {
              return `bs.${this.NAME}`;
            }
            static get EVENT_KEY() {
              return `.${this.DATA_KEY}`;
            }
            static eventName(t2) {
              return `${t2}${this.EVENT_KEY}`;
            }
          }
          const B = (t2) => {
            let e2 = t2.getAttribute("data-bs-target");
            if (!e2 || "#" === e2) {
              let i3 = t2.getAttribute("href");
              if (!i3 || !i3.includes("#") && !i3.startsWith(".")) return null;
              i3.includes("#") && !i3.startsWith("#") && (i3 = `#${i3.split("#")[1]}`), e2 = i3 && "#" !== i3 ? i3.trim() : null;
            }
            return e2 ? e2.split(",").map(((t3) => n(t3))).join(",") : null;
          }, z = { find: (t2, e2 = document.documentElement) => [].concat(...Element.prototype.querySelectorAll.call(e2, t2)), findOne: (t2, e2 = document.documentElement) => Element.prototype.querySelector.call(e2, t2), children: (t2, e2) => [].concat(...t2.children).filter(((t3) => t3.matches(e2))), parents(t2, e2) {
            const i3 = [];
            let n2 = t2.parentNode.closest(e2);
            for (; n2; ) i3.push(n2), n2 = n2.parentNode.closest(e2);
            return i3;
          }, prev(t2, e2) {
            let i3 = t2.previousElementSibling;
            for (; i3; ) {
              if (i3.matches(e2)) return [i3];
              i3 = i3.previousElementSibling;
            }
            return [];
          }, next(t2, e2) {
            let i3 = t2.nextElementSibling;
            for (; i3; ) {
              if (i3.matches(e2)) return [i3];
              i3 = i3.nextElementSibling;
            }
            return [];
          }, focusableChildren(t2) {
            const e2 = ["a", "button", "input", "textarea", "select", "details", "[tabindex]", '[contenteditable="true"]'].map(((t3) => `${t3}:not([tabindex^="-"])`)).join(",");
            return this.find(e2, t2).filter(((t3) => !l(t3) && a(t3)));
          }, getSelectorFromElement(t2) {
            const e2 = B(t2);
            return e2 && z.findOne(e2) ? e2 : null;
          }, getElementFromSelector(t2) {
            const e2 = B(t2);
            return e2 ? z.findOne(e2) : null;
          }, getMultipleElementsFromSelector(t2) {
            const e2 = B(t2);
            return e2 ? z.find(e2) : [];
          } }, R = (t2, e2 = "hide") => {
            const i3 = `click.dismiss${t2.EVENT_KEY}`, n2 = t2.NAME;
            N.on(document, i3, `[data-bs-dismiss="${n2}"]`, (function(i4) {
              if (["A", "AREA"].includes(this.tagName) && i4.preventDefault(), l(this)) return;
              const s2 = z.getElementFromSelector(this) || this.closest(`.${n2}`);
              t2.getOrCreateInstance(s2)[e2]();
            }));
          }, q = ".bs.alert", V = `close${q}`, K = `closed${q}`;
          class Q extends W {
            static get NAME() {
              return "alert";
            }
            close() {
              if (N.trigger(this._element, V).defaultPrevented) return;
              this._element.classList.remove("show");
              const t2 = this._element.classList.contains("fade");
              this._queueCallback((() => this._destroyElement()), this._element, t2);
            }
            _destroyElement() {
              this._element.remove(), N.trigger(this._element, K), this.dispose();
            }
            static jQueryInterface(t2) {
              return this.each((function() {
                const e2 = Q.getOrCreateInstance(this);
                if ("string" == typeof t2) {
                  if (void 0 === e2[t2] || t2.startsWith("_") || "constructor" === t2) throw new TypeError(`No method named "${t2}"`);
                  e2[t2](this);
                }
              }));
            }
          }
          R(Q, "close"), m(Q);
          const X = '[data-bs-toggle="button"]';
          class Y extends W {
            static get NAME() {
              return "button";
            }
            toggle() {
              this._element.setAttribute("aria-pressed", this._element.classList.toggle("active"));
            }
            static jQueryInterface(t2) {
              return this.each((function() {
                const e2 = Y.getOrCreateInstance(this);
                "toggle" === t2 && e2[t2]();
              }));
            }
          }
          N.on(document, "click.bs.button.data-api", X, ((t2) => {
            t2.preventDefault();
            const e2 = t2.target.closest(X);
            Y.getOrCreateInstance(e2).toggle();
          })), m(Y);
          const U = ".bs.swipe", G = `touchstart${U}`, J = `touchmove${U}`, Z = `touchend${U}`, tt = `pointerdown${U}`, et = `pointerup${U}`, it = { endCallback: null, leftCallback: null, rightCallback: null }, nt = { endCallback: "(function|null)", leftCallback: "(function|null)", rightCallback: "(function|null)" };
          class st extends H {
            constructor(t2, e2) {
              super(), this._element = t2, t2 && st.isSupported() && (this._config = this._getConfig(e2), this._deltaX = 0, this._supportPointerEvents = Boolean(window.PointerEvent), this._initEvents());
            }
            static get Default() {
              return it;
            }
            static get DefaultType() {
              return nt;
            }
            static get NAME() {
              return "swipe";
            }
            dispose() {
              N.off(this._element, U);
            }
            _start(t2) {
              this._supportPointerEvents ? this._eventIsPointerPenTouch(t2) && (this._deltaX = t2.clientX) : this._deltaX = t2.touches[0].clientX;
            }
            _end(t2) {
              this._eventIsPointerPenTouch(t2) && (this._deltaX = t2.clientX - this._deltaX), this._handleSwipe(), g(this._config.endCallback);
            }
            _move(t2) {
              this._deltaX = t2.touches && t2.touches.length > 1 ? 0 : t2.touches[0].clientX - this._deltaX;
            }
            _handleSwipe() {
              const t2 = Math.abs(this._deltaX);
              if (t2 <= 40) return;
              const e2 = t2 / this._deltaX;
              this._deltaX = 0, e2 && g(e2 > 0 ? this._config.rightCallback : this._config.leftCallback);
            }
            _initEvents() {
              this._supportPointerEvents ? (N.on(this._element, tt, ((t2) => this._start(t2))), N.on(this._element, et, ((t2) => this._end(t2))), this._element.classList.add("pointer-event")) : (N.on(this._element, G, ((t2) => this._start(t2))), N.on(this._element, J, ((t2) => this._move(t2))), N.on(this._element, Z, ((t2) => this._end(t2))));
            }
            _eventIsPointerPenTouch(t2) {
              return this._supportPointerEvents && ("pen" === t2.pointerType || "touch" === t2.pointerType);
            }
            static isSupported() {
              return "ontouchstart" in document.documentElement || navigator.maxTouchPoints > 0;
            }
          }
          const ot = ".bs.carousel", rt = ".data-api", at = "ArrowLeft", lt = "ArrowRight", ct = "next", ht = "prev", dt = "left", ut = "right", ft = `slide${ot}`, pt = `slid${ot}`, mt = `keydown${ot}`, gt = `mouseenter${ot}`, _t = `mouseleave${ot}`, bt = `dragstart${ot}`, vt = `load${ot}${rt}`, yt = `click${ot}${rt}`, wt = "carousel", At = "active", Et = ".active", Tt = ".carousel-item", Ct = Et + Tt, Ot = { [at]: ut, [lt]: dt }, xt = { interval: 5e3, keyboard: true, pause: "hover", ride: false, touch: true, wrap: true }, kt = { interval: "(number|boolean)", keyboard: "boolean", pause: "(string|boolean)", ride: "(boolean|string)", touch: "boolean", wrap: "boolean" };
          class Lt extends W {
            constructor(t2, e2) {
              super(t2, e2), this._interval = null, this._activeElement = null, this._isSliding = false, this.touchTimeout = null, this._swipeHelper = null, this._indicatorsElement = z.findOne(".carousel-indicators", this._element), this._addEventListeners(), this._config.ride === wt && this.cycle();
            }
            static get Default() {
              return xt;
            }
            static get DefaultType() {
              return kt;
            }
            static get NAME() {
              return "carousel";
            }
            next() {
              this._slide(ct);
            }
            nextWhenVisible() {
              !document.hidden && a(this._element) && this.next();
            }
            prev() {
              this._slide(ht);
            }
            pause() {
              this._isSliding && s(this._element), this._clearInterval();
            }
            cycle() {
              this._clearInterval(), this._updateInterval(), this._interval = setInterval((() => this.nextWhenVisible()), this._config.interval);
            }
            _maybeEnableCycle() {
              this._config.ride && (this._isSliding ? N.one(this._element, pt, (() => this.cycle())) : this.cycle());
            }
            to(t2) {
              const e2 = this._getItems();
              if (t2 > e2.length - 1 || t2 < 0) return;
              if (this._isSliding) return void N.one(this._element, pt, (() => this.to(t2)));
              const i3 = this._getItemIndex(this._getActive());
              if (i3 === t2) return;
              const n2 = t2 > i3 ? ct : ht;
              this._slide(n2, e2[t2]);
            }
            dispose() {
              this._swipeHelper && this._swipeHelper.dispose(), super.dispose();
            }
            _configAfterMerge(t2) {
              return t2.defaultInterval = t2.interval, t2;
            }
            _addEventListeners() {
              this._config.keyboard && N.on(this._element, mt, ((t2) => this._keydown(t2))), "hover" === this._config.pause && (N.on(this._element, gt, (() => this.pause())), N.on(this._element, _t, (() => this._maybeEnableCycle()))), this._config.touch && st.isSupported() && this._addTouchEventListeners();
            }
            _addTouchEventListeners() {
              for (const t3 of z.find(".carousel-item img", this._element)) N.on(t3, bt, ((t4) => t4.preventDefault()));
              const t2 = { leftCallback: () => this._slide(this._directionToOrder(dt)), rightCallback: () => this._slide(this._directionToOrder(ut)), endCallback: () => {
                "hover" === this._config.pause && (this.pause(), this.touchTimeout && clearTimeout(this.touchTimeout), this.touchTimeout = setTimeout((() => this._maybeEnableCycle()), 500 + this._config.interval));
              } };
              this._swipeHelper = new st(this._element, t2);
            }
            _keydown(t2) {
              if (/input|textarea/i.test(t2.target.tagName)) return;
              const e2 = Ot[t2.key];
              e2 && (t2.preventDefault(), this._slide(this._directionToOrder(e2)));
            }
            _getItemIndex(t2) {
              return this._getItems().indexOf(t2);
            }
            _setActiveIndicatorElement(t2) {
              if (!this._indicatorsElement) return;
              const e2 = z.findOne(Et, this._indicatorsElement);
              e2.classList.remove(At), e2.removeAttribute("aria-current");
              const i3 = z.findOne(`[data-bs-slide-to="${t2}"]`, this._indicatorsElement);
              i3 && (i3.classList.add(At), i3.setAttribute("aria-current", "true"));
            }
            _updateInterval() {
              const t2 = this._activeElement || this._getActive();
              if (!t2) return;
              const e2 = Number.parseInt(t2.getAttribute("data-bs-interval"), 10);
              this._config.interval = e2 || this._config.defaultInterval;
            }
            _slide(t2, e2 = null) {
              if (this._isSliding) return;
              const i3 = this._getActive(), n2 = t2 === ct, s2 = e2 || b(this._getItems(), i3, n2, this._config.wrap);
              if (s2 === i3) return;
              const o2 = this._getItemIndex(s2), r2 = (e3) => N.trigger(this._element, e3, { relatedTarget: s2, direction: this._orderToDirection(t2), from: this._getItemIndex(i3), to: o2 });
              if (r2(ft).defaultPrevented) return;
              if (!i3 || !s2) return;
              const a2 = Boolean(this._interval);
              this.pause(), this._isSliding = true, this._setActiveIndicatorElement(o2), this._activeElement = s2;
              const l2 = n2 ? "carousel-item-start" : "carousel-item-end", c2 = n2 ? "carousel-item-next" : "carousel-item-prev";
              s2.classList.add(c2), d(s2), i3.classList.add(l2), s2.classList.add(l2), this._queueCallback((() => {
                s2.classList.remove(l2, c2), s2.classList.add(At), i3.classList.remove(At, c2, l2), this._isSliding = false, r2(pt);
              }), i3, this._isAnimated()), a2 && this.cycle();
            }
            _isAnimated() {
              return this._element.classList.contains("slide");
            }
            _getActive() {
              return z.findOne(Ct, this._element);
            }
            _getItems() {
              return z.find(Tt, this._element);
            }
            _clearInterval() {
              this._interval && (clearInterval(this._interval), this._interval = null);
            }
            _directionToOrder(t2) {
              return p() ? t2 === dt ? ht : ct : t2 === dt ? ct : ht;
            }
            _orderToDirection(t2) {
              return p() ? t2 === ht ? dt : ut : t2 === ht ? ut : dt;
            }
            static jQueryInterface(t2) {
              return this.each((function() {
                const e2 = Lt.getOrCreateInstance(this, t2);
                if ("number" != typeof t2) {
                  if ("string" == typeof t2) {
                    if (void 0 === e2[t2] || t2.startsWith("_") || "constructor" === t2) throw new TypeError(`No method named "${t2}"`);
                    e2[t2]();
                  }
                } else e2.to(t2);
              }));
            }
          }
          N.on(document, yt, "[data-bs-slide], [data-bs-slide-to]", (function(t2) {
            const e2 = z.getElementFromSelector(this);
            if (!e2 || !e2.classList.contains(wt)) return;
            t2.preventDefault();
            const i3 = Lt.getOrCreateInstance(e2), n2 = this.getAttribute("data-bs-slide-to");
            return n2 ? (i3.to(n2), void i3._maybeEnableCycle()) : "next" === F.getDataAttribute(this, "slide") ? (i3.next(), void i3._maybeEnableCycle()) : (i3.prev(), void i3._maybeEnableCycle());
          })), N.on(window, vt, (() => {
            const t2 = z.find('[data-bs-ride="carousel"]');
            for (const e2 of t2) Lt.getOrCreateInstance(e2);
          })), m(Lt);
          const St = ".bs.collapse", Dt = `show${St}`, $t = `shown${St}`, It = `hide${St}`, Nt = `hidden${St}`, Pt = `click${St}.data-api`, jt = "show", Mt = "collapse", Ft = "collapsing", Ht = `:scope .${Mt} .${Mt}`, Wt = '[data-bs-toggle="collapse"]', Bt = { parent: null, toggle: true }, zt = { parent: "(null|element)", toggle: "boolean" };
          class Rt extends W {
            constructor(t2, e2) {
              super(t2, e2), this._isTransitioning = false, this._triggerArray = [];
              const i3 = z.find(Wt);
              for (const t3 of i3) {
                const e3 = z.getSelectorFromElement(t3), i4 = z.find(e3).filter(((t4) => t4 === this._element));
                null !== e3 && i4.length && this._triggerArray.push(t3);
              }
              this._initializeChildren(), this._config.parent || this._addAriaAndCollapsedClass(this._triggerArray, this._isShown()), this._config.toggle && this.toggle();
            }
            static get Default() {
              return Bt;
            }
            static get DefaultType() {
              return zt;
            }
            static get NAME() {
              return "collapse";
            }
            toggle() {
              this._isShown() ? this.hide() : this.show();
            }
            show() {
              if (this._isTransitioning || this._isShown()) return;
              let t2 = [];
              if (this._config.parent && (t2 = this._getFirstLevelChildren(".collapse.show, .collapse.collapsing").filter(((t3) => t3 !== this._element)).map(((t3) => Rt.getOrCreateInstance(t3, { toggle: false })))), t2.length && t2[0]._isTransitioning) return;
              if (N.trigger(this._element, Dt).defaultPrevented) return;
              for (const e3 of t2) e3.hide();
              const e2 = this._getDimension();
              this._element.classList.remove(Mt), this._element.classList.add(Ft), this._element.style[e2] = 0, this._addAriaAndCollapsedClass(this._triggerArray, true), this._isTransitioning = true;
              const i3 = `scroll${e2[0].toUpperCase() + e2.slice(1)}`;
              this._queueCallback((() => {
                this._isTransitioning = false, this._element.classList.remove(Ft), this._element.classList.add(Mt, jt), this._element.style[e2] = "", N.trigger(this._element, $t);
              }), this._element, true), this._element.style[e2] = `${this._element[i3]}px`;
            }
            hide() {
              if (this._isTransitioning || !this._isShown()) return;
              if (N.trigger(this._element, It).defaultPrevented) return;
              const t2 = this._getDimension();
              this._element.style[t2] = `${this._element.getBoundingClientRect()[t2]}px`, d(this._element), this._element.classList.add(Ft), this._element.classList.remove(Mt, jt);
              for (const t3 of this._triggerArray) {
                const e2 = z.getElementFromSelector(t3);
                e2 && !this._isShown(e2) && this._addAriaAndCollapsedClass([t3], false);
              }
              this._isTransitioning = true, this._element.style[t2] = "", this._queueCallback((() => {
                this._isTransitioning = false, this._element.classList.remove(Ft), this._element.classList.add(Mt), N.trigger(this._element, Nt);
              }), this._element, true);
            }
            _isShown(t2 = this._element) {
              return t2.classList.contains(jt);
            }
            _configAfterMerge(t2) {
              return t2.toggle = Boolean(t2.toggle), t2.parent = r(t2.parent), t2;
            }
            _getDimension() {
              return this._element.classList.contains("collapse-horizontal") ? "width" : "height";
            }
            _initializeChildren() {
              if (!this._config.parent) return;
              const t2 = this._getFirstLevelChildren(Wt);
              for (const e2 of t2) {
                const t3 = z.getElementFromSelector(e2);
                t3 && this._addAriaAndCollapsedClass([e2], this._isShown(t3));
              }
            }
            _getFirstLevelChildren(t2) {
              const e2 = z.find(Ht, this._config.parent);
              return z.find(t2, this._config.parent).filter(((t3) => !e2.includes(t3)));
            }
            _addAriaAndCollapsedClass(t2, e2) {
              if (t2.length) for (const i3 of t2) i3.classList.toggle("collapsed", !e2), i3.setAttribute("aria-expanded", e2);
            }
            static jQueryInterface(t2) {
              const e2 = {};
              return "string" == typeof t2 && /show|hide/.test(t2) && (e2.toggle = false), this.each((function() {
                const i3 = Rt.getOrCreateInstance(this, e2);
                if ("string" == typeof t2) {
                  if (void 0 === i3[t2]) throw new TypeError(`No method named "${t2}"`);
                  i3[t2]();
                }
              }));
            }
          }
          N.on(document, Pt, Wt, (function(t2) {
            ("A" === t2.target.tagName || t2.delegateTarget && "A" === t2.delegateTarget.tagName) && t2.preventDefault();
            for (const t3 of z.getMultipleElementsFromSelector(this)) Rt.getOrCreateInstance(t3, { toggle: false }).toggle();
          })), m(Rt);
          var qt = "top", Vt = "bottom", Kt = "right", Qt = "left", Xt = "auto", Yt = [qt, Vt, Kt, Qt], Ut = "start", Gt = "end", Jt = "clippingParents", Zt = "viewport", te = "popper", ee = "reference", ie = Yt.reduce((function(t2, e2) {
            return t2.concat([e2 + "-" + Ut, e2 + "-" + Gt]);
          }), []), ne = [].concat(Yt, [Xt]).reduce((function(t2, e2) {
            return t2.concat([e2, e2 + "-" + Ut, e2 + "-" + Gt]);
          }), []), se = "beforeRead", oe = "read", re = "afterRead", ae = "beforeMain", le = "main", ce = "afterMain", he = "beforeWrite", de = "write", ue = "afterWrite", fe = [se, oe, re, ae, le, ce, he, de, ue];
          function pe(t2) {
            return t2 ? (t2.nodeName || "").toLowerCase() : null;
          }
          function me(t2) {
            if (null == t2) return window;
            if ("[object Window]" !== t2.toString()) {
              var e2 = t2.ownerDocument;
              return e2 && e2.defaultView || window;
            }
            return t2;
          }
          function ge(t2) {
            return t2 instanceof me(t2).Element || t2 instanceof Element;
          }
          function _e(t2) {
            return t2 instanceof me(t2).HTMLElement || t2 instanceof HTMLElement;
          }
          function be(t2) {
            return "undefined" != typeof ShadowRoot && (t2 instanceof me(t2).ShadowRoot || t2 instanceof ShadowRoot);
          }
          const ve = { name: "applyStyles", enabled: true, phase: "write", fn: function(t2) {
            var e2 = t2.state;
            Object.keys(e2.elements).forEach((function(t3) {
              var i3 = e2.styles[t3] || {}, n2 = e2.attributes[t3] || {}, s2 = e2.elements[t3];
              _e(s2) && pe(s2) && (Object.assign(s2.style, i3), Object.keys(n2).forEach((function(t4) {
                var e3 = n2[t4];
                false === e3 ? s2.removeAttribute(t4) : s2.setAttribute(t4, true === e3 ? "" : e3);
              })));
            }));
          }, effect: function(t2) {
            var e2 = t2.state, i3 = { popper: { position: e2.options.strategy, left: "0", top: "0", margin: "0" }, arrow: { position: "absolute" }, reference: {} };
            return Object.assign(e2.elements.popper.style, i3.popper), e2.styles = i3, e2.elements.arrow && Object.assign(e2.elements.arrow.style, i3.arrow), function() {
              Object.keys(e2.elements).forEach((function(t3) {
                var n2 = e2.elements[t3], s2 = e2.attributes[t3] || {}, o2 = Object.keys(e2.styles.hasOwnProperty(t3) ? e2.styles[t3] : i3[t3]).reduce((function(t4, e3) {
                  return t4[e3] = "", t4;
                }), {});
                _e(n2) && pe(n2) && (Object.assign(n2.style, o2), Object.keys(s2).forEach((function(t4) {
                  n2.removeAttribute(t4);
                })));
              }));
            };
          }, requires: ["computeStyles"] };
          function ye(t2) {
            return t2.split("-")[0];
          }
          var we = Math.max, Ae = Math.min, Ee = Math.round;
          function Te() {
            var t2 = navigator.userAgentData;
            return null != t2 && t2.brands && Array.isArray(t2.brands) ? t2.brands.map((function(t3) {
              return t3.brand + "/" + t3.version;
            })).join(" ") : navigator.userAgent;
          }
          function Ce() {
            return !/^((?!chrome|android).)*safari/i.test(Te());
          }
          function Oe(t2, e2, i3) {
            void 0 === e2 && (e2 = false), void 0 === i3 && (i3 = false);
            var n2 = t2.getBoundingClientRect(), s2 = 1, o2 = 1;
            e2 && _e(t2) && (s2 = t2.offsetWidth > 0 && Ee(n2.width) / t2.offsetWidth || 1, o2 = t2.offsetHeight > 0 && Ee(n2.height) / t2.offsetHeight || 1);
            var r2 = (ge(t2) ? me(t2) : window).visualViewport, a2 = !Ce() && i3, l2 = (n2.left + (a2 && r2 ? r2.offsetLeft : 0)) / s2, c2 = (n2.top + (a2 && r2 ? r2.offsetTop : 0)) / o2, h2 = n2.width / s2, d2 = n2.height / o2;
            return { width: h2, height: d2, top: c2, right: l2 + h2, bottom: c2 + d2, left: l2, x: l2, y: c2 };
          }
          function xe(t2) {
            var e2 = Oe(t2), i3 = t2.offsetWidth, n2 = t2.offsetHeight;
            return Math.abs(e2.width - i3) <= 1 && (i3 = e2.width), Math.abs(e2.height - n2) <= 1 && (n2 = e2.height), { x: t2.offsetLeft, y: t2.offsetTop, width: i3, height: n2 };
          }
          function ke(t2, e2) {
            var i3 = e2.getRootNode && e2.getRootNode();
            if (t2.contains(e2)) return true;
            if (i3 && be(i3)) {
              var n2 = e2;
              do {
                if (n2 && t2.isSameNode(n2)) return true;
                n2 = n2.parentNode || n2.host;
              } while (n2);
            }
            return false;
          }
          function Le(t2) {
            return me(t2).getComputedStyle(t2);
          }
          function Se(t2) {
            return ["table", "td", "th"].indexOf(pe(t2)) >= 0;
          }
          function De(t2) {
            return ((ge(t2) ? t2.ownerDocument : t2.document) || window.document).documentElement;
          }
          function $e(t2) {
            return "html" === pe(t2) ? t2 : t2.assignedSlot || t2.parentNode || (be(t2) ? t2.host : null) || De(t2);
          }
          function Ie(t2) {
            return _e(t2) && "fixed" !== Le(t2).position ? t2.offsetParent : null;
          }
          function Ne(t2) {
            for (var e2 = me(t2), i3 = Ie(t2); i3 && Se(i3) && "static" === Le(i3).position; ) i3 = Ie(i3);
            return i3 && ("html" === pe(i3) || "body" === pe(i3) && "static" === Le(i3).position) ? e2 : i3 || (function(t3) {
              var e3 = /firefox/i.test(Te());
              if (/Trident/i.test(Te()) && _e(t3) && "fixed" === Le(t3).position) return null;
              var i4 = $e(t3);
              for (be(i4) && (i4 = i4.host); _e(i4) && ["html", "body"].indexOf(pe(i4)) < 0; ) {
                var n2 = Le(i4);
                if ("none" !== n2.transform || "none" !== n2.perspective || "paint" === n2.contain || -1 !== ["transform", "perspective"].indexOf(n2.willChange) || e3 && "filter" === n2.willChange || e3 && n2.filter && "none" !== n2.filter) return i4;
                i4 = i4.parentNode;
              }
              return null;
            })(t2) || e2;
          }
          function Pe(t2) {
            return ["top", "bottom"].indexOf(t2) >= 0 ? "x" : "y";
          }
          function je(t2, e2, i3) {
            return we(t2, Ae(e2, i3));
          }
          function Me(t2) {
            return Object.assign({}, { top: 0, right: 0, bottom: 0, left: 0 }, t2);
          }
          function Fe(t2, e2) {
            return e2.reduce((function(e3, i3) {
              return e3[i3] = t2, e3;
            }), {});
          }
          const He = { name: "arrow", enabled: true, phase: "main", fn: function(t2) {
            var e2, i3 = t2.state, n2 = t2.name, s2 = t2.options, o2 = i3.elements.arrow, r2 = i3.modifiersData.popperOffsets, a2 = ye(i3.placement), l2 = Pe(a2), c2 = [Qt, Kt].indexOf(a2) >= 0 ? "height" : "width";
            if (o2 && r2) {
              var h2 = (function(t3, e3) {
                return Me("number" != typeof (t3 = "function" == typeof t3 ? t3(Object.assign({}, e3.rects, { placement: e3.placement })) : t3) ? t3 : Fe(t3, Yt));
              })(s2.padding, i3), d2 = xe(o2), u2 = "y" === l2 ? qt : Qt, f2 = "y" === l2 ? Vt : Kt, p2 = i3.rects.reference[c2] + i3.rects.reference[l2] - r2[l2] - i3.rects.popper[c2], m2 = r2[l2] - i3.rects.reference[l2], g2 = Ne(o2), _2 = g2 ? "y" === l2 ? g2.clientHeight || 0 : g2.clientWidth || 0 : 0, b2 = p2 / 2 - m2 / 2, v2 = h2[u2], y2 = _2 - d2[c2] - h2[f2], w2 = _2 / 2 - d2[c2] / 2 + b2, A2 = je(v2, w2, y2), E2 = l2;
              i3.modifiersData[n2] = ((e2 = {})[E2] = A2, e2.centerOffset = A2 - w2, e2);
            }
          }, effect: function(t2) {
            var e2 = t2.state, i3 = t2.options.element, n2 = void 0 === i3 ? "[data-popper-arrow]" : i3;
            null != n2 && ("string" != typeof n2 || (n2 = e2.elements.popper.querySelector(n2))) && ke(e2.elements.popper, n2) && (e2.elements.arrow = n2);
          }, requires: ["popperOffsets"], requiresIfExists: ["preventOverflow"] };
          function We(t2) {
            return t2.split("-")[1];
          }
          var Be = { top: "auto", right: "auto", bottom: "auto", left: "auto" };
          function ze(t2) {
            var e2, i3 = t2.popper, n2 = t2.popperRect, s2 = t2.placement, o2 = t2.variation, r2 = t2.offsets, a2 = t2.position, l2 = t2.gpuAcceleration, c2 = t2.adaptive, h2 = t2.roundOffsets, d2 = t2.isFixed, u2 = r2.x, f2 = void 0 === u2 ? 0 : u2, p2 = r2.y, m2 = void 0 === p2 ? 0 : p2, g2 = "function" == typeof h2 ? h2({ x: f2, y: m2 }) : { x: f2, y: m2 };
            f2 = g2.x, m2 = g2.y;
            var _2 = r2.hasOwnProperty("x"), b2 = r2.hasOwnProperty("y"), v2 = Qt, y2 = qt, w2 = window;
            if (c2) {
              var A2 = Ne(i3), E2 = "clientHeight", T2 = "clientWidth";
              A2 === me(i3) && "static" !== Le(A2 = De(i3)).position && "absolute" === a2 && (E2 = "scrollHeight", T2 = "scrollWidth"), (s2 === qt || (s2 === Qt || s2 === Kt) && o2 === Gt) && (y2 = Vt, m2 -= (d2 && A2 === w2 && w2.visualViewport ? w2.visualViewport.height : A2[E2]) - n2.height, m2 *= l2 ? 1 : -1), s2 !== Qt && (s2 !== qt && s2 !== Vt || o2 !== Gt) || (v2 = Kt, f2 -= (d2 && A2 === w2 && w2.visualViewport ? w2.visualViewport.width : A2[T2]) - n2.width, f2 *= l2 ? 1 : -1);
            }
            var C2, O2 = Object.assign({ position: a2 }, c2 && Be), x2 = true === h2 ? (function(t3, e3) {
              var i4 = t3.x, n3 = t3.y, s3 = e3.devicePixelRatio || 1;
              return { x: Ee(i4 * s3) / s3 || 0, y: Ee(n3 * s3) / s3 || 0 };
            })({ x: f2, y: m2 }, me(i3)) : { x: f2, y: m2 };
            return f2 = x2.x, m2 = x2.y, l2 ? Object.assign({}, O2, ((C2 = {})[y2] = b2 ? "0" : "", C2[v2] = _2 ? "0" : "", C2.transform = (w2.devicePixelRatio || 1) <= 1 ? "translate(" + f2 + "px, " + m2 + "px)" : "translate3d(" + f2 + "px, " + m2 + "px, 0)", C2)) : Object.assign({}, O2, ((e2 = {})[y2] = b2 ? m2 + "px" : "", e2[v2] = _2 ? f2 + "px" : "", e2.transform = "", e2));
          }
          const Re = { name: "computeStyles", enabled: true, phase: "beforeWrite", fn: function(t2) {
            var e2 = t2.state, i3 = t2.options, n2 = i3.gpuAcceleration, s2 = void 0 === n2 || n2, o2 = i3.adaptive, r2 = void 0 === o2 || o2, a2 = i3.roundOffsets, l2 = void 0 === a2 || a2, c2 = { placement: ye(e2.placement), variation: We(e2.placement), popper: e2.elements.popper, popperRect: e2.rects.popper, gpuAcceleration: s2, isFixed: "fixed" === e2.options.strategy };
            null != e2.modifiersData.popperOffsets && (e2.styles.popper = Object.assign({}, e2.styles.popper, ze(Object.assign({}, c2, { offsets: e2.modifiersData.popperOffsets, position: e2.options.strategy, adaptive: r2, roundOffsets: l2 })))), null != e2.modifiersData.arrow && (e2.styles.arrow = Object.assign({}, e2.styles.arrow, ze(Object.assign({}, c2, { offsets: e2.modifiersData.arrow, position: "absolute", adaptive: false, roundOffsets: l2 })))), e2.attributes.popper = Object.assign({}, e2.attributes.popper, { "data-popper-placement": e2.placement });
          }, data: {} };
          var qe = { passive: true };
          const Ve = { name: "eventListeners", enabled: true, phase: "write", fn: function() {
          }, effect: function(t2) {
            var e2 = t2.state, i3 = t2.instance, n2 = t2.options, s2 = n2.scroll, o2 = void 0 === s2 || s2, r2 = n2.resize, a2 = void 0 === r2 || r2, l2 = me(e2.elements.popper), c2 = [].concat(e2.scrollParents.reference, e2.scrollParents.popper);
            return o2 && c2.forEach((function(t3) {
              t3.addEventListener("scroll", i3.update, qe);
            })), a2 && l2.addEventListener("resize", i3.update, qe), function() {
              o2 && c2.forEach((function(t3) {
                t3.removeEventListener("scroll", i3.update, qe);
              })), a2 && l2.removeEventListener("resize", i3.update, qe);
            };
          }, data: {} };
          var Ke = { left: "right", right: "left", bottom: "top", top: "bottom" };
          function Qe(t2) {
            return t2.replace(/left|right|bottom|top/g, (function(t3) {
              return Ke[t3];
            }));
          }
          var Xe = { start: "end", end: "start" };
          function Ye(t2) {
            return t2.replace(/start|end/g, (function(t3) {
              return Xe[t3];
            }));
          }
          function Ue(t2) {
            var e2 = me(t2);
            return { scrollLeft: e2.pageXOffset, scrollTop: e2.pageYOffset };
          }
          function Ge(t2) {
            return Oe(De(t2)).left + Ue(t2).scrollLeft;
          }
          function Je(t2) {
            var e2 = Le(t2), i3 = e2.overflow, n2 = e2.overflowX, s2 = e2.overflowY;
            return /auto|scroll|overlay|hidden/.test(i3 + s2 + n2);
          }
          function Ze(t2) {
            return ["html", "body", "#document"].indexOf(pe(t2)) >= 0 ? t2.ownerDocument.body : _e(t2) && Je(t2) ? t2 : Ze($e(t2));
          }
          function ti(t2, e2) {
            var i3;
            void 0 === e2 && (e2 = []);
            var n2 = Ze(t2), s2 = n2 === (null == (i3 = t2.ownerDocument) ? void 0 : i3.body), o2 = me(n2), r2 = s2 ? [o2].concat(o2.visualViewport || [], Je(n2) ? n2 : []) : n2, a2 = e2.concat(r2);
            return s2 ? a2 : a2.concat(ti($e(r2)));
          }
          function ei(t2) {
            return Object.assign({}, t2, { left: t2.x, top: t2.y, right: t2.x + t2.width, bottom: t2.y + t2.height });
          }
          function ii(t2, e2, i3) {
            return e2 === Zt ? ei((function(t3, e3) {
              var i4 = me(t3), n2 = De(t3), s2 = i4.visualViewport, o2 = n2.clientWidth, r2 = n2.clientHeight, a2 = 0, l2 = 0;
              if (s2) {
                o2 = s2.width, r2 = s2.height;
                var c2 = Ce();
                (c2 || !c2 && "fixed" === e3) && (a2 = s2.offsetLeft, l2 = s2.offsetTop);
              }
              return { width: o2, height: r2, x: a2 + Ge(t3), y: l2 };
            })(t2, i3)) : ge(e2) ? (function(t3, e3) {
              var i4 = Oe(t3, false, "fixed" === e3);
              return i4.top = i4.top + t3.clientTop, i4.left = i4.left + t3.clientLeft, i4.bottom = i4.top + t3.clientHeight, i4.right = i4.left + t3.clientWidth, i4.width = t3.clientWidth, i4.height = t3.clientHeight, i4.x = i4.left, i4.y = i4.top, i4;
            })(e2, i3) : ei((function(t3) {
              var e3, i4 = De(t3), n2 = Ue(t3), s2 = null == (e3 = t3.ownerDocument) ? void 0 : e3.body, o2 = we(i4.scrollWidth, i4.clientWidth, s2 ? s2.scrollWidth : 0, s2 ? s2.clientWidth : 0), r2 = we(i4.scrollHeight, i4.clientHeight, s2 ? s2.scrollHeight : 0, s2 ? s2.clientHeight : 0), a2 = -n2.scrollLeft + Ge(t3), l2 = -n2.scrollTop;
              return "rtl" === Le(s2 || i4).direction && (a2 += we(i4.clientWidth, s2 ? s2.clientWidth : 0) - o2), { width: o2, height: r2, x: a2, y: l2 };
            })(De(t2)));
          }
          function ni(t2) {
            var e2, i3 = t2.reference, n2 = t2.element, s2 = t2.placement, o2 = s2 ? ye(s2) : null, r2 = s2 ? We(s2) : null, a2 = i3.x + i3.width / 2 - n2.width / 2, l2 = i3.y + i3.height / 2 - n2.height / 2;
            switch (o2) {
              case qt:
                e2 = { x: a2, y: i3.y - n2.height };
                break;
              case Vt:
                e2 = { x: a2, y: i3.y + i3.height };
                break;
              case Kt:
                e2 = { x: i3.x + i3.width, y: l2 };
                break;
              case Qt:
                e2 = { x: i3.x - n2.width, y: l2 };
                break;
              default:
                e2 = { x: i3.x, y: i3.y };
            }
            var c2 = o2 ? Pe(o2) : null;
            if (null != c2) {
              var h2 = "y" === c2 ? "height" : "width";
              switch (r2) {
                case Ut:
                  e2[c2] = e2[c2] - (i3[h2] / 2 - n2[h2] / 2);
                  break;
                case Gt:
                  e2[c2] = e2[c2] + (i3[h2] / 2 - n2[h2] / 2);
              }
            }
            return e2;
          }
          function si(t2, e2) {
            void 0 === e2 && (e2 = {});
            var i3 = e2, n2 = i3.placement, s2 = void 0 === n2 ? t2.placement : n2, o2 = i3.strategy, r2 = void 0 === o2 ? t2.strategy : o2, a2 = i3.boundary, l2 = void 0 === a2 ? Jt : a2, c2 = i3.rootBoundary, h2 = void 0 === c2 ? Zt : c2, d2 = i3.elementContext, u2 = void 0 === d2 ? te : d2, f2 = i3.altBoundary, p2 = void 0 !== f2 && f2, m2 = i3.padding, g2 = void 0 === m2 ? 0 : m2, _2 = Me("number" != typeof g2 ? g2 : Fe(g2, Yt)), b2 = u2 === te ? ee : te, v2 = t2.rects.popper, y2 = t2.elements[p2 ? b2 : u2], w2 = (function(t3, e3, i4, n3) {
              var s3 = "clippingParents" === e3 ? (function(t4) {
                var e4 = ti($e(t4)), i5 = ["absolute", "fixed"].indexOf(Le(t4).position) >= 0 && _e(t4) ? Ne(t4) : t4;
                return ge(i5) ? e4.filter((function(t5) {
                  return ge(t5) && ke(t5, i5) && "body" !== pe(t5);
                })) : [];
              })(t3) : [].concat(e3), o3 = [].concat(s3, [i4]), r3 = o3[0], a3 = o3.reduce((function(e4, i5) {
                var s4 = ii(t3, i5, n3);
                return e4.top = we(s4.top, e4.top), e4.right = Ae(s4.right, e4.right), e4.bottom = Ae(s4.bottom, e4.bottom), e4.left = we(s4.left, e4.left), e4;
              }), ii(t3, r3, n3));
              return a3.width = a3.right - a3.left, a3.height = a3.bottom - a3.top, a3.x = a3.left, a3.y = a3.top, a3;
            })(ge(y2) ? y2 : y2.contextElement || De(t2.elements.popper), l2, h2, r2), A2 = Oe(t2.elements.reference), E2 = ni({ reference: A2, element: v2, placement: s2 }), T2 = ei(Object.assign({}, v2, E2)), C2 = u2 === te ? T2 : A2, O2 = { top: w2.top - C2.top + _2.top, bottom: C2.bottom - w2.bottom + _2.bottom, left: w2.left - C2.left + _2.left, right: C2.right - w2.right + _2.right }, x2 = t2.modifiersData.offset;
            if (u2 === te && x2) {
              var k2 = x2[s2];
              Object.keys(O2).forEach((function(t3) {
                var e3 = [Kt, Vt].indexOf(t3) >= 0 ? 1 : -1, i4 = [qt, Vt].indexOf(t3) >= 0 ? "y" : "x";
                O2[t3] += k2[i4] * e3;
              }));
            }
            return O2;
          }
          function oi(t2, e2) {
            void 0 === e2 && (e2 = {});
            var i3 = e2, n2 = i3.placement, s2 = i3.boundary, o2 = i3.rootBoundary, r2 = i3.padding, a2 = i3.flipVariations, l2 = i3.allowedAutoPlacements, c2 = void 0 === l2 ? ne : l2, h2 = We(n2), d2 = h2 ? a2 ? ie : ie.filter((function(t3) {
              return We(t3) === h2;
            })) : Yt, u2 = d2.filter((function(t3) {
              return c2.indexOf(t3) >= 0;
            }));
            0 === u2.length && (u2 = d2);
            var f2 = u2.reduce((function(e3, i4) {
              return e3[i4] = si(t2, { placement: i4, boundary: s2, rootBoundary: o2, padding: r2 })[ye(i4)], e3;
            }), {});
            return Object.keys(f2).sort((function(t3, e3) {
              return f2[t3] - f2[e3];
            }));
          }
          const ri = { name: "flip", enabled: true, phase: "main", fn: function(t2) {
            var e2 = t2.state, i3 = t2.options, n2 = t2.name;
            if (!e2.modifiersData[n2]._skip) {
              for (var s2 = i3.mainAxis, o2 = void 0 === s2 || s2, r2 = i3.altAxis, a2 = void 0 === r2 || r2, l2 = i3.fallbackPlacements, c2 = i3.padding, h2 = i3.boundary, d2 = i3.rootBoundary, u2 = i3.altBoundary, f2 = i3.flipVariations, p2 = void 0 === f2 || f2, m2 = i3.allowedAutoPlacements, g2 = e2.options.placement, _2 = ye(g2), b2 = l2 || (_2 !== g2 && p2 ? (function(t3) {
                if (ye(t3) === Xt) return [];
                var e3 = Qe(t3);
                return [Ye(t3), e3, Ye(e3)];
              })(g2) : [Qe(g2)]), v2 = [g2].concat(b2).reduce((function(t3, i4) {
                return t3.concat(ye(i4) === Xt ? oi(e2, { placement: i4, boundary: h2, rootBoundary: d2, padding: c2, flipVariations: p2, allowedAutoPlacements: m2 }) : i4);
              }), []), y2 = e2.rects.reference, w2 = e2.rects.popper, A2 = /* @__PURE__ */ new Map(), E2 = true, T2 = v2[0], C2 = 0; C2 < v2.length; C2++) {
                var O2 = v2[C2], x2 = ye(O2), k2 = We(O2) === Ut, L2 = [qt, Vt].indexOf(x2) >= 0, S2 = L2 ? "width" : "height", D2 = si(e2, { placement: O2, boundary: h2, rootBoundary: d2, altBoundary: u2, padding: c2 }), $3 = L2 ? k2 ? Kt : Qt : k2 ? Vt : qt;
                y2[S2] > w2[S2] && ($3 = Qe($3));
                var I2 = Qe($3), N2 = [];
                if (o2 && N2.push(D2[x2] <= 0), a2 && N2.push(D2[$3] <= 0, D2[I2] <= 0), N2.every((function(t3) {
                  return t3;
                }))) {
                  T2 = O2, E2 = false;
                  break;
                }
                A2.set(O2, N2);
              }
              if (E2) for (var P2 = function(t3) {
                var e3 = v2.find((function(e4) {
                  var i4 = A2.get(e4);
                  if (i4) return i4.slice(0, t3).every((function(t4) {
                    return t4;
                  }));
                }));
                if (e3) return T2 = e3, "break";
              }, j2 = p2 ? 3 : 1; j2 > 0 && "break" !== P2(j2); j2--) ;
              e2.placement !== T2 && (e2.modifiersData[n2]._skip = true, e2.placement = T2, e2.reset = true);
            }
          }, requiresIfExists: ["offset"], data: { _skip: false } };
          function ai(t2, e2, i3) {
            return void 0 === i3 && (i3 = { x: 0, y: 0 }), { top: t2.top - e2.height - i3.y, right: t2.right - e2.width + i3.x, bottom: t2.bottom - e2.height + i3.y, left: t2.left - e2.width - i3.x };
          }
          function li(t2) {
            return [qt, Kt, Vt, Qt].some((function(e2) {
              return t2[e2] >= 0;
            }));
          }
          const ci = { name: "hide", enabled: true, phase: "main", requiresIfExists: ["preventOverflow"], fn: function(t2) {
            var e2 = t2.state, i3 = t2.name, n2 = e2.rects.reference, s2 = e2.rects.popper, o2 = e2.modifiersData.preventOverflow, r2 = si(e2, { elementContext: "reference" }), a2 = si(e2, { altBoundary: true }), l2 = ai(r2, n2), c2 = ai(a2, s2, o2), h2 = li(l2), d2 = li(c2);
            e2.modifiersData[i3] = { referenceClippingOffsets: l2, popperEscapeOffsets: c2, isReferenceHidden: h2, hasPopperEscaped: d2 }, e2.attributes.popper = Object.assign({}, e2.attributes.popper, { "data-popper-reference-hidden": h2, "data-popper-escaped": d2 });
          } }, hi = { name: "offset", enabled: true, phase: "main", requires: ["popperOffsets"], fn: function(t2) {
            var e2 = t2.state, i3 = t2.options, n2 = t2.name, s2 = i3.offset, o2 = void 0 === s2 ? [0, 0] : s2, r2 = ne.reduce((function(t3, i4) {
              return t3[i4] = (function(t4, e3, i5) {
                var n3 = ye(t4), s3 = [Qt, qt].indexOf(n3) >= 0 ? -1 : 1, o3 = "function" == typeof i5 ? i5(Object.assign({}, e3, { placement: t4 })) : i5, r3 = o3[0], a3 = o3[1];
                return r3 = r3 || 0, a3 = (a3 || 0) * s3, [Qt, Kt].indexOf(n3) >= 0 ? { x: a3, y: r3 } : { x: r3, y: a3 };
              })(i4, e2.rects, o2), t3;
            }), {}), a2 = r2[e2.placement], l2 = a2.x, c2 = a2.y;
            null != e2.modifiersData.popperOffsets && (e2.modifiersData.popperOffsets.x += l2, e2.modifiersData.popperOffsets.y += c2), e2.modifiersData[n2] = r2;
          } }, di = { name: "popperOffsets", enabled: true, phase: "read", fn: function(t2) {
            var e2 = t2.state, i3 = t2.name;
            e2.modifiersData[i3] = ni({ reference: e2.rects.reference, element: e2.rects.popper, placement: e2.placement });
          }, data: {} }, ui = { name: "preventOverflow", enabled: true, phase: "main", fn: function(t2) {
            var e2 = t2.state, i3 = t2.options, n2 = t2.name, s2 = i3.mainAxis, o2 = void 0 === s2 || s2, r2 = i3.altAxis, a2 = void 0 !== r2 && r2, l2 = i3.boundary, c2 = i3.rootBoundary, h2 = i3.altBoundary, d2 = i3.padding, u2 = i3.tether, f2 = void 0 === u2 || u2, p2 = i3.tetherOffset, m2 = void 0 === p2 ? 0 : p2, g2 = si(e2, { boundary: l2, rootBoundary: c2, padding: d2, altBoundary: h2 }), _2 = ye(e2.placement), b2 = We(e2.placement), v2 = !b2, y2 = Pe(_2), w2 = "x" === y2 ? "y" : "x", A2 = e2.modifiersData.popperOffsets, E2 = e2.rects.reference, T2 = e2.rects.popper, C2 = "function" == typeof m2 ? m2(Object.assign({}, e2.rects, { placement: e2.placement })) : m2, O2 = "number" == typeof C2 ? { mainAxis: C2, altAxis: C2 } : Object.assign({ mainAxis: 0, altAxis: 0 }, C2), x2 = e2.modifiersData.offset ? e2.modifiersData.offset[e2.placement] : null, k2 = { x: 0, y: 0 };
            if (A2) {
              if (o2) {
                var L2, S2 = "y" === y2 ? qt : Qt, D2 = "y" === y2 ? Vt : Kt, $3 = "y" === y2 ? "height" : "width", I2 = A2[y2], N2 = I2 + g2[S2], P2 = I2 - g2[D2], j2 = f2 ? -T2[$3] / 2 : 0, M2 = b2 === Ut ? E2[$3] : T2[$3], F2 = b2 === Ut ? -T2[$3] : -E2[$3], H2 = e2.elements.arrow, W2 = f2 && H2 ? xe(H2) : { width: 0, height: 0 }, B2 = e2.modifiersData["arrow#persistent"] ? e2.modifiersData["arrow#persistent"].padding : { top: 0, right: 0, bottom: 0, left: 0 }, z2 = B2[S2], R2 = B2[D2], q2 = je(0, E2[$3], W2[$3]), V2 = v2 ? E2[$3] / 2 - j2 - q2 - z2 - O2.mainAxis : M2 - q2 - z2 - O2.mainAxis, K2 = v2 ? -E2[$3] / 2 + j2 + q2 + R2 + O2.mainAxis : F2 + q2 + R2 + O2.mainAxis, Q2 = e2.elements.arrow && Ne(e2.elements.arrow), X2 = Q2 ? "y" === y2 ? Q2.clientTop || 0 : Q2.clientLeft || 0 : 0, Y2 = null != (L2 = null == x2 ? void 0 : x2[y2]) ? L2 : 0, U2 = I2 + K2 - Y2, G2 = je(f2 ? Ae(N2, I2 + V2 - Y2 - X2) : N2, I2, f2 ? we(P2, U2) : P2);
                A2[y2] = G2, k2[y2] = G2 - I2;
              }
              if (a2) {
                var J2, Z2 = "x" === y2 ? qt : Qt, tt2 = "x" === y2 ? Vt : Kt, et2 = A2[w2], it2 = "y" === w2 ? "height" : "width", nt2 = et2 + g2[Z2], st2 = et2 - g2[tt2], ot2 = -1 !== [qt, Qt].indexOf(_2), rt2 = null != (J2 = null == x2 ? void 0 : x2[w2]) ? J2 : 0, at2 = ot2 ? nt2 : et2 - E2[it2] - T2[it2] - rt2 + O2.altAxis, lt2 = ot2 ? et2 + E2[it2] + T2[it2] - rt2 - O2.altAxis : st2, ct2 = f2 && ot2 ? (function(t3, e3, i4) {
                  var n3 = je(t3, e3, i4);
                  return n3 > i4 ? i4 : n3;
                })(at2, et2, lt2) : je(f2 ? at2 : nt2, et2, f2 ? lt2 : st2);
                A2[w2] = ct2, k2[w2] = ct2 - et2;
              }
              e2.modifiersData[n2] = k2;
            }
          }, requiresIfExists: ["offset"] };
          function fi(t2, e2, i3) {
            void 0 === i3 && (i3 = false);
            var n2, s2, o2 = _e(e2), r2 = _e(e2) && (function(t3) {
              var e3 = t3.getBoundingClientRect(), i4 = Ee(e3.width) / t3.offsetWidth || 1, n3 = Ee(e3.height) / t3.offsetHeight || 1;
              return 1 !== i4 || 1 !== n3;
            })(e2), a2 = De(e2), l2 = Oe(t2, r2, i3), c2 = { scrollLeft: 0, scrollTop: 0 }, h2 = { x: 0, y: 0 };
            return (o2 || !o2 && !i3) && (("body" !== pe(e2) || Je(a2)) && (c2 = (n2 = e2) !== me(n2) && _e(n2) ? { scrollLeft: (s2 = n2).scrollLeft, scrollTop: s2.scrollTop } : Ue(n2)), _e(e2) ? ((h2 = Oe(e2, true)).x += e2.clientLeft, h2.y += e2.clientTop) : a2 && (h2.x = Ge(a2))), { x: l2.left + c2.scrollLeft - h2.x, y: l2.top + c2.scrollTop - h2.y, width: l2.width, height: l2.height };
          }
          function pi(t2) {
            var e2 = /* @__PURE__ */ new Map(), i3 = /* @__PURE__ */ new Set(), n2 = [];
            function s2(t3) {
              i3.add(t3.name), [].concat(t3.requires || [], t3.requiresIfExists || []).forEach((function(t4) {
                if (!i3.has(t4)) {
                  var n3 = e2.get(t4);
                  n3 && s2(n3);
                }
              })), n2.push(t3);
            }
            return t2.forEach((function(t3) {
              e2.set(t3.name, t3);
            })), t2.forEach((function(t3) {
              i3.has(t3.name) || s2(t3);
            })), n2;
          }
          var mi = { placement: "bottom", modifiers: [], strategy: "absolute" };
          function gi() {
            for (var t2 = arguments.length, e2 = new Array(t2), i3 = 0; i3 < t2; i3++) e2[i3] = arguments[i3];
            return !e2.some((function(t3) {
              return !(t3 && "function" == typeof t3.getBoundingClientRect);
            }));
          }
          function _i(t2) {
            void 0 === t2 && (t2 = {});
            var e2 = t2, i3 = e2.defaultModifiers, n2 = void 0 === i3 ? [] : i3, s2 = e2.defaultOptions, o2 = void 0 === s2 ? mi : s2;
            return function(t3, e3, i4) {
              void 0 === i4 && (i4 = o2);
              var s3, r2, a2 = { placement: "bottom", orderedModifiers: [], options: Object.assign({}, mi, o2), modifiersData: {}, elements: { reference: t3, popper: e3 }, attributes: {}, styles: {} }, l2 = [], c2 = false, h2 = { state: a2, setOptions: function(i5) {
                var s4 = "function" == typeof i5 ? i5(a2.options) : i5;
                d2(), a2.options = Object.assign({}, o2, a2.options, s4), a2.scrollParents = { reference: ge(t3) ? ti(t3) : t3.contextElement ? ti(t3.contextElement) : [], popper: ti(e3) };
                var r3, c3, u2 = (function(t4) {
                  var e4 = pi(t4);
                  return fe.reduce((function(t5, i6) {
                    return t5.concat(e4.filter((function(t6) {
                      return t6.phase === i6;
                    })));
                  }), []);
                })((r3 = [].concat(n2, a2.options.modifiers), c3 = r3.reduce((function(t4, e4) {
                  var i6 = t4[e4.name];
                  return t4[e4.name] = i6 ? Object.assign({}, i6, e4, { options: Object.assign({}, i6.options, e4.options), data: Object.assign({}, i6.data, e4.data) }) : e4, t4;
                }), {}), Object.keys(c3).map((function(t4) {
                  return c3[t4];
                }))));
                return a2.orderedModifiers = u2.filter((function(t4) {
                  return t4.enabled;
                })), a2.orderedModifiers.forEach((function(t4) {
                  var e4 = t4.name, i6 = t4.options, n3 = void 0 === i6 ? {} : i6, s5 = t4.effect;
                  if ("function" == typeof s5) {
                    var o3 = s5({ state: a2, name: e4, instance: h2, options: n3 });
                    l2.push(o3 || function() {
                    });
                  }
                })), h2.update();
              }, forceUpdate: function() {
                if (!c2) {
                  var t4 = a2.elements, e4 = t4.reference, i5 = t4.popper;
                  if (gi(e4, i5)) {
                    a2.rects = { reference: fi(e4, Ne(i5), "fixed" === a2.options.strategy), popper: xe(i5) }, a2.reset = false, a2.placement = a2.options.placement, a2.orderedModifiers.forEach((function(t5) {
                      return a2.modifiersData[t5.name] = Object.assign({}, t5.data);
                    }));
                    for (var n3 = 0; n3 < a2.orderedModifiers.length; n3++) if (true !== a2.reset) {
                      var s4 = a2.orderedModifiers[n3], o3 = s4.fn, r3 = s4.options, l3 = void 0 === r3 ? {} : r3, d3 = s4.name;
                      "function" == typeof o3 && (a2 = o3({ state: a2, options: l3, name: d3, instance: h2 }) || a2);
                    } else a2.reset = false, n3 = -1;
                  }
                }
              }, update: (s3 = function() {
                return new Promise((function(t4) {
                  h2.forceUpdate(), t4(a2);
                }));
              }, function() {
                return r2 || (r2 = new Promise((function(t4) {
                  Promise.resolve().then((function() {
                    r2 = void 0, t4(s3());
                  }));
                }))), r2;
              }), destroy: function() {
                d2(), c2 = true;
              } };
              if (!gi(t3, e3)) return h2;
              function d2() {
                l2.forEach((function(t4) {
                  return t4();
                })), l2 = [];
              }
              return h2.setOptions(i4).then((function(t4) {
                !c2 && i4.onFirstUpdate && i4.onFirstUpdate(t4);
              })), h2;
            };
          }
          var bi = _i(), vi = _i({ defaultModifiers: [Ve, di, Re, ve] }), yi = _i({ defaultModifiers: [Ve, di, Re, ve, hi, ri, ui, He, ci] });
          const wi = Object.freeze(Object.defineProperty({ __proto__: null, afterMain: ce, afterRead: re, afterWrite: ue, applyStyles: ve, arrow: He, auto: Xt, basePlacements: Yt, beforeMain: ae, beforeRead: se, beforeWrite: he, bottom: Vt, clippingParents: Jt, computeStyles: Re, createPopper: yi, createPopperBase: bi, createPopperLite: vi, detectOverflow: si, end: Gt, eventListeners: Ve, flip: ri, hide: ci, left: Qt, main: le, modifierPhases: fe, offset: hi, placements: ne, popper: te, popperGenerator: _i, popperOffsets: di, preventOverflow: ui, read: oe, reference: ee, right: Kt, start: Ut, top: qt, variationPlacements: ie, viewport: Zt, write: de }, Symbol.toStringTag, { value: "Module" })), Ai = "dropdown", Ei = ".bs.dropdown", Ti = ".data-api", Ci = "ArrowUp", Oi = "ArrowDown", xi = `hide${Ei}`, ki = `hidden${Ei}`, Li = `show${Ei}`, Si = `shown${Ei}`, Di = `click${Ei}${Ti}`, $i = `keydown${Ei}${Ti}`, Ii = `keyup${Ei}${Ti}`, Ni = "show", Pi = '[data-bs-toggle="dropdown"]:not(.disabled):not(:disabled)', ji = `${Pi}.${Ni}`, Mi = ".dropdown-menu", Fi = p() ? "top-end" : "top-start", Hi = p() ? "top-start" : "top-end", Wi = p() ? "bottom-end" : "bottom-start", Bi = p() ? "bottom-start" : "bottom-end", zi = p() ? "left-start" : "right-start", Ri = p() ? "right-start" : "left-start", qi = { autoClose: true, boundary: "clippingParents", display: "dynamic", offset: [0, 2], popperConfig: null, reference: "toggle" }, Vi = { autoClose: "(boolean|string)", boundary: "(string|element)", display: "string", offset: "(array|string|function)", popperConfig: "(null|object|function)", reference: "(string|element|object)" };
          class Ki extends W {
            constructor(t2, e2) {
              super(t2, e2), this._popper = null, this._parent = this._element.parentNode, this._menu = z.next(this._element, Mi)[0] || z.prev(this._element, Mi)[0] || z.findOne(Mi, this._parent), this._inNavbar = this._detectNavbar();
            }
            static get Default() {
              return qi;
            }
            static get DefaultType() {
              return Vi;
            }
            static get NAME() {
              return Ai;
            }
            toggle() {
              return this._isShown() ? this.hide() : this.show();
            }
            show() {
              if (l(this._element) || this._isShown()) return;
              const t2 = { relatedTarget: this._element };
              if (!N.trigger(this._element, Li, t2).defaultPrevented) {
                if (this._createPopper(), "ontouchstart" in document.documentElement && !this._parent.closest(".navbar-nav")) for (const t3 of [].concat(...document.body.children)) N.on(t3, "mouseover", h);
                this._element.focus(), this._element.setAttribute("aria-expanded", true), this._menu.classList.add(Ni), this._element.classList.add(Ni), N.trigger(this._element, Si, t2);
              }
            }
            hide() {
              if (l(this._element) || !this._isShown()) return;
              const t2 = { relatedTarget: this._element };
              this._completeHide(t2);
            }
            dispose() {
              this._popper && this._popper.destroy(), super.dispose();
            }
            update() {
              this._inNavbar = this._detectNavbar(), this._popper && this._popper.update();
            }
            _completeHide(t2) {
              if (!N.trigger(this._element, xi, t2).defaultPrevented) {
                if ("ontouchstart" in document.documentElement) for (const t3 of [].concat(...document.body.children)) N.off(t3, "mouseover", h);
                this._popper && this._popper.destroy(), this._menu.classList.remove(Ni), this._element.classList.remove(Ni), this._element.setAttribute("aria-expanded", "false"), F.removeDataAttribute(this._menu, "popper"), N.trigger(this._element, ki, t2), this._element.focus();
              }
            }
            _getConfig(t2) {
              if ("object" == typeof (t2 = super._getConfig(t2)).reference && !o(t2.reference) && "function" != typeof t2.reference.getBoundingClientRect) throw new TypeError(`${Ai.toUpperCase()}: Option "reference" provided type "object" without a required "getBoundingClientRect" method.`);
              return t2;
            }
            _createPopper() {
              if (void 0 === wi) throw new TypeError("Bootstrap's dropdowns require Popper (https://popper.js.org/docs/v2/)");
              let t2 = this._element;
              "parent" === this._config.reference ? t2 = this._parent : o(this._config.reference) ? t2 = r(this._config.reference) : "object" == typeof this._config.reference && (t2 = this._config.reference);
              const e2 = this._getPopperConfig();
              this._popper = yi(t2, this._menu, e2);
            }
            _isShown() {
              return this._menu.classList.contains(Ni);
            }
            _getPlacement() {
              const t2 = this._parent;
              if (t2.classList.contains("dropend")) return zi;
              if (t2.classList.contains("dropstart")) return Ri;
              if (t2.classList.contains("dropup-center")) return "top";
              if (t2.classList.contains("dropdown-center")) return "bottom";
              const e2 = "end" === getComputedStyle(this._menu).getPropertyValue("--bs-position").trim();
              return t2.classList.contains("dropup") ? e2 ? Hi : Fi : e2 ? Bi : Wi;
            }
            _detectNavbar() {
              return null !== this._element.closest(".navbar");
            }
            _getOffset() {
              const { offset: t2 } = this._config;
              return "string" == typeof t2 ? t2.split(",").map(((t3) => Number.parseInt(t3, 10))) : "function" == typeof t2 ? (e2) => t2(e2, this._element) : t2;
            }
            _getPopperConfig() {
              const t2 = { placement: this._getPlacement(), modifiers: [{ name: "preventOverflow", options: { boundary: this._config.boundary } }, { name: "offset", options: { offset: this._getOffset() } }] };
              return (this._inNavbar || "static" === this._config.display) && (F.setDataAttribute(this._menu, "popper", "static"), t2.modifiers = [{ name: "applyStyles", enabled: false }]), { ...t2, ...g(this._config.popperConfig, [void 0, t2]) };
            }
            _selectMenuItem({ key: t2, target: e2 }) {
              const i3 = z.find(".dropdown-menu .dropdown-item:not(.disabled):not(:disabled)", this._menu).filter(((t3) => a(t3)));
              i3.length && b(i3, e2, t2 === Oi, !i3.includes(e2)).focus();
            }
            static jQueryInterface(t2) {
              return this.each((function() {
                const e2 = Ki.getOrCreateInstance(this, t2);
                if ("string" == typeof t2) {
                  if (void 0 === e2[t2]) throw new TypeError(`No method named "${t2}"`);
                  e2[t2]();
                }
              }));
            }
            static clearMenus(t2) {
              if (2 === t2.button || "keyup" === t2.type && "Tab" !== t2.key) return;
              const e2 = z.find(ji);
              for (const i3 of e2) {
                const e3 = Ki.getInstance(i3);
                if (!e3 || false === e3._config.autoClose) continue;
                const n2 = t2.composedPath(), s2 = n2.includes(e3._menu);
                if (n2.includes(e3._element) || "inside" === e3._config.autoClose && !s2 || "outside" === e3._config.autoClose && s2) continue;
                if (e3._menu.contains(t2.target) && ("keyup" === t2.type && "Tab" === t2.key || /input|select|option|textarea|form/i.test(t2.target.tagName))) continue;
                const o2 = { relatedTarget: e3._element };
                "click" === t2.type && (o2.clickEvent = t2), e3._completeHide(o2);
              }
            }
            static dataApiKeydownHandler(t2) {
              const e2 = /input|textarea/i.test(t2.target.tagName), i3 = "Escape" === t2.key, n2 = [Ci, Oi].includes(t2.key);
              if (!n2 && !i3) return;
              if (e2 && !i3) return;
              t2.preventDefault();
              const s2 = this.matches(Pi) ? this : z.prev(this, Pi)[0] || z.next(this, Pi)[0] || z.findOne(Pi, t2.delegateTarget.parentNode), o2 = Ki.getOrCreateInstance(s2);
              if (n2) return t2.stopPropagation(), o2.show(), void o2._selectMenuItem(t2);
              o2._isShown() && (t2.stopPropagation(), o2.hide(), s2.focus());
            }
          }
          N.on(document, $i, Pi, Ki.dataApiKeydownHandler), N.on(document, $i, Mi, Ki.dataApiKeydownHandler), N.on(document, Di, Ki.clearMenus), N.on(document, Ii, Ki.clearMenus), N.on(document, Di, Pi, (function(t2) {
            t2.preventDefault(), Ki.getOrCreateInstance(this).toggle();
          })), m(Ki);
          const Qi = "backdrop", Xi = "show", Yi = `mousedown.bs.${Qi}`, Ui = { className: "modal-backdrop", clickCallback: null, isAnimated: false, isVisible: true, rootElement: "body" }, Gi = { className: "string", clickCallback: "(function|null)", isAnimated: "boolean", isVisible: "boolean", rootElement: "(element|string)" };
          class Ji extends H {
            constructor(t2) {
              super(), this._config = this._getConfig(t2), this._isAppended = false, this._element = null;
            }
            static get Default() {
              return Ui;
            }
            static get DefaultType() {
              return Gi;
            }
            static get NAME() {
              return Qi;
            }
            show(t2) {
              if (!this._config.isVisible) return void g(t2);
              this._append();
              const e2 = this._getElement();
              this._config.isAnimated && d(e2), e2.classList.add(Xi), this._emulateAnimation((() => {
                g(t2);
              }));
            }
            hide(t2) {
              this._config.isVisible ? (this._getElement().classList.remove(Xi), this._emulateAnimation((() => {
                this.dispose(), g(t2);
              }))) : g(t2);
            }
            dispose() {
              this._isAppended && (N.off(this._element, Yi), this._element.remove(), this._isAppended = false);
            }
            _getElement() {
              if (!this._element) {
                const t2 = document.createElement("div");
                t2.className = this._config.className, this._config.isAnimated && t2.classList.add("fade"), this._element = t2;
              }
              return this._element;
            }
            _configAfterMerge(t2) {
              return t2.rootElement = r(t2.rootElement), t2;
            }
            _append() {
              if (this._isAppended) return;
              const t2 = this._getElement();
              this._config.rootElement.append(t2), N.on(t2, Yi, (() => {
                g(this._config.clickCallback);
              })), this._isAppended = true;
            }
            _emulateAnimation(t2) {
              _(t2, this._getElement(), this._config.isAnimated);
            }
          }
          const Zi = ".bs.focustrap", tn = `focusin${Zi}`, en = `keydown.tab${Zi}`, nn = "backward", sn = { autofocus: true, trapElement: null }, on = { autofocus: "boolean", trapElement: "element" };
          class rn extends H {
            constructor(t2) {
              super(), this._config = this._getConfig(t2), this._isActive = false, this._lastTabNavDirection = null;
            }
            static get Default() {
              return sn;
            }
            static get DefaultType() {
              return on;
            }
            static get NAME() {
              return "focustrap";
            }
            activate() {
              this._isActive || (this._config.autofocus && this._config.trapElement.focus(), N.off(document, Zi), N.on(document, tn, ((t2) => this._handleFocusin(t2))), N.on(document, en, ((t2) => this._handleKeydown(t2))), this._isActive = true);
            }
            deactivate() {
              this._isActive && (this._isActive = false, N.off(document, Zi));
            }
            _handleFocusin(t2) {
              const { trapElement: e2 } = this._config;
              if (t2.target === document || t2.target === e2 || e2.contains(t2.target)) return;
              const i3 = z.focusableChildren(e2);
              0 === i3.length ? e2.focus() : this._lastTabNavDirection === nn ? i3[i3.length - 1].focus() : i3[0].focus();
            }
            _handleKeydown(t2) {
              "Tab" === t2.key && (this._lastTabNavDirection = t2.shiftKey ? nn : "forward");
            }
          }
          const an = ".fixed-top, .fixed-bottom, .is-fixed, .sticky-top", ln = ".sticky-top", cn = "padding-right", hn = "margin-right";
          class dn {
            constructor() {
              this._element = document.body;
            }
            getWidth() {
              const t2 = document.documentElement.clientWidth;
              return Math.abs(window.innerWidth - t2);
            }
            hide() {
              const t2 = this.getWidth();
              this._disableOverFlow(), this._setElementAttributes(this._element, cn, ((e2) => e2 + t2)), this._setElementAttributes(an, cn, ((e2) => e2 + t2)), this._setElementAttributes(ln, hn, ((e2) => e2 - t2));
            }
            reset() {
              this._resetElementAttributes(this._element, "overflow"), this._resetElementAttributes(this._element, cn), this._resetElementAttributes(an, cn), this._resetElementAttributes(ln, hn);
            }
            isOverflowing() {
              return this.getWidth() > 0;
            }
            _disableOverFlow() {
              this._saveInitialAttribute(this._element, "overflow"), this._element.style.overflow = "hidden";
            }
            _setElementAttributes(t2, e2, i3) {
              const n2 = this.getWidth();
              this._applyManipulationCallback(t2, ((t3) => {
                if (t3 !== this._element && window.innerWidth > t3.clientWidth + n2) return;
                this._saveInitialAttribute(t3, e2);
                const s2 = window.getComputedStyle(t3).getPropertyValue(e2);
                t3.style.setProperty(e2, `${i3(Number.parseFloat(s2))}px`);
              }));
            }
            _saveInitialAttribute(t2, e2) {
              const i3 = t2.style.getPropertyValue(e2);
              i3 && F.setDataAttribute(t2, e2, i3);
            }
            _resetElementAttributes(t2, e2) {
              this._applyManipulationCallback(t2, ((t3) => {
                const i3 = F.getDataAttribute(t3, e2);
                null !== i3 ? (F.removeDataAttribute(t3, e2), t3.style.setProperty(e2, i3)) : t3.style.removeProperty(e2);
              }));
            }
            _applyManipulationCallback(t2, e2) {
              if (o(t2)) e2(t2);
              else for (const i3 of z.find(t2, this._element)) e2(i3);
            }
          }
          const un = ".bs.modal", fn = `hide${un}`, pn = `hidePrevented${un}`, mn = `hidden${un}`, gn = `show${un}`, _n = `shown${un}`, bn = `resize${un}`, vn = `click.dismiss${un}`, yn = `mousedown.dismiss${un}`, wn = `keydown.dismiss${un}`, An = `click${un}.data-api`, En = "modal-open", Tn = "show", Cn = "modal-static", On = { backdrop: true, focus: true, keyboard: true }, xn = { backdrop: "(boolean|string)", focus: "boolean", keyboard: "boolean" };
          class kn extends W {
            constructor(t2, e2) {
              super(t2, e2), this._dialog = z.findOne(".modal-dialog", this._element), this._backdrop = this._initializeBackDrop(), this._focustrap = this._initializeFocusTrap(), this._isShown = false, this._isTransitioning = false, this._scrollBar = new dn(), this._addEventListeners();
            }
            static get Default() {
              return On;
            }
            static get DefaultType() {
              return xn;
            }
            static get NAME() {
              return "modal";
            }
            toggle(t2) {
              return this._isShown ? this.hide() : this.show(t2);
            }
            show(t2) {
              this._isShown || this._isTransitioning || N.trigger(this._element, gn, { relatedTarget: t2 }).defaultPrevented || (this._isShown = true, this._isTransitioning = true, this._scrollBar.hide(), document.body.classList.add(En), this._adjustDialog(), this._backdrop.show((() => this._showElement(t2))));
            }
            hide() {
              this._isShown && !this._isTransitioning && (N.trigger(this._element, fn).defaultPrevented || (this._isShown = false, this._isTransitioning = true, this._focustrap.deactivate(), this._element.classList.remove(Tn), this._queueCallback((() => this._hideModal()), this._element, this._isAnimated())));
            }
            dispose() {
              N.off(window, un), N.off(this._dialog, un), this._backdrop.dispose(), this._focustrap.deactivate(), super.dispose();
            }
            handleUpdate() {
              this._adjustDialog();
            }
            _initializeBackDrop() {
              return new Ji({ isVisible: Boolean(this._config.backdrop), isAnimated: this._isAnimated() });
            }
            _initializeFocusTrap() {
              return new rn({ trapElement: this._element });
            }
            _showElement(t2) {
              document.body.contains(this._element) || document.body.append(this._element), this._element.style.display = "block", this._element.removeAttribute("aria-hidden"), this._element.setAttribute("aria-modal", true), this._element.setAttribute("role", "dialog"), this._element.scrollTop = 0;
              const e2 = z.findOne(".modal-body", this._dialog);
              e2 && (e2.scrollTop = 0), d(this._element), this._element.classList.add(Tn), this._queueCallback((() => {
                this._config.focus && this._focustrap.activate(), this._isTransitioning = false, N.trigger(this._element, _n, { relatedTarget: t2 });
              }), this._dialog, this._isAnimated());
            }
            _addEventListeners() {
              N.on(this._element, wn, ((t2) => {
                "Escape" === t2.key && (this._config.keyboard ? this.hide() : this._triggerBackdropTransition());
              })), N.on(window, bn, (() => {
                this._isShown && !this._isTransitioning && this._adjustDialog();
              })), N.on(this._element, yn, ((t2) => {
                N.one(this._element, vn, ((e2) => {
                  this._element === t2.target && this._element === e2.target && ("static" !== this._config.backdrop ? this._config.backdrop && this.hide() : this._triggerBackdropTransition());
                }));
              }));
            }
            _hideModal() {
              this._element.style.display = "none", this._element.setAttribute("aria-hidden", true), this._element.removeAttribute("aria-modal"), this._element.removeAttribute("role"), this._isTransitioning = false, this._backdrop.hide((() => {
                document.body.classList.remove(En), this._resetAdjustments(), this._scrollBar.reset(), N.trigger(this._element, mn);
              }));
            }
            _isAnimated() {
              return this._element.classList.contains("fade");
            }
            _triggerBackdropTransition() {
              if (N.trigger(this._element, pn).defaultPrevented) return;
              const t2 = this._element.scrollHeight > document.documentElement.clientHeight, e2 = this._element.style.overflowY;
              "hidden" === e2 || this._element.classList.contains(Cn) || (t2 || (this._element.style.overflowY = "hidden"), this._element.classList.add(Cn), this._queueCallback((() => {
                this._element.classList.remove(Cn), this._queueCallback((() => {
                  this._element.style.overflowY = e2;
                }), this._dialog);
              }), this._dialog), this._element.focus());
            }
            _adjustDialog() {
              const t2 = this._element.scrollHeight > document.documentElement.clientHeight, e2 = this._scrollBar.getWidth(), i3 = e2 > 0;
              if (i3 && !t2) {
                const t3 = p() ? "paddingLeft" : "paddingRight";
                this._element.style[t3] = `${e2}px`;
              }
              if (!i3 && t2) {
                const t3 = p() ? "paddingRight" : "paddingLeft";
                this._element.style[t3] = `${e2}px`;
              }
            }
            _resetAdjustments() {
              this._element.style.paddingLeft = "", this._element.style.paddingRight = "";
            }
            static jQueryInterface(t2, e2) {
              return this.each((function() {
                const i3 = kn.getOrCreateInstance(this, t2);
                if ("string" == typeof t2) {
                  if (void 0 === i3[t2]) throw new TypeError(`No method named "${t2}"`);
                  i3[t2](e2);
                }
              }));
            }
          }
          N.on(document, An, '[data-bs-toggle="modal"]', (function(t2) {
            const e2 = z.getElementFromSelector(this);
            ["A", "AREA"].includes(this.tagName) && t2.preventDefault(), N.one(e2, gn, ((t3) => {
              t3.defaultPrevented || N.one(e2, mn, (() => {
                a(this) && this.focus();
              }));
            }));
            const i3 = z.findOne(".modal.show");
            i3 && kn.getInstance(i3).hide(), kn.getOrCreateInstance(e2).toggle(this);
          })), R(kn), m(kn);
          const Ln = ".bs.offcanvas", Sn = ".data-api", Dn = `load${Ln}${Sn}`, $n = "show", In = "showing", Nn = "hiding", Pn = ".offcanvas.show", jn = `show${Ln}`, Mn = `shown${Ln}`, Fn = `hide${Ln}`, Hn = `hidePrevented${Ln}`, Wn = `hidden${Ln}`, Bn = `resize${Ln}`, zn = `click${Ln}${Sn}`, Rn = `keydown.dismiss${Ln}`, qn = { backdrop: true, keyboard: true, scroll: false }, Vn = { backdrop: "(boolean|string)", keyboard: "boolean", scroll: "boolean" };
          class Kn extends W {
            constructor(t2, e2) {
              super(t2, e2), this._isShown = false, this._backdrop = this._initializeBackDrop(), this._focustrap = this._initializeFocusTrap(), this._addEventListeners();
            }
            static get Default() {
              return qn;
            }
            static get DefaultType() {
              return Vn;
            }
            static get NAME() {
              return "offcanvas";
            }
            toggle(t2) {
              return this._isShown ? this.hide() : this.show(t2);
            }
            show(t2) {
              this._isShown || N.trigger(this._element, jn, { relatedTarget: t2 }).defaultPrevented || (this._isShown = true, this._backdrop.show(), this._config.scroll || new dn().hide(), this._element.setAttribute("aria-modal", true), this._element.setAttribute("role", "dialog"), this._element.classList.add(In), this._queueCallback((() => {
                this._config.scroll && !this._config.backdrop || this._focustrap.activate(), this._element.classList.add($n), this._element.classList.remove(In), N.trigger(this._element, Mn, { relatedTarget: t2 });
              }), this._element, true));
            }
            hide() {
              this._isShown && (N.trigger(this._element, Fn).defaultPrevented || (this._focustrap.deactivate(), this._element.blur(), this._isShown = false, this._element.classList.add(Nn), this._backdrop.hide(), this._queueCallback((() => {
                this._element.classList.remove($n, Nn), this._element.removeAttribute("aria-modal"), this._element.removeAttribute("role"), this._config.scroll || new dn().reset(), N.trigger(this._element, Wn);
              }), this._element, true)));
            }
            dispose() {
              this._backdrop.dispose(), this._focustrap.deactivate(), super.dispose();
            }
            _initializeBackDrop() {
              const t2 = Boolean(this._config.backdrop);
              return new Ji({ className: "offcanvas-backdrop", isVisible: t2, isAnimated: true, rootElement: this._element.parentNode, clickCallback: t2 ? () => {
                "static" !== this._config.backdrop ? this.hide() : N.trigger(this._element, Hn);
              } : null });
            }
            _initializeFocusTrap() {
              return new rn({ trapElement: this._element });
            }
            _addEventListeners() {
              N.on(this._element, Rn, ((t2) => {
                "Escape" === t2.key && (this._config.keyboard ? this.hide() : N.trigger(this._element, Hn));
              }));
            }
            static jQueryInterface(t2) {
              return this.each((function() {
                const e2 = Kn.getOrCreateInstance(this, t2);
                if ("string" == typeof t2) {
                  if (void 0 === e2[t2] || t2.startsWith("_") || "constructor" === t2) throw new TypeError(`No method named "${t2}"`);
                  e2[t2](this);
                }
              }));
            }
          }
          N.on(document, zn, '[data-bs-toggle="offcanvas"]', (function(t2) {
            const e2 = z.getElementFromSelector(this);
            if (["A", "AREA"].includes(this.tagName) && t2.preventDefault(), l(this)) return;
            N.one(e2, Wn, (() => {
              a(this) && this.focus();
            }));
            const i3 = z.findOne(Pn);
            i3 && i3 !== e2 && Kn.getInstance(i3).hide(), Kn.getOrCreateInstance(e2).toggle(this);
          })), N.on(window, Dn, (() => {
            for (const t2 of z.find(Pn)) Kn.getOrCreateInstance(t2).show();
          })), N.on(window, Bn, (() => {
            for (const t2 of z.find("[aria-modal][class*=show][class*=offcanvas-]")) "fixed" !== getComputedStyle(t2).position && Kn.getOrCreateInstance(t2).hide();
          })), R(Kn), m(Kn);
          const Qn = { "*": ["class", "dir", "id", "lang", "role", /^aria-[\w-]*$/i], a: ["target", "href", "title", "rel"], area: [], b: [], br: [], col: [], code: [], dd: [], div: [], dl: [], dt: [], em: [], hr: [], h1: [], h2: [], h3: [], h4: [], h5: [], h6: [], i: [], img: ["src", "srcset", "alt", "title", "width", "height"], li: [], ol: [], p: [], pre: [], s: [], small: [], span: [], sub: [], sup: [], strong: [], u: [], ul: [] }, Xn = /* @__PURE__ */ new Set(["background", "cite", "href", "itemtype", "longdesc", "poster", "src", "xlink:href"]), Yn = /^(?!javascript:)(?:[a-z0-9+.-]+:|[^&:/?#]*(?:[/?#]|$))/i, Un = (t2, e2) => {
            const i3 = t2.nodeName.toLowerCase();
            return e2.includes(i3) ? !Xn.has(i3) || Boolean(Yn.test(t2.nodeValue)) : e2.filter(((t3) => t3 instanceof RegExp)).some(((t3) => t3.test(i3)));
          }, Gn = { allowList: Qn, content: {}, extraClass: "", html: false, sanitize: true, sanitizeFn: null, template: "<div></div>" }, Jn = { allowList: "object", content: "object", extraClass: "(string|function)", html: "boolean", sanitize: "boolean", sanitizeFn: "(null|function)", template: "string" }, Zn = { entry: "(string|element|function|null)", selector: "(string|element)" };
          class ts extends H {
            constructor(t2) {
              super(), this._config = this._getConfig(t2);
            }
            static get Default() {
              return Gn;
            }
            static get DefaultType() {
              return Jn;
            }
            static get NAME() {
              return "TemplateFactory";
            }
            getContent() {
              return Object.values(this._config.content).map(((t2) => this._resolvePossibleFunction(t2))).filter(Boolean);
            }
            hasContent() {
              return this.getContent().length > 0;
            }
            changeContent(t2) {
              return this._checkContent(t2), this._config.content = { ...this._config.content, ...t2 }, this;
            }
            toHtml() {
              const t2 = document.createElement("div");
              t2.innerHTML = this._maybeSanitize(this._config.template);
              for (const [e3, i4] of Object.entries(this._config.content)) this._setContent(t2, i4, e3);
              const e2 = t2.children[0], i3 = this._resolvePossibleFunction(this._config.extraClass);
              return i3 && e2.classList.add(...i3.split(" ")), e2;
            }
            _typeCheckConfig(t2) {
              super._typeCheckConfig(t2), this._checkContent(t2.content);
            }
            _checkContent(t2) {
              for (const [e2, i3] of Object.entries(t2)) super._typeCheckConfig({ selector: e2, entry: i3 }, Zn);
            }
            _setContent(t2, e2, i3) {
              const n2 = z.findOne(i3, t2);
              n2 && ((e2 = this._resolvePossibleFunction(e2)) ? o(e2) ? this._putElementInTemplate(r(e2), n2) : this._config.html ? n2.innerHTML = this._maybeSanitize(e2) : n2.textContent = e2 : n2.remove());
            }
            _maybeSanitize(t2) {
              return this._config.sanitize ? (function(t3, e2, i3) {
                if (!t3.length) return t3;
                if (i3 && "function" == typeof i3) return i3(t3);
                const n2 = new window.DOMParser().parseFromString(t3, "text/html"), s2 = [].concat(...n2.body.querySelectorAll("*"));
                for (const t4 of s2) {
                  const i4 = t4.nodeName.toLowerCase();
                  if (!Object.keys(e2).includes(i4)) {
                    t4.remove();
                    continue;
                  }
                  const n3 = [].concat(...t4.attributes), s3 = [].concat(e2["*"] || [], e2[i4] || []);
                  for (const e3 of n3) Un(e3, s3) || t4.removeAttribute(e3.nodeName);
                }
                return n2.body.innerHTML;
              })(t2, this._config.allowList, this._config.sanitizeFn) : t2;
            }
            _resolvePossibleFunction(t2) {
              return g(t2, [void 0, this]);
            }
            _putElementInTemplate(t2, e2) {
              if (this._config.html) return e2.innerHTML = "", void e2.append(t2);
              e2.textContent = t2.textContent;
            }
          }
          const es = /* @__PURE__ */ new Set(["sanitize", "allowList", "sanitizeFn"]), is = "fade", ns = "show", ss = ".tooltip-inner", os = ".modal", rs = "hide.bs.modal", as = "hover", ls = "focus", cs = "click", hs = { AUTO: "auto", TOP: "top", RIGHT: p() ? "left" : "right", BOTTOM: "bottom", LEFT: p() ? "right" : "left" }, ds = { allowList: Qn, animation: true, boundary: "clippingParents", container: false, customClass: "", delay: 0, fallbackPlacements: ["top", "right", "bottom", "left"], html: false, offset: [0, 6], placement: "top", popperConfig: null, sanitize: true, sanitizeFn: null, selector: false, template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>', title: "", trigger: "hover focus" }, us = { allowList: "object", animation: "boolean", boundary: "(string|element)", container: "(string|element|boolean)", customClass: "(string|function)", delay: "(number|object)", fallbackPlacements: "array", html: "boolean", offset: "(array|string|function)", placement: "(string|function)", popperConfig: "(null|object|function)", sanitize: "boolean", sanitizeFn: "(null|function)", selector: "(string|boolean)", template: "string", title: "(string|element|function)", trigger: "string" };
          class fs extends W {
            constructor(t2, e2) {
              if (void 0 === wi) throw new TypeError("Bootstrap's tooltips require Popper (https://popper.js.org/docs/v2/)");
              super(t2, e2), this._isEnabled = true, this._timeout = 0, this._isHovered = null, this._activeTrigger = {}, this._popper = null, this._templateFactory = null, this._newContent = null, this.tip = null, this._setListeners(), this._config.selector || this._fixTitle();
            }
            static get Default() {
              return ds;
            }
            static get DefaultType() {
              return us;
            }
            static get NAME() {
              return "tooltip";
            }
            enable() {
              this._isEnabled = true;
            }
            disable() {
              this._isEnabled = false;
            }
            toggleEnabled() {
              this._isEnabled = !this._isEnabled;
            }
            toggle() {
              this._isEnabled && (this._isShown() ? this._leave() : this._enter());
            }
            dispose() {
              clearTimeout(this._timeout), N.off(this._element.closest(os), rs, this._hideModalHandler), this._element.getAttribute("data-bs-original-title") && this._element.setAttribute("title", this._element.getAttribute("data-bs-original-title")), this._disposePopper(), super.dispose();
            }
            show() {
              if ("none" === this._element.style.display) throw new Error("Please use show on visible elements");
              if (!this._isWithContent() || !this._isEnabled) return;
              const t2 = N.trigger(this._element, this.constructor.eventName("show")), e2 = (c(this._element) || this._element.ownerDocument.documentElement).contains(this._element);
              if (t2.defaultPrevented || !e2) return;
              this._disposePopper();
              const i3 = this._getTipElement();
              this._element.setAttribute("aria-describedby", i3.getAttribute("id"));
              const { container: n2 } = this._config;
              if (this._element.ownerDocument.documentElement.contains(this.tip) || (n2.append(i3), N.trigger(this._element, this.constructor.eventName("inserted"))), this._popper = this._createPopper(i3), i3.classList.add(ns), "ontouchstart" in document.documentElement) for (const t3 of [].concat(...document.body.children)) N.on(t3, "mouseover", h);
              this._queueCallback((() => {
                N.trigger(this._element, this.constructor.eventName("shown")), false === this._isHovered && this._leave(), this._isHovered = false;
              }), this.tip, this._isAnimated());
            }
            hide() {
              if (this._isShown() && !N.trigger(this._element, this.constructor.eventName("hide")).defaultPrevented) {
                if (this._getTipElement().classList.remove(ns), "ontouchstart" in document.documentElement) for (const t2 of [].concat(...document.body.children)) N.off(t2, "mouseover", h);
                this._activeTrigger[cs] = false, this._activeTrigger[ls] = false, this._activeTrigger[as] = false, this._isHovered = null, this._queueCallback((() => {
                  this._isWithActiveTrigger() || (this._isHovered || this._disposePopper(), this._element.removeAttribute("aria-describedby"), N.trigger(this._element, this.constructor.eventName("hidden")));
                }), this.tip, this._isAnimated());
              }
            }
            update() {
              this._popper && this._popper.update();
            }
            _isWithContent() {
              return Boolean(this._getTitle());
            }
            _getTipElement() {
              return this.tip || (this.tip = this._createTipElement(this._newContent || this._getContentForTemplate())), this.tip;
            }
            _createTipElement(t2) {
              const e2 = this._getTemplateFactory(t2).toHtml();
              if (!e2) return null;
              e2.classList.remove(is, ns), e2.classList.add(`bs-${this.constructor.NAME}-auto`);
              const i3 = ((t3) => {
                do {
                  t3 += Math.floor(1e6 * Math.random());
                } while (document.getElementById(t3));
                return t3;
              })(this.constructor.NAME).toString();
              return e2.setAttribute("id", i3), this._isAnimated() && e2.classList.add(is), e2;
            }
            setContent(t2) {
              this._newContent = t2, this._isShown() && (this._disposePopper(), this.show());
            }
            _getTemplateFactory(t2) {
              return this._templateFactory ? this._templateFactory.changeContent(t2) : this._templateFactory = new ts({ ...this._config, content: t2, extraClass: this._resolvePossibleFunction(this._config.customClass) }), this._templateFactory;
            }
            _getContentForTemplate() {
              return { [ss]: this._getTitle() };
            }
            _getTitle() {
              return this._resolvePossibleFunction(this._config.title) || this._element.getAttribute("data-bs-original-title");
            }
            _initializeOnDelegatedTarget(t2) {
              return this.constructor.getOrCreateInstance(t2.delegateTarget, this._getDelegateConfig());
            }
            _isAnimated() {
              return this._config.animation || this.tip && this.tip.classList.contains(is);
            }
            _isShown() {
              return this.tip && this.tip.classList.contains(ns);
            }
            _createPopper(t2) {
              const e2 = g(this._config.placement, [this, t2, this._element]), i3 = hs[e2.toUpperCase()];
              return yi(this._element, t2, this._getPopperConfig(i3));
            }
            _getOffset() {
              const { offset: t2 } = this._config;
              return "string" == typeof t2 ? t2.split(",").map(((t3) => Number.parseInt(t3, 10))) : "function" == typeof t2 ? (e2) => t2(e2, this._element) : t2;
            }
            _resolvePossibleFunction(t2) {
              return g(t2, [this._element, this._element]);
            }
            _getPopperConfig(t2) {
              const e2 = { placement: t2, modifiers: [{ name: "flip", options: { fallbackPlacements: this._config.fallbackPlacements } }, { name: "offset", options: { offset: this._getOffset() } }, { name: "preventOverflow", options: { boundary: this._config.boundary } }, { name: "arrow", options: { element: `.${this.constructor.NAME}-arrow` } }, { name: "preSetPlacement", enabled: true, phase: "beforeMain", fn: (t3) => {
                this._getTipElement().setAttribute("data-popper-placement", t3.state.placement);
              } }] };
              return { ...e2, ...g(this._config.popperConfig, [void 0, e2]) };
            }
            _setListeners() {
              const t2 = this._config.trigger.split(" ");
              for (const e2 of t2) if ("click" === e2) N.on(this._element, this.constructor.eventName("click"), this._config.selector, ((t3) => {
                const e3 = this._initializeOnDelegatedTarget(t3);
                e3._activeTrigger[cs] = !(e3._isShown() && e3._activeTrigger[cs]), e3.toggle();
              }));
              else if ("manual" !== e2) {
                const t3 = e2 === as ? this.constructor.eventName("mouseenter") : this.constructor.eventName("focusin"), i3 = e2 === as ? this.constructor.eventName("mouseleave") : this.constructor.eventName("focusout");
                N.on(this._element, t3, this._config.selector, ((t4) => {
                  const e3 = this._initializeOnDelegatedTarget(t4);
                  e3._activeTrigger["focusin" === t4.type ? ls : as] = true, e3._enter();
                })), N.on(this._element, i3, this._config.selector, ((t4) => {
                  const e3 = this._initializeOnDelegatedTarget(t4);
                  e3._activeTrigger["focusout" === t4.type ? ls : as] = e3._element.contains(t4.relatedTarget), e3._leave();
                }));
              }
              this._hideModalHandler = () => {
                this._element && this.hide();
              }, N.on(this._element.closest(os), rs, this._hideModalHandler);
            }
            _fixTitle() {
              const t2 = this._element.getAttribute("title");
              t2 && (this._element.getAttribute("aria-label") || this._element.textContent.trim() || this._element.setAttribute("aria-label", t2), this._element.setAttribute("data-bs-original-title", t2), this._element.removeAttribute("title"));
            }
            _enter() {
              this._isShown() || this._isHovered ? this._isHovered = true : (this._isHovered = true, this._setTimeout((() => {
                this._isHovered && this.show();
              }), this._config.delay.show));
            }
            _leave() {
              this._isWithActiveTrigger() || (this._isHovered = false, this._setTimeout((() => {
                this._isHovered || this.hide();
              }), this._config.delay.hide));
            }
            _setTimeout(t2, e2) {
              clearTimeout(this._timeout), this._timeout = setTimeout(t2, e2);
            }
            _isWithActiveTrigger() {
              return Object.values(this._activeTrigger).includes(true);
            }
            _getConfig(t2) {
              const e2 = F.getDataAttributes(this._element);
              for (const t3 of Object.keys(e2)) es.has(t3) && delete e2[t3];
              return t2 = { ...e2, ..."object" == typeof t2 && t2 ? t2 : {} }, t2 = this._mergeConfigObj(t2), t2 = this._configAfterMerge(t2), this._typeCheckConfig(t2), t2;
            }
            _configAfterMerge(t2) {
              return t2.container = false === t2.container ? document.body : r(t2.container), "number" == typeof t2.delay && (t2.delay = { show: t2.delay, hide: t2.delay }), "number" == typeof t2.title && (t2.title = t2.title.toString()), "number" == typeof t2.content && (t2.content = t2.content.toString()), t2;
            }
            _getDelegateConfig() {
              const t2 = {};
              for (const [e2, i3] of Object.entries(this._config)) this.constructor.Default[e2] !== i3 && (t2[e2] = i3);
              return t2.selector = false, t2.trigger = "manual", t2;
            }
            _disposePopper() {
              this._popper && (this._popper.destroy(), this._popper = null), this.tip && (this.tip.remove(), this.tip = null);
            }
            static jQueryInterface(t2) {
              return this.each((function() {
                const e2 = fs.getOrCreateInstance(this, t2);
                if ("string" == typeof t2) {
                  if (void 0 === e2[t2]) throw new TypeError(`No method named "${t2}"`);
                  e2[t2]();
                }
              }));
            }
          }
          m(fs);
          const ps = ".popover-header", ms = ".popover-body", gs = { ...fs.Default, content: "", offset: [0, 8], placement: "right", template: '<div class="popover" role="tooltip"><div class="popover-arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>', trigger: "click" }, _s = { ...fs.DefaultType, content: "(null|string|element|function)" };
          class bs extends fs {
            static get Default() {
              return gs;
            }
            static get DefaultType() {
              return _s;
            }
            static get NAME() {
              return "popover";
            }
            _isWithContent() {
              return this._getTitle() || this._getContent();
            }
            _getContentForTemplate() {
              return { [ps]: this._getTitle(), [ms]: this._getContent() };
            }
            _getContent() {
              return this._resolvePossibleFunction(this._config.content);
            }
            static jQueryInterface(t2) {
              return this.each((function() {
                const e2 = bs.getOrCreateInstance(this, t2);
                if ("string" == typeof t2) {
                  if (void 0 === e2[t2]) throw new TypeError(`No method named "${t2}"`);
                  e2[t2]();
                }
              }));
            }
          }
          m(bs);
          const vs = ".bs.scrollspy", ys = `activate${vs}`, ws = `click${vs}`, As = `load${vs}.data-api`, Es = "active", Ts = "[href]", Cs = ".nav-link", Os = `${Cs}, .nav-item > ${Cs}, .list-group-item`, xs = { offset: null, rootMargin: "0px 0px -25%", smoothScroll: false, target: null, threshold: [0.1, 0.5, 1] }, ks = { offset: "(number|null)", rootMargin: "string", smoothScroll: "boolean", target: "element", threshold: "array" };
          class Ls extends W {
            constructor(t2, e2) {
              super(t2, e2), this._targetLinks = /* @__PURE__ */ new Map(), this._observableSections = /* @__PURE__ */ new Map(), this._rootElement = "visible" === getComputedStyle(this._element).overflowY ? null : this._element, this._activeTarget = null, this._observer = null, this._previousScrollData = { visibleEntryTop: 0, parentScrollTop: 0 }, this.refresh();
            }
            static get Default() {
              return xs;
            }
            static get DefaultType() {
              return ks;
            }
            static get NAME() {
              return "scrollspy";
            }
            refresh() {
              this._initializeTargetsAndObservables(), this._maybeEnableSmoothScroll(), this._observer ? this._observer.disconnect() : this._observer = this._getNewObserver();
              for (const t2 of this._observableSections.values()) this._observer.observe(t2);
            }
            dispose() {
              this._observer.disconnect(), super.dispose();
            }
            _configAfterMerge(t2) {
              return t2.target = r(t2.target) || document.body, t2.rootMargin = t2.offset ? `${t2.offset}px 0px -30%` : t2.rootMargin, "string" == typeof t2.threshold && (t2.threshold = t2.threshold.split(",").map(((t3) => Number.parseFloat(t3)))), t2;
            }
            _maybeEnableSmoothScroll() {
              this._config.smoothScroll && (N.off(this._config.target, ws), N.on(this._config.target, ws, Ts, ((t2) => {
                const e2 = this._observableSections.get(t2.target.hash);
                if (e2) {
                  t2.preventDefault();
                  const i3 = this._rootElement || window, n2 = e2.offsetTop - this._element.offsetTop;
                  if (i3.scrollTo) return void i3.scrollTo({ top: n2, behavior: "smooth" });
                  i3.scrollTop = n2;
                }
              })));
            }
            _getNewObserver() {
              const t2 = { root: this._rootElement, threshold: this._config.threshold, rootMargin: this._config.rootMargin };
              return new IntersectionObserver(((t3) => this._observerCallback(t3)), t2);
            }
            _observerCallback(t2) {
              const e2 = (t3) => this._targetLinks.get(`#${t3.target.id}`), i3 = (t3) => {
                this._previousScrollData.visibleEntryTop = t3.target.offsetTop, this._process(e2(t3));
              }, n2 = (this._rootElement || document.documentElement).scrollTop, s2 = n2 >= this._previousScrollData.parentScrollTop;
              this._previousScrollData.parentScrollTop = n2;
              for (const o2 of t2) {
                if (!o2.isIntersecting) {
                  this._activeTarget = null, this._clearActiveClass(e2(o2));
                  continue;
                }
                const t3 = o2.target.offsetTop >= this._previousScrollData.visibleEntryTop;
                if (s2 && t3) {
                  if (i3(o2), !n2) return;
                } else s2 || t3 || i3(o2);
              }
            }
            _initializeTargetsAndObservables() {
              this._targetLinks = /* @__PURE__ */ new Map(), this._observableSections = /* @__PURE__ */ new Map();
              const t2 = z.find(Ts, this._config.target);
              for (const e2 of t2) {
                if (!e2.hash || l(e2)) continue;
                const t3 = z.findOne(decodeURI(e2.hash), this._element);
                a(t3) && (this._targetLinks.set(decodeURI(e2.hash), e2), this._observableSections.set(e2.hash, t3));
              }
            }
            _process(t2) {
              this._activeTarget !== t2 && (this._clearActiveClass(this._config.target), this._activeTarget = t2, t2.classList.add(Es), this._activateParents(t2), N.trigger(this._element, ys, { relatedTarget: t2 }));
            }
            _activateParents(t2) {
              if (t2.classList.contains("dropdown-item")) z.findOne(".dropdown-toggle", t2.closest(".dropdown")).classList.add(Es);
              else for (const e2 of z.parents(t2, ".nav, .list-group")) for (const t3 of z.prev(e2, Os)) t3.classList.add(Es);
            }
            _clearActiveClass(t2) {
              t2.classList.remove(Es);
              const e2 = z.find(`${Ts}.${Es}`, t2);
              for (const t3 of e2) t3.classList.remove(Es);
            }
            static jQueryInterface(t2) {
              return this.each((function() {
                const e2 = Ls.getOrCreateInstance(this, t2);
                if ("string" == typeof t2) {
                  if (void 0 === e2[t2] || t2.startsWith("_") || "constructor" === t2) throw new TypeError(`No method named "${t2}"`);
                  e2[t2]();
                }
              }));
            }
          }
          N.on(window, As, (() => {
            for (const t2 of z.find('[data-bs-spy="scroll"]')) Ls.getOrCreateInstance(t2);
          })), m(Ls);
          const Ss = ".bs.tab", Ds = `hide${Ss}`, $s = `hidden${Ss}`, Is = `show${Ss}`, Ns = `shown${Ss}`, Ps = `click${Ss}`, js = `keydown${Ss}`, Ms = `load${Ss}`, Fs = "ArrowLeft", Hs = "ArrowRight", Ws = "ArrowUp", Bs = "ArrowDown", zs = "Home", Rs = "End", qs = "active", Vs = "fade", Ks = "show", Qs = ".dropdown-toggle", Xs = `:not(${Qs})`, Ys = '[data-bs-toggle="tab"], [data-bs-toggle="pill"], [data-bs-toggle="list"]', Us = `.nav-link${Xs}, .list-group-item${Xs}, [role="tab"]${Xs}, ${Ys}`, Gs = `.${qs}[data-bs-toggle="tab"], .${qs}[data-bs-toggle="pill"], .${qs}[data-bs-toggle="list"]`;
          class Js extends W {
            constructor(t2) {
              super(t2), this._parent = this._element.closest('.list-group, .nav, [role="tablist"]'), this._parent && (this._setInitialAttributes(this._parent, this._getChildren()), N.on(this._element, js, ((t3) => this._keydown(t3))));
            }
            static get NAME() {
              return "tab";
            }
            show() {
              const t2 = this._element;
              if (this._elemIsActive(t2)) return;
              const e2 = this._getActiveElem(), i3 = e2 ? N.trigger(e2, Ds, { relatedTarget: t2 }) : null;
              N.trigger(t2, Is, { relatedTarget: e2 }).defaultPrevented || i3 && i3.defaultPrevented || (this._deactivate(e2, t2), this._activate(t2, e2));
            }
            _activate(t2, e2) {
              t2 && (t2.classList.add(qs), this._activate(z.getElementFromSelector(t2)), this._queueCallback((() => {
                "tab" === t2.getAttribute("role") ? (t2.removeAttribute("tabindex"), t2.setAttribute("aria-selected", true), this._toggleDropDown(t2, true), N.trigger(t2, Ns, { relatedTarget: e2 })) : t2.classList.add(Ks);
              }), t2, t2.classList.contains(Vs)));
            }
            _deactivate(t2, e2) {
              t2 && (t2.classList.remove(qs), t2.blur(), this._deactivate(z.getElementFromSelector(t2)), this._queueCallback((() => {
                "tab" === t2.getAttribute("role") ? (t2.setAttribute("aria-selected", false), t2.setAttribute("tabindex", "-1"), this._toggleDropDown(t2, false), N.trigger(t2, $s, { relatedTarget: e2 })) : t2.classList.remove(Ks);
              }), t2, t2.classList.contains(Vs)));
            }
            _keydown(t2) {
              if (![Fs, Hs, Ws, Bs, zs, Rs].includes(t2.key)) return;
              t2.stopPropagation(), t2.preventDefault();
              const e2 = this._getChildren().filter(((t3) => !l(t3)));
              let i3;
              if ([zs, Rs].includes(t2.key)) i3 = e2[t2.key === zs ? 0 : e2.length - 1];
              else {
                const n2 = [Hs, Bs].includes(t2.key);
                i3 = b(e2, t2.target, n2, true);
              }
              i3 && (i3.focus({ preventScroll: true }), Js.getOrCreateInstance(i3).show());
            }
            _getChildren() {
              return z.find(Us, this._parent);
            }
            _getActiveElem() {
              return this._getChildren().find(((t2) => this._elemIsActive(t2))) || null;
            }
            _setInitialAttributes(t2, e2) {
              this._setAttributeIfNotExists(t2, "role", "tablist");
              for (const t3 of e2) this._setInitialAttributesOnChild(t3);
            }
            _setInitialAttributesOnChild(t2) {
              t2 = this._getInnerElement(t2);
              const e2 = this._elemIsActive(t2), i3 = this._getOuterElement(t2);
              t2.setAttribute("aria-selected", e2), i3 !== t2 && this._setAttributeIfNotExists(i3, "role", "presentation"), e2 || t2.setAttribute("tabindex", "-1"), this._setAttributeIfNotExists(t2, "role", "tab"), this._setInitialAttributesOnTargetPanel(t2);
            }
            _setInitialAttributesOnTargetPanel(t2) {
              const e2 = z.getElementFromSelector(t2);
              e2 && (this._setAttributeIfNotExists(e2, "role", "tabpanel"), t2.id && this._setAttributeIfNotExists(e2, "aria-labelledby", `${t2.id}`));
            }
            _toggleDropDown(t2, e2) {
              const i3 = this._getOuterElement(t2);
              if (!i3.classList.contains("dropdown")) return;
              const n2 = (t3, n3) => {
                const s2 = z.findOne(t3, i3);
                s2 && s2.classList.toggle(n3, e2);
              };
              n2(Qs, qs), n2(".dropdown-menu", Ks), i3.setAttribute("aria-expanded", e2);
            }
            _setAttributeIfNotExists(t2, e2, i3) {
              t2.hasAttribute(e2) || t2.setAttribute(e2, i3);
            }
            _elemIsActive(t2) {
              return t2.classList.contains(qs);
            }
            _getInnerElement(t2) {
              return t2.matches(Us) ? t2 : z.findOne(Us, t2);
            }
            _getOuterElement(t2) {
              return t2.closest(".nav-item, .list-group-item") || t2;
            }
            static jQueryInterface(t2) {
              return this.each((function() {
                const e2 = Js.getOrCreateInstance(this);
                if ("string" == typeof t2) {
                  if (void 0 === e2[t2] || t2.startsWith("_") || "constructor" === t2) throw new TypeError(`No method named "${t2}"`);
                  e2[t2]();
                }
              }));
            }
          }
          N.on(document, Ps, Ys, (function(t2) {
            ["A", "AREA"].includes(this.tagName) && t2.preventDefault(), l(this) || Js.getOrCreateInstance(this).show();
          })), N.on(window, Ms, (() => {
            for (const t2 of z.find(Gs)) Js.getOrCreateInstance(t2);
          })), m(Js);
          const Zs = ".bs.toast", to = `mouseover${Zs}`, eo = `mouseout${Zs}`, io = `focusin${Zs}`, no = `focusout${Zs}`, so = `hide${Zs}`, oo = `hidden${Zs}`, ro = `show${Zs}`, ao = `shown${Zs}`, lo = "hide", co = "show", ho = "showing", uo = { animation: "boolean", autohide: "boolean", delay: "number" }, fo = { animation: true, autohide: true, delay: 5e3 };
          class po extends W {
            constructor(t2, e2) {
              super(t2, e2), this._timeout = null, this._hasMouseInteraction = false, this._hasKeyboardInteraction = false, this._setListeners();
            }
            static get Default() {
              return fo;
            }
            static get DefaultType() {
              return uo;
            }
            static get NAME() {
              return "toast";
            }
            show() {
              N.trigger(this._element, ro).defaultPrevented || (this._clearTimeout(), this._config.animation && this._element.classList.add("fade"), this._element.classList.remove(lo), d(this._element), this._element.classList.add(co, ho), this._queueCallback((() => {
                this._element.classList.remove(ho), N.trigger(this._element, ao), this._maybeScheduleHide();
              }), this._element, this._config.animation));
            }
            hide() {
              this.isShown() && (N.trigger(this._element, so).defaultPrevented || (this._element.classList.add(ho), this._queueCallback((() => {
                this._element.classList.add(lo), this._element.classList.remove(ho, co), N.trigger(this._element, oo);
              }), this._element, this._config.animation)));
            }
            dispose() {
              this._clearTimeout(), this.isShown() && this._element.classList.remove(co), super.dispose();
            }
            isShown() {
              return this._element.classList.contains(co);
            }
            _maybeScheduleHide() {
              this._config.autohide && (this._hasMouseInteraction || this._hasKeyboardInteraction || (this._timeout = setTimeout((() => {
                this.hide();
              }), this._config.delay)));
            }
            _onInteraction(t2, e2) {
              switch (t2.type) {
                case "mouseover":
                case "mouseout":
                  this._hasMouseInteraction = e2;
                  break;
                case "focusin":
                case "focusout":
                  this._hasKeyboardInteraction = e2;
              }
              if (e2) return void this._clearTimeout();
              const i3 = t2.relatedTarget;
              this._element === i3 || this._element.contains(i3) || this._maybeScheduleHide();
            }
            _setListeners() {
              N.on(this._element, to, ((t2) => this._onInteraction(t2, true))), N.on(this._element, eo, ((t2) => this._onInteraction(t2, false))), N.on(this._element, io, ((t2) => this._onInteraction(t2, true))), N.on(this._element, no, ((t2) => this._onInteraction(t2, false)));
            }
            _clearTimeout() {
              clearTimeout(this._timeout), this._timeout = null;
            }
            static jQueryInterface(t2) {
              return this.each((function() {
                const e2 = po.getOrCreateInstance(this, t2);
                if ("string" == typeof t2) {
                  if (void 0 === e2[t2]) throw new TypeError(`No method named "${t2}"`);
                  e2[t2](this);
                }
              }));
            }
          }
          return R(po), m(po), { Alert: Q, Button: Y, Carousel: Lt, Collapse: Rt, Dropdown: Ki, Modal: kn, Offcanvas: Kn, Popover: bs, ScrollSpy: Ls, Tab: Js, Toast: po, Tooltip: fs };
        }));
      })(bootstrap_bundle_min$1);
      return bootstrap_bundle_min$1.exports;
    }
    requireBootstrap_bundle_min();
    var HOOKS = [
      "onChange",
      "onClose",
      "onDayCreate",
      "onDestroy",
      "onKeyDown",
      "onMonthChange",
      "onOpen",
      "onParseConfig",
      "onReady",
      "onValueUpdate",
      "onYearChange",
      "onPreCalendarPosition"
    ];
    var defaults = {
      _disable: [],
      allowInput: false,
      allowInvalidPreload: false,
      altFormat: "F j, Y",
      altInput: false,
      altInputClass: "form-control input",
      animate: typeof window === "object" && window.navigator.userAgent.indexOf("MSIE") === -1,
      ariaDateFormat: "F j, Y",
      autoFillDefaultTime: true,
      clickOpens: true,
      closeOnSelect: true,
      conjunction: ", ",
      dateFormat: "Y-m-d",
      defaultHour: 12,
      defaultMinute: 0,
      defaultSeconds: 0,
      disable: [],
      disableMobile: false,
      enableSeconds: false,
      enableTime: false,
      errorHandler: function(err) {
        return typeof console !== "undefined" && console.warn(err);
      },
      getWeek: function(givenDate) {
        var date = new Date(givenDate.getTime());
        date.setHours(0, 0, 0, 0);
        date.setDate(date.getDate() + 3 - (date.getDay() + 6) % 7);
        var week1 = new Date(date.getFullYear(), 0, 4);
        return 1 + Math.round(((date.getTime() - week1.getTime()) / 864e5 - 3 + (week1.getDay() + 6) % 7) / 7);
      },
      hourIncrement: 1,
      ignoredFocusElements: [],
      inline: false,
      locale: "default",
      minuteIncrement: 5,
      mode: "single",
      monthSelectorType: "dropdown",
      nextArrow: "<svg version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 17 17'><g></g><path d='M13.207 8.472l-7.854 7.854-0.707-0.707 7.146-7.146-7.146-7.148 0.707-0.707 7.854 7.854z' /></svg>",
      noCalendar: false,
      now: /* @__PURE__ */ new Date(),
      onChange: [],
      onClose: [],
      onDayCreate: [],
      onDestroy: [],
      onKeyDown: [],
      onMonthChange: [],
      onOpen: [],
      onParseConfig: [],
      onReady: [],
      onValueUpdate: [],
      onYearChange: [],
      onPreCalendarPosition: [],
      plugins: [],
      position: "auto",
      positionElement: void 0,
      prevArrow: "<svg version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 17 17'><g></g><path d='M5.207 8.471l7.146 7.147-0.707 0.707-7.853-7.854 7.854-7.853 0.707 0.707-7.147 7.146z' /></svg>",
      shorthandCurrentMonth: false,
      showMonths: 1,
      static: false,
      time_24hr: false,
      weekNumbers: false,
      wrap: false
    };
    var english = {
      weekdays: {
        shorthand: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
        longhand: [
          "Sunday",
          "Monday",
          "Tuesday",
          "Wednesday",
          "Thursday",
          "Friday",
          "Saturday"
        ]
      },
      months: {
        shorthand: [
          "Jan",
          "Feb",
          "Mar",
          "Apr",
          "May",
          "Jun",
          "Jul",
          "Aug",
          "Sep",
          "Oct",
          "Nov",
          "Dec"
        ],
        longhand: [
          "January",
          "February",
          "March",
          "April",
          "May",
          "June",
          "July",
          "August",
          "September",
          "October",
          "November",
          "December"
        ]
      },
      daysInMonth: [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
      firstDayOfWeek: 0,
      ordinal: function(nth) {
        var s = nth % 100;
        if (s > 3 && s < 21)
          return "th";
        switch (s % 10) {
          case 1:
            return "st";
          case 2:
            return "nd";
          case 3:
            return "rd";
          default:
            return "th";
        }
      },
      rangeSeparator: " to ",
      weekAbbreviation: "Wk",
      scrollTitle: "Scroll to increment",
      toggleTitle: "Click to toggle",
      amPM: ["AM", "PM"],
      yearAriaLabel: "Year",
      monthAriaLabel: "Month",
      hourAriaLabel: "Hour",
      minuteAriaLabel: "Minute",
      time_24hr: false
    };
    var pad = function(number, length) {
      if (length === void 0) {
        length = 2;
      }
      return ("000" + number).slice(length * -1);
    };
    var int = function(bool) {
      return bool === true ? 1 : 0;
    };
    function debounce(fn, wait) {
      var t;
      return function() {
        var _this = this;
        var args = arguments;
        clearTimeout(t);
        t = setTimeout(function() {
          return fn.apply(_this, args);
        }, wait);
      };
    }
    var arrayify = function(obj) {
      return obj instanceof Array ? obj : [obj];
    };
    function toggleClass(elem, className, bool) {
      if (bool === true)
        return elem.classList.add(className);
      elem.classList.remove(className);
    }
    function createElement(tag, className, content) {
      var e = window.document.createElement(tag);
      className = className || "";
      content = content || "";
      e.className = className;
      if (content !== void 0)
        e.textContent = content;
      return e;
    }
    function clearNode(node) {
      while (node.firstChild)
        node.removeChild(node.firstChild);
    }
    function findParent(node, condition) {
      if (condition(node))
        return node;
      else if (node.parentNode)
        return findParent(node.parentNode, condition);
      return void 0;
    }
    function createNumberInput(inputClassName, opts) {
      var wrapper = createElement("div", "numInputWrapper"), numInput = createElement("input", "numInput " + inputClassName), arrowUp = createElement("span", "arrowUp"), arrowDown = createElement("span", "arrowDown");
      if (navigator.userAgent.indexOf("MSIE 9.0") === -1) {
        numInput.type = "number";
      } else {
        numInput.type = "text";
        numInput.pattern = "\\d*";
      }
      if (opts !== void 0)
        for (var key2 in opts)
          numInput.setAttribute(key2, opts[key2]);
      wrapper.appendChild(numInput);
      wrapper.appendChild(arrowUp);
      wrapper.appendChild(arrowDown);
      return wrapper;
    }
    function getEventTarget(event) {
      try {
        if (typeof event.composedPath === "function") {
          var path = event.composedPath();
          return path[0];
        }
        return event.target;
      } catch (error) {
        return event.target;
      }
    }
    var doNothing = function() {
      return void 0;
    };
    var monthToStr = function(monthNumber, shorthand, locale) {
      return locale.months[shorthand ? "shorthand" : "longhand"][monthNumber];
    };
    var revFormat = {
      D: doNothing,
      F: function(dateObj, monthName, locale) {
        dateObj.setMonth(locale.months.longhand.indexOf(monthName));
      },
      G: function(dateObj, hour) {
        dateObj.setHours((dateObj.getHours() >= 12 ? 12 : 0) + parseFloat(hour));
      },
      H: function(dateObj, hour) {
        dateObj.setHours(parseFloat(hour));
      },
      J: function(dateObj, day) {
        dateObj.setDate(parseFloat(day));
      },
      K: function(dateObj, amPM, locale) {
        dateObj.setHours(dateObj.getHours() % 12 + 12 * int(new RegExp(locale.amPM[1], "i").test(amPM)));
      },
      M: function(dateObj, shortMonth, locale) {
        dateObj.setMonth(locale.months.shorthand.indexOf(shortMonth));
      },
      S: function(dateObj, seconds) {
        dateObj.setSeconds(parseFloat(seconds));
      },
      U: function(_, unixSeconds) {
        return new Date(parseFloat(unixSeconds) * 1e3);
      },
      W: function(dateObj, weekNum, locale) {
        var weekNumber = parseInt(weekNum);
        var date = new Date(dateObj.getFullYear(), 0, 2 + (weekNumber - 1) * 7, 0, 0, 0, 0);
        date.setDate(date.getDate() - date.getDay() + locale.firstDayOfWeek);
        return date;
      },
      Y: function(dateObj, year) {
        dateObj.setFullYear(parseFloat(year));
      },
      Z: function(_, ISODate) {
        return new Date(ISODate);
      },
      d: function(dateObj, day) {
        dateObj.setDate(parseFloat(day));
      },
      h: function(dateObj, hour) {
        dateObj.setHours((dateObj.getHours() >= 12 ? 12 : 0) + parseFloat(hour));
      },
      i: function(dateObj, minutes) {
        dateObj.setMinutes(parseFloat(minutes));
      },
      j: function(dateObj, day) {
        dateObj.setDate(parseFloat(day));
      },
      l: doNothing,
      m: function(dateObj, month) {
        dateObj.setMonth(parseFloat(month) - 1);
      },
      n: function(dateObj, month) {
        dateObj.setMonth(parseFloat(month) - 1);
      },
      s: function(dateObj, seconds) {
        dateObj.setSeconds(parseFloat(seconds));
      },
      u: function(_, unixMillSeconds) {
        return new Date(parseFloat(unixMillSeconds));
      },
      w: doNothing,
      y: function(dateObj, year) {
        dateObj.setFullYear(2e3 + parseFloat(year));
      }
    };
    var tokenRegex = {
      D: "",
      F: "",
      G: "(\\d\\d|\\d)",
      H: "(\\d\\d|\\d)",
      J: "(\\d\\d|\\d)\\w+",
      K: "",
      M: "",
      S: "(\\d\\d|\\d)",
      U: "(.+)",
      W: "(\\d\\d|\\d)",
      Y: "(\\d{4})",
      Z: "(.+)",
      d: "(\\d\\d|\\d)",
      h: "(\\d\\d|\\d)",
      i: "(\\d\\d|\\d)",
      j: "(\\d\\d|\\d)",
      l: "",
      m: "(\\d\\d|\\d)",
      n: "(\\d\\d|\\d)",
      s: "(\\d\\d|\\d)",
      u: "(.+)",
      w: "(\\d\\d|\\d)",
      y: "(\\d{2})"
    };
    var formats = {
      Z: function(date) {
        return date.toISOString();
      },
      D: function(date, locale, options) {
        return locale.weekdays.shorthand[formats.w(date, locale, options)];
      },
      F: function(date, locale, options) {
        return monthToStr(formats.n(date, locale, options) - 1, false, locale);
      },
      G: function(date, locale, options) {
        return pad(formats.h(date, locale, options));
      },
      H: function(date) {
        return pad(date.getHours());
      },
      J: function(date, locale) {
        return locale.ordinal !== void 0 ? date.getDate() + locale.ordinal(date.getDate()) : date.getDate();
      },
      K: function(date, locale) {
        return locale.amPM[int(date.getHours() > 11)];
      },
      M: function(date, locale) {
        return monthToStr(date.getMonth(), true, locale);
      },
      S: function(date) {
        return pad(date.getSeconds());
      },
      U: function(date) {
        return date.getTime() / 1e3;
      },
      W: function(date, _, options) {
        return options.getWeek(date);
      },
      Y: function(date) {
        return pad(date.getFullYear(), 4);
      },
      d: function(date) {
        return pad(date.getDate());
      },
      h: function(date) {
        return date.getHours() % 12 ? date.getHours() % 12 : 12;
      },
      i: function(date) {
        return pad(date.getMinutes());
      },
      j: function(date) {
        return date.getDate();
      },
      l: function(date, locale) {
        return locale.weekdays.longhand[date.getDay()];
      },
      m: function(date) {
        return pad(date.getMonth() + 1);
      },
      n: function(date) {
        return date.getMonth() + 1;
      },
      s: function(date) {
        return date.getSeconds();
      },
      u: function(date) {
        return date.getTime();
      },
      w: function(date) {
        return date.getDay();
      },
      y: function(date) {
        return String(date.getFullYear()).substring(2);
      }
    };
    var createDateFormatter = function(_a) {
      var _b = _a.config, config = _b === void 0 ? defaults : _b, _c = _a.l10n, l10n = _c === void 0 ? english : _c, _d = _a.isMobile, isMobile = _d === void 0 ? false : _d;
      return function(dateObj, frmt, overrideLocale) {
        var locale = overrideLocale || l10n;
        if (config.formatDate !== void 0 && !isMobile) {
          return config.formatDate(dateObj, frmt, locale);
        }
        return frmt.split("").map(function(c, i2, arr) {
          return formats[c] && arr[i2 - 1] !== "\\" ? formats[c](dateObj, locale, config) : c !== "\\" ? c : "";
        }).join("");
      };
    };
    var createDateParser = function(_a) {
      var _b = _a.config, config = _b === void 0 ? defaults : _b, _c = _a.l10n, l10n = _c === void 0 ? english : _c;
      return function(date, givenFormat, timeless, customLocale) {
        if (date !== 0 && !date)
          return void 0;
        var locale = customLocale || l10n;
        var parsedDate;
        var dateOrig = date;
        if (date instanceof Date)
          parsedDate = new Date(date.getTime());
        else if (typeof date !== "string" && date.toFixed !== void 0)
          parsedDate = new Date(date);
        else if (typeof date === "string") {
          var format = givenFormat || (config || defaults).dateFormat;
          var datestr = String(date).trim();
          if (datestr === "today") {
            parsedDate = /* @__PURE__ */ new Date();
            timeless = true;
          } else if (config && config.parseDate) {
            parsedDate = config.parseDate(date, format);
          } else if (/Z$/.test(datestr) || /GMT$/.test(datestr)) {
            parsedDate = new Date(date);
          } else {
            var matched = void 0, ops = [];
            for (var i2 = 0, matchIndex = 0, regexStr = ""; i2 < format.length; i2++) {
              var token = format[i2];
              var isBackSlash = token === "\\";
              var escaped = format[i2 - 1] === "\\" || isBackSlash;
              if (tokenRegex[token] && !escaped) {
                regexStr += tokenRegex[token];
                var match = new RegExp(regexStr).exec(date);
                if (match && (matched = true)) {
                  ops[token !== "Y" ? "push" : "unshift"]({
                    fn: revFormat[token],
                    val: match[++matchIndex]
                  });
                }
              } else if (!isBackSlash)
                regexStr += ".";
            }
            parsedDate = !config || !config.noCalendar ? new Date((/* @__PURE__ */ new Date()).getFullYear(), 0, 1, 0, 0, 0, 0) : new Date((/* @__PURE__ */ new Date()).setHours(0, 0, 0, 0));
            ops.forEach(function(_a2) {
              var fn = _a2.fn, val = _a2.val;
              return parsedDate = fn(parsedDate, val, locale) || parsedDate;
            });
            parsedDate = matched ? parsedDate : void 0;
          }
        }
        if (!(parsedDate instanceof Date && !isNaN(parsedDate.getTime()))) {
          config.errorHandler(new Error("Invalid date provided: " + dateOrig));
          return void 0;
        }
        if (timeless === true)
          parsedDate.setHours(0, 0, 0, 0);
        return parsedDate;
      };
    };
    function compareDates(date1, date2, timeless) {
      if (timeless === void 0) {
        timeless = true;
      }
      if (timeless !== false) {
        return new Date(date1.getTime()).setHours(0, 0, 0, 0) - new Date(date2.getTime()).setHours(0, 0, 0, 0);
      }
      return date1.getTime() - date2.getTime();
    }
    var isBetween = function(ts, ts1, ts2) {
      return ts > Math.min(ts1, ts2) && ts < Math.max(ts1, ts2);
    };
    var calculateSecondsSinceMidnight = function(hours, minutes, seconds) {
      return hours * 3600 + minutes * 60 + seconds;
    };
    var parseSeconds = function(secondsSinceMidnight) {
      var hours = Math.floor(secondsSinceMidnight / 3600), minutes = (secondsSinceMidnight - hours * 3600) / 60;
      return [hours, minutes, secondsSinceMidnight - hours * 3600 - minutes * 60];
    };
    var duration = {
      DAY: 864e5
    };
    function getDefaultHours(config) {
      var hours = config.defaultHour;
      var minutes = config.defaultMinute;
      var seconds = config.defaultSeconds;
      if (config.minDate !== void 0) {
        var minHour = config.minDate.getHours();
        var minMinutes = config.minDate.getMinutes();
        var minSeconds = config.minDate.getSeconds();
        if (hours < minHour) {
          hours = minHour;
        }
        if (hours === minHour && minutes < minMinutes) {
          minutes = minMinutes;
        }
        if (hours === minHour && minutes === minMinutes && seconds < minSeconds)
          seconds = config.minDate.getSeconds();
      }
      if (config.maxDate !== void 0) {
        var maxHr = config.maxDate.getHours();
        var maxMinutes = config.maxDate.getMinutes();
        hours = Math.min(hours, maxHr);
        if (hours === maxHr)
          minutes = Math.min(maxMinutes, minutes);
        if (hours === maxHr && minutes === maxMinutes)
          seconds = config.maxDate.getSeconds();
      }
      return { hours, minutes, seconds };
    }
    if (typeof Object.assign !== "function") {
      Object.assign = function(target) {
        var args = [];
        for (var _i = 1; _i < arguments.length; _i++) {
          args[_i - 1] = arguments[_i];
        }
        if (!target) {
          throw TypeError("Cannot convert undefined or null to object");
        }
        var _loop_1 = function(source2) {
          if (source2) {
            Object.keys(source2).forEach(function(key2) {
              return target[key2] = source2[key2];
            });
          }
        };
        for (var _a = 0, args_1 = args; _a < args_1.length; _a++) {
          var source = args_1[_a];
          _loop_1(source);
        }
        return target;
      };
    }
    var __assign = function() {
      __assign = Object.assign || function(t) {
        for (var s, i2 = 1, n = arguments.length; i2 < n; i2++) {
          s = arguments[i2];
          for (var p in s) if (Object.prototype.hasOwnProperty.call(s, p))
            t[p] = s[p];
        }
        return t;
      };
      return __assign.apply(this, arguments);
    };
    var __spreadArrays = function() {
      for (var s = 0, i2 = 0, il = arguments.length; i2 < il; i2++) s += arguments[i2].length;
      for (var r = Array(s), k = 0, i2 = 0; i2 < il; i2++)
        for (var a = arguments[i2], j = 0, jl = a.length; j < jl; j++, k++)
          r[k] = a[j];
      return r;
    };
    var DEBOUNCED_CHANGE_MS = 300;
    function FlatpickrInstance(element, instanceConfig) {
      var self = {
        config: __assign(__assign({}, defaults), flatpickr.defaultConfig),
        l10n: english
      };
      self.parseDate = createDateParser({ config: self.config, l10n: self.l10n });
      self._handlers = [];
      self.pluginElements = [];
      self.loadedPlugins = [];
      self._bind = bind;
      self._setHoursFromDate = setHoursFromDate;
      self._positionCalendar = positionCalendar;
      self.changeMonth = changeMonth;
      self.changeYear = changeYear;
      self.clear = clear;
      self.close = close;
      self.onMouseOver = onMouseOver;
      self._createElement = createElement;
      self.createDay = createDay;
      self.destroy = destroy;
      self.isEnabled = isEnabled;
      self.jumpToDate = jumpToDate;
      self.updateValue = updateValue;
      self.open = open;
      self.redraw = redraw;
      self.set = set;
      self.setDate = setDate;
      self.toggle = toggle;
      function setupHelperFunctions() {
        self.utils = {
          getDaysInMonth: function(month, yr) {
            if (month === void 0) {
              month = self.currentMonth;
            }
            if (yr === void 0) {
              yr = self.currentYear;
            }
            if (month === 1 && (yr % 4 === 0 && yr % 100 !== 0 || yr % 400 === 0))
              return 29;
            return self.l10n.daysInMonth[month];
          }
        };
      }
      function init() {
        self.element = self.input = element;
        self.isOpen = false;
        parseConfig();
        setupLocale();
        setupInputs();
        setupDates();
        setupHelperFunctions();
        if (!self.isMobile)
          build();
        bindEvents();
        if (self.selectedDates.length || self.config.noCalendar) {
          if (self.config.enableTime) {
            setHoursFromDate(self.config.noCalendar ? self.latestSelectedDateObj : void 0);
          }
          updateValue(false);
        }
        setCalendarWidth();
        var isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
        if (!self.isMobile && isSafari) {
          positionCalendar();
        }
        triggerEvent("onReady");
      }
      function getClosestActiveElement() {
        var _a;
        return ((_a = self.calendarContainer) === null || _a === void 0 ? void 0 : _a.getRootNode()).activeElement || document.activeElement;
      }
      function bindToInstance(fn) {
        return fn.bind(self);
      }
      function setCalendarWidth() {
        var config = self.config;
        if (config.weekNumbers === false && config.showMonths === 1) {
          return;
        } else if (config.noCalendar !== true) {
          window.requestAnimationFrame(function() {
            if (self.calendarContainer !== void 0) {
              self.calendarContainer.style.visibility = "hidden";
              self.calendarContainer.style.display = "block";
            }
            if (self.daysContainer !== void 0) {
              var daysWidth = (self.days.offsetWidth + 1) * config.showMonths;
              self.daysContainer.style.width = daysWidth + "px";
              self.calendarContainer.style.width = daysWidth + (self.weekWrapper !== void 0 ? self.weekWrapper.offsetWidth : 0) + "px";
              self.calendarContainer.style.removeProperty("visibility");
              self.calendarContainer.style.removeProperty("display");
            }
          });
        }
      }
      function updateTime(e) {
        if (self.selectedDates.length === 0) {
          var defaultDate = self.config.minDate === void 0 || compareDates(/* @__PURE__ */ new Date(), self.config.minDate) >= 0 ? /* @__PURE__ */ new Date() : new Date(self.config.minDate.getTime());
          var defaults2 = getDefaultHours(self.config);
          defaultDate.setHours(defaults2.hours, defaults2.minutes, defaults2.seconds, defaultDate.getMilliseconds());
          self.selectedDates = [defaultDate];
          self.latestSelectedDateObj = defaultDate;
        }
        if (e !== void 0 && e.type !== "blur") {
          timeWrapper(e);
        }
        var prevValue = self._input.value;
        setHoursFromInputs();
        updateValue();
        if (self._input.value !== prevValue) {
          self._debouncedChange();
        }
      }
      function ampm2military(hour, amPM) {
        return hour % 12 + 12 * int(amPM === self.l10n.amPM[1]);
      }
      function military2ampm(hour) {
        switch (hour % 24) {
          case 0:
          case 12:
            return 12;
          default:
            return hour % 12;
        }
      }
      function setHoursFromInputs() {
        if (self.hourElement === void 0 || self.minuteElement === void 0)
          return;
        var hours = (parseInt(self.hourElement.value.slice(-2), 10) || 0) % 24, minutes = (parseInt(self.minuteElement.value, 10) || 0) % 60, seconds = self.secondElement !== void 0 ? (parseInt(self.secondElement.value, 10) || 0) % 60 : 0;
        if (self.amPM !== void 0) {
          hours = ampm2military(hours, self.amPM.textContent);
        }
        var limitMinHours = self.config.minTime !== void 0 || self.config.minDate && self.minDateHasTime && self.latestSelectedDateObj && compareDates(self.latestSelectedDateObj, self.config.minDate, true) === 0;
        var limitMaxHours = self.config.maxTime !== void 0 || self.config.maxDate && self.maxDateHasTime && self.latestSelectedDateObj && compareDates(self.latestSelectedDateObj, self.config.maxDate, true) === 0;
        if (self.config.maxTime !== void 0 && self.config.minTime !== void 0 && self.config.minTime > self.config.maxTime) {
          var minBound = calculateSecondsSinceMidnight(self.config.minTime.getHours(), self.config.minTime.getMinutes(), self.config.minTime.getSeconds());
          var maxBound = calculateSecondsSinceMidnight(self.config.maxTime.getHours(), self.config.maxTime.getMinutes(), self.config.maxTime.getSeconds());
          var currentTime = calculateSecondsSinceMidnight(hours, minutes, seconds);
          if (currentTime > maxBound && currentTime < minBound) {
            var result = parseSeconds(minBound);
            hours = result[0];
            minutes = result[1];
            seconds = result[2];
          }
        } else {
          if (limitMaxHours) {
            var maxTime = self.config.maxTime !== void 0 ? self.config.maxTime : self.config.maxDate;
            hours = Math.min(hours, maxTime.getHours());
            if (hours === maxTime.getHours())
              minutes = Math.min(minutes, maxTime.getMinutes());
            if (minutes === maxTime.getMinutes())
              seconds = Math.min(seconds, maxTime.getSeconds());
          }
          if (limitMinHours) {
            var minTime = self.config.minTime !== void 0 ? self.config.minTime : self.config.minDate;
            hours = Math.max(hours, minTime.getHours());
            if (hours === minTime.getHours() && minutes < minTime.getMinutes())
              minutes = minTime.getMinutes();
            if (minutes === minTime.getMinutes())
              seconds = Math.max(seconds, minTime.getSeconds());
          }
        }
        setHours(hours, minutes, seconds);
      }
      function setHoursFromDate(dateObj) {
        var date = dateObj || self.latestSelectedDateObj;
        if (date && date instanceof Date) {
          setHours(date.getHours(), date.getMinutes(), date.getSeconds());
        }
      }
      function setHours(hours, minutes, seconds) {
        if (self.latestSelectedDateObj !== void 0) {
          self.latestSelectedDateObj.setHours(hours % 24, minutes, seconds || 0, 0);
        }
        if (!self.hourElement || !self.minuteElement || self.isMobile)
          return;
        self.hourElement.value = pad(!self.config.time_24hr ? (12 + hours) % 12 + 12 * int(hours % 12 === 0) : hours);
        self.minuteElement.value = pad(minutes);
        if (self.amPM !== void 0)
          self.amPM.textContent = self.l10n.amPM[int(hours >= 12)];
        if (self.secondElement !== void 0)
          self.secondElement.value = pad(seconds);
      }
      function onYearInput(event) {
        var eventTarget = getEventTarget(event);
        var year = parseInt(eventTarget.value) + (event.delta || 0);
        if (year / 1e3 > 1 || event.key === "Enter" && !/[^\d]/.test(year.toString())) {
          changeYear(year);
        }
      }
      function bind(element2, event, handler, options) {
        if (event instanceof Array)
          return event.forEach(function(ev) {
            return bind(element2, ev, handler, options);
          });
        if (element2 instanceof Array)
          return element2.forEach(function(el) {
            return bind(el, event, handler, options);
          });
        element2.addEventListener(event, handler, options);
        self._handlers.push({
          remove: function() {
            return element2.removeEventListener(event, handler, options);
          }
        });
      }
      function triggerChange() {
        triggerEvent("onChange");
      }
      function bindEvents() {
        if (self.config.wrap) {
          ["open", "close", "toggle", "clear"].forEach(function(evt) {
            Array.prototype.forEach.call(self.element.querySelectorAll("[data-" + evt + "]"), function(el) {
              return bind(el, "click", self[evt]);
            });
          });
        }
        if (self.isMobile) {
          setupMobile();
          return;
        }
        var debouncedResize = debounce(onResize, 50);
        self._debouncedChange = debounce(triggerChange, DEBOUNCED_CHANGE_MS);
        if (self.daysContainer && !/iPhone|iPad|iPod/i.test(navigator.userAgent))
          bind(self.daysContainer, "mouseover", function(e) {
            if (self.config.mode === "range")
              onMouseOver(getEventTarget(e));
          });
        bind(self._input, "keydown", onKeyDown);
        if (self.calendarContainer !== void 0) {
          bind(self.calendarContainer, "keydown", onKeyDown);
        }
        if (!self.config.inline && !self.config.static)
          bind(window, "resize", debouncedResize);
        if (window.ontouchstart !== void 0)
          bind(window.document, "touchstart", documentClick);
        else
          bind(window.document, "mousedown", documentClick);
        bind(window.document, "focus", documentClick, { capture: true });
        if (self.config.clickOpens === true) {
          bind(self._input, "focus", self.open);
          bind(self._input, "click", self.open);
        }
        if (self.daysContainer !== void 0) {
          bind(self.monthNav, "click", onMonthNavClick);
          bind(self.monthNav, ["keyup", "increment"], onYearInput);
          bind(self.daysContainer, "click", selectDate);
        }
        if (self.timeContainer !== void 0 && self.minuteElement !== void 0 && self.hourElement !== void 0) {
          var selText = function(e) {
            return getEventTarget(e).select();
          };
          bind(self.timeContainer, ["increment"], updateTime);
          bind(self.timeContainer, "blur", updateTime, { capture: true });
          bind(self.timeContainer, "click", timeIncrement);
          bind([self.hourElement, self.minuteElement], ["focus", "click"], selText);
          if (self.secondElement !== void 0)
            bind(self.secondElement, "focus", function() {
              return self.secondElement && self.secondElement.select();
            });
          if (self.amPM !== void 0) {
            bind(self.amPM, "click", function(e) {
              updateTime(e);
            });
          }
        }
        if (self.config.allowInput) {
          bind(self._input, "blur", onBlur);
        }
      }
      function jumpToDate(jumpDate, triggerChange2) {
        var jumpTo = jumpDate !== void 0 ? self.parseDate(jumpDate) : self.latestSelectedDateObj || (self.config.minDate && self.config.minDate > self.now ? self.config.minDate : self.config.maxDate && self.config.maxDate < self.now ? self.config.maxDate : self.now);
        var oldYear = self.currentYear;
        var oldMonth = self.currentMonth;
        try {
          if (jumpTo !== void 0) {
            self.currentYear = jumpTo.getFullYear();
            self.currentMonth = jumpTo.getMonth();
          }
        } catch (e) {
          e.message = "Invalid date supplied: " + jumpTo;
          self.config.errorHandler(e);
        }
        if (triggerChange2 && self.currentYear !== oldYear) {
          triggerEvent("onYearChange");
          buildMonthSwitch();
        }
        if (triggerChange2 && (self.currentYear !== oldYear || self.currentMonth !== oldMonth)) {
          triggerEvent("onMonthChange");
        }
        self.redraw();
      }
      function timeIncrement(e) {
        var eventTarget = getEventTarget(e);
        if (~eventTarget.className.indexOf("arrow"))
          incrementNumInput(e, eventTarget.classList.contains("arrowUp") ? 1 : -1);
      }
      function incrementNumInput(e, delta, inputElem) {
        var target = e && getEventTarget(e);
        var input = inputElem || target && target.parentNode && target.parentNode.firstChild;
        var event = createEvent("increment");
        event.delta = delta;
        input && input.dispatchEvent(event);
      }
      function build() {
        var fragment = window.document.createDocumentFragment();
        self.calendarContainer = createElement("div", "flatpickr-calendar");
        self.calendarContainer.tabIndex = -1;
        if (!self.config.noCalendar) {
          fragment.appendChild(buildMonthNav());
          self.innerContainer = createElement("div", "flatpickr-innerContainer");
          if (self.config.weekNumbers) {
            var _a = buildWeeks(), weekWrapper = _a.weekWrapper, weekNumbers = _a.weekNumbers;
            self.innerContainer.appendChild(weekWrapper);
            self.weekNumbers = weekNumbers;
            self.weekWrapper = weekWrapper;
          }
          self.rContainer = createElement("div", "flatpickr-rContainer");
          self.rContainer.appendChild(buildWeekdays());
          if (!self.daysContainer) {
            self.daysContainer = createElement("div", "flatpickr-days");
            self.daysContainer.tabIndex = -1;
          }
          buildDays();
          self.rContainer.appendChild(self.daysContainer);
          self.innerContainer.appendChild(self.rContainer);
          fragment.appendChild(self.innerContainer);
        }
        if (self.config.enableTime) {
          fragment.appendChild(buildTime());
        }
        toggleClass(self.calendarContainer, "rangeMode", self.config.mode === "range");
        toggleClass(self.calendarContainer, "animate", self.config.animate === true);
        toggleClass(self.calendarContainer, "multiMonth", self.config.showMonths > 1);
        self.calendarContainer.appendChild(fragment);
        var customAppend = self.config.appendTo !== void 0 && self.config.appendTo.nodeType !== void 0;
        if (self.config.inline || self.config.static) {
          self.calendarContainer.classList.add(self.config.inline ? "inline" : "static");
          if (self.config.inline) {
            if (!customAppend && self.element.parentNode)
              self.element.parentNode.insertBefore(self.calendarContainer, self._input.nextSibling);
            else if (self.config.appendTo !== void 0)
              self.config.appendTo.appendChild(self.calendarContainer);
          }
          if (self.config.static) {
            var wrapper = createElement("div", "flatpickr-wrapper");
            if (self.element.parentNode)
              self.element.parentNode.insertBefore(wrapper, self.element);
            wrapper.appendChild(self.element);
            if (self.altInput)
              wrapper.appendChild(self.altInput);
            wrapper.appendChild(self.calendarContainer);
          }
        }
        if (!self.config.static && !self.config.inline)
          (self.config.appendTo !== void 0 ? self.config.appendTo : window.document.body).appendChild(self.calendarContainer);
      }
      function createDay(className, date, _dayNumber, i2) {
        var dateIsEnabled = isEnabled(date, true), dayElement = createElement("span", className, date.getDate().toString());
        dayElement.dateObj = date;
        dayElement.$i = i2;
        dayElement.setAttribute("aria-label", self.formatDate(date, self.config.ariaDateFormat));
        if (className.indexOf("hidden") === -1 && compareDates(date, self.now) === 0) {
          self.todayDateElem = dayElement;
          dayElement.classList.add("today");
          dayElement.setAttribute("aria-current", "date");
        }
        if (dateIsEnabled) {
          dayElement.tabIndex = -1;
          if (isDateSelected(date)) {
            dayElement.classList.add("selected");
            self.selectedDateElem = dayElement;
            if (self.config.mode === "range") {
              toggleClass(dayElement, "startRange", self.selectedDates[0] && compareDates(date, self.selectedDates[0], true) === 0);
              toggleClass(dayElement, "endRange", self.selectedDates[1] && compareDates(date, self.selectedDates[1], true) === 0);
              if (className === "nextMonthDay")
                dayElement.classList.add("inRange");
            }
          }
        } else {
          dayElement.classList.add("flatpickr-disabled");
        }
        if (self.config.mode === "range") {
          if (isDateInRange(date) && !isDateSelected(date))
            dayElement.classList.add("inRange");
        }
        if (self.weekNumbers && self.config.showMonths === 1 && className !== "prevMonthDay" && i2 % 7 === 6) {
          self.weekNumbers.insertAdjacentHTML("beforeend", "<span class='flatpickr-day'>" + self.config.getWeek(date) + "</span>");
        }
        triggerEvent("onDayCreate", dayElement);
        return dayElement;
      }
      function focusOnDayElem(targetNode) {
        targetNode.focus();
        if (self.config.mode === "range")
          onMouseOver(targetNode);
      }
      function getFirstAvailableDay(delta) {
        var startMonth = delta > 0 ? 0 : self.config.showMonths - 1;
        var endMonth = delta > 0 ? self.config.showMonths : -1;
        for (var m = startMonth; m != endMonth; m += delta) {
          var month = self.daysContainer.children[m];
          var startIndex = delta > 0 ? 0 : month.children.length - 1;
          var endIndex = delta > 0 ? month.children.length : -1;
          for (var i2 = startIndex; i2 != endIndex; i2 += delta) {
            var c = month.children[i2];
            if (c.className.indexOf("hidden") === -1 && isEnabled(c.dateObj))
              return c;
          }
        }
        return void 0;
      }
      function getNextAvailableDay(current, delta) {
        var givenMonth = current.className.indexOf("Month") === -1 ? current.dateObj.getMonth() : self.currentMonth;
        var endMonth = delta > 0 ? self.config.showMonths : -1;
        var loopDelta = delta > 0 ? 1 : -1;
        for (var m = givenMonth - self.currentMonth; m != endMonth; m += loopDelta) {
          var month = self.daysContainer.children[m];
          var startIndex = givenMonth - self.currentMonth === m ? current.$i + delta : delta < 0 ? month.children.length - 1 : 0;
          var numMonthDays = month.children.length;
          for (var i2 = startIndex; i2 >= 0 && i2 < numMonthDays && i2 != (delta > 0 ? numMonthDays : -1); i2 += loopDelta) {
            var c = month.children[i2];
            if (c.className.indexOf("hidden") === -1 && isEnabled(c.dateObj) && Math.abs(current.$i - i2) >= Math.abs(delta))
              return focusOnDayElem(c);
          }
        }
        self.changeMonth(loopDelta);
        focusOnDay(getFirstAvailableDay(loopDelta), 0);
        return void 0;
      }
      function focusOnDay(current, offset) {
        var activeElement = getClosestActiveElement();
        var dayFocused = isInView(activeElement || document.body);
        var startElem = current !== void 0 ? current : dayFocused ? activeElement : self.selectedDateElem !== void 0 && isInView(self.selectedDateElem) ? self.selectedDateElem : self.todayDateElem !== void 0 && isInView(self.todayDateElem) ? self.todayDateElem : getFirstAvailableDay(offset > 0 ? 1 : -1);
        if (startElem === void 0) {
          self._input.focus();
        } else if (!dayFocused) {
          focusOnDayElem(startElem);
        } else {
          getNextAvailableDay(startElem, offset);
        }
      }
      function buildMonthDays(year, month) {
        var firstOfMonth = (new Date(year, month, 1).getDay() - self.l10n.firstDayOfWeek + 7) % 7;
        var prevMonthDays = self.utils.getDaysInMonth((month - 1 + 12) % 12, year);
        var daysInMonth = self.utils.getDaysInMonth(month, year), days = window.document.createDocumentFragment(), isMultiMonth = self.config.showMonths > 1, prevMonthDayClass = isMultiMonth ? "prevMonthDay hidden" : "prevMonthDay", nextMonthDayClass = isMultiMonth ? "nextMonthDay hidden" : "nextMonthDay";
        var dayNumber = prevMonthDays + 1 - firstOfMonth, dayIndex = 0;
        for (; dayNumber <= prevMonthDays; dayNumber++, dayIndex++) {
          days.appendChild(createDay("flatpickr-day " + prevMonthDayClass, new Date(year, month - 1, dayNumber), dayNumber, dayIndex));
        }
        for (dayNumber = 1; dayNumber <= daysInMonth; dayNumber++, dayIndex++) {
          days.appendChild(createDay("flatpickr-day", new Date(year, month, dayNumber), dayNumber, dayIndex));
        }
        for (var dayNum = daysInMonth + 1; dayNum <= 42 - firstOfMonth && (self.config.showMonths === 1 || dayIndex % 7 !== 0); dayNum++, dayIndex++) {
          days.appendChild(createDay("flatpickr-day " + nextMonthDayClass, new Date(year, month + 1, dayNum % daysInMonth), dayNum, dayIndex));
        }
        var dayContainer = createElement("div", "dayContainer");
        dayContainer.appendChild(days);
        return dayContainer;
      }
      function buildDays() {
        if (self.daysContainer === void 0) {
          return;
        }
        clearNode(self.daysContainer);
        if (self.weekNumbers)
          clearNode(self.weekNumbers);
        var frag = document.createDocumentFragment();
        for (var i2 = 0; i2 < self.config.showMonths; i2++) {
          var d = new Date(self.currentYear, self.currentMonth, 1);
          d.setMonth(self.currentMonth + i2);
          frag.appendChild(buildMonthDays(d.getFullYear(), d.getMonth()));
        }
        self.daysContainer.appendChild(frag);
        self.days = self.daysContainer.firstChild;
        if (self.config.mode === "range" && self.selectedDates.length === 1) {
          onMouseOver();
        }
      }
      function buildMonthSwitch() {
        if (self.config.showMonths > 1 || self.config.monthSelectorType !== "dropdown")
          return;
        var shouldBuildMonth = function(month2) {
          if (self.config.minDate !== void 0 && self.currentYear === self.config.minDate.getFullYear() && month2 < self.config.minDate.getMonth()) {
            return false;
          }
          return !(self.config.maxDate !== void 0 && self.currentYear === self.config.maxDate.getFullYear() && month2 > self.config.maxDate.getMonth());
        };
        self.monthsDropdownContainer.tabIndex = -1;
        self.monthsDropdownContainer.innerHTML = "";
        for (var i2 = 0; i2 < 12; i2++) {
          if (!shouldBuildMonth(i2))
            continue;
          var month = createElement("option", "flatpickr-monthDropdown-month");
          month.value = new Date(self.currentYear, i2).getMonth().toString();
          month.textContent = monthToStr(i2, self.config.shorthandCurrentMonth, self.l10n);
          month.tabIndex = -1;
          if (self.currentMonth === i2) {
            month.selected = true;
          }
          self.monthsDropdownContainer.appendChild(month);
        }
      }
      function buildMonth() {
        var container = createElement("div", "flatpickr-month");
        var monthNavFragment = window.document.createDocumentFragment();
        var monthElement;
        if (self.config.showMonths > 1 || self.config.monthSelectorType === "static") {
          monthElement = createElement("span", "cur-month");
        } else {
          self.monthsDropdownContainer = createElement("select", "flatpickr-monthDropdown-months");
          self.monthsDropdownContainer.setAttribute("aria-label", self.l10n.monthAriaLabel);
          bind(self.monthsDropdownContainer, "change", function(e) {
            var target = getEventTarget(e);
            var selectedMonth = parseInt(target.value, 10);
            self.changeMonth(selectedMonth - self.currentMonth);
            triggerEvent("onMonthChange");
          });
          buildMonthSwitch();
          monthElement = self.monthsDropdownContainer;
        }
        var yearInput = createNumberInput("cur-year", { tabindex: "-1" });
        var yearElement = yearInput.getElementsByTagName("input")[0];
        yearElement.setAttribute("aria-label", self.l10n.yearAriaLabel);
        if (self.config.minDate) {
          yearElement.setAttribute("min", self.config.minDate.getFullYear().toString());
        }
        if (self.config.maxDate) {
          yearElement.setAttribute("max", self.config.maxDate.getFullYear().toString());
          yearElement.disabled = !!self.config.minDate && self.config.minDate.getFullYear() === self.config.maxDate.getFullYear();
        }
        var currentMonth = createElement("div", "flatpickr-current-month");
        currentMonth.appendChild(monthElement);
        currentMonth.appendChild(yearInput);
        monthNavFragment.appendChild(currentMonth);
        container.appendChild(monthNavFragment);
        return {
          container,
          yearElement,
          monthElement
        };
      }
      function buildMonths() {
        clearNode(self.monthNav);
        self.monthNav.appendChild(self.prevMonthNav);
        if (self.config.showMonths) {
          self.yearElements = [];
          self.monthElements = [];
        }
        for (var m = self.config.showMonths; m--; ) {
          var month = buildMonth();
          self.yearElements.push(month.yearElement);
          self.monthElements.push(month.monthElement);
          self.monthNav.appendChild(month.container);
        }
        self.monthNav.appendChild(self.nextMonthNav);
      }
      function buildMonthNav() {
        self.monthNav = createElement("div", "flatpickr-months");
        self.yearElements = [];
        self.monthElements = [];
        self.prevMonthNav = createElement("span", "flatpickr-prev-month");
        self.prevMonthNav.innerHTML = self.config.prevArrow;
        self.nextMonthNav = createElement("span", "flatpickr-next-month");
        self.nextMonthNav.innerHTML = self.config.nextArrow;
        buildMonths();
        Object.defineProperty(self, "_hidePrevMonthArrow", {
          get: function() {
            return self.__hidePrevMonthArrow;
          },
          set: function(bool) {
            if (self.__hidePrevMonthArrow !== bool) {
              toggleClass(self.prevMonthNav, "flatpickr-disabled", bool);
              self.__hidePrevMonthArrow = bool;
            }
          }
        });
        Object.defineProperty(self, "_hideNextMonthArrow", {
          get: function() {
            return self.__hideNextMonthArrow;
          },
          set: function(bool) {
            if (self.__hideNextMonthArrow !== bool) {
              toggleClass(self.nextMonthNav, "flatpickr-disabled", bool);
              self.__hideNextMonthArrow = bool;
            }
          }
        });
        self.currentYearElement = self.yearElements[0];
        updateNavigationCurrentMonth();
        return self.monthNav;
      }
      function buildTime() {
        self.calendarContainer.classList.add("hasTime");
        if (self.config.noCalendar)
          self.calendarContainer.classList.add("noCalendar");
        var defaults2 = getDefaultHours(self.config);
        self.timeContainer = createElement("div", "flatpickr-time");
        self.timeContainer.tabIndex = -1;
        var separator = createElement("span", "flatpickr-time-separator", ":");
        var hourInput = createNumberInput("flatpickr-hour", {
          "aria-label": self.l10n.hourAriaLabel
        });
        self.hourElement = hourInput.getElementsByTagName("input")[0];
        var minuteInput = createNumberInput("flatpickr-minute", {
          "aria-label": self.l10n.minuteAriaLabel
        });
        self.minuteElement = minuteInput.getElementsByTagName("input")[0];
        self.hourElement.tabIndex = self.minuteElement.tabIndex = -1;
        self.hourElement.value = pad(self.latestSelectedDateObj ? self.latestSelectedDateObj.getHours() : self.config.time_24hr ? defaults2.hours : military2ampm(defaults2.hours));
        self.minuteElement.value = pad(self.latestSelectedDateObj ? self.latestSelectedDateObj.getMinutes() : defaults2.minutes);
        self.hourElement.setAttribute("step", self.config.hourIncrement.toString());
        self.minuteElement.setAttribute("step", self.config.minuteIncrement.toString());
        self.hourElement.setAttribute("min", self.config.time_24hr ? "0" : "1");
        self.hourElement.setAttribute("max", self.config.time_24hr ? "23" : "12");
        self.hourElement.setAttribute("maxlength", "2");
        self.minuteElement.setAttribute("min", "0");
        self.minuteElement.setAttribute("max", "59");
        self.minuteElement.setAttribute("maxlength", "2");
        self.timeContainer.appendChild(hourInput);
        self.timeContainer.appendChild(separator);
        self.timeContainer.appendChild(minuteInput);
        if (self.config.time_24hr)
          self.timeContainer.classList.add("time24hr");
        if (self.config.enableSeconds) {
          self.timeContainer.classList.add("hasSeconds");
          var secondInput = createNumberInput("flatpickr-second");
          self.secondElement = secondInput.getElementsByTagName("input")[0];
          self.secondElement.value = pad(self.latestSelectedDateObj ? self.latestSelectedDateObj.getSeconds() : defaults2.seconds);
          self.secondElement.setAttribute("step", self.minuteElement.getAttribute("step"));
          self.secondElement.setAttribute("min", "0");
          self.secondElement.setAttribute("max", "59");
          self.secondElement.setAttribute("maxlength", "2");
          self.timeContainer.appendChild(createElement("span", "flatpickr-time-separator", ":"));
          self.timeContainer.appendChild(secondInput);
        }
        if (!self.config.time_24hr) {
          self.amPM = createElement("span", "flatpickr-am-pm", self.l10n.amPM[int((self.latestSelectedDateObj ? self.hourElement.value : self.config.defaultHour) > 11)]);
          self.amPM.title = self.l10n.toggleTitle;
          self.amPM.tabIndex = -1;
          self.timeContainer.appendChild(self.amPM);
        }
        return self.timeContainer;
      }
      function buildWeekdays() {
        if (!self.weekdayContainer)
          self.weekdayContainer = createElement("div", "flatpickr-weekdays");
        else
          clearNode(self.weekdayContainer);
        for (var i2 = self.config.showMonths; i2--; ) {
          var container = createElement("div", "flatpickr-weekdaycontainer");
          self.weekdayContainer.appendChild(container);
        }
        updateWeekdays();
        return self.weekdayContainer;
      }
      function updateWeekdays() {
        if (!self.weekdayContainer) {
          return;
        }
        var firstDayOfWeek = self.l10n.firstDayOfWeek;
        var weekdays = __spreadArrays(self.l10n.weekdays.shorthand);
        if (firstDayOfWeek > 0 && firstDayOfWeek < weekdays.length) {
          weekdays = __spreadArrays(weekdays.splice(firstDayOfWeek, weekdays.length), weekdays.splice(0, firstDayOfWeek));
        }
        for (var i2 = self.config.showMonths; i2--; ) {
          self.weekdayContainer.children[i2].innerHTML = "\n      <span class='flatpickr-weekday'>\n        " + weekdays.join("</span><span class='flatpickr-weekday'>") + "\n      </span>\n      ";
        }
      }
      function buildWeeks() {
        self.calendarContainer.classList.add("hasWeeks");
        var weekWrapper = createElement("div", "flatpickr-weekwrapper");
        weekWrapper.appendChild(createElement("span", "flatpickr-weekday", self.l10n.weekAbbreviation));
        var weekNumbers = createElement("div", "flatpickr-weeks");
        weekWrapper.appendChild(weekNumbers);
        return {
          weekWrapper,
          weekNumbers
        };
      }
      function changeMonth(value, isOffset) {
        if (isOffset === void 0) {
          isOffset = true;
        }
        var delta = isOffset ? value : value - self.currentMonth;
        if (delta < 0 && self._hidePrevMonthArrow === true || delta > 0 && self._hideNextMonthArrow === true)
          return;
        self.currentMonth += delta;
        if (self.currentMonth < 0 || self.currentMonth > 11) {
          self.currentYear += self.currentMonth > 11 ? 1 : -1;
          self.currentMonth = (self.currentMonth + 12) % 12;
          triggerEvent("onYearChange");
          buildMonthSwitch();
        }
        buildDays();
        triggerEvent("onMonthChange");
        updateNavigationCurrentMonth();
      }
      function clear(triggerChangeEvent, toInitial) {
        if (triggerChangeEvent === void 0) {
          triggerChangeEvent = true;
        }
        if (toInitial === void 0) {
          toInitial = true;
        }
        self.input.value = "";
        if (self.altInput !== void 0)
          self.altInput.value = "";
        if (self.mobileInput !== void 0)
          self.mobileInput.value = "";
        self.selectedDates = [];
        self.latestSelectedDateObj = void 0;
        if (toInitial === true) {
          self.currentYear = self._initialDate.getFullYear();
          self.currentMonth = self._initialDate.getMonth();
        }
        if (self.config.enableTime === true) {
          var _a = getDefaultHours(self.config), hours = _a.hours, minutes = _a.minutes, seconds = _a.seconds;
          setHours(hours, minutes, seconds);
        }
        self.redraw();
        if (triggerChangeEvent)
          triggerEvent("onChange");
      }
      function close() {
        self.isOpen = false;
        if (!self.isMobile) {
          if (self.calendarContainer !== void 0) {
            self.calendarContainer.classList.remove("open");
          }
          if (self._input !== void 0) {
            self._input.classList.remove("active");
          }
        }
        triggerEvent("onClose");
      }
      function destroy() {
        if (self.config !== void 0)
          triggerEvent("onDestroy");
        for (var i2 = self._handlers.length; i2--; ) {
          self._handlers[i2].remove();
        }
        self._handlers = [];
        if (self.mobileInput) {
          if (self.mobileInput.parentNode)
            self.mobileInput.parentNode.removeChild(self.mobileInput);
          self.mobileInput = void 0;
        } else if (self.calendarContainer && self.calendarContainer.parentNode) {
          if (self.config.static && self.calendarContainer.parentNode) {
            var wrapper = self.calendarContainer.parentNode;
            wrapper.lastChild && wrapper.removeChild(wrapper.lastChild);
            if (wrapper.parentNode) {
              while (wrapper.firstChild)
                wrapper.parentNode.insertBefore(wrapper.firstChild, wrapper);
              wrapper.parentNode.removeChild(wrapper);
            }
          } else
            self.calendarContainer.parentNode.removeChild(self.calendarContainer);
        }
        if (self.altInput) {
          self.input.type = "text";
          if (self.altInput.parentNode)
            self.altInput.parentNode.removeChild(self.altInput);
          delete self.altInput;
        }
        if (self.input) {
          self.input.type = self.input._type;
          self.input.classList.remove("flatpickr-input");
          self.input.removeAttribute("readonly");
        }
        [
          "_showTimeInput",
          "latestSelectedDateObj",
          "_hideNextMonthArrow",
          "_hidePrevMonthArrow",
          "__hideNextMonthArrow",
          "__hidePrevMonthArrow",
          "isMobile",
          "isOpen",
          "selectedDateElem",
          "minDateHasTime",
          "maxDateHasTime",
          "days",
          "daysContainer",
          "_input",
          "_positionElement",
          "innerContainer",
          "rContainer",
          "monthNav",
          "todayDateElem",
          "calendarContainer",
          "weekdayContainer",
          "prevMonthNav",
          "nextMonthNav",
          "monthsDropdownContainer",
          "currentMonthElement",
          "currentYearElement",
          "navigationCurrentMonth",
          "selectedDateElem",
          "config"
        ].forEach(function(k) {
          try {
            delete self[k];
          } catch (_) {
          }
        });
      }
      function isCalendarElem(elem) {
        return self.calendarContainer.contains(elem);
      }
      function documentClick(e) {
        if (self.isOpen && !self.config.inline) {
          var eventTarget_1 = getEventTarget(e);
          var isCalendarElement = isCalendarElem(eventTarget_1);
          var isInput = eventTarget_1 === self.input || eventTarget_1 === self.altInput || self.element.contains(eventTarget_1) || e.path && e.path.indexOf && (~e.path.indexOf(self.input) || ~e.path.indexOf(self.altInput));
          var lostFocus = !isInput && !isCalendarElement && !isCalendarElem(e.relatedTarget);
          var isIgnored = !self.config.ignoredFocusElements.some(function(elem) {
            return elem.contains(eventTarget_1);
          });
          if (lostFocus && isIgnored) {
            if (self.config.allowInput) {
              self.setDate(self._input.value, false, self.config.altInput ? self.config.altFormat : self.config.dateFormat);
            }
            if (self.timeContainer !== void 0 && self.minuteElement !== void 0 && self.hourElement !== void 0 && self.input.value !== "" && self.input.value !== void 0) {
              updateTime();
            }
            self.close();
            if (self.config && self.config.mode === "range" && self.selectedDates.length === 1)
              self.clear(false);
          }
        }
      }
      function changeYear(newYear) {
        if (!newYear || self.config.minDate && newYear < self.config.minDate.getFullYear() || self.config.maxDate && newYear > self.config.maxDate.getFullYear())
          return;
        var newYearNum = newYear, isNewYear = self.currentYear !== newYearNum;
        self.currentYear = newYearNum || self.currentYear;
        if (self.config.maxDate && self.currentYear === self.config.maxDate.getFullYear()) {
          self.currentMonth = Math.min(self.config.maxDate.getMonth(), self.currentMonth);
        } else if (self.config.minDate && self.currentYear === self.config.minDate.getFullYear()) {
          self.currentMonth = Math.max(self.config.minDate.getMonth(), self.currentMonth);
        }
        if (isNewYear) {
          self.redraw();
          triggerEvent("onYearChange");
          buildMonthSwitch();
        }
      }
      function isEnabled(date, timeless) {
        var _a;
        if (timeless === void 0) {
          timeless = true;
        }
        var dateToCheck = self.parseDate(date, void 0, timeless);
        if (self.config.minDate && dateToCheck && compareDates(dateToCheck, self.config.minDate, timeless !== void 0 ? timeless : !self.minDateHasTime) < 0 || self.config.maxDate && dateToCheck && compareDates(dateToCheck, self.config.maxDate, timeless !== void 0 ? timeless : !self.maxDateHasTime) > 0)
          return false;
        if (!self.config.enable && self.config.disable.length === 0)
          return true;
        if (dateToCheck === void 0)
          return false;
        var bool = !!self.config.enable, array = (_a = self.config.enable) !== null && _a !== void 0 ? _a : self.config.disable;
        for (var i2 = 0, d = void 0; i2 < array.length; i2++) {
          d = array[i2];
          if (typeof d === "function" && d(dateToCheck))
            return bool;
          else if (d instanceof Date && dateToCheck !== void 0 && d.getTime() === dateToCheck.getTime())
            return bool;
          else if (typeof d === "string") {
            var parsed = self.parseDate(d, void 0, true);
            return parsed && parsed.getTime() === dateToCheck.getTime() ? bool : !bool;
          } else if (typeof d === "object" && dateToCheck !== void 0 && d.from && d.to && dateToCheck.getTime() >= d.from.getTime() && dateToCheck.getTime() <= d.to.getTime())
            return bool;
        }
        return !bool;
      }
      function isInView(elem) {
        if (self.daysContainer !== void 0)
          return elem.className.indexOf("hidden") === -1 && elem.className.indexOf("flatpickr-disabled") === -1 && self.daysContainer.contains(elem);
        return false;
      }
      function onBlur(e) {
        var isInput = e.target === self._input;
        var valueChanged = self._input.value.trimEnd() !== getDateStr();
        if (isInput && valueChanged && !(e.relatedTarget && isCalendarElem(e.relatedTarget))) {
          self.setDate(self._input.value, true, e.target === self.altInput ? self.config.altFormat : self.config.dateFormat);
        }
      }
      function onKeyDown(e) {
        var eventTarget = getEventTarget(e);
        var isInput = self.config.wrap ? element.contains(eventTarget) : eventTarget === self._input;
        var allowInput = self.config.allowInput;
        var allowKeydown = self.isOpen && (!allowInput || !isInput);
        var allowInlineKeydown = self.config.inline && isInput && !allowInput;
        if (e.keyCode === 13 && isInput) {
          if (allowInput) {
            self.setDate(self._input.value, true, eventTarget === self.altInput ? self.config.altFormat : self.config.dateFormat);
            self.close();
            return eventTarget.blur();
          } else {
            self.open();
          }
        } else if (isCalendarElem(eventTarget) || allowKeydown || allowInlineKeydown) {
          var isTimeObj = !!self.timeContainer && self.timeContainer.contains(eventTarget);
          switch (e.keyCode) {
            case 13:
              if (isTimeObj) {
                e.preventDefault();
                updateTime();
                focusAndClose();
              } else
                selectDate(e);
              break;
            case 27:
              e.preventDefault();
              focusAndClose();
              break;
            case 8:
            case 46:
              if (isInput && !self.config.allowInput) {
                e.preventDefault();
                self.clear();
              }
              break;
            case 37:
            case 39:
              if (!isTimeObj && !isInput) {
                e.preventDefault();
                var activeElement = getClosestActiveElement();
                if (self.daysContainer !== void 0 && (allowInput === false || activeElement && isInView(activeElement))) {
                  var delta_1 = e.keyCode === 39 ? 1 : -1;
                  if (!e.ctrlKey)
                    focusOnDay(void 0, delta_1);
                  else {
                    e.stopPropagation();
                    changeMonth(delta_1);
                    focusOnDay(getFirstAvailableDay(1), 0);
                  }
                }
              } else if (self.hourElement)
                self.hourElement.focus();
              break;
            case 38:
            case 40:
              e.preventDefault();
              var delta = e.keyCode === 40 ? 1 : -1;
              if (self.daysContainer && eventTarget.$i !== void 0 || eventTarget === self.input || eventTarget === self.altInput) {
                if (e.ctrlKey) {
                  e.stopPropagation();
                  changeYear(self.currentYear - delta);
                  focusOnDay(getFirstAvailableDay(1), 0);
                } else if (!isTimeObj)
                  focusOnDay(void 0, delta * 7);
              } else if (eventTarget === self.currentYearElement) {
                changeYear(self.currentYear - delta);
              } else if (self.config.enableTime) {
                if (!isTimeObj && self.hourElement)
                  self.hourElement.focus();
                updateTime(e);
                self._debouncedChange();
              }
              break;
            case 9:
              if (isTimeObj) {
                var elems = [
                  self.hourElement,
                  self.minuteElement,
                  self.secondElement,
                  self.amPM
                ].concat(self.pluginElements).filter(function(x) {
                  return x;
                });
                var i2 = elems.indexOf(eventTarget);
                if (i2 !== -1) {
                  var target = elems[i2 + (e.shiftKey ? -1 : 1)];
                  e.preventDefault();
                  (target || self._input).focus();
                }
              } else if (!self.config.noCalendar && self.daysContainer && self.daysContainer.contains(eventTarget) && e.shiftKey) {
                e.preventDefault();
                self._input.focus();
              }
              break;
          }
        }
        if (self.amPM !== void 0 && eventTarget === self.amPM) {
          switch (e.key) {
            case self.l10n.amPM[0].charAt(0):
            case self.l10n.amPM[0].charAt(0).toLowerCase():
              self.amPM.textContent = self.l10n.amPM[0];
              setHoursFromInputs();
              updateValue();
              break;
            case self.l10n.amPM[1].charAt(0):
            case self.l10n.amPM[1].charAt(0).toLowerCase():
              self.amPM.textContent = self.l10n.amPM[1];
              setHoursFromInputs();
              updateValue();
              break;
          }
        }
        if (isInput || isCalendarElem(eventTarget)) {
          triggerEvent("onKeyDown", e);
        }
      }
      function onMouseOver(elem, cellClass) {
        if (cellClass === void 0) {
          cellClass = "flatpickr-day";
        }
        if (self.selectedDates.length !== 1 || elem && (!elem.classList.contains(cellClass) || elem.classList.contains("flatpickr-disabled")))
          return;
        var hoverDate = elem ? elem.dateObj.getTime() : self.days.firstElementChild.dateObj.getTime(), initialDate = self.parseDate(self.selectedDates[0], void 0, true).getTime(), rangeStartDate = Math.min(hoverDate, self.selectedDates[0].getTime()), rangeEndDate = Math.max(hoverDate, self.selectedDates[0].getTime());
        var containsDisabled = false;
        var minRange = 0, maxRange = 0;
        for (var t = rangeStartDate; t < rangeEndDate; t += duration.DAY) {
          if (!isEnabled(new Date(t), true)) {
            containsDisabled = containsDisabled || t > rangeStartDate && t < rangeEndDate;
            if (t < initialDate && (!minRange || t > minRange))
              minRange = t;
            else if (t > initialDate && (!maxRange || t < maxRange))
              maxRange = t;
          }
        }
        var hoverableCells = Array.from(self.rContainer.querySelectorAll("*:nth-child(-n+" + self.config.showMonths + ") > ." + cellClass));
        hoverableCells.forEach(function(dayElem) {
          var date = dayElem.dateObj;
          var timestamp = date.getTime();
          var outOfRange = minRange > 0 && timestamp < minRange || maxRange > 0 && timestamp > maxRange;
          if (outOfRange) {
            dayElem.classList.add("notAllowed");
            ["inRange", "startRange", "endRange"].forEach(function(c) {
              dayElem.classList.remove(c);
            });
            return;
          } else if (containsDisabled && !outOfRange)
            return;
          ["startRange", "inRange", "endRange", "notAllowed"].forEach(function(c) {
            dayElem.classList.remove(c);
          });
          if (elem !== void 0) {
            elem.classList.add(hoverDate <= self.selectedDates[0].getTime() ? "startRange" : "endRange");
            if (initialDate < hoverDate && timestamp === initialDate)
              dayElem.classList.add("startRange");
            else if (initialDate > hoverDate && timestamp === initialDate)
              dayElem.classList.add("endRange");
            if (timestamp >= minRange && (maxRange === 0 || timestamp <= maxRange) && isBetween(timestamp, initialDate, hoverDate))
              dayElem.classList.add("inRange");
          }
        });
      }
      function onResize() {
        if (self.isOpen && !self.config.static && !self.config.inline)
          positionCalendar();
      }
      function open(e, positionElement) {
        if (positionElement === void 0) {
          positionElement = self._positionElement;
        }
        if (self.isMobile === true) {
          if (e) {
            e.preventDefault();
            var eventTarget = getEventTarget(e);
            if (eventTarget) {
              eventTarget.blur();
            }
          }
          if (self.mobileInput !== void 0) {
            self.mobileInput.focus();
            self.mobileInput.click();
          }
          triggerEvent("onOpen");
          return;
        } else if (self._input.disabled || self.config.inline) {
          return;
        }
        var wasOpen = self.isOpen;
        self.isOpen = true;
        if (!wasOpen) {
          self.calendarContainer.classList.add("open");
          self._input.classList.add("active");
          triggerEvent("onOpen");
          positionCalendar(positionElement);
        }
        if (self.config.enableTime === true && self.config.noCalendar === true) {
          if (self.config.allowInput === false && (e === void 0 || !self.timeContainer.contains(e.relatedTarget))) {
            setTimeout(function() {
              return self.hourElement.select();
            }, 50);
          }
        }
      }
      function minMaxDateSetter(type) {
        return function(date) {
          var dateObj = self.config["_" + type + "Date"] = self.parseDate(date, self.config.dateFormat);
          var inverseDateObj = self.config["_" + (type === "min" ? "max" : "min") + "Date"];
          if (dateObj !== void 0) {
            self[type === "min" ? "minDateHasTime" : "maxDateHasTime"] = dateObj.getHours() > 0 || dateObj.getMinutes() > 0 || dateObj.getSeconds() > 0;
          }
          if (self.selectedDates) {
            self.selectedDates = self.selectedDates.filter(function(d) {
              return isEnabled(d);
            });
            if (!self.selectedDates.length && type === "min")
              setHoursFromDate(dateObj);
            updateValue();
          }
          if (self.daysContainer) {
            redraw();
            if (dateObj !== void 0)
              self.currentYearElement[type] = dateObj.getFullYear().toString();
            else
              self.currentYearElement.removeAttribute(type);
            self.currentYearElement.disabled = !!inverseDateObj && dateObj !== void 0 && inverseDateObj.getFullYear() === dateObj.getFullYear();
          }
        };
      }
      function parseConfig() {
        var boolOpts = [
          "wrap",
          "weekNumbers",
          "allowInput",
          "allowInvalidPreload",
          "clickOpens",
          "time_24hr",
          "enableTime",
          "noCalendar",
          "altInput",
          "shorthandCurrentMonth",
          "inline",
          "static",
          "enableSeconds",
          "disableMobile"
        ];
        var userConfig = __assign(__assign({}, JSON.parse(JSON.stringify(element.dataset || {}))), instanceConfig);
        var formats2 = {};
        self.config.parseDate = userConfig.parseDate;
        self.config.formatDate = userConfig.formatDate;
        Object.defineProperty(self.config, "enable", {
          get: function() {
            return self.config._enable;
          },
          set: function(dates) {
            self.config._enable = parseDateRules(dates);
          }
        });
        Object.defineProperty(self.config, "disable", {
          get: function() {
            return self.config._disable;
          },
          set: function(dates) {
            self.config._disable = parseDateRules(dates);
          }
        });
        var timeMode = userConfig.mode === "time";
        if (!userConfig.dateFormat && (userConfig.enableTime || timeMode)) {
          var defaultDateFormat = flatpickr.defaultConfig.dateFormat || defaults.dateFormat;
          formats2.dateFormat = userConfig.noCalendar || timeMode ? "H:i" + (userConfig.enableSeconds ? ":S" : "") : defaultDateFormat + " H:i" + (userConfig.enableSeconds ? ":S" : "");
        }
        if (userConfig.altInput && (userConfig.enableTime || timeMode) && !userConfig.altFormat) {
          var defaultAltFormat = flatpickr.defaultConfig.altFormat || defaults.altFormat;
          formats2.altFormat = userConfig.noCalendar || timeMode ? "h:i" + (userConfig.enableSeconds ? ":S K" : " K") : defaultAltFormat + (" h:i" + (userConfig.enableSeconds ? ":S" : "") + " K");
        }
        Object.defineProperty(self.config, "minDate", {
          get: function() {
            return self.config._minDate;
          },
          set: minMaxDateSetter("min")
        });
        Object.defineProperty(self.config, "maxDate", {
          get: function() {
            return self.config._maxDate;
          },
          set: minMaxDateSetter("max")
        });
        var minMaxTimeSetter = function(type) {
          return function(val) {
            self.config[type === "min" ? "_minTime" : "_maxTime"] = self.parseDate(val, "H:i:S");
          };
        };
        Object.defineProperty(self.config, "minTime", {
          get: function() {
            return self.config._minTime;
          },
          set: minMaxTimeSetter("min")
        });
        Object.defineProperty(self.config, "maxTime", {
          get: function() {
            return self.config._maxTime;
          },
          set: minMaxTimeSetter("max")
        });
        if (userConfig.mode === "time") {
          self.config.noCalendar = true;
          self.config.enableTime = true;
        }
        Object.assign(self.config, formats2, userConfig);
        for (var i2 = 0; i2 < boolOpts.length; i2++)
          self.config[boolOpts[i2]] = self.config[boolOpts[i2]] === true || self.config[boolOpts[i2]] === "true";
        HOOKS.filter(function(hook) {
          return self.config[hook] !== void 0;
        }).forEach(function(hook) {
          self.config[hook] = arrayify(self.config[hook] || []).map(bindToInstance);
        });
        self.isMobile = !self.config.disableMobile && !self.config.inline && self.config.mode === "single" && !self.config.disable.length && !self.config.enable && !self.config.weekNumbers && /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        for (var i2 = 0; i2 < self.config.plugins.length; i2++) {
          var pluginConf = self.config.plugins[i2](self) || {};
          for (var key2 in pluginConf) {
            if (HOOKS.indexOf(key2) > -1) {
              self.config[key2] = arrayify(pluginConf[key2]).map(bindToInstance).concat(self.config[key2]);
            } else if (typeof userConfig[key2] === "undefined")
              self.config[key2] = pluginConf[key2];
          }
        }
        if (!userConfig.altInputClass) {
          self.config.altInputClass = getInputElem().className + " " + self.config.altInputClass;
        }
        triggerEvent("onParseConfig");
      }
      function getInputElem() {
        return self.config.wrap ? element.querySelector("[data-input]") : element;
      }
      function setupLocale() {
        if (typeof self.config.locale !== "object" && typeof flatpickr.l10ns[self.config.locale] === "undefined")
          self.config.errorHandler(new Error("flatpickr: invalid locale " + self.config.locale));
        self.l10n = __assign(__assign({}, flatpickr.l10ns.default), typeof self.config.locale === "object" ? self.config.locale : self.config.locale !== "default" ? flatpickr.l10ns[self.config.locale] : void 0);
        tokenRegex.D = "(" + self.l10n.weekdays.shorthand.join("|") + ")";
        tokenRegex.l = "(" + self.l10n.weekdays.longhand.join("|") + ")";
        tokenRegex.M = "(" + self.l10n.months.shorthand.join("|") + ")";
        tokenRegex.F = "(" + self.l10n.months.longhand.join("|") + ")";
        tokenRegex.K = "(" + self.l10n.amPM[0] + "|" + self.l10n.amPM[1] + "|" + self.l10n.amPM[0].toLowerCase() + "|" + self.l10n.amPM[1].toLowerCase() + ")";
        var userConfig = __assign(__assign({}, instanceConfig), JSON.parse(JSON.stringify(element.dataset || {})));
        if (userConfig.time_24hr === void 0 && flatpickr.defaultConfig.time_24hr === void 0) {
          self.config.time_24hr = self.l10n.time_24hr;
        }
        self.formatDate = createDateFormatter(self);
        self.parseDate = createDateParser({ config: self.config, l10n: self.l10n });
      }
      function positionCalendar(customPositionElement) {
        if (typeof self.config.position === "function") {
          return void self.config.position(self, customPositionElement);
        }
        if (self.calendarContainer === void 0)
          return;
        triggerEvent("onPreCalendarPosition");
        var positionElement = customPositionElement || self._positionElement;
        var calendarHeight = Array.prototype.reduce.call(self.calendarContainer.children, (function(acc, child) {
          return acc + child.offsetHeight;
        }), 0), calendarWidth = self.calendarContainer.offsetWidth, configPos = self.config.position.split(" "), configPosVertical = configPos[0], configPosHorizontal = configPos.length > 1 ? configPos[1] : null, inputBounds = positionElement.getBoundingClientRect(), distanceFromBottom = window.innerHeight - inputBounds.bottom, showOnTop = configPosVertical === "above" || configPosVertical !== "below" && distanceFromBottom < calendarHeight && inputBounds.top > calendarHeight;
        var top = window.pageYOffset + inputBounds.top + (!showOnTop ? positionElement.offsetHeight + 2 : -calendarHeight - 2);
        toggleClass(self.calendarContainer, "arrowTop", !showOnTop);
        toggleClass(self.calendarContainer, "arrowBottom", showOnTop);
        if (self.config.inline)
          return;
        var left = window.pageXOffset + inputBounds.left;
        var isCenter = false;
        var isRight = false;
        if (configPosHorizontal === "center") {
          left -= (calendarWidth - inputBounds.width) / 2;
          isCenter = true;
        } else if (configPosHorizontal === "right") {
          left -= calendarWidth - inputBounds.width;
          isRight = true;
        }
        toggleClass(self.calendarContainer, "arrowLeft", !isCenter && !isRight);
        toggleClass(self.calendarContainer, "arrowCenter", isCenter);
        toggleClass(self.calendarContainer, "arrowRight", isRight);
        var right = window.document.body.offsetWidth - (window.pageXOffset + inputBounds.right);
        var rightMost = left + calendarWidth > window.document.body.offsetWidth;
        var centerMost = right + calendarWidth > window.document.body.offsetWidth;
        toggleClass(self.calendarContainer, "rightMost", rightMost);
        if (self.config.static)
          return;
        self.calendarContainer.style.top = top + "px";
        if (!rightMost) {
          self.calendarContainer.style.left = left + "px";
          self.calendarContainer.style.right = "auto";
        } else if (!centerMost) {
          self.calendarContainer.style.left = "auto";
          self.calendarContainer.style.right = right + "px";
        } else {
          var doc = getDocumentStyleSheet();
          if (doc === void 0)
            return;
          var bodyWidth = window.document.body.offsetWidth;
          var centerLeft = Math.max(0, bodyWidth / 2 - calendarWidth / 2);
          var centerBefore = ".flatpickr-calendar.centerMost:before";
          var centerAfter = ".flatpickr-calendar.centerMost:after";
          var centerIndex = doc.cssRules.length;
          var centerStyle = "{left:" + inputBounds.left + "px;right:auto;}";
          toggleClass(self.calendarContainer, "rightMost", false);
          toggleClass(self.calendarContainer, "centerMost", true);
          doc.insertRule(centerBefore + "," + centerAfter + centerStyle, centerIndex);
          self.calendarContainer.style.left = centerLeft + "px";
          self.calendarContainer.style.right = "auto";
        }
      }
      function getDocumentStyleSheet() {
        var editableSheet = null;
        for (var i2 = 0; i2 < document.styleSheets.length; i2++) {
          var sheet = document.styleSheets[i2];
          if (!sheet.cssRules)
            continue;
          try {
            sheet.cssRules;
          } catch (err) {
            continue;
          }
          editableSheet = sheet;
          break;
        }
        return editableSheet != null ? editableSheet : createStyleSheet();
      }
      function createStyleSheet() {
        var style = document.createElement("style");
        document.head.appendChild(style);
        return style.sheet;
      }
      function redraw() {
        if (self.config.noCalendar || self.isMobile)
          return;
        buildMonthSwitch();
        updateNavigationCurrentMonth();
        buildDays();
      }
      function focusAndClose() {
        self._input.focus();
        if (window.navigator.userAgent.indexOf("MSIE") !== -1 || navigator.msMaxTouchPoints !== void 0) {
          setTimeout(self.close, 0);
        } else {
          self.close();
        }
      }
      function selectDate(e) {
        e.preventDefault();
        e.stopPropagation();
        var isSelectable = function(day) {
          return day.classList && day.classList.contains("flatpickr-day") && !day.classList.contains("flatpickr-disabled") && !day.classList.contains("notAllowed");
        };
        var t = findParent(getEventTarget(e), isSelectable);
        if (t === void 0)
          return;
        var target = t;
        var selectedDate = self.latestSelectedDateObj = new Date(target.dateObj.getTime());
        var shouldChangeMonth = (selectedDate.getMonth() < self.currentMonth || selectedDate.getMonth() > self.currentMonth + self.config.showMonths - 1) && self.config.mode !== "range";
        self.selectedDateElem = target;
        if (self.config.mode === "single")
          self.selectedDates = [selectedDate];
        else if (self.config.mode === "multiple") {
          var selectedIndex = isDateSelected(selectedDate);
          if (selectedIndex)
            self.selectedDates.splice(parseInt(selectedIndex), 1);
          else
            self.selectedDates.push(selectedDate);
        } else if (self.config.mode === "range") {
          if (self.selectedDates.length === 2) {
            self.clear(false, false);
          }
          self.latestSelectedDateObj = selectedDate;
          self.selectedDates.push(selectedDate);
          if (compareDates(selectedDate, self.selectedDates[0], true) !== 0)
            self.selectedDates.sort(function(a, b) {
              return a.getTime() - b.getTime();
            });
        }
        setHoursFromInputs();
        if (shouldChangeMonth) {
          var isNewYear = self.currentYear !== selectedDate.getFullYear();
          self.currentYear = selectedDate.getFullYear();
          self.currentMonth = selectedDate.getMonth();
          if (isNewYear) {
            triggerEvent("onYearChange");
            buildMonthSwitch();
          }
          triggerEvent("onMonthChange");
        }
        updateNavigationCurrentMonth();
        buildDays();
        updateValue();
        if (!shouldChangeMonth && self.config.mode !== "range" && self.config.showMonths === 1)
          focusOnDayElem(target);
        else if (self.selectedDateElem !== void 0 && self.hourElement === void 0) {
          self.selectedDateElem && self.selectedDateElem.focus();
        }
        if (self.hourElement !== void 0)
          self.hourElement !== void 0 && self.hourElement.focus();
        if (self.config.closeOnSelect) {
          var single = self.config.mode === "single" && !self.config.enableTime;
          var range = self.config.mode === "range" && self.selectedDates.length === 2 && !self.config.enableTime;
          if (single || range) {
            focusAndClose();
          }
        }
        triggerChange();
      }
      var CALLBACKS = {
        locale: [setupLocale, updateWeekdays],
        showMonths: [buildMonths, setCalendarWidth, buildWeekdays],
        minDate: [jumpToDate],
        maxDate: [jumpToDate],
        positionElement: [updatePositionElement],
        clickOpens: [
          function() {
            if (self.config.clickOpens === true) {
              bind(self._input, "focus", self.open);
              bind(self._input, "click", self.open);
            } else {
              self._input.removeEventListener("focus", self.open);
              self._input.removeEventListener("click", self.open);
            }
          }
        ]
      };
      function set(option, value) {
        if (option !== null && typeof option === "object") {
          Object.assign(self.config, option);
          for (var key2 in option) {
            if (CALLBACKS[key2] !== void 0)
              CALLBACKS[key2].forEach(function(x) {
                return x();
              });
          }
        } else {
          self.config[option] = value;
          if (CALLBACKS[option] !== void 0)
            CALLBACKS[option].forEach(function(x) {
              return x();
            });
          else if (HOOKS.indexOf(option) > -1)
            self.config[option] = arrayify(value);
        }
        self.redraw();
        updateValue(true);
      }
      function setSelectedDate(inputDate, format) {
        var dates = [];
        if (inputDate instanceof Array)
          dates = inputDate.map(function(d) {
            return self.parseDate(d, format);
          });
        else if (inputDate instanceof Date || typeof inputDate === "number")
          dates = [self.parseDate(inputDate, format)];
        else if (typeof inputDate === "string") {
          switch (self.config.mode) {
            case "single":
            case "time":
              dates = [self.parseDate(inputDate, format)];
              break;
            case "multiple":
              dates = inputDate.split(self.config.conjunction).map(function(date) {
                return self.parseDate(date, format);
              });
              break;
            case "range":
              dates = inputDate.split(self.l10n.rangeSeparator).map(function(date) {
                return self.parseDate(date, format);
              });
              break;
          }
        } else
          self.config.errorHandler(new Error("Invalid date supplied: " + JSON.stringify(inputDate)));
        self.selectedDates = self.config.allowInvalidPreload ? dates : dates.filter(function(d) {
          return d instanceof Date && isEnabled(d, false);
        });
        if (self.config.mode === "range")
          self.selectedDates.sort(function(a, b) {
            return a.getTime() - b.getTime();
          });
      }
      function setDate(date, triggerChange2, format) {
        if (triggerChange2 === void 0) {
          triggerChange2 = false;
        }
        if (format === void 0) {
          format = self.config.dateFormat;
        }
        if (date !== 0 && !date || date instanceof Array && date.length === 0)
          return self.clear(triggerChange2);
        setSelectedDate(date, format);
        self.latestSelectedDateObj = self.selectedDates[self.selectedDates.length - 1];
        self.redraw();
        jumpToDate(void 0, triggerChange2);
        setHoursFromDate();
        if (self.selectedDates.length === 0) {
          self.clear(false);
        }
        updateValue(triggerChange2);
        if (triggerChange2)
          triggerEvent("onChange");
      }
      function parseDateRules(arr) {
        return arr.slice().map(function(rule) {
          if (typeof rule === "string" || typeof rule === "number" || rule instanceof Date) {
            return self.parseDate(rule, void 0, true);
          } else if (rule && typeof rule === "object" && rule.from && rule.to)
            return {
              from: self.parseDate(rule.from, void 0),
              to: self.parseDate(rule.to, void 0)
            };
          return rule;
        }).filter(function(x) {
          return x;
        });
      }
      function setupDates() {
        self.selectedDates = [];
        self.now = self.parseDate(self.config.now) || /* @__PURE__ */ new Date();
        var preloadedDate = self.config.defaultDate || ((self.input.nodeName === "INPUT" || self.input.nodeName === "TEXTAREA") && self.input.placeholder && self.input.value === self.input.placeholder ? null : self.input.value);
        if (preloadedDate)
          setSelectedDate(preloadedDate, self.config.dateFormat);
        self._initialDate = self.selectedDates.length > 0 ? self.selectedDates[0] : self.config.minDate && self.config.minDate.getTime() > self.now.getTime() ? self.config.minDate : self.config.maxDate && self.config.maxDate.getTime() < self.now.getTime() ? self.config.maxDate : self.now;
        self.currentYear = self._initialDate.getFullYear();
        self.currentMonth = self._initialDate.getMonth();
        if (self.selectedDates.length > 0)
          self.latestSelectedDateObj = self.selectedDates[0];
        if (self.config.minTime !== void 0)
          self.config.minTime = self.parseDate(self.config.minTime, "H:i");
        if (self.config.maxTime !== void 0)
          self.config.maxTime = self.parseDate(self.config.maxTime, "H:i");
        self.minDateHasTime = !!self.config.minDate && (self.config.minDate.getHours() > 0 || self.config.minDate.getMinutes() > 0 || self.config.minDate.getSeconds() > 0);
        self.maxDateHasTime = !!self.config.maxDate && (self.config.maxDate.getHours() > 0 || self.config.maxDate.getMinutes() > 0 || self.config.maxDate.getSeconds() > 0);
      }
      function setupInputs() {
        self.input = getInputElem();
        if (!self.input) {
          self.config.errorHandler(new Error("Invalid input element specified"));
          return;
        }
        self.input._type = self.input.type;
        self.input.type = "text";
        self.input.classList.add("flatpickr-input");
        self._input = self.input;
        if (self.config.altInput) {
          self.altInput = createElement(self.input.nodeName, self.config.altInputClass);
          self._input = self.altInput;
          self.altInput.placeholder = self.input.placeholder;
          self.altInput.disabled = self.input.disabled;
          self.altInput.required = self.input.required;
          self.altInput.tabIndex = self.input.tabIndex;
          self.altInput.type = "text";
          self.input.setAttribute("type", "hidden");
          if (!self.config.static && self.input.parentNode)
            self.input.parentNode.insertBefore(self.altInput, self.input.nextSibling);
        }
        if (!self.config.allowInput)
          self._input.setAttribute("readonly", "readonly");
        updatePositionElement();
      }
      function updatePositionElement() {
        self._positionElement = self.config.positionElement || self._input;
      }
      function setupMobile() {
        var inputType = self.config.enableTime ? self.config.noCalendar ? "time" : "datetime-local" : "date";
        self.mobileInput = createElement("input", self.input.className + " flatpickr-mobile");
        self.mobileInput.tabIndex = 1;
        self.mobileInput.type = inputType;
        self.mobileInput.disabled = self.input.disabled;
        self.mobileInput.required = self.input.required;
        self.mobileInput.placeholder = self.input.placeholder;
        self.mobileFormatStr = inputType === "datetime-local" ? "Y-m-d\\TH:i:S" : inputType === "date" ? "Y-m-d" : "H:i:S";
        if (self.selectedDates.length > 0) {
          self.mobileInput.defaultValue = self.mobileInput.value = self.formatDate(self.selectedDates[0], self.mobileFormatStr);
        }
        if (self.config.minDate)
          self.mobileInput.min = self.formatDate(self.config.minDate, "Y-m-d");
        if (self.config.maxDate)
          self.mobileInput.max = self.formatDate(self.config.maxDate, "Y-m-d");
        if (self.input.getAttribute("step"))
          self.mobileInput.step = String(self.input.getAttribute("step"));
        self.input.type = "hidden";
        if (self.altInput !== void 0)
          self.altInput.type = "hidden";
        try {
          if (self.input.parentNode)
            self.input.parentNode.insertBefore(self.mobileInput, self.input.nextSibling);
        } catch (_a) {
        }
        bind(self.mobileInput, "change", function(e) {
          self.setDate(getEventTarget(e).value, false, self.mobileFormatStr);
          triggerEvent("onChange");
          triggerEvent("onClose");
        });
      }
      function toggle(e) {
        if (self.isOpen === true)
          return self.close();
        self.open(e);
      }
      function triggerEvent(event, data) {
        if (self.config === void 0)
          return;
        var hooks = self.config[event];
        if (hooks !== void 0 && hooks.length > 0) {
          for (var i2 = 0; hooks[i2] && i2 < hooks.length; i2++)
            hooks[i2](self.selectedDates, self.input.value, self, data);
        }
        if (event === "onChange") {
          self.input.dispatchEvent(createEvent("change"));
          self.input.dispatchEvent(createEvent("input"));
        }
      }
      function createEvent(name) {
        var e = document.createEvent("Event");
        e.initEvent(name, true, true);
        return e;
      }
      function isDateSelected(date) {
        for (var i2 = 0; i2 < self.selectedDates.length; i2++) {
          var selectedDate = self.selectedDates[i2];
          if (selectedDate instanceof Date && compareDates(selectedDate, date) === 0)
            return "" + i2;
        }
        return false;
      }
      function isDateInRange(date) {
        if (self.config.mode !== "range" || self.selectedDates.length < 2)
          return false;
        return compareDates(date, self.selectedDates[0]) >= 0 && compareDates(date, self.selectedDates[1]) <= 0;
      }
      function updateNavigationCurrentMonth() {
        if (self.config.noCalendar || self.isMobile || !self.monthNav)
          return;
        self.yearElements.forEach(function(yearElement, i2) {
          var d = new Date(self.currentYear, self.currentMonth, 1);
          d.setMonth(self.currentMonth + i2);
          if (self.config.showMonths > 1 || self.config.monthSelectorType === "static") {
            self.monthElements[i2].textContent = monthToStr(d.getMonth(), self.config.shorthandCurrentMonth, self.l10n) + " ";
          } else {
            self.monthsDropdownContainer.value = d.getMonth().toString();
          }
          yearElement.value = d.getFullYear().toString();
        });
        self._hidePrevMonthArrow = self.config.minDate !== void 0 && (self.currentYear === self.config.minDate.getFullYear() ? self.currentMonth <= self.config.minDate.getMonth() : self.currentYear < self.config.minDate.getFullYear());
        self._hideNextMonthArrow = self.config.maxDate !== void 0 && (self.currentYear === self.config.maxDate.getFullYear() ? self.currentMonth + 1 > self.config.maxDate.getMonth() : self.currentYear > self.config.maxDate.getFullYear());
      }
      function getDateStr(specificFormat) {
        var format = specificFormat || (self.config.altInput ? self.config.altFormat : self.config.dateFormat);
        return self.selectedDates.map(function(dObj) {
          return self.formatDate(dObj, format);
        }).filter(function(d, i2, arr) {
          return self.config.mode !== "range" || self.config.enableTime || arr.indexOf(d) === i2;
        }).join(self.config.mode !== "range" ? self.config.conjunction : self.l10n.rangeSeparator);
      }
      function updateValue(triggerChange2) {
        if (triggerChange2 === void 0) {
          triggerChange2 = true;
        }
        if (self.mobileInput !== void 0 && self.mobileFormatStr) {
          self.mobileInput.value = self.latestSelectedDateObj !== void 0 ? self.formatDate(self.latestSelectedDateObj, self.mobileFormatStr) : "";
        }
        self.input.value = getDateStr(self.config.dateFormat);
        if (self.altInput !== void 0) {
          self.altInput.value = getDateStr(self.config.altFormat);
        }
        if (triggerChange2 !== false)
          triggerEvent("onValueUpdate");
      }
      function onMonthNavClick(e) {
        var eventTarget = getEventTarget(e);
        var isPrevMonth = self.prevMonthNav.contains(eventTarget);
        var isNextMonth = self.nextMonthNav.contains(eventTarget);
        if (isPrevMonth || isNextMonth) {
          changeMonth(isPrevMonth ? -1 : 1);
        } else if (self.yearElements.indexOf(eventTarget) >= 0) {
          eventTarget.select();
        } else if (eventTarget.classList.contains("arrowUp")) {
          self.changeYear(self.currentYear + 1);
        } else if (eventTarget.classList.contains("arrowDown")) {
          self.changeYear(self.currentYear - 1);
        }
      }
      function timeWrapper(e) {
        e.preventDefault();
        var isKeyDown = e.type === "keydown", eventTarget = getEventTarget(e), input = eventTarget;
        if (self.amPM !== void 0 && eventTarget === self.amPM) {
          self.amPM.textContent = self.l10n.amPM[int(self.amPM.textContent === self.l10n.amPM[0])];
        }
        var min = parseFloat(input.getAttribute("min")), max = parseFloat(input.getAttribute("max")), step = parseFloat(input.getAttribute("step")), curValue = parseInt(input.value, 10), delta = e.delta || (isKeyDown ? e.which === 38 ? 1 : -1 : 0);
        var newValue = curValue + step * delta;
        if (typeof input.value !== "undefined" && input.value.length === 2) {
          var isHourElem = input === self.hourElement, isMinuteElem = input === self.minuteElement;
          if (newValue < min) {
            newValue = max + newValue + int(!isHourElem) + (int(isHourElem) && int(!self.amPM));
            if (isMinuteElem)
              incrementNumInput(void 0, -1, self.hourElement);
          } else if (newValue > max) {
            newValue = input === self.hourElement ? newValue - max - int(!self.amPM) : min;
            if (isMinuteElem)
              incrementNumInput(void 0, 1, self.hourElement);
          }
          if (self.amPM && isHourElem && (step === 1 ? newValue + curValue === 23 : Math.abs(newValue - curValue) > step)) {
            self.amPM.textContent = self.l10n.amPM[int(self.amPM.textContent === self.l10n.amPM[0])];
          }
          input.value = pad(newValue);
        }
      }
      init();
      return self;
    }
    function _flatpickr(nodeList, config) {
      var nodes = Array.prototype.slice.call(nodeList).filter(function(x) {
        return x instanceof HTMLElement;
      });
      var instances = [];
      for (var i2 = 0; i2 < nodes.length; i2++) {
        var node = nodes[i2];
        try {
          if (node.getAttribute("data-fp-omit") !== null)
            continue;
          if (node._flatpickr !== void 0) {
            node._flatpickr.destroy();
            node._flatpickr = void 0;
          }
          node._flatpickr = FlatpickrInstance(node, config || {});
          instances.push(node._flatpickr);
        } catch (e) {
          console.error(e);
        }
      }
      return instances.length === 1 ? instances[0] : instances;
    }
    if (typeof HTMLElement !== "undefined" && typeof HTMLCollection !== "undefined" && typeof NodeList !== "undefined") {
      HTMLCollection.prototype.flatpickr = NodeList.prototype.flatpickr = function(config) {
        return _flatpickr(this, config);
      };
      HTMLElement.prototype.flatpickr = function(config) {
        return _flatpickr([this], config);
      };
    }
    var flatpickr = function(selector, config) {
      if (typeof selector === "string") {
        return _flatpickr(window.document.querySelectorAll(selector), config);
      } else if (selector instanceof Node) {
        return _flatpickr([selector], config);
      } else {
        return _flatpickr(selector, config);
      }
    };
    flatpickr.defaultConfig = {};
    flatpickr.l10ns = {
      en: __assign({}, english),
      default: __assign({}, english)
    };
    flatpickr.localize = function(l10n) {
      flatpickr.l10ns.default = __assign(__assign({}, flatpickr.l10ns.default), l10n);
    };
    flatpickr.setDefaults = function(config) {
      flatpickr.defaultConfig = __assign(__assign({}, flatpickr.defaultConfig), config);
    };
    flatpickr.parseDate = createDateParser({});
    flatpickr.formatDate = createDateFormatter({});
    flatpickr.compareDates = compareDates;
    if (typeof $$1 !== "undefined" && typeof $$1.fn !== "undefined") {
      $$1.fn.flatpickr = function(config) {
        return _flatpickr(this, config);
      };
    }
    Date.prototype.fp_incr = function(days) {
      return new Date(this.getFullYear(), this.getMonth(), this.getDate() + (typeof days === "string" ? parseInt(days, 10) : days));
    };
    if (typeof window !== "undefined") {
      window.flatpickr = flatpickr;
    }
    window.$ = window.jQuery = $$1;
    const jitterbug = {
      clearStorage() {
        sessionStorage.removeItem("selectedAdminTable");
        localStorage.removeItem("itemsSearchField");
        localStorage.removeItem("itemsFilterPanel");
        sessionStorage.removeItem("itemsTableSelection");
        localStorage.removeItem("itemsTableParams");
        localStorage.removeItem("instancesSearchField");
        localStorage.removeItem("instancesFilterPanel");
        sessionStorage.removeItem("instancesTableSelection");
        localStorage.removeItem("instancesTableParams");
        localStorage.removeItem("transfersSearchField");
        localStorage.removeItem("transfersFilterPanel");
        sessionStorage.removeItem("transfersTableSelection");
        localStorage.removeItem("transfersTableParams");
        sessionStorage.removeItem("dashboardMarks");
      },
      initAjax() {
        $$1.ajaxSetup({
          headers: { "X-CSRF-TOKEN": $$1('meta[name="csrf-token"]').attr("content") }
        });
      },
      initSessionTimeout() {
        let threeHours = 108e5;
        window.setTimeout(function() {
          window.location.href = "/logout";
        }, threeHours);
      },
      initGreeting() {
        let hour = (/* @__PURE__ */ new Date()).getHours(), greeting;
        if (hour > 17) {
          greeting = "Good Evening!";
        } else if (hour > 11) {
          greeting = "Good Afternoon!";
        } else if (hour > 0) {
          greeting = "Good Morning!";
        } else {
          greeting = "Welcome!";
        }
        $$1("#greeting").text(greeting);
      },
      getAlert() {
        $$1.get("/alerts", function(data) {
          if (!$$1.isEmptyObject(data)) {
            $$1.ajax({ url: "/alerts", type: "delete" });
            jitterbug.displayAlert(data["type"], data["message"]);
          }
        });
      },
      displayAlert(type, message) {
        if (type.length && message.length) {
          let alert2 = document.createElement("div");
          $$1(alert2).attr("id", "alert");
          $$1(alert2).attr("class", "col-md-12 alert alert-" + type);
          $$1(alert2).attr("role", "alert");
          $$1(alert2).html(message);
          $$1("#alert").replaceWith(alert2);
          $$1("#alert").delay(500).slideDown(200).delay(8e3).slideUp(200);
        }
      },
      initSubmitButton() {
        $$1('button[type="submit"]').on("click", function(event) {
          $$1(this).attr("disabled", true);
          $$1(this).closest("form").submit();
        });
      },
      initSelectAll(allSelector, checkboxSelector) {
        $$1(allSelector).on("change", function(event) {
          if (jitterbug.checked) {
            $$1(checkboxSelector).each(function() {
              jitterbug.checked = true;
            });
          } else {
            $$1(checkboxSelector).each(function() {
              jitterbug.checked = false;
            });
          }
        });
        $$1(checkboxSelector).on("change", function() {
          if ($$1(this).is(":checked")) {
            let isAllChecked = 0;
            $$1(checkboxSelector).each(function() {
              if (!jitterbug.checked)
                isAllChecked = 1;
            });
            if (isAllChecked == 0) {
              $$1(allSelector).prop("checked", true);
            }
          } else {
            $$1(allSelector).prop("checked", false);
          }
        });
      },
      initAdmin() {
        let selectedTable = sessionStorage.getItem("selectedAdminTable");
        if (selectedTable == null) {
          selectedTable = "users";
          sessionStorage.setItem("selectedAdminTable", "users");
        }
        $$1("input[name=table]").on("click", function(event) {
          let table = $$1(this).val(), resource = table.replace(/_/g, "-");
          $$1.get("/" + resource, function(data) {
            sessionStorage.setItem("selectedAdminTable", table);
            $$1(".popover").hide();
            $$1("#record-container").replaceWith(data);
            if (table === "prefixes") {
              jitterbug.toggleLegacy();
              jitterbug.initAdminEditableFields(resource);
            } else {
              jitterbug.initAdminEditableFields(resource);
            }
          });
        });
        $$1("input[name=table]").each(function() {
          if ($$1(this).val() === selectedTable) {
            $$1(this).trigger("click");
          }
        });
      },
      toggleAdmin(user_id) {
        let user = $$1(`#${user_id}`);
        let makeAdmin = user.is(":checked");
        let route = makeAdmin ? "/admin/make-admin" : "/admin/remove-admin";
        let username = user.data("username");
        let data = {};
        data["username"] = username;
        $$1.post(route, data, function(data2) {
          let message = makeAdmin ? "User " + username + " was successfully made admin." : "User " + username + " is no longer an admin.";
          $$1(window).scrollTop(0);
          jitterbug.displayAlert("success", message);
        }).fail(function(jqXHR) {
          if (jqXHR.status === 422) {
            let errors = JSON.parse(jqXHR.responseText);
            let errorMessage = errors["errors"]["name"][0];
            jitterbug.displayAlert("danger", "<strong>Whoops.</strong> " + errorMessage);
          }
        });
      },
      toggleInactive(user_id) {
        let user = $$1(`#${user_id}`);
        let makeInactive = user.is(":checked");
        let route = makeInactive ? "/users/inactivate" : "/users/reactivate";
        let username = user.data("username");
        let data = {};
        let row = user.closest("tr");
        let id = row.data("id");
        let adminCheckbox = row.find(".admin input:checkbox");
        data["id"] = id;
        $$1.post(route, data, function(data2) {
          let numberDeleted = data2["marksDeleted"];
          let message = "";
          if (makeInactive) {
            adminCheckbox.prop("checked", false);
            adminCheckbox.attr("disabled", true);
            row.addClass("inactive-row");
            message = `User ${username} was successfully inactivated. 
              ${numberDeleted} of their marks were deleted.`;
          } else {
            adminCheckbox.attr("disabled", false);
            row.removeClass("inactive-row");
            message = "User " + username + " is now active.";
          }
          $$1(window).scrollTop(0);
          jitterbug.displayAlert("success", message);
        });
      },
      toggleLegacy() {
        let legacyCheckboxes = $$1(".legacy input:checkbox");
        legacyCheckboxes.on("click", function(event) {
          let makeLegacy = $$1(this).is(":checked");
          let route = makeLegacy ? "/prefixes/set-legacy-status" : "/prefixes/remove-legacy-status";
          let data = {};
          data["id"] = $$1(this).data("id");
          $$1.post(route, data, function(data2) {
            let message = makeLegacy ? "That prefix was successfully made legacy." : "That prefix is no longer legacy.";
            jitterbug.displayAlert("success", message);
          });
        });
      },
      initAdminEditableFields(resource) {
        $$1("#new-record-button").on("click", function(event) {
          event.preventDefault();
          let button = this;
          let popover = $$1("#" + $$1(this).attr("aria-describedby"));
          popover.css("max-width", "none");
          $$1(button).popover("show");
          popover.find("form").submit(function(event2) {
            event2.preventDefault();
            let form = $$1(this).serialize();
            let submitButton = $$1(this).find('button[type="submit"]');
            let cancelButton = $$1(this).find("button.cancel-new-record");
            submitButton.attr("disabled", true);
            cancelButton.attr("disabled", true);
            let icon = submitButton.find("i");
            icon.removeClass("fa-check");
            icon.addClass("fa-spinner").addClass("fa-pulse");
            $$1.ajax({
              url: "/" + resource,
              type: "post",
              data: form,
              success: function(data) {
                let tableContainer = $$1("#table-container");
                tableContainer.animate({ scrollTop: 0 });
                let templateRow = tableContainer.find("tbody > tr:first").clone();
                templateRow.find("[data-field]").each(function() {
                  let field = $$1(this).attr("data-field");
                  $$1(this).attr("data-id", data.id);
                  let newCellValue = data[field] === "" ? "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" : data[field];
                  if (field === "collection_type_id") {
                    newCellValue = data["collectionTypeName"];
                  } else if (field === "prefixes") {
                    newCellValue = "Please add prefixes.";
                  }
                  $$1(this).html(newCellValue);
                  if ($$1(this).hasClass("editable")) {
                    jitterbug.createAdminEditableFieldPopover(resource, this);
                  }
                });
                let deleteAnchor = templateRow.find(".delete");
                jitterbug.bindAdminRecordDelete(resource, deleteAnchor);
                templateRow.prependTo("#table-container > table > tbody");
              },
              error: function(jqXHR, textStatus, error) {
                if (jqXHR.status === 422) {
                  let errors = JSON.parse(jqXHR.responseText);
                  let errorMessage = errors["errors"]["name"][0];
                  jitterbug.displayAlert(
                    "danger",
                    "<strong>Whoops.</strong> " + errorMessage
                  );
                } else {
                  jitterbug.displayAlert(
                    "danger",
                    "<strong>Uh oh.</strong> An error has occurred: " + error
                  );
                }
              },
              complete() {
                $$1(button).popover("hide");
              }
            });
          });
        });
        let body_events = $$1("body");
        body_events.on("click", ".cancel-new-record", function(event) {
          event.preventDefault();
          $$1("#new-record-button").popover("hide");
        });
        body_events.on("hidden.bs.popover", function(event) {
          $$1(event.target).data("bs.popover")._activeTrigger.click = false;
        });
        $$1(".editable").each(function() {
          jitterbug.createAdminEditableFieldPopover(resource, this);
        });
        $$1(".delete").each(function() {
          jitterbug.bindAdminRecordDelete(resource, this);
        });
        body_events.on("click", ".cancel-edit", function(event) {
          event.preventDefault();
          let popover = $$1(this).closest(".popover");
          popover.popover("hide");
        });
        body_events.on("show.bs.popover", function(event) {
          let target = event.target;
          $$1(".editable").each(function() {
            if ($$1(this).is(target)) {
              return true;
            } else {
              if ($$1(this).attr("aria-describedby")) {
                $$1(this).popover("hide");
              }
            }
          });
          if (!$$1("#new-record-button").is(target)) {
            $$1("#new-record-button").popover("hide");
          }
        });
        $$1("#table-container").scroll(function() {
          $$1(".editable").popover("hide");
        });
      },
      createAdminEditableFieldPopover(resource, span) {
        let fieldName = $$1(span).data("field"), fieldText = $$1(span).text().trim(), formSelector = "#edit-" + fieldName + "-form", field = $$1(formSelector + " input[name=" + fieldName + "]");
        field.attr("value", fieldText);
        $$1(span).popover({
          placement: "bottom",
          html: true,
          content: $$1(formSelector).html()
        }).on("click", function(event) {
          event.preventDefault();
          let fieldSpan = this;
          $$1(this).popover("show");
          let popover = $$1("#" + $$1(this).attr("aria-describedby"));
          popover.css("max-width", "none");
          $$1(this).popover("show");
          let popoverInput = popover.find("input[name=" + fieldName + "]");
          popoverInput.attr("value", $$1(fieldSpan).text().trim());
          popover.find("form").submit(function(event2) {
            event2.preventDefault();
            let id = $$1(fieldSpan).attr("data-id"), dropdownSelect = false, formInputVal = $$1(this).find("input[name=" + fieldName + "]").val();
            if (formInputVal === void 0) {
              formInputVal = parseInt($$1(this).find(":selected").val());
              dropdownSelect = true;
              $$1(this).find(":selected").text();
            }
            let data = {};
            data[fieldName] = formInputVal;
            let submitButton = $$1(this).find('button[type="submit"]');
            let cancelButton = $$1(this).find("button.cancel-edit");
            submitButton.attr("disabled", true);
            cancelButton.attr("disabled", true);
            let icon = submitButton.find("i");
            icon.removeClass("fa-check");
            icon.addClass("fa-spinner").addClass("fa-pulse");
            $$1.ajax({
              url: "/" + resource + "/" + id,
              type: "put",
              data,
              success: function(data2) {
                let newCellValue = formInputVal === "" ? "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" : formInputVal;
                if (dropdownSelect === true) {
                  newCellValue = formInputText;
                }
                $$1(fieldSpan).html(newCellValue);
                if (fieldName === "id") {
                  $$1('.editable[data-id="' + id + '"]').attr("data-id", formInputVal);
                }
              },
              error: function(jqXHR, textStatus, error) {
                if (jqXHR.status === 422) {
                  let errors = JSON.parse(jqXHR.responseText);
                  for (let key2 in errors) if (errors.hasOwnProperty(key2)) break;
                  jitterbug.displayAlert(
                    "danger",
                    "<strong>Whoops.</strong> " + errors[key]
                  );
                } else {
                  jitterbug.displayAlert(
                    "danger",
                    "<strong>Uh oh.</strong> An error has occurred: " + error
                  );
                }
              },
              complete() {
                $$1(fieldSpan).popover("hide");
              }
            });
          });
        });
      },
      bindAdminRecordDelete(resource, anchor) {
        $$1(anchor).on("click", function(event) {
          event.preventDefault();
          let row = $$1(this).closest("tr");
          let id = row.find(".editable").first().attr("data-id");
          $$1.ajax({
            url: "/" + resource + "/" + id,
            type: "delete",
            success: function(data) {
              let additionalMessage = data["message"] === void 0 ? "" : data["message"];
              row.remove();
              jitterbug.displayAlert(
                "success",
                "<strong>Gone.</strong> The record was successfully deleted. " + additionalMessage
              );
            },
            error: function(jqXHR, textStatus, error) {
              if (jqXHR.status === 422) {
                let errors = JSON.parse(jqXHR.responseText);
                for (let key2 in errors) if (errors.hasOwnProperty(key2)) break;
                jitterbug.displayAlert(
                  "danger",
                  "<strong>Hmm.</strong> " + errors[key]
                );
              } else {
                jitterbug.displayAlert(
                  "danger",
                  "<strong>Uh oh.</strong> An error has occurred: " + error
                );
              }
            }
          });
        });
      },
      initPrefixActions() {
        $$1(".delete").each(function() {
          jitterbug.bindFormatPrefixDetachment(this);
        });
        jitterbug.handlePrefixAttachmentForm();
        jitterbug.initChosenMultiSelect(".chosen-select", { width: "500px" }, { width: "500px" });
      },
      initChosenMultiSelect(selector, options, deselectOptions) {
        $$1(document).ready(function() {
          $$1(selector).chosen(options);
          $$1(".chosen-select-deselect").chosen(deselectOptions);
        });
      },
      handlePrefixAttachmentForm() {
        $$1("#prefix-attach-form").submit(function(event) {
          event.preventDefault();
          let dropdown = $$1(this).find("select");
          let prefixIds = dropdown.val();
          let id = $$1(this).attr("data-format-id");
          let url = window.location.href;
          let data = {
            "id": id,
            "prefixIds": prefixIds
          };
          $$1.ajax({
            url: "/formats/attach_prefixes",
            type: "POST",
            data,
            success: function() {
              dropdown.val("");
              jitterbug.displayAlert(
                "success",
                "The prefixes were successfully attached."
              );
              $$1("#data-panel").load(url + " #data-panel", function() {
                jitterbug.initPrefixActions();
              });
            },
            error: function(jqXHR, textStatus, error) {
              jitterbug.displayAlert("danger", "<strong>Uh oh.</strong> An error has occurred: " + error);
            }
          });
        });
      },
      bindFormatPrefixDetachment(anchor) {
        $$1(anchor).on("click", function(event) {
          event.preventDefault();
          let row = $$1(this).closest("tr");
          let data = {
            "id": row.attr("data-format-id"),
            "prefixId": row.attr("data-prefix-id")
          };
          $$1.ajax({
            url: "/formats/detach_prefixes",
            type: "POST",
            data,
            success: function() {
              row.remove();
              jitterbug.displayAlert(
                "success",
                "<strong>Gone.</strong> The prefix was successfully detached."
              );
            },
            error: function(jqXHR, textStatus, error) {
              jitterbug.displayAlert("danger", "<strong>Uh oh.</strong> An error has occurred: " + error);
            }
          });
        });
      },
      initDashboardCharts() {
        google.charts.load("current", { "packages": ["corechart"] });
        google.charts.setOnLoadCallback(jitterbug.drawDashboardCharts);
      },
      drawDashboardCharts() {
        let itemChart = $$1("#item-chart");
        let itemCounts = itemChart.data("counts").split(",").map(Number);
        let itemData = new google.visualization.DataTable();
        itemData.addColumn("string", "Type");
        itemData.addColumn("number", "Count");
        itemData.addRows([
          ["Audio", itemCounts[0]],
          ["Film", itemCounts[1]],
          ["Video", itemCounts[2]]
        ]);
        let instanceChart = $$1("#instance-chart");
        let instanceCounts = instanceChart.data("counts").split(",").map(Number);
        let instanceData = new google.visualization.DataTable();
        instanceData.addColumn("string", "Type");
        instanceData.addColumn("number", "Count");
        instanceData.addRows([
          ["Audio", instanceCounts[0]],
          ["Film", instanceCounts[1]],
          ["Video", instanceCounts[2]]
        ]);
        let transferChart = $$1("#transfer-chart");
        let transferCounts = transferChart.data("counts").split(",").map(Number);
        let transferData = new google.visualization.DataTable();
        transferData.addColumn("string", "Type");
        transferData.addColumn("number", "Count");
        transferData.addRows([
          ["Audio", transferCounts[0]],
          ["Film", transferCounts[1]],
          ["Video", transferCounts[2]]
        ]);
        let options = {
          width: 200,
          height: 200,
          legend: "none",
          fontName: "Source Sans Pro",
          fontSize: 12,
          chartArea: { width: "80%", height: "80%" },
          colors: ["#317da1", "#d1a842", "#d16642"]
        };
        itemChart = new google.visualization.PieChart(itemChart[0]);
        itemChart.draw(itemData, options);
        instanceChart = new google.visualization.PieChart(instanceChart[0]);
        instanceChart.draw(instanceData, options);
        transferChart = new google.visualization.PieChart(transferChart[0]);
        transferChart.draw(transferData, options);
      },
      initDashboardActivityStream() {
        $$1('.recent-activity li[role="button"]').on("click", function(event) {
          let type = $$1(this).data("object-type"), id = $$1(this).data("object-id");
          window.location.href = "/" + type + "s/" + id;
        });
      },
      initDashboardMarks() {
        let marksModule = jitterbug.MarksModule.load("dashboardMarks", "session");
        if (marksModule == null) {
          marksModule = jitterbug.MarksModule({
            key: "dashboardMarks",
            location: "session",
            marksContainer: ".marks",
            marksSelector: '.marks li[role="button"]',
            noMarksSelector: ".no-marks",
            filtersSelector: "#marks-filters label",
            usersSelector: ".marks-user",
            selectedUserSelector: "#selected-marks-user"
          });
        }
        marksModule.init();
        marksModule.store();
      },
      /*
       * These properties are set to deserialized instances for each
       * index page (items, instances, and transfers). They aren't used
       * for other pages.
       */
      searchField: null,
      filterPanel: null,
      tableParams: null,
      tableSelection: null,
      queryManager: null,
      /*
       * This is used to determine, when a data import modal is closed,
       * if the page should be refreshed. It is set to true when a data
       * import is successfully executed.
       */
      dataImported: false,
      initItemsNewButton() {
        $$1("#items-new").on("click", function(event) {
          jitterbug.tableSelection.clear();
        });
      },
      initItemsBatchMenu() {
        $$1("#items-batch-edit").on("click", function(event) {
          let tableSelection = jitterbug.tableSelection;
          let maxEditLimit = $$1(this).data("max-edit-limit");
          if (!jitterbug.validateBatchSelection(tableSelection, "editing", maxEditLimit)) {
            return;
          }
          jitterbug.submitBatchEditForm("items", tableSelection);
        });
        jitterbug.initDataExportModal("items");
        $$1("#items-batch-export").on("click", function(event) {
          let tableSelection = jitterbug.tableSelection;
          if (!jitterbug.validateBatchSelection(tableSelection, "exporting")) {
            return;
          }
          jitterbug.openDataExportModal("items", tableSelection);
        });
        $$1("#items-batch-mark").on("click", function(event) {
          let tableSelection = jitterbug.tableSelection;
          if (!jitterbug.validateBatchSelection(tableSelection, "marking", 100)) {
            return;
          }
          jitterbug.batchMark("items", "AudioVisualItem", tableSelection);
        });
        $$1("#items-batch-unmark").on("click", function(event) {
          let tableSelection = jitterbug.tableSelection;
          if (!jitterbug.validateBatchSelection(tableSelection, "unmarking", 100)) {
            return;
          }
          jitterbug.batchUnmark("items", "AudioVisualItem", tableSelection);
        });
        $$1("#items-batch-delete").on("click", function(event) {
          let tableSelection = jitterbug.tableSelection;
          if (!jitterbug.validateBatchSelection(tableSelection, "deleting", 100)) {
            return;
          }
          $$1("#confirm-batch-delete-modal").modal("toggle");
          $$1('#batch-delete-form input[name="ids"]').val(tableSelection.selectedIds());
        });
        $$1("#items-batch-items-import").on("click", function(event) {
          $$1("#items-import-modal").modal("toggle");
        });
      },
      initItemsImportModal() {
        jitterbug.initDataUploadForm("items");
        jitterbug.initDataImportForm("items");
        $$1("#items-import-modal .reset").on("click", function(event) {
          event.preventDefault();
          jitterbug.resetDataImportModal("items");
        });
        $$1("#items-import-modal").on("hide.bs.modal", function() {
          jitterbug.resetDataImportModal("items");
          if (jitterbug.dataImported) {
            location.reload();
          }
        });
      },
      initItemSuggestions() {
        $$1("#recording-location").autocomplete({
          serviceUrl: "/suggestions/recording-locations",
          deferRequestBy: 100
        });
        $$1("#speed").autocomplete({
          serviceUrl: "/suggestions/speeds",
          deferRequestBy: 100
        });
        $$1("#track-configuration").autocomplete({
          serviceUrl: "/suggestions/track-configurations",
          deferRequestBy: 100
        });
        $$1("#audio-base").autocomplete({
          serviceUrl: "/suggestions/audio-bases",
          deferRequestBy: 100
        });
        $$1("#film-element").autocomplete({
          serviceUrl: "/suggestions/film-elements",
          deferRequestBy: 100
        });
        $$1("#film-base").autocomplete({
          serviceUrl: "/suggestions/film-bases",
          deferRequestBy: 100
        });
      },
      initItemTypeControls() {
        $$1("#detail #item-type-controls :radio").on("click", function(event) {
          let value = $$1(this).val();
          if (value === "AudioItem") {
            $$1("#audio-form").show();
            $$1("#film-form").hide();
            $$1("#video-form").hide();
          } else if (value === "FilmItem") {
            $$1("#audio-form").hide();
            $$1("#film-form").show();
            $$1("#video-form").hide();
          } else if (value === "VideoItem") {
            $$1("#audio-form").hide();
            $$1("#film-form").hide();
            $$1("#video-form").show();
          }
        });
      },
      initItemCallNumberGeneration() {
        $$1("#collection-id, #format-id").on("change", function() {
          let collectionId = $$1("#collection-id").val();
          let formatId = $$1("#format-id").val();
          if (collectionId.length && formatId.length) {
            let query = {};
            query["format"] = formatId;
            query["collection"] = collectionId;
            $$1.get("/call-numbers/generate", query, function(data) {
              $$1("#call-number").val(data["callNumber"]);
            }).fail(function() {
              console.log("Call number generation failure.");
              $$1("#call-number").val("");
            });
          } else {
            $$1("#call-number").val("");
          }
        });
      },
      initInstancesNewButton() {
        $$1("#instances-new").on("click", function(event) {
          jitterbug.tableSelection.clear();
        });
      },
      initInstancesBatchMenu() {
        $$1("#instances-batch-edit").on("click", function(event) {
          let tableSelection = jitterbug.tableSelection;
          let maxEditLimit = $$1(this).data("max-edit-limit");
          if (!jitterbug.validateBatchSelection(tableSelection, "editing", maxEditLimit)) {
            return;
          }
          jitterbug.submitBatchEditForm("instances", tableSelection);
        });
        jitterbug.initDataExportModal("instances");
        $$1("#instances-batch-export").on("click", function(event) {
          let tableSelection = jitterbug.tableSelection;
          if (!jitterbug.validateBatchSelection(tableSelection, "exporting")) {
            return;
          }
          jitterbug.openDataExportModal("instances", tableSelection);
        });
        $$1("#instances-batch-mark").on("click", function(event) {
          let tableSelection = jitterbug.tableSelection;
          if (!jitterbug.validateBatchSelection(tableSelection, "marking", 100)) {
            return;
          }
          jitterbug.batchMark("instances", "PreservationInstance", tableSelection);
        });
        $$1("#instances-batch-unmark").on("click", function(event) {
          let tableSelection = jitterbug.tableSelection;
          if (!jitterbug.validateBatchSelection(tableSelection, "unmarking", 500)) {
            return;
          }
          jitterbug.batchUnmark("instances", "PreservationInstance", tableSelection);
        });
        $$1("#instances-batch-delete").on("click", function(event) {
          let tableSelection = jitterbug.tableSelection;
          if (!jitterbug.validateBatchSelection(tableSelection, "deleting", 100)) {
            return;
          }
          $$1("#confirm-batch-delete-modal").modal("toggle");
          $$1('#batch-delete-form input[name="ids"]').val(
            tableSelection.selectedIds()
          );
        });
      },
      initInstanceTypeControls() {
        $$1("#detail #instance-type-controls :radio").on("click", function(event) {
          let value = $$1(this).val();
          if (value === "AudioInstance") {
            $$1("#audio-form").show();
            $$1("#film-form").hide();
            $$1("#video-form").hide();
          } else if (value === "FilmInstance") {
            $$1("#audio-form").hide();
            $$1("#film-form").show();
            $$1("#video-form").hide();
          } else if (value === "VideoInstance") {
            $$1("#audio-form").hide();
            $$1("#film-form").hide();
            $$1("#video-form").show();
          }
        });
      },
      initInstanceBatchCheckbox() {
        $$1("#batch-checkbox").on("change", function(event) {
          $$1("#fileName").attr("readonly", $$1(this).is(":checked"));
          $$1("#fileName").val("");
        });
      },
      initTransfersNewButton() {
        $$1("#transfers-new").on("click", function(event) {
          jitterbug.tableSelection.clear();
        });
      },
      initTransfersBatchMenu() {
        $$1("#transfers-batch-edit").on("click", function(event) {
          let tableSelection = jitterbug.tableSelection;
          let maxEditLimit = $$1(this).data("max-edit-limit");
          if (!jitterbug.validateBatchSelection(tableSelection, "editing", maxEditLimit)) {
            return;
          }
          jitterbug.submitBatchEditForm("transfers", tableSelection);
        });
        jitterbug.initDataExportModal("transfers");
        $$1("#transfers-batch-export").on("click", function(event) {
          let tableSelection = jitterbug.tableSelection;
          if (!jitterbug.validateBatchSelection(tableSelection, "exporting")) {
            return;
          }
          jitterbug.openDataExportModal("transfers", tableSelection);
        });
        $$1("#transfers-batch-mark").on("click", function(event) {
          let tableSelection = jitterbug.tableSelection;
          if (!jitterbug.validateBatchSelection(tableSelection, "marking", 100)) {
            return;
          }
          jitterbug.batchMark("transfers", "Transfer", tableSelection);
        });
        $$1("#transfers-batch-unmark").on("click", function(event) {
          let tableSelection = jitterbug.tableSelection;
          if (!jitterbug.validateBatchSelection(tableSelection, "unmarking", 500)) {
            return;
          }
          jitterbug.batchUnmark("transfers", "Transfer", tableSelection);
        });
        $$1("#transfers-batch-delete").on("click", function(event) {
          let tableSelection = jitterbug.tableSelection;
          if (!jitterbug.validateBatchSelection(tableSelection, "deleting", 100)) {
            return;
          }
          $$1("#confirm-batch-delete-modal").modal("toggle");
          $$1('#batch-delete-form input[name="ids"]').val(tableSelection.selectedIds());
        });
        $$1("#transfers-batch-audio-import").on("click", function(event) {
          $$1("#audio-import-modal").modal("toggle");
        });
        $$1("#transfers-batch-video-import").on("click", function(event) {
          $$1("#video-import-modal").modal("toggle");
        });
      },
      initTransferTypeControls() {
        $$1("#detail #transfer-type-controls :radio").on("click", function(event) {
          let value = $$1(this).val();
          if (value === "AudioTransfer") {
            $$1("#audio-form").show();
            $$1("#film-form").hide();
            $$1("#video-form").hide();
          } else if (value === "FilmTransfer") {
            $$1("#audio-form").hide();
            $$1("#film-form").show();
            $$1("#video-form").hide();
          } else if (value === "VideoTransfer") {
            $$1("#audio-form").hide();
            $$1("#film-form").hide();
            $$1("#video-form").show();
          }
        });
      },
      initTransferCallNumberQuery() {
        $$1("#preservation-instance-id").on("change", function() {
          let preservationInstanceId = $$1("#preservation-instance-id").val();
          if (preservationInstanceId.length) {
            let query = {};
            query["preservation-instance-id"] = preservationInstanceId;
            $$1.get("/call-numbers/for-pm", query, function(data) {
              $$1("#call-number").val(data["callNumber"]);
            }).fail(function() {
              console.log("Could not resolve PM to a call number.");
              $$1("#call-number").val("");
            });
          } else {
            $$1("#call-number").val("");
          }
        });
      },
      initBatchDeleteForm() {
        $$1('#batch-delete-form button[type="submit"]').on("click", function() {
          $$1(this).attr("clicked", "true");
        });
        $$1("#batch-delete-form").submit(function(event) {
          jitterbug.tableSelection.clear();
          jitterbug.tableParams.setPage(1);
          let submitButtons = $$1(this).find('button[type="submit"]');
          let deleteCommand = $$1(this).find('button[type="submit"][clicked="true"]').val();
          $$1(this).find('input[name="deleteCommand"]').val(deleteCommand);
          submitButtons.attr("disabled", true);
        });
      },
      initAudioImportModal() {
        jitterbug.initDataUploadForm("audio");
        jitterbug.initDataImportForm("audio");
        $$1("#audio-import-modal .reset").on("click", function(event) {
          event.preventDefault();
          jitterbug.resetDataImportModal("audio");
        });
        $$1("#audio-import-modal").on("hide.bs.modal", function() {
          jitterbug.resetDataImportModal("audio");
          if (jitterbug.dataImported) {
            location.reload();
          }
        });
      },
      initVideoImportModal() {
        jitterbug.initDataUploadForm("video");
        jitterbug.initDataImportForm("video");
        $$1("#video-import-modal .reset").on("click", function(event) {
          event.preventDefault();
          jitterbug.resetDataImportModal("video");
        });
        $$1("#video-import-modal").on("hide.bs.modal", function() {
          jitterbug.resetDataImportModal("video");
          if (jitterbug.dataImported) {
            location.reload();
          }
        });
      },
      initFileSelect() {
        $$1(":file").on("change", function() {
          let input = $$1(this), fileName = input.val().replace(/\\/g, "/").replace(/.*\//, "");
          input.trigger("fileselect", fileName);
        });
        $$1("#items-import-file").on("fileselect", function(event, fileName) {
          $$1("#items-import-filename").val(fileName);
        });
        $$1("#audio-import-file").on("fileselect", function(event, fileName) {
          $$1("#audio-import-filename").val(fileName);
        });
        $$1("#video-import-file").on("fileselect", function(event, fileName) {
          $$1("#video-import-filename").val(fileName);
        });
      },
      resetDataImportModal(type) {
        $$1("#" + type + "-import-file").val("");
        $$1("#" + type + "-import-filename").val("");
        $$1("#" + type + "-upload-form-error").html("").hide();
        $$1("#" + type + "-import-dialog").width(400);
        $$1("#" + type + "-import-dialog-content").width(400);
        $$1("#" + type + "-import-step-2 .modal-body").height(80);
        $$1("#" + type + "-import-step-2").show();
        $$1("#" + type + "-import-step-2 .modal-body").scrollTop(0);
        $$1("#" + type + "-import-step-2 .modal-body").scrollLeft(0);
        $$1("#" + type + "-import-step-1").show();
        $$1("#" + type + "-import-step-2").hide();
        $$1("#" + type + "-import-step-2 .success-actions").show();
        $$1("#" + type + "-import-step-2 .failure-actions").hide();
        $$1("#" + type + "-import-step-3").show();
        $$1("#" + type + "-import-step-3 .modal-body").scrollTop(0);
        $$1("#" + type + "-import-step-3 .modal-body").scrollLeft(0);
        $$1("#" + type + "-import-step-3").hide();
      },
      initDataUploadForm(type) {
        jitterbug.initFileSelect();
        $$1("#" + type + "-upload-form").submit(function(event) {
          event.preventDefault();
          if (!jitterbug.validateDataUploadForm(type)) {
            return;
          }
          $$1("#" + type + "-upload-spinner").show();
          let form = new FormData(this);
          $$1.ajax({
            url: $$1(this).attr("action"),
            type: "post",
            data: form,
            processData: false,
            contentType: false,
            success: function(data) {
              console.log("upload success");
              let count = data["count"];
              if (count === 0) {
                $$1("#" + type + "-import-step-2 .success-actions").hide();
                $$1("#" + type + "-import-step-2 .failure-actions").show();
              }
              $$1("#" + type + "-import-dialog").width(700);
              $$1("#" + type + "-import-dialog-content").width(700);
              let delay = 500;
              setTimeout(function() {
                $$1("#" + type + "-import-step-1").hide();
                $$1("#" + type + "-import-step-2").show();
                $$1("#" + type + "-import-step-2 .modal-body").height(300);
              }, delay);
              $$1("#" + type + "-upload-data-container").replaceWith(data["html"]);
            },
            error: function(jqXHR, textStatus, error) {
              console.log("upload failure: " + textStatus);
              if (jqXHR.status === 500) {
                $$1("#" + type + "-upload-form-error").html("<small>An error occurred               while parsing your file. Check that it's a               valid .csv file.</small>").show();
              } else {
                $$1("#" + type + "-upload-form-error").html("<small>An error occurred               while uploading your file. Refresh the page and try               again.</small>").show();
              }
            },
            complete() {
              $$1("#" + type + "-upload-spinner").hide();
            }
          });
        });
      },
      initDataImportForm(type) {
        $$1("#" + type + "-import-form").submit(function(event) {
          event.preventDefault();
          let submitButton = $$1(this).find('button[type="submit"]');
          submitButton.attr("disabled", true);
          $$1("#" + type + "-import-spinner").show();
          let form = new FormData(this);
          $$1.ajax({
            url: $$1(this).attr("action"),
            type: "post",
            data: form,
            processData: false,
            contentType: false,
            success: function(data) {
              let status = data["status"];
              $$1("#" + type + "-import-result-container").replaceWith(data["html"]);
              $$1("#" + type + "-import-step-2").hide();
              $$1("#" + type + "-import-step-3 .modal-body").height(300);
              $$1("#" + type + "-import-step-3").show();
              if (status == "success") {
                $$1("#" + type + "-import-step-3 .modal-body").height(50);
                jitterbug.dataImported = true;
              }
              jitterbug.initPopovers();
            },
            error: function(jqXHR, textStatus, error) {
              console.log("import failure: " + textStatus);
            },
            complete() {
              $$1("#" + type + "-import-spinner").hide();
              submitButton.attr("disabled", false);
            }
          });
        });
      },
      validateDataUploadForm(type) {
        if ($$1("#" + type + "-import-file").val() == "" || $$1("#" + type + "-import-filename").val() == "") {
          $$1("#" + type + "-upload-form-error").html("<small>Please select a         data file to upload.</small>").show();
          return false;
        } else if (!$$1("#" + type + "-import-filename").val().endsWith(".csv")) {
          $$1("#" + type + "-upload-form-error").html("<small>A file of type         .csv is required.</small>").show();
          return false;
        } else {
          $$1("#" + type + "-upload-form-error").html("").hide();
          return true;
        }
      },
      initDataExportModal(resource) {
        $$1("#data-export-form").submit(function(event) {
          event.preventDefault();
          let fieldCheckboxes = $$1("#data-export-fields-container").find(":checkbox"), oneIsChecked = false;
          $$1.each(fieldCheckboxes, function(i2, checkbox) {
            if ($$1(this).is(":checked")) {
              oneIsChecked = true;
              return false;
            }
          });
          if (oneIsChecked) {
            $$1("#export-instructions").removeClass("text-danger");
          } else {
            $$1("#export-instructions").addClass("text-danger");
            $$1("#data-export-modal .modal-body").scrollTop(0);
            return;
          }
          $$1("#export-building-spinner").show();
          let submitButton = $$1(this).find('button[type="submit"]');
          submitButton.attr("disabled", true);
          let form = new FormData(this);
          $$1.ajax({
            url: $$1(this).attr("action"),
            type: "post",
            data: form,
            processData: false,
            contentType: false,
            success: function(data) {
              let form2 = $$1(document.createElement("form"));
              form2.attr("action", "/" + resource + "/batch/export-download");
              form2.attr("method", "post");
              $$1("<input>").attr("type", "hidden").attr("name", "_token").attr("value", $$1('meta[name="csrf-token"]').attr("content")).appendTo(form2);
              form2.appendTo(document.body).submit().remove();
              $$1("#export-building-spinner").hide();
              $$1("#data-export-modal .modal-body").scrollTop(0);
              $$1("#data-export-modal").modal("toggle");
              submitButton.attr("disabled", false);
            },
            error: function(jqXHR, textStatus, error) {
              console.log("Export failed: " + error);
            }
          });
        });
        $$1("#data-export-modal").on("hidden.bs.modal", function() {
          $$1(".export-modal-body").height(40);
        });
      },
      openDataExportModal(resource, tableSelection) {
        $$1("#data-export-modal").modal("toggle");
        $$1("#loading-export-fields-spinner").show();
        $$1.ajax({
          url: "/" + resource + "/batch/export-fields",
          type: "post",
          data: { "ids": tableSelection.selectedIds().toString() },
          success: function(data) {
            $$1("#data-export-fields-container").replaceWith(data);
            let delay = 200;
            setTimeout(function() {
              $$1(".export-modal-body").height(220);
            }, delay);
            $$1('#data-export-form input[name="ids"]').val(
              tableSelection.selectedIds()
            );
            jitterbug.initSelectAll("#checkedAll", ".checkSingle");
          },
          error: function(jqXHR, textStatus, error) {
            console.log("Could not fetch export fields: " + error);
          },
          complete() {
            $$1("#loading-export-fields-spinner").hide();
          }
        });
      },
      validateBatchSelection(tableSelection, action, max) {
        if (tableSelection.count() === 0) {
          jitterbug.displayAlert(
            "warning",
            "<strong>Here's a tip:</strong> Batch actions require a table                 selection. Make a selection by 'shift-clicking'                 or 'command-clicking' on rows of the table."
          );
          return false;
        }
        if (tableSelection.count() === 1 && action !== "exporting") {
          jitterbug.displayAlert(
            "warning",
            "<strong>More please!</strong> Batch actions require at least                 2 records to be selected. Make a selection by                 'shift-clicking' or 'command-clicking' on rows of the table."
          );
          return false;
        }
        if (tableSelection.count() > max) {
          jitterbug.displayAlert(
            "warning",
            "<strong>Whoa there!</strong> Batch " + action + " is limited         to " + max + " records at a time. Please narrow your selection."
          );
          return false;
        }
        return true;
      },
      submitBatchEditForm(resource, tableSelection) {
        let form = $$1(document.createElement("form"));
        form.attr("action", "/" + resource + "/batch/edit");
        form.attr("method", "post");
        $$1("<input>").attr("type", "hidden").attr("name", "ids").attr("value", tableSelection.selectedIds()).appendTo(form);
        $$1("<input>").attr("type", "hidden").attr("name", "_token").attr("value", $$1('meta[name="csrf-token"]').attr("content")).appendTo(form);
        form.appendTo(document.body).submit().remove();
      },
      initMarkRibbon() {
        $$1(".mark").on("click", function(event) {
          let mark = $$1(this);
          let data = {};
          data["markableType"] = mark.data("markable-type");
          data["markableIds"] = [mark.data("markable-id")];
          if (mark.hasClass("marked")) {
            data["_method"] = "DELETE";
            $$1.post("/marks", data, function(data2) {
              mark.removeClass("marked");
            });
          } else {
            $$1.post("/marks", data, function(data2) {
              mark.addClass("marked");
            });
          }
        });
      },
      batchMark(resourceName, type, tableSelection) {
        let data = {};
        data["markableType"] = type;
        data["markableIds"] = tableSelection.selectedIds();
        $$1.post("/marks", data, function(data2) {
          $$1("#" + resourceName + '-data tr[role="button"]').each(function() {
            let id = $$1(this).data("id");
            if ($$1.inArray(id, tableSelection.selectedIds()) !== -1) {
              $$1(this).addClass("marked");
            }
          });
        });
      },
      batchUnmark(resourceName, type, tableSelection) {
        let data = {};
        data["markableType"] = type;
        data["markableIds"] = tableSelection.selectedIds();
        data["_method"] = "DELETE";
        $$1.post("/marks", data, function(data2) {
          $$1("#" + resourceName + '-data tr[role="button"]').each(function() {
            let id = $$1(this).data("id");
            if ($$1.inArray(id, tableSelection.selectedIds()) !== -1) {
              $$1(this).removeClass("marked");
            }
          });
        });
      },
      initPopovers() {
        $$1('[data-bs-toggle="popover"]').popover();
      },
      initDatepicker() {
        flatpickr(".input-group.date", {
          allowInput: true,
          dateFormat: "Y-m-d",
          wrap: true
        });
      },
      // When a user batch edits records, some form fields will
      // be set to a value of <mixed>, meaning that those
      // fields differ across the batch. When a user
      // changes one of the <mixed> fields to something
      // else, we want to give them an easy way to reset
      // the field back to the magic value, which we will
      // do with the addition of a 'reset' icon after they
      // have changed the value.
      initBatchEditMixed() {
        $$1("input[value='<mixed>']").on("change", function() {
          jitterbug.handleMixedValueChange(this);
        });
        $$1("textarea").filter(function() {
          return $$1(this).val() === "<mixed>";
        }).on("change", function() {
          jitterbug.handleMixedValueChange(this);
        });
        $$1('select:has(option[value="<mixed>"]:selected)').on("change", function() {
          jitterbug.handleMixedValueChange(this);
        });
      },
      sequence: 0,
      handleMixedValueChange(that) {
        let input = $$1(that);
        let parent = $$1(that).closest(".detail-value");
        if ($$1(that).val() !== "<mixed>" && parent.hasClass("col-xs-7")) {
          parent.removeClass("col-xs-7");
          parent.addClass("col-xs-6");
          let divId = jitterbug.sequence++, linkId = jitterbug.sequence++;
          parent.after("        <div id=" + divId + ' class="col-xs-1 detail-value">          <a id=' + linkId + ' href="#" title="Reset">            <i class="fa fa-reply" aria-hidden="true"></i>          </a>        </div>      ');
          $$1("#" + linkId).on("click", function(event) {
            $$1("#" + divId).remove();
            parent.removeClass("col-xs-6");
            parent.addClass("col-xs-7");
            input.val("<mixed>");
            event.preventDefault();
          });
        } else if ($$1(that).val() === "<mixed>" && parent.hasClass("col-xs-6")) {
          parent.next().remove();
          parent.removeClass("col-xs-6");
          parent.addClass("col-xs-7");
        }
      },
      initTableKeyboardShortcuts() {
        $$1(document).keydown(function(event) {
          if ($$1("#search").is(":focus") && $$1("#search").val() != "") {
            return;
          }
          let modalOpen = false;
          $$1(".modal").each(function() {
            if ($$1(this).is(":visible")) {
              modalOpen = true;
              return false;
            }
          });
          if (!modalOpen) {
            if (event.which == 39) {
              $$1(".next-page").first().trigger("click");
            } else if (event.which == 37) {
              $$1(".prev-page").first().trigger("click");
            } else if (event.which === 65 && (event.ctrlKey || event.metaKey)) {
              event.preventDefault();
              jitterbug.tableSelection.selectAll();
            } else if (event.which === 27) {
              jitterbug.tableSelection.clear();
              jitterbug.tableSelection.render();
            }
          }
        });
      },
      initRevisionHistory() {
        $$1(".revision-history-title").on("click", function(event) {
          event.preventDefault();
          let icon = $$1(".revision-history-title i");
          if (icon.hasClass("fa-caret-right")) {
            icon.removeClass("fa-caret-right");
            icon.addClass("fa-caret-down");
          } else {
            icon.removeClass("fa-caret-down");
            icon.addClass("fa-caret-right");
          }
          $$1(".revision-history").slideToggle(200);
        });
      },
      initRelatedPreservationInstances() {
        $$1('#related-instances tr[role="button"]').on("click", function(event) {
          window.location.href = "/instances/" + $$1(this).data("id");
        });
      },
      initRelatedCuts() {
        $$1('#related-cuts tr[role="button"]').on("click", function(event) {
          window.location.href = "/cuts/" + $$1(this).data("id") + "?instanceId=" + $$1(this).data("instance");
        });
      },
      initRelatedTransfers() {
        $$1('#related-transfers tr[role="button"]').on("click", function(event) {
          window.location.href = "/transfers/" + $$1(this).data("id");
        });
      },
      initIndexPage(resourceName) {
        let searchField = jitterbug.SearchField.load(resourceName + "SearchField");
        if (searchField == null) {
          searchField = jitterbug.SearchField({
            key: resourceName + "SearchField",
            selector: "#search"
          });
          searchField.init();
          searchField.store();
        } else {
          searchField.init();
        }
        jitterbug.searchField = searchField;
        let filterPanel = jitterbug.FilterPanel.load(resourceName + "FilterPanel");
        if (filterPanel == null) {
          filterPanel = jitterbug.FilterPanel({
            key: resourceName + "FilterPanel",
            selector: "#filter-panel",
            listSelector: ".filter-list"
          });
          filterPanel.init();
          filterPanel.store();
        } else {
          filterPanel.init();
        }
        jitterbug.filterPanel = filterPanel;
        let tableParams = jitterbug.TableParams.load(resourceName + "TableParams");
        if (tableParams == null) {
          tableParams = jitterbug.TableParams({
            key: resourceName + "TableParams"
          });
          tableParams.store();
        }
        jitterbug.tableParams = tableParams;
        let tableSelection = jitterbug.TableSelection.load(resourceName + "TableSelection", "session");
        if (tableSelection == null) {
          tableSelection = jitterbug.TableSelection({
            key: resourceName + "TableSelection",
            resource: resourceName,
            location: "session",
            selector: "#" + resourceName + '-data tr[role="button"]',
            countSelector: "#data-panel .selection-count"
          });
          tableSelection.init();
          tableSelection.store();
        } else {
          tableSelection.init();
          tableSelection.render();
        }
        jitterbug.tableSelection = tableSelection;
        let queryManager = jitterbug.QueryManager(
          searchField,
          filterPanel,
          tableParams,
          tableSelection,
          resourceName
        );
        jitterbug.tableSelection.setQueryManager(queryManager);
        queryManager.init();
        queryManager.executeQuery();
        jitterbug.queryManager = queryManager;
      },
      initItemsIndex() {
        jitterbug.initIndexPage("items");
      },
      initInstancesIndex() {
        jitterbug.initIndexPage("instances");
      },
      initTransfersIndex() {
        jitterbug.initIndexPage("transfers");
      },
      QueryManager(searchFieldInstance, filterPanelInstance, tableParamsInstance, tableSelectionInstance, resourceName) {
        let searchField = searchFieldInstance, filterPanel = filterPanelInstance, tableSelection = tableSelectionInstance, tableParams = tableParamsInstance, resource = resourceName;
        let init = function() {
          $$1.subscribe("filterPanelChanged", handleFilterPanelChanged);
          $$1.subscribe("searchSubmitted", handleSearchSubmitted);
        };
        let handleFilterPanelChanged = function() {
          tableSelection.clear();
          tableParams.setPage(1);
          executeQuery();
        };
        let handleSearchSubmitted = function(event) {
          tableSelection.clear();
          tableParams.setPage(1);
          executeQuery();
        };
        let queryString = function() {
          let query = {};
          query["search"] = searchField.elementValue();
          query = $$1.extend(query, filterPanel.selectedFilters());
          return JSON.stringify(query);
        };
        let executeQuery = function(sortColumn = "updatedAt", sortDirection = "desc") {
          let query = {};
          query["q"] = encodeURIComponent(queryString());
          query["page"] = tableParams.getPage();
          query["perPage"] = tableParams.getPerPage();
          query["sortColumn"] = sortColumn;
          query["sortDirection"] = sortDirection;
          $$1.get("/" + resource, query, function(data) {
            $$1("#data-container").replaceWith(data);
            let dataSelector = "#" + resource + "-data";
            $$1(dataSelector).colResizable(
              { partialRefresh: true, postbackSafe: true, removePadding: false }
            );
            tableSelection.init();
            $$1.publish("dataLoaded");
            $$1(dataSelector + ' tr[role="button"]').on("click", function(event) {
              tableSelection.clear();
              tableSelection.render();
              window.location.href = "/" + resource + "/" + $$1(this).data("id");
            });
            $$1("#header-row").on("click", function(e) {
              e.preventDefault();
              const column = e.target;
              const columnName = column.getAttribute("data-sort-column");
              const currentSort = column.getAttribute("data-sort-direction");
              if (columnName !== null && currentSort !== null) {
                const toggleSort = currentSort === "asc" ? "desc" : "asc";
                tableSelection.clear();
                tableParams.setPage(1);
                executeQuery(columnName, toggleSort);
              }
            });
            if ($$1(".pagination").length) {
              let currentPage = parseInt($$1(".page-item.active").text().trim());
              tableParams.setPage(currentPage);
              $$1(".pagination").each(function() {
                $$1(".page-link").each(function() {
                  if ($$1(this).parent().hasClass("disabled") || $$1(this).parent().hasClass("active")) {
                    return;
                  } else if ($$1(this).hasClass("prev-page")) {
                    $$1(this).on("click", function(event) {
                      event.preventDefault();
                      tableParams.setPage(currentPage - 1);
                      executeQuery(sortColumn, sortDirection);
                    });
                  } else if ($$1(this).hasClass("next-page")) {
                    $$1(this).on("click", function(event) {
                      event.preventDefault();
                      tableParams.setPage(currentPage + 1);
                      executeQuery(sortColumn, sortDirection);
                    });
                  } else {
                    $$1(this).on("click", function(event) {
                      event.preventDefault();
                      tableParams.setPage($$1(this).text().trim());
                      executeQuery(sortColumn, sortDirection);
                    });
                  }
                });
              });
            }
          });
        };
        return {
          init,
          executeQuery,
          queryString
        };
      },
      TableParams(params) {
        let key2 = params.key, location2 = params.location, page = params.page == null ? 1 : params.page, perPage = params.perPage == null ? 20 : params.perPage;
        let allParams = function() {
          return {
            page,
            perPage
          };
        };
        let getPage = function() {
          return page;
        };
        let setPage = function(pageNum) {
          page = pageNum;
          store();
        };
        let getPerPage = function() {
          return perPage;
        };
        let setPerPage = function(perPageNum) {
          perPage = perPageNum;
          store();
        };
        let store = function() {
          if (key2 != null) {
            if (location2 == NaN || location2 == null) {
              localStorage.setItem(key2, toString());
            } else if (location2 == NaN) {
              sessionStorage.setItem(key2, toString());
            }
          }
        };
        let toJson = function() {
          return {
            key: key2,
            location: location2,
            page,
            perPage
          };
        };
        let toString = () => JSON.stringify(toJson());
        return {
          allParams,
          getPage,
          setPage,
          getPerPage,
          setPerPage,
          store,
          toString
        };
      },
      SearchField(params) {
        if (params == null || params.selector == null) {
          throw jitterbug.IllegalArgumentException("Param 'selector' is required.");
        }
        let key2 = params.key, location2 = params.location, selector = params.selector, value = params.value, lastValue = params.lastValue;
        let init = function() {
          $$1(selector).val(value);
          if (value !== "") {
            $$1(selector).next().find("i").show();
          }
          let clearLink = $$1(selector).next().find("a");
          clearLink.on("click", function(event) {
            event.preventDefault();
            $$1(selector).next().find("i").hide();
            $$1(selector).val("");
            $$1(selector).focus();
            store();
            $$1.publish("searchSubmitted");
          });
          $$1(selector).keypress(function(event) {
            if (enterKey(event)) {
              event.preventDefault();
              lastValue = elementValue();
              store();
              $$1.publish("searchSubmitted");
            }
          });
          $$1(selector).keyup(function(event) {
            if (deleteKey(event)) {
              if (searchTermsRemoved()) {
                store();
                $$1.publish("searchSubmitted");
              }
              lastValue = elementValue();
              if (elementValue() === "") {
                $$1(selector).next().find("i").hide();
              }
            } else {
              if (elementValue() !== "") {
                $$1(selector).next().find("i").show();
              }
            }
          });
        };
        let enterKey = function(event) {
          return event.which === 13;
        };
        let deleteKey = function(event) {
          return event.keyCode === 8;
        };
        let searchTermsRemoved = function() {
          return lastValue != null && lastValue !== "" && elementValue() === "";
        };
        let elementValue = function() {
          return $$1(selector).val();
        };
        let store = function() {
          if (key2 != null) {
            if (location2 === "local" || location2 == null) {
              localStorage.setItem(key2, toString());
            } else if (location2 === "session") {
              sessionStorage.setItem(key2, toString());
            }
          }
        };
        let toJson = function() {
          return {
            key: key2,
            location: location2,
            selector,
            lastValue,
            value: elementValue()
          };
        };
        let toString = function() {
          return JSON.stringify(toJson());
        };
        return {
          init,
          elementValue,
          store,
          toString
        };
      },
      /**
       * A FilterPanel is composed of one or more FilterLists, instantiated
       * when the FilterPanel.init() method is called.
       */
      FilterPanel(params) {
        if (params == null || params.selector == null || params.listSelector == null) {
          throw jitterbug.IllegalArgumentException("Params 'selector' and 'listSelector' are required.");
        }
        let key2 = params.key, location2 = params.location, selector = params.selector, listSelector = params.listSelector, selected = params.selectedFilters, lists = [];
        let init = () => {
          $$1(selector).find(listSelector).each(function() {
            let list = jitterbug.FilterList(this);
            list.init();
            if (selected != null && selected[list.listType()] != null) {
              list.setSelected(selected[list.listType()]);
            } else {
              list.setDefault();
            }
            lists.push(list);
          });
          $$1.subscribe("filterChanged", handleFilterChanged);
        };
        let handleFilterChanged = () => {
          store();
          $$1.publish("filterPanelChanged");
        };
        let setDefault = () => {
          $$1.each(lists, function(i2, list) {
            list.setDefault();
          });
        };
        let filterLists = () => lists;
        let selectedFilters = () => {
          let allSelected = {};
          if (!lists.length) {
            $$1(selector).find(listSelector).each(function() {
              let list = jitterbug.FilterList(this);
              lists.push(list);
            });
          }
          $$1.each(lists, function(i2, list) {
            allSelected[list.listType()] = list.selectedFilters();
          });
          return allSelected;
        };
        let store = () => {
          if (key2 != null) {
            if (location2 === "local" || location2 == null) {
              localStorage.setItem(key2, toString());
            } else if (location2 === "session") {
              sessionStorage.setItem(key2, toString());
            }
          }
        }, toJson = function() {
          return {
            key: key2,
            location: location2,
            selector,
            listSelector,
            selectedFilters: selectedFilters()
          };
        }, toString = function() {
          return JSON.stringify(toJson());
        };
        return {
          init,
          setDefault,
          filterLists,
          selectedFilters,
          store,
          toString
        };
      },
      FilterList(listElement) {
        let list = listElement, checkboxes = $$1(list).find(":checkbox"), radioButtons = $$1(list).find(":radio"), init = function() {
          $$1.each(checkboxes, function(i2, checkbox) {
            $$1(checkbox).on("click", function(event) {
              if ($$1(this).is(checkboxes[0])) {
                if (!$$1(this).is(":checked")) {
                  event.preventDefault();
                  return false;
                }
                for (let i3 = 1; i3 < checkboxes.length; i3++) {
                  checkboxes[i3].checked = false;
                }
              } else {
                let oneIsChecked = false;
                for (let i3 = 1; i3 < checkboxes.length; i3++) {
                  if (checkboxes[i3].checked) {
                    oneIsChecked = true;
                    break;
                  }
                }
                if (oneIsChecked) {
                  checkboxes[0].checked = false;
                } else {
                  checkboxes[0].checked = true;
                }
              }
              renderSelectionCount();
              $$1.publish("filterChanged");
            });
          });
          $$1.each(radioButtons, function(i2, radioButton) {
            $$1(radioButton).on("click", function(event) {
              $$1.publish("filterChanged");
            });
          });
        };
        let setSelected = (selectedFilters2) => {
          let totalChecked = 0;
          $$1.each(checkboxes, function(i2, checkbox) {
            if ($$1.inArray(checkbox.value, selectedFilters2) !== -1) {
              checkbox.checked = true;
              totalChecked++;
            } else {
              checkbox.checked = false;
            }
          });
          if (totalChecked !== selectedFilters2.length) {
            setDefault();
          }
          $$1.each(radioButtons, function(i2, radioButton) {
            radioButton.checked = $$1.inArray(radioButton.value, selectedFilters2) !== -1;
          });
          renderSelectionCount();
        };
        let setDefault = () => {
          $$1.each(checkboxes, function(i2) {
            checkboxes[i2].checked = i2 === 0;
          });
          if (radioButtons.length) {
            radioButtons[0].checked = true;
          }
        };
        let listType = () => $$1(list).attr("id");
        let selectedFilters = () => {
          let selected = $$1(list).find("input:checked");
          let values = [];
          for (let i2 = 0; i2 < selected.length; i2++) {
            values.push(selected[i2].value);
          }
          return values;
        };
        let count = () => {
          if (selectedFilters()[0] === 0) {
            return 0;
          } else {
            return selectedFilters().length;
          }
        };
        let scrollable = () => $$1(list).height() < list.scrollHeight;
        let renderSelectionCount = () => {
          if (scrollable()) {
            let countSelector = "#" + listType() + "-selection-count";
            if (count() > 0) {
              $$1(countSelector).html(count() + ' selected <a id="' + listType() + '-clear-selection" href="#" style="color: #fff">                <i class="fa fa-times-circle" aria-hidden="true"></i>              </a>');
              $$1("#" + listType() + "-clear-selection").on("click", function(event) {
                event.preventDefault();
                setSelected(["0"]);
                $$1.publish("filterChanged");
              });
            } else {
              $$1(countSelector).html("");
            }
          }
        };
        return {
          init,
          setDefault,
          setSelected,
          listType,
          selectedFilters
        };
      },
      /**
       * A TableSelection models a user's selection of multiple
       * rows of a table created by 'shift-clicking' or 'command-clicking'
       * on the rows to make the selection, rather than using form
       * checkboxes.
       *
       * Rows of the table must have the data attributes 'data-index'
       * and 'data-id' on them that reflects the index of the record
       * in the table and the id of the record in the database,
       * respectively.
       *
       * If storage parameters are supplied (storage key and location),
       * the table selection will persist itself to local storage when
       * the selection changes.
       *
       * Constructor params are as follows:
       * 'key' = storage key under which the serialized selection is stored
       * 'location' = Storage location (can be 'session' or 'local')
       * 'resource' = The type of entity being displayed in the table
       * 'selector' = jQuery selector for the table rows *required
       * 'countSelector' = jQuery selector for the element containing
       *  the count of selected items
       * 'beginIndex' = Beginning index of the selection range
       * 'beginId' = Database id for the record at beginIndex
       * 'ids' = Ids that are currently selected
       */
      TableSelection(params) {
        if (params == null || params.resource == null || params.selector == null || params.countSelector == null) {
          throw jitterbug.IllegalArgumentException("Params 'resource', 'selector' and 'countSelector' are required.");
        }
        let key2 = params.key, location2 = params.location, resource = params.resource, selector = params.selector, countSelector = params.countSelector, beginIndex = params.beginIndex, beginId = params.beginId, ids = params.ids != null ? params.ids : [], queryManager = null, cache = {}, init = function() {
          $$1.unsubscribe("dataLoaded");
          let dataTableRows = $$1(selector);
          dataTableRows.on("selectstart dragstart", function(event) {
            event.preventDefault();
          });
          dataTableRows.on("click", function(event) {
            let index = $$1(this).data("index");
            let id = $$1(this).data("id");
            const sortColumn = $$1(this).closest("table").data("sort-column");
            const sortDirection = $$1(this).closest("table").data("sort-direction");
            if (event.shiftKey) {
              resolveRange(index, id, sortColumn, sortDirection);
              finalizeEvent(event);
              return;
            }
            if (event.ctrlKey || event.metaKey) {
              toggle(id);
              finalizeEvent(event);
            }
          });
          $$1.subscribe("dataLoaded", jitterbug.dataLoaded);
        };
        let finalizeEvent = (event) => {
          store();
          render();
          event.stopImmediatePropagation();
        };
        let selected = (id) => {
          return $$1.inArray(id, ids) !== -1;
        };
        let render = () => {
          $$1(selector).each(function() {
            let id = $$1(this).data("id");
            if (selected(id)) {
              $$1(this).addClass("selected");
            } else {
              $$1(this).removeClass("selected");
            }
          });
          if (count() > 0) {
            $$1(countSelector).html(count() + ' selected <a id="clear-selection" href="#" style="color: #fff">                        <i class="fa fa-times-circle" aria-hidden="true"></i>                      </a>');
            $$1("#clear-selection").on("click", function(event) {
              event.preventDefault();
              clear();
              render();
            });
          } else {
            $$1(countSelector).html("");
          }
        };
        let resolveRange = (endIndex, endId, sortColumn, sortDirection) => {
          if (beginIndex == null && beginId == null) {
            beginIndex = endIndex;
            beginId = endId;
            ids = [beginId];
          } else {
            let beforeCount = count();
            if (rangeInTable(beginIndex, endIndex)) {
              console.log("Getting range from table: " + beginIndex + " " + endIndex);
              ids = idsFromTable(beginIndex, endIndex);
            } else if (rangeInCache(beginIndex, endIndex)) {
              console.log("Getting range from cache: " + beginIndex + " " + endIndex);
              ids = idsFromCache(beginIndex, endIndex);
            } else {
              if (queryManager != null) {
                console.log("Getting range from server");
                let query = {};
                query["q"] = encodeURIComponent(queryManager.queryString());
                let range = JSON.stringify({
                  beginIndex,
                  beginId,
                  endIndex,
                  endId
                });
                query["r"] = encodeURIComponent(range);
                query["sortColumn"] = sortColumn;
                query["sortDirection"] = sortDirection;
                $$1.ajax({
                  url: "/" + resource + "/resolve-range",
                  data: query,
                  success(data) {
                    ids = data["ids"].map(Number);
                    store();
                    render();
                  },
                  statusCode: {
                    400() {
                      jitterbug.displayAlert(
                        "danger",
                        "<strong>Sorry to interrupt!</strong> It appears someone                                         has changed the data you're viewing. Please reload the                                         page and try your selection again."
                      );
                      clear();
                      render();
                    }
                  },
                  error() {
                    console.log("Could not resolve selection range");
                  }
                });
              } else {
                console.log("QueryManager is null.               Could not resolve selection range");
              }
            }
            if (count() === 1 && beforeCount === 1 && beginIndex === endIndex) {
              clear();
            }
          }
        };
        let rangeInTable = (begin, end) => {
          let table = tableToObject();
          return table[begin] != null && table[end] != null;
        };
        let idsFromTable = (begin, end) => {
          let first = Math.min(begin, end), last = Math.max(begin, end);
          let tableIds = [];
          $$1(selector).each(function() {
            let thisIndex = $$1(this).data("index"), thisId = $$1(this).data("id");
            if (thisIndex >= first && thisIndex <= last) {
              tableIds.push(thisId);
            }
          });
          return tableIds;
        };
        let rangeInCache = (begin, end) => {
          let first = Math.min(begin, end), last = Math.max(begin, end);
          for (let i2 = first; i2 <= last; i2++) {
            if (cache[i2] == null) {
              return false;
            }
          }
          return true;
        };
        let idsFromCache = (begin, end) => {
          let first = Math.min(begin, end), last = Math.max(begin, end), cacheIds = [];
          for (let i2 = first; i2 <= last; i2++) {
            cacheIds.push(cache[i2]);
          }
          return cacheIds;
        };
        let tableToObject = () => {
          let table = {};
          $$1(selector).each(function() {
            table[$$1(this).data("index")] = $$1(this).data("id");
          });
          return table;
        };
        let toggle = (id) => {
          let result = $$1.inArray(id, ids);
          if (result === -1) {
            ids.push(id);
          } else {
            ids.splice(result, 1);
          }
          if (jitterbug.count() === 0) {
            jitterbug.clear();
          }
        };
        let setQueryManager = (manager) => queryManager = manager;
        let selectAll = function() {
          let max = 3e3;
          let total = parseInt($$1(".record-count").text().trim().split(/\s+/)[0]);
          if (total > max) {
            jitterbug.displayAlert(
              "warning",
              "<strong>Sorry!</strong> That's too many records to select at                     once. Please narrow your search to less than " + max + " records."
            );
          } else {
            beginIndex = 0;
            let endIndex = total - 1;
            resolveRange(endIndex, null);
            if (rangeInTable(beginIndex, endIndex) || rangeInCache(beginIndex, endIndex)) {
              store();
              render();
            }
            for (let i2 = beginIndex; i2 <= endIndex; i2++) {
              cache[i2] = ids[i2];
            }
          }
        };
        let selectedIds = () => ids;
        let clear = () => {
          beginIndex = null;
          beginId = null;
          ids = [];
          cache = {};
          store();
        };
        let count = () => ids.length;
        let store = () => {
          if (key2 != null) {
            if (location2 === "local" || location2 == null) {
              localStorage.setItem(key2, toString());
            } else if (location2 === "session") {
              sessionStorage.setItem(key2, toString());
            }
          }
        };
        let toJson = () => {
          return {
            key: key2,
            location: location2,
            resource,
            selector,
            countSelector,
            beginIndex,
            beginId,
            ids
          };
        };
        let toString = () => JSON.stringify(toJson());
        return {
          init,
          selected,
          render,
          clear,
          selectedIds,
          selectAll,
          count,
          setQueryManager,
          store,
          toJson,
          toString
        };
      },
      MarksModule(params) {
        if (params == null || params.marksContainer == null || params.marksSelector == null || params.noMarksSelector == null || params.filtersSelector == null || params.usersSelector == null || params.selectedUserSelector == null) {
          throw jitterbug.IllegalArgumentException("Params 'marksContainer', 'marksSelector', 'noMarksSelector', 'filtersSelector', 'usersSelector' and 'selectedUserSelector' are required.");
        }
        let key2 = params.key, location2 = params.location, marksContainer = params.marksContainer, marksSelector = params.marksSelector, noMarksSelector = params.noMarksSelector, filtersSelector = params.filtersSelector, usersSelector = params.usersSelector, selectedUserSelector = params.selectedUserSelector, currentFilter = params.currentFilter, selectedUserId = params.selectedUserId;
        let init = () => {
          if (!selectedUserIdPresent()) {
            selectedUserId = currentUser().id;
          }
          $$1(filtersSelector).on("click", function(event) {
            event.preventDefault();
            currentFilter = $$1(this).data("filter");
            updateFilterHighlighting();
            deselectAllMarks();
            store();
            render();
          });
          $$1(usersSelector).on("click", function(event) {
            event.preventDefault();
            selectedUserId = $$1(this).data("user-id");
            store();
            getMarks();
          });
          if (currentFilter == null) {
            currentFilter = "all";
            $$1(filtersSelector).first().addClass("active");
          } else {
            updateFilterHighlighting();
          }
          $$1(".delete-marks button").on("click", function() {
            let size = $$1("input.delete-checkbox:checkbox:checked").length;
            if (confirm("Are you sure you want to delete " + size + " marks?")) {
              deleteMarks();
            }
          });
          getMarks();
        };
        let updateFilterHighlighting = () => {
          $$1(filtersSelector).each(function() {
            if (currentFilter === $$1(this).data("filter")) {
              $$1(this).addClass("active");
            } else {
              $$1(this).removeClass("active");
            }
          });
        };
        let getMarks = () => {
          let query = {};
          query["id"] = selectedUserId;
          $$1.get("/dashboard/marks-for-user", query, function(data) {
            $$1(marksContainer).replaceWith(data);
            link();
            toggleSelectAllVisibility(selectedUserId);
            render();
            let selectedUserFullName = selectedUserName();
            let truncatedUser = selectedUserFullName.length > 13 ? selectedUserFullName.substr(0, 13) + "..." : selectedUserFullName;
            $$1(selectedUserSelector).text(truncatedUser);
            jitterbug.initSelectAll("#mark-checkbox-all", ".delete-checkbox:visible");
          });
        };
        let deleteMarks = () => {
          let marksToDelete = {};
          $$1("input.delete-checkbox:checkbox:checked").each(function() {
            let parent = $$1(this).parent();
            let markId = parent.data("object-id");
            let type = parent.data("object-type");
            if (marksToDelete[type] === void 0) {
              marksToDelete[type] = [markId];
            } else {
              marksToDelete[type].push(markId);
            }
          });
          let keys = Object.keys(marksToDelete);
          for (let index in keys) {
            key2 = keys[index];
            let markableType;
            if (key2 === "item") {
              markableType = "AudioVisualItem";
            } else if (key2 === "instance") {
              markableType = "PreservationInstance";
            } else if (key2 === "transfer") {
              markableType = "Transfer";
            }
            let data = {};
            data["markableType"] = markableType;
            data["markableIds"] = marksToDelete[key2];
            data["_method"] = "DELETE";
            $$1.post("/marks", data, function(data2) {
              getMarks();
            });
          }
        };
        let link = () => {
          $$1(marksSelector).on("click", function(event) {
            let type = $$1(this).data("object-type"), id = $$1(this).data("object-id");
            window.location.href = "/" + type + "s/" + id;
          });
          $$1(".delete-checkbox").on("click", function(event) {
            event.stopImmediatePropagation();
          });
        };
        let deselectAllMarks = () => {
          $$1("#mark-checkbox-all").prop("checked", false);
          $$1(".delete-checkbox").each(function() {
            jitterbug.checked = false;
          });
        };
        let toggleSelectAllVisibility = (selectedUserId2) => {
          if (selectedUserId2 === currentUser().id) {
            $$1(".select-all").show();
            $$1(".delete-marks").show();
          } else {
            $$1(".select-all").hide();
            $$1(".delete-marks").hide();
          }
        };
        let render = () => {
          let hasOne = false;
          $$1(marksSelector).each(function() {
            if (currentFilter === "all") {
              $$1(this).show();
              hasOne = true;
              return true;
            }
            let type = $$1(this).data("object-type");
            if (currentFilter === type) {
              $$1(this).show();
              hasOne = true;
            } else {
              $$1(this).hide();
            }
          });
          if (!hasOne) {
            switch (currentFilter) {
              case "all":
                $$1(noMarksSelector).text("Marks are like shortcuts to records. Try them out!");
                break;
              case "item":
                $$1(noMarksSelector).text("No audio visual items are currently marked.");
                break;
              case "instance":
                $$1(noMarksSelector).text("No preservation instances are currently marked.");
                break;
              case "transfer":
                $$1(noMarksSelector).text("No transfers are currently marked.");
                break;
            }
            $$1(noMarksSelector).show();
          } else {
            $$1(noMarksSelector).hide();
          }
        };
        let currentUser = () => {
          let current_user = {};
          $$1(usersSelector).each(function() {
            if ($$1(this).hasClass("current-user")) {
              current_user.id = $$1(this).data("user-id");
              current_user.fullName = $$1(this).text();
            }
          });
          return current_user;
        };
        let selectedUserIdPresent = () => {
          let isPresent = false;
          $$1(usersSelector).each(function() {
            if (selectedUserId === $$1(this).data("user-id")) {
              isPresent = true;
            }
          });
          return isPresent;
        };
        let selectedUserName = () => {
          let fullName = null;
          $$1(usersSelector).each(function() {
            if (selectedUserId === $$1(this).data("user-id")) {
              fullName = $$1(this).text();
            }
          });
          return fullName;
        }, store = function() {
          if (key2 != null) {
            if (location2 === "local" || location2 == null) {
              localStorage.setItem(key2, toString());
            } else if (location2 === "session") {
              sessionStorage.setItem(key2, toString());
            }
          }
        }, toJson = function() {
          return {
            key: key2,
            location: location2,
            marksContainer,
            marksSelector,
            noMarksSelector,
            filtersSelector,
            usersSelector,
            selectedUserSelector,
            currentFilter,
            selectedUserId
          };
        }, toString = function() {
          return JSON.stringify(toJson());
        };
        return {
          init,
          store
        };
      },
      IllegalArgumentException(message) {
        jitterbug.message = message;
        return this;
      },
      /**
       * Used to deserialize all models from storage.
       */
      loader(key2, location2) {
        if (key2 == null) {
          console.log("Could not load object. Param 'key' is null.");
          return null;
        }
        let string = null;
        if (location2 === "local" || location2 == null) {
          string = localStorage.getItem(key2);
        } else if (location2 === "session") {
          string = sessionStorage.getItem(key2);
        }
        if (string == null) {
          return null;
        }
        return this(JSON.parse(string));
      }
    };
    jitterbug.SearchField.load = jitterbug.loader;
    jitterbug.TableParams.load = jitterbug.loader;
    jitterbug.FilterPanel.load = jitterbug.loader;
    jitterbug.TableSelection.load = jitterbug.loader;
    jitterbug.MarksModule.load = jitterbug.loader;
    (function($2) {
      let o = $2({});
      $2.subscribe = function() {
        o.on.apply(o, arguments);
      };
      $2.unsubscribe = function() {
        o.off.apply(o, arguments);
      };
      $2.publish = function() {
        o.trigger.apply(o, arguments);
      };
    })($$1);
    /*! DataTables 2.3.4
     * © SpryMedia Ltd - datatables.net/license
     */
    var $ = $$1;
    var DataTable = function(selector, options) {
      if (DataTable.factory(selector, options)) {
        return DataTable;
      }
      if (this instanceof DataTable) {
        return $(selector).DataTable(options);
      } else {
        options = selector;
      }
      var _that = this;
      var emptyInit = options === void 0;
      var len = this.length;
      if (emptyInit) {
        options = {};
      }
      this.api = function() {
        return new _Api(this);
      };
      this.each(function() {
        var o = {};
        var oInit = len > 1 ? (
          // optimisation for single table case
          _fnExtend(o, options, true)
        ) : options;
        var i2 = 0, iLen;
        var sId = this.getAttribute("id");
        var defaults2 = DataTable.defaults;
        var $this = $(this);
        if (this.nodeName.toLowerCase() != "table") {
          _fnLog(null, 0, "Non-table node initialisation (" + this.nodeName + ")", 2);
          return;
        }
        if (oInit.on && oInit.on.options) {
          _fnListener($this, "options", oInit.on.options);
        }
        $this.trigger("options.dt", oInit);
        _fnCompatOpts(defaults2);
        _fnCompatCols(defaults2.column);
        _fnCamelToHungarian(defaults2, defaults2, true);
        _fnCamelToHungarian(defaults2.column, defaults2.column, true);
        _fnCamelToHungarian(defaults2, $.extend(oInit, _fnEscapeObject($this.data())), true);
        var allSettings = DataTable.settings;
        for (i2 = 0, iLen = allSettings.length; i2 < iLen; i2++) {
          var s = allSettings[i2];
          if (s.nTable == this || s.nTHead && s.nTHead.parentNode == this || s.nTFoot && s.nTFoot.parentNode == this) {
            var bRetrieve = oInit.bRetrieve !== void 0 ? oInit.bRetrieve : defaults2.bRetrieve;
            var bDestroy = oInit.bDestroy !== void 0 ? oInit.bDestroy : defaults2.bDestroy;
            if (emptyInit || bRetrieve) {
              return s.oInstance;
            } else if (bDestroy) {
              new DataTable.Api(s).destroy();
              break;
            } else {
              _fnLog(s, 0, "Cannot reinitialise DataTable", 3);
              return;
            }
          }
          if (s.sTableId == this.id) {
            allSettings.splice(i2, 1);
            break;
          }
        }
        if (sId === null || sId === "") {
          sId = "DataTables_Table_" + DataTable.ext._unique++;
          this.id = sId;
        }
        $this.children("colgroup").remove();
        var oSettings = $.extend(true, {}, DataTable.models.oSettings, {
          "sDestroyWidth": $this[0].style.width,
          "sInstance": sId,
          "sTableId": sId,
          colgroup: $("<colgroup>").prependTo(this),
          fastData: function(row, column, type) {
            return _fnGetCellData(oSettings, row, column, type);
          }
        });
        oSettings.nTable = this;
        oSettings.oInit = oInit;
        allSettings.push(oSettings);
        oSettings.api = new _Api(oSettings);
        oSettings.oInstance = _that.length === 1 ? _that : $this.dataTable();
        _fnCompatOpts(oInit);
        if (oInit.aLengthMenu && !oInit.iDisplayLength) {
          oInit.iDisplayLength = Array.isArray(oInit.aLengthMenu[0]) ? oInit.aLengthMenu[0][0] : $.isPlainObject(oInit.aLengthMenu[0]) ? oInit.aLengthMenu[0].value : oInit.aLengthMenu[0];
        }
        oInit = _fnExtend($.extend(true, {}, defaults2), oInit);
        _fnMap(oSettings.oFeatures, oInit, [
          "bPaginate",
          "bLengthChange",
          "bFilter",
          "bSort",
          "bSortMulti",
          "bInfo",
          "bProcessing",
          "bAutoWidth",
          "bSortClasses",
          "bServerSide",
          "bDeferRender"
        ]);
        _fnMap(oSettings, oInit, [
          "ajax",
          "fnFormatNumber",
          "sServerMethod",
          "aaSorting",
          "aaSortingFixed",
          "aLengthMenu",
          "sPaginationType",
          "iStateDuration",
          "bSortCellsTop",
          "iTabIndex",
          "sDom",
          "fnStateLoadCallback",
          "fnStateSaveCallback",
          "renderer",
          "searchDelay",
          "rowId",
          "caption",
          "layout",
          "orderDescReverse",
          "orderIndicators",
          "orderHandler",
          "titleRow",
          "typeDetect",
          ["iCookieDuration", "iStateDuration"],
          // backwards compat
          ["oSearch", "oPreviousSearch"],
          ["aoSearchCols", "aoPreSearchCols"],
          ["iDisplayLength", "_iDisplayLength"]
        ]);
        _fnMap(oSettings.oScroll, oInit, [
          ["sScrollX", "sX"],
          ["sScrollXInner", "sXInner"],
          ["sScrollY", "sY"],
          ["bScrollCollapse", "bCollapse"]
        ]);
        _fnMap(oSettings.oLanguage, oInit, "fnInfoCallback");
        _fnCallbackReg(oSettings, "aoDrawCallback", oInit.fnDrawCallback);
        _fnCallbackReg(oSettings, "aoStateSaveParams", oInit.fnStateSaveParams);
        _fnCallbackReg(oSettings, "aoStateLoadParams", oInit.fnStateLoadParams);
        _fnCallbackReg(oSettings, "aoStateLoaded", oInit.fnStateLoaded);
        _fnCallbackReg(oSettings, "aoRowCallback", oInit.fnRowCallback);
        _fnCallbackReg(oSettings, "aoRowCreatedCallback", oInit.fnCreatedRow);
        _fnCallbackReg(oSettings, "aoHeaderCallback", oInit.fnHeaderCallback);
        _fnCallbackReg(oSettings, "aoFooterCallback", oInit.fnFooterCallback);
        _fnCallbackReg(oSettings, "aoInitComplete", oInit.fnInitComplete);
        _fnCallbackReg(oSettings, "aoPreDrawCallback", oInit.fnPreDrawCallback);
        oSettings.rowIdFn = _fnGetObjectDataFn(oInit.rowId);
        if (oInit.on) {
          Object.keys(oInit.on).forEach(function(key2) {
            _fnListener($this, key2, oInit.on[key2]);
          });
        }
        _fnBrowserDetect(oSettings);
        var oClasses = oSettings.oClasses;
        $.extend(oClasses, DataTable.ext.classes, oInit.oClasses);
        $this.addClass(oClasses.table);
        if (!oSettings.oFeatures.bPaginate) {
          oInit.iDisplayStart = 0;
        }
        if (oSettings.iInitDisplayStart === void 0) {
          oSettings.iInitDisplayStart = oInit.iDisplayStart;
          oSettings._iDisplayStart = oInit.iDisplayStart;
        }
        var defer = oInit.iDeferLoading;
        if (defer !== null) {
          oSettings.deferLoading = true;
          var tmp = Array.isArray(defer);
          oSettings._iRecordsDisplay = tmp ? defer[0] : defer;
          oSettings._iRecordsTotal = tmp ? defer[1] : defer;
        }
        var columnsInit = [];
        var thead = this.getElementsByTagName("thead");
        var initHeaderLayout = _fnDetectHeader(oSettings, thead[0]);
        if (oInit.aoColumns) {
          columnsInit = oInit.aoColumns;
        } else if (initHeaderLayout.length) {
          for (i2 = 0, iLen = initHeaderLayout[0].length; i2 < iLen; i2++) {
            columnsInit.push(null);
          }
        }
        for (i2 = 0, iLen = columnsInit.length; i2 < iLen; i2++) {
          _fnAddColumn(oSettings);
        }
        _fnApplyColumnDefs(oSettings, oInit.aoColumnDefs, columnsInit, initHeaderLayout, function(iCol, oDef) {
          _fnColumnOptions(oSettings, iCol, oDef);
        });
        var rowOne = $this.children("tbody").find("tr:first-child").eq(0);
        if (rowOne.length) {
          var a = function(cell, name) {
            return cell.getAttribute("data-" + name) !== null ? name : null;
          };
          $(rowOne[0]).children("th, td").each(function(i3, cell) {
            var col = oSettings.aoColumns[i3];
            if (!col) {
              _fnLog(oSettings, 0, "Incorrect column count", 18);
            }
            if (col.mData === i3) {
              var sort = a(cell, "sort") || a(cell, "order");
              var filter = a(cell, "filter") || a(cell, "search");
              if (sort !== null || filter !== null) {
                col.mData = {
                  _: i3 + ".display",
                  sort: sort !== null ? i3 + ".@data-" + sort : void 0,
                  type: sort !== null ? i3 + ".@data-" + sort : void 0,
                  filter: filter !== null ? i3 + ".@data-" + filter : void 0
                };
                col._isArrayHost = true;
                _fnColumnOptions(oSettings, i3);
              }
            }
          });
        }
        _fnCallbackReg(oSettings, "aoDrawCallback", _fnSaveState);
        var features = oSettings.oFeatures;
        if (oInit.bStateSave) {
          features.bStateSave = true;
        }
        if (oInit.aaSorting === void 0) {
          var sorting = oSettings.aaSorting;
          for (i2 = 0, iLen = sorting.length; i2 < iLen; i2++) {
            sorting[i2][1] = oSettings.aoColumns[i2].asSorting[0];
          }
        }
        _fnSortingClasses(oSettings);
        _fnCallbackReg(oSettings, "aoDrawCallback", function() {
          if (oSettings.bSorted || _fnDataSource(oSettings) === "ssp" || features.bDeferRender) {
            _fnSortingClasses(oSettings);
          }
        });
        var caption = $this.children("caption");
        if (oSettings.caption) {
          if (caption.length === 0) {
            caption = $("<caption/>").appendTo($this);
          }
          caption.html(oSettings.caption);
        }
        if (caption.length) {
          caption[0]._captionSide = caption.css("caption-side");
          oSettings.captionNode = caption[0];
        }
        if (thead.length === 0) {
          thead = $("<thead/>").appendTo($this);
        }
        oSettings.nTHead = thead[0];
        var tbody = $this.children("tbody");
        if (tbody.length === 0) {
          tbody = $("<tbody/>").insertAfter(thead);
        }
        oSettings.nTBody = tbody[0];
        var tfoot = $this.children("tfoot");
        if (tfoot.length === 0) {
          tfoot = $("<tfoot/>").appendTo($this);
        }
        oSettings.nTFoot = tfoot[0];
        oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
        oSettings.bInitialised = true;
        var oLanguage = oSettings.oLanguage;
        $.extend(true, oLanguage, oInit.oLanguage);
        if (oLanguage.sUrl) {
          $.ajax({
            dataType: "json",
            url: oLanguage.sUrl,
            success: function(json) {
              _fnCamelToHungarian(defaults2.oLanguage, json);
              $.extend(true, oLanguage, json, oSettings.oInit.oLanguage);
              _fnCallbackFire(oSettings, null, "i18n", [oSettings], true);
              _fnInitialise(oSettings);
            },
            error: function() {
              _fnLog(oSettings, 0, "i18n file loading error", 21);
              _fnInitialise(oSettings);
            }
          });
        } else {
          _fnCallbackFire(oSettings, null, "i18n", [oSettings], true);
          _fnInitialise(oSettings);
        }
      });
      _that = null;
      return this;
    };
    DataTable.ext = _ext = {
      /**
       * DataTables build type (expanded by the download builder)
       *
       *  @type string
       */
      builder: "-source-",
      /**
       * Buttons. For use with the Buttons extension for DataTables. This is
       * defined here so other extensions can define buttons regardless of load
       * order. It is _not_ used by DataTables core.
       *
       *  @type object
       *  @default {}
       */
      buttons: {},
      /**
       * ColumnControl buttons and content
       *
       *  @type object
       */
      ccContent: {},
      /**
       * Element class names
       *
       *  @type object
       *  @default {}
       */
      classes: {},
      /**
       * Error reporting.
       * 
       * How should DataTables report an error. Can take the value 'alert',
       * 'throw', 'none' or a function.
       *
       *  @type string|function
       *  @default alert
       */
      errMode: "alert",
      /** HTML entity escaping */
      escape: {
        /** When reading data-* attributes for initialisation options */
        attributes: false
      },
      /**
       * Legacy so v1 plug-ins don't throw js errors on load
       */
      feature: [],
      /**
       * Feature plug-ins.
       * 
       * This is an object of callbacks which provide the features for DataTables
       * to be initialised via the `layout` option.
       */
      features: {},
      /**
       * Row searching.
       * 
       * This method of searching is complimentary to the default type based
       * searching, and a lot more comprehensive as it allows you complete control
       * over the searching logic. Each element in this array is a function
       * (parameters described below) that is called for every row in the table,
       * and your logic decides if it should be included in the searching data set
       * or not.
       *
       * Searching functions have the following input parameters:
       *
       * 1. `{object}` DataTables settings object: see
       *    {@link DataTable.models.oSettings}
       * 2. `{array|object}` Data for the row to be processed (same as the
       *    original format that was passed in as the data source, or an array
       *    from a DOM data source
       * 3. `{int}` Row index ({@link DataTable.models.oSettings.aoData}), which
       *    can be useful to retrieve the `TR` element if you need DOM interaction.
       *
       * And the following return is expected:
       *
       * * {boolean} Include the row in the searched result set (true) or not
       *   (false)
       *
       * Note that as with the main search ability in DataTables, technically this
       * is "filtering", since it is subtractive. However, for consistency in
       * naming we call it searching here.
       *
       *  @type array
       *  @default []
       *
       *  @example
       *    // The following example shows custom search being applied to the
       *    // fourth column (i.e. the data[3] index) based on two input values
       *    // from the end-user, matching the data in a certain range.
       *    $.fn.dataTable.ext.search.push(
       *      function( settings, data, dataIndex ) {
       *        var min = document.getElementById('min').value * 1;
       *        var max = document.getElementById('max').value * 1;
       *        var version = data[3] == "-" ? 0 : data[3]*1;
       *
       *        if ( min == "" && max == "" ) {
       *          return true;
       *        }
       *        else if ( min == "" && version < max ) {
       *          return true;
       *        }
       *        else if ( min < version && "" == max ) {
       *          return true;
       *        }
       *        else if ( min < version && version < max ) {
       *          return true;
       *        }
       *        return false;
       *      }
       *    );
       */
      search: [],
      /**
       * Selector extensions
       *
       * The `selector` option can be used to extend the options available for the
       * selector modifier options (`selector-modifier` object data type) that
       * each of the three built in selector types offer (row, column and cell +
       * their plural counterparts). For example the Select extension uses this
       * mechanism to provide an option to select only rows, columns and cells
       * that have been marked as selected by the end user (`{selected: true}`),
       * which can be used in conjunction with the existing built in selector
       * options.
       *
       * Each property is an array to which functions can be pushed. The functions
       * take three attributes:
       *
       * * Settings object for the host table
       * * Options object (`selector-modifier` object type)
       * * Array of selected item indexes
       *
       * The return is an array of the resulting item indexes after the custom
       * selector has been applied.
       *
       *  @type object
       */
      selector: {
        cell: [],
        column: [],
        row: []
      },
      /**
       * Legacy configuration options. Enable and disable legacy options that
       * are available in DataTables.
       *
       *  @type object
       */
      legacy: {
        /**
         * Enable / disable DataTables 1.9 compatible server-side processing
         * requests
         *
         *  @type boolean
         *  @default null
         */
        ajax: null
      },
      /**
       * Pagination plug-in methods.
       * 
       * Each entry in this object is a function and defines which buttons should
       * be shown by the pagination rendering method that is used for the table:
       * {@link DataTable.ext.renderer.pageButton}. The renderer addresses how the
       * buttons are displayed in the document, while the functions here tell it
       * what buttons to display. This is done by returning an array of button
       * descriptions (what each button will do).
       *
       * Pagination types (the four built in options and any additional plug-in
       * options defined here) can be used through the `paginationType`
       * initialisation parameter.
       *
       * The functions defined take two parameters:
       *
       * 1. `{int} page` The current page index
       * 2. `{int} pages` The number of pages in the table
       *
       * Each function is expected to return an array where each element of the
       * array can be one of:
       *
       * * `first` - Jump to first page when activated
       * * `last` - Jump to last page when activated
       * * `previous` - Show previous page when activated
       * * `next` - Show next page when activated
       * * `{int}` - Show page of the index given
       * * `{array}` - A nested array containing the above elements to add a
       *   containing 'DIV' element (might be useful for styling).
       *
       * Note that DataTables v1.9- used this object slightly differently whereby
       * an object with two functions would be defined for each plug-in. That
       * ability is still supported by DataTables 1.10+ to provide backwards
       * compatibility, but this option of use is now decremented and no longer
       * documented in DataTables 1.10+.
       *
       *  @type object
       *  @default {}
       *
       *  @example
       *    // Show previous, next and current page buttons only
       *    $.fn.dataTableExt.oPagination.current = function ( page, pages ) {
       *      return [ 'previous', page, 'next' ];
       *    };
       */
      pager: {},
      renderer: {
        pageButton: {},
        header: {}
      },
      /**
       * Ordering plug-ins - custom data source
       * 
       * The extension options for ordering of data available here is complimentary
       * to the default type based ordering that DataTables typically uses. It
       * allows much greater control over the data that is being used to
       * order a column, but is necessarily therefore more complex.
       * 
       * This type of ordering is useful if you want to do ordering based on data
       * live from the DOM (for example the contents of an 'input' element) rather
       * than just the static string that DataTables knows of.
       * 
       * The way these plug-ins work is that you create an array of the values you
       * wish to be ordering for the column in question and then return that
       * array. The data in the array much be in the index order of the rows in
       * the table (not the currently ordering order!). Which order data gathering
       * function is run here depends on the `dt-init columns.orderDataType`
       * parameter that is used for the column (if any).
       *
       * The functions defined take two parameters:
       *
       * 1. `{object}` DataTables settings object: see
       *    {@link DataTable.models.oSettings}
       * 2. `{int}` Target column index
       *
       * Each function is expected to return an array:
       *
       * * `{array}` Data for the column to be ordering upon
       *
       *  @type array
       *
       *  @example
       *    // Ordering using `input` node values
       *    $.fn.dataTable.ext.order['dom-text'] = function  ( settings, col )
       *    {
       *      return this.api().column( col, {order:'index'} ).nodes().map( function ( td, i ) {
       *        return $('input', td).val();
       *      } );
       *    }
       */
      order: {},
      /**
       * Type based plug-ins.
       *
       * Each column in DataTables has a type assigned to it, either by automatic
       * detection or by direct assignment using the `type` option for the column.
       * The type of a column will effect how it is ordering and search (plug-ins
       * can also make use of the column type if required).
       *
       * @namespace
       */
      type: {
        /**
         * Automatic column class assignment
         */
        className: {},
        /**
         * Type detection functions.
         *
         * The functions defined in this object are used to automatically detect
         * a column's type, making initialisation of DataTables super easy, even
         * when complex data is in the table.
         *
         * The functions defined take two parameters:
         *
            *  1. `{*}` Data from the column cell to be analysed
            *  2. `{settings}` DataTables settings object. This can be used to
            *     perform context specific type detection - for example detection
            *     based on language settings such as using a comma for a decimal
            *     place. Generally speaking the options from the settings will not
            *     be required
         *
         * Each function is expected to return:
         *
         * * `{string|null}` Data type detected, or null if unknown (and thus
         *   pass it on to the other type detection functions.
         *
         *  @type array
         *
         *  @example
         *    // Currency type detection plug-in:
         *    $.fn.dataTable.ext.type.detect.push(
         *      function ( data, settings ) {
         *        // Check the numeric part
         *        if ( ! data.substring(1).match(/[0-9]/) ) {
         *          return null;
         *        }
         *
         *        // Check prefixed by currency
         *        if ( data.charAt(0) == '$' || data.charAt(0) == '&pound;' ) {
         *          return 'currency';
         *        }
         *        return null;
         *      }
         *    );
         */
        detect: [],
        /**
         * Automatic renderer assignment
         */
        render: {},
        /**
         * Type based search formatting.
         *
         * The type based searching functions can be used to pre-format the
         * data to be search on. For example, it can be used to strip HTML
         * tags or to de-format telephone numbers for numeric only searching.
         *
         * Note that is a search is not defined for a column of a given type,
         * no search formatting will be performed.
         * 
         * Pre-processing of searching data plug-ins - When you assign the sType
         * for a column (or have it automatically detected for you by DataTables
         * or a type detection plug-in), you will typically be using this for
         * custom sorting, but it can also be used to provide custom searching
         * by allowing you to pre-processing the data and returning the data in
         * the format that should be searched upon. This is done by adding
         * functions this object with a parameter name which matches the sType
         * for that target column. This is the corollary of <i>afnSortData</i>
         * for searching data.
         *
         * The functions defined take a single parameter:
         *
            *  1. `{*}` Data from the column cell to be prepared for searching
         *
         * Each function is expected to return:
         *
         * * `{string|null}` Formatted string that will be used for the searching.
         *
         *  @type object
         *  @default {}
         *
         *  @example
         *    $.fn.dataTable.ext.type.search['title-numeric'] = function ( d ) {
         *      return d.replace(/\n/g," ").replace( /<.*?>/g, "" );
         *    }
         */
        search: {},
        /**
         * Type based ordering.
         *
         * The column type tells DataTables what ordering to apply to the table
         * when a column is sorted upon. The order for each type that is defined,
         * is defined by the functions available in this object.
         *
         * Each ordering option can be described by three properties added to
         * this object:
         *
         * * `{type}-pre` - Pre-formatting function
         * * `{type}-asc` - Ascending order function
         * * `{type}-desc` - Descending order function
         *
         * All three can be used together, only `{type}-pre` or only
         * `{type}-asc` and `{type}-desc` together. It is generally recommended
         * that only `{type}-pre` is used, as this provides the optimal
         * implementation in terms of speed, although the others are provided
         * for compatibility with existing JavaScript sort functions.
         *
         * `{type}-pre`: Functions defined take a single parameter:
         *
            *  1. `{*}` Data from the column cell to be prepared for ordering
         *
         * And return:
         *
         * * `{*}` Data to be sorted upon
         *
         * `{type}-asc` and `{type}-desc`: Functions are typical JavaScript sort
         * functions, taking two parameters:
         *
            *  1. `{*}` Data to compare to the second parameter
            *  2. `{*}` Data to compare to the first parameter
         *
         * And returning:
         *
         * * `{*}` Ordering match: <0 if first parameter should be sorted lower
         *   than the second parameter, ===0 if the two parameters are equal and
         *   >0 if the first parameter should be sorted height than the second
         *   parameter.
         * 
         *  @type object
         *  @default {}
         *
         *  @example
         *    // Numeric ordering of formatted numbers with a pre-formatter
         *    $.extend( $.fn.dataTable.ext.type.order, {
         *      "string-pre": function(x) {
         *        a = (a === "-" || a === "") ? 0 : a.replace( /[^\d\-\.]/g, "" );
         *        return parseFloat( a );
         *      }
         *    } );
         *
         *  @example
         *    // Case-sensitive string ordering, with no pre-formatting method
         *    $.extend( $.fn.dataTable.ext.order, {
         *      "string-case-asc": function(x,y) {
         *        return ((x < y) ? -1 : ((x > y) ? 1 : 0));
         *      },
         *      "string-case-desc": function(x,y) {
         *        return ((x < y) ? 1 : ((x > y) ? -1 : 0));
         *      }
         *    } );
         */
        order: {}
      },
      /**
       * Unique DataTables instance counter
       *
       * @type int
       * @private
       */
      _unique: 0,
      //
      // Depreciated
      // The following properties are retained for backwards compatibility only.
      // The should not be used in new projects and will be removed in a future
      // version
      //
      /**
       * Version check function.
       *  @type function
       *  @depreciated Since 1.10
       */
      fnVersionCheck: DataTable.fnVersionCheck,
      /**
       * Index for what 'this' index API functions should use
       *  @type int
       *  @deprecated Since v1.10
       */
      iApiIndex: 0,
      /**
       * Software version
       *  @type string
       *  @deprecated Since v1.10
       */
      sVersion: DataTable.version
    };
    $.extend(_ext, {
      afnFiltering: _ext.search,
      aTypes: _ext.type.detect,
      ofnSearch: _ext.type.search,
      oSort: _ext.type.order,
      afnSortData: _ext.order,
      aoFeatures: _ext.feature,
      oStdClasses: _ext.classes,
      oPagination: _ext.pager
    });
    $.extend(DataTable.ext.classes, {
      container: "dt-container",
      empty: {
        row: "dt-empty"
      },
      info: {
        container: "dt-info"
      },
      layout: {
        row: "dt-layout-row",
        cell: "dt-layout-cell",
        tableRow: "dt-layout-table",
        tableCell: "",
        start: "dt-layout-start",
        end: "dt-layout-end",
        full: "dt-layout-full"
      },
      length: {
        container: "dt-length",
        select: "dt-input"
      },
      order: {
        canAsc: "dt-orderable-asc",
        canDesc: "dt-orderable-desc",
        isAsc: "dt-ordering-asc",
        isDesc: "dt-ordering-desc",
        none: "dt-orderable-none",
        position: "sorting_"
      },
      processing: {
        container: "dt-processing"
      },
      scrolling: {
        body: "dt-scroll-body",
        container: "dt-scroll",
        footer: {
          self: "dt-scroll-foot",
          inner: "dt-scroll-footInner"
        },
        header: {
          self: "dt-scroll-head",
          inner: "dt-scroll-headInner"
        }
      },
      search: {
        container: "dt-search",
        input: "dt-input"
      },
      table: "dataTable",
      tbody: {
        cell: "",
        row: ""
      },
      thead: {
        cell: "",
        row: ""
      },
      tfoot: {
        cell: "",
        row: ""
      },
      paging: {
        active: "current",
        button: "dt-paging-button",
        container: "dt-paging",
        disabled: "disabled",
        nav: ""
      }
    });
    var _ext;
    var _Api;
    var _api_register;
    var _api_registerPlural;
    var _re_dic = {};
    var _re_new_lines = /[\r\n\u2028]/g;
    var _re_html = /<([^>]*>)/g;
    var _max_str_len = Math.pow(2, 28);
    var _re_date = /^\d{2,4}[./-]\d{1,2}[./-]\d{1,2}([T ]{1}\d{1,2}[:.]\d{2}([.:]\d{2})?)?$/;
    var _re_escape_regex = new RegExp("(\\" + ["/", ".", "*", "+", "?", "|", "(", ")", "[", "]", "{", "}", "\\", "$", "^", "-"].join("|\\") + ")", "g");
    var _re_formatted_numeric = /['\u00A0,$£€¥%\u2009\u202F\u20BD\u20a9\u20BArfkɃΞ]/gi;
    var _empty = function(d) {
      return !d || d === true || d === "-" ? true : false;
    };
    var _intVal = function(s) {
      var integer = parseInt(s, 10);
      return !isNaN(integer) && isFinite(s) ? integer : null;
    };
    var _numToDecimal = function(num2, decimalPoint) {
      if (!_re_dic[decimalPoint]) {
        _re_dic[decimalPoint] = new RegExp(_fnEscapeRegex(decimalPoint), "g");
      }
      return typeof num2 === "string" && decimalPoint !== "." ? num2.replace(/\./g, "").replace(_re_dic[decimalPoint], ".") : num2;
    };
    var _isNumber = function(d, decimalPoint, formatted, allowEmpty) {
      var type = typeof d;
      var strType = type === "string";
      if (type === "number" || type === "bigint") {
        return true;
      }
      if (allowEmpty && _empty(d)) {
        return true;
      }
      if (decimalPoint && strType) {
        d = _numToDecimal(d, decimalPoint);
      }
      if (formatted && strType) {
        d = d.replace(_re_formatted_numeric, "");
      }
      return !isNaN(parseFloat(d)) && isFinite(d);
    };
    var _isHtml = function(d) {
      return _empty(d) || typeof d === "string";
    };
    var _htmlNumeric = function(d, decimalPoint, formatted, allowEmpty) {
      if (allowEmpty && _empty(d)) {
        return true;
      }
      if (typeof d === "string" && d.match(/<(input|select)/i)) {
        return null;
      }
      var html = _isHtml(d);
      return !html ? null : _isNumber(_stripHtml(d), decimalPoint, formatted, allowEmpty) ? true : null;
    };
    var _pluck = function(a, prop, prop2) {
      var out = [];
      var i2 = 0, iLen = a.length;
      if (prop2 !== void 0) {
        for (; i2 < iLen; i2++) {
          if (a[i2] && a[i2][prop]) {
            out.push(a[i2][prop][prop2]);
          }
        }
      } else {
        for (; i2 < iLen; i2++) {
          if (a[i2]) {
            out.push(a[i2][prop]);
          }
        }
      }
      return out;
    };
    var _pluck_order = function(a, order, prop, prop2) {
      var out = [];
      var i2 = 0, iLen = order.length;
      if (prop2 !== void 0) {
        for (; i2 < iLen; i2++) {
          if (a[order[i2]] && a[order[i2]][prop]) {
            out.push(a[order[i2]][prop][prop2]);
          }
        }
      } else {
        for (; i2 < iLen; i2++) {
          if (a[order[i2]]) {
            out.push(a[order[i2]][prop]);
          }
        }
      }
      return out;
    };
    var _range = function(len, start) {
      var out = [];
      var end;
      if (start === void 0) {
        start = 0;
        end = len;
      } else {
        end = start;
        start = len;
      }
      for (var i2 = start; i2 < end; i2++) {
        out.push(i2);
      }
      return out;
    };
    var _removeEmpty = function(a) {
      var out = [];
      for (var i2 = 0, iLen = a.length; i2 < iLen; i2++) {
        if (a[i2]) {
          out.push(a[i2]);
        }
      }
      return out;
    };
    var _stripHtml = function(input) {
      if (!input || typeof input !== "string") {
        return input;
      }
      if (input.length > _max_str_len) {
        throw new Error("Exceeded max str len");
      }
      var previous;
      input = input.replace(_re_html, "");
      do {
        previous = input;
        input = input.replace(/<script/i, "");
      } while (input !== previous);
      return previous;
    };
    var _escapeHtml = function(d) {
      if (Array.isArray(d)) {
        d = d.join(",");
      }
      return typeof d === "string" ? d.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;") : d;
    };
    var _normalize = function(str, both) {
      if (typeof str !== "string") {
        return str;
      }
      var res = str.normalize ? str.normalize("NFD") : str;
      return res.length !== str.length ? (both === true ? str + " " : "") + res.replace(/[\u0300-\u036f]/g, "") : res;
    };
    var _areAllUnique = function(src) {
      if (src.length < 2) {
        return true;
      }
      var sorted = src.slice().sort();
      var last = sorted[0];
      for (var i2 = 1, iLen = sorted.length; i2 < iLen; i2++) {
        if (sorted[i2] === last) {
          return false;
        }
        last = sorted[i2];
      }
      return true;
    };
    var _unique = function(src) {
      if (Array.from && Set) {
        return Array.from(new Set(src));
      }
      if (_areAllUnique(src)) {
        return src.slice();
      }
      var out = [], val, i2, iLen = src.length, j, k = 0;
      again: for (i2 = 0; i2 < iLen; i2++) {
        val = src[i2];
        for (j = 0; j < k; j++) {
          if (out[j] === val) {
            continue again;
          }
        }
        out.push(val);
        k++;
      }
      return out;
    };
    var _flatten = function(out, val) {
      if (Array.isArray(val)) {
        for (var i2 = 0; i2 < val.length; i2++) {
          _flatten(out, val[i2]);
        }
      } else {
        out.push(val);
      }
      return out;
    };
    function _addClass(el, name) {
      if (name) {
        name.split(" ").forEach(function(n) {
          if (n) {
            el.classList.add(n);
          }
        });
      }
    }
    DataTable.util = {
      /**
       * Return a string with diacritic characters decomposed
       * @param {*} mixed Function or string to normalize
       * @param {*} both Return original string and the normalized string
       * @returns String or undefined
       */
      diacritics: function(mixed, both) {
        var type = typeof mixed;
        if (type !== "function") {
          return _normalize(mixed, both);
        }
        _normalize = mixed;
      },
      /**
       * Debounce a function
       *
       * @param {function} fn Function to be called
       * @param {integer} freq Call frequency in mS
       * @return {function} Wrapped function
       */
      debounce: function(fn, timeout) {
        var timer;
        return function() {
          var that = this;
          var args = arguments;
          clearTimeout(timer);
          timer = setTimeout(function() {
            fn.apply(that, args);
          }, timeout || 250);
        };
      },
      /**
       * Throttle the calls to a function. Arguments and context are maintained
       * for the throttled function.
       *
       * @param {function} fn Function to be called
       * @param {integer} freq Call frequency in mS
       * @return {function} Wrapped function
       */
      throttle: function(fn, freq) {
        var frequency = freq !== void 0 ? freq : 200, last, timer;
        return function() {
          var that = this, now = +/* @__PURE__ */ new Date(), args = arguments;
          if (last && now < last + frequency) {
            clearTimeout(timer);
            timer = setTimeout(function() {
              last = void 0;
              fn.apply(that, args);
            }, frequency);
          } else {
            last = now;
            fn.apply(that, args);
          }
        };
      },
      /**
       * Escape a string such that it can be used in a regular expression
       *
       *  @param {string} val string to escape
       *  @returns {string} escaped string
       */
      escapeRegex: function(val) {
        return val.replace(_re_escape_regex, "\\$1");
      },
      /**
       * Create a function that will write to a nested object or array
       * @param {*} source JSON notation string
       * @returns Write function
       */
      set: function(source) {
        if ($.isPlainObject(source)) {
          return DataTable.util.set(source._);
        } else if (source === null) {
          return function() {
          };
        } else if (typeof source === "function") {
          return function(data, val, meta) {
            source(data, "set", val, meta);
          };
        } else if (typeof source === "string" && (source.indexOf(".") !== -1 || source.indexOf("[") !== -1 || source.indexOf("(") !== -1)) {
          var setData = function(data, val, src) {
            var a = _fnSplitObjNotation(src), b;
            var aLast = a[a.length - 1];
            var arrayNotation, funcNotation, o, innerSrc;
            for (var i2 = 0, iLen = a.length - 1; i2 < iLen; i2++) {
              if (a[i2] === "__proto__" || a[i2] === "constructor") {
                throw new Error("Cannot set prototype values");
              }
              arrayNotation = a[i2].match(__reArray);
              funcNotation = a[i2].match(__reFn);
              if (arrayNotation) {
                a[i2] = a[i2].replace(__reArray, "");
                data[a[i2]] = [];
                b = a.slice();
                b.splice(0, i2 + 1);
                innerSrc = b.join(".");
                if (Array.isArray(val)) {
                  for (var j = 0, jLen = val.length; j < jLen; j++) {
                    o = {};
                    setData(o, val[j], innerSrc);
                    data[a[i2]].push(o);
                  }
                } else {
                  data[a[i2]] = val;
                }
                return;
              } else if (funcNotation) {
                a[i2] = a[i2].replace(__reFn, "");
                data = data[a[i2]](val);
              }
              if (data[a[i2]] === null || data[a[i2]] === void 0) {
                data[a[i2]] = {};
              }
              data = data[a[i2]];
            }
            if (aLast.match(__reFn)) {
              data = data[aLast.replace(__reFn, "")](val);
            } else {
              data[aLast.replace(__reArray, "")] = val;
            }
          };
          return function(data, val) {
            return setData(data, val, source);
          };
        } else {
          return function(data, val) {
            data[source] = val;
          };
        }
      },
      /**
       * Create a function that will read nested objects from arrays, based on JSON notation
       * @param {*} source JSON notation string
       * @returns Value read
       */
      get: function(source) {
        if ($.isPlainObject(source)) {
          var o = {};
          $.each(source, function(key2, val) {
            if (val) {
              o[key2] = DataTable.util.get(val);
            }
          });
          return function(data, type, row, meta) {
            var t = o[type] || o._;
            return t !== void 0 ? t(data, type, row, meta) : data;
          };
        } else if (source === null) {
          return function(data) {
            return data;
          };
        } else if (typeof source === "function") {
          return function(data, type, row, meta) {
            return source(data, type, row, meta);
          };
        } else if (typeof source === "string" && (source.indexOf(".") !== -1 || source.indexOf("[") !== -1 || source.indexOf("(") !== -1)) {
          var fetchData = function(data, type, src) {
            var arrayNotation, funcNotation, out, innerSrc;
            if (src !== "") {
              var a = _fnSplitObjNotation(src);
              for (var i2 = 0, iLen = a.length; i2 < iLen; i2++) {
                arrayNotation = a[i2].match(__reArray);
                funcNotation = a[i2].match(__reFn);
                if (arrayNotation) {
                  a[i2] = a[i2].replace(__reArray, "");
                  if (a[i2] !== "") {
                    data = data[a[i2]];
                  }
                  out = [];
                  a.splice(0, i2 + 1);
                  innerSrc = a.join(".");
                  if (Array.isArray(data)) {
                    for (var j = 0, jLen = data.length; j < jLen; j++) {
                      out.push(fetchData(data[j], type, innerSrc));
                    }
                  }
                  var join = arrayNotation[0].substring(1, arrayNotation[0].length - 1);
                  data = join === "" ? out : out.join(join);
                  break;
                } else if (funcNotation) {
                  a[i2] = a[i2].replace(__reFn, "");
                  data = data[a[i2]]();
                  continue;
                }
                if (data === null || data[a[i2]] === null) {
                  return null;
                } else if (data === void 0 || data[a[i2]] === void 0) {
                  return void 0;
                }
                data = data[a[i2]];
              }
            }
            return data;
          };
          return function(data, type) {
            return fetchData(data, type, source);
          };
        } else {
          return function(data) {
            return data[source];
          };
        }
      },
      stripHtml: function(mixed) {
        var type = typeof mixed;
        if (type === "function") {
          _stripHtml = mixed;
          return;
        } else if (type === "string") {
          return _stripHtml(mixed);
        }
        return mixed;
      },
      escapeHtml: function(mixed) {
        var type = typeof mixed;
        if (type === "function") {
          _escapeHtml = mixed;
          return;
        } else if (type === "string" || Array.isArray(mixed)) {
          return _escapeHtml(mixed);
        }
        return mixed;
      },
      unique: _unique
    };
    function _fnHungarianMap(o) {
      var hungarian = "a aa ai ao as b fn i m o s ", match, newKey, map = {};
      $.each(o, function(key2) {
        match = key2.match(/^([^A-Z]+?)([A-Z])/);
        if (match && hungarian.indexOf(match[1] + " ") !== -1) {
          newKey = key2.replace(match[0], match[2].toLowerCase());
          map[newKey] = key2;
          if (match[1] === "o") {
            _fnHungarianMap(o[key2]);
          }
        }
      });
      o._hungarianMap = map;
    }
    function _fnCamelToHungarian(src, user, force) {
      if (!src._hungarianMap) {
        _fnHungarianMap(src);
      }
      var hungarianKey;
      $.each(user, function(key2) {
        hungarianKey = src._hungarianMap[key2];
        if (hungarianKey !== void 0 && (force || user[hungarianKey] === void 0)) {
          if (hungarianKey.charAt(0) === "o") {
            if (!user[hungarianKey]) {
              user[hungarianKey] = {};
            }
            $.extend(true, user[hungarianKey], user[key2]);
            _fnCamelToHungarian(src[hungarianKey], user[hungarianKey], force);
          } else {
            user[hungarianKey] = user[key2];
          }
        }
      });
    }
    var _fnCompatMap = function(o, knew, old) {
      if (o[knew] !== void 0) {
        o[old] = o[knew];
      }
    };
    function _fnCompatOpts(init) {
      _fnCompatMap(init, "ordering", "bSort");
      _fnCompatMap(init, "orderMulti", "bSortMulti");
      _fnCompatMap(init, "orderClasses", "bSortClasses");
      _fnCompatMap(init, "orderCellsTop", "bSortCellsTop");
      _fnCompatMap(init, "order", "aaSorting");
      _fnCompatMap(init, "orderFixed", "aaSortingFixed");
      _fnCompatMap(init, "paging", "bPaginate");
      _fnCompatMap(init, "pagingType", "sPaginationType");
      _fnCompatMap(init, "pageLength", "iDisplayLength");
      _fnCompatMap(init, "searching", "bFilter");
      if (typeof init.sScrollX === "boolean") {
        init.sScrollX = init.sScrollX ? "100%" : "";
      }
      if (typeof init.scrollX === "boolean") {
        init.scrollX = init.scrollX ? "100%" : "";
      }
      if (typeof init.bSort === "object") {
        init.orderIndicators = init.bSort.indicators !== void 0 ? init.bSort.indicators : true;
        init.orderHandler = init.bSort.handler !== void 0 ? init.bSort.handler : true;
        init.bSort = true;
      } else if (init.bSort === false) {
        init.orderIndicators = false;
        init.orderHandler = false;
      } else if (init.bSort === true) {
        init.orderIndicators = true;
        init.orderHandler = true;
      }
      if (typeof init.bSortCellsTop === "boolean") {
        init.titleRow = init.bSortCellsTop;
      }
      var searchCols = init.aoSearchCols;
      if (searchCols) {
        for (var i2 = 0, iLen = searchCols.length; i2 < iLen; i2++) {
          if (searchCols[i2]) {
            _fnCamelToHungarian(DataTable.models.oSearch, searchCols[i2]);
          }
        }
      }
      if (init.serverSide && !init.searchDelay) {
        init.searchDelay = 400;
      }
    }
    function _fnCompatCols(init) {
      _fnCompatMap(init, "orderable", "bSortable");
      _fnCompatMap(init, "orderData", "aDataSort");
      _fnCompatMap(init, "orderSequence", "asSorting");
      _fnCompatMap(init, "orderDataType", "sortDataType");
      var dataSort = init.aDataSort;
      if (typeof dataSort === "number" && !Array.isArray(dataSort)) {
        init.aDataSort = [dataSort];
      }
    }
    function _fnBrowserDetect(settings) {
      if (!DataTable.__browser) {
        var browser = {};
        DataTable.__browser = browser;
        var n = $("<div/>").css({
          position: "fixed",
          top: 0,
          left: -1 * window.pageXOffset,
          // allow for scrolling
          height: 1,
          width: 1,
          overflow: "hidden"
        }).append(
          $("<div/>").css({
            position: "absolute",
            top: 1,
            left: 1,
            width: 100,
            overflow: "scroll"
          }).append(
            $("<div/>").css({
              width: "100%",
              height: 10
            })
          )
        ).appendTo("body");
        var outer = n.children();
        var inner = outer.children();
        browser.barWidth = outer[0].offsetWidth - outer[0].clientWidth;
        browser.bScrollbarLeft = Math.round(inner.offset().left) !== 1;
        n.remove();
      }
      $.extend(settings.oBrowser, DataTable.__browser);
      settings.oScroll.iBarWidth = DataTable.__browser.barWidth;
    }
    function _fnAddColumn(oSettings) {
      var oDefaults = DataTable.defaults.column;
      var iCol = oSettings.aoColumns.length;
      var oCol = $.extend({}, DataTable.models.oColumn, oDefaults, {
        "aDataSort": oDefaults.aDataSort ? oDefaults.aDataSort : [iCol],
        "mData": oDefaults.mData ? oDefaults.mData : iCol,
        idx: iCol,
        searchFixed: {},
        colEl: $("<col>").attr("data-dt-column", iCol)
      });
      oSettings.aoColumns.push(oCol);
      var searchCols = oSettings.aoPreSearchCols;
      searchCols[iCol] = $.extend({}, DataTable.models.oSearch, searchCols[iCol]);
    }
    function _fnColumnOptions(oSettings, iCol, oOptions) {
      var oCol = oSettings.aoColumns[iCol];
      if (oOptions !== void 0 && oOptions !== null) {
        _fnCompatCols(oOptions);
        _fnCamelToHungarian(DataTable.defaults.column, oOptions, true);
        if (oOptions.mDataProp !== void 0 && !oOptions.mData) {
          oOptions.mData = oOptions.mDataProp;
        }
        if (oOptions.sType) {
          oCol._sManualType = oOptions.sType;
        }
        if (oOptions.className && !oOptions.sClass) {
          oOptions.sClass = oOptions.className;
        }
        var origClass = oCol.sClass;
        $.extend(oCol, oOptions);
        _fnMap(oCol, oOptions, "sWidth", "sWidthOrig");
        if (origClass !== oCol.sClass) {
          oCol.sClass = origClass + " " + oCol.sClass;
        }
        if (oOptions.iDataSort !== void 0) {
          oCol.aDataSort = [oOptions.iDataSort];
        }
        _fnMap(oCol, oOptions, "aDataSort");
      }
      var mDataSrc = oCol.mData;
      var mData = _fnGetObjectDataFn(mDataSrc);
      if (oCol.mRender && Array.isArray(oCol.mRender)) {
        var copy = oCol.mRender.slice();
        var name = copy.shift();
        oCol.mRender = DataTable.render[name].apply(window, copy);
      }
      oCol._render = oCol.mRender ? _fnGetObjectDataFn(oCol.mRender) : null;
      var attrTest = function(src) {
        return typeof src === "string" && src.indexOf("@") !== -1;
      };
      oCol._bAttrSrc = $.isPlainObject(mDataSrc) && (attrTest(mDataSrc.sort) || attrTest(mDataSrc.type) || attrTest(mDataSrc.filter));
      oCol._setter = null;
      oCol.fnGetData = function(rowData, type, meta) {
        var innerData = mData(rowData, type, void 0, meta);
        return oCol._render && type ? oCol._render(innerData, type, rowData, meta) : innerData;
      };
      oCol.fnSetData = function(rowData, val, meta) {
        return _fnSetObjectDataFn(mDataSrc)(rowData, val, meta);
      };
      if (typeof mDataSrc !== "number" && !oCol._isArrayHost) {
        oSettings._rowReadObject = true;
      }
      if (!oSettings.oFeatures.bSort) {
        oCol.bSortable = false;
      }
    }
    function _fnAdjustColumnSizing(settings) {
      _fnCalculateColumnWidths(settings);
      _fnColumnSizes(settings);
      var scroll = settings.oScroll;
      if (scroll.sY !== "" || scroll.sX !== "") {
        _fnScrollDraw(settings);
      }
      _fnCallbackFire(settings, null, "column-sizing", [settings]);
    }
    function _fnColumnSizes(settings) {
      var cols = settings.aoColumns;
      for (var i2 = 0; i2 < cols.length; i2++) {
        var width = _fnColumnsSumWidth(settings, [i2], false);
        cols[i2].colEl.css("width", width);
        if (settings.oScroll.sX) {
          cols[i2].colEl.css("min-width", width);
        }
      }
    }
    function _fnVisibleToColumnIndex(oSettings, iMatch) {
      var aiVis = _fnGetColumns(oSettings, "bVisible");
      return typeof aiVis[iMatch] === "number" ? aiVis[iMatch] : null;
    }
    function _fnColumnIndexToVisible(oSettings, iMatch) {
      var aiVis = _fnGetColumns(oSettings, "bVisible");
      var iPos = aiVis.indexOf(iMatch);
      return iPos !== -1 ? iPos : null;
    }
    function _fnVisibleColumns(settings) {
      var layout = settings.aoHeader;
      var columns = settings.aoColumns;
      var vis = 0;
      if (layout.length) {
        for (var i2 = 0, iLen = layout[0].length; i2 < iLen; i2++) {
          if (columns[i2].bVisible && $(layout[0][i2].cell).css("display") !== "none") {
            vis++;
          }
        }
      }
      return vis;
    }
    function _fnGetColumns(oSettings, sParam) {
      var a = [];
      oSettings.aoColumns.map(function(val, i2) {
        if (val[sParam]) {
          a.push(i2);
        }
      });
      return a;
    }
    function _typeResult(typeDetect, res) {
      return res === true ? typeDetect._name : res;
    }
    function _fnColumnTypes(settings) {
      var columns = settings.aoColumns;
      var data = settings.aoData;
      var types = DataTable.ext.type.detect;
      var i2, iLen, j, jen, k, ken;
      var col, detectedType, cache;
      for (i2 = 0, iLen = columns.length; i2 < iLen; i2++) {
        col = columns[i2];
        cache = [];
        if (!col.sType && col._sManualType) {
          col.sType = col._sManualType;
        } else if (!col.sType) {
          if (!settings.typeDetect) {
            return;
          }
          for (j = 0, jen = types.length; j < jen; j++) {
            var typeDetect = types[j];
            var oneOf = typeDetect.oneOf;
            var allOf = typeDetect.allOf || typeDetect;
            var init = typeDetect.init;
            var one = false;
            detectedType = null;
            if (init) {
              detectedType = _typeResult(typeDetect, init(settings, col, i2));
              if (detectedType) {
                col.sType = detectedType;
                break;
              }
            }
            for (k = 0, ken = data.length; k < ken; k++) {
              if (!data[k]) {
                continue;
              }
              if (cache[k] === void 0) {
                cache[k] = _fnGetCellData(settings, k, i2, "type");
              }
              if (oneOf && !one) {
                one = _typeResult(typeDetect, oneOf(cache[k], settings));
              }
              detectedType = _typeResult(typeDetect, allOf(cache[k], settings));
              if (!detectedType && j !== types.length - 3) {
                break;
              }
              if (detectedType === "html" && !_empty(cache[k])) {
                break;
              }
            }
            if (oneOf && one && detectedType || !oneOf && detectedType) {
              col.sType = detectedType;
              break;
            }
          }
          if (!col.sType) {
            col.sType = "string";
          }
        }
        var autoClass = _ext.type.className[col.sType];
        if (autoClass) {
          _columnAutoClass(settings.aoHeader, i2, autoClass);
          _columnAutoClass(settings.aoFooter, i2, autoClass);
        }
        var renderer = _ext.type.render[col.sType];
        if (renderer && !col._render) {
          col._render = DataTable.util.get(renderer);
          _columnAutoRender(settings, i2);
        }
      }
    }
    function _columnAutoRender(settings, colIdx) {
      var data = settings.aoData;
      for (var i2 = 0; i2 < data.length; i2++) {
        if (data[i2].nTr) {
          var display = _fnGetCellData(settings, i2, colIdx, "display");
          data[i2].displayData[colIdx] = display;
          _fnWriteCell(data[i2].anCells[colIdx], display);
        }
      }
    }
    function _columnAutoClass(container, colIdx, className) {
      container.forEach(function(row) {
        if (row[colIdx] && row[colIdx].unique) {
          _addClass(row[colIdx].cell, className);
        }
      });
    }
    function _fnApplyColumnDefs(oSettings, aoColDefs, aoCols, headerLayout, fn) {
      var i2, iLen, j, jLen, k, kLen, def;
      var columns = oSettings.aoColumns;
      if (aoCols) {
        for (i2 = 0, iLen = aoCols.length; i2 < iLen; i2++) {
          if (aoCols[i2] && aoCols[i2].name) {
            columns[i2].sName = aoCols[i2].name;
          }
        }
      }
      if (aoColDefs) {
        for (i2 = aoColDefs.length - 1; i2 >= 0; i2--) {
          def = aoColDefs[i2];
          var aTargets = def.target !== void 0 ? def.target : def.targets !== void 0 ? def.targets : def.aTargets;
          if (!Array.isArray(aTargets)) {
            aTargets = [aTargets];
          }
          for (j = 0, jLen = aTargets.length; j < jLen; j++) {
            var target = aTargets[j];
            if (typeof target === "number" && target >= 0) {
              while (columns.length <= target) {
                _fnAddColumn(oSettings);
              }
              fn(target, def);
            } else if (typeof target === "number" && target < 0) {
              fn(columns.length + target, def);
            } else if (typeof target === "string") {
              for (k = 0, kLen = columns.length; k < kLen; k++) {
                if (target === "_all") {
                  fn(k, def);
                } else if (target.indexOf(":name") !== -1) {
                  if (columns[k].sName === target.replace(":name", "")) {
                    fn(k, def);
                  }
                } else {
                  headerLayout.forEach(function(row) {
                    if (row[k]) {
                      var cell = $(row[k].cell);
                      if (target.match(/^[a-z][\w-]*$/i)) {
                        target = "." + target;
                      }
                      if (cell.is(target)) {
                        fn(k, def);
                      }
                    }
                  });
                }
              }
            }
          }
        }
      }
      if (aoCols) {
        for (i2 = 0, iLen = aoCols.length; i2 < iLen; i2++) {
          fn(i2, aoCols[i2]);
        }
      }
    }
    function _fnColumnsSumWidth(settings, targets, original, incVisible) {
      if (!Array.isArray(targets)) {
        targets = _fnColumnsFromHeader(targets);
      }
      var sum = 0;
      var unit;
      var columns = settings.aoColumns;
      for (var i2 = 0, iLen = targets.length; i2 < iLen; i2++) {
        var column = columns[targets[i2]];
        var definedWidth = original ? column.sWidthOrig : column.sWidth;
        if (column.bVisible === false) {
          continue;
        }
        if (definedWidth === null || definedWidth === void 0) {
          return null;
        } else if (typeof definedWidth === "number") {
          unit = "px";
          sum += definedWidth;
        } else {
          var matched = definedWidth.match(/([\d\.]+)([^\d]*)/);
          if (matched) {
            sum += matched[1] * 1;
            unit = matched.length === 3 ? matched[2] : "px";
          }
        }
      }
      return sum + unit;
    }
    function _fnColumnsFromHeader(cell) {
      var attr = $(cell).closest("[data-dt-column]").attr("data-dt-column");
      if (!attr) {
        return [];
      }
      return attr.split(",").map(function(val) {
        return val * 1;
      });
    }
    function _fnAddData(settings, dataIn, tr, tds) {
      var rowIdx = settings.aoData.length;
      var rowModel = $.extend(true, {}, DataTable.models.oRow, {
        src: tr ? "dom" : "data",
        idx: rowIdx
      });
      rowModel._aData = dataIn;
      settings.aoData.push(rowModel);
      var columns = settings.aoColumns;
      for (var i2 = 0, iLen = columns.length; i2 < iLen; i2++) {
        columns[i2].sType = null;
      }
      settings.aiDisplayMaster.push(rowIdx);
      var id = settings.rowIdFn(dataIn);
      if (id !== void 0) {
        settings.aIds[id] = rowModel;
      }
      if (tr || !settings.oFeatures.bDeferRender) {
        _fnCreateTr(settings, rowIdx, tr, tds);
      }
      return rowIdx;
    }
    function _fnAddTr(settings, trs) {
      var row;
      if (!(trs instanceof $)) {
        trs = $(trs);
      }
      return trs.map(function(i2, el) {
        row = _fnGetRowElements(settings, el);
        return _fnAddData(settings, row.data, el, row.cells);
      });
    }
    function _fnGetCellData(settings, rowIdx, colIdx, type) {
      if (type === "search") {
        type = "filter";
      } else if (type === "order") {
        type = "sort";
      }
      var row = settings.aoData[rowIdx];
      if (!row) {
        return void 0;
      }
      var draw = settings.iDraw;
      var col = settings.aoColumns[colIdx];
      var rowData = row._aData;
      var defaultContent = col.sDefaultContent;
      var cellData = col.fnGetData(rowData, type, {
        settings,
        row: rowIdx,
        col: colIdx
      });
      if (type !== "display" && cellData && typeof cellData === "object" && cellData.nodeName) {
        cellData = cellData.innerHTML;
      }
      if (cellData === void 0) {
        if (settings.iDrawError != draw && defaultContent === null) {
          _fnLog(settings, 0, "Requested unknown parameter " + (typeof col.mData == "function" ? "{function}" : "'" + col.mData + "'") + " for row " + rowIdx + ", column " + colIdx, 4);
          settings.iDrawError = draw;
        }
        return defaultContent;
      }
      if ((cellData === rowData || cellData === null) && defaultContent !== null && type !== void 0) {
        cellData = defaultContent;
      } else if (typeof cellData === "function") {
        return cellData.call(rowData);
      }
      if (cellData === null && type === "display") {
        return "";
      }
      if (type === "filter") {
        var formatters = DataTable.ext.type.search;
        if (formatters[col.sType]) {
          cellData = formatters[col.sType](cellData);
        }
      }
      return cellData;
    }
    function _fnSetCellData(settings, rowIdx, colIdx, val) {
      var col = settings.aoColumns[colIdx];
      var rowData = settings.aoData[rowIdx]._aData;
      col.fnSetData(rowData, val, {
        settings,
        row: rowIdx,
        col: colIdx
      });
    }
    function _fnWriteCell(td, val) {
      if (val && typeof val === "object" && val.nodeName) {
        $(td).empty().append(val);
      } else {
        td.innerHTML = val;
      }
    }
    var __reArray = /\[.*?\]$/;
    var __reFn = /\(\)$/;
    function _fnSplitObjNotation(str) {
      var parts = str.match(/(\\.|[^.])+/g) || [""];
      return parts.map(function(s) {
        return s.replace(/\\\./g, ".");
      });
    }
    var _fnGetObjectDataFn = DataTable.util.get;
    var _fnSetObjectDataFn = DataTable.util.set;
    function _fnGetDataMaster(settings) {
      return _pluck(settings.aoData, "_aData");
    }
    function _fnClearTable(settings) {
      settings.aoData.length = 0;
      settings.aiDisplayMaster.length = 0;
      settings.aiDisplay.length = 0;
      settings.aIds = {};
    }
    function _fnInvalidate(settings, rowIdx, src, colIdx) {
      var row = settings.aoData[rowIdx];
      var i2, iLen;
      row._aSortData = null;
      row._aFilterData = null;
      row.displayData = null;
      if (src === "dom" || (!src || src === "auto") && row.src === "dom") {
        row._aData = _fnGetRowElements(
          settings,
          row,
          colIdx,
          colIdx === void 0 ? void 0 : row._aData
        ).data;
      } else {
        var cells = row.anCells;
        var display = _fnGetRowDisplay(settings, rowIdx);
        if (cells) {
          if (colIdx !== void 0) {
            _fnWriteCell(cells[colIdx], display[colIdx]);
          } else {
            for (i2 = 0, iLen = cells.length; i2 < iLen; i2++) {
              _fnWriteCell(cells[i2], display[i2]);
            }
          }
        }
      }
      var cols = settings.aoColumns;
      if (colIdx !== void 0) {
        cols[colIdx].sType = null;
        cols[colIdx].maxLenString = null;
      } else {
        for (i2 = 0, iLen = cols.length; i2 < iLen; i2++) {
          cols[i2].sType = null;
          cols[i2].maxLenString = null;
        }
        _fnRowAttributes(settings, row);
      }
    }
    function _fnGetRowElements(settings, row, colIdx, d) {
      var tds = [], td = row.firstChild, name, col, i2 = 0, contents, columns = settings.aoColumns, objectRead = settings._rowReadObject;
      d = d !== void 0 ? d : objectRead ? {} : [];
      var attr = function(str, td2) {
        if (typeof str === "string") {
          var idx = str.indexOf("@");
          if (idx !== -1) {
            var attr2 = str.substring(idx + 1);
            var setter = _fnSetObjectDataFn(str);
            setter(d, td2.getAttribute(attr2));
          }
        }
      };
      var cellProcess = function(cell) {
        if (colIdx === void 0 || colIdx === i2) {
          col = columns[i2];
          contents = cell.innerHTML.trim();
          if (col && col._bAttrSrc) {
            var setter = _fnSetObjectDataFn(col.mData._);
            setter(d, contents);
            attr(col.mData.sort, cell);
            attr(col.mData.type, cell);
            attr(col.mData.filter, cell);
          } else {
            if (objectRead) {
              if (!col._setter) {
                col._setter = _fnSetObjectDataFn(col.mData);
              }
              col._setter(d, contents);
            } else {
              d[i2] = contents;
            }
          }
        }
        i2++;
      };
      if (td) {
        while (td) {
          name = td.nodeName.toUpperCase();
          if (name == "TD" || name == "TH") {
            cellProcess(td);
            tds.push(td);
          }
          td = td.nextSibling;
        }
      } else {
        tds = row.anCells;
        for (var j = 0, jen = tds.length; j < jen; j++) {
          cellProcess(tds[j]);
        }
      }
      var rowNode = row.firstChild ? row : row.nTr;
      if (rowNode) {
        var id = rowNode.getAttribute("id");
        if (id) {
          _fnSetObjectDataFn(settings.rowId)(d, id);
        }
      }
      return {
        data: d,
        cells: tds
      };
    }
    function _fnGetRowDisplay(settings, rowIdx) {
      var rowModal = settings.aoData[rowIdx];
      var columns = settings.aoColumns;
      if (!rowModal.displayData) {
        rowModal.displayData = [];
        for (var colIdx = 0, len = columns.length; colIdx < len; colIdx++) {
          rowModal.displayData.push(
            _fnGetCellData(settings, rowIdx, colIdx, "display")
          );
        }
      }
      return rowModal.displayData;
    }
    function _fnCreateTr(oSettings, iRow, nTrIn, anTds) {
      var row = oSettings.aoData[iRow], rowData = row._aData, cells = [], nTr, nTd, oCol, i2, iLen, create, trClass = oSettings.oClasses.tbody.row;
      if (row.nTr === null) {
        nTr = nTrIn || document.createElement("tr");
        row.nTr = nTr;
        row.anCells = cells;
        _addClass(nTr, trClass);
        nTr._DT_RowIndex = iRow;
        _fnRowAttributes(oSettings, row);
        for (i2 = 0, iLen = oSettings.aoColumns.length; i2 < iLen; i2++) {
          oCol = oSettings.aoColumns[i2];
          create = nTrIn && anTds[i2] ? false : true;
          nTd = create ? document.createElement(oCol.sCellType) : anTds[i2];
          if (!nTd) {
            _fnLog(oSettings, 0, "Incorrect column count", 18);
          }
          nTd._DT_CellIndex = {
            row: iRow,
            column: i2
          };
          cells.push(nTd);
          var display = _fnGetRowDisplay(oSettings, iRow);
          if (create || (oCol.mRender || oCol.mData !== i2) && (!$.isPlainObject(oCol.mData) || oCol.mData._ !== i2 + ".display")) {
            _fnWriteCell(nTd, display[i2]);
          }
          _addClass(nTd, oCol.sClass);
          if (oCol.bVisible && create) {
            nTr.appendChild(nTd);
          } else if (!oCol.bVisible && !create) {
            nTd.parentNode.removeChild(nTd);
          }
          if (oCol.fnCreatedCell) {
            oCol.fnCreatedCell.call(
              oSettings.oInstance,
              nTd,
              _fnGetCellData(oSettings, iRow, i2),
              rowData,
              iRow,
              i2
            );
          }
        }
        _fnCallbackFire(oSettings, "aoRowCreatedCallback", "row-created", [nTr, rowData, iRow, cells]);
      } else {
        _addClass(row.nTr, trClass);
      }
    }
    function _fnRowAttributes(settings, row) {
      var tr = row.nTr;
      var data = row._aData;
      if (tr) {
        var id = settings.rowIdFn(data);
        if (id) {
          tr.id = id;
        }
        if (data.DT_RowClass) {
          var a = data.DT_RowClass.split(" ");
          row.__rowc = row.__rowc ? _unique(row.__rowc.concat(a)) : a;
          $(tr).removeClass(row.__rowc.join(" ")).addClass(data.DT_RowClass);
        }
        if (data.DT_RowAttr) {
          $(tr).attr(data.DT_RowAttr);
        }
        if (data.DT_RowData) {
          $(tr).data(data.DT_RowData);
        }
      }
    }
    function _fnBuildHead(settings, side) {
      var classes = settings.oClasses;
      var columns = settings.aoColumns;
      var i2, iLen, row;
      var target = side === "header" ? settings.nTHead : settings.nTFoot;
      var titleProp = side === "header" ? "sTitle" : side;
      if (!target) {
        return;
      }
      if (side === "header" || _pluck(settings.aoColumns, titleProp).join("")) {
        row = $("tr", target);
        if (!row.length) {
          row = $("<tr/>").appendTo(target);
        }
        if (row.length === 1) {
          var cellCount = 0;
          $("td, th", row).each(function() {
            cellCount += this.colSpan;
          });
          for (i2 = cellCount, iLen = columns.length; i2 < iLen; i2++) {
            $("<th/>").html(columns[i2][titleProp] || "").appendTo(row);
          }
        }
      }
      var detected = _fnDetectHeader(settings, target, true);
      if (side === "header") {
        settings.aoHeader = detected;
        $("tr", target).addClass(classes.thead.row);
      } else {
        settings.aoFooter = detected;
        $("tr", target).addClass(classes.tfoot.row);
      }
      $(target).children("tr").children("th, td").each(function() {
        _fnRenderer(settings, side)(
          settings,
          $(this),
          classes
        );
      });
    }
    function _fnHeaderLayout(settings, source, incColumns) {
      var row, column, cell;
      var local = [];
      var structure = [];
      var columns = settings.aoColumns;
      var columnCount = columns.length;
      var rowspan, colspan;
      if (!source) {
        return;
      }
      if (!incColumns) {
        incColumns = _range(columnCount).filter(function(idx) {
          return columns[idx].bVisible;
        });
      }
      for (row = 0; row < source.length; row++) {
        local[row] = source[row].slice().filter(function(cell2, i2) {
          return incColumns.includes(i2);
        });
        structure.push([]);
      }
      for (row = 0; row < local.length; row++) {
        for (column = 0; column < local[row].length; column++) {
          rowspan = 1;
          colspan = 1;
          if (structure[row][column] === void 0) {
            cell = local[row][column].cell;
            while (local[row + rowspan] !== void 0 && local[row][column].cell == local[row + rowspan][column].cell) {
              structure[row + rowspan][column] = null;
              rowspan++;
            }
            while (local[row][column + colspan] !== void 0 && local[row][column].cell == local[row][column + colspan].cell) {
              for (var k = 0; k < rowspan; k++) {
                structure[row + k][column + colspan] = null;
              }
              colspan++;
            }
            var titleSpan = $("span.dt-column-title", cell);
            structure[row][column] = {
              cell,
              colspan,
              rowspan,
              title: titleSpan.length ? titleSpan.html() : $(cell).html()
            };
          }
        }
      }
      return structure;
    }
    function _fnDrawHead(settings, source) {
      var layout = _fnHeaderLayout(settings, source);
      var tr, n;
      for (var row = 0; row < source.length; row++) {
        tr = source[row].row;
        if (tr) {
          while (n = tr.firstChild) {
            tr.removeChild(n);
          }
        }
        for (var column = 0; column < layout[row].length; column++) {
          var point = layout[row][column];
          if (point) {
            $(point.cell).appendTo(tr).attr("rowspan", point.rowspan).attr("colspan", point.colspan);
          }
        }
      }
    }
    function _fnDraw(oSettings, ajaxComplete) {
      _fnStart(oSettings);
      var aPreDraw = _fnCallbackFire(oSettings, "aoPreDrawCallback", "preDraw", [oSettings]);
      if (aPreDraw.indexOf(false) !== -1) {
        _fnProcessingDisplay(oSettings, false);
        return;
      }
      var anRows = [];
      var iRowCount = 0;
      var bServerSide = _fnDataSource(oSettings) == "ssp";
      var aiDisplay = oSettings.aiDisplay;
      var iDisplayStart = oSettings._iDisplayStart;
      var iDisplayEnd = oSettings.fnDisplayEnd();
      var columns = oSettings.aoColumns;
      var body = $(oSettings.nTBody);
      oSettings.bDrawing = true;
      if (oSettings.deferLoading) {
        oSettings.deferLoading = false;
        oSettings.iDraw++;
        _fnProcessingDisplay(oSettings, false);
      } else if (!bServerSide) {
        oSettings.iDraw++;
      } else if (!oSettings.bDestroying && !ajaxComplete) {
        if (oSettings.iDraw === 0) {
          body.empty().append(_emptyRow(oSettings));
        }
        _fnAjaxUpdate(oSettings);
        return;
      }
      if (aiDisplay.length !== 0) {
        var iStart = bServerSide ? 0 : iDisplayStart;
        var iEnd = bServerSide ? oSettings.aoData.length : iDisplayEnd;
        for (var j = iStart; j < iEnd; j++) {
          var iDataIndex = aiDisplay[j];
          var aoData = oSettings.aoData[iDataIndex];
          if (aoData.nTr === null) {
            _fnCreateTr(oSettings, iDataIndex);
          }
          var nRow = aoData.nTr;
          for (var i2 = 0; i2 < columns.length; i2++) {
            var col = columns[i2];
            var td = aoData.anCells[i2];
            _addClass(td, _ext.type.className[col.sType]);
            _addClass(td, oSettings.oClasses.tbody.cell);
          }
          _fnCallbackFire(
            oSettings,
            "aoRowCallback",
            null,
            [nRow, aoData._aData, iRowCount, j, iDataIndex]
          );
          anRows.push(nRow);
          iRowCount++;
        }
      } else {
        anRows[0] = _emptyRow(oSettings);
      }
      _fnCallbackFire(oSettings, "aoHeaderCallback", "header", [
        $(oSettings.nTHead).children("tr")[0],
        _fnGetDataMaster(oSettings),
        iDisplayStart,
        iDisplayEnd,
        aiDisplay
      ]);
      _fnCallbackFire(oSettings, "aoFooterCallback", "footer", [
        $(oSettings.nTFoot).children("tr")[0],
        _fnGetDataMaster(oSettings),
        iDisplayStart,
        iDisplayEnd,
        aiDisplay
      ]);
      if (body[0].replaceChildren) {
        body[0].replaceChildren.apply(body[0], anRows);
      } else {
        body.children().detach();
        body.append($(anRows));
      }
      $(oSettings.nTableWrapper).toggleClass("dt-empty-footer", $("tr", oSettings.nTFoot).length === 0);
      _fnCallbackFire(oSettings, "aoDrawCallback", "draw", [oSettings], true);
      oSettings.bSorted = false;
      oSettings.bFiltered = false;
      oSettings.bDrawing = false;
    }
    function _fnReDraw(settings, holdPosition, recompute) {
      var features = settings.oFeatures, sort = features.bSort, filter = features.bFilter;
      if (recompute === void 0 || recompute === true) {
        _fnColumnTypes(settings);
        if (sort) {
          _fnSort(settings);
        }
        if (filter) {
          _fnFilterComplete(settings, settings.oPreviousSearch);
        } else {
          settings.aiDisplay = settings.aiDisplayMaster.slice();
        }
      }
      if (holdPosition !== true) {
        settings._iDisplayStart = 0;
      }
      settings._drawHold = holdPosition;
      _fnDraw(settings);
      settings.api.one("draw", function() {
        settings._drawHold = false;
      });
    }
    function _emptyRow(settings) {
      var oLang = settings.oLanguage;
      var zero = oLang.sZeroRecords;
      var dataSrc = _fnDataSource(settings);
      if ((dataSrc === "ssp" || dataSrc === "ajax") && !settings.json) {
        zero = oLang.sLoadingRecords;
      } else if (oLang.sEmptyTable && settings.fnRecordsTotal() === 0) {
        zero = oLang.sEmptyTable;
      }
      return $("<tr/>").append($("<td />", {
        "colSpan": _fnVisibleColumns(settings),
        "class": settings.oClasses.empty.row
      }).html(zero))[0];
    }
    function _layoutItems(row, align, items) {
      if (Array.isArray(items)) {
        for (var i2 = 0; i2 < items.length; i2++) {
          _layoutItems(row, align, items[i2]);
        }
        return;
      }
      var rowCell = row[align];
      if ($.isPlainObject(items)) {
        if (items.features) {
          if (items.rowId) {
            row.id = items.rowId;
          }
          if (items.rowClass) {
            row.className = items.rowClass;
          }
          rowCell.id = items.id;
          rowCell.className = items.className;
          _layoutItems(row, align, items.features);
        } else {
          Object.keys(items).map(function(key2) {
            rowCell.contents.push({
              feature: key2,
              opts: items[key2]
            });
          });
        }
      } else {
        rowCell.contents.push(items);
      }
    }
    function _layoutGetRow(rows, rowNum, align) {
      var row;
      for (var i2 = 0; i2 < rows.length; i2++) {
        row = rows[i2];
        if (row.rowNum === rowNum) {
          if (align === "full" && row.full || (align === "start" || align === "end") && (row.start || row.end)) {
            if (!row[align]) {
              row[align] = {
                contents: []
              };
            }
            return row;
          }
        }
      }
      row = {
        rowNum
      };
      row[align] = {
        contents: []
      };
      rows.push(row);
      return row;
    }
    function _layoutArray(settings, layout, side) {
      var rows = [];
      $.each(layout, function(pos, items) {
        if (items === null) {
          return;
        }
        var parts = pos.match(/^([a-z]+)([0-9]*)([A-Za-z]*)$/);
        var rowNum = parts[2] ? parts[2] * 1 : 0;
        var align = parts[3] ? parts[3].toLowerCase() : "full";
        if (parts[1] !== side) {
          return;
        }
        var row2 = _layoutGetRow(rows, rowNum, align);
        _layoutItems(row2, align, items);
      });
      rows.sort(function(a, b) {
        var order1 = a.rowNum;
        var order2 = b.rowNum;
        if (order1 === order2) {
          var ret = a.full && !b.full ? -1 : 1;
          return side === "bottom" ? ret * -1 : ret;
        }
        return order2 - order1;
      });
      if (side === "bottom") {
        rows.reverse();
      }
      for (var row = 0; row < rows.length; row++) {
        delete rows[row].rowNum;
        _layoutResolve(settings, rows[row]);
      }
      return rows;
    }
    function _layoutResolve(settings, row) {
      var getFeature = function(feature, opts) {
        if (!_ext.features[feature]) {
          _fnLog(settings, 0, "Unknown feature: " + feature);
        }
        return _ext.features[feature].apply(this, [settings, opts]);
      };
      var resolve = function(item) {
        if (!row[item]) {
          return;
        }
        var line = row[item].contents;
        for (var i2 = 0, iLen = line.length; i2 < iLen; i2++) {
          if (!line[i2]) {
            continue;
          } else if (typeof line[i2] === "string") {
            line[i2] = getFeature(line[i2], null);
          } else if ($.isPlainObject(line[i2])) {
            line[i2] = getFeature(line[i2].feature, line[i2].opts);
          } else if (typeof line[i2].node === "function") {
            line[i2] = line[i2].node(settings);
          } else if (typeof line[i2] === "function") {
            var inst = line[i2](settings);
            line[i2] = typeof inst.node === "function" ? inst.node() : inst;
          }
        }
      };
      resolve("start");
      resolve("end");
      resolve("full");
    }
    function _fnAddOptionsHtml(settings) {
      var classes = settings.oClasses;
      var table = $(settings.nTable);
      var insert = $("<div/>").attr({
        id: settings.sTableId + "_wrapper",
        "class": classes.container
      }).insertBefore(table);
      settings.nTableWrapper = insert[0];
      if (settings.sDom) {
        _fnLayoutDom(settings, settings.sDom, insert);
      } else {
        var top = _layoutArray(settings, settings.layout, "top");
        var bottom = _layoutArray(settings, settings.layout, "bottom");
        var renderer = _fnRenderer(settings, "layout");
        top.forEach(function(item) {
          renderer(settings, insert, item);
        });
        renderer(settings, insert, {
          full: {
            table: true,
            contents: [_fnFeatureHtmlTable(settings)]
          }
        });
        bottom.forEach(function(item) {
          renderer(settings, insert, item);
        });
      }
      _processingHtml(settings);
    }
    function _fnLayoutDom(settings, dom, insert) {
      var parts = dom.match(/(".*?")|('.*?')|./g);
      var featureNode, option, newNode, next, attr;
      for (var i2 = 0; i2 < parts.length; i2++) {
        featureNode = null;
        option = parts[i2];
        if (option == "<") {
          newNode = $("<div/>");
          next = parts[i2 + 1];
          if (next[0] == "'" || next[0] == '"') {
            attr = next.replace(/['"]/g, "");
            var id = "", className;
            if (attr.indexOf(".") != -1) {
              var split = attr.split(".");
              id = split[0];
              className = split[1];
            } else if (attr[0] == "#") {
              id = attr;
            } else {
              className = attr;
            }
            newNode.attr("id", id.substring(1)).addClass(className);
            i2++;
          }
          insert.append(newNode);
          insert = newNode;
        } else if (option == ">") {
          insert = insert.parent();
        } else if (option == "t") {
          featureNode = _fnFeatureHtmlTable(settings);
        } else {
          DataTable.ext.feature.forEach(function(feature) {
            if (option == feature.cFeature) {
              featureNode = feature.fnInit(settings);
            }
          });
        }
        if (featureNode) {
          insert.append(featureNode);
        }
      }
    }
    function _fnDetectHeader(settings, thead, write) {
      var columns = settings.aoColumns;
      var rows = $(thead).children("tr");
      var row, cell;
      var i2, k, l, iLen, shifted, column, colspan, rowspan;
      var titleRow = settings.titleRow;
      var isHeader = thead && thead.nodeName.toLowerCase() === "thead";
      var layout = [];
      var unique;
      var shift = function(a, i3, j) {
        var k2 = a[i3];
        while (k2[j]) {
          j++;
        }
        return j;
      };
      for (i2 = 0, iLen = rows.length; i2 < iLen; i2++) {
        layout.push([]);
      }
      for (i2 = 0, iLen = rows.length; i2 < iLen; i2++) {
        row = rows[i2];
        column = 0;
        cell = row.firstChild;
        while (cell) {
          if (cell.nodeName.toUpperCase() == "TD" || cell.nodeName.toUpperCase() == "TH") {
            var cols = [];
            var jqCell = $(cell);
            colspan = cell.getAttribute("colspan") * 1;
            rowspan = cell.getAttribute("rowspan") * 1;
            colspan = !colspan || colspan === 0 || colspan === 1 ? 1 : colspan;
            rowspan = !rowspan || rowspan === 0 || rowspan === 1 ? 1 : rowspan;
            shifted = shift(layout, i2, column);
            unique = colspan === 1 ? true : false;
            if (write) {
              if (unique) {
                _fnColumnOptions(settings, shifted, _fnEscapeObject(jqCell.data()));
                var columnDef = columns[shifted];
                var width = cell.getAttribute("width") || null;
                var t = cell.style.width.match(/width:\s*(\d+[pxem%]+)/);
                if (t) {
                  width = t[1];
                }
                columnDef.sWidthOrig = columnDef.sWidth || width;
                if (isHeader) {
                  if (columnDef.sTitle !== null && !columnDef.autoTitle) {
                    if (titleRow === true && i2 === 0 || // top row
                    titleRow === false && i2 === rows.length - 1 || // bottom row
                    titleRow === i2 || // specific row
                    titleRow === null) {
                      cell.innerHTML = columnDef.sTitle;
                    }
                  }
                  if (!columnDef.sTitle && unique) {
                    columnDef.sTitle = _stripHtml(cell.innerHTML);
                    columnDef.autoTitle = true;
                  }
                } else {
                  if (columnDef.footer) {
                    cell.innerHTML = columnDef.footer;
                  }
                }
                if (!columnDef.ariaTitle) {
                  columnDef.ariaTitle = jqCell.attr("aria-label") || columnDef.sTitle;
                }
                if (columnDef.className) {
                  jqCell.addClass(columnDef.className);
                }
              }
              if ($("span.dt-column-title", cell).length === 0) {
                $("<span>").addClass("dt-column-title").append(cell.childNodes).appendTo(cell);
              }
              if (settings.orderIndicators && isHeader && jqCell.filter(":not([data-dt-order=disable])").length !== 0 && jqCell.parent(":not([data-dt-order=disable])").length !== 0 && $("span.dt-column-order", cell).length === 0) {
                $("<span>").addClass("dt-column-order").appendTo(cell);
              }
              var headerFooter = isHeader ? "header" : "footer";
              if ($("span.dt-column-" + headerFooter, cell).length === 0) {
                $("<div>").addClass("dt-column-" + headerFooter).append(cell.childNodes).appendTo(cell);
              }
            }
            for (l = 0; l < colspan; l++) {
              for (k = 0; k < rowspan; k++) {
                layout[i2 + k][shifted + l] = {
                  cell,
                  unique
                };
                layout[i2 + k].row = row;
              }
              cols.push(shifted + l);
            }
            cell.setAttribute("data-dt-column", _unique(cols).join(","));
          }
          cell = cell.nextSibling;
        }
      }
      return layout;
    }
    function _fnStart(oSettings) {
      var bServerSide = _fnDataSource(oSettings) == "ssp";
      var iInitDisplayStart = oSettings.iInitDisplayStart;
      if (iInitDisplayStart !== void 0 && iInitDisplayStart !== -1) {
        oSettings._iDisplayStart = bServerSide ? iInitDisplayStart : iInitDisplayStart >= oSettings.fnRecordsDisplay() ? 0 : iInitDisplayStart;
        oSettings.iInitDisplayStart = -1;
      }
    }
    function _fnBuildAjax(oSettings, data, fn) {
      var ajaxData;
      var ajax = oSettings.ajax;
      var instance = oSettings.oInstance;
      var callback = function(json) {
        var status = oSettings.jqXHR ? oSettings.jqXHR.status : null;
        if (json === null || typeof status === "number" && status == 204) {
          json = {};
          _fnAjaxDataSrc(oSettings, json, []);
        }
        var error = json.error || json.sError;
        if (error) {
          _fnLog(oSettings, 0, error);
        }
        if (json.d && typeof json.d === "string") {
          try {
            json = JSON.parse(json.d);
          } catch (e) {
          }
        }
        oSettings.json = json;
        _fnCallbackFire(oSettings, null, "xhr", [oSettings, json, oSettings.jqXHR], true);
        fn(json);
      };
      if ($.isPlainObject(ajax) && ajax.data) {
        ajaxData = ajax.data;
        var newData = typeof ajaxData === "function" ? ajaxData(data, oSettings) : ajaxData;
        data = typeof ajaxData === "function" && newData ? newData : $.extend(true, data, newData);
        delete ajax.data;
      }
      var baseAjax = {
        url: typeof ajax === "string" ? ajax : "",
        data,
        success: callback,
        dataType: "json",
        cache: false,
        type: oSettings.sServerMethod,
        error: function(xhr, error) {
          var ret = _fnCallbackFire(
            oSettings,
            null,
            "xhr",
            [oSettings, null, oSettings.jqXHR],
            true
          );
          if (ret.indexOf(true) === -1) {
            if (error == "parsererror") {
              _fnLog(oSettings, 0, "Invalid JSON response", 1);
            } else if (xhr.readyState === 4) {
              _fnLog(oSettings, 0, "Ajax error", 7);
            }
          }
          _fnProcessingDisplay(oSettings, false);
        }
      };
      if ($.isPlainObject(ajax)) {
        $.extend(baseAjax, ajax);
      }
      oSettings.oAjaxData = data;
      _fnCallbackFire(oSettings, null, "preXhr", [oSettings, data, baseAjax], true);
      if (baseAjax.submitAs === "json" && typeof data === "object") {
        baseAjax.data = JSON.stringify(data);
      }
      if (typeof ajax === "function") {
        oSettings.jqXHR = ajax.call(instance, data, callback, oSettings);
      } else if (ajax.url === "") {
        var empty = {};
        _fnAjaxDataSrc(oSettings, empty, []);
        callback(empty);
      } else {
        oSettings.jqXHR = $.ajax(baseAjax);
      }
      if (ajaxData) {
        ajax.data = ajaxData;
      }
    }
    function _fnAjaxUpdate(settings) {
      settings.iDraw++;
      _fnProcessingDisplay(settings, true);
      _fnBuildAjax(settings, _fnAjaxParameters(settings), function(json) {
        _fnAjaxUpdateDraw(settings, json);
      });
    }
    function _fnAjaxParameters(settings) {
      var columns = settings.aoColumns, features = settings.oFeatures, preSearch = settings.oPreviousSearch, preColSearch = settings.aoPreSearchCols, colData = function(idx, prop) {
        return typeof columns[idx][prop] === "function" ? "function" : columns[idx][prop];
      };
      return {
        draw: settings.iDraw,
        columns: columns.map(function(column, i2) {
          return {
            data: colData(i2, "mData"),
            name: column.sName,
            searchable: column.bSearchable,
            orderable: column.bSortable,
            search: {
              value: preColSearch[i2].search,
              regex: preColSearch[i2].regex,
              fixed: Object.keys(column.searchFixed).map(function(name) {
                return {
                  name,
                  term: typeof column.searchFixed[name] !== "function" ? column.searchFixed[name].toString() : "function"
                };
              })
            }
          };
        }),
        order: _fnSortFlatten(settings).map(function(val) {
          return {
            column: val.col,
            dir: val.dir,
            name: colData(val.col, "sName")
          };
        }),
        start: settings._iDisplayStart,
        length: features.bPaginate ? settings._iDisplayLength : -1,
        search: {
          value: preSearch.search,
          regex: preSearch.regex,
          fixed: Object.keys(settings.searchFixed).map(function(name) {
            return {
              name,
              term: typeof settings.searchFixed[name] !== "function" ? settings.searchFixed[name].toString() : "function"
            };
          })
        }
      };
    }
    function _fnAjaxUpdateDraw(settings, json) {
      var data = _fnAjaxDataSrc(settings, json);
      var draw = _fnAjaxDataSrcParam(settings, "draw", json);
      var recordsTotal = _fnAjaxDataSrcParam(settings, "recordsTotal", json);
      var recordsFiltered = _fnAjaxDataSrcParam(settings, "recordsFiltered", json);
      if (draw !== void 0) {
        if (draw * 1 < settings.iDraw) {
          return;
        }
        settings.iDraw = draw * 1;
      }
      if (!data) {
        data = [];
      }
      _fnClearTable(settings);
      settings._iRecordsTotal = parseInt(recordsTotal, 10);
      settings._iRecordsDisplay = parseInt(recordsFiltered, 10);
      for (var i2 = 0, iLen = data.length; i2 < iLen; i2++) {
        _fnAddData(settings, data[i2]);
      }
      settings.aiDisplay = settings.aiDisplayMaster.slice();
      _fnColumnTypes(settings);
      _fnDraw(settings, true);
      _fnInitComplete(settings);
      _fnProcessingDisplay(settings, false);
    }
    function _fnAjaxDataSrc(settings, json, write) {
      var dataProp = "data";
      if ($.isPlainObject(settings.ajax) && settings.ajax.dataSrc !== void 0) {
        var dataSrc = settings.ajax.dataSrc;
        if (typeof dataSrc === "string" || typeof dataSrc === "function") {
          dataProp = dataSrc;
        } else if (dataSrc.data !== void 0) {
          dataProp = dataSrc.data;
        }
      }
      if (!write) {
        if (dataProp === "data") {
          return json.aaData || json[dataProp];
        }
        return dataProp !== "" ? _fnGetObjectDataFn(dataProp)(json) : json;
      }
      _fnSetObjectDataFn(dataProp)(json, write);
    }
    function _fnAjaxDataSrcParam(settings, param, json) {
      var dataSrc = $.isPlainObject(settings.ajax) ? settings.ajax.dataSrc : null;
      if (dataSrc && dataSrc[param]) {
        return _fnGetObjectDataFn(dataSrc[param])(json);
      }
      var old = "";
      if (param === "draw") {
        old = "sEcho";
      } else if (param === "recordsTotal") {
        old = "iTotalRecords";
      } else if (param === "recordsFiltered") {
        old = "iTotalDisplayRecords";
      }
      return json[old] !== void 0 ? json[old] : json[param];
    }
    function _fnFilterComplete(settings, input) {
      var columnsSearch = settings.aoPreSearchCols;
      if (_fnDataSource(settings) != "ssp") {
        _fnFilterData(settings);
        settings.aiDisplay = settings.aiDisplayMaster.slice();
        _fnFilter(settings.aiDisplay, settings, input.search, input);
        $.each(settings.searchFixed, function(name, term) {
          _fnFilter(settings.aiDisplay, settings, term, {});
        });
        for (var i2 = 0; i2 < columnsSearch.length; i2++) {
          var col = columnsSearch[i2];
          _fnFilter(
            settings.aiDisplay,
            settings,
            col.search,
            col,
            i2
          );
          $.each(settings.aoColumns[i2].searchFixed, function(name, term) {
            _fnFilter(settings.aiDisplay, settings, term, {}, i2);
          });
        }
        _fnFilterCustom(settings);
      }
      settings.bFiltered = true;
      _fnCallbackFire(settings, null, "search", [settings]);
    }
    function _fnFilterCustom(settings) {
      var filters = DataTable.ext.search;
      var displayRows = settings.aiDisplay;
      var row, rowIdx;
      for (var i2 = 0, iLen = filters.length; i2 < iLen; i2++) {
        var rows = [];
        for (var j = 0, jen = displayRows.length; j < jen; j++) {
          rowIdx = displayRows[j];
          row = settings.aoData[rowIdx];
          if (filters[i2](settings, row._aFilterData, rowIdx, row._aData, j)) {
            rows.push(rowIdx);
          }
        }
        displayRows.length = 0;
        _fnArrayApply(displayRows, rows);
      }
    }
    function _fnFilter(searchRows, settings, input, options, column) {
      if (input === "") {
        return;
      }
      var i2 = 0;
      var matched = [];
      var searchFunc = typeof input === "function" ? input : null;
      var rpSearch = input instanceof RegExp ? input : searchFunc ? null : _fnFilterCreateSearch(input, options);
      for (i2 = 0; i2 < searchRows.length; i2++) {
        var row = settings.aoData[searchRows[i2]];
        var data = column === void 0 ? row._sFilterRow : row._aFilterData[column];
        if (searchFunc && searchFunc(data, row._aData, searchRows[i2], column) || rpSearch && rpSearch.test(data)) {
          matched.push(searchRows[i2]);
        }
      }
      searchRows.length = matched.length;
      for (i2 = 0; i2 < matched.length; i2++) {
        searchRows[i2] = matched[i2];
      }
    }
    function _fnFilterCreateSearch(search, inOpts) {
      var not = [];
      var options = $.extend({}, {
        boundary: false,
        caseInsensitive: true,
        exact: false,
        regex: false,
        smart: true
      }, inOpts);
      if (typeof search !== "string") {
        search = search.toString();
      }
      search = _normalize(search);
      if (options.exact) {
        return new RegExp(
          "^" + _fnEscapeRegex(search) + "$",
          options.caseInsensitive ? "i" : ""
        );
      }
      search = options.regex ? search : _fnEscapeRegex(search);
      if (options.smart) {
        var parts = search.match(/!?["\u201C][^"\u201D]+["\u201D]|[^ ]+/g) || [""];
        var a = parts.map(function(word) {
          var negative = false;
          var m;
          if (word.charAt(0) === "!") {
            negative = true;
            word = word.substring(1);
          }
          if (word.charAt(0) === '"') {
            m = word.match(/^"(.*)"$/);
            word = m ? m[1] : word;
          } else if (word.charAt(0) === "“") {
            m = word.match(/^\u201C(.*)\u201D$/);
            word = m ? m[1] : word;
          }
          if (negative) {
            if (word.length > 1) {
              not.push("(?!" + word + ")");
            }
            word = "";
          }
          return word.replace(/"/g, "");
        });
        var match = not.length ? not.join("") : "";
        var boundary = options.boundary ? "\\b" : "";
        search = "^(?=.*?" + boundary + a.join(")(?=.*?" + boundary) + ")(" + match + ".)*$";
      }
      return new RegExp(search, options.caseInsensitive ? "i" : "");
    }
    var _fnEscapeRegex = DataTable.util.escapeRegex;
    var __filter_div = $("<div>")[0];
    var __filter_div_textContent = __filter_div.textContent !== void 0;
    function _fnFilterData(settings) {
      var columns = settings.aoColumns;
      var data = settings.aoData;
      var column;
      var j, jen, filterData, cellData, row;
      var wasInvalidated = false;
      for (var rowIdx = 0; rowIdx < data.length; rowIdx++) {
        if (!data[rowIdx]) {
          continue;
        }
        row = data[rowIdx];
        if (!row._aFilterData) {
          filterData = [];
          for (j = 0, jen = columns.length; j < jen; j++) {
            column = columns[j];
            if (column.bSearchable) {
              cellData = _fnGetCellData(settings, rowIdx, j, "filter");
              if (cellData === null) {
                cellData = "";
              }
              if (typeof cellData !== "string" && cellData.toString) {
                cellData = cellData.toString();
              }
            } else {
              cellData = "";
            }
            if (cellData.indexOf && cellData.indexOf("&") !== -1) {
              __filter_div.innerHTML = cellData;
              cellData = __filter_div_textContent ? __filter_div.textContent : __filter_div.innerText;
            }
            if (cellData.replace) {
              cellData = cellData.replace(/[\r\n\u2028]/g, "");
            }
            filterData.push(cellData);
          }
          row._aFilterData = filterData;
          row._sFilterRow = filterData.join("  ");
          wasInvalidated = true;
        }
      }
      return wasInvalidated;
    }
    function _fnInitialise(settings) {
      var i2;
      var init = settings.oInit;
      var deferLoading = settings.deferLoading;
      var dataSrc = _fnDataSource(settings);
      if (!settings.bInitialised) {
        setTimeout(function() {
          _fnInitialise(settings);
        }, 200);
        return;
      }
      _fnBuildHead(settings, "header");
      _fnBuildHead(settings, "footer");
      _fnLoadState(settings, init, function() {
        _fnDrawHead(settings, settings.aoHeader);
        _fnDrawHead(settings, settings.aoFooter);
        var iAjaxStart = settings.iInitDisplayStart;
        if (init.aaData) {
          for (i2 = 0; i2 < init.aaData.length; i2++) {
            _fnAddData(settings, init.aaData[i2]);
          }
        } else if (deferLoading || dataSrc == "dom") {
          _fnAddTr(settings, $(settings.nTBody).children("tr"));
        }
        settings.aiDisplay = settings.aiDisplayMaster.slice();
        _fnAddOptionsHtml(settings);
        _fnSortInit(settings);
        _colGroup(settings);
        _fnProcessingDisplay(settings, true);
        _fnCallbackFire(settings, null, "preInit", [settings], true);
        _fnReDraw(settings);
        if (dataSrc != "ssp" || deferLoading) {
          if (dataSrc == "ajax") {
            _fnBuildAjax(settings, {}, function(json) {
              var aData = _fnAjaxDataSrc(settings, json);
              for (i2 = 0; i2 < aData.length; i2++) {
                _fnAddData(settings, aData[i2]);
              }
              settings.iInitDisplayStart = iAjaxStart;
              _fnReDraw(settings);
              _fnProcessingDisplay(settings, false);
              _fnInitComplete(settings);
            });
          } else {
            _fnInitComplete(settings);
            _fnProcessingDisplay(settings, false);
          }
        }
      });
    }
    function _fnInitComplete(settings) {
      if (settings._bInitComplete) {
        return;
      }
      var args = [settings, settings.json];
      settings._bInitComplete = true;
      _fnAdjustColumnSizing(settings);
      _fnCallbackFire(settings, null, "plugin-init", args, true);
      _fnCallbackFire(settings, "aoInitComplete", "init", args, true);
    }
    function _fnLengthChange(settings, val) {
      var len = parseInt(val, 10);
      settings._iDisplayLength = len;
      _fnLengthOverflow(settings);
      _fnCallbackFire(settings, null, "length", [settings, len]);
    }
    function _fnPageChange(settings, action, redraw) {
      var start = settings._iDisplayStart, len = settings._iDisplayLength, records = settings.fnRecordsDisplay();
      if (records === 0 || len === -1) {
        start = 0;
      } else if (typeof action === "number") {
        start = action * len;
        if (start > records) {
          start = 0;
        }
      } else if (action == "first") {
        start = 0;
      } else if (action == "previous") {
        start = len >= 0 ? start - len : 0;
        if (start < 0) {
          start = 0;
        }
      } else if (action == "next") {
        if (start + len < records) {
          start += len;
        }
      } else if (action == "last") {
        start = Math.floor((records - 1) / len) * len;
      } else if (action === "ellipsis") {
        return;
      } else {
        _fnLog(settings, 0, "Unknown paging action: " + action, 5);
      }
      var changed = settings._iDisplayStart !== start;
      settings._iDisplayStart = start;
      _fnCallbackFire(settings, null, changed ? "page" : "page-nc", [settings]);
      if (changed && redraw) {
        _fnDraw(settings);
      }
      return changed;
    }
    function _processingHtml(settings) {
      var table = settings.nTable;
      var scrolling = settings.oScroll.sX !== "" || settings.oScroll.sY !== "";
      if (settings.oFeatures.bProcessing) {
        var n = $("<div/>", {
          "id": settings.sTableId + "_processing",
          "class": settings.oClasses.processing.container,
          "role": "status"
        }).html(settings.oLanguage.sProcessing).append("<div><div></div><div></div><div></div><div></div></div>");
        if (scrolling) {
          n.prependTo($("div.dt-scroll", settings.nTableWrapper));
        } else {
          n.insertBefore(table);
        }
        $(table).on("processing.dt.DT", function(e, s, show) {
          n.css("display", show ? "block" : "none");
        });
      }
    }
    function _fnProcessingDisplay(settings, show) {
      if (settings.bDrawing && show === false) {
        return;
      }
      _fnCallbackFire(settings, null, "processing", [settings, show]);
    }
    function _fnProcessingRun(settings, enable, run) {
      if (!enable) {
        run();
      } else {
        _fnProcessingDisplay(settings, true);
        setTimeout(function() {
          run();
          _fnProcessingDisplay(settings, false);
        }, 0);
      }
    }
    function _fnFeatureHtmlTable(settings) {
      var table = $(settings.nTable);
      var scroll = settings.oScroll;
      if (scroll.sX === "" && scroll.sY === "") {
        return settings.nTable;
      }
      var scrollX = scroll.sX;
      var scrollY = scroll.sY;
      var classes = settings.oClasses.scrolling;
      var caption = settings.captionNode;
      var captionSide = caption ? caption._captionSide : null;
      var headerClone = $(table[0].cloneNode(false));
      var footerClone = $(table[0].cloneNode(false));
      var footer = table.children("tfoot");
      var _div = "<div/>";
      var size = function(s) {
        return !s ? null : _fnStringToCss(s);
      };
      if (!footer.length) {
        footer = null;
      }
      var scroller = $(_div, { "class": classes.container }).append(
        $(_div, { "class": classes.header.self }).css({
          overflow: "hidden",
          position: "relative",
          border: 0,
          width: scrollX ? size(scrollX) : "100%"
        }).append(
          $(_div, { "class": classes.header.inner }).css({
            "box-sizing": "content-box",
            width: scroll.sXInner || "100%"
          }).append(
            headerClone.removeAttr("id").css("margin-left", 0).append(captionSide === "top" ? caption : null).append(
              table.children("thead")
            )
          )
        )
      ).append(
        $(_div, { "class": classes.body }).css({
          position: "relative",
          overflow: "auto",
          width: size(scrollX)
        }).append(table)
      );
      if (footer) {
        scroller.append(
          $(_div, { "class": classes.footer.self }).css({
            overflow: "hidden",
            border: 0,
            width: scrollX ? size(scrollX) : "100%"
          }).append(
            $(_div, { "class": classes.footer.inner }).append(
              footerClone.removeAttr("id").css("margin-left", 0).append(captionSide === "bottom" ? caption : null).append(
                table.children("tfoot")
              )
            )
          )
        );
      }
      var children = scroller.children();
      var scrollHead = children[0];
      var scrollBody = children[1];
      var scrollFoot = footer ? children[2] : null;
      $(scrollBody).on("scroll.DT", function() {
        var scrollLeft = this.scrollLeft;
        scrollHead.scrollLeft = scrollLeft;
        if (footer) {
          scrollFoot.scrollLeft = scrollLeft;
        }
      });
      $("th, td", scrollHead).on("focus", function() {
        var scrollLeft = scrollHead.scrollLeft;
        scrollBody.scrollLeft = scrollLeft;
        if (footer) {
          scrollBody.scrollLeft = scrollLeft;
        }
      });
      $(scrollBody).css("max-height", scrollY);
      if (!scroll.bCollapse) {
        $(scrollBody).css("height", scrollY);
      }
      settings.nScrollHead = scrollHead;
      settings.nScrollBody = scrollBody;
      settings.nScrollFoot = scrollFoot;
      settings.aoDrawCallback.push(_fnScrollDraw);
      return scroller[0];
    }
    function _fnScrollDraw(settings) {
      var scroll = settings.oScroll, barWidth = scroll.iBarWidth, divHeader = $(settings.nScrollHead), divHeaderInner = divHeader.children("div"), divHeaderTable = divHeaderInner.children("table"), divBodyEl = settings.nScrollBody, divBody = $(divBodyEl), divFooter = $(settings.nScrollFoot), divFooterInner = divFooter.children("div"), divFooterTable = divFooterInner.children("table"), header = $(settings.nTHead), table = $(settings.nTable), footer = settings.nTFoot && $("th, td", settings.nTFoot).length ? $(settings.nTFoot) : null, browser = settings.oBrowser, headerCopy, footerCopy;
      var scrollBarVis = divBodyEl.scrollHeight > divBodyEl.clientHeight;
      if (settings.scrollBarVis !== scrollBarVis && settings.scrollBarVis !== void 0) {
        settings.scrollBarVis = scrollBarVis;
        _fnAdjustColumnSizing(settings);
        return;
      } else {
        settings.scrollBarVis = scrollBarVis;
      }
      table.children("thead, tfoot").remove();
      headerCopy = header.clone().prependTo(table);
      headerCopy.find("th, td").removeAttr("tabindex");
      headerCopy.find("[id]").removeAttr("id");
      if (footer) {
        footerCopy = footer.clone().prependTo(table);
        footerCopy.find("[id]").removeAttr("id");
      }
      if (settings.aiDisplay.length) {
        var firstTr = null;
        var start = _fnDataSource(settings) !== "ssp" ? settings._iDisplayStart : 0;
        for (i2 = start; i2 < start + settings.aiDisplay.length; i2++) {
          var idx = settings.aiDisplay[i2];
          var tr = settings.aoData[idx].nTr;
          if (tr) {
            firstTr = tr;
            break;
          }
        }
        if (firstTr) {
          var colSizes = $(firstTr).children("th, td").map(function(vis) {
            return {
              idx: _fnVisibleToColumnIndex(settings, vis),
              width: $(this).outerWidth()
            };
          });
          for (var i2 = 0; i2 < colSizes.length; i2++) {
            var colEl = settings.aoColumns[colSizes[i2].idx].colEl[0];
            var colWidth = colEl.style.width.replace("px", "");
            if (colWidth !== colSizes[i2].width) {
              colEl.style.width = colSizes[i2].width + "px";
              if (scroll.sX) {
                colEl.style.minWidth = colSizes[i2].width + "px";
              }
            }
          }
        }
      }
      divHeaderTable.find("colgroup").remove();
      divHeaderTable.append(settings.colgroup.clone());
      if (footer) {
        divFooterTable.find("colgroup").remove();
        divFooterTable.append(settings.colgroup.clone());
      }
      $("th, td", headerCopy).each(function() {
        $(this.childNodes).wrapAll('<div class="dt-scroll-sizing">');
      });
      if (footer) {
        $("th, td", footerCopy).each(function() {
          $(this.childNodes).wrapAll('<div class="dt-scroll-sizing">');
        });
      }
      var isScrolling = Math.floor(table.height()) > divBodyEl.clientHeight || divBody.css("overflow-y") == "scroll";
      var paddingSide = "padding" + (browser.bScrollbarLeft ? "Left" : "Right");
      var outerWidth = table.outerWidth();
      divHeaderTable.css("width", _fnStringToCss(outerWidth));
      divHeaderInner.css("width", _fnStringToCss(outerWidth)).css(paddingSide, isScrolling ? barWidth + "px" : "0px");
      if (footer) {
        divFooterTable.css("width", _fnStringToCss(outerWidth));
        divFooterInner.css("width", _fnStringToCss(outerWidth)).css(paddingSide, isScrolling ? barWidth + "px" : "0px");
      }
      table.children("colgroup").prependTo(table);
      divBody.trigger("scroll");
      if ((settings.bSorted || settings.bFiltered) && !settings._drawHold) {
        divBodyEl.scrollTop = 0;
      }
    }
    function _fnCalculateColumnWidths(settings) {
      if (!settings.oFeatures.bAutoWidth) {
        return;
      }
      var table = settings.nTable, columns = settings.aoColumns, scroll = settings.oScroll, scrollY = scroll.sY, scrollX = scroll.sX, scrollXInner = scroll.sXInner, visibleColumns = _fnGetColumns(settings, "bVisible"), tableWidthAttr = table.getAttribute("width"), tableContainer = table.parentNode, i2, column, columnIdx;
      var styleWidth = table.style.width;
      var containerWidth = _fnWrapperWidth(settings);
      if (containerWidth === settings.containerWidth) {
        return false;
      }
      settings.containerWidth = containerWidth;
      if (!styleWidth && !tableWidthAttr) {
        table.style.width = "100%";
        styleWidth = "100%";
      }
      if (styleWidth && styleWidth.indexOf("%") !== -1) {
        tableWidthAttr = styleWidth;
      }
      _fnCallbackFire(
        settings,
        null,
        "column-calc",
        { visible: visibleColumns },
        false
      );
      var tmpTable = $(table.cloneNode()).css("visibility", "hidden").removeAttr("id");
      tmpTable.append("<tbody/>");
      var tr = $("<tr/>").appendTo(tmpTable.find("tbody"));
      tmpTable.append($(settings.nTHead).clone()).append($(settings.nTFoot).clone());
      tmpTable.find("tfoot th, tfoot td").css("width", "");
      tmpTable.find("thead th, thead td").each(function() {
        var width = _fnColumnsSumWidth(settings, this, true);
        if (width) {
          this.style.width = width;
          if (scrollX) {
            this.style.minWidth = width;
            $(this).append($("<div/>").css({
              width,
              margin: 0,
              padding: 0,
              border: 0,
              height: 1
            }));
          }
        } else {
          this.style.width = "";
        }
      });
      for (i2 = 0; i2 < visibleColumns.length; i2++) {
        columnIdx = visibleColumns[i2];
        column = columns[columnIdx];
        var longest = _fnGetMaxLenString(settings, columnIdx);
        var autoClass = _ext.type.className[column.sType];
        var text = longest + column.sContentPadding;
        var insert = longest.indexOf("<") === -1 ? document.createTextNode(text) : text;
        $("<td/>").addClass(autoClass).addClass(column.sClass).append(insert).appendTo(tr);
      }
      $("[name]", tmpTable).removeAttr("name");
      var holder = $("<div/>").css(
        scrollX || scrollY ? {
          position: "absolute",
          top: 0,
          left: 0,
          height: 1,
          right: 0,
          overflow: "hidden"
        } : {}
      ).append(tmpTable).appendTo(tableContainer);
      if (scrollX && scrollXInner) {
        tmpTable.width(scrollXInner);
      } else if (scrollX) {
        tmpTable.css("width", "auto");
        tmpTable.removeAttr("width");
        if (tmpTable.outerWidth() < tableContainer.clientWidth && tableWidthAttr) {
          tmpTable.outerWidth(tableContainer.clientWidth);
        }
      } else if (scrollY) {
        tmpTable.outerWidth(tableContainer.clientWidth);
      } else if (tableWidthAttr) {
        tmpTable.outerWidth(tableWidthAttr);
      }
      var total = 0;
      var bodyCells = tmpTable.find("tbody tr").eq(0).children();
      for (i2 = 0; i2 < visibleColumns.length; i2++) {
        var bounding = bodyCells[i2].getBoundingClientRect().width;
        total += bounding;
        columns[visibleColumns[i2]].sWidth = _fnStringToCss(bounding);
      }
      table.style.width = _fnStringToCss(total);
      holder.remove();
      if (tableWidthAttr) {
        table.style.width = _fnStringToCss(tableWidthAttr);
      }
      if ((tableWidthAttr || scrollX) && !settings._reszEvt) {
        var resize = DataTable.util.throttle(function() {
          var newWidth = _fnWrapperWidth(settings);
          if (!settings.bDestroying && newWidth !== 0) {
            _fnAdjustColumnSizing(settings);
          }
        });
        if (window.ResizeObserver) {
          var first = $(settings.nTableWrapper).is(":visible");
          var resizer = $("<div>").css({
            width: "100%",
            height: 0
          }).addClass("dt-autosize").appendTo(settings.nTableWrapper);
          settings.resizeObserver = new ResizeObserver(function(e) {
            if (first) {
              first = false;
            } else {
              resize();
            }
          });
          settings.resizeObserver.observe(resizer[0]);
        } else {
          $(window).on("resize.DT-" + settings.sInstance, resize);
        }
        settings._reszEvt = true;
      }
    }
    function _fnWrapperWidth(settings) {
      return $(settings.nTableWrapper).is(":visible") ? $(settings.nTableWrapper).width() : 0;
    }
    function _fnGetMaxLenString(settings, colIdx) {
      var column = settings.aoColumns[colIdx];
      if (!column.maxLenString) {
        var s, max = "", maxLen = -1;
        for (var i2 = 0, iLen = settings.aiDisplayMaster.length; i2 < iLen; i2++) {
          var rowIdx = settings.aiDisplayMaster[i2];
          var data = _fnGetRowDisplay(settings, rowIdx)[colIdx];
          var cellString = data && typeof data === "object" && data.nodeType ? data.innerHTML : data + "";
          cellString = cellString.replace(/id=".*?"/g, "").replace(/name=".*?"/g, "");
          s = _stripHtml(cellString).replace(/&nbsp;/g, " ");
          if (s.length > maxLen) {
            max = cellString;
            maxLen = s.length;
          }
        }
        column.maxLenString = max;
      }
      return column.maxLenString;
    }
    function _fnStringToCss(s) {
      if (s === null) {
        return "0px";
      }
      if (typeof s == "number") {
        return s < 0 ? "0px" : s + "px";
      }
      return s.match(/\d$/) ? s + "px" : s;
    }
    function _colGroup(settings) {
      var cols = settings.aoColumns;
      settings.colgroup.empty();
      for (i = 0; i < cols.length; i++) {
        if (cols[i].bVisible) {
          settings.colgroup.append(cols[i].colEl);
        }
      }
    }
    function _fnSortInit(settings) {
      var target = settings.nTHead;
      var headerRows = target.querySelectorAll("tr");
      var titleRow = settings.titleRow;
      var notSelector = ':not([data-dt-order="disable"]):not([data-dt-order="icon-only"])';
      if (titleRow === true) {
        target = headerRows[0];
      } else if (titleRow === false) {
        target = headerRows[headerRows.length - 1];
      } else if (titleRow !== null) {
        target = headerRows[titleRow];
      }
      if (settings.orderHandler) {
        _fnSortAttachListener(
          settings,
          target,
          target === settings.nTHead ? "tr" + notSelector + " th" + notSelector + ", tr" + notSelector + " td" + notSelector : "th" + notSelector + ", td" + notSelector
        );
      }
      var order = [];
      _fnSortResolve(settings, order, settings.aaSorting);
      settings.aaSorting = order;
    }
    function _fnSortAttachListener(settings, node, selector, column, callback) {
      _fnBindAction(node, selector, function(e) {
        var run = false;
        var columns = column === void 0 ? _fnColumnsFromHeader(e.target) : typeof column === "function" ? column() : Array.isArray(column) ? column : [column];
        if (columns.length) {
          for (var i2 = 0, iLen = columns.length; i2 < iLen; i2++) {
            var ret = _fnSortAdd(settings, columns[i2], i2, e.shiftKey);
            if (ret !== false) {
              run = true;
            }
            if (settings.aaSorting.length === 1 && settings.aaSorting[0][1] === "") {
              break;
            }
          }
          if (run) {
            _fnProcessingRun(settings, true, function() {
              _fnSort(settings);
              _fnSortDisplay(settings, settings.aiDisplay);
              _fnReDraw(settings, false, false);
              if (callback) {
                callback();
              }
            });
          }
        }
      });
    }
    function _fnSortDisplay(settings, display) {
      if (display.length < 2) {
        return;
      }
      var master = settings.aiDisplayMaster;
      var masterMap = {};
      var map = {};
      var i2;
      for (i2 = 0; i2 < master.length; i2++) {
        masterMap[master[i2]] = i2;
      }
      for (i2 = 0; i2 < display.length; i2++) {
        map[display[i2]] = masterMap[display[i2]];
      }
      display.sort(function(a, b) {
        return map[a] - map[b];
      });
    }
    function _fnSortResolve(settings, nestedSort, sort) {
      var push = function(a) {
        if ($.isPlainObject(a)) {
          if (a.idx !== void 0) {
            nestedSort.push([a.idx, a.dir]);
          } else if (a.name) {
            var cols = _pluck(settings.aoColumns, "sName");
            var idx = cols.indexOf(a.name);
            if (idx !== -1) {
              nestedSort.push([idx, a.dir]);
            }
          }
        } else {
          nestedSort.push(a);
        }
      };
      if ($.isPlainObject(sort)) {
        push(sort);
      } else if (sort.length && typeof sort[0] === "number") {
        push(sort);
      } else if (sort.length) {
        for (var z = 0; z < sort.length; z++) {
          push(sort[z]);
        }
      }
    }
    function _fnSortFlatten(settings) {
      var i2, k, kLen, aSort = [], extSort = DataTable.ext.type.order, aoColumns = settings.aoColumns, aDataSort, iCol, sType, srcCol, fixed = settings.aaSortingFixed, fixedObj = $.isPlainObject(fixed), nestedSort = [];
      if (!settings.oFeatures.bSort) {
        return aSort;
      }
      if (Array.isArray(fixed)) {
        _fnSortResolve(settings, nestedSort, fixed);
      }
      if (fixedObj && fixed.pre) {
        _fnSortResolve(settings, nestedSort, fixed.pre);
      }
      _fnSortResolve(settings, nestedSort, settings.aaSorting);
      if (fixedObj && fixed.post) {
        _fnSortResolve(settings, nestedSort, fixed.post);
      }
      for (i2 = 0; i2 < nestedSort.length; i2++) {
        srcCol = nestedSort[i2][0];
        if (aoColumns[srcCol]) {
          aDataSort = aoColumns[srcCol].aDataSort;
          for (k = 0, kLen = aDataSort.length; k < kLen; k++) {
            iCol = aDataSort[k];
            sType = aoColumns[iCol].sType || "string";
            if (nestedSort[i2]._idx === void 0) {
              nestedSort[i2]._idx = aoColumns[iCol].asSorting.indexOf(nestedSort[i2][1]);
            }
            if (nestedSort[i2][1]) {
              aSort.push({
                src: srcCol,
                col: iCol,
                dir: nestedSort[i2][1],
                index: nestedSort[i2]._idx,
                type: sType,
                formatter: extSort[sType + "-pre"],
                sorter: extSort[sType + "-" + nestedSort[i2][1]]
              });
            }
          }
        }
      }
      return aSort;
    }
    function _fnSort(oSettings, col, dir) {
      var i2, iLen, aiOrig = [], extSort = DataTable.ext.type.order, aoData = oSettings.aoData, sortCol, displayMaster = oSettings.aiDisplayMaster, aSort;
      _fnColumnTypes(oSettings);
      if (col !== void 0) {
        var srcCol = oSettings.aoColumns[col];
        aSort = [{
          src: col,
          col,
          dir,
          index: 0,
          type: srcCol.sType,
          formatter: extSort[srcCol.sType + "-pre"],
          sorter: extSort[srcCol.sType + "-" + dir]
        }];
        displayMaster = displayMaster.slice();
      } else {
        aSort = _fnSortFlatten(oSettings);
      }
      for (i2 = 0, iLen = aSort.length; i2 < iLen; i2++) {
        sortCol = aSort[i2];
        _fnSortData(oSettings, sortCol.col);
      }
      if (_fnDataSource(oSettings) != "ssp" && aSort.length !== 0) {
        for (i2 = 0, iLen = displayMaster.length; i2 < iLen; i2++) {
          aiOrig[i2] = i2;
        }
        if (aSort.length && aSort[0].dir === "desc" && oSettings.orderDescReverse) {
          aiOrig.reverse();
        }
        displayMaster.sort(function(a, b) {
          var x, y, k, test, sort, len = aSort.length, dataA = aoData[a]._aSortData, dataB = aoData[b]._aSortData;
          for (k = 0; k < len; k++) {
            sort = aSort[k];
            x = dataA[sort.col];
            y = dataB[sort.col];
            if (sort.sorter) {
              test = sort.sorter(x, y);
              if (test !== 0) {
                return test;
              }
            } else {
              test = x < y ? -1 : x > y ? 1 : 0;
              if (test !== 0) {
                return sort.dir === "asc" ? test : -test;
              }
            }
          }
          x = aiOrig[a];
          y = aiOrig[b];
          return x < y ? -1 : x > y ? 1 : 0;
        });
      } else if (aSort.length === 0) {
        displayMaster.sort(function(x, y) {
          return x < y ? -1 : x > y ? 1 : 0;
        });
      }
      if (col === void 0) {
        oSettings.bSorted = true;
        oSettings.sortDetails = aSort;
        _fnCallbackFire(oSettings, null, "order", [oSettings, aSort]);
      }
      return displayMaster;
    }
    function _fnSortAdd(settings, colIdx, addIndex, shift) {
      var col = settings.aoColumns[colIdx];
      var sorting = settings.aaSorting;
      var asSorting = col.asSorting;
      var nextSortIdx;
      var next = function(a, overflow) {
        var idx = a._idx;
        if (idx === void 0) {
          idx = asSorting.indexOf(a[1]);
        }
        return idx + 1 < asSorting.length ? idx + 1 : overflow ? null : 0;
      };
      if (!col.bSortable) {
        return false;
      }
      if (typeof sorting[0] === "number") {
        sorting = settings.aaSorting = [sorting];
      }
      if ((shift || addIndex) && settings.oFeatures.bSortMulti) {
        var sortIdx = _pluck(sorting, "0").indexOf(colIdx);
        if (sortIdx !== -1) {
          nextSortIdx = next(sorting[sortIdx], true);
          if (nextSortIdx === null && sorting.length === 1) {
            nextSortIdx = 0;
          }
          if (nextSortIdx === null || asSorting[nextSortIdx] === "") {
            sorting.splice(sortIdx, 1);
          } else {
            sorting[sortIdx][1] = asSorting[nextSortIdx];
            sorting[sortIdx]._idx = nextSortIdx;
          }
        } else if (shift) {
          sorting.push([colIdx, asSorting[0], 0]);
          sorting[sorting.length - 1]._idx = 0;
        } else {
          sorting.push([colIdx, sorting[0][1], 0]);
          sorting[sorting.length - 1]._idx = 0;
        }
      } else if (sorting.length && sorting[0][0] == colIdx) {
        nextSortIdx = next(sorting[0]);
        sorting.length = 1;
        sorting[0][1] = asSorting[nextSortIdx];
        sorting[0]._idx = nextSortIdx;
      } else {
        sorting.length = 0;
        sorting.push([colIdx, asSorting[0]]);
        sorting[0]._idx = 0;
      }
    }
    function _fnSortingClasses(settings) {
      var oldSort = settings.aLastSort;
      var sortClass = settings.oClasses.order.position;
      var sort = _fnSortFlatten(settings);
      var features = settings.oFeatures;
      var i2, iLen, colIdx;
      if (features.bSort && features.bSortClasses) {
        for (i2 = 0, iLen = oldSort.length; i2 < iLen; i2++) {
          colIdx = oldSort[i2].src;
          $(_pluck(settings.aoData, "anCells", colIdx)).removeClass(sortClass + (i2 < 2 ? i2 + 1 : 3));
        }
        for (i2 = 0, iLen = sort.length; i2 < iLen; i2++) {
          colIdx = sort[i2].src;
          $(_pluck(settings.aoData, "anCells", colIdx)).addClass(sortClass + (i2 < 2 ? i2 + 1 : 3));
        }
      }
      settings.aLastSort = sort;
    }
    function _fnSortData(settings, colIdx) {
      var column = settings.aoColumns[colIdx];
      var customSort = DataTable.ext.order[column.sSortDataType];
      var customData;
      if (customSort) {
        customData = customSort.call(
          settings.oInstance,
          settings,
          colIdx,
          _fnColumnIndexToVisible(settings, colIdx)
        );
      }
      var row, cellData;
      var formatter = DataTable.ext.type.order[column.sType + "-pre"];
      var data = settings.aoData;
      for (var rowIdx = 0; rowIdx < data.length; rowIdx++) {
        if (!data[rowIdx]) {
          continue;
        }
        row = data[rowIdx];
        if (!row._aSortData) {
          row._aSortData = [];
        }
        if (!row._aSortData[colIdx] || customSort) {
          cellData = customSort ? customData[rowIdx] : (
            // If there was a custom sort function, use data from there
            _fnGetCellData(settings, rowIdx, colIdx, "sort")
          );
          row._aSortData[colIdx] = formatter ? formatter(cellData, settings) : cellData;
        }
      }
    }
    function _fnSaveState(settings) {
      if (settings._bLoadingState) {
        return;
      }
      var sorting = [];
      _fnSortResolve(settings, sorting, settings.aaSorting);
      var columns = settings.aoColumns;
      var state = {
        time: +/* @__PURE__ */ new Date(),
        start: settings._iDisplayStart,
        length: settings._iDisplayLength,
        order: sorting.map(function(sort) {
          return columns[sort[0]] && columns[sort[0]].sName ? [columns[sort[0]].sName, sort[1]] : sort.slice();
        }),
        search: $.extend({}, settings.oPreviousSearch),
        columns: settings.aoColumns.map(function(col, i2) {
          return {
            name: col.sName,
            visible: col.bVisible,
            search: $.extend({}, settings.aoPreSearchCols[i2])
          };
        })
      };
      settings.oSavedState = state;
      _fnCallbackFire(settings, "aoStateSaveParams", "stateSaveParams", [settings, state]);
      if (settings.oFeatures.bStateSave && !settings.bDestroying) {
        settings.fnStateSaveCallback.call(settings.oInstance, settings, state);
      }
    }
    function _fnLoadState(settings, init, callback) {
      if (!settings.oFeatures.bStateSave) {
        callback();
        return;
      }
      var loaded = function(state2) {
        _fnImplementState(settings, state2, callback);
      };
      var state = settings.fnStateLoadCallback.call(settings.oInstance, settings, loaded);
      if (state !== void 0) {
        _fnImplementState(settings, state, callback);
      }
      return true;
    }
    function _fnImplementState(settings, s, callback) {
      var i2, iLen;
      var columns = settings.aoColumns;
      var currentNames = _pluck(settings.aoColumns, "sName");
      settings._bLoadingState = true;
      var api = settings._bInitComplete ? new DataTable.Api(settings) : null;
      if (!s || !s.time) {
        settings._bLoadingState = false;
        callback();
        return;
      }
      var duration2 = settings.iStateDuration;
      if (duration2 > 0 && s.time < +/* @__PURE__ */ new Date() - duration2 * 1e3) {
        settings._bLoadingState = false;
        callback();
        return;
      }
      var abStateLoad = _fnCallbackFire(settings, "aoStateLoadParams", "stateLoadParams", [settings, s]);
      if (abStateLoad.indexOf(false) !== -1) {
        settings._bLoadingState = false;
        callback();
        return;
      }
      settings.oLoadedState = $.extend(true, {}, s);
      _fnCallbackFire(settings, null, "stateLoadInit", [settings, s], true);
      if (s.length !== void 0) {
        if (api) {
          api.page.len(s.length);
        } else {
          settings._iDisplayLength = s.length;
        }
      }
      if (s.start !== void 0) {
        if (api === null) {
          settings._iDisplayStart = s.start;
          settings.iInitDisplayStart = s.start;
        } else {
          _fnPageChange(settings, s.start / settings._iDisplayLength);
        }
      }
      if (s.order !== void 0) {
        settings.aaSorting = [];
        $.each(s.order, function(i3, col2) {
          var set2 = [col2[0], col2[1]];
          if (typeof col2[0] === "string") {
            var idx2 = currentNames.indexOf(col2[0]);
            if (idx2 < 0) {
              return;
            }
            set2[0] = idx2;
          } else if (set2[0] >= columns.length) {
            return;
          }
          settings.aaSorting.push(set2);
        });
      }
      if (s.search !== void 0) {
        $.extend(settings.oPreviousSearch, s.search);
      }
      if (s.columns) {
        var set = s.columns;
        var incoming = _pluck(s.columns, "name");
        if (incoming.join("").length && incoming.join("") !== currentNames.join("")) {
          set = [];
          for (i2 = 0; i2 < currentNames.length; i2++) {
            if (currentNames[i2] != "") {
              var idx = incoming.indexOf(currentNames[i2]);
              if (idx >= 0) {
                set.push(s.columns[idx]);
              } else {
                set.push({});
              }
            } else {
              set.push({});
            }
          }
        }
        if (set.length === columns.length) {
          for (i2 = 0, iLen = set.length; i2 < iLen; i2++) {
            var col = set[i2];
            if (col.visible !== void 0) {
              if (api) {
                api.column(i2).visible(col.visible, false);
              } else {
                columns[i2].bVisible = col.visible;
              }
            }
            if (col.search !== void 0) {
              $.extend(settings.aoPreSearchCols[i2], col.search);
            }
          }
          if (api) {
            api.one("draw", function() {
              api.columns.adjust();
            });
          }
        }
      }
      settings._bLoadingState = false;
      _fnCallbackFire(settings, "aoStateLoaded", "stateLoaded", [settings, s]);
      callback();
    }
    function _fnLog(settings, level, msg, tn) {
      msg = "DataTables warning: " + (settings ? "table id=" + settings.sTableId + " - " : "") + msg;
      if (tn) {
        msg += ". For more information about this error, please see https://datatables.net/tn/" + tn;
      }
      {
        var ext = DataTable.ext;
        var type = ext.sErrMode || ext.errMode;
        if (settings) {
          _fnCallbackFire(settings, null, "dt-error", [settings, tn, msg], true);
        }
        if (type == "alert") {
          alert(msg);
        } else if (type == "throw") {
          throw new Error(msg);
        } else if (typeof type == "function") {
          type(settings, tn, msg);
        }
      }
    }
    function _fnMap(ret, src, name, mappedName) {
      if (Array.isArray(name)) {
        $.each(name, function(i2, val) {
          if (Array.isArray(val)) {
            _fnMap(ret, src, val[0], val[1]);
          } else {
            _fnMap(ret, src, val);
          }
        });
        return;
      }
      if (mappedName === void 0) {
        mappedName = name;
      }
      if (src[name] !== void 0) {
        ret[mappedName] = src[name];
      }
    }
    function _fnExtend(out, extender, breakRefs) {
      var val;
      for (var prop in extender) {
        if (Object.prototype.hasOwnProperty.call(extender, prop)) {
          val = extender[prop];
          if ($.isPlainObject(val)) {
            if (!$.isPlainObject(out[prop])) {
              out[prop] = {};
            }
            $.extend(true, out[prop], val);
          } else if (breakRefs && prop !== "data" && prop !== "aaData" && Array.isArray(val)) {
            out[prop] = val.slice();
          } else {
            out[prop] = val;
          }
        }
      }
      return out;
    }
    function _fnBindAction(n, selector, fn) {
      $(n).on("click.DT", selector, function(e) {
        fn(e);
      }).on("keypress.DT", selector, function(e) {
        if (e.which === 13) {
          e.preventDefault();
          fn(e);
        }
      }).on("selectstart.DT", selector, function() {
        return false;
      });
    }
    function _fnCallbackReg(settings, store, fn) {
      if (fn) {
        settings[store].push(fn);
      }
    }
    function _fnCallbackFire(settings, callbackArr, eventName, args, bubbles) {
      var ret = [];
      if (callbackArr) {
        ret = settings[callbackArr].slice().reverse().map(function(val) {
          return val.apply(settings.oInstance, args);
        });
      }
      if (eventName !== null) {
        var e = $.Event(eventName + ".dt");
        var table = $(settings.nTable);
        e.dt = settings.api;
        table[bubbles ? "trigger" : "triggerHandler"](e, args);
        if (bubbles && table.parents("body").length === 0) {
          $("body").trigger(e, args);
        }
        ret.push(e.result);
      }
      return ret;
    }
    function _fnLengthOverflow(settings) {
      var start = settings._iDisplayStart, end = settings.fnDisplayEnd(), len = settings._iDisplayLength;
      if (start >= end) {
        start = end - len;
      }
      start -= start % len;
      if (len === -1 || start < 0) {
        start = 0;
      }
      settings._iDisplayStart = start;
    }
    function _fnRenderer(settings, type) {
      var renderer = settings.renderer;
      var host = DataTable.ext.renderer[type];
      if ($.isPlainObject(renderer) && renderer[type]) {
        return host[renderer[type]] || host._;
      } else if (typeof renderer === "string") {
        return host[renderer] || host._;
      }
      return host._;
    }
    function _fnDataSource(settings) {
      if (settings.oFeatures.bServerSide) {
        return "ssp";
      } else if (settings.ajax) {
        return "ajax";
      }
      return "dom";
    }
    function _fnMacros(settings, str, entries) {
      var formatter = settings.fnFormatNumber, start = settings._iDisplayStart + 1, len = settings._iDisplayLength, vis = settings.fnRecordsDisplay(), max = settings.fnRecordsTotal(), all = len === -1;
      return str.replace(/_START_/g, formatter.call(settings, start)).replace(/_END_/g, formatter.call(settings, settings.fnDisplayEnd())).replace(/_MAX_/g, formatter.call(settings, max)).replace(/_TOTAL_/g, formatter.call(settings, vis)).replace(/_PAGE_/g, formatter.call(settings, all ? 1 : Math.ceil(start / len))).replace(/_PAGES_/g, formatter.call(settings, all ? 1 : Math.ceil(vis / len))).replace(/_ENTRIES_/g, settings.api.i18n("entries", "", entries)).replace(/_ENTRIES-MAX_/g, settings.api.i18n("entries", "", max)).replace(/_ENTRIES-TOTAL_/g, settings.api.i18n("entries", "", vis));
    }
    function _fnArrayApply(arr, data) {
      if (!data) {
        return;
      }
      if (data.length < 1e4) {
        arr.push.apply(arr, data);
      } else {
        for (i = 0; i < data.length; i++) {
          arr.push(data[i]);
        }
      }
    }
    function _fnListener(that, name, src) {
      if (!Array.isArray(src)) {
        src = [src];
      }
      for (i = 0; i < src.length; i++) {
        that.on(name + ".dt", src[i]);
      }
    }
    function _fnEscapeObject(obj) {
      if (DataTable.ext.escape.attributes) {
        $.each(obj, function(key2, val) {
          obj[key2] = _escapeHtml(val);
        });
      }
      return obj;
    }
    var __apiStruct = [];
    var __arrayProto = Array.prototype;
    var _toSettings = function(mixed) {
      var idx, jq;
      var settings = DataTable.settings;
      var tables = _pluck(settings, "nTable");
      if (!mixed) {
        return [];
      } else if (mixed.nTable && mixed.oFeatures) {
        return [mixed];
      } else if (mixed.nodeName && mixed.nodeName.toLowerCase() === "table") {
        idx = tables.indexOf(mixed);
        return idx !== -1 ? [settings[idx]] : null;
      } else if (mixed && typeof mixed.settings === "function") {
        return mixed.settings().toArray();
      } else if (typeof mixed === "string") {
        jq = $(mixed).get();
      } else if (mixed instanceof $) {
        jq = mixed.get();
      }
      if (jq) {
        return settings.filter(function(v, idx2) {
          return jq.includes(tables[idx2]);
        });
      }
    };
    _Api = function(context, data) {
      if (!(this instanceof _Api)) {
        return new _Api(context, data);
      }
      var i2;
      var settings = [];
      var ctxSettings = function(o) {
        var a = _toSettings(o);
        if (a) {
          settings.push.apply(settings, a);
        }
      };
      if (Array.isArray(context)) {
        for (i2 = 0; i2 < context.length; i2++) {
          ctxSettings(context[i2]);
        }
      } else {
        ctxSettings(context);
      }
      this.context = settings.length > 1 ? _unique(settings) : settings;
      _fnArrayApply(this, data);
      this.selector = {
        rows: null,
        cols: null,
        opts: null
      };
      _Api.extend(this, this, __apiStruct);
    };
    DataTable.Api = _Api;
    $.extend(_Api.prototype, {
      any: function() {
        return this.count() !== 0;
      },
      context: [],
      // array of table settings objects
      count: function() {
        return this.flatten().length;
      },
      each: function(fn) {
        for (var i2 = 0, iLen = this.length; i2 < iLen; i2++) {
          fn.call(this, this[i2], i2, this);
        }
        return this;
      },
      eq: function(idx) {
        var ctx = this.context;
        return ctx.length > idx ? new _Api(ctx[idx], this[idx]) : null;
      },
      filter: function(fn) {
        var a = __arrayProto.filter.call(this, fn, this);
        return new _Api(this.context, a);
      },
      flatten: function() {
        var a = [];
        return new _Api(this.context, a.concat.apply(a, this.toArray()));
      },
      get: function(idx) {
        return this[idx];
      },
      join: __arrayProto.join,
      includes: function(find) {
        return this.indexOf(find) === -1 ? false : true;
      },
      indexOf: __arrayProto.indexOf,
      iterator: function(flatten, type, fn, alwaysNew) {
        var a = [], ret, i2, iLen, j, jen, context = this.context, rows, items, item, selector = this.selector;
        if (typeof flatten === "string") {
          alwaysNew = fn;
          fn = type;
          type = flatten;
          flatten = false;
        }
        for (i2 = 0, iLen = context.length; i2 < iLen; i2++) {
          var apiInst = new _Api(context[i2]);
          if (type === "table") {
            ret = fn.call(apiInst, context[i2], i2);
            if (ret !== void 0) {
              a.push(ret);
            }
          } else if (type === "columns" || type === "rows") {
            ret = fn.call(apiInst, context[i2], this[i2], i2);
            if (ret !== void 0) {
              a.push(ret);
            }
          } else if (type === "every" || type === "column" || type === "column-rows" || type === "row" || type === "cell") {
            items = this[i2];
            if (type === "column-rows") {
              rows = _selector_row_indexes(context[i2], selector.opts);
            }
            for (j = 0, jen = items.length; j < jen; j++) {
              item = items[j];
              if (type === "cell") {
                ret = fn.call(apiInst, context[i2], item.row, item.column, i2, j);
              } else {
                ret = fn.call(apiInst, context[i2], item, i2, j, rows);
              }
              if (ret !== void 0) {
                a.push(ret);
              }
            }
          }
        }
        if (a.length || alwaysNew) {
          var api = new _Api(context, flatten ? a.concat.apply([], a) : a);
          var apiSelector = api.selector;
          apiSelector.rows = selector.rows;
          apiSelector.cols = selector.cols;
          apiSelector.opts = selector.opts;
          return api;
        }
        return this;
      },
      lastIndexOf: __arrayProto.lastIndexOf,
      length: 0,
      map: function(fn) {
        var a = __arrayProto.map.call(this, fn, this);
        return new _Api(this.context, a);
      },
      pluck: function(prop) {
        var fn = DataTable.util.get(prop);
        return this.map(function(el) {
          return fn(el);
        });
      },
      pop: __arrayProto.pop,
      push: __arrayProto.push,
      reduce: __arrayProto.reduce,
      reduceRight: __arrayProto.reduceRight,
      reverse: __arrayProto.reverse,
      // Object with rows, columns and opts
      selector: null,
      shift: __arrayProto.shift,
      slice: function() {
        return new _Api(this.context, this);
      },
      sort: __arrayProto.sort,
      splice: __arrayProto.splice,
      toArray: function() {
        return __arrayProto.slice.call(this);
      },
      to$: function() {
        return $(this);
      },
      toJQuery: function() {
        return $(this);
      },
      unique: function() {
        return new _Api(this.context, _unique(this.toArray()));
      },
      unshift: __arrayProto.unshift
    });
    function _api_scope(scope, fn, struct) {
      return function() {
        var ret = fn.apply(scope || this, arguments);
        _Api.extend(ret, ret, struct.methodExt);
        return ret;
      };
    }
    function _api_find(src, name) {
      for (var i2 = 0, iLen = src.length; i2 < iLen; i2++) {
        if (src[i2].name === name) {
          return src[i2];
        }
      }
      return null;
    }
    window.__apiStruct = __apiStruct;
    _Api.extend = function(scope, obj, ext) {
      if (!ext.length || !obj || !(obj instanceof _Api) && !obj.__dt_wrapper) {
        return;
      }
      var i2, iLen, struct;
      for (i2 = 0, iLen = ext.length; i2 < iLen; i2++) {
        struct = ext[i2];
        if (struct.name === "__proto__") {
          continue;
        }
        obj[struct.name] = struct.type === "function" ? _api_scope(scope, struct.val, struct) : struct.type === "object" ? {} : struct.val;
        obj[struct.name].__dt_wrapper = true;
        _Api.extend(scope, obj[struct.name], struct.propExt);
      }
    };
    _Api.register = _api_register = function(name, val) {
      if (Array.isArray(name)) {
        for (var j = 0, jen = name.length; j < jen; j++) {
          _Api.register(name[j], val);
        }
        return;
      }
      var i2, iLen, heir = name.split("."), struct = __apiStruct, key2, method;
      for (i2 = 0, iLen = heir.length; i2 < iLen; i2++) {
        method = heir[i2].indexOf("()") !== -1;
        key2 = method ? heir[i2].replace("()", "") : heir[i2];
        var src = _api_find(struct, key2);
        if (!src) {
          src = {
            name: key2,
            val: {},
            methodExt: [],
            propExt: [],
            type: "object"
          };
          struct.push(src);
        }
        if (i2 === iLen - 1) {
          src.val = val;
          src.type = typeof val === "function" ? "function" : $.isPlainObject(val) ? "object" : "other";
        } else {
          struct = method ? src.methodExt : src.propExt;
        }
      }
    };
    _Api.registerPlural = _api_registerPlural = function(pluralName, singularName, val) {
      _Api.register(pluralName, val);
      _Api.register(singularName, function() {
        var ret = val.apply(this, arguments);
        if (ret === this) {
          return this;
        } else if (ret instanceof _Api) {
          return ret.length ? Array.isArray(ret[0]) ? new _Api(ret.context, ret[0]) : (
            // Array results are 'enhanced'
            ret[0]
          ) : void 0;
        }
        return ret;
      });
    };
    var __table_selector = function(selector, a) {
      if (Array.isArray(selector)) {
        var result = [];
        selector.forEach(function(sel) {
          var inner = __table_selector(sel, a);
          _fnArrayApply(result, inner);
        });
        return result.filter(function(item) {
          return item;
        });
      }
      if (typeof selector === "number") {
        return [a[selector]];
      }
      var nodes = a.map(function(el) {
        return el.nTable;
      });
      return $(nodes).filter(selector).map(function() {
        var idx = nodes.indexOf(this);
        return a[idx];
      }).toArray();
    };
    _api_register("tables()", function(selector) {
      return selector !== void 0 && selector !== null ? new _Api(__table_selector(selector, this.context)) : this;
    });
    _api_register("table()", function(selector) {
      var tables = this.tables(selector);
      var ctx = tables.context;
      return ctx.length ? new _Api(ctx[0]) : tables;
    });
    [
      ["nodes", "node", "nTable"],
      ["body", "body", "nTBody"],
      ["header", "header", "nTHead"],
      ["footer", "footer", "nTFoot"]
    ].forEach(function(item) {
      _api_registerPlural(
        "tables()." + item[0] + "()",
        "table()." + item[1] + "()",
        function() {
          return this.iterator("table", function(ctx) {
            return ctx[item[2]];
          }, 1);
        }
      );
    });
    [
      ["header", "aoHeader"],
      ["footer", "aoFooter"]
    ].forEach(function(item) {
      _api_register("table()." + item[0] + ".structure()", function(selector) {
        var indexes = this.columns(selector).indexes().flatten().toArray();
        var ctx = this.context[0];
        var structure = _fnHeaderLayout(ctx, ctx[item[1]], indexes);
        var orderedIndexes = indexes.slice().sort(function(a, b) {
          return a - b;
        });
        return structure.map(function(row) {
          return indexes.map(function(colIdx) {
            return row[orderedIndexes.indexOf(colIdx)];
          });
        });
      });
    });
    _api_registerPlural("tables().containers()", "table().container()", function() {
      return this.iterator("table", function(ctx) {
        return ctx.nTableWrapper;
      }, 1);
    });
    _api_register("tables().every()", function(fn) {
      var that = this;
      return this.iterator("table", function(s, i2) {
        fn.call(that.table(i2), i2);
      });
    });
    _api_register("caption()", function(value, side) {
      var context = this.context;
      if (value === void 0) {
        var caption = context[0].captionNode;
        return caption && context.length ? caption.innerHTML : null;
      }
      return this.iterator("table", function(ctx) {
        var table = $(ctx.nTable);
        var caption2 = $(ctx.captionNode);
        var container = $(ctx.nTableWrapper);
        if (!caption2.length) {
          caption2 = $("<caption/>").html(value);
          ctx.captionNode = caption2[0];
          if (!side) {
            table.prepend(caption2);
            side = caption2.css("caption-side");
          }
        }
        caption2.html(value);
        if (side) {
          caption2.css("caption-side", side);
          caption2[0]._captionSide = side;
        }
        if (container.find("div.dataTables_scroll").length) {
          var selector = side === "top" ? "Head" : "Foot";
          container.find("div.dataTables_scroll" + selector + " table").prepend(caption2);
        } else {
          table.prepend(caption2);
        }
      }, 1);
    });
    _api_register("caption.node()", function() {
      var ctx = this.context;
      return ctx.length ? ctx[0].captionNode : null;
    });
    _api_register("draw()", function(paging) {
      return this.iterator("table", function(settings) {
        if (paging === "page") {
          _fnDraw(settings);
        } else {
          if (typeof paging === "string") {
            paging = paging === "full-hold" ? false : true;
          }
          _fnReDraw(settings, paging === false);
        }
      });
    });
    _api_register("page()", function(action) {
      if (action === void 0) {
        return this.page.info().page;
      }
      return this.iterator("table", function(settings) {
        _fnPageChange(settings, action);
      });
    });
    _api_register("page.info()", function() {
      if (this.context.length === 0) {
        return void 0;
      }
      var settings = this.context[0], start = settings._iDisplayStart, len = settings.oFeatures.bPaginate ? settings._iDisplayLength : -1, visRecords = settings.fnRecordsDisplay(), all = len === -1;
      return {
        "page": all ? 0 : Math.floor(start / len),
        "pages": all ? 1 : Math.ceil(visRecords / len),
        "start": start,
        "end": settings.fnDisplayEnd(),
        "length": len,
        "recordsTotal": settings.fnRecordsTotal(),
        "recordsDisplay": visRecords,
        "serverSide": _fnDataSource(settings) === "ssp"
      };
    });
    _api_register("page.len()", function(len) {
      if (len === void 0) {
        return this.context.length !== 0 ? this.context[0]._iDisplayLength : void 0;
      }
      return this.iterator("table", function(settings) {
        _fnLengthChange(settings, len);
      });
    });
    var __reload = function(settings, holdPosition, callback) {
      if (callback) {
        var api = new _Api(settings);
        api.one("draw", function() {
          callback(api.ajax.json());
        });
      }
      if (_fnDataSource(settings) == "ssp") {
        _fnReDraw(settings, holdPosition);
      } else {
        _fnProcessingDisplay(settings, true);
        var xhr = settings.jqXHR;
        if (xhr && xhr.readyState !== 4) {
          xhr.abort();
        }
        _fnBuildAjax(settings, {}, function(json) {
          _fnClearTable(settings);
          var data = _fnAjaxDataSrc(settings, json);
          for (var i2 = 0, iLen = data.length; i2 < iLen; i2++) {
            _fnAddData(settings, data[i2]);
          }
          _fnReDraw(settings, holdPosition);
          _fnInitComplete(settings);
          _fnProcessingDisplay(settings, false);
        });
      }
    };
    _api_register("ajax.json()", function() {
      var ctx = this.context;
      if (ctx.length > 0) {
        return ctx[0].json;
      }
    });
    _api_register("ajax.params()", function() {
      var ctx = this.context;
      if (ctx.length > 0) {
        return ctx[0].oAjaxData;
      }
    });
    _api_register("ajax.reload()", function(callback, resetPaging) {
      return this.iterator("table", function(settings) {
        __reload(settings, resetPaging === false, callback);
      });
    });
    _api_register("ajax.url()", function(url) {
      var ctx = this.context;
      if (url === void 0) {
        if (ctx.length === 0) {
          return void 0;
        }
        ctx = ctx[0];
        return $.isPlainObject(ctx.ajax) ? ctx.ajax.url : ctx.ajax;
      }
      return this.iterator("table", function(settings) {
        if ($.isPlainObject(settings.ajax)) {
          settings.ajax.url = url;
        } else {
          settings.ajax = url;
        }
      });
    });
    _api_register("ajax.url().load()", function(callback, resetPaging) {
      return this.iterator("table", function(ctx) {
        __reload(ctx, resetPaging === false, callback);
      });
    });
    var _selector_run = function(type, selector, selectFn, settings, opts) {
      var out = [], res, i2, iLen, selectorType = typeof selector;
      if (!selector || selectorType === "string" || selectorType === "function" || selector.length === void 0) {
        selector = [selector];
      }
      for (i2 = 0, iLen = selector.length; i2 < iLen; i2++) {
        res = selectFn(typeof selector[i2] === "string" ? selector[i2].trim() : selector[i2]);
        res = res.filter(function(item) {
          return item !== null && item !== void 0;
        });
        if (res && res.length) {
          out = out.concat(res);
        }
      }
      var ext = _ext.selector[type];
      if (ext.length) {
        for (i2 = 0, iLen = ext.length; i2 < iLen; i2++) {
          out = ext[i2](settings, opts, out);
        }
      }
      return _unique(out);
    };
    var _selector_opts = function(opts) {
      if (!opts) {
        opts = {};
      }
      if (opts.filter && opts.search === void 0) {
        opts.search = opts.filter;
      }
      return $.extend({
        columnOrder: "implied",
        search: "none",
        order: "current",
        page: "all"
      }, opts);
    };
    var _selector_first = function(old) {
      var inst = new _Api(old.context[0]);
      if (old.length) {
        inst.push(old[0]);
      }
      inst.selector = old.selector;
      if (inst.length && inst[0].length > 1) {
        inst[0].splice(1);
      }
      return inst;
    };
    var _selector_row_indexes = function(settings, opts) {
      var i2, iLen, tmp, a = [], displayFiltered = settings.aiDisplay, displayMaster = settings.aiDisplayMaster;
      var search = opts.search, order = opts.order, page = opts.page;
      if (_fnDataSource(settings) == "ssp") {
        return search === "removed" ? [] : _range(0, displayMaster.length);
      }
      if (page == "current") {
        for (i2 = settings._iDisplayStart, iLen = settings.fnDisplayEnd(); i2 < iLen; i2++) {
          a.push(displayFiltered[i2]);
        }
      } else if (order == "current" || order == "applied") {
        if (search == "none") {
          a = displayMaster.slice();
        } else if (search == "applied") {
          a = displayFiltered.slice();
        } else if (search == "removed") {
          var displayFilteredMap = {};
          for (i2 = 0, iLen = displayFiltered.length; i2 < iLen; i2++) {
            displayFilteredMap[displayFiltered[i2]] = null;
          }
          displayMaster.forEach(function(item) {
            if (!Object.prototype.hasOwnProperty.call(displayFilteredMap, item)) {
              a.push(item);
            }
          });
        }
      } else if (order == "index" || order == "original") {
        for (i2 = 0, iLen = settings.aoData.length; i2 < iLen; i2++) {
          if (!settings.aoData[i2]) {
            continue;
          }
          if (search == "none") {
            a.push(i2);
          } else {
            tmp = displayFiltered.indexOf(i2);
            if (tmp === -1 && search == "removed" || tmp >= 0 && search == "applied") {
              a.push(i2);
            }
          }
        }
      } else if (typeof order === "number") {
        var ordered = _fnSort(settings, order, "asc");
        if (search === "none") {
          a = ordered;
        } else {
          for (i2 = 0; i2 < ordered.length; i2++) {
            tmp = displayFiltered.indexOf(ordered[i2]);
            if (tmp === -1 && search == "removed" || tmp >= 0 && search == "applied") {
              a.push(ordered[i2]);
            }
          }
        }
      }
      return a;
    };
    var __row_selector = function(settings, selector, opts) {
      var rows;
      var run = function(sel) {
        var selInt = _intVal(sel);
        var aoData = settings.aoData;
        if (selInt !== null && !opts) {
          return [selInt];
        }
        if (!rows) {
          rows = _selector_row_indexes(settings, opts);
        }
        if (selInt !== null && rows.indexOf(selInt) !== -1) {
          return [selInt];
        } else if (sel === null || sel === void 0 || sel === "") {
          return rows;
        }
        if (typeof sel === "function") {
          return rows.map(function(idx) {
            var row = aoData[idx];
            return sel(idx, row._aData, row.nTr) ? idx : null;
          });
        }
        if (sel.nodeName) {
          var rowIdx = sel._DT_RowIndex;
          var cellIdx = sel._DT_CellIndex;
          if (rowIdx !== void 0) {
            return aoData[rowIdx] && aoData[rowIdx].nTr === sel ? [rowIdx] : [];
          } else if (cellIdx) {
            return aoData[cellIdx.row] && aoData[cellIdx.row].nTr === sel.parentNode ? [cellIdx.row] : [];
          } else {
            var host = $(sel).closest("*[data-dt-row]");
            return host.length ? [host.data("dt-row")] : [];
          }
        }
        if (typeof sel === "string" && sel.charAt(0) === "#") {
          var rowObj = settings.aIds[sel.replace(/^#/, "")];
          if (rowObj !== void 0) {
            return [rowObj.idx];
          }
        }
        var nodes = _removeEmpty(
          _pluck_order(settings.aoData, rows, "nTr")
        );
        return $(nodes).filter(sel).map(function() {
          return this._DT_RowIndex;
        }).toArray();
      };
      var matched = _selector_run("row", selector, run, settings, opts);
      if (opts.order === "current" || opts.order === "applied") {
        _fnSortDisplay(settings, matched);
      }
      return matched;
    };
    _api_register("rows()", function(selector, opts) {
      if (selector === void 0) {
        selector = "";
      } else if ($.isPlainObject(selector)) {
        opts = selector;
        selector = "";
      }
      opts = _selector_opts(opts);
      var inst = this.iterator("table", function(settings) {
        return __row_selector(settings, selector, opts);
      }, 1);
      inst.selector.rows = selector;
      inst.selector.opts = opts;
      return inst;
    });
    _api_register("rows().nodes()", function() {
      return this.iterator("row", function(settings, row) {
        return settings.aoData[row].nTr || void 0;
      }, 1);
    });
    _api_register("rows().data()", function() {
      return this.iterator(true, "rows", function(settings, rows) {
        return _pluck_order(settings.aoData, rows, "_aData");
      }, 1);
    });
    _api_registerPlural("rows().cache()", "row().cache()", function(type) {
      return this.iterator("row", function(settings, row) {
        var r = settings.aoData[row];
        return type === "search" ? r._aFilterData : r._aSortData;
      }, 1);
    });
    _api_registerPlural("rows().invalidate()", "row().invalidate()", function(src) {
      return this.iterator("row", function(settings, row) {
        _fnInvalidate(settings, row, src);
      });
    });
    _api_registerPlural("rows().indexes()", "row().index()", function() {
      return this.iterator("row", function(settings, row) {
        return row;
      }, 1);
    });
    _api_registerPlural("rows().ids()", "row().id()", function(hash) {
      var a = [];
      var context = this.context;
      for (var i2 = 0, iLen = context.length; i2 < iLen; i2++) {
        for (var j = 0, jen = this[i2].length; j < jen; j++) {
          var id = context[i2].rowIdFn(context[i2].aoData[this[i2][j]]._aData);
          a.push((hash === true ? "#" : "") + id);
        }
      }
      return new _Api(context, a);
    });
    _api_registerPlural("rows().remove()", "row().remove()", function() {
      this.iterator("row", function(settings, row) {
        var data = settings.aoData;
        var rowData = data[row];
        var idx = settings.aiDisplayMaster.indexOf(row);
        if (idx !== -1) {
          settings.aiDisplayMaster.splice(idx, 1);
        }
        if (settings._iRecordsDisplay > 0) {
          settings._iRecordsDisplay--;
        }
        _fnLengthOverflow(settings);
        var id = settings.rowIdFn(rowData._aData);
        if (id !== void 0) {
          delete settings.aIds[id];
        }
        data[row] = null;
      });
      return this;
    });
    _api_register("rows.add()", function(rows) {
      var newRows = this.iterator("table", function(settings) {
        var row, i2, iLen;
        var out = [];
        for (i2 = 0, iLen = rows.length; i2 < iLen; i2++) {
          row = rows[i2];
          if (row.nodeName && row.nodeName.toUpperCase() === "TR") {
            out.push(_fnAddTr(settings, row)[0]);
          } else {
            out.push(_fnAddData(settings, row));
          }
        }
        return out;
      }, 1);
      var modRows = this.rows(-1);
      modRows.pop();
      _fnArrayApply(modRows, newRows);
      return modRows;
    });
    _api_register("row()", function(selector, opts) {
      return _selector_first(this.rows(selector, opts));
    });
    _api_register("row().data()", function(data) {
      var ctx = this.context;
      if (data === void 0) {
        return ctx.length && this.length && this[0].length ? ctx[0].aoData[this[0]]._aData : void 0;
      }
      var row = ctx[0].aoData[this[0]];
      row._aData = data;
      if (Array.isArray(data) && row.nTr && row.nTr.id) {
        _fnSetObjectDataFn(ctx[0].rowId)(data, row.nTr.id);
      }
      _fnInvalidate(ctx[0], this[0], "data");
      return this;
    });
    _api_register("row().node()", function() {
      var ctx = this.context;
      if (ctx.length && this.length && this[0].length) {
        var row = ctx[0].aoData[this[0]];
        if (row && row.nTr) {
          return row.nTr;
        }
      }
      return null;
    });
    _api_register("row.add()", function(row) {
      if (row instanceof $ && row.length) {
        row = row[0];
      }
      var rows = this.iterator("table", function(settings) {
        if (row.nodeName && row.nodeName.toUpperCase() === "TR") {
          return _fnAddTr(settings, row)[0];
        }
        return _fnAddData(settings, row);
      });
      return this.row(rows[0]);
    });
    $(document).on("plugin-init.dt", function(e, context) {
      var api = new _Api(context);
      api.on("stateSaveParams.DT", function(e2, settings, d) {
        var idFn = settings.rowIdFn;
        var rows = settings.aiDisplayMaster;
        var ids = [];
        for (var i2 = 0; i2 < rows.length; i2++) {
          var rowIdx = rows[i2];
          var data = settings.aoData[rowIdx];
          if (data._detailsShow) {
            ids.push("#" + idFn(data._aData));
          }
        }
        d.childRows = ids;
      });
      api.on("stateLoaded.DT", function(e2, settings, state) {
        __details_state_load(api, state);
      });
      __details_state_load(api, api.state.loaded());
    });
    var __details_state_load = function(api, state) {
      if (state && state.childRows) {
        api.rows(state.childRows.map(function(id) {
          return id.replace(/([^:\\]*(?:\\.[^:\\]*)*):/g, "$1\\:");
        })).every(function() {
          _fnCallbackFire(api.settings()[0], null, "requestChild", [this]);
        });
      }
    };
    var __details_add = function(ctx, row, data, klass) {
      var rows = [];
      var addRow = function(r, k) {
        if (Array.isArray(r) || r instanceof $) {
          for (var i2 = 0, iLen = r.length; i2 < iLen; i2++) {
            addRow(r[i2], k);
          }
          return;
        }
        if (r.nodeName && r.nodeName.toLowerCase() === "tr") {
          r.setAttribute("data-dt-row", row.idx);
          rows.push(r);
        } else {
          var created = $("<tr><td></td></tr>").attr("data-dt-row", row.idx).addClass(k);
          $("td", created).addClass(k).html(r)[0].colSpan = _fnVisibleColumns(ctx);
          rows.push(created[0]);
        }
      };
      addRow(data, klass);
      if (row._details) {
        row._details.detach();
      }
      row._details = $(rows);
      if (row._detailsShow) {
        row._details.insertAfter(row.nTr);
      }
    };
    var __details_state = DataTable.util.throttle(
      function(ctx) {
        _fnSaveState(ctx[0]);
      },
      500
    );
    var __details_remove = function(api, idx) {
      var ctx = api.context;
      if (ctx.length) {
        var row = ctx[0].aoData[idx !== void 0 ? idx : api[0]];
        if (row && row._details) {
          row._details.detach();
          row._detailsShow = void 0;
          row._details = void 0;
          $(row.nTr).removeClass("dt-hasChild");
          __details_state(ctx);
        }
      }
    };
    var __details_display = function(api, show) {
      var ctx = api.context;
      if (ctx.length && api.length) {
        var row = ctx[0].aoData[api[0]];
        if (row._details) {
          row._detailsShow = show;
          if (show) {
            row._details.insertAfter(row.nTr);
            $(row.nTr).addClass("dt-hasChild");
          } else {
            row._details.detach();
            $(row.nTr).removeClass("dt-hasChild");
          }
          _fnCallbackFire(ctx[0], null, "childRow", [show, api.row(api[0])]);
          __details_events(ctx[0]);
          __details_state(ctx);
        }
      }
    };
    var __details_events = function(settings) {
      var api = new _Api(settings);
      var namespace = ".dt.DT_details";
      var drawEvent = "draw" + namespace;
      var colvisEvent = "column-sizing" + namespace;
      var destroyEvent = "destroy" + namespace;
      var data = settings.aoData;
      api.off(drawEvent + " " + colvisEvent + " " + destroyEvent);
      if (_pluck(data, "_details").length > 0) {
        api.on(drawEvent, function(e, ctx) {
          if (settings !== ctx) {
            return;
          }
          api.rows({ page: "current" }).eq(0).each(function(idx) {
            var row = data[idx];
            if (row._detailsShow) {
              row._details.insertAfter(row.nTr);
            }
          });
        });
        api.on(colvisEvent, function(e, ctx) {
          if (settings !== ctx) {
            return;
          }
          var row, visible = _fnVisibleColumns(ctx);
          for (var i2 = 0, iLen = data.length; i2 < iLen; i2++) {
            row = data[i2];
            if (row && row._details) {
              row._details.each(function() {
                var el = $(this).children("td");
                if (el.length == 1) {
                  el.attr("colspan", visible);
                }
              });
            }
          }
        });
        api.on(destroyEvent, function(e, ctx) {
          if (settings !== ctx) {
            return;
          }
          for (var i2 = 0, iLen = data.length; i2 < iLen; i2++) {
            if (data[i2] && data[i2]._details) {
              __details_remove(api, i2);
            }
          }
        });
      }
    };
    var _emp = "";
    var _child_obj = _emp + "row().child";
    var _child_mth = _child_obj + "()";
    _api_register(_child_mth, function(data, klass) {
      var ctx = this.context;
      if (data === void 0) {
        return ctx.length && this.length && ctx[0].aoData[this[0]] ? ctx[0].aoData[this[0]]._details : void 0;
      } else if (data === true) {
        this.child.show();
      } else if (data === false) {
        __details_remove(this);
      } else if (ctx.length && this.length) {
        __details_add(ctx[0], ctx[0].aoData[this[0]], data, klass);
      }
      return this;
    });
    _api_register([
      _child_obj + ".show()",
      _child_mth + ".show()"
      // only when `child()` was called with parameters (without
    ], function() {
      __details_display(this, true);
      return this;
    });
    _api_register([
      _child_obj + ".hide()",
      _child_mth + ".hide()"
      // only when `child()` was called with parameters (without
    ], function() {
      __details_display(this, false);
      return this;
    });
    _api_register([
      _child_obj + ".remove()",
      _child_mth + ".remove()"
      // only when `child()` was called with parameters (without
    ], function() {
      __details_remove(this);
      return this;
    });
    _api_register(_child_obj + ".isShown()", function() {
      var ctx = this.context;
      if (ctx.length && this.length && ctx[0].aoData[this[0]]) {
        return ctx[0].aoData[this[0]]._detailsShow || false;
      }
      return false;
    });
    var __re_column_selector = /^([^:]+)?:(name|title|visIdx|visible)$/;
    var __columnData = function(settings, column, r1, r2, rows, type) {
      var a = [];
      for (var row = 0, iLen = rows.length; row < iLen; row++) {
        a.push(_fnGetCellData(settings, rows[row], column, type));
      }
      return a;
    };
    var __column_header = function(settings, column, row) {
      var header = settings.aoHeader;
      var titleRow = settings.titleRow;
      var target = null;
      if (row !== void 0) {
        target = row;
      } else if (titleRow === true) {
        target = 0;
      } else if (titleRow === false) {
        target = header.length - 1;
      } else if (titleRow !== null) {
        target = titleRow;
      } else {
        for (var i2 = 0; i2 < header.length; i2++) {
          if (header[i2][column].unique && $("span.dt-column-title", header[i2][column].cell).text()) {
            target = i2;
          }
        }
        if (target === null) {
          target = 0;
        }
      }
      return header[target][column].cell;
    };
    var __column_header_cells = function(header) {
      var out = [];
      for (var i2 = 0; i2 < header.length; i2++) {
        for (var j = 0; j < header[i2].length; j++) {
          var cell = header[i2][j].cell;
          if (!out.includes(cell)) {
            out.push(cell);
          }
        }
      }
      return out;
    };
    var __column_selector = function(settings, selector, opts) {
      var columns = settings.aoColumns, names, titles, nodes = __column_header_cells(settings.aoHeader);
      var run = function(s) {
        var selInt = _intVal(s);
        if (s === "") {
          return _range(columns.length);
        }
        if (selInt !== null) {
          return [
            selInt >= 0 ? selInt : (
              // Count from left
              columns.length + selInt
            )
            // Count from right (+ because its a negative value)
          ];
        }
        if (typeof s === "function") {
          var rows = _selector_row_indexes(settings, opts);
          return columns.map(function(col, idx2) {
            return s(
              idx2,
              __columnData(settings, idx2, 0, 0, rows),
              __column_header(settings, idx2)
            ) ? idx2 : null;
          });
        }
        var match = typeof s === "string" ? s.match(__re_column_selector) : "";
        if (match) {
          switch (match[2]) {
            case "visIdx":
            case "visible":
              if (match[1] && match[1].match(/^\d+$/)) {
                var idx = parseInt(match[1], 10);
                if (idx < 0) {
                  var visColumns = columns.map(function(col, i2) {
                    return col.bVisible ? i2 : null;
                  });
                  return [visColumns[visColumns.length + idx]];
                }
                return [_fnVisibleToColumnIndex(settings, idx)];
              }
              return columns.map(function(col, idx2) {
                if (!col.bVisible) {
                  return null;
                }
                if (match[1]) {
                  return $(nodes[idx2]).filter(match[1]).length > 0 ? idx2 : null;
                }
                return idx2;
              });
            case "name":
              if (!names) {
                names = _pluck(columns, "sName");
              }
              return names.map(function(name, i2) {
                return name === match[1] ? i2 : null;
              });
            case "title":
              if (!titles) {
                titles = _pluck(columns, "sTitle");
              }
              return titles.map(function(title, i2) {
                return title === match[1] ? i2 : null;
              });
            default:
              return [];
          }
        }
        if (s.nodeName && s._DT_CellIndex) {
          return [s._DT_CellIndex.column];
        }
        var jqResult = $(nodes).filter(s).map(function() {
          return _fnColumnsFromHeader(this);
        }).toArray().sort(function(a, b) {
          return a - b;
        });
        if (jqResult.length || !s.nodeName) {
          return jqResult;
        }
        var host = $(s).closest("*[data-dt-column]");
        return host.length ? [host.data("dt-column")] : [];
      };
      var selected = _selector_run("column", selector, run, settings, opts);
      return opts.columnOrder && opts.columnOrder === "index" ? selected.sort(function(a, b) {
        return a - b;
      }) : selected;
    };
    var __setColumnVis = function(settings, column, vis) {
      var cols = settings.aoColumns, col = cols[column], data = settings.aoData, cells, i2, iLen, tr;
      if (vis === void 0) {
        return col.bVisible;
      }
      if (col.bVisible === vis) {
        return false;
      }
      if (vis) {
        var insertBefore = _pluck(cols, "bVisible").indexOf(true, column + 1);
        for (i2 = 0, iLen = data.length; i2 < iLen; i2++) {
          if (data[i2]) {
            tr = data[i2].nTr;
            cells = data[i2].anCells;
            if (tr) {
              tr.insertBefore(cells[column], cells[insertBefore] || null);
            }
          }
        }
      } else {
        $(_pluck(settings.aoData, "anCells", column)).detach();
      }
      col.bVisible = vis;
      _colGroup(settings);
      return true;
    };
    _api_register("columns()", function(selector, opts) {
      if (selector === void 0) {
        selector = "";
      } else if ($.isPlainObject(selector)) {
        opts = selector;
        selector = "";
      }
      opts = _selector_opts(opts);
      var inst = this.iterator("table", function(settings) {
        return __column_selector(settings, selector, opts);
      }, 1);
      inst.selector.cols = selector;
      inst.selector.opts = opts;
      return inst;
    });
    _api_registerPlural("columns().header()", "column().header()", function(row) {
      return this.iterator("column", function(settings, column) {
        return __column_header(settings, column, row);
      }, 1);
    });
    _api_registerPlural("columns().footer()", "column().footer()", function(row) {
      return this.iterator("column", function(settings, column) {
        var footer = settings.aoFooter;
        if (!footer.length) {
          return null;
        }
        return settings.aoFooter[row !== void 0 ? row : 0][column].cell;
      }, 1);
    });
    _api_registerPlural("columns().data()", "column().data()", function() {
      return this.iterator("column-rows", __columnData, 1);
    });
    _api_registerPlural("columns().render()", "column().render()", function(type) {
      return this.iterator("column-rows", function(settings, column, i2, j, rows) {
        return __columnData(settings, column, i2, j, rows, type);
      }, 1);
    });
    _api_registerPlural("columns().dataSrc()", "column().dataSrc()", function() {
      return this.iterator("column", function(settings, column) {
        return settings.aoColumns[column].mData;
      }, 1);
    });
    _api_registerPlural("columns().cache()", "column().cache()", function(type) {
      return this.iterator("column-rows", function(settings, column, i2, j, rows) {
        return _pluck_order(
          settings.aoData,
          rows,
          type === "search" ? "_aFilterData" : "_aSortData",
          column
        );
      }, 1);
    });
    _api_registerPlural("columns().init()", "column().init()", function() {
      return this.iterator("column", function(settings, column) {
        return settings.aoColumns[column];
      }, 1);
    });
    _api_registerPlural("columns().names()", "column().name()", function() {
      return this.iterator("column", function(settings, column) {
        return settings.aoColumns[column].sName;
      }, 1);
    });
    _api_registerPlural("columns().nodes()", "column().nodes()", function() {
      return this.iterator("column-rows", function(settings, column, i2, j, rows) {
        return _pluck_order(settings.aoData, rows, "anCells", column);
      }, 1);
    });
    _api_registerPlural("columns().titles()", "column().title()", function(title, row) {
      return this.iterator("column", function(settings, column) {
        if (typeof title === "number") {
          row = title;
          title = void 0;
        }
        var span = $("span.dt-column-title", this.column(column).header(row));
        if (title !== void 0) {
          span.html(title);
          return this;
        }
        return span.html();
      }, 1);
    });
    _api_registerPlural("columns().types()", "column().type()", function() {
      return this.iterator("column", function(settings, column) {
        var type = settings.aoColumns[column].sType;
        if (!type) {
          _fnColumnTypes(settings);
        }
        return type;
      }, 1);
    });
    _api_registerPlural("columns().visible()", "column().visible()", function(vis, calc) {
      var that = this;
      var changed = [];
      var ret = this.iterator("column", function(settings, column) {
        if (vis === void 0) {
          return settings.aoColumns[column].bVisible;
        }
        if (__setColumnVis(settings, column, vis)) {
          changed.push(column);
        }
      });
      if (vis !== void 0) {
        this.iterator("table", function(settings) {
          _fnDrawHead(settings, settings.aoHeader);
          _fnDrawHead(settings, settings.aoFooter);
          if (!settings.aiDisplay.length) {
            $(settings.nTBody).find("td[colspan]").attr("colspan", _fnVisibleColumns(settings));
          }
          _fnSaveState(settings);
          that.iterator("column", function(settings2, column) {
            if (changed.includes(column)) {
              _fnCallbackFire(settings2, null, "column-visibility", [settings2, column, vis, calc]);
            }
          });
          if (changed.length && (calc === void 0 || calc)) {
            that.columns.adjust();
          }
        });
      }
      return ret;
    });
    _api_registerPlural("columns().widths()", "column().width()", function() {
      var columns = this.columns(":visible").count();
      var row = $("<tr>").html("<td>" + Array(columns).join("</td><td>") + "</td>");
      $(this.table().body()).append(row);
      var widths = row.children().map(function() {
        return $(this).outerWidth();
      });
      row.remove();
      return this.iterator("column", function(settings, column) {
        var visIdx = _fnColumnIndexToVisible(settings, column);
        return visIdx !== null ? widths[visIdx] : 0;
      }, 1);
    });
    _api_registerPlural("columns().indexes()", "column().index()", function(type) {
      return this.iterator("column", function(settings, column) {
        return type === "visible" ? _fnColumnIndexToVisible(settings, column) : column;
      }, 1);
    });
    _api_register("columns.adjust()", function() {
      return this.iterator("table", function(settings) {
        settings.containerWidth = -1;
        _fnAdjustColumnSizing(settings);
      }, 1);
    });
    _api_register("column.index()", function(type, idx) {
      if (this.context.length !== 0) {
        var ctx = this.context[0];
        if (type === "fromVisible" || type === "toData") {
          return _fnVisibleToColumnIndex(ctx, idx);
        } else if (type === "fromData" || type === "toVisible") {
          return _fnColumnIndexToVisible(ctx, idx);
        }
      }
    });
    _api_register("column()", function(selector, opts) {
      return _selector_first(this.columns(selector, opts));
    });
    var __cell_selector = function(settings, selector, opts) {
      var data = settings.aoData;
      var rows = _selector_row_indexes(settings, opts);
      var cells = _removeEmpty(_pluck_order(data, rows, "anCells"));
      var allCells = $(_flatten([], cells));
      var row;
      var columns = settings.aoColumns.length;
      var a, i2, iLen, j, o, host;
      var run = function(s) {
        var fnSelector = typeof s === "function";
        if (s === null || s === void 0 || fnSelector) {
          a = [];
          for (i2 = 0, iLen = rows.length; i2 < iLen; i2++) {
            row = rows[i2];
            for (j = 0; j < columns; j++) {
              o = {
                row,
                column: j
              };
              if (fnSelector) {
                host = data[row];
                if (s(o, _fnGetCellData(settings, row, j), host.anCells ? host.anCells[j] : null)) {
                  a.push(o);
                }
              } else {
                a.push(o);
              }
            }
          }
          return a;
        }
        if ($.isPlainObject(s)) {
          return s.column !== void 0 && s.row !== void 0 && rows.indexOf(s.row) !== -1 ? [s] : [];
        }
        var jqResult = allCells.filter(s).map(function(i3, el) {
          return {
            // use a new object, in case someone changes the values
            row: el._DT_CellIndex.row,
            column: el._DT_CellIndex.column
          };
        }).toArray();
        if (jqResult.length || !s.nodeName) {
          return jqResult;
        }
        host = $(s).closest("*[data-dt-row]");
        return host.length ? [{
          row: host.data("dt-row"),
          column: host.data("dt-column")
        }] : [];
      };
      return _selector_run("cell", selector, run, settings, opts);
    };
    _api_register("cells()", function(rowSelector, columnSelector, opts) {
      if ($.isPlainObject(rowSelector)) {
        if (rowSelector.row === void 0) {
          opts = rowSelector;
          rowSelector = null;
        } else {
          opts = columnSelector;
          columnSelector = null;
        }
      }
      if ($.isPlainObject(columnSelector)) {
        opts = columnSelector;
        columnSelector = null;
      }
      if (columnSelector === null || columnSelector === void 0) {
        return this.iterator("table", function(settings) {
          return __cell_selector(settings, rowSelector, _selector_opts(opts));
        });
      }
      var internalOpts = opts ? {
        page: opts.page,
        order: opts.order,
        search: opts.search
      } : {};
      var columns = this.columns(columnSelector, internalOpts);
      var rows = this.rows(rowSelector, internalOpts);
      var i2, iLen, j, jen;
      var cellsNoOpts = this.iterator("table", function(settings, idx) {
        var a = [];
        for (i2 = 0, iLen = rows[idx].length; i2 < iLen; i2++) {
          for (j = 0, jen = columns[idx].length; j < jen; j++) {
            a.push({
              row: rows[idx][i2],
              column: columns[idx][j]
            });
          }
        }
        return a;
      }, 1);
      var cells = opts && opts.selected ? this.cells(cellsNoOpts, opts) : cellsNoOpts;
      $.extend(cells.selector, {
        cols: columnSelector,
        rows: rowSelector,
        opts
      });
      return cells;
    });
    _api_registerPlural("cells().nodes()", "cell().node()", function() {
      return this.iterator("cell", function(settings, row, column) {
        var data = settings.aoData[row];
        return data && data.anCells ? data.anCells[column] : void 0;
      }, 1);
    });
    _api_register("cells().data()", function() {
      return this.iterator("cell", function(settings, row, column) {
        return _fnGetCellData(settings, row, column);
      }, 1);
    });
    _api_registerPlural("cells().cache()", "cell().cache()", function(type) {
      type = type === "search" ? "_aFilterData" : "_aSortData";
      return this.iterator("cell", function(settings, row, column) {
        return settings.aoData[row][type][column];
      }, 1);
    });
    _api_registerPlural("cells().render()", "cell().render()", function(type) {
      return this.iterator("cell", function(settings, row, column) {
        return _fnGetCellData(settings, row, column, type);
      }, 1);
    });
    _api_registerPlural("cells().indexes()", "cell().index()", function() {
      return this.iterator("cell", function(settings, row, column) {
        return {
          row,
          column,
          columnVisible: _fnColumnIndexToVisible(settings, column)
        };
      }, 1);
    });
    _api_registerPlural("cells().invalidate()", "cell().invalidate()", function(src) {
      return this.iterator("cell", function(settings, row, column) {
        _fnInvalidate(settings, row, src, column);
      });
    });
    _api_register("cell()", function(rowSelector, columnSelector, opts) {
      return _selector_first(this.cells(rowSelector, columnSelector, opts));
    });
    _api_register("cell().data()", function(data) {
      var ctx = this.context;
      var cell = this[0];
      if (data === void 0) {
        return ctx.length && cell.length ? _fnGetCellData(ctx[0], cell[0].row, cell[0].column) : void 0;
      }
      _fnSetCellData(ctx[0], cell[0].row, cell[0].column, data);
      _fnInvalidate(ctx[0], cell[0].row, "data", cell[0].column);
      return this;
    });
    _api_register("order()", function(order, dir) {
      var ctx = this.context;
      var args = Array.prototype.slice.call(arguments);
      if (order === void 0) {
        return ctx.length !== 0 ? ctx[0].aaSorting : void 0;
      }
      if (typeof order === "number") {
        order = [[order, dir]];
      } else if (args.length > 1) {
        order = args;
      }
      return this.iterator("table", function(settings) {
        var resolved = [];
        _fnSortResolve(settings, resolved, order);
        settings.aaSorting = resolved;
      });
    });
    _api_register("order.listener()", function(node, column, callback) {
      return this.iterator("table", function(settings) {
        _fnSortAttachListener(settings, node, {}, column, callback);
      });
    });
    _api_register("order.fixed()", function(set) {
      if (!set) {
        var ctx = this.context;
        var fixed = ctx.length ? ctx[0].aaSortingFixed : void 0;
        return Array.isArray(fixed) ? { pre: fixed } : fixed;
      }
      return this.iterator("table", function(settings) {
        settings.aaSortingFixed = $.extend(true, {}, set);
      });
    });
    _api_register([
      "columns().order()",
      "column().order()"
    ], function(dir) {
      var that = this;
      if (!dir) {
        return this.iterator("column", function(settings, idx) {
          var sort = _fnSortFlatten(settings);
          for (var i2 = 0, iLen = sort.length; i2 < iLen; i2++) {
            if (sort[i2].col === idx) {
              return sort[i2].dir;
            }
          }
          return null;
        }, 1);
      } else {
        return this.iterator("table", function(settings, i2) {
          settings.aaSorting = that[i2].map(function(col) {
            return [col, dir];
          });
        });
      }
    });
    _api_registerPlural("columns().orderable()", "column().orderable()", function(directions) {
      return this.iterator("column", function(settings, idx) {
        var col = settings.aoColumns[idx];
        return directions ? col.asSorting : col.bSortable;
      }, 1);
    });
    _api_register("processing()", function(show) {
      return this.iterator("table", function(ctx) {
        _fnProcessingDisplay(ctx, show);
      });
    });
    _api_register("search()", function(input, regex, smart, caseInsen) {
      var ctx = this.context;
      if (input === void 0) {
        return ctx.length !== 0 ? ctx[0].oPreviousSearch.search : void 0;
      }
      return this.iterator("table", function(settings) {
        if (!settings.oFeatures.bFilter) {
          return;
        }
        if (typeof regex === "object") {
          _fnFilterComplete(settings, $.extend(settings.oPreviousSearch, regex, {
            search: input
          }));
        } else {
          _fnFilterComplete(settings, $.extend(settings.oPreviousSearch, {
            search: input,
            regex: regex === null ? false : regex,
            smart: smart === null ? true : smart,
            caseInsensitive: caseInsen === null ? true : caseInsen
          }));
        }
      });
    });
    _api_register("search.fixed()", function(name, search) {
      var ret = this.iterator(true, "table", function(settings) {
        var fixed = settings.searchFixed;
        if (!name) {
          return Object.keys(fixed);
        } else if (search === void 0) {
          return fixed[name];
        } else if (search === null) {
          delete fixed[name];
        } else {
          fixed[name] = search;
        }
        return this;
      });
      return name !== void 0 && search === void 0 ? ret[0] : ret;
    });
    _api_registerPlural(
      "columns().search()",
      "column().search()",
      function(input, regex, smart, caseInsen) {
        return this.iterator("column", function(settings, column) {
          var preSearch = settings.aoPreSearchCols;
          if (input === void 0) {
            return preSearch[column].search;
          }
          if (!settings.oFeatures.bFilter) {
            return;
          }
          if (typeof regex === "object") {
            $.extend(preSearch[column], regex, {
              search: input
            });
          } else {
            $.extend(preSearch[column], {
              search: input,
              regex: regex === null ? false : regex,
              smart: smart === null ? true : smart,
              caseInsensitive: caseInsen === null ? true : caseInsen
            });
          }
          _fnFilterComplete(settings, settings.oPreviousSearch);
        });
      }
    );
    _api_register(
      [
        "columns().search.fixed()",
        "column().search.fixed()"
      ],
      function(name, search) {
        var ret = this.iterator(true, "column", function(settings, colIdx) {
          var fixed = settings.aoColumns[colIdx].searchFixed;
          if (!name) {
            return Object.keys(fixed);
          } else if (search === void 0) {
            return fixed[name] || null;
          } else if (search === null) {
            delete fixed[name];
          } else {
            fixed[name] = search;
          }
          return this;
        });
        return name !== void 0 && search === void 0 ? ret[0] : ret;
      }
    );
    _api_register("state()", function(set, ignoreTime) {
      if (!set) {
        return this.context.length ? this.context[0].oSavedState : null;
      }
      var setMutate = $.extend(true, {}, set);
      return this.iterator("table", function(settings) {
        if (ignoreTime !== false) {
          setMutate.time = +/* @__PURE__ */ new Date() + 100;
        }
        _fnImplementState(settings, setMutate, function() {
        });
      });
    });
    _api_register("state.clear()", function() {
      return this.iterator("table", function(settings) {
        settings.fnStateSaveCallback.call(settings.oInstance, settings, {});
      });
    });
    _api_register("state.loaded()", function() {
      return this.context.length ? this.context[0].oLoadedState : null;
    });
    _api_register("state.save()", function() {
      return this.iterator("table", function(settings) {
        _fnSaveState(settings);
      });
    });
    var __bootstrap;
    var __foundation;
    DataTable.use = function(arg1, arg2) {
      var module2 = typeof arg1 === "string" ? arg2 : arg1;
      var type = typeof arg2 === "string" ? arg2 : arg1;
      if (module2 === void 0 && typeof type === "string") {
        switch (type) {
          case "lib":
          case "jq":
            return $;
          case "win":
            return window;
          case "datetime":
            return DataTable.DateTime;
          case "luxon":
            return __luxon;
          case "moment":
            return __moment;
          case "bootstrap":
            return __bootstrap || window.bootstrap;
          case "foundation":
            return __foundation || window.Foundation;
          default:
            return null;
        }
      }
      if (type === "lib" || type === "jq" || module2 && module2.fn && module2.fn.jquery) {
        $ = module2;
      } else if (type === "win" || module2 && module2.document) {
        window = module2;
        document = module2.document;
      } else if (type === "datetime" || module2 && module2.type === "DateTime") {
        DataTable.DateTime = module2;
      } else if (type === "luxon" || module2 && module2.FixedOffsetZone) {
        __luxon = module2;
      } else if (type === "moment" || module2 && module2.isMoment) {
        __moment = module2;
      } else if (type === "bootstrap" || module2 && module2.Modal && module2.Modal.NAME === "modal") {
        __bootstrap = module2;
      } else if (type === "foundation" || module2 && module2.Reveal) {
        __foundation = module2;
      }
    };
    DataTable.factory = function(root, jq) {
      var is = false;
      if (root && root.document) {
        window = root;
        document = root.document;
      }
      if (jq && jq.fn && jq.fn.jquery) {
        $ = jq;
        is = true;
      }
      return is;
    };
    DataTable.versionCheck = function(version, version2) {
      var aThis = version2 ? version2.split(".") : DataTable.version.split(".");
      var aThat = version.split(".");
      var iThis, iThat;
      for (var i2 = 0, iLen = aThat.length; i2 < iLen; i2++) {
        iThis = parseInt(aThis[i2], 10) || 0;
        iThat = parseInt(aThat[i2], 10) || 0;
        if (iThis === iThat) {
          continue;
        }
        return iThis > iThat;
      }
      return true;
    };
    DataTable.isDataTable = function(table) {
      var t = $(table).get(0);
      var is = false;
      if (table instanceof DataTable.Api) {
        return true;
      }
      $.each(DataTable.settings, function(i2, o) {
        var head = o.nScrollHead ? $("table", o.nScrollHead)[0] : null;
        var foot = o.nScrollFoot ? $("table", o.nScrollFoot)[0] : null;
        if (o.nTable === t || head === t || foot === t) {
          is = true;
        }
      });
      return is;
    };
    DataTable.tables = function(visible) {
      var api = false;
      if ($.isPlainObject(visible)) {
        api = visible.api;
        visible = visible.visible;
      }
      var a = DataTable.settings.filter(function(o) {
        return !visible || visible && $(o.nTable).is(":visible") ? true : false;
      }).map(function(o) {
        return o.nTable;
      });
      return api ? new _Api(a) : a;
    };
    DataTable.camelToHungarian = _fnCamelToHungarian;
    _api_register("$()", function(selector, opts) {
      var rows = this.rows(opts).nodes(), jqRows = $(rows);
      return $([].concat(
        jqRows.filter(selector).toArray(),
        jqRows.find(selector).toArray()
      ));
    });
    $.each(["on", "one", "off"], function(i2, key2) {
      _api_register(key2 + "()", function() {
        var args = Array.prototype.slice.call(arguments);
        args[0] = args[0].split(/\s/).map(function(e) {
          return !e.match(/\.dt\b/) ? e + ".dt" : e;
        }).join(" ");
        var inst = $(this.tables().nodes());
        inst[key2].apply(inst, args);
        return this;
      });
    });
    _api_register("clear()", function() {
      return this.iterator("table", function(settings) {
        _fnClearTable(settings);
      });
    });
    _api_register("error()", function(msg) {
      return this.iterator("table", function(settings) {
        _fnLog(settings, 0, msg);
      });
    });
    _api_register("settings()", function() {
      return new _Api(this.context, this.context);
    });
    _api_register("init()", function() {
      var ctx = this.context;
      return ctx.length ? ctx[0].oInit : null;
    });
    _api_register("data()", function() {
      return this.iterator("table", function(settings) {
        return _pluck(settings.aoData, "_aData");
      }).flatten();
    });
    _api_register("trigger()", function(name, args, bubbles) {
      return this.iterator("table", function(settings) {
        return _fnCallbackFire(settings, null, name, args, bubbles);
      }).flatten();
    });
    _api_register("ready()", function(fn) {
      var ctx = this.context;
      if (!fn) {
        return ctx.length ? ctx[0]._bInitComplete || false : null;
      }
      return this.tables().every(function() {
        var api = this;
        if (this.context[0]._bInitComplete) {
          fn.call(api);
        } else {
          this.on("init.dt.DT", function() {
            fn.call(api);
          });
        }
      });
    });
    _api_register("destroy()", function(remove) {
      remove = remove || false;
      return this.iterator("table", function(settings) {
        var classes = settings.oClasses;
        var table = settings.nTable;
        var tbody = settings.nTBody;
        var thead = settings.nTHead;
        var tfoot = settings.nTFoot;
        var jqTable = $(table);
        var jqTbody = $(tbody);
        var jqWrapper = $(settings.nTableWrapper);
        var rows = settings.aoData.map(function(r) {
          return r ? r.nTr : null;
        });
        var orderClasses = classes.order;
        settings.bDestroying = true;
        _fnCallbackFire(settings, "aoDestroyCallback", "destroy", [settings], true);
        if (!remove) {
          new _Api(settings).columns().visible(true);
        }
        if (settings.resizeObserver) {
          settings.resizeObserver.disconnect();
        }
        jqWrapper.off(".DT").find(":not(tbody *)").off(".DT");
        $(window).off(".DT-" + settings.sInstance);
        if (table != thead.parentNode) {
          jqTable.children("thead").detach();
          jqTable.append(thead);
        }
        if (tfoot && table != tfoot.parentNode) {
          jqTable.children("tfoot").detach();
          jqTable.append(tfoot);
        }
        cleanHeader(thead, "header");
        cleanHeader(tfoot, "footer");
        settings.colgroup.remove();
        settings.aaSorting = [];
        settings.aaSortingFixed = [];
        _fnSortingClasses(settings);
        $(jqTable).find("th, td").removeClass(
          $.map(DataTable.ext.type.className, function(v) {
            return v;
          }).join(" ")
        );
        $("th, td", thead).removeClass(
          orderClasses.none + " " + orderClasses.canAsc + " " + orderClasses.canDesc + " " + orderClasses.isAsc + " " + orderClasses.isDesc
        ).css("width", "").removeAttr("aria-sort");
        jqTbody.children().detach();
        jqTbody.append(rows);
        var orig = settings.nTableWrapper.parentNode;
        var insertBefore = settings.nTableWrapper.nextSibling;
        var removedMethod = remove ? "remove" : "detach";
        jqTable[removedMethod]();
        jqWrapper[removedMethod]();
        if (!remove && orig) {
          orig.insertBefore(table, insertBefore);
          jqTable.css("width", settings.sDestroyWidth).removeClass(classes.table);
        }
        var idx = DataTable.settings.indexOf(settings);
        if (idx !== -1) {
          DataTable.settings.splice(idx, 1);
        }
      });
    });
    $.each(["column", "row", "cell"], function(i2, type) {
      _api_register(type + "s().every()", function(fn) {
        var opts = this.selector.opts;
        var api = this;
        var inst;
        var counter = 0;
        return this.iterator("every", function(settings, selectedIdx, tableIdx) {
          inst = api[type](selectedIdx, opts);
          if (type === "cell") {
            fn.call(inst, inst[0][0].row, inst[0][0].column, tableIdx, counter);
          } else {
            fn.call(inst, selectedIdx, tableIdx, counter);
          }
          counter++;
        });
      });
    });
    _api_register("i18n()", function(token, def, plural) {
      var ctx = this.context[0];
      var resolved = _fnGetObjectDataFn(token)(ctx.oLanguage);
      if (resolved === void 0) {
        resolved = def;
      }
      if ($.isPlainObject(resolved)) {
        resolved = plural !== void 0 && resolved[plural] !== void 0 ? resolved[plural] : plural === false ? resolved : resolved._;
      }
      return typeof resolved === "string" ? resolved.replace("%d", plural) : resolved;
    });
    function cleanHeader(node, className) {
      $(node).find("span.dt-column-order").remove();
      $(node).find("span.dt-column-title").each(function() {
        var title = $(this).html();
        $(this).parent().parent().append(title);
        $(this).remove();
      });
      $(node).find("div.dt-column-" + className).remove();
      $("th, td", node).removeAttr("data-dt-column");
    }
    DataTable.version = "2.3.4";
    DataTable.settings = [];
    DataTable.models = {};
    DataTable.models.oSearch = {
      /**
       * Flag to whether or not the filtering should be case-insensitive
       */
      "caseInsensitive": true,
      /**
       * Applied search term
       */
      "search": "",
      /**
       * Flag to indicate if the search term should be interpreted as a
       * regular expression (true) or not (false) and therefore and special
       * regex characters escaped.
       */
      "regex": false,
      /**
       * Flag to indicate if DataTables is to use its smart filtering or not.
       */
      "smart": true,
      /**
       * Flag to indicate if DataTables should only trigger a search when
       * the return key is pressed.
       */
      "return": false
    };
    DataTable.models.oRow = {
      /**
       * TR element for the row
       */
      "nTr": null,
      /**
       * Array of TD elements for each row. This is null until the row has been
       * created.
       */
      "anCells": null,
      /**
       * Data object from the original data source for the row. This is either
       * an array if using the traditional form of DataTables, or an object if
       * using mData options. The exact type will depend on the passed in
       * data from the data source, or will be an array if using DOM a data
       * source.
       */
      "_aData": [],
      /**
       * Sorting data cache - this array is ostensibly the same length as the
       * number of columns (although each index is generated only as it is
       * needed), and holds the data that is used for sorting each column in the
       * row. We do this cache generation at the start of the sort in order that
       * the formatting of the sort data need be done only once for each cell
       * per sort. This array should not be read from or written to by anything
       * other than the master sorting methods.
       */
      "_aSortData": null,
      /**
       * Per cell filtering data cache. As per the sort data cache, used to
       * increase the performance of the filtering in DataTables
       */
      "_aFilterData": null,
      /**
       * Filtering data cache. This is the same as the cell filtering cache, but
       * in this case a string rather than an array. This is easily computed with
       * a join on `_aFilterData`, but is provided as a cache so the join isn't
       * needed on every search (memory traded for performance)
       */
      "_sFilterRow": null,
      /**
       * Denote if the original data source was from the DOM, or the data source
       * object. This is used for invalidating data, so DataTables can
       * automatically read data from the original source, unless uninstructed
       * otherwise.
       */
      "src": null,
      /**
       * Index in the aoData array. This saves an indexOf lookup when we have the
       * object, but want to know the index
       */
      "idx": -1,
      /**
       * Cached display value
       */
      displayData: null
    };
    DataTable.models.oColumn = {
      /**
       * Column index.
       */
      "idx": null,
      /**
       * A list of the columns that sorting should occur on when this column
       * is sorted. That this property is an array allows multi-column sorting
       * to be defined for a column (for example first name / last name columns
       * would benefit from this). The values are integers pointing to the
       * columns to be sorted on (typically it will be a single integer pointing
       * at itself, but that doesn't need to be the case).
       */
      "aDataSort": null,
      /**
       * Define the sorting directions that are applied to the column, in sequence
       * as the column is repeatedly sorted upon - i.e. the first value is used
       * as the sorting direction when the column if first sorted (clicked on).
       * Sort it again (click again) and it will move on to the next index.
       * Repeat until loop.
       */
      "asSorting": null,
      /**
       * Flag to indicate if the column is searchable, and thus should be included
       * in the filtering or not.
       */
      "bSearchable": null,
      /**
       * Flag to indicate if the column is sortable or not.
       */
      "bSortable": null,
      /**
       * Flag to indicate if the column is currently visible in the table or not
       */
      "bVisible": null,
      /**
       * Store for manual type assignment using the `column.type` option. This
       * is held in store so we can manipulate the column's `sType` property.
       */
      "_sManualType": null,
      /**
       * Flag to indicate if HTML5 data attributes should be used as the data
       * source for filtering or sorting. True is either are.
       */
      "_bAttrSrc": false,
      /**
       * Developer definable function that is called whenever a cell is created (Ajax source,
       * etc) or processed for input (DOM source). This can be used as a compliment to mRender
       * allowing you to modify the DOM element (add background colour for example) when the
       * element is available.
       */
      "fnCreatedCell": null,
      /**
       * Function to get data from a cell in a column. You should <b>never</b>
       * access data directly through _aData internally in DataTables - always use
       * the method attached to this property. It allows mData to function as
       * required. This function is automatically assigned by the column
       * initialisation method
       */
      "fnGetData": null,
      /**
       * Function to set data for a cell in the column. You should <b>never</b>
       * set the data directly to _aData internally in DataTables - always use
       * this method. It allows mData to function as required. This function
       * is automatically assigned by the column initialisation method
       */
      "fnSetData": null,
      /**
       * Property to read the value for the cells in the column from the data
       * source array / object. If null, then the default content is used, if a
       * function is given then the return from the function is used.
       */
      "mData": null,
      /**
       * Partner property to mData which is used (only when defined) to get
       * the data - i.e. it is basically the same as mData, but without the
       * 'set' option, and also the data fed to it is the result from mData.
       * This is the rendering method to match the data method of mData.
       */
      "mRender": null,
      /**
       * The class to apply to all TD elements in the table's TBODY for the column
       */
      "sClass": null,
      /**
       * When DataTables calculates the column widths to assign to each column,
       * it finds the longest string in each column and then constructs a
       * temporary table and reads the widths from that. The problem with this
       * is that "mmm" is much wider then "iiii", but the latter is a longer
       * string - thus the calculation can go wrong (doing it properly and putting
       * it into an DOM object and measuring that is horribly(!) slow). Thus as
       * a "work around" we provide this option. It will append its value to the
       * text that is found to be the longest string for the column - i.e. padding.
       */
      "sContentPadding": null,
      /**
       * Allows a default value to be given for a column's data, and will be used
       * whenever a null data source is encountered (this can be because mData
       * is set to null, or because the data source itself is null).
       */
      "sDefaultContent": null,
      /**
       * Name for the column, allowing reference to the column by name as well as
       * by index (needs a lookup to work by name).
       */
      "sName": null,
      /**
       * Custom sorting data type - defines which of the available plug-ins in
       * afnSortData the custom sorting will use - if any is defined.
       */
      "sSortDataType": "std",
      /**
       * Class to be applied to the header element when sorting on this column
       */
      "sSortingClass": null,
      /**
       * Title of the column - what is seen in the TH element (nTh).
       */
      "sTitle": null,
      /**
       * Column sorting and filtering type
       */
      "sType": null,
      /**
       * Width of the column
       */
      "sWidth": null,
      /**
       * Width of the column when it was first "encountered"
       */
      "sWidthOrig": null,
      /** Cached string which is the longest in the column */
      maxLenString: null,
      /**
       * Store for named searches
       */
      searchFixed: null
    };
    DataTable.defaults = {
      /**
       * An array of data to use for the table, passed in at initialisation which
       * will be used in preference to any data which is already in the DOM. This is
       * particularly useful for constructing tables purely in JavaScript, for
       * example with a custom Ajax call.
       */
      "aaData": null,
      /**
       * If ordering is enabled, then DataTables will perform a first pass sort on
       * initialisation. You can define which column(s) the sort is performed
       * upon, and the sorting direction, with this variable. The `sorting` array
       * should contain an array for each column to be sorted initially containing
       * the column's index and a direction string ('asc' or 'desc').
       */
      "aaSorting": [[0, "asc"]],
      /**
       * This parameter is basically identical to the `sorting` parameter, but
       * cannot be overridden by user interaction with the table. What this means
       * is that you could have a column (visible or hidden) which the sorting
       * will always be forced on first - any sorting after that (from the user)
       * will then be performed as required. This can be useful for grouping rows
       * together.
       */
      "aaSortingFixed": [],
      /**
       * DataTables can be instructed to load data to display in the table from a
       * Ajax source. This option defines how that Ajax call is made and where to.
       *
       * The `ajax` property has three different modes of operation, depending on
       * how it is defined. These are:
       *
       * * `string` - Set the URL from where the data should be loaded from.
       * * `object` - Define properties for `jQuery.ajax`.
       * * `function` - Custom data get function
       *
       * `string`
       * --------
       *
       * As a string, the `ajax` property simply defines the URL from which
       * DataTables will load data.
       *
       * `object`
       * --------
       *
       * As an object, the parameters in the object are passed to
       * [jQuery.ajax](https://api.jquery.com/jQuery.ajax/) allowing fine control
       * of the Ajax request. DataTables has a number of default parameters which
       * you can override using this option. Please refer to the jQuery
       * documentation for a full description of the options available, although
       * the following parameters provide additional options in DataTables or
       * require special consideration:
       *
       * * `data` - As with jQuery, `data` can be provided as an object, but it
       *   can also be used as a function to manipulate the data DataTables sends
       *   to the server. The function takes a single parameter, an object of
       *   parameters with the values that DataTables has readied for sending. An
       *   object may be returned which will be merged into the DataTables
       *   defaults, or you can add the items to the object that was passed in and
       *   not return anything from the function. This supersedes `fnServerParams`
       *   from DataTables 1.9-.
       *
       * * `dataSrc` - By default DataTables will look for the property `data` (or
       *   `aaData` for compatibility with DataTables 1.9-) when obtaining data
       *   from an Ajax source or for server-side processing - this parameter
       *   allows that property to be changed. You can use JavaScript dotted
       *   object notation to get a data source for multiple levels of nesting, or
       *   it my be used as a function. As a function it takes a single parameter,
       *   the JSON returned from the server, which can be manipulated as
       *   required, with the returned value being that used by DataTables as the
       *   data source for the table.
       *
       * * `success` - Should not be overridden it is used internally in
       *   DataTables. To manipulate / transform the data returned by the server
       *   use `ajax.dataSrc`, or use `ajax` as a function (see below).
       *
       * `function`
       * ----------
       *
       * As a function, making the Ajax call is left up to yourself allowing
       * complete control of the Ajax request. Indeed, if desired, a method other
       * than Ajax could be used to obtain the required data, such as Web storage
       * or an AIR database.
       *
       * The function is given four parameters and no return is required. The
       * parameters are:
       *
       * 1. _object_ - Data to send to the server
       * 2. _function_ - Callback function that must be executed when the required
       *    data has been obtained. That data should be passed into the callback
       *    as the only parameter
       * 3. _object_ - DataTables settings object for the table
       */
      "ajax": null,
      /**
       * This parameter allows you to readily specify the entries in the length drop
       * down menu that DataTables shows when pagination is enabled. It can be
       * either a 1D array of options which will be used for both the displayed
       * option and the value, or a 2D array which will use the array in the first
       * position as the value, and the array in the second position as the
       * displayed options (useful for language strings such as 'All').
       *
       * Note that the `pageLength` property will be automatically set to the
       * first value given in this array, unless `pageLength` is also provided.
       */
      "aLengthMenu": [10, 25, 50, 100],
      /**
       * The `columns` option in the initialisation parameter allows you to define
       * details about the way individual columns behave. For a full list of
       * column options that can be set, please see
       * {@link DataTable.defaults.column}. Note that if you use `columns` to
       * define your columns, you must have an entry in the array for every single
       * column that you have in your table (these can be null if you don't which
       * to specify any options).
       */
      "aoColumns": null,
      /**
       * Very similar to `columns`, `columnDefs` allows you to target a specific
       * column, multiple columns, or all columns, using the `targets` property of
       * each object in the array. This allows great flexibility when creating
       * tables, as the `columnDefs` arrays can be of any length, targeting the
       * columns you specifically want. `columnDefs` may use any of the column
       * options available: {@link DataTable.defaults.column}, but it _must_
       * have `targets` defined in each object in the array. Values in the `targets`
       * array may be:
       *   <ul>
       *     <li>a string - class name will be matched on the TH for the column</li>
       *     <li>0 or a positive integer - column index counting from the left</li>
       *     <li>a negative integer - column index counting from the right</li>
       *     <li>the string "_all" - all columns (i.e. assign a default)</li>
       *   </ul>
       */
      "aoColumnDefs": null,
      /**
       * Basically the same as `search`, this parameter defines the individual column
       * filtering state at initialisation time. The array must be of the same size
       * as the number of columns, and each element be an object with the parameters
       * `search` and `escapeRegex` (the latter is optional). 'null' is also
       * accepted and the default will be used.
       */
      "aoSearchCols": [],
      /**
       * Enable or disable automatic column width calculation. This can be disabled
       * as an optimisation (it takes some time to calculate the widths) if the
       * tables widths are passed in using `columns`.
       */
      "bAutoWidth": true,
      /**
       * Deferred rendering can provide DataTables with a huge speed boost when you
       * are using an Ajax or JS data source for the table. This option, when set to
       * true, will cause DataTables to defer the creation of the table elements for
       * each row until they are needed for a draw - saving a significant amount of
       * time.
       */
      "bDeferRender": true,
      /**
       * Replace a DataTable which matches the given selector and replace it with
       * one which has the properties of the new initialisation object passed. If no
       * table matches the selector, then the new DataTable will be constructed as
       * per normal.
       */
      "bDestroy": false,
      /**
       * Enable or disable filtering of data. Filtering in DataTables is "smart" in
       * that it allows the end user to input multiple words (space separated) and
       * will match a row containing those words, even if not in the order that was
       * specified (this allow matching across multiple columns). Note that if you
       * wish to use filtering in DataTables this must remain 'true' - to remove the
       * default filtering input box and retain filtering abilities, please use
       * {@link DataTable.defaults.dom}.
       */
      "bFilter": true,
      /**
       * Used only for compatibility with DT1
       * @deprecated
       */
      "bInfo": true,
      /**
       * Used only for compatibility with DT1
       * @deprecated
       */
      "bLengthChange": true,
      /**
       * Enable or disable pagination.
       */
      "bPaginate": true,
      /**
       * Enable or disable the display of a 'processing' indicator when the table is
       * being processed (e.g. a sort). This is particularly useful for tables with
       * large amounts of data where it can take a noticeable amount of time to sort
       * the entries.
       */
      "bProcessing": false,
      /**
       * Retrieve the DataTables object for the given selector. Note that if the
       * table has already been initialised, this parameter will cause DataTables
       * to simply return the object that has already been set up - it will not take
       * account of any changes you might have made to the initialisation object
       * passed to DataTables (setting this parameter to true is an acknowledgement
       * that you understand this). `destroy` can be used to reinitialise a table if
       * you need.
       */
      "bRetrieve": false,
      /**
       * When vertical (y) scrolling is enabled, DataTables will force the height of
       * the table's viewport to the given height at all times (useful for layout).
       * However, this can look odd when filtering data down to a small data set,
       * and the footer is left "floating" further down. This parameter (when
       * enabled) will cause DataTables to collapse the table's viewport down when
       * the result set will fit within the given Y height.
       */
      "bScrollCollapse": false,
      /**
       * Configure DataTables to use server-side processing. Note that the
       * `ajax` parameter must also be given in order to give DataTables a
       * source to obtain the required data for each draw.
       */
      "bServerSide": false,
      /**
       * Enable or disable sorting of columns. Sorting of individual columns can be
       * disabled by the `sortable` option for each column.
       */
      "bSort": true,
      /**
       * Enable or display DataTables' ability to sort multiple columns at the
       * same time (activated by shift-click by the user).
       */
      "bSortMulti": true,
      /**
       * Allows control over whether DataTables should use the top (true) unique
       * cell that is found for a single column, or the bottom (false - default).
       * This is useful when using complex headers.
       */
      "bSortCellsTop": null,
      /** Specify which row is the title row in the header. Replacement for bSortCellsTop */
      titleRow: null,
      /**
       * Enable or disable the addition of the classes `sorting\_1`, `sorting\_2` and
       * `sorting\_3` to the columns which are currently being sorted on. This is
       * presented as a feature switch as it can increase processing time (while
       * classes are removed and added) so for large data sets you might want to
       * turn this off.
       */
      "bSortClasses": true,
      /**
       * Enable or disable state saving. When enabled HTML5 `localStorage` will be
       * used to save table display information such as pagination information,
       * display length, filtering and sorting. As such when the end user reloads
       * the page the display will match what thy had previously set up.
       */
      "bStateSave": false,
      /**
       * This function is called when a TR element is created (and all TD child
       * elements have been inserted), or registered if using a DOM source, allowing
       * manipulation of the TR element (adding classes etc).
       */
      "fnCreatedRow": null,
      /**
       * This function is called on every 'draw' event, and allows you to
       * dynamically modify any aspect you want about the created DOM.
       */
      "fnDrawCallback": null,
      /**
       * Identical to fnHeaderCallback() but for the table footer this function
       * allows you to modify the table footer on every 'draw' event.
       */
      "fnFooterCallback": null,
      /**
       * When rendering large numbers in the information element for the table
       * (i.e. "Showing 1 to 10 of 57 entries") DataTables will render large numbers
       * to have a comma separator for the 'thousands' units (e.g. 1 million is
       * rendered as "1,000,000") to help readability for the end user. This
       * function will override the default method DataTables uses.
       */
      "fnFormatNumber": function(toFormat) {
        return toFormat.toString().replace(
          /\B(?=(\d{3})+(?!\d))/g,
          this.oLanguage.sThousands
        );
      },
      /**
       * This function is called on every 'draw' event, and allows you to
       * dynamically modify the header row. This can be used to calculate and
       * display useful information about the table.
       */
      "fnHeaderCallback": null,
      /**
       * The information element can be used to convey information about the current
       * state of the table. Although the internationalisation options presented by
       * DataTables are quite capable of dealing with most customisations, there may
       * be times where you wish to customise the string further. This callback
       * allows you to do exactly that.
       */
      "fnInfoCallback": null,
      /**
       * Called when the table has been initialised. Normally DataTables will
       * initialise sequentially and there will be no need for this function,
       * however, this does not hold true when using external language information
       * since that is obtained using an async XHR call.
       */
      "fnInitComplete": null,
      /**
       * Called at the very start of each table draw and can be used to cancel the
       * draw by returning false, any other return (including undefined) results in
       * the full draw occurring).
       */
      "fnPreDrawCallback": null,
      /**
       * This function allows you to 'post process' each row after it have been
       * generated for each table draw, but before it is rendered on screen. This
       * function might be used for setting the row class name etc.
       */
      "fnRowCallback": null,
      /**
       * Load the table state. With this function you can define from where, and how, the
       * state of a table is loaded. By default DataTables will load from `localStorage`
       * but you might wish to use a server-side database or cookies.
       */
      "fnStateLoadCallback": function(settings) {
        try {
          return JSON.parse(
            (settings.iStateDuration === -1 ? sessionStorage : localStorage).getItem(
              "DataTables_" + settings.sInstance + "_" + location.pathname
            )
          );
        } catch (e) {
          return {};
        }
      },
      /**
       * Callback which allows modification of the saved state prior to loading that state.
       * This callback is called when the table is loading state from the stored data, but
       * prior to the settings object being modified by the saved state. Note that for
       * plug-in authors, you should use the `stateLoadParams` event to load parameters for
       * a plug-in.
       */
      "fnStateLoadParams": null,
      /**
       * Callback that is called when the state has been loaded from the state saving method
       * and the DataTables settings object has been modified as a result of the loaded state.
       */
      "fnStateLoaded": null,
      /**
       * Save the table state. This function allows you to define where and how the state
       * information for the table is stored By default DataTables will use `localStorage`
       * but you might wish to use a server-side database or cookies.
       */
      "fnStateSaveCallback": function(settings, data) {
        try {
          (settings.iStateDuration === -1 ? sessionStorage : localStorage).setItem(
            "DataTables_" + settings.sInstance + "_" + location.pathname,
            JSON.stringify(data)
          );
        } catch (e) {
        }
      },
      /**
       * Callback which allows modification of the state to be saved. Called when the table
       * has changed state a new state save is required. This method allows modification of
       * the state saving object prior to actually doing the save, including addition or
       * other state properties or modification. Note that for plug-in authors, you should
       * use the `stateSaveParams` event to save parameters for a plug-in.
       */
      "fnStateSaveParams": null,
      /**
       * Duration for which the saved state information is considered valid. After this period
       * has elapsed the state will be returned to the default.
       * Value is given in seconds.
       */
      "iStateDuration": 7200,
      /**
       * Number of rows to display on a single page when using pagination. If
       * feature enabled (`lengthChange`) then the end user will be able to override
       * this to a custom setting using a pop-up menu.
       */
      "iDisplayLength": 10,
      /**
       * Define the starting point for data display when using DataTables with
       * pagination. Note that this parameter is the number of records, rather than
       * the page number, so if you have 10 records per page and want to start on
       * the third page, it should be "20".
       */
      "iDisplayStart": 0,
      /**
       * By default DataTables allows keyboard navigation of the table (sorting, paging,
       * and filtering) by adding a `tabindex` attribute to the required elements. This
       * allows you to tab through the controls and press the enter key to activate them.
       * The tabindex is default 0, meaning that the tab follows the flow of the document.
       * You can overrule this using this parameter if you wish. Use a value of -1 to
       * disable built-in keyboard navigation.
       */
      "iTabIndex": 0,
      /**
       * Classes that DataTables assigns to the various components and features
       * that it adds to the HTML table. This allows classes to be configured
       * during initialisation in addition to through the static
       * {@link DataTable.ext.oStdClasses} object).
       */
      "oClasses": {},
      /**
       * All strings that DataTables uses in the user interface that it creates
       * are defined in this object, allowing you to modified them individually or
       * completely replace them all as required.
       */
      "oLanguage": {
        /**
         * Strings that are used for WAI-ARIA labels and controls only (these are not
         * actually visible on the page, but will be read by screenreaders, and thus
         * must be internationalised as well).
         */
        "oAria": {
          /**
           * ARIA label that is added to the table headers when the column may be sorted
           */
          "orderable": ": Activate to sort",
          /**
           * ARIA label that is added to the table headers when the column is currently being sorted
           */
          "orderableReverse": ": Activate to invert sorting",
          /**
           * ARIA label that is added to the table headers when the column is currently being 
           * sorted and next step is to remove sorting
           */
          "orderableRemove": ": Activate to remove sorting",
          paginate: {
            first: "First",
            last: "Last",
            next: "Next",
            previous: "Previous",
            number: ""
          }
        },
        /**
         * Pagination string used by DataTables for the built-in pagination
         * control types.
         */
        "oPaginate": {
          /**
           * Label and character for first page button («)
           */
          "sFirst": "«",
          /**
           * Last page button (»)
           */
          "sLast": "»",
          /**
           * Next page button (›)
           */
          "sNext": "›",
          /**
           * Previous page button (‹)
           */
          "sPrevious": "‹"
        },
        /**
         * Plural object for the data type the table is showing
         */
        entries: {
          _: "entries",
          1: "entry"
        },
        /**
         * Page length options
         */
        lengthLabels: {
          "-1": "All"
        },
        /**
         * This string is shown in preference to `zeroRecords` when the table is
         * empty of data (regardless of filtering). Note that this is an optional
         * parameter - if it is not given, the value of `zeroRecords` will be used
         * instead (either the default or given value).
         */
        "sEmptyTable": "No data available in table",
        /**
         * This string gives information to the end user about the information
         * that is current on display on the page. The following tokens can be
         * used in the string and will be dynamically replaced as the table
         * display updates. This tokens can be placed anywhere in the string, or
         * removed as needed by the language requires:
         *
         * * `\_START\_` - Display index of the first record on the current page
         * * `\_END\_` - Display index of the last record on the current page
         * * `\_TOTAL\_` - Number of records in the table after filtering
         * * `\_MAX\_` - Number of records in the table without filtering
         * * `\_PAGE\_` - Current page number
         * * `\_PAGES\_` - Total number of pages of data in the table
         */
        "sInfo": "Showing _START_ to _END_ of _TOTAL_ _ENTRIES-TOTAL_",
        /**
         * Display information string for when the table is empty. Typically the
         * format of this string should match `info`.
         */
        "sInfoEmpty": "Showing 0 to 0 of 0 _ENTRIES-TOTAL_",
        /**
         * When a user filters the information in a table, this string is appended
         * to the information (`info`) to give an idea of how strong the filtering
         * is. The variable _MAX_ is dynamically updated.
         */
        "sInfoFiltered": "(filtered from _MAX_ total _ENTRIES-MAX_)",
        /**
         * If can be useful to append extra information to the info string at times,
         * and this variable does exactly that. This information will be appended to
         * the `info` (`infoEmpty` and `infoFiltered` in whatever combination they are
         * being used) at all times.
         */
        "sInfoPostFix": "",
        /**
         * This decimal place operator is a little different from the other
         * language options since DataTables doesn't output floating point
         * numbers, so it won't ever use this for display of a number. Rather,
         * what this parameter does is modify the sort methods of the table so
         * that numbers which are in a format which has a character other than
         * a period (`.`) as a decimal place will be sorted numerically.
         *
         * Note that numbers with different decimal places cannot be shown in
         * the same table and still be sortable, the table must be consistent.
         * However, multiple different tables on the page can use different
         * decimal place characters.
         */
        "sDecimal": "",
        /**
         * DataTables has a build in number formatter (`formatNumber`) which is
         * used to format large numbers that are used in the table information.
         * By default a comma is used, but this can be trivially changed to any
         * character you wish with this parameter.
         */
        "sThousands": ",",
        /**
         * Detail the action that will be taken when the drop down menu for the
         * pagination length option is changed. The '_MENU_' variable is replaced
         * with a default select list of 10, 25, 50 and 100, and can be replaced
         * with a custom select box if required.
         */
        "sLengthMenu": "_MENU_ _ENTRIES_ per page",
        /**
         * When using Ajax sourced data and during the first draw when DataTables is
         * gathering the data, this message is shown in an empty row in the table to
         * indicate to the end user the data is being loaded. Note that this
         * parameter is not used when loading data by server-side processing, just
         * Ajax sourced data with client-side processing.
         */
        "sLoadingRecords": "Loading...",
        /**
         * Text which is displayed when the table is processing a user action
         * (usually a sort command or similar).
         */
        "sProcessing": "",
        /**
         * Details the actions that will be taken when the user types into the
         * filtering input text box. The variable "_INPUT_", if used in the string,
         * is replaced with the HTML text box for the filtering input allowing
         * control over where it appears in the string. If "_INPUT_" is not given
         * then the input box is appended to the string automatically.
         */
        "sSearch": "Search:",
        /**
         * Assign a `placeholder` attribute to the search `input` element
         *  @type string
         *  @default 
         *
         *  @dtopt Language
         *  @name DataTable.defaults.language.searchPlaceholder
         */
        "sSearchPlaceholder": "",
        /**
         * All of the language information can be stored in a file on the
         * server-side, which DataTables will look up if this parameter is passed.
         * It must store the URL of the language file, which is in a JSON format,
         * and the object has the same properties as the oLanguage object in the
         * initialiser object (i.e. the above parameters). Please refer to one of
         * the example language files to see how this works in action.
         */
        "sUrl": "",
        /**
         * Text shown inside the table records when the is no information to be
         * displayed after filtering. `emptyTable` is shown when there is simply no
         * information in the table at all (regardless of filtering).
         */
        "sZeroRecords": "No matching records found"
      },
      /** The initial data order is reversed when `desc` ordering */
      orderDescReverse: true,
      /**
       * This parameter allows you to have define the global filtering state at
       * initialisation time. As an object the `search` parameter must be
       * defined, but all other parameters are optional. When `regex` is true,
       * the search string will be treated as a regular expression, when false
       * (default) it will be treated as a straight string. When `smart`
       * DataTables will use it's smart filtering methods (to word match at
       * any point in the data), when false this will not be done.
       */
      "oSearch": $.extend({}, DataTable.models.oSearch),
      /**
       * Table and control layout. This replaces the legacy `dom` option.
       */
      layout: {
        topStart: "pageLength",
        topEnd: "search",
        bottomStart: "info",
        bottomEnd: "paging"
      },
      /**
       * Legacy DOM layout option
       */
      "sDom": null,
      /**
       * Search delay option. This will throttle full table searches that use the
       * DataTables provided search input element (it does not effect calls to
       * `dt-api search()`, providing a delay before the search is made.
       */
      "searchDelay": null,
      /**
       * DataTables features six different built-in options for the buttons to
       * display for pagination control:
       *
       * * `numbers` - Page number buttons only
       * * `simple` - 'Previous' and 'Next' buttons only
       * * 'simple_numbers` - 'Previous' and 'Next' buttons, plus page numbers
       * * `full` - 'First', 'Previous', 'Next' and 'Last' buttons
       * * `full_numbers` - 'First', 'Previous', 'Next' and 'Last' buttons, plus page numbers
       * * `first_last_numbers` - 'First' and 'Last' buttons, plus page numbers
       */
      "sPaginationType": "",
      /**
       * Enable horizontal scrolling. When a table is too wide to fit into a
       * certain layout, or you have a large number of columns in the table, you
       * can enable x-scrolling to show the table in a viewport, which can be
       * scrolled. This property can be `true` which will allow the table to
       * scroll horizontally when needed, or any CSS unit, or a number (in which
       * case it will be treated as a pixel measurement). Setting as simply `true`
       * is recommended.
       */
      "sScrollX": "",
      /**
       * This property can be used to force a DataTable to use more width than it
       * might otherwise do when x-scrolling is enabled. For example if you have a
       * table which requires to be well spaced, this parameter is useful for
       * "over-sizing" the table, and thus forcing scrolling. This property can by
       * any CSS unit, or a number (in which case it will be treated as a pixel
       * measurement).
       */
      "sScrollXInner": "",
      /**
       * Enable vertical scrolling. Vertical scrolling will constrain the DataTable
       * to the given height, and enable scrolling for any data which overflows the
       * current viewport. This can be used as an alternative to paging to display
       * a lot of data in a small area (although paging and scrolling can both be
       * enabled at the same time). This property can be any CSS unit, or a number
       * (in which case it will be treated as a pixel measurement).
       */
      "sScrollY": "",
      /**
       * __Deprecated__ The functionality provided by this parameter has now been
       * superseded by that provided through `ajax`, which should be used instead.
       *
       * Set the HTTP method that is used to make the Ajax call for server-side
       * processing or Ajax sourced data.
       */
      "sServerMethod": "GET",
      /**
       * DataTables makes use of renderers when displaying HTML elements for
       * a table. These renderers can be added or modified by plug-ins to
       * generate suitable mark-up for a site. For example the Bootstrap
       * integration plug-in for DataTables uses a paging button renderer to
       * display pagination buttons in the mark-up required by Bootstrap.
       *
       * For further information about the renderers available see
       * DataTable.ext.renderer
       */
      "renderer": null,
      /**
       * Set the data property name that DataTables should use to get a row's id
       * to set as the `id` property in the node.
       */
      "rowId": "DT_RowId",
      /**
       * Caption value
       */
      "caption": null,
      /**
       * For server-side processing - use the data from the DOM for the first draw
       */
      iDeferLoading: null,
      /** Event listeners */
      on: null
    };
    _fnHungarianMap(DataTable.defaults);
    DataTable.defaults.column = {
      /**
       * Define which column(s) an order will occur on for this column. This
       * allows a column's ordering to take multiple columns into account when
       * doing a sort or use the data from a different column. For example first
       * name / last name columns make sense to do a multi-column sort over the
       * two columns.
       */
      "aDataSort": null,
      "iDataSort": -1,
      ariaTitle: "",
      /**
       * You can control the default ordering direction, and even alter the
       * behaviour of the sort handler (i.e. only allow ascending ordering etc)
       * using this parameter.
       */
      "asSorting": ["asc", "desc", ""],
      /**
       * Enable or disable filtering on the data in this column.
       */
      "bSearchable": true,
      /**
       * Enable or disable ordering on this column.
       */
      "bSortable": true,
      /**
       * Enable or disable the display of this column.
       */
      "bVisible": true,
      /**
       * Developer definable function that is called whenever a cell is created (Ajax source,
       * etc) or processed for input (DOM source). This can be used as a compliment to mRender
       * allowing you to modify the DOM element (add background colour for example) when the
       * element is available.
       */
      "fnCreatedCell": null,
      /**
       * This property can be used to read data from any data source property,
       * including deeply nested objects / properties. `data` can be given in a
       * number of different ways which effect its behaviour:
       *
       * * `integer` - treated as an array index for the data source. This is the
       *   default that DataTables uses (incrementally increased for each column).
       * * `string` - read an object property from the data source. There are
       *   three 'special' options that can be used in the string to alter how
       *   DataTables reads the data from the source object:
       *    * `.` - Dotted JavaScript notation. Just as you use a `.` in
       *      JavaScript to read from nested objects, so to can the options
       *      specified in `data`. For example: `browser.version` or
       *      `browser.name`. If your object parameter name contains a period, use
       *      `\\` to escape it - i.e. `first\\.name`.
       *    * `[]` - Array notation. DataTables can automatically combine data
       *      from and array source, joining the data with the characters provided
       *      between the two brackets. For example: `name[, ]` would provide a
       *      comma-space separated list from the source array. If no characters
       *      are provided between the brackets, the original array source is
       *      returned.
       *    * `()` - Function notation. Adding `()` to the end of a parameter will
       *      execute a function of the name given. For example: `browser()` for a
       *      simple function on the data source, `browser.version()` for a
       *      function in a nested property or even `browser().version` to get an
       *      object property if the function called returns an object. Note that
       *      function notation is recommended for use in `render` rather than
       *      `data` as it is much simpler to use as a renderer.
       * * `null` - use the original data source for the row rather than plucking
       *   data directly from it. This action has effects on two other
       *   initialisation options:
       *    * `defaultContent` - When null is given as the `data` option and
       *      `defaultContent` is specified for the column, the value defined by
       *      `defaultContent` will be used for the cell.
       *    * `render` - When null is used for the `data` option and the `render`
       *      option is specified for the column, the whole data source for the
       *      row is used for the renderer.
       * * `function` - the function given will be executed whenever DataTables
       *   needs to set or get the data for a cell in the column. The function
       *   takes three parameters:
       *    * Parameters:
       *      * `{array|object}` The data source for the row
       *      * `{string}` The type call data requested - this will be 'set' when
       *        setting data or 'filter', 'display', 'type', 'sort' or undefined
       *        when gathering data. Note that when `undefined` is given for the
       *        type DataTables expects to get the raw data for the object back<
       *      * `{*}` Data to set when the second parameter is 'set'.
       *    * Return:
       *      * The return value from the function is not required when 'set' is
       *        the type of call, but otherwise the return is what will be used
       *        for the data requested.
       *
       * Note that `data` is a getter and setter option. If you just require
       * formatting of data for output, you will likely want to use `render` which
       * is simply a getter and thus simpler to use.
       *
       * Note that prior to DataTables 1.9.2 `data` was called `mDataProp`. The
       * name change reflects the flexibility of this property and is consistent
       * with the naming of mRender. If 'mDataProp' is given, then it will still
       * be used by DataTables, as it automatically maps the old name to the new
       * if required.
       */
      "mData": null,
      /**
       * This property is the rendering partner to `data` and it is suggested that
       * when you want to manipulate data for display (including filtering,
       * sorting etc) without altering the underlying data for the table, use this
       * property. `render` can be considered to be the read only companion to
       * `data` which is read / write (then as such more complex). Like `data`
       * this option can be given in a number of different ways to effect its
       * behaviour:
       *
       * * `integer` - treated as an array index for the data source. This is the
       *   default that DataTables uses (incrementally increased for each column).
       * * `string` - read an object property from the data source. There are
       *   three 'special' options that can be used in the string to alter how
       *   DataTables reads the data from the source object:
       *    * `.` - Dotted JavaScript notation. Just as you use a `.` in
       *      JavaScript to read from nested objects, so to can the options
       *      specified in `data`. For example: `browser.version` or
       *      `browser.name`. If your object parameter name contains a period, use
       *      `\\` to escape it - i.e. `first\\.name`.
       *    * `[]` - Array notation. DataTables can automatically combine data
       *      from and array source, joining the data with the characters provided
       *      between the two brackets. For example: `name[, ]` would provide a
       *      comma-space separated list from the source array. If no characters
       *      are provided between the brackets, the original array source is
       *      returned.
       *    * `()` - Function notation. Adding `()` to the end of a parameter will
       *      execute a function of the name given. For example: `browser()` for a
       *      simple function on the data source, `browser.version()` for a
       *      function in a nested property or even `browser().version` to get an
       *      object property if the function called returns an object.
       * * `object` - use different data for the different data types requested by
       *   DataTables ('filter', 'display', 'type' or 'sort'). The property names
       *   of the object is the data type the property refers to and the value can
       *   defined using an integer, string or function using the same rules as
       *   `render` normally does. Note that an `_` option _must_ be specified.
       *   This is the default value to use if you haven't specified a value for
       *   the data type requested by DataTables.
       * * `function` - the function given will be executed whenever DataTables
       *   needs to set or get the data for a cell in the column. The function
       *   takes three parameters:
       *    * Parameters:
       *      * {array|object} The data source for the row (based on `data`)
       *      * {string} The type call data requested - this will be 'filter',
       *        'display', 'type' or 'sort'.
       *      * {array|object} The full data source for the row (not based on
       *        `data`)
       *    * Return:
       *      * The return value from the function is what will be used for the
       *        data requested.
       */
      "mRender": null,
      /**
       * Change the cell type created for the column - either TD cells or TH cells. This
       * can be useful as TH cells have semantic meaning in the table body, allowing them
       * to act as a header for a row (you may wish to add scope='row' to the TH elements).
       */
      "sCellType": "td",
      /**
       * Class to give to each cell in this column.
       */
      "sClass": "",
      /**
       * When DataTables calculates the column widths to assign to each column,
       * it finds the longest string in each column and then constructs a
       * temporary table and reads the widths from that. The problem with this
       * is that "mmm" is much wider then "iiii", but the latter is a longer
       * string - thus the calculation can go wrong (doing it properly and putting
       * it into an DOM object and measuring that is horribly(!) slow). Thus as
       * a "work around" we provide this option. It will append its value to the
       * text that is found to be the longest string for the column - i.e. padding.
       * Generally you shouldn't need this!
       */
      "sContentPadding": "",
      /**
       * Allows a default value to be given for a column's data, and will be used
       * whenever a null data source is encountered (this can be because `data`
       * is set to null, or because the data source itself is null).
       */
      "sDefaultContent": null,
      /**
       * This parameter is only used in DataTables' server-side processing. It can
       * be exceptionally useful to know what columns are being displayed on the
       * client side, and to map these to database fields. When defined, the names
       * also allow DataTables to reorder information from the server if it comes
       * back in an unexpected order (i.e. if you switch your columns around on the
       * client-side, your server-side code does not also need updating).
       */
      "sName": "",
      /**
       * Defines a data source type for the ordering which can be used to read
       * real-time information from the table (updating the internally cached
       * version) prior to ordering. This allows ordering to occur on user
       * editable elements such as form inputs.
       */
      "sSortDataType": "std",
      /**
       * The title of this column.
       */
      "sTitle": null,
      /**
       * The type allows you to specify how the data for this column will be
       * ordered. Four types (string, numeric, date and html (which will strip
       * HTML tags before ordering)) are currently available. Note that only date
       * formats understood by JavaScript's Date() object will be accepted as type
       * date. For example: "Mar 26, 2008 5:03 PM". May take the values: 'string',
       * 'numeric', 'date' or 'html' (by default). Further types can be adding
       * through plug-ins.
       */
      "sType": null,
      /**
       * Defining the width of the column, this parameter may take any CSS value
       * (3em, 20px etc). DataTables applies 'smart' widths to columns which have not
       * been given a specific width through this interface ensuring that the table
       * remains readable.
       */
      "sWidth": null
    };
    _fnHungarianMap(DataTable.defaults.column);
    DataTable.models.oSettings = {
      /**
       * Primary features of DataTables and their enablement state.
       */
      "oFeatures": {
        /**
         * Flag to say if DataTables should automatically try to calculate the
         * optimum table and columns widths (true) or not (false).
         * Note that this parameter will be set by the initialisation routine. To
         * set a default use {@link DataTable.defaults}.
         */
        "bAutoWidth": null,
        /**
         * Delay the creation of TR and TD elements until they are actually
         * needed by a driven page draw. This can give a significant speed
         * increase for Ajax source and JavaScript source data, but makes no
         * difference at all for DOM and server-side processing tables.
         * Note that this parameter will be set by the initialisation routine. To
         * set a default use {@link DataTable.defaults}.
         */
        "bDeferRender": null,
        /**
         * Enable filtering on the table or not. Note that if this is disabled
         * then there is no filtering at all on the table, including fnFilter.
         * To just remove the filtering input use sDom and remove the 'f' option.
         * Note that this parameter will be set by the initialisation routine. To
         * set a default use {@link DataTable.defaults}.
         */
        "bFilter": null,
        /**
         * Used only for compatibility with DT1
         * @deprecated
         */
        "bInfo": true,
        /**
         * Used only for compatibility with DT1
         * @deprecated
         */
        "bLengthChange": true,
        /**
         * Pagination enabled or not. Note that if this is disabled then length
         * changing must also be disabled.
         * Note that this parameter will be set by the initialisation routine. To
         * set a default use {@link DataTable.defaults}.
         */
        "bPaginate": null,
        /**
         * Processing indicator enable flag whenever DataTables is enacting a
         * user request - typically an Ajax request for server-side processing.
         * Note that this parameter will be set by the initialisation routine. To
         * set a default use {@link DataTable.defaults}.
         */
        "bProcessing": null,
        /**
         * Server-side processing enabled flag - when enabled DataTables will
         * get all data from the server for every draw - there is no filtering,
         * sorting or paging done on the client-side.
         * Note that this parameter will be set by the initialisation routine. To
         * set a default use {@link DataTable.defaults}.
         */
        "bServerSide": null,
        /**
         * Sorting enablement flag.
         * Note that this parameter will be set by the initialisation routine. To
         * set a default use {@link DataTable.defaults}.
         */
        "bSort": null,
        /**
         * Multi-column sorting
         * Note that this parameter will be set by the initialisation routine. To
         * set a default use {@link DataTable.defaults}.
         */
        "bSortMulti": null,
        /**
         * Apply a class to the columns which are being sorted to provide a
         * visual highlight or not. This can slow things down when enabled since
         * there is a lot of DOM interaction.
         * Note that this parameter will be set by the initialisation routine. To
         * set a default use {@link DataTable.defaults}.
         */
        "bSortClasses": null,
        /**
         * State saving enablement flag.
         * Note that this parameter will be set by the initialisation routine. To
         * set a default use {@link DataTable.defaults}.
         */
        "bStateSave": null
      },
      /**
       * Scrolling settings for a table.
       */
      "oScroll": {
        /**
         * When the table is shorter in height than sScrollY, collapse the
         * table container down to the height of the table (when true).
         * Note that this parameter will be set by the initialisation routine. To
         * set a default use {@link DataTable.defaults}.
         */
        "bCollapse": null,
        /**
         * Width of the scrollbar for the web-browser's platform. Calculated
         * during table initialisation.
         */
        "iBarWidth": 0,
        /**
         * Viewport width for horizontal scrolling. Horizontal scrolling is
         * disabled if an empty string.
         * Note that this parameter will be set by the initialisation routine. To
         * set a default use {@link DataTable.defaults}.
         */
        "sX": null,
        /**
         * Width to expand the table to when using x-scrolling. Typically you
         * should not need to use this.
         * Note that this parameter will be set by the initialisation routine. To
         * set a default use {@link DataTable.defaults}.
         *  @deprecated
         */
        "sXInner": null,
        /**
         * Viewport height for vertical scrolling. Vertical scrolling is disabled
         * if an empty string.
         * Note that this parameter will be set by the initialisation routine. To
         * set a default use {@link DataTable.defaults}.
         */
        "sY": null
      },
      /**
       * Language information for the table.
       */
      "oLanguage": {
        /**
         * Information callback function. See
         * {@link DataTable.defaults.fnInfoCallback}
         */
        "fnInfoCallback": null
      },
      /**
       * Browser support parameters
       */
      "oBrowser": {
        /**
         * Determine if the vertical scrollbar is on the right or left of the
         * scrolling container - needed for rtl language layout, although not
         * all browsers move the scrollbar (Safari).
         */
        "bScrollbarLeft": false,
        /**
         * Browser scrollbar width
         */
        "barWidth": 0
      },
      "ajax": null,
      /**
       * Array referencing the nodes which are used for the features. The
       * parameters of this object match what is allowed by sDom - i.e.
       *   <ul>
       *     <li>'l' - Length changing</li>
       *     <li>'f' - Filtering input</li>
       *     <li>'t' - The table!</li>
       *     <li>'i' - Information</li>
       *     <li>'p' - Pagination</li>
       *     <li>'r' - pRocessing</li>
       *   </ul>
       */
      "aanFeatures": [],
      /**
       * Store data information - see {@link DataTable.models.oRow} for detailed
       * information.
       */
      "aoData": [],
      /**
       * Array of indexes which are in the current display (after filtering etc)
       */
      "aiDisplay": [],
      /**
       * Array of indexes for display - no filtering
       */
      "aiDisplayMaster": [],
      /**
       * Map of row ids to data indexes
       */
      "aIds": {},
      /**
       * Store information about each column that is in use
       */
      "aoColumns": [],
      /**
       * Store information about the table's header
       */
      "aoHeader": [],
      /**
       * Store information about the table's footer
       */
      "aoFooter": [],
      /**
       * Store the applied global search information in case we want to force a
       * research or compare the old search to a new one.
       * Note that this parameter will be set by the initialisation routine. To
       * set a default use {@link DataTable.defaults}.
       */
      "oPreviousSearch": {},
      /**
       * Store for named searches
       */
      searchFixed: {},
      /**
       * Store the applied search for each column - see
       * {@link DataTable.models.oSearch} for the format that is used for the
       * filtering information for each column.
       */
      "aoPreSearchCols": [],
      /**
       * Sorting that is applied to the table. Note that the inner arrays are
       * used in the following manner:
       * <ul>
       *   <li>Index 0 - column number</li>
       *   <li>Index 1 - current sorting direction</li>
       * </ul>
       * Note that this parameter will be set by the initialisation routine. To
       * set a default use {@link DataTable.defaults}.
       */
      "aaSorting": null,
      /**
       * Sorting that is always applied to the table (i.e. prefixed in front of
       * aaSorting).
       * Note that this parameter will be set by the initialisation routine. To
       * set a default use {@link DataTable.defaults}.
       */
      "aaSortingFixed": [],
      /**
       * If restoring a table - we should restore its width
       */
      "sDestroyWidth": 0,
      /**
       * Callback functions array for every time a row is inserted (i.e. on a draw).
       */
      "aoRowCallback": [],
      /**
       * Callback functions for the header on each draw.
       */
      "aoHeaderCallback": [],
      /**
       * Callback function for the footer on each draw.
       */
      "aoFooterCallback": [],
      /**
       * Array of callback functions for draw callback functions
       */
      "aoDrawCallback": [],
      /**
       * Array of callback functions for row created function
       */
      "aoRowCreatedCallback": [],
      /**
       * Callback functions for just before the table is redrawn. A return of
       * false will be used to cancel the draw.
       */
      "aoPreDrawCallback": [],
      /**
       * Callback functions for when the table has been initialised.
       */
      "aoInitComplete": [],
      /**
       * Callbacks for modifying the settings to be stored for state saving, prior to
       * saving state.
       */
      "aoStateSaveParams": [],
      /**
       * Callbacks for modifying the settings that have been stored for state saving
       * prior to using the stored values to restore the state.
       */
      "aoStateLoadParams": [],
      /**
       * Callbacks for operating on the settings object once the saved state has been
       * loaded
       */
      "aoStateLoaded": [],
      /**
       * Cache the table ID for quick access
       */
      "sTableId": "",
      /**
       * The TABLE node for the main table
       */
      "nTable": null,
      /**
       * Permanent ref to the thead element
       */
      "nTHead": null,
      /**
       * Permanent ref to the tfoot element - if it exists
       */
      "nTFoot": null,
      /**
       * Permanent ref to the tbody element
       */
      "nTBody": null,
      /**
       * Cache the wrapper node (contains all DataTables controlled elements)
       */
      "nTableWrapper": null,
      /**
       * Indicate if all required information has been read in
       */
      "bInitialised": false,
      /**
       * Information about open rows. Each object in the array has the parameters
       * 'nTr' and 'nParent'
       */
      "aoOpenRows": [],
      /**
       * Dictate the positioning of DataTables' control elements - see
       * {@link DataTable.model.oInit.sDom}.
       * Note that this parameter will be set by the initialisation routine. To
       * set a default use {@link DataTable.defaults}.
       */
      "sDom": null,
      /**
       * Search delay (in mS)
       */
      "searchDelay": null,
      /**
       * Which type of pagination should be used.
       * Note that this parameter will be set by the initialisation routine. To
       * set a default use {@link DataTable.defaults}.
       */
      "sPaginationType": "two_button",
      /**
       * Number of paging controls on the page. Only used for backwards compatibility
       */
      pagingControls: 0,
      /**
       * The state duration (for `stateSave`) in seconds.
       * Note that this parameter will be set by the initialisation routine. To
       * set a default use {@link DataTable.defaults}.
       */
      "iStateDuration": 0,
      /**
       * Array of callback functions for state saving. Each array element is an
       * object with the following parameters:
       *   <ul>
       *     <li>function:fn - function to call. Takes two parameters, oSettings
       *       and the JSON string to save that has been thus far created. Returns
       *       a JSON string to be inserted into a json object
       *       (i.e. '"param": [ 0, 1, 2]')</li>
       *     <li>string:sName - name of callback</li>
       *   </ul>
       */
      "aoStateSave": [],
      /**
       * Array of callback functions for state loading. Each array element is an
       * object with the following parameters:
       *   <ul>
       *     <li>function:fn - function to call. Takes two parameters, oSettings
       *       and the object stored. May return false to cancel state loading</li>
       *     <li>string:sName - name of callback</li>
       *   </ul>
       */
      "aoStateLoad": [],
      /**
       * State that was saved. Useful for back reference
       */
      "oSavedState": null,
      /**
       * State that was loaded. Useful for back reference
       */
      "oLoadedState": null,
      /**
       * Note if draw should be blocked while getting data
       */
      "bAjaxDataGet": true,
      /**
       * The last jQuery XHR object that was used for server-side data gathering.
       * This can be used for working with the XHR information in one of the
       * callbacks
       */
      "jqXHR": null,
      /**
       * JSON returned from the server in the last Ajax request
       */
      "json": void 0,
      /**
       * Data submitted as part of the last Ajax request
       */
      "oAjaxData": void 0,
      /**
       * Send the XHR HTTP method - GET or POST (could be PUT or DELETE if
       * required).
       * Note that this parameter will be set by the initialisation routine. To
       * set a default use {@link DataTable.defaults}.
       */
      "sServerMethod": null,
      /**
       * Format numbers for display.
       * Note that this parameter will be set by the initialisation routine. To
       * set a default use {@link DataTable.defaults}.
       */
      "fnFormatNumber": null,
      /**
       * List of options that can be used for the user selectable length menu.
       * Note that this parameter will be set by the initialisation routine. To
       * set a default use {@link DataTable.defaults}.
       */
      "aLengthMenu": null,
      /**
       * Counter for the draws that the table does. Also used as a tracker for
       * server-side processing
       */
      "iDraw": 0,
      /**
       * Indicate if a redraw is being done - useful for Ajax
       */
      "bDrawing": false,
      /**
       * Draw index (iDraw) of the last error when parsing the returned data
       */
      "iDrawError": -1,
      /**
       * Paging display length
       */
      "_iDisplayLength": 10,
      /**
       * Paging start point - aiDisplay index
       */
      "_iDisplayStart": 0,
      /**
       * Server-side processing - number of records in the result set
       * (i.e. before filtering), Use fnRecordsTotal rather than
       * this property to get the value of the number of records, regardless of
       * the server-side processing setting.
       */
      "_iRecordsTotal": 0,
      /**
       * Server-side processing - number of records in the current display set
       * (i.e. after filtering). Use fnRecordsDisplay rather than
       * this property to get the value of the number of records, regardless of
       * the server-side processing setting.
       */
      "_iRecordsDisplay": 0,
      /**
       * The classes to use for the table
       */
      "oClasses": {},
      /**
       * Flag attached to the settings object so you can check in the draw
       * callback if filtering has been done in the draw. Deprecated in favour of
       * events.
       *  @deprecated
       */
      "bFiltered": false,
      /**
       * Flag attached to the settings object so you can check in the draw
       * callback if sorting has been done in the draw. Deprecated in favour of
       * events.
       *  @deprecated
       */
      "bSorted": false,
      /**
       * Indicate that if multiple rows are in the header and there is more than
       * one unique cell per column. Replaced by titleRow
       */
      "bSortCellsTop": null,
      /**
       * Initialisation object that is used for the table
       */
      "oInit": null,
      /**
       * Destroy callback functions - for plug-ins to attach themselves to the
       * destroy so they can clean up markup and events.
       */
      "aoDestroyCallback": [],
      /**
       * Get the number of records in the current record set, before filtering
       */
      "fnRecordsTotal": function() {
        return _fnDataSource(this) == "ssp" ? this._iRecordsTotal * 1 : this.aiDisplayMaster.length;
      },
      /**
       * Get the number of records in the current record set, after filtering
       */
      "fnRecordsDisplay": function() {
        return _fnDataSource(this) == "ssp" ? this._iRecordsDisplay * 1 : this.aiDisplay.length;
      },
      /**
       * Get the display end point - aiDisplay index
       */
      "fnDisplayEnd": function() {
        var len = this._iDisplayLength, start = this._iDisplayStart, calc = start + len, records = this.aiDisplay.length, features = this.oFeatures, paginate = features.bPaginate;
        if (features.bServerSide) {
          return paginate === false || len === -1 ? start + records : Math.min(start + len, this._iRecordsDisplay);
        } else {
          return !paginate || calc > records || len === -1 ? records : calc;
        }
      },
      /**
       * The DataTables object for this table
       */
      "oInstance": null,
      /**
       * Unique identifier for each instance of the DataTables object. If there
       * is an ID on the table node, then it takes that value, otherwise an
       * incrementing internal counter is used.
       */
      "sInstance": null,
      /**
       * tabindex attribute value that is added to DataTables control elements, allowing
       * keyboard navigation of the table and its controls.
       */
      "iTabIndex": 0,
      /**
       * DIV container for the footer scrolling table if scrolling
       */
      "nScrollHead": null,
      /**
       * DIV container for the footer scrolling table if scrolling
       */
      "nScrollFoot": null,
      /**
       * Last applied sort
       */
      "aLastSort": [],
      /**
       * Stored plug-in instances
       */
      "oPlugins": {},
      /**
       * Function used to get a row's id from the row's data
       */
      "rowIdFn": null,
      /**
       * Data location where to store a row's id
       */
      "rowId": null,
      caption: "",
      captionNode: null,
      colgroup: null,
      /** Delay loading of data */
      deferLoading: null,
      /** Allow auto type detection */
      typeDetect: true,
      /** ResizeObserver for the container div */
      resizeObserver: null,
      /** Keep a record of the last size of the container, so we can skip duplicates */
      containerWidth: -1,
      /** Reverse the initial order of the data set on desc ordering */
      orderDescReverse: null,
      /** Show / hide ordering indicators in headers */
      orderIndicators: true,
      /** Default ordering listener */
      orderHandler: true,
      /** Title row indicator */
      titleRow: null
    };
    var extPagination = DataTable.ext.pager;
    $.extend(extPagination, {
      simple: function() {
        return ["previous", "next"];
      },
      full: function() {
        return ["first", "previous", "next", "last"];
      },
      numbers: function() {
        return ["numbers"];
      },
      simple_numbers: function() {
        return ["previous", "numbers", "next"];
      },
      full_numbers: function() {
        return ["first", "previous", "numbers", "next", "last"];
      },
      first_last: function() {
        return ["first", "last"];
      },
      first_last_numbers: function() {
        return ["first", "numbers", "last"];
      },
      // For testing and plug-ins to use
      _numbers: _pagingNumbers,
      // Number of number buttons - legacy, use `numbers` option for paging feature
      numbers_length: 7
    });
    $.extend(true, DataTable.ext.renderer, {
      pagingButton: {
        _: function(settings, buttonType, content, active, disabled) {
          var classes = settings.oClasses.paging;
          var btnClasses = [classes.button];
          var btn;
          if (active) {
            btnClasses.push(classes.active);
          }
          if (disabled) {
            btnClasses.push(classes.disabled);
          }
          if (buttonType === "ellipsis") {
            btn = $('<span class="ellipsis"></span>').html(content)[0];
          } else {
            btn = $("<button>", {
              class: btnClasses.join(" "),
              role: "link",
              type: "button"
            }).html(content);
          }
          return {
            display: btn,
            clicker: btn
          };
        }
      },
      pagingContainer: {
        _: function(settings, buttons) {
          return buttons;
        }
      }
    });
    var _filterString = function(stripHtml, normalize) {
      return function(str) {
        if (_empty(str) || typeof str !== "string") {
          return str;
        }
        str = str.replace(_re_new_lines, " ");
        if (stripHtml) {
          str = _stripHtml(str);
        }
        {
          str = _normalize(str, false);
        }
        return str;
      };
    };
    function __mld(dtLib, momentFn, luxonFn, dateFn, arg1) {
      if (__moment) {
        return dtLib[momentFn](arg1);
      } else if (__luxon) {
        return dtLib[luxonFn](arg1);
      }
      return dateFn ? dtLib[dateFn](arg1) : dtLib;
    }
    var __mlWarning = false;
    var __luxon;
    var __moment;
    function resolveWindowLibs() {
      if (window.luxon && !__luxon) {
        __luxon = window.luxon;
      }
      if (window.moment && !__moment) {
        __moment = window.moment;
      }
    }
    function __mldObj(d, format, locale) {
      var dt;
      resolveWindowLibs();
      if (__moment) {
        dt = __moment.utc(d, format, locale, true);
        if (!dt.isValid()) {
          return null;
        }
      } else if (__luxon) {
        dt = format && typeof d === "string" ? __luxon.DateTime.fromFormat(d, format) : __luxon.DateTime.fromISO(d);
        if (!dt.isValid) {
          return null;
        }
        dt = dt.setLocale(locale);
      } else if (!format) {
        dt = new Date(d);
      } else {
        if (!__mlWarning) {
          alert("DataTables warning: Formatted date without Moment.js or Luxon - https://datatables.net/tn/17");
        }
        __mlWarning = true;
      }
      return dt;
    }
    function __mlHelper(localeString) {
      return function(from, to, locale, def) {
        if (arguments.length === 0) {
          locale = "en";
          to = null;
          from = null;
        } else if (arguments.length === 1) {
          locale = "en";
          to = from;
          from = null;
        } else if (arguments.length === 2) {
          locale = to;
          to = from;
          from = null;
        }
        var typeName = "datetime" + (to ? "-" + to : "");
        if (!DataTable.ext.type.order[typeName + "-pre"]) {
          DataTable.type(typeName, {
            detect: function(d) {
              return d === typeName ? typeName : false;
            },
            order: {
              pre: function(d) {
                return d.valueOf();
              }
            },
            className: "dt-right"
          });
        }
        return function(d, type) {
          if (d === null || d === void 0) {
            if (def === "--now") {
              var local = /* @__PURE__ */ new Date();
              d = new Date(Date.UTC(
                local.getFullYear(),
                local.getMonth(),
                local.getDate(),
                local.getHours(),
                local.getMinutes(),
                local.getSeconds()
              ));
            } else {
              d = "";
            }
          }
          if (type === "type") {
            return typeName;
          }
          if (d === "") {
            return type !== "sort" ? "" : __mldObj("0000-01-01 00:00:00", null, locale);
          }
          if (to !== null && from === to && type !== "sort" && type !== "type" && !(d instanceof Date)) {
            return d;
          }
          var dt = __mldObj(d, from, locale);
          if (dt === null) {
            return d;
          }
          if (type === "sort") {
            return dt;
          }
          var formatted = to === null ? __mld(dt, "toDate", "toJSDate", "")[localeString](
            navigator.language,
            { timeZone: "UTC" }
          ) : __mld(dt, "format", "toFormat", "toISOString", to);
          return type === "display" ? _escapeHtml(formatted) : formatted;
        };
      };
    }
    var __thousands = ",";
    var __decimal = ".";
    if (window.Intl !== void 0) {
      try {
        var num = new Intl.NumberFormat().formatToParts(100000.1);
        for (var i = 0; i < num.length; i++) {
          if (num[i].type === "group") {
            __thousands = num[i].value;
          } else if (num[i].type === "decimal") {
            __decimal = num[i].value;
          }
        }
      } catch (e) {
      }
    }
    DataTable.datetime = function(format, locale) {
      var typeName = "datetime-" + format;
      if (!locale) {
        locale = "en";
      }
      if (!DataTable.ext.type.order[typeName]) {
        DataTable.type(typeName, {
          detect: function(d) {
            var dt = __mldObj(d, format, locale);
            return d === "" || dt ? typeName : false;
          },
          order: {
            pre: function(d) {
              return __mldObj(d, format, locale) || 0;
            }
          },
          className: "dt-right"
        });
      }
    };
    DataTable.render = {
      date: __mlHelper("toLocaleDateString"),
      datetime: __mlHelper("toLocaleString"),
      time: __mlHelper("toLocaleTimeString"),
      number: function(thousands, decimal, precision, prefix, postfix) {
        if (thousands === null || thousands === void 0) {
          thousands = __thousands;
        }
        if (decimal === null || decimal === void 0) {
          decimal = __decimal;
        }
        return {
          display: function(d) {
            if (typeof d !== "number" && typeof d !== "string") {
              return d;
            }
            if (d === "" || d === null) {
              return d;
            }
            var negative = d < 0 ? "-" : "";
            var flo = parseFloat(d);
            var abs = Math.abs(flo);
            if (abs >= 1e11 || abs < 1e-4 && abs !== 0) {
              var exp = flo.toExponential(precision).split(/e\+?/);
              return exp[0] + " x 10<sup>" + exp[1] + "</sup>";
            }
            if (isNaN(flo)) {
              return _escapeHtml(d);
            }
            flo = flo.toFixed(precision);
            d = Math.abs(flo);
            var intPart = parseInt(d, 10);
            var floatPart = precision ? decimal + (d - intPart).toFixed(precision).substring(2) : "";
            if (intPart === 0 && parseFloat(floatPart) === 0) {
              negative = "";
            }
            return negative + (prefix || "") + intPart.toString().replace(
              /\B(?=(\d{3})+(?!\d))/g,
              thousands
            ) + floatPart + (postfix || "");
          }
        };
      },
      text: function() {
        return {
          display: _escapeHtml,
          filter: _escapeHtml
        };
      }
    };
    var _extTypes = DataTable.ext.type;
    DataTable.type = function(name, prop, val) {
      if (!prop) {
        return {
          className: _extTypes.className[name],
          detect: _extTypes.detect.find(function(fn) {
            return fn._name === name;
          }),
          order: {
            pre: _extTypes.order[name + "-pre"],
            asc: _extTypes.order[name + "-asc"],
            desc: _extTypes.order[name + "-desc"]
          },
          render: _extTypes.render[name],
          search: _extTypes.search[name]
        };
      }
      var setProp = function(prop2, propVal) {
        _extTypes[prop2][name] = propVal;
      };
      var setDetect = function(detect) {
        Object.defineProperty(detect, "_name", { value: name });
        var idx = _extTypes.detect.findIndex(function(item) {
          return item._name === name;
        });
        if (idx === -1) {
          _extTypes.detect.unshift(detect);
        } else {
          _extTypes.detect.splice(idx, 1, detect);
        }
      };
      var setOrder = function(obj) {
        _extTypes.order[name + "-pre"] = obj.pre;
        _extTypes.order[name + "-asc"] = obj.asc;
        _extTypes.order[name + "-desc"] = obj.desc;
      };
      if (val === void 0) {
        val = prop;
        prop = null;
      }
      if (prop === "className") {
        setProp("className", val);
      } else if (prop === "detect") {
        setDetect(val);
      } else if (prop === "order") {
        setOrder(val);
      } else if (prop === "render") {
        setProp("render", val);
      } else if (prop === "search") {
        setProp("search", val);
      } else if (!prop) {
        if (val.className) {
          setProp("className", val.className);
        }
        if (val.detect !== void 0) {
          setDetect(val.detect);
        }
        if (val.order) {
          setOrder(val.order);
        }
        if (val.render !== void 0) {
          setProp("render", val.render);
        }
        if (val.search !== void 0) {
          setProp("search", val.search);
        }
      }
    };
    DataTable.types = function() {
      return _extTypes.detect.map(function(fn) {
        return fn._name;
      });
    };
    var __diacriticSort = function(a, b) {
      a = a !== null && a !== void 0 ? a.toString().toLowerCase() : "";
      b = b !== null && b !== void 0 ? b.toString().toLowerCase() : "";
      return a.localeCompare(b, navigator.languages[0] || navigator.language, {
        numeric: true,
        ignorePunctuation: true
      });
    };
    var __diacriticHtmlSort = function(a, b) {
      a = _stripHtml(a);
      b = _stripHtml(b);
      return __diacriticSort(a, b);
    };
    DataTable.type("string", {
      detect: function() {
        return "string";
      },
      order: {
        pre: function(a) {
          return _empty(a) && typeof a !== "boolean" ? "" : typeof a === "string" ? a.toLowerCase() : !a.toString ? "" : a.toString();
        }
      },
      search: _filterString(false)
    });
    DataTable.type("string-utf8", {
      detect: {
        allOf: function(d) {
          return true;
        },
        oneOf: function(d) {
          return !_empty(d) && navigator.languages && typeof d === "string" && d.match(/[^\x00-\x7F]/);
        }
      },
      order: {
        asc: __diacriticSort,
        desc: function(a, b) {
          return __diacriticSort(a, b) * -1;
        }
      },
      search: _filterString(false)
    });
    DataTable.type("html", {
      detect: {
        allOf: function(d) {
          return _empty(d) || typeof d === "string" && d.indexOf("<") !== -1;
        },
        oneOf: function(d) {
          return !_empty(d) && typeof d === "string" && d.indexOf("<") !== -1;
        }
      },
      order: {
        pre: function(a) {
          return _empty(a) ? "" : a.replace ? _stripHtml(a).trim().toLowerCase() : a + "";
        }
      },
      search: _filterString(true)
    });
    DataTable.type("html-utf8", {
      detect: {
        allOf: function(d) {
          return _empty(d) || typeof d === "string" && d.indexOf("<") !== -1;
        },
        oneOf: function(d) {
          return navigator.languages && !_empty(d) && typeof d === "string" && d.indexOf("<") !== -1 && typeof d === "string" && d.match(/[^\x00-\x7F]/);
        }
      },
      order: {
        asc: __diacriticHtmlSort,
        desc: function(a, b) {
          return __diacriticHtmlSort(a, b) * -1;
        }
      },
      search: _filterString(true)
    });
    DataTable.type("date", {
      className: "dt-type-date",
      detect: {
        allOf: function(d) {
          if (d && !(d instanceof Date) && !_re_date.test(d)) {
            return null;
          }
          var parsed = Date.parse(d);
          return parsed !== null && !isNaN(parsed) || _empty(d);
        },
        oneOf: function(d) {
          return d instanceof Date || typeof d === "string" && _re_date.test(d);
        }
      },
      order: {
        pre: function(d) {
          var ts = Date.parse(d);
          return isNaN(ts) ? -Infinity : ts;
        }
      }
    });
    DataTable.type("html-num-fmt", {
      className: "dt-type-numeric",
      detect: {
        allOf: function(d, settings) {
          var decimal = settings.oLanguage.sDecimal;
          return _htmlNumeric(d, decimal, true, false);
        },
        oneOf: function(d, settings) {
          var decimal = settings.oLanguage.sDecimal;
          return _htmlNumeric(d, decimal, true, false);
        }
      },
      order: {
        pre: function(d, s) {
          var dp = s.oLanguage.sDecimal;
          return __numericReplace(d, dp, _re_html, _re_formatted_numeric);
        }
      },
      search: _filterString(true)
    });
    DataTable.type("html-num", {
      className: "dt-type-numeric",
      detect: {
        allOf: function(d, settings) {
          var decimal = settings.oLanguage.sDecimal;
          return _htmlNumeric(d, decimal, false, true);
        },
        oneOf: function(d, settings) {
          var decimal = settings.oLanguage.sDecimal;
          return _htmlNumeric(d, decimal, false, false);
        }
      },
      order: {
        pre: function(d, s) {
          var dp = s.oLanguage.sDecimal;
          return __numericReplace(d, dp, _re_html);
        }
      },
      search: _filterString(true)
    });
    DataTable.type("num-fmt", {
      className: "dt-type-numeric",
      detect: {
        allOf: function(d, settings) {
          var decimal = settings.oLanguage.sDecimal;
          return _isNumber(d, decimal, true, true);
        },
        oneOf: function(d, settings) {
          var decimal = settings.oLanguage.sDecimal;
          return _isNumber(d, decimal, true, false);
        }
      },
      order: {
        pre: function(d, s) {
          var dp = s.oLanguage.sDecimal;
          return __numericReplace(d, dp, _re_formatted_numeric);
        }
      }
    });
    DataTable.type("num", {
      className: "dt-type-numeric",
      detect: {
        allOf: function(d, settings) {
          var decimal = settings.oLanguage.sDecimal;
          return _isNumber(d, decimal, false, true);
        },
        oneOf: function(d, settings) {
          var decimal = settings.oLanguage.sDecimal;
          return _isNumber(d, decimal, false, false);
        }
      },
      order: {
        pre: function(d, s) {
          var dp = s.oLanguage.sDecimal;
          return __numericReplace(d, dp);
        }
      }
    });
    var __numericReplace = function(d, decimalPlace, re1, re2) {
      if (d !== 0 && (!d || d === "-")) {
        return -Infinity;
      }
      var type = typeof d;
      if (type === "number" || type === "bigint") {
        return d;
      }
      if (decimalPlace) {
        d = _numToDecimal(d, decimalPlace);
      }
      if (d.replace) {
        if (re1) {
          d = d.replace(re1, "");
        }
        if (re2) {
          d = d.replace(re2, "");
        }
      }
      return d * 1;
    };
    $.extend(true, DataTable.ext.renderer, {
      footer: {
        _: function(settings, cell, classes) {
          cell.addClass(classes.tfoot.cell);
        }
      },
      header: {
        _: function(settings, cell, classes) {
          cell.addClass(classes.thead.cell);
          if (!settings.oFeatures.bSort) {
            cell.addClass(classes.order.none);
          }
          var titleRow = settings.titleRow;
          var headerRows = cell.closest("thead").find("tr");
          var rowIdx = cell.parent().index();
          if (
            // Cells and rows which have the attribute to disable the icons
            cell.attr("data-dt-order") === "disable" || cell.parent().attr("data-dt-order") === "disable" || // titleRow support, for defining a specific row in the header
            titleRow === true && rowIdx !== 0 || titleRow === false && rowIdx !== headerRows.length - 1 || typeof titleRow === "number" && rowIdx !== titleRow
          ) {
            return;
          }
          $(settings.nTable).on("order.dt.DT column-visibility.dt.DT", function(e, ctx, column) {
            if (settings !== ctx) {
              return;
            }
            var sorting = ctx.sortDetails;
            if (!sorting) {
              return;
            }
            var orderedColumns = _pluck(sorting, "col");
            if (e.type === "column-visibility" && !orderedColumns.includes(column)) {
              return;
            }
            var i2;
            var orderClasses = classes.order;
            var columns = ctx.api.columns(cell);
            var col = settings.aoColumns[columns.flatten()[0]];
            var orderable = columns.orderable().includes(true);
            var ariaType = "";
            var indexes = columns.indexes();
            var sortDirs = columns.orderable(true).flatten();
            var tabIndex = settings.iTabIndex;
            var canOrder = ctx.orderHandler && orderable;
            cell.removeClass(
              orderClasses.isAsc + " " + orderClasses.isDesc
            ).toggleClass(orderClasses.none, !orderable).toggleClass(orderClasses.canAsc, canOrder && sortDirs.includes("asc")).toggleClass(orderClasses.canDesc, canOrder && sortDirs.includes("desc"));
            var isOrdering = true;
            for (i2 = 0; i2 < indexes.length; i2++) {
              if (!orderedColumns.includes(indexes[i2])) {
                isOrdering = false;
              }
            }
            if (isOrdering) {
              var orderDirs = columns.order();
              cell.addClass(
                orderDirs.includes("asc") ? orderClasses.isAsc : "" + orderDirs.includes("desc") ? orderClasses.isDesc : ""
              );
            }
            var firstVis = -1;
            for (i2 = 0; i2 < orderedColumns.length; i2++) {
              if (settings.aoColumns[orderedColumns[i2]].bVisible) {
                firstVis = orderedColumns[i2];
                break;
              }
            }
            if (indexes[0] == firstVis) {
              var firstSort = sorting[0];
              var sortOrder = col.asSorting;
              cell.attr("aria-sort", firstSort.dir === "asc" ? "ascending" : "descending");
              ariaType = !sortOrder[firstSort.index + 1] ? "Remove" : "Reverse";
            } else {
              cell.removeAttr("aria-sort");
            }
            if (orderable) {
              var orderSpan = cell.find(".dt-column-order");
              orderSpan.attr("role", "button").attr(
                "aria-label",
                orderable ? col.ariaTitle + ctx.api.i18n("oAria.orderable" + ariaType) : col.ariaTitle
              );
              if (tabIndex !== -1) {
                orderSpan.attr("tabindex", tabIndex);
              }
            }
          });
        }
      },
      layout: {
        _: function(settings, container, items) {
          var classes = settings.oClasses.layout;
          var row = $("<div/>").attr("id", items.id || null).addClass(items.className || classes.row).appendTo(container);
          DataTable.ext.renderer.layout._forLayoutRow(items, function(key2, val) {
            if (key2 === "id" || key2 === "className") {
              return;
            }
            var klass = "";
            if (val.table) {
              row.addClass(classes.tableRow);
              klass += classes.tableCell + " ";
            }
            if (key2 === "start") {
              klass += classes.start;
            } else if (key2 === "end") {
              klass += classes.end;
            } else {
              klass += classes.full;
            }
            $("<div/>").attr({
              id: val.id || null,
              "class": val.className ? val.className : classes.cell + " " + klass
            }).append(val.contents).appendTo(row);
          });
        },
        // Shared for use by the styling frameworks
        _forLayoutRow: function(items, fn) {
          var layoutEnum = function(x) {
            switch (x) {
              case "":
                return 0;
              case "start":
                return 1;
              case "end":
                return 2;
              default:
                return 3;
            }
          };
          Object.keys(items).sort(function(a, b) {
            return layoutEnum(a) - layoutEnum(b);
          }).forEach(function(key2) {
            fn(key2, items[key2]);
          });
        }
      }
    });
    DataTable.feature = {};
    DataTable.feature.register = function(name, cb, legacy) {
      DataTable.ext.features[name] = cb;
      if (legacy) {
        _ext.feature.push({
          cFeature: legacy,
          fnInit: cb
        });
      }
    };
    function _divProp(el, prop, val) {
      if (val) {
        el[prop] = val;
      }
    }
    DataTable.feature.register("div", function(settings, opts) {
      var n = $("<div>")[0];
      if (opts) {
        _divProp(n, "className", opts.className);
        _divProp(n, "id", opts.id);
        _divProp(n, "innerHTML", opts.html);
        _divProp(n, "textContent", opts.text);
      }
      return n;
    });
    DataTable.feature.register("info", function(settings, opts) {
      if (!settings.oFeatures.bInfo) {
        return null;
      }
      var lang = settings.oLanguage, tid = settings.sTableId, n = $("<div/>", {
        "class": settings.oClasses.info.container
      });
      opts = $.extend({
        callback: lang.fnInfoCallback,
        empty: lang.sInfoEmpty,
        postfix: lang.sInfoPostFix,
        search: lang.sInfoFiltered,
        text: lang.sInfo
      }, opts);
      settings.aoDrawCallback.push(function(s) {
        _fnUpdateInfo(s, opts, n);
      });
      if (!settings._infoEl) {
        n.attr({
          "aria-live": "polite",
          id: tid + "_info",
          role: "status"
        });
        $(settings.nTable).attr("aria-describedby", tid + "_info");
        settings._infoEl = n;
      }
      return n;
    }, "i");
    function _fnUpdateInfo(settings, opts, node) {
      var start = settings._iDisplayStart + 1, end = settings.fnDisplayEnd(), max = settings.fnRecordsTotal(), total = settings.fnRecordsDisplay(), out = total ? opts.text : opts.empty;
      if (total !== max) {
        out += " " + opts.search;
      }
      out += opts.postfix;
      out = _fnMacros(settings, out);
      if (opts.callback) {
        out = opts.callback.call(
          settings.oInstance,
          settings,
          start,
          end,
          max,
          total,
          out
        );
      }
      node.html(out);
      _fnCallbackFire(settings, null, "info", [settings, node[0], out]);
    }
    var __searchCounter = 0;
    DataTable.feature.register("search", function(settings, opts) {
      if (!settings.oFeatures.bFilter) {
        return null;
      }
      var classes = settings.oClasses.search;
      var tableId = settings.sTableId;
      var language = settings.oLanguage;
      var previousSearch = settings.oPreviousSearch;
      var input = '<input type="search" class="' + classes.input + '"/>';
      opts = $.extend({
        placeholder: language.sSearchPlaceholder,
        processing: false,
        text: language.sSearch
      }, opts);
      if (opts.text.indexOf("_INPUT_") === -1) {
        opts.text += "_INPUT_";
      }
      opts.text = _fnMacros(settings, opts.text);
      var end = opts.text.match(/_INPUT_$/);
      var start = opts.text.match(/^_INPUT_/);
      var removed = opts.text.replace(/_INPUT_/, "");
      var str = "<label>" + opts.text + "</label>";
      if (start) {
        str = "_INPUT_<label>" + removed + "</label>";
      } else if (end) {
        str = "<label>" + removed + "</label>_INPUT_";
      }
      var filter = $("<div>").addClass(classes.container).append(str.replace(/_INPUT_/, input));
      filter.find("label").attr("for", "dt-search-" + __searchCounter);
      filter.find("input").attr("id", "dt-search-" + __searchCounter);
      __searchCounter++;
      var searchFn = function(event) {
        var val = this.value;
        if (previousSearch.return && event.key !== "Enter") {
          return;
        }
        if (val != previousSearch.search) {
          _fnProcessingRun(settings, opts.processing, function() {
            previousSearch.search = val;
            _fnFilterComplete(settings, previousSearch);
            settings._iDisplayStart = 0;
            _fnDraw(settings);
          });
        }
      };
      var searchDelay = settings.searchDelay !== null ? settings.searchDelay : 0;
      var jqFilter = $("input", filter).val(previousSearch.search).attr("placeholder", opts.placeholder).on(
        "keyup.DT search.DT input.DT paste.DT cut.DT",
        searchDelay ? DataTable.util.debounce(searchFn, searchDelay) : searchFn
      ).on("mouseup.DT", function(e) {
        setTimeout(function() {
          searchFn.call(jqFilter[0], e);
        }, 10);
      }).on("keypress.DT", function(e) {
        if (e.keyCode == 13) {
          return false;
        }
      }).attr("aria-controls", tableId);
      $(settings.nTable).on("search.dt.DT", function(ev, s) {
        if (settings === s && jqFilter[0] !== document.activeElement) {
          jqFilter.val(
            typeof previousSearch.search !== "function" ? previousSearch.search : ""
          );
        }
      });
      return filter;
    }, "f");
    DataTable.feature.register("paging", function(settings, opts) {
      if (!settings.oFeatures.bPaginate) {
        return null;
      }
      opts = $.extend({
        buttons: DataTable.ext.pager.numbers_length,
        type: settings.sPaginationType,
        boundaryNumbers: true,
        firstLast: true,
        previousNext: true,
        numbers: true
      }, opts);
      var host = $("<div/>").addClass(settings.oClasses.paging.container + (opts.type ? " paging_" + opts.type : "")).append(
        $("<nav>").attr("aria-label", "pagination").addClass(settings.oClasses.paging.nav)
      );
      var draw = function() {
        _pagingDraw(settings, host.children(), opts);
      };
      settings.aoDrawCallback.push(draw);
      $(settings.nTable).on("column-sizing.dt.DT", draw);
      return host;
    }, "p");
    function _pagingDynamic(opts) {
      var out = [];
      if (opts.numbers) {
        out.push("numbers");
      }
      if (opts.previousNext) {
        out.unshift("previous");
        out.push("next");
      }
      if (opts.firstLast) {
        out.unshift("first");
        out.push("last");
      }
      return out;
    }
    function _pagingDraw(settings, host, opts) {
      if (!settings._bInitComplete) {
        return;
      }
      var plugin = opts.type ? DataTable.ext.pager[opts.type] : _pagingDynamic, aria = settings.oLanguage.oAria.paginate || {}, start = settings._iDisplayStart, len = settings._iDisplayLength, visRecords = settings.fnRecordsDisplay(), all = len === -1, page = all ? 0 : Math.ceil(start / len), pages = all ? 1 : Math.ceil(visRecords / len), buttons = [], buttonEls = [], buttonsNested = plugin(opts).map(function(val) {
        return val === "numbers" ? _pagingNumbers(page, pages, opts.buttons, opts.boundaryNumbers) : val;
      });
      buttons = buttons.concat.apply(buttons, buttonsNested);
      for (var i2 = 0; i2 < buttons.length; i2++) {
        var button = buttons[i2];
        var btnInfo = _pagingButtonInfo(settings, button, page, pages);
        var btn = _fnRenderer(settings, "pagingButton")(
          settings,
          button,
          btnInfo.display,
          btnInfo.active,
          btnInfo.disabled
        );
        var ariaLabel = typeof button === "string" ? aria[button] : aria.number ? aria.number + (button + 1) : null;
        $(btn.clicker).attr({
          "aria-controls": settings.sTableId,
          "aria-disabled": btnInfo.disabled ? "true" : null,
          "aria-current": btnInfo.active ? "page" : null,
          "aria-label": ariaLabel,
          "data-dt-idx": button,
          "tabIndex": btnInfo.disabled ? -1 : settings.iTabIndex && btn.clicker[0].nodeName.toLowerCase() !== "span" ? settings.iTabIndex : null
          // `0` doesn't need a tabIndex since it is the default
        });
        if (typeof button !== "number") {
          $(btn.clicker).addClass(button);
        }
        _fnBindAction(
          btn.clicker,
          { action: button },
          function(e) {
            e.preventDefault();
            _fnPageChange(settings, e.data.action, true);
          }
        );
        buttonEls.push(btn.display);
      }
      var wrapped = _fnRenderer(settings, "pagingContainer")(
        settings,
        buttonEls
      );
      var activeEl = host.find(document.activeElement).data("dt-idx");
      host.empty().append(wrapped);
      if (activeEl !== void 0) {
        host.find("[data-dt-idx=" + activeEl + "]").trigger("focus");
      }
      if (buttonEls.length) {
        var outerHeight = $(buttonEls[0]).outerHeight();
        if (opts.buttons > 1 && // prevent infinite
        outerHeight > 0 && // will be 0 if hidden
        $(host).height() >= outerHeight * 2 - 10) {
          _pagingDraw(settings, host, $.extend({}, opts, { buttons: opts.buttons - 2 }));
        }
      }
    }
    function _pagingButtonInfo(settings, button, page, pages) {
      var lang = settings.oLanguage.oPaginate;
      var o = {
        display: "",
        active: false,
        disabled: false
      };
      switch (button) {
        case "ellipsis":
          o.display = "&#x2026;";
          break;
        case "first":
          o.display = lang.sFirst;
          if (page === 0) {
            o.disabled = true;
          }
          break;
        case "previous":
          o.display = lang.sPrevious;
          if (page === 0) {
            o.disabled = true;
          }
          break;
        case "next":
          o.display = lang.sNext;
          if (pages === 0 || page === pages - 1) {
            o.disabled = true;
          }
          break;
        case "last":
          o.display = lang.sLast;
          if (pages === 0 || page === pages - 1) {
            o.disabled = true;
          }
          break;
        default:
          if (typeof button === "number") {
            o.display = settings.fnFormatNumber(button + 1);
            if (page === button) {
              o.active = true;
            }
          }
          break;
      }
      return o;
    }
    function _pagingNumbers(page, pages, buttons, addFirstLast) {
      var numbers = [], half = Math.floor(buttons / 2), before = addFirstLast ? 2 : 1, after = addFirstLast ? 1 : 0;
      if (pages <= buttons) {
        numbers = _range(0, pages);
      } else if (buttons === 1) {
        numbers = [page];
      } else if (buttons === 3) {
        if (page <= 1) {
          numbers = [0, 1, "ellipsis"];
        } else if (page >= pages - 2) {
          numbers = _range(pages - 2, pages);
          numbers.unshift("ellipsis");
        } else {
          numbers = ["ellipsis", page, "ellipsis"];
        }
      } else if (page <= half) {
        numbers = _range(0, buttons - before);
        numbers.push("ellipsis");
        if (addFirstLast) {
          numbers.push(pages - 1);
        }
      } else if (page >= pages - 1 - half) {
        numbers = _range(pages - (buttons - before), pages);
        numbers.unshift("ellipsis");
        if (addFirstLast) {
          numbers.unshift(0);
        }
      } else {
        numbers = _range(page - half + before, page + half - after);
        numbers.push("ellipsis");
        numbers.unshift("ellipsis");
        if (addFirstLast) {
          numbers.push(pages - 1);
          numbers.unshift(0);
        }
      }
      return numbers;
    }
    var __lengthCounter = 0;
    DataTable.feature.register("pageLength", function(settings, opts) {
      var features = settings.oFeatures;
      if (!features.bPaginate || !features.bLengthChange) {
        return null;
      }
      opts = $.extend({
        menu: settings.aLengthMenu,
        text: settings.oLanguage.sLengthMenu
      }, opts);
      var classes = settings.oClasses.length, tableId = settings.sTableId, menu = opts.menu, lengths = [], language = [], i2;
      if (Array.isArray(menu[0])) {
        lengths = menu[0];
        language = menu[1];
      } else {
        for (i2 = 0; i2 < menu.length; i2++) {
          if ($.isPlainObject(menu[i2])) {
            lengths.push(menu[i2].value);
            language.push(menu[i2].label);
          } else {
            lengths.push(menu[i2]);
            language.push(menu[i2]);
          }
        }
      }
      var end = opts.text.match(/_MENU_$/);
      var start = opts.text.match(/^_MENU_/);
      var removed = opts.text.replace(/_MENU_/, "");
      var str = "<label>" + opts.text + "</label>";
      if (start) {
        str = "_MENU_<label>" + removed + "</label>";
      } else if (end) {
        str = "<label>" + removed + "</label>_MENU_";
      }
      var tmpId = "tmp-" + +/* @__PURE__ */ new Date();
      var div = $("<div/>").addClass(classes.container).append(
        str.replace("_MENU_", '<span id="' + tmpId + '"></span>')
      );
      var textNodes = [];
      Array.prototype.slice.call(div.find("label")[0].childNodes).forEach(function(el) {
        if (el.nodeType === Node.TEXT_NODE) {
          textNodes.push({
            el,
            text: el.textContent
          });
        }
      });
      var updateEntries = function(len) {
        textNodes.forEach(function(node) {
          node.el.textContent = _fnMacros(settings, node.text, len);
        });
      };
      var select = $("<select/>", {
        "aria-controls": tableId,
        "class": classes.select
      });
      for (i2 = 0; i2 < lengths.length; i2++) {
        var label = settings.api.i18n("lengthLabels." + lengths[i2], null);
        if (label === null) {
          label = typeof language[i2] === "number" ? settings.fnFormatNumber(language[i2]) : language[i2];
        }
        select[0][i2] = new Option(label, lengths[i2]);
      }
      div.find("label").attr("for", "dt-length-" + __lengthCounter);
      select.attr("id", "dt-length-" + __lengthCounter);
      __lengthCounter++;
      div.find("#" + tmpId).replaceWith(select);
      $("select", div).val(settings._iDisplayLength).on("change.DT", function() {
        _fnLengthChange(settings, $(this).val());
        _fnDraw(settings);
      });
      $(settings.nTable).on("length.dt.DT", function(e, s, len) {
        if (settings === s) {
          $("select", div).val(len);
          updateEntries(len);
        }
      });
      updateEntries(settings._iDisplayLength);
      return div;
    }, "l");
    $.fn.dataTable = DataTable;
    DataTable.$ = $;
    $.fn.dataTableSettings = DataTable.settings;
    $.fn.dataTableExt = DataTable.ext;
    $.fn.DataTable = function(opts) {
      return $(this).dataTable(opts).api();
    };
    $.each(DataTable, function(prop, val) {
      $.fn.DataTable[prop] = val;
    });
    const JITTERBUG_LOAD = {
      common: {
        init() {
          jitterbug.initAjax();
          jitterbug.initSessionTimeout();
          jitterbug.getAlert();
        }
      },
      login: {
        showLoginForm() {
          jitterbug.initGreeting();
        }
      },
      admin: {
        init() {
        },
        index() {
          jitterbug.initAdmin();
        }
      },
      dashboard: {
        init() {
        },
        index() {
          jitterbug.initDashboardCharts();
          jitterbug.initDashboardActivityStream();
          jitterbug.initDashboardMarks();
        }
      },
      items: {
        init() {
        },
        index() {
          jitterbug.initItemsIndex();
          jitterbug.initTableKeyboardShortcuts();
          jitterbug.initItemsImportModal();
          jitterbug.initItemsNewButton();
          jitterbug.initItemsBatchMenu();
          jitterbug.initBatchDeleteForm();
        },
        show() {
          jitterbug.initMarkRibbon();
          jitterbug.initRevisionHistory();
          jitterbug.initRelatedPreservationInstances();
          jitterbug.initRelatedCuts();
        },
        create() {
          jitterbug.initItemTypeControls();
          jitterbug.initItemCallNumberGeneration();
          jitterbug.initDatepicker();
          jitterbug.initItemSuggestions();
          jitterbug.initSubmitButton();
        },
        edit() {
          jitterbug.initDatepicker();
          jitterbug.initItemSuggestions();
          jitterbug.initRevisionHistory();
          jitterbug.initRelatedPreservationInstances();
          jitterbug.initRelatedCuts();
          jitterbug.initSubmitButton();
        },
        batchEdit() {
          jitterbug.initBatchEditMixed();
          jitterbug.initDatepicker();
          jitterbug.initItemSuggestions();
          jitterbug.initSubmitButton();
        }
      },
      instances: {
        init() {
        },
        index() {
          jitterbug.initInstancesIndex();
          jitterbug.initTableKeyboardShortcuts();
          jitterbug.initInstancesNewButton();
          jitterbug.initInstancesBatchMenu();
          jitterbug.initBatchDeleteForm();
        },
        show() {
          jitterbug.initMarkRibbon();
          jitterbug.initRevisionHistory();
          jitterbug.initRelatedCuts();
          jitterbug.initRelatedTransfers();
        },
        create() {
          jitterbug.initInstanceTypeControls();
          jitterbug.initInstanceBatchCheckbox();
          jitterbug.initSubmitButton();
        },
        edit() {
          jitterbug.initRevisionHistory();
          jitterbug.initRelatedCuts();
          jitterbug.initRelatedTransfers();
          jitterbug.initSubmitButton();
        },
        batchEdit() {
          jitterbug.initBatchEditMixed();
          jitterbug.initSubmitButton();
        }
      },
      cuts: {
        init() {
        },
        show() {
          jitterbug.initRevisionHistory();
          jitterbug.initRelatedTransfers();
        },
        edit: function() {
          jitterbug.initRevisionHistory();
          jitterbug.initRelatedTransfers();
          jitterbug.initSubmitButton();
        }
      },
      transfers: {
        init() {
        },
        index() {
          jitterbug.initTransfersIndex();
          jitterbug.initTableKeyboardShortcuts();
          jitterbug.initAudioImportModal();
          jitterbug.initVideoImportModal();
          jitterbug.initTransfersNewButton();
          jitterbug.initTransfersBatchMenu();
          jitterbug.initBatchDeleteForm();
        },
        show() {
          jitterbug.initMarkRibbon();
          jitterbug.initRevisionHistory();
          jitterbug.initRelatedCuts();
        },
        create() {
          jitterbug.initTransferTypeControls();
          jitterbug.initTransferCallNumberQuery();
          jitterbug.initDatepicker();
          jitterbug.initSubmitButton();
        },
        edit() {
          jitterbug.initDatepicker();
          jitterbug.initTransferCallNumberQuery();
          jitterbug.initRevisionHistory();
          jitterbug.initRelatedCuts();
          jitterbug.initSubmitButton();
        },
        batchEdit() {
          jitterbug.initDatepicker();
          jitterbug.initTransferCallNumberQuery();
          jitterbug.initBatchEditMixed();
          jitterbug.initSubmitButton();
        }
      },
      formats: {
        init() {
        },
        show() {
          jitterbug.initPrefixActions();
        }
      }
    };
    const ROUTER = {
      exec(controller, action) {
        let ns = JITTERBUG_LOAD, action_type = action === void 0 ? "init" : action;
        if (controller !== "" && ns[controller] && typeof ns[controller][action] == "function") {
          ns[controller][action_type]();
        }
      },
      init() {
        let body = document.body, controller = body.getAttribute("data-controller"), action = body.getAttribute("data-action");
        ROUTER.exec("common");
        ROUTER.exec(controller);
        ROUTER.exec(controller, action);
      }
    };
    $$1(document).ready(ROUTER.init);
    $$1(document).ready(function() {
      new DataTable("#user-table", {
        columnDefs: [
          // the last two columns are not orderable: admin & inactive checkboxes
          { orderable: false, targets: [-2, -1] }
        ]
      });
      let table = $$1("#user-table");
      table.on("click", ".admin", function(e) {
        if (e.target.id.startsWith("admin")) {
          jitterbug.toggleAdmin(e.target.id);
        }
      });
      table.on("click", ".inactive", function(e) {
        if (e.target.id.startsWith("active")) {
          jitterbug.toggleInactive(e.target.id);
        }
      });
    });
  }
});
export default require_app_002();
