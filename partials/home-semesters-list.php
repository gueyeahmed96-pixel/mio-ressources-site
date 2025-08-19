<?php
// Fichier : /partials/home-semesters-list.php

@require_once __DIR__ . '/../includes/db.php';

$bg_images = [];
if (isset($pdo)) {
    $params_query = $pdo->query("SELECT nom_param, valeur_param FROM parametres WHERE nom_param IN ('bg_image_l1', 'bg_image_l2', 'bg_image_l3')");
    $bg_images_db = $params_query->fetchAll(PDO::FETCH_KEY_PAIR);
    $bg_images = [
        'L1' => $bg_images_db['bg_image_l1'] ?? 'bg_l1_default.jpg',
        'L2' => $bg_images_db['bg_image_l2'] ?? 'bg_l2_default.jpg',
        'L3' => $bg_images_db['bg_image_l3'] ?? 'bg_l3_default.jpg'
    ];
}
?>
<main class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Explorez les Ressources</h2>
            <p class="lead text-muted">Naviguez à travers les semestres pour trouver les cours et TD dont vous avez besoin.</p>
        </div>
        <div class="row g-4 justify-content-center">
            <?php foreach ($semestres as $semestre):
                $background_image_name = $bg_images[$semestre['niveau']] ?? '';
            ?>
                <div class="col-md-6 col-lg-4">
                    <a href="/mio-ressources/pages/semestre.php?id=<?= htmlspecialchars($semestre['id']) ?>" class="semester-link">
                        <div class="semester-card" style="background-image: url('/mio-ressources/uploads/backgrounds/<?= htmlspecialchars($background_image_name) ?>');">
                            <div class="card-content">
                                <h3 class="card-title fw-bold mb-1"><?= htmlspecialchars($semestre['niveau']) ?></h3>
                                <p class="lead mb-2"><?= htmlspecialchars($semestre['nom']) ?></p>
                                <p class="see-more mb-0">Voir les matières <i class="bi bi-arrow-right-short"></i></p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>