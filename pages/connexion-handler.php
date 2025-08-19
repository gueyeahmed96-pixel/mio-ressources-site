<?php
// Fichier : /pages/connexion-handler.php

// On inclut notre configuration qui charge tout le système
require_once '../includes/auth_config.php';

// On vérifie que le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // On récupère les données
    $email = $_POST['email'];
    $password = $_POST['password'];
    // La case "Se souvenir de moi" crée un cookie sécurisé pour une connexion plus longue
    $remember = isset($_POST['remember']) ? 1 : 0;

    // On utilise la fonction login() de PHPAuth.
    // Elle renvoie un tableau avec le résultat de la tentative.
    $result = $auth->login($email, $password, $remember);
    
    // On traite le résultat
    handle_auth_result($result);

    // Si la connexion a réussi (pas d'erreur)
    if (empty($result['error'])) {
        // On redirige vers la page d'accueil ou le forum
        header('Location: /mio-ressources/index.php');
        exit();
    } else {
        // S'il y a une erreur (email/mdp incorrect), on retourne à la page de connexion
        header('Location: connexion.php');
        exit();
    }
}