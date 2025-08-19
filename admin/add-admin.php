<?php
// Fichier : /admin/add-admin.php
require_once '../includes/db.php';
require_once 'auth_admin.php';
$pageTitle = "Ajouter un Administrateur";
require_once 'partials/header.php';
?>
<h1 class="h3 mb-4">Ajouter un Nouvel Administrateur</h1>
<?php if(isset($_SESSION['error_message'])) { echo '<div class="alert alert-danger">'.$_SESSION['error_message'].'</div>'; unset($_SESSION['error_message']); } ?>
<div class="card shadow">
    <div class="card-body">
        <form action="add-admin-handler.php" method="POST">
            <div class="mb-3">
                <label for="identifiant" class="form-label">Identifiant</label>
                <input type="text" class="form-control" id="identifiant" name="identifiant" required>
                <div class="form-text">Ce nom sera utilisé pour se connecter.</div>
            </div>
            <div class="mb-3">
                <label for="mot_de_passe" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required>
            </div>
            <div class="d-flex justify-content-end">
                <a href="list-admins.php" class="btn btn-secondary me-2">Annuler</a>
                <button type="submit" class="btn btn-primary">Ajouter l'administrateur</button>
            </div>
        </form>
    </div>
</div>
<?php require_once 'partials/footer.php'; ?>