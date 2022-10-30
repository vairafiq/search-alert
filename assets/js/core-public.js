/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/modules/core/sass/core-public.scss":
/*!************************************************!*\
  !*** ./src/modules/core/sass/core-public.scss ***!
  \************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


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
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
!function() {
/*!***************************************************!*\
  !*** ./src/modules/core/js/public/core-public.js ***!
  \***************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _sass_core_public_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./../../sass/core-public.scss */ "./src/modules/core/sass/core-public.scss");
// import 'CoreCSS/core-public.scss';

(function ($) {
  var qs = function (a) {
    if (a == '') return {};
    var b = {};
    for (var i = 0; i < a.length; ++i) {
      var p = a[i].split('=', 2);
      if (p.length == 1) b[p[0]] = '';else b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, ' '));
    }
    return b;
  }(window.location.search.substr(1).split('&'));
  $('body').on('click', '.searchalert_add', function (e) {
    e.preventDefault();
    requet('.searchalert_add');
  });
  $('body').on('click', '.searchalert_delete', function (e) {
    e.preventDefault();
    var data = {
      category: $(this).data("search-category"),
      query: $(this).data("search-query")
    };
    requet('.searchalert_delete', 'delete', data);
  });
  function requet(selector) {
    var task = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'add';
    var data = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : [];
    var elmText = task !== 'delete' ? searchAlert.deleteText : searchAlert.addText;
    var directorist = qs.q ? qs.q : '';
    var geodirectory = qs.s ? qs.s : '';
    var query = directorist ? directorist : geodirectory;
    var query = query ? query : data.query ? data.query : '';
    var category = qs.in_cat ? qs.in_cat : data.category ? data.category : '';
    var form_data = new FormData();
    form_data.append('action', 'update_search_notice');
    form_data.append('search_alert_nonce', searchAlert.nonce);
    form_data.append('task', task);
    form_data.append('query', query);
    form_data.append('category', category);
    $.ajax({
      method: 'POST',
      processData: false,
      contentType: false,
      url: searchAlert.ajaxurl,
      data: form_data,
      success: function success(response) {
        if (task === 'add') {
          $(selector).removeClass('searchalert_add').addClass('searchalert_delete').text(elmText);
        } else {
          $(selector).removeClass('searchalert_delete').addClass('searchalert_add').text(elmText);
        }
        console.log(response);
      },
      error: function error(response) {
        console.log(response);
      }
    });
  }
})(jQuery);
}();
/******/ })()
;
//# sourceMappingURL=core-public.js.map