(function (undefined) {
  'use strict';

  if (!String.prototype.startsWith) {
    Object.defineProperty(String.prototype, 'startsWith', {
      enumerable: false,
      configurable: false,
      writable: false,
      value: function String_startsWith(searchString) {
        return this.lastIndexOf(searchString) === 0;
      }
    });
  }

  if (!String.prototype.trim) {
    (function () {
      // Make sure we trim BOM and NBSP
      var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
      String.prototype.trim = function String_trim() {
        return this.replace(rtrim, '');
      };
    })();
  }
}());
