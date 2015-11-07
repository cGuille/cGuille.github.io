window.document.addEventListener('DOMContentLoaded', function clickToReveal() {
    'use strict';

    var revealButton = document.createElement('button');
    revealButton.appendChild(document.createTextNode('Révéler'));
    revealButton.classList.add('reveal-btn');

    document.querySelectorAll('.click-to-reveal').toArray().forEach(function (revealableElt) {
        revealableElt.classList.add('hidden');
        var btn = revealButton.cloneNode(true);
        btn.addEventListener('click', function () {
            revealableElt.classList.remove('hidden');
            btn.parentElement.removeChild(btn);
        });

        revealableElt.parentElement.insertBefore(btn, revealableElt);
    });
});
