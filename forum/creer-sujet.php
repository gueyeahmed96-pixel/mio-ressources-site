<?php
// Fichier : /forum/creer-sujet.php

require_once '../includes/header.php'; // Ce header charge déjà auth_config.php

// --- SÉCURITÉ : Vérifier si l'utilisateur est connecté ---
if (!$is_student_logged_in) {
    // Si non, on stocke un message et on le redirige vers la page de connexion
    $_SESSION['error_message'] = "Vous devez être connecté pour créer un sujet.";
    header('Location: /mio-ressources/pages/connexion.php');
    exit();
}

// Récupérer les catégories pour la liste déroulante
$categories = $pdo->query("SELECT id, nom FROM forum_categories ORDER BY ordre ASC")->fetchAll();

// Pré-sélectionner la catégorie si un ID est passé dans l'URL
$selected_cat_id = isset($_GET['cat_id']) ? (int)$_GET['cat_id'] : 0;

$pageTitle = "Créer un nouveau sujet";
?>

<main class="container py-5">
    <h1 class="mb-4">Créer un nouveau sujet de discussion</h1>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            
            <?= show_auth_messages(); // Affiche les erreurs éventuelles ?>

            <form action="creer-sujet-handler.php" method="POST">
                
                <!-- Champ pour la Catégorie -->
                <div class="mb-3">
                    <label for="categorie_id" class="form-label">Dans quelle catégorie ?</label>
                    <select class="form-select" id="categorie_id" name="categorie_id" required>
                        <option value="" disabled <?= $selected_cat_id == 0 ? 'selected' : '' ?>>-- Choisissez une catégorie --</option>
                        <?php foreach ($categories as $categorie): ?>
                            <option value="<?= $categorie['id'] ?>" <?= ($categorie['id'] == $selected_cat_id) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($categorie['nom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Champ pour le Titre du sujet -->
                <div class="mb-3">
                    <label for="titre" class="form-label">Titre du sujet</label>
                    <input type="text" class="form-control" id="titre" name="titre" placeholder="Ex: Problème avec l'exercice 5 de stats" required>
                </div>

                <!-- Champ pour le Message -->
                <div class="mb-3">
                    <label for="contenu" class="form-label">Votre message</label>
                    <textarea class="form-control" id="contenu" name="contenu" rows="10" placeholder="Décrivez votre question ou votre sujet de discussion en détail ici..." required></textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="index.php" class="btn btn-secondary me-2">Annuler</a>
                    <button type="submit" class="btn btn-primary">Publier le sujet</button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php
require_once '../includes/footer.php';
?>