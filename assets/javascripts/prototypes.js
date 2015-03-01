(function (undefined) {
  'use strict';

  if (!NodeList.prototype.toArray) {
    NodeList.prototype.toArray = toArray;
  }
  if (!HTMLCollection.prototype.toArray) {
    HTMLCollection.prototype.toArray = toArray;
  }
  if (!String.prototype.contains) {
    String.prototype.contains = function String_contains(searchString) {
      return this.indexOf(searchString) !== -1;
    };
  }

  function toArray() {
    return Array.prototype.slice.call(this);
  }
}());
