(function (undefined) {
  'use strict';

  if (!NodeList.prototype.toArray) {
    NodeList.prototype.toArray = toArray;
  }
  if (!HTMLCollection.prototype.toArray) {
    HTMLCollection.prototype.toArray = toArray;
  }

  function toArray() {
    return Array.prototype.slice.call(this);
  }
}());
