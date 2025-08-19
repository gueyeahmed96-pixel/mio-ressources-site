<?php
// Fichier : /admin/add-resource.php
// Démarrer la session pour pouvoir lire les messages
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- 1. LOGIQUE & DONNÉES ---
require_once '../includes/db.php';
require_once 'auth_admin.php';

// On récupère toutes les matières pour les afficher dans la liste déroulante
// On fait une jointure pour pouvoir afficher le semestre à côté du nom de la matière (ex: "L1-S1 - Algorithmique")
$sql = "SELECT 
            matieres.id, 
            matieres.nom AS matiere_nom, 
            semestres.nom AS semestre_nom, 
            semestres.niveau
        FROM matieres 
        JOIN semestres ON matieres.semestre_id = semestres.id 
        ORDER BY semestres.id, matieres.nom ASC";
$query_matieres = $pdo->query($sql);
$matieres = $query_matieres->fetchAll();

// Définir le titre de la page
$pageTitle = "Ajouter une Ressource";


// --- 2. AFFICHAGE (VUE) ---
// On inclut l'en-tête de l'admin
require_once 'partials/header.php';
?>

<h1 class="mt-4">Ajouter une Nouvelle Ressource</h1>
<p class="lead">Remplissez le formulaire ci-dessous pour ajouter un nouveau cours, TD, ou lien vidéo.</p>

<?php
// On affichera ici les messages de succès ou d'erreur après la soumission du formulaire
?>

<div class="card shadow-sm">
    <div class="card-body">
        <!-- 
            IMPORTANT : Le formulaire doit avoir l'attribut enctype="multipart/form-data" 
            C'est OBLIGATOIRE pour pouvoir uploader des fichiers.
            Il pointe vers un futur script de traitement : 'add-resource-handler.php'.
        -->
        <form action="add-resource-handler.php" method="POST" enctype="multipart/form-data">
            
            <!-- Champ : Titre de la ressource -->
            <div class="mb-3">
                <label for="nom" class="form-label">Titre de la ressource</label>
                <input type="text" class="form-control" id="nom" name="nom" placeholder="Ex: Chapitre 1 - Introduction à l'Algo" required>
            </div>

            <!-- Champ : Matière associée -->
            <div class="mb-3">
                <label for="matiere_id" class="form-label">Matière Associée</label>
                <select class="form-select" id="matiere_id" name="matiere_id" required>
                    <option value="" selected disabled>-- Choisir une matière --</option>
                    <?php foreach ($matieres as $matiere): ?>
                        <option value="<?= $matiere['id'] ?>">
                            <?= htmlspecialchars($matiere['niveau'] . ' - ' . $matiere['semestre_nom'] . ' | ' . $matiere['matiere_nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="row">
                <!-- Champ : Type de ressource -->
                <div class="col-md-6 mb-3">
                    <label for="type" class="form-label">Type de ressource</label>
                    <select class="form-select" id="type" name="type" required>
                        <option value="Cours">Cours</option>
                        <option value="TD">TD (Travaux Dirigés)</option>
                        <option value="Vidéo">Vidéo (lien)</option>
                        <option value="Autre">Autre</option>
                    </select>
                </div>
                <!-- Champ : Fichier ou Lien -->
                <div class="col-md-6 mb-3">
                    <label for="fichier" class="form-label">Fichier à uploader (ou lien pour vidéo)</label>
                    <input class="form-control" type="file" id="fichier" name="fichier">
                    <input class="form-control" type="text" id="lien_video" name="lien_video" placeholder="Collez le lien YouTube/Vimeo ici" style="display:none;">
                    <div class="form-text">
                        Pour un cours ou un TD, choisissez un fichier. Pour une vidéo, collez un lien.
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-plus-circle-fill me-2"></i>
                    Ajouter la ressource
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Un peu de JavaScript pour la logique du formulaire -->
<script>
    // Attend que le document soit entièrement chargé
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('type');
        const fileInput = document.getElementById('fichier');
        const videoInput = document.getElementById('lien_video');

        // Fonction pour gérer la visibilité des champs
        function toggleInputs() {
            if (typeSelect.value === 'Vidéo') {
                fileInput.style.display = 'none';
                fileInput.required = false; // Le fichier n'est plus obligatoire
                videoInput.style.display = 'block';
                videoInput.required = true; // Le lien devient obligatoire
            } else {
                fileInput.style.display = 'block';
                fileInput.required = true; // Le fichier redevient obligatoire
                videoInput.style.display = 'none';
                videoInput.required = false; // Le lien n'est plus obligatoire
            }
        }

        // Appelle la fonction une première fois au chargement
        toggleInputs();

        // Ajoute un écouteur d'événement sur le selecteur de type
        typeSelect.addEventListener('change', toggleInputs);
    });
</script>

<?php
// On inclut le pied de page de l'admin
require_once 'partials/footer.php';
?>