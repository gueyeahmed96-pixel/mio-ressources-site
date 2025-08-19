<?php
// Fichier : /pages/semestre.php

require_once '../includes/db.php';

$semestre_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($semestre_id === 0) { header('Location: /mio-ressources/index.php'); exit(); }

$query_semestre = $pdo->prepare('SELECT * FROM semestres WHERE id = ?');
$query_semestre->execute([$semestre_id]);
$semestre = $query_semestre->fetch();
if (!$semestre) { header('Location: /mio-ressources/index.php'); exit(); }

$params_query = $pdo->query("SELECT nom_param, valeur_param FROM parametres WHERE nom_param IN ('bg_image_l1', 'bg_image_l2', 'bg_image_l3')");
$bg_images_db = $params_query->fetchAll(PDO::FETCH_KEY_PAIR);
$bg_images = [
    'L1' => $bg_images_db['bg_image_l1'] ?? 'bg_l1_default.jpg',
    'L2' => $bg_images_db['bg_image_l2'] ?? 'bg_l2_default.jpg',
    'L3' => $bg_images_db['bg_image_l3'] ?? 'bg_l3_default.jpg'
];
$background_image_name = $bg_images[$semestre['niveau']] ?? '';

$query_matieres = $pdo->prepare('SELECT * FROM matieres WHERE semestre_id = ? ORDER BY code_matiere ASC');
$query_matieres->execute([$semestre_id]);
$matieres = $query_matieres->fetchAll();

$pageTitle = htmlspecialchars($semestre['niveau'] . ' - ' . $semestre['nom']);
require_once '../includes/header.php';
?>

<header class="hero-banner text-white text-center py-5" style="background-image: url('/mio-ressources/uploads/backgrounds/<?= htmlspecialchars($background_image_name) ?>');">
    <div class="container">
        <h1 class="display-5 fw-bold"><?= htmlspecialchars($semestre['niveau']) ?> - <?= htmlspecialchars($semestre['nom']) ?></h1>
        <p class="lead">Consultez la liste des matières et accédez aux ressources de cours.</p>
    </div>
</header>

<main class="py-5">
    <div class="container">
        <!-- Reste du code de la page (liste des matières, etc.) qui ne change pas -->
        <?php if (count($matieres) > 0): ?>
            <div class="list-group list-group-flush shadow-sm">
                <?php foreach ($matieres as $matiere): ?>
                    <a href="matiere.php?id=<?= htmlspecialchars($matiere['id']) ?>" class="list-group-item list-group-item-action p-4">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1 fw-bold"><?= htmlspecialchars($matiere['nom']) ?></h5>
                                <p class="mb-1 text-muted">Code : <?= htmlspecialchars($matiere['code_matiere']) ?></p>
                            </div>
                            <i class="bi bi-chevron-right h3 text-secondary"></i>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center" role="alert"><i class="bi bi-exclamation-triangle-fill"></i> Il n'y a pas encore de matières enregistrées pour ce semestre.</div>
        <?php endif; ?>
        <div class="text-center mt-5"><a href="/mio-ressources/index.php" class="btn btn-outline-primary"><i class="bi bi-arrow-left"></i> Retour à la liste des semestres</a></div>
    </div>
</main>

<?php require_once '../includes/footer.php'; ?>