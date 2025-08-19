<?php
// Fichier : /admin/edit-admin.php (Version corrigée avec phpauth_users)
require_once '../includes/db.php';
require_once 'auth_admin.php';

$admin_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($admin_id === 0) { header('Location: list-admins.php'); exit(); }

// --- ON UTILISE LA BONNE TABLE ET LES BONNES COLONNES ---
$query = $pdo->prepare("SELECT id, username, photo_profil FROM phpauth_users WHERE id = ?");
$query->execute([$admin_id]);
$admin = $query->fetch();

if (!$admin) { header('Location: list-admins.php'); exit(); }

$pageTitle = "Modifier le Profil";
require_once 'partials/header.php';
?>
<h1 class="h3 mb-4">Modifier : <?= htmlspecialchars($admin['username']) ?></h1>
<div class="card shadow">
    <div class="card-body">
        <form action="edit-admin-handler.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $admin['id'] ?>">
            <div class="row">
                <div class="col-md-3 text-center">
                    <?php if (!empty($admin['photo_profil'])): ?>
                        <img src="../uploads/profiles/<?= htmlspecialchars($admin['photo_profil']) ?>" class="img-thumbnail rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;" alt="Photo de profil">
                    <?php else: ?>
                        <i class="bi bi-person-circle text-secondary" style="font-size: 150px;"></i>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label for="photo_profil" class="form-label">Changer la photo</label>
                        <input class="form-control form-control-sm" type="file" id="photo_profil" name="photo_profil">
                    </div>
                    <?php if (!empty($admin['photo_profil'])): ?>
                        <div class="form-check form-switch d-flex justify-content-center">
                            <input class="form-check-input" type="checkbox" id="delete_photo" name="delete_photo">
                            <label class="form-check-label ms-2" for="delete_photo">Supprimer la photo</label>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-9">
                    <div class="mb-3">
                        <label for="username" class="form-label">Nom d'utilisateur</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($admin['username']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="mot_de_passe" class="form-label">Nouveau Mot de Passe</label>
                        <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe">
                        <div class="form-text">Laissez ce champ vide pour ne pas changer le mot de passe.</div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-3 border-top pt-3">
                <a href="list-admins.php" class="btn btn-secondary me-2">Annuler</a>
                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
            </div>
        </form>
    </div>
</div>
<?php require_once 'partials/footer.php'; ?>