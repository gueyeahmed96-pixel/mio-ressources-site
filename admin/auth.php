<?php
// Fichier : /admin/auth.php (Version finale, gestion de session corrigée)

// On inclut la configuration qui gère TOUT (y compris session_start())
require_once __DIR__ . '/../includes/auth_config.php';

// On utilise la propre méthode de PHPAuth pour vérifier si on est connecté
// ET on vérifie si notre variable de session admin existe bien.
if (!$auth->isLogged() || !isset($_SESSION['admin_id'])) {
    
    $_SESSION['error_message'] = "Veuillez vous connecter pour accéder à cette page.";
    
    // On s'assure d'être dans le bon dossier pour la redirection
    $path_to_admin = '/mio-ressources/admin/';
    header('Location: ' . $path_to_admin . 'login.php');
    exit();
}