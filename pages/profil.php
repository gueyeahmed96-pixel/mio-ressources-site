<?php
// Fichier : /pages/profil.php (Version corrigée)
$pageTitle = "Mon Profil";
require_once '../includes/header.php'; // Ce header charge auth_config.php

// Sécurité : si l'utilisateur n'est pas connecté, on le renvoie
if (!$is_student_logged_in) {
    header('Location: connexion.php');
    exit();
}

// On récupère les infos de l'utilisateur actuel.
// $auth est déjà disponible grâce à auth_config.php
$uid = $auth->getCurrentUID();
$user_data = $auth->getUser($uid); // C'est la bonne méthode pour avoir toutes les infos

// On s'assure que les données existent pour éviter des erreurs
$username = htmlspecialchars($user_data['username'] ?? '');
$email = htmlspecialchars($user_data['email'] ?? '');
$photo_profil = htmlspecialchars($user_data['photo_profil'] ?? '');
?>
<main class="container py-5">
    <h1 class="mb-4">Mon Profil</h1>
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <?= show_auth_messages(); ?>
            <form action="profil-handler.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <?php if (!empty($photo_profil)): ?>
                            <img src="../uploads/profiles/<?= $photo_profil ?>" class="img-thumbnail rounded-circle mb-3" style="width:150px; height:150px; object-fit: cover;">
                        <?php else: ?>
                            <i class="bi bi-person-circle text-secondary" style="font-size: 150px;"></i>
                        <?php endif; ?>
                        <div class="mb-3">
                            <label for="photo" class="form-label">Changer de photo</label>
                            <input class="form-control form-control-sm" type="file" name="photo" id="photo">
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="mb-3">
                            <label for="username" class="form-label">Nom d'utilisateur</label>
                            <input type="text" class="form-control" name="username" id="username" value="<?= $username ?>">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="<?= $email ?>" readonly disabled>
                            <div class="form-text">L'adresse email ne peut pas être changée.</div>
                        </div>
                        <hr>
                        <h5 class="mt-4">Changer le mot de passe</h5>
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Mot de passe actuel</label>
                            <input type="password" class="form-control" name="current_password" id="current_password" placeholder="Requis pour changer le mot de passe">
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Nouveau mot de passe</label>
                            <input type="password" class="form-control" name="new_password" id="new_password">
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirmer le nouveau mot de passe</label>
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password">
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4 border-top pt-3">
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </div>
            </form>
        </div>
    </div>
</main>
<?php require_once '../includes/footer.php'; ?>