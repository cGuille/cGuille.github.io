<?php
require __DIR__ . '/../helpers/posts.php';
require __DIR__ . '/../fragments/head.html.php';
?>

<section id="page-content">
    <h1 id="page-title">Toutes les notes</h1>

    <ul class="posts-list">
        <?php foreach (get_posts() as $post): ?>
        <li class="posts-list-item">
            <a href="<?= $post->path ?>" title="<?= $post->title ?>">
                <h2><?= $post->title ?></h2>
                <h3><?= $post->subtitle ?></h3>
                <aside>Publié le <?= $post->published ?>.</aside>
            </a>
        </li>
        <?php endforeach ?>
    </ul>

    <section>
        <p><a href="/" class="return-link">Retour</a></p>
    </section>
</section>

<?php require __DIR__ . '/../fragments/foot.html.php'; ?>
