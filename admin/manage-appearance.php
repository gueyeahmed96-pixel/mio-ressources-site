<?php
// Fichier : /admin/manage-appearance.php

require_once '../includes/db.php';
require_once 'auth_admin.php';

// Récupérer les slides
$query_slides = $pdo->query("SELECT * FROM slider_images ORDER BY ordre ASC");
$slides = $query_slides->fetchAll();

// Récupérer les paramètres des images de fond
$query_params = $pdo->query("SELECT nom_param, valeur_param FROM parametres WHERE nom_param LIKE 'bg_image_%'");
$params = $query_params->fetchAll(PDO::FETCH_KEY_PAIR);

$pageTitle = "Gérer l'Apparence du Site";
require_once 'partials/header.php';
?>

<h1 class="mt-4">Gérer l'Apparence du Site</h1>
<p class="lead">Modifiez ici les images principales qui définissent le style de votre site.</p>

<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert"><?= htmlspecialchars($_SESSION['success_message']); ?><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<!-- Section 1 : Gestion du Slider -->
<div class="card shadow-sm mb-4">
    <div class="card-header"><h5 class="mb-0">Images du Slider d'Accueil</h5></div>
    <div class="card-body">
        <div class="row">
            <?php foreach ($slides as $slide): ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                    <img src="../uploads/slider/<?= htmlspecialchars($slide['image_path']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Aperçu">
                    <div class="card-body">
                        <form action="appearance-handler.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="update_slide">
                            <input type="hidden" name="id" value="<?= $slide['id'] ?>">
                            <div class="mb-3"><label class="form-label">Changer l'image</label><input type="file" name="image" class="form-control form-control-sm"></div>
                            <div class="mb-3"><label class="form-label">Titre</label><input type="text" name="titre" class="form-control" value="<?= htmlspecialchars($slide['titre']) ?>"></div>
                            <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($slide['description']) ?></textarea></div>
                            <button type="submit" class="btn btn-primary w-100">Enregistrer Slide <?= $slide['ordre'] ?></button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Section 2 : Gestion des Images de Fond -->
<div class="card shadow-sm">
    <div class="card-header"><h5 class="mb-0">Images de Fond des Niveaux</h5></div>
    <div class="card-body">
        <form action="appearance-handler.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="update_backgrounds">
            <div class="row">
                <div class="col-md-4 mb-3"><label class="form-label fw-bold">Image L1</label><img src="../uploads/backgrounds/<?= htmlspecialchars($params['bg_image_l1'] ?? '') ?>" class="img-thumbnail mb-2"><input type="file" class="form-control" name="bg_image_l1"></div>
                <div class="col-md-4 mb-3"><label class="form-label fw-bold">Image L2</label><img src="../uploads/backgrounds/<?= htmlspecialchars($params['bg_image_l2'] ?? '') ?>" class="img-thumbnail mb-2"><input type="file" class="form-control" name="bg_image_l2"></div>
                <div class="col-md-4 mb-3"><label class="form-label fw-bold">Image L3</label><img src="../uploads/backgrounds/<?= htmlspecialchars($params['bg_image_l3'] ?? '') ?>" class="img-thumbnail mb-2"><input type="file" class="form-control" name="bg_image_l3"></div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Enregistrer les Images de Fond</button>
            </div>
        </form>
    </div>
</div>

<?php require_once 'partials/footer.php'; ?>