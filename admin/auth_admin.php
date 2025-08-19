<?php
// Fichier : /admin/auth_admin.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Si la variable de session 'admin_id' n'existe pas, on redirige
if (!isset($_SESSION['admin_id'])) {
    $_SESSION['error_message'] = "Veuillez vous connecter pour accéder à cette page.";
    header('Location: login.php');
    exit();
}
?>