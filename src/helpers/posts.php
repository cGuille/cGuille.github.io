<?php
declare(strict_types=1);

const POSTS_SRC_DIR = __DIR__ . '/../pages/posts';

function get_posts(?int $limit = null): Generator {
    $postMetaFiles = array_reverse(glob(POSTS_SRC_DIR . '/*.json'));

    if ($limit) {
        $postMetaFiles = array_slice($postMetaFiles, 0, $limit);
    }

    foreach ($postMetaFiles as $i => $postMetaFile) {
        yield post_meta($postMetaFile);
    }
}

function get_post(string $postSourcePath): PostMetadata {
    $postMetaPath = preg_replace(
        '#\.html.php$#',
        '.json',
        $postSourcePath,
        -1,
        $count
    );

    if (!$postMetaPath || $count !== 1) {
        throw new Exception("Could not compute post metadata path from source path: $postMetaPath");
    }

    return post_meta($postMetaPath);
}

readonly class PostMetadata
{
    public function __construct(
        public string $title,
        public string $subtitle,
        public string $published,
        public string $path,
    ) {}
}

function post_meta(string $postMetaFilePath): PostMetadata {
    $contents = file_get_contents($postMetaFilePath);
    if (false === $contents) {
        throw Exception("Could not read post metadata from '$postMetaFilePath'");
    }

    $data = json_decode($contents, false, 512, JSON_THROW_ON_ERROR);

    $postPath = preg_replace(
        '#^.+/pages/posts/(.+).json#',
        '/posts/\1.html',
        $postMetaFilePath,
        -1,
        $count
    );

    if (!$postPath || $count !== 1) {
        throw new Exception("Could not compute post path from meta path: $postMetaFilePath");
    }

    return new PostMetadata($data->title, $data->subtitle, $data->published, $postPath);
}
