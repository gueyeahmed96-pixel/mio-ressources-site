<?php
// Fichier : /pages/club-mio.php (version dynamique)

require_once '../includes/db.php';

// On va chercher le contenu de la page avec le slug 'club-mio'
$query = $pdo->prepare("SELECT * FROM pages WHERE slug = 'club-mio'");
$query->execute();
$page = $query->fetch();

if (!$page) {
    $page = ['titre' => 'Page non trouvée', 'contenu' => 'Le contenu de cette page n\'a pas pu être chargé.'];
}

$pageTitle = htmlspecialchars($page['titre']);
require_once '../includes/header.php';
?>

<div class="container py-5">
    <h1 class="mb-4"><?= htmlspecialchars($page['titre']) ?></h1>

    <div class="page-content">
        <?= $page['contenu'] ?>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>