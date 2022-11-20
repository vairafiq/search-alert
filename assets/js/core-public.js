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

  // result pages
  $('body').on('click', '.searchalert_add', function (e) {
    e.preventDefault();
    var data = {
      user: searchAlert.current_user_id
    };
    requet('.searchalert_add', '', data);
  });

  // inline form
  $('body').on('click', '.searchalert_add_form', function (e) {
    e.preventDefault();
    var isUpdate = $('.search_alert_update').val();
    var data = {
      query: $('.search_alert_input').val(),
      delete: false,
      user: searchAlert.current_user_id,
      form: true,
      reload: true
    };
    if (!data.query) {
      return;
    }
    if (isUpdate) {
      var updateData = {
        query: isUpdate,
        delete: true,
        form: false
      };
      requet('.searchalert_add_form', 'delete', updateData);
    }

    // console.log( data );
    // console.log( updateData );
    // return;
    requet('.searchalert_add_form', '', data);
  });

  // delete form dashboard
  $('body').on('click', '.searchalert_delete', function (e) {
    e.preventDefault();
    var data = {
      query: $(this).data("search-query"),
      delete: $(this).data("searchalert_delete_from_list")
    };
    requet('.searchalert_delete', 'delete', data);
  });

  // edit from dashboard
  $('body').on('click', '.searchalert_edit', function (e) {
    e.preventDefault();
    $('.search_alert_input').val($(this).data("search-query"));
    $('.search_alert_update').val($(this).data("search-query"));
    $('.searchalert_add_form').text('Update');
  });

  // full form
  $('body').on('submit', '#searchalert-form', function (e) {
    e.preventDefault();
    var data = {
      query: $('.searchalert_keyword').val(),
      email: $('.searchalert_email').val(),
      form: true,
      reload: false
    };
    requet('.searchalert_form_submit', '', data);
    $('.searchalert_keyword').val('');
    $('.searchalert_email').val('');
  });
  function requet(selector) {
    var task = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'add';
    var data = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : [];
    var elmText = task !== 'delete' ? searchAlert.deleteText : searchAlert.addText;
    if (data.form) {
      elmText = searchAlert.addText;
      $(selector).text('Adding..');
    }
    var directorist = qs.q ? qs.q : '';
    var geodirectory = qs.s ? qs.s : '';
    var query = directorist ? directorist : geodirectory;
    var query = query ? query : data.query ? data.query : '';
    var email = data.email ? data.email : '';
    var user = data.user ? data.user : '';
    var form_data = new FormData();
    form_data.append('action', 'update_search_notice');
    form_data.append('search_alert_nonce', searchAlert.nonce);
    form_data.append('task', task);
    form_data.append('query', query);
    form_data.append('email', email);
    form_data.append('user', user);
    $.ajax({
      method: 'POST',
      processData: false,
      contentType: false,
      url: searchAlert.ajaxurl,
      data: form_data,
      success: function success(response) {
        if (data.form) {
          $(selector).text('Saved');
          setTimeout(function () {
            $(selector).text(elmText);
            $('.search_alert_input').val('');
          }, 800);
          if (!data.reload) {
            return;
          }
          window.location.reload();
          return;
        }
        if (task === 'add') {
          $(selector).removeClass('searchalert_add').addClass('searchalert_delete').text(elmText);
        } else {
          if (!data.delete) {
            $(selector).removeClass('searchalert_delete').addClass('searchalert_add').text(elmText);
          } else {
            $('#search-alert-item-to-remove-' + response.data).remove();
          }
        }
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