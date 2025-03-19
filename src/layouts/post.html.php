<?php
require_once __DIR__ . '/../types.php';
assert($pageBuild instanceof PageBuild);
$post = $pageBuild->page;
assert($post instanceof Post);
?>
<article id="post">
    <header>
        <h1><?= $post->title ?></h2>
        <h3><?= $post->subtitle ?></h3>
        <aside>Publié le <?= $post->published ?>.</aside>
    </header>

    <div class="post-content">
        <?php require $post->src(); ?>
    </div>
    
    <aside>
        <p><a href="/" class="return-link">Retour</a></p>
    </aside>

    <footer>Vous avez vraiment tout lu ? Bravo ! <a href="#">↑ Vous pouvez remonter maintenant ↑</a>.</footer>
</article>
