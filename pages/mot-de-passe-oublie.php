<?php
// Fichier : /pages/mot-de-passe-oublie.php
$pageTitle = "Récupération de mot de passe";
require_once '../includes/header.php';
?>
<main class="auth-container py-5"><div class="container"><div class="card auth-card shadow-lg border-0">
    <div class="card-body p-lg-5 p-4 text-center">
        <h3 class="fw-bold mb-3">Mot de passe oublié ?</h3>
        <p class="text-muted mb-4">Entrez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.</p>
        <?= show_auth_messages(); ?>
        <form action="mot-de-passe-handler.php" method="POST">
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                <label for="email">Adresse Email</label>
            </div>
            <div class="d-grid"><button class="btn btn-primary" type="submit">Envoyer le lien de réinitialisation</button></div>
        </form>
        <div class="mt-4"><a href="connexion.php">Retour à la connexion</a></div>
    </div>
</div></div></main>
<?php require_once '../includes/footer.php'; ?>