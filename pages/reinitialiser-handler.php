<?php
// Fichier : /pages/reinitialiser-handler.php
require_once '../includes/auth_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // La fonction resetPass() vérifie le token, la correspondance des mdp,
    // et met à jour le mdp haché dans la BDD.
    $result = $auth->resetPass($_POST['key'], $_POST['password'], $_POST['confirm_password']);
    
    handle_auth_result($result);
    
    if (empty($result['error'])) {
        header('Location: connexion.php');
    } else {
        header('Location: reinitialiser-mot-de-passe.php?key=' . urlencode($_POST['key']));
    }
    exit();
}