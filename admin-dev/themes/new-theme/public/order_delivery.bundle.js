!function(e){function t(o){if(n[o])return n[o].exports;var l=n[o]={i:o,l:!1,exports:{}};return e[o].call(l.exports,l,l.exports,t),l.l=!0,l.exports}var n={};t.m=e,t.c=n,t.i=function(e){return e},t.d=function(e,n,o){t.o(e,n)||Object.defineProperty(e,n,{configurable:!1,enumerable:!0,get:o})},t.n=function(e){var n=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(n,"a",n),n},t.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},t.p="",t(t.s=312)}({16:function(e,t,n){"use strict";function o(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}var l=function(){function e(e,t){for(var n=0;n<t.length;n++){var o=t[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(t,n,o){return n&&e(t.prototype,n),o&&e(t,o),t}}(),r=window.$,a=function(){function e(t){o(this,e),t=t||{},this.localeItemSelector=t.localeItemSelector||".js-locale-item",this.localeButtonSelector=t.localeButtonSelector||".js-locale-btn",this.localeInputSelector=t.localeInputSelector||".js-locale-input",r("body").on("click",this.localeItemSelector,this.toggleInputs.bind(this))}return l(e,[{key:"toggleInputs",value:function(e){var t=r(e.target),n=t.closest("form"),o=t.data("locale"),l=n.find(this.localeButtonSelector),a=l.data("change-language-url");l.text(o),n.find(this.localeInputSelector).addClass("d-none"),n.find(this.localeInputSelector+".js-locale-"+o).removeClass("d-none"),a&&this._saveSelectedLanguage(a,o)}},{key:"_saveSelectedLanguage",value:function(e,t){r.post({url:e,data:{language_iso_code:t}})}}]),e}();t.a=a},312:function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var o=n(16);(0,window.$)(function(){new o.a})}});