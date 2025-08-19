<?php
// Fichier : /admin/forum-categories.php
require_once '../includes/db.php';
require_once 'auth_admin.php';
$pageTitle = "Gérer les Catégories du Forum";

// Traitement du formulaire d'ajout/modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $description = trim($_POST['description']);
    $ordre = (int)$_POST['ordre'];
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if (!empty($nom)) {
        if ($id > 0) { // Modification
            $sql = "UPDATE forum_categories SET nom = ?, description = ?, ordre = ? WHERE id = ?";
            $pdo->prepare($sql)->execute([$nom, $description, $ordre, $id]);
            $_SESSION['success_message'] = "Catégorie mise à jour.";
        } else { // Ajout
            $sql = "INSERT INTO forum_categories (nom, description, ordre) VALUES (?, ?, ?)";
            $pdo->prepare($sql)->execute([$nom, $description, $ordre]);
            $_SESSION['success_message'] = "Catégorie ajoutée.";
        }
    }
    header('Location: forum-categories.php');
    exit();
}

// Logique pour la suppression
if (isset($_GET['delete_id'])) {
    $id_to_delete = (int)$_GET['delete_id'];
    $pdo->prepare("DELETE FROM forum_categories WHERE id = ?")->execute([$id_to_delete]);
    $_SESSION['success_message'] = "Catégorie supprimée.";
    header('Location: forum-categories.php');
    exit();
}

// Logique pour pré-remplir le formulaire en mode édition
$categorie_a_editer = null;
if (isset($_GET['edit_id'])) {
    $id_to_edit = (int)$_GET['edit_id'];
    $query_edit = $pdo->prepare("SELECT * FROM forum_categories WHERE id = ?");
    $query_edit->execute([$id_to_edit]);
    $categorie_a_editer = $query_edit->fetch();
}

// Récupération de toutes les catégories pour les lister
$categories = $pdo->query("SELECT * FROM forum_categories ORDER BY ordre ASC")->fetchAll();
require_once 'partials/header.php';
?>

<h1 class="h3 mb-4"><?= $categorie_a_editer ? "Modifier une Catégorie" : "Gérer les Catégories du Forum" ?></h1>
<?php if(isset($_SESSION['success_message'])) { echo '<div class="alert alert-success">'.$_SESSION['success_message'].'</div>'; unset($_SESSION['success_message']); } ?>

<!-- Formulaire d'ajout ou de modification -->
<div class="card shadow mb-4">
    <div class="card-header"><h6 class="m-0 fw-bold text-primary"><?= $categorie_a_editer ? "Édition de : " . htmlspecialchars($categorie_a_editer['nom']) : "Ajouter une nouvelle catégorie" ?></h6></div>
    <div class="card-body">
        <form action="forum-categories.php" method="POST">
            <input type="hidden" name="id" value="<?= $categorie_a_editer['id'] ?? 0 ?>">
            <div class="row">
                <div class="col-md-4 mb-3"><label class="form-label">Nom</label><input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($categorie_a_editer['nom'] ?? '') ?>" required></div>
                <div class="col-md-6 mb-3"><label class="form-label">Description</label><input type="text" name="description" class="form-control" value="<?= htmlspecialchars($categorie_a_editer['description'] ?? '') ?>"></div>
                <div class="col-md-2 mb-3"><label class="form-label">Ordre</label><input type="number" name="ordre" class="form-control" value="<?= $categorie_a_editer['ordre'] ?? 0 ?>"></div>
            </div>
            <button type="submit" class="btn btn-primary"><?= $categorie_a_editer ? "Enregistrer les modifications" : "Ajouter la catégorie" ?></button>
            <?php if ($categorie_a_editer): ?><a href="forum-categories.php" class="btn btn-secondary">Annuler</a><?php endif; ?>
        </form>
    </div>
</div>

<!-- Liste des catégories existantes -->
<div class="card shadow">
    <div class="card-header"><h6 class="m-0 fw-bold text-primary">Catégories existantes</h6></div>
    <div class="card-body">
        <table class="table table-hover">
            <thead><tr><th>Ordre</th><th>Nom</th><th>Description</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
                <?php foreach ($categories as $cat): ?>
                <tr>
                    <td><?= $cat['ordre'] ?></td>
                    <td><?= htmlspecialchars($cat['nom']) ?></td>
                    <td><?= htmlspecialchars($cat['description']) ?></td>
                    <td class="text-end">
                        <a href="forum-categories.php?edit_id=<?= $cat['id'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-fill"></i></a>
                        <a href="forum-categories.php?delete_id=<?= $cat['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Sûr ?')"><i class="bi bi-trash-fill"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'partials/footer.php'; ?>