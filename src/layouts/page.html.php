<?php
require_once __DIR__ . '/../types.php';
assert($pageBuild instanceof PageBuild);
?>
<section id="page-content">
  <?php if ($pageBuild->page->title !== null): ?>
  <h1 id="page-title"><?= $pageBuild->page->title ?></h1>
  <?php endif ?>

  <?php require $pageBuild->page->src(); ?>
</section>
