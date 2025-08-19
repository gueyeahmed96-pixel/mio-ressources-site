<?php
// Fichier : /includes/auth_config.php (Version finale, email désactivé)

if (session_status() === PHP_SESSION_NONE) { session_start(); }

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/db.php';

try {
    $config = new PHPAuth\Config($pdo);
    
    // --- C'EST LA PARTIE CRUCIALE ---
    // On dit explicitement à la librairie que l'envoi d'email est désactivé
    // et qu'il ne doit PAS essayer d'utiliser la fonction mail() de PHP.
    $config->email_enabled = false;
    // ------------------------------------

    $auth = new PHPAuth\Auth($pdo, $config);

} catch (\PDOException $e) {
    die("Erreur critique d'initialisation du système d'authentification.");
}

// Les fonctions show_auth_messages et handle_auth_result restent les mêmes
function show_auth_messages() {
    $output = '';
    if (isset($_SESSION['success_message'])) { $output .= '<div class="alert alert-success">'.htmlspecialchars($_SESSION['success_message']).'</div>'; unset($_SESSION['success_message']); }
    if (isset($_SESSION['error_message'])) { $output .= '<div class="alert alert-danger">'.htmlspecialchars($_SESSION['error_message']).'</div>'; unset($_SESSION['error_message']); }
    return $output;
}

function handle_auth_result($result) {
    if (!empty($result['error'])) { $_SESSION['error_message'] = $result['message']; } 
    elseif (!empty($result['message'])) { $_SESSION['success_message'] = $result['message']; }
}