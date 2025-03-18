window.document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    document.getElementsByTagName('a')
        .toArray()
        .filter(function isExternalLink(linkElt) {
            return linkElt.host !== document.location.host;
        })
        .forEach(function (externalLinkElt) {
            var linkRelParts = [];

            if (externalLinkElt.rel) {
                linkRelParts.push(externalLinkElt.rel);
            }

            if (!/\bnoopener\b/.test(externalLinkElt.rel)) {
                linkRelParts.push('noopener');
            }

            if (!/\bnoreferrer\b/.test(externalLinkElt.rel)) {
                linkRelParts.push('noreferrer');
            }

            externalLinkElt.rel = linkRelParts.join(' ');
            externalLinkElt.target = '_blank';
        });
});
