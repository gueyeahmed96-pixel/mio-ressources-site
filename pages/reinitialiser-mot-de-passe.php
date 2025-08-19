<?php
// Fichier : /pages/reinitialiser-mot-de-passe.php
$pageTitle = "Réinitialiser le mot de passe";
require_once '../includes/header.php';
$key = $_GET['key'] ?? ''; // On récupère la clé depuis l'URL
?>
<main class="auth-container py-5"><div class="container"><div class="card auth-card shadow-lg border-0">
    <div class="card-body p-lg-5 p-4 text-center">
        <h3 class="fw-bold mb-4">Définir un nouveau mot de passe</h3>
        <?= show_auth_messages(); ?>
        <form action="reinitialiser-handler.php" method="POST">
            <input type="hidden" name="key" value="<?= htmlspecialchars($key) ?>">
            <div class="form-floating mb-3">
                <input type="password" class="form-control" name="password" placeholder="Nouveau mot de passe" required>
                <label>Nouveau mot de passe</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" name="confirm_password" placeholder="Confirmer" required>
                <label>Confirmer le mot de passe</label>
            </div>
            <div class="d-grid"><button class="btn btn-primary" type="submit">Enregistrer le nouveau mot de passe</button></div>
        </form>
    </div>
</div></div></main>
<?php require_once '../includes/footer.php'; ?>