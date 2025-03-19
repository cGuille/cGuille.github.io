<?php
require_once __DIR__ . '/../types.php';
assert($pageBuild instanceof PageBuild);

$posts = array_filter($pageBuild->posts, function (Post $p) use($post): bool {
    return str_starts_with($p->link(), '/posts/cli-cheat-sheet-');
});
usort($posts, function (Post $p1, Post $p2): int {
    return mb_strtolower($p1->title) <=> mb_strtolower($p2->title);
});
?>
<section>
    <p>
        Cette page référence toutes les notes de la série « Trucs et astuces pour la CLI ».
    </p>
</section>

<ul class="posts-list">
    <?php foreach ($posts as $post): ?>
        <li class="posts-list-item">
            <a href="<?= $post->link() ?>" title="<?= $post->title ?>">
                <h2><?= $post->title ?></h2>
                <aside>Publié le <?= $post->published ?>.</aside>
            </a>
        </li>
    <?php endforeach ?>
<ul>

<section>
    <p><a href="/" class="return-link">Retour</a></p>
</section>
