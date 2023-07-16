/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "@inertiajs/react":
/*!***********************************!*\
  !*** external "@inertiajs/react" ***!
  \***********************************/
/***/ ((module) => {

module.exports = require("@inertiajs/react");

/***/ }),

/***/ "@inertiajs/react/server":
/*!******************************************!*\
  !*** external "@inertiajs/react/server" ***!
  \******************************************/
/***/ ((module) => {

module.exports = require("@inertiajs/react/server");

/***/ }),

/***/ "laravel-vite-plugin/inertia-helpers":
/*!******************************************************!*\
  !*** external "laravel-vite-plugin/inertia-helpers" ***!
  \******************************************************/
/***/ ((module) => {

module.exports = require("laravel-vite-plugin/inertia-helpers");

/***/ }),

/***/ "react-dom/server":
/*!***********************************!*\
  !*** external "react-dom/server" ***!
  \***********************************/
/***/ ((module) => {

module.exports = require("react-dom/server");

/***/ }),

/***/ "react/jsx-runtime":
/*!************************************!*\
  !*** external "react/jsx-runtime" ***!
  \************************************/
/***/ ((module) => {

module.exports = require("react/jsx-runtime");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!******************************!*\
  !*** ./resources/js/ssr.tsx ***!
  \******************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react_dom_server__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react-dom/server */ "react-dom/server");
/* harmony import */ var react_dom_server__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react_dom_server__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _inertiajs_react__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @inertiajs/react */ "@inertiajs/react");
/* harmony import */ var _inertiajs_react__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_inertiajs_react__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _inertiajs_react_server__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @inertiajs/react/server */ "@inertiajs/react/server");
/* harmony import */ var _inertiajs_react_server__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_inertiajs_react_server__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var laravel_vite_plugin_inertia_helpers__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! laravel-vite-plugin/inertia-helpers */ "laravel-vite-plugin/inertia-helpers");
/* harmony import */ var laravel_vite_plugin_inertia_helpers__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(laravel_vite_plugin_inertia_helpers__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__);
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }




 //import route from '../../vendor/tightenco/ziggy/dist/index.m';


var appName = 'Juzaweb';
_inertiajs_react_server__WEBPACK_IMPORTED_MODULE_2___default()(function (page) {
  return (0,_inertiajs_react__WEBPACK_IMPORTED_MODULE_1__.createInertiaApp)({
    page: page,
    render: (react_dom_server__WEBPACK_IMPORTED_MODULE_0___default().renderToString),
    title: function title(_title) {
      return "".concat(_title, " - ").concat(appName);
    },
    resolve: function resolve(name) {
      return (0,laravel_vite_plugin_inertia_helpers__WEBPACK_IMPORTED_MODULE_3__.resolvePageComponent)("./pages/".concat(name, ".tsx"), ({}).glob('./pages/**/*.tsx'));
    },
    setup: function setup(_ref) {
      var App = _ref.App,
          props = _ref.props;
      // global.route = (name, params, absolute) =>
      //     route(name, params, absolute, {
      //         // @ts-expect-error
      //         ...page.props.ziggy,
      //         // @ts-expect-error
      //         location: new URL(page.props.ziggy.location),
      //     });
      return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_4__.jsx)(App, _objectSpread({}, props));
    }
  });
});
})();

/******/ })()
;