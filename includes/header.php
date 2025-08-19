<?php
// Fichier : /includes/header.php (Version finale avec photo de profil)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inclure la configuration de notre système d'authentification
require_once __DIR__ . '/auth_config.php';

// On vérifie si un étudiant est connecté
$is_student_logged_in = $auth->isLogged();

// Si l'étudiant est connecté, on récupère ses informations
$current_student_data = [];
if ($is_student_logged_in) {
    $current_student_data = $auth->getUser($auth->getCurrentUID());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' | MIO Ressources' : 'MIO Ressources' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/mio-ressources/css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/mio-ressources/index.php">
                <i class="bi bi-box-seam-fill"></i> MIO Ressources
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="/mio-ressources/index.php">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="/mio-ressources/pages/a-propos.php">À Propos</a></li>
                    <li class="nav-item"><a class="nav-link" href="/mio-ressources/pages/club-mio.php">Club MIO</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold" href="/mio-ressources/forum/index.php">Forum</a></li>
                    <li class="nav-item"><a class="nav-link" href="/mio-ressources/pages/contact.php">Contact</a></li>
                    
                    <!-- ========================================================== -->
                    <!-- ====     C'EST CETTE PARTIE QUI A ÉTÉ AMÉLIORÉE       ==== -->
                    <!-- ========================================================== -->
                    <?php if ($is_student_logged_in): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php if (!empty($current_student_data['photo_profil'])): ?>
                                    <img src="/mio-ressources/uploads/profiles/<?= htmlspecialchars($current_student_data['photo_profil']) ?>" alt="Profil" width="32" height="32" class="rounded-circle me-2">
                                <?php else: ?>
                                    <i class="bi bi-person-circle me-2"></i>
                                <?php endif; ?>
                                <span><?= htmlspecialchars($current_student_data['username'] ?? 'Mon Compte') ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="/mio-ressources/pages/profil.php">Mon Profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/mio-ressources/pages/deconnexion.php">Se déconnecter</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/mio-ressources/pages/connexion.php">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary btn-sm ms-2" href="/mio-ressources/pages/inscription.php">S'inscrire</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>