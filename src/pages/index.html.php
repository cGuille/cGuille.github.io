<?php
require __DIR__ . '/../helpers/posts.php';
require __DIR__ . '/../fragments/head.html.php';
?>
<section id="page-content">
    <section class="posts-list-section">
        <ul class="posts-list">
            <?php foreach (get_posts(4) as $post): ?>
            <li class="posts-list-item">
                <a href="<?= $post->path ?>" title="<?= $post->title ?>">
                    <h2><?= $post->title ?></h2>
                    <h3><?= $post->subtitle ?></h3>
                    <aside>Publié le <?= $post->published ?>.</aside>
                </a>
            </li>
            <?php endforeach ?>
        </ul>
        <p class="more-posts">
            <a href="/posts.html">Voir toutes les notes.</a>
        </p>
    </section>

    <section>
        <h2>Qui suis-je ?</h2>
        <p>
            Je suis Guillaume Charmetant. Vous pouvez me retrouver sur
            <a href="https://piaille.fr/@cGuille">Mastodon</a> et
            <a href="https://github.com/cGuille">GitHub</a>.
        </p>
    </section>

    <section>
        <h2>Crédits</h2>
        <p>
            Ce blog est hébergé sur <a href="https://pages.github.com/">les pages GitHub</a>.
            Vous pouvez retrouver <a href="https://github.com/cGuille/cGuille.github.io">son code source sur GitHub</a>.<br />

            La coloration syntaxique est fournie par <a href="http://prismjs.com/">PrismJS</a>,
            un outil écrit par <a href="https://front-end.social/@leaverou">@LeaVerou</a>.<br />

            Logo : <i>book pen by bezier master from the Noun Project</i>.
        </p>
    </section>
</section>

<?php require __DIR__ . '/../fragments/foot.html.php'; ?>
