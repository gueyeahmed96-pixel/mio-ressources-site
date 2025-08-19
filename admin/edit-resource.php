<?php
// Fichier : /admin/edit-resource.php

require_once '../includes/db.php';
require_once 'auth_admin.php';

// --- 1. LOGIQUE & DONNÉES ---

// A. Récupérer et valider l'ID de la ressource à éditer
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id === 0) {
    // Si l'ID est invalide, on redirige avec un message d'erreur
    $_SESSION['error_message'] = "ID de ressource non valide.";
    header('Location: list-resources.php');
    exit();
}

// B. Récupérer les données actuelles de la ressource
$query_ressource = $pdo->prepare("SELECT * FROM ressources WHERE id = ?");
$query_ressource->execute([$id]);
$ressource = $query_ressource->fetch();

// Si la ressource n'existe pas, on redirige
if (!$ressource) {
    $_SESSION['error_message'] = "Aucune ressource trouvée avec cet ID.";
    header('Location: list-resources.php');
    exit();
}

// C. Récupérer toutes les matières pour la liste déroulante (comme sur la page d'ajout)
$sql_matieres = "SELECT m.id, m.nom AS matiere_nom, s.nom AS semestre_nom, s.niveau
                 FROM matieres AS m JOIN semestres AS s ON m.semestre_id = s.id 
                 ORDER BY s.id, m.nom ASC";
$matieres = $pdo->query($sql_matieres)->fetchAll();

$pageTitle = "Modifier la Ressource";


// --- 2. AFFICHAGE (VUE) ---
require_once 'partials/header.php';
?>

<h1 class="mt-4">Modifier la Ressource</h1>
<p class="lead">Mettez à jour les informations de la ressource ci-dessous.</p>

<?php
// On affichera ici les messages de succès ou d'erreur
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error_message']; ?></div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <!-- Le formulaire pointe vers notre script de traitement 'edit-resource-handler.php' -->
        <form action="edit-resource-handler.php" method="POST" enctype="multipart/form-data">
            
            <!-- Champ caché pour garder l'ID de la ressource. C'est crucial ! -->
            <input type="hidden" name="id" value="<?= $ressource['id'] ?>">

            <!-- Titre : on utilise l'attribut 'value' pour pré-remplir -->
            <div class="mb-3">
                <label for="nom" class="form-label">Titre de la ressource</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($ressource['nom']) ?>" required>
            </div>

            <!-- Matière : on utilise du PHP pour sélectionner la bonne option -->
            <div class="mb-3">
                <label for="matiere_id" class="form-label">Matière Associée</label>
                <select class="form-select" id="matiere_id" name="matiere_id" required>
                    <?php foreach ($matieres as $matiere): ?>
                        <option value="<?= $matiere['id'] ?>" <?= ($matiere['id'] == $ressource['matiere_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($matiere['niveau'] . ' | ' . $matiere['matiere_nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Type : on sélectionne aussi la bonne option -->
            <div class="mb-3">
                <label for="type" class="form-label">Type de ressource</label>
                <select class="form-select" id="type" name="type" required>
                    <option value="Cours" <?= ($ressource['type'] == 'Cours') ? 'selected' : '' ?>>Cours</option>
                    <option value="TD" <?= ($ressource['type'] == 'TD') ? 'selected' : '' ?>>TD</option>
                    <option value="Vidéo" <?= ($ressource['type'] == 'Vidéo') ? 'selected' : '' ?>>Vidéo</option>
                    <option value="Autre" <?= ($ressource['type'] == 'Autre') ? 'selected' : '' ?>>Autre</option>
                </select>
            </div>
            
            <!-- Fichier/Lien : on affiche le fichier actuel et on permet d'en uploader un nouveau -->
            <div class="mb-3">
                <label for="fichier" class="form-label">Changer le fichier (optionnel)</label>
                <p class="form-text">Fichier actuel : 
                    <a href="../uploads/<?= htmlspecialchars($ressource['chemin_fichier'])?>" target="_blank"><?= htmlspecialchars($ressource['chemin_fichier']) ?></a>
                </p>
                <input class="form-control" type="file" id="fichier" name="fichier">
                <div class="form-text">Laissez ce champ vide si vous ne voulez pas changer le fichier.</div>
            </div>

            <div class="d-flex justify-content-end">
                <a href="list-resources.php" class="btn btn-secondary me-2">Annuler</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>

<?php
require_once 'partials/footer.php';
?>