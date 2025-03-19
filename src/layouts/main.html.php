<?php
require_once __DIR__ . '/../types.php';
assert($pageBuild instanceof PageBuild);
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset='utf-8'>
    <meta http-equiv="X-UA-Compatible" content="chrome=1">

    <link rel="stylesheet" type="text/css" href="/assets/stylesheets/prism.css" media="screen">
    <link rel="stylesheet" type="text/css" href="/assets/stylesheets/stylesheet.css" media="screen">

    <link rel="icon" type="image/svg" href="/assets/images/book-pen.svg">

    <meta name="theme-color" content="rgb(41, 128, 185)">

    <title><?= $pageBuild->site->title ?></title>
  </head>

  <body>
    <header id="main-header">
        <a href="/">
          <img src="/assets/images/book-pen.svg" alt="Logo" class="site-logo" />
          <span class="site-title"><?= $pageBuild->site->title ?></span>
        </a>
    </header>

<?php require $pageBuild->page->layout()->value ?>

    <script src="/assets/javascripts/prototypes.js"></script>
    <script src="/assets/javascripts/polyfills.js"></script>

    <script src="/assets/javascripts/prism.js"></script>

    <script src="/assets/javascripts/external-links-targets.js"></script>
    <script src="/assets/javascripts/return-links.js"></script>
    <script src="/assets/javascripts/click-to-reveal.js"></script>
  </body>
</html>
