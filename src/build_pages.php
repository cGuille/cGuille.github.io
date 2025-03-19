<?php
declare(strict_types=1);

$buildDir = $argv[1];

$manifest = require __DIR__ . '/manifest.php';

$posts = array_reverse(array_filter($manifest->pages, function (Page $page): bool {
    return $page instanceof Post;
}));

foreach ($manifest->pages as $page) {
    $pageBuild = new PageBuild(
        site: $manifest->site,
        page: $page,
        posts: $posts,
    );

    ob_start();
    require __DIR__ . '/layouts/main.html.php';
    $pageContent = ob_get_clean();

    $destPath = "${buildDir}" . $pageBuild->page->link();
    $destDir = dirname($destPath);

    if (!is_dir($destDir) && !mkdir($destDir, 0777, true)) {
        throw new Exception("Failed to create page's directory at ${destDir}");
    }

    if (file_put_contents($destPath, $pageContent) === false) {
        throw new Exception("Failed to write page content to ${destPath}");
    }
}
