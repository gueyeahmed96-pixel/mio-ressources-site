<?php
// Fichier : /pages/connexion.php
$pageTitle = "Connexion";
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
                <!-- Colonne de Gauche : Formulaire -->
                <div class="col-lg-6">
                    <div class="card-body p-lg-5 p-4">
                        <h3 class="fw-bold mb-4">Connexion</h3>
                        
                        <!-- Affichage des messages de succès/erreur -->
                        <?= show_auth_messages(); ?>

                        <!-- Le formulaire pointe vers notre script de traitement -->
                        <form action="connexion-handler.php" method="POST">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder="nom@exemple.com" required>
                                <label for="email">Adresse Email</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" required>
                                <label for="password">Mot de passe</label>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">
                                        Se souvenir de moi
                                    </label>
                                </div>
                                <a href="mot-de-passe-oublie.php" class="small">Mot de passe oublié ?</a>
                            </div>

                            <div class="d-grid">
                                <button class="btn btn-primary btn-lg" type="submit">Se connecter</button>
                            </div>
                        </form>
                        <hr class="my-4">
                        <div class="text-center">
                            <p class="mb-0">Vous n'avez pas de compte ? <a href="inscription.php">Créez-en un</a></p>
                        </div>
                    </div>
                </div>

                <!-- Colonne de Droite : Image et Message -->
                <div class="col-lg-6 auth-image-column d-none d-lg-flex">
                    <i class="bi bi-chat-dots-fill icon"></i>
                    <h2 class="fw-bold">Prêt à Participer ?</h2>
                    <p class="lead">Connectez-vous pour accéder au forum, poser vos questions et contribuer à la communauté MIO.</p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
require_once '../includes/footer.php';
?>