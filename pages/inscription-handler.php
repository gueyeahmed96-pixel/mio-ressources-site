<?php
// Fichier : /pages/inscription-handler.php

// On inclut notre configuration qui charge tout le système
require_once '../includes/auth_config.php';

// On vérifie que le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // On récupère les données du formulaire
    $email = $_POST['email'];
    $password = $_POST['mot_de_passe'];
    $confirm_password = $_POST['mot_de_passe_confirm'];
    // PHPAuth utilise l'email comme identifiant principal, mais on peut aussi utiliser un nom d'utilisateur
    // Pour l'instant, simplifions et utilisons l'email.
    $params = [
        'username' => $_POST['nom_utilisateur']
    ];

    // On utilise la fonction register() de PHPAuth. Elle fait TOUT pour nous :
    // - Vérifie si les mots de passe correspondent
    // - Vérifie si l'email est valide
    // - Vérifie si l'email existe déjà
    // - Hache le mot de passe
    // - Insère l'utilisateur dans la table `phpauth_users`
    $result = $auth->register($email, $password, $confirm_password, $params);
    
    // On traite le résultat (succès ou erreur)
    handle_auth_result($result);
    
    // Si l'inscription a réussi (pas d'erreur)
    if (empty($result['error'])) {
        // On redirige vers la page de connexion avec un message de succès
        header('Location: connexion.php');
        exit();
    } else {
        // S'il y a une erreur, on retourne à la page d'inscription
        header('Location: inscription.php');
        exit();
    }
}