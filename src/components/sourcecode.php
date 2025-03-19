<?php
declare(strict_types=1);

function code_block(string $langName, string $sourceCode): string {
    return '<pre>' . code($langName, $sourceCode) . '</pre>';
}

function code(string $langName, string $sourceCode): string {
    return '<code class="language-' . $langName . '">' . htmlspecialchars(trim($sourceCode)) . '</code>';
}
