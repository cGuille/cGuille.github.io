(function (undefined) {
  'use strict';

  HTMLCollection.prototype.toArray = function HTMLCollection_toArray() {
    return Array.prototype.slice.call(this);
  };
}());
