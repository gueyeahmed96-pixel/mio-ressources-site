<?php
// Fichier : /pages/a-propos.php (version dynamique)

require_once '../includes/db.php';

// On va chercher le contenu de la page avec le slug 'a-propos'
$query = $pdo->prepare("SELECT * FROM pages WHERE slug = 'a-propos'");
$query->execute();
$page = $query->fetch();

// Si la page n'est pas trouvée (ne devrait pas arriver), on met des valeurs par défaut
if (!$page) {
    $page = ['titre' => 'Page non trouvée', 'contenu' => 'Le contenu de cette page n\'a pas pu être chargé.'];
}

$pageTitle = htmlspecialchars($page['titre']);
require_once '../includes/header.php';
?>

<div class="container py-5">
    <h1 class="mb-4"><?= htmlspecialchars($page['titre']) ?></h1>
    
    <!-- On affiche le contenu HTML directement. C'est sécurisé car seul l'admin peut le modifier. -->
    <div class="page-content">
        <?= $page['contenu'] ?>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>