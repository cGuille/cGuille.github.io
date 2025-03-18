<?php
const SITE_TITLE = 'Les notes de cGuille';
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

    <title><?= SITE_TITLE ?></title>
  </head>

  <body>
    <header id="main-header">
        <a href="/">
          <img src="/assets/images/book-pen.svg" alt="Logo" class="site-logo" />
          <span class="site-title"><?= SITE_TITLE ?></span>
        </a>
    </header>
