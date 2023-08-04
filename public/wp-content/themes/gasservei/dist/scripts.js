/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/js/scripts.js":
/*!******************************!*\
  !*** ./assets/js/scripts.js ***!
  \******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _sass_styles_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../sass/styles.scss */ \"./assets/sass/styles.scss\");\n/* provided dependency */ var jQuery = __webpack_require__(/*! jquery */ \"jquery\");\nfunction _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== \"undefined\" && o[Symbol.iterator] || o[\"@@iterator\"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === \"number\") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError(\"Invalid attempt to iterate non-iterable instance.\\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.\"); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it[\"return\"] != null) it[\"return\"](); } finally { if (didErr) throw err; } } }; }\nfunction _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === \"string\") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === \"Object\" && o.constructor) n = o.constructor.name; if (n === \"Map\" || n === \"Set\") return Array.from(o); if (n === \"Arguments\" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }\nfunction _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i]; return arr2; }\n\n\n//Hide or reveal sticky add-to-cart-bar\nvar stickybar = document.getElementById('sticky-add-to-cart');\nvar scrollUp = \"scroll-up\";\nvar scrollDown = \"scroll-down\";\nvar lastScroll = 0;\nwindow.addEventListener(\"scroll\", function () {\n  var currentScroll = window.pageYOffset;\n  if (!stickybar) {\n    return;\n  }\n  if (currentScroll > 700) {\n    // down\n    stickybar.classList.remove(scrollUp);\n    stickybar.classList.add(scrollDown);\n  } else {\n    // up\n    stickybar.classList.remove(scrollDown);\n    stickybar.classList.add(scrollUp);\n  }\n  lastScroll = currentScroll;\n});\nwindow.addEventListener('load', function () {\n  var searcher = document.querySelector(\".home .wc-block-product-search__fields\");\n  var menuSearcher = document.querySelector('#menu-search-block');\n  if (searcher) {\n    searcher.addEventListener(\"click\", function (e) {\n      console.log('header');\n      e.stopPropagation();\n      e.preventDefault();\n      document.querySelector('li.search-button a').click();\n      document.getElementById('search-input').focus();\n    });\n  }\n  if (menuSearcher) {\n    menuSearcher.addEventListener(\"click\", function (e) {\n      console.log('menu');\n      e.stopPropagation();\n      e.preventDefault();\n      document.querySelector('li.search-button a').click();\n      document.getElementById('search-input').focus();\n    });\n  }\n});\n\n// Shop sidebar menu accordion\nwindow.addEventListener('load', function () {\n  document.querySelectorAll(\"#gss_sidebar_categories .arrow\").forEach(function (item) {\n    item.addEventListener('click', function (event) {\n      item.closest('li').classList.toggle('active');\n    });\n  });\n});\n\n// focus on search\njQuery(function ($) {\n  var searchButton = $(\"li.search-button\");\n  var searchInput = $(\"#search-input\");\n  searchButton.on(\"click\", function (e) {\n    setTimeout(function () {\n      searchInput.focus();\n      console.log(searchInput);\n    }, 400);\n  });\n});\nwindow.addEventListener('load', function () {\n  var sliderHome = document.getElementById('slider-home');\n  if (sliderHome) {\n    createHomeSlider(sliderHome);\n    var sliderHomeTimer = setInterval(changeHomeSlide, 5000);\n  }\n  document.addEventListener('click', function (e) {\n    if (e.target && e.target.classList.contains('dot')) {\n      var sliderElements = document.getElementById('slider-home-wrap').children;\n      var _iterator = _createForOfIteratorHelper(sliderElements),\n        _step;\n      try {\n        for (_iterator.s(); !(_step = _iterator.n()).done;) {\n          var element = _step.value;\n          element.classList.remove('active');\n        }\n      } catch (err) {\n        _iterator.e(err);\n      } finally {\n        _iterator.f();\n      }\n      var dots = document.querySelectorAll('#slider-home .dot');\n      var _iterator2 = _createForOfIteratorHelper(dots),\n        _step2;\n      try {\n        for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {\n          var dot = _step2.value;\n          dot.classList.remove('active');\n        }\n      } catch (err) {\n        _iterator2.e(err);\n      } finally {\n        _iterator2.f();\n      }\n      e.target.classList.add('active');\n      sliderElements[e.target.dataset.slide].classList.add('active');\n      clearInterval(sliderHomeTimer);\n      sliderHomeTimer = setInterval(changeHomeSlide, 5000);\n    }\n  });\n});\nfunction createHomeSlider(sliderHome) {\n  sliderHome.innerHTML = '<div id=\"slider-home-wrap\">' + sliderHome.innerHTML + '</div>';\n  var sliderElements = document.getElementById('slider-home-wrap');\n  var elements = sliderElements.children;\n  elements[0].classList.add('active');\n  var dots = document.createElement(\"div\");\n  dots.classList.add('dots');\n  for (var i = 0; i < elements.length; i++) {\n    var dot = document.createElement(\"div\");\n    dot.classList.add('dot');\n    dot.dataset.slide = i;\n    if (i == 0) {\n      dot.classList.add('active');\n    }\n    dots.appendChild(dot);\n  }\n  sliderHome.appendChild(dots);\n\n  //Show slider\n  sliderHome.classList.add('ready');\n}\nfunction changeHomeSlide() {\n  var activeDot = document.querySelector('#slider-home .dot.active');\n  var nextDot;\n  if (activeDot.nextSibling === null) {\n    nextDot = document.querySelector('#slider-home .dot');\n  } else {\n    nextDot = activeDot.nextSibling;\n  }\n  nextDot.click();\n}\njQuery(function ($) {\n  $(\"body.single-product td.quantity form.variable-cart\").on(\"change\", \"input.qty, input.custom-qty\", function () {\n    $(this).closest('tr').find('button').attr(\"data-quantity\", this.value);\n  });\n\n  //  Simple Product - Build and display notification on ajax add to cart\n  $('body.gbt_custom_notif.single-product').on('click touchend', '.variations .ajax_add_to_cart', function (e) {\n    // get product's image\n    if ($('body').find('.product_layout_classic').length > 0) {\n      var imgSrc = $('.woocommerce-product-gallery .woocommerce-product-gallery__wrapper > .woocommerce-product-gallery__image img').attr('src') || \"\";\n    } else {\n      var imgSrc = $('.woocommerce-product-gallery__wrapper .product_images .product-image:first-child img').attr('src') || \"\";\n    }\n\n    // get product's title\n    var prodTitle = $('.product_title').html() || \"\";\n    gbt_cn_onAddedToCart($(this), 'added', function () {\n      $('#content').prepend('<div class=\"woocommerce-message\"><div class=\"product_notification_wrapper\"><div class=\"product_notification_background\"><img src=\"' + imgSrc + '\" alt=\"Notification Image\" /></div><div class=\"product_notification_text\"><div>' + gbt_cn_info.cartButton + '&quot;' + prodTitle + '&quot; ' + gbt_cn_info.addedToCartMessage + '</div></div></div></div>');\n      // $('.button.added').removeClass('added');\n    });\n  });\n});\n\nfunction gbt_cn_onAddedToCart(selector, theclass, callback) {\n  if (\"MutationObserver\" in window) {\n    var onMutationsObserved = function onMutationsObserved(mutations) {\n      mutations.forEach(function (mutation) {\n        if (theclass != \"\") {\n          if ((!mutation.oldValue || !mutation.oldValue.match(theclass) && mutation.oldValue.match('loading')) && mutation.target.classList && mutation.target.classList.contains(theclass)) {\n            callback();\n          }\n        } else {\n          if (!mutation.oldValue || mutation.oldValue.match('loading')) {\n            callback();\n          }\n        }\n      });\n    };\n    var target = selector[0];\n    var MutationObserver = window.MutationObserver || window.WebKitMutationObserver;\n    var observer = new MutationObserver(onMutationsObserved);\n    var config = {\n      attributes: true,\n      attributeOldValue: true,\n      attributeFilter: ['class']\n    };\n    observer.observe(target, config);\n  }\n}\n\n//Tabs\njQuery(function ($) {\n  $('#distributors-tabs .dt-button').click(function () {\n    var type = $(this).attr('data-type');\n    console.log(type);\n    var content = $('.dt-content[data-type=\"' + type + '\"]');\n    $('.dt-content').removeClass('active');\n    $('.dt-button').removeClass('active');\n    $(this).addClass('active');\n    content.addClass('active');\n    console.log(content);\n  });\n});\n\n//Accordion\njQuery(function ($) {\n  $('.accordion h3').click(function () {\n    $(this).parent().toggleClass('active');\n  });\n});\n\n//Disable current language click\njQuery(function ($) {\n  jQuery('.wpml-ls-current-language > a').click(function (e) {\n    e.preventDefault();\n  });\n});\n//open submenu when click on parent in mobile\njQuery(function ($) {\n  jQuery('.mobile-navigation.primary-navigation .menu-item-has-children > a').click(function (e) {\n    e.preventDefault();\n    var parent = $(this).parent();\n    parent.find('.sub-menu').toggleClass('open');\n  });\n});\n\n//# sourceURL=webpack://gasservei/./assets/js/scripts.js?");

/***/ }),

/***/ "./assets/sass/styles.scss":
/*!*********************************!*\
  !*** ./assets/sass/styles.scss ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n// extracted by mini-css-extract-plugin\n\n\n//# sourceURL=webpack://gasservei/./assets/sass/styles.scss?");

/***/ }),

/***/ "jquery":
/*!*************************!*\
  !*** external "jQuery" ***!
  \*************************/
/***/ ((module) => {

module.exports = jQuery;

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
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./assets/js/scripts.js");
/******/ 	
/******/ })()
;