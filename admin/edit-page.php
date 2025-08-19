<?php
// Fichier : /admin/edit-page.php

require_once '../includes/db.php';

// --- 1. LOGIQUE & DONNÉES ---

// A. Récupérer et valider le slug de la page à éditer
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
if (empty($slug)) {
    $_SESSION['error_message'] = "Aucune page spécifiée pour l'édition.";
    header('Location: index.php'); // Redirige vers le tableau de bord si pas de slug
    exit();
}

// B. Récupérer les données actuelles de la page
$query = $pdo->prepare("SELECT * FROM pages WHERE slug = ?");
$query->execute([$slug]);
$page = $query->fetch();

// Si la page n'existe pas, on redirige
if (!$page) {
    $_SESSION['error_message'] = "La page que vous essayez de modifier n'existe pas.";
    header('Location: index.php');
    exit();
}

$pageTitle = "Modifier : " . htmlspecialchars($page['titre']);


// --- 2. AFFICHAGE (VUE) ---
require_once 'partials/header.php';
?>

<!-- On inclut le script de TinyMCE depuis leur CDN. Mettez votre clé API si vous en avez une. -->
<!-- Pour un usage de test/développement, 'no-api-key' fonctionne. -->
<script src="https://cdn.tiny.cloud/1/n4zczoxfyqa08tjhkx626omw9nu1jj1c909kaz0hi77iu6zc/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>

<!-- Le script d'initialisation de TinyMCE -->
<script>
  tinymce.init({
    selector: '#page-content-editor', // MODIFIÉ : Cible notre textarea par son ID
    plugins: [
      // ... tous vos plugins ...
      'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
      'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'advtemplate', 'ai', 'uploadcare', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
    ],
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link media table mergetags | addcomment showcomments | spellcheckdialog a1ycheck typography uploadcare | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
    uploadcare_public_key: '2d078ff7a54856cb4996',
    
    // AJOUTS IMPORTANTS
    language: 'fr_FR', // Pour garder l'interface en français
    height: 500       // Pour définir la hauteur de l'éditeur
  });
</script>


<h1 class="mt-4">Modifier la Page : <?= htmlspecialchars($page['titre']) ?></h1>
<p class="lead">Utilisez l'éditeur ci-dessous pour mettre à jour le contenu de la page.</p>

<?php
// Affichage des messages flash (succès/erreur)
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $_SESSION['success_message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="edit-page-handler.php" method="POST">
            
            <!-- Champ caché pour garder le slug, c'est notre identifiant -->
            <input type="hidden" name="slug" value="<?= htmlspecialchars($page['slug']) ?>">

            <!-- Champ pour le titre de la page -->
            <div class="mb-3">
                <label for="titre" class="form-label">Titre de la page</label>
                <input type="text" class="form-control" id="titre" name="titre" value="<?= htmlspecialchars($page['titre']) ?>" required>
            </div>

            <!-- L'éditeur de texte pour le contenu de la page -->
            <div class="mb-3">
                <label for="page-content-editor" class="form-label">Contenu de la page</label>
                <!-- Ce textarea sera remplacé par TinyMCE -->
                <textarea id="page-content-editor" name="contenu">
                    <?= htmlspecialchars($page['contenu']) ?>
                </textarea>
            </div>

            <div class="d-flex justify-content-end">
                <a href="index.php" class="btn btn-secondary me-2">Retour au tableau de bord</a>
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