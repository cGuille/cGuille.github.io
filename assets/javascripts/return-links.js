window.document.addEventListener('DOMContentLoaded', function () {
  'use strict';

  if (!window.history || !document.referrer.contains(document.location.host)) {
    return;
  }
  document.querySelectorAll('a.return-link')
    .toArray()
    .forEach(function (returnLinkElt) {
      returnLinkElt.addEventListener('click', function () {
        this.setAttribute('href', 'javascript:history.back()');
      });
    });
});
