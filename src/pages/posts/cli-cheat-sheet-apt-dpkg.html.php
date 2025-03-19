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

<h2>apt</h2>

<h3>Sélection de version</h3>

<p>Downgrade / installer une version spécifique d'un paquet :</p>

<?= code_block('bash', <<<'BASH'
# Affiche les versions disponibles :
apt-cache showpkg "$package_name"

# Installation d'une version spécifique :
sudo apt-get install "$package_name"="$package_version"
BASH) ?>

<p>Empêcher un paquet spécifique d'être mis à jour automatiquement :</p>

<?= code_block('bash', <<<'BASH'
# Bloquer les mises à jour d'un paquet :
sudo apt-mark hold "$package_name"

# Retirer le bloquage :
sudo apt-mark unhold "$package_name"

# Afficher tous les paquets bloqués :
sudo apt-mark showhold
BASH) ?>

<h3>D'où vient ce paquet ?</h3>

<p>Afin de savoir pourquoi un paquet est installé, on peut lister les paquets qui en dépendent :

<?= code_block('bash', <<<'BASH'
apt-cache rdepends --recurse --installed "$package_name"
BASH) ?>

<h2>dpkg</h2>

<h3>Quel paquet détient ce fichier ?</h3>

<?= code_block('bash', <<<'BASH'
dpkg -S "$file_path"
BASH) ?>

<h3>Quels fichiers ont été installés par ce paquet ?</h3>

<?= code_block('bash', <<<'BASH'
dpkg -L "$package_name"
BASH) ?>

<h3>Quels fichiers seraient installés par ce fichier .deb ?</h3>

<?= code_block('bash', <<<'BASH'
dpkg -c "$deb_path"
BASH) ?>

<h3>Vue condensée des fichiers installés</h3>

<p>Affiche une vue condensée des paquets installés, contenant notamment leur état
d'installation, leur version, ainsi qu'une description courte.</p>

<?= code_block('bash', <<<'BASH'
# Tous les paquets installés :
dpkg -l

# Seulement les paquets spécifiés :
dpkg -l "$package1" "$package2" # …
BASH) ?>
