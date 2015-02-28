window.document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    document.getElementsByTagName('a')
        .toArray()
        .filter(function isExternalLink(linkElt) {
            return linkElt.host !== document.location.host;
        })
        .forEach(function (externalLinkElt) {
            externalLinkElt.target = '_blank';
        });
});
