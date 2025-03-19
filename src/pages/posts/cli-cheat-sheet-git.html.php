<?php
require_once __DIR__ . '/../../types.php';
require_once __DIR__ . '/../../components/sourcecode.php';
assert($pageBuild instanceof PageBuild);
$post = $pageBuild->page;
assert($post instanceof Post);
?>
<p>
    Cette note fait partie de
    <a href="/cli-cheat-sheets.html">
        la série « Trucs et astuces pour la CLI »
    </a>.
</p>

<h2>Filtrer des fichiers avec des patterns</h2>

<p>
    Les commandes qui acceptent des fichiers du dépôt supportent une notation
    permettant de les filtrer avec des patterns.
</p>
<p>
    Pour cela, au lieu de lister les fichiers manuellement ou avec un glob pattern Bash,
    on peut donner <?= code('bash', ':') ?> suivi d'un pattern du chemin complet.<br />
    En ajoutant un <?= code('bash', '!') ?> (ou la notation longue <?= code('bash', '(exclude)') ?>) après le <?= code('bash', ':') ?>, on réalise une exclusion.
</p>

<p>
    Quelques exemples :
</p>

<?= code_block('bash', <<<'BASH'
# Affiche l'historique des changements de tous les fichiers `Cargo.toml` du dépôt :
git log -p  ':*/Cargo.toml'

# Exclus l'affichage des changements de tous les fichiers dont le chemin termine par `.lock`:
git show ':!*.lock'
# Même chose en version longue (`(exclude)` au lieu de `!`).
git show ':(exclude)*.lock'

# Fonctionne également avec git diff:
git diff ':!*.lock'

# Ou encore avec git grep:
git grep -w clap ':*/Cargo.toml'
BASH) ?>

<h2>Renommages dans l'historique d'un fichier</h2>

<p>
    On peut utiliser l'option <?= code('bash', '--follow') ?> pour suivre les renommages d'un fichier dans le log de ses changements.
</p>

<?= code_block('bash', <<<'BASH'
git log --follow -- path/to/file
BASH) ?>

<h2>Patchs</h2>

<p>La sortie standard de <?= code('bash', 'git diff') ?> peut simplement être utilisée pour créer un fichier de patch.

<?= code_block('bash', <<<'BASH'
# Crée un patch avec le diff actuel :
git diff > file.patch

# Applique les changements du patch dans le répertoire de travail :
git apply file.patch

# Crée un patch avec uniquement les changements du fichier README.md :
git diff README.md > readme.patch
BASH) ?>
