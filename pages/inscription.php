<?php
// Fichier : /pages/inscription.php
$pageTitle = "Inscription";
require_once '../includes/header.php'; // Ce header inclut déjà notre auth_config.php

// Si un utilisateur est déjà connecté, on le redirige vers l'accueil
if ($is_student_logged_in) {
    header('Location: /mio-ressources/index.php');
    exit();
}
?>

<main class="auth-container py-5">
    <div class="container">
        <div class="card auth-card shadow-lg border-0">
            <div class="row g-0">
                <!-- Colonne de Gauche : Image et Message -->
                <div class="col-lg-6 auth-image-column d-none d-lg-flex">
                    <i class="bi bi-people-fill icon"></i>
                    <h2 class="fw-bold">Rejoignez la Communauté</h2>
                    <p class="lead">Créez votre compte pour participer aux discussions, poser des questions et échanger avec les autres étudiants de la filière MIO.</p>
                </div>

                <!-- Colonne de Droite : Formulaire -->
                <div class="col-lg-6">
                    <div class="card-body p-lg-5 p-4">
                        <h3 class="fw-bold mb-4">Créer un compte</h3>

                        <?php
                        // Affichage des messages d'erreur de la session
                        if (isset($_SESSION['error_message'])): ?>
                            <div class="alert alert-danger" role="alert">
                                <?= $_SESSION['error_message']; ?>
                            </div>
                            <?php unset($_SESSION['error_message']); ?>
                        <?php endif; ?>

                        <!-- Le formulaire pointe vers un script de traitement que nous créerons ensuite -->
                        <form action="inscription-handler.php" method="POST">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="nom_utilisateur" name="nom_utilisateur" placeholder="Votre nom d'utilisateur" required>
                                <label for="nom_utilisateur">Nom d'utilisateur</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder="nom@exemple.com" required>
                                <label for="email">Adresse Email</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" placeholder="Mot de passe" required>
                                <label for="mot_de_passe">Mot de passe</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="mot_de_passe_confirm" name="mot_de_passe_confirm" placeholder="Confirmer le mot de passe" required>
                                <label for="mot_de_passe_confirm">Confirmer le mot de passe</label>
                            </div>

                            <div class="d-grid">
                                <button class="btn btn-primary btn-lg" type="submit">S'inscrire</button>
                            </div>
                        </form>
                        <hr class="my-4">
                        <div class="text-center">
                            <p class="mb-0">Vous avez déjà un compte ? <a href="connexion.php">Connectez-vous</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
require_once '../includes/footer.php';
?>