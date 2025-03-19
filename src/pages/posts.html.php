<?php
require_once __DIR__ . '/../types.php';
assert($pageBuild instanceof PageBuild);
?>
<ul class="posts-list">
    <?php foreach ($pageBuild->posts() as $post): ?>
    <li class="posts-list-item">
        <a href="<?= $post->link() ?>" title="<?= $post->title ?>">
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
