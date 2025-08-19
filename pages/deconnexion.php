<?php
// Fichier : /pages/deconnexion.php

// On inclut notre configuration qui charge tout le système
require_once '../includes/auth_config.php';

// On récupère le "hash" de la session actuelle
$user_hash = $auth->getCurrentSessionHash();

// On utilise la fonction logout() de PHPAuth en lui passant le hash
// Cela supprime la session de la base de données et du cookie.
$auth->logout($user_hash);

// On ajoute un petit message de succès pour la page d'accueil
$_SESSION['success_message'] = "Vous avez été déconnecté avec succès.";

// On redirige l'utilisateur vers la page d'accueil
header('Location: /mio-ressources/index.php');
exit();
?>