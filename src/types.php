<?php
declare(strict_types=1);

// Types to describe the page being built:

readonly class PageBuild
{
    public function __construct(
        public Site $site,
        public Page $page,
        public array $posts,
    ) {}

    public function posts(?int $limit = null) {
        $res = $this->posts;

        if ($limit) {
            $res = array_slice($res, 0, $limit);
        }

        return $res;
    }
}

// Types to describe the entire website:

readonly class Manifest
{
    public function __construct(
        public Site $site,
        public array $pages
    ) {}
}

readonly class Site
{
    public function __construct(
        public string $title,
    ) {}
}

enum Layout: string
{
    case Page = __DIR__ . '/layouts/page.html.php';
    case Post = __DIR__ . '/layouts/post.html.php';
}

readonly class Page
{
    protected const SRC_DIR = __DIR__ . '/pages/';

    public function __construct(
        protected string $path,
        public ?string $title = null,
    ) {}

    public function layout(): Layout {
        return Layout::Page;
    }

    public function src(): string {
        return self::SRC_DIR . $this->path;
    }

    public function link(): string {
        $name = basename($this->path, '.php');
        $base = dirname(substr($this->src(), strlen(self::SRC_DIR)));

        return '/' . $base . '/' . $name;
    }
}

readonly class Post extends Page
{
    public function __construct(
        public string $path,
        public ?string $title,
        public string $subtitle,
        public string $published,
        public ?string $updated = null,
    ) {}

    public function layout(): Layout {
        return Layout::Post;
    }
}
