<?php
// Fichier : /admin/list-admins.php (Version corrigée avec phpauth_users)
require_once '../includes/db.php';
require_once 'auth_admin.php'; // On utilise notre propre garde du corps
$pageTitle = "Gérer les Administrateurs";

// --- ON UTILISE LA NOUVELLE TABLE ET LES NOUVELLES COLONNES ---
$query = $pdo->query("SELECT id, username, email FROM phpauth_users ORDER BY username ASC");
$admins = $query->fetchAll();

require_once 'partials/header.php';
?>

<h1 class="h3 mb-4">Gérer les Administrateurs</h1>

<!-- Affichage des messages flash -->
<?php if(isset($_SESSION['success_message'])) { echo '<div class="alert alert-success alert-dismissible fade show" role="alert">'.$_SESSION['success_message'].'<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>'; unset($_SESSION['success_message']); } ?>
<?php if(isset($_SESSION['error_message'])) { echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'.$_SESSION['error_message'].'<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>'; unset($_SESSION['error_message']); } ?>

<div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="m-0 fw-bold text-primary">Liste des utilisateurs</h6>
        <a href="add-admin.php" class="btn btn-primary btn-sm"><i class="bi bi-person-plus-fill me-2"></i>Ajouter un admin</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Nom d'utilisateur</th>
                        <th>Email</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admins as $admin): ?>
                    <tr>
                        <td><i class="bi bi-person-circle me-2"></i><?= htmlspecialchars($admin['username']) ?></td>
                        <td><?= htmlspecialchars($admin['email']) ?></td>
                        <td class="text-end">
                            <a href="edit-admin.php?id=<?= $admin['id'] ?>" class="btn btn-warning btn-sm" title="Modifier"><i class="bi bi-pencil-fill"></i></a>
                            
                            <?php if ($admin['id'] == 1): ?>
                                <button class="btn btn-secondary btn-sm" disabled title="Le Super Admin ne peut pas être supprimé"><i class="bi bi-shield-lock-fill"></i></button>
                            <?php elseif ($admin['id'] == $_SESSION['admin_id']): ?>
                                <button class="btn btn-danger btn-sm" disabled title="Vous ne pouvez pas vous supprimer vous-même"><i class="bi bi-trash-fill"></i></button>
                            <?php else: ?>
                                <a href="delete-admin.php?id=<?= $admin['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet administrateur ?');" title="Supprimer"><i class="bi bi-trash-fill"></i></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'partials/footer.php'; ?>