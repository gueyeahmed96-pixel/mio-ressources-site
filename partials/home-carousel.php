<?php
// Fichier : /partials/home-carousel.php

// Le chemin est rendu plus robuste avec __DIR__
@require_once __DIR__ . '/../includes/db.php';

// On s'assure que $pdo existe avant de l'utiliser
if (isset($pdo)) {
    $query_slides = $pdo->query("SELECT * FROM slider_images ORDER BY ordre ASC");
    $slides = $query_slides->fetchAll();
} else {
    // Fournit un tableau vide si la BDD n'est pas connectée, pour éviter de planter le site
    $slides = [];
}
?>

<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <?php if (!empty($slides)): // On n'affiche le slider que s'il y a des images ?>
        <div class="carousel-indicators">
            <?php foreach ($slides as $index => $slide): ?>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?= $index ?>" class="<?= ($index == 0) ? 'active' : '' ?>" aria-label="Slide <?= $index + 1 ?>"></button>
            <?php endforeach; ?>
        </div>

        <div class="carousel-inner">
            <?php foreach ($slides as $index => $slide): ?>
                <div class="carousel-item <?= ($index == 0) ? 'active' : '' ?>">
                    <img src="/mio-ressources/uploads/slider/<?= htmlspecialchars($slide['image_path']) ?>" class="d-block w-100" alt="<?= htmlspecialchars($slide['titre']) ?>" loading="lazy"> // Ligne 30
                    <div class="carousel-caption d-none d-md-block">
                        <h5><?= htmlspecialchars($slide['titre']) ?></h5>
                        <p><?= htmlspecialchars($slide['description']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Précédent</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Suivant</span>
        </button>
    <?php else: ?>
        <div class="carousel-inner"><div class="carousel-item active" style="height: 60vh; background-color: #333;"></div></div>
    <?php endif; ?>
</div>