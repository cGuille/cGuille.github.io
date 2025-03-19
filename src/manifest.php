<?php
declare(strict_types=1);

require_once __DIR__ . '/types.php';

return new Manifest(
    new Site(title: 'Les notes de cGuille'),
    [
        new Page(
            path: 'index.html.php',
        ),
        new Page(
            path: 'posts.html.php',
            title: 'Toutes les notes',
        ),
        new Page(
            path: 'cli-cheat-sheets.html.php',
            title: 'Tous les trucs et astuces pour la CLI',
        ),
        new Post(
            path: 'posts/2015-02-28-tant-pis.html.php',
            title: 'Tant pis',
            subtitle: "Moralité : essayer d'être plus malin que le navigateur, ça marche pas.",
            published: '2015-02-28',
        ),
        new Post(
            path: 'posts/2015-10-04-js-objets-constructeurs-prototypes-et-heritage.html.php',
            title: 'Les objets en JavaScript',
            subtitle: 'Prototypes, héritage et constructeurs',
            published: '2015-10-04',
        ),
        new Post(
            path: 'posts/2016-03-11-des-filtres-pour-la-ligne-de-commande-avec-les-streams-de-node-js.html.php',
            title: 'Des filtres pour la ligne de commande avec Node.js',
            subtitle: "Jouons avec l'API stream",
            published: '2016-03-11',
        ),
        new Post(
            path: 'posts/2018-07-21-apprendre-rust-http-crud.html.php',
            title: 'Apprenons Rust : le plus bête des services web',
            subtitle: 'Du CRUD et des doggos',
            published: '2018-07-21',
        ),
        new Post(
            path: 'posts/2021-01-12-rust-decorer-type-avec-deref.html.php',
            title: 'Apprenons Rust : décorer nos types',
            subtitle: 'En utilisant les traits Deref et DerefMut',
            published: '2021-01-12',
        ),
        new Post(
            path: 'posts/cli-cheat-sheet-apt-dpkg.html.php',
            title: 'Cheat Sheet : apt et dpkg',
            subtitle: 'Trucs et astuces pour la CLI',
            published: '2025-03-19',
        ),
    ]
);
