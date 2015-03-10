(function (undefined) {
  'use strict';

  if (!NodeList.prototype.toArray) {
    NodeList.prototype.toArray = toArray;
  }
  if (!HTMLCollection.prototype.toArray) {
    HTMLCollection.prototype.toArray = toArray;
  }
  if (!String.prototype.contains) {
    String.prototype.contains = contains;
  }
  if (!Array.prototype.contains) {
    Array.prototype.contains = contains;
  }

  function contains(search) {
    return this.indexOf(search) !== -1;
  }

  function toArray() {
    return Array.prototype.slice.call(this);
  }
}());
